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
        Schema::table('assets', function (Blueprint $table) {
            if (!Schema::hasColumn('assets', 'status')) {
                $table->enum('status', ['working', 'maintenance', 'disposal', 'inactive'])->default('working')->after('quantity');
            }
            if (!Schema::hasColumn('assets', 'last_maintenance_date')) {
                $table->date('last_maintenance_date')->nullable()->after('acquisition_date');
            }
            if (!Schema::hasColumn('assets', 'description')) {
                $table->text('description')->nullable()->after('last_maintenance_date');
            }
            if (!Schema::hasColumn('assets', 'location')) {
                $table->string('location')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            if (Schema::hasColumn('assets', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('assets', 'last_maintenance_date')) {
                $table->dropColumn('last_maintenance_date');
            }
            if (Schema::hasColumn('assets', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('assets', 'location')) {
                $table->dropColumn('location');
            }
        });
    }
};
