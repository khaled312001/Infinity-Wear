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
        'content',
        'content_type',
        'image',
        'video_url',
        'icon_class',
        'button_text',
        'button_link',
        'button_style',
        'link_text',
        'link_url',
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
     * الحصول على نوع المحتوى (محاولة استنتاج من البيانات المتاحة)
     */
    public function getContentTypeAttribute()
    {
        if ($this->image && $this->image != 'sections/') {
            return 'image';
        } elseif (!empty($this->link_text) && !empty($this->link_url)) {
            return 'button';
        } elseif (preg_match('/\d+/', $this->title) && preg_match('/عميل|مشروع|سنوات|ساعة/', $this->content)) {
            return 'icon';
        } elseif (preg_match('/أحمد|فاطمة|خالد/', $this->title)) {
            return 'testimonial';
        } elseif ($this->title == 'مرحباً بكم في إنفينيتي وير' && !empty($this->link_text)) {
            return 'button';
        } else {
            return 'text';
        }
    }

    /**
     * الحصول على الوصف (استخدام محتوى الحقل content)
     */
    public function getDescriptionAttribute()
    {
        return $this->content;
    }

    /**
     * الحصول على النص الفرعي (استخدام link_text كبديل)
     */
    public function getSubtitleAttribute()
    {
        return $this->link_text;
    }

    /**
     * الحصول على نص الزر (استخدام link_text)
     */
    public function getButtonTextAttribute()
    {
        return $this->link_text;
    }

    /**
     * الحصول على رابط الزر (استخدام link_url)
     */
    public function getButtonLinkAttribute()
    {
        return $this->link_url;
    }

    /**
     * الحصول على نمط الزر
     */
    public function getButtonStyleAttribute()
    {
        return 'primary';
    }

    /**
     * الحصول على أيقونة المحتوى (استخدام link_text كأيقونة)
     */
    public function getIconClassAttribute()
    {
        return $this->link_text;
    }

    /**
     * الحصول على كلاس الأيقونة الكامل
     */
    public function getFullIconClassAttribute()
    {
        return $this->icon_class ? 'fas ' . $this->icon_class : 'fas fa-star';
    }

    /**
     * الحصول على رابط الفيديو (غير متوفر حالياً)
     */
    public function getVideoUrlAttribute()
    {
        return null;
    }

    /**
     * الحصول على البيانات المخصصة (غير متوفر حالياً)
     */
    public function getCustomDataAttribute()
    {
        return [];
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
}