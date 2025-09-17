<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSlider;
use App\Models\HomeSection;
use App\Models\SectionContent;

class HomeContentSeeder extends Seeder
{
    public function run()
    {
        // إنشاء Hero Sliders
        $heroSliders = [
            [
                'title' => 'مرحباً بك في Infinity Wear',
                'subtitle' => 'مؤسسة اللباس اللامحدود',
                'description' => 'مؤسسة سعودية رائدة متخصصة في تصنيع وتوريد أجود أنواع الملابس والزي الرسمي للشركات والمؤسسات التعليمية والرياضية',
                'image' => 'images/hero/home-hero.svg',
                'button_text' => 'اكتشف خدماتنا',
                'button_link' => route('services'),
                'text_color' => '#ffffff',
                'overlay_opacity' => 0.6,
                'animation_type' => 'fade',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'تصاميم احترافية وجودة عالمية',
                'subtitle' => 'نصنع الفرق في كل قطعة',
                'description' => 'نستخدم أحدث التقنيات وأفضل المواد الخام لضمان منتجات عالية الجودة تدوم طويلاً وتلبي جميع توقعاتكم وتفوقها',
                'image' => 'images/sections/quality-manufacturing.svg',
                'button_text' => 'ابدأ التصميم المخصص',
                'button_link' => route('importers.form'),
                'text_color' => '#ffffff',
                'overlay_opacity' => 0.7,
                'animation_type' => 'slide',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'شراكات استراتيجية ناجحة',
                'subtitle' => 'نبني معاً مستقبل أفضل',
                'description' => 'نفخر بشراكاتنا مع أكبر الشركات والمؤسسات التعليمية والرياضية، ونسعى دائماً لتقديم حلول مبتكرة تلبي احتياجات عملائنا',
                'image' => 'images/sections/team-collaboration.svg',
                'button_text' => 'انضم لشركائنا',
                'button_link' => route('contact'),
                'text_color' => '#ffffff',
                'overlay_opacity' => 0.5,
                'animation_type' => 'zoom',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($heroSliders as $slider) {
            HeroSlider::create($slider);
        }

        // إنشاء أقسام الصفحة الرئيسية
        
        // قسم الخدمات
        $servicesSection = HomeSection::create([
            'name' => 'خدماتنا المتميزة',
            'title' => 'خدماتنا الشاملة',
            'subtitle' => 'نقدم مجموعة شاملة من الخدمات عالية الجودة',
            'description' => 'من التصميم والتطوير إلى التصنيع والتسليم، نحن معك في كل خطوة لضمان حصولك على أفضل النتائج',
            'section_type' => 'services',
            'layout_type' => 'grid_3',
            'background_color' => '#ffffff',
            'text_color' => '#333333',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $services = [
            [
                'title' => 'الملابس الرياضية المتخصصة',
                'subtitle' => 'للأندية والأكاديميات الرياضية',
                'description' => 'تصميم وإنتاج ملابس رياضية عالية الجودة باستخدام أحدث التقنيات والمواد المتطورة للأندية والأكاديميات الرياضية',
                'content_type' => 'card',
                'icon_class' => 'fa-running',
                'button_text' => 'استكشف المنتجات',
                'button_link' => route('products.index'),
                'button_style' => 'primary',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'الزي المدرسي الموحد',
                'subtitle' => 'للمدارس والمؤسسات التعليمية',
                'description' => 'توفير زي مدرسي موحد بأعلى معايير الجودة والراحة للطلاب، مع تصاميم عصرية تناسب جميع المراحل التعليمية',
                'content_type' => 'card',
                'icon_class' => 'fa-graduation-cap',
                'button_text' => 'طلب عرض سعر',
                'button_link' => route('contact'),
                'button_style' => 'primary',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'الزي الرسمي للشركات',
                'subtitle' => 'للشركات والمؤسسات المهنية',
                'description' => 'تصميم وإنتاج زي موحد احترافي يعكس هوية شركتكم ويضمن المظهر المهني المتميز لجميع الموظفين',
                'content_type' => 'card',
                'icon_class' => 'fa-briefcase',
                'button_text' => 'تصميم مخصص',
                'button_link' => route('importers.form'),
                'button_style' => 'primary',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'التصميم والتطوير المخصص',
                'subtitle' => 'حلول مبتكرة حسب احتياجاتكم',
                'description' => 'فريق من المصممين والمطورين المحترفين لإنشاء تصاميم فريدة ومبتكرة تلبي جميع متطلباتكم الخاصة',
                'content_type' => 'card',
                'icon_class' => 'fa-palette',
                'button_text' => 'ابدأ مشروعك',
                'button_link' => route('importers.form'),
                'button_style' => 'outline',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'خدمة التوصيل السريع',
                'subtitle' => 'لجميع أنحاء المملكة',
                'description' => 'خدمة توصيل سريعة وآمنة لجميع أنحاء المملكة العربية السعودية مع ضمان وصول منتجاتكم في أفضل حالة',
                'content_type' => 'card',
                'icon_class' => 'fa-shipping-fast',
                'button_text' => 'تفاصيل التوصيل',
                'button_link' => route('services'),
                'button_style' => 'secondary',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'خدمة العملاء المتميزة',
                'subtitle' => 'دعم فني على مدار الساعة',
                'description' => 'فريق خدمة عملاء متخصص ومتاح على مدار الساعة لتقديم الدعم والمساعدة في جميع استفساراتكم ومتطلباتكم',
                'content_type' => 'card',
                'icon_class' => 'fa-headset',
                'button_text' => 'تواصل معنا',
                'button_link' => route('contact'),
                'button_style' => 'secondary',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            $service['home_section_id'] = $servicesSection->id;
            SectionContent::create($service);
        }

        // قسم الإحصائيات
        $statsSection = HomeSection::create([
            'name' => 'إحصائياتنا',
            'title' => 'أرقام تتحدث عن نفسها',
            'subtitle' => 'إنجازاتنا في أرقام',
            'section_type' => 'features',
            'layout_type' => 'grid_4',
            'background_color' => '#1e3a8a',
            'text_color' => '#ffffff',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $stats = [
            [
                'title' => '500+',
                'subtitle' => 'عميل راضي',
                'description' => 'عميل سعيد وراضي عن خدماتنا المتميزة',
                'content_type' => 'icon',
                'icon_class' => 'fa-users',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => '1200+',
                'subtitle' => 'تصميم مخصص',
                'description' => 'تصميم مخصص تم تنفيذه بأعلى معايير الجودة',
                'content_type' => 'icon',
                'icon_class' => 'fa-palette',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => '50+',
                'subtitle' => 'مشروع مكتمل',
                'description' => 'مشروع تم إنجازه بنجاح وفي الوقت المحدد',
                'content_type' => 'icon',
                'icon_class' => 'fa-trophy',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => '10',
                'subtitle' => 'سنوات خبرة',
                'description' => 'سنوات من الخبرة والتميز في هذا المجال',
                'content_type' => 'icon',
                'icon_class' => 'fa-award',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($stats as $stat) {
            $stat['home_section_id'] = $statsSection->id;
            SectionContent::create($stat);
        }

        // قسم الشهادات
        $testimonialsSection = HomeSection::create([
            'name' => 'آراء العملاء',
            'title' => 'ماذا يقول عملاؤنا',
            'subtitle' => 'آراء عملائنا الكرام في خدماتنا المتميزة',
            'section_type' => 'testimonials',
            'layout_type' => 'carousel',
            'background_color' => '#f8f9fa',
            'text_color' => '#333333',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        $testimonials = [
            [
                'title' => 'أحمد محمد العلي',
                'subtitle' => 'مدير أكاديمية الرياض الرياضية',
                'description' => 'خدمة ممتازة وجودة عالية. التصاميم احترافية والتسليم في الوقت المحدد. تجربة رائعة مع فريق محترف يتميز بالاحترافية والدقة في العمل.',
                'content_type' => 'testimonial',
                'custom_data' => ['rating' => 5],
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'سارة العلي الأحمد',
                'subtitle' => 'مديرة مدارس الفيصل الأهلية',
                'description' => 'أفضل مكان للحصول على زي موحد عالي الجودة. أنصح الجميع بالتعامل معهم. خدمة عملاء ممتازة وتفهم كامل لاحتياجات المؤسسات التعليمية.',
                'content_type' => 'testimonial',
                'custom_data' => ['rating' => 5],
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'خالد السعد المطيري',
                'subtitle' => 'مدير عام شركة التقنية المتطورة',
                'description' => 'التصاميم المخصصة رائعة والفريق متعاون جداً. تجربة ممتازة من البداية للنهاية. جودة لا تُضاهى وأسعار تنافسية مع التزام كامل بالمواعيد المحددة.',
                'content_type' => 'testimonial',
                'custom_data' => ['rating' => 5],
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            $testimonial['home_section_id'] = $testimonialsSection->id;
            SectionContent::create($testimonial);
        }
    }
}