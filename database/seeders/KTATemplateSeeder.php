<?php

namespace Database\Seeders;

use App\Models\KTATemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Intervention\Image\Facades\Image;

class KTATemplateSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create a simple default template image
        $templatePath = 'kta-templates/default-template.png';

        // Check if template doesn't exist, create it
        if (!file_exists(storage_path('app/' . $templatePath))) {
            // Create a simple placeholder image
            $width = 500;
            $height = 800;

            $image = imagecreate($width, $height);

            // Colors
            $white = imagecolorallocate($image, 255, 255, 255);
            $blue = imagecolorallocate($image, 30, 60, 114);
            $black = imagecolorallocate($image, 0, 0, 0);

            // Fill background
            imagefill($image, 0, 0, $white);

            // Draw blue header
            imagefilledrectangle($image, 0, 0, $width, 80, $blue);

            // Header text
            imagestring($image, 5, 150, 20, 'ISKAB', $white);
            imagestring($image, 3, 140, 45, 'Kartu Tanda Anggota', $white);

            // Save the image
            @mkdir(storage_path('app/kta-templates'), 0755, true);
            imagepng($image, storage_path('app/' . $templatePath));
            imagedestroy($image);
        }

        // Create or update the default template
        KTATemplate::updateOrCreate(
            ['name' => 'KTA Standar ISKAB'],
            [
                'image_path' => $templatePath,
                'field_positions' => [
                    'nama' => ['x' => 50, 'y' => 120, 'size' => 14],
                    'nomor_anggota' => ['x' => 50, 'y' => 160, 'size' => 12],
                    'rayon' => ['x' => 50, 'y' => 200, 'size' => 10],
                    'korwil' => ['x' => 50, 'y' => 230, 'size' => 10],
                    'foto' => ['x' => 350, 'y' => 100, 'width' => 100, 'height' => 140],
                ],
                'is_active' => true,
            ]
        );
    }
}
