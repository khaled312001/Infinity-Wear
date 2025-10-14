<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'icon',
        'color',
        'data',
        'is_read',
        'read_at',
        'is_archived',
        'archived_at'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'archived_at' => 'datetime',
        'is_read' => 'boolean',
        'is_archived' => 'boolean',
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope للحصول على الإشعارات غير المقروءة
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope للحصول على الإشعارات غير المؤرشفة
     */
    public function scopeNotArchived($query)
    {
        return $query->where('is_archived', false);
    }

    /**
     * Scope للحصول على إشعارات من نوع معين
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * تحديد الإشعار كمقروء
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    /**
     * أرشفة الإشعار
     */
    public function archive()
    {
        $this->update([
            'is_archived' => true,
            'archived_at' => now()
        ]);
    }

    /**
     * إنشاء إشعار جديد
     */
    public static function createNotification($userId, $type, $title, $message, $icon = 'fas fa-bell', $color = 'primary', $data = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'icon' => $icon,
            'color' => $color,
            'data' => $data
        ]);
    }

    /**
     * إنشاء إشعار طلب جديد
     */
    public static function createOrderNotification($userId, $order)
    {
        return self::createNotification(
            $userId,
            'order',
            'طلب جديد',
            "تم استلام طلب جديد من {$order->customer_name} بقيمة {$order->total} ريال",
            'fas fa-shopping-cart',
            'success',
            ['order_id' => $order->id, 'order_number' => $order->order_number]
        );
    }

    /**
     * إنشاء إشعار رسالة اتصال جديدة
     */
    public static function createContactNotification($userId, $contact)
    {
        return self::createNotification(
            $userId,
            'contact',
            'رسالة اتصال جديدة',
            "رسالة جديدة من {$contact->name} - {$contact->subject}",
            'fas fa-envelope',
            'info',
            [
                'contact_id' => $contact->id, 
                'email' => $contact->email,
                'contact_name' => $contact->name,
                'contact_phone' => $contact->phone,
                'contact_company' => $contact->company,
                'contact_subject' => $contact->subject,
                'contact_message' => $contact->message
            ]
        );
    }

    /**
     * إنشاء إشعار رسالة واتساب جديدة
     */
    public static function createWhatsAppNotification($userId, $message)
    {
        return self::createNotification(
            $userId,
            'whatsapp',
            'رسالة واتساب جديدة',
            "رسالة جديدة من {$message->contact_name} ({$message->from_number})",
            'fab fa-whatsapp',
            'success',
            ['message_id' => $message->id, 'from_number' => $message->from_number]
        );
    }

    /**
     * إنشاء إشعار طلب مستورد جديد
     */
    public static function createImporterOrderNotification($userId, $importerOrder)
    {
        return self::createNotification(
            $userId,
            'importer_order',
            'طلب مستورد جديد',
            "طلب جديد من المستورد {$importerOrder->importer->company_name}",
            'fas fa-industry',
            'warning',
            ['importer_order_id' => $importerOrder->id, 'importer_id' => $importerOrder->importer_id]
        );
    }
}
