<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anggota extends Model
{
    protected $table = 'anggota';

    protected $fillable = [
        'nama',
        'nomor_anggota',
        'alamat',
        'pondok',
        'rayon_id',
        'foto',
        'kta_path',
    ];

    public function rayon(): BelongsTo
    {
        return $this->belongsTo(Rayon::class);
    }


}
