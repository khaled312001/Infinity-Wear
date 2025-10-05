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
use Illuminate\Support\Facades\Log;


// Test settings page
Route::get('/test-settings', function () {
    return view('test-settings');
})->name('test-settings');

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

Route::get('/sales/dashboard', function () {
    return view('demo.sales-dashboard');
})->name('sales.demo');

Route::get('/marketing/dashboard', function () {
    return view('demo.marketing-dashboard');
})->name('marketing.demo');

// الصفحة الرئيسية الجديدة
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// صفحة من نحن
Route::get('/about', function () {
    return view('about');
})->name('about');

// صفحة الخدمات
    Route::get('/services', [ServicesController::class, 'index'])->name('services');
    
    // Admin Services Management
    Route::get('/admin/services', [ServicesController::class, 'adminIndex'])->name('admin.services.index');
    Route::get('/admin/services/{service}/edit', [ServicesController::class, 'edit'])->name('admin.services.edit');
    Route::post('/admin/services', [ServicesController::class, 'store'])->name('admin.services.store');
    Route::put('/admin/services/{service}', [ServicesController::class, 'update'])->name('admin.services.update');
    Route::delete('/admin/services/{service}', [ServicesController::class, 'destroy'])->name('admin.services.destroy');
    Route::patch('/admin/services/{service}/toggle-status', [ServicesController::class, 'toggleStatus'])->name('admin.services.toggle-status');
    Route::post('/admin/services/activate-all', [ServicesController::class, 'activateAll'])->name('admin.services.activate-all');
    Route::post('/admin/services/update-order', [ServicesController::class, 'updateOrder'])->name('admin.services.update-order');

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
                'phone' => '+966 50 123 4567',
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

    // إرسال رسالة التواصل
    Route::post('/contact', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        // حفظ الرسالة في قاعدة البيانات
        try {
            $contact = \App\Models\Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'company' => $validated['company'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'status' => 'new',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // إنشاء إشعار للمدير
            $notificationService = app(\App\Services\NotificationService::class);
            $notificationService->createContactNotification($contact);

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.',
                'data' => [
                    'id' => $contact->id,
                    'timestamp' => now()->toISOString()
                ]
            ], 201);
        } catch (\Exception $e) {
            Log::error('Contact form submission error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة مرة أخرى.',
                'error' => 'Database error'
            ], 500);
        }
    })->name('api.contact');

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
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
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

// AI API endpoints for importer form
Route::post('/api/ai/design-assistance', [ImporterController::class, 'aiDesignAssistance'])->name('api.ai.design-assistance');
Route::post('/api/ai/analyze-requirements', [ImporterController::class, 'analyzeDesignRequirements'])->name('api.ai.analyze-requirements');
Route::post('/api/ai/generate-design', [ImporterController::class, 'generateDesign'])->name('api.ai.generate-design');

// لوحة تحكم المستوردين
Route::middleware(['auth', 'user.type:importer'])->prefix('importers')->name('importers.')->group(function () {
    Route::get('/dashboard', [ImporterController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [ImporterController::class, 'orders'])->name('orders');
    Route::get('/profile', [ImporterController::class, 'profile'])->name('profile');
    Route::put('/profile', [ImporterController::class, 'updateProfile'])->name('profile.update');
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
    Route::get('/tasks', [App\Http\Controllers\Marketing\DashboardController::class, 'tasks'])->name('tasks');
    Route::put('/tasks/{task}/status', [App\Http\Controllers\Marketing\DashboardController::class, 'updateTaskStatus'])->name('tasks.update-status');
    Route::get('/contacts', [App\Http\Controllers\Marketing\DashboardController::class, 'contacts'])->name('contacts');
    Route::get('/contacts/{contact}', [App\Http\Controllers\Marketing\DashboardController::class, 'showContact'])->name('contacts.show');
    Route::put('/contacts/{contact}', [App\Http\Controllers\Marketing\DashboardController::class, 'updateContact'])->name('contacts.update');
    Route::patch('/contacts/{contact}/mark-read', [App\Http\Controllers\Marketing\DashboardController::class, 'markContactAsRead'])->name('contacts.mark-read');
    Route::patch('/contacts/{contact}/mark-replied', [App\Http\Controllers\Marketing\DashboardController::class, 'markContactAsReplied'])->name('contacts.mark-replied');
    Route::patch('/contacts/{contact}/mark-closed', [App\Http\Controllers\Marketing\DashboardController::class, 'markContactAsClosed'])->name('contacts.mark-closed');
    Route::get('/profile', [App\Http\Controllers\Marketing\DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Marketing\DashboardController::class, 'updateProfile'])->name('profile.update');
});

// لوحة تحكم فريق المبيعات
Route::middleware(['auth', 'user.type:sales'])->prefix('sales')->name('sales.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Sales\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [App\Http\Controllers\Sales\DashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [App\Http\Controllers\Sales\DashboardController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{order}/status', [App\Http\Controllers\Sales\DashboardController::class, 'updateOrderStatus'])->name('orders.update-status');
    Route::get('/importer-orders', [App\Http\Controllers\Sales\DashboardController::class, 'importerOrders'])->name('importer-orders');
    Route::get('/importer-orders/{order}', [App\Http\Controllers\Sales\DashboardController::class, 'showImporterOrder'])->name('importer-orders.show');
    Route::put('/importer-orders/{order}/status', [App\Http\Controllers\Sales\DashboardController::class, 'updateImporterOrderStatus'])->name('importer-orders.update-status');
    Route::get('/importers', [App\Http\Controllers\Sales\DashboardController::class, 'importers'])->name('importers');
    Route::get('/importers/{importer}', [App\Http\Controllers\Sales\DashboardController::class, 'showImporter'])->name('importers.show');
    Route::put('/importers/{importer}/status', [App\Http\Controllers\Sales\DashboardController::class, 'updateImporterStatus'])->name('importers.update-status');
    Route::get('/tasks', [App\Http\Controllers\Sales\DashboardController::class, 'tasks'])->name('tasks');
    Route::put('/tasks/{task}/status', [App\Http\Controllers\Sales\DashboardController::class, 'updateTaskStatus'])->name('tasks.update-status');
    Route::get('/contacts', [App\Http\Controllers\Sales\DashboardController::class, 'contacts'])->name('contacts');
    Route::get('/contacts/{id}', [App\Http\Controllers\Sales\DashboardController::class, 'showContact'])->name('contacts.show');
    Route::put('/contacts/{id}', [App\Http\Controllers\Sales\DashboardController::class, 'updateContact'])->name('contacts.update');
    Route::get('/reports', [App\Http\Controllers\Sales\DashboardController::class, 'reports'])->name('reports');
    Route::get('/profile', [App\Http\Controllers\Sales\DashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Sales\DashboardController::class, 'updateProfile'])->name('profile.update');
});



