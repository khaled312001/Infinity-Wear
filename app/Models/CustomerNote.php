<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'added_by',
        'note_type',
        'title',
        'content',
        'priority',
        'status',
        'tags',
        'follow_up_date'
    ];

    protected $casts = [
        'tags' => 'array',
        'follow_up_date' => 'datetime',
    ];

    /**
     * العلاقة مع العميل
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * العلاقة مع الإداري الذي أضاف الملاحظة
     */
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'added_by');
    }

    /**
     * الحصول على نوع الملاحظة بشكل مقروء
     */
    public function getNoteTypeLabelAttribute(): string
    {
        return match($this->note_type) {
            'marketing' => 'تسويق',
            'sales' => 'مبيعات',
            'general' => 'عام',
            default => $this->note_type
        };
    }

    /**
     * الحصول على أولوية الملاحظة بشكل مقروء
     */
    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            'low' => 'منخفضة',
            'medium' => 'متوسطة',
            'high' => 'عالية',
            default => $this->priority
        };
    }

    /**
     * الحصول على حالة الملاحظة بشكل مقروء
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'نشطة',
            'archived' => 'مؤرشفة',
            'deleted' => 'محذوفة',
            default => $this->status
        };
    }

    /**
     * الحصول على لون الأولوية
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * الحصول على لون نوع الملاحظة
     */
    public function getNoteTypeColorAttribute(): string
    {
        return match($this->note_type) {
            'marketing' => 'info',
            'sales' => 'primary',
            'general' => 'secondary',
            default => 'secondary'
        };
    }

    /**
     * Scope للحصول على الملاحظات النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope للحصول على ملاحظات نوع معين
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('note_type', $type);
    }

    /**
     * Scope للحصول على ملاحظات عميل معين
     */
    public function scopeForCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }
}