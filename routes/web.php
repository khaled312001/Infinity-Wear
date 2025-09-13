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
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ContentController;

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

// التقييمات
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
Route::get('/testimonials/create', [TestimonialController::class, 'create'])->name('testimonials.create');
Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

// معرض الأعمال
use App\Http\Controllers\PortfolioController;
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{portfolioItem}', [PortfolioController::class, 'show'])->name('portfolio.show');
Route::post('/portfolio/filter', [PortfolioController::class, 'filterByCategory'])->name('portfolio.filter');

// التصاميم المخصصة (متاحة بدون تسجيل دخول)
Route::get('/custom-designs/create', [CustomDesignController::class, 'create'])->name('custom-designs.create');
Route::get('/custom-designs/enhanced-create', [CustomDesignController::class, 'enhancedCreate'])->name('custom-designs.enhanced-create');
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

// المستوردين
use App\Http\Controllers\ImporterController;
Route::get('/importers/register', [ImporterController::class, 'showImporterForm'])->name('importers.form');
Route::post('/importers/register', [ImporterController::class, 'submitImporterForm'])->name('importers.submit');
Route::get('/importers/dashboard', [ImporterController::class, 'dashboard'])->name('importers.dashboard')->middleware('auth');

// تسجيل دخول الإدارة
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// لوحة التحكم الإدارية
Route::prefix('admin')->middleware(['auth:admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('custom-designs', CustomDesignController::class);
    
    // المستوردين
    Route::get('/importers', [AdminController::class, 'importersIndex'])->name('importers.index');
    Route::get('/importers/{id}', [AdminController::class, 'importersShow'])->name('importers.show');
    Route::put('/importers/{id}/status', [AdminController::class, 'importersUpdateStatus'])->name('importers.updateStatus');
    Route::put('/orders/{id}/status', [AdminController::class, 'ordersUpdateStatus'])->name('orders.updateStatus');
    
    // النظام المالي
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/', [FinanceController::class, 'dashboard'])->name('dashboard');
        Route::get('/transactions', [FinanceController::class, 'transactions'])->name('transactions');
        Route::get('/transactions/create', [FinanceController::class, 'create'])->name('create');
        Route::post('/transactions', [FinanceController::class, 'store'])->name('store');
        Route::get('/transactions/{transaction}', [FinanceController::class, 'show'])->name('show');
        Route::get('/transactions/{transaction}/edit', [FinanceController::class, 'edit'])->name('edit');
        Route::put('/transactions/{transaction}', [FinanceController::class, 'update'])->name('update');
        Route::delete('/transactions/{transaction}', [FinanceController::class, 'destroy'])->name('destroy');
        Route::get('/reports', [FinanceController::class, 'reports'])->name('reports');
        Route::get('/export', [FinanceController::class, 'export'])->name('export');
        Route::get('/quick-stats', [FinanceController::class, 'quickStats'])->name('quick-stats');
    });
    
    // إدارة المحتوى والـ SEO
    Route::prefix('content')->name('content.')->group(function () {
        Route::get('/', [ContentController::class, 'index'])->name('index');
        Route::get('/seo', [ContentController::class, 'seo'])->name('seo');
        Route::post('/seo', [ContentController::class, 'updateSeo'])->name('seo.update');
        Route::get('/pages', [ContentController::class, 'pages'])->name('pages');
        Route::post('/pages', [ContentController::class, 'updatePages'])->name('pages.update');
        Route::post('/clear-cache', [ContentController::class, 'clearCache'])->name('clear-cache');
        Route::post('/generate-sitemap', [ContentController::class, 'generateSitemap'])->name('generate-sitemap');
    });
});
