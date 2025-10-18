<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Helpers\SettingsHelper;

class SettingsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        try {
            $view->with([
                'siteSettings' => SettingsHelper::getSiteInfo(),
                'contactSettings' => SettingsHelper::getContactInfo(),
                'socialSettings' => SettingsHelper::getSocialLinks(),
                'systemSettings' => SettingsHelper::getSystemSettings(),
            ]);
        } catch (\Exception $e) {
            // If settings fail to load, provide fallback values
            \Log::warning("SettingsComposer failed, using fallback values: " . $e->getMessage());
            $view->with([
                'siteSettings' => $this->getFallbackSiteSettings(),
                'contactSettings' => $this->getFallbackContactSettings(),
                'socialSettings' => $this->getFallbackSocialSettings(),
                'systemSettings' => $this->getFallbackSystemSettings(),
            ]);
        }
    }

    /**
     * Get fallback site settings when database is unavailable
     */
    private function getFallbackSiteSettings()
    {
        return [
            'name' => 'Infinity Wear',
            'tagline' => 'مؤسسة الزي اللامحدود',
            'description' => 'مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد',
            'logo' => null,
            'favicon' => null,
        ];
    }

    /**
     * Get fallback contact settings when database is unavailable
     */
    private function getFallbackContactSettings()
    {
        return [
            'email' => 'info@infinitywear.com',
            'phone' => '+966500982394',
            'whatsapp' => null,
            'support_email' => null,
            'address' => 'المملكة العربية السعودية، الرياض',
            'business_hours' => null,
            'emergency_contact' => null,
        ];
    }

    /**
     * Get fallback social settings when database is unavailable
     */
    private function getFallbackSocialSettings()
    {
        return [
            'facebook' => null,
            'twitter' => null,
            'instagram' => null,
            'linkedin' => null,
            'youtube' => null,
            'tiktok' => null,
        ];
    }

    /**
     * Get fallback system settings when database is unavailable
     */
    private function getFallbackSystemSettings()
    {
        return [
            'enable_registration' => true,
            'email_verification' => true,
            'maintenance_mode' => false,
            'debug_mode' => false,
            'default_language' => 'ar',
            'default_currency' => 'SAR',
            'timezone' => 'Asia/Riyadh',
        ];
    }
}
