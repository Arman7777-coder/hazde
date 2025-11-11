<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\FilterOptionController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SellerController;
//use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\SellerPlanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ClientController::class, 'index'])->name('client.home');

Route::get('categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('categories/{id}', [CategoriesController::class, 'show'])->name('categories.show');

Route::get('seller', [SellerController::class, 'index'])->name('seller.index');

Route::get('auth/{provider}', [SocialLoginController::class, 'redirectToProvider'])->name('social.login');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback']);

// Payment routes
Route::post('/payment/pay', [PaymentController::class, 'pay'])->name('payment.pay');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

// 卖家路由
Route::middleware(['auth', 'role:seller'])->group(function () {
    // 套餐计划路由
    Route::get('/seller/plans', [SellerPlanController::class, 'index'])->name('seller.plans.index');
    Route::get('/seller/plans/select', [SellerPlanController::class, 'selectPlan'])->name('seller.plans.select');

    // 产品路由
    Route::resource('/seller/products', SellerProductController::class)->names([
        'index' => 'seller.products.index',
        'create' => 'seller.products.create',
        'store' => 'seller.products.store',
        'show' => 'seller.products.show',
        'edit' => 'seller.products.edit',
        'update' => 'seller.products.update',
        'destroy' => 'seller.products.destroy',
    ]);
});

// 管理员路由
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // 管理员仪表板
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // 分类管理路由
    Route::resource('categories', CategoryController::class);
    
    // 分类过滤器管理路由
    Route::prefix('categories/{category}')->group(function () {
        Route::resource('filters', FilterController::class)->except(['show'])->names([
            'index' => 'categories.filters.index',
            'create' => 'categories.filters.create',
            'store' => 'categories.filters.store',
            'edit' => 'categories.filters.edit',
            'update' => 'categories.filters.update',
            'destroy' => 'categories.filters.destroy',
        ]);
        
        // 过滤器选项管理路由
        Route::prefix('filters/{filter}')->group(function () {
            Route::resource('options', FilterOptionController::class)->except(['show'])->names([
                'index' => 'categories.filters.options.index',
                'create' => 'categories.filters.options.create',
                'store' => 'categories.filters.options.store',
                'edit' => 'categories.filters.options.edit',
                'update' => 'categories.filters.options.update',
                'destroy' => 'categories.filters.options.destroy',
            ]);
        });
    });

    // 产品管理路由
    Route::get('/products/pending', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/approved', [AdminProductController::class, 'approved'])->name('products.approved');
    Route::get('/products/rejected', [AdminProductController::class, 'rejected'])->name('products.rejected');
    Route::get('/products/{product}', [AdminProductController::class, 'show'])->name('products.show');
    Route::post('/products/{product}/approve', [AdminProductController::class, 'approve'])->name('products.approve');
    Route::post('/products/{product}/reject', [AdminProductController::class, 'reject'])->name('products.reject');
});

Auth::routes();