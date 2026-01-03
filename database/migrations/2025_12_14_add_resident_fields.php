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
        Schema::table('residents', function (Blueprint $table) {
            // Restructure address fields
            $table->string('house_no')->nullable()->after('barangay');
            $table->string('street_name')->nullable()->after('house_no');
            $table->string('purok')->nullable()->after('street_name');
            $table->string('province')->nullable()->after('purok');
            $table->string('zip_code')->nullable()->after('province');
            
            // Keep the old address column for backward compatibility (can be deprecated later)
            // It will be populated by combining the new fields
            
            // Additional resident information
            $table->string('special_sector')->nullable()->after('nationality');
            $table->string('telephone_no')->nullable()->after('contact_number');
            $table->string('blood_type')->nullable()->after('telephone_no');
            
            // Emergency contact information
            $table->string('emergency_contact_name')->nullable()->after('blood_type');
            $table->string('emergency_contact_no')->nullable()->after('emergency_contact_name');
            $table->string('emergency_contact_relationship')->nullable()->after('emergency_contact_no');
            $table->string('emergency_contact_address')->nullable()->after('emergency_contact_relationship');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropColumn([
                'house_no',
                'street_name',
                'purok',
                'province',
                'zip_code',
                'special_sector',
                'telephone_no',
                'blood_type',
                'emergency_contact_name',
                'emergency_contact_no',
                'emergency_contact_relationship',
                'emergency_contact_address',
            ]);
        });
    }
};
