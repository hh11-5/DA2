<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Geocoder\Geocoder;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;

// Admin và Employee routes
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');

// Trang chủ
Route::get('/', [IndexController::class, 'index'])->name('index');

// Routes cho authentication (chỉ giữ lại các route cho khách hàng)
Route::group(['prefix' => 'auth'], function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('auth');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// Routes cho admin login (để riêng)
Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.loginForm');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login');

// Routes cho giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
// Thêm route mới
Route::get('/cart/info', [CartController::class, 'getCartInfo'])->name('cart.info');
Route::post('/buy-now/{id}', [CartController::class, 'buyNow'])->name('buy.now');

// Routes cho sản phẩm
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/type/{type}', [ProductController::class, 'getProductsByType'])->name('products.by.type');

// Routes cho thương hiệu
Route::get('/brands/{id}', [BrandController::class, 'getProducts'])->name('brands.products');
Route::get('/brands/page/{id}', [BrandController::class, 'brandPage'])->name('brands.page');

// Routes cho tìm kiếm
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');
Route::post('/filter-products', [SearchController::class, 'filter'])->name('products.filter');
Route::post('/filter-products', [ProductController::class, 'filterProducts'])->name('filter.products');

// Thay thế route profile cũ bằng route mới
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/verify-address', function (Request $request) {
    try {
        if (!$request->has('address')) {
            return response()->json([
                'isValid' => false,
                'error' => 'Thiếu tham số địa chỉ'
            ], 400);
        }

        $response = Http::withHeaders([
            'User-Agent' => 'WatchStore/1.0'
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $request->address . ', Việt Nam', // Thêm "Việt Nam" vào query
            'format' => 'json',
            'addressdetails' => 1,
            'limit' => 1,
            'countrycodes' => 'vn'
        ]);

        if (!$response->successful()) {
            \Log::error('Nominatim API error:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return response()->json([
                'isValid' => false,
                'error' => 'Không thể kết nối đến server kiểm tra địa chỉ'
            ], 500);
        }

        $result = $response->json();

        \Log::info('Nominatim response:', [
            'address' => $request->address,
            'result' => $result
        ]);

        // Kiểm tra kết quả và valid địa chỉ Việt Nam
        if (!empty($result) && isset($result[0])) {
            $address = $result[0];

            // Kiểm tra có phải địa chỉ Việt Nam không
            if (isset($address['address']) &&
                (isset($address['address']['country_code']) && $address['address']['country_code'] === 'vn')) {
                return response()->json([
                    'isValid' => true,
                    'data' => $result,
                    'formatted_address' => $address['display_name']
                ]);
            }
        }

        return response()->json([
            'isValid' => false,
            'error' => 'Không tìm thấy địa chỉ hoặc địa chỉ không thuộc Việt Nam',
            'data' => $result
        ]);

    } catch (\Exception $e) {
        \Log::error('Verify address error:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json([
            'isValid' => false,
            'error' => 'Lỗi hệ thống: ' . $e->getMessage(),
            'details' => $e->getMessage()
        ], 500);
    }
})->name('verify.address');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

// Routes cho đơn hàng
Route::middleware(['auth'])->group(function () {
    Route::get('/history', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Employee routes
    Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])
        ->name('employee.dashboard');
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Product management
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');

    // Staff management
    Route::get('/staff', [AdminController::class, 'staff'])->name('admin.staff');
    Route::get('/staff/create', [AdminController::class, 'createStaff'])->name('admin.staff.create');
    Route::post('/staff', [AdminController::class, 'storeStaff'])->name('admin.staff.store');
    Route::put('/staff/{id}/toggle-status', [AdminController::class, 'toggleStaffStatus'])->name('admin.staff.toggle-status');
    Route::delete('/staff/{id}', [AdminController::class, 'deleteStaff'])->name('admin.staff.delete');
});

// Employee routes
Route::prefix('employee')->group(function () {
    Route::get('/orders', [EmployeeController::class, 'orders'])->name('employee.orders');
    Route::get('/orders/{iddhang}', [EmployeeController::class, 'showOrder'])->name('employee.orders.show');
    Route::put('/orders/{iddhang}/status', [EmployeeController::class, 'updateOrderStatus'])->name('employee.orders.update-status');
});

Route::middleware(['auth', 'employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/orders/{iddhang}', [EmployeeController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{iddhang}/status', [EmployeeController::class, 'updateOrderStatus'])->name('orders.update-status');
});

Route::prefix('employee')->name('employee.')->group(function () {
    Route::get('/orders', [EmployeeController::class, 'orders'])->name('orders');
    Route::get('/orders/{iddhang}', [EmployeeController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{iddhang}/status', [EmployeeController::class, 'updateOrderStatus'])->name('orders.update-status');
});

