<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PublicRegisterOnly
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
        // Redirect any authenticated user (admin or resident) away from public register
        if (auth()->check()) {
            return auth()->user()->role === 'admin'
                ? redirect()->route('admin.login')
                : redirect()->route('login');
        }

        return $next($request);
    }
}
