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
        Schema::table('clans', function (Blueprint $table) {
            // Drop the composite unique index on clan_name + address
            $table->dropUnique('clans_name_address_unique');
            
            // Add unique index on clan_name only (case-insensitive)
            $table->unique('clan_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clans', function (Blueprint $table) {
            // Revert to composite unique index
            $table->dropUnique(['clan_name']);
            $table->unique(['clan_name', 'address'], 'clans_name_address_unique');
        });
    }
};
