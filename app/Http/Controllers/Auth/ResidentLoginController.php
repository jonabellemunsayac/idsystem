<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ResidentLoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Check if user is admin - redirect them to admin login
            if ($user->role === 'admin') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Admin accounts must use /admin/login',
                ]);
            }

            // Log the successful login with IP address (wrapped in try-catch)
            try {
                ActivityLogger::logLogin($user->id, $request->ip());
            } catch (\Exception $e) {
                // Fail silently if logging fails
                \Log::error('Failed to log resident login: ' . $e->getMessage());
            }

            return redirect()->route('resident.dashboard');
        }

        throw ValidationException::withMessages([
            'email' => 'These credentials do not match our records.',
        ]);
    }
}
