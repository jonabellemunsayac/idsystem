<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated via web guard (admin)
        if (!auth()->guard('web')->check()) {
            // If trying to access admin route without admin auth, redirect to admin login
            return redirect()->route('admin.login');
        }

        // Ensure the authenticated user has a valid staff role
        if (!in_array(auth()->guard('web')->user()->role, ['encoder', 'site_editor', 'admin', 'superadmin'])) {
            // If resident or non-staff tries to access, redirect to public website
            return redirect()->route('public.home')->with('error', 'Access denied. This area is for administrators only.');
        }

        return $next($request);
    }
}
