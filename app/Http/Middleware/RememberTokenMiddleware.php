<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RememberTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        // Jika user terautentikasi dan memiliki remember token
        if (Auth::check() && Auth::viaRemember()) {
            $user = Auth::user();
            Log::info("User authenticated via remember token: {$user->email}");
        }

        return $next($request);
    }
}