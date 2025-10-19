<!-- الرئيسية -->
<div class="nav-group">
    <div class="nav-group-title">الرئيسية</div>
    <a href="<?php echo e(route('customer.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('customer.dashboard') ? 'active' : ''); ?>">
        <i class="fas fa-tachometer-alt me-2"></i>
        لوحة التحكم
    </a>
</div>

<!-- إدارة الطلبات -->
<div class="nav-group">
    <div class="nav-group-title">إدارة الطلبات</div>
    <a href="<?php echo e(route('customer.orders')); ?>" class="nav-link <?php echo e(request()->routeIs('customer.orders*') ? 'active' : ''); ?>">
        <i class="fas fa-shopping-cart me-2"></i>
        طلباتي
    </a>
    <a href="<?php echo e(route('customer.designs')); ?>" class="nav-link <?php echo e(request()->routeIs('customer.designs*') ? 'active' : ''); ?>">
        <i class="fas fa-palette me-2"></i>
        تصاميمي
    </a>
</div>

<!-- إدارة الحساب -->
<div class="nav-group">
    <div class="nav-group-title">إدارة الحساب</div>
    <a href="<?php echo e(route('customer.profile')); ?>" class="nav-link <?php echo e(request()->routeIs('customer.profile*') ? 'active' : ''); ?>">
        <i class="fas fa-user me-2"></i>
        الملف الشخصي
    </a>
    <a href="<?php echo e(route('customer.settings')); ?>" class="nav-link <?php echo e(request()->routeIs('customer.settings*') ? 'active' : ''); ?>">
        <i class="fas fa-cog me-2"></i>
        الإعدادات
    </a>
</div>
<?php /**PATH F:\infinity\Infinity-Wear\resources\views\partials\customer-sidebar.blade.php ENDPATH**/ ?>