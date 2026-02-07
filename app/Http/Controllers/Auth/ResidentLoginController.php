<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ResidentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResidentLoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $residentAccount = ResidentAccount::where('username', $request->username)->first();

        if (!$residentAccount || !Hash::check($request->password, $residentAccount->password_hash)) {
            throw ValidationException::withMessages([
                'username' => 'These credentials do not match our records.',
            ]);
        }

        Auth::guard('resident')->login($residentAccount, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->route('resident.dashboard');
    }
}
