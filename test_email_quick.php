<?php
/**
 * اختبار سريع لنظام الإيميل
 * Quick Email System Test
 */

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Mail;
use App\Services\EmailService;

// إعدادات الإيميل
$emailConfig = [
    'MAIL_MAILER' => 'smtp',
    'MAIL_HOST' => 'smtp.hostinger.com',
    'MAIL_PORT' => 465,
    'MAIL_USERNAME' => 'info@infinitywearsa.com',
    'MAIL_PASSWORD' => 'Info2025#*',
    'MAIL_ENCRYPTION' => 'ssl',
    'MAIL_FROM_ADDRESS' => 'info@infinitywearsa.com',
    'MAIL_FROM_NAME' => 'Infinity Wear',
    'MAIL_ADMIN_EMAIL' => 'info@infinitywearsa.com'
];

echo "=== اختبار نظام الإيميل - Infinity Wear ===\n";
echo "Email System Test - Infinity Wear\n\n";

// اختبار الاتصال بـ SMTP
echo "1. اختبار الاتصال بـ SMTP...\n";
echo "Testing SMTP connection...\n";

try {
    $transport = new \Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport(
        $emailConfig['MAIL_HOST'],
        $emailConfig['MAIL_PORT'],
        true
    );
    
    $transport->setUsername($emailConfig['MAIL_USERNAME']);
    $transport->setPassword($emailConfig['MAIL_PASSWORD']);
    
    // اختبار الاتصال
    $transport->start();
    echo "✅ الاتصال بـ SMTP ناجح!\n";
    echo "✅ SMTP connection successful!\n\n";
    
} catch (Exception $e) {
    echo "❌ فشل الاتصال بـ SMTP: " . $e->getMessage() . "\n";
    echo "❌ SMTP connection failed: " . $e->getMessage() . "\n\n";
}

// اختبار إرسال إيميل بسيط
echo "2. اختبار إرسال إيميل...\n";
echo "Testing email sending...\n";

try {
    // إعداد Mailer
    $mailer = new \Symfony\Component\Mailer\Mailer($transport);
    
    // إنشاء رسالة
    $email = (new \Symfony\Component\Mime\Email())
        ->from($emailConfig['MAIL_FROM_ADDRESS'])
        ->to($emailConfig['MAIL_ADMIN_EMAIL'])
        ->subject('اختبار نظام الإيميل - Infinity Wear')
        ->text('هذا اختبار لنظام الإيميل الجديد لشركة Infinity Wear.')
        ->html('
            <html>
            <body dir="rtl">
                <h2>اختبار نظام الإيميل</h2>
                <p>هذا اختبار لنظام الإيميل الجديد لشركة Infinity Wear.</p>
                <p>تم الإرسال في: ' . date('Y-m-d H:i:s') . '</p>
                <hr>
                <p><strong>Infinity Wear</strong> - نظام إدارة الإيميلات</p>
            </body>
            </html>
        ');
    
    // إرسال الإيميل
    $mailer->send($email);
    
    echo "✅ تم إرسال الإيميل بنجاح!\n";
    echo "✅ Email sent successfully!\n\n";
    
} catch (Exception $e) {
    echo "❌ فشل إرسال الإيميل: " . $e->getMessage() . "\n";
    echo "❌ Email sending failed: " . $e->getMessage() . "\n\n";
}

// اختبار إعدادات IMAP
echo "3. اختبار إعدادات IMAP...\n";
echo "Testing IMAP settings...\n";

$imapHost = 'imap.hostinger.com';
$imapPort = 993;
$imapUsername = $emailConfig['MAIL_USERNAME'];
$imapPassword = $emailConfig['MAIL_PASSWORD'];

try {
    $connectionString = "{{$imapHost}:{$imapPort}/imap/ssl}INBOX";
    $imapConnection = imap_open($connectionString, $imapUsername, $imapPassword);
    
    if ($imapConnection) {
        echo "✅ الاتصال بـ IMAP ناجح!\n";
        echo "✅ IMAP connection successful!\n";
        
        // إحصائيات صندوق الوارد
        $mailboxInfo = imap_mailboxmsginfo($imapConnection);
        echo "📧 عدد الرسائل في صندوق الوارد: " . $mailboxInfo->Nmsgs . "\n";
        echo "📧 Messages in inbox: " . $mailboxInfo->Nmsgs . "\n";
        
        imap_close($imapConnection);
    } else {
        echo "❌ فشل الاتصال بـ IMAP\n";
        echo "❌ IMAP connection failed\n";
    }
    
} catch (Exception $e) {
    echo "❌ خطأ في IMAP: " . $e->getMessage() . "\n";
    echo "❌ IMAP error: " . $e->getMessage() . "\n";
}

echo "\n=== انتهاء الاختبار ===\n";
echo "=== Test Complete ===\n";

// معلومات إضافية
echo "\nمعلومات النظام:\n";
echo "System Information:\n";
echo "- PHP Version: " . PHP_VERSION . "\n";
echo "- Server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "\n";
echo "- Time: " . date('Y-m-d H:i:s') . "\n";
echo "- Timezone: " . date_default_timezone_get() . "\n";

echo "\nإعدادات الإيميل:\n";
echo "Email Settings:\n";
foreach ($emailConfig as $key => $value) {
    if (strpos($key, 'PASSWORD') !== false) {
        echo "- {$key}: [مخفي]\n";
    } else {
        echo "- {$key}: {$value}\n";
    }
}

echo "\nللوصول لصفحة الاختبار الكاملة:\n";
echo "For full testing page:\n";
echo "https://infinitywear.sa/email-test\n";
?>
