<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsAppMessage extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_messages';

    protected $fillable = [
        'message_id',
        'from_number',
        'to_number',
        'contact_name',
        'message_content',
        'message_type',
        'direction',
        'status',
        'sent_at',
        'delivered_at',
        'read_at',
        'media_url',
        'sent_by',
        'contact_id',
        'contact_type',
        'is_archived',
        'whatsapp_url'
    ];

    protected $casts = [
        'media_url' => 'array',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    /**
     * العلاقة مع الإداري الذي أرسل الرسالة
     */
    public function sentBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'sent_by');
    }

    /**
     * العلاقة مع جهة الاتصال في النظام
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contact_id');
    }

    /**
     * الحصول على نوع الرسالة بشكل مقروء
     */
    public function getMessageTypeLabelAttribute(): string
    {
        return match($this->message_type) {
            'text' => 'نص',
            'image' => 'صورة',
            'document' => 'مستند',
            'audio' => 'صوت',
            'video' => 'فيديو',
            default => $this->message_type
        };
    }

    /**
     * الحصول على اتجاه الرسالة بشكل مقروء
     */
    public function getDirectionLabelAttribute(): string
    {
        return match($this->direction) {
            'inbound' => 'واردة',
            'outbound' => 'صادرة',
            default => $this->direction
        };
    }

    /**
     * الحصول على حالة الرسالة بشكل مقروء
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'sent' => 'مرسلة',
            'delivered' => 'تم التسليم',
            'read' => 'تم القراءة',
            'failed' => 'فشل الإرسال',
            default => $this->status
        };
    }

    /**
     * الحصول على نوع جهة الاتصال بشكل مقروء
     */
    public function getContactTypeLabelAttribute(): string
    {
        return match($this->contact_type) {
            'importer' => 'مستورد',
            'marketing' => 'تسويق',
            'sales' => 'مبيعات',
            'external' => 'خارجي',
            default => $this->contact_type
        };
    }

    /**
     * الحصول على لون حالة الرسالة
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'sent' => 'primary',
            'delivered' => 'info',
            'read' => 'success',
            'failed' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * الحصول على لون اتجاه الرسالة
     */
    public function getDirectionColorAttribute(): string
    {
        return match($this->direction) {
            'inbound' => 'success',
            'outbound' => 'primary',
            default => 'secondary'
        };
    }

    /**
     * الحصول على لون نوع جهة الاتصال
     */
    public function getContactTypeColorAttribute(): string
    {
        return match($this->contact_type) {
            'importer' => 'warning',
            'marketing' => 'info',
            'sales' => 'success',
            'external' => 'secondary',
            default => 'secondary'
        };
    }

    /**
     * Scope للحصول على الرسائل الواردة فقط
     */
    public function scopeInbound($query)
    {
        return $query->where('direction', 'inbound');
    }

    /**
     * Scope للحصول على الرسائل الصادرة فقط
     */
    public function scopeOutbound($query)
    {
        return $query->where('direction', 'outbound');
    }

    /**
     * Scope للحصول على رسائل جهة اتصال معينة
     */
    public function scopeForContact($query, $number)
    {
        return $query->where(function($q) use ($number) {
            $q->where('from_number', $number)
              ->orWhere('to_number', $number);
        });
    }

    /**
     * Scope للحصول على الرسائل غير المؤرشفة
     */
    public function scopeNotArchived($query)
    {
        return $query->where('is_archived', false);
    }

    /**
     * تنسيق رقم الهاتف للواتساب
     */
    public static function formatPhoneNumber($phone)
    {
        // إزالة جميع الأحرف غير الرقمية
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // إضافة رمز البلد إذا لم يكن موجود
        if (!str_starts_with($phone, '966') && !str_starts_with($phone, '+966')) {
            if (str_starts_with($phone, '0')) {
                $phone = '966' . substr($phone, 1);
            } else {
                $phone = '966' . $phone;
            }
        }
        
        return $phone;
    }

    /**
     * إنشاء رابط الواتساب للرسالة
     */
    public function getWhatsAppUrlAttribute(): string
    {
        $phone = self::formatPhoneNumber($this->to_number);
        $message = urlencode($this->message_content);
        return "https://wa.me/{$phone}?text={$message}";
    }
}