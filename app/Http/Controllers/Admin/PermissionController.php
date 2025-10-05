<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Display the permissions management page
     */
    public function index()
    {
        // Define available permissions for each user type
        $permissions = [
            'admin' => [
                'dashboard' => 'الوصول للوحة التحكم',
                'users_management' => 'إدارة المستخدمين',
                'admins_management' => 'إدارة الإداريين',
                'importers_management' => 'إدارة المستوردين',
                'sales_management' => 'إدارة فريق المبيعات',
                'marketing_management' => 'إدارة فريق التسويق',
                'orders_management' => 'إدارة الطلبات',
                'categories_management' => 'إدارة الفئات',
                'content_management' => 'إدارة المحتوى',
                'portfolio_management' => 'إدارة معرض الأعمال',
                'testimonials_management' => 'إدارة التقييمات',
                'tasks_management' => 'إدارة المهام',
                'finance_management' => 'إدارة النظام المالي',
                'reports_access' => 'الوصول للتقارير',
                'settings_access' => 'إعدادات النظام',
                'permissions_management' => 'إدارة الصلاحيات',
                'seo_management' => 'إدارة SEO',
                'hero_slider_management' => 'إدارة السلايدر الرئيسي',
                'home_sections_management' => 'إدارة أقسام الصفحة الرئيسية'
            ],
            'importer' => [
                'dashboard' => 'الوصول للوحة التحكم',
                'profile_management' => 'إدارة الملف الشخصي',
                'orders_view' => 'عرض الطلبات',
                'orders_create' => 'إنشاء طلبات جديدة',
                'orders_edit' => 'تعديل الطلبات',
                'orders_delete' => 'حذف الطلبات',
                'custom_designs_create' => 'إنشاء تصميمات مخصصة',
                'portfolio_view' => 'عرض معرض الأعمال',
                'testimonials_create' => 'إنشاء شهادات',
                'reports_view' => 'عرض التقارير الخاصة',
                'notifications_access' => 'الوصول للإشعارات'
            ],
            'sales' => [
                'dashboard' => 'الوصول للوحة التحكم',
                'profile_management' => 'إدارة الملف الشخصي',
                'orders_view' => 'عرض الطلبات',
                'orders_create' => 'إنشاء طلبات جديدة',
                'orders_edit' => 'تعديل الطلبات',
                'customers_management' => 'إدارة العملاء',
                'leads_management' => 'إدارة العملاء المحتملين',
                'sales_reports' => 'تقارير المبيعات',
                'targets_management' => 'إدارة الأهداف',
                'portfolio_view' => 'عرض معرض الأعمال',
                'notifications_access' => 'الوصول للإشعارات',
                'tasks_view' => 'عرض المهام المخصصة',
                'tasks_update' => 'تحديث حالة المهام'
            ],
            'marketing' => [
                'dashboard' => 'الوصول للوحة التحكم',
                'profile_management' => 'إدارة الملف الشخصي',
                'content_creation' => 'إنشاء المحتوى',
                'social_media_management' => 'إدارة وسائل التواصل الاجتماعي',
                'campaigns_management' => 'إدارة الحملات التسويقية',
                'leads_management' => 'إدارة العملاء المحتملين',
                'marketing_reports' => 'تقارير التسويق',
                'portfolio_management' => 'إدارة معرض الأعمال',
                'testimonials_management' => 'إدارة التقييمات',
                'seo_management' => 'إدارة SEO',
                'hero_slider_management' => 'إدارة السلايدر الرئيسي',
                'home_sections_management' => 'إدارة أقسام الصفحة الرئيسية',
                'notifications_access' => 'الوصول للإشعارات',
                'tasks_view' => 'عرض المهام المخصصة',
                'tasks_update' => 'تحديث حالة المهام'
            ]
        ];

        // Get current permissions from database (if exists)
        $currentPermissions = $this->getCurrentPermissions();

        return view('admin.permissions.index', compact('permissions', 'currentPermissions'));
    }

    /**
     * Update permissions for user types
     */
    public function update(Request $request)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'array'
        ]);

        try {
            DB::beginTransaction();

            // Clear existing permissions
            DB::table('user_type_permissions')->truncate();

            // Insert new permissions
            foreach ($request->permissions as $userType => $userPermissions) {
                foreach ($userPermissions as $permission => $enabled) {
                    if ($enabled) {
                        DB::table('user_type_permissions')->insert([
                            'user_type' => $userType,
                            'permission' => $permission,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.permissions.index')
                ->with('success', 'تم تحديث الصلاحيات بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.permissions.index')
                ->with('error', 'حدث خطأ أثناء تحديث الصلاحيات: ' . $e->getMessage());
        }
    }

    /**
     * Get current permissions from database
     */
    private function getCurrentPermissions()
    {
        try {
            $permissions = DB::table('user_type_permissions')
                ->select('user_type', 'permission')
                ->get()
                ->groupBy('user_type')
                ->map(function ($group) {
                    return $group->pluck('permission')->toArray();
                })
                ->toArray();

            return $permissions;
        } catch (\Exception $e) {
            // If table doesn't exist, return empty array
            return [];
        }
    }

    /**
     * Reset permissions to default
     */
    public function reset()
    {
        try {
            DB::beginTransaction();

            // Clear existing permissions
            DB::table('user_type_permissions')->truncate();

            // Set default permissions
            $defaultPermissions = [
                'admin' => [
                    'dashboard', 'users_management', 'admins_management', 'importers_management',
                    'sales_management', 'marketing_management', 'orders_management', 
                    'categories_management', 'content_management', 'portfolio_management', 
                    'testimonials_management', 'tasks_management', 'finance_management',
                    'reports_access', 'settings_access', 'permissions_management', 
                    'seo_management', 'hero_slider_management', 'home_sections_management'
                ],
                'importer' => [
                    'dashboard', 'profile_management', 'orders_view', 'orders_create',
                    'orders_edit', 'orders_delete', 'custom_designs_create', 'portfolio_view', 
                    'testimonials_create', 'reports_view', 'notifications_access'
                ],
                'sales' => [
                    'dashboard', 'profile_management', 'orders_view', 'orders_create',
                    'orders_edit', 'customers_management', 'leads_management', 'sales_reports',
                    'targets_management', 'portfolio_view', 'notifications_access',
                    'tasks_view', 'tasks_update'
                ],
                'marketing' => [
                    'dashboard', 'profile_management', 'content_creation', 'social_media_management',
                    'campaigns_management', 'leads_management', 'marketing_reports',
                    'portfolio_management', 'testimonials_management', 'seo_management',
                    'hero_slider_management', 'home_sections_management', 'notifications_access',
                    'tasks_view', 'tasks_update'
                ]
            ];

            foreach ($defaultPermissions as $userType => $permissions) {
                foreach ($permissions as $permission) {
                    DB::table('user_type_permissions')->insert([
                        'user_type' => $userType,
                        'permission' => $permission,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.permissions.index')
                ->with('success', 'تم إعادة تعيين الصلاحيات للقيم الافتراضية');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.permissions.index')
                ->with('error', 'حدث خطأ أثناء إعادة تعيين الصلاحيات: ' . $e->getMessage());
        }
    }
}