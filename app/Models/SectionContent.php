<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_section_id',
        'title',
        'subtitle',
        'description',
        'content_type',
        'image',
        'video_url',
        'icon_class',
        'button_text',
        'button_link',
        'button_style',
        'custom_data',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'custom_data' => 'array',
    ];

    /**
     * علاقة القسم الرئيسي
     */
    public function homeSection()
    {
        return $this->belongsTo(HomeSection::class);
    }

    /**
     * Scope للحصول على المحتويات النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope للحصول على المحتويات مرتبة
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
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * الحصول على نوع المحتوى المترجم
     */
    public function getContentTypeTranslatedAttribute()
    {
        $types = [
            'text' => 'نص',
            'image' => 'صورة',
            'video' => 'فيديو',
            'icon' => 'أيقونة',
            'button' => 'زر',
            'card' => 'بطاقة',
            'testimonial' => 'شهادة',
        ];

        return $types[$this->content_type] ?? 'غير محدد';
    }

    /**
     * الحصول على نمط الزر المترجم
     */
    public function getButtonStyleTranslatedAttribute()
    {
        $styles = [
            'primary' => 'أساسي',
            'secondary' => 'ثانوي',
            'outline' => 'مفرغ',
            'link' => 'رابط',
        ];

        return $styles[$this->button_style] ?? 'أساسي';
    }

    /**
     * الحصول على كلاس الأيقونة الكامل
     */
    public function getFullIconClassAttribute()
    {
        return $this->icon_class ? 'fas ' . $this->icon_class : 'fas fa-star';
    }
}