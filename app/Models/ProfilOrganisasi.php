<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilOrganisasi extends Model
{
    protected $table = 'profil_organisasi';

    protected $fillable = [
        'nama_organisasi',
        'logo_path',
        'hero_image',
        'hero_image_2',
        'hero_image_3',
        'sejarah',
        'visi',
        'misi',
        'struktur_organisasi',
    ];
}
