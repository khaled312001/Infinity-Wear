<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;
use App\Services\CloudinaryService;

class LogoController extends Controller
{
    protected $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }
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

            // حذف الشعار القديم من Cloudinary والمحلي
            $oldLogoData = Setting::get('site_logo_data');
            if ($oldLogoData) {
                $oldData = json_decode($oldLogoData, true);
                if (isset($oldData['cloudinary']['public_id'])) {
                    $this->cloudinaryService->deleteFile($oldData['cloudinary']['public_id']);
                }
                if (isset($oldData['file_path']) && Storage::disk('public')->exists($oldData['file_path'])) {
                    Storage::disk('public')->delete($oldData['file_path']);
                }
            }

            // رفع الشعار إلى Cloudinary
            $uploadResult = $this->cloudinaryService->uploadFile($logoFile, 'infinitywearsa/logos');
            
            if ($uploadResult['success']) {
                // حفظ الشعار محلياً كـ backup
                $logoPath = $logoFile->store('logos', 'public');
                
                // حفظ بيانات Cloudinary والمحلي
                $logoData = [
                    'cloudinary' => [
                        'public_id' => $uploadResult['public_id'],
                        'secure_url' => $uploadResult['secure_url'],
                        'url' => $uploadResult['url'],
                        'format' => $uploadResult['format'],
                        'width' => $uploadResult['width'],
                        'height' => $uploadResult['height'],
                        'bytes' => $uploadResult['bytes'],
                    ],
                    'file_path' => $logoPath,
                    'uploaded_at' => now()->toISOString(),
                ];
                
                Setting::set('site_logo', $logoPath); // للتوافق مع النظام القديم
                Setting::set('site_logo_data', json_encode($logoData));
                
                // Auto-set favicon to use the same logo image
                $this->setFaviconFromLogo($logoData, $logoPath);
                
                // مسح الكاش
                Setting::clearCache();
                \App\Helpers\SiteSettingsHelper::clearCache();

                Log::info('Logo uploaded to Cloudinary successfully', [
                    'public_id' => $uploadResult['public_id'],
                    'file_name' => $logoFile->getClientOriginalName(),
                    'file_size' => $logoFile->getSize(),
                    'cloudinary_url' => $uploadResult['secure_url']
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'تم رفع الشعار بنجاح إلى السحابة وتم تعيين أيقونة الموقع تلقائياً',
                    'logo_url' => $uploadResult['secure_url'],
                    'cloudinary_data' => $logoData['cloudinary'],
                    'favicon_auto_set' => true
                ]);
            } else {
                // في حالة فشل الرفع إلى Cloudinary، استخدم التخزين المحلي فقط
                $logoPath = $logoFile->store('logos', 'public');
                
                $logoData = [
                    'file_path' => $logoPath,
                    'uploaded_at' => now()->toISOString(),
                    'cloudinary_error' => $uploadResult['error'] ?? 'Unknown error',
                ];
                
                Setting::set('site_logo', $logoPath);
                Setting::set('site_logo_data', json_encode($logoData));
                
                // Auto-set favicon to use the same logo image
                $this->setFaviconFromLogo($logoData, $logoPath);
                
                Setting::clearCache();
                \App\Helpers\SiteSettingsHelper::clearCache();

                Log::warning('Cloudinary upload failed, using local storage', [
                    'error' => $uploadResult['error'] ?? 'Unknown error',
                    'file_name' => $logoFile->getClientOriginalName(),
                    'local_path' => $logoPath
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'تم رفع الشعار محلياً وتم تعيين أيقونة الموقع تلقائياً (فشل الرفع إلى السحابة)',
                    'logo_url' => asset('storage/' . $logoPath),
                    'warning' => 'تم الحفظ محلياً فقط',
                    'favicon_auto_set' => true
                ]);
            }

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
            $logoData = Setting::get('site_logo_data');
            $legacyLogo = Setting::get('site_logo');
            
            Log::info('Starting logo deletion', [
                'has_logo_data' => !empty($logoData),
                'has_legacy_logo' => !empty($legacyLogo)
            ]);
            
            if ($logoData) {
                $data = json_decode($logoData, true);
                
                if ($data) {
                    // حذف من Cloudinary
                    if (isset($data['cloudinary']['public_id'])) {
                        $deleteResult = $this->cloudinaryService->deleteFile($data['cloudinary']['public_id']);
                        if ($deleteResult['success']) {
                            Log::info('Logo deleted from Cloudinary', ['public_id' => $data['cloudinary']['public_id']]);
                        } else {
                            Log::warning('Failed to delete logo from Cloudinary', ['error' => $deleteResult['error']]);
                        }
                    }
                    
                    // حذف من التخزين المحلي
                    if (isset($data['file_path']) && Storage::disk('public')->exists($data['file_path'])) {
                        Storage::disk('public')->delete($data['file_path']);
                        Log::info('Logo deleted from local storage', ['path' => $data['file_path']]);
                    }
                }
            }
            
            // حذف الملف المحلي القديم أيضاً
            if ($legacyLogo && Storage::disk('public')->exists($legacyLogo)) {
                Storage::disk('public')->delete($legacyLogo);
                Log::info('Legacy logo deleted from local storage', ['path' => $legacyLogo]);
            }
            
            // حذف البيانات من قاعدة البيانات
            Setting::set('site_logo', '');
            Setting::set('site_logo_data', '');
            Setting::clearCache();
            \App\Helpers\SiteSettingsHelper::clearCache();

            Log::info('Logo deletion completed successfully');

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الشعار بنجاح من السحابة والمحلي'
            ]);

        } catch (\Exception $e) {
            Log::error('Logo deletion failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف الشعار: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * الحصول على معلومات الشعار الحالي
     */
    public function getLogoInfo()
    {
        $logoData = Setting::get('site_logo_data');
        $legacyLogo = Setting::get('site_logo');
        
        if ($logoData) {
            $data = json_decode($logoData, true);
            
            return response()->json([
                'success' => true,
                'has_logo' => true,
                'logo_url' => $data['cloudinary']['secure_url'] ?? asset('storage/' . $data['file_path']),
                'logo_path' => $data['file_path'] ?? $legacyLogo,
                'cloudinary_data' => $data['cloudinary'] ?? null,
                'is_cloudinary' => isset($data['cloudinary']['secure_url']),
                'uploaded_at' => $data['uploaded_at'] ?? null
            ]);
        }
        
        // للتوافق مع النظام القديم
        return response()->json([
            'success' => true,
            'has_logo' => !empty($legacyLogo),
            'logo_url' => \App\Helpers\SiteSettingsHelper::getLogoUrl(),
            'logo_path' => $legacyLogo,
            'is_cloudinary' => false
        ]);
    }

    /**
     * Set favicon to use the same image as logo
     */
    private function setFaviconFromLogo(array $logoData, string $logoPath)
    {
        try {
            // Create favicon data based on logo data
            $faviconData = [
                'cloudinary' => $logoData['cloudinary'] ?? null,
                'file_path' => $logoPath, // Use the same file path
                'uploaded_at' => now()->toISOString(),
                'auto_generated_from_logo' => true, // Mark as auto-generated
            ];

            // If logo has Cloudinary data, create a favicon-specific Cloudinary entry
            if (isset($logoData['cloudinary'])) {
                // Create a new Cloudinary entry for favicon with different folder
                $faviconCloudinaryData = $logoData['cloudinary'];
                $faviconCloudinaryData['public_id'] = str_replace('infinitywearsa/logos/', 'infinitywearsa/favicons/', $faviconCloudinaryData['public_id']);
                $faviconData['cloudinary'] = $faviconCloudinaryData;
            }

            // Save favicon data
            Setting::set('site_favicon', $logoPath); // Use same path for compatibility
            Setting::set('site_favicon_data', json_encode($faviconData));

            Log::info('Favicon automatically set from logo', [
                'logo_cloudinary_id' => $logoData['cloudinary']['public_id'] ?? 'none',
                'favicon_path' => $logoPath,
                'auto_generated' => true
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to auto-set favicon from logo', [
                'error' => $e->getMessage(),
                'logo_data' => $logoData
            ]);
        }
    }
}
