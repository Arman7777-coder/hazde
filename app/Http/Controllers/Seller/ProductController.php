<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductFilterValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display seller dashboard
     */
    public function dashboard()
    {
        // Fetch the latest user data from the database to ensure we have updated verification status
        $user = Auth::user()->fresh();

        // Get product statistics
        $productsCount = $user->products()->count();
        $approvedProductsCount = $user->products()->where('status', 'approved')->count();
        $pendingProductsCount = $user->products()->where('status', 'pending')->count();
        $rejectedProductsCount = $user->products()->where('status', 'rejected')->count();

        // Calculate percentages
        $approvedProductsPercentage = $productsCount > 0 ? round(($approvedProductsCount / $productsCount) * 100) : 0;
        $pendingProductsPercentage = $productsCount > 0 ? round(($pendingProductsCount / $productsCount) * 100) : 0;

        // Get subscription status
        $subscriptionActive = $user->subscription && $user->subscription->payment_status === 'paid';

        // Get recent products
        $recentProducts = $user->products()->with('category')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('seller.dashboard', compact(
            'productsCount',
            'approvedProductsCount',
            'pendingProductsCount',
            'rejectedProductsCount',
            'approvedProductsPercentage',
            'pendingProductsPercentage',
            'subscriptionActive',
            'recentProducts'
        ));
    }

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
        $categories = Category::where('is_active', true)->with('filters.options')->get();
        
        // Get the maximum images allowed for the user's plan
        $user = Auth::user();
        $maxImages = 1; // Default to 1 image
        
        if ($user->subscription && $user->subscription->plan) {
            $maxImages = $user->subscription->plan->max_images_per_product ?? 1;
        }

        return view('seller.products.create', compact('categories', 'maxImages'));
    }

    /**
     * 保存新产品
     */
    public function store(Request $request)
    {
        // Get the maximum images allowed for the user's plan
        $maxImages = Auth::user()->subscription->plan->max_images_per_product ?? 1;
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'location' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'price_type' => 'required|in:fixed,hourly',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'array|max:' . $maxImages,
            'unavailable_dates' => 'nullable|array',
            'unavailable_dates.*' => 'date_format:Y-m-d',
            'pdf_document' => 'nullable|file|mimes:pdf|max:10240' // 10MB max
        ]);

        // 检查用户是否已达到产品限制
        $userProductsCount = Auth::user()->products()->count();
        $maxProducts = Auth::user()->subscription->plan->max_products;

        if ($maxProducts !== null && $userProductsCount >= $maxProducts) {
            return redirect()->route('seller.products.index')->with('error', 'Вы достигли максимального количества товаров для вашего тарифного плана.');
        }

        // Handle PDF document upload
        $pdfDocumentPath = null;
        if ($request->hasFile('pdf_document') && $this->isUserOnProPlan()) {
            $pdfDocumentPath = $request->file('pdf_document')->store('product_pdfs', 'public');
        }

        // 创建产品
        $product = Product::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'details' => $request->details,
            'location' => $request->location,
            'price' => $request->price,
            'price_type' => $request->price_type,
            'status' => 'pending', // 等待审批
            'is_active' => false,
            'pdf_document_path' => $pdfDocumentPath
        ]);

        // 处理筛选器值
        if ($request->has('filters')) {
            foreach ($request->input('filters') as $filterId => $value) {
                if (!empty($value)) {
                    ProductFilterValue::create([
                        'product_id' => $product->id,
                        'filter_id' => $filterId,
                        'filter_option_id' => is_numeric($value) ? $value : null,
                        'value' => is_numeric($value) ? null : $value
                    ]);
                }
            }
        }

        // 处理上传的图片（如果提供了新图片）
        if ($request->hasFile('images')) {
            $maxImages = Auth::user()->subscription->plan->max_images_per_product ?? 1;
            // Ensure we don't exceed the plan limit
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
        if ($product->status !== 'approved') {
            return redirect()->route('seller.products.index')->with('error', 'Редактирование возможно только для товаров со статусом "Ожидает модерации" или "Отклонен".');
        }

        $categories = Category::where('is_active', true)->with('filters.options')->get();
        
        // Get the maximum images allowed for the user's plan
        $user = Auth::user();
        $maxImages = 1; // Default to 1 image
        
        if ($user->subscription && $user->subscription->plan) {
            $maxImages = $user->subscription->plan->max_images_per_product ?? 1;
        }

        return view('seller.products.edit', compact('product', 'categories', 'maxImages'));
    }

    /**
     * Обновить продукт
     */
    public function update(Request $request, Product $product)
    {
        // 只有 продукт всео может обновить
        if (Auth::user()->id !== $product->user_id) {
            abort(403);
        }

        // Только ожидает модерации или отклоненный продукт можно обновить
//        if ($product->status !== 'pending' && $product->status !== 'rejected') {
//            return redirect()->route('seller.products.index')->with('error', 'Редактирование возможно только для товаров со статусом "Ожидает модерации" или "Отклонен".');
//        }

        // Get the maximum images allowed for the user's plan
        $maxImages = Auth::user()->subscription->plan->max_images_per_product ?? 1;

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'location' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'price_type' => 'required|in:fixed,hourly',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'array|max:' . $maxImages,
            'unavailable_dates' => 'nullable|array',
            'unavailable_dates.*' => 'date_format:Y-m-d',
            'pdf_document' => 'nullable|file|mimes:pdf|max:10240' // 10MB max
        ]);

        // Handle PDF document upload
        $pdfDocumentPath = $product->pdf_document_path; // Keep existing path by default
        if ($request->hasFile('pdf_document') && $this->isUserOnProPlan()) {
            // Delete old PDF if exists
            if ($product->pdf_document_path) {
                \Storage::disk('public')->delete($product->pdf_document_path);
            }
            // Store new PDF
            $pdfDocumentPath = $request->file('pdf_document')->store('product_pdfs', 'public');
        }

        // Обновить продукт
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'details' => $request->details,
            'location' => $request->location,
            'price' => $request->price,
            'price_type' => $request->price_type,
            'status' => 'pending', // 重新 отправить на модерацию
            'pdf_document_path' => $pdfDocumentPath
        ]);

        // Обработать значения фильтров
        // Удалить существующие значения фильтров
        $product->filterValues()->delete();

        // Добавить новые значения фильтров
        if ($request->has('filters')) {
            foreach ($request->input('filters') as $filterId => $value) {
                if (!empty($value)) {
                    ProductFilterValue::create([
                        'product_id' => $product->id,
                        'filter_id' => $filterId,
                        'filter_option_id' => is_numeric($value) ? $value : null,
                        'value' => is_numeric($value) ? null : $value
                    ]);
                }
            }
        }

        // Обработать загруженные изображения (если предоставлены новые изображения)
        if ($request->hasFile('images')) {
            $maxImages = Auth::user()->subscription->plan->max_images_per_product;
            $images = array_slice($request->file('images'), 0, $maxImages);

            // Удалить существующие изображения
            $product->images()->delete();

            // Загрузить новые изображения
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
        
        // Handle unavailable dates
        if ($request->has('unavailable_dates')) {
            // Delete existing unavailable dates
            $product->unavailableDates()->delete();
            
            // Add new unavailable dates
            $unavailableDates = $request->input('unavailable_dates', []);
            if (is_array($unavailableDates)) {
                foreach ($unavailableDates as $date) {
                    $product->unavailableDates()->create([
                        'unavailable_date' => $date
                    ]);
                }
            }
        } else {
            // If no unavailable dates were submitted, delete all existing ones
            $product->unavailableDates()->delete();
        }

        return redirect()->route('seller.products.index')->with('success', 'Товар успешно обновлен и отправлен на повторную модерацию.');
    }

    /**
     * Удалить продукт
     */
    public function destroy(Product $product)
    {
        // Только владелец продукта может удалить его
        if (Auth::user()->id !== $product->user_id) {
            abort(403);
        }

        // Только продукты со статусом "Ожидает модерации" или "Отклонен" могут быть удалены
        if ($product->status !== 'pending' && $product->status !== 'rejected') {
            return redirect()->route('seller.products.index')->with('error', 'Удаление возможно только для товаров со статусом "Ожидает модерации" или "Отклонен".');
        }

        // Удалить изображения продукта
        $product->images()->delete();

        // Удалить значения фильтров продукта
        $product->filterValues()->delete();

        // Удалить продукт
        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Товар успешно удален.');
    }

    // Check if user is on a Pro plan (plan ID 3)
    private function isUserOnProPlan()
    {
        $user = Auth::user();
        
        // Check if user has a subscription and it's paid
        if (!$user->subscription || $user->subscription->payment_status !== 'paid') {
            return false;
        }
        
        // Check if user's plan ID is 3
        $plan = $user->subscription->plan;
        return $plan && $plan->id === 3;
    }
}
