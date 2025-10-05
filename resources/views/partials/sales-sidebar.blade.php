<!-- الرئيسية -->
<div class="nav-group">
    <div class="nav-group-title">الرئيسية</div>
    <a href="{{ route('sales.dashboard') }}" class="nav-link {{ request()->routeIs('sales.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt me-2"></i>
        لوحة التحكم
    </a>
</div>

<!-- إدارة الطلبات -->
<div class="nav-group">
    <div class="nav-group-title">إدارة الطلبات</div>
    <a href="{{ route('sales.importer-orders') }}" class="nav-link {{ request()->routeIs('sales.importer-orders*') ? 'active' : '' }}">
        <i class="fas fa-industry me-2"></i>
        طلبات المستوردين
    </a>
</div>

<!-- إدارة العملاء والمستوردين -->
<div class="nav-group">
    <div class="nav-group-title">إدارة العملاء والمستوردين</div>
    <a href="{{ route('sales.importers') }}" class="nav-link {{ request()->routeIs('sales.importers*') ? 'active' : '' }}">
        <i class="fas fa-users me-2"></i>
        المستوردين
    </a>
    <a href="{{ route('sales.contacts') }}" class="nav-link {{ request()->routeIs('sales.contacts*') ? 'active' : '' }}">
        <i class="fas fa-address-book me-2"></i>
        جهات الاتصال
    </a>
</div>

<!-- إدارة المهام -->
<div class="nav-group">
    <div class="nav-group-title">إدارة المهام</div>
    <a href="{{ route('sales.tasks') }}" class="nav-link {{ request()->routeIs('sales.tasks*') ? 'active' : '' }}">
        <i class="fas fa-tasks me-2"></i>
        المهام التجارية
    </a>
</div>

<!-- التقارير والإحصائيات -->
<div class="nav-group">
    <div class="nav-group-title">التقارير والإحصائيات</div>
    <a href="{{ route('sales.reports') }}" class="nav-link {{ request()->routeIs('sales.reports*') ? 'active' : '' }}">
        <i class="fas fa-chart-line me-2"></i>
        تقارير المبيعات
    </a>
</div>

<!-- الملف الشخصي -->
<div class="nav-group">
    <div class="nav-group-title">الحساب الشخصي</div>
    <a href="{{ route('sales.profile') }}" class="nav-link {{ request()->routeIs('sales.profile*') ? 'active' : '' }}">
        <i class="fas fa-user-cog me-2"></i>
        الملف الشخصي
    </a>
</div>
