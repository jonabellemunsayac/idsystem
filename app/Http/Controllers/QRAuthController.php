<?php

namespace App\Http\Controllers;

use App\Models\ResidentAccount;
use Illuminate\Http\Request;

class QRAuthController extends Controller
{
    /**
     * Authenticate resident via QR token
     * Route: GET /qr/authenticate/{token}
     */
    public function authenticate($token)
    {
        $residentAccount = ResidentAccount::where('qr_token', $token)
            ->with('resident')
            ->firstOrFail();

        if (auth('resident')->check() && auth('resident')->id() === $residentAccount->id) {
            $residentAccount->update(['last_login' => now()]);
            return redirect()->route('resident.dashboard')->with('success', 'QR verified. Welcome back!');
        }

        session([
            'resident_qr_auth' => [
                'token' => $token,
                'resident_account_id' => $residentAccount->id,
                'username' => $residentAccount->username,
                'resident_name' => $residentAccount->resident?->display_name,
            ],
        ]);

        return redirect()->route('login')->with('status', 'QR code verified. Enter your password to continue to the resident portal.');
    }

    /**
     * Generate QR token for a resident account
     * Used when creating an ID card
     */
    public function generateToken(ResidentAccount $residentAccount)
    {
        $token = $residentAccount->generateQRToken();
        $qrUrl = $residentAccount->getQRCodeUrl();

        return response()->json([
            'success' => true,
            'qr_token' => $token,
            'qr_url' => $qrUrl,
            'message' => 'QR token generated successfully',
        ]);
    }

    /**
     * Logout resident session
     */
    public function logout(Request $request)
    {
        auth('resident')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully');
    }

    /**
     * Get QR token info for a resident account
     */
    public function getTokenInfo(ResidentAccount $residentAccount)
    {
        return response()->json([
            'has_valid_token' => $residentAccount->qr_token ? true : false,
            'qr_url' => $residentAccount->getQRCodeUrl(),
            'last_login' => $residentAccount->last_login,
        ]);
    }

    /**
     * Regenerate QR token
     */
    public function regenerateToken(ResidentAccount $residentAccount)
    {
        $token = $residentAccount->generateQRToken();
        $qrUrl = $residentAccount->getQRCodeUrl();

        return response()->json([
            'success' => true,
            'qr_token' => $token,
            'qr_url' => $qrUrl,
            'message' => 'QR token regenerated successfully',
        ]);
    }
}
