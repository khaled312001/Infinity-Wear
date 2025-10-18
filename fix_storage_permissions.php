<?php
/**
 * سكربت لإصلاح صلاحيات ملفات التخزين على الخادم
 * قم بتشغيله على الخادم لحل مشكلة خطأ 403
 */

echo "===========================================\n";
echo "إصلاح صلاحيات ملفات التخزين\n";
echo "===========================================\n\n";

// إنشاء مجلدات التخزين إذا لم تكن موجودة
$directories = [
    'storage/app/public',
    'storage/app/public/images',
    'storage/app/public/images/portfolio',
    'storage/app/public/images/portfolio/gallery',
    'storage/logs',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'bootstrap/cache'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "✓ تم إنشاء المجلد: {$dir}\n";
    } else {
        echo "✓ المجلد موجود: {$dir}\n";
    }
}

// تعيين الصلاحيات الصحيحة
$commands = [
    'chmod -R 755 storage/',
    'chmod -R 755 bootstrap/cache/',
    'chmod -R 755 public/storage/',
    'chown -R www-data:www-data storage/',
    'chown -R www-data:www-data bootstrap/cache/',
    'chown -R www-data:www-data public/storage/'
];

echo "\nتعيين الصلاحيات...\n";
echo "==================\n";

foreach ($commands as $command) {
    echo "تشغيل: {$command}\n";
    $output = shell_exec($command . ' 2>&1');
    if ($output) {
        echo "النتيجة: {$output}\n";
    }
}

echo "\n===========================================\n";
echo "تم إصلاح الصلاحيات!\n";
echo "===========================================\n";

// التحقق من الرابط الرمزي
if (is_link('public/storage')) {
    echo "✓ الرابط الرمزي موجود: public/storage\n";
    $target = readlink('public/storage');
    echo "  يشير إلى: {$target}\n";
} else {
    echo "✗ الرابط الرمزي غير موجود\n";
    echo "قم بتشغيل: php artisan storage:link\n";
}

// التحقق من الصلاحيات
$storagePath = 'storage/app/public';
if (is_dir($storagePath)) {
    $perms = substr(sprintf('%o', fileperms($storagePath)), -4);
    echo "صلاحيات مجلد التخزين: {$perms}\n";
}

echo "\nإذا استمرت المشكلة، تأكد من:\n";
echo "1. أن خادم الويب (Apache/Nginx) لديه صلاحيات القراءة\n";
echo "2. أن إعدادات PHP تسمح بالوصول للملفات\n";
echo "3. أن ملف .htaccess في public/storage صحيح\n";
