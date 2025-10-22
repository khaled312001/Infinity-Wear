<?php
/**
 * اختبار الكود بالضبط كما في Blade
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ImporterOrder;

echo "===========================================\n";
echo "اختبار الكود بالضبط كما في Blade\n";
echo "===========================================\n\n";

// البحث عن الطلب
$order = ImporterOrder::where('design_details', 'like', '%xk1Jw6GXEVphwkGlNs1JcuzkFvOIAOxxdrXLiNVO.jpg%')->first();

if ($order) {
    $designDetails = is_string($order->design_details) ? json_decode($order->design_details, true) : $order->design_details;
    
    if (isset($designDetails['file_path'])) {
        $filePath = $designDetails['file_path'];
        echo "مسار الملف: " . $filePath . "\n";
        
        // نفس الكود المستخدم في Blade
        $fullPath = public_path('storage/' . $filePath);
        $fileExists = file_exists($fullPath);
        $fileUrl = asset('storage/' . $filePath);
        
        echo "المسار الكامل: " . $fullPath . "\n";
        echo "موجود: " . ($fileExists ? 'نعم' : 'لا') . "\n";
        echo "رابط الملف: " . $fileUrl . "\n";
        
        if ($fileExists) {
            echo "\n✓ الملف موجود - يجب أن يظهر في الصفحة\n";
            
            // فحص نوع الملف
            if (str_contains($filePath, '.jpg') || str_contains($filePath, '.jpeg') || str_contains($filePath, '.png') || str_contains($filePath, '.gif') || str_contains($filePath, '.webp')) {
                echo "✓ نوع الملف: صورة - يجب أن تظهر معاينة\n";
            } else {
                echo "✗ نوع الملف: ليس صورة\n";
            }
        } else {
            echo "\n✗ الملف غير موجود - سيظهر رسالة الخطأ\n";
        }
    } else {
        echo "✗ لا يوجد file_path في تفاصيل التصميم\n";
    }
} else {
    echo "✗ لم يتم العثور على الطلب\n";
}

echo "\n===========================================\n";
echo "اكتمل الاختبار!\n";
echo "===========================================\n";
