<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_notifications_enabled',
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
        'smtp_encryption',
        'from_email',
        'from_name',
        'admin_email',
        'notify_new_orders',
        'notify_contact_messages',
        'notify_whatsapp_messages',
        'notify_importer_orders',
        'notify_system_updates',
        'email_verification_enabled',
        'email_rate_limit',
        'email_queue_enabled',
        'email_template_customization'
    ];

    protected $casts = [
        'email_notifications_enabled' => 'boolean',
        'notify_new_orders' => 'boolean',
        'notify_contact_messages' => 'boolean',
        'notify_whatsapp_messages' => 'boolean',
        'notify_importer_orders' => 'boolean',
        'notify_system_updates' => 'boolean',
        'email_verification_enabled' => 'boolean',
        'email_queue_enabled' => 'boolean',
        'email_template_customization' => 'array',
        'smtp_port' => 'integer',
        'email_rate_limit' => 'integer'
    ];

    /**
     * الحصول على إعدادات الإشعارات (Singleton pattern)
     */
    public static function getSettings()
    {
        $settings = self::first();
        
        if (!$settings) {
            $settings = self::create([
                'email_notifications_enabled' => true,
                'smtp_port' => 587,
                'smtp_encryption' => 'tls',
                'from_name' => 'Infinity Wear',
                'notify_new_orders' => true,
                'notify_contact_messages' => true,
                'notify_whatsapp_messages' => true,
                'notify_importer_orders' => true,
                'notify_system_updates' => true,
                'email_verification_enabled' => true,
                'email_rate_limit' => 60,
                'email_queue_enabled' => true
            ]);
        }
        
        return $settings;
    }

    /**
     * تحديث إعدادات الإشعارات
     */
    public static function updateSettings(array $data)
    {
        $settings = self::getSettings();
        $settings->update($data);
        return $settings;
    }

    /**
     * التحقق من تفعيل الإشعارات عبر البريد الإلكتروني
     */
    public function isEmailNotificationsEnabled()
    {
        return $this->email_notifications_enabled && 
               !empty($this->smtp_host) && 
               !empty($this->smtp_username) && 
               !empty($this->smtp_password) &&
               !empty($this->from_email) &&
               !empty($this->admin_email);
    }

    /**
     * التحقق من تفعيل إشعارات نوع معين
     */
    public function isNotificationTypeEnabled($type)
    {
        switch ($type) {
            case 'order':
                return $this->notify_new_orders;
            case 'contact':
                return $this->notify_contact_messages;
            case 'whatsapp':
                return $this->notify_whatsapp_messages;
            case 'importer_order':
                return $this->notify_importer_orders;
            case 'system':
                return $this->notify_system_updates;
            default:
                return false;
        }
    }

    /**
     * الحصول على إعدادات SMTP
     */
    public function getSmtpConfig()
    {
        return [
            'host' => $this->smtp_host,
            'port' => $this->smtp_port,
            'username' => $this->smtp_username,
            'password' => $this->smtp_password,
            'encryption' => $this->smtp_encryption,
        ];
    }

    /**
     * الحصول على إعدادات المرسل
     */
    public function getFromConfig()
    {
        return [
            'address' => $this->from_email,
            'name' => $this->from_name,
        ];
    }
}
