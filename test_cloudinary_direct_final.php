<?php
/**
 * اختبار Cloudinary مباشرة مع الاسم الصحيح
 */

require __DIR__ . '/vendor/autoload.php';

echo "===========================================\n";
echo "اختبار Cloudinary مباشرة مع الاسم الصحيح\n";
echo "===========================================\n\n";

try {
    $cloudinary = new \Cloudinary\Cloudinary([
        'cloud' => [
            'cloud_name' => 'dhx24m770',
            'api_key' => '787844769525158',
            'api_secret' => 'uZa3Vo50vIgiE4UizMtVMW_OAHI',
        ],
        'url' => [
            'secure' => true,
        ],
    ]);
    
    echo "✓ تم إنشاء Cloudinary بنجاح\n";
    
    // اختبار ping
    $pingResult = $cloudinary->adminApi()->ping();
    echo "✓ Ping نجح: " . json_encode($pingResult) . "\n";
    
    // اختبار رفع صورة
    $testImagePath = __DIR__ . '/public/storage/designs/xk1Jw6GXEVphwkGlNs1JcuzkFvOIAOxxdrXLiNVO.jpg';
    
    if (file_exists($testImagePath)) {
        echo "\nاختبار رفع صورة...\n";
        echo "الملف: " . basename($testImagePath) . "\n";
        
        $uploadResult = $cloudinary->uploadApi()->upload($testImagePath, [
            'folder' => 'infinitywearsa/designs',
            'quality' => 'auto',
            'format' => 'auto',
        ]);
        
        echo "✅ تم رفع الصورة بنجاح!\n";
        echo "Public ID: " . $uploadResult['public_id'] . "\n";
        echo "Secure URL: " . $uploadResult['secure_url'] . "\n";
        echo "Format: " . $uploadResult['format'] . "\n";
        echo "Size: " . $uploadResult['bytes'] . " bytes\n";
        echo "Width: " . $uploadResult['width'] . "px\n";
        echo "Height: " . $uploadResult['height'] . "px\n";
        
        echo "\n🔗 يمكنك رؤية الصورة في: https://console.cloudinary.com/\n";
        echo "📁 مجلد: infinitywearsa/designs\n";
        
    } else {
        echo "⚠ صورة الاختبار غير موجودة: " . $testImagePath . "\n";
    }
    
} catch (Exception $e) {
    echo "✗ خطأ: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n===========================================\n";
echo "اكتمل الاختبار!\n";
echo "===========================================\n";
