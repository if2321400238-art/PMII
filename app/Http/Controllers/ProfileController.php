<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     * Supports all guards: web (admin), korwil, rayon
     */
    public function edit(Request $request): View
    {
        // Get user from any active guard and determine user type
        $user = null;
        $userType = 'admin';

        if (Auth::guard('korwil')->check()) {
            $user = Auth::guard('korwil')->user();
            $userType = 'korwil';
        } elseif (Auth::guard('rayon')->check()) {
            $user = Auth::guard('rayon')->user();
            $userType = 'rayon';
        } else {
            $user = $request->user();
            $userType = 'admin';
        }

        return view('admin.profile.edit', [
            'user' => $user,
            'userType' => $userType,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Get user from any active guard
        $user = null;

        if (Auth::guard('korwil')->check()) {
            $user = Auth::guard('korwil')->user();
        } elseif (Auth::guard('rayon')->check()) {
            $user = Auth::guard('rayon')->user();
        } else {
            $user = $request->user();
        }

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
