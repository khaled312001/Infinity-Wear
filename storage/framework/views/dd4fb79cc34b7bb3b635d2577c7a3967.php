<!-- الرئيسية -->
<div class="nav-group">
    <div class="nav-group-title">الرئيسية</div>
    <a href="<?php echo e(route('marketing.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('marketing.dashboard') ? 'active' : ''); ?>">
        <i class="fas fa-tachometer-alt me-2"></i>
        لوحة التحكم
    </a>
</div>

<!-- إدارة المحتوى -->
<div class="nav-group">
    <div class="nav-group-title">إدارة المحتوى</div>
    <a href="<?php echo e(route('marketing.portfolio')); ?>" class="nav-link <?php echo e(request()->routeIs('marketing.portfolio*') ? 'active' : ''); ?>">
        <i class="fas fa-images me-2"></i>
        معرض الأعمال
    </a>
    <a href="<?php echo e(route('marketing.testimonials')); ?>" class="nav-link <?php echo e(request()->routeIs('marketing.testimonials*') ? 'active' : ''); ?>">
        <i class="fas fa-star me-2"></i>
        التقييمات
    </a>
</div>

<!-- إدارة المهام -->
<div class="nav-group">
    <div class="nav-group-title">إدارة المهام</div>
    <a href="<?php echo e(route('marketing.tasks.index')); ?>" class="nav-link <?php echo e(request()->routeIs('marketing.tasks*') ? 'active' : ''); ?>">
        <i class="fas fa-tasks me-2"></i>
        المهام
    </a>
</div>

<!-- إدارة التواصل -->
<div class="nav-group">
    <div class="nav-group-title">إدارة التواصل</div>
    <a href="<?php echo e(route('marketing.contacts')); ?>" class="nav-link <?php echo e(request()->routeIs('marketing.contacts*') ? 'active' : ''); ?>">
        <i class="fas fa-address-book me-2"></i>
        جهات الاتصال
    </a>
</div>

<!-- إدارة الحساب -->
<div class="nav-group">
    <div class="nav-group-title">إدارة الحساب</div>
    <a href="<?php echo e(route('marketing.profile')); ?>" class="nav-link <?php echo e(request()->routeIs('marketing.profile*') ? 'active' : ''); ?>">
        <i class="fas fa-user me-2"></i>
        الملف الشخصي
    </a>
</div><?php /**PATH F:\infinity\Infinity-Wear\resources\views\partials\marketing-sidebar.blade.php ENDPATH**/ ?>