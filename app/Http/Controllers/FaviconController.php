<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class FaviconController extends Controller
{
    /**
     * رفع أيقونة موقع جديدة
     */
    public function uploadFavicon(Request $request)
    {
        try {
            // التحقق من وجود الملف
            if (!$request->hasFile('favicon')) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم اختيار ملف'
                ], 400);
            }

            $faviconFile = $request->file('favicon');
            
            // التحقق من صحة الملف
            if (!$faviconFile->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ملف أيقونة الموقع غير صالح'
                ], 400);
            }

            // التحقق من نوع الملف
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml', 'image/webp', 'image/avif'];
            if (!in_array($faviconFile->getMimeType(), $allowedTypes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'نوع الملف غير مدعوم'
                ], 400);
            }

            // التحقق من حجم الملف (1MB)
            if ($faviconFile->getSize() > 1 * 1024 * 1024) {
                return response()->json([
                    'success' => false,
                    'message' => 'حجم الملف كبير جداً. الحد الأقصى 1MB'
                ], 400);
            }

            // حذف أيقونة الموقع القديمة
            $oldFavicon = Setting::get('site_favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }

            // حفظ أيقونة الموقع الجديدة
            $faviconPath = $faviconFile->store('settings', 'public');
            
            // حفظ المسار في قاعدة البيانات
            Setting::set('site_favicon', $faviconPath);
            
            // مسح الكاش
            Setting::clearCache();
            \App\Helpers\SiteSettingsHelper::clearCache();

            Log::info('Favicon uploaded successfully', [
                'favicon_path' => $faviconPath,
                'file_name' => $faviconFile->getClientOriginalName(),
                'file_size' => $faviconFile->getSize()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم رفع أيقونة الموقع بنجاح',
                'favicon_url' => asset('storage/' . $faviconPath)
            ]);

        } catch (\Exception $e) {
            Log::error('Favicon upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء رفع أيقونة الموقع: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * حذف أيقونة الموقع
     */
    public function deleteFavicon()
    {
        try {
            // الحصول على أيقونة الموقع الحالية
            $currentFavicon = Setting::get('site_favicon');
            
            if (!$currentFavicon) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا توجد أيقونة موقع محفوظة'
                ], 400);
            }

            // حذف الملف من التخزين
            if (Storage::disk('public')->exists($currentFavicon)) {
                Storage::disk('public')->delete($currentFavicon);
            }

            // حذف المسار من قاعدة البيانات
            Setting::set('site_favicon', null);
            
            // مسح الكاش
            Setting::clearCache();
            \App\Helpers\SiteSettingsHelper::clearCache();

            Log::info('Favicon deleted successfully', [
                'deleted_favicon' => $currentFavicon
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم حذف أيقونة الموقع بنجاح'
            ]);

        } catch (\Exception $e) {
            Log::error('Favicon deletion failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف أيقونة الموقع: ' . $e->getMessage()
            ], 500);
        }
    }
}
