<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated and has the admin role
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);  // Allow the request to continue
        }

        // Prevent redirect loop by checking if the user is already on the discover page
        if ($request->is('discover') || $request->is('discover/*')) {
            return $next($request);  // If they're already on the discover page, allow the request
        }

        // Redirect non-admin users to the discover page
        return redirect('/discover');
    }
}
