<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class SeoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('seo', function () {
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
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}