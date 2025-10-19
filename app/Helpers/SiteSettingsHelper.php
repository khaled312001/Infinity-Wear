<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SiteSettingsHelper
{
    /**
     * Get all site settings with caching
     */
    public static function getAll()
    {
        return Cache::remember('site_settings_all', 3600, function () {
            return Setting::getAll();
        });
    }

    /**
     * Get a specific setting with caching
     */
    public static function get($key, $default = null)
    {
        return Cache::remember("site_setting_{$key}", 3600, function () use ($key, $default) {
            return Setting::get($key, $default);
        });
    }

    /**
     * Get site logo URL
     */
    public static function getLogoUrl()
    {
        $logo = self::get('site_logo');
        if ($logo && file_exists(storage_path('app/public/' . $logo))) {
            // إضافة timestamp لمنع الكاش في المتصفح
            $timestamp = filemtime(storage_path('app/public/' . $logo));
            return asset('storage/' . $logo) . '?v=' . $timestamp;
        }
        return asset('images/logo.svg');
    }

    /**
     * Get site favicon URL
     */
    public static function getFaviconUrl()
    {
        $favicon = self::get('site_favicon');
        if ($favicon && file_exists(storage_path('app/public/' . $favicon))) {
            // إضافة timestamp لمنع الكاش في المتصفح
            $timestamp = filemtime(storage_path('app/public/' . $favicon));
            return asset('storage/' . $favicon) . '?v=' . $timestamp;
        }
        return asset('images/logo.png');
    }

    /**
     * Get site name
     */
    public static function getSiteName()
    {
        return self::get('site_name', 'Infinity Wear');
    }

    /**
     * Get site tagline
     */
    public static function getSiteTagline()
    {
        return self::get('site_tagline', 'مؤسسة الزي اللامحدود');
    }

    /**
     * Get site description
     */
    public static function getSiteDescription()
    {
        return self::get('site_description', 'مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية');
    }

    /**
     * Get page title
     */
    public static function getPageTitle($pageTitle = null)
    {
        if ($pageTitle) {
            return $pageTitle . ' - ' . self::getSiteName() . ' - ' . self::getSiteTagline();
        }
        return self::getSiteName() . ' - ' . self::getSiteTagline();
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        Cache::forget('site_settings_all');
        $keys = Setting::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("site_setting_{$key}");
        }
        // مسح كاش Laravel العام أيضاً
        Cache::flush();
    }
}
