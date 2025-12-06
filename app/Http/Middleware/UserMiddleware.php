<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
   
    public function handle(Request $request, Closure $next): Response
    {
        
        if (!auth()->check() || auth()->user()->role !== 'user') {
            abort(403, 'Unauthorized access. User only.');
        }

        return $next($request);
    }
}