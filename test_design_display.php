<?php
/**
 * صفحة اختبار لعرض ملف التصميم
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Storage;

$fileName = 'xk1Jw6GXEVphwkGlNs1JcuzkFvOIAOxxdrXLiNVO.jpg';
$filePath = 'designs/' . $fileName;

echo "<!DOCTYPE html>\n";
echo "<html dir='rtl' lang='ar'>\n";
echo "<head>\n";
echo "    <meta charset='UTF-8'>\n";
echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>\n";
echo "    <title>اختبار عرض ملف التصميم</title>\n";
echo "    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>\n";
echo "</head>\n";
echo "<body>\n";
echo "    <div class='container mt-5'>\n";
echo "        <h1>اختبار عرض ملف التصميم</h1>\n";
echo "        <div class='row'>\n";
echo "            <div class='col-md-6'>\n";
echo "                <h3>معلومات الملف</h3>\n";
echo "                <ul class='list-group'>\n";

// فحص وجود الملف في التخزين
if (Storage::disk('public')->exists($filePath)) {
    echo "                    <li class='list-group-item'>✓ الملف موجود في التخزين</li>\n";
    $size = Storage::disk('public')->size($filePath);
    echo "                    <li class='list-group-item'>حجم الملف: {$size} بايت</li>\n";
} else {
    echo "                    <li class='list-group-item text-danger'>✗ الملف غير موجود في التخزين</li>\n";
}

// فحص وجود الملف في الرابط الرمزي
$publicPath = public_path('storage/' . $filePath);
if (file_exists($publicPath)) {
    echo "                    <li class='list-group-item'>✓ الملف موجود في الرابط الرمزي</li>\n";
    $size = filesize($publicPath);
    echo "                    <li class='list-group-item'>حجم الملف في الرابط الرمزي: {$size} بايت</li>\n";
} else {
    echo "                    <li class='list-group-item text-danger'>✗ الملف غير موجود في الرابط الرمزي</li>\n";
}

echo "                </ul>\n";
echo "            </div>\n";
echo "            <div class='col-md-6'>\n";
echo "                <h3>عرض الملف</h3>\n";

if (file_exists($publicPath)) {
    $url = asset('storage/' . $filePath);
    echo "                <p><strong>رابط الملف:</strong> <a href='{$url}' target='_blank'>{$url}</a></p>\n";
    echo "                <div class='mt-3'>\n";
    echo "                    <img src='{$url}' class='img-fluid' alt='تصميم' style='max-height: 300px;'>\n";
    echo "                </div>\n";
} else {
    echo "                <div class='alert alert-danger'>لا يمكن عرض الملف لأنه غير موجود</div>\n";
}

echo "            </div>\n";
echo "        </div>\n";
echo "    </div>\n";
echo "</body>\n";
echo "</html>\n";
