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
            // Check if columns don't already exist before adding them
            if (!Schema::hasColumn('blotter_records', 'complainant_contact')) {
                $table->string('complainant_contact')->nullable()->after('complainant_name');
            }
            if (!Schema::hasColumn('blotter_records', 'respondent_contact')) {
                $table->string('respondent_contact')->nullable()->after('respondent_name');
            }
            if (!Schema::hasColumn('blotter_records', 'severity')) {
                $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium')->after('incident_location');
            }
            if (!Schema::hasColumn('blotter_records', 'status')) {
                $table->enum('status', ['pending', 'investigating', 'resolved'])->default('pending')->after('severity');
            }
            if (!Schema::hasColumn('blotter_records', 'witnesses')) {
                $table->integer('witnesses')->default(0)->after('status');
            }
            if (!Schema::hasColumn('blotter_records', 'notes')) {
                $table->text('notes')->nullable()->after('witnesses');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blotter_records', function (Blueprint $table) {
            if (Schema::hasColumn('blotter_records', 'complainant_contact')) {
                $table->dropColumn('complainant_contact');
            }
            if (Schema::hasColumn('blotter_records', 'respondent_contact')) {
                $table->dropColumn('respondent_contact');
            }
            if (Schema::hasColumn('blotter_records', 'severity')) {
                $table->dropColumn('severity');
            }
            if (Schema::hasColumn('blotter_records', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('blotter_records', 'witnesses')) {
                $table->dropColumn('witnesses');
            }
            if (Schema::hasColumn('blotter_records', 'notes')) {
                $table->dropColumn('notes');
            }
        });
    }
};
