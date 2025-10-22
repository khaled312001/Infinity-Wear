<?php
/**
 * اختبار Cloudinary مع الاسم الصحيح
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\CloudinaryService;

echo "===========================================\n";
echo "اختبار Cloudinary مع الاسم الصحيح\n";
echo "===========================================\n\n";

try {
    $cloudinaryService = new CloudinaryService();
    
    echo "1. فحص توفر Cloudinary...\n";
    if ($cloudinaryService->isAvailable()) {
        echo "✓ Cloudinary متاح\n";
    } else {
        echo "✗ Cloudinary غير متاح\n";
    }
    
    echo "\n2. اختبار رفع صورة...\n";
    
    // إنشاء ملف اختبار
    $testImagePath = public_path('storage/designs/xk1Jw6GXEVphwkGlNs1JcuzkFvOIAOxxdrXLiNVO.jpg');
    
    if (file_exists($testImagePath)) {
        echo "تم العثور على صورة اختبار: " . basename($testImagePath) . "\n";
        
        // محاكاة UploadedFile
        $file = new \Illuminate\Http\UploadedFile(
            $testImagePath,
            basename($testImagePath),
            mime_content_type($testImagePath),
            null,
            true
        );
        
        // رفع الصورة
        $uploadResult = $cloudinaryService->uploadFile($file, 'infinitywearsa/designs');
        
        if ($uploadResult['success']) {
            echo "✓ تم رفع الصورة بنجاح!\n";
            echo "Public ID: " . $uploadResult['public_id'] . "\n";
            echo "Secure URL: " . $uploadResult['secure_url'] . "\n";
            echo "Format: " . $uploadResult['format'] . "\n";
            echo "Size: " . $uploadResult['bytes'] . " bytes\n";
            
            if (isset($uploadResult['local_storage']) && $uploadResult['local_storage']) {
                echo "⚠ تم الحفظ محلياً فقط\n";
            } else {
                echo "✅ تم الحفظ في Cloudinary بنجاح!\n";
                echo "🔗 يمكنك رؤيتها في: https://console.cloudinary.com/\n";
            }
        } else {
            echo "✗ فشل في رفع الصورة\n";
            if (isset($uploadResult['error'])) {
                echo "الخطأ: " . $uploadResult['error'] . "\n";
            }
        }
    } else {
        echo "⚠ صورة الاختبار غير موجودة: " . $testImagePath . "\n";
    }
    
    echo "\n3. فحص إعدادات Cloudinary...\n";
    echo "Cloud Name: " . config('cloudinary.cloud_name') . "\n";
    echo "API Key: " . config('cloudinary.api_key') . "\n";
    echo "Default Folder: " . config('cloudinary.default_folder') . "\n";
    
    echo "\n===========================================\n";
    echo "اكتمل الاختبار!\n";
    echo "===========================================\n";
    
    if ($cloudinaryService->isAvailable()) {
        echo "✅ الصور ستُحفظ في Cloudinary عند التسجيل\n";
        echo "🔗 يمكنك رؤيتها في: https://console.cloudinary.com/\n";
        echo "📁 مجلد الصور: infinitywearsa/designs\n";
    } else {
        echo "⚠ الصور ستُحفظ محلياً فقط\n";
    }
    
} catch (Exception $e) {
    echo "✗ خطأ في الاختبار: " . $e->getMessage() . "\n";
}
