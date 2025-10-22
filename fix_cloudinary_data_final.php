<?php
/**
 * إصلاح بيانات Cloudinary القديمة
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ImporterOrder;
use App\Services\CloudinaryService;

echo "===========================================\n";
echo "إصلاح بيانات Cloudinary القديمة\n";
echo "===========================================\n\n";

try {
    $cloudinaryService = new CloudinaryService();
    
    if (!$cloudinaryService->isAvailable()) {
        echo "❌ Cloudinary غير متاح\n";
        exit;
    }
    
    echo "✅ Cloudinary متاح\n";
    
    // البحث عن الطلبات التي تحتوي على URLs خاطئة
    $orders = ImporterOrder::where('design_details', 'like', '%infinitywearsa.com/storage%')->get();
    
    echo "📊 عدد الطلبات التي تحتاج إصلاح: " . $orders->count() . "\n\n";
    
    foreach ($orders as $order) {
        echo "إصلاح طلب #" . $order->order_number . "...\n";
        
        $designDetails = json_decode($order->design_details, true);
        
        if (isset($designDetails['cloudinary']['secure_url'])) {
            $oldUrl = $designDetails['cloudinary']['secure_url'];
            echo "  URL القديم: " . $oldUrl . "\n";
            
            // استخراج اسم الملف من URL القديم
            $fileName = basename($oldUrl);
            $localPath = public_path('storage/designs/' . $fileName);
            
            if (file_exists($localPath)) {
                echo "  ✅ تم العثور على الملف المحلي: " . $fileName . "\n";
                
                // رفع الملف إلى Cloudinary
                $file = new \Illuminate\Http\UploadedFile(
                    $localPath,
                    $fileName,
                    mime_content_type($localPath),
                    null,
                    true
                );
                
                $uploadResult = $cloudinaryService->uploadFile($file, 'infinitywearsa/designs');
                
                if ($uploadResult['success'] && !isset($uploadResult['local_storage'])) {
                    echo "  ✅ تم رفع الملف إلى Cloudinary بنجاح\n";
                    echo "  Public ID: " . $uploadResult['public_id'] . "\n";
                    echo "  Secure URL: " . $uploadResult['secure_url'] . "\n";
                    
                    // تحديث البيانات
                    $designDetails['cloudinary'] = [
                        'public_id' => $uploadResult['public_id'],
                        'secure_url' => $uploadResult['secure_url'],
                        'url' => $uploadResult['url'],
                        'format' => $uploadResult['format'],
                        'width' => $uploadResult['width'],
                        'height' => $uploadResult['height'],
                        'bytes' => $uploadResult['bytes'],
                    ];
                    
                    $order->design_details = json_encode($designDetails);
                    $order->save();
                    
                    echo "  ✅ تم تحديث بيانات الطلب\n";
                } else {
                    echo "  ❌ فشل في رفع الملف إلى Cloudinary\n";
                }
            } else {
                echo "  ❌ الملف المحلي غير موجود: " . $localPath . "\n";
            }
        }
        
        echo "\n";
    }
    
    echo "===========================================\n";
    echo "اكتمل الإصلاح!\n";
    echo "===========================================\n";
    
    echo "✅ تم إصلاح جميع الطلبات المتاحة\n";
    echo "🔗 يمكنك رؤية الصور في: https://console.cloudinary.com/\n";
    echo "📁 مجلد الصور: infinitywearsa/designs\n";
    
} catch (Exception $e) {
    echo "❌ خطأ: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
