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
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'gallery' => 'array',
        'completion_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the portfolio item image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            $possiblePaths = [];
            
            // بناء قائمة بالمسارات المحتملة للصورة
            $imageName = basename($this->image);
            
            // مسارات محتملة في public
            $possiblePaths[] = public_path('images/portfolio/' . $imageName);
            $possiblePaths[] = public_path($this->image);
            
            // مسارات محتملة في storage
            $possiblePaths[] = storage_path('app/public/images/portfolio/' . $imageName);
            $possiblePaths[] = storage_path('app/public/' . $this->image);
            
            // إذا كان المسار يحتوي على 'images/portfolio/' فهو في public أو storage
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
            
            // إزالة المسارات المكررة
            $possiblePaths = array_unique($possiblePaths);
            
            // التحقق من وجود الصورة في أي من المسارات
            foreach ($possiblePaths as $path) {
                if (file_exists($path) && is_file($path)) {
                    // إذا كانت الصورة في storage/app/public
                    if (strpos($path, storage_path('app/public')) !== false) {
                        $relativePath = str_replace(storage_path('app/public'), '', $path);
                        $relativePath = ltrim($relativePath, '/\\');
                        return asset('storage/' . $relativePath);
                    }
                    // إذا كانت الصورة في public
                    if (strpos($path, public_path()) !== false) {
                        $relativePath = str_replace(public_path(), '', $path);
                        $relativePath = ltrim($relativePath, '/\\');
                        return asset($relativePath);
                    }
                }
            }
            
            // إذا لم توجد الصورة، إرجاع صورة افتراضية
            return asset('images/default-image.png');
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