<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrganizerApprovedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        if (!$user || $user->role !== 'organizer' || $user->organizer_status !== 'approved') {
            abort(403, 'Organizer account not approved yet.');
        }

        return $next($request);
    }
}