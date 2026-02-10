<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rayon;
use App\Models\Anggota;
use Illuminate\Contracts\Auth\Authenticatable;

class AnggotaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Authenticatable $user): bool
    {
        return $user !== null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Authenticatable $user, Anggota $anggota): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Authenticatable $user): bool
    {
        return in_array($this->role($user), ['admin', 'rayon_admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $user, Anggota $anggota): bool
    {
        return in_array($this->role($user), ['admin', 'rayon_admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, Anggota $anggota): bool
    {
        return $this->role($user) === 'admin';
    }

    private function role(Authenticatable $user): ?string
    {
        if ($user instanceof User) {
            return $user->role_slug;
        }

        if ($user instanceof Rayon) {
            return 'rayon_admin';
        }

        return null;
    }
}
