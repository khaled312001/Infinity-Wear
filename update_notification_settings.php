<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// إنشاء تطبيق Laravel
$app = new Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

// تحميل التطبيق
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== تحديث إعدادات الإشعارات ===\n\n";

try {
    // تحديث إعدادات الإشعارات
    $settings = \App\Models\NotificationSetting::getSettings();
    
    echo "1. تحديث إعدادات البريد الإلكتروني...\n";
    
    $settings->update([
        'email_notifications_enabled' => true,
        'smtp_host' => 'smtp.hostinger.com',
        'smtp_port' => 465,
        'smtp_username' => 'info@infinitywearsa.com',
        'smtp_password' => 'Info2025#*',
        'smtp_encryption' => 'ssl',
        'from_email' => 'info@infinitywearsa.com',
        'from_name' => 'Infinity Wear',
        'admin_email' => 'info@infinitywearsa.com',
        'notify_new_orders' => true,
        'notify_contact_messages' => true,
        'notify_whatsapp_messages' => true,
        'notify_importer_orders' => true,
        'notify_system_updates' => true,
        'email_verification_enabled' => true,
        'email_rate_limit' => 60,
        'email_queue_enabled' => true,
        'vapid_public_key' => '',
        'vapid_private_key' => '',
        'vapid_subject' => 'mailto:info@infinitywearsa.com'
    ]);
    
    echo "   ✅ تم تحديث إعدادات البريد الإلكتروني بنجاح!\n\n";
    
    echo "2. إعدادات البريد الإلكتروني:\n";
    echo "   الخادم: smtp.hostinger.com:465 (SSL)\n";
    echo "   البريد: info@infinitywearsa.com\n";
    echo "   التشفير: SSL\n";
    echo "   الإشعارات: مفعلة\n\n";
    
    echo "3. أنواع الإشعارات المفعلة:\n";
    echo "   ✅ الطلبات الجديدة\n";
    echo "   ✅ رسائل الاتصال\n";
    echo "   ✅ رسائل الواتساب\n";
    echo "   ✅ طلبات المستوردين\n";
    echo "   ✅ إشعارات النظام\n\n";
    
    echo "=== انتهى التحديث ===\n";
    echo "النتيجة: ✅ تم تحديث جميع الإعدادات بنجاح!\n";
    echo "النظام جاهز لإرسال الإشعارات والإيميلات.\n";

} catch (Exception $e) {
    echo "❌ خطأ: " . $e->getMessage() . "\n";
    echo "تتبع الخطأ: " . $e->getTraceAsString() . "\n";
}
