<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Determine which view to show based on role
        // Bisa pakai view yang sama atau berbeda per role
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    
    // Fill validated data
    $user->fill($request->validated());

    // If email changed, reset email_verified_at
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    // Handle profile image upload
    if ($request->hasFile('profile_image')) {
        // Delete old image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Store new image - HANYA SATU KALI
        $path = $request->file('profile_image')->store('profiles', 'public');
        $user->profile_image = $path;
    }

    $user->save();

    // Redirect based on role
    $redirectRoute = match($user->role) {
        'admin' => 'admin.dashboard',
        'organizer' => 'organizer.dashboard',
        default => 'user.dashboard',
    };

    return Redirect::route($redirectRoute)
        ->with('success', 'Profile updated successfully!');
}

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully!');
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

        // Check if organizer has events
        if ($user->role === 'organizer') {
            $hasEvents = $user->events()->exists();
            if ($hasEvents) {
                return back()->withErrors([
                    'password' => 'Cannot delete account. You have active events. Please delete all events first.'
                ])->withBag('userDeletion');
            }
        }

        // Check if user has active bookings
        if ($user->role === 'user') {
            $hasActiveBookings = $user->bookings()
                ->whereIn('status', ['pending', 'approved'])
                ->exists();
            
            if ($hasActiveBookings) {
                return back()->withErrors([
                    'password' => 'Cannot delete account. You have active bookings. Please cancel all bookings first.'
                ])->withBag('userDeletion');
            }
        }

        // Delete profile image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }



        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')
            ->with('success', 'Account deleted successfully.');
    }
}