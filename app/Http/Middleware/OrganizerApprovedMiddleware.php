<?php
// app/Http/Middleware/OrganizerApprovedMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrganizerApprovedMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Cek apakah user adalah organizer
        if (!$user || $user->role !== 'organizer') {
            abort(403, 'Unauthorized access.');
        }

        // Jika status pending atau rejected, redirect ke pending page
        if (in_array($user->organizer_status, ['pending', 'rejected'])) {
            return redirect()->route('organizer.pending');
        }

        // Jika status approved, lanjutkan
        if ($user->organizer_status !== 'approved') {
            abort(403, 'Your organizer account is not approved yet.');
        }

        return $next($request);
    }
}