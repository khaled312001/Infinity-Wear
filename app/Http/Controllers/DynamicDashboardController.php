<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;

class DynamicDashboardController extends Controller
{
    /**
     * Show dynamic dashboard based on user permissions
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get user permissions
        $permissions = $this->getUserPermissions($user);
        
        // Get sidebar menu items based on permissions
        $sidebarItems = $this->getSidebarItems($permissions);
        
        // Get dashboard widgets based on permissions
        $widgets = $this->getDashboardWidgets($permissions);
        
        return view('dynamic-dashboard', compact('permissions', 'sidebarItems', 'widgets', 'user'));
    }
    
    /**
     * Get user permissions (direct + role permissions)
     */
    private function getUserPermissions($user)
    {
        $permissions = collect();
        
        // Get direct permissions
        $directPermissions = $user->permissions;
        $permissions = $permissions->merge($directPermissions);
        
        // Get role permissions
        foreach ($user->roles as $role) {
            $rolePermissions = $role->permissions;
            $permissions = $permissions->merge($rolePermissions);
        }
        
        return $permissions->unique('id');
    }
    
    /**
     * Get sidebar items based on permissions
     */
    private function getSidebarItems($permissions)
    {
        $sidebarItems = [];
        
        // Define menu structure with required permissions
        $menuStructure = [
            'dashboard' => [
                'title' => 'لوحة التحكم',
                'icon' => 'fas fa-tachometer-alt',
                'route' => 'dashboard',
                'permissions' => ['dashboard.view']
            ],
            'notifications' => [
                'title' => 'الإشعارات',
                'icon' => 'fas fa-bell',
                'route' => 'notifications.index',
                'permissions' => ['admin.notifications', 'notifications.view']
            ],
            'contacts' => [
                'title' => 'رسائل التواصل',
                'icon' => 'fas fa-envelope',
                'route' => 'admin.contacts.index',
                'permissions' => ['admin.contacts']
            ],
            'whatsapp' => [
                'title' => 'رسائل الواتساب',
                'icon' => 'fab fa-whatsapp',
                'route' => 'admin.whatsapp.index',
                'permissions' => ['admin.whatsapp']
            ],
            'services' => [
                'title' => 'إدارة الخدمات',
                'icon' => 'fas fa-cogs',
                'route' => 'admin.services.index',
                'permissions' => ['admin.services']
            ],
            'portfolio' => [
                'title' => 'معرض الأعمال',
                'icon' => 'fas fa-images',
                'route' => 'admin.portfolio.index',
                'permissions' => ['admin.portfolio']
            ],
            'testimonials' => [
                'title' => 'التقييمات',
                'icon' => 'fas fa-star',
                'route' => 'admin.testimonials.index',
                'permissions' => ['admin.testimonials']
            ],
            'importers' => [
                'title' => 'المستوردين',
                'icon' => 'fas fa-industry',
                'route' => 'admin.importers.index',
                'permissions' => ['admin.importers']
            ],
            'importer_orders' => [
                'title' => 'طلبات المستوردين',
                'icon' => 'fas fa-shopping-bag',
                'route' => 'admin.importers.orders',
                'permissions' => ['admin.importers.orders']
            ],
            'tasks' => [
                'title' => 'المهام',
                'icon' => 'fas fa-tasks',
                'route' => 'admin.tasks.index',
                'permissions' => ['admin.tasks']
            ],
            'company_plans' => [
                'title' => 'خطط الشركة',
                'icon' => 'fas fa-chart-line',
                'route' => 'admin.company-plans.index',
                'permissions' => ['admin.company_plans']
            ],
            'financial' => [
                'title' => 'لوحة المالية',
                'icon' => 'fas fa-chart-pie',
                'route' => 'admin.financial.dashboard',
                'permissions' => ['admin.financial']
            ],
            'transactions' => [
                'title' => 'المعاملات المالية',
                'icon' => 'fas fa-money-bill-wave',
                'route' => 'admin.financial.transactions',
                'permissions' => ['admin.financial.transactions']
            ],
            'financial_reports' => [
                'title' => 'التقارير المالية',
                'icon' => 'fas fa-chart-bar',
                'route' => 'admin.financial.reports',
                'permissions' => ['admin.financial.reports']
            ],
            'marketing_team' => [
                'title' => 'فريق التسويق',
                'icon' => 'fas fa-bullhorn',
                'route' => 'admin.marketing.team',
                'permissions' => ['admin.marketing.team']
            ],
            'sales_team' => [
                'title' => 'فريق المبيعات',
                'icon' => 'fas fa-handshake',
                'route' => 'admin.sales.team',
                'permissions' => ['admin.sales.team']
            ],
            'users' => [
                'title' => 'إدارة المستخدمين',
                'icon' => 'fas fa-users',
                'route' => 'admin.users.index',
                'permissions' => ['admin.users']
            ],
            'customer_notes' => [
                'title' => 'ملاحظات العملاء',
                'icon' => 'fas fa-sticky-note',
                'route' => 'admin.customer-notes.index',
                'permissions' => ['admin.customer_notes']
            ],
            'reports' => [
                'title' => 'التقارير',
                'icon' => 'fas fa-chart-bar',
                'route' => 'admin.reports',
                'permissions' => ['admin.reports']
            ],
            'settings' => [
                'title' => 'الإعدادات',
                'icon' => 'fas fa-cog',
                'route' => 'admin.settings',
                'permissions' => ['admin.settings']
            ],
            'permissions' => [
                'title' => 'الأدوار والصلاحيات',
                'icon' => 'fas fa-shield-alt',
                'route' => 'admin.permissions.index',
                'permissions' => ['admin.permissions']
            ],
            'admins' => [
                'title' => 'إدارة المديرين',
                'icon' => 'fas fa-user-shield',
                'route' => 'admin.admins.index',
                'permissions' => ['admin.admins']
            ],
            'profile' => [
                'title' => 'الملف الشخصي',
                'icon' => 'fas fa-user-cog',
                'route' => 'admin.profile',
                'permissions' => ['admin.profile']
            ]
        ];
        
        // Filter menu items based on user permissions
        foreach ($menuStructure as $key => $item) {
            if ($this->hasAnyPermission($permissions, $item['permissions'])) {
                $sidebarItems[$key] = $item;
            }
        }
        
        return $sidebarItems;
    }
    
