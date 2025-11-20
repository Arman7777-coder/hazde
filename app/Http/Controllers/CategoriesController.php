<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductFilterValue;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display the main categories page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
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

        // 获取已批准的产品
        $approvedProducts = Product::where('status', 'approved')
            ->where('is_active', true)
            ->with('images', 'user')
            ->limit(12)
            ->get();
        
        // Check if products are liked by current user
        $likedProducts = $this->getLikedProducts($approvedProducts);

        return view('client.categories', compact('categories', 'selectedCategory', 'categoryFilters', 'approvedProducts', 'likedProducts'));
    }

    /**
     * 显示特定分类的页面
     */
    public function show($category, Request $request)
    {
        // Fetch active categories from the database
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // 获取选中的分类
        $selectedCategory = Category::findOrFail($category);

        // 获取分类的过滤器
        $categoryFilters = $selectedCategory->filters()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with('options')
            ->get();

        // 获取该分类下已批准的产品
        $approvedProducts = Product::where('category_id', $selectedCategory->id)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->with('images', 'user')
            ->paginate(12);
        
        // Check if products are liked by current user
        $likedProducts = $this->getLikedProducts($approvedProducts);

        return view('client.categories', compact('categories', 'selectedCategory', 'categoryFilters', 'approvedProducts', 'likedProducts'));
    }
    
    /**
     * Check which products are liked by the current user
     */
    private function getLikedProducts($products)
    {
        // Get user IP
        $ipAddress = request()->ip();
        
        // Get product IDs
        $productIds = $products->pluck('id')->toArray();
        
        // Get liked product IDs for this IP
        $likedProductIds = \App\Models\ProductLike::where('ip_address', $ipAddress)
            ->whereIn('product_id', $productIds)
            ->pluck('product_id')
            ->toArray();
            
        return $likedProductIds;
    }

    /**
     * 获取过滤后的产品 (AJAX endpoint)
     */
    public function filterProducts(Request $request, $category)
    {
        // Handle AJAX requests for filtering
        if ($request->wantsJson() || $request->ajax()) {
            $products = $this->getFilteredProducts($request, $category);
            
            // Return JSON response for AJAX requests
            return response()->json([
                'products' => $products->items(),
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ]);
        }
        
        // If not AJAX, redirect back
        return redirect()->back();
    }

    /**
     * 获取过滤后的产品
     */
    private function getFilteredProducts(Request $request, $categoryId = null)
    {
        $query = Product::where('status', 'approved')
            ->where('is_active', true)
            ->with(['images', 'user']);

        // 如果指定了分类，则按分类过滤
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // 搜索功能
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // 位置搜索
        if ($request->has('location') && $request->location) {
            $locationTerm = $request->location;
            $query->where('location', 'like', '%' . $locationTerm . '%');
        }

        // 过滤器选项
        if ($request->has('filters') && is_array($request->filters)) {
            $filterValues = $request->filters;
            
            // 通过产品过滤值关联来过滤产品
            foreach ($filterValues as $filterId => $optionId) {
                if ($optionId) {
                    $query->whereHas('filterValues', function ($q) use ($filterId, $optionId) {
                        $q->where('filter_id', $filterId)
                          ->where('filter_option_id', $optionId);
                    });
                }
            }
        }

        // 返回分页结果
        return $query->paginate(12);
    }
}