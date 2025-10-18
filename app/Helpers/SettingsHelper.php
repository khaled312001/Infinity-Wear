<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingsHelper
{
    /**
     * Get a setting value with fallback
     */
    public static function get($key, $default = null)
    {
        return Setting::get($key, $default);
    }

    /**
     * Get site information
     */
    public static function getSiteInfo()
    {
        $settings = self::getAllSettings();
        return [
            'name' => $settings['site_name'] ?? 'Infinity Wear',
            'tagline' => $settings['site_tagline'] ?? 'مؤسسة الزي اللامحدود',
            'description' => $settings['site_description'] ?? 'مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد',
            'logo' => $settings['site_logo'] ?? null,
            'favicon' => $settings['site_favicon'] ?? null,
        ];
    }

    /**
     * Get contact information
     */
    public static function getContactInfo()
    {
        $settings = self::getAllSettings();
        return [
            'email' => $settings['contact_email'] ?? 'info@infinitywear.com',
            'phone' => $settings['contact_phone'] ?? '+966500982394',
            'whatsapp' => $settings['whatsapp_number'] ?? null,
            'support_email' => $settings['support_email'] ?? null,
            'address' => $settings['address'] ?? 'المملكة العربية السعودية، الرياض',
            'business_hours' => $settings['business_hours'] ?? null,
            'emergency_contact' => $settings['emergency_contact'] ?? null,
        ];
    }

    /**
     * Get social media links
     */
    public static function getSocialLinks()
    {
        $settings = self::getAllSettings();
        return [
            'facebook' => $settings['facebook_url'] ?? null,
            'twitter' => $settings['twitter_url'] ?? null,
            'instagram' => $settings['instagram_url'] ?? null,
            'linkedin' => $settings['linkedin_url'] ?? null,
            'youtube' => $settings['youtube_url'] ?? null,
            'tiktok' => $settings['tiktok_url'] ?? null,
        ];
    }

    /**
     * Get system settings
     */
    public static function getSystemSettings()
    {
        $settings = self::getAllSettings();
        return [
            'enable_registration' => (bool) ($settings['enable_registration'] ?? true),
            'email_verification' => (bool) ($settings['email_verification'] ?? true),
            'maintenance_mode' => (bool) ($settings['maintenance_mode'] ?? false),
            'debug_mode' => (bool) ($settings['debug_mode'] ?? false),
            'default_language' => $settings['default_language'] ?? 'ar',
            'default_currency' => $settings['default_currency'] ?? 'SAR',
            'timezone' => $settings['timezone'] ?? 'Asia/Riyadh',
        ];
    }

    /**
     * Check if maintenance mode is enabled
     */
    public static function isMaintenanceMode()
    {
        return (bool) self::get('maintenance_mode', false);
    }

    /**
     * Check if registration is enabled
     */
    public static function isRegistrationEnabled()
    {
        return (bool) self::get('enable_registration', true);
    }

    /**
     * Check if email verification is required
     */
    public static function isEmailVerificationRequired()
    {
        return (bool) self::get('email_verification', true);
    }

    /**
     * Get all settings at once to reduce database queries
     */
    public static function getAllSettings()
    {
        try {
            return \Illuminate\Support\Facades\Cache::remember('settings.all', 3600, function () {
                return \App\Models\Setting::pluck('value', 'key')->toArray();
            });
        } catch (\Exception $e) {
            \Log::warning("Failed to load settings, using fallback: " . $e->getMessage());
            return [];
        }
    }
}
