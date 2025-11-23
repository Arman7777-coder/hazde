<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first category and user with seller role
        $category = Category::first();
        $seller = User::whereHas('roles', function ($query) {
            $query->where('name', 'seller');
        })->first();
        
        // If no seller exists, create one
        if (!$seller) {
            $seller = User::factory()->create([
                'uuid' => Str::uuid()->toString(),
                'name' => 'Test Seller',
                'email' => 'seller@example.com',
                'password' => bcrypt('password'),
            ]);
            
            $seller->assignRole('seller');
        }
        
        // Create a sample product
        $product = new Product();
        $product->user_id = $seller->id;
        $product->category_id = $category ? $category->id : null;
        $product->name = 'Пример свадебного автомобиля';
        $product->slug = Str::slug($product->name);
        $product->description = 'Роскошный автомобиль для свадьбы. Отличный выбор для вашего особенного дня.';
        $product->details = 'Автомобиль марки Rolls Royce, белого цвета, с декоративными элементами. В комплекте водитель в форменной одежде.';
        $product->price = 50000;
        $product->price_type = 'hourly';
        $product->status = 'approved';
        $product->is_active = true;
        $product->save();
    }
}