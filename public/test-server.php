<?php
// سكريبت اختبار الخادم
header('Content-Type: text/html; charset=utf-8');

echo "<h1>اختبار إعدادات الخادم</h1>";

echo "<h2>معلومات الخادم:</h2>";
echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Name: " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p>Request URI: " . $_SERVER['REQUEST_URI'] . "</p>";

echo "<h2>فحص وجود الملفات:</h2>";
$files = [
    'logo.svg' => 'images/logo.svg',
    'infinity-home.js' => 'js/infinity-home.js',
    'home-responsive.js' => 'js/home-responsive.js',
    'infinity-home.css' => 'css/infinity-home.css',
    'sw.js' => 'sw.js',
    'site.webmanifest' => 'site.webmanifest'
];

foreach ($files as $name => $path) {
    $fullPath = __DIR__ . '/' . $path;
    $exists = file_exists($fullPath);
    $size = $exists ? filesize($fullPath) : 0;
    $readable = $exists ? is_readable($fullPath) : false;
    echo "<p><strong>$name</strong>: " . ($exists ? "✓ موجود ($size bytes)" : "✗ غير موجود") . 
         ($readable ? " - قابل للقراءة" : " - غير قابل للقراءة") . "</p>";
}

echo "<h2>اختبار MIME Types:</h2>";
$mimeTypes = [
    'logo.svg' => 'image/svg+xml',
    'infinity-home.js' => 'application/javascript',
    'home-responsive.js' => 'application/javascript',
    'infinity-home.css' => 'text/css',
    'sw.js' => 'application/javascript',
    'site.webmanifest' => 'application/manifest+json'
];

foreach ($mimeTypes as $file => $expectedMime) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        $actualMime = mime_content_type($path);
        $status = ($actualMime === $expectedMime) ? "✓" : "✗";
        echo "<p><strong>$file</strong>: $status المتوقع: $expectedMime، الفعلي: $actualMime</p>";
    }
}

echo "<h2>اختبار الصلاحيات:</h2>";
$dirs = ['images', 'js', 'css', 'storage'];
foreach ($dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (is_dir($path)) {
        $readable = is_readable($path);
        $writable = is_writable($path);
        echo "<p><strong>$dir/</strong>: " . ($readable ? "✓ قابل للقراءة" : "✗ غير قابل للقراءة") . 
             " - " . ($writable ? "✓ قابل للكتابة" : "✗ غير قابل للكتابة") . "</p>";
    }
}

echo "<h2>اختبار symlink:</h2>";
$storageLink = __DIR__ . '/storage';
if (is_link($storageLink)) {
    $target = readlink($storageLink);
    echo "<p>✓ symlink موجود: $storageLink -> $target</p>";
} else {
    echo "<p>✗ symlink غير موجود</p>";
}

echo "<h2>اختبار Laravel:</h2>";
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    
    try {
        $app = require_once __DIR__ . '/../bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        
        echo "<p>✓ Laravel يعمل بشكل صحيح</p>";
        echo "<p>APP_URL: " . config('app.url') . "</p>";
        echo "<p>APP_ENV: " . config('app.env') . "</p>";
        echo "<p>APP_DEBUG: " . (config('app.debug') ? 'true' : 'false') . "</p>";
        
        echo "<h3>اختبار asset helper:</h3>";
        echo "<p>logo.svg: " . asset('images/logo.svg') . "</p>";
        echo "<p>infinity-home.js: " . asset('js/infinity-home.js') . "</p>";
        echo "<p>infinity-home.css: " . asset('css/infinity-home.css') . "</p>";
        
    } catch (Exception $e) {
        echo "<p>✗ خطأ في Laravel: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>✗ Laravel غير موجود</p>";
}

echo "<h2>اختبار الوصول المباشر للملفات:</h2>";
echo "<p><a href='logo.svg' target='_blank'>اختبار logo.svg</a></p>";
echo "<p><a href='js/infinity-home.js' target='_blank'>اختبار infinity-home.js</a></p>";
echo "<p><a href='css/infinity-home.css' target='_blank'>اختبار infinity-home.css</a></p>";
echo "<p><a href='sw.js' target='_blank'>اختبار sw.js</a></p>";
echo "<p><a href='site.webmanifest' target='_blank'>اختبار site.webmanifest</a></p>";

echo "<h2>معلومات PHP:</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Loaded Extensions: " . implode(', ', get_loaded_extensions()) . "</p>";

echo "<h2>إعدادات Apache:</h2>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    $required = ['mod_rewrite', 'mod_mime', 'mod_deflate'];
    foreach ($required as $module) {
        $status = in_array($module, $modules) ? "✓" : "✗";
        echo "<p>$module: $status</p>";
    }
}
?>
