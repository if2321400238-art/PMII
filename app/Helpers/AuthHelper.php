<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    /**
     * Get authenticated user from any guard
     */
    public static function user()
    {
        if (Auth::guard('web')->check()) {
            return Auth::guard('web')->user();
        }

        if (Auth::guard('rayon')->check()) {
            return Auth::guard('rayon')->user();
        }

        return null;
    }

    /**
     * Check if any guard is authenticated
     */
    public static function check(): bool
    {
        return Auth::guard('web')->check()
            || Auth::guard('rayon')->check();
    }

    /**
     * Get the name of the active guard
     */
    public static function guardName(): ?string
    {
        if (Auth::guard('web')->check()) {
            return 'web';
        }

        if (Auth::guard('rayon')->check()) {
            return 'rayon';
        }

        return null;
    }

    /**
     * Get user type: 'user' or 'rayon'
     */
    public static function userType(): ?string
    {
        if (Auth::guard('web')->check()) {
            return 'user';
        }

        if (Auth::guard('rayon')->check()) {
            return 'rayon';
        }

        return null;
    }
}
