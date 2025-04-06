<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;


Route::get('/', function () {
    return view('index');
});

Route::get('/cart', function () {
    return view('cart.index'); // Giao diện giỏ hàng
});

// Route::get('/contact', function () {
//     return view('contact'); // Giao diện liên hệ
// });

Route::get('/login', function () {
    return view('welcome'); // Giao diện đăng nhập
});
// Route::get('/dangky', function () {
//     return view('dangky');
// });

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
