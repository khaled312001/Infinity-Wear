<?php
/**
 * سكربت لاختبار الصور بعد الإصلاح
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PortfolioItem;

echo "===========================================\n";
echo "اختبار الصور بعد الإصلاح\n";
echo "===========================================\n\n";

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
    }
    echo "---\n";
}

echo "\n===========================================\n";
echo "اكتمل الاختبار!\n";
echo "===========================================\n";
