<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PageBasedPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // مسح الصلاحيات الموجودة
        Permission::truncate();
        
        // صلاحيات الأدمن - مطابقة للصفحات الفعلية في السايد بار
        $adminPermissions = [
            // الرئيسية
            [
                'name' => 'admin.dashboard',
                'display_name' => 'لوحة التحكم',
                'description' => 'الوصول إلى لوحة تحكم الأدمن الرئيسية',
                'module' => 'dashboard',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.notifications',
                'display_name' => 'الإشعارات',
                'description' => 'عرض وإدارة الإشعارات',
                'module' => 'notifications',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.contacts',
                'display_name' => 'رسائل التواصل',
                'description' => 'عرض وإدارة رسائل التواصل',
                'module' => 'contacts',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.whatsapp',
                'display_name' => 'رسائل الواتساب',
                'description' => 'عرض وإدارة رسائل الواتساب',
                'module' => 'whatsapp',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.support',
                'display_name' => 'الدعم الفني',
                'description' => 'صفحة الدعم الفني',
                'module' => 'support',
                'user_type' => 'admin'
            ],
            
            // إدارة المحتوى
            [
                'name' => 'admin.services',
                'display_name' => 'إدارة الخدمات',
                'description' => 'إدارة خدمات الشركة',
                'module' => 'content',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.portfolio',
                'display_name' => 'معرض الأعمال',
                'description' => 'إدارة معرض الأعمال',
                'module' => 'content',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.testimonials',
                'display_name' => 'التقييمات',
                'description' => 'إدارة تقييمات العملاء',
                'module' => 'content',
                'user_type' => 'admin'
            ],
            
            // إدارة المستوردين
            [
                'name' => 'admin.importers',
                'display_name' => 'المستوردين',
                'description' => 'إدارة المستوردين',
                'module' => 'importers',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.importers.orders',
                'display_name' => 'طلبات المستوردين',
                'description' => 'إدارة طلبات المستوردين',
                'module' => 'importers',
                'user_type' => 'admin'
            ],
            
            // إدارة المهام
            [
                'name' => 'admin.tasks',
                'display_name' => 'المهام',
                'description' => 'إدارة المهام',
                'module' => 'tasks',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.company-plans',
                'display_name' => 'خطط الشركة',
                'description' => 'إدارة خطط الشركة',
                'module' => 'tasks',
                'user_type' => 'admin'
            ],
            
            // إدارة المالية
            [
                'name' => 'admin.financial.dashboard',
                'display_name' => 'لوحة المالية',
                'description' => 'لوحة التحكم المالية',
                'module' => 'financial',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.financial.transactions',
                'display_name' => 'المعاملات المالية',
                'description' => 'إدارة المعاملات المالية',
                'module' => 'financial',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.financial.reports',
                'display_name' => 'التقارير المالية',
                'description' => 'التقارير المالية',
                'module' => 'financial',
                'user_type' => 'admin'
            ],
            
            // إدارة الفرق
            [
                'name' => 'admin.marketing.team',
                'display_name' => 'فريق التسويق',
                'description' => 'إدارة فريق التسويق',
                'module' => 'teams',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.sales.team',
                'display_name' => 'فريق المبيعات',
                'description' => 'إدارة فريق المبيعات',
                'module' => 'teams',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.marketing-reports',
                'display_name' => 'تقارير المندوبين',
                'description' => 'تقارير المندوبين التسويقيين',
                'module' => 'teams',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.email-marketing',
                'display_name' => 'التسويق بالبريد الإلكتروني',
                'description' => 'إدارة التسويق بالبريد الإلكتروني',
                'module' => 'teams',
                'user_type' => 'admin'
            ],
            
            // إدارة العملاء
            [
                'name' => 'admin.users',
                'display_name' => 'إدارة المستخدمين',
                'description' => 'إدارة المستخدمين',
                'module' => 'customers',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.customer-notes',
                'display_name' => 'ملاحظات العملاء',
                'description' => 'إدارة ملاحظات العملاء',
                'module' => 'customers',
                'user_type' => 'admin'
            ],
            
            // إدارة النظام
            [
                'name' => 'admin.reports',
                'display_name' => 'التقارير',
                'description' => 'تقارير النظام',
                'module' => 'system',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.settings',
                'display_name' => 'الإعدادات',
                'description' => 'إعدادات النظام',
                'module' => 'system',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.permissions',
                'display_name' => 'الأدوار والصلاحيات',
                'description' => 'إدارة الأدوار والصلاحيات',
                'module' => 'system',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.admins',
                'display_name' => 'إدارة المديرين',
                'description' => 'إدارة المديرين',
                'module' => 'system',
                'user_type' => 'admin'
            ],
            [
                'name' => 'admin.profile',
                'display_name' => 'الملف الشخصي',
                'description' => 'الملف الشخصي للأدمن',
                'module' => 'system',
                'user_type' => 'admin'
            ],
        ];

        // صلاحيات فريق المبيعات
        $salesPermissions = [
            [
                'name' => 'sales.dashboard',
                'display_name' => 'لوحة التحكم',
                'description' => 'لوحة تحكم فريق المبيعات',
                'module' => 'dashboard',
                'user_type' => 'sales'
            ],
            [
                'name' => 'sales.orders',
                'display_name' => 'الطلبات',
                'description' => 'إدارة الطلبات',
                'module' => 'orders',
                'user_type' => 'sales'
            ],
            [
                'name' => 'sales.importer-orders',
                'display_name' => 'طلبات المستوردين',
                'description' => 'إدارة طلبات المستوردين',
                'module' => 'orders',
                'user_type' => 'sales'
            ],
            [
                'name' => 'sales.importers',
                'display_name' => 'المستوردين',
                'description' => 'إدارة المستوردين',
                'module' => 'importers',
                'user_type' => 'sales'
            ],
            [
                'name' => 'sales.contacts',
                'display_name' => 'رسائل التواصل',
                'description' => 'عرض رسائل التواصل',
                'module' => 'contacts',
                'user_type' => 'sales'
            ],
            [
                'name' => 'sales.reports',
                'display_name' => 'التقارير',
                'description' => 'تقارير المبيعات',
                'module' => 'reports',
                'user_type' => 'sales'
            ],
            [
                'name' => 'sales.profile',
                'display_name' => 'الملف الشخصي',
                'description' => 'الملف الشخصي',
                'module' => 'profile',
                'user_type' => 'sales'
            ],
        ];

        // صلاحيات فريق التسويق
        $marketingPermissions = [
            [
                'name' => 'marketing.dashboard',
                'display_name' => 'لوحة التحكم',
                'description' => 'لوحة تحكم فريق التسويق',
                'module' => 'dashboard',
                'user_type' => 'marketing'
            ],
            [
                'name' => 'marketing.portfolio',
                'display_name' => 'معرض الأعمال',
                'description' => 'إدارة معرض الأعمال',
                'module' => 'content',
                'user_type' => 'marketing'
            ],
            [
                'name' => 'marketing.testimonials',
                'display_name' => 'التقييمات',
                'description' => 'إدارة تقييمات العملاء',
                'module' => 'content',
                'user_type' => 'marketing'
            ],
            [
                'name' => 'marketing.tasks',
                'display_name' => 'المهام',
                'description' => 'إدارة المهام',
                'module' => 'tasks',
                'user_type' => 'marketing'
            ],
            [
                'name' => 'marketing.contacts',
                'display_name' => 'رسائل التواصل',
                'description' => 'عرض رسائل التواصل',
                'module' => 'contacts',
                'user_type' => 'marketing'
            ],
            [
                'name' => 'marketing.profile',
                'display_name' => 'الملف الشخصي',
                'description' => 'الملف الشخصي',
                'module' => 'profile',
                'user_type' => 'marketing'
            ],
        ];

        // صلاحيات المستوردين
        $importerPermissions = [
            [
                'name' => 'importer.dashboard',
                'display_name' => 'لوحة التحكم',
                'description' => 'لوحة تحكم المستورد',
                'module' => 'dashboard',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.orders',
                'display_name' => 'الطلبات',
                'description' => 'إدارة الطلبات',
                'module' => 'orders',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.tracking',
                'display_name' => 'تتبع الطلبات',
                'description' => 'تتبع حالة الطلبات',
                'module' => 'orders',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.invoices',
                'display_name' => 'الفواتير',
                'description' => 'عرض وإدارة الفواتير',
                'module' => 'orders',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.payment-methods',
                'display_name' => 'طرق الدفع',
                'description' => 'إدارة طرق الدفع',
                'module' => 'profile',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.notifications',
                'display_name' => 'الإشعارات',
                'description' => 'عرض الإشعارات',
                'module' => 'notifications',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.help',
                'display_name' => 'المساعدة',
                'description' => 'صفحة المساعدة',
                'module' => 'support',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.support',
                'display_name' => 'الدعم الفني',
                'description' => 'الدعم الفني',
                'module' => 'support',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.contact',
                'display_name' => 'التواصل معنا',
                'description' => 'التواصل مع الشركة',
                'module' => 'support',
                'user_type' => 'importer'
            ],
            [
                'name' => 'importer.profile',
                'display_name' => 'الملف الشخصي',
                'description' => 'الملف الشخصي',
                'module' => 'profile',
                'user_type' => 'importer'
            ],
        ];

        // دمج جميع الصلاحيات
        $allPermissions = array_merge(
            $adminPermissions,
            $salesPermissions,
            $marketingPermissions,
            $importerPermissions
        );

        // إنشاء الصلاحيات
        foreach ($allPermissions as $permission) {
            Permission::create(array_merge($permission, ['is_active' => true]));
        }

        // إنشاء الأدوار مع الصلاحيات المناسبة
        $roles = [
            'admin' => array_merge(
                array_column($adminPermissions, 'name'),
                array_column($salesPermissions, 'name'),
                array_column($marketingPermissions, 'name'),
                array_column($importerPermissions, 'name')
            ),
            'sales' => array_column($salesPermissions, 'name'),
            'marketing' => array_column($marketingPermissions, 'name'),
            'importer' => array_column($importerPermissions, 'name'),
        ];

        foreach ($roles as $roleName => $permissions) {
            $role = Role::firstOrCreate(
                ['name' => $roleName],
                [
                    'display_name' => ucfirst($roleName),
                    'description' => "دور {$roleName}"
                ]
            );

            // ربط الصلاحيات بالدور
            $permissionIds = Permission::whereIn('name', $permissions)->pluck('id')->toArray();
            $role->permissions()->sync($permissionIds);
        }

        $this->command->info('تم إنشاء الصلاحيات بنجاح!');
    }
}
