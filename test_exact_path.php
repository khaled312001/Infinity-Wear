<?php
/**
 * اختبار المسار بالضبط كما في الكود
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ImporterOrder;

echo "===========================================\n";
echo "اختبار المسار بالضبط كما في الكود\n";
echo "===========================================\n\n";

// البحث عن الطلب
$order = ImporterOrder::where('design_details', 'like', '%xk1Jw6GXEVphwkGlNs1JcuzkFvOIAOxxdrXLiNVO.jpg%')->first();

if ($order) {
    $designDetails = is_string($order->design_details) ? json_decode($order->design_details, true) : $order->design_details;
    
    if (isset($designDetails['file_path'])) {
        $filePath = $designDetails['file_path'];
        echo "مسار الملف من قاعدة البيانات: " . $filePath . "\n";
        
        // نفس الكود المستخدم في Blade
        $fullPath = public_path('storage/' . $filePath);
        echo "المسار الكامل: " . $fullPath . "\n";
        echo "موجود: " . (file_exists($fullPath) ? 'نعم' : 'لا') . "\n";
        
        // فحص المسارات البديلة
        $alternativePath1 = public_path('storage/designs/' . basename($filePath));
        echo "المسار البديل 1: " . $alternativePath1 . "\n";
        echo "موجود في المسار البديل 1: " . (file_exists($alternativePath1) ? 'نعم' : 'لا') . "\n";
        
        $alternativePath2 = storage_path('app/public/' . $filePath);
        echo "المسار البديل 2: " . $alternativePath2 . "\n";
        echo "موجود في المسار البديل 2: " . (file_exists($alternativePath2) ? 'نعم' : 'لا') . "\n";
        
        // فحص محتويات مجلد public/storage/designs
        $designsDir = public_path('storage/designs');
        echo "\nمحتوى مجلد designs:\n";
        if (is_dir($designsDir)) {
            $files = scandir($designsDir);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    echo "  - " . $file . "\n";
                }
            }
        } else {
            echo "المجلد غير موجود\n";
        }
    }
}

echo "\n===========================================\n";
echo "اكتمل الاختبار!\n";
echo "===========================================\n";
