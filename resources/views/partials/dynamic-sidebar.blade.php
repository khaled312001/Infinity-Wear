<!-- Dynamic Sidebar Based on User Permissions -->
@php
    $user = auth()->user();
    $permissions = collect();
    
    // Get direct permissions
    $directPermissions = $user->permissions;
    $permissions = $permissions->merge($directPermissions);
    
    // Get role permissions
    foreach ($user->roles as $role) {
        $rolePermissions = $role->permissions;
        $permissions = $permissions->merge($rolePermissions);
    }
    
    $permissions = $permissions->unique('id');
    
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
    $sidebarItems = [];
    $permissionNames = $permissions->pluck('name')->toArray();
    
    foreach ($menuStructure as $key => $item) {
        $hasPermission = false;
        foreach ($item['permissions'] as $requiredPermission) {
            if (in_array($requiredPermission, $permissionNames)) {
                $hasPermission = true;
                break;
            }
        }
        
        if ($hasPermission) {
            $sidebarItems[$key] = $item;
        }
    }
@endphp

<!-- إدارة المحتوى -->
@if(isset($sidebarItems['services']) || isset($sidebarItems['portfolio']) || isset($sidebarItems['testimonials']))
<div class="nav-group">
    <div class="nav-group-title">إدارة المحتوى</div>
    @if(isset($sidebarItems['services']))
    <a href="{{ route($sidebarItems['services']['route']) }}" class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['services']['icon'] }} me-2"></i>
        {{ $sidebarItems['services']['title'] }}
    </a>
    @endif
    @if(isset($sidebarItems['portfolio']))
    <a href="{{ route($sidebarItems['portfolio']['route']) }}" class="nav-link {{ request()->routeIs('admin.portfolio*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['portfolio']['icon'] }} me-2"></i>
        {{ $sidebarItems['portfolio']['title'] }}
    </a>
    @endif
    @if(isset($sidebarItems['testimonials']))
    <a href="{{ route($sidebarItems['testimonials']['route']) }}" class="nav-link {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['testimonials']['icon'] }} me-2"></i>
        {{ $sidebarItems['testimonials']['title'] }}
    </a>
    @endif
</div>
@endif

<!-- إدارة المستوردين -->
@if(isset($sidebarItems['importers']) || isset($sidebarItems['importer_orders']))
<div class="nav-group">
    <div class="nav-group-title">إدارة المستوردين</div>
    @if(isset($sidebarItems['importers']))
    <a href="{{ route($sidebarItems['importers']['route']) }}" class="nav-link {{ request()->routeIs('admin.importers*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['importers']['icon'] }} me-2"></i>
        {{ $sidebarItems['importers']['title'] }}
    </a>
    @endif
    @if(isset($sidebarItems['importer_orders']))
    <a href="{{ route($sidebarItems['importer_orders']['route']) }}" class="nav-link {{ request()->routeIs('admin.importers.orders*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['importer_orders']['icon'] }} me-2"></i>
        {{ $sidebarItems['importer_orders']['title'] }}
    </a>
    @endif
</div>
@endif

<!-- إدارة المهام -->
@if(isset($sidebarItems['tasks']) || isset($sidebarItems['company_plans']))
<div class="nav-group">
    <div class="nav-group-title">إدارة المهام</div>
    @if(isset($sidebarItems['tasks']))
    <a href="{{ route($sidebarItems['tasks']['route']) }}" class="nav-link {{ request()->routeIs('admin.tasks*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['tasks']['icon'] }} me-2"></i>
        {{ $sidebarItems['tasks']['title'] }}
    </a>
    @endif
    @if(isset($sidebarItems['company_plans']))
    <a href="{{ route($sidebarItems['company_plans']['route']) }}" class="nav-link {{ request()->routeIs('admin.company-plans*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['company_plans']['icon'] }} me-2"></i>
        {{ $sidebarItems['company_plans']['title'] }}
    </a>
    @endif
</div>
@endif

