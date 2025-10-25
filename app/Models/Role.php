<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'user_type',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * العلاقة مع المستخدمين
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

    /**
     * العلاقة مع المدراء
     */
    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class, 'admin_roles');
    }

    /**
     * العلاقة مع الصلاحيات
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    /**
     * التحقق من وجود صلاحية معينة
     */
    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    /**
     * إضافة صلاحية للدور
     */
    public function givePermissionTo(Permission $permission): void
    {
        $this->permissions()->syncWithoutDetaching([$permission->id]);
    }

    /**
     * إزالة صلاحية من الدور
     */
    public function revokePermissionTo(Permission $permission): void
    {
        $this->permissions()->detach($permission->id);
    }
}
