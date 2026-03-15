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
        Schema::table('blotter_records', function (Blueprint $table) {
            if (!Schema::hasColumn('blotter_records', 'resident_id')) {
                $table->foreignId('resident_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('residents')
                    ->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blotter_records', function (Blueprint $table) {
            if (Schema::hasColumn('blotter_records', 'resident_id')) {
                $table->dropConstrainedForeignId('resident_id');
            }
        });
    }
};

