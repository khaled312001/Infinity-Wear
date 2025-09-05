<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomDesignController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/services', [HomeController::class, 'services'])->name('services');

// المنتجات
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// الفئات
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// التصاميم المخصصة (متاحة بدون تسجيل دخول)
Route::get('/custom-designs/create', [CustomDesignController::class, 'create'])->name('custom-designs.create');
Route::post('/custom-designs', [CustomDesignController::class, 'store'])->name('custom-designs.store');

// التصاميم المخصصة (تتطلب تسجيل دخول)
Route::middleware('auth')->group(function () {
    Route::get('/custom-designs', [CustomDesignController::class, 'index'])->name('custom-designs.index');
    Route::get('/custom-designs/{customDesign}', [CustomDesignController::class, 'show'])->name('custom-designs.show');
    Route::get('/custom-designs/{customDesign}/edit', [CustomDesignController::class, 'edit'])->name('custom-designs.edit');
    Route::put('/custom-designs/{customDesign}', [CustomDesignController::class, 'update'])->name('custom-designs.update');
    Route::delete('/custom-designs/{customDesign}', [CustomDesignController::class, 'destroy'])->name('custom-designs.destroy');
});

// المصادقة
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// تسجيل دخول الإدارة
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// لوحة التحكم الإدارية
Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('custom-designs', CustomDesignController::class);
});
