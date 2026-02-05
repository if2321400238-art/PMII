<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $anggota = \App\Models\Anggota::first();

    echo "=== ANGGOTA DATA ===\n";
    echo "ID: " . $anggota->id . "\n";
    echo "Nama: " . $anggota->nama . "\n";
    echo "Nomor: " . $anggota->nomor_anggota . "\n";
    echo "Foto Path: " . $anggota->foto . "\n";
    echo "Foto Exists: " . (file_exists(public_path($anggota->foto)) ? "YES" : "NO") . "\n";
    echo "\n=== RELATIONSHIPS ===\n";
    echo "Rayon: " . ($anggota->rayon ? $anggota->rayon->nama : "NULL") . "\n";
    echo "Korwil: " . ($anggota->korwil ? $anggota->korwil->nama : "NULL") . "\n";
    echo "KTA Template: " . ($anggota->ktaTemplate ? $anggota->ktaTemplate->name : "NULL (will use default)") . "\n";

    $template = $anggota->ktaTemplate ?? \App\Models\KTATemplate::where('is_active', true)->first();
    echo "\n=== TEMPLATE ===\n";
    echo "Template Name: " . $template->name . "\n";
    echo "Template Path: " . $template->image_path . "\n";

    $templatePath = \Illuminate\Support\Facades\Storage::disk('public')->path($template->image_path);
    echo "Full Path: " . $templatePath . "\n";
    echo "File Exists: " . (file_exists($templatePath) ? "YES" : "NO") . "\n";

    $fontPath = base_path('public/fonts/arial.ttf');
    echo "\nFont Path: " . $fontPath . "\n";
    echo "Font Exists: " . (file_exists($fontPath) ? "YES" : "NO") . "\n";

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
