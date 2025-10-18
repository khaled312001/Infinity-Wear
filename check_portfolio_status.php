<?php
/**
 * سكربت للتحقق من حالة صور المعرض
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PortfolioItem;
use Illuminate\Support\Facades\File;

echo "===========================================\n";
echo "فحص حالة صور المعرض\n";
echo "===========================================\n\n";

// 1. فحص الصور في storage
echo "1. الصور في storage/app/public/images/portfolio/:\n";
$storagePath = storage_path('app/public/images/portfolio');
if (File::exists($storagePath)) {
    $storageFiles = File::allFiles($storagePath);
    echo "  عدد الملفات: " . count($storageFiles) . "\n";
    foreach ($storageFiles as $file) {
        echo "  - " . $file->getRelativePathname() . "\n";
    }
} else {
    echo "  ✗ المجلد غير موجود\n";
}

// 2. فحص الصور في public
echo "\n2. الصور في public/images/portfolio/:\n";
$publicPath = public_path('images/portfolio');
if (File::exists($publicPath)) {
    $publicFiles = File::allFiles($publicPath);
    echo "  عدد الملفات: " . count($publicFiles) . "\n";
    foreach ($publicFiles as $file) {
        echo "  - " . $file->getRelativePathname() . "\n";
    }
} else {
    echo "  ✗ المجلد غير موجود\n";
}

// 3. فحص قاعدة البيانات
echo "\n3. عناصر المعرض في قاعدة البيانات:\n";
$portfolioItems = PortfolioItem::orderBy('id', 'desc')->take(10)->get();
echo "  عدد العناصر: " . $portfolioItems->count() . "\n";

foreach ($portfolioItems as $item) {
    echo "\n  عنصر #{$item->id}: {$item->title}\n";
    echo "    مسار الصورة: {$item->image}\n";
    echo "    رابط الصورة: {$item->image_url}\n";
    
    // تحقق من وجود الصورة
    if (strpos($item->image, 'images/portfolio/') === 0) {
        $storageFile = storage_path('app/public/' . $item->image);
        $publicFile = public_path('images/' . $item->image);
        
        if (File::exists($storageFile)) {
            echo "    ✓ موجود في storage\n";
        } else {
            echo "    ✗ غير موجود في storage\n";
        }
        
        if (File::exists($publicFile)) {
            echo "    ✓ موجود في public\n";
        } else {
            echo "    ✗ غير موجود في public\n";
        }
    } else {
        $publicFile = public_path('images/' . $item->image);
        if (File::exists($publicFile)) {
            echo "    ✓ موجود في public\n";
        } else {
            echo "    ✗ غير موجود في public\n";
        }
    }
}

// 4. اختبار الوصول للصور
echo "\n4. اختبار الوصول للصور:\n";
$testUrls = [
    'images/portfolio/GnPYxG74TXGlnEoHVKpl5dPZI9SRmOuKhz9OyeON.webp',
    'images/portfolio/vBtKpPzkHzDjXX2tVUATy19ewOZ51YAwGsYBXe1a.webp',
    'images/portfolio/Z1f7LtDHJvSLpK0YJ1Le8Xx7XDILd8fR0326jrEQ.webp',
    'images/portfolio/Hpw205wrzOsbwAVEguZN6yC5Drl2l5kYe4j4gTAG.jpg'
];

foreach ($testUrls as $url) {
    $fullPath = public_path($url);
    if (File::exists($fullPath)) {
        echo "  ✓ يمكن الوصول لـ: {$url}\n";
    } else {
        echo "  ✗ لا يمكن الوصول لـ: {$url}\n";
    }
}

echo "\n===========================================\n";
echo "اكتمل الفحص!\n";
echo "===========================================\n";
