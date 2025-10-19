<?php $__env->startSection('title', 'لوحة التحكم - العميل'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة التحكم'); ?>
<?php $__env->startSection('page-title', 'لوحة التحكم'); ?>
<?php $__env->startSection('page-subtitle', 'مرحباً بك في لوحة تحكم العميل'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- إحصائيات الطلبات -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($orderStats['total']); ?></h3>
                    <p class="mb-0 text-muted">إجمالي الطلبات</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($orderStats['pending']); ?></h3>
                    <p class="mb-0 text-muted">طلبات معلقة</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($orderStats['shipped']); ?></h3>
                    <p class="mb-0 text-muted">طلبات مرسلة</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon success">
                    <i class="fas fa-check"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e($orderStats['delivered']); ?></h3>
                    <p class="mb-0 text-muted">طلبات مكتملة</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- إجمالي المبلغ المنفق -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-money-bill-wave me-2"></i>
                    إجمالي المبلغ المنفق
                </h5>
            </div>
            <div class="card-body text-center">
                <h2 class="text-primary mb-3"><?php echo e(number_format($totalSpent)); ?> ريال</h2>
                <p class="text-muted">إجمالي المبلغ المنفق على جميع الطلبات</p>
            </div>
        </div>
    </div>

    <!-- معلومات العميل -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>
                    معلومات العميل
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <i class="fas fa-user fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-1"><?php echo e($user->name); ?></h6>
                        <p class="text-muted mb-0">الاسم</p>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <i class="fas fa-envelope fa-2x text-info"></i>
                    </div>
                    <div>
                        <h6 class="mb-1"><?php echo e($user->email); ?></h6>
                        <p class="text-muted mb-0">البريد الإلكتروني</p>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-phone fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="mb-1"><?php echo e($user->phone ?? 'غير محدد'); ?></h6>
                        <p class="text-muted mb-0">رقم الهاتف</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- الطلبات الحديثة -->
    <div class="col-lg-8 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>
                    الطلبات الحديثة
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1"><?php echo e($order->order_number); ?></h6>
                                <p class="mb-1 text-muted"><?php echo e($order->created_at->format('Y-m-d H:i')); ?></p>
                                <small class="text-muted"><?php echo e($order->created_at->diffForHumans()); ?></small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-<?php echo e($order->status === 'pending' ? 'warning' : ($order->status === 'delivered' ? 'success' : 'info')); ?>">
                                    <?php echo e($order->status === 'pending' ? 'معلق' : ($order->status === 'delivered' ? 'مكتمل' : 'قيد المعالجة')); ?>

                                </span>
                                <div class="mt-1">
                                    <strong><?php echo e(number_format($order->total)); ?> ريال</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                        <p>لا توجد طلبات حديثة</p>
                        <a href="<?php echo e(route('customer.orders.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            إنشاء طلب جديد
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- النشاط الأخير -->
    <div class="col-lg-4 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>
                    النشاط الأخير
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    <?php $__empty_1 = true; $__currentLoopData = $recentActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="activity-item">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="fas <?php echo e($activity['icon']); ?> text-<?php echo e($activity['color']); ?>"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1"><?php echo e($activity['title']); ?></h6>
                                <p class="mb-1 text-muted"><?php echo e($activity['description']); ?></p>
                                <small class="text-muted"><?php echo e($activity['time']->diffForHumans()); ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-history fa-3x mb-3"></i>
                        <p>لا يوجد نشاط حديث</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- معرض الأعمال -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-images me-2"></i>
                    معرض الأعمال
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php $__empty_1 = true; $__currentLoopData = $portfolio; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo e($item->image); ?>" class="card-img-top" alt="<?php echo e($item->title); ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo e($item->title); ?></h6>
                                <p class="card-text text-muted"><?php echo e(Str::limit($item->description, 100)); ?></p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    <?php echo e($item->completion_date->format('Y-m-d')); ?>

                                </small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center text-muted py-4">
                        <i class="fas fa-images fa-3x mb-3"></i>
                        <p>لا توجد مشاريع في المعرض</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- التقييمات -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-star me-2"></i>
                    تقييمات العملاء
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?php echo e($i <= $testimonial->rating ? 'text-warning' : 'text-muted'); ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="card-text">"<?php echo e($testimonial->content); ?>"</p>
                                <h6 class="card-title"><?php echo e($testimonial->client_name); ?></h6>
                                <small class="text-muted"><?php echo e($testimonial->client_position); ?> - <?php echo e($testimonial->client_company); ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center text-muted py-4">
                        <i class="fas fa-star fa-3x mb-3"></i>
                        <p>لا توجد تقييمات متاحة</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- أزرار سريعة -->
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    إجراءات سريعة
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('customer.orders.create')); ?>" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>
                            إنشاء طلب جديد
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('customer.orders')); ?>" class="btn btn-info w-100">
                            <i class="fas fa-shopping-cart me-2"></i>
                            عرض جميع الطلبات
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('customer.portfolio')); ?>" class="btn btn-success w-100">
                            <i class="fas fa-images me-2"></i>
                            معرض الأعمال
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('customer.contact')); ?>" class="btn btn-warning w-100">
                            <i class="fas fa-envelope me-2"></i>
                            اتصل بنا
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\customer\dashboard.blade.php ENDPATH**/ ?>