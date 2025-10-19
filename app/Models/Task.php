<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends TaskCard
{
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
}
