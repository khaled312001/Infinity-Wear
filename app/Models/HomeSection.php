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
        'background_color',
        'text_color',
        'section_type',
        'settings',
        'order',
        'is_active',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function contents()
    {
        return $this->hasMany(SectionContent::class)->where('is_active', true)->orderBy('order');
    }

    public function allContents()
    {
        return $this->hasMany(SectionContent::class)->orderBy('order');
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