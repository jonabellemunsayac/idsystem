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
        Schema::table('resident_accounts', function (Blueprint $table) {
            $table->string('email')->nullable()->after('username');
            $table->string('qr_token')->unique()->nullable()->after('password_hash');
            $table->timestamp('qr_token_expires_at')->nullable()->after('qr_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resident_accounts', function (Blueprint $table) {
            $table->dropColumn(['email', 'qr_token', 'qr_token_expires_at']);
        });
    }
};
