<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'image',
        'features',
        'order',
        'is_active',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Get the service image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // إذا كان المسار يحتوي على 'sections/' فهو في public/images/sections/
            if (strpos($this->image, 'sections/') === 0) {
                return asset('images/' . $this->image);
            }
            // إذا كان المسار يحتوي على 'images/' فهو في public/images/
            if (strpos($this->image, 'images/') === 0) {
                return asset($this->image);
            }
            // إذا كان المسار لا يحتوي على 'images/' أضف 'images/' إليه
            return asset('images/' . $this->image);
        }
        return asset('images/default-service.jpg');
    }

    /**
     * Scope for active services
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered services
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