// لوحة التحكم الإدارية
Route::prefix('admin')->middleware(['admin.auth'])->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/employees', [App\Http\Controllers\Admin\DashboardController::class, 'employees'])->name('employees');
    Route::get('/tasks', [App\Http\Controllers\Admin\DashboardController::class, 'tasks'])->name('tasks');
    Route::get('/reports', [App\Http\Controllers\Admin\DashboardController::class, 'reports'])->name('reports');
    Route::get('/settings', [App\Http\Controllers\Admin\DashboardController::class, 'settings'])->name('settings');
    Route::get('/api/dashboard-stats', [AdminController::class, 'getDashboardStats'])->name('api.dashboard-stats');
    
    // إدارة المحتوى الشاملة
    Route::resource('content-management', App\Http\Controllers\Admin\ContentManagementController::class);
    Route::patch('content-management/{contentManagement}/toggle-status', [App\Http\Controllers\Admin\ContentManagementController::class, 'toggleStatus'])->name('content-management.toggle-status');
    
    // إدارة المحتوى التقليدية - تم حذفها
    
    // إدارة أقسام الصفحة الرئيسية - تم حذفها
    
    // إدارة المشرفين
    Route::get('/admins', [AdminController::class, 'admins'])->name('admins.index');
    Route::get('/admins/create', [AdminController::class, 'createAdmin'])->name('admins.create');
    Route::post('/admins', [AdminController::class, 'storeAdmin'])->name('admins.store');
    Route::get('/admins/{admin}', [AdminController::class, 'showAdmin'])->name('admins.show');
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
    Route::get('/importers-orders', [AdminController::class, 'importersOrders'])->name('importers.orders');
    Route::get('/orders', [AdminController::class, 'ordersIndex'])->name('orders.index');
    Route::put('/orders/{id}/status', [AdminController::class, 'ordersUpdateStatus'])->name('orders.updateStatus');
    
    // النظام المالي
    Route::prefix('finance')->name('finance.')->group(function () {
        Route::get('/', [FinanceController::class, 'dashboard'])->name('dashboard');
        Route::get('/index', [FinanceController::class, 'dashboard'])->name('index');
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
    
    // التقييمات
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
    
    // إدارة رسائل التواصل
    Route::resource('contacts', App\Http\Controllers\Admin\ContactController::class);
    Route::patch('contacts/{contact}/mark-read', [App\Http\Controllers\Admin\ContactController::class, 'markAsRead'])->name('contacts.mark-read');
    Route::patch('contacts/{contact}/mark-replied', [App\Http\Controllers\Admin\ContactController::class, 'markAsReplied'])->name('contacts.mark-replied');
    Route::patch('contacts/{contact}/mark-closed', [App\Http\Controllers\Admin\ContactController::class, 'markAsClosed'])->name('contacts.mark-closed');
    
    // الإعدادات
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    
    // إدارة الإشعارات
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('index');
        Route::get('/unread', [App\Http\Controllers\Admin\NotificationController::class, 'getUnreadNotifications'])->name('unread');
        Route::get('/stats', [App\Http\Controllers\Admin\NotificationController::class, 'getNotificationStats'])->name('stats');
        Route::get('/{notification}/preview', [App\Http\Controllers\Admin\NotificationController::class, 'preview'])->name('preview');
        Route::post('/mark-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::post('/archive', [App\Http\Controllers\Admin\NotificationController::class, 'archiveNotification'])->name('archive');
    });
    
    // الملف الشخصي للمشرف
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('profile.password.update');
    
    // إعدادات المشرف
    Route::get('/admin-settings', [AdminController::class, 'adminSettings'])->name('admin-settings');
    Route::put('/admin-settings', [AdminController::class, 'updateAdminSettings'])->name('admin-settings.update');
});

// Webhook للواتساب (بدون middleware)
Route::post('/webhook/whatsapp', [App\Http\Controllers\Admin\WhatsAppController::class, 'receiveMessage'])->name('whatsapp.webhook');
