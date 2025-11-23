<?php

namespace Database\Seeders;

use App\Models\SellerPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SellerPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SellerPlan::updateOrCreate(
            ['name' => 'Базовый'],
            [
                'description' => 'Базовый тарифный план для новых продавцов',
                'price' => 0, // Updated to 2000 rubles/month
                'max_products' => 1,
                'max_images_per_product' => 1, // Changed to 1 image for free plan
                'can_set_price' => true
            ]
        );

        SellerPlan::updateOrCreate(
            ['name' => 'Расширенный'],
            [
                'description' => 'Расширенный тарифный план для активных продавцов',
                'price' => 2000, // Updated to 5000 rubles/month
                'max_products' => 20,
                'max_images_per_product' => 5, // 5 images for paid plans
                'can_set_price' => true
            ]
        );

        SellerPlan::updateOrCreate(
            ['name' => 'Pro'],
            [
                'description' => 'Профессиональный тарифный план для крупных продавцов',
                'price' => 5000, // Updated to 5000 rubles/month
                'max_products' => null, // Unlimited
                'max_images_per_product' => 5, // 5 images for paid plans (changed from 10)
                'can_set_price' => true
            ]
        );
    }
}
