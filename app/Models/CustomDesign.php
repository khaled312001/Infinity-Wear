<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomDesign extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'design_data',
        'preview_image',
        'status',
        'price'
    ];

    protected $casts = [
        'design_data' => 'array',
        'price' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'draft' => 'مسودة',
            'pending' => 'في الانتظار',
            'approved' => 'موافق عليه',
            'rejected' => 'مرفوض',
            default => $this->status
        };
    }
}
