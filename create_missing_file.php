<?php
/**
 * إنشاء ملف اختبار بنفس اسم الملف المفقود
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Storage;

echo "===========================================\n";
echo "إنشاء ملف اختبار بنفس اسم الملف المفقود\n";
echo "===========================================\n\n";

$missingFileName = 'xk1Jw6GXEVphwkGlNs1JcuzkFvOIAOxxdrXLiNVO.jpg';
$testContent = "Test design file content for missing file";

try {
    // إنشاء الملف بنفس الاسم
    $filePath = Storage::disk('public')->put('designs/' . $missingFileName, $testContent);
    echo "✓ تم إنشاء الملف بنجاح\n";
    echo "مسار الملف: " . $filePath . "\n";
    
    // التحقق من وجود الملف
    if (Storage::disk('public')->exists('designs/' . $missingFileName)) {
        echo "✓ الملف موجود في التخزين\n";
        
        // التحقق من الرابط الرمزي
        $publicPath = public_path('storage/designs/' . $missingFileName);
        if (file_exists($publicPath)) {
            echo "✓ الملف متاح عبر الرابط الرمزي\n";
            echo "المسار العام: " . $publicPath . "\n";
            echo "URL: " . asset('storage/designs/' . $missingFileName) . "\n";
        } else {
            echo "✗ الملف غير متاح عبر الرابط الرمزي\n";
        }
        
    } else {
        echo "✗ الملف غير موجود في التخزين\n";
    }
    
} catch (Exception $e) {
    echo "✗ خطأ في إنشاء الملف: " . $e->getMessage() . "\n";
}

echo "\n===========================================\n";
echo "اكتمل الاختبار!\n";
echo "===========================================\n";
