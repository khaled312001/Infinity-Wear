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
            $possiblePaths = [];
            
            // بناء قائمة بالمسارات المحتملة للصورة
            if (strpos($this->image, 'images/portfolio/') === 0) {
                $possiblePaths[] = public_path($this->image);
                $possiblePaths[] = storage_path('app/public/' . $this->image);
            } elseif (strpos($this->image, 'portfolio/') === 0) {
                $possiblePaths[] = public_path('images/' . $this->image);
                $possiblePaths[] = storage_path('app/public/images/' . $this->image);
            } elseif (strpos($this->image, 'images/') === 0) {
                $possiblePaths[] = public_path($this->image);
                $possiblePaths[] = storage_path('app/public/' . $this->image);
            } else {
                $possiblePaths[] = public_path('images/' . $this->image);
                $possiblePaths[] = public_path('images/portfolio/' . $this->image);
                $possiblePaths[] = storage_path('app/public/images/portfolio/' . $this->image);
            }
            
            // التحقق من وجود الصورة في أي من المسارات
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    // إرجاع URL بناءً على المسار الذي وجدت فيه الصورة
                    $relativePath = str_replace(public_path(), '', $path);
                    // إزالة الشرطة المائلة الأولى إذا كانت موجودة
                    $relativePath = ltrim($relativePath, '/\\');
                    return asset($relativePath);
                }
            }
            
            // إذا لم توجد الصورة، إرجاع URL بناءً على المسار الأصلي (للمحاولة)
            if (strpos($this->image, 'images/portfolio/') === 0) {
                return asset($this->image);
            }
            if (strpos($this->image, 'portfolio/') === 0) {
                return asset('images/' . $this->image);
            }
            if (strpos($this->image, 'images/') === 0) {
                return asset($this->image);
            }
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
            return array_filter(array_map(function($image) {
                if (empty($image)) {
                    return null;
                }
                
                $possiblePaths = [];
                
                // بناء قائمة بالمسارات المحتملة للصورة
                if (strpos($image, 'images/portfolio/') === 0) {
                    $possiblePaths[] = public_path($image);
                    $possiblePaths[] = storage_path('app/public/' . $image);
                } elseif (strpos($image, 'portfolio/') === 0) {
                    $possiblePaths[] = public_path('images/' . $image);
                    $possiblePaths[] = storage_path('app/public/images/' . $image);
                } elseif (strpos($image, 'images/') === 0) {
                    $possiblePaths[] = public_path($image);
                    $possiblePaths[] = storage_path('app/public/' . $image);
                } else {
                    $possiblePaths[] = public_path('images/' . $image);
                    $possiblePaths[] = public_path('images/portfolio/' . $image);
                    $possiblePaths[] = storage_path('app/public/images/portfolio/' . $image);
                }
                
                // التحقق من وجود الصورة في أي من المسارات
                foreach ($possiblePaths as $path) {
                    if (file_exists($path)) {
                        // إرجاع URL بناءً على المسار الذي وجدت فيه الصورة
                        $relativePath = str_replace(public_path(), '', $path);
                        // إزالة الشرطة المائلة الأولى إذا كانت موجودة
                        $relativePath = ltrim($relativePath, '/\\');
                        return asset($relativePath);
                    }
                }
                
                // إذا لم توجد الصورة، إرجاع null (سيتم تصفيتها لاحقاً)
                return null;
            }, $this->gallery));
        }
        return [];
    }
}