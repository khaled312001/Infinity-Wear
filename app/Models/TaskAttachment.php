<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'file_name',
        'original_name',
        'file_path',
        'file_size',
        'mime_type',
        'uploaded_by',
        'uploaded_by_type',
        'description'
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    /**
     * العلاقة مع المهمة
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(TaskCard::class, 'task_id');
    }

    /**
     * العلاقة مع المستخدم (Admin)
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'uploaded_by');
    }

    /**
     * العلاقة مع المستخدم (Marketing)
     */
    public function marketing(): BelongsTo
    {
        return $this->belongsTo(MarketingTeam::class, 'uploaded_by');
    }

    /**
     * العلاقة مع المستخدم (Sales)
     */
    public function sales(): BelongsTo
    {
        return $this->belongsTo(SalesTeam::class, 'uploaded_by');
    }

    /**
     * الحصول على المستخدم
     */
    public function getUploaderAttribute()
    {
        return match($this->uploaded_by_type) {
            'admin' => $this->admin,
            'marketing' => $this->marketing,
            'sales' => $this->sales,
            default => null
        };
    }

    /**
     * الحصول على حجم الملف بشكل مقروء
     */
    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * تحديد ما إذا كان الملف صورة
     */
    public function getIsImageAttribute(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * تحديد ما إذا كان الملف مستند
     */
    public function getIsDocumentAttribute(): bool
    {
        $documentTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'text/plain'
        ];
        
        return in_array($this->mime_type, $documentTypes);
    }

    /**
     * الحصول على أيقونة الملف
     */
    public function getFileIconAttribute(): string
    {
        if ($this->is_image) {
            return 'fas fa-image';
        }
        
        if ($this->is_document) {
            return 'fas fa-file-alt';
        }
        
        return 'fas fa-file';
    }

    /**
     * الحصول على رابط الملف
     */
    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }
}
