<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\FaviconController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MailTestController;
use Illuminate\Support\Facades\Log;

// Health check routes
Route::get('/health', [HealthController::class, 'index']);
Route::get('/health/database', [HealthController::class, 'database']);

// Email testing routes
Route::get('/email-test', function () {
    return view('email-test');
})->name('email-test.page');

Route::prefix('email-test')->name('email-test.')->group(function () {
    Route::get('/test', [App\Http\Controllers\EmailTestController::class, 'testEmail'])->name('test');
    Route::get('/status', [App\Http\Controllers\EmailTestController::class, 'getEmailStatus'])->name('status');
    Route::post('/send-notification', [App\Http\Controllers\EmailTestController::class, 'sendTestNotification'])->name('send-notification');
    Route::post('/send-alert', [App\Http\Controllers\EmailTestController::class, 'sendSystemAlert'])->name('send-alert');
    Route::post('/test-contact-form', [App\Http\Controllers\EmailTestController::class, 'testContactForm'])->name('test-contact-form');
    Route::post('/test-importer-request', [App\Http\Controllers\EmailTestController::class, 'testImporterRequest'])->name('test-importer-request');
});

// Notification testing page
Route::get('/notification-test', function () {
    return view('notification-test');
})->name('notification-test.page');

// Pusher Push Notifications routes
Route::prefix('api/pusher')->name('api.pusher.')->group(function () {
    Route::post('/test', [App\Http\Controllers\PusherNotificationController::class, 'testNotification'])->name('test');
    Route::get('/stats', [App\Http\Controllers\PusherNotificationController::class, 'getStats'])->name('stats');
});

// Test settings page
Route::get('/test-settings', function () {
    return view('test-settings');
})->name('test-settings');

// Test login route
Route::get('/test-login', function () {
    return response()->json([
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId(),
        'timestamp' => now()->toISOString(),
        'session_data' => session()->all()
    ]);
})->name('test-login');

// Simple login test route
Route::get('/login-test', function () {
    return view('auth.login-test');
})->name('login-test');

// Alternative login route without CSRF issues
Route::get('/login-alt', function () {
    // Clear any existing session issues
    session()->flush();
    session()->regenerate();
    return view('auth.login');
})->name('login-alt');

// Test file upload functionality
Route::get('/test-upload', function () {
    $settings = \App\Models\Setting::getAll();
    return response()->json([
        'settings' => $settings,
        'storage_link_exists' => file_exists(public_path('storage')),
        'settings_dir_exists' => file_exists(storage_path('app/public/settings')),
        'storage_permissions' => is_writable(storage_path('app/public'))
    ]);
})->name('test-upload');

// Demo Dashboard Routes (for testing only)
Route::get('/importer/dashboard', function () {
    return view('demo.importer-dashboard');
})->name('importer.demo');

// Demo route removed - using proper authenticated route below

// Demo route removed - using proper authenticated route below

// الصفحة الرئيسية الجديدة
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// صفحة من نحن
Route::get('/about', function () {
    return view('about');
})->name('about');

// صفحة الخدمات
    Route::get('/services', [ServicesController::class, 'index'])->name('services');
    
    // Admin Services Management
    Route::get('/admin/services', [ServicesController::class, 'adminIndex'])->name('admin.services.index')->middleware('user.permission:services_management');
    Route::get('/admin/services/{service}/edit', [ServicesController::class, 'edit'])->name('admin.services.edit')->middleware('user.permission:services_management');
    Route::post('/admin/services', [ServicesController::class, 'store'])->name('admin.services.store')->middleware('user.permission:services_management');
    Route::put('/admin/services/{service}', [ServicesController::class, 'update'])->name('admin.services.update')->middleware('user.permission:services_management');
    Route::delete('/admin/services/{service}', [ServicesController::class, 'destroy'])->name('admin.services.destroy')->middleware('user.permission:services_management');
    Route::patch('/admin/services/{service}/toggle-status', [ServicesController::class, 'toggleStatus'])->name('admin.services.toggle-status')->middleware('user.permission:services_management');
    Route::post('/admin/services/activate-all', [ServicesController::class, 'activateAll'])->name('admin.services.activate-all')->middleware('user.permission:services_management');
    Route::post('/admin/services/update-order', [ServicesController::class, 'updateOrder'])->name('admin.services.update-order')->middleware('user.permission:services_management');

// صفحة المنتجات
Route::get('/products', function () {
    return view('products.index');
})->name('products.index');


