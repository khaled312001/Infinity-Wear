<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'due_date',
        'assigned_to',
        'assigned_to_type',
        'created_by',
        'importer_id',
        'department',
        'board_id',
        'column_status',
        'position',
        'labels',
        'attachments',
        'checklist',
        'estimated_hours',
        'actual_hours',
        'started_at',
        'completed_at',
        'time_logs',
        'comments',
        'color',
        'is_archived'
    ];

    protected $casts = [
        'due_date' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'labels' => 'array',
        'attachments' => 'array',
        'checklist' => 'array',
        'time_logs' => 'array',
        'comments' => 'array',
        'is_archived' => 'boolean',
    ];

    /**
     * العلاقة مع المسؤول المعين
     */
    public function assignedAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }

    /**
     * العلاقة مع المسؤول المنشئ
     */
    public function createdByAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * العلاقة مع المستورد
     */
    public function importer(): BelongsTo
    {
        return $this->belongsTo(Importer::class);
    }

    /**
     * العلاقة مع لوحة المهام
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(TaskBoard::class, 'board_id');
    }

    /**
     * العلاقة مع المستخدم المعين
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
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
            default => $this->priority
        };
    }

    /**
     * الحصول على القسم بشكل مقروء
     */
    public function getDepartmentLabelAttribute(): string
    {
        return match($this->department) {
            'admin' => 'الإدارة',
            'marketing' => 'التسويق',
            'sales' => 'المبيعات',
            default => $this->department
        };
    }

    /**
     * تحديد ما إذا كانت المهمة متأخرة
     */
    public function getIsOverdueAttribute(): bool
    {
        if ($this->column_status === 'done' || $this->status === 'cancelled') {
            return false;
        }
        
        if ($this->due_date) {
            return $this->due_date->isPast();
        }
        
        return false;
    }

    /**
     * الحصول على حالة العمود بشكل مقروء
     */
    public function getColumnStatusLabelAttribute(): string
    {
        $columns = TaskBoard::getColumns();
        return $columns[$this->column_status]['name'] ?? $this->column_status;
    }

    /**
     * الحصول على لون العمود
     */
    public function getColumnColorAttribute(): string
    {
        $columns = TaskBoard::getColumns();
        return $columns[$this->column_status]['color'] ?? '#6c757d';
    }

    /**
     * الحصول على أيقونة العمود
     */
    public function getColumnIconAttribute(): string
    {
        $columns = TaskBoard::getColumns();
        return $columns[$this->column_status]['icon'] ?? 'fas fa-circle';
    }

    /**
     * حساب نسبة إنجاز المهمة
     */
    public function getProgressPercentageAttribute(): int
    {
        if (!$this->checklist || empty($this->checklist)) {
            return $this->column_status === 'done' ? 100 : 0;
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
        if (!$this->started_at) {
            return 0;
        }

        $endTime = $this->completed_at ?? now();
        return $this->started_at->diffInMinutes($endTime);
    }

    /**
     * إضافة تعليق جديد
     */
    public function addComment(string $comment, int $userId, string $userName): void
    {
        $comments = $this->comments ?? [];
        $comments[] = [
            'id' => uniqid(),
            'user_id' => $userId,
            'user_name' => $userName,
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
    public function addTimeLog(int $minutes, string $description = ''): void
    {
        $timeLogs = $this->time_logs ?? [];
        $timeLogs[] = [
            'id' => uniqid(),
            'minutes' => $minutes,
            'description' => $description,
            'logged_at' => now()->toDateTimeString(),
        ];
        
        $this->update([
            'time_logs' => $timeLogs,
            'actual_hours' => ($this->actual_hours ?? 0) + ($minutes / 60)
        ]);
    }
}