<!-- إدارة المالية -->
@if(isset($sidebarItems['financial']) || isset($sidebarItems['transactions']) || isset($sidebarItems['financial_reports']))
<div class="nav-group">
    <div class="nav-group-title">إدارة المالية</div>
    @if(isset($sidebarItems['financial']))
    <a href="{{ route($sidebarItems['financial']['route']) }}" class="nav-link {{ request()->routeIs('admin.financial*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['financial']['icon'] }} me-2"></i>
        {{ $sidebarItems['financial']['title'] }}
    </a>
    @endif
    @if(isset($sidebarItems['transactions']))
    <a href="{{ route($sidebarItems['transactions']['route']) }}" class="nav-link {{ request()->routeIs('admin.financial.transactions*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['transactions']['icon'] }} me-2"></i>
        {{ $sidebarItems['transactions']['title'] }}
    </a>
    @endif
    @if(isset($sidebarItems['financial_reports']))
    <a href="{{ route($sidebarItems['financial_reports']['route']) }}" class="nav-link {{ request()->routeIs('admin.financial.reports*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['financial_reports']['icon'] }} me-2"></i>
        {{ $sidebarItems['financial_reports']['title'] }}
    </a>
    @endif
</div>
@endif

<!-- إدارة الفرق -->
@if(isset($sidebarItems['marketing_team']) || isset($sidebarItems['sales_team']))
<div class="nav-group">
    <div class="nav-group-title">إدارة الفرق</div>
    @if(isset($sidebarItems['marketing_team']))
    <a href="{{ route($sidebarItems['marketing_team']['route']) }}" class="nav-link {{ request()->routeIs('admin.marketing*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['marketing_team']['icon'] }} me-2"></i>
        {{ $sidebarItems['marketing_team']['title'] }}
    </a>
    @endif
    @if(isset($sidebarItems['sales_team']))
    <a href="{{ route($sidebarItems['sales_team']['route']) }}" class="nav-link {{ request()->routeIs('admin.sales*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['sales_team']['icon'] }} me-2"></i>
        {{ $sidebarItems['sales_team']['title'] }}
    </a>
    @endif
</div>
@endif

<!-- إدارة العملاء -->
@if(isset($sidebarItems['users']) || isset($sidebarItems['customer_notes']))
<div class="nav-group">
    <div class="nav-group-title">إدارة العملاء</div>
    @if(isset($sidebarItems['users']))
    <a href="{{ route($sidebarItems['users']['route']) }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['users']['icon'] }} me-2"></i>
        {{ $sidebarItems['users']['title'] }}
    </a>
    @endif
    @if(isset($sidebarItems['customer_notes']))
    <a href="{{ route($sidebarItems['customer_notes']['route']) }}" class="nav-link {{ request()->routeIs('admin.customer-notes*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['customer_notes']['icon'] }} me-2"></i>
        {{ $sidebarItems['customer_notes']['title'] }}
    </a>
    @endif
</div>
@endif

<!-- إدارة النظام -->
@if(isset($sidebarItems['reports']) || isset($sidebarItems['settings']) || isset($sidebarItems['permissions']) || isset($sidebarItems['admins']) || isset($sidebarItems['profile']))
<div class="nav-group">
    <div class="nav-group-title">إدارة النظام</div>
    @if(isset($sidebarItems['reports']))
    <a href="{{ route($sidebarItems['reports']['route']) }}" class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['reports']['icon'] }} me-2"></i>
        {{ $sidebarItems['reports']['title'] }}
    </a>
    @endif
    @if(isset($sidebarItems['settings']))
    <a href="{{ route($sidebarItems['settings']['route']) }}" class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['settings']['icon'] }} me-2"></i>
        {{ $sidebarItems['settings']['title'] }}
    </a>
    @endif
    @if(isset($sidebarItems['permissions']))
    <a href="{{ route($sidebarItems['permissions']['route']) }}" class="nav-link {{ request()->routeIs('admin.permissions*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['permissions']['icon'] }} me-2"></i>
        {{ $sidebarItems['permissions']['title'] }}
    </a>
    @endif
    @if(isset($sidebarItems['admins']))
    <a href="{{ route($sidebarItems['admins']['route']) }}" class="nav-link {{ request()->routeIs('admin.admins*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['admins']['icon'] }} me-2"></i>
        {{ $sidebarItems['admins']['title'] }}
    </a>
    @endif
    @if(isset($sidebarItems['profile']))
    <a href="{{ route($sidebarItems['profile']['route']) }}" class="nav-link {{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
        <i class="{{ $sidebarItems['profile']['icon'] }} me-2"></i>
        {{ $sidebarItems['profile']['title'] }}
    </a>
    @endif
</div>
@endif
