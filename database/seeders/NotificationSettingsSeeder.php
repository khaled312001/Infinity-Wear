<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NotificationSetting;

class NotificationSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء إعدادات الإشعارات الافتراضية
        NotificationSetting::create([
            'email_notifications_enabled' => true,
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_username' => null, // سيتم ملؤها من قبل المدير
            'smtp_password' => null, // سيتم ملؤها من قبل المدير
            'smtp_encryption' => 'tls',
            'from_email' => null, // سيتم ملؤها من قبل المدير
            'from_name' => 'Infinity Wear',
            'admin_email' => null, // سيتم ملؤها من قبل المدير
            
            // إعدادات الإشعارات حسب النوع
            'notify_new_orders' => true,
            'notify_contact_messages' => true,
            'notify_whatsapp_messages' => true,
            'notify_importer_orders' => true,
            'notify_system_updates' => true,
            
            // إعدادات إضافية
            'email_verification_enabled' => true,
            'email_rate_limit' => 60,
            'email_queue_enabled' => true,
            'email_template_customization' => null,
        ]);
    }
}
