<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ids', function (Blueprint $table) {
            $table->longText('qr_code')->nullable()->after('expiration_date'); // Base64 encoded QR code image
            $table->string('qr_code_url')->nullable()->after('qr_code'); // URL that QR code points to
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ids', function (Blueprint $table) {
            $table->dropColumn(['qr_code', 'qr_code_url']);
        });
    }
};
