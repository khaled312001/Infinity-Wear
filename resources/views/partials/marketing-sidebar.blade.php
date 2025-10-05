<!-- الرئيسية -->
<div class="nav-group">
    <div class="nav-group-title">الرئيسية</div>
    <a href="{{ route('marketing.dashboard') }}" class="nav-link {{ request()->routeIs('marketing.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt me-2"></i>
        لوحة التحكم
    </a>
</div>

<!-- إدارة المحتوى التسويقي -->
<div class="nav-group">
    <div class="nav-group-title">إدارة المحتوى التسويقي</div>
    <a href="{{ route('marketing.portfolio') }}" class="nav-link {{ request()->routeIs('marketing.portfolio*') ? 'active' : '' }}">
        <i class="fas fa-images me-2"></i>
        معرض الأعمال
    </a>
    <a href="{{ route('marketing.testimonials') }}" class="nav-link {{ request()->routeIs('marketing.testimonials*') ? 'active' : '' }}">
        <i class="fas fa-star me-2"></i>
        التقييمات
    </a>
</div>

<!-- إدارة المهام -->
<div class="nav-group">
    <div class="nav-group-title">إدارة المهام</div>
    <a href="{{ route('marketing.tasks') }}" class="nav-link {{ request()->routeIs('marketing.tasks*') ? 'active' : '' }}">
        <i class="fas fa-tasks me-2"></i>
        المهام التسويقية
    </a>
</div>

<!-- التواصل والتفاعل -->
<div class="nav-group">
    <div class="nav-group-title">التواصل والتفاعل</div>
    <a href="{{ route('marketing.contacts') }}" class="nav-link {{ request()->routeIs('marketing.contacts*') ? 'active' : '' }}">
        <i class="fas fa-address-book me-2"></i>
        جهات الاتصال المشتركة
    </a>
    {{-- <a href="{{ route('marketing.whatsapp') }}" class="nav-link {{ request()->routeIs('marketing.whatsapp*') ? 'active' : '' }}">
        <i class="fas fa-comments me-2"></i>
        رسائل الواتساب
    </a> --}}
</div>

<!-- التقارير والإحصائيات -->
{{-- <div class="nav-group">
    <div class="nav-group-title">التقارير والإحصائيات</div>
    <a href="{{ route('marketing.reports') }}" class="nav-link {{ request()->routeIs('marketing.reports*') ? 'active' : '' }}">
        <i class="fas fa-chart-bar me-2"></i>
        تقارير التسويق
    </a>
</div> --}}

<!-- الملف الشخصي -->
<div class="nav-group">
    <div class="nav-group-title">الحساب الشخصي</div>
    <a href="{{ route('marketing.profile') }}" class="nav-link {{ request()->routeIs('marketing.profile*') ? 'active' : '' }}">
        <i class="fas fa-user-cog me-2"></i>
        الملف الشخصي
    </a>
</div>
