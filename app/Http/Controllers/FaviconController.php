<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;
use App\Services\CloudinaryService;

class FaviconController extends Controller
{
    protected $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }
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

            // حذف الأيقونة القديمة من Cloudinary والمحلي
            $oldFaviconData = Setting::get('site_favicon_data');
            if ($oldFaviconData) {
                $oldData = json_decode($oldFaviconData, true);
                if (isset($oldData['cloudinary']['public_id'])) {
                    $this->cloudinaryService->deleteFile($oldData['cloudinary']['public_id']);
                }
                if (isset($oldData['file_path']) && Storage::disk('public')->exists($oldData['file_path'])) {
                    Storage::disk('public')->delete($oldData['file_path']);
                }
            }

            // رفع الأيقونة إلى Cloudinary
            $uploadResult = $this->cloudinaryService->uploadFile($faviconFile, 'infinitywearsa/favicons');
            
            if ($uploadResult['success']) {
                // حفظ الأيقونة محلياً كـ backup
                $faviconPath = $faviconFile->store('settings', 'public');
                
                // حفظ بيانات Cloudinary والمحلي
                $faviconData = [
                    'cloudinary' => [
                        'public_id' => $uploadResult['public_id'],
                        'secure_url' => $uploadResult['secure_url'],
                        'url' => $uploadResult['url'],
                        'format' => $uploadResult['format'],
                        'width' => $uploadResult['width'],
                        'height' => $uploadResult['height'],
                        'bytes' => $uploadResult['bytes'],
                    ],
                    'file_path' => $faviconPath,
                    'uploaded_at' => now()->toISOString(),
                ];
                
                Setting::set('site_favicon', $faviconPath); // للتوافق مع النظام القديم
                Setting::set('site_favicon_data', json_encode($faviconData));
                
                // مسح الكاش
                Setting::clearCache();
                \App\Helpers\SiteSettingsHelper::clearCache();

                Log::info('Favicon uploaded to Cloudinary successfully', [
                    'public_id' => $uploadResult['public_id'],
                    'file_name' => $faviconFile->getClientOriginalName(),
                    'file_size' => $faviconFile->getSize(),
                    'cloudinary_url' => $uploadResult['secure_url']
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'تم رفع أيقونة الموقع بنجاح إلى السحابة',
                    'favicon_url' => $uploadResult['secure_url'],
                    'cloudinary_data' => $faviconData['cloudinary']
                ]);
            } else {
                // في حالة فشل الرفع إلى Cloudinary، استخدم التخزين المحلي فقط
                $faviconPath = $faviconFile->store('settings', 'public');
                
                $faviconData = [
                    'file_path' => $faviconPath,
                    'uploaded_at' => now()->toISOString(),
                    'cloudinary_error' => $uploadResult['error'] ?? 'Unknown error',
                ];
                
                Setting::set('site_favicon', $faviconPath);
                Setting::set('site_favicon_data', json_encode($faviconData));
                
                Setting::clearCache();
                \App\Helpers\SiteSettingsHelper::clearCache();

                Log::warning('Cloudinary upload failed, using local storage', [
                    'error' => $uploadResult['error'] ?? 'Unknown error',
                    'file_name' => $faviconFile->getClientOriginalName(),
                    'local_path' => $faviconPath
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'تم رفع أيقونة الموقع محلياً (فشل الرفع إلى السحابة)',
                    'favicon_url' => asset('storage/' . $faviconPath),
                    'warning' => 'تم الحفظ محلياً فقط'
                ]);
            }

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
            $faviconData = Setting::get('site_favicon_data');
            
            if ($faviconData) {
                $data = json_decode($faviconData, true);
                
                // حذف من Cloudinary
                if (isset($data['cloudinary']['public_id'])) {
                    $deleteResult = $this->cloudinaryService->deleteFile($data['cloudinary']['public_id']);
                    if ($deleteResult['success']) {
                        Log::info('Favicon deleted from Cloudinary', ['public_id' => $data['cloudinary']['public_id']]);
                    } else {
                        Log::warning('Failed to delete favicon from Cloudinary', ['error' => $deleteResult['error']]);
                    }
                }
                
                // حذف من التخزين المحلي
                if (isset($data['file_path']) && Storage::disk('public')->exists($data['file_path'])) {
                    Storage::disk('public')->delete($data['file_path']);
                    Log::info('Favicon deleted from local storage', ['path' => $data['file_path']]);
                }
            }
            
            // حذف البيانات من قاعدة البيانات
            Setting::set('site_favicon', '');
            Setting::set('site_favicon_data', '');
            Setting::clearCache();
            \App\Helpers\SiteSettingsHelper::clearCache();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف أيقونة الموقع بنجاح من السحابة والمحلي'
            ]);

        } catch (\Exception $e) {
            Log::error('Favicon deletion failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف أيقونة الموقع'
            ], 500);
        }
    }

    /**
     * الحصول على معلومات أيقونة الموقع الحالية
     */
    public function getFaviconInfo()
    {
        $faviconData = Setting::get('site_favicon_data');
        $legacyFavicon = Setting::get('site_favicon');
        
        if ($faviconData) {
            $data = json_decode($faviconData, true);
            
            return response()->json([
                'success' => true,
                'has_favicon' => true,
                'favicon_url' => $data['cloudinary']['secure_url'] ?? asset('storage/' . $data['file_path']),
                'favicon_path' => $data['file_path'] ?? $legacyFavicon,
                'cloudinary_data' => $data['cloudinary'] ?? null,
                'is_cloudinary' => isset($data['cloudinary']['secure_url']),
                'uploaded_at' => $data['uploaded_at'] ?? null,
                'auto_generated' => $data['auto_generated_from_logo'] ?? false
            ]);
        }
        
        // للتوافق مع النظام القديم
        return response()->json([
            'success' => true,
            'has_favicon' => !empty($legacyFavicon),
            'favicon_url' => \App\Helpers\SiteSettingsHelper::getFaviconUrl(),
            'favicon_path' => $legacyFavicon,
            'is_cloudinary' => false
        ]);
    }

    /**
     * تحديث أيقونة الموقع من الشعار
     */
    public function refreshFromLogo(Request $request)
    {
        try {
            // الحصول على بيانات الشعار
            $logoData = Setting::get('site_logo_data');
            if (!$logoData) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يوجد شعار محفوظ لتحديث الأيقونة منه'
                ], 400);
            }

            $logo = json_decode($logoData, true);
            if (!$logo) {
                return response()->json([
                    'success' => false,
                    'message' => 'بيانات الشعار غير صحيحة'
                ], 400);
            }

            // إنشاء بيانات الأيقونة من الشعار
            $faviconData = [
                'cloudinary' => $logo['cloudinary'] ?? null,
                'file_path' => $logo['file_path'] ?? null,
                'uploaded_at' => now()->toISOString(),
                'auto_generated_from_logo' => true,
            ];

            // إذا كان الشعار في Cloudinary، أنشئ إدخال منفصل للأيقونة
            if (isset($logo['cloudinary'])) {
                $faviconCloudinaryData = $logo['cloudinary'];
                $faviconCloudinaryData['public_id'] = str_replace('infinitywearsa/logos/', 'infinitywearsa/favicons/', $faviconCloudinaryData['public_id']);
                $faviconData['cloudinary'] = $faviconCloudinaryData;
            }

            // حفظ بيانات الأيقونة
            Setting::set('site_favicon', $logo['file_path'] ?? '');
            Setting::set('site_favicon_data', json_encode($faviconData));

            // الحصول على رابط الأيقونة الجديد
            $faviconUrl = \App\Helpers\SiteSettingsHelper::getFaviconUrl();

            Log::info('Favicon refreshed from logo', [
                'logo_cloudinary_id' => $logo['cloudinary']['public_id'] ?? 'none',
                'favicon_path' => $logo['file_path'] ?? 'none',
                'auto_generated' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث أيقونة الموقع من الشعار بنجاح',
                'favicon_url' => $faviconUrl,
                'auto_generated' => true
            ]);

        } catch (\Exception $e) {
            Log::error('Error refreshing favicon from logo', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث أيقونة الموقع من الشعار'
            ], 500);
        }
    }
}
