<?php
// Debug script to test asset serving
header('Content-Type: text/html; charset=utf-8');

echo "<h1>Asset Debug Information</h1>";

echo "<h2>Server Information:</h2>";
echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Name: " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p>Request URI: " . $_SERVER['REQUEST_URI'] . "</p>";

echo "<h2>File Existence Check:</h2>";
$files = [
    'logo.svg' => 'images/logo.svg',
    'infinity-home.js' => 'js/infinity-home.js',
    'home-responsive.js' => 'js/home-responsive.js',
    'sw.js' => 'sw.js',
    'site.webmanifest' => 'site.webmanifest'
];

foreach ($files as $name => $path) {
    $fullPath = __DIR__ . '/' . $path;
    $exists = file_exists($fullPath);
    $size = $exists ? filesize($fullPath) : 0;
    echo "<p><strong>$name</strong>: " . ($exists ? "✓ EXISTS ($size bytes)" : "✗ NOT FOUND") . "</p>";
}

echo "<h2>Direct File Access Test:</h2>";
echo "<p><a href='logo.svg' target='_blank'>Test logo.svg</a></p>";
echo "<p><a href='js/infinity-home.js' target='_blank'>Test infinity-home.js</a></p>";
echo "<p><a href='js/home-responsive.js' target='_blank'>Test home-responsive.js</a></p>";
echo "<p><a href='sw.js' target='_blank'>Test sw.js</a></p>";
echo "<p><a href='site.webmanifest' target='_blank'>Test site.webmanifest</a></p>";

echo "<h2>MIME Type Test:</h2>";
$mimeTypes = [
    'logo.svg' => 'image/svg+xml',
    'infinity-home.js' => 'application/javascript',
    'home-responsive.js' => 'application/javascript',
    'sw.js' => 'application/javascript',
    'site.webmanifest' => 'application/manifest+json'
];

foreach ($mimeTypes as $file => $expectedMime) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        $actualMime = mime_content_type($path);
        echo "<p><strong>$file</strong>: Expected: $expectedMime, Actual: $actualMime</p>";
    }
}

echo "<h2>Laravel Asset Helper Test:</h2>";
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
    
    // Bootstrap Laravel
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    echo "<p>Laravel Asset Helper Results:</p>";
    echo "<p>logo.svg: " . asset('images/logo.svg') . "</p>";
    echo "<p>infinity-home.js: " . asset('js/infinity-home.js') . "</p>";
    echo "<p>home-responsive.js: " . asset('js/home-responsive.js') . "</p>";
    echo "<p>sw.js: " . asset('sw.js') . "</p>";
    echo "<p>site.webmanifest: " . asset('site.webmanifest') . "</p>";
} else {
    echo "<p>Laravel not found - cannot test asset helper</p>";
}
?>
