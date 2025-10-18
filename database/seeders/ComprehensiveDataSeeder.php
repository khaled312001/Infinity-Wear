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
        $cities = ['الرياض', 'جدة', 'مكة', 'المدينة', 'الدمام', 'الخبر', 'الظهران', 'الطائف', 'بريدة', 'تبوك'];
        $statuses = ['new', 'contacted', 'qualified', 'proposal', 'negotiation', 'closed_won', 'closed_lost'];

        for ($i = 1; $i <= 30; $i++) {
            $importers[] = [
                'name' => 'مستورد ' . $i,
                'email' => 'importer' . $i . '@example.com',
                'phone' => '+9665' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'company_name' => 'شركة ' . $i . ' التجارية',
                'address' => 'شارع ' . $i . '، حي ' . rand(1, 20),
                'city' => $cities[array_rand($cities)],
                'business_type' => $businessTypes[array_rand($businessTypes)],
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
                'target' => 100000.00,
                'achieved' => 85000.00,
                'phone' => '+966501234567',
                'avatar' => '/images/avatars/sales1.jpg',
                'is_active' => true,
            ],
            [
                'admin_id' => Admin::skip(1)->first()->id,
                'position' => 'مدير المبيعات الدولية',
                'region' => 'الخليج',
                'target' => 200000.00,
                'achieved' => 180000.00,
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
                'name' => 'من نحن',
                'title' => 'من نحن',
                'subtitle' => 'شركة رائدة في مجال الأزياء الموحدة',
                'description' => 'نحن شركة متخصصة في تصميم وتصنيع الأزياء الموحدة للشركات والمؤسسات',
                'section_type' => 'about',
                'layout_type' => 'container',
                'background_color' => '#f8f9fa',
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
                    'button_link' => '/details/' . $i,
                    'button_style' => 'primary',
                    'sort_order' => $i,
                    'is_active' => true,
                ]);
            }
        }
    }

    private function createCompanyPlans()
    {
        $plans = [
            [
                'title' => 'الخطة الأساسية',
                'description' => 'خطة مناسبة للشركات الصغيرة',
                'type' => 'annual',
                'status' => 'active',
                'start_date' => Carbon::now()->subMonths(6),
                'end_date' => Carbon::now()->addMonths(6),
                'objectives' => json_encode(['زيادة المبيعات', 'تحسين الجودة', 'توسيع السوق']),
                'strengths' => json_encode(['فريق متميز', 'جودة عالية', 'أسعار مناسبة']),
                'weaknesses' => json_encode(['محدودية التسويق', 'قلة الموارد']),
                'opportunities' => json_encode(['سوق متنامي', 'طلب متزايد']),
                'threats' => json_encode(['منافسة شديدة', 'تغيرات اقتصادية']),
                'strategies' => json_encode(['تطوير المنتجات', 'تحسين التسويق']),
                'action_items' => json_encode(['تدريب الفريق', 'تطوير الموقع']),
                'budget' => 50000.00,
                'actual_cost' => 45000.00,
                'progress_percentage' => 75,
                'notes' => 'خطة ناجحة ومتقدمة بشكل جيد',
                'created_by' => Admin::first()->id,
                'assigned_to' => Admin::first()->id,
            ],
            [
                'title' => 'الخطة المتقدمة',
                'description' => 'خطة شاملة للشركات المتوسطة',
                'type' => 'annual',
                'status' => 'active',
                'start_date' => Carbon::now()->subMonths(3),
                'end_date' => Carbon::now()->addMonths(9),
                'objectives' => json_encode(['توسيع النطاق', 'زيادة الأرباح', 'تطوير الخدمات']),
                'strengths' => json_encode(['خبرة واسعة', 'موارد كافية', 'شبكة علاقات']),
                'weaknesses' => json_encode(['تعقيد العمليات', 'تكاليف عالية']),
                'opportunities' => json_encode(['شراكات جديدة', 'تقنيات متطورة']),
                'threats' => json_encode(['تقلبات السوق', 'منافسة دولية']),
                'strategies' => json_encode(['الابتكار', 'الشراكات الاستراتيجية']),
                'action_items' => json_encode(['تطوير التقنيات', 'تدريب متقدم']),
                'budget' => 100000.00,
                'actual_cost' => 75000.00,
                'progress_percentage' => 60,
                'notes' => 'خطة متقدمة تحتاج لمتابعة مستمرة',
                'created_by' => Admin::first()->id,
                'assigned_to' => Admin::skip(1)->first()->id,
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
        $noteTypes = ['marketing', 'sales', 'general'];
        $priorities = ['low', 'medium', 'high'];
        $statuses = ['active', 'archived', 'deleted'];

        for ($i = 1; $i <= 30; $i++) {
            $notes[] = [
                'customer_id' => $users->random()->id,
                'added_by' => $admins->random()->id,
                'note_type' => $noteTypes[array_rand($noteTypes)],
                'title' => 'ملاحظة مهمة للعميل رقم ' . $i,
                'content' => 'ملاحظة مهمة للعميل رقم ' . $i . ' - يفضل التواصل في المساء',
                'priority' => $priorities[array_rand($priorities)],
                'status' => $statuses[array_rand($statuses)],
                'tags' => json_encode(['مهم', 'متابعة', 'عميل مميز']),
                'follow_up_date' => rand(0, 1) ? Carbon::now()->addDays(rand(1, 30)) : null,
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
        $directions = ['inbound', 'outbound'];
        $statuses = ['sent', 'delivered', 'read', 'failed'];
        $messageTypes = ['text', 'image', 'document', 'audio', 'video'];
        $contactTypes = ['importer', 'marketing', 'sales', 'customer', 'external'];
        $admins = Admin::all();

        for ($i = 1; $i <= 50; $i++) {
            $messages[] = [
                'message_id' => 'msg_' . $i . '_' . time(),
                'from_number' => $phoneNumbers[array_rand($phoneNumbers)],
                'to_number' => $phoneNumbers[array_rand($phoneNumbers)],
                'contact_name' => 'جهة اتصال ' . $i,
                'message_content' => 'رسالة واتساب رقم ' . $i . ' - مرحباً، كيف يمكنني مساعدتك؟',
                'message_type' => $messageTypes[array_rand($messageTypes)],
                'direction' => $directions[array_rand($directions)],
                'status' => $statuses[array_rand($statuses)],
                'sent_at' => Carbon::now()->subDays(rand(1, 30)),
                'delivered_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 29)) : null,
                'read_at' => rand(0, 1) ? Carbon::now()->subDays(rand(1, 28)) : null,
                'media_url' => rand(0, 1) ? json_encode(['url' => 'https://example.com/media' . $i . '.jpg']) : null,
                'sent_by' => rand(0, 1) ? $admins->random()->id : null,
                'contact_id' => rand(0, 1) ? rand(1, 50) : null,
                'contact_type' => $contactTypes[array_rand($contactTypes)],
                'is_archived' => rand(0, 1),
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->subDays(rand(1, 5)),
            ];
        }

        WhatsAppMessage::insert($messages);
    }
}
