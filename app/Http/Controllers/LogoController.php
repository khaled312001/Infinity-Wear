<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class LogoController extends Controller
{
    /**
     * رفع شعار جديد
     */
    public function uploadLogo(Request $request)
    {
        try {
            // التحقق من وجود الملف
            if (!$request->hasFile('logo')) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم اختيار ملف'
                ], 400);
            }

            $logoFile = $request->file('logo');
            
            // التحقق من صحة الملف
            if (!$logoFile->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'ملف الشعار غير صالح'
                ], 400);
            }

            // التحقق من نوع الملف
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml', 'image/webp', 'image/avif'];
            if (!in_array($logoFile->getMimeType(), $allowedTypes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'نوع الملف غير مدعوم'
                ], 400);
            }

            // التحقق من حجم الملف (2MB)
            if ($logoFile->getSize() > 2 * 1024 * 1024) {
                return response()->json([
                    'success' => false,
                    'message' => 'حجم الملف كبير جداً. الحد الأقصى 2MB'
                ], 400);
            }

            // حذف الشعار القديم
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // حفظ الشعار الجديد
            $logoPath = $logoFile->store('logos', 'public');
            
            // حفظ المسار في قاعدة البيانات
            Setting::set('site_logo', $logoPath);
            
            // مسح الكاش
            Setting::clearCache();
            \App\Helpers\SiteSettingsHelper::clearCache();

            Log::info('Logo uploaded successfully', [
                'logo_path' => $logoPath,
                'file_name' => $logoFile->getClientOriginalName(),
                'file_size' => $logoFile->getSize()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم رفع الشعار بنجاح',
                'logo_url' => asset('storage/' . $logoPath)
            ]);

        } catch (\Exception $e) {
            Log::error('Logo upload failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء رفع الشعار: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * حذف الشعار
     */
    public function deleteLogo()
    {
        try {
            $currentLogo = Setting::get('site_logo');
            
            if ($currentLogo && Storage::disk('public')->exists($currentLogo)) {
                Storage::disk('public')->delete($currentLogo);
            }
            
            Setting::set('site_logo', '');
            Setting::clearCache();
            \App\Helpers\SiteSettingsHelper::clearCache();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الشعار بنجاح'
            ]);

        } catch (\Exception $e) {
            Log::error('Logo deletion failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف الشعار'
            ], 500);
        }
    }

    /**
     * الحصول على معلومات الشعار الحالي
     */
    public function getLogoInfo()
    {
        $logo = Setting::get('site_logo');
        
        return response()->json([
            'success' => true,
            'has_logo' => !empty($logo),
            'logo_url' => \App\Helpers\SiteSettingsHelper::getLogoUrl(),
            'logo_path' => $logo
        ]);
    }
}
