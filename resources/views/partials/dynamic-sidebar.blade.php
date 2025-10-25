<!-- الرئيسية -->
<div class="nav-group">
    <div class="nav-group-title">الرئيسية</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt me-2"></i>
        لوحة التحكم
    </a>
    <a href="{{ route('admin.notifications.index') }}" class="nav-link {{ request()->routeIs('admin.notifications.index') ? 'active' : '' }}" style="position: relative;">
        <i class="fas fa-bell me-2"></i>
        الإشعارات
        <span class="notification-badge" id="sidebarNotificationsBadge" style="display: none;">0</span>
    </a>
    {{-- Removed old notifications link to prevent route errors --}}
    <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}">
        <i class="fas fa-address-book me-2"></i>
        رسائل التواصل    </a>
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
    <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
        <i class="fas fa-cogs me-2"></i>
        إدارة الخدمات
    </a>
    <a href="{{ route('admin.portfolio.index') }}" class="nav-link {{ request()->routeIs('admin.portfolio*') ? 'active' : '' }}">
        <i class="fas fa-images me-2"></i>
        معرض الأعمال
    </a>
    <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
        <i class="fas fa-star me-2"></i>
        التقييمات
    </a>
  
  
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
<div class="nav-group">
    <div class="nav-group-title">إدارة المهام</div>
    <a href="{{ route('admin.tasks.index') }}" class="nav-link {{ request()->routeIs('admin.tasks*') ? 'active' : '' }}">
        <i class="fas fa-tasks me-2"></i>
        المهام
    </a>
    <a href="{{ route('admin.company-plans.index') }}" class="nav-link {{ request()->routeIs('admin.company-plans*') ? 'active' : '' }}">
        <i class="fas fa-chart-line me-2"></i>
        خطط الشركة
    </a>
</div>

<!-- إدارة المالية -->
@if (\Illuminate\Support\Facades\Route::has('admin.financial.dashboard'))
<div class="nav-group">
    <div class="nav-group-title">إدارة المالية</div>
    <a href="{{ route('admin.financial.dashboard') }}" class="nav-link {{ request()->routeIs('admin.financial.dashboard*') ? 'active' : '' }}">
        <i class="fas fa-chart-pie me-2"></i>
        لوحة المالية
    </a>
    @if (\Illuminate\Support\Facades\Route::has('admin.financial.transactions'))
    <a href="{{ route('admin.financial.transactions') }}" class="nav-link {{ request()->routeIs('admin.financial.transactions*') ? 'active' : '' }}">
        <i class="fas fa-money-bill-wave me-2"></i>
        المعاملات المالية
    </a>
    @endif
    @if (\Illuminate\Support\Facades\Route::has('admin.financial.reports'))
    <a href="{{ route('admin.financial.reports') }}" class="nav-link {{ request()->routeIs('admin.financial.reports*') ? 'active' : '' }}">
        <i class="fas fa-chart-bar me-2"></i>
        التقارير المالية
    </a>
    @endif
</div>
@endif

<!-- إدارة الفرق -->
@if (\Illuminate\Support\Facades\Route::has('admin.marketing.team') || \Illuminate\Support\Facades\Route::has('admin.sales.team'))
<div class="nav-group">
    <div class="nav-group-title">إدارة الفرق</div>
    @if (\Illuminate\Support\Facades\Route::has('admin.marketing.team'))
    <a href="{{ route('admin.marketing.team') }}" class="nav-link {{ request()->routeIs('admin.marketing*') ? 'active' : '' }}">
        <i class="fas fa-bullhorn me-2"></i>
        فريق التسويق
    </a>
    @endif
    @if (\Illuminate\Support\Facades\Route::has('admin.sales.team'))
    <a href="{{ route('admin.sales.team') }}" class="nav-link {{ request()->routeIs('admin.sales*') ? 'active' : '' }}">
        <i class="fas fa-handshake me-2"></i>
        فريق المبيعات
    </a>
    @endif
</div>
@endif

<!-- إدارة العملاء -->
@if (\Illuminate\Support\Facades\Route::has('admin.users.index') || \Illuminate\Support\Facades\Route::has('admin.customer-notes.index'))
<div class="nav-group">
    <div class="nav-group-title">إدارة العملاء</div>
    @if (\Illuminate\Support\Facades\Route::has('admin.users.index'))
    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
        <i class="fas fa-users me-2"></i>
        إدارة المستخدمين
    </a>
    @endif
    @if (\Illuminate\Support\Facades\Route::has('admin.customer-notes.index'))
    <a href="{{ route('admin.customer-notes.index') }}" class="nav-link {{ request()->routeIs('admin.customer-notes*') ? 'active' : '' }}">
        <i class="fas fa-sticky-note me-2"></i>
        ملاحظات العملاء
    </a>
    @endif
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
    <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->routeIs('admin.permissions*') ? 'active' : '' }}">
        <i class="fas fa-shield-alt me-2"></i>
        الأدوار والصلاحيات
    </a>
    <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins*') ? 'active' : '' }}">
        <i class="fas fa-user-shield me-2"></i>
        إدارة المديرين
    </a>
    <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
        <i class="fas fa-user-cog me-2"></i>
        الملف الشخصي
    </a>
</div>