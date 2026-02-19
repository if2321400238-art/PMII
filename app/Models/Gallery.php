<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
        'uploader_type',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'approved_at' => 'datetime',
        ];
    }

    /**
     * Get the uploader (polymorphic: User or Rayon)
     */
    public function uploadedBy(): MorphTo
    {
        return $this->morphTo('uploadedBy', 'uploader_type', 'uploaded_by');
    }

    /**
     * Get uploader name helper
     */
    public function getUploaderNameAttribute(): string
    {
        return $this->uploadedBy?->name ?? 'Unknown';
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

    public function getEmbedPlayerUrlAttribute(): ?string
    {
        if (!$this->embed_url) {
            return null;
        }

        $url = trim($this->embed_url);
        $host = parse_url($url, PHP_URL_HOST) ?? '';
        $path = parse_url($url, PHP_URL_PATH) ?? '';

        if (str_contains($host, 'youtube.com') || str_contains($host, 'youtu.be')) {
            $videoId = $this->extractYoutubeId($url);
            return $videoId ? "https://www.youtube.com/embed/{$videoId}" : $url;
        }

        if (str_contains($host, 'vimeo.com') && !str_contains($host, 'player.vimeo.com')) {
            $videoId = trim($path, '/');
            return $videoId ? "https://player.vimeo.com/video/{$videoId}" : $url;
        }

        return $url;
    }

    public function getVideoThumbnailUrlAttribute(): ?string
    {
        if (!$this->embed_url) {
            return null;
        }

        $videoId = $this->extractYoutubeId($this->embed_url);
        if ($videoId) {
            return "https://i.ytimg.com/vi/{$videoId}/hqdefault.jpg";
        }

        return null;
    }

    private function extractYoutubeId(string $url): ?string
    {
        $parsedHost = parse_url($url, PHP_URL_HOST) ?? '';
        $parsedPath = parse_url($url, PHP_URL_PATH) ?? '';
        $query = parse_url($url, PHP_URL_QUERY) ?? '';

        if (str_contains($parsedHost, 'youtu.be')) {
            $id = trim($parsedPath, '/');
            return $id !== '' ? $id : null;
        }

        if (str_contains($parsedPath, '/embed/')) {
            $parts = explode('/embed/', $parsedPath);
            return isset($parts[1]) && $parts[1] !== '' ? explode('/', $parts[1])[0] : null;
        }

        parse_str($query, $params);
        return $params['v'] ?? null;
    }
}
