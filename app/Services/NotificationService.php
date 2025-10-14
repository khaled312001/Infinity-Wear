<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Order;
use App\Models\Contact;
use App\Models\WhatsAppMessage;
use App\Models\ImporterOrder;
use App\Models\NotificationSetting;
use App\Models\PushSubscription;
use App\Mail\OrderNotificationMail;
use App\Mail\ContactNotificationMail;
use App\Mail\WhatsAppNotificationMail;
use App\Mail\SystemNotificationMail;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * إنشاء إشعار طلب جديد
     */
    public function createOrderNotification(Order $order)
    {
        // الحصول على أول مدير نشط لإرسال الإشعار إليه
        $admin = \App\Models\Admin::where('is_active', true)->first();
        
        if (!$admin) {
            return null;
        }
        
        // البحث عن مستخدم مطابق للمدير في جدول المستخدمين
        $user = \App\Models\User::where('email', $admin->email)->where('user_type', 'admin')->first();
        
        if (!$user) {
            // إنشاء مستخدم جديد للمدير إذا لم يكن موجوداً
            $user = \App\Models\User::create([
                'name' => $admin->name,
                'email' => $admin->email,
                'password' => $admin->password,
                'user_type' => 'admin',
                'is_active' => true,
            ]);
        }
        
        // إنشاء الإشعار في قاعدة البيانات
        $notification = Notification::createOrderNotification($user->id, $order);
        
        // إرسال الإشعار عبر البريد الإلكتروني
        $this->sendEmailNotification('order', $order, $admin->email);
        
        return $notification;
    }

    /**
     * إنشاء إشعار رسالة اتصال جديدة
     */
    public function createContactNotification(Contact $contact)
    {
        // الحصول على أول مدير نشط لإرسال الإشعار إليه
        $admin = \App\Models\Admin::where('is_active', true)->first();
        
        if (!$admin) {
            return null;
        }
        
        // البحث عن مستخدم مطابق للمدير في جدول المستخدمين
        $user = \App\Models\User::where('email', $admin->email)->where('user_type', 'admin')->first();
        
        if (!$user) {
            // إنشاء مستخدم جديد للمدير إذا لم يكن موجوداً
            $user = \App\Models\User::create([
                'name' => $admin->name,
                'email' => $admin->email,
                'password' => $admin->password,
                'user_type' => 'admin',
                'is_active' => true,
            ]);
        }
        
        // إنشاء الإشعار في قاعدة البيانات
        $notification = Notification::createContactNotification($user->id, $contact);
        
        // إرسال الإشعار عبر البريد الإلكتروني
        $this->sendEmailNotification('contact', $contact, $admin->email);
        
        return $notification;
    }

    /**
     * إنشاء إشعار رسالة واتساب جديدة
     */
    public function createWhatsAppNotification(WhatsAppMessage $message)
    {
        // الحصول على أول مدير نشط لإرسال الإشعار إليه
        $admin = \App\Models\Admin::where('is_active', true)->first();
        
        if (!$admin) {
            return null;
        }
        
        // البحث عن مستخدم مطابق للمدير في جدول المستخدمين
        $user = \App\Models\User::where('email', $admin->email)->where('user_type', 'admin')->first();
        
        if (!$user) {
            // إنشاء مستخدم جديد للمدير إذا لم يكن موجوداً
            $user = \App\Models\User::create([
                'name' => $admin->name,
                'email' => $admin->email,
                'password' => $admin->password,
                'user_type' => 'admin',
                'is_active' => true,
            ]);
        }
        
        // إنشاء الإشعار في قاعدة البيانات
        $notification = Notification::createWhatsAppNotification($user->id, $message);
        
        // إرسال الإشعار عبر البريد الإلكتروني
        $this->sendEmailNotification('whatsapp', $message, $admin->email);
        
        return $notification;
    }

    /**
     * إنشاء إشعار طلب مستورد جديد
     */
    public function createImporterOrderNotification(ImporterOrder $importerOrder)
    {
        // الحصول على أول مدير نشط لإرسال الإشعار إليه
        $admin = \App\Models\Admin::where('is_active', true)->first();
        
        if (!$admin) {
            // إذا لم يوجد مدير، إنشاء إشعار بدون مستخدم محدد
            return null;
        }
        
        // البحث عن مستخدم مطابق للمدير في جدول المستخدمين
        $user = \App\Models\User::where('email', $admin->email)->where('user_type', 'admin')->first();
        
        if (!$user) {
            // إنشاء مستخدم جديد للمدير إذا لم يكن موجوداً
            $user = \App\Models\User::create([
                'name' => $admin->name,
                'email' => $admin->email,
                'password' => $admin->password, // استخدام نفس كلمة المرور
                'user_type' => 'admin',
                'is_active' => true,
            ]);
        }
        
        return Notification::createImporterOrderNotification($user->id, $importerOrder);
    }

    /**
     * الحصول على الإشعارات غير المقروءة
     */
    public function getUnreadNotifications($limit = 10)
    {
        return Notification::unread()
            ->notArchived()
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * الحصول على عدد الإشعارات غير المقروءة
     */
    public function getUnreadCount()
    {
        return Notification::unread()->notArchived()->count();
    }

    /**
     * الحصول على إحصائيات الإشعارات
     */
    public function getNotificationStats()
    {
        return [
            'total_unread' => Notification::unread()->notArchived()->count(),
            'orders' => Notification::unread()->notArchived()->ofType('order')->count(),
            'contacts' => Notification::unread()->notArchived()->ofType('contact')->count(),
            'whatsapp' => Notification::unread()->notArchived()->ofType('whatsapp')->count(),
            'importer_orders' => Notification::unread()->notArchived()->ofType('importer_order')->count(),
        ];
    }

    /**
     * تحديد جميع الإشعارات كمقروءة
     */
    public function markAllAsRead()
    {
        return Notification::unread()->notArchived()->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    /**
     * تحديد إشعار معين كمقروء
     */
    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            return true;
        }
        return false;
    }

    /**
     * أرشفة إشعار معين
     */
    public function archiveNotification($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->archive();
            return true;
        }
        return false;
    }

    /**
     * أرشفة جميع الإشعارات المقروءة
     */
    public function archiveReadNotifications()
    {
        return Notification::where('is_read', true)
            ->where('is_archived', false)
            ->update([
                'is_archived' => true,
                'archived_at' => now()
            ]);
    }

    /**
     * حذف الإشعارات المؤرشفة القديمة (أكثر من 30 يوم)
     */
    public function cleanupOldNotifications($days = 30)
    {
        return Notification::where('is_archived', true)
            ->where('archived_at', '<', now()->subDays($days))
            ->delete();
    }

    /**
     * إرسال الإشعارات عبر البريد الإلكتروني
     */
    public function sendEmailNotification($type, $data, $adminEmail)
    {
        try {
            $settings = NotificationSetting::getSettings();
            
            // التحقق من تفعيل الإشعارات عبر البريد الإلكتروني
            if (!$settings->isEmailNotificationsEnabled()) {
                Log::info('Email notifications disabled or settings incomplete');
                return false;
            }
            
            // التحقق من تفعيل نوع الإشعار
            if (!$settings->isNotificationTypeEnabled($type)) {
                Log::info("Email notification type '{$type}' is disabled");
                return false;
            }
            
            // تحديث إعدادات البريد الإلكتروني
            $this->updateMailConfig($settings);
            
            // إرسال البريد الإلكتروني حسب النوع
            switch ($type) {
                case 'order':
                    if ($settings->email_queue_enabled) {
                        Mail::to($adminEmail)->queue(new OrderNotificationMail($data, $adminEmail));
                    } else {
                        Mail::to($adminEmail)->send(new OrderNotificationMail($data, $adminEmail));
                    }
                    break;
                    
                case 'contact':
                    if ($settings->email_queue_enabled) {
                        Mail::to($adminEmail)->queue(new ContactNotificationMail($data, $adminEmail));
                    } else {
                        Mail::to($adminEmail)->send(new ContactNotificationMail($data, $adminEmail));
                    }
                    break;
                    
                case 'whatsapp':
                    if ($settings->email_queue_enabled) {
                        Mail::to($adminEmail)->queue(new WhatsAppNotificationMail($data, $adminEmail));
                    } else {
                        Mail::to($adminEmail)->send(new WhatsAppNotificationMail($data, $adminEmail));
                    }
                    break;
                    
                case 'system':
                    if ($settings->email_queue_enabled) {
                        Mail::to($adminEmail)->queue(new SystemNotificationMail($data['title'], $data['message'], $adminEmail, $data['data'] ?? []));
                    } else {
                        Mail::to($adminEmail)->send(new SystemNotificationMail($data['title'], $data['message'], $adminEmail, $data['data'] ?? []));
                    }
                    break;
            }
            
            // إرسال Push Notification
            $this->sendPushNotification($type, $data, $adminEmail);
            
            Log::info("Email notification sent successfully", [
                'type' => $type,
                'to' => $adminEmail,
                'queued' => $settings->email_queue_enabled
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to send email notification: ' . $e->getMessage(), [
                'type' => $type,
                'to' => $adminEmail,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }

    /**
     * تحديث إعدادات البريد الإلكتروني
     */
    private function updateMailConfig(NotificationSetting $settings)
    {
        $smtpConfig = $settings->getSmtpConfig();
        $fromConfig = $settings->getFromConfig();
        
        // تحديث إعدادات البريد الإلكتروني
        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => $smtpConfig['host'],
            'mail.mailers.smtp.port' => $smtpConfig['port'],
            'mail.mailers.smtp.username' => $smtpConfig['username'],
            'mail.mailers.smtp.password' => $smtpConfig['password'],
            'mail.mailers.smtp.encryption' => $smtpConfig['encryption'],
            'mail.from.address' => $fromConfig['address'],
            'mail.from.name' => $fromConfig['name'],
        ]);
    }

    /**
     * إنشاء إشعار نظام
     */
    public function createSystemNotification($title, $message, $data = [])
    {
        // الحصول على أول مدير نشط لإرسال الإشعار إليه
        $admin = \App\Models\Admin::where('is_active', true)->first();
        
        if (!$admin) {
            return null;
        }
        
        // البحث عن مستخدم مطابق للمدير في جدول المستخدمين
        $user = \App\Models\User::where('email', $admin->email)->where('user_type', 'admin')->first();
        
        if (!$user) {
            // إنشاء مستخدم جديد للمدير إذا لم يكن موجوداً
            $user = \App\Models\User::create([
                'name' => $admin->name,
                'email' => $admin->email,
                'password' => $admin->password,
                'user_type' => 'admin',
                'is_active' => true,
            ]);
        }
        
        // إنشاء الإشعار في قاعدة البيانات
        $notification = Notification::create([
            'user_id' => $user->id,
            'type' => 'system',
            'title' => $title,
            'message' => $message,
            'icon' => 'fas fa-cogs',
            'color' => 'info',
            'data' => $data
        ]);
        
        // إرسال الإشعار عبر البريد الإلكتروني
        $this->sendEmailNotification('system', [
            'title' => $title,
            'message' => $message,
            'data' => $data
        ], $admin->email);
        
        return $notification;
    }

    /**
     * إرسال Push Notification
     */
    private function sendPushNotification($type, $data, $adminEmail)
    {
        try {
            // التحقق من تفعيل Push Notifications
            if (!config('push.settings.enabled', true)) {
                return false;
            }

            // الحصول على الاشتراكات النشطة
            $subscriptions = PushSubscription::getActiveSubscriptions('admin');
            
            if ($subscriptions->isEmpty()) {
                Log::info('No active push subscriptions found');
                return false;
            }

            // إعداد بيانات الإشعار
            $payload = $this->preparePushPayload($type, $data);
            
            // إرسال الإشعار
            $sentCount = $this->sendToPushSubscriptions($subscriptions, $payload);
            
            Log::info("Push notification sent successfully", [
                'type' => $type,
                'sent_count' => $sentCount,
                'total_subscriptions' => $subscriptions->count()
            ]);
            
            return true;
            
        } catch (\Exception $e) {
            Log::error("Push notification failed", [
                'type' => $type,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * إعداد بيانات Push Notification
     */
    private function preparePushPayload($type, $data)
    {
        $config = config("push.types.{$type}", []);
        
        $payload = [
            'title' => $config['title'] ?? 'إشعار جديد',
            'body' => '',
            'icon' => $config['icon'] ?? config('push.settings.default_icon'),
            'badge' => config('push.settings.default_badge'),
            'url' => $config['url'] ?? config('push.settings.default_url'),
            'timestamp' => now()->toISOString(),
            'data' => [
                'type' => $type,
                'id' => $data->id ?? null
            ]
        ];

        // إعداد النص حسب النوع
        switch ($type) {
            case 'order':
                $payload['body'] = "طلب جديد من {$data->customer_name} - رقم الطلب: {$data->id}";
                $payload['data']['order_id'] = $data->id;
                break;
                
            case 'contact':
                $payload['body'] = "رسالة اتصال جديدة من {$data->name}";
                $payload['data']['contact_id'] = $data->id;
                break;
                
            case 'whatsapp':
                $payload['body'] = "رسالة واتساب جديدة من {$data->sender_name}";
                $payload['data']['message_id'] = $data->id;
                break;
                
            case 'system':
                $payload['title'] = $data['title'] ?? 'إشعار النظام';
                $payload['body'] = $data['message'] ?? 'لديك إشعار جديد من النظام';
                break;
        }

        return $payload;
    }

    /**
     * إرسال الإشعار إلى قائمة من الاشتراكات
     */
    private function sendToPushSubscriptions($subscriptions, $payload)
    {
        $sentCount = 0;
        $vapidKeys = $this->getVapidKeys();

        if (!$vapidKeys['public_key'] || !$vapidKeys['private_key']) {
            Log::warning('VAPID keys not configured');
            return 0;
        }

        $webPush = new WebPush([
            'VAPID' => [
                'subject' => config('push.vapid.subject'),
                'publicKey' => $vapidKeys['public_key'],
                'privateKey' => $vapidKeys['private_key']
            ]
        ]);

        foreach ($subscriptions as $subscription) {
            try {
                $pushSubscription = Subscription::create([
                    'endpoint' => $subscription->endpoint,
                    'keys' => [
                        'p256dh' => $subscription->p256dh_key,
                        'auth' => $subscription->auth_key
                    ]
                ]);

                $webPush->queueNotification(
                    $pushSubscription,
                    json_encode($payload)
                );

                $subscription->updateLastUsed();
                $sentCount++;

            } catch (\Exception $e) {
                Log::warning('Failed to send push notification', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage()
                ]);

                // إلغاء تفعيل الاشتراك إذا كان غير صالح
                if (str_contains($e->getMessage(), '410') || str_contains($e->getMessage(), '404')) {
                    $subscription->deactivate();
                }
            }
        }

        // إرسال جميع الإشعارات
        $webPush->flush();

        return $sentCount;
    }

    /**
     * الحصول على مفاتيح VAPID
     */
    private function getVapidKeys()
    {
        return [
            'public_key' => config('push.vapid.public_key'),
            'private_key' => config('push.vapid.private_key')
        ];
    }
}
