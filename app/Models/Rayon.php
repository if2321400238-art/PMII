<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rayon extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'description',
        'contact',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }


    public function anggota(): HasMany
    {
        return $this->hasMany(Anggota::class);
    }

    public function getRoleSlugAttribute(): string
    {
        return 'rayon_admin';
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role_slug, $roles);
    }
}
