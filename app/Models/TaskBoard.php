<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * العلاقة مع المهام
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'board_id')->orderBy('position');
    }

    /**
     * المهام في العمود المحدد
     */
    public function tasksInColumn(string $column): HasMany
    {
        return $this->hasMany(Task::class, 'board_id')
            ->where('column_status', $column)
            ->orderBy('position');
    }

    /**
     * الحصول على نوع اللوحة بشكل مقروء
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'marketing' => 'التسويق',
            'sales' => 'المبيعات',
            'general' => 'عام',
            default => $this->type
        };
    }

    /**
     * الحصول على إحصائيات اللوحة
     */
    public function getStatsAttribute(): array
    {
        $tasks = $this->tasks;
        
        return [
            'total' => $tasks->count(),
            'todo' => $tasks->where('column_status', 'todo')->count(),
            'in_progress' => $tasks->where('column_status', 'in_progress')->count(),
            'review' => $tasks->where('column_status', 'review')->count(),
            'done' => $tasks->where('column_status', 'done')->count(),
            'overdue' => $tasks->where('due_date', '<', now())
                ->where('column_status', '!=', 'done')
                ->count(),
        ];
    }

    /**
     * الحصول على الأعمدة المتاحة
     */
    public static function getColumns(): array
    {
        return [
            'todo' => [
                'name' => 'قائمة المهام',
                'color' => '#6c757d',
                'icon' => 'fas fa-list'
            ],
            'in_progress' => [
                'name' => 'قيد التنفيذ',
                'color' => '#007bff',
                'icon' => 'fas fa-play'
            ],
            'review' => [
                'name' => 'قيد المراجعة',
                'color' => '#ffc107',
                'icon' => 'fas fa-eye'
            ],
            'done' => [
                'name' => 'مكتملة',
                'color' => '#28a745',
                'icon' => 'fas fa-check'
            ]
        ];
    }
}