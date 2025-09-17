{{-- Unified Admin Sidebar Menu --}}
<a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt me-2"></i>
    الرئيسية
</a>

<!-- إدارة المحتوى -->
<div class="nav-group">
    <div class="nav-group-title">
        <i class="fas fa-store me-2"></i>
        إدارة المحتوى
    </div>
    <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <i class="fas fa-shopping-cart me-2"></i>
        الطلبات
    </a>
    <a href="{{ route('admin.hero-slider.index') }}" class="nav-link {{ request()->routeIs('admin.hero-slider.*') ? 'active' : '' }}">
        <i class="fas fa-images me-2"></i>
        السلايدر الرئيسي
    </a>
    <a href="{{ route('admin.home-sections.index') }}" class="nav-link {{ request()->routeIs('admin.home-sections.*') ? 'active' : '' }}">
        <i class="fas fa-th-large me-2"></i>
        أقسام الصفحة الرئيسية
    </a>
    <a href="{{ route('admin.portfolio.index') }}" class="nav-link {{ request()->routeIs('admin.portfolio.*') ? 'active' : '' }}">
        <i class="fas fa-image me-2"></i>
        معرض الأعمال
    </a>
    <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
        <i class="fas fa-star me-2"></i>
        الشهادات والتقييمات
    </a>
</div>

<!-- إدارة المستخدمين -->
<div class="nav-group">
    <div class="nav-group-title">
        <i class="fas fa-users me-2"></i>
        إدارة المستخدمين
    </div>
    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <i class="fas fa-user me-2"></i>
        المستخدمين
    </a>
    <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
        <i class="fas fa-user-shield me-2"></i>
        الإداريين
    </a>
    <a href="{{ route('admin.importers.index') }}" class="nav-link {{ request()->routeIs('admin.importers.*') ? 'active' : '' }}">
        <i class="fas fa-truck me-2"></i>
        المستوردين
    </a>
    <a href="{{ route('admin.customer-notes.index') }}" class="nav-link {{ request()->routeIs('admin.customer-notes.*') ? 'active' : '' }}">
        <i class="fas fa-database me-2"></i>
        قاعدة بيانات العملاء
    </a>
    <a href="{{ route('admin.whatsapp.index') }}" class="nav-link {{ request()->routeIs('admin.whatsapp.*') ? 'active' : '' }}">
        <i class="fab fa-whatsapp me-2"></i>
        الواتساب
    </a>
</div>

<!-- إدارة المهام -->
<div class="nav-group">
    <div class="nav-group-title">
        <i class="fas fa-tasks me-2"></i>
        إدارة المهام
    </div>
    <a href="{{ route('admin.tasks.index') }}" class="nav-link {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}">
        <i class="fas fa-clipboard-list me-2"></i>
        المهام
    </a>
    <a href="{{ route('admin.marketing.index') }}" class="nav-link {{ request()->routeIs('admin.marketing.*') ? 'active' : '' }}">
        <i class="fas fa-bullhorn me-2"></i>
        فريق التسويق
    </a>
    <a href="{{ route('admin.sales.index') }}" class="nav-link {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}">
        <i class="fas fa-chart-line me-2"></i>
        فريق المبيعات
    </a>
    <a href="{{ route('admin.company-plans.index') }}" class="nav-link {{ request()->routeIs('admin.company-plans.*') ? 'active' : '' }}">
        <i class="fas fa-chart-pie me-2"></i>
        خطط الشركة
    </a>
</div>

<!-- النظام المالي -->
<div class="nav-group">
    <div class="nav-group-title">
        <i class="fas fa-money-bill-wave me-2"></i>
        النظام المالي
    </div>
    <a href="{{ route('admin.finance.dashboard') }}" class="nav-link {{ request()->routeIs('admin.finance.*') ? 'active' : '' }}">
        <i class="fas fa-chart-pie me-2"></i>
        لوحة المالية
    </a>
</div>

<!-- إدارة المحتوى والـ SEO -->
<div class="nav-group">
    <div class="nav-group-title">
        <i class="fas fa-search me-2"></i>
        المحتوى والـ SEO
    </div>
    <a href="{{ route('admin.content.seo') }}" class="nav-link {{ request()->routeIs('admin.content.seo') ? 'active' : '' }}">
        <i class="fas fa-search-plus me-2"></i>
        إعدادات SEO
    </a>
    <a href="{{ route('admin.content.index') }}" class="nav-link {{ request()->routeIs('admin.content.index') ? 'active' : '' }}">
        <i class="fas fa-sitemap me-2"></i>
        خريطة الموقع
    </a>
</div>

<!-- التقارير والإحصائيات -->
<div class="nav-group">
    <div class="nav-group-title">
        <i class="fas fa-chart-bar me-2"></i>
        التقارير والإحصائيات
    </div>
    <a href="{{ route('admin.reports') }}" class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
        <i class="fas fa-analytics me-2"></i>
        تقارير شاملة
    </a>
</div>

<!-- الإعدادات -->
<div class="nav-group">
    <div class="nav-group-title">
        <i class="fas fa-cog me-2"></i>
        الإعدادات
    </div>
    <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
        <i class="fas fa-shield-alt me-2"></i>
        إدارة الصلاحيات
    </a>
    <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
        <i class="fas fa-sliders-h me-2"></i>
        إعدادات النظام
    </a>
</div>