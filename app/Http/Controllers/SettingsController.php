<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class SettingsController extends Controller
{
    /**
     * تحديث إعدادات عامة
     */
    public function updateGeneral(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'site_name' => 'required|string|max:255',
                'site_tagline' => 'nullable|string|max:255',
                'site_description' => 'required|string',
                'default_language' => 'nullable|string|in:ar,en',
                'default_currency' => 'nullable|string|in:SAR,USD,EUR',
                'timezone' => 'nullable|string',
            ]);

            Setting::setMultiple($validatedData);
            Setting::clearCache();
            \App\Helpers\SiteSettingsHelper::clearCache();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الإعدادات العامة بنجاح'
            ]);

        } catch (\Exception $e) {
            Log::error('General settings update failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الإعدادات: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تحديث معلومات الاتصال
     */
    public function updateContact(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'contact_email' => 'required|email',
                'contact_phone' => 'required|string',
                'whatsapp_number' => 'nullable|string',
                'whatsapp_message' => 'nullable|string',
                'whatsapp_floating_enabled' => 'boolean',
                'support_email' => 'nullable|email',
                'address' => 'required|string',
                'business_hours' => 'nullable|string',
                'emergency_contact' => 'nullable|string',
            ]);

            // تحويل القيمة المنطقية
            $validatedData['whatsapp_floating_enabled'] = $request->has('whatsapp_floating_enabled') ? 1 : 0;

            Setting::setMultiple($validatedData);
            Setting::clearCache();
            \App\Helpers\SiteSettingsHelper::clearCache();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث معلومات الاتصال بنجاح'
            ]);

        } catch (\Exception $e) {
            Log::error('Contact settings update failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث معلومات الاتصال: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تحديث وسائل التواصل الاجتماعي
     */
    public function updateSocial(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'facebook_url' => 'nullable|url',
                'twitter_url' => 'nullable|url',
                'instagram_url' => 'nullable|url',
                'linkedin_url' => 'nullable|url',
                'youtube_url' => 'nullable|url',
                'tiktok_url' => 'nullable|url',
            ]);

            Setting::setMultiple($validatedData);
            Setting::clearCache();
            \App\Helpers\SiteSettingsHelper::clearCache();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث وسائل التواصل الاجتماعي بنجاح'
            ]);

        } catch (\Exception $e) {
            Log::error('Social settings update failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث وسائل التواصل: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تحديث إعدادات النظام
     */
    public function updateSystem(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'enable_registration' => 'boolean',
                'email_verification' => 'boolean',
                'maintenance_mode' => 'boolean',
                'debug_mode' => 'boolean',
                'backup_frequency' => 'nullable|string|in:daily,weekly,monthly',
                'log_level' => 'nullable|string|in:error,warning,info,debug',
                'session_timeout' => 'nullable|integer|min:30|max:1440',
            ]);

            // تحويل القيم المنطقية
            $validatedData['enable_registration'] = $request->has('enable_registration') ? 1 : 0;
            $validatedData['email_verification'] = $request->has('email_verification') ? 1 : 0;
            $validatedData['maintenance_mode'] = $request->has('maintenance_mode') ? 1 : 0;
            $validatedData['debug_mode'] = $request->has('debug_mode') ? 1 : 0;

            Setting::setMultiple($validatedData);
            Setting::clearCache();
            \App\Helpers\SiteSettingsHelper::clearCache();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث إعدادات النظام بنجاح'
            ]);

        } catch (\Exception $e) {
            Log::error('System settings update failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث إعدادات النظام: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * رفع الفافيكون
     */
    public function uploadFavicon(Request $request)
    {
        try {
            if (!$request->hasFile('favicon')) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم اختيار ملف'
                ], 400);
            }

            $faviconFile = $request->file('favicon');
            
            if (!$faviconFile->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ملف الأيقونة غير صالح'
                ], 400);
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml', 'image/webp', 'image/avif'];
            if (!in_array($faviconFile->getMimeType(), $allowedTypes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'نوع الملف غير مدعوم'
                ], 400);
            }

            if ($faviconFile->getSize() > 1024 * 1024) { // 1MB
                return response()->json([
                    'success' => false,
                    'message' => 'حجم الملف كبير جداً. الحد الأقصى 1MB'
                ], 400);
            }

            // حذف الفافيكون القديم
            $oldFavicon = Setting::get('site_favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }

            // حفظ الفافيكون الجديد
            $faviconPath = $faviconFile->store('favicons', 'public');
            Setting::set('site_favicon', $faviconPath);
            
            Setting::clearCache();
            \App\Helpers\SiteSettingsHelper::clearCache();

            return response()->json([
                'success' => true,
                'message' => 'تم رفع الأيقونة بنجاح',
                'favicon_url' => asset('storage/' . $faviconPath)
            ]);

        } catch (\Exception $e) {
            Log::error('Favicon upload failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء رفع الأيقونة: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * الحصول على جميع الإعدادات
     */
    public function getAllSettings()
    {
        $settings = Setting::getAll();
        return response()->json([
            'success' => true,
            'settings' => $settings
        ]);
    }

    /**
     * تنظيف الكاش
     */
    public function clearCache()
    {
        try {
            \Illuminate\Support\Facades\Cache::flush();
            Setting::clearCache();
            \App\Helpers\SiteSettingsHelper::clearCache();

            return response()->json([
                'success' => true,
                'message' => 'تم تنظيف الكاش بنجاح'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تنظيف الكاش'
            ], 500);
        }
    }
}
