<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Services\QRCodeGenerator;
use App\Models\ResidentAccount;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all QR codes to use the new service (data URI approach)
        $ids = DB::table('ids')->get();

        foreach ($ids as $id) {
            try {
                // Get the resident account to regenerate the QR token and URL
                $residentAccount = ResidentAccount::where('resident_id', $id->resident_id)->first();
                
                if ($residentAccount) {
                    // Generate QR code using the new service
                    $qrToken = $residentAccount->qr_token ?? $residentAccount->generateQRToken();
                    $qrUrl = route('qr.authenticate', ['token' => $qrToken]);
                    $qrCodeImage = QRCodeGenerator::generateQRCode($qrUrl);
                    
                    // Update the database
                    DB::table('ids')
                        ->where('id', $id->id)
                        ->update(['qr_code' => $qrCodeImage]);
                }
            } catch (\Exception $e) {
                \Log::warning('Failed to update QR code for ID ' . $id->id . ': ' . $e->getMessage());
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optional: revert to Google Charts API URLs if needed
        // This would require storing the original token data
    }
};
