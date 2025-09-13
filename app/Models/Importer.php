<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Importer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'company_name',
        'business_type',
        'business_type_other',
        'address',
        'city',
        'country',
        'notes',
        'status'
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع طلبات المستورد
     */
    public function orders(): HasMany
    {
        return $this->hasMany(ImporterOrder::class);
    }

    /**
     * العلاقة مع المهام
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * الحصول على حالة المستورد بشكل مقروء
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'new' => 'جديد',
            'contacted' => 'تم التواصل',
            'qualified' => 'مؤهل',
            'proposal' => 'تم تقديم عرض',
            'negotiation' => 'قيد التفاوض',
            'closed_won' => 'تم إغلاق الصفقة بنجاح',
            'closed_lost' => 'تم إغلاق الصفقة بدون نجاح',
            default => $this->status
        };
    }

    /**
     * الحصول على نوع النشاط التجاري بشكل مقروء
     */
    public function getBusinessTypeLabelAttribute(): string
    {
        return match($this->business_type) {
            'academy' => 'أكاديمية',
            'school' => 'مدرسة',
            'store' => 'متجر',
            'hospital' => 'مستشفى',
            'other' => $this->business_type_other ?? 'أخرى',
            default => $this->business_type
        };
    }
}