<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== اختبار تسجيل الدخول ===\n\n";

$testAccounts = [
    // حسابات الأدمن
    ['email' => 'admin@infinitywear.sa', 'password' => 'password123', 'type' => 'admin'],
    ['email' => 'content@infinitywearsa.com', 'password' => 'content123', 'type' => 'admin'],
    
    // حسابات التسويق
    ['email' => 'marketing@infinitywear.sa', 'password' => 'marketing123', 'type' => 'user'],
    ['email' => 'marketing2@infinitywear.sa', 'password' => 'marketing123', 'type' => 'user'],
    
    // حسابات المبيعات
    ['email' => 'sales@infinitywear.sa', 'password' => 'sales123', 'type' => 'user'],
    ['email' => 'sales2@infinitywear.sa', 'password' => 'sales123', 'type' => 'user'],
];

foreach ($testAccounts as $account) {
    echo "🔐 اختبار: {$account['email']}\n";
    echo "كلمة المرور: {$account['password']}\n";
    
    try {
        if ($account['type'] === 'admin') {
            $user = Admin::where('email', $account['email'])->first();
            if ($user && Hash::check($account['password'], $user->password)) {
                echo "✅ تسجيل الدخول ناجح - أدمن\n";
                echo "   الاسم: {$user->name}\n";
                echo "   الدور: {$user->role}\n";
                echo "   نشط: " . ($user->is_active ? 'نعم' : 'لا') . "\n";
            } else {
                echo "❌ فشل تسجيل الدخول - أدمن\n";
            }
        } else {
            $user = User::where('email', $account['email'])->first();
            if ($user && Hash::check($account['password'], $user->password)) {
                echo "✅ تسجيل الدخول ناجح - مستخدم\n";
                echo "   الاسم: {$user->name}\n";
                echo "   النوع: {$user->user_type}\n";
                echo "   نشط: " . ($user->is_active ? 'نعم' : 'لا') . "\n";
            } else {
                echo "❌ فشل تسجيل الدخول - مستخدم\n";
            }
        }
    } catch (Exception $e) {
        echo "❌ خطأ: " . $e->getMessage() . "\n";
    }
    
    echo "---\n\n";
}

echo "=== انتهاء الاختبار ===\n";
