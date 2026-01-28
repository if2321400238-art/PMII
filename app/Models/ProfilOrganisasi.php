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
        'sejarah',
        'visi',
        'misi',
        'struktur_organisasi',
    ];
}
