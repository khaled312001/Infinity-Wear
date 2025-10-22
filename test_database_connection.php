<?php
/**
 * اختبار اتصال قاعدة البيانات
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

echo "===========================================\n";
echo "اختبار اتصال قاعدة البيانات\n";
echo "===========================================\n\n";

try {
    // فحص إعدادات قاعدة البيانات
    echo "1. فحص إعدادات قاعدة البيانات...\n";
    echo "Host: " . config('database.connections.mysql.host') . "\n";
    echo "Port: " . config('database.connections.mysql.port') . "\n";
    echo "Database: " . config('database.connections.mysql.database') . "\n";
    echo "Username: " . config('database.connections.mysql.username') . "\n";
    echo "Password: " . (config('database.connections.mysql.password') ? '***' : 'empty') . "\n";
    echo "Charset: " . config('database.connections.mysql.charset') . "\n";
    
    echo "\n2. اختبار الاتصال...\n";
    
    // اختبار الاتصال
    DB::connection('mysql')->getPdo();
    echo "✅ تم الاتصال بقاعدة البيانات بنجاح!\n";
    
    // اختبار استعلام بسيط
    $result = DB::select('SELECT 1 as test');
    echo "✅ تم تنفيذ استعلام اختبار بنجاح!\n";
    
    // اختبار جدول المستخدمين
    try {
        $userCount = DB::table('users')->count();
        echo "✅ تم الوصول لجدول المستخدمين - عدد المستخدمين: " . $userCount . "\n";
    } catch (Exception $e) {
        echo "⚠ تحذير: لا يمكن الوصول لجدول المستخدمين - " . $e->getMessage() . "\n";
    }
    
    echo "\n3. فحص متغيرات البيئة...\n";
    echo "DB_CONNECTION: " . env('DB_CONNECTION', 'not set') . "\n";
    echo "DB_HOST: " . env('DB_HOST', 'not set') . "\n";
    echo "DB_PORT: " . env('DB_PORT', 'not set') . "\n";
    echo "DB_DATABASE: " . env('DB_DATABASE', 'not set') . "\n";
    echo "DB_USERNAME: " . env('DB_USERNAME', 'not set') . "\n";
    echo "DB_PASSWORD: " . (env('DB_PASSWORD') ? '***' : 'not set') . "\n";
    
} catch (Exception $e) {
    echo "❌ فشل في الاتصال بقاعدة البيانات!\n";
    echo "الخطأ: " . $e->getMessage() . "\n";
    echo "كود الخطأ: " . $e->getCode() . "\n";
    
    echo "\n🔧 الحلول المقترحة:\n";
    echo "1. تحقق من إعدادات قاعدة البيانات في ملف .env\n";
    echo "2. تأكد من أن خادم MySQL يعمل\n";
    echo "3. تحقق من صحة اسم المستخدم وكلمة المرور\n";
    echo "4. تأكد من أن قاعدة البيانات موجودة\n";
    echo "5. تحقق من صلاحيات المستخدم\n";
}

echo "\n===========================================\n";
echo "اكتمل الاختبار!\n";
echo "===========================================\n";
