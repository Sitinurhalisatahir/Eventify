<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // ✅ Redirect berdasarkan role setelah login
        $user = Auth::user();

        // Admin
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        // Organizer
        if ($user->role === 'organizer') {
            // Jika status pending atau rejected, redirect ke pending page
            if (in_array($user->organizer_status, ['pending', 'rejected'])) {
                return redirect()->route('organizer.pending');
            }

            // Jika approved, redirect ke dashboard organizer
            if ($user->organizer_status === 'approved') {
                return redirect()->intended(route('organizer.dashboard'));
            }
        }

        // User biasa
        return redirect()->intended(route('user.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}