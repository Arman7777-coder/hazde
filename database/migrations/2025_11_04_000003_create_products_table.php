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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // 卖家ID
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('details')->nullable(); // 产品详细信息
            $table->decimal('price', 10, 2)->nullable(); // 价格
            $table->string('price_type')->default('fixed'); // 价格类型：fixed（固定）或 hourly（每小时）
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('rejection_reason')->nullable(); // 拒绝原因
            $table->boolean('is_active')->default(false); // 是否激活（审批通过后激活）
            $table->integer('view_count')->default(0); // 浏览次数
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};