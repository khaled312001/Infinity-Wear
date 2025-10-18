<!-- الرئيسية -->
<div class="nav-group">
    <div class="nav-group-title">الرئيسية</div>
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
        <i class="fas fa-tachometer-alt me-2"></i>
        لوحة التحكم
    </a>
    <a href="<?php echo e(route('admin.notifications.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.notifications*') ? 'active' : ''); ?>" style="position: relative;">
        <i class="fas fa-bell me-2"></i>
        الإشعارات
        <span class="notification-badge" id="sidebarNotificationsBadge" style="display: none;">0</span>
    </a>
    <a href="<?php echo e(route('admin.contacts.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.contacts*') ? 'active' : ''); ?>">
        <i class="fas fa-address-book me-2"></i>
        رسائل التواصل    </a>
    <a href="<?php echo e(route('admin.whatsapp.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.whatsapp*') ? 'active' : ''); ?>">
        <i class="fas fa-comments me-2"></i>
        رسائل الواتساب
    </a>
</div>

<!-- إدارة المحتوى -->
<div class="nav-group">
    <div class="nav-group-title">إدارة المحتوى</div>
    <a href="<?php echo e(route('admin.services.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.services*') ? 'active' : ''); ?>">
        <i class="fas fa-cogs me-2"></i>
        إدارة الخدمات
    </a>
    <a href="<?php echo e(route('admin.portfolio.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.portfolio*') ? 'active' : ''); ?>">
        <i class="fas fa-images me-2"></i>
        معرض الأعمال
    </a>
    <a href="<?php echo e(route('admin.testimonials.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.testimonials*') ? 'active' : ''); ?>">
        <i class="fas fa-star me-2"></i>
        التقييمات
    </a>
  
  
</div>

<!-- إدارة المستوردين -->
<div class="nav-group">
    <div class="nav-group-title">إدارة المستوردين</div>
    <a href="<?php echo e(route('admin.importers.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.importers*') ? 'active' : ''); ?>">
        <i class="fas fa-industry me-2"></i>
        المستوردين
    </a>
    <a href="<?php echo e(route('admin.importers.orders')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.importers.orders*') ? 'active' : ''); ?>">
        <i class="fas fa-shopping-bag me-2"></i>
        طلبات المستوردين
    </a>
</div>


<!-- إدارة المهام -->
<div class="nav-group">
    <div class="nav-group-title">إدارة المهام</div>
    <a href="<?php echo e(route('admin.tasks.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.tasks*') ? 'active' : ''); ?>">
        <i class="fas fa-tasks me-2"></i>
        المهام
    </a>
    <a href="<?php echo e(route('admin.company-plans.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.company-plans*') ? 'active' : ''); ?>">
        <i class="fas fa-chart-line me-2"></i>
        خطط الشركة
    </a>
</div>

<!-- إدارة المالية -->
<div class="nav-group">
    <div class="nav-group-title">إدارة المالية</div>
    <a href="<?php echo e(route('admin.finance.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.finance.dashboard*') ? 'active' : ''); ?>">
        <i class="fas fa-chart-line me-2"></i>
        لوحة المالية
    </a>
    <a href="<?php echo e(route('admin.finance.transactions')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.finance.transactions*') ? 'active' : ''); ?>">
        <i class="fas fa-money-bill-wave me-2"></i>
        المعاملات المالية
    </a>
    <a href="<?php echo e(route('admin.finance.reports')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.finance.reports*') ? 'active' : ''); ?>">
        <i class="fas fa-chart-pie me-2"></i>
        التقارير المالية
    </a>
</div>



<!-- إدارة الفرق -->
<div class="nav-group">
    <div class="nav-group-title">إدارة الفرق</div>
    <a href="<?php echo e(route('admin.marketing.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.marketing*') ? 'active' : ''); ?>">
        <i class="fas fa-bullhorn me-2"></i>
        فريق التسويق
    </a>
    <a href="<?php echo e(route('admin.sales.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.sales*') ? 'active' : ''); ?>">
        <i class="fas fa-handshake me-2"></i>
        فريق المبيعات
    </a>
    <a href="<?php echo e(route('admin.email-marketing.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.email-marketing*') ? 'active' : ''); ?>">
        <i class="fas fa-envelope-open-text me-2"></i>
        التسويق بالبريد الإلكتروني
    </a>
</div>

<!-- إدارة العملاء -->
<div class="nav-group">
    <div class="nav-group-title">إدارة العملاء</div>
   
    <a href="<?php echo e(route('admin.customer-notes.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.customer-notes*') ? 'active' : ''); ?>">
        <i class="fas fa-sticky-note me-2"></i>
        ملاحظات العملاء
    </a>
</div>

<!-- إدارة النظام -->
<div class="nav-group">
    <div class="nav-group-title">إدارة النظام</div>
    <a href="<?php echo e(route('admin.reports')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.reports*') ? 'active' : ''); ?>">
        <i class="fas fa-chart-bar me-2"></i>
        التقارير
    </a>
    <a href="<?php echo e(route('admin.settings')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.settings*') ? 'active' : ''); ?>">
        <i class="fas fa-cog me-2"></i>
        الإعدادات
    </a>
    <a href="<?php echo e(route('admin.permissions.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.permissions*') ? 'active' : ''); ?>">
        <i class="fas fa-shield-alt me-2"></i>
        الأدوار والصلاحيات
    </a>
    <a href="<?php echo e(route('admin.admins.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.admins*') ? 'active' : ''); ?>">
        <i class="fas fa-user-shield me-2"></i>
        إدارة المديرين
    </a>
    <a href="<?php echo e(route('admin.profile')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.profile*') ? 'active' : ''); ?>">
        <i class="fas fa-user-cog me-2"></i>
        الملف الشخصي
    </a>
</div><?php /**PATH F:\infinity\Infinity-Wear\resources\views/partials/admin-sidebar.blade.php ENDPATH**/ ?>