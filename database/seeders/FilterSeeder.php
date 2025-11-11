<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Filter;
use App\Models\FilterOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 获取汽车分类
        $carCategory = Category::where('name', 'Авто')->first();
        
        if ($carCategory) {
            // 为汽车分类创建过滤器
            $filters = [
                [
                    'category_id' => $carCategory->id,
                    'name' => 'price',
                    'title' => 'Цена',
                    'sort_order' => 1,
                    'is_active' => true,
                    'options' => [
                        ['name' => 'До 1000 руб.', 'value' => '0-1000', 'sort_order' => 1],
                        ['name' => '1000 - 3000 руб.', 'value' => '1000-3000', 'sort_order' => 2],
                        ['name' => 'От 3000 руб.', 'value' => '3000+', 'sort_order' => 3],
                    ]
                ],
                [
                    'category_id' => $carCategory->id,
                    'name' => 'type',
                    'title' => 'Тип автомобиля',
                    'sort_order' => 2,
                    'is_active' => true,
                    'options' => [
                        ['name' => 'Лимузин', 'value' => 'limousine', 'sort_order' => 1],
                        ['name' => 'Седан', 'value' => 'sedan', 'sort_order' => 2],
                        ['name' => 'Хэтчбек', 'value' => 'hatchback', 'sort_order' => 3],
                    ]
                ],
                [
                    'category_id' => $carCategory->id,
                    'name' => 'brand',
                    'title' => 'Марка / Бренд',
                    'sort_order' => 3,
                    'is_active' => true,
                    'options' => [
                        ['name' => 'Mercedes', 'value' => 'mercedes', 'sort_order' => 1],
                        ['name' => 'BMW', 'value' => 'bmw', 'sort_order' => 2],
                        ['name' => 'Audi', 'value' => 'audi', 'sort_order' => 3],
                    ]
                ],
                [
                    'category_id' => $carCategory->id,
                    'name' => 'capacity',
                    'title' => 'Вместимость',
                    'sort_order' => 4,
                    'is_active' => true,
                    'options' => [
                        ['name' => 'До 5 человек', 'value' => '1-5', 'sort_order' => 1],
                        ['name' => '5-10 человек', 'value' => '5-10', 'sort_order' => 2],
                        ['name' => 'Более 10 человек', 'value' => '10+', 'sort_order' => 3],
                    ]
                ],
                [
                    'category_id' => $carCategory->id,
                    'name' => 'body_color',
                    'title' => 'Цвет кузова',
                    'sort_order' => 5,
                    'is_active' => true,
                    'options' => [
                        ['name' => 'Черный', 'value' => 'black', 'sort_order' => 1],
                        ['name' => 'Белый', 'value' => 'white', 'sort_order' => 2],
                        ['name' => 'Серебристый', 'value' => 'silver', 'sort_order' => 3],
                    ]
                ],
                [
                    'category_id' => $carCategory->id,
                    'name' => 'interior_color',
                    'title' => 'Цвет салона',
                    'sort_order' => 6,
                    'is_active' => true,
                    'options' => [
                        ['name' => 'Черный', 'value' => 'black', 'sort_order' => 1],
                        ['name' => 'Бежевый', 'value' => 'beige', 'sort_order' => 2],
                        ['name' => 'Коричневый', 'value' => 'brown', 'sort_order' => 3],
                    ]
                ],
            ];

            foreach ($filters as $filterData) {
                $options = $filterData['options'];
                unset($filterData['options']);
                
                // 创建过滤器
                $filter = Filter::create($filterData);
                
                // 创建过滤器选项
                foreach ($options as $optionData) {
                    $optionData['filter_id'] = $filter->id;
                    FilterOption::create($optionData);
                }
            }
        }
    }
}