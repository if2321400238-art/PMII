<?php

namespace App\Services;

use App\Models\Anggota;
use App\Models\ProfilOrganisasi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer\Barcode\BarcodeGeneratorPNG;

class KTAGeneratorService
{
    private int $width = 1150;
    private int $height = 720;
    private string $fontPath;
    private int $leftPanelWidth = 400;

    public function __construct()
    {
        $this->fontPath = public_path('fonts/arial.ttf');
    }

    /**
     * Generate KTA image for a member
     */
    public function generate(Anggota $anggota): ?string
    {
        try {
            // Create the base image
            $image = imagecreatetruecolor($this->width, $this->height);
            imageantialias($image, true);

            // Define colors
            $colors = $this->defineColors($image);

            // Fill background with white/light gray
            imagefill($image, 0, 0, $colors['lightBg']);

            // Draw left panel (dark blue)
            imagefilledrectangle($image, 0, 0, $this->leftPanelWidth, $this->height, $colors['darkBlue']);

            // Draw right accent strip (gold/bronze)
            imagefilledrectangle($image, $this->width - 50, 0, $this->width, $this->height, $colors['gold']);

            // Draw vertical "E-KTA" text on right strip
            $this->drawVerticalText($image, $this->width - 30, 420, 'E-KTA', $colors['white'], 22);

            // Get organization profile
            $profil = ProfilOrganisasi::first();

            // Draw left panel content
            $this->drawLeftPanel($image, $profil, $anggota, $colors);

            // Draw right panel content
            $this->drawRightPanel($image, $anggota, $colors);

            // Save to temp file
            $tempFile = tempnam(sys_get_temp_dir(), 'kta_') . '.png';
            imagepng($image, $tempFile, 9);
            imagedestroy($image);

            return file_exists($tempFile) ? $tempFile : null;

        } catch (\Exception $e) {
            Log::error('KTA Generation Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Define all colors used in the card
     */
    private function defineColors($image): array
    {
        return [
            'white' => imagecolorallocate($image, 255, 255, 255),
            'black' => imagecolorallocate($image, 0, 0, 0),
            'darkBlue' => imagecolorallocate($image, 21, 62, 99),
            'lightBg' => imagecolorallocate($image, 245, 248, 252),
            'gold' => imagecolorallocate($image, 196, 145, 68),
            'gray' => imagecolorallocate($image, 100, 100, 100),
            'lightGray' => imagecolorallocate($image, 200, 200, 200),
        ];
    }

    /**
     * Draw left panel with organization branding
     */
    private function drawLeftPanel($image, ?ProfilOrganisasi $profil, Anggota $anggota, array $colors): void
    {
        $centerX = $this->leftPanelWidth / 2;

        // Logo circle background
        $logoY = 130;
        imagefilledellipse($image, (int)$centerX, $logoY, 160, 160, $colors['gold']);
        imagefilledellipse($image, (int)$centerX, $logoY, 150, 150, $colors['darkBlue']);

        // Add logo if exists
        if ($profil && $profil->logo_path) {
            $logoPath = Storage::disk('public')->path($profil->logo_path);
            if (file_exists($logoPath)) {
                $this->addImageToCanvas($image, $logoPath, (int)$centerX - 60, $logoY - 60, 120, 120);
            }
        }

        // Organization name
        $orgName = $profil?->nama_organisasi ?? 'ISKAB';
        $titleY = 245;

        $this->drawCenteredText($image, $centerX, $titleY, 'IKATAN SANTRI', $colors['white'], 16);
        $this->drawCenteredText($image, $centerX, $titleY + 35, strtoupper($orgName), $colors['white'], 26);
        $this->drawCenteredText($image, $centerX, $titleY + 70, 'Kabupaten Probolinggo', $colors['gold'], 13);

        // Social media
        $this->drawCenteredText($image, $centerX, 375, '@iskab.official', $colors['white'], 11);

        // QR Code
        $this->addQRCode($image, $anggota, $centerX);

        // QR Code instructions
        $instructY = 590;
        $this->drawCenteredText($image, $centerX, $instructY, 'Untuk verifikasi KTA ini, pindai QR', $colors['white'], 9);
        $this->drawCenteredText($image, $centerX, $instructY + 15, 'di atas dan cocokkan dengan data', $colors['white'], 9);
        $this->drawCenteredText($image, $centerX, $instructY + 30, 'di server kami.', $colors['white'], 9);

        // Website
        $this->drawCenteredText($image, $centerX, 685, 'www.iskab.or.id', $colors['white'], 14);
    }

    /**
     * Draw right panel with member information
     */
    private function drawRightPanel($image, Anggota $anggota, array $colors): void
    {
        $rightStart = $this->leftPanelWidth + 30;
        $rightWidth = $this->width - $this->leftPanelWidth - 80;
        $centerRight = $rightStart + ($rightWidth / 2);

        // Header text
        @imagettftext($image, 18, 0, $rightStart, 40, $colors['gray'], $this->fontPath, 'Kartu Tanda');
        @imagettftext($image, 34, 0, $rightStart, 80, $colors['darkBlue'], $this->fontPath, 'Anggota');

        // Member photo
        $photoWidth = 180;
        $photoHeight = 220;
        $photoX = (int)($centerRight - $photoWidth / 2);
        $photoY = 110;

        // Photo border
        imagefilledrectangle($image, $photoX - 4, $photoY - 4, $photoX + $photoWidth + 4, $photoY + $photoHeight + 4, $colors['darkBlue']);

        // Add photo or placeholder
        $photoAdded = false;
        if ($anggota->foto) {
            $photoPath = Storage::disk('public')->path($anggota->foto);
            if (file_exists($photoPath)) {
                $this->addImageToCanvas($image, $photoPath, $photoX, $photoY, $photoWidth, $photoHeight);
                $photoAdded = true;
            }
        }

        if (!$photoAdded) {
            $this->drawPhotoPlaceholder($image, $photoX, $photoY, $photoWidth, $photoHeight, $colors);
        }

        // Barcode
        $barcodeY = $photoY + $photoHeight + 30;
        $this->addBarcode($image, $anggota, $centerRight, $barcodeY);

        // Member number
        $numberY = $barcodeY + 75;
        $this->drawCenteredText($image, $centerRight, $numberY, $anggota->nomor_anggota, $colors['black'], 20);

        // Member name
        $nameY = $numberY + 40;
        $this->drawCenteredText($image, $centerRight, $nameY, strtoupper($anggota->nama), $colors['darkBlue'], 18);

        // Pondok
        $nextY = $nameY + 28;
        if ($anggota->pondok) {
            $this->drawCenteredText($image, $centerRight, $nextY, $anggota->pondok, $colors['darkBlue'], 12);
            $nextY += 22;
        }

        // Rayon
        if ($anggota->rayon) {
            $this->drawCenteredText($image, $centerRight, $nextY, 'Rayon ' . $anggota->rayon->name, $colors['gray'], 12);
            $nextY += 22;
        }

        // Korwil
        if ($anggota->korwil) {
            $this->drawCenteredText($image, $centerRight, $nextY, $anggota->korwil->name, $colors['gray'], 12);
        }
    }

    /**
     * Draw photo placeholder
     */
    private function drawPhotoPlaceholder($image, int $x, int $y, int $width, int $height, array $colors): void
    {
        imagefilledrectangle($image, $x, $y, $x + $width, $y + $height, $colors['lightGray']);
        $this->drawCenteredText($image, $x + $width / 2, $y + $height / 2, 'FOTO', $colors['gray'], 16);
    }

    /**
     * Add QR Code to left panel
     */
    private function addQRCode($image, Anggota $anggota, float $centerX): void
    {
        try {
            $verificationUrl = url('/verify/anggota/' . $anggota->nomor_anggota);

            $qrCode = QrCode::format('png')
                ->size(130)
                ->margin(1)
                ->backgroundColor(21, 62, 99)
                ->color(255, 255, 255)
                ->generate($verificationUrl);

            $qrTempFile = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
            file_put_contents($qrTempFile, $qrCode);

            $qrImage = @imagecreatefrompng($qrTempFile);
            if ($qrImage) {
                $qrX = (int)($centerX - 65);
                $qrY = 420;
                imagecopy($image, $qrImage, $qrX, $qrY, 0, 0, imagesx($qrImage), imagesy($qrImage));
                imagedestroy($qrImage);
            }

            @unlink($qrTempFile);
        } catch (\Exception $e) {
            Log::warning('QR Code generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Add Barcode
     */
    private function addBarcode($image, Anggota $anggota, float $centerX, int $y): void
    {
        try {
            $generator = new BarcodeGeneratorPNG();
            $barcodeData = $generator->getBarcode($anggota->nomor_anggota, $generator::TYPE_CODE_128, 2, 50);

            $barcodeTempFile = tempnam(sys_get_temp_dir(), 'barcode_') . '.png';
            file_put_contents($barcodeTempFile, $barcodeData);

            $barcodeImage = @imagecreatefrompng($barcodeTempFile);
            if ($barcodeImage) {
                $barcodeWidth = imagesx($barcodeImage);
                $barcodeX = (int)($centerX - $barcodeWidth / 2);
                imagecopy($image, $barcodeImage, $barcodeX, $y, 0, 0, $barcodeWidth, imagesy($barcodeImage));
                imagedestroy($barcodeImage);
            }

            @unlink($barcodeTempFile);
        } catch (\Exception $e) {
            Log::warning('Barcode generation failed: ' . $e->getMessage());
        }
    }

    /**
     * Draw centered text
     */
    private function drawCenteredText($image, float $centerX, int $y, string $text, $color, int $size): void
    {
        if (empty($text)) return;

        $bbox = @imagettfbbox($size, 0, $this->fontPath, $text);
        if ($bbox === false) return;

        $textWidth = $bbox[2] - $bbox[0];
        $x = (int)($centerX - $textWidth / 2);

        @imagettftext($image, $size, 0, $x, $y, $color, $this->fontPath, $text);
    }

    /**
     * Draw vertical text
     */
    private function drawVerticalText($image, int $x, int $y, string $text, $color, int $size): void
    {
        @imagettftext($image, $size, 90, $x, $y, $color, $this->fontPath, $text);
    }

    /**
     * Add image to canvas with resizing
     */
    private function addImageToCanvas($canvas, string $imagePath, int $x, int $y, int $width, int $height): void
    {
        $extension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));

        $sourceImage = match ($extension) {
            'png' => @imagecreatefrompng($imagePath),
            'jpg', 'jpeg' => @imagecreatefromjpeg($imagePath),
            'gif' => @imagecreatefromgif($imagePath),
            'webp' => @imagecreatefromwebp($imagePath),
            default => null
        };

        if ($sourceImage) {
            imagecopyresampled(
                $canvas,
                $sourceImage,
                $x,
                $y,
                0,
                0,
                $width,
                $height,
                imagesx($sourceImage),
                imagesy($sourceImage)
            );
            imagedestroy($sourceImage);
        }
    }
}
