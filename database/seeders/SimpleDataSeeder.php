<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use App\Models\Importer;
use App\Models\Order;
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

class SimpleDataSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء المدراء إذا لم تكن موجودة
        if (Admin::count() == 0) {
            Admin::create([
                'name' => 'أحمد محمد',
                'email' => 'admin@infinitywear.sa',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'is_active' => true,
            ]);
        }

        // إنشاء المستخدمين
        if (User::count() < 20) {
            $this->createUsers();
        }

        // إنشاء المستوردين
        if (Importer::count() < 10) {
            $this->createImporters();
        }

        // إنشاء الطلبات
        if (Order::count() < 20) {
            $this->createOrders();
        }

        // إنشاء طلبات المستوردين
        if (ImporterOrder::count() < 10) {
            $this->createImporterOrders();
        }

        // إنشاء المهام
        if (Task::count() < 20) {
            $this->createTasks();
        }

        // إنشاء المعاملات المالية
        if (Transaction::count() < 30) {
            $this->createTransactions();
        }

        // إنشاء فرق التسويق والمبيعات
        if (MarketingTeam::count() == 0) {
            $this->createTeams();
        }

        // إنشاء معرض الأعمال
        if (PortfolioItem::count() < 10) {
            $this->createPortfolio();
        }

        // إنشاء التقييمات
        if (Testimonial::count() < 10) {
            $this->createTestimonials();
        }

        // إنشاء محتوى الصفحة الرئيسية - تم حذفها

        // إنشاء خطط الشركة
        if (CompanyPlan::count() == 0) {
            $this->createCompanyPlans();
        }

        // إنشاء ملاحظات العملاء
        if (CustomerNote::count() < 10) {
            $this->createCustomerNotes();
        }

        // إنشاء رسائل الواتساب
        if (WhatsAppMessage::count() < 10) {
            $this->createWhatsAppMessages();
        }
    }

    private function createUsers()
    {
        $users = [];
        $cities = ['الرياض', 'جدة', 'مكة', 'المدينة', 'الدمام', 'الخبر', 'الظهران', 'الطائف', 'بريدة', 'تبوك'];
        
        for ($i = 1; $i <= 20; $i++) {
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
        $statuses = ['new', 'contacted', 'qualified', 'proposal', 'negotiation', 'closed_won', 'closed_lost'];
        $cities = ['الرياض', 'جدة', 'مكة', 'المدينة', 'الدمام', 'الخبر', 'الظهران', 'الطائف', 'بريدة', 'تبوك'];
        
        for ($i = 1; $i <= 10; $i++) {
            $importers[] = [
                'user_id' => null,
                'name' => 'مستورد ' . $i,
                'email' => 'importer' . $i . '@example.com',
                'phone' => '+9665' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'company_name' => 'شركة ' . $i . ' التجارية',
                'business_type' => $businessTypes[array_rand($businessTypes)],
                'business_type_other' => rand(0, 1) ? 'نشاط تجاري آخر' : null,
                'address' => 'شارع ' . $i . '، حي ' . rand(1, 20),
                'city' => $cities[array_rand($cities)],
                'country' => 'السعودية',
                'notes' => 'ملاحظات مهمة للمستورد رقم ' . $i,
                'status' => $statuses[array_rand($statuses)],
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
        
        if ($users->count() > 0) {
            for ($i = 1; $i <= 20; $i++) {
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
    }

    private function createImporterOrders()
    {
        $importerOrders = [];
        $statuses = ['new', 'processing', 'completed', 'cancelled'];
        $importers = Importer::all();
        $admins = Admin::all();
        
        if ($importers->count() > 0 && $admins->count() > 0) {
            for ($i = 1; $i <= 10; $i++) {
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
    }

    private function createTasks()
    {
        // إنشاء لوحات المهام
        if (TaskBoard::count() == 0) {
            $boards = [
                ['name' => 'مهام عامة', 'description' => 'المهام العامة للمشروع'],
                ['name' => 'مهام التسويق', 'description' => 'مهام فريق التسويق'],
                ['name' => 'مهام المبيعات', 'description' => 'مهام فريق المبيعات'],
            ];

            foreach ($boards as $board) {
                TaskBoard::create($board);
            }
        }

        $tasks = [];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        $statuses = ['pending', 'in_progress', 'completed', 'cancelled'];
        $departments = ['admin', 'marketing', 'sales'];
        $columns = ['todo', 'in_progress', 'review', 'done'];
        $importers = Importer::all();
        $admins = Admin::all();
        $boards = TaskBoard::all();

        if ($admins->count() > 0 && $boards->count() > 0) {
            for ($i = 1; $i <= 20; $i++) {
                $tasks[] = [
                    'title' => 'مهمة ' . $i,
                    'description' => 'وصف مفصل للمهمة رقم ' . $i . ' مع جميع التفاصيل المطلوبة',
                    'priority' => $priorities[array_rand($priorities)],
                    'status' => $statuses[array_rand($statuses)],
                    'due_date' => Carbon::now()->addDays(rand(-30, 60)),
                    'assigned_to' => $admins->random()->id,
                    'created_by' => $admins->random()->id,
                    'importer_id' => $importers->count() > 0 && rand(0, 1) ? $importers->random()->id : null,
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

        if ($admins->count() > 0) {
            for ($i = 1; $i <= 30; $i++) {
                $type = $types[array_rand($types)];
                $category = $type === 'income' ? $incomeCategories[array_rand($incomeCategories)] : $expenseCategories[array_rand($expenseCategories)];
                $amount = rand(50, 10000);
                
                $transactions[] = [
                    'type' => $type,
                    'category' => $category,
                    'amount' => $amount,
                    'description' => 'معاملة ' . $type . ' رقم ' . $i . ' - ' . $category,
                    'reference_id' => $type === 'income' && $orders->count() > 0 && rand(0, 1) ? $orders->random()->id : null,
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
    }

    private function createTeams()
    {
        $admins = Admin::all();
        
        if ($admins->count() > 0) {
            // فريق التسويق
            MarketingTeam::create([
                'admin_id' => $admins->first()->id,
                'department' => 'التسويق الرقمي',
                'position' => 'مدير التسويق الرقمي',
                'bio' => 'فريق متخصص في التسويق الرقمي والإعلانات',
                'phone' => '+966501234567',
                'avatar' => '/images/avatars/marketing1.jpg',
                'is_active' => true,
            ]);

            // فريق المبيعات
            SalesTeam::create([
                'admin_id' => $admins->first()->id,
                'position' => 'مدير المبيعات المحلية',
                'region' => 'الرياض',
                'target' => 100000,
                'achieved' => 85000,
                'phone' => '+966501234567',
                'avatar' => '/images/avatars/sales1.jpg',
                'is_active' => true,
            ]);
        }
    }

    private function createPortfolio()
    {
        $portfolioItems = [];
        $categories = ['أزياء مدرسية', 'أزياء طبية', 'أزياء رياضية', 'أزياء شركات', 'أزياء موحدة'];

        for ($i = 1; $i <= 10; $i++) {
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

        for ($i = 1; $i <= 10; $i++) {
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
                'name' => 'من نحن',
                'title' => 'من نحن',
                'subtitle' => 'شركة رائدة في مجال الأزياء الموحدة',
                'description' => 'نحن شركة متخصصة في تصميم وتصنيع الأزياء الموحدة للشركات والمؤسسات',
                'section_type' => 'about',
                'layout_type' => 'container',
                'background_color' => '#f8f9fa',
                'background_image' => '/images/sections/about.jpg',
                'text_color' => '#333333',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'خدماتنا',
                'title' => 'خدماتنا',
                'subtitle' => 'خدمات شاملة ومتنوعة',
                'description' => 'نقدم مجموعة واسعة من الخدمات في مجال الأزياء الموحدة',
                'section_type' => 'services',
                'layout_type' => 'grid_3',
                'background_color' => '#ffffff',
                'background_image' => '/images/sections/services.jpg',
                'text_color' => '#333333',
                'sort_order' => 2,
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
                    'subtitle' => 'عنوان فرعي ' . $i,
                    'description' => 'محتوى مفصل للقسم ' . $i,
                    'content_type' => 'card',
                    'image' => '/images/sections/content' . $i . '.jpg',
                    'button_text' => 'اقرأ المزيد',
                    'button_link' => '/services',
                    'button_style' => 'primary',
                    'sort_order' => $i,
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
                'image' => '/images/slider/slider1.jpg',
                'button_text' => 'اكتشف المزيد',
                'button_link' => '/services',
                'text_color' => '#ffffff',
                'overlay_opacity' => 0.5,
                'animation_type' => 'fade',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'جودة لا تضاهى',
                'subtitle' => 'أفضل المواد والخامات',
                'description' => 'نستخدم أفضل المواد والخامات لضمان الجودة العالية',
                'image' => '/images/slider/slider2.jpg',
                'button_text' => 'شاهد أعمالنا',
                'button_link' => '/portfolio',
                'text_color' => '#ffffff',
                'overlay_opacity' => 0.5,
                'animation_type' => 'slide',
                'sort_order' => 2,
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

        if ($users->count() > 0 && $admins->count() > 0) {
            for ($i = 1; $i <= 10; $i++) {
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
    }

    private function createWhatsAppMessages()
    {
        $messages = [];
        $phoneNumbers = ['+966501234567', '+966502345678', '+966503456789', '+966504567890', '+966505678901'];
        $types = ['incoming', 'outgoing'];
        $statuses = ['sent', 'delivered', 'read', 'failed'];

        for ($i = 1; $i <= 10; $i++) {
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
