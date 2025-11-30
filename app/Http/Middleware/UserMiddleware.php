<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan rolenya user
        if (!auth()->check() || auth()->user()->role !== 'user') {
            abort(403, 'Unauthorized access. User only.');
        }

        return $next($request);
    }
}