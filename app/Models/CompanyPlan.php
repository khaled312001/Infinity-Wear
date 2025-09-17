<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'status',
        'start_date',
        'end_date',
        'objectives',
        'strengths',
        'weaknesses',
        'opportunities',
        'threats',
        'strategies',
        'action_items',
        'budget',
        'actual_cost',
        'progress_percentage',
        'notes',
        'created_by',
        'assigned_to'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'objectives' => 'array',
        'strengths' => 'array',
        'weaknesses' => 'array',
        'opportunities' => 'array',
        'threats' => 'array',
        'strategies' => 'array',
        'action_items' => 'array',
        'budget' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'progress_percentage' => 'integer',
    ];

    /**
     * العلاقة مع منشئ الخطة
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * العلاقة مع المسؤول عن الخطة
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }

    /**
     * الحصول على نوع الخطة بشكل مقروء
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'quarterly' => 'ربع سنوية',
            'semi_annual' => 'نصف سنوية',
            'annual' => 'سنوية',
            default => $this->type
        };
    }

    /**
     * الحصول على حالة الخطة بشكل مقروء
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'مسودة',
            'active' => 'نشطة',
            'completed' => 'مكتملة',
            'cancelled' => 'ملغية',
            default => $this->status
        };
    }

    /**
     * الحصول على لون الحالة
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'draft' => 'secondary',
            'active' => 'success',
            'completed' => 'primary',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * تحديد ما إذا كانت الخطة متأخرة
     */
    public function getIsOverdueAttribute(): bool
    {
        if ($this->status === 'completed' || $this->status === 'cancelled') {
            return false;
        }
        
        return $this->end_date->isPast();
    }

    /**
     * الحصول على عدد الأيام المتبقية
     */
    public function getDaysRemainingAttribute(): int
    {
        if ($this->status === 'completed' || $this->status === 'cancelled') {
            return 0;
        }
        
        return max(0, now()->diffInDays($this->end_date, false));
    }

    /**
     * الحصول على نسبة التكلفة الفعلية من الميزانية
     */
    public function getCostPercentageAttribute(): float
    {
        if (!$this->budget || $this->budget == 0) {
            return 0;
        }
        
        return round(($this->actual_cost / $this->budget) * 100, 2);
    }
}
