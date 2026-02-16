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
        Schema::table('certificates', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['resident_id']);
            
            // Modify the column to be nullable
            $table->unsignedBigInteger('resident_id')->nullable()->change();
            
            // Re-add the foreign key constraint
            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            // Drop the foreign key
            $table->dropForeign(['resident_id']);
            
            // Make it non-nullable again
            $table->unsignedBigInteger('resident_id')->change();
            
            // Re-add the foreign key constraint
            $table->foreign('resident_id')->references('id')->on('residents')->onDelete('cascade');
        });
    }
};