    /**
     * Get dashboard widgets based on permissions
     */
    private function getDashboardWidgets($permissions)
    {
        $widgets = [];
        
        // Define widgets with required permissions
        $widgetDefinitions = [
            'notifications_widget' => [
                'title' => 'الإشعارات الحديثة',
                'permissions' => ['admin.notifications', 'notifications.view']
            ],
            'contacts_widget' => [
                'title' => 'رسائل التواصل الجديدة',
                'permissions' => ['admin.contacts']
            ],
            'whatsapp_widget' => [
                'title' => 'رسائل الواتساب',
                'permissions' => ['admin.whatsapp']
            ],
            'tasks_widget' => [
                'title' => 'المهام المعلقة',
                'permissions' => ['admin.tasks']
            ],
            'financial_widget' => [
                'title' => 'الملخص المالي',
                'permissions' => ['admin.financial']
            ],
            'reports_widget' => [
                'title' => 'التقارير السريعة',
                'permissions' => ['admin.reports']
            ]
        ];
        
        // Filter widgets based on user permissions
        foreach ($widgetDefinitions as $key => $widget) {
            if ($this->hasAnyPermission($permissions, $widget['permissions'])) {
                $widgets[$key] = $widget;
            }
        }
        
        return $widgets;
    }
    
    /**
     * Check if user has any of the required permissions
     */
    private function hasAnyPermission($permissions, $requiredPermissions)
    {
        $permissionNames = $permissions->pluck('name')->toArray();
        
        foreach ($requiredPermissions as $requiredPermission) {
            if (in_array($requiredPermission, $permissionNames)) {
                return true;
            }
        }
        
        return false;
    }
}
