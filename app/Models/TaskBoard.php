<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'is_active',
        'sort_order',
        'color',
        'icon',
        'created_by',
        'team_type',
        'team_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * العلاقة مع الأعمدة
     */
    public function columns(): HasMany
    {
        return $this->hasMany(TaskColumn::class, 'board_id')->orderBy('sort_order');
    }

    /**
     * العلاقة مع المهام
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'board_id');
    }

    /**
     * العلاقة مع المنشئ
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * الحصول على نوع اللوحة بشكل مقروء
     */
    public function getBoardTypeLabelAttribute(): string
    {
        return match($this->type ?? 'general') {
            'marketing' => 'التسويق',
            'sales' => 'المبيعات',
            'general' => 'عام',
            'project' => 'مشروع',
            'department' => 'قسم',
            default => 'عام'
        };
    }

    /**
     * الحصول على إحصائيات اللوحة
     */
    public function getStatsAttribute(): array
    {
        $tasks = $this->tasks;
        
        return [
            'total_tasks' => $tasks->count(),
            'completed_tasks' => $tasks->where('status', 'completed')->count(),
            'in_progress_tasks' => $tasks->where('status', 'in_progress')->count(),
            'pending_tasks' => $tasks->where('status', 'pending')->count(),
            'overdue_tasks' => $tasks->where('due_date', '<', now())
                ->where('status', '!=', 'completed')
                ->count(),
        ];
    }

    /**
     * الحصول على الأعمدة الافتراضية
     */
    public static function getDefaultColumns(): array
    {
        return [
            [
                'name' => 'قائمة المهام',
                'description' => 'المهام الجديدة والمعلقة',
                'color' => '#6c757d',
                'icon' => 'fas fa-list',
                'sort_order' => 1
            ],
            [
                'name' => 'قيد التنفيذ',
                'description' => 'المهام قيد العمل',
                'color' => '#007bff',
                'icon' => 'fas fa-play',
                'sort_order' => 2
            ],
            [
                'name' => 'قيد المراجعة',
                'description' => 'المهام جاهزة للمراجعة',
                'color' => '#ffc107',
                'icon' => 'fas fa-eye',
                'sort_order' => 3
            ],
            [
                'name' => 'مكتملة',
                'description' => 'المهام المنجزة',
                'color' => '#28a745',
                'icon' => 'fas fa-check',
                'sort_order' => 4
            ]
        ];
    }

    /**
     * إنشاء لوحة جديدة مع الأعمدة الافتراضية
     */
    public static function createWithDefaultColumns(array $data): self
    {
        $board = self::create($data);
        
        foreach (self::getDefaultColumns() as $columnData) {
            $board->columns()->create($columnData);
        }
        
        return $board;
    }

    /**
     * تحديد ما إذا كانت اللوحة مخصصة لفريق معين
     */
    public function isTeamBoard(): bool
    {
        return !empty($this->team_type) && !empty($this->team_id);
    }

    /**
     * الحصول على لون اللوحة
     */
    public function getBoardColorAttribute(): string
    {
        return $this->color ?? '#007bff';
    }

    /**
     * الحصول على أيقونة اللوحة
     */
    public function getBoardIconAttribute(): string
    {
        return $this->icon ?? 'fas fa-tasks';
    }
}
