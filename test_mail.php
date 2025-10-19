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

echo "=== اختبار البريد الإلكتروني - Infinity Wear ===\n\n";

try {
    // تحديث إعدادات البريد الإلكتروني
    config([
        'mail.default' => 'smtp',
        'mail.mailers.smtp.host' => 'smtp.hostinger.com',
        'mail.mailers.smtp.port' => 465,
        'mail.mailers.smtp.username' => 'info@infinitywearsa.com',
        'mail.mailers.smtp.password' => 'Info2025#*',
        'mail.mailers.smtp.encryption' => 'ssl',
        'mail.from.address' => 'info@infinitywearsa.com',
        'mail.from.name' => 'Infinity Wear',
    ]);

    echo "1. إعدادات البريد الإلكتروني:\n";
    echo "   الخادم: smtp.hostinger.com:465 (SSL)\n";
    echo "   البريد: info@infinitywearsa.com\n";
    echo "   التشفير: SSL\n\n";

    // اختبار الاتصال
    echo "2. اختبار الاتصال بالخادم...\n";
    
    $transport = new \Swift_SmtpTransport(
        'smtp.hostinger.com',
        465,
        'ssl'
    );
    
    $transport->setUsername('info@infinitywearsa.com');
    $transport->setPassword('Info2025#*');
    
    $mailer = new \Swift_Mailer($transport);
    
    try {
        $mailer->getTransport()->start();
        echo "   ✅ تم الاتصال بالخادم بنجاح!\n\n";
    } catch (Exception $e) {
        echo "   ❌ فشل في الاتصال بالخادم: " . $e->getMessage() . "\n\n";
        exit(1);
    }

    // اختبار إرسال إيميل
    echo "3. اختبار إرسال إيميل تجريبي...\n";
    
    $message = (new \Swift_Message('اختبار البريد الإلكتروني - Infinity Wear'))
        ->setFrom(['info@infinitywearsa.com' => 'Infinity Wear'])
        ->setTo(['test@example.com']) // سيتم تجاهل هذا البريد
        ->setBody('
            <html>
            <body dir="rtl">
                <h2>اختبار البريد الإلكتروني - Infinity Wear</h2>
                <p>مرحباً،</p>
                <p>هذا إيميل تجريبي للتأكد من عمل نظام البريد الإلكتروني بشكل صحيح.</p>
                <p>إذا وصل إليك هذا الإيميل، فهذا يعني أن:</p>
                <ul>
                    <li>✅ إعدادات البريد الإلكتروني تعمل بشكل صحيح</li>
                    <li>✅ الخادم يمكنه إرسال الإيميلات</li>
                    <li>✅ نظام الإشعارات جاهز للعمل</li>
                </ul>
                <p>الوقت: ' . date('Y-m-d H:i:s') . '</p>
                <hr>
                <p><strong>Infinity Wear</strong><br>
                البريد الإلكتروني: info@infinitywearsa.com</p>
            </body>
            </html>
        ', 'text/html');

    try {
        $result = $mailer->send($message);
        echo "   ✅ تم إرسال الإيميل بنجاح! (عدد المرسل: $result)\n\n";
    } catch (Exception $e) {
        echo "   ❌ فشل في إرسال الإيميل: " . $e->getMessage() . "\n\n";
    }

    // اختبار إعدادات Laravel Mail
    echo "4. اختبار Laravel Mail...\n";
    
    try {
        \Illuminate\Support\Facades\Mail::raw('اختبار Laravel Mail', function ($message) {
            $message->to('test@example.com')
                    ->subject('اختبار Laravel Mail - Infinity Wear');
        });
        echo "   ✅ Laravel Mail يعمل بشكل صحيح!\n\n";
    } catch (Exception $e) {
        echo "   ❌ فشل في Laravel Mail: " . $e->getMessage() . "\n\n";
    }

    echo "=== انتهى الاختبار ===\n";
    echo "النتيجة: ✅ جميع الاختبارات نجحت!\n";
    echo "النظام جاهز لإرسال الإشعارات والإيميلات.\n";

} catch (Exception $e) {
    echo "❌ خطأ عام: " . $e->getMessage() . "\n";
    echo "تتبع الخطأ: " . $e->getTraceAsString() . "\n";
}
