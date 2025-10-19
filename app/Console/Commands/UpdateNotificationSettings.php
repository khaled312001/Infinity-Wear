<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NotificationSetting;

class UpdateNotificationSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:update-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update notification settings with official email configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== تحديث إعدادات الإشعارات ===');
        $this->newLine();
        
        try {
            // تحديث إعدادات الإشعارات
            $this->info('1. تحديث إعدادات البريد الإلكتروني...');
            
            $settings = NotificationSetting::getSettings();
            
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
            
            $this->info('   ✅ تم تحديث إعدادات البريد الإلكتروني بنجاح!');
            $this->newLine();
            
            $this->info('2. إعدادات البريد الإلكتروني:');
            $this->info('   الخادم: smtp.hostinger.com:465 (SSL)');
            $this->info('   البريد: info@infinitywearsa.com');
            $this->info('   التشفير: SSL');
            $this->info('   الإشعارات: مفعلة');
            $this->newLine();
            
            $this->info('3. أنواع الإشعارات المفعلة:');
            $this->info('   ✅ الطلبات الجديدة');
            $this->info('   ✅ رسائل الاتصال');
            $this->info('   ✅ رسائل الواتساب');
            $this->info('   ✅ طلبات المستوردين');
            $this->info('   ✅ إشعارات النظام');
            $this->newLine();
            
            $this->info('=== انتهى التحديث ===');
            $this->info('النتيجة: ✅ تم تحديث جميع الإعدادات بنجاح!');
            $this->info('النظام جاهز لإرسال الإشعارات والإيميلات.');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ خطأ: ' . $e->getMessage());
            return 1;
        }
    }
}
