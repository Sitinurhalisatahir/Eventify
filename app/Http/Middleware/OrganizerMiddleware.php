<?php
// app/Http/Middleware/OrganizerMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrganizerMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan rolenya organizer
        if (!auth()->check() || auth()->user()->role !== 'organizer') {
            abort(403, 'Unauthorized access. Organizer only.');
        }

        return $next($request);
    }
}