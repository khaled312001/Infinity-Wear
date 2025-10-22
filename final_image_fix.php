<?php
/**
 * إصلاح نهائي لمشكلة عرض الصور
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "===========================================\n";
echo "إصلاح نهائي لمشكلة عرض الصور\n";
echo "===========================================\n\n";

try {
    // 1. إنشاء المجلدات المطلوبة
    $directories = [
        public_path('storage'),
        public_path('storage/designs'),
        public_path('storage/infinitywearsa'),
        public_path('storage/infinitywearsa/designs'),
    ];
    
    foreach ($directories as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
            echo "✓ تم إنشاء المجلد: " . $dir . "\n";
        } else {
            echo "✓ المجلد موجود: " . $dir . "\n";
        }
    }
    
    // 2. نسخ الصور من جميع المصادر المحتملة
    $sourcePaths = [
        storage_path('app/public/designs'),
        storage_path('app/public/infinitywearsa/designs'),
        public_path('storage/designs'),
        public_path('storage/infinitywearsa/designs'),
    ];
    
    $targetPaths = [
        public_path('storage/designs'),
        public_path('storage/infinitywearsa/designs'),
    ];
    
    $copiedCount = 0;
    
    foreach ($sourcePaths as $sourcePath) {
        if (is_dir($sourcePath)) {
            echo "\nفحص المجلد المصدر: " . $sourcePath . "\n";
            
            $files = glob($sourcePath . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
            echo "تم العثور على " . count($files) . " صورة\n";
            
            foreach ($files as $file) {
                $filename = basename($file);
                
                // نسخ إلى جميع المجلدات المستهدفة
                foreach ($targetPaths as $targetPath) {
                    $targetFile = $targetPath . '/' . $filename;
                    
                    if (!file_exists($targetFile)) {
                        if (copy($file, $targetFile)) {
                            $copiedCount++;
                            echo "  ✓ تم نسخ: " . $filename . " إلى " . basename($targetPath) . "\n";
                        } else {
                            echo "  ✗ فشل في نسخ: " . $filename . "\n";
                        }
                    }
                }
            }
        }
    }
    
    echo "\nتم نسخ " . $copiedCount . " ملف\n";
    
    // 3. إنشاء ملف .htaccess للتأكد من الوصول
    $htaccessContent = 'RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^storage/(.*)$ ../storage/app/public/$1 [L]';
    
    $htaccessFile = public_path('storage/.htaccess');
    file_put_contents($htaccessFile, $htaccessContent);
    echo "✓ تم إنشاء ملف .htaccess\n";
    
    // 4. فحص الصور الموجودة
    echo "\nفحص الصور الموجودة:\n";
    $checkPaths = [
        public_path('storage/designs'),
        public_path('storage/infinitywearsa/designs'),
    ];
    
    foreach ($checkPaths as $path) {
        if (is_dir($path)) {
            $files = glob($path . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
            echo "  " . basename($path) . ": " . count($files) . " صورة\n";
            
            foreach ($files as $file) {
                $filename = basename($file);
                $url = asset('storage/' . basename($path) . '/' . $filename);
                echo "    - " . $filename . " -> " . $url . "\n";
            }
        }
    }
    
    echo "\n===========================================\n";
    echo "اكتمل الإصلاح!\n";
    echo "===========================================\n";
    echo "الآن يجب أن تعمل الصور في:\n";
    echo "- https://infinitywearsa.com/importers/dashboard\n";
    echo "- https://infinitywearsa.com/importers/orders\n";
    echo "- https://infinitywearsa.com/admin/orders\n";
    
} catch (Exception $e) {
    echo "✗ خطأ في الإصلاح: " . $e->getMessage() . "\n";
}
