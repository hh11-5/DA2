<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;

// Trang chủ
Route::get('/', function () {
    return view('index');
})->name('index');

// Routes cho authentication
Route::group(['prefix' => 'auth'], function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('auth');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// Routes cho giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// ...existing code...

// Routes cần đăng nhập
Route::middleware(['auth'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    // Thêm các routes khác cần bảo vệ ở đây
});
