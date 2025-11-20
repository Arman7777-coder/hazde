<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first product
        $product = Product::first();
        
        if ($product) {
            // Create a sample product image
            $productImage = new ProductImage();
            $productImage->product_id = $product->id;
            $productImage->image_path = 'products/sample-car.jpg';
            $productImage->is_primary = true;
            $productImage->save();
            
            // Create directory if it doesn't exist
            $productsDir = storage_path('app/public/products');
            if (!file_exists($productsDir)) {
                mkdir($productsDir, 0755, true);
            }
            
            // Copy sample image if it exists in public/images
            $sourcePath = public_path('images/car.png');
            $destinationPath = storage_path('app/public/products/sample-car.jpg');
            
            if (file_exists($sourcePath)) {
                copy($sourcePath, $destinationPath);
            } else {
                // If source doesn't exist, create a simple placeholder
                if (!file_exists($destinationPath)) {
                    // Create a simple placeholder image
                    $im = imagecreate(300, 200);
                    $bg = imagecolorallocate($im, 200, 200, 200);
                    $textColor = imagecolorallocate($im, 0, 0, 0);
                    imagestring($im, 5, 100, 90, 'Sample Image', $textColor);
                    imagejpeg($im, $destinationPath);
                    imagedestroy($im);
                }
            }
        }
    }
}