<?php
/**
 * سكربت إصلاح مشكلة bootstrap/cache
 * قم بتشغيله على السيرفر لحل مشكلة HTTP 500
 */

echo "===========================================\n";
echo "إصلاح مشكلة bootstrap/cache\n";
echo "===========================================\n\n";

// المسار الأساسي
$basePath = __DIR__;
$cachePath = $basePath . '/bootstrap/cache';

echo "المسار الأساسي: {$basePath}\n";
echo "مسار الكاش: {$cachePath}\n\n";

// 1. إنشاء مجلد bootstrap/cache إذا لم يكن موجوداً
echo "1. التحقق من وجود مجلد bootstrap/cache...\n";
if (!is_dir($cachePath)) {
    if (mkdir($cachePath, 0755, true)) {
        echo "  ✓ تم إنشاء المجلد: bootstrap/cache\n";
    } else {
        echo "  ✗ فشل في إنشاء المجلد: bootstrap/cache\n";
        echo "  حاول إنشاءه يدوياً باستخدام:\n";
        echo "  mkdir -p bootstrap/cache\n";
        echo "  chmod 755 bootstrap/cache\n";
    }
} else {
    echo "  ✓ المجلد موجود: bootstrap/cache\n";
}

// 2. التحقق من الصلاحيات
echo "\n2. التحقق من صلاحيات المجلد...\n";
if (is_dir($cachePath)) {
    $perms = substr(sprintf('%o', fileperms($cachePath)), -4);
    echo "  الصلاحيات الحالية: {$perms}\n";
    
    if (is_writable($cachePath)) {
        echo "  ✓ المجلد قابل للكتابة\n";
    } else {
        echo "  ✗ المجلد غير قابل للكتابة\n";
        echo "  حاول تغيير الصلاحيات باستخدام:\n";
        echo "  chmod 755 bootstrap/cache\n";
        echo "  أو\n";
        echo "  chmod 775 bootstrap/cache\n";
    }
}

// 3. إنشاء ملف .gitignore في bootstrap/cache
echo "\n3. إنشاء ملف .gitignore...\n";
$gitignorePath = $cachePath . '/.gitignore';
$gitignoreContent = "*\n!.gitignore\n";

if (file_put_contents($gitignorePath, $gitignoreContent)) {
    echo "  ✓ تم إنشاء ملف .gitignore\n";
} else {
    echo "  ✗ فشل في إنشاء ملف .gitignore\n";
}

// 4. إنشاء ملف services.php إذا لم يكن موجوداً
echo "\n4. التحقق من ملف services.php...\n";
$servicesPath = $cachePath . '/services.php';
if (!file_exists($servicesPath)) {
    $servicesContent = "<?php\n\nreturn [];\n";
    if (file_put_contents($servicesPath, $servicesContent)) {
        echo "  ✓ تم إنشاء ملف services.php\n";
    } else {
        echo "  ✗ فشل في إنشاء ملف services.php\n";
    }
} else {
    echo "  ✓ ملف services.php موجود\n";
}

// 5. إنشاء ملف packages.php إذا لم يكن موجوداً
echo "\n5. التحقق من ملف packages.php...\n";
$packagesPath = $cachePath . '/packages.php';
if (!file_exists($packagesPath)) {
    $packagesContent = "<?php\n\nreturn [];\n";
    if (file_put_contents($packagesPath, $packagesContent)) {
        echo "  ✓ تم إنشاء ملف packages.php\n";
    } else {
        echo "  ✗ فشل في إنشاء ملف packages.php\n";
    }
} else {
    echo "  ✓ ملف packages.php موجود\n";
}

// 6. محاولة تنظيف الكاش
echo "\n6. تنظيف الكاش...\n";
if (file_exists($basePath . '/artisan')) {
    echo "  محاولة تشغيل artisan commands...\n";
    
    // تنظيف الكاش
    $commands = [
        'config:clear',
        'cache:clear',
        'route:clear',
        'view:clear'
    ];
    
    foreach ($commands as $cmd) {
        $output = shell_exec("cd {$basePath} && php artisan {$cmd} 2>&1");
        if ($output) {
            echo "  {$cmd}: " . trim($output) . "\n";
        }
    }
    
    // إعادة إنشاء الكاش
    echo "\n  إعادة إنشاء الكاش...\n";
    $cacheCommands = [
        'config:cache',
        'route:cache',
        'view:cache'
    ];
    
    foreach ($cacheCommands as $cmd) {
        $output = shell_exec("cd {$basePath} && php artisan {$cmd} 2>&1");
        if ($output) {
            echo "  {$cmd}: " . trim($output) . "\n";
        }
    }
} else {
    echo "  ⚠ ملف artisan غير موجود - تخطي تنظيف الكاش\n";
}

echo "\n===========================================\n";
echo "تم الانتهاء!\n";
echo "===========================================\n";
echo "\nإذا استمرت المشكلة، قم بتنفيذ الأوامر التالية في SSH:\n";
echo "cd /home/u790947786/domains/infinitywearsa.com/public_html\n";
echo "mkdir -p bootstrap/cache\n";
echo "chmod 755 bootstrap/cache\n";
echo "chmod 755 bootstrap\n";
echo "php artisan config:clear\n";
echo "php artisan cache:clear\n";
echo "php artisan config:cache\n";
echo "\n";

