<?php
/**
 * سكربت لإنشاء الرابط الرمزي للتخزين على الخادم
 * قم بتشغيله إذا لم يعمل php artisan storage:link
 */

echo "===========================================\n";
echo "إنشاء الرابط الرمزي للتخزين\n";
echo "===========================================\n\n";

$storagePath = __DIR__ . '/storage/app/public';
$publicPath = __DIR__ . '/public/storage';

// حذف الرابط القديم إذا كان موجوداً
if (is_link($publicPath)) {
    unlink($publicPath);
    echo "✓ تم حذف الرابط القديم\n";
}

// إنشاء الرابط الجديد
if (symlink($storagePath, $publicPath)) {
    echo "✓ تم إنشاء الرابط الرمزي بنجاح\n";
    echo "  من: {$storagePath}\n";
    echo "  إلى: {$publicPath}\n";
} else {
    echo "✗ فشل في إنشاء الرابط الرمزي\n";
    echo "تأكد من أن لديك صلاحيات إنشاء الروابط الرمزية\n";
}

// التحقق من الرابط
if (is_link($publicPath)) {
    $target = readlink($publicPath);
    echo "\n✓ الرابط يعمل بشكل صحيح\n";
    echo "  يشير إلى: {$target}\n";
    
    // اختبار الوصول لملف
    $testFile = $publicPath . '/test.txt';
    file_put_contents($testFile, 'test');
    if (file_exists($testFile)) {
        echo "✓ يمكن الوصول للملفات\n";
        unlink($testFile);
    } else {
        echo "✗ لا يمكن الوصول للملفات\n";
    }
} else {
    echo "\n✗ الرابط لا يعمل\n";
}

echo "\n===========================================\n";
echo "اكتمل إنشاء الرابط!\n";
echo "===========================================\n";
