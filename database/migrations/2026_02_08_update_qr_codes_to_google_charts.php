<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update all QR codes that use the qrserver API to use Google Charts API instead
        $ids = DB::table('ids')
            ->whereRaw("qr_code LIKE '%api.qrserver.com%'")
            ->get();

        foreach ($ids as $id) {
            // Extract the data parameter from the old URL
            preg_match('/data=([^&]+)/', $id->qr_code, $matches);
            if (isset($matches[1])) {
                $data = urldecode($matches[1]);
                // Generate new URL using Google Charts API
                $newQrCode = 'https://chart.googleapis.com/chart?chs=150x150&chld=M|0&cht=qr&chl=' . urlencode($data);
                
                DB::table('ids')
                    ->where('id', $id->id)
                    ->update(['qr_code' => $newQrCode]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to qrserver if needed (optional)
        // This would be the reverse operation if you need to rollback
    }
};
