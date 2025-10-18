<?php
/**
 * سكربت نهائي لإصلاح مشاكل التخزين بدون shell_exec
 * يستخدم Laravel فقط لحل مشكلة 403
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

echo "===========================================\n";
echo "إصلاح نهائي لمشاكل التخزين\n";
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
    if (!File::exists($dir)) {
        File::makeDirectory($dir, 0755, true);
        echo "  ✓ تم إنشاء: {$dir}\n";
    } else {
        echo "  ✓ موجود: {$dir}\n";
    }
}

// 2. إنشاء الرابط الرمزي باستخدام Laravel
echo "\n2. إنشاء الرابط الرمزي...\n";
$storagePath = __DIR__ . '/storage/app/public';
$publicPath = __DIR__ . '/public/storage';

// حذف الرابط القديم إذا كان موجوداً
if (File::exists($publicPath)) {
    if (is_link($publicPath)) {
        unlink($publicPath);
        echo "  ✓ تم حذف الرابط القديم\n";
    } else {
        File::deleteDirectory($publicPath);
        echo "  ✓ تم حذف المجلد القديم\n";
    }
}

// إنشاء الرابط الجديد
if (symlink($storagePath, $publicPath)) {
    echo "  ✓ تم إنشاء الرابط الرمزي\n";
    echo "    من: {$storagePath}\n";
    echo "    إلى: {$publicPath}\n";
} else {
    echo "  ✗ فشل في إنشاء الرابط الرمزي\n";
    echo "  جاري إنشاء نسخة من الملفات...\n";
    
    // إنشاء نسخة من الملفات بدلاً من الرابط الرمزي
    if (File::copyDirectory($storagePath, $publicPath)) {
        echo "  ✓ تم نسخ الملفات بنجاح\n";
    } else {
        echo "  ✗ فشل في نسخ الملفات\n";
    }
}

// 3. إنشاء ملف .htaccess
echo "\n3. إنشاء ملف .htaccess...\n";
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
</IfModule>

# Enable CORS for images
<IfModule mod_headers.c>
    <FilesMatch "\.(jpg|jpeg|png|gif|webp|svg|avif)$">
        Header set Access-Control-Allow-Origin "*"
        Header set Access-Control-Allow-Methods "GET, POST, OPTIONS"
        Header set Access-Control-Allow-Headers "Content-Type"
    </FilesMatch>
</IfModule>';

File::put($publicPath . '/.htaccess', $htaccessContent);
echo "  ✓ تم إنشاء ملف .htaccess\n";

// 4. نسخ الصور الموجودة من storage إلى public
echo "\n4. نسخ الصور الموجودة...\n";
$storageImages = Storage::disk('public')->allFiles('images/portfolio');
$copiedCount = 0;

foreach ($storageImages as $image) {
    $sourcePath = storage_path('app/public/' . $image);
    $destPath = public_path('images/' . $image);
    
    // إنشاء المجلد إذا لم يكن موجوداً
    $destDir = dirname($destPath);
    if (!File::exists($destDir)) {
        File::makeDirectory($destDir, 0755, true);
    }
    
    if (File::copy($sourcePath, $destPath)) {
        $copiedCount++;
        echo "  ✓ تم نسخ: {$image}\n";
    } else {
        echo "  ✗ فشل في نسخ: {$image}\n";
    }
}

echo "  تم نسخ {$copiedCount} صورة\n";

// 5. تنظيف الكاش
echo "\n5. تنظيف الكاش...\n";
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
echo "\n6. اختبار الوصول للصور...\n";
$testImages = [
    'storage/images/portfolio/GnPYxG74TXGlnEoHVKpl5dPZI9SRmOuKhz9OyeON.webp',
    'storage/images/portfolio/vBtKpPzkHzDjXX2tVUATy19ewOZ51YAwGsYBXe1a.webp',
    'storage/images/portfolio/Z1f7LtDHJvSLpK0YJ1Le8Xx7XDILd8fR0326jrEQ.webp',
    'storage/images/portfolio/Hpw205wrzOsbwAVEguZN6yC5Drl2l5kYe4j4gTAG.jpg'
];

foreach ($testImages as $image) {
    $fullPath = public_path($image);
    if (File::exists($fullPath)) {
        echo "  ✓ موجود: {$image}\n";
    } else {
        echo "  ✗ غير موجود: {$image}\n";
    }
}

echo "\n===========================================\n";
echo "اكتمل الإصلاح!\n";
echo "===========================================\n";
echo "\nإذا استمرت المشكلة:\n";
echo "1. تأكد من أن مجلد public/storage موجود ويمكن الوصول إليه\n";
echo "2. تحقق من إعدادات Apache/Nginx\n";
echo "3. تأكد من أن mod_rewrite مفعل\n";
echo "4. جرب الوصول المباشر للصورة: yourdomain.com/storage/images/portfolio/filename.webp\n";
