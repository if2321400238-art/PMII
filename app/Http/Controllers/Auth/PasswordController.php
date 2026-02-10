<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     * Supports all guards: web (admin), rayon
     */
    public function update(Request $request): RedirectResponse
    {
        // Get user from any active guard
        $user = $request->user() ?? Auth::guard('rayon')->user();

        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password_any'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ], [
            'current_password.current_password_any' => 'Password saat ini tidak sesuai.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