// API Routes للصفحة الرئيسية
Route::prefix('api')->group(function () {
    // معلومات الشركة
    Route::get('/company-info', function () {
        return response()->json([
            'name' => 'إنفينيتي وير',
            'english_name' => 'Infinity Wear',
            'description' => 'شركة سعودية رائدة في تصميم وإنتاج الملابس الرياضية والزي الموحد للفرق والمدارس والشركات',
            'vision' => 'أن نكون الخيار الأول في المملكة العربية السعودية للملابس الرياضية والزي الموحد، من خلال تقديم منتجات عالية الجودة وخدمة عملاء متميزة تلبي احتياجات عملائنا وتتجاوز توقعاتهم.',
            'mission' => 'نقدم حلولاً شاملة في تصميم وإنتاج الملابس الرياضية والزي الموحد باستخدام أحدث التقنيات والمواد عالية الجودة، مع الحرص على إرضاء عملائنا وتحقيق أهدافهم بكفاءة واحترافية عالية.',
            'contact' => [
                'phone' => '+966500982394',
                'email' => 'info@infinitywear.sa',
                'address' => 'الرياض، حي النخيل، المملكة العربية السعودية',
                'working_hours' => 'الأحد - الخميس: 8:00 ص - 6:00 م'
            ],
            'social_media' => [
                'facebook' => '#',
                'twitter' => '#',
                'instagram' => '#',
                'linkedin' => '#'
            ],
            'stats' => [
                'satisfied_customers' => 500,
                'completed_projects' => 1000,
                'team_members' => 50,
                'years_experience' => 5
            ]
        ]);
    })->name('api.company-info');

    // الخدمات
    Route::get('/services', function () {
        return response()->json([
            'services' => [
                [
                    'id' => 1,
                    'title' => 'زي الفرق الرياضية',
                    'description' => 'تصميم وإنتاج أزياء متكاملة للفرق الرياضية بمختلف الأنواع (كرة قدم، كرة سلة، كرة طائرة، إلخ)',
                    'icon' => 'fas fa-users',
                    'features' => [
                        'تصاميم عصرية وجذابة',
                        'مواد مقاومة للعرق والرطوبة',
                        'ألوان ثابتة لا تبهت',
                        'مقاسات متنوعة ومريحة'
                    ]
                ],
                [
                    'id' => 2,
                    'title' => 'زي المدارس والجامعات',
                    'description' => 'زي موحد للمدارس والجامعات يجمع بين الأناقة والراحة والمتانة للاستخدام اليومي',
                    'icon' => 'fas fa-graduation-cap',
                    'features' => [
                        'تصاميم رسمية ومناسبة',
                        'أقمشة عالية الجودة',
                        'سهولة في الصيانة والغسيل',
                        'أسعار تنافسية للكميات الكبيرة'
                    ]
                ],
                [
                    'id' => 3,
                    'title' => 'زي الشركات والمؤسسات',
                    'description' => 'ملابس عمل رسمية وأنيقة تعكس هوية الشركة وتعزز من المظهر المهني للموظفين',
                    'icon' => 'fas fa-building',
                    'features' => [
                        'تصاميم احترافية',
                        'ألوان وشعارات مخصصة',
                        'مقاسات متعددة',
                        'كميات مرنة حسب الحاجة'
                    ]
                ],
                [
                    'id' => 4,
                    'title' => 'تصاميم مخصصة',
                    'description' => 'خدمة تصميم مخصصة بالكامل حسب متطلبات العميل ورؤيته الخاصة',
                    'icon' => 'fas fa-palette',
                    'features' => [
                        'فريق تصميم محترف',
                        'نماذج ثلاثية الأبعاد',
                        'مراجعات متعددة',
                        'تنفيذ دقيق للتصميم'
                    ]
                ],
                [
                    'id' => 5,
                    'title' => 'الطباعة والتطريز',
                    'description' => 'خدمات طباعة وتطريز عالية الجودة للشعارات والأسماء والأرقام',
                    'icon' => 'fas fa-print',
                    'features' => [
                        'تقنيات طباعة حديثة',
                        'تطريز دقيق ومتين',
                        'ألوان ثابتة وواضحة',
                        'تنفيذ سريع وبدقة عالية'
                    ]
                ],
                [
                    'id' => 6,
                    'title' => 'التوصيل والتوزيع',
                    'description' => 'خدمة توصيل وتوزيع شاملة تغطي جميع مناطق المملكة العربية السعودية',
                    'icon' => 'fas fa-truck',
                    'features' => [
                        'توصيل مجاني للطلبات الكبيرة',
                        'تغليف آمن ومحترف',
                        'تتبع الشحنات',
                        'خدمة عملاء على مدار الساعة'
                    ]
                ]
            ]
        ]);
    })->name('api.services');

    // المنتجات
    Route::get('/products', function () {
        return response()->json([
            'products' => [
                [
                    'id' => 1,
                    'title' => 'تيشيرت كرة قدم احترافي',
                    'description' => 'تيشيرت مصنوع من أجود أنواع الأقمشة المقاومة للعرق والرطوبة',
                    'category' => 'jerseys',
                    'price' => '85',
                    'currency' => 'ريال',
                    'image' => 'images/portfolio/football_kit_1.jpg',
                    'features' => ['جودة عالية', 'مقاوم للعرق', 'ألوان ثابتة']
                ],
                [
                    'id' => 2,
                    'title' => 'جيرسي كرة سلة',
                    'description' => 'جيرسي خفيف الوزن ومريح للحركة مع تصميم عصري',
                    'category' => 'jerseys',
                    'price' => '95',
                    'currency' => 'ريال',
                    'image' => 'images/portfolio/sports_wear_1.jpg',
                    'features' => ['خفيف الوزن', 'تهوية ممتازة', 'مرونة عالية']
                ],
                [
                    'id' => 3,
                    'title' => 'شورت رياضي احترافي',
                    'description' => 'شورت مصنوع من أقمشة ممتازة مع حزام مرن للراحة التامة',
                    'category' => 'shorts',
                    'price' => '65',
                    'currency' => 'ريال',
                    'image' => 'images/portfolio/school_uniform_1.jpg',
                    'features' => ['حزام مرن', 'جيوب عملية', 'مقاوم للتمزق']
                ],
                [
                    'id' => 4,
                    'title' => 'إكسسوارات رياضية',
                    'description' => 'مجموعة متنوعة من الإكسسوارات الرياضية عالية الجودة',
                    'category' => 'accessories',
                    'price' => '25',
                    'currency' => 'ريال',
                    'image' => 'images/portfolio/corporate_uniform_1.jpg',
                    'features' => ['تصاميم متنوعة', 'جودة ممتازة', 'أسعار مناسبة']
                ],
                [
                    'id' => 5,
                    'title' => 'معدات رياضية احترافية',
                    'description' => 'أدوات ومعدات رياضية تساعد في تحسين الأداء والسلامة',
                    'category' => 'equipment',
                    'price' => '150',
                    'currency' => 'ريال',
                    'image' => 'images/portfolio/medical_uniform_1.jpg',
                    'features' => ['معايير أمان عالية', 'متانة فائقة', 'ضمان لمدة عام']
                ],
                [
                    'id' => 6,
                    'title' => 'زي مدرسي رياضي',
                    'description' => 'زي مدرسي مريح وعملي للأنشطة الرياضية في المدارس',
                    'category' => 'jerseys',
                    'price' => '75',
                    'currency' => 'ريال',
                    'image' => 'images/portfolio/school_uniform_1.jpg',
                    'features' => ['مناسب للأطفال', 'سهل الغسيل', 'ألوان مشرقة']
                ]
            ],
            'categories' => [
                ['id' => 'all', 'name' => 'جميع المنتجات'],
                ['id' => 'jerseys', 'name' => 'التيشيرتات والجيرسي'],
                ['id' => 'shorts', 'name' => 'الشورتات والسراويل'],
                ['id' => 'accessories', 'name' => 'الإكسسوارات'],
                ['id' => 'equipment', 'name' => 'المعدات الرياضية']
            ]
        ]);
    })->name('api.products');

    // الأعمال السابقة
    Route::get('/portfolio', function () {
        return response()->json([
            'portfolio' => [
                [
                    'id' => 1,
                    'title' => 'فريق كرة قدم الرياض',
                    'description' => 'زي كامل لفريق كرة قدم محلي',
                    'category' => 'football',
                    'image' => 'images/portfolio/football_kit_1.jpg',
                    'client' => 'نادي الرياض الرياضي',
                    'year' => '2024'
                ],
                [
                    'id' => 2,
                    'title' => 'نادي كرة السلة الأهلي',
                    'description' => 'جيرسي وشورت لفريق كرة سلة محترف',
                    'category' => 'basketball',
                    'image' => 'images/portfolio/sports_wear_1.jpg',
                    'client' => 'نادي الأهلي السعودي',
                    'year' => '2024'
                ],
                [
                    'id' => 3,
                    'title' => 'مدرسة الرياض الدولية',
                    'description' => 'زي رياضي موحد للمدرسة',
                    'category' => 'schools',
                    'image' => 'images/portfolio/school_uniform_1.jpg',
                    'client' => 'مدرسة الرياض الدولية',
                    'year' => '2023'
                ],
                [
                    'id' => 4,
                    'title' => 'شركة الاتصالات السعودية',
                    'description' => 'زي عمل لموظفي الشركة',
                    'category' => 'companies',
                    'image' => 'images/portfolio/corporate_uniform_1.jpg',
                    'client' => 'شركة الاتصالات السعودية',
                    'year' => '2023'
                ],
                [
                    'id' => 5,
                    'title' => 'أكاديمية كرة القدم',
                    'description' => 'زي تدريب لأكاديمية كرة قدم',
                    'category' => 'football',
                    'image' => 'images/portfolio/football_kit_1.jpg',
                    'client' => 'أكاديمية الرياض لكرة القدم',
                    'year' => '2023'
                ],
                [
                    'id' => 6,
                    'title' => 'جامعة الملك سعود',
                    'description' => 'زي رياضي لفرق الجامعة',
                    'category' => 'schools',
                    'image' => 'images/portfolio/school_uniform_1.jpg',
                    'client' => 'جامعة الملك سعود',
                    'year' => '2022'
                ]
            ],
            'categories' => [
                ['id' => 'all', 'name' => 'جميع الأعمال'],
                ['id' => 'football', 'name' => 'كرة قدم'],
                ['id' => 'basketball', 'name' => 'كرة سلة'],
                ['id' => 'schools', 'name' => 'مدارس'],
                ['id' => 'companies', 'name' => 'شركات']
            ]
        ]);
    })->name('api.portfolio');

    // التقييمات
    Route::get('/testimonials', function () {
        return response()->json([
            'testimonials' => [
                [
                    'id' => 1,
                    'name' => 'أحمد محمد',
                    'title' => 'مدرب فريق كرة قدم',
                    'avatar' => 'https://via.placeholder.com/60x60/007bff/ffffff?text=أحمد',
                    'rating' => 5,
                    'text' => 'خدمة ممتازة وجودة عالية في المنتجات. فريق العمل محترف ومتعاون. تم تسليم الطلب في الموعد المحدد وبأفضل جودة ممكنة.'
                ],
                [
                    'id' => 2,
                    'name' => 'سارة أحمد',
                    'title' => 'مديرة مدرسة دولية',
                    'avatar' => 'https://via.placeholder.com/60x60/28a745/ffffff?text=سارة',
                    'rating' => 5,
                    'text' => 'تعامل راقي ومنتجات عالية الجودة. التصاميم المقدمة كانت إبداعية ومميزة. سنتعامل معهم في جميع مشاريعنا المستقبلية.'
                ],
                [
                    'id' => 3,
                    'name' => 'محمد علي',
                    'title' => 'مدير شركة رياضية',
                    'avatar' => 'https://via.placeholder.com/60x60/ffc107/000000?text=محمد',
                    'rating' => 5,
                    'text' => 'شركة محترفة وملتزمة بالمواعيد. الجودة تفوق التوقعات والأسعار تنافسية. أنصح بالتعامل معهم لأي مشروع رياضي.'
                ]
            ]
        ]);
    })->name('api.testimonials');

    // إرسال رسالة التواصل - تُدار عبر ContactController@store
    // Route removed to avoid duplication with Route::post('/contact', [ContactController::class, 'store']) below

    // نقطة وصول الدعم الفني العامة
    // Route::post('/importers/support', [ImporterController::class, 'createSupportTicket'])->name('api.support');

    // طلب عرض سعر
    Route::post('/quote-request', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'service_type' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string|max:1000',
            'budget' => 'nullable|string|max:255',
            'timeline' => 'nullable|string|max:255'
        ]);

        // هنا يمكن إضافة منطق معالجة طلب العرض السعر
        
        return response()->json([
            'success' => true,
            'message' => 'تم استلام طلب عرض السعر بنجاح! سنتواصل معك خلال 24 ساعة.',
            'data' => [
                'quote_id' => 'Q' . rand(10000, 99999),
                'estimated_response_time' => '24 ساعة',
                'timestamp' => now()->toISOString()
            ]
        ], 201);
    })->name('api.quote-request');

    // إحصائيات الموقع
    Route::get('/stats', function () {
        return response()->json([
            'stats' => [
                'total_customers' => 500,
                'completed_projects' => 1000,
                'team_members' => 50,
                'years_experience' => 5,
                'satisfaction_rate' => 98,
                'delivery_time' => '7-14 يوم',
                'coverage_areas' => 13, // محافظات المملكة
                'product_categories' => 6
            ],
            'updated_at' => now()->toISOString()
        ]);
    })->name('api.stats');
});

