<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\Seller\RegisterController as SellerRegisterController;
use App\Http\Controllers\Seller\PaymentController as SellerPaymentController;
use App\Http\Controllers\Seller\TestEmailController as SellerTestEmailController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\FilterOptionController;
use App\Http\Controllers\Client\ProductLikeController;
use App\Http\Controllers\ClientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Remove duplicate route definition
Route::get('/', [ClientController::class, 'index'])->name('client.home');

// Test route to check if routing is working
Route::get('/test', function () {
    return 'Test route is working!';
})->name('test');

Route::get('categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('categories/{category}', [CategoriesController::class, 'show'])->name('categories.show');
Route::post('categories/{category}/filter', [CategoriesController::class, 'filterProducts'])->name('categories.filter');

// Product like routes (place before product show route to avoid conflicts)
Route::post('/products/{productId}/like', [ProductLikeController::class, 'toggleLike'])->name('client.products.like');
Route::get('/liked-products', [ProductLikeController::class, 'likedProducts'])->name('client.products.liked');

// Add route for product details
Route::get('products/{product}', [ProductController::class, 'show'])->name('client.products.show');

// Route to get unavailable dates for a product
Route::get('products/{product}/unavailable-dates', function (\App\Models\Product $product) {
    $unavailableDates = $product->unavailableDates()
        ->pluck('unavailable_date')
        ->map(function ($date) {
            return $date->format('Y-m-d');
        })
        ->toArray();

    return response()->json($unavailableDates);
})->name('client.products.unavailable-dates');

// Contact form route
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/become-seller', [SellerController::class, 'index'])->name('seller.index');

// Seller routes
Route::prefix('seller')->group(function () {
    Route::get('/', [SellerRegisterController::class, 'showRegistrationForm'])->name('seller.index');
    Route::post('/register', [SellerRegisterController::class, 'register'])->name('seller.register');

    // New route for the plans page
    Route::get('/plans', [SellerRegisterController::class, 'showPlansPage'])->name('seller.plans');

    // Payment routes
    Route::prefix('payment')->group(function () {
        // Adding GET route for direct access to the payment page
        Route::get('/pay', [SellerPaymentController::class, 'showPaymentPage'])->name('seller.payment.show');
        Route::post('/pay', [SellerPaymentController::class, 'pay'])->name('seller.payment.pay');
        Route::get('/return', [SellerPaymentController::class, 'return'])->name('seller.payment.return');
        Route::post('/webhook', [SellerPaymentController::class, 'webhook'])->name('seller.payment.webhook')
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
        
        // Test email route (only in local environment)
        if (app()->environment('local')) {
            Route::get('/test-email', [SellerTestEmailController::class, 'sendTestEmail'])->name('seller.payment.test-email');
        }
    });

    // Seller routes
    Route::middleware(['auth', 'role:seller'])->group(function () {
        // Seller dashboard
        Route::get('/', [SellerProductController::class, 'dashboard'])->name('seller.dashboard');

        // Plan routes
//        Route::get('/plans', [SellerPlanController::class, 'index'])->name('seller.plans.index');
//        Route::get('/plans/select', [SellerPlanController::class, 'selectPlan'])->name('seller.plans.select');

        // Product routes (requires valid subscription)
        Route::middleware(['seller.subscription'])->group(function () {
            Route::resource('/products', SellerProductController::class)->names([
                'index' => 'seller.products.index',
                'create' => 'seller.products.create',
                'store' => 'seller.products.store',
                'show' => 'seller.products.show',
                'edit' => 'seller.products.edit',
                'update' => 'seller.products.update',
                'destroy' => 'seller.products.destroy',
            ]);
            
            // Product unavailable dates routes
            Route::post('/products/{product}/unavailable-dates', [ProductUnavailableDateController::class, 'store'])->name('seller.products.unavailable-dates.store');
            Route::get('/products/{product}/unavailable-dates', [ProductUnavailableDateController::class, 'show'])->name('seller.products.unavailable-dates.show');
        });

        Route::get('/debug-subscription', function () {
            return view('debug.subscription');
        })->name('debug.subscription');
    });
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin dashboard
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Contact requests management
    Route::get('/contact-requests', [ContactController::class, 'index'])->name('contact-requests.index');
    Route::get('/contact-requests/{contactRequest}', [ContactController::class, 'show'])->name('contact-requests.show');
    Route::post('/contact-requests/{contactRequest}/reply', [ContactController::class, 'reply'])->name('contact-requests.reply');

    // Category management routes
    Route::resource('categories', CategoryController::class);

    // Category filter management routes
    Route::prefix('categories/{category}')->group(function () {
        Route::resource('filters', FilterController::class)->except(['show'])->names([
            'index' => 'categories.filters.index',
            'create' => 'categories.filters.create',
            'store' => 'categories.filters.store',
            'edit' => 'categories.filters.edit',
            'update' => 'categories.filters.update',
            'destroy' => 'categories.filters.destroy',
        ]);

        // Filter option management routes
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

    // Product management routes
    // These routes have been moved to routes/admin.php to avoid naming conflicts

});

Auth::routes();
