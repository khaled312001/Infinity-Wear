<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'gallery',
        'client_name',
        'completion_date',
        'category',
        'is_featured',
        'sort_order'
    ];

    protected $casts = [
        'gallery' => 'array',
        'completion_date' => 'date',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the portfolio item image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // إذا كان المسار يحتوي على 'portfolio/' فهو في public/images/portfolio/
            if (strpos($this->image, 'portfolio/') === 0) {
                return asset('images/' . $this->image);
            }
            // إذا كان المسار يحتوي على 'images/' فهو في public/images/
            if (strpos($this->image, 'images/') === 0) {
                return asset($this->image);
            }
            // إذا كان المسار لا يحتوي على 'images/' أضف 'images/' إليه
            return asset('images/' . $this->image);
        }
        return asset('images/default-image.png');
    }

    /**
     * Get the portfolio item gallery URLs
     */
    public function getGalleryUrlsAttribute()
    {
        if ($this->gallery && is_array($this->gallery)) {
            return array_map(function($image) {
                if (strpos($image, 'portfolio/') === 0) {
                    return asset('images/' . $image);
                }
                if (strpos($image, 'images/') === 0) {
                    return asset($image);
                }
                return asset('images/' . $image);
            }, $this->gallery);
        }
        return [];
    }
}