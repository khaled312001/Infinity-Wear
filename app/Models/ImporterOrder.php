<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImporterOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'importer_id',
        'order_number',
        'status',
        'requirements',
        'quantity',
        'design_details',
        'estimated_cost',
        'final_cost',
        'delivery_date',
        'notes',
        'assigned_to'
    ];

    protected $casts = [
        'design_details' => 'array',
        'delivery_date' => 'date',
        'estimated_cost' => 'decimal:2',
        'final_cost' => 'decimal:2',
    ];

    /**
     * العلاقة مع المستورد
     */
    public function importer(): BelongsTo
    {
        return $this->belongsTo(Importer::class);
    }

    /**
     * العلاقة مع المسؤول المعين
     */
    public function assignedAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }

    /**
     * الحصول على حالة الطلب بشكل مقروء
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'new' => 'جديد',
            'processing' => 'قيد المعالجة',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي',
            default => $this->status
        };
    }

    /**
     * توليد رقم طلب فريد
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'IMP-';
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
}