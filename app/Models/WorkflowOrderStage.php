<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkflowOrderStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'workflow_order_id',
        'stage_name',
        'status',
        'assigned_user_id',
        'notes',
        'attachments',
        'started_at',
        'completed_at',
        'rejection_reason',
    ];

    protected $casts = [
        'attachments' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * العلاقة مع الطلب
     */
    public function workflowOrder(): BelongsTo
    {
        return $this->belongsTo(WorkflowOrder::class);
    }

    /**
     * العلاقة مع المستخدم المعين
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    /**
     * الحصول على اسم المرحلة بشكل مقروء
     */
    public function getStageLabelAttribute(): string
    {
        return match($this->stage_name) {
            'marketing' => 'التسويق',
            'sales' => 'المبيعات',
            'design' => 'التصميم',
            'first_sample' => 'العينة الأولى',
            'work_approval' => 'اعتماد الشغل',
            'manufacturing' => 'التصنيع',
            'shipping' => 'الشحن',
            'receipt_delivery' => 'استلام وتسليم',
            'collection' => 'التحصيل',
            'after_sales' => 'خدمة ما بعد البيع',
            default => $this->stage_name
        };
    }

    /**
     * الحصول على حالة المرحلة بشكل مقروء
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'في الانتظار',
            'in_progress' => 'قيد التنفيذ',
            'completed' => 'مكتمل',
            'rejected' => 'مرفوض',
            default => $this->status
        };
    }
}
