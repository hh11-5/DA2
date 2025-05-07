<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SearchController;

// Trang chủ
Route::get('/', [IndexController::class, 'index'])->name('index');

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

// Routes cho sản phẩm
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Routes cho thương hiệu
Route::get('/brands/{id}', [BrandController::class, 'show'])->name('brands.show');
Route::get('/brands/page/{id}', [BrandController::class, 'brandPage'])->name('brands.page');

// Routes cho tìm kiếm
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');
Route::post('/filter-products', [SearchController::class, 'filter'])->name('products.filter');
