<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Korwil extends Authenticatable
{
    use Notifiable;

    protected $table = 'korwils';

    protected $fillable = [
        'name',
        'wilayah',
        'email',
        'password',
        'nomor_sk',
        'tanggal_sk',
        'description',
        'contact',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_sk' => 'date',
            'password' => 'hashed',
        ];
    }

    public function rayons(): HasMany
    {
        return $this->hasMany(Rayon::class);
    }

    public function anggota(): HasMany
{
        return $this->hasMany(Anggota::class);
    }

    public function skPengajuan(): HasMany
    {
        return $this->hasMany(SKPengajuan::class);
    }

    public function scopeWithSK($query)
    {
        return $query->whereNotNull('nomor_sk');
    }

    /**
     * Check role helper for Korwil auth
     */
    public function hasRole(string ...$roles): bool
    {
        return in_array('korwil_admin', $roles);
    }
}
