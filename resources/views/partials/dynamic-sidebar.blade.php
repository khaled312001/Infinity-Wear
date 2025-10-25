<!-- Simple Admin Sidebar -->

<!-- الرئيسية -->
<div class="nav-group">
    <div class="nav-group-title">الرئيسية</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt me-2"></i>
        لوحة التحكم
    </a>
    <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ request()->routeIs('admin.notifications*') ? 'active' : '' }}" style="position: relative;">
        <i class="fas fa-bell me-2"></i>
        الإشعارات
        <span class="notification-badge" id="sidebarNotificationsBadge" style="display: none;">0</span>
    </a>
    <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}">
        <i class="fas fa-address-book me-2"></i>
        رسائل التواصل
    </a>
    <a href="{{ route('admin.whatsapp.index') }}" class="nav-link {{ request()->routeIs('admin.whatsapp*') ? 'active' : '' }}">
        <i class="fas fa-comments me-2"></i>
        رسائل الواتساب
    </a>
    @if (\Illuminate\Support\Facades\Route::has('admin.support'))
    <a href="{{ route('admin.support') }}" class="nav-link {{ request()->routeIs('admin.support') ? 'active' : '' }}" target="_self">
        <i class="fas fa-life-ring me-2"></i>
        الدعم الفني
    </a>
    @endif
</div>

<!-- إدارة المحتوى -->
<div class="nav-group">
    <div class="nav-group-title">إدارة المحتوى</div>
    @if (\Illuminate\Support\Facades\Route::has('admin.services.index'))
    <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
        <i class="fas fa-cogs me-2"></i>
        إدارة الخدمات
    </a>
    @endif
    @if (\Illuminate\Support\Facades\Route::has('admin.portfolio.index'))
    <a href="{{ route('admin.portfolio.index') }}" class="nav-link {{ request()->routeIs('admin.portfolio*') ? 'active' : '' }}">
        <i class="fas fa-images me-2"></i>
        معرض الأعمال
    </a>
    @endif
    @if (\Illuminate\Support\Facades\Route::has('admin.testimonials.index'))
    <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
        <i class="fas fa-star me-2"></i>
        التقييمات
    </a>
    @endif
</div>

<!-- إدارة المستوردين -->
<div class="nav-group">
    <div class="nav-group-title">إدارة المستوردين</div>
    <a href="{{ route('admin.importers.index') }}" class="nav-link {{ request()->routeIs('admin.importers*') ? 'active' : '' }}">
        <i class="fas fa-industry me-2"></i>
        المستوردين
    </a>
    <a href="{{ route('admin.importers.orders') }}" class="nav-link {{ request()->routeIs('admin.importers.orders*') ? 'active' : '' }}">
        <i class="fas fa-shopping-bag me-2"></i>
        طلبات المستوردين
    </a>
</div>

<!-- إدارة المهام -->
@if (\Illuminate\Support\Facades\Route::has('admin.tasks.index'))
<div class="nav-group">
    <div class="nav-group-title">إدارة المهام</div>
    <a href="{{ route('admin.tasks.index') }}" class="nav-link {{ request()->routeIs('admin.tasks*') ? 'active' : '' }}">
        <i class="fas fa-tasks me-2"></i>
        المهام
    </a>
</div>
@endif

<!-- إدارة النظام -->
<div class="nav-group">
    <div class="nav-group-title">إدارة النظام</div>
    <a href="{{ route('admin.reports') }}" class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
        <i class="fas fa-chart-bar me-2"></i>
        التقارير
    </a>
    <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
        <i class="fas fa-cog me-2"></i>
        الإعدادات
    </a>
    @if (\Illuminate\Support\Facades\Route::has('admin.permissions.index'))
    <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->routeIs('admin.permissions*') ? 'active' : '' }}">
        <i class="fas fa-shield-alt me-2"></i>
        الأدوار والصلاحيات
    </a>
    @endif
    <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins*') ? 'active' : '' }}">
        <i class="fas fa-user-shield me-2"></i>
        إدارة المديرين
    </a>
</div>