// المنتجات - تم إزالتها

// الفئات - تم حذفها

// التقييمات - تم نقلها إلى مجموعة admin

// معرض الأعمال
use App\Http\Controllers\PortfolioController;
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{portfolioItem}', [PortfolioController::class, 'show'])->name('portfolio.show');
Route::post('/portfolio/filter', [PortfolioController::class, 'filterByCategory'])->name('portfolio.filter');

// التقييمات
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
Route::get('/testimonials/create', [TestimonialController::class, 'create'])->name('testimonials.create');
Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

// صفحة التواصل
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// التصاميم المخصصة (متاحة بدون تسجيل دخول) - تم إزالتها


// المصادقة للعملاء
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('refresh.csrf');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// المصادقة لفريق التسويق
Route::get('/marketing/login', [AuthController::class, 'showLoginForm'])->name('marketing.login');
Route::post('/marketing/login', [AuthController::class, 'login'])->name('marketing.login.post');

// المصادقة لفريق المبيعات
Route::get('/sales/login', [AuthController::class, 'showLoginForm'])->name('sales.login');
Route::post('/sales/login', [AuthController::class, 'login'])->name('sales.login.post');

// المصادقة للأدمن
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('admin.auth');

// لوحات تحكم العملاء تم إلغاؤها

// المستوردين
use App\Http\Controllers\ImporterController;
Route::get('/importers/register', [ImporterController::class, 'showImporterForm'])->name('importers.form');
Route::post('/importers/register', [ImporterController::class, 'submitImporterForm'])->name('importers.submit');
Route::post('/importers/upload-design', [ImporterController::class, 'uploadDesignFile'])->name('importers.upload-design');

// AI API endpoints for importer form
Route::post('/api/ai/design-assistance', [ImporterController::class, 'aiDesignAssistance'])->name('api.ai.design-assistance');
Route::post('/api/ai/analyze-requirements', [ImporterController::class, 'analyzeDesignRequirements'])->name('api.ai.analyze-requirements');
Route::post('/api/ai/generate-design', [ImporterController::class, 'generateDesign'])->name('api.ai.generate-design');

// لوحة تحكم المستوردين
Route::middleware(['auth', 'user.type:importer'])->prefix('importers')->name('importers.')->group(function () {
    Route::get('/dashboard', [ImporterController::class, 'dashboard'])->name('dashboard')->middleware('user.permission:dashboard');
    Route::get('/orders', [ImporterController::class, 'orders'])->name('orders')->middleware('user.permission:orders');
    Route::get('/tracking', [ImporterController::class, 'tracking'])->name('tracking')->middleware('user.permission:tracking');
    Route::get('/invoices', [ImporterController::class, 'invoices'])->name('invoices')->middleware('user.permission:invoices');
    Route::get('/invoices/{orderId}', [ImporterController::class, 'showInvoice'])->name('invoices.show')->middleware('user.permission:invoices');
    Route::get('/payment-methods', [ImporterController::class, 'paymentMethods'])->name('payment-methods')->middleware('user.permission:payment_methods');
    Route::post('/payment-methods/add', [ImporterController::class, 'addPaymentMethod'])->name('payment-methods.add')->middleware('user.permission:payment_methods');
    Route::delete('/payment-methods/{methodId}', [ImporterController::class, 'deletePaymentMethod'])->name('payment-methods.delete')->middleware('user.permission:payment_methods');
    Route::get('/notifications', [ImporterController::class, 'notifications'])->name('notifications')->middleware('user.permission:notifications');
    Route::get('/notifications/unread-count', [ImporterController::class, 'getUnreadNotificationsCount'])->name('notifications.unread-count')->middleware('user.permission:notifications');
    Route::post('/notifications/{notificationId}/mark-read', [ImporterController::class, 'markNotificationAsRead'])->name('notifications.mark-read')->middleware('user.permission:notifications');
    Route::post('/notifications/mark-all-read', [ImporterController::class, 'markAllNotificationsAsRead'])->name('notifications.mark-all-read')->middleware('user.permission:notifications');
    Route::delete('/notifications/{notificationId}/delete', [ImporterController::class, 'deleteNotification'])->name('notifications.delete')->middleware('user.permission:notifications');
    Route::get('/notification-settings', [ImporterController::class, 'notificationSettings'])->name('notification-settings')->middleware('user.permission:notifications');
    Route::put('/notification-settings', [ImporterController::class, 'updateNotificationSettings'])->name('notification-settings.update')->middleware('user.permission:notifications');
    Route::get('/help', [ImporterController::class, 'help'])->name('help')->middleware('user.permission:help');
    Route::get('/support', [ImporterController::class, 'support'])->name('support')->middleware('user.permission:support');
    Route::post('/support/create-ticket', [ImporterController::class, 'createSupportTicket'])->name('support.create-ticket')->middleware('user.permission:support');
    Route::get('/contact', [ImporterController::class, 'contact'])->name('contact')->middleware('user.permission:contact');
    Route::post('/contact/send', [ImporterController::class, 'sendContactMessage'])->name('contact.send')->middleware('user.permission:contact');
    Route::get('/profile', [ImporterController::class, 'profile'])->name('profile')->middleware('user.permission:profile');
    Route::put('/profile', [ImporterController::class, 'updateProfile'])->name('profile.update')->middleware('user.permission:profile');
});

// لوحة تحكم فريق التسويق
Route::middleware(['auth', 'user.type:marketing'])->prefix('marketing')->name('marketing.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Marketing\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/portfolio', [App\Http\Controllers\Marketing\DashboardController::class, 'portfolio'])->name('portfolio');
    Route::get('/portfolio/create', [App\Http\Controllers\Marketing\DashboardController::class, 'createPortfolio'])->name('portfolio.create');
    Route::post('/portfolio', [App\Http\Controllers\Marketing\DashboardController::class, 'storePortfolio'])->name('portfolio.store');
    Route::get('/portfolio/{portfolioItem}/edit', [App\Http\Controllers\Marketing\DashboardController::class, 'editPortfolio'])->name('portfolio.edit');
    Route::put('/portfolio/{portfolioItem}', [App\Http\Controllers\Marketing\DashboardController::class, 'updatePortfolio'])->name('portfolio.update');
    Route::delete('/portfolio/{portfolioItem}', [App\Http\Controllers\Marketing\DashboardController::class, 'destroyPortfolio'])->name('portfolio.destroy');
    Route::get('/testimonials', [App\Http\Controllers\Marketing\DashboardController::class, 'testimonials'])->name('testimonials');
    Route::get('/testimonials/create', [App\Http\Controllers\Marketing\DashboardController::class, 'createTestimonial'])->name('testimonials.create');
    Route::post('/testimonials', [App\Http\Controllers\Marketing\DashboardController::class, 'storeTestimonial'])->name('testimonials.store');
    Route::get('/testimonials/{testimonial}/edit', [App\Http\Controllers\Marketing\DashboardController::class, 'editTestimonial'])->name('testimonials.edit');
    Route::put('/testimonials/{testimonial}', [App\Http\Controllers\Marketing\DashboardController::class, 'updateTestimonial'])->name('testimonials.update');
    Route::delete('/testimonials/{testimonial}', [App\Http\Controllers\Marketing\DashboardController::class, 'destroyTestimonial'])->name('testimonials.destroy');
    Route::get('/contacts', [App\Http\Controllers\Marketing\DashboardController::class, 'contacts'])->name('contacts');
    Route::get('/contacts/{contact}', [App\Http\Controllers\Marketing\DashboardController::class, 'showContact'])->name('contacts.show');
    Route::put('/contacts/{contact}', [App\Http\Controllers\Marketing\DashboardController::class, 'updateContact'])->name('contacts.update');
    Route::patch('/contacts/{contact}/mark-read', [App\Http\Controllers\Marketing\DashboardController::class, 'markContactAsRead'])->name('contacts.mark-read');
    Route::patch('/contacts/{contact}/mark-replied', [App\Http\Controllers\Marketing\DashboardController::class, 'markContactAsReplied'])->name('contacts.mark-replied');
    Route::patch('/contacts/{contact}/mark-closed', [App\Http\Controllers\Marketing\DashboardController::class, 'markContactAsClosed'])->name('contacts.mark-closed');
    Route::get('/profile', [App\Http\Controllers\Marketing\DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Marketing\DashboardController::class, 'updateProfile'])->name('profile.update');
    
    // إدارة المهام لفريق التسويق
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [App\Http\Controllers\Marketing\TaskController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Marketing\TaskController::class, 'createTask'])->name('create');
        Route::put('/{task}', [App\Http\Controllers\Marketing\TaskController::class, 'updateTask'])->name('update');
        Route::post('/{task}/move', [App\Http\Controllers\Marketing\TaskController::class, 'moveTask'])->name('move');
        Route::get('/{task}/comments', [App\Http\Controllers\Marketing\TaskController::class, 'getComments'])->name('comments');
        Route::post('/{task}/comment', [App\Http\Controllers\Marketing\TaskController::class, 'addComment'])->name('comment');
        Route::post('/{task}/attachment', [App\Http\Controllers\Marketing\TaskController::class, 'addAttachment'])->name('attachment');
        Route::post('/{task}/checklist', [App\Http\Controllers\Marketing\TaskController::class, 'addChecklistItem'])->name('checklist');
        Route::put('/{task}/checklist', [App\Http\Controllers\Marketing\TaskController::class, 'updateChecklistItem'])->name('update-checklist');
        Route::post('/{task}/time-log', [App\Http\Controllers\Marketing\TaskController::class, 'addTimeLog'])->name('time-log');
    });
});

