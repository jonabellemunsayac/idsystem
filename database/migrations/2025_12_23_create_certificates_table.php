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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resident_id')->constrained('residents')->cascadeOnDelete();
            $table->string('reference_number')->unique();
            $table->enum('type', [
                'barangay_clearance',
                'certificate_of_indigency',
                'certificate_of_residency',
                'business_permit',
                'community_tax_certificate',
                'other'
            ]);
            $table->string('purpose');
            $table->text('purpose_details')->nullable();
            $table->enum('status', [
                'pending',
                'processing',
                'approved',
                'ready',
                'released',
                'cancelled'
            ])->default('pending');
            $table->enum('pickup_or_delivery', ['pickup', 'delivery'])->default('pickup');
            $table->string('delivery_address')->nullable();
            $table->date('approved_date')->nullable();
            $table->date('released_date')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->foreignId('released_by')->nullable()->constrained('users');
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
