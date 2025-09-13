<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesTeam extends Model
{
    use HasFactory;

    protected $table = 'sales_team';

    protected $fillable = [
        'admin_id',
        'position',
        'region',
        'target',
        'achieved',
        'phone',
        'avatar',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'target' => 'decimal:2',
        'achieved' => 'decimal:2',
    ];

    /**
     * العلاقة مع المسؤول
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * العلاقة مع المهام
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to', 'admin_id')
            ->where('department', 'sales');
    }

    /**
     * الحصول على الاسم الكامل من خلال العلاقة مع المسؤول
     */
    public function getNameAttribute()
    {
        return $this->admin->name;
    }

    /**
     * الحصول على البريد الإلكتروني من خلال العلاقة مع المسؤول
     */
    public function getEmailAttribute()
    {
        return $this->admin->email;
    }

    /**
     * حساب نسبة الإنجاز
     */
    public function getAchievementPercentageAttribute()
    {
        if ($this->target > 0) {
            return round(($this->achieved / $this->target) * 100, 2);
        }
        
        return 0;
    }
}