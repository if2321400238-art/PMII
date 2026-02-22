<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OptimizedImageController extends Controller
{
    public function show(Request $request, string $path)
    {
        $normalizedPath = ltrim($path, '/');

        if ($normalizedPath === '' || str_contains($normalizedPath, '..')) {
            abort(404);
        }

        $disk = Storage::disk('public');

        if (!$disk->exists($normalizedPath)) {
            abort(404);
        }

        $width = (int) $request->query('w', 0);
        $width = max(0, min($width, 1920));

        $extension = strtolower(pathinfo($normalizedPath, PATHINFO_EXTENSION));
        $supportedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

        $cacheHeaders = [
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ];

        if ($width === 0 || !in_array($extension, $supportedExtensions, true) || !function_exists('imagewebp')) {
            return response()->file($disk->path($normalizedPath), $cacheHeaders);
        }

        $cachePath = '_cache/img/w' . $width . '/' . md5($normalizedPath) . '.webp';

        if (!$disk->exists($cachePath)) {
            $binary = $this->createOptimizedImage(
                $disk->path($normalizedPath),
                $extension,
                $width
            );

            if ($binary === null) {
                return response()->file($disk->path($normalizedPath), $cacheHeaders);
            }

            $disk->put($cachePath, $binary);
        }

        return response()->file($disk->path($cachePath), [
            ...$cacheHeaders,
            'Content-Type' => 'image/webp',
        ]);
    }

    private function createOptimizedImage(string $absolutePath, string $extension, int $maxWidth): ?string
    {
        [$originalWidth, $originalHeight] = getimagesize($absolutePath) ?: [0, 0];

        if ($originalWidth <= 0 || $originalHeight <= 0) {
            return null;
        }

        $source = $this->createImageResource($absolutePath, $extension);

        if (!$source) {
            return null;
        }

        $targetWidth = $originalWidth;
        $targetHeight = $originalHeight;

        if ($originalWidth > $maxWidth) {
            $ratio = $maxWidth / $originalWidth;
            $targetWidth = $maxWidth;
            $targetHeight = (int) round($originalHeight * $ratio);
        }

        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);

        imagealphablending($canvas, false);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefilledrectangle($canvas, 0, 0, $targetWidth, $targetHeight, $transparent);

        imagecopyresampled(
            $canvas,
            $source,
            0,
            0,
            0,
            0,
            $targetWidth,
            $targetHeight,
            $originalWidth,
            $originalHeight
        );

        ob_start();
        $encoded = imagewebp($canvas, null, 80);
        $binary = $encoded ? ob_get_clean() : null;

        if (!$encoded) {
            ob_end_clean();
        }

        imagedestroy($canvas);
        imagedestroy($source);

        return $binary;
    }

    private function createImageResource(string $path, string $extension)
    {
        return match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($path),
            'png' => @imagecreatefrompng($path),
            'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : null,
            default => null,
        };
    }
}
