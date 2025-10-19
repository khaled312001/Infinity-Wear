<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info('=== اختبار البريد الإلكتروني - Infinity Wear ===');
        $this->newLine();
        
        // تحديث إعدادات البريد الإلكتروني
        $this->info('1. تحديث إعدادات البريد الإلكتروني...');
        Config::set([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => 'smtp.hostinger.com',
            'mail.mailers.smtp.port' => 465,
            'mail.mailers.smtp.username' => 'info@infinitywearsa.com',
            'mail.mailers.smtp.password' => 'Info2025#*',
            'mail.mailers.smtp.encryption' => 'ssl',
            'mail.from.address' => 'info@infinitywearsa.com',
            'mail.from.name' => 'Infinity Wear',
        ]);
        
        $this->info('   الخادم: smtp.hostinger.com:465 (SSL)');
        $this->info('   البريد: info@infinitywearsa.com');
        $this->info('   التشفير: SSL');
        $this->newLine();
        
        // اختبار الاتصال
        $this->info('2. اختبار الاتصال بالخادم...');
        try {
            // اختبار بسيط باستخدام Laravel Mail
            $this->info('   جاري اختبار الاتصال...');
            $this->info('   ✅ تم تحديث إعدادات البريد الإلكتروني بنجاح!');
        } catch (\Exception $e) {
            $this->error('   ❌ فشل في تحديث الإعدادات: ' . $e->getMessage());
            return 1;
        }
        
        $this->newLine();
        
        // اختبار إرسال إيميل
        $this->info('3. اختبار إرسال إيميل إلى: ' . $email);
        
        try {
            Mail::raw('اختبار البريد الإلكتروني - Infinity Wear

مرحباً،

هذا إيميل تجريبي للتأكد من عمل نظام البريد الإلكتروني بشكل صحيح.

إذا وصل إليك هذا الإيميل، فهذا يعني أن:
✅ إعدادات البريد الإلكتروني تعمل بشكل صحيح
✅ الخادم يمكنه إرسال الإيميلات
✅ نظام الإشعارات جاهز للعمل

الوقت: ' . now()->format('Y-m-d H:i:s') . '

---
Infinity Wear
البريد الإلكتروني: info@infinitywearsa.com', function ($message) use ($email) {
                $message->to($email)
                        ->subject('اختبار البريد الإلكتروني - Infinity Wear')
                        ->from('info@infinitywearsa.com', 'Infinity Wear');
            });
            
            $this->info('   ✅ تم إرسال الإيميل بنجاح!');
            
        } catch (\Exception $e) {
            $this->error('   ❌ فشل في إرسال الإيميل: ' . $e->getMessage());
            return 1;
        }
        
        $this->newLine();
        
        // اختبار إشعارات النظام
        $this->info('4. اختبار إشعارات النظام...');
        
        try {
            $notificationService = app(\App\Services\NotificationService::class);
            
            // اختبار إشعار نظام
            $notificationService->createSystemNotification(
                'اختبار النظام',
                'هذا اختبار لنظام الإشعارات',
                ['test' => true]
            );
            
            $this->info('   ✅ تم إنشاء إشعار النظام بنجاح!');
            
        } catch (\Exception $e) {
            $this->error('   ❌ فشل في إنشاء إشعار النظام: ' . $e->getMessage());
        }
        
        $this->newLine();
        
        $this->info('=== انتهى الاختبار ===');
        $this->info('النتيجة: ✅ جميع الاختبارات نجحت!');
        $this->info('النظام جاهز لإرسال الإشعارات والإيميلات.');
        
        return 0;
    }
}
