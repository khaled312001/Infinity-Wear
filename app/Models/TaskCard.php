<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'board_id',
        'column_id',
        'priority',
        'status',
        'due_date',
        'start_date',
        'completed_at',
        'assigned_to',
        'assigned_to_type',
        'created_by',
        'created_by_type',
        'sort_order',
        'color',
        'labels',
        'attachments',
        'checklist',
        'estimated_hours',
        'actual_hours',
        'time_logs',
        'comments',
        'is_archived',
        'is_urgent',
        'tags',
        'progress_percentage',
        'custom_fields'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'start_date' => 'datetime',
        'completed_at' => 'datetime',
        'labels' => 'array',
        'attachments' => 'array',
        'checklist' => 'array',
        'time_logs' => 'array',
        'comments' => 'array',
        'tags' => 'array',
        'custom_fields' => 'array',
        'is_archived' => 'boolean',
        'is_urgent' => 'boolean',
        'progress_percentage' => 'integer',
        'estimated_hours' => 'decimal:2',
        'actual_hours' => 'decimal:2',
    ];

    /**
     * العلاقة مع اللوحة
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(TaskBoard::class, 'board_id');
    }

    /**
     * العلاقة مع العمود
     */
    public function column(): BelongsTo
    {
        return $this->belongsTo(TaskColumn::class, 'column_id');
    }

    /**
     * العلاقة مع المعين (Admin)
     */
    public function assignedAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }

    /**
     * العلاقة مع المعين (Marketing)
     */
    public function assignedMarketing(): BelongsTo
    {
        return $this->belongsTo(MarketingTeam::class, 'assigned_to');
    }

    /**
     * العلاقة مع المعين (Sales)
     */
    public function assignedSales(): BelongsTo
    {
        return $this->belongsTo(SalesTeam::class, 'assigned_to');
    }

    /**
     * العلاقة مع المنشئ (Admin)
     */
    public function createdByAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * العلاقة مع المنشئ (Marketing)
     */
    public function createdByMarketing(): BelongsTo
    {
        return $this->belongsTo(MarketingTeam::class, 'created_by');
    }

    /**
     * العلاقة مع المنشئ (Sales)
     */
    public function createdBySales(): BelongsTo
    {
        return $this->belongsTo(SalesTeam::class, 'created_by');
    }

    /**
     * العلاقة مع التعليقات
     */
    public function taskComments(): HasMany
    {
        return $this->hasMany(TaskComment::class, 'task_id');
    }

    /**
     * العلاقة مع المرفقات
     */
    public function taskAttachments(): HasMany
    {
        return $this->hasMany(TaskAttachment::class, 'task_id');
    }

    /**
     * الحصول على المعين
     */
    public function getAssignedUserAttribute()
    {
        return match($this->assigned_to_type) {
            'admin' => $this->assignedAdmin,
            'marketing' => $this->assignedMarketing,
            'sales' => $this->assignedSales,
            default => null
        };
    }

    /**
     * الحصول على المنشئ
     */
    public function getCreatorAttribute()
    {
        return match($this->created_by_type) {
            'admin' => $this->createdByAdmin,
            'marketing' => $this->createdByMarketing,
            'sales' => $this->createdBySales,
            default => null
        };
    }

    /**
     * الحصول على حالة المهمة بشكل مقروء
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'قيد الانتظار',
            'in_progress' => 'قيد التنفيذ',
            'completed' => 'مكتملة',
            'cancelled' => 'ملغية',
            'on_hold' => 'معلقة',
            default => $this->status
        };
    }

    /**
     * الحصول على أولوية المهمة بشكل مقروء
     */
    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            'low' => 'منخفضة',
            'medium' => 'متوسطة',
            'high' => 'عالية',
            'urgent' => 'عاجلة',
            'critical' => 'حرجة',
            default => $this->priority
        };
    }

    /**
     * الحصول على لون الأولوية
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'low' => '#28a745',
            'medium' => '#ffc107',
            'high' => '#fd7e14',
            'urgent' => '#dc3545',
            'critical' => '#6f42c1',
            default => '#6c757d'
        };
    }

    /**
     * تحديد ما إذا كانت المهمة متأخرة
     */
    public function getIsOverdueAttribute(): bool
    {
        if ($this->status === 'completed' || $this->status === 'cancelled') {
            return false;
        }
        
        if ($this->due_date) {
            return $this->due_date < now();
        }
        
        return false;
    }

    /**
     * تحديد ما إذا كانت المهمة قريبة من الموعد النهائي
     */
    public function getIsDueSoonAttribute(): bool
    {
        if ($this->status === 'completed' || $this->status === 'cancelled') {
            return false;
        }
        
        if ($this->due_date) {
            return $this->due_date > now() && $this->due_date->diffInDays(now()) <= 3;
        }
        
        return false;
    }

    /**
     * حساب نسبة إنجاز المهمة
     */
    public function getProgressPercentageAttribute(): int
    {
        if ($this->status === 'completed') {
            return 100;
        }

        if (!$this->checklist || empty($this->checklist)) {
            return 0;
        }

        $completed = collect($this->checklist)->where('completed', true)->count();
        $total = count($this->checklist);
        
        return $total > 0 ? round(($completed / $total) * 100) : 0;
    }

    /**
     * الحصول على الوقت المنقضي
     */
    public function getElapsedTimeAttribute(): int
    {
        if (!$this->start_date) {
            return 0;
        }

        $endTime = $this->completed_at ?? now();
        return $this->start_date->diffInMinutes($endTime);
    }

    /**
     * إضافة تعليق جديد
     */
    public function addComment(string $comment, int $userId, string $userName, string $userType = 'admin'): void
    {
        $comments = $this->comments ?? [];
        $comments[] = [
            'id' => uniqid(),
            'user_id' => $userId,
            'user_name' => $userName,
            'user_type' => $userType,
            'comment' => $comment,
            'created_at' => now()->toDateTimeString(),
        ];
        
        $this->update(['comments' => $comments]);
    }

    /**
     * إضافة عنصر للقائمة المرجعية
     */
    public function addChecklistItem(string $text): void
    {
        $checklist = $this->checklist ?? [];
        $checklist[] = [
            'id' => uniqid(),
            'text' => $text,
            'completed' => false,
            'created_at' => now()->toDateTimeString(),
        ];
        
        $this->update(['checklist' => $checklist]);
    }

    /**
     * تحديث عنصر في القائمة المرجعية
     */
    public function updateChecklistItem(string $itemId, bool $completed): void
    {
        $checklist = $this->checklist ?? [];
        $checklist = collect($checklist)->map(function ($item) use ($itemId, $completed) {
            if ($item['id'] === $itemId) {
                $item['completed'] = $completed;
            }
            return $item;
        })->toArray();
        
        $this->update(['checklist' => $checklist]);
    }

    /**
     * إضافة تتبع وقت
     */
    public function addTimeLog(int $minutes, string $description = '', int $userId = null, string $userName = ''): void
    {
        $timeLogs = $this->time_logs ?? [];
        $timeLogs[] = [
            'id' => uniqid(),
            'minutes' => $minutes,
            'description' => $description,
            'user_id' => $userId,
            'user_name' => $userName,
            'logged_at' => now()->toDateTimeString(),
        ];
        
        $this->update([
            'time_logs' => $timeLogs,
            'actual_hours' => ($this->actual_hours ?? 0) + ($minutes / 60)
        ]);
    }

    /**
     * نقل المهمة إلى عمود آخر
     */
    public function moveToColumn(TaskColumn $column, int $newPosition = null): void
    {
        $this->update([
            'column_id' => $column->id,
            'sort_order' => $newPosition ?? ($column->active_tasks_count + 1)
        ]);
    }

    /**
     * أرشفة المهمة
     */
    public function archive(): void
    {
        $this->update(['is_archived' => true]);
    }

    /**
     * إلغاء أرشفة المهمة
     */
    public function unarchive(): void
    {
        $this->update(['is_archived' => false]);
    }

    /**
     * إكمال المهمة
     */
    public function complete(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress_percentage' => 100
        ]);
    }

    /**
     * إلغاء إكمال المهمة
     */
    public function uncomplete(): void
    {
        $this->update([
            'status' => 'in_progress',
            'completed_at' => null,
            'progress_percentage' => $this->getProgressPercentageAttribute()
        ]);
    }
}
