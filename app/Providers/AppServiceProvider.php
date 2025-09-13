<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bind SEO data service
        $this->app->singleton('seo', function ($app) {
            return $app['cache']->remember('seo_data', 3600, function () {
                $filePath = storage_path('app/seo_data.json');
                
                if (file_exists($filePath)) {
                    return json_decode(file_get_contents($filePath), true) ?? [];
                }
                
                // Default SEO values
                return [
                    'site_title' => 'Infinity Wear - مؤسسة اللباس اللامحدود',
                    'site_description' => 'مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية',
                    'site_keywords' => 'ملابس رياضية، زي موحد، أكاديميات رياضية، السعودية، كرة قدم، تصميم ملابس، infinity wear، اللباس اللامحدود',
                    'google_analytics_id' => null,
                    'facebook_pixel_id' => null,
                    'google_site_verification' => null,
                ];
            });
        });
    }
}
