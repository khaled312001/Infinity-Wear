<?php
/**
 * سكربت لإصلاح مسار الصور
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PortfolioItem;
use Illuminate\Support\Facades\File;

echo "===========================================\n";
echo "إصلاح مسار الصور\n";
echo "===========================================\n\n";

// 1. فحص المسارات الموجودة
echo "1. فحص المسارات الموجودة...\n";

$storagePath = storage_path('app/public/images/portfolio');
$publicPath = public_path('images/portfolio');

echo "مسار storage: {$storagePath}\n";
echo "مسار public: {$publicPath}\n";

if (File::exists($storagePath)) {
    $storageFiles = File::allFiles($storagePath);
    echo "عدد الملفات في storage: " . count($storageFiles) . "\n";
    foreach ($storageFiles as $file) {
        echo "  - " . $file->getRelativePathname() . "\n";
    }
} else {
    echo "✗ مجلد storage غير موجود\n";
}

if (File::exists($publicPath)) {
    $publicFiles = File::allFiles($publicPath);
    echo "عدد الملفات في public: " . count($publicFiles) . "\n";
    foreach ($publicFiles as $file) {
        echo "  - " . $file->getRelativePathname() . "\n";
    }
} else {
    echo "✗ مجلد public غير موجود\n";
}

// 2. نسخ الصور من storage إلى public
echo "\n2. نسخ الصور من storage إلى public...\n";

if (File::exists($storagePath)) {
    $storageFiles = File::allFiles($storagePath);
    $copiedCount = 0;
    
    foreach ($storageFiles as $file) {
        $relativePath = $file->getRelativePathname();
        $sourcePath = $file->getPathname();
        $destPath = public_path('images/portfolio/' . $relativePath);
        
        // إنشاء المجلد إذا لم يكن موجوداً
        $destDir = dirname($destPath);
        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }
        
        if (File::copy($sourcePath, $destPath)) {
            $copiedCount++;
            echo "  ✓ تم نسخ: {$relativePath}\n";
        } else {
            echo "  ✗ فشل في نسخ: {$relativePath}\n";
        }
    }
    
    echo "تم نسخ {$copiedCount} صورة\n";
} else {
    echo "✗ لا يمكن نسخ الصور - مجلد storage غير موجود\n";
}

// 3. اختبار الصور بعد النسخ
echo "\n3. اختبار الصور بعد النسخ...\n";

$portfolioItems = PortfolioItem::orderBy('id', 'desc')->take(5)->get();

foreach ($portfolioItems as $item) {
    echo "عنصر #{$item->id}: {$item->title}\n";
    echo "مسار الصورة: {$item->image}\n";
    echo "رابط الصورة: {$item->image_url}\n";
    
    // تحقق من وجود الملف
    $imagePath = public_path($item->image);
    if (file_exists($imagePath)) {
        echo "✓ الصورة موجودة في: {$imagePath}\n";
    } else {
        echo "✗ الصورة غير موجودة في: {$imagePath}\n";
        
        // جرب البحث في storage
        $storageImagePath = storage_path('app/public/' . $item->image);
        if (file_exists($storageImagePath)) {
            echo "  لكن موجودة في storage: {$storageImagePath}\n";
            
            // انسخها إلى public
            $destPath = public_path($item->image);
            $destDir = dirname($destPath);
            if (!File::exists($destDir)) {
                File::makeDirectory($destDir, 0755, true);
            }
            
            if (File::copy($storageImagePath, $destPath)) {
                echo "  ✓ تم نسخها إلى public\n";
            } else {
                echo "  ✗ فشل في نسخها إلى public\n";
            }
        } else {
            echo "  ✗ غير موجودة في storage أيضاً\n";
        }
    }
    echo "---\n";
}

echo "\n===========================================\n";
echo "اكتمل الإصلاح!\n";
echo "===========================================\n";
