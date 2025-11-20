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
        Schema::table('filter_options', function (Blueprint $table) {
            // Check if the column exists
            if (!Schema::hasColumn('filter_options', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('sort_order');
            } else {
                // Ensure the column has the correct default
                $table->boolean('is_active')->default(true)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't want to remove this column as it's needed
    }
};