<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'button_text',
        'button_link',
        'text_color',
        'overlay_opacity',
        'animation_type',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'overlay_opacity' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    /**
     * Scope للحصول على الشرائح النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope للحصول على الشرائح مرتبة
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * الحصول على رابط الصورة
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-slider.jpg');
    }

    /**
     * الحصول على نوع الحركة المترجم
     */
    public function getAnimationTypeTranslatedAttribute()
    {
        $animations = [
            'fade' => 'تلاشي',
            'slide' => 'انزلاق',
            'zoom' => 'تكبير',
        ];

        return $animations[$this->animation_type] ?? 'تلاشي';
    }
}