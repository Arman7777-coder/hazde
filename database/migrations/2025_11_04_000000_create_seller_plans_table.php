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
        Schema::create('seller_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // free, basic, pro
            $table->string('description')->nullable();
            $table->decimal('price', 10, 2)->default(0); // 价格，免费套餐为0
            $table->integer('max_products')->nullable(); // 最大产品数，null表示无限制
            $table->integer('max_images_per_product')->default(1); // 每个产品最大图片数
            $table->boolean('can_set_price')->default(true); // 是否可以设置价格
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_plans');
    }
};