// Test route for debugging
Route::get('/test-sales-comments/{task}', function($task) {
    return response()->json([
        'success' => true,
        'message' => 'Test route working',
        'task_id' => $task,
        'timestamp' => now()
    ]);
});

// لوحة تحكم فريق المبيعات
Route::middleware(['auth', 'user.type:sales'])->prefix('sales')->name('sales.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Sales\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/importer-orders', [App\Http\Controllers\Sales\DashboardController::class, 'importerOrders'])->name('importer-orders');
    Route::get('/importer-orders/{order}', [App\Http\Controllers\Sales\DashboardController::class, 'showImporterOrder'])->name('importer-orders.show');
    Route::put('/importer-orders/{order}/status', [App\Http\Controllers\Sales\DashboardController::class, 'updateImporterOrderStatus'])->name('importer-orders.update-status');
    Route::get('/importers', [App\Http\Controllers\Sales\DashboardController::class, 'importers'])->name('importers');
    Route::get('/importers/{importer}', [App\Http\Controllers\Sales\DashboardController::class, 'showImporter'])->name('importers.show');
    Route::put('/importers/{importer}/status', [App\Http\Controllers\Sales\DashboardController::class, 'updateImporterStatus'])->name('importers.update-status');
    Route::get('/contacts', [App\Http\Controllers\Sales\DashboardController::class, 'contacts'])->name('contacts');
    Route::get('/contacts/{id}', [App\Http\Controllers\Sales\DashboardController::class, 'showContact'])->name('contacts.show');
    Route::put('/contacts/{id}', [App\Http\Controllers\Sales\DashboardController::class, 'updateContact'])->name('contacts.update');
    Route::get('/reports', [App\Http\Controllers\Sales\DashboardController::class, 'reports'])->name('reports');
    
    // تقارير المندوبين التسويقيين
    Route::get('/marketing-reports', [App\Http\Controllers\Sales\MarketingReportController::class, 'index'])->name('marketing-reports.index');
    Route::get('/marketing-reports/create', [App\Http\Controllers\Sales\MarketingReportController::class, 'create'])->name('marketing-reports.create');
    Route::post('/marketing-reports', [App\Http\Controllers\Sales\MarketingReportController::class, 'store'])->name('marketing-reports.store');
    Route::get('/marketing-reports/{marketingReport}', [App\Http\Controllers\Sales\MarketingReportController::class, 'show'])->name('marketing-reports.show');
    Route::get('/marketing-reports/{marketingReport}/edit', [App\Http\Controllers\Sales\MarketingReportController::class, 'edit'])->name('marketing-reports.edit');
    Route::put('/marketing-reports/{marketingReport}', [App\Http\Controllers\Sales\MarketingReportController::class, 'update'])->name('marketing-reports.update');
    Route::delete('/marketing-reports/{marketingReport}', [App\Http\Controllers\Sales\MarketingReportController::class, 'destroy'])->name('marketing-reports.destroy');
    Route::patch('/marketing-reports/{marketingReport}/status', [App\Http\Controllers\Sales\MarketingReportController::class, 'updateStatus'])->name('marketing-reports.update-status');
    Route::get('/marketing-reports-export', [App\Http\Controllers\Sales\MarketingReportController::class, 'export'])->name('marketing-reports.export');
    
    Route::get('/profile', [App\Http\Controllers\Sales\DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Sales\DashboardController::class, 'updateProfile'])->name('profile.update');
    
    // إدارة المهام لفريق المبيعات
    Route::get('/tasks', [App\Http\Controllers\Sales\TaskController::class, 'index'])->name('tasks');
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::post('/', [App\Http\Controllers\Sales\TaskController::class, 'createTask'])->name('create');
        Route::put('/{task}', [App\Http\Controllers\Sales\TaskController::class, 'updateTask'])->name('update');
        Route::post('/{task}/move', [App\Http\Controllers\Sales\TaskController::class, 'moveTask'])->name('move');
        Route::get('/{task}/comments', [App\Http\Controllers\Sales\TaskController::class, 'getComments'])->name('comments');
        Route::post('/{task}/comment', [App\Http\Controllers\Sales\TaskController::class, 'addComment'])->name('comment');
        Route::post('/{task}/attachment', [App\Http\Controllers\Sales\TaskController::class, 'addAttachment'])->name('attachment');
        Route::post('/{task}/checklist', [App\Http\Controllers\Sales\TaskController::class, 'addChecklistItem'])->name('checklist');
        Route::put('/{task}/checklist', [App\Http\Controllers\Sales\TaskController::class, 'updateChecklistItem'])->name('update-checklist');
        Route::post('/{task}/time-log', [App\Http\Controllers\Sales\TaskController::class, 'addTimeLog'])->name('time-log');
    });
});

// لوحة تحكم الموظفين
Route::middleware(['auth', 'user.type:employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Employee\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/tasks', [App\Http\Controllers\Employee\DashboardController::class, 'tasks'])->name('tasks');
    Route::put('/tasks/{task}/status', [App\Http\Controllers\Employee\DashboardController::class, 'updateTaskStatus'])->name('tasks.update-status');
    Route::get('/profile', [App\Http\Controllers\Employee\DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Employee\DashboardController::class, 'updateProfile'])->name('profile.update');
});

