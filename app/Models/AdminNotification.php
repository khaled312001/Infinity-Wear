<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'email_content',
        'type',
        'target_type',
        'target_users',
        'target_user_types',
        'priority',
        'category',
        'is_scheduled',
        'scheduled_at',
        'is_sent',
        'sent_at',
        'sent_count',
        'failed_count',
        'send_results',
        'created_by'
    ];

    protected $casts = [
        'target_users' => 'array',
        'target_user_types' => 'array',
        'send_results' => 'array',
        'is_scheduled' => 'boolean',
        'is_sent' => 'boolean',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    /**
     * العلاقة مع منشئ الإشعار
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * الحصول على المستخدمين المستهدفين
     */
    public function getTargetUsers()
    {
        if ($this->target_type === 'all') {
            return User::where('is_active', true)->get();
        } elseif ($this->target_type === 'user_type' && $this->target_user_types) {
            return User::whereIn('user_type', $this->target_user_types)
                      ->where('is_active', true)
                      ->get();
        } elseif ($this->target_type === 'specific_users' && $this->target_users) {
            return User::whereIn('id', $this->target_users)
                      ->where('is_active', true)
                      ->get();
        }
        
        return collect();
    }

    /**
     * الحصول على تسمية نوع الإرسال
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'notification' => 'إشعار فقط',
            'email' => 'إيميل فقط',
            'both' => 'إشعار وإيميل',
            default => $this->type
        };
    }

    /**
     * الحصول على تسمية نوع المستهدفين
     */
    public function getTargetTypeLabelAttribute(): string
    {
        return match($this->target_type) {
            'specific_users' => 'مستخدمين محددين',
            'user_type' => 'نوع مستخدم',
            'all' => 'جميع المستخدمين',
            default => $this->target_type
        };
    }

    /**
     * الحصول على تسمية الأولوية
     */
    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            'low' => 'منخفضة',
            'normal' => 'عادية',
            'high' => 'عالية',
            'urgent' => 'عاجلة',
            default => $this->priority
        };
    }

    /**
     * الحصول على لون الأولوية
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'low' => 'success',
            'normal' => 'primary',
            'high' => 'warning',
            'urgent' => 'danger',
            default => 'primary'
        };
    }

    /**
     * التحقق من إمكانية الإرسال
     */
    public function canBeSent(): bool
    {
        if ($this->is_sent) {
            return false;
        }

        if ($this->is_scheduled && $this->scheduled_at && $this->scheduled_at->isFuture()) {
            return false;
        }

        return true;
    }

    /**
     * تسجيل نتيجة الإرسال
     */
    public function recordSendResult($userId, $success, $error = null)
    {
        $results = $this->send_results ?? [];
        $results[] = [
            'user_id' => $userId,
            'success' => $success,
            'error' => $error,
            'sent_at' => now()
        ];

        $this->update([
            'send_results' => $results,
            'sent_count' => $this->sent_count + ($success ? 1 : 0),
            'failed_count' => $this->failed_count + ($success ? 0 : 1)
        ]);
    }
}
