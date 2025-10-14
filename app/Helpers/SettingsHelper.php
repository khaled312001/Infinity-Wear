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
        return [
            'name' => self::get('site_name', 'Infinity Wear'),
            'tagline' => self::get('site_tagline', 'مؤسسة الزي اللامحدود'),
            'description' => self::get('site_description', 'مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد'),
            'logo' => self::get('site_logo'),
            'favicon' => self::get('site_favicon'),
        ];
    }

    /**
     * Get contact information
     */
    public static function getContactInfo()
    {
        return [
            'email' => self::get('contact_email', 'info@infinitywear.com'),
            'phone' => self::get('contact_phone', '+966500982394'),
            'whatsapp' => self::get('whatsapp_number'),
            'support_email' => self::get('support_email'),
            'address' => self::get('address', 'المملكة العربية السعودية، الرياض'),
            'business_hours' => self::get('business_hours'),
            'emergency_contact' => self::get('emergency_contact'),
        ];
    }

    /**
     * Get social media links
     */
    public static function getSocialLinks()
    {
        return [
            'facebook' => self::get('facebook_url'),
            'twitter' => self::get('twitter_url'),
            'instagram' => self::get('instagram_url'),
            'linkedin' => self::get('linkedin_url'),
            'youtube' => self::get('youtube_url'),
            'tiktok' => self::get('tiktok_url'),
        ];
    }

    /**
     * Get system settings
     */
    public static function getSystemSettings()
    {
        return [
            'enable_registration' => (bool) self::get('enable_registration', true),
            'email_verification' => (bool) self::get('email_verification', true),
            'maintenance_mode' => (bool) self::get('maintenance_mode', false),
            'debug_mode' => (bool) self::get('debug_mode', false),
            'default_language' => self::get('default_language', 'ar'),
            'default_currency' => self::get('default_currency', 'SAR'),
            'timezone' => self::get('timezone', 'Asia/Riyadh'),
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
}
