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
        Schema::table('categories', function (Blueprint $table) {
            // Check if parent_id column exists before trying to drop it
            if (Schema::hasColumn('categories', 'parent_id')) {
                // Check if foreign key constraint exists before dropping it
                try {
                    $table->dropForeign(['parent_id']);
                } catch (Exception $e) {
                    // Foreign key doesn't exist, continue
                }
                $table->dropColumn('parent_id');
            }
            
            // Add image column if it doesn't exist
            if (!Schema::hasColumn('categories', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Drop image column if it exists
            if (Schema::hasColumn('categories', 'image')) {
                $table->dropColumn('image');
            }
            
            // Add parent_id column if it doesn't exist
            if (!Schema::hasColumn('categories', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('description');
                $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            }
        });
    }
};