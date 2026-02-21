<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaCompressionService
{
    public function storeCompressedImage(
        UploadedFile $file,
        string $directory,
        string $disk = 'public',
        int $maxWidth = 1920,
        int $jpegQuality = 80,
        int $webpQuality = 80
    ): string {
        $extension = strtolower($file->getClientOriginalExtension());
        $extension = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']) ? $extension : 'jpg';

        $source = $this->createImageResource($file->getRealPath(), $extension);
        if (!$source) {
            return $file->store($directory, $disk);
        }

        [$originalWidth, $originalHeight] = [imagesx($source), imagesy($source)];
        $targetWidth = $originalWidth;
        $targetHeight = $originalHeight;

        if ($originalWidth > $maxWidth) {
            $ratio = $maxWidth / $originalWidth;
            $targetWidth = $maxWidth;
            $targetHeight = (int) round($originalHeight * $ratio);
        }

        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);

        if (in_array($extension, ['png', 'webp'])) {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefilledrectangle($canvas, 0, 0, $targetWidth, $targetHeight, $transparent);
        }

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

        $filename = $this->generateFilename($extension);
        $relativePath = trim($directory, '/') . '/' . $filename;

        $binary = $this->encodeImage($canvas, $extension, $jpegQuality, $webpQuality);

        imagedestroy($canvas);
        imagedestroy($source);

        if ($binary === null) {
            return $file->store($directory, $disk);
        }

        Storage::disk($disk)->put($relativePath, $binary);

        return $relativePath;
    }

    public function storeCompressedVideo(
        UploadedFile $file,
        string $directory,
        string $disk = 'public',
        int $crf = 28,
        string $preset = 'veryfast'
    ): string {
        if (!$this->isFfmpegAvailable()) {
            return $file->store($directory, $disk);
        }

        $tempInput = tempnam(sys_get_temp_dir(), 'in_');
        $tempOutput = tempnam(sys_get_temp_dir(), 'out_') . '.mp4';

        if (!$tempInput || !$tempOutput) {
            return $file->store($directory, $disk);
        }

        $copied = copy($file->getRealPath(), $tempInput);
        if (!$copied) {
            @unlink($tempInput);
            @unlink($tempOutput);
            return $file->store($directory, $disk);
        }

        $command = sprintf(
            'ffmpeg -y -i %s -vcodec libx264 -crf %d -preset %s -acodec aac -b:a 128k -movflags +faststart %s 2>&1',
            escapeshellarg($tempInput),
            $crf,
            escapeshellarg($preset),
            escapeshellarg($tempOutput)
        );

        exec($command, $output, $exitCode);

        if ($exitCode !== 0 || !file_exists($tempOutput) || filesize($tempOutput) === 0) {
            @unlink($tempInput);
            @unlink($tempOutput);
            return $file->store($directory, $disk);
        }

        $relativePath = trim($directory, '/') . '/' . $this->generateFilename('mp4');
        Storage::disk($disk)->put($relativePath, file_get_contents($tempOutput));

        @unlink($tempInput);
        @unlink($tempOutput);

        return $relativePath;
    }

    private function createImageResource(string $path, string $extension)
    {
        return match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($path),
            'png' => @imagecreatefrompng($path),
            'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : null,
            default => @imagecreatefromstring((string) file_get_contents($path)),
        };
    }

    private function encodeImage($resource, string $extension, int $jpegQuality, int $webpQuality): ?string
    {
        ob_start();

        $result = match ($extension) {
            'jpg', 'jpeg' => imagejpeg($resource, null, $jpegQuality),
            'png' => imagepng($resource, null, 6),
            'webp' => function_exists('imagewebp') ? imagewebp($resource, null, $webpQuality) : imagejpeg($resource, null, $jpegQuality),
            default => imagejpeg($resource, null, $jpegQuality),
        };

        if (!$result) {
            ob_end_clean();
            return null;
        }

        return ob_get_clean();
    }

    private function generateFilename(string $extension): string
    {
        return now()->format('YmdHis') . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
    }

    private function isFfmpegAvailable(): bool
    {
        exec('ffmpeg -version 2>&1', $output, $exitCode);

        return $exitCode === 0;
    }
}
