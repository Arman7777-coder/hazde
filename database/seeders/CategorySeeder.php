<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories directory if it doesn't exist
        $categoriesDir = storage_path('app/public/categories');
        if (!file_exists($categoriesDir)) {
            mkdir($categoriesDir, 0755, true);
        }

        $categories = [
            [
                'name' => 'Авто',
                'description' => 'Свадебные кортежи и автомобили премиум-класса.',
                'image_file' => 'rolce-image.png',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Фото & Видео',
                'description' => 'Сохраните лучшие моменты вашего праздника.',
                'image_file' => 'photo-video.png',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Дома торжеств',
                'description' => 'Лучшие рестораны и банкетные залы для вашего события.',
                'image_file' => 'beautiful-home.png',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Ведущие & Музыка',
                'description' => 'Профессиональные ведущие, диджеи и музыканты.',
                'image_file' => 'music-violin.png',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Флористика',
                'description' => 'Свадебные букеты, декор и цветочное оформление.',
                'image_file' => 'flower-cat.png',
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'name' => 'Кейтеринг',
                'description' => 'Изысканные блюда и выездное обслуживание.',
                'image_file' => 'furchete-cat.png',
                'sort_order' => 6,
                'is_active' => true
            ],
            [
                'name' => 'Всадники',
                'description' => 'Эффектное появление и фотосессии на лошадях.',
                'image_file' => 'horse-cat.png',
                'sort_order' => 7,
                'is_active' => true
            ],
            [
                'name' => 'Упаковка приданого',
                'description' => 'Современное оформление традиционных подарков.',
                'image_file' => 'gift-car.png',
                'sort_order' => 8,
                'is_active' => true
            ],
            [
                'name' => 'Аксессуары',
                'description' => 'Пригласительные, бокалы и другие важные мелочи.',
                'image_file' => 'accesories.png',
                'sort_order' => 9,
                'is_active' => true
            ],
        ];

        foreach ($categories as $categoryData) {
            // Check if category already exists
            $existingCategory = Category::where('name', $categoryData['name'])->first();
            
            if ($existingCategory) {
                // Update existing category
                $existingCategory->update([
                    'description' => $categoryData['description'],
                    'sort_order' => $categoryData['sort_order'],
                    'is_active' => $categoryData['is_active']
                ]);
                
                // Copy image if it doesn't exist or if we want to update it
                if ($categoryData['image_file']) {
                    $sourcePath = public_path('images/' . $categoryData['image_file']);
                    $destinationPath = 'categories/' . $categoryData['image_file'];
                    $fullDestinationPath = storage_path('app/public/' . $destinationPath);
                    
                    // Check if source file exists
                    if (file_exists($sourcePath)) {
                        // Copy file to storage
                        copy($sourcePath, $fullDestinationPath);
                        $existingCategory->update(['image' => $destinationPath]);
                    }
                }
            } else {
                // Create new category
                $category = new Category();
                $category->name = $categoryData['name'];
                $category->description = $categoryData['description'];
                $category->sort_order = $categoryData['sort_order'];
                $category->is_active = $categoryData['is_active'];
                
                // Copy image if it exists
                if ($categoryData['image_file']) {
                    $sourcePath = public_path('images/' . $categoryData['image_file']);
                    $destinationPath = 'categories/' . $categoryData['image_file'];
                    $fullDestinationPath = storage_path('app/public/' . $destinationPath);
                    
                    // Check if source file exists
                    if (file_exists($sourcePath)) {
                        // Copy file to storage
                        copy($sourcePath, $fullDestinationPath);
                        $category->image = $destinationPath;
                    }
                }
                
                $category->save();
            }
        }
    }
}