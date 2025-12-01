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
    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('profile.edit', compact('user'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
    $user = $request->user();
    
    $user->fill($request->validated());

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    if ($request->hasFile('profile_image')) {
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $path = $request->file('profile_image')->store('profiles', 'public');
        $user->profile_image = $path;
    }

    $user->save();

    $redirectRoute = match($user->role) {
        'admin' => 'admin.dashboard',
        'organizer' => 'organizer.dashboard',
        default => 'user.dashboard',
    };

    return Redirect::route($redirectRoute)
        ->with('success', 'Profile updated successfully!');
}

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

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->role === 'organizer') {
            $hasEvents = $user->events()->exists();
            if ($hasEvents) {
                return back()->withErrors([
                    'password' => 'Cannot delete account. You have active events. Please delete all events first.'
                ])->withBag('userDeletion');
            }
        }

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