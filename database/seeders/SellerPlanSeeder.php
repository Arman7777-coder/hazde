<?php

namespace Database\Seeders;

use App\Models\SellerPlan;
use Illuminate\Database\Seeder;

class SellerPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SellerPlan::create([
            'name' => 'free',
            'description' => 'Бесплатный тариф - 1 товар, 1 изображение на товар',
            'price' => 0,
            'max_products' => 1,
            'max_images_per_product' => 1,
            'can_set_price' => true
        ]);

        SellerPlan::create([
            'name' => 'basic',
            'description' => 'Базовый тариф - 5 товаров, 3 изображения на товар',
            'price' => 499, // 499 руб.
            'max_products' => 5,
            'max_images_per_product' => 3,
            'can_set_price' => true
        ]);

        SellerPlan::create([
            'name' => 'pro',
            'description' => 'Профессиональный тариф - Неограниченное количество товаров, 5 изображений на товар',
            'price' => 999, // 999 руб.
            'max_products' => null, // 无限制
            'max_images_per_product' => 5,
            'can_set_price' => true
        ]);
    }
}