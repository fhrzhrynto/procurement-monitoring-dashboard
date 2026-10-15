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
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has admin role (role=1)
        if (Auth::check() && Auth::user()->role == 1) {
            return $next($request);
        }
        
        // Redirect to dashboard with error message if not admin
        return redirect()->route('dashboard')->with('error', 'You do not have permission to access this page.');
    }
}