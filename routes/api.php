<?php

use App\Http\Controllers\Seller\SellerPlanController as ApiSellerPlanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 卖家套餐API路由
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/plans/{id}', [ApiSellerPlanController::class, 'show'])->name('api.plans.show');
});