<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_section_id',
        'type',
        'title',
        'description',
        'image',
        'icon',
        'icon_color',
        'button_text',
        'button_url',
        'extra_data',
        'order',
        'is_active',
    ];

    protected $casts = [
        'extra_data' => 'array',
        'is_active' => 'boolean',
    ];

    public function homeSection()
    {
        return $this->belongsTo(HomeSection::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}