// لوحة التحكم الإدارية
Route::prefix('admin')->middleware(['admin.auth'])->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/employees', [App\Http\Controllers\Admin\DashboardController::class, 'employees'])->name('employees');
    // صفحة الدعم الفني للأدمن
    Route::get('/support', function () { return view('admin.support'); })->name('support');
    Route::get('/reports', [App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('reports')->middleware('user.permission:reports');
    Route::get('/reports/export/excel', [App\Http\Controllers\Admin\ReportsController::class, 'exportExcel'])->name('reports.export.excel')->middleware('user.permission:reports');
    Route::get('/reports/export/pdf', [App\Http\Controllers\Admin\ReportsController::class, 'exportPdf'])->name('reports.export.pdf')->middleware('user.permission:reports');
    Route::get('/settings', [App\Http\Controllers\Admin\DashboardController::class, 'settings'])->name('settings')->middleware('user.permission:settings');
    
    // إدارة المهام الجديدة
    Route::prefix('tasks')->name('tasks.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\TaskManagementController::class, 'index'])->name('index')->middleware('user.permission:tasks_management');
        Route::post('/board', [App\Http\Controllers\Admin\TaskManagementController::class, 'createBoard'])->name('create-board')->middleware('user.permission:tasks_management');
        Route::post('/', [App\Http\Controllers\Admin\TaskManagementController::class, 'createTask'])->name('create')->middleware('user.permission:tasks_management');
        Route::put('/{task}', [App\Http\Controllers\Admin\TaskManagementController::class, 'updateTask'])->name('update')->middleware('user.permission:tasks_management');
        Route::delete('/{task}', [App\Http\Controllers\Admin\TaskManagementController::class, 'deleteTask'])->name('delete')->middleware('user.permission:tasks_management');
        Route::post('/{task}/move', [App\Http\Controllers\Admin\TaskManagementController::class, 'moveTask'])->name('move')->middleware('user.permission:tasks_management');
        Route::get('/{task}/comments', [App\Http\Controllers\Admin\TaskManagementController::class, 'getComments'])->name('comments')->middleware('user.permission:tasks_management');
        Route::post('/{task}/comment', [App\Http\Controllers\Admin\TaskManagementController::class, 'addComment'])->name('comment')->middleware('user.permission:tasks_management');
        Route::post('/{task}/attachment', [App\Http\Controllers\Admin\TaskManagementController::class, 'addAttachment'])->name('attachment')->middleware('user.permission:tasks_management');
        Route::post('/{task}/checklist', [App\Http\Controllers\Admin\TaskManagementController::class, 'addChecklistItem'])->name('checklist')->middleware('user.permission:tasks_management');
        Route::put('/{task}/checklist', [App\Http\Controllers\Admin\TaskManagementController::class, 'updateChecklistItem'])->name('update-checklist')->middleware('user.permission:tasks_management');
        Route::post('/{task}/time-log', [App\Http\Controllers\Admin\TaskManagementController::class, 'addTimeLog'])->name('time-log')->middleware('user.permission:tasks_management');
        Route::post('/{task}/toggle-archive', [App\Http\Controllers\Admin\TaskManagementController::class, 'toggleArchive'])->name('toggle-archive')->middleware('user.permission:tasks_management');
    });
    Route::get('/api/dashboard-stats', [AdminController::class, 'getDashboardStats'])->name('api.dashboard-stats');
    
    // إدارة المحتوى الشاملة
    Route::resource('content-management', App\Http\Controllers\Admin\ContentManagementController::class);
    Route::patch('content-management/{contentManagement}/toggle-status', [App\Http\Controllers\Admin\ContentManagementController::class, 'toggleStatus'])->name('content-management.toggle-status');
    
    // إدارة المحتوى التقليدية - تم حذفها
    
    // إدارة أقسام الصفحة الرئيسية - تم حذفها
    
    // إدارة المشرفين
    Route::get('/admins', [AdminController::class, 'admins'])->name('admins.index')->middleware('user.permission:admins_management');
    Route::get('/admins/create', [AdminController::class, 'createAdmin'])->name('admins.create')->middleware('user.permission:admins_management');
    Route::post('/admins', [AdminController::class, 'storeAdmin'])->name('admins.store')->middleware('user.permission:admins_management');
    Route::get('/admins/{admin}', [AdminController::class, 'showAdmin'])->name('admins.show')->middleware('user.permission:admins_management');
    Route::get('/admins/{admin}/edit', [AdminController::class, 'editAdmin'])->name('admins.edit')->middleware('user.permission:admins_management');
    Route::put('/admins/{admin}', [AdminController::class, 'updateAdmin'])->name('admins.update')->middleware('user.permission:admins_management');
    Route::delete('/admins/{admin}', [AdminController::class, 'destroyAdmin'])->name('admins.destroy')->middleware('user.permission:admins_management');
    
    // المستوردين
    Route::get('/importers', [AdminController::class, 'importersIndex'])->name('importers.index')->middleware('user.permission:importers_management');
    Route::get('/importers/create', [AdminController::class, 'importersCreate'])->name('importers.create')->middleware('user.permission:importers_management');
    Route::post('/importers', [AdminController::class, 'importersStore'])->name('importers.store')->middleware('user.permission:importers_management');
    Route::get('/importers/{id}', [AdminController::class, 'importersShow'])->name('importers.show')->middleware('user.permission:importers_management');
    Route::get('/importers/{id}/edit', [AdminController::class, 'importersEdit'])->name('importers.edit')->middleware('user.permission:importers_management');
    Route::put('/importers/{id}', [AdminController::class, 'importersUpdate'])->name('importers.update')->middleware('user.permission:importers_management');
    Route::delete('/importers/{id}', [AdminController::class, 'importersDestroy'])->name('importers.destroy')->middleware('user.permission:importers_management');
    Route::put('/importers/{id}/status', [AdminController::class, 'importersUpdateStatus'])->name('importers.updateStatus')->middleware('user.permission:importers_management');
    Route::get('/importers-orders', [AdminController::class, 'importersOrders'])->name('importers.orders')->middleware('user.permission:importers_orders');
    Route::get('/orders', [AdminController::class, 'ordersIndex'])->name('orders.index');
    Route::get('/orders/{id}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{id}/status', [AdminController::class, 'ordersUpdateStatus'])->name('orders.updateStatus');
    
    // النظام المالي
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/', [FinanceController::class, 'dashboard'])->name('dashboard')->middleware('user.permission:finance_dashboard');
        Route::get('/index', [FinanceController::class, 'dashboard'])->name('index')->middleware('user.permission:finance_dashboard');
        Route::get('/transactions', [FinanceController::class, 'transactions'])->name('transactions')->middleware('user.permission:finance_transactions');
        Route::get('/transactions/create', [FinanceController::class, 'create'])->name('create')->middleware('user.permission:finance_transactions');
        Route::post('/transactions', [FinanceController::class, 'store'])->name('store')->middleware('user.permission:finance_transactions');
        Route::get('/transactions/{transaction}', [FinanceController::class, 'show'])->name('show')->middleware('user.permission:finance_transactions');
        Route::get('/transactions/{transaction}/edit', [FinanceController::class, 'edit'])->name('edit')->middleware('user.permission:finance_transactions');
        Route::put('/transactions/{transaction}', [FinanceController::class, 'update'])->name('update')->middleware('user.permission:finance_transactions');
        Route::delete('/transactions/{transaction}', [FinanceController::class, 'destroy'])->name('destroy')->middleware('user.permission:finance_transactions');
        Route::get('/reports', [FinanceController::class, 'reports'])->name('reports')->middleware('user.permission:finance_reports');
        Route::get('/export', [FinanceController::class, 'export'])->name('export')->middleware('user.permission:finance_reports');
        Route::get('/quick-stats', [FinanceController::class, 'quickStats'])->name('quick-stats')->middleware('user.permission:finance_dashboard');
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
    Route::resource('customer-notes', App\Http\Controllers\Admin\CustomerNotesController::class)->middleware('user.permission:customer_notes');
    Route::post('customer-notes/{customerNote}/archive', [App\Http\Controllers\Admin\CustomerNotesController::class, 'archive'])->name('customer-notes.archive')->middleware('user.permission:customer_notes');
    Route::post('customer-notes/{customerNote}/restore', [App\Http\Controllers\Admin\CustomerNotesController::class, 'restore'])->name('customer-notes.restore')->middleware('user.permission:customer_notes');
    Route::get('customers/{customer}/notes', [App\Http\Controllers\Admin\CustomerNotesController::class, 'customerNotes'])->name('customers.notes')->middleware('user.permission:customer_notes');
    Route::get('api/customers/{customer}/notes', [App\Http\Controllers\Admin\CustomerNotesController::class, 'getCustomerNotes'])->name('api.customers.notes')->middleware('user.permission:customer_notes');
    
    // إدارة الواتساب
    Route::prefix('whatsapp')->name('whatsapp.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\WhatsAppController::class, 'index'])->name('index')->middleware('user.permission:whatsapp');
        Route::get('/test', function() { return view('admin.whatsapp.test'); })->name('test')->middleware('user.permission:whatsapp');
        Route::get('/conversation/{phoneNumber}', [App\Http\Controllers\Admin\WhatsAppController::class, 'conversation'])->name('conversation')->middleware('user.permission:whatsapp');
        Route::post('/send', [App\Http\Controllers\Admin\WhatsAppController::class, 'sendMessage'])->name('send')->middleware('user.permission:whatsapp');
        Route::post('/test', [App\Http\Controllers\Admin\WhatsAppController::class, 'testMessage'])->name('test.send')->middleware('user.permission:whatsapp');
        Route::get('/test-connection', [App\Http\Controllers\Admin\WhatsAppController::class, 'testConnection'])->name('test.connection')->middleware('user.permission:whatsapp');
        Route::post('/receive', [App\Http\Controllers\Admin\WhatsAppController::class, 'receiveMessage'])->name('receive')->middleware('user.permission:whatsapp');
        Route::post('/messages/{message}/archive', [App\Http\Controllers\Admin\WhatsAppController::class, 'archiveMessage'])->name('messages.archive')->middleware('user.permission:whatsapp');
        Route::delete('/messages/{message}', [App\Http\Controllers\Admin\WhatsAppController::class, 'deleteMessage'])->name('messages.delete')->middleware('user.permission:whatsapp');
        Route::get('/stats', [App\Http\Controllers\Admin\WhatsAppController::class, 'getConversationStats'])->name('stats');
    });
    
    // إدارة المستخدمين الجديدة
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\UserManagementController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\UserManagementController::class, 'store'])->name('store');
        Route::get('/{user}', [App\Http\Controllers\Admin\UserManagementController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [App\Http\Controllers\Admin\UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{user}', [App\Http\Controllers\Admin\UserManagementController::class, 'update'])->name('update');
        Route::delete('/{user}', [App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/toggle-status', [App\Http\Controllers\Admin\UserManagementController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/export', [App\Http\Controllers\Admin\UserManagementController::class, 'export'])->name('export');
    });
    
    
    // فريق التسويق
    Route::get('/marketing', [AdminController::class, 'marketingTeam'])->name('marketing.index')->middleware('user.permission:marketing_team_management');
    Route::get('/marketing/create', [AdminController::class, 'createMarketingMember'])->name('marketing.create')->middleware('user.permission:marketing_team_management');
    Route::post('/marketing', [AdminController::class, 'storeMarketingMember'])->name('marketing.store')->middleware('user.permission:marketing_team_management');
    Route::get('/marketing/{id}', [AdminController::class, 'showMarketingMember'])->name('marketing.show')->middleware('user.permission:marketing_team_management');
    Route::get('/marketing/{id}/edit', [AdminController::class, 'editMarketingMember'])->name('marketing.edit')->middleware('user.permission:marketing_team_management');
    Route::put('/marketing/{id}', [AdminController::class, 'updateMarketingMember'])->name('marketing.update')->middleware('user.permission:marketing_team_management');
    Route::delete('/marketing/{id}', [AdminController::class, 'destroyMarketingMember'])->name('marketing.destroy')->middleware('user.permission:marketing_team_management');
    Route::post('/marketing/{id}/assign-task', [AdminController::class, 'assignTaskToMarketing'])->name('marketing.assign-task')->middleware('user.permission:marketing_team_management');
    Route::put('/marketing/{id}/disable', [AdminController::class, 'disableMarketingMember'])->name('marketing.disable')->middleware('user.permission:marketing_team_management');
    
    // مهام فريق التسويق
    Route::prefix('marketing/tasks')->name('marketing.tasks.')->group(function () {
        Route::get('/', [App\Http\Controllers\Marketing\TaskController::class, 'index'])->name('index');
        Route::get('/{task}', [App\Http\Controllers\Marketing\TaskController::class, 'show'])->name('show');
        Route::post('/{task}/move', [App\Http\Controllers\Marketing\TaskController::class, 'moveTask'])->name('move');
        Route::post('/{task}/comment', [App\Http\Controllers\Marketing\TaskController::class, 'addComment'])->name('comment');
    });
    
    // التسويق بالبريد الإلكتروني
    Route::get('/email-marketing', [App\Http\Controllers\Admin\EmailMarketingController::class, 'index'])->name('email-marketing.index');
    Route::get('/email-marketing/create', [App\Http\Controllers\Admin\EmailMarketingController::class, 'create'])->name('email-marketing.create');
    Route::post('/email-marketing', [App\Http\Controllers\Admin\EmailMarketingController::class, 'store'])->name('email-marketing.store');
    Route::get('/email-marketing/stats', [App\Http\Controllers\Admin\EmailMarketingController::class, 'getStats'])->name('email-marketing.stats');
    
    // فريق المبيعات
    Route::get('/sales', [AdminController::class, 'salesTeam'])->name('sales.index')->middleware('user.permission:sales_team_management');
    Route::get('/sales/{id}', [AdminController::class, 'showSalesMember'])->name('sales.show')->middleware('user.permission:sales_team_management');
    Route::post('/sales/{id}/assign-task', [AdminController::class, 'assignTaskToSales'])->name('sales.assign-task')->middleware('user.permission:sales_team_management');
    Route::put('/sales/{id}/target', [AdminController::class, 'updateSalesTarget'])->name('sales.update-target')->middleware('user.permission:sales_team_management');
    
    // مهام فريق المبيعات - Admin access
    Route::prefix('sales/tasks')->name('sales.tasks.')->group(function () {
        Route::get('/', [App\Http\Controllers\Sales\TaskController::class, 'index'])->name('index');
        Route::get('/{task}', [App\Http\Controllers\Sales\TaskController::class, 'show'])->name('show');
        Route::post('/{task}/move', [App\Http\Controllers\Sales\TaskController::class, 'moveTask'])->name('move');
        Route::get('/{task}/comments', [App\Http\Controllers\Sales\TaskController::class, 'getComments'])->name('comments');
        Route::post('/{task}/comment', [App\Http\Controllers\Sales\TaskController::class, 'addComment'])->name('comment');
    });
    Route::put('/sales/{id}/disable', [AdminController::class, 'disableSalesMember'])->name('sales.disable')->middleware('user.permission:sales_team_management');
    
    
    // معرض الأعمال
    Route::get('/portfolio', [AdminController::class, 'portfolio'])->name('portfolio.index')->middleware('user.permission:portfolio_management');
    Route::get('/portfolio/create', [AdminController::class, 'createPortfolioItem'])->name('portfolio.create')->middleware('user.permission:portfolio_management');
    Route::post('/portfolio', [AdminController::class, 'storePortfolioItem'])->name('portfolio.store')->middleware('user.permission:portfolio_management');
    Route::get('/portfolio/{id}/edit', [AdminController::class, 'editPortfolioItem'])->name('portfolio.edit')->middleware('user.permission:portfolio_management');
    Route::put('/portfolio/{id}', [AdminController::class, 'updatePortfolioItem'])->name('portfolio.update')->middleware('user.permission:portfolio_management');
    Route::delete('/portfolio/{id}', [AdminController::class, 'destroyPortfolioItem'])->name('portfolio.destroy')->middleware('user.permission:portfolio_management');
    
    // التقييمات
    Route::get('/testimonials', [AdminController::class, 'testimonials'])->name('testimonials.index')->middleware('user.permission:testimonials_management');
    Route::get('/testimonials/create', [AdminController::class, 'createTestimonial'])->name('testimonials.create')->middleware('user.permission:testimonials_management');
    Route::post('/testimonials', [AdminController::class, 'storeTestimonial'])->name('testimonials.store')->middleware('user.permission:testimonials_management');
    Route::get('/testimonials/{id}/edit', [AdminController::class, 'editTestimonial'])->name('testimonials.edit')->middleware('user.permission:testimonials_management');
    Route::put('/testimonials/{id}', [AdminController::class, 'updateTestimonial'])->name('testimonials.update')->middleware('user.permission:testimonials_management');
    Route::delete('/testimonials/{id}', [AdminController::class, 'destroyTestimonial'])->name('testimonials.destroy')->middleware('user.permission:testimonials_management');
    
    // التقارير
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    
    // إدارة خطط الشركة
    Route::resource('company-plans', App\Http\Controllers\Admin\CompanyPlanController::class);
    Route::put('/company-plans/{companyPlan}/status', [App\Http\Controllers\Admin\CompanyPlanController::class, 'updateStatus'])->name('company-plans.update-status');
    
    // إدارة الصلاحيات
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('index')->middleware('user.permission:permissions_management');
        Route::put('/', [App\Http\Controllers\Admin\PermissionController::class, 'update'])->name('update')->middleware('user.permission:permissions_management');
        Route::post('/reset', [App\Http\Controllers\Admin\PermissionController::class, 'reset'])->name('reset')->middleware('user.permission:permissions_management');
        
        // Role management routes
        Route::post('/roles', [App\Http\Controllers\Admin\PermissionController::class, 'storeRole'])->name('store-role')->middleware('user.permission:permissions_management');
        Route::put('/roles/{role}', [App\Http\Controllers\Admin\PermissionController::class, 'updateRole'])->name('update-role')->middleware('user.permission:permissions_management');
        Route::delete('/roles/{role}', [App\Http\Controllers\Admin\PermissionController::class, 'destroyRole'])->name('destroy-role')->middleware('user.permission:permissions_management');
    });
    
    // إدارة رسائل التواصل
    Route::resource('contacts', App\Http\Controllers\Admin\ContactController::class)->middleware('user.permission:contacts');
    Route::patch('contacts/{contact}/mark-read', [App\Http\Controllers\Admin\ContactController::class, 'markAsRead'])->name('contacts.mark-read')->middleware('user.permission:contacts');
    Route::patch('contacts/{contact}/mark-replied', [App\Http\Controllers\Admin\ContactController::class, 'markAsReplied'])->name('contacts.mark-replied')->middleware('user.permission:contacts');
    Route::patch('contacts/{contact}/mark-closed', [App\Http\Controllers\Admin\ContactController::class, 'markAsClosed'])->name('contacts.mark-closed')->middleware('user.permission:contacts');
    
    // إدارة الجهات المخصصة
    Route::patch('contacts/{contact}/archive', [App\Http\Controllers\Admin\ContactController::class, 'archive'])->name('contacts.archive')->middleware('user.permission:contacts');
    
    // إدارة تقارير المندوبين التسويقيين
    Route::prefix('marketing-reports')->name('marketing-reports.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\MarketingReportController::class, 'index'])->name('index')->middleware('user.permission:marketing_reports');
        Route::get('/{marketingReport}', [App\Http\Controllers\Admin\MarketingReportController::class, 'show'])->name('show')->middleware('user.permission:marketing_reports');
        Route::get('/{marketingReport}/edit', [App\Http\Controllers\Admin\MarketingReportController::class, 'edit'])->name('edit')->middleware('user.permission:marketing_reports');
        Route::put('/{marketingReport}', [App\Http\Controllers\Admin\MarketingReportController::class, 'update'])->name('update')->middleware('user.permission:marketing_reports');
        Route::delete('/{marketingReport}', [App\Http\Controllers\Admin\MarketingReportController::class, 'destroy'])->name('destroy')->middleware('user.permission:marketing_reports');
        Route::patch('/{marketingReport}/status', [App\Http\Controllers\Admin\MarketingReportController::class, 'updateStatus'])->name('update-status')->middleware('user.permission:marketing_reports');
        Route::get('/export', [App\Http\Controllers\Admin\MarketingReportController::class, 'export'])->name('export')->middleware('user.permission:marketing_reports');
        Route::get('/analytics', [App\Http\Controllers\Admin\MarketingReportController::class, 'analytics'])->name('analytics')->middleware('user.permission:marketing_reports');
    });
    Route::patch('contacts/{contact}/unarchive', [App\Http\Controllers\Admin\ContactController::class, 'unarchive'])->name('contacts.unarchive')->middleware('user.permission:contacts');
    Route::patch('contacts/{contact}/assign', [App\Http\Controllers\Admin\ContactController::class, 'assign'])->name('contacts.assign')->middleware('user.permission:contacts');
    Route::patch('contacts/{contact}/set-priority', [App\Http\Controllers\Admin\ContactController::class, 'setPriority'])->name('contacts.set-priority')->middleware('user.permission:contacts');
    Route::post('contacts/{contact}/add-tag', [App\Http\Controllers\Admin\ContactController::class, 'addTag'])->name('contacts.add-tag')->middleware('user.permission:contacts');
    Route::delete('contacts/{contact}/remove-tag', [App\Http\Controllers\Admin\ContactController::class, 'removeTag'])->name('contacts.remove-tag')->middleware('user.permission:contacts');
    Route::patch('contacts/{contact}/set-follow-up', [App\Http\Controllers\Admin\ContactController::class, 'setFollowUp'])->name('contacts.set-follow-up')->middleware('user.permission:contacts');
    Route::post('contacts/bulk-assign', [App\Http\Controllers\Admin\ContactController::class, 'bulkAssign'])->name('contacts.bulk-assign')->middleware('user.permission:contacts');
    Route::post('contacts/bulk-archive', [App\Http\Controllers\Admin\ContactController::class, 'bulkArchive'])->name('contacts.bulk-archive')->middleware('user.permission:contacts');
    Route::get('api/contacts/team/{team}', [App\Http\Controllers\Admin\ContactController::class, 'getTeamContacts'])->name('api.contacts.team')->middleware('user.permission:contacts');
    
    // الإعدادات
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    
    // إدارة الشعار
    Route::post('/logo/upload', [App\Http\Controllers\LogoController::class, 'uploadLogo'])->name('logo.upload');
    Route::delete('/logo/delete', [App\Http\Controllers\LogoController::class, 'deleteLogo'])->name('logo.delete');
    Route::get('/logo/info', [App\Http\Controllers\LogoController::class, 'getLogoInfo'])->name('logo.info');
    
    // إدارة أيقونة الموقع
    Route::post('/favicon/upload', [App\Http\Controllers\FaviconController::class, 'uploadFavicon'])->name('favicon.upload');
    Route::delete('/favicon/delete', [App\Http\Controllers\FaviconController::class, 'deleteFavicon'])->name('favicon.delete');
    Route::get('/favicon/info', [App\Http\Controllers\FaviconController::class, 'getFaviconInfo'])->name('favicon.info');
    Route::post('/favicon/refresh-from-logo', [App\Http\Controllers\FaviconController::class, 'refreshFromLogo'])->name('favicon.refresh-from-logo');
    
    // إدارة الإعدادات
    Route::post('/settings/general', [App\Http\Controllers\SettingsController::class, 'updateGeneral'])->name('settings.general');
    Route::post('/settings/contact', [App\Http\Controllers\SettingsController::class, 'updateContact'])->name('settings.contact');
    Route::post('/settings/social', [App\Http\Controllers\SettingsController::class, 'updateSocial'])->name('settings.social');
    Route::post('/settings/system', [App\Http\Controllers\SettingsController::class, 'updateSystem'])->name('settings.system');
    Route::post('/settings/favicon', [App\Http\Controllers\SettingsController::class, 'uploadFavicon'])->name('settings.favicon');
    Route::get('/settings/all', [App\Http\Controllers\SettingsController::class, 'getAllSettings'])->name('settings.all');
    Route::post('/settings/clear-cache', [App\Http\Controllers\SettingsController::class, 'clearCache'])->name('settings.clear-cache');
    
    // إدارة الإشعارات
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', function() {
            return view('admin.notifications.simple-working');
        })->name('index');
        Route::get('/unread', [App\Http\Controllers\Admin\NotificationController::class, 'getUnreadNotifications'])->name('unread')->middleware('auth:admin');
        Route::get('/stats', [App\Http\Controllers\Admin\NotificationController::class, 'getNotificationStats'])->name('stats')->middleware('auth:admin');
        Route::get('/{notification}/preview', [App\Http\Controllers\Admin\NotificationController::class, 'preview'])->name('preview')->middleware('user.permission:notifications');
        Route::post('/mark-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('mark-read')->middleware('user.permission:notifications');
        Route::post('/mark-all-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('mark-all-read')->middleware('user.permission:notifications');
        Route::post('/archive', [App\Http\Controllers\Admin\NotificationController::class, 'archiveNotification'])->name('archive')->middleware('user.permission:notifications');
        Route::post('/archive-read', [App\Http\Controllers\Admin\NotificationController::class, 'archiveRead'])->name('archive-read')->middleware('user.permission:notifications');
        
        // إدارة الإشعارات المخصصة للأدمن
        Route::get('/admin', [App\Http\Controllers\Admin\AdminNotificationController::class, 'index'])->name('admin.index')->middleware('user.permission:admin_notifications');
        Route::get('/admin/create', [App\Http\Controllers\Admin\AdminNotificationController::class, 'create'])->name('admin.create')->middleware('user.permission:admin_notifications');
        Route::post('/admin', [App\Http\Controllers\Admin\AdminNotificationController::class, 'store'])->name('admin.store')->middleware('user.permission:admin_notifications');
        Route::get('/admin/{notification}', [App\Http\Controllers\Admin\AdminNotificationController::class, 'show'])->name('admin.show')->middleware('user.permission:admin_notifications');
        Route::post('/admin/{notification}/send', [App\Http\Controllers\Admin\AdminNotificationController::class, 'send'])->name('admin.send')->middleware('user.permission:admin_notifications');
        Route::delete('/admin/{notification}', [App\Http\Controllers\Admin\AdminNotificationController::class, 'destroy'])->name('admin.destroy')->middleware('user.permission:admin_notifications');
        Route::get('/admin/api/users-by-type', [App\Http\Controllers\Admin\AdminNotificationController::class, 'getUsersByType'])->name('admin.api.users-by-type')->middleware('user.permission:admin_notifications');
        Route::get('/admin/api/stats', [App\Http\Controllers\Admin\AdminNotificationController::class, 'stats'])->name('admin.api.stats')->middleware('user.permission:admin_notifications');
        
        // إعدادات الإشعارات
        Route::get('/settings', [App\Http\Controllers\Admin\NotificationSettingsController::class, 'index'])->name('settings')->middleware('user.permission:notifications');
        
        // النظام الجديد للإشعارات - مؤقت
        Route::get('/new', function() {
            return view('admin.notifications.simple-working');
        })->name('new.index');
        Route::put('/settings', [App\Http\Controllers\Admin\NotificationSettingsController::class, 'update'])->name('settings.update')->middleware('user.permission:notifications');
        Route::post('/settings/test', [App\Http\Controllers\Admin\NotificationSettingsController::class, 'testEmail'])->name('settings.test')->middleware('user.permission:notifications');
        Route::post('/settings/reset', [App\Http\Controllers\Admin\NotificationSettingsController::class, 'reset'])->name('settings.reset')->middleware('user.permission:notifications');
        
        // مراقبة النظام
        Route::get('/queue-monitor', [App\Http\Controllers\Admin\QueueMonitorController::class, 'index'])->name('queue-monitor');
        Route::get('/queue-monitor/stats', [App\Http\Controllers\Admin\QueueMonitorController::class, 'getStats'])->name('queue-monitor.stats');
        Route::post('/queue-monitor/retry-failed', [App\Http\Controllers\Admin\QueueMonitorController::class, 'retryFailedJobs'])->name('queue-monitor.retry-failed');
        Route::post('/queue-monitor/flush-failed', [App\Http\Controllers\Admin\QueueMonitorController::class, 'flushFailedJobs'])->name('queue-monitor.flush-failed');
        Route::post('/queue-monitor/restart-worker', [App\Http\Controllers\Admin\QueueMonitorController::class, 'restartWorker'])->name('queue-monitor.restart-worker');
        
        // Push Notifications
        Route::get('/push-notifications', [App\Http\Controllers\Admin\PushNotificationController::class, 'index'])->name('push-notifications');
        Route::post('/push-notifications/send', [App\Http\Controllers\Admin\PushNotificationController::class, 'sendNotification'])->name('push-notifications.send');
        Route::post('/push-notifications/test', [App\Http\Controllers\Admin\PushNotificationController::class, 'testNotification'])->name('push-notifications.test');
        Route::delete('/push-notifications/{id}', [App\Http\Controllers\Admin\PushNotificationController::class, 'deleteSubscription'])->name('push-notifications.delete');
        Route::post('/push-notifications/{id}/toggle', [App\Http\Controllers\Admin\PushNotificationController::class, 'toggleSubscription'])->name('push-notifications.toggle');
        Route::post('/push-notifications/cleanup', [App\Http\Controllers\Admin\PushNotificationController::class, 'cleanupOldSubscriptions'])->name('push-notifications.cleanup');
        Route::get('/push-notifications/stats', [App\Http\Controllers\Admin\PushNotificationController::class, 'getStats'])->name('push-notifications.stats');
    });
    
    // الملف الشخصي للمشرف
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile')->middleware('user.permission:profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update')->middleware('user.permission:profile');
    Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('profile.password.update')->middleware('user.permission:profile');
    
    // إعدادات المشرف
    Route::get('/admin-settings', [AdminController::class, 'adminSettings'])->name('admin-settings');
    Route::put('/admin-settings', [AdminController::class, 'updateAdminSettings'])->name('admin-settings.update');
});

