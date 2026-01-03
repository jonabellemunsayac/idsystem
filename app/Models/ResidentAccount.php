<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class ResidentAccount extends Authenticatable
{
    use Notifiable;

    protected $table = 'resident_accounts';

    protected $fillable = [
        'resident_id',
        'username',
        'password_hash',
        'email',
        'qr_token',
        'last_login',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'last_login' => 'datetime',
    ];

    // Relationship to Resident
    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    // Generate QR token - only generate if not already exists
    public function generateQRToken()
    {
        // If token already exists and is valid, return existing token
        if ($this->qr_token && $this->isQRTokenValid()) {
            return $this->qr_token;
        }

        // Generate new token with no expiration
        $qrToken = Str::random(40);
        
        $this->update([
            'qr_token' => $qrToken,
        ]);

        return $qrToken;
    }

    // Regenerate QR token
    public function regenerateQRToken()
    {
        $qrToken = Str::random(40);
        
        $this->update([
            'qr_token' => $qrToken,
        ]);
        
        return $qrToken;
    }

    // Check if QR token is valid
    public function isQRTokenValid()
    {
        return !is_null($this->qr_token);
    }

    // Get QR code URL
    public function getQRCodeUrl()
    {
        if (!$this->qr_token) {
            return null;
        }
        return route('qr.authenticate', ['token' => $this->qr_token]);
    }

    // Required for authentication - returns the password field
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
