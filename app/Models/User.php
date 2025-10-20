<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'user_type',
        'is_active',
        'avatar',
        'bio'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * العلاقة مع الموظف
     */
    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * العلاقة مع المستورد
     */
    public function importer(): HasOne
    {
        return $this->hasOne(Importer::class);
    }

    /**
     * العلاقة مع فريق التسويق
     */
    public function marketingTeam(): HasOne
    {
        return $this->hasOne(MarketingTeam::class);
    }

    /**
     * العلاقة مع فريق المبيعات
     */
    public function salesTeam(): HasOne
    {
        return $this->hasOne(SalesTeam::class);
    }

    /**
     * العلاقة مع الأدوار
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * العلاقة مع الصلاحيات
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }


    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    public function isImporter(): bool
    {
        return $this->user_type === 'importer';
    }

    public function isEmployee(): bool
    {
        return $this->user_type === 'employee';
    }

    public function isCustomer(): bool
    {
        return $this->user_type === 'customer';
    }

    public function isSales(): bool
    {
        return $this->user_type === 'sales';
    }

    public function isMarketing(): bool
    {
        return $this->user_type === 'marketing';
    }

    /**
     * التحقق من وجود دور معين
     */
    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * التحقق من وجود أي دور من الأدوار المحددة
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * التحقق من وجود صلاحية معينة
     */
    public function hasPermission(string $permission): bool
    {
        // التحقق من الصلاحيات المباشرة
        if ($this->permissions()->where('name', $permission)->exists()) {
            return true;
        }

        // التحقق من الصلاحيات من خلال الأدوار
        return $this->roles()->whereHas('permissions', function ($query) use ($permission) {
            $query->where('name', $permission);
        })->exists();
    }

    /**
     * الحصول على جميع الصلاحيات
     */
    public function getAllPermissions(): \Illuminate\Database\Eloquent\Collection
    {
        $directPermissions = $this->permissions;
        $rolePermissions = $this->roles()->with('permissions')->get()
            ->pluck('permissions')
            ->flatten()
            ->unique('id');

        return $directPermissions->merge($rolePermissions)->unique('id');
    }

    /**
     * إضافة دور للمستخدم
     */
    public function assignRole(Role $role): void
    {
        $this->roles()->syncWithoutDetaching([$role->id]);
    }

    /**
     * إزالة دور من المستخدم
     */
    public function removeRole(Role $role): void
    {
        $this->roles()->detach($role->id);
    }

    /**
     * إعطاء صلاحية مباشرة للمستخدم
     */
    public function givePermissionTo(Permission $permission): void
    {
        $this->permissions()->syncWithoutDetaching([$permission->id]);
    }

    /**
     * إزالة صلاحية من المستخدم
     */
    public function revokePermissionTo(Permission $permission): void
    {
        $this->permissions()->detach($permission->id);
    }

    public function getDashboardRoute(): string
    {
        switch ($this->user_type) {
            case 'admin':
                return 'admin.dashboard';
            case 'employee':
                return 'employee.dashboard';
            case 'importer':
                return 'importers.dashboard';
            case 'customer':
                return 'importers.dashboard';
            case 'sales':
                return 'sales.dashboard';
            case 'marketing':
                return 'marketing.dashboard';
            default:
                return 'importers.dashboard';
        }
    }

    /**
     * الحصول على تسمية نوع المستخدم
     */
    public function getUserTypeLabelAttribute(): string
    {
        return match($this->user_type) {
            'admin' => 'مدير',
            'employee' => 'موظف',
            'importer' => 'مستورد',
            'customer' => 'عميل',
            'sales' => 'مندوب مبيعات',
            'marketing' => 'موظف تسويق',
            default => $this->user_type
        };
    }
} 