<?php
/**
 * سكربت شامل لإصلاح مشاكل صور المعرض على الخادم
 * قم بتشغيله لحل جميع المشاكل المتعلقة بالصور
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PortfolioItem;
use Illuminate\Support\Facades\Storage;

echo "===========================================\n";
echo "إصلاح شامل لصور المعرض\n";
echo "===========================================\n\n";

// 1. إنشاء مجلدات التخزين
echo "1. إنشاء مجلدات التخزين...\n";
$directories = [
    'storage/app/public',
    'storage/app/public/images',
    'storage/app/public/images/portfolio',
    'storage/app/public/images/portfolio/gallery',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "  ✓ تم إنشاء: {$dir}\n";
    } else {
        echo "  ✓ موجود: {$dir}\n";
    }
}

// 2. تعيين الصلاحيات
echo "\n2. تعيين الصلاحيات...\n";
$commands = [
    'chmod -R 755 storage/',
    'chmod -R 755 public/',
    'chown -R www-data:www-data storage/ 2>/dev/null || chown -R apache:apache storage/ 2>/dev/null || true',
    'chown -R www-data:www-data public/ 2>/dev/null || chown -R apache:apache public/ 2>/dev/null || true'
];

foreach ($commands as $command) {
    echo "  تشغيل: {$command}\n";
    shell_exec($command);
}

// 3. إنشاء الرابط الرمزي
echo "\n3. إنشاء الرابط الرمزي...\n";
$storagePath = __DIR__ . '/storage/app/public';
$publicPath = __DIR__ . '/public/storage';

if (is_link($publicPath)) {
    unlink($publicPath);
    echo "  ✓ تم حذف الرابط القديم\n";
}

if (symlink($storagePath, $publicPath)) {
    echo "  ✓ تم إنشاء الرابط الرمزي\n";
} else {
    echo "  ✗ فشل في إنشاء الرابط الرمزي\n";
}

// 4. إنشاء ملف .htaccess
echo "\n4. إنشاء ملف .htaccess...\n";
$htaccessContent = '# Allow access to all files in storage directory
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>

# Allow access to image files
<FilesMatch "\.(jpg|jpeg|png|gif|webp|svg|avif)$">
    Order Allow,Deny
    Allow from all
</FilesMatch>

# Set proper MIME types
<IfModule mod_mime.c>
    AddType image/webp .webp
    AddType image/avif .avif
</IfModule>';

file_put_contents($publicPath . '/.htaccess', $htaccessContent);
echo "  ✓ تم إنشاء ملف .htaccess\n";

// 5. تنظيف الكاش
echo "\n5. تنظيف الكاش...\n";
$cacheCommands = [
    'php artisan cache:clear',
    'php artisan view:clear',
    'php artisan config:clear'
];

foreach ($cacheCommands as $command) {
    echo "  تشغيل: {$command}\n";
    shell_exec($command);
}

// 6. التحقق من الصور الموجودة
echo "\n6. التحقق من الصور...\n";
$portfolioItems = PortfolioItem::orderBy('id', 'desc')->take(5)->get();

foreach ($portfolioItems as $item) {
    echo "  عنصر: {$item->title}\n";
    echo "    مسار الصورة: {$item->image}\n";
    echo "    رابط الصورة: {$item->image_url}\n";
    
    if (strpos($item->image, 'images/portfolio/') === 0) {
        $filePath = storage_path('app/public/' . $item->image);
        if (file_exists($filePath)) {
            echo "    ✓ الصورة موجودة في التخزين\n";
        } else {
            echo "    ✗ الصورة غير موجودة في التخزين\n";
        }
    } else {
        $filePath = public_path('images/' . $item->image);
        if (file_exists($filePath)) {
            echo "    ✓ الصورة موجودة في public\n";
        } else {
            echo "    ✗ الصورة غير موجودة في public\n";
        }
    }
    echo "\n";
}

echo "===========================================\n";
echo "اكتمل الإصلاح!\n";
echo "===========================================\n";
echo "\nإذا استمرت المشكلة:\n";
echo "1. تأكد من أن خادم الويب لديه صلاحيات القراءة\n";
echo "2. تحقق من إعدادات PHP\n";
echo "3. تأكد من أن mod_rewrite مفعل في Apache\n";
