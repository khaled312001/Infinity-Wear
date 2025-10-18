<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$portfolioItems = App\Models\PortfolioItem::orderBy('id', 'desc')->take(10)->get();

echo "آخر 10 عناصر في المعرض:\n";
echo "========================\n\n";

foreach ($portfolioItems as $item) {
    echo "ID: {$item->id}\n";
    echo "Title: {$item->title}\n";
    echo "Image Path: {$item->image}\n";
    echo "Image URL: {$item->image_url}\n";
    
    // تحقق من وجود الملف
    if (strpos($item->image, 'images/portfolio/') === 0) {
        $imagePath = storage_path('app/public/' . $item->image);
        if (file_exists($imagePath)) {
            echo "Status: ✓ Image exists in storage\n";
        } else {
            echo "Status: ✗ Image not found in storage: {$imagePath}\n";
        }
    } else {
        $imagePath = public_path('images/' . $item->image);
        if (file_exists($imagePath)) {
            echo "Status: ✓ Image exists in public\n";
        } else {
            echo "Status: ✗ Image not found in public: {$imagePath}\n";
        }
    }
    echo "---\n";
}
