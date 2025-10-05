<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ContentManagement extends Model
{
    protected $fillable = [
        'page_name',
        'section_name',
        'content_type',
        'title_ar',
        'title_en',
        'content_ar',
        'content_en',
        'description_ar',
        'description_en',
        'image_path',
        'gallery_images',
        'video_url',
        'button_text_ar',
        'button_text_en',
        'button_url',
        'sort_order',
        'is_active',
        'is_featured',
        'meta_data'
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'meta_data' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Scope للبحث في صفحة معينة
    public function scopeForPage(Builder $query, string $pageName): Builder
    {
        return $query->where('page_name', $pageName);
    }

    // Scope للبحث في قسم معين
    public function scopeForSection(Builder $query, string $sectionName): Builder
    {
        return $query->where('section_name', $sectionName);
    }

    // Scope للمحتوى النشط فقط
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    // Scope للمحتوى المميز
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    // Scope مرتب حسب الترتيب
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    // دالة للحصول على العنوان حسب اللغة
    public function getTitleAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->title_ar : $this->title_en;
    }

    // دالة للحصول على المحتوى حسب اللغة
    public function getContentAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->content_ar : $this->content_en;
    }

    // دالة للحصول على الوصف حسب اللغة
    public function getDescriptionAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->description_ar : $this->description_en;
    }

    // دالة للحصول على نص الزر حسب اللغة
    public function getButtonTextAttribute()
    {
        return app()->getLocale() === 'ar' ? $this->button_text_ar : $this->button_text_en;
    }
}
