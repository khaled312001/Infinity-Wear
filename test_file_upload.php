<?php
/**
 * اختبار رفع ملف تصميم
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Storage;

echo "===========================================\n";
echo "اختبار رفع ملف تصميم\n";
echo "===========================================\n\n";

// إنشاء ملف اختبار
$testContent = "Test design file content";
$testFileName = 'test_design_' . time() . '.txt';

try {
    // رفع الملف
    $filePath = Storage::disk('public')->put('designs/' . $testFileName, $testContent);
    echo "✓ تم رفع الملف بنجاح\n";
    echo "مسار الملف: " . $filePath . "\n";
    
    // التحقق من وجود الملف
    if (Storage::disk('public')->exists('designs/' . $testFileName)) {
        echo "✓ الملف موجود في التخزين\n";
        
        // قراءة محتوى الملف
        $content = Storage::disk('public')->get('designs/' . $testFileName);
        echo "محتوى الملف: " . $content . "\n";
        
        // التحقق من الرابط الرمزي
        $publicPath = public_path('storage/designs/' . $testFileName);
        if (file_exists($publicPath)) {
            echo "✓ الملف متاح عبر الرابط الرمزي\n";
            echo "المسار العام: " . $publicPath . "\n";
        } else {
            echo "✗ الملف غير متاح عبر الرابط الرمزي\n";
        }
        
        // حذف الملف التجريبي
        Storage::disk('public')->delete('designs/' . $testFileName);
        echo "✓ تم حذف الملف التجريبي\n";
        
    } else {
        echo "✗ الملف غير موجود في التخزين\n";
    }
    
} catch (Exception $e) {
    echo "✗ خطأ في رفع الملف: " . $e->getMessage() . "\n";
}

echo "\n===========================================\n";
echo "اكتمل الاختبار!\n";
echo "===========================================\n";