// API Routes for Notifications
Route::prefix('api/notifications')->name('api.notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'getNotifications'])->name('index');
    Route::get('/stats', [NotificationController::class, 'getStats'])->name('stats');
    Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('mark-read');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    Route::post('/{id}/archive', [NotificationController::class, 'archive'])->name('archive');
    Route::post('/archive-read', [NotificationController::class, 'archiveRead'])->name('archive-read');
    Route::delete('/{id}', [NotificationController::class, 'delete'])->name('delete');
    Route::post('/subscribe', [NotificationController::class, 'subscribe'])->name('subscribe');
    Route::post('/unsubscribe', [NotificationController::class, 'unsubscribe'])->name('unsubscribe');
    Route::post('/test', [NotificationController::class, 'sendTestNotification'])->name('test');
    Route::post('/cleanup', [NotificationController::class, 'cleanup'])->name('cleanup');
});

// API Routes for Push Notifications
Route::prefix('api/push')->name('api.push.')->group(function () {
    Route::get('/vapid-key', function () {
        return response()->json([
            'public_key' => config('push.vapid.public_key')
        ]);
    })->name('vapid-key');
    
    Route::post('/subscribe', [App\Http\Controllers\Admin\PushNotificationController::class, 'subscribe'])->name('subscribe');
    Route::post('/unsubscribe', [App\Http\Controllers\Admin\PushNotificationController::class, 'unsubscribe'])->name('unsubscribe');
    Route::post('/test', [App\Http\Controllers\Admin\PushNotificationController::class, 'testNotification'])->name('test');
});

