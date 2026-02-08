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
        // Revert all QR codes back to qrserver.com format
        $ids = DB::table('ids')->get();

        foreach ($ids as $id) {
            try {
                // Get the resident account to get the QR token
                $residentAccount = ResidentAccount::where('resident_id', $id->resident_id)->first();
                
                if ($residentAccount) {
                    // Generate QR code using qrserver API
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
        // No action needed on rollback
    }
};
