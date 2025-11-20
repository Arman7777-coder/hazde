<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\FilterOptionController;
use App\Http\Controllers\Admin\LoginInfo\LoginInfoController;
use App\Http\Controllers\Admin\Permissions\RolesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\Users\ProfileController;
use App\Http\Controllers\Admin\Users\UsersController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
Route::resource('users', UsersController::class);
Route::resource('roles', RolesController::class);
Route::resource('profile', ProfileController::class)->only(['index', 'update']);
Route::get('user/{type}', [UsersController::class, 'filterByType']);
Route::get('login-info', [LoginInfoController::class, 'index'])->name('login_info');
Route::post('login-info', [LoginInfoController::class, 'getLoginInfo'])->name('login_info.paginate');
Route::post('users/getRolePermissions/{roleId}', [UsersController::class, 'getRolePermissions']);

// Categories and filters
Route::resource('categories', CategoryController::class)->names([
    'index' => 'admin.categories.index',
    'create' => 'admin.categories.create',
    'store' => 'admin.categories.store',
    'show' => 'admin.categories.show',
    'edit' => 'admin.categories.edit',
    'update' => 'admin.categories.update',
    'destroy' => 'admin.categories.destroy',
]);
Route::resource('categories.filters', FilterController::class)->names([
    'index' => 'admin.categories.filters.index',
    'create' => 'admin.categories.filters.create',
    'store' => 'admin.categories.filters.store',
    'show' => 'admin.categories.filters.show',
    'edit' => 'admin.categories.filters.edit',
    'update' => 'admin.categories.filters.update',
    'destroy' => 'admin.categories.filters.destroy',
]);
Route::resource('categories.filters.options', FilterOptionController::class)->names([
    'index' => 'admin.categories.filters.options.index',
    'create' => 'admin.categories.filters.options.create',
    'store' => 'admin.categories.filters.options.store',
    'show' => 'admin.categories.filters.options.show',
    'edit' => 'admin.categories.filters.options.edit',
    'update' => 'admin.categories.filters.options.update',
    'destroy' => 'admin.categories.filters.options.destroy',
]);

// Products
Route::get('products/pending', [ProductController::class, 'index'])->name('admin.products.pending');
Route::get('products/approved', [ProductController::class, 'approved'])->name('admin.products.approved');
Route::get('products/rejected', [ProductController::class, 'rejected'])->name('admin.products.rejected');
Route::resource('products', ProductController::class)->only(['index', 'show'])->names([
    'index' => 'admin.products.index',
    'show' => 'admin.products.show',
]);
Route::post('products/{product}/approve', [ProductController::class, 'approve'])->name('admin.products.approve');
Route::post('products/{product}/reject', [ProductController::class, 'reject'])->name('admin.products.reject');