<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Filter;
use App\Models\FilterOption;
use Illuminate\Database\Seeder;

class FilterOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a category
        $category = Category::firstOrCreate([
            'name' => 'Electronics',
            'description' => 'Electronic devices and accessories',
        ], [
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Get or create a filter
        $filter = Filter::firstOrCreate([
            'category_id' => $category->id,
            'name' => 'Brand',
            'title' => 'Brand',
        ], [
            'is_active' => true,
            'sort_order' => 1,
        ]);

        // Create some filter options
        FilterOption::firstOrCreate([
            'filter_id' => $filter->id,
            'name' => 'Apple',
            'value' => 'apple',
        ], [
            'sort_order' => 1,
            'is_active' => true,
        ]);

        FilterOption::firstOrCreate([
            'filter_id' => $filter->id,
            'name' => 'Samsung',
            'value' => 'samsung',
        ], [
            'sort_order' => 2,
            'is_active' => true,
        ]);

        FilterOption::firstOrCreate([
            'filter_id' => $filter->id,
            'name' => 'Google',
            'value' => 'google',
        ], [
            'sort_order' => 3,
            'is_active' => false,
        ]);
    }
}