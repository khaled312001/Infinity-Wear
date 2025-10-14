<!-- الرئيسية -->
<div class="nav-group">
    <div class="nav-group-title">الرئيسية</div>
    <a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt me-2"></i>
        لوحة التحكم
    </a>
</div>

<!-- إدارة الطلبات -->
<div class="nav-group">
    <div class="nav-group-title">إدارة الطلبات</div>
    <a href="{{ route('customer.orders') }}" class="nav-link {{ request()->routeIs('customer.orders*') ? 'active' : '' }}">
        <i class="fas fa-shopping-cart me-2"></i>
        طلباتي
    </a>
    <a href="{{ route('customer.designs') }}" class="nav-link {{ request()->routeIs('customer.designs*') ? 'active' : '' }}">
        <i class="fas fa-palette me-2"></i>
        تصاميمي
    </a>
</div>

<!-- إدارة الحساب -->
<div class="nav-group">
    <div class="nav-group-title">إدارة الحساب</div>
    <a href="{{ route('customer.profile') }}" class="nav-link {{ request()->routeIs('customer.profile*') ? 'active' : '' }}">
        <i class="fas fa-user me-2"></i>
        الملف الشخصي
    </a>
    <a href="{{ route('customer.settings') }}" class="nav-link {{ request()->routeIs('customer.settings*') ? 'active' : '' }}">
        <i class="fas fa-cog me-2"></i>
        الإعدادات
    </a>
</div>
