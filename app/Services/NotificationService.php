<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Order;
use App\Models\Contact;
use App\Models\WhatsAppMessage;
use App\Models\ImporterOrder;

class NotificationService
{
    /**
     * إنشاء إشعار طلب جديد
     */
    public function createOrderNotification(Order $order)
    {
        return Notification::createOrderNotification($order);
    }

    /**
     * إنشاء إشعار رسالة اتصال جديدة
     */
    public function createContactNotification(Contact $contact)
    {
        return Notification::createContactNotification($contact);
    }

    /**
     * إنشاء إشعار رسالة واتساب جديدة
     */
    public function createWhatsAppNotification(WhatsAppMessage $message)
    {
        return Notification::createWhatsAppNotification($message);
    }

    /**
     * إنشاء إشعار طلب مستورد جديد
     */
    public function createImporterOrderNotification(ImporterOrder $importerOrder)
    {
        return Notification::createImporterOrderNotification($importerOrder);
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
}
