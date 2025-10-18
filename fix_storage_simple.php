<?php
/**
 * سكربت بسيط لإصلاح مشاكل التخزين بدون symlink أو shell_exec
 * ينسخ الملفات مباشرة إلى public
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

echo "===========================================\n";
echo "إصلاح بسيط لمشاكل التخزين\n";
echo "===========================================\n\n";

// 1. إنشاء مجلدات التخزين
echo "1. إنشاء مجلدات التخزين...\n";
$directories = [
    'storage/app/public',
    'storage/app/public/images',
    'storage/app/public/images/portfolio',
    'storage/app/public/images/portfolio/gallery',
    'public/images',
    'public/images/portfolio',
    'public/images/portfolio/gallery',
];

foreach ($directories as $dir) {
    if (!File::exists($dir)) {
        File::makeDirectory($dir, 0755, true);
        echo "  ✓ تم إنشاء: {$dir}\n";
    } else {
        echo "  ✓ موجود: {$dir}\n";
    }
}

// 2. نسخ جميع الصور من storage إلى public
echo "\n2. نسخ الصور من storage إلى public...\n";
$storageImages = Storage::disk('public')->allFiles('images/portfolio');
$copiedCount = 0;
$failedCount = 0;

foreach ($storageImages as $image) {
    $sourcePath = storage_path('app/public/' . $image);
    $destPath = public_path('images/' . $image);
    
    // إنشاء المجلد إذا لم يكن موجوداً
    $destDir = dirname($destPath);
    if (!File::exists($destDir)) {
        File::makeDirectory($destDir, 0755, true);
    }
    
    if (File::exists($sourcePath)) {
        if (File::copy($sourcePath, $destPath)) {
            $copiedCount++;
            echo "  ✓ تم نسخ: {$image}\n";
        } else {
            $failedCount++;
            echo "  ✗ فشل في نسخ: {$image}\n";
        }
    } else {
        $failedCount++;
        echo "  ✗ الملف غير موجود: {$image}\n";
    }
}

echo "  تم نسخ {$copiedCount} صورة بنجاح\n";
if ($failedCount > 0) {
    echo "  فشل في نسخ {$failedCount} صورة\n";
}

// 3. إنشاء ملف .htaccess للمجلد العام
echo "\n3. إنشاء ملف .htaccess...\n";
$htaccessContent = '# Allow access to all image files
<FilesMatch "\.(jpg|jpeg|png|gif|webp|svg|avif)$">
    Order Allow,Deny
    Allow from all
</FilesMatch>

# Set proper MIME types
<IfModule mod_mime.c>
    AddType image/webp .webp
    AddType image/avif .avif
</IfModule>

# Enable CORS for images
<IfModule mod_headers.c>
    <FilesMatch "\.(jpg|jpeg|png|gif|webp|svg|avif)$">
        Header set Access-Control-Allow-Origin "*"
        Header set Access-Control-Allow-Methods "GET, POST, OPTIONS"
        Header set Access-Control-Allow-Headers "Content-Type"
    </FilesMatch>
</IfModule>';

File::put(public_path('images/.htaccess'), $htaccessContent);
echo "  ✓ تم إنشاء ملف .htaccess في public/images/\n";

// 4. إنشاء ملف .htaccess لمجلد portfolio
File::put(public_path('images/portfolio/.htaccess'), $htaccessContent);
echo "  ✓ تم إنشاء ملف .htaccess في public/images/portfolio/\n";

// 5. تنظيف الكاش
echo "\n4. تنظيف الكاش...\n";
try {
    \Artisan::call('cache:clear');
    echo "  ✓ تم تنظيف الكاش\n";
    
    \Artisan::call('view:clear');
    echo "  ✓ تم تنظيف الملفات المترجمة\n";
    
    \Artisan::call('config:clear');
    echo "  ✓ تم تنظيف إعدادات الكاش\n";
} catch (Exception $e) {
    echo "  ⚠ تحذير: " . $e->getMessage() . "\n";
}

// 6. اختبار الوصول للصور
echo "\n5. اختبار الوصول للصور...\n";
$testImages = [
    'images/portfolio/GnPYxG74TXGlnEoHVKpl5dPZI9SRmOuKhz9OyeON.webp',
    'images/portfolio/vBtKpPzkHzDjXX2tVUATy19ewOZ51YAwGsYBXe1a.webp',
    'images/portfolio/Z1f7LtDHJvSLpK0YJ1Le8Xx7XDILd8fR0326jrEQ.webp',
    'images/portfolio/Hpw205wrzOsbwAVEguZN6yC5Drl2l5kYe4j4gTAG.jpg'
];

$foundCount = 0;
foreach ($testImages as $image) {
    $fullPath = public_path($image);
    if (File::exists($fullPath)) {
        $foundCount++;
        echo "  ✓ موجود: {$image}\n";
    } else {
        echo "  ✗ غير موجود: {$image}\n";
    }
}

echo "  تم العثور على {$foundCount} من " . count($testImages) . " صورة\n";

// 7. إنشاء سكربت للنسخ التلقائي (للمستقبل)
echo "\n6. إنشاء سكربت للنسخ التلقائي...\n";
$syncScript = '<?php
// سكربت لنسخ الصور الجديدة من storage إلى public
require __DIR__ . "/vendor/autoload.php";
$app = require_once __DIR__ . "/bootstrap/app.php";
$app->make("Illuminate\\Contracts\\Console\\Kernel")->bootstrap();

use Illuminate\\Support\\Facades\\Storage;
use Illuminate\\Support\\Facades\\File;

$storageImages = Storage::disk("public")->allFiles("images/portfolio");
foreach ($storageImages as $image) {
    $sourcePath = storage_path("app/public/" . $image);
    $destPath = public_path("images/" . $image);
    
    if (File::exists($sourcePath) && !File::exists($destPath)) {
        $destDir = dirname($destPath);
        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }
        File::copy($sourcePath, $destPath);
        echo "تم نسخ: {$image}\n";
    }
}
echo "اكتمل النسخ!\n";
?>';

File::put('sync_images.php', $syncScript);
echo "  ✓ تم إنشاء sync_images.php للنسخ التلقائي\n";

echo "\n===========================================\n";
echo "اكتمل الإصلاح!\n";
echo "===========================================\n";
echo "\nالآن الصور متاحة في:\n";
echo "- public/images/portfolio/\n";
echo "- يمكن الوصول إليها عبر: yourdomain.com/images/portfolio/filename.webp\n";
echo "\nلنسخ الصور الجديدة في المستقبل، شغل:\n";
echo "php sync_images.php\n";