// Webhook للواتساب (بدون middleware)
Route::post('/webhook/whatsapp', [App\Http\Controllers\Admin\WhatsAppController::class, 'receiveMessage'])->name('whatsapp.webhook');

// 3D Model Routes
use App\Http\Controllers\ThreeDModelController;
Route::get('/3d-model', [ThreeDModelController::class, 'show'])->name('3d.model.viewer');
Route::get('/3d-model/obj', [ThreeDModelController::class, 'getObjFile'])->name('3d.model.obj');
Route::get('/3d-model/info', [ThreeDModelController::class, 'getModelInfo'])->name('3d.model.info');

// Mail Test Routes
Route::get('/mail-test', function () {
    return view('mail-test');
})->name('mail-test');
Route::prefix('mail-test')->name('mail-test.')->group(function () {
    Route::get('/settings', [MailTestController::class, 'testMailSettings'])->name('settings');
    Route::post('/send', [MailTestController::class, 'sendTestEmail'])->name('send');
    Route::post('/notification', [MailTestController::class, 'testNotificationEmail'])->name('notification');
    Route::post('/full-test', [MailTestController::class, 'runFullTest'])->name('full-test');
});

// Daily Report Routes
Route::get('/daily-report', function () {
    return view('daily-report');
})->name('daily-report');
Route::prefix('daily-report')->name('daily-report.')->group(function () {
    Route::get('/preview', function () {
        $dailyReportService = app(\App\Services\DailyReportService::class);
        $reportData = $dailyReportService->generateDailyReport();
        return view('emails.daily-report', compact('reportData'));
    })->name('preview');
    Route::post('/send', function (\Illuminate\Http\Request $request) {
        $email = $request->input('email', 'info@infinitywearsa.com');
        $date = $request->input('date');
        
        \Illuminate\Support\Facades\Artisan::call('report:daily', [
            '--email' => $email,
            '--date' => $date
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'تم إرسال التقرير بنجاح'
        ]);
    })->name('send');
});

