<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CompleteDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        $this->command->info('Clearing existing data...');
        $this->clearExistingData();

        // Seed all tables
        $this->command->info('Seeding database...');
        
        $this->seedUsers();
        $this->seedAdmins();
        $this->seedSettings();
        $this->seedCategories();
        // Hero sliders seeding removed
        $this->seedHomeSections();
        $this->seedSectionContents();
        $this->seedPortfolioItems();
        $this->seedTestimonials();
        $this->seedImporters();
        $this->seedImporterOrders();
        $this->seedContacts();

        $this->command->info('Database seeding completed successfully!');
    }

    private function clearExistingData()
    {
        $tables = [
            'importer_orders', 'importers', 'contacts', 'testimonials', 
            'portfolio_items', 'section_contents', 'home_sections', 
            'hero_sliders', 'settings', 'categories', 'orders', 'admins', 'users'
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
    }

    private function seedUsers()
    {
        $this->command->info('Seeding users...');
        
        $users = [
            [
                'name' => 'أحمد محمد',
                'email' => 'ahmed@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'user_type' => 'customer',
                'phone' => '+966501234567',
                'address' => 'مكة المكرمة  - شارع الستين ',
                'city' => 'الرياض',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'فاطمة علي',
                'email' => 'fatima@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'user_type' => 'customer',
                'phone' => '+966501234568',
                'address' => 'جدة، المملكة العربية السعودية',
                'city' => 'جدة',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'محمد السعيد',
                'email' => 'mohammed@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'user_type' => 'importer',
                'phone' => '+966501234569',
                'address' => 'الدمام، المملكة العربية السعودية',
                'city' => 'الدمام',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('users')->insert($users);
    }

    private function seedAdmins()
    {
        $this->command->info('Seeding admins...');
        
        $admins = [
            [
                'name' => 'مدير النظام',
                'email' => 'admin@infinitywearsa.com',
                'password' => Hash::make('admin123'),
                'phone' => '+966501234567',
                'bio' => 'مدير النظام الرئيسي لموقع إنفينيتي وير',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'مدير المحتوى',
                'email' => 'content@infinitywearsa.com',
                'password' => Hash::make('content123'),
                'phone' => '+966501234568',
                'bio' => 'مدير المحتوى والتصاميم',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('admins')->insert($admins);
    }

    private function seedSettings()
    {
        $this->command->info('Seeding settings...');
        
        $settings = [
            // Site Information
            ['site_name', 'إنفينيتي وير', 'string', 'اسم الموقع'],
            ['site_tagline', 'مؤسسة الزي اللامحدود', 'string', 'شعار الموقع'],
            ['site_description', 'متجر التيشيرتات والملابس الرياضية', 'string', 'وصف الموقع'],
            ['site_logo', null, 'string', 'شعار الموقع'],
            ['site_favicon', null, 'string', 'أيقونة الموقع'],
            
            // Contact Information
            ['contact_email', 'info@infinitywearsa.com', 'string', 'البريد الإلكتروني للتواصل'],
            ['contact_phone', '+966501234567', 'string', 'رقم الهاتف للتواصل'],
            ['whatsapp_number', '+966501234567', 'string', 'رقم الواتساب'],
            ['support_email', null, 'string', 'بريد الدعم الفني'],
            ['address', 'المملكة العربية السعودية، الرياض', 'string', 'العنوان'],
            ['business_hours', null, 'string', 'ساعات العمل'],
            ['emergency_contact', null, 'string', 'رقم الطوارئ'],
            
            // Social Media
            ['facebook_url', 'https://facebook.com/infinitywear', 'string', 'رابط الفيسبوك'],
            ['twitter_url', 'https://twitter.com/infinitywear', 'string', 'رابط تويتر'],
            ['instagram_url', 'https://instagram.com/infinitywear', 'string', 'رابط الإنستغرام'],
            ['linkedin_url', null, 'string', 'رابط لينكد إن'],
            ['youtube_url', null, 'string', 'رابط يوتيوب'],
            ['tiktok_url', null, 'string', 'رابط تيك توك'],
            
            // System Settings
            ['enable_registration', true, 'boolean', 'تفعيل التسجيل'],
            ['email_verification', true, 'boolean', 'تفعيل التحقق من البريد الإلكتروني'],
            ['maintenance_mode', false, 'boolean', 'وضع الصيانة'],
            ['debug_mode', false, 'boolean', 'وضع التطوير'],
            ['default_language', 'ar', 'string', 'اللغة الافتراضية'],
            ['default_currency', 'SAR', 'string', 'العملة الافتراضية'],
            ['timezone', 'Asia/Riyadh', 'string', 'المنطقة الزمنية'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert([
                'key' => $setting[0],
                'value' => $setting[1],
                'type' => $setting[2],
                'description' => $setting[3],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function seedCategories()
    {
        $this->command->info('Seeding categories...');
        
        $categories = [
            [
                'name' => 'تيشيرتات رياضية',
                'description' => 'تيشيرتات مخصصة للرياضة والأنشطة البدنية',
                'image' => 'sports.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'تيشيرتات عادية',
                'description' => 'تيشيرتات يومية مريحة وعصرية',
                'image' => 'casual.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'تيشيرتات أطفال',
                'description' => 'تيشيرتات ملونة ومناسبة للأطفال',
                'image' => 'kids.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'تيشيرتات نسائية',
                'description' => 'تيشيرتات أنيقة ومريحة للنساء',
                'image' => 'women.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'تيشيرتات رجالية',
                'description' => 'تيشيرتات أنيقة ومناسبة للرجال',
                'image' => 'men.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('categories')->insert($categories);
    }

    // Hero sliders seeding method removed

    private function seedHomeSections()
    {
        $this->command->info('Seeding home sections...');
        
        $homeSections = [
            [
                'title' => 'خدماتنا',
                'subtitle' => 'ما نقدمه لك',
                'description' => 'نقدم مجموعة واسعة من خدمات الطباعة والتصميم',
                'content_type' => 'text',
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
           
            [
                'title' => 'لماذا نحن؟',
                'subtitle' => 'مميزاتنا',
                'description' => 'نتميز بالجودة العالية والخدمة المتميزة',
                'content_type' => 'text',
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'عملاؤنا',
                'subtitle' => 'آراء العملاء',
                'description' => 'ما يقوله عملاؤنا عن خدماتنا',
                'content_type' => 'gallery',
                'is_active' => true,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('home_sections')->insert($homeSections);
    }

    private function seedSectionContents()
    {
        $this->command->info('Seeding section contents...');
        
        $sectionContents = [
            // Services Section (ID: 1)
            [
                'home_section_id' => 1,
                'title' => 'طباعة التيشيرتات',
                'content' => 'طباعة عالية الجودة على جميع أنواع التيشيرتات',
                'image' => 'printing.jpg',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'home_section_id' => 1,
                'title' => 'التصميم المخصص',
                'content' => 'تصميم مخصص حسب طلبك باستخدام الذكاء الاصطناعي',
                'image' => 'custom-design.jpg',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'home_section_id' => 1,
                'title' => 'التوصيل السريع',
                'content' => 'توصيل سريع لجميع أنحاء المملكة',
                'image' => 'delivery.jpg',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Products Section (ID: 2)
            [
                'home_section_id' => 2,
                'title' => 'تيشيرت رياضي',
                'content' => 'تيشيرتات رياضية عالية الجودة',
                'image' => 'sports-tshirt.jpg',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'home_section_id' => 2,
                'title' => 'تيشيرت أطفال',
                'content' => 'تيشيرتات ملونة ومناسبة للأطفال',
                'image' => 'kids-tshirt.jpg',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'home_section_id' => 2,
                'title' => 'تيشيرت نسائي',
                'content' => 'تيشيرتات أنيقة ومريحة للنساء',
                'image' => 'women-tshirt.jpg',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'home_section_id' => 2,
                'title' => 'تيشيرت رجالي',
                'content' => 'تيشيرتات أنيقة ومناسبة للرجال',
                'image' => 'men-tshirt.jpg',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Why Us Section (ID: 3)
            [
                'home_section_id' => 3,
                'title' => 'جودة عالية',
                'content' => 'نستخدم أفضل المواد والطباعة',
                'image' => null,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'home_section_id' => 3,
                'title' => 'أسعار مناسبة',
                'content' => 'أسعار تنافسية ومناسبة للجميع',
                'image' => null,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'home_section_id' => 3,
                'title' => 'خدمة عملاء متميزة',
                'content' => 'فريق خدمة عملاء متخصص ومتاح 24/7',
                'image' => null,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'home_section_id' => 3,
                'title' => 'توصيل سريع',
                'content' => 'توصيل سريع وآمن لجميع أنحاء المملكة',
                'image' => null,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('section_contents')->insert($sectionContents);
    }

    private function seedPortfolioItems()
    {
        $this->command->info('Seeding portfolio items...');
        
        $portfolioItems = [
            [
                'title' => 'تصميم كرة القدم',
                'description' => 'تيشيرت رياضي بتصميم كرة القدم',
                'image' => 'football-design.jpg',
                'category' => 'تيشيرتات رياضية',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'تصميم بسيط',
                'description' => 'تيشيرت بتصميم بسيط وأنيق',
                'image' => 'simple-design.jpg',
                'category' => 'تيشيرتات عادية',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'تصميم أطفال',
                'description' => 'تيشيرت ملون ومناسب للأطفال',
                'image' => 'kids-design.jpg',
                'category' => 'تيشيرتات أطفال',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'تصميم نسائي',
                'description' => 'تيشيرت أنيق ومريح للنساء',
                'image' => 'women-design.jpg',
                'category' => 'تيشيرتات نسائية',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'تصميم رجالي',
                'description' => 'تيشيرت أنيق ومناسب للرجال',
                'image' => 'men-design.jpg',
                'category' => 'تيشيرتات رجالية',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'تصميم الشركات',
                'description' => 'تيشيرتات مخصصة للشركات والمؤسسات',
                'image' => 'corporate-design.jpg',
                'category' => 'تيشيرتات عادية',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('portfolio_items')->insert($portfolioItems);
    }

    private function seedTestimonials()
    {
        $this->command->info('Seeding testimonials...');
        
        $testimonials = [
            [
                'name' => 'أحمد محمد',
                'position' => 'عميل',
                'company' => 'شركة التقنية',
                'content' => 'خدمة ممتازة وجودة عالية في التصميم والطباعة. أنصح الجميع بالتعامل معهم.',
                'rating' => 5,
                'image' => 'testimonial-1.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'فاطمة علي',
                'position' => 'مصممة',
                'company' => 'استوديو الإبداع',
                'content' => 'أفضل مكان لطباعة التصاميم بجودة عالية. فريق العمل محترف جداً.',
                'rating' => 5,
                'image' => 'testimonial-2.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'محمد السعيد',
                'position' => 'مدير تسويق',
                'company' => 'شركة الإعلانات',
                'content' => 'سرعة في التنفيذ ودقة في التفاصيل. أسعار مناسبة وجودة ممتازة.',
                'rating' => 4,
                'image' => 'testimonial-3.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'نورا أحمد',
                'position' => 'طالبة',
                'company' => 'جامعة الملك سعود',
                'content' => 'تيشيرتات جميلة ومناسبة للجامعة. التوصيل سريع والجودة عالية.',
                'rating' => 5,
                'image' => 'testimonial-4.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'خالد العتيبي',
                'position' => 'مدير مشروع',
                'company' => 'شركة البناء',
                'content' => 'خدمة ممتازة وتنفيذ سريع. أنصح بالتعامل معهم للمشاريع الكبيرة.',
                'rating' => 5,
                'image' => 'testimonial-5.jpg',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('testimonials')->insert($testimonials);
    }

    private function seedImporters()
    {
        $this->command->info('Seeding importers...');
        
        $importers = [
            [
                'name' => 'أحمد الشركة',
                'email' => 'ahmed@company.com',
                'phone' => '+966501234567',
                'company_name' => 'شركة التقنية المتقدمة',
                'address' => 'مكة المكرمة  - شارع الستين ',
                'city' => 'الرياض',
                'business_type' => 'شركة تقنية',
                'experience_level' => 'متقدم',
                'expected_volume' => '100-500 قطعة شهرياً',
                'design_preference' => 'تصاميم تقنية',
                'budget_range' => '1000-5000 ريال',
                'additional_info' => 'نحتاج تيشيرتات للفريق التقني',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'فاطمة المصممة',
                'email' => 'fatima@design.com',
                'phone' => '+966501234568',
                'company_name' => 'استوديو الإبداع',
                'address' => 'جدة، المملكة العربية السعودية',
                'city' => 'جدة',
                'business_type' => 'استوديو تصميم',
                'experience_level' => 'متوسط',
                'expected_volume' => '50-200 قطعة شهرياً',
                'design_preference' => 'تصاميم إبداعية',
                'budget_range' => '500-2000 ريال',
                'additional_info' => 'نحتاج تيشيرتات للعملاء',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'محمد التسويق',
                'email' => 'mohammed@marketing.com',
                'phone' => '+966501234569',
                'company_name' => 'شركة الإعلانات',
                'address' => 'الدمام، المملكة العربية السعودية',
                'city' => 'الدمام',
                'business_type' => 'شركة إعلانات',
                'experience_level' => 'مبتدئ',
                'expected_volume' => '20-100 قطعة شهرياً',
                'design_preference' => 'تصاميم تسويقية',
                'budget_range' => '200-1000 ريال',
                'additional_info' => 'نحتاج تيشيرتات للحملات التسويقية',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('importers')->insert($importers);
    }

    private function seedImporterOrders()
    {
        $this->command->info('Seeding importer orders...');
        
        $importerOrders = [
            [
                'importer_id' => 1,
                'order_type' => 'ai',
                'design_description' => null,
                'design_file' => null,
                'template_id' => null,
                'ai_prompt' => 'تيشيرت تقني بتصميم حديث للفريق التقني',
                'ai_generated_image' => 'ai-design-1.jpg',
                'quantity' => 50,
                'status' => 'completed',
                'notes' => 'تم التنفيذ بنجاح',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(1),
            ],
            [
                'importer_id' => 1,
                'order_type' => 'text',
                'design_description' => 'تيشيرت بسيط مع شعار الشركة',
                'design_file' => null,
                'template_id' => null,
                'ai_prompt' => null,
                'ai_generated_image' => null,
                'quantity' => 30,
                'status' => 'processing',
                'notes' => 'قيد التنفيذ',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(1),
            ],
            [
                'importer_id' => 2,
                'order_type' => 'file',
                'design_description' => null,
                'design_file' => 'design-file-1.psd',
                'template_id' => null,
                'ai_prompt' => null,
                'ai_generated_image' => null,
                'quantity' => 25,
                'status' => 'pending',
                'notes' => 'في انتظار الموافقة',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'importer_id' => 3,
                'order_type' => 'template',
                'design_description' => null,
                'design_file' => null,
                'template_id' => 1,
                'ai_prompt' => null,
                'ai_generated_image' => null,
                'quantity' => 100,
                'status' => 'completed',
                'notes' => 'تم التنفيذ بنجاح',
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(2),
            ]
        ];

        DB::table('importer_orders')->insert($importerOrders);
    }

    private function seedContacts()
    {
        $this->command->info('Seeding contacts...');
        
        $contacts = [
            [
                'name' => 'سارة أحمد',
                'email' => 'sara@example.com',
                'phone' => '+966501234570',
                'subject' => 'استفسار عن الخدمات',
                'message' => 'أريد معرفة المزيد عن خدماتكم في طباعة التيشيرتات',
                'status' => 'new',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'name' => 'عبدالله محمد',
                'email' => 'abdullah@example.com',
                'phone' => '+966501234571',
                'subject' => 'طلب عرض سعر',
                'message' => 'أحتاج عرض سعر لطباعة 200 تيشيرت',
                'status' => 'read',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(2),
            ],
            [
                'name' => 'مريم علي',
                'email' => 'mariam@example.com',
                'phone' => '+966501234572',
                'subject' => 'شكر وتقدير',
                'message' => 'شكراً لكم على الخدمة الممتازة والجودة العالية',
                'status' => 'replied',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(4),
            ]
        ];

        DB::table('contacts')->insert($contacts);
    }
}
