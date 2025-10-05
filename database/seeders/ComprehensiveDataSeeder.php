<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use App\Models\Importer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ImporterOrder;
use App\Models\Task;
use App\Models\TaskBoard;
use App\Models\Transaction;
use App\Models\MarketingTeam;
use App\Models\SalesTeam;
use App\Models\PortfolioItem;
use App\Models\Testimonial;
use App\Models\HomeSection;
use App\Models\SectionContent;
use App\Models\CompanyPlan;
use App\Models\CustomerNote;
use App\Models\WhatsAppMessage;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ComprehensiveDataSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء المدراء
        $this->createAdmins();
        
        // إنشاء المستخدمين
        $this->createUsers();
        
        // إنشاء المستوردين
        $this->createImporters();
        
        // إنشاء الطلبات
        $this->createOrders();
        
        // إنشاء طلبات المستوردين
        $this->createImporterOrders();
        
        // إنشاء المهام
        $this->createTasks();
        
        // إنشاء المعاملات المالية
        $this->createTransactions();
        
        // إنشاء فرق التسويق والمبيعات
        $this->createTeams();
        
        // إنشاء معرض الأعمال
        $this->createPortfolio();
        
        // إنشاء التقييمات
        $this->createTestimonials();
        
        // إنشاء محتوى الصفحة الرئيسية
        $this->createHomeContent();
        
        // إنشاء خطط الشركة
        $this->createCompanyPlans();
        
        // إنشاء ملاحظات العملاء
        $this->createCustomerNotes();
        
        // إنشاء رسائل الواتساب
        $this->createWhatsAppMessages();
    }

    private function createAdmins()
    {
        $admins = [
            [
                'name' => 'أحمد محمد',
                'email' => 'admin@infinitywear.sa',
                'password' => Hash::make('password123'),
                'phone' => '+966501234567',
                'bio' => 'مدير عام لشركة Infinity Wear',
                'is_active' => true,
            ],
            [
                'name' => 'فاطمة أحمد',
                'email' => 'manager@infinitywear.sa',
                'password' => Hash::make('password123'),
                'phone' => '+966502345678',
                'bio' => 'مديرة المشاريع والتطوير',
                'is_active' => true,
            ],
            [
                'name' => 'محمد علي',
                'email' => 'sales@infinitywear.sa',
                'password' => Hash::make('password123'),
                'phone' => '+966503456789',
                'bio' => 'مدير قسم المبيعات والتسويق',
                'is_active' => true,
            ],
        ];

        foreach ($admins as $admin) {
            $existingAdmin = Admin::where('email', $admin['email'])->first();
            if (!$existingAdmin) {
                Admin::create($admin);
            }
        }
    }

    private function createUsers()
    {
        $users = [];
        $cities = ['الرياض', 'جدة', 'مكة', 'المدينة', 'الدمام', 'الخبر', 'الظهران', 'الطائف', 'بريدة', 'تبوك'];
        
        for ($i = 1; $i <= 50; $i++) {
            $users[] = [
                'name' => 'عميل ' . $i,
                'email' => 'customer' . $i . '@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+9665' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'address' => 'شارع ' . $i . '، حي ' . rand(1, 20),
                'city' => $cities[array_rand($cities)],
                'user_type' => 'importer',
                'created_at' => Carbon::now()->subDays(rand(1, 365)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30)),
            ];
        }

        User::insert($users);
    }

    private function createImporters()
    {
        $importers = [];
        $businessTypes = ['academy', 'school', 'store', 'hospital', 'other'];
        $experienceLevels = ['beginner', 'intermediate', 'advanced'];
        $expectedVolumes = ['small', 'medium', 'large'];
        $designPreferences = ['classic', 'modern', 'custom'];
        $budgetRanges = ['low', 'medium', 'high'];
        $cities = ['الرياض', 'جدة', 'مكة', 'المدينة', 'الدمام', 'الخبر', 'الظهران', 'الطائف', 'بريدة', 'تبوك'];

        for ($i = 1; $i <= 30; $i++) {
            $importers[] = [
                'name' => 'مستورد ' . $i,
                'email' => 'importer' . $i . '@example.com',
                'phone' => '+9665' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'company_name' => 'شركة ' . $i . ' التجارية',
                'address' => 'شارع ' . $i . '، حي ' . rand(1, 20),
                'city' => $cities[array_rand($cities)],
                'business_type' => $businessTypes[array_rand($businessTypes)],
                'experience_level' => $experienceLevels[array_rand($experienceLevels)],
                'expected_volume' => $expectedVolumes[array_rand($expectedVolumes)],
                'design_preference' => $designPreferences[array_rand($designPreferences)],
                'budget_range' => $budgetRanges[array_rand($budgetRanges)],
                'additional_info' => 'معلومات إضافية للمستورد رقم ' . $i,
                'status' => ['pending', 'approved', 'rejected'][array_rand(['pending', 'approved', 'rejected'])],
                'created_at' => Carbon::now()->subDays(rand(1, 200)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30)),
            ];
        }

        Importer::insert($importers);
    }

    private function createOrders()
    {
        $orders = [];
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $users = User::all();
        
        for ($i = 1; $i <= 100; $i++) {
            $user = $users->random();
            $subtotal = rand(100, 5000);
            $tax = $subtotal * 0.15;
            $shipping = rand(20, 100);
            $total = $subtotal + $tax + $shipping;
            
            $orders[] = [
                'user_id' => $user->id,
                'order_number' => 'ORD-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'status' => $statuses[array_rand($statuses)],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone,
                'shipping_address' => $user->address . '، ' . $user->city,
                'notes' => rand(0, 1) ? 'ملاحظات خاصة للطلب رقم ' . $i : null,
                'created_at' => Carbon::now()->subDays(rand(1, 180)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30)),
            ];
        }

        Order::insert($orders);
    }

    private function createImporterOrders()
    {
        $importerOrders = [];
        $statuses = ['new', 'processing', 'completed', 'cancelled'];
        $importers = Importer::all();
        $admins = Admin::all();
        
        for ($i = 1; $i <= 50; $i++) {
            $importer = $importers->random();
            $estimatedCost = rand(1000, 50000);
            $finalCost = $estimatedCost + rand(-5000, 10000);
            
            $importerOrders[] = [
                'importer_id' => $importer->id,
                'order_number' => 'IMP-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'status' => $statuses[array_rand($statuses)],
                'requirements' => 'متطلبات خاصة للطلب رقم ' . $i,
                'quantity' => rand(10, 1000),
                'design_details' => json_encode([
                    'colors' => ['أحمر', 'أزرق', 'أخضر'],
                    'sizes' => ['S', 'M', 'L', 'XL'],
                    'materials' => ['قطن', 'بوليستر']
                ]),
                'estimated_cost' => $estimatedCost,
                'final_cost' => $finalCost,
                'delivery_date' => Carbon::now()->addDays(rand(7, 60)),
                'notes' => 'ملاحظات مهمة للطلب رقم ' . $i,
                'assigned_to' => $admins->random()->id,
                'created_at' => Carbon::now()->subDays(rand(1, 150)),
                'updated_at' => Carbon::now()->subDays(rand(1, 20)),
            ];
        }

        ImporterOrder::insert($importerOrders);
    }

    private function createTasks()
    {
        // إنشاء لوحات المهام
        $boards = [
            ['name' => 'مهام عامة', 'description' => 'المهام العامة للمشروع'],
            ['name' => 'مهام التسويق', 'description' => 'مهام فريق التسويق'],
            ['name' => 'مهام المبيعات', 'description' => 'مهام فريق المبيعات'],
        ];

        foreach ($boards as $board) {
            TaskBoard::create($board);
        }

        $tasks = [];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        $statuses = ['pending', 'in_progress', 'completed', 'cancelled'];
        $departments = ['admin', 'marketing', 'sales'];
        $columns = ['todo', 'in_progress', 'review', 'done'];
        $importers = Importer::all();
        $admins = Admin::all();
        $boards = TaskBoard::all();

        for ($i = 1; $i <= 80; $i++) {
            $tasks[] = [
                'title' => 'مهمة ' . $i,
                'description' => 'وصف مفصل للمهمة رقم ' . $i . ' مع جميع التفاصيل المطلوبة',
                'priority' => $priorities[array_rand($priorities)],
                'status' => $statuses[array_rand($statuses)],
                'due_date' => Carbon::now()->addDays(rand(-30, 60)),
                'assigned_to' => $admins->random()->id,
                'created_by' => $admins->random()->id,
                'importer_id' => rand(0, 1) ? $importers->random()->id : null,
                'department' => $departments[array_rand($departments)],
                'board_id' => $boards->random()->id,
                'column_status' => $columns[array_rand($columns)],
                'position' => $i,
                'labels' => json_encode(['مهم', 'عاجل', 'متابعة']),
                'attachments' => json_encode([]),
                'checklist' => json_encode([
                    ['id' => 1, 'text' => 'الخطوة الأولى', 'completed' => rand(0, 1)],
                    ['id' => 2, 'text' => 'الخطوة الثانية', 'completed' => rand(0, 1)],
                ]),
                'estimated_hours' => rand(1, 40),
                'actual_hours' => rand(0, 50),
                'started_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 30)) : null,
                'completed_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 10)) : null,
                'time_logs' => json_encode([]),
                'comments' => json_encode([]),
                'color' => '#3b82f6',
                'is_archived' => rand(0, 1),
                'created_at' => Carbon::now()->subDays(rand(1, 120)),
                'updated_at' => Carbon::now()->subDays(rand(1, 15)),
            ];
        }

        Task::insert($tasks);
    }

    private function createTransactions()
    {
        $transactions = [];
        $types = ['income', 'expense'];
        $incomeCategories = ['orders', 'custom_designs', 'consultation', 'rush_orders', 'bulk_discount', 'other'];
        $expenseCategories = ['materials', 'manufacturing', 'shipping', 'marketing', 'salaries', 'rent', 'utilities', 'equipment', 'maintenance', 'insurance', 'taxes', 'other'];
        $paymentMethods = ['cash', 'bank_transfer', 'credit_card', 'mada', 'stc_pay', 'paypal', 'other'];
        $statuses = ['pending', 'completed', 'cancelled'];
        $admins = Admin::all();
        $orders = Order::all();

        for ($i = 1; $i <= 200; $i++) {
            $type = $types[array_rand($types)];
            $category = $type === 'income' ? $incomeCategories[array_rand($incomeCategories)] : $expenseCategories[array_rand($expenseCategories)];
            $amount = rand(50, 10000);
            
            $transactions[] = [
                'type' => $type,
                'category' => $category,
                'amount' => $amount,
                'description' => 'معاملة ' . $type . ' رقم ' . $i . ' - ' . $category,
                'reference_id' => $type === 'income' && rand(0, 1) ? $orders->random()->id : null,
                'reference_type' => $type === 'income' && rand(0, 1) ? 'order' : 'general',
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'transaction_date' => Carbon::now()->subDays(rand(1, 365)),
                'status' => $statuses[array_rand($statuses)],
                'created_by' => $admins->random()->id,
                'notes' => rand(0, 1) ? 'ملاحظات إضافية للمعاملة رقم ' . $i : null,
                'created_at' => Carbon::now()->subDays(rand(1, 365)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30)),
            ];
        }

        Transaction::insert($transactions);
    }

    private function createTeams()
    {
        // فريق التسويق
        $marketingTeam = [
            [
                'admin_id' => Admin::first()->id,
                'department' => 'التسويق الرقمي',
                'position' => 'مدير التسويق الرقمي',
                'bio' => 'فريق متخصص في التسويق الرقمي والإعلانات',
                'phone' => '+966501234567',
                'avatar' => '/images/avatars/marketing1.jpg',
                'is_active' => true,
            ],
            [
                'admin_id' => Admin::skip(1)->first()->id,
                'department' => 'التسويق التقليدي',
                'position' => 'مدير التسويق التقليدي',
                'bio' => 'فريق متخصص في التسويق التقليدي والمعارض',
                'phone' => '+966502345678',
                'avatar' => '/images/avatars/marketing2.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($marketingTeam as $member) {
            MarketingTeam::create($member);
        }

        // فريق المبيعات
        $salesTeam = [
            [
                'admin_id' => Admin::first()->id,
                'position' => 'مدير المبيعات المحلية',
                'region' => 'الرياض',
                'target' => 100000,
                'achieved' => 85000,
                'phone' => '+966501234567',
                'avatar' => '/images/avatars/sales1.jpg',
                'is_active' => true,
            ],
            [
                'admin_id' => Admin::skip(1)->first()->id,
                'position' => 'مدير المبيعات الدولية',
                'region' => 'الخليج',
                'target' => 200000,
                'achieved' => 180000,
                'phone' => '+966502345678',
                'avatar' => '/images/avatars/sales2.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($salesTeam as $member) {
            SalesTeam::create($member);
        }
    }

    private function createPortfolio()
    {
        $portfolioItems = [];
        $categories = ['أزياء مدرسية', 'أزياء طبية', 'أزياء رياضية', 'أزياء شركات', 'أزياء موحدة'];

        for ($i = 1; $i <= 20; $i++) {
            $portfolioItems[] = [
                'title' => 'مشروع ' . $i,
                'description' => 'وصف مفصل للمشروع رقم ' . $i . ' مع جميع التفاصيل',
                'image' => '/images/portfolio/project' . $i . '.jpg',
                'gallery' => json_encode(['/images/portfolio/project' . $i . '_1.jpg', '/images/portfolio/project' . $i . '_2.jpg']),
                'client_name' => 'عميل ' . $i,
                'completion_date' => Carbon::now()->subDays(rand(1, 365)),
                'category' => $categories[array_rand($categories)],
                'is_featured' => rand(0, 1),
                'sort_order' => $i,
                'created_at' => Carbon::now()->subDays(rand(1, 200)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30)),
            ];
        }

        PortfolioItem::insert($portfolioItems);
    }

    private function createTestimonials()
    {
        $testimonials = [];
        $names = ['أحمد محمد', 'فاطمة أحمد', 'محمد علي', 'نورا سعد', 'خالد عبدالله', 'مريم حسن', 'عبدالرحمن يوسف', 'هند محمد'];

        for ($i = 1; $i <= 15; $i++) {
            $testimonials[] = [
                'client_name' => $names[array_rand($names)],
                'client_position' => 'مدير ' . $i,
                'client_company' => 'شركة ' . $i,
                'content' => 'تجربة رائعة مع شركة Infinity Wear. الخدمة ممتازة والجودة عالية. أنصح الجميع بالتعامل معهم.',
                'rating' => rand(4, 5),
                'image' => '/images/testimonials/client' . $i . '.jpg',
                'is_active' => true,
                'sort_order' => $i,
                'created_at' => Carbon::now()->subDays(rand(1, 100)),
                'updated_at' => Carbon::now()->subDays(rand(1, 20)),
            ];
        }

        Testimonial::insert($testimonials);
    }

    private function createHomeContent()
    {
        // إنشاء أقسام الصفحة الرئيسية
        $sections = [
            [
                'title' => 'من نحن',
                'subtitle' => 'شركة رائدة في مجال الأزياء الموحدة',
                'content' => 'نحن شركة متخصصة في تصميم وتصنيع الأزياء الموحدة للشركات والمؤسسات',
                'image_url' => '/images/sections/about.jpg',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'خدماتنا',
                'subtitle' => 'خدمات شاملة ومتنوعة',
                'content' => 'نقدم مجموعة واسعة من الخدمات في مجال الأزياء الموحدة',
                'image_url' => '/images/sections/services.jpg',
                'order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            HomeSection::create($section);
        }

        // إنشاء محتوى الأقسام
        $sections = HomeSection::all();
        foreach ($sections as $section) {
            for ($i = 1; $i <= 3; $i++) {
                SectionContent::create([
                    'home_section_id' => $section->id,
                    'title' => 'عنوان ' . $i,
                    'content' => 'محتوى مفصل للقسم ' . $i,
                    'image_url' => '/images/sections/content' . $i . '.jpg',
                    'order' => $i,
                    'is_active' => true,
                ]);
            }
        }

        // إنشاء شريط التمرير
        $sliders = [
            [
                'title' => 'مرحباً بكم في Infinity Wear',
                'subtitle' => 'أزياء موحدة بجودة عالية',
                'description' => 'نحن نقدم أفضل الأزياء الموحدة للشركات والمؤسسات',
                'image_url' => '/images/slider/slider1.jpg',
                'button_text' => 'اكتشف المزيد',
                'button_url' => '/services',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'جودة لا تضاهى',
                'subtitle' => 'أفضل المواد والخامات',
                'description' => 'نستخدم أفضل المواد والخامات لضمان الجودة العالية',
                'image_url' => '/images/slider/slider2.jpg',
                'button_text' => 'شاهد أعمالنا',
                'button_url' => '/portfolio',
                'order' => 2,
                'is_active' => true,
            ],
        ];

        // Hero sliders seeding removed
    }

    private function createCompanyPlans()
    {
        $plans = [
            [
                'name' => 'الخطة الأساسية',
                'description' => 'خطة مناسبة للشركات الصغيرة',
                'price' => 5000,
                'duration_months' => 12,
                'features' => json_encode(['تصميم أساسي', 'طباعة عادية', 'خدمة عملاء']),
                'is_active' => true,
            ],
            [
                'name' => 'الخطة المتقدمة',
                'description' => 'خطة شاملة للشركات المتوسطة',
                'price' => 10000,
                'duration_months' => 12,
                'features' => json_encode(['تصميم متقدم', 'طباعة عالية الجودة', 'خدمة عملاء متميزة', 'توصيل مجاني']),
                'is_active' => true,
            ],
            [
                'name' => 'الخطة المميزة',
                'description' => 'خطة شاملة للشركات الكبيرة',
                'price' => 20000,
                'duration_months' => 12,
                'features' => json_encode(['تصميم مخصص', 'طباعة فاخرة', 'خدمة عملاء 24/7', 'توصيل مجاني', 'ضمان الجودة']),
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            CompanyPlan::create($plan);
        }
    }

    private function createCustomerNotes()
    {
        $notes = [];
        $users = User::all();
        $admins = Admin::all();

        for ($i = 1; $i <= 30; $i++) {
            $notes[] = [
                'user_id' => $users->random()->id,
                'admin_id' => $admins->random()->id,
                'note' => 'ملاحظة مهمة للعميل رقم ' . $i . ' - يفضل التواصل في المساء',
                'type' => ['general', 'complaint', 'suggestion', 'compliment'][array_rand(['general', 'complaint', 'suggestion', 'compliment'])],
                'is_archived' => rand(0, 1),
                'created_at' => Carbon::now()->subDays(rand(1, 60)),
                'updated_at' => Carbon::now()->subDays(rand(1, 10)),
            ];
        }

        CustomerNote::insert($notes);
    }

    private function createWhatsAppMessages()
    {
        $messages = [];
        $phoneNumbers = ['+966501234567', '+966502345678', '+966503456789', '+966504567890', '+966505678901'];
        $types = ['incoming', 'outgoing'];
        $statuses = ['sent', 'delivered', 'read', 'failed'];

        for ($i = 1; $i <= 50; $i++) {
            $messages[] = [
                'phone_number' => $phoneNumbers[array_rand($phoneNumbers)],
                'message' => 'رسالة واتساب رقم ' . $i . ' - مرحباً، كيف يمكنني مساعدتك؟',
                'type' => $types[array_rand($types)],
                'status' => $statuses[array_rand($statuses)],
                'sent_at' => Carbon::now()->subDays(rand(1, 30)),
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->subDays(rand(1, 5)),
            ];
        }

        WhatsAppMessage::insert($messages);
    }
}
