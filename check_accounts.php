<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\User;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== فحص الحسابات في قاعدة البيانات ===\n\n";

try {
    // فحص حسابات الأدمن
    echo "📊 حسابات الأدمن:\n";
    echo "================\n";
    $admins = Admin::select('id', 'name', 'email', 'role', 'is_active')->get();
    
    if ($admins->count() > 0) {
        foreach ($admins as $admin) {
            echo "ID: {$admin->id} | الاسم: {$admin->name} | البريد: {$admin->email} | الدور: {$admin->role} | نشط: " . ($admin->is_active ? 'نعم' : 'لا') . "\n";
        }
    } else {
        echo "❌ لا توجد حسابات أدمن في قاعدة البيانات\n";
    }
    
    echo "\n";
    
    // فحص حسابات المستخدمين
    echo "👥 حسابات المستخدمين:\n";
    echo "====================\n";
    $users = User::select('id', 'name', 'email', 'user_type', 'is_active')->get();
    
    if ($users->count() > 0) {
        foreach ($users as $user) {
            echo "ID: {$user->id} | الاسم: {$user->name} | البريد: {$user->email} | النوع: {$user->user_type} | نشط: " . ($user->is_active ? 'نعم' : 'لا') . "\n";
        }
    } else {
        echo "❌ لا توجد حسابات مستخدمين في قاعدة البيانات\n";
    }
    
    echo "\n";
    
    // إحصائيات
    echo "📈 الإحصائيات:\n";
    echo "=============\n";
    echo "عدد الأدمن: " . Admin::count() . "\n";
    echo "عدد المستخدمين: " . User::count() . "\n";
    echo "المستخدمين النشطين: " . User::where('is_active', 1)->count() . "\n";
    echo "الأدمن النشطين: " . Admin::where('is_active', 1)->count() . "\n";
    
    // فحص الحسابات المحددة
    echo "\n🔍 فحص الحسابات المحددة:\n";
    echo "========================\n";
    
    $testEmails = [
        'admin@infinitywear.sa',
        'content@infinitywearsa.com',
        'marketing@infinitywear.sa',
        'marketing2@infinitywear.sa',
        'sales@infinitywear.sa',
        'sales2@infinitywear.sa'
    ];
    
    foreach ($testEmails as $email) {
        $admin = Admin::where('email', $email)->first();
        $user = User::where('email', $email)->first();
        
        if ($admin) {
            echo "✅ {$email} - أدمن موجود (نشط: " . ($admin->is_active ? 'نعم' : 'لا') . ")\n";
        } elseif ($user) {
            echo "✅ {$email} - مستخدم موجود (نشط: " . ($user->is_active ? 'نعم' : 'لا') . ")\n";
        } else {
            echo "❌ {$email} - غير موجود\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage() . "\n";
}

echo "\n=== انتهاء الفحص ===\n";
