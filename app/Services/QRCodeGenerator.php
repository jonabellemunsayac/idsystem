<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class QRCodeGenerator
{
    /**
     * Generate a QR code using qrserver.com API
     */
    public static function generateQRCode($data, $size = '150x150')
    {
        // Use qrserver API
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=' . $size . '&data=' . urlencode($data);
        
        return $qrUrl;
    }

    /**
     * Generate and store QR code as a file
     */
    public static function generateAndStoreQRCode($data, $filename = null)
    {
        if (!$filename) {
            $filename = 'qr-' . uniqid() . '.png';
        }

        $qrUrl = self::generateQRCode($data);
        
        // Optionally fetch and store the image locally
        try {
            $imageContents = @file_get_contents($qrUrl);
            if ($imageContents) {
                Storage::disk('public')->put('qrcodes/' . $filename, $imageContents);
                return Storage::disk('public')->url('qrcodes/' . $filename);
            }
        } catch (\Exception $e) {
            \Log::warning('Failed to cache QR code: ' . $e->getMessage());
        }

        return $qrUrl;
    }
}


