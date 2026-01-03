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
        // -------- directories table --------
        Schema::create('directories', function (Blueprint $table) {
            $table->id();
            $table->string('office_name');
            $table->string('contact_number')->nullable();
            $table->string('office_hours')->nullable();
            $table->timestamps();
        });


        // -------- service_request_links table --------
        Schema::create('service_request_links', function (Blueprint $table) {
            $table->id();
            $table->string('link_name');
            $table->string('url');
            $table->timestamps();
        });


        // -------- blotter_records table --------
        Schema::create('blotter_records', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->unique();
            $table->string('complainant_name');
            $table->string('respondent_name')->nullable();
            $table->string('incident_type');
            $table->string('incident_location');
            $table->text('details')->nullable();
            $table->timestamp('incident_date');
            $table->timestamps();
        });


        // -------- assets table --------
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_name');
            $table->string('category');
            $table->integer('quantity');
            $table->date('acquisition_date')->nullable();
            $table->timestamps();
        });


        // -------- asset_logs table --------
        Schema::create('asset_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnDelete();
            $table->string('log_type');
            $table->text('description')->nullable();
            $table->date('date_performed');
            $table->timestamps();
        });

        // -------- announcements table --------
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });

        // -------- resident_family table --------
        Schema::create('resident_family', function (Blueprint $table) {
            $table->id();
            $table->string('family_id')->unique();
            $table->string('leader_name');
            $table->timestamps();
        });


        // -------- residents table --------
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->enum('gender', ['Male','Female'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('nationality')->nullable();
            $table->string('barangay')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('family_id')->nullable()->constrained('resident_family');
            $table->timestamps();
        });


        // -------- resident_accounts table --------
        Schema::create('resident_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->cascadeOnDelete();
            $table->string('username')->unique();
            $table->string('password_hash');
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });

        // -------- audit_logs table --------
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('action');
            $table->text('details')->nullable();
            $table->timestamps();
        });


        // -------- resident_cases table --------
        Schema::create('resident_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->cascadeOnDelete();
            $table->string('case_type');
            $table->timestamps();
        });


        // -------- families table --------
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('family_name');
            $table->string('description')->nullable();
            $table->timestamps();
        });


        // -------- ids table --------
        Schema::create('ids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->cascadeOnDelete();
            $table->string('id_type');
            $table->string('id_number')->unique();
            $table->string('issued_by')->nullable();
            $table->date('issued_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->timestamps();
        });

        // -------- appointments table --------
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->cascadeOnDelete();
            $table->string('service_type');
            $table->string('reference_number')->unique();
            $table->dateTime('scheduled_time');
            $table->string('status')->default('pending');
            $table->timestamps();
        });

        // -------- appointment_notes table --------
        Schema::create('appointment_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->cascadeOnDelete();
            $table->text('note');
            $table->timestamps();
        });


        // -------- cases table --------
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // CHILD TABLES FIRST
        Schema::dropIfExists('appointment_notes');
        Schema::dropIfExists('appointments');

        Schema::dropIfExists('ids');
        Schema::dropIfExists('resident_cases');
        Schema::dropIfExists('resident_accounts');

        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('announcements');

        Schema::dropIfExists('asset_logs');

        // THEN PARENT TABLES
        Schema::dropIfExists('residents');
        Schema::dropIfExists('resident_family');

        Schema::dropIfExists('families');
        Schema::dropIfExists('assets');

        Schema::dropIfExists('blotter_records');
        Schema::dropIfExists('service_request_links');
        Schema::dropIfExists('directories');
        Schema::dropIfExists('cases');
    }
};
