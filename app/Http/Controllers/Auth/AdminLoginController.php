<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Check if user has a valid staff role
            if (!in_array($user->role, ['encoder', 'site_editor', 'admin', 'superadmin'])) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'username' => 'Only staff accounts can access this.',
                ]);
            }

            // Log the successful login with IP address (wrapped in try-catch)
            try {
                \App\Services\ActivityLogger::logLogin($user->id, $request->ip());
            } catch (\Exception $e) {
                // Fail silently if logging fails
                \Log::error('Failed to log admin login: ' . $e->getMessage());
            }

            return redirect()->route('dashboard');
        }

        throw ValidationException::withMessages([
            'username' => 'These credentials do not match our records.',
        ]);
    }
}
