<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display the main categories page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch active categories from the database
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // 获取选中的分类（示例中默认为第一个分类）
        $selectedCategory = $categories->first();

        // 获取分类的过滤器
        $categoryFilters = [];
        if ($selectedCategory) {
            $categoryFilters = $selectedCategory->filters()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->with('options')
                ->get();
        }

        return view('client.categories', compact('categories', 'selectedCategory', 'categoryFilters'));
    }

    /**
     * 显示特定分类的页面
     */
    public function show($id)
    {
        // Fetch active categories from the database
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // 获取选中的分类
        $selectedCategory = Category::findOrFail($id);

        // 获取分类的过滤器
        $categoryFilters = $selectedCategory->filters()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with('options')
            ->get();

        return view('client.categories', compact('categories', 'selectedCategory', 'categoryFilters'));
    }
}