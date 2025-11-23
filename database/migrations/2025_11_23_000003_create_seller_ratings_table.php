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
        Schema::create('seller_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable(); // Admin who set the rating
            $table->unsignedBigInteger('seller_id');
            $table->tinyInteger('rating')->unsigned(); // Rating from 1 to 5
            $table->text('notes')->nullable(); // Admin notes about the rating
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_ratings');
    }
};