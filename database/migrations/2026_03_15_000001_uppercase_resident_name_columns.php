<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            UPDATE residents
            SET
                first_name = UPPER(first_name),
                middle_name = UPPER(middle_name),
                last_name = UPPER(last_name)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Irreversible: original letter casing cannot be restored automatically.
    }
};

