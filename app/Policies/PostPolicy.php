<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rayon;
use App\Models\Post;
use Illuminate\Contracts\Auth\Authenticatable;

class PostPolicy
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
    public function view(Authenticatable $user, Post $post): bool
    {
        return true; // Everyone can view published posts
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Authenticatable $user): bool
    {
        return $user !== null; // Semua user bisa buat post (akan pending)
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $user, Post $post): bool
    {
        if ($this->role($user) === 'admin') {
            return true;
        }

        return (int) $post->author_id === (int) $user->getAuthIdentifier()
            && $post->author_type === get_class($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, Post $post): bool
    {
        if ($this->role($user) === 'admin') {
            return true;
        }

        return (int) $post->author_id === (int) $user->getAuthIdentifier()
            && $post->author_type === get_class($user);
    }

    /**
     * Determine whether the user can approve the model.
     */
    public function approve(Authenticatable $user, Post $post): bool
    {
        return $this->role($user) === 'admin';
    }

    /**
     * Determine whether the user can reject the model.
     */
    public function reject(Authenticatable $user, Post $post): bool
    {
        return $this->role($user) === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Authenticatable $user, Post $post): bool
    {
        return $this->role($user) === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Authenticatable $user, Post $post): bool
    {
        return $this->role($user) === 'admin';
    }

    private function role(Authenticatable $user): ?string
    {
        if ($user instanceof User) {
            return $user->role_slug;
        }

        if ($user instanceof Rayon) {
            return 'rayon';
        }

        return null;
    }
}
