<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class ContentController extends Controller
{
    public function __construct()
    {
        // Middleware is applied in routes
    }

    /**
     * إدارة المحتوى الرئيسية
     */
    public function index()
    {
        $stats = [
            'pages_count' => $this->getPagesCount(),
            'seo_status' => $this->getSeoStatus(),
            'cache_size' => $this->getCacheSize(),
            'last_update' => $this->getLastUpdate()
        ];

        return view('admin.content.index', compact('stats'));
    }

    /**
     * إدارة الـ SEO
     */
    public function seo()
    {
        $seoData = $this->getSeoData();
        
        return view('admin.content.seo', compact('seoData'));
    }

    /**
     * تحديث إعدادات الـ SEO
     */
    public function updateSeo(Request $request)
    {
        $request->validate([
            'site_title' => 'required|string|max:255',
            'site_description' => 'required|string|max:500',
            'site_keywords' => 'required|string|max:1000',
            'home_title' => 'nullable|string|max:255',
            'home_description' => 'nullable|string|max:500',
            'about_title' => 'nullable|string|max:255',
            'about_description' => 'nullable|string|max:500',
            'services_title' => 'nullable|string|max:255',
            'services_description' => 'nullable|string|max:500',
            'contact_title' => 'nullable|string|max:255',
            'contact_description' => 'nullable|string|max:500',
            'portfolio_title' => 'nullable|string|max:255',
            'portfolio_description' => 'nullable|string|max:500',
            'google_analytics_id' => 'nullable|string|max:255',
            'facebook_pixel_id' => 'nullable|string|max:255',
            'google_site_verification' => 'nullable|string|max:255',
        ]);

        $seoData = $request->all();
        
        // حفظ البيانات في ملف JSON
        $filePath = storage_path('app/seo_data.json');
        File::put($filePath, json_encode($seoData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // مسح الكاش
        Cache::forget('seo_data');

        return redirect()->back()->with('success', 'تم تحديث إعدادات الـ SEO بنجاح');
    }

    /**
     * إدارة محتوى الصفحات
     */
    public function pages()
    {
        $pagesContent = $this->getPagesContent();
        
        return view('admin.content.pages', compact('pagesContent'));
    }

    /**
     * تحديث محتوى الصفحات
     */
    public function updatePages(Request $request)
    {
        $request->validate([
            'home_hero_title' => 'nullable|string|max:255',
            'home_hero_subtitle' => 'nullable|string|max:500',
            'home_about_title' => 'nullable|string|max:255',
            'home_about_content' => 'nullable|string|max:2000',
            'about_content' => 'nullable|string|max:5000',
            'services_intro' => 'nullable|string|max:1000',
            'contact_address' => 'nullable|string|max:500',
            'contact_phone' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:100',
            'contact_hours' => 'nullable|string|max:200',
            'footer_about' => 'nullable|string|max:500',
        ]);

        $pagesData = $request->all();
        
        // حفظ البيانات في ملف JSON
        $filePath = storage_path('app/pages_content.json');
        File::put($filePath, json_encode($pagesData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // مسح الكاش
        Cache::forget('pages_content');

        return redirect()->back()->with('success', 'تم تحديث محتوى الصفحات بنجاح');
    }

    /**
     * الحصول على بيانات الـ SEO
     */
    private function getSeoData()
    {
        return Cache::remember('seo_data', 3600, function () {
            $filePath = storage_path('app/seo_data.json');
            
            if (File::exists($filePath)) {
                return json_decode(File::get($filePath), true);
            }

            // القيم الافتراضية
            return [
                'site_title' => 'Infinity Wear - مؤسسة الزي اللامحدود',
                'site_description' => 'مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية. ثقة، سرعة، مصداقية، جودة، تصميم، احترافية.',
                'site_keywords' => 'ملابس رياضية، زي موحد، أكاديميات رياضية، السعودية، كرة قدم، تصميم ملابس، infinity wear، الزي اللامحدود',
                'home_title' => 'الرئيسية - Infinity Wear',
                'home_description' => 'مؤسسة Infinity Wear متخصصة في توريد أفضل الملابس الرياضية والأزياء الموحدة للأكاديميات الرياضية في المملكة العربية السعودية',
                'about_title' => 'من نحن - Infinity Wear',
                'about_description' => 'تعرف على مؤسسة Infinity Wear وخبرتنا في مجال الملابس الرياضية والأزياء الموحدة. نحن نقدم أعلى مستوى من الجودة والاحترافية',
                'services_title' => 'خدماتنا - Infinity Wear',
                'services_description' => 'اكتشف خدماتنا المتنوعة في مجال الملابس الرياضية: تصميم الأزياء، الزي الموحد للأكاديميات، ملابس الفرق الرياضية، والطباعة على الملابس',
                'contact_title' => 'اتصل بنا - Infinity Wear',
                'contact_description' => 'تواصل مع فريق Infinity Wear للحصول على أفضل الخدمات في مجال الملابس الرياضية والأزياء الموحدة',
                'portfolio_title' => 'معرض أعمالنا - Infinity Wear',
                'portfolio_description' => 'شاهد أعمالنا المميزة في تصميم وتوريد الملابس الرياضية والأزياء الموحدة للأكاديميات والفرق الرياضية',
                'google_analytics_id' => '',
                'facebook_pixel_id' => '',
                'google_site_verification' => '',
            ];
        });
    }

    /**
     * الحصول على محتوى الصفحات
     */
    private function getPagesContent()
    {
        return Cache::remember('pages_content', 3600, function () {
            $filePath = storage_path('app/pages_content.json');
            
            if (File::exists($filePath)) {
                return json_decode(File::get($filePath), true);
            }

            // القيم الافتراضية
            return [
                'home_hero_title' => 'مؤسسة الزي اللامحدود',
                'home_hero_subtitle' => 'زي موحد يعبر عن هويتكم وعلامتكم التجارية',
                'home_about_title' => 'من نحن',
                'home_about_content' => 'نحن مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية. نتميز بالثقة، السرعة، المصداقية، الجودة، التصميم، والاحترافية.',
                'about_content' => 'مؤسسة Infinity Wear تأسست برؤية واضحة لتكون الشريك الأول والموثوق في مجال توريد الملابس الرياضية والأزياء الموحدة في المملكة العربية السعودية. نحن نؤمن بأن الزي الموحد ليس مجرد ملابس، بل هو تعبير عن الهوية والانتماء والاحترافية.',
                'services_intro' => 'نقدم مجموعة شاملة من الخدمات المتخصصة في مجال الملابس الرياضية والأزياء الموحدة',
                'contact_address' => 'مكة المكرمة، المملكة العربية السعودية',
                'contact_phone' => '+966500982394',
                'contact_email' => 'info@infinitywear.sa',
                'contact_hours' => 'الأحد - الخميس: 9:00 ص - 5:00 م',
                'footer_about' => 'مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية',
            ];
        });
    }

    /**
     * عدد الصفحات
     */
    private function getPagesCount()
    {
        $viewsPath = resource_path('views');
        $pages = File::allFiles($viewsPath);
        return count($pages);
    }

    /**
     * حالة الـ SEO
     */
    private function getSeoStatus()
    {
        $seoData = $this->getSeoData();
        $requiredFields = ['site_title', 'site_description', 'site_keywords'];
        
        $completedFields = 0;
        foreach ($requiredFields as $field) {
            if (!empty($seoData[$field])) {
                $completedFields++;
            }
        }

        return round(($completedFields / count($requiredFields)) * 100);
    }

    /**
     * حجم الكاش
     */
    private function getCacheSize()
    {
        try {
            $cacheDir = storage_path('framework/cache');
            if (File::exists($cacheDir)) {
                $size = 0;
                $files = File::allFiles($cacheDir);
                foreach ($files as $file) {
                    $size += $file->getSize();
                }
                return $this->formatBytes($size);
            }
        } catch (\Exception $e) {
            return 'غير محدد';
        }

        return '0 KB';
    }

    /**
     * آخر تحديث
     */
    private function getLastUpdate()
    {
        $filePath = storage_path('app/seo_data.json');
        if (File::exists($filePath)) {
            return \Carbon\Carbon::createFromTimestamp(File::lastModified($filePath))->diffForHumans();
        }
        return 'لم يتم التحديث بعد';
    }

    /**
     * تنسيق حجم الملف
     */
    private function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $base = log($size, 1024);
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $units[floor($base)];
    }

    /**
     * مسح الكاش
     */
    public function clearCache()
    {
        try {
            // مسح جميع أنواع الكاش
            Cache::flush();
            
            // مسح كاش التطبيق
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');
            \Artisan::call('view:clear');
            
            return response()->json([
                'success' => true,
                'message' => 'تم مسح الكاش بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء مسح الكاش: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * إنشاء خريطة الموقع
     */
    public function generateSitemap()
    {
        try {
            $urls = [
                ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
                ['url' => route('about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
                ['url' => route('services'), 'priority' => '0.8', 'changefreq' => 'monthly'],
                ['url' => route('portfolio.index'), 'priority' => '0.9', 'changefreq' => 'weekly'],
                ['url' => route('testimonials.index'), 'priority' => '0.7', 'changefreq' => 'monthly'],
                ['url' => route('contact'), 'priority' => '0.6', 'changefreq' => 'monthly'],
                ['url' => route('importers.form'), 'priority' => '0.9', 'changefreq' => 'weekly'],
            ];

            // إضافة صفحات معرض الأعمال
            try {
                $portfolioItems = \App\Models\PortfolioItem::where('is_active', true)->get();
                foreach ($portfolioItems as $item) {
                    $urls[] = [
                        'url' => route('portfolio.show', $item),
                        'priority' => '0.7',
                        'changefreq' => 'monthly'
                    ];
                }
            } catch (\Exception $e) {
                // تجاهل الخطأ إذا لم تكن النماذج موجودة
            }

            $xml = view('admin.content.sitemap', compact('urls'))->render();
            
            // التأكد من وجود مجلد public
            if (!File::exists(public_path())) {
                File::makeDirectory(public_path(), 0755, true);
            }
            
            File::put(public_path('sitemap.xml'), $xml);

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء خريطة الموقع بنجاح',
                'sitemap_url' => url('sitemap.xml')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إنشاء خريطة الموقع: ' . $e->getMessage()
            ], 500);
        }
    }
}