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
        'korwil_id',
        'foto',
        'kta_path',
        'kta_template_id',
    ];

    public function rayon(): BelongsTo
    {
        return $this->belongsTo(Rayon::class);
    }

    public function korwil(): BelongsTo
    {
        return $this->belongsTo(Korwil::class);
    }

    public function ktaTemplate(): BelongsTo
    {
        return $this->belongsTo(KTATemplate::class, 'kta_template_id');
    }
}
