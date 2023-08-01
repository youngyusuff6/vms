<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
          // Check if the user is authenticated and has the admin role
    if (Auth::check() && Auth::user()->role === 'admin') {
        // User has the admin role, allow access to the route
        return $next($request);
    }
    // User does not have the admin role, redirect or return an unauthorized response
    return redirect('/')->with('error', 'Unauthorized access');
    }
}
