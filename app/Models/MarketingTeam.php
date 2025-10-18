<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarketingTeam extends Model
{
    use HasFactory;

    protected $table = 'marketing_team';

    protected $fillable = [
        'admin_id',
        'department',
        'position',
        'bio',
        'phone',
        'avatar',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * العلاقة مع المسؤول
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * العلاقة مع المهام
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to', 'admin_id')
            ->where('department', 'marketing');
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
}