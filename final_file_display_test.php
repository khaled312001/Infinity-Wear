<?php
/**
 * اختبار نهائي لنظام عرض الملفات
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ImporterOrder;

echo "===========================================\n";
echo "اختبار نهائي لنظام عرض الملفات\n";
echo "===========================================\n\n";

// البحث عن الطلب
$order = ImporterOrder::where('design_details', 'like', '%xk1Jw6GXEVphwkGlNs1JcuzkFvOIAOxxdrXLiNVO.jpg%')->first();

if ($order) {
    echo "طلب رقم: " . $order->order_number . "\n";
    
    $designDetails = is_string($order->design_details) ? json_decode($order->design_details, true) : $order->design_details;
    
    if (isset($designDetails['file_path'])) {
        $filePath = $designDetails['file_path'];
        echo "مسار الملف: " . $filePath . "\n";
        
        // نفس الكود المستخدم في Blade مع التحسينات
        $fullPath = public_path('storage/' . $filePath);
        $fileExists = file_exists($fullPath);
        $fileUrl = asset('storage/' . $filePath);
        
        echo "المسار الأساسي: " . $fullPath . "\n";
        echo "موجود في المسار الأساسي: " . ($fileExists ? 'نعم' : 'لا') . "\n";
        
        // معالجة إضافية للتحقق من وجود الملف
        if (!$fileExists) {
            // محاولة مسارات بديلة
            $alternativePath1 = public_path('storage/designs/' . basename($filePath));
            $alternativePath2 = storage_path('app/public/' . $filePath);
            
            echo "المسار البديل 1: " . $alternativePath1 . "\n";
            echo "موجود في المسار البديل 1: " . (file_exists($alternativePath1) ? 'نعم' : 'لا') . "\n";
            
            echo "المسار البديل 2: " . $alternativePath2 . "\n";
            echo "موجود في المسار البديل 2: " . (file_exists($alternativePath2) ? 'نعم' : 'لا') . "\n";
            
            if (file_exists($alternativePath1)) {
                $fileExists = true;
                $fullPath = $alternativePath1;
                $fileUrl = asset('storage/designs/' . basename($filePath));
                echo "✓ تم العثور على الملف في المسار البديل 1\n";
            } elseif (file_exists($alternativePath2)) {
                $fileExists = true;
                $fullPath = $alternativePath2;
                $fileUrl = asset('storage/' . $filePath);
                echo "✓ تم العثور على الملف في المسار البديل 2\n";
            }
        }
        
        echo "النتيجة النهائية: " . ($fileExists ? 'نعم' : 'لا') . "\n";
        echo "رابط الملف: " . $fileUrl . "\n";
        
        if ($fileExists) {
            echo "✓ الملف يجب أن يظهر في الصفحة\n";
            
            // فحص نوع الملف
            if (str_contains($filePath, '.jpg') || str_contains($filePath, '.jpeg') || str_contains($filePath, '.png') || str_contains($filePath, '.gif') || str_contains($filePath, '.webp')) {
                echo "✓ نوع الملف: صورة - يجب أن تظهر معاينة\n";
            } else {
                echo "✗ نوع الملف: ليس صورة\n";
            }
        } else {
            echo "✗ الملف غير موجود - سيظهر رسالة الخطأ\n";
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
