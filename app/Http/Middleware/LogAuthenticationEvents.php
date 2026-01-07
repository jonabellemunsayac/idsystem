<?php

namespace App\Http\Middleware;

use App\Services\ActivityLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogAuthenticationEvents
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Check if user is logging out
            if ($request->route() && $request->route()->getName() === 'logout' && Auth::check()) {
                $userId = Auth::id();
                ActivityLogger::logLogout($userId);
            }
        } catch (\Exception $e) {
            // Fail silently if middleware logging fails
            \Log::error('Middleware logging error: ' . $e->getMessage());
        }

        return $next($request);
    }
}

