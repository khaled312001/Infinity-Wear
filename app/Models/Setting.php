<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];
    
    public $timestamps = true;

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        try {
            return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
                $setting = static::where('key', $key)->first();
                return $setting ? $setting->value : $default;
            });
        } catch (\Exception $e) {
            // If database is unavailable, return default value
            \Log::warning("Database unavailable for setting {$key}, using default: " . $e->getMessage());
            return $default;
        }
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        
        // Clear cache
        Cache::forget("setting.{$key}");
        
        return $setting;
    }

    /**
     * Get multiple settings at once
     */
    public static function getMultiple(array $keys)
    {
        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = static::get($key);
        }
        return $settings;
    }

    /**
     * Set multiple settings at once
     */
    public static function setMultiple(array $data)
    {
        foreach ($data as $key => $value) {
            static::set($key, $value);
        }
    }

    /**
     * Get all settings as key-value array
     */
    public static function getAll()
    {
        try {
            return Cache::remember('settings.all', 3600, function () {
                return static::pluck('value', 'key')->toArray();
            });
        } catch (\Exception $e) {
            // If database is unavailable, return empty array
            \Log::warning("Database unavailable for settings, returning empty array: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        Cache::forget('settings.all');
        // Clear individual setting caches
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("setting.{$key}");
        }
    }
}
