<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;


Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
Route::post('logout', [LoginController::class ,'logout'])->name('user.logout');
