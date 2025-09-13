<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'subtitle',
        'description',
        'section_type',
        'layout_type',
        'background_color',
        'background_image',
        'text_color',
        'custom_css',
        'custom_js',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * علاقة المحتويات
     */
    public function contents()
    {
        return $this->hasMany(SectionContent::class)->orderBy('sort_order');
    }

    /**
     * Scope للحصول على الأقسام النشطة فقط
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope للحصول على الأقسام مرتبة
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * الحصول على رابط صورة الخلفية
     */
    public function getBackgroundImageUrlAttribute()
    {
        return $this->background_image ? asset('storage/' . $this->background_image) : null;
    }

    /**
     * الحصول على نوع القسم المترجم
     */
    public function getSectionTypeTranslatedAttribute()
    {
        $types = [
            'hero' => 'قسم البطل',
            'services' => 'الخدمات',
            'features' => 'المميزات',
            'about' => 'نبذة عنا',
            'portfolio' => 'معرض الأعمال',
            'testimonials' => 'آراء العملاء',
            'contact' => 'اتصل بنا',
            'custom' => 'مخصص',
        ];

        return $types[$this->section_type] ?? 'غير محدد';
    }

    /**
     * الحصول على نوع التخطيط المترجم
     */
    public function getLayoutTypeTranslatedAttribute()
    {
        $layouts = [
            'full_width' => 'عرض كامل',
            'container' => 'حاوي',
            'grid_2' => 'شبكة عمودين',
            'grid_3' => 'شبكة ثلاثة أعمدة',
            'grid_4' => 'شبكة أربعة أعمدة',
            'carousel' => 'عرض دائري',
        ];

        return $layouts[$this->layout_type] ?? 'غير محدد';
    }
}