<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Korwil;
use App\Models\Rayon;
use App\Models\SKPengajuan;
use Illuminate\Contracts\Auth\Authenticatable;

class SKPengajuanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Authenticatable $user): bool
    {
        return $this->role($user) === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Authenticatable $user, SKPengajuan $sk): bool
    {
        return $this->role($user) === 'admin';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Authenticatable $user): bool
    {
        return in_array($this->role($user), ['admin', 'korwil_admin', 'rayon_admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $user, SKPengajuan $sk): bool
    {
        // Only pending SKs can be updated by submitter
        return ($user->getAuthIdentifier() === $sk->submitted_by && $sk->status === 'pending') || $this->role($user) === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, SKPengajuan $sk): bool
    {
        return $this->role($user) === 'admin';
    }

    /**
     * Only Admin can approve/reject/revise
     */
    public function approve(Authenticatable $user, SKPengajuan $sk): bool
    {
        return $this->role($user) === 'admin';
    }

    public function revise(Authenticatable $user, SKPengajuan $sk): bool
    {
        return $this->role($user) === 'admin';
    }

    public function reject(Authenticatable $user, SKPengajuan $sk): bool
    {
        return $this->role($user) === 'admin';
    }

    private function role(Authenticatable $user): ?string
    {
        if ($user instanceof User) {
            return $user->role === 'pb' ? 'admin' : $user->role;
        }

        if ($user instanceof Korwil) {
            return 'korwil_admin';
        }

        if ($user instanceof Rayon) {
            return 'rayon_admin';
        }

        return null;
    }
}
