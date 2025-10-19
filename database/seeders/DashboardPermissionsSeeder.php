<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class DashboardPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء الصلاحيات بناءً على الصفحات الفعلية في كل داشبورد
        
        $permissions = [
            // صلاحيات الأدمن
            [
                'name' => 'admin.dashboard',
                'display_name' => 'لوحة تحكم الأدمن',
                'description' => 'الوصول إلى لوحة تحكم الأدمن الرئيسية',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.notifications',
                'display_name' => 'إدارة الإشعارات',
                'description' => 'عرض وإدارة الإشعارات',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.contacts',
                'display_name' => 'رسائل التواصل',
                'description' => 'عرض وإدارة رسائل التواصل',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.whatsapp',
                'display_name' => 'رسائل الواتساب',
                'description' => 'عرض وإدارة رسائل الواتساب',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.services',
                'display_name' => 'إدارة الخدمات',
                'description' => 'إدارة خدمات الشركة',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.portfolio',
                'display_name' => 'معرض الأعمال',
                'description' => 'إدارة معرض أعمال الشركة',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.testimonials',
                'display_name' => 'التقييمات',
                'description' => 'إدارة تقييمات العملاء',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.importers',
                'display_name' => 'إدارة المستوردين',
                'description' => 'إدارة بيانات المستوردين',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.importers.orders',
                'display_name' => 'طلبات المستوردين',
                'description' => 'إدارة طلبات المستوردين',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.tasks',
                'display_name' => 'إدارة المهام',
                'description' => 'إدارة مهام الفريق',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'tasks.edit',
                'display_name' => 'تعديل المهام',
                'description' => 'تعديل جميع تفاصيل المهام',
                'module' => 'tasks',
                'user_type' => 'admin'
            ],
            [
                'name' => 'tasks.delete',
                'display_name' => 'حذف المهام',
                'description' => 'حذف المهام',
                'module' => 'tasks',
                'user_type' => 'admin'
            ],
            [
                'name' => 'tasks.create',
                'display_name' => 'إنشاء المهام',
                'description' => 'إنشاء مهام جديدة',
                'module' => 'tasks',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.company-plans',
                'display_name' => 'خطط الشركة',
                'description' => 'إدارة خطط الشركة',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.finance.dashboard',
                'display_name' => 'لوحة المالية',
                'description' => 'عرض الإحصائيات المالية',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.finance.transactions',
                'display_name' => 'المعاملات المالية',
                'description' => 'إدارة المعاملات المالية',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.finance.reports',
                'display_name' => 'التقارير المالية',
                'description' => 'عرض التقارير المالية',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.marketing-team',
                'display_name' => 'فريق التسويق',
                'description' => 'إدارة فريق التسويق',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.sales-team',
                'display_name' => 'فريق المبيعات',
                'description' => 'إدارة فريق المبيعات',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.customer-notes',
                'display_name' => 'ملاحظات العملاء',
                'description' => 'إدارة ملاحظات العملاء',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.marketing-reports',
                'display_name' => 'تقارير المندوبين',
                'description' => 'إدارة تقارير المندوبين التسويقيين',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.reports',
                'display_name' => 'التقارير',
                'description' => 'عرض تقارير النظام',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.settings',
                'display_name' => 'الإعدادات',
                'description' => 'إعدادات النظام',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.permissions',
                'display_name' => 'الأدوار والصلاحيات',
                'description' => 'إدارة الأدوار والصلاحيات',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.admins',
                'display_name' => 'إدارة المديرين',
                'description' => 'إدارة حسابات المديرين',
                'module' => 'admin',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.profile',
                'display_name' => 'الملف الشخصي',
                'description' => 'إدارة الملف الشخصي',
                'module' => 'admin',
                'user_type' => 'admin'
            ],

            // صلاحيات المبيعات
            [
                'name' => 'sales.dashboard',
                'display_name' => 'لوحة تحكم المبيعات',
                'description' => 'الوصول إلى لوحة تحكم المبيعات',
                'module' => 'sales',
                'user_type' => 'sales'
            ],
            [
                'name' => 'sales.importer-orders',
                'display_name' => 'طلبات المستوردين',
                'description' => 'عرض وإدارة طلبات المستوردين',
                'module' => 'sales',
                'user_type' => 'sales'
            ],
            [
                'name' => 'sales.importers',
                'display_name' => 'إدارة المستوردين',
                'description' => 'إدارة بيانات المستوردين',
                'module' => 'sales',
                'user_type' => 'sales'
            ],
            [
                'name' => 'sales.tasks',
                'display_name' => 'المهام',
                'description' => 'عرض وإدارة المهام',
                'module' => 'sales',
                'user_type' => 'sales'
            ],
            [
                'name' => 'sales.contacts',
                'display_name' => 'جهات الاتصال',
                'description' => 'إدارة جهات الاتصال',
                'module' => 'sales',
                'user_type' => 'sales'
            ],
            [
                'name' => 'sales.reports',
                'display_name' => 'التقارير',
                'description' => 'عرض تقارير المبيعات',
                'module' => 'sales',
                'user_type' => 'sales'
            ],
            [
                'name' => 'sales.profile',
                'display_name' => 'الملف الشخصي',
                'description' => 'إدارة الملف الشخصي',
                'module' => 'sales',
                'user_type' => 'sales'
            ],
            [
                'name' => 'sales.tasks',
                'display_name' => 'المهام',
                'description' => 'عرض وإدارة المهام',
                'module' => 'sales',
                'user_type' => 'sales'
            ],
            [
                'name' => 'sales.tasks.move',
                'display_name' => 'نقل المهام',
                'description' => 'نقل المهام بين الأعمدة فقط',
                'module' => 'sales',
                'user_type' => 'sales'
            ],

            // صلاحيات التسويق
            [
                'name' => 'marketing.dashboard',
                'display_name' => 'لوحة تحكم التسويق',
                'description' => 'الوصول إلى لوحة تحكم التسويق',
                'module' => 'marketing',
                'user_type' => 'marketing'
            ],
            [
                'name' => 'marketing.portfolio',
                'display_name' => 'معرض الأعمال',
                'description' => 'إدارة معرض أعمال الشركة',
                'module' => 'marketing',
                'user_type' => 'marketing'
            ],
            [
                'name' => 'marketing.testimonials',
                'display_name' => 'التقييمات',
                'description' => 'إدارة تقييمات العملاء',
                'module' => 'marketing',
                'user_type' => 'marketing'
            ],
            [
                'name' => 'marketing.tasks',
                'display_name' => 'المهام',
                'description' => 'عرض وإدارة المهام',
                'module' => 'marketing',
                'user_type' => 'marketing'
            ],
            [
                'name' => 'marketing.tasks.move',
                'display_name' => 'نقل المهام',
                'description' => 'نقل المهام بين الأعمدة فقط',
                'module' => 'marketing',
                'user_type' => 'marketing'
            ],
            [
                'name' => 'marketing.contacts',
                'display_name' => 'جهات الاتصال',
                'description' => 'إدارة جهات الاتصال',
                'module' => 'marketing',
                'user_type' => 'marketing'
            ],
            [
                'name' => 'marketing.profile',
                'display_name' => 'الملف الشخصي',
                'description' => 'إدارة الملف الشخصي',
                'module' => 'marketing',
                'user_type' => 'marketing'
            ],

            // صلاحيات العملاء
            [
                'name' => 'customer.dashboard',
                'display_name' => 'لوحة تحكم العميل',
                'description' => 'الوصول إلى لوحة تحكم العميل',
                'module' => 'customer',
                'user_type' => 'customer'
            ],
            [
                'name' => 'customer.orders',
                'display_name' => 'طلباتي',
                'description' => 'عرض طلبات العميل',
                'module' => 'customer',
                'user_type' => 'customer'
            ],
            [
                'name' => 'customer.designs',
                'display_name' => 'تصاميمي',
                'description' => 'عرض تصاميم العميل',
                'module' => 'customer',
                'user_type' => 'customer'
            ],
            [
                'name' => 'customer.profile',
                'display_name' => 'الملف الشخصي',
                'description' => 'إدارة الملف الشخصي',
                'module' => 'customer',
                'user_type' => 'customer'
            ],
            [
                'name' => 'customer.settings',
                'display_name' => 'الإعدادات',
                'description' => 'إعدادات الحساب',
                'module' => 'customer',
                'user_type' => 'customer'
            ],

            // صلاحيات المستوردين
            [
                'name' => 'importer.dashboard',
                'display_name' => 'لوحة تحكم المستورد',
                'description' => 'الوصول إلى لوحة تحكم المستورد',
                'module' => 'importer',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.orders',
                'display_name' => 'طلباتي',
                'description' => 'عرض طلبات المستورد',
                'module' => 'importer',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.tracking',
                'display_name' => 'تتبع الشحنات',
                'description' => 'تتبع حالة الشحنات',
                'module' => 'importer',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.invoices',
                'display_name' => 'الفواتير',
                'description' => 'عرض وإدارة الفواتير',
                'module' => 'importer',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.profile',
                'display_name' => 'الملف الشخصي',
                'description' => 'إدارة الملف الشخصي',
                'module' => 'importer',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.payment-methods',
                'display_name' => 'طرق الدفع',
                'description' => 'إدارة طرق الدفع',
                'module' => 'importer',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.notifications',
                'display_name' => 'الإشعارات',
                'description' => 'عرض الإشعارات',
                'module' => 'importer',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.help',
                'display_name' => 'المساعدة',
                'description' => 'صفحة المساعدة',
                'module' => 'importer',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.support',
                'display_name' => 'الدعم الفني',
                'description' => 'الدعم الفني',
                'module' => 'importer',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.contact',
                'display_name' => 'التواصل معنا',
                'description' => 'التواصل مع الشركة',
                'module' => 'importer',
                'user_type' => 'importer'
            ],
        ];

        // إنشاء الصلاحيات
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                array_merge($permission, ['is_active' => true])
            );
        }

        // إنشاء الأدوار مع الصلاحيات المناسبة
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'مدير عام',
                'description' => 'مدير عام مع جميع الصلاحيات',
                'permissions' => Permission::where('user_type', 'admin')->pluck('name')->toArray()
            ],
            [
                'name' => 'admin',
                'display_name' => 'مدير',
                'description' => 'مدير النظام',
                'permissions' => Permission::where('user_type', 'admin')->pluck('name')->toArray()
            ],
            [
                'name' => 'sales',
                'display_name' => 'مندوب مبيعات',
                'description' => 'مندوب مبيعات',
                'permissions' => Permission::where('user_type', 'sales')->pluck('name')->toArray()
            ],
            [
                'name' => 'marketing',
                'display_name' => 'موظف تسويق',
                'description' => 'موظف تسويق',
                'permissions' => Permission::where('user_type', 'marketing')->pluck('name')->toArray()
            ],
            [
                'name' => 'customer',
                'display_name' => 'عميل',
                'description' => 'عميل',
                'permissions' => Permission::where('user_type', 'customer')->pluck('name')->toArray()
            ],
            [
                'name' => 'importer',
                'display_name' => 'مستورد',
                'description' => 'مستورد',
                'permissions' => Permission::where('user_type', 'importer')->pluck('name')->toArray()
            ],
        ];

        foreach ($roles as $roleData) {
            $permissions = $roleData['permissions'];
            unset($roleData['permissions']);

            $role = Role::firstOrCreate(
                ['name' => $roleData['name']],
                array_merge($roleData, ['is_active' => true])
            );

            // ربط الصلاحيات بالدور
            $permissionIds = Permission::whereIn('name', $permissions)->pluck('id')->toArray();
            $role->permissions()->sync($permissionIds);
        }
    }
}
