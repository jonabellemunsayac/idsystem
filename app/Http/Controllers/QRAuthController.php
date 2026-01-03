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
        // Find the resident account by QR token
        $residentAccount = ResidentAccount::where('qr_token', $token)
            ->with('resident')
            ->firstOrFail();

        // Create session for resident using the 'resident' guard
        auth('resident')->login($residentAccount);

        // Update last login timestamp
        $residentAccount->update(['last_login' => now()]);

        // Redirect to resident dashboard
        return redirect()->route('resident.dashboard')->with('success', 'Welcome back!');
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
