<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Post extends Model
{
    protected $fillable = [
        'type',
        'title',
        'slug',
        'content',
        'thumbnail',
        'category_id',
        'author_id',
        'author_type',
        'view_count',
        'is_popular',
        'published_at',
        'approval_status',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'approved_at' => 'datetime',
            'is_popular' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the author (polymorphic: User or Rayon)
     */
    public function author(): MorphTo
    {
        return $this->morphTo('author', 'author_type', 'author_id');
    }

    /**
     * Get author name helper
     */
    public function getAuthorNameAttribute(): string
    {
        return $this->author?->name ?? 'Unknown';
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopeBerita($query)
    {
        return $query->where('type', 'berita');
    }



    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now())
                     ->where('approval_status', 'approved');
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

    public function scopePopular($query)
    {
        return $query->where('is_popular', true);
    }
}
