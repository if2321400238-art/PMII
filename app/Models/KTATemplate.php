<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KTATemplate extends Model
{
    protected $fillable = [
        'name',
        'image_path',
        'field_positions',
        'is_active',
    ];

    protected $casts = [
        'field_positions' => 'json',
        'is_active' => 'boolean',
    ];

    public function anggota()
    {
        return $this->hasMany(Anggota::class, 'kta_template_id');
    }
}
