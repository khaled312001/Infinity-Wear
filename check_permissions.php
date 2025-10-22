<?php
/**
 * فحص صلاحيات المجلدات والملفات
 */

echo "===========================================\n";
echo "فحص صلاحيات المجلدات والملفات\n";
echo "===========================================\n\n";

$paths = [
    'storage/app/public',
    'storage/app/public/designs',
    'public/storage',
    'public/storage/designs'
];

foreach ($paths as $path) {
    if (is_dir($path)) {
        $perms = fileperms($path);
        $readable = is_readable($path);
        $writable = is_writable($path);
        
        echo "المجلد: {$path}\n";
        echo "  الصلاحيات: " . substr(sprintf('%o', $perms), -4) . "\n";
        echo "  قابل للقراءة: " . ($readable ? 'نعم' : 'لا') . "\n";
        echo "  قابل للكتابة: " . ($writable ? 'نعم' : 'لا') . "\n";
        echo "----------------------------------------\n";
    } else {
        echo "المجلد غير موجود: {$path}\n";
        echo "----------------------------------------\n";
    }
}

// فحص ملف محدد
$testFile = 'public/storage/designs/xk1Jw6GXEVphwkGlNs1JcuzkFvOIAOxxdrXLiNVO.jpg';
if (file_exists($testFile)) {
    $perms = fileperms($testFile);
    $readable = is_readable($testFile);
    
    echo "الملف: {$testFile}\n";
    echo "  الصلاحيات: " . substr(sprintf('%o', $perms), -4) . "\n";
    echo "  قابل للقراءة: " . ($readable ? 'نعم' : 'لا') . "\n";
    echo "  الحجم: " . filesize($testFile) . " بايت\n";
} else {
    echo "الملف غير موجود: {$testFile}\n";
}

echo "\n===========================================\n";
echo "اكتمل الفحص!\n";
echo "===========================================\n";
