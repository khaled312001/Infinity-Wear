<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'department',
        'position',
        'salary',
        'hire_date',
        'manager_id',
        'is_active',
        'phone',
        'address',
        'emergency_contact',
        'notes'
    ];

    protected $casts = [
        'hire_date' => 'date',
        'is_active' => 'boolean',
        'salary' => 'decimal:2',
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع المدير
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    /**
     * العلاقة مع الموظفين التابعين
     */
    public function subordinates(): HasMany
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    /**
     * العلاقة مع الأدوار
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'employee_roles');
    }

    /**
     * العلاقة مع الصلاحيات
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'employee_permissions');
    }

    /**
     * العلاقة مع المهام
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    /**
     * التحقق من وجود دور معين
     */
    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
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
     * الحصول على تسمية القسم
     */
    public function getDepartmentLabelAttribute(): string
    {
        return match($this->department) {
            'admin' => 'الإدارة',
            'sales' => 'المبيعات',
            'marketing' => 'التسويق',
            'production' => 'الإنتاج',
            'finance' => 'المالية',
            'hr' => 'الموارد البشرية',
            'customer_service' => 'خدمة العملاء',
            'warehouse' => 'المستودع',
            default => $this->department
        };
    }

    /**
     * الحصول على حالة الموظف
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? 'نشط' : 'غير نشط';
    }
}
