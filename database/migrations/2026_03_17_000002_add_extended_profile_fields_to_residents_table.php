<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->decimal('height_cm', 5, 2)->nullable()->after('blood_type');
            $table->decimal('weight_kg', 5, 2)->nullable()->after('height_cm');
            $table->string('religion', 100)->nullable()->after('weight_kg');
            $table->string('spouse_name')->nullable()->after('religion');
            $table->text('children_names')->nullable()->after('spouse_name');
            $table->string('father_name')->nullable()->after('children_names');
            $table->string('mother_maiden_name')->nullable()->after('father_name');
            $table->string('residency_type', 50)->nullable()->after('mother_maiden_name');
            $table->string('tenure_status', 50)->nullable()->after('residency_type');
            $table->string('length_of_stay', 100)->nullable()->after('tenure_status');
            $table->string('registered_voter', 10)->nullable()->after('length_of_stay');
            $table->string('precinct_no', 50)->nullable()->after('registered_voter');
            $table->string('occupation')->nullable()->after('precinct_no');
            $table->string('employment_type', 50)->nullable()->after('occupation');
            $table->string('economic_status', 100)->nullable()->after('employment_type');
        });
    }

    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropColumn([
                'height_cm',
                'weight_kg',
                'religion',
                'spouse_name',
                'children_names',
                'father_name',
                'mother_maiden_name',
                'residency_type',
                'tenure_status',
                'length_of_stay',
                'registered_voter',
                'precinct_no',
                'occupation',
                'employment_type',
                'economic_status',
            ]);
        });
    }
};
