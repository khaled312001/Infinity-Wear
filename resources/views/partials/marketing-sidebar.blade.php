<!-- الرئيسية -->
<div class="nav-group">
    <div class="nav-group-title">الرئيسية</div>
    <a href="{{ route('marketing.dashboard') }}" class="nav-link {{ request()->routeIs('marketing.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt me-2"></i>
        لوحة التحكم
    </a>
</div>

<!-- إدارة المحتوى -->
<div class="nav-group">
    <div class="nav-group-title">إدارة المحتوى</div>
    <a href="{{ route('marketing.portfolio') }}" class="nav-link {{ request()->routeIs('marketing.portfolio*') ? 'active' : '' }}">
        <i class="fas fa-images me-2"></i>
        معرض الأعمال
    </a>
    <a href="{{ route('marketing.testimonials') }}" class="nav-link {{ request()->routeIs('marketing.testimonials*') ? 'active' : '' }}">
        <i class="fas fa-star me-2"></i>
        التقييمات
    </a>
</div>

<!-- إدارة الطلبات -->
@if(\Illuminate\Support\Facades\Route::has('marketing.workflow-orders.index'))
<div class="nav-group">
    <div class="nav-group-title">إدارة الطلبات</div>
    <a href="{{ route('marketing.workflow-orders.index') }}" class="nav-link {{ request()->routeIs('marketing.workflow-orders*') ? 'active' : '' }}">
        <i class="fas fa-bullhorn me-2"></i>
        طلبات التسويق
    </a>
</div>
@endif

<!-- إدارة المهام -->
<div class="nav-group">
    <div class="nav-group-title">إدارة المهام</div>
    <a href="{{ route('marketing.tasks.index') }}" class="nav-link {{ request()->routeIs('marketing.tasks*') ? 'active' : '' }}">
        <i class="fas fa-tasks me-2"></i>
        المهام
    </a>
</div>

<!-- إدارة التواصل -->
<div class="nav-group">
    <div class="nav-group-title">إدارة التواصل</div>
    <a href="{{ route('marketing.contacts') }}" class="nav-link {{ request()->routeIs('marketing.contacts*') ? 'active' : '' }}">
        <i class="fas fa-address-book me-2"></i>
        جهات الاتصال
    </a>
</div>

<!-- إدارة الحساب -->
<div class="nav-group">
    <div class="nav-group-title">إدارة الحساب</div>
    <a href="{{ route('marketing.profile') }}" class="nav-link {{ request()->routeIs('marketing.profile*') ? 'active' : '' }}">
        <i class="fas fa-user me-2"></i>
        الملف الشخصي
    </a>
</div>