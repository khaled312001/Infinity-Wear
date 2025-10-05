<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'module',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * العلاقة مع الأدوار
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    /**
     * العلاقة مع المستخدمين
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_permissions');
    }

    /**
     * العلاقة مع المدراء
     */
    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class, 'admin_permissions');
    }

    /**
     * الحصول على جميع الصلاحيات المجمعة حسب الوحدة
     */
    public static function getGroupedPermissions(): array
    {
        return self::where('is_active', true)
            ->orderBy('module')
            ->orderBy('display_name')
            ->get()
            ->groupBy('module')
            ->toArray();
    }

    /**
     * الحصول على الصلاحيات حسب الوحدة
     */
    public static function getByModule(string $module): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('module', $module)
            ->where('is_active', true)
            ->orderBy('display_name')
            ->get();
    }
}
