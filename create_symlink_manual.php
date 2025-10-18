<?php
/**
 * سكربت لإنشاء الرابط الرمزي يدوياً
 */

echo "===========================================\n";
echo "إنشاء الرابط الرمزي يدوياً\n";
echo "===========================================\n\n";

$storagePath = __DIR__ . '/storage/app/public';
$publicPath = __DIR__ . '/public/storage';

echo "مسار storage: {$storagePath}\n";
echo "مسار public: {$publicPath}\n";

// حذف الرابط القديم إذا كان موجوداً
if (file_exists($publicPath)) {
    if (is_link($publicPath)) {
        unlink($publicPath);
        echo "✓ تم حذف الرابط القديم\n";
    } else {
        echo "✓ الرابط موجود ولكن ليس رابط رمزي\n";
    }
}

// إنشاء الرابط الجديد
if (symlink($storagePath, $publicPath)) {
    echo "✓ تم إنشاء الرابط الرمزي بنجاح\n";
    echo "  من: {$storagePath}\n";
    echo "  إلى: {$publicPath}\n";
} else {
    echo "✗ فشل في إنشاء الرابط الرمزي\n";
    echo "جاري إنشاء نسخة من الملفات...\n";
    
    // إنشاء نسخة من الملفات بدلاً من الرابط الرمزي
    if (is_dir($storagePath)) {
        // نسخ جميع الملفات من storage إلى public/storage
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($storagePath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $item) {
            $target = $publicPath . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
            
            if ($item->isDir()) {
                if (!is_dir($target)) {
                    mkdir($target, 0755, true);
                }
            } else {
                if (!file_exists($target)) {
                    copy($item, $target);
                }
            }
        }
        
        echo "✓ تم نسخ الملفات بنجاح\n";
    } else {
        echo "✗ مجلد storage غير موجود\n";
    }
}

// التحقق من الرابط
if (file_exists($publicPath)) {
    if (is_link($publicPath)) {
        $target = readlink($publicPath);
        echo "✓ الرابط يعمل بشكل صحيح\n";
        echo "  يشير إلى: {$target}\n";
    } else {
        echo "✓ الملفات موجودة (نسخة وليس رابط رمزي)\n";
    }
} else {
    echo "✗ الرابط لا يعمل\n";
}

echo "\n===========================================\n";
echo "اكتمل إنشاء الرابط!\n";
echo "===========================================\n";