// Test route for Services Cloudinary integration
Route::get('/test-services-cloudinary', function () {
    try {
        $cloudinaryService = app(\App\Services\CloudinaryService::class);
        
        $result = [
            'cloudinary_available' => $cloudinaryService->isAvailable(),
            'service_model_tests' => []
        ];
        
        // Test Service model image URL generation
        $service = new \App\Models\Service();
        
        // Test 1: Cloudinary format
        $cloudinaryImageData = [
            'cloudinary' => [
                'public_id' => 'infinitywearsa/services/test_image',
                'secure_url' => 'https://res.cloudinary.com/dhx24m770/image/upload/v1234567890/infinitywearsa/services/test_image.jpg',
                'url' => 'http://res.cloudinary.com/dhx24m770/image/upload/v1234567890/infinitywearsa/services/test_image.jpg',
                'format' => 'jpg',
                'width' => 800,
                'height' => 600,
                'bytes' => 125000,
            ],
            'file_path' => 'images/services/test_image_1234567890.jpg',
            'uploaded_at' => '2024-01-01T00:00:00.000000Z',
        ];
        
        $service->image = json_encode($cloudinaryImageData);
        $result['service_model_tests']['cloudinary_format'] = $service->image_url;
        
        // Test 2: Legacy format (storage path)
        $service->image = 'images/services/legacy_image.jpg';
        $result['service_model_tests']['legacy_storage_format'] = $service->image_url;
        
        // Test 3: Legacy format (public path)
        $service->image = 'images/sections/test_section.jpg';
        $result['service_model_tests']['legacy_public_format'] = $service->image_url;
        
        // Test 4: No image
        $service->image = null;
        $result['service_model_tests']['no_image'] = $service->image_url;
        
        return response()->json([
            'success' => true,
            'message' => 'Services Cloudinary integration test completed successfully',
            'results' => $result
        ]);
        
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error during testing: ' . $e->getMessage(),
            'error' => $e->getTraceAsString()
        ], 500);
    }
});

