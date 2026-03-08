<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Usage: Route::middleware('role:admin,superadmin')
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Comma-separated list of allowed roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = auth()->guard('web')->user();

        if (!$user || !in_array($user->role, $roles)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Forbidden'], 403);
            }

            return redirect()->route('dashboard')->with('error', 'You do not have permission to access that page.');
        }

        return $next($request);
    }
}
