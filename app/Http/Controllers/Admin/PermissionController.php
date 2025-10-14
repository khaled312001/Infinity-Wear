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
        // Define available permissions for each user type based on actual sidebar pages
        $permissions = [
            'admin' => [
                // الرئيسية
                'dashboard' => 'الوصول للوحة التحكم',
                'notifications' => 'الإشعارات',
                'contacts' => 'رسائل التواصل',
                'whatsapp' => 'رسائل الواتساب',
                
                // إدارة المحتوى
                'services_management' => 'إدارة الخدمات',
                'portfolio_management' => 'معرض الأعمال',
                'testimonials_management' => 'التقييمات',
                
                // إدارة المستوردين
                'importers_management' => 'المستوردين',
                'importers_orders' => 'طلبات المستوردين',
                
                // إدارة المهام
                'tasks_management' => 'المهام',
                
                // إدارة المالية
                'finance_dashboard' => 'لوحة المالية',
                'finance_transactions' => 'المعاملات المالية',
                'finance_reports' => 'التقارير المالية',
                
                // إدارة الفرق
                'marketing_team_management' => 'فريق التسويق',
                'sales_team_management' => 'فريق المبيعات',
                
                // إدارة العملاء
                'customer_notes' => 'ملاحظات العملاء',
                
                // إدارة النظام
                'reports' => 'التقارير',
                'settings' => 'الإعدادات',
                'permissions_management' => 'الأدوار والصلاحيات',
                'admins_management' => 'إدارة المديرين',
                'profile' => 'الملف الشخصي'
            ],
            'importer' => [
                // الرئيسية
                'dashboard' => 'الوصول للوحة التحكم',
                
                // إدارة الطلبات
                'orders' => 'طلباتي',
                'tracking' => 'تتبع الشحنات',
                'invoices' => 'الفواتير',
                
                // إدارة الحساب
                'profile' => 'الملف الشخصي',
                'payment_methods' => 'طرق الدفع',
                'notifications' => 'الإشعارات',
                
                // الدعم والمساعدة
                'help' => 'المساعدة',
                'support' => 'الدعم الفني',
                'contact' => 'التواصل معنا'
            ],
            'sales' => [
                // الرئيسية
                'dashboard' => 'الوصول للوحة التحكم',
                
                // إدارة الطلبات
                'orders' => 'طلبات العملاء',
                'importer_orders' => 'طلبات المستوردين',
                
                // إدارة المستوردين
                'importers' => 'المستوردين',
                
                // إدارة المهام
                'tasks' => 'المهام',
                
                // إدارة التواصل
                'contacts' => 'جهات الاتصال',
                
                // التقارير
                'reports' => 'التقارير',
                
                // إدارة الحساب
                'profile' => 'الملف الشخصي'
            ],
            'marketing' => [
                // الرئيسية
                'dashboard' => 'الوصول للوحة التحكم',
                
                // إدارة المحتوى
                'portfolio' => 'معرض الأعمال',
                'testimonials' => 'التقييمات',
                
                // إدارة المهام
                'tasks' => 'المهام',
                
                // إدارة التواصل
                'contacts' => 'جهات الاتصال',
                
                // إدارة الحساب
                'profile' => 'الملف الشخصي'
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

            // Set default permissions based on actual sidebar pages
            $defaultPermissions = [
                'admin' => [
                    'dashboard', 'notifications', 'contacts', 'whatsapp',
                    'services_management', 'portfolio_management', 'testimonials_management',
                    'importers_management', 'importers_orders', 'tasks_management',
                    'finance_dashboard', 'finance_transactions', 'finance_reports',
                    'marketing_team_management', 'sales_team_management', 'customer_notes',
                    'reports', 'settings', 'permissions_management', 'admins_management', 'profile'
                ],
                'importer' => [
                    'dashboard', 'orders', 'tracking', 'invoices',
                    'profile', 'payment_methods', 'notifications',
                    'help', 'support', 'contact'
                ],
                'sales' => [
                    'dashboard', 'orders', 'importer_orders', 'importers',
                    'tasks', 'contacts', 'reports', 'profile'
                ],
                'marketing' => [
                    'dashboard', 'portfolio', 'testimonials', 'tasks',
                    'contacts', 'profile'
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