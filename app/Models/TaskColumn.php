<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskColumn extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'board_id',
        'color',
        'icon',
        'sort_order',
        'is_active',
        'max_tasks',
        'wip_limit'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'max_tasks' => 'integer',
        'wip_limit' => 'integer',
    ];

    /**
     * العلاقة مع اللوحة
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(TaskBoard::class, 'board_id');
    }

    /**
     * العلاقة مع المهام
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'column_id')->orderBy('sort_order');
    }

    /**
     * المهام النشطة فقط
     */
    public function activeTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'column_id')
            ->where('is_archived', false)
            ->orderBy('sort_order');
    }

    /**
     * الحصول على عدد المهام في العمود
     */
    public function getTasksCountAttribute(): int
    {
        return $this->tasks()->count();
    }

    /**
     * الحصول على عدد المهام النشطة
     */
    public function getActiveTasksCountAttribute(): int
    {
        return $this->activeTasks()->count();
    }

    /**
     * تحديد ما إذا كان العمود ممتلئ
     */
    public function getIsFullAttribute(): bool
    {
        if (!$this->max_tasks) {
            return false;
        }
        
        return $this->active_tasks_count >= $this->max_tasks;
    }

    /**
     * تحديد ما إذا كان العمود وصل للحد الأقصى للعمل
     */
    public function getIsWipLimitReachedAttribute(): bool
    {
        if (!$this->wip_limit) {
            return false;
        }
        
        return $this->active_tasks_count >= $this->wip_limit;
    }

    /**
     * الحصول على لون العمود
     */
    public function getColumnColorAttribute(): string
    {
        return $this->color ?? '#6c757d';
    }

    /**
     * الحصول على أيقونة العمود
     */
    public function getColumnIconAttribute(): string
    {
        return $this->icon ?? 'fas fa-circle';
    }

    /**
     * إعادة ترتيب المهام في العمود
     */
    public function reorderTasks(array $taskIds): void
    {
        foreach ($taskIds as $index => $taskId) {
            $this->tasks()->where('id', $taskId)->update(['sort_order' => $index + 1]);
        }
    }

    /**
     * نقل مهمة إلى عمود آخر
     */
    public function moveTaskTo(TaskCard $task, TaskColumn $targetColumn, int $newPosition = null): void
    {
        $task->update([
            'column_id' => $targetColumn->id,
            'sort_order' => $newPosition ?? ($targetColumn->active_tasks_count + 1)
        ]);
    }

    /**
     * الحصول على إحصائيات العمود
     */
    public function getStatsAttribute(): array
    {
        $tasks = $this->tasks;
        
        return [
            'total_tasks' => $tasks->count(),
            'active_tasks' => $this->active_tasks_count,
            'completed_tasks' => $tasks->where('status', 'completed')->count(),
            'overdue_tasks' => $tasks->where('due_date', '<', now())
                ->where('status', '!=', 'completed')
                ->count(),
            'is_full' => $this->is_full,
            'wip_limit_reached' => $this->is_wip_limit_reached,
        ];
    }
}
