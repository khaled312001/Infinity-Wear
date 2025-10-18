<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketingReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'representative_name',
        'company_name',
        'company_images',
        'company_address',
        'company_activity',
        'responsible_name',
        'responsible_phone',
        'responsible_position',
        'visit_type',
        'agreement_status',
        'customer_concerns',
        'target_quantity',
        'annual_consumption',
        'recommendations',
        'next_steps',
        'created_by',
        'status',
        'notes'
    ];

    protected $casts = [
        'company_images' => 'array',
        'customer_concerns' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // العلاقات
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeByRepresentative($query, $representativeName)
    {
        return $query->where('representative_name', $representativeName);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByVisitType($query, $visitType)
    {
        return $query->where('visit_type', $visitType);
    }

    public function scopeByAgreementStatus($query, $agreementStatus)
    {
        return $query->where('agreement_status', $agreementStatus);
    }

    // Accessors
    public function getCompanyImagesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setCompanyImagesAttribute($value)
    {
        $this->attributes['company_images'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getCustomerConcernsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function setCustomerConcernsAttribute($value)
    {
        $this->attributes['customer_concerns'] = is_array($value) ? json_encode($value) : $value;
    }

    // Helper methods
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'under_review' => 'info',
            default => 'secondary'
        };
    }

    public function getStatusText()
    {
        return match($this->status) {
            'pending' => 'قيد المراجعة',
            'approved' => 'موافق عليه',
            'rejected' => 'مرفوض',
            'under_review' => 'قيد المراجعة',
            default => 'غير محدد'
        };
    }

    public function getAgreementStatusText()
    {
        return match($this->agreement_status) {
            'agreed' => 'تم الاتفاق',
            'rejected' => 'تم الرفض',
            'needs_time' => 'بحاجة إلى وقت',
            default => 'غير محدد'
        };
    }

    public function getVisitTypeText()
    {
        return match($this->visit_type) {
            'office_visit' => 'زيارة مقر',
            'phone_call' => 'اتصال',
            'whatsapp' => 'رسائل Whatsapp',
            default => 'غير محدد'
        };
    }

    public function getCompanyActivityText()
    {
        return match($this->company_activity) {
            'sports_academy' => 'أكاديمية رياضية',
            'school' => 'مدرسة',
            'institution_company' => 'مؤسسة / شركة',
            'wholesale_store' => 'محل جملة',
            'retail_store' => 'محل تجزئة',
            'other' => 'أخرى',
            default => 'غير محدد'
        };
    }
}
