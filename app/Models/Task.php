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
        'created_by',
        'importer_id',
        'department'
    ];

    protected $casts = [
        'due_date' => 'date',
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
        if ($this->status === 'completed' || $this->status === 'cancelled') {
            return false;
        }
        
        if ($this->due_date) {
            return $this->due_date->isPast();
        }
        
        return false;
    }
}