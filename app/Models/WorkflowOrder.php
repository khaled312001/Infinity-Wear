<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkflowOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'importer_id',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'requirements',
        'quantity',
        'design_details',
        'estimated_cost',
        'final_cost',
        'marketing_status',
        'sales_status',
        'design_status',
        'first_sample_status',
        'work_approval_status',
        'manufacturing_status',
        'shipping_status',
        'receipt_delivery_status',
        'collection_status',
        'after_sales_status',
        'marketing_user_id',
        'sales_user_id',
        'design_user_id',
        'first_sample_user_id',
        'work_approval_user_id',
        'manufacturing_user_id',
        'shipping_user_id',
        'receipt_delivery_user_id',
        'collection_user_id',
        'after_sales_user_id',
        'marketing_started_at',
        'marketing_completed_at',
        'sales_started_at',
        'sales_completed_at',
        'design_started_at',
        'design_completed_at',
        'first_sample_started_at',
        'first_sample_completed_at',
        'work_approval_started_at',
        'work_approval_completed_at',
        'manufacturing_started_at',
        'manufacturing_completed_at',
        'shipping_started_at',
        'shipping_completed_at',
        'receipt_delivery_started_at',
        'receipt_delivery_completed_at',
        'collection_started_at',
        'collection_completed_at',
        'after_sales_started_at',
        'after_sales_completed_at',
        'overall_status',
        'notes',
        'expected_delivery_date',
        'actual_delivery_date',
        'tracking_number',
        'rejection_reason',
    ];

    protected $casts = [
        'design_details' => 'array',
        'estimated_cost' => 'decimal:2',
        'final_cost' => 'decimal:2',
        'expected_delivery_date' => 'date',
        'actual_delivery_date' => 'date',
        'marketing_started_at' => 'datetime',
        'marketing_completed_at' => 'datetime',
        'sales_started_at' => 'datetime',
        'sales_completed_at' => 'datetime',
        'design_started_at' => 'datetime',
        'design_completed_at' => 'datetime',
        'first_sample_started_at' => 'datetime',
        'first_sample_completed_at' => 'datetime',
        'work_approval_started_at' => 'datetime',
        'work_approval_completed_at' => 'datetime',
        'manufacturing_started_at' => 'datetime',
        'manufacturing_completed_at' => 'datetime',
        'shipping_started_at' => 'datetime',
        'shipping_completed_at' => 'datetime',
        'receipt_delivery_started_at' => 'datetime',
        'receipt_delivery_completed_at' => 'datetime',
        'collection_started_at' => 'datetime',
        'collection_completed_at' => 'datetime',
        'after_sales_started_at' => 'datetime',
        'after_sales_completed_at' => 'datetime',
    ];

    /**
     * العلاقة مع المستورد
     */
    public function importer(): BelongsTo
    {
        return $this->belongsTo(Importer::class);
    }

    /**
     * العلاقة مع العميل
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * العلاقة مع مراحل الطلب
     */
    public function stages(): HasMany
    {
        return $this->hasMany(WorkflowOrderStage::class);
    }

    /**
     * العلاقات مع المستخدمين المعينين لكل مرحلة
     */
    public function marketingUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'marketing_user_id');
    }

    public function salesUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sales_user_id');
    }

    public function designUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'design_user_id');
    }

    public function firstSampleUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'first_sample_user_id');
    }

    public function workApprovalUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'work_approval_user_id');
    }

    public function manufacturingUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manufacturing_user_id');
    }

    public function shippingUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'shipping_user_id');
    }

    public function receiptDeliveryUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receipt_delivery_user_id');
    }

    public function collectionUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'collection_user_id');
    }

    public function afterSalesUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'after_sales_user_id');
    }

    /**
     * الحصول على حالة الطلب بشكل مقروء
     */
    public function getOverallStatusLabelAttribute(): string
    {
        return match($this->overall_status) {
            'new' => 'جديد',
            'in_progress' => 'قيد التنفيذ',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            default => $this->overall_status
        };
    }

    /**
     * الحصول على المرحلة الحالية
     */
    public function getCurrentStageAttribute(): string
    {
        $stages = [
            'marketing' => 'التسويق',
            'sales' => 'المبيعات',
            'design' => 'التصميم',
            'first_sample' => 'العينة الأولى',
            'work_approval' => 'اعتماد الشغل',
            'manufacturing' => 'التصنيع',
            'shipping' => 'الشحن',
            'receipt_delivery' => 'استلام وتسليم',
            'collection' => 'التحصيل',
            'after_sales' => 'خدمة ما بعد البيع',
        ];

        foreach ($stages as $stage => $label) {
            $statusField = $stage . '_status';
            if ($this->$statusField === 'in_progress' || ($this->$statusField === 'pending' && $this->getPreviousStageStatus($stage) === 'completed')) {
                return $label;
            }
        }

        return 'مكتمل';
    }

    /**
     * الحصول على حالة المرحلة السابقة
     */
    private function getPreviousStageStatus(string $currentStage): string
    {
        $stageOrder = [
            'marketing',
            'sales',
            'design',
            'first_sample',
            'work_approval',
            'manufacturing',
            'shipping',
            'receipt_delivery',
            'collection',
            'after_sales',
        ];

        $currentIndex = array_search($currentStage, $stageOrder);
        if ($currentIndex > 0) {
            $previousStage = $stageOrder[$currentIndex - 1];
            $statusField = $previousStage . '_status';
            return $this->$statusField ?? 'pending';
        }

        return 'completed';
    }

    /**
     * توليد رقم طلب فريد
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'WF-';
        $date = now()->format('Ymd');
        $lastOrder = self::latest()->first();
        
        if ($lastOrder) {
            $lastNumber = intval(substr($lastOrder->order_number, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $date . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * تحديث حالة المرحلة
     */
    public function updateStageStatus(string $stage, string $status, ?int $userId = null): void
    {
        $statusField = $stage . '_status';
        $startedAtField = $stage . '_started_at';
        $completedAtField = $stage . '_completed_at';
        $userIdField = $stage . '_user_id';

        $this->$statusField = $status;

        if ($status === 'in_progress' && !$this->$startedAtField) {
            $this->$startedAtField = now();
        }

        if ($status === 'completed' && !$this->$completedAtField) {
            $this->$completedAtField = now();
        }

        if ($userId) {
            $this->$userIdField = $userId;
        }

        $this->updateOverallStatus();
        $this->save();
    }

    /**
     * تحديث الحالة العامة للطلب
     */
    private function updateOverallStatus(): void
    {
        $allStages = ['marketing', 'sales', 'design', 'first_sample', 'work_approval', 'manufacturing', 'shipping', 'receipt_delivery', 'collection', 'after_sales'];
        
        $completedCount = 0;
        $inProgressCount = 0;
        
        foreach ($allStages as $stage) {
            $statusField = $stage . '_status';
            if ($this->$statusField === 'completed') {
                $completedCount++;
            } elseif ($this->$statusField === 'in_progress') {
                $inProgressCount++;
            }
        }

        if ($completedCount === count($allStages)) {
            $this->overall_status = 'completed';
        } elseif ($inProgressCount > 0 || $completedCount > 0) {
            $this->overall_status = 'in_progress';
        } else {
            $this->overall_status = 'new';
        }
    }
}
