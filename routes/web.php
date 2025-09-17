<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
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

// المنتجات - تم إزالتها

// الفئات - تم حذفها

// التقييمات - تم نقلها إلى مجموعة admin

// معرض الأعمال
use App\Http\Controllers\PortfolioController;
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{portfolioItem}', [PortfolioController::class, 'show'])->name('portfolio.show');
Route::post('/portfolio/filter', [PortfolioController::class, 'filterByCategory'])->name('portfolio.filter');

// التقييمات والشهادات
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

// التصاميم المخصصة (متاحة بدون تسجيل دخول) - تم إزالتها


// المصادقة
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// لوحات التحكم للعملاء
Route::middleware(['auth', 'user.type:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [App\Http\Controllers\CustomerController::class, 'orders'])->name('orders');
    Route::get('/designs', [App\Http\Controllers\CustomerController::class, 'designs'])->name('designs');
    Route::get('/profile', [App\Http\Controllers\CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\CustomerController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [App\Http\Controllers\CustomerController::class, 'settings'])->name('settings');
    Route::put('/settings/notifications', [App\Http\Controllers\CustomerController::class, 'updateNotifications'])->name('settings.notifications');
    Route::put('/settings/privacy', [App\Http\Controllers\CustomerController::class, 'updatePrivacy'])->name('settings.privacy');
    Route::put('/password', [App\Http\Controllers\CustomerController::class, 'updatePassword'])->name('password.update');
    Route::delete('/account', [App\Http\Controllers\CustomerController::class, 'deleteAccount'])->name('account.delete');
});

// المستوردين
use App\Http\Controllers\ImporterController;
Route::get('/importers/register', [ImporterController::class, 'showImporterForm'])->name('importers.form');
Route::post('/importers/register', [ImporterController::class, 'submitImporterForm'])->name('importers.submit');

// لوحة تحكم المستوردين
Route::middleware(['auth', 'user.type:importer'])->prefix('importers')->name('importers.')->group(function () {
    Route::get('/dashboard', [ImporterController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [ImporterController::class, 'orders'])->name('orders');
    Route::get('/profile', [ImporterController::class, 'profile'])->name('profile');
    Route::put('/profile', [ImporterController::class, 'updateProfile'])->name('profile.update');
});

// تسجيل دخول الإدارة
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// لوحة التحكم الإدارية
Route::prefix('admin')->middleware(['auth:admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('orders', OrderController::class);
    
    // إدارة المحتوى
    Route::resource('hero-slider', App\Http\Controllers\Admin\HeroSliderController::class);
    Route::post('hero-slider/update-order', [App\Http\Controllers\Admin\HeroSliderController::class, 'updateOrder'])->name('hero-slider.update-order');
    Route::patch('hero-slider/{heroSlider}/toggle-active', [App\Http\Controllers\Admin\HeroSliderController::class, 'toggleActive'])->name('hero-slider.toggle-active');
    
    Route::resource('home-sections', App\Http\Controllers\Admin\HomeSectionController::class);
    Route::post('home-sections/update-order', [App\Http\Controllers\Admin\HomeSectionController::class, 'updateOrder'])->name('home-sections.update-order');
    Route::patch('home-sections/{homeSection}/toggle-active', [App\Http\Controllers\Admin\HomeSectionController::class, 'toggleActive'])->name('home-sections.toggle-active');
    
    Route::resource('home-sections.section-contents', App\Http\Controllers\Admin\SectionContentController::class)->shallow();
    Route::post('home-sections/{homeSection}/section-contents/update-order', [App\Http\Controllers\Admin\SectionContentController::class, 'updateOrder'])->name('section-contents.update-order');
    Route::patch('section-contents/{sectionContent}/toggle-active', [App\Http\Controllers\Admin\SectionContentController::class, 'toggleActive'])->name('section-contents.toggle-active');
    
    // إدارة المشرفين
    Route::get('/admins', [AdminController::class, 'admins'])->name('admins.index');
    Route::get('/admins/create', [AdminController::class, 'createAdmin'])->name('admins.create');
    Route::post('/admins', [AdminController::class, 'storeAdmin'])->name('admins.store');
    Route::get('/admins/{admin}/edit', [AdminController::class, 'editAdmin'])->name('admins.edit');
    Route::put('/admins/{admin}', [AdminController::class, 'updateAdmin'])->name('admins.update');
    Route::delete('/admins/{admin}', [AdminController::class, 'destroyAdmin'])->name('admins.destroy');
    
    // المستوردين
    Route::get('/importers', [AdminController::class, 'importersIndex'])->name('importers.index');
    Route::get('/importers/create', [AdminController::class, 'importersCreate'])->name('importers.create');
    Route::post('/importers', [AdminController::class, 'importersStore'])->name('importers.store');
    Route::get('/importers/{id}', [AdminController::class, 'importersShow'])->name('importers.show');
    Route::get('/importers/{id}/edit', [AdminController::class, 'importersEdit'])->name('importers.edit');
    Route::put('/importers/{id}', [AdminController::class, 'importersUpdate'])->name('importers.update');
    Route::delete('/importers/{id}', [AdminController::class, 'importersDestroy'])->name('importers.destroy');
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
    
    // إدارة ملاحظات العملاء
    Route::resource('customer-notes', App\Http\Controllers\Admin\CustomerNotesController::class);
    Route::post('customer-notes/{customerNote}/archive', [App\Http\Controllers\Admin\CustomerNotesController::class, 'archive'])->name('customer-notes.archive');
    Route::post('customer-notes/{customerNote}/restore', [App\Http\Controllers\Admin\CustomerNotesController::class, 'restore'])->name('customer-notes.restore');
    Route::get('customers/{customer}/notes', [App\Http\Controllers\Admin\CustomerNotesController::class, 'customerNotes'])->name('customers.notes');
    Route::get('api/customers/{customer}/notes', [App\Http\Controllers\Admin\CustomerNotesController::class, 'getCustomerNotes'])->name('api.customers.notes');
    
    // إدارة الواتساب
    Route::prefix('whatsapp')->name('whatsapp.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\WhatsAppController::class, 'index'])->name('index');
        Route::get('/test', function() { return view('admin.whatsapp.test'); })->name('test');
        Route::get('/conversation/{phoneNumber}', [App\Http\Controllers\Admin\WhatsAppController::class, 'conversation'])->name('conversation');
        Route::post('/send', [App\Http\Controllers\Admin\WhatsAppController::class, 'sendMessage'])->name('send');
        Route::post('/test', [App\Http\Controllers\Admin\WhatsAppController::class, 'testMessage'])->name('test.send');
        Route::get('/test-connection', [App\Http\Controllers\Admin\WhatsAppController::class, 'testConnection'])->name('test.connection');
        Route::post('/receive', [App\Http\Controllers\Admin\WhatsAppController::class, 'receiveMessage'])->name('receive');
        Route::post('/messages/{message}/archive', [App\Http\Controllers\Admin\WhatsAppController::class, 'archiveMessage'])->name('messages.archive');
        Route::delete('/messages/{message}', [App\Http\Controllers\Admin\WhatsAppController::class, 'deleteMessage'])->name('messages.delete');
        Route::get('/stats', [App\Http\Controllers\Admin\WhatsAppController::class, 'getConversationStats'])->name('stats');
    });
    
    // إدارة المستخدمين
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    
    // فريق التسويق
    Route::get('/marketing', [AdminController::class, 'marketingTeam'])->name('marketing.index');
    Route::get('/marketing/create', [AdminController::class, 'createMarketingMember'])->name('marketing.create');
    Route::post('/marketing', [AdminController::class, 'storeMarketingMember'])->name('marketing.store');
    Route::get('/marketing/{id}', [AdminController::class, 'showMarketingMember'])->name('marketing.show');
    Route::get('/marketing/{id}/edit', [AdminController::class, 'editMarketingMember'])->name('marketing.edit');
    Route::put('/marketing/{id}', [AdminController::class, 'updateMarketingMember'])->name('marketing.update');
    Route::delete('/marketing/{id}', [AdminController::class, 'destroyMarketingMember'])->name('marketing.destroy');
    Route::post('/marketing/{id}/assign-task', [AdminController::class, 'assignTaskToMarketing'])->name('marketing.assign-task');
    Route::put('/marketing/{id}/disable', [AdminController::class, 'disableMarketingMember'])->name('marketing.disable');
    
    // فريق المبيعات
    Route::get('/sales', [AdminController::class, 'salesTeam'])->name('sales.index');
    Route::get('/sales/{id}', [AdminController::class, 'showSalesMember'])->name('sales.show');
    Route::post('/sales/{id}/assign-task', [AdminController::class, 'assignTaskToSales'])->name('sales.assign-task');
    Route::put('/sales/{id}/target', [AdminController::class, 'updateSalesTarget'])->name('sales.update-target');
    Route::put('/sales/{id}/disable', [AdminController::class, 'disableSalesMember'])->name('sales.disable');
    
    // إدارة المهام
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [App\Http\Controllers\TaskController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\TaskController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\TaskController::class, 'store'])->name('store');
        Route::get('/{task}', [App\Http\Controllers\TaskController::class, 'show'])->name('show');
        Route::get('/{task}/edit', [App\Http\Controllers\TaskController::class, 'edit'])->name('edit');
        Route::put('/{task}', [App\Http\Controllers\TaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('destroy');
        Route::put('/{task}/status', [App\Http\Controllers\TaskController::class, 'updateStatus'])->name('update-status');
        
        // مسارات Kanban الجديدة
        Route::post('/{task}/position', [App\Http\Controllers\TaskController::class, 'updatePosition'])->name('update-position');
        Route::post('/{task}/comment', [App\Http\Controllers\TaskController::class, 'addComment'])->name('add-comment');
        Route::post('/{task}/checklist', [App\Http\Controllers\TaskController::class, 'addChecklistItem'])->name('add-checklist');
        Route::put('/{task}/checklist', [App\Http\Controllers\TaskController::class, 'updateChecklistItem'])->name('update-checklist');
        Route::post('/{task}/time-log', [App\Http\Controllers\TaskController::class, 'addTimeLog'])->name('add-time-log');
        
        // مسارات اللوحات
        Route::post('/board', [App\Http\Controllers\TaskController::class, 'createBoard'])->name('create-board');
    });
    
    // معرض الأعمال
    Route::get('/portfolio', [AdminController::class, 'portfolio'])->name('portfolio.index');
    Route::get('/portfolio/create', [AdminController::class, 'createPortfolioItem'])->name('portfolio.create');
    Route::post('/portfolio', [AdminController::class, 'storePortfolioItem'])->name('portfolio.store');
    Route::get('/portfolio/{id}/edit', [AdminController::class, 'editPortfolioItem'])->name('portfolio.edit');
    Route::put('/portfolio/{id}', [AdminController::class, 'updatePortfolioItem'])->name('portfolio.update');
    Route::delete('/portfolio/{id}', [AdminController::class, 'destroyPortfolioItem'])->name('portfolio.destroy');
    
    // الشهادات والتقييمات
    Route::get('/testimonials', [AdminController::class, 'testimonials'])->name('testimonials.index');
    Route::get('/testimonials/create', [AdminController::class, 'createTestimonial'])->name('testimonials.create');
    Route::post('/testimonials', [AdminController::class, 'storeTestimonial'])->name('testimonials.store');
    Route::get('/testimonials/{id}/edit', [AdminController::class, 'editTestimonial'])->name('testimonials.edit');
    Route::put('/testimonials/{id}', [AdminController::class, 'updateTestimonial'])->name('testimonials.update');
    Route::delete('/testimonials/{id}', [AdminController::class, 'destroyTestimonial'])->name('testimonials.destroy');
    
    // التقارير
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    
    // إدارة خطط الشركة
    Route::resource('company-plans', App\Http\Controllers\Admin\CompanyPlanController::class);
    Route::put('/company-plans/{companyPlan}/status', [App\Http\Controllers\Admin\CompanyPlanController::class, 'updateStatus'])->name('company-plans.update-status');
    
    // إدارة الصلاحيات
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('index');
        Route::put('/', [App\Http\Controllers\Admin\PermissionController::class, 'update'])->name('update');
        Route::post('/reset', [App\Http\Controllers\Admin\PermissionController::class, 'reset'])->name('reset');
    });
    
    // الإعدادات
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});
