<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\MediaCompressionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(private readonly MediaCompressionService $mediaCompressionService)
    {
    }

    /**
     * Display the user's profile form.
     * Supports all guards: web (admin), rayon
     */
    public function edit(Request $request): View
    {
        // Get user from any active guard and determine user type
        $user = null;
        $userType = 'admin';

        if (Auth::guard('rayon')->check()) {
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
        $isRayon = false;

        if (Auth::guard('rayon')->check()) {
            $user = Auth::guard('rayon')->user();
            $isRayon = true;
        } else {
            $user = $request->user();
        }

        $validated = $request->validated();

        if ($isRayon && $request->hasFile('logo_path')) {
            if ($user->logo_path && Storage::disk('public')->exists($user->logo_path)) {
                Storage::disk('public')->delete($user->logo_path);
            }

            $validated['logo_path'] = $this->mediaCompressionService->storeCompressedImage(
                $request->file('logo_path'),
                'rayon/logo'
            );
        }

        $user->fill($validated);

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
