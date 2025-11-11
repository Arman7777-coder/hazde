<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * 显示卖家的产品列表
     */
    public function index()
    {
        $products = Auth::user()->products()->with('category')->paginate(10);
        return view('seller.products.index', compact('products'));
    }

    /**
     * 显示创建产品表单
     */
    public function create()
    {
        // 检查用户是否有有效的订阅
        $subscription = Auth::user()->subscription;
        if (!$subscription || $subscription->payment_status !== 'paid') {
            return redirect()->route('seller.plans.select')->with('error', 'Пожалуйста, выберите тарифный план и оплатите его перед добавлением товаров.');
        }

        // 检查用户是否已达到产品限制
        $userProductsCount = Auth::user()->products()->count();
        $maxProducts = $subscription->plan->max_products;
        
        if ($maxProducts !== null && $userProductsCount >= $maxProducts) {
            return redirect()->route('seller.products.index')->with('error', 'Вы достигли максимального количества товаров для вашего тарифного плана.');
        }

        $categories = Category::where('is_active', true)->get();
        $maxImages = $subscription->plan->max_images_per_product;
        return view('seller.products.create', compact('categories', 'maxImages'));
    }

    /**
     * 存储新产品
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'price_type' => 'required|in:fixed,hourly',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'array|max:5' // 最多5张图片
        ]);

        // 检查用户是否有有效的订阅
        $subscription = Auth::user()->subscription;
        if (!$subscription || $subscription->payment_status !== 'paid') {
            return redirect()->route('seller.plans.select')->with('error', 'Пожалуйста, выберите тарифный план и оплатите его перед добавлением товаров.');
        }

        // 检查用户是否已达到产品限制
        $userProductsCount = Auth::user()->products()->count();
        $maxProducts = $subscription->plan->max_products;
        
        if ($maxProducts !== null && $userProductsCount >= $maxProducts) {
            return redirect()->route('seller.products.index')->with('error', 'Вы достигли максимального количества товаров для вашего тарифного плана.');
        }

        // 创建产品
        $product = Product::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'details' => $request->details,
            'price' => $request->price,
            'price_type' => $request->price_type,
            'status' => 'pending', // 等待审批
            'is_active' => false
        ]);

        // 处理上传的图片
        if ($request->hasFile('images')) {
            $maxImages = $subscription->plan->max_images_per_product;
            $images = array_slice($request->file('images'), 0, $maxImages);
            
            foreach ($images as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index
                ]);
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Товар успешно создан и отправлен на модерацию.');
    }

    /**
     * 显示产品详情
     */
    public function show(Product $product)
    {
        // 只有产品所有者或管理员可以查看
        if (Auth::user()->id !== $product->user_id && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        return view('seller.products.show', compact('product'));
    }

    /**
     * 显示编辑产品表单
     */
    public function edit(Product $product)
    {
        // 只有产品所有者可以编辑
        if (Auth::user()->id !== $product->user_id) {
            abort(403);
        }

        // 只有等待审批的产品可以编辑
        if ($product->status !== 'pending' && $product->status !== 'rejected') {
            return redirect()->route('seller.products.index')->with('error', 'Редактирование возможно только для товаров со статусом "Ожидает модерации" или "Отклонен".');
        }

        $categories = Category::where('is_active', true)->get();
        $subscription = Auth::user()->subscription;
        $maxImages = $subscription ? $subscription->plan->max_images_per_product : 1;
        
        return view('seller.products.edit', compact('product', 'categories', 'maxImages'));
    }

    /**
     * 更新产品
     */
    public function update(Request $request, Product $product)
    {
        // 只有产品所有者可以更新
        if (Auth::user()->id !== $product->user_id) {
            abort(403);
        }

        // 只有等待审批或被拒绝的产品可以更新
        if ($product->status !== 'pending' && $product->status !== 'rejected') {
            return redirect()->route('seller.products.index')->with('error', 'Редактирование возможно только для товаров со статусом "Ожидает модерации" или "Отклонен".');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'price_type' => 'required|in:fixed,hourly',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'array|max:5'
        ]);

        // 更新产品
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'details' => $request->details,
            'price' => $request->price,
            'price_type' => $request->price_type,
            'status' => 'pending' // 重新提交审批
        ]);

        // 处理上传的图片（如果提供了新图片）
        if ($request->hasFile('images')) {
            $subscription = Auth::user()->subscription;
            $maxImages = $subscription ? $subscription->plan->max_images_per_product : 1;
            $images = array_slice($request->file('images'), 0, $maxImages);
            
            // 删除现有图片
            $product->images()->delete();
            
            // 上传新图片
            foreach ($images as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index
                ]);
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Товар успешно обновлен и отправлен на повторную модерацию.');
    }

    /**
     * 删除产品
     */
    public function destroy(Product $product)
    {
        // 只有产品所有者可以删除
        if (Auth::user()->id !== $product->user_id) {
            abort(403);
        }

        // 只有待审批或被拒绝的产品可以删除
        if ($product->status !== 'pending' && $product->status !== 'rejected') {
            return redirect()->route('seller.products.index')->with('error', 'Удаление возможно только для товаров со статусом "Ожидает модерации" или "Отклонен".');
        }

        // 删除产品图片
        $product->images()->delete();
        
        // 删除产品
        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Товар успешно удален.');
    }
}