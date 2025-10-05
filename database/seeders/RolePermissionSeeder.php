<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء الصلاحيات
        $permissions = [
            // إدارة المستخدمين
            ['name' => 'users.view', 'display_name' => 'عرض المستخدمين', 'description' => 'إمكانية عرض قائمة المستخدمين', 'module' => 'users'],
            ['name' => 'users.create', 'display_name' => 'إضافة مستخدمين', 'description' => 'إمكانية إضافة مستخدمين جدد', 'module' => 'users'],
            ['name' => 'users.edit', 'display_name' => 'تعديل المستخدمين', 'description' => 'إمكانية تعديل بيانات المستخدمين', 'module' => 'users'],
            ['name' => 'users.delete', 'display_name' => 'حذف المستخدمين', 'description' => 'إمكانية حذف المستخدمين', 'module' => 'users'],

            // إدارة المدراء
            ['name' => 'admins.view', 'display_name' => 'عرض المدراء', 'description' => 'إمكانية عرض قائمة المدراء', 'module' => 'admins'],
            ['name' => 'admins.create', 'display_name' => 'إضافة مدراء', 'description' => 'إمكانية إضافة مدراء جدد', 'module' => 'admins'],
            ['name' => 'admins.edit', 'display_name' => 'تعديل المدراء', 'description' => 'إمكانية تعديل بيانات المدراء', 'module' => 'admins'],
            ['name' => 'admins.delete', 'display_name' => 'حذف المدراء', 'description' => 'إمكانية حذف المدراء', 'module' => 'admins'],

            // إدارة الموظفين
            ['name' => 'employees.view', 'display_name' => 'عرض الموظفين', 'description' => 'إمكانية عرض قائمة الموظفين', 'module' => 'employees'],
            ['name' => 'employees.create', 'display_name' => 'إضافة موظفين', 'description' => 'إمكانية إضافة موظفين جدد', 'module' => 'employees'],
            ['name' => 'employees.edit', 'display_name' => 'تعديل الموظفين', 'description' => 'إمكانية تعديل بيانات الموظفين', 'module' => 'employees'],
            ['name' => 'employees.delete', 'display_name' => 'حذف الموظفين', 'description' => 'إمكانية حذف الموظفين', 'module' => 'employees'],

            // إدارة الطلبات
            ['name' => 'orders.view', 'display_name' => 'عرض الطلبات', 'description' => 'إمكانية عرض قائمة الطلبات', 'module' => 'orders'],
            ['name' => 'orders.create', 'display_name' => 'إضافة طلبات', 'description' => 'إمكانية إضافة طلبات جديدة', 'module' => 'orders'],
            ['name' => 'orders.edit', 'display_name' => 'تعديل الطلبات', 'description' => 'إمكانية تعديل الطلبات', 'module' => 'orders'],
            ['name' => 'orders.delete', 'display_name' => 'حذف الطلبات', 'description' => 'إمكانية حذف الطلبات', 'module' => 'orders'],

            // إدارة المستوردين
            ['name' => 'importers.view', 'display_name' => 'عرض المستوردين', 'description' => 'إمكانية عرض قائمة المستوردين', 'module' => 'importers'],
            ['name' => 'importers.create', 'display_name' => 'إضافة مستوردين', 'description' => 'إمكانية إضافة مستوردين جدد', 'module' => 'importers'],
            ['name' => 'importers.edit', 'display_name' => 'تعديل المستوردين', 'description' => 'إمكانية تعديل بيانات المستوردين', 'module' => 'importers'],
            ['name' => 'importers.delete', 'display_name' => 'حذف المستوردين', 'description' => 'إمكانية حذف المستوردين', 'module' => 'importers'],

            // إدارة المهام
            ['name' => 'tasks.view', 'display_name' => 'عرض المهام', 'description' => 'إمكانية عرض قائمة المهام', 'module' => 'tasks'],
            ['name' => 'tasks.create', 'display_name' => 'إضافة مهام', 'description' => 'إمكانية إضافة مهام جديدة', 'module' => 'tasks'],
            ['name' => 'tasks.edit', 'display_name' => 'تعديل المهام', 'description' => 'إمكانية تعديل المهام', 'module' => 'tasks'],
            ['name' => 'tasks.delete', 'display_name' => 'حذف المهام', 'description' => 'إمكانية حذف المهام', 'module' => 'tasks'],

            // إدارة المعاملات المالية
            ['name' => 'transactions.view', 'display_name' => 'عرض المعاملات', 'description' => 'إمكانية عرض المعاملات المالية', 'module' => 'transactions'],
            ['name' => 'transactions.create', 'display_name' => 'إضافة معاملات', 'description' => 'إمكانية إضافة معاملات مالية', 'module' => 'transactions'],
            ['name' => 'transactions.edit', 'display_name' => 'تعديل المعاملات', 'description' => 'إمكانية تعديل المعاملات المالية', 'module' => 'transactions'],
            ['name' => 'transactions.delete', 'display_name' => 'حذف المعاملات', 'description' => 'إمكانية حذف المعاملات المالية', 'module' => 'transactions'],

            // إدارة التقارير
            ['name' => 'reports.view', 'display_name' => 'عرض التقارير', 'description' => 'إمكانية عرض التقارير', 'module' => 'reports'],
            ['name' => 'reports.export', 'display_name' => 'تصدير التقارير', 'description' => 'إمكانية تصدير التقارير', 'module' => 'reports'],

            // إدارة الإعدادات
            ['name' => 'settings.view', 'display_name' => 'عرض الإعدادات', 'description' => 'إمكانية عرض إعدادات النظام', 'module' => 'settings'],
            ['name' => 'settings.edit', 'display_name' => 'تعديل الإعدادات', 'description' => 'إمكانية تعديل إعدادات النظام', 'module' => 'settings'],

            // إدارة الأدوار والصلاحيات
            ['name' => 'roles.view', 'display_name' => 'عرض الأدوار', 'description' => 'إمكانية عرض قائمة الأدوار', 'module' => 'roles'],
            ['name' => 'roles.create', 'display_name' => 'إضافة أدوار', 'description' => 'إمكانية إضافة أدوار جديدة', 'module' => 'roles'],
            ['name' => 'roles.edit', 'display_name' => 'تعديل الأدوار', 'description' => 'إمكانية تعديل الأدوار', 'module' => 'roles'],
            ['name' => 'roles.delete', 'display_name' => 'حذف الأدوار', 'description' => 'إمكانية حذف الأدوار', 'module' => 'roles'],

            ['name' => 'permissions.view', 'display_name' => 'عرض الصلاحيات', 'description' => 'إمكانية عرض قائمة الصلاحيات', 'module' => 'permissions'],
            ['name' => 'permissions.create', 'display_name' => 'إضافة صلاحيات', 'description' => 'إمكانية إضافة صلاحيات جديدة', 'module' => 'permissions'],
            ['name' => 'permissions.edit', 'display_name' => 'تعديل الصلاحيات', 'description' => 'إمكانية تعديل الصلاحيات', 'module' => 'permissions'],
            ['name' => 'permissions.delete', 'display_name' => 'حذف الصلاحيات', 'description' => 'إمكانية حذف الصلاحيات', 'module' => 'permissions'],

            // إدارة المحتوى
            ['name' => 'content.view', 'display_name' => 'عرض المحتوى', 'description' => 'إمكانية عرض محتوى الموقع', 'module' => 'content'],
            ['name' => 'content.create', 'display_name' => 'إضافة محتوى', 'description' => 'إمكانية إضافة محتوى جديد', 'module' => 'content'],
            ['name' => 'content.edit', 'display_name' => 'تعديل المحتوى', 'description' => 'إمكانية تعديل المحتوى', 'module' => 'content'],
            ['name' => 'content.delete', 'display_name' => 'حذف المحتوى', 'description' => 'إمكانية حذف المحتوى', 'module' => 'content'],

            // إدارة المبيعات
            ['name' => 'sales.view', 'display_name' => 'عرض المبيعات', 'description' => 'إمكانية عرض بيانات المبيعات', 'module' => 'sales'],
            ['name' => 'sales.create', 'display_name' => 'إضافة مبيعات', 'description' => 'إمكانية إضافة مبيعات جديدة', 'module' => 'sales'],
            ['name' => 'sales.edit', 'display_name' => 'تعديل المبيعات', 'description' => 'إمكانية تعديل بيانات المبيعات', 'module' => 'sales'],

            // إدارة التسويق
            ['name' => 'marketing.view', 'display_name' => 'عرض التسويق', 'description' => 'إمكانية عرض بيانات التسويق', 'module' => 'marketing'],
            ['name' => 'marketing.create', 'display_name' => 'إضافة تسويق', 'description' => 'إمكانية إضافة حملات تسويقية', 'module' => 'marketing'],
            ['name' => 'marketing.edit', 'display_name' => 'تعديل التسويق', 'description' => 'إمكانية تعديل الحملات التسويقية', 'module' => 'marketing'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        // إنشاء الأدوار
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'مدير عام',
                'description' => 'مدير عام للنظام مع جميع الصلاحيات',
                'permissions' => Permission::all()->pluck('name')->toArray()
            ],
            [
                'name' => 'admin',
                'display_name' => 'مدير',
                'description' => 'مدير النظام مع صلاحيات إدارية',
                'permissions' => [
                    'users.view', 'users.create', 'users.edit',
                    'employees.view', 'employees.create', 'employees.edit',
                    'orders.view', 'orders.create', 'orders.edit',
                    'importers.view', 'importers.create', 'importers.edit',
                    'tasks.view', 'tasks.create', 'tasks.edit',
                    'transactions.view', 'transactions.create', 'transactions.edit',
                    'reports.view', 'reports.export',
                    'content.view', 'content.create', 'content.edit',
                    'sales.view', 'sales.create', 'sales.edit',
                    'marketing.view', 'marketing.create', 'marketing.edit',
                ]
            ],
            [
                'name' => 'manager',
                'display_name' => 'مدير قسم',
                'description' => 'مدير قسم مع صلاحيات محدودة',
                'permissions' => [
                    'employees.view', 'employees.edit',
                    'orders.view', 'orders.edit',
                    'tasks.view', 'tasks.create', 'tasks.edit',
                    'reports.view',
                    'sales.view', 'sales.edit',
                    'marketing.view', 'marketing.edit',
                ]
            ],
            [
                'name' => 'employee',
                'display_name' => 'موظف',
                'description' => 'موظف عادي مع صلاحيات أساسية',
                'permissions' => [
                    'orders.view', 'orders.edit',
                    'tasks.view', 'tasks.edit',
                    'sales.view',
                    'marketing.view',
                ]
            ],
            [
                'name' => 'sales_rep',
                'display_name' => 'مندوب مبيعات',
                'description' => 'مندوب مبيعات مع صلاحيات المبيعات',
                'permissions' => [
                    'orders.view', 'orders.create', 'orders.edit',
                    'importers.view', 'importers.create', 'importers.edit',
                    'tasks.view', 'tasks.edit',
                    'sales.view', 'sales.create', 'sales.edit',
                ]
            ],
            [
                'name' => 'marketing_rep',
                'display_name' => 'موظف تسويق',
                'description' => 'موظف تسويق مع صلاحيات التسويق',
                'permissions' => [
                    'tasks.view', 'tasks.edit',
                    'marketing.view', 'marketing.create', 'marketing.edit',
                    'content.view', 'content.create', 'content.edit',
                ]
            ],
            [
                'name' => 'customer',
                'display_name' => 'عميل',
                'description' => 'عميل عادي مع صلاحيات محدودة',
                'permissions' => [
                    'orders.view', 'orders.create',
                ]
            ],
            [
                'name' => 'importer',
                'display_name' => 'مستورد',
                'description' => 'مستورد مع صلاحيات خاصة',
                'permissions' => [
                    'orders.view', 'orders.create', 'orders.edit',
                    'importers.view', 'importers.edit',
                ]
            ],
        ];

        foreach ($roles as $roleData) {
            $permissions = $roleData['permissions'];
            unset($roleData['permissions']);

            $role = Role::firstOrCreate(
                ['name' => $roleData['name']],
                $roleData
            );

            // ربط الصلاحيات بالدور
            $permissionIds = Permission::whereIn('name', $permissions)->pluck('id')->toArray();
            $role->permissions()->sync($permissionIds);
        }
    }
}