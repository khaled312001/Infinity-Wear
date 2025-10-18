<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'user_type',
        'user_name',
        'comment',
        'is_internal',
        'attachments'
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_internal' => 'boolean',
    ];

    /**
     * العلاقة مع المهمة
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(TaskCard::class, 'task_id');
    }

    /**
     * العلاقة مع المستخدم (Admin)
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    /**
     * العلاقة مع المستخدم (Marketing)
     */
    public function marketing(): BelongsTo
    {
        return $this->belongsTo(MarketingTeam::class, 'user_id');
    }

    /**
     * العلاقة مع المستخدم (Sales)
     */
    public function sales(): BelongsTo
    {
        return $this->belongsTo(SalesTeam::class, 'user_id');
    }

    /**
     * الحصول على المستخدم
     */
    public function getUserAttribute()
    {
        return match($this->user_type) {
            'admin' => $this->admin,
            'marketing' => $this->marketing,
            'sales' => $this->sales,
            default => null
        };
    }

    /**
     * الحصول على نوع المستخدم بشكل مقروء
     */
    public function getUserTypeLabelAttribute(): string
    {
        return match($this->user_type) {
            'admin' => 'مدير',
            'marketing' => 'تسويق',
            'sales' => 'مبيعات',
            default => $this->user_type
        };
    }

    /**
     * تحديد ما إذا كان التعليق داخلي
     */
    public function getIsInternalLabelAttribute(): string
    {
        return $this->is_internal ? 'داخلي' : 'عام';
    }
}
