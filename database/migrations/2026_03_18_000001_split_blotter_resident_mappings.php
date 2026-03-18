<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blotter_records', function (Blueprint $table) {
            if (!Schema::hasColumn('blotter_records', 'complainant_resident_id')) {
                $table->foreignId('complainant_resident_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('residents')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('blotter_records', 'respondent_resident_id')) {
                $table->foreignId('respondent_resident_id')
                    ->nullable()
                    ->after('complainant_resident_id')
                    ->constrained('residents')
                    ->nullOnDelete();
            }
        });

        if (Schema::hasColumn('blotter_records', 'resident_id')) {
            DB::table('blotter_records')
                ->whereNotNull('resident_id')
                ->update([
                    'complainant_resident_id' => DB::raw('resident_id'),
                ]);

            Schema::table('blotter_records', function (Blueprint $table) {
                $table->dropConstrainedForeignId('resident_id');
            });
        }
    }

    public function down(): void
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

        if (Schema::hasColumn('blotter_records', 'complainant_resident_id')) {
            DB::table('blotter_records')
                ->whereNotNull('complainant_resident_id')
                ->update([
                    'resident_id' => DB::raw('complainant_resident_id'),
                ]);
        }

        Schema::table('blotter_records', function (Blueprint $table) {
            if (Schema::hasColumn('blotter_records', 'respondent_resident_id')) {
                $table->dropConstrainedForeignId('respondent_resident_id');
            }

            if (Schema::hasColumn('blotter_records', 'complainant_resident_id')) {
                $table->dropConstrainedForeignId('complainant_resident_id');
            }
        });
    }
};
