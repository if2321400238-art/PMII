<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'type',
        'title',
        'description',
        'file_path',
        'embed_url',
        'kegiatan',
        'tahun',
        'approval_status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'uploaded_by',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'approved_at' => 'datetime',
        ];
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('approval_status', 'pending');
    }

    public function scopeDraft($query)
    {
        return $query->where('approval_status', 'draft');
    }

    public function scopePhotos($query)
    {
        return $query->where('type', 'photo');
    }

    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    public function scopeByKegitan($query, $kegiatan)
    {
        return $query->where('kegiatan', $kegiatan);
    }

    public function scopeByTahun($query, $tahun)
    {
        return $query->where('tahun', $tahun);
    }
}
