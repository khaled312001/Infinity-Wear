<?php
/**
 * فحص الملف المحدد في قاعدة البيانات
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ImporterOrder;

echo "===========================================\n";
echo "فحص الملف المحدد في قاعدة البيانات\n";
echo "===========================================\n\n";

// البحث عن الطلب الذي يحتوي على الملف المحدد
$order = ImporterOrder::where('design_details', 'like', '%xk1Jw6GXEVphwkGlNs1JcuzkFvOIAOxxdrXLiNVO.jpg%')->first();

if ($order) {
    echo "تم العثور على الطلب:\n";
    echo "رقم الطلب: " . $order->order_number . "\n";
    echo "معرف الطلب: " . $order->id . "\n";
    echo "تفاصيل التصميم: " . $order->design_details . "\n\n";
    
    $designDetails = is_string($order->design_details) ? json_decode($order->design_details, true) : $order->design_details;
    
    if (isset($designDetails['file_path'])) {
        $filePath = $designDetails['file_path'];
        echo "مسار الملف: " . $filePath . "\n";
        
        // فحص وجود الملف في التخزين
        $storagePath = storage_path('app/public/' . $filePath);
        echo "مسار التخزين: " . $storagePath . "\n";
        echo "موجود في التخزين: " . (file_exists($storagePath) ? 'نعم' : 'لا') . "\n";
        
        // فحص وجود الملف في الرابط الرمزي
        $publicPath = public_path('storage/' . $filePath);
        echo "مسار الرابط الرمزي: " . $publicPath . "\n";
        echo "موجود في الرابط الرمزي: " . (file_exists($publicPath) ? 'نعم' : 'لا') . "\n";
        
        if (file_exists($publicPath)) {
            echo "حجم الملف: " . filesize($publicPath) . " بايت\n";
            echo "رابط الملف: " . asset('storage/' . $filePath) . "\n";
        }
    }
} else {
    echo "لم يتم العثور على طلب يحتوي على هذا الملف\n";
}

echo "\n===========================================\n";
echo "اكتمل الفحص!\n";
echo "===========================================\n";
