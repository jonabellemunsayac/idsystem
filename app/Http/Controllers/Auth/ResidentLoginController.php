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

        $qrAuth = $request->session()->get('resident_qr_auth');

        if ($qrAuth && (int) ($qrAuth['resident_account_id'] ?? 0) !== (int) $residentAccount->id) {
            throw ValidationException::withMessages([
                'username' => 'This account does not match the scanned QR code. Please use the account linked to that ID.',
            ]);
        }

        Auth::guard('resident')->login($residentAccount, $request->boolean('remember'));
        $request->session()->regenerate();
        $request->session()->forget('resident_qr_auth');
        $residentAccount->update(['last_login' => now()]);

        return redirect()->route('resident.dashboard');
    }
}
