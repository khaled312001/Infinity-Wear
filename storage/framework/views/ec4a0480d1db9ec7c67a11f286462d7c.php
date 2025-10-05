

<?php $__env->startSection('title', 'لوحة التحكم - فريق المبيعات'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة التحكم'); ?>
<?php $__env->startSection('page-title', 'لوحة التحكم'); ?>
<?php $__env->startSection('page-subtitle', 'مرحباً بك في لوحة تحكم فريق المبيعات'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- إحصائيات المستوردين -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon primary">
                    <i class="fas fa-industry"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e(number_format($salesStats['total_importers'])); ?></h3>
                    <p class="mb-0 text-muted">إجمالي المستوردين</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon success">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e(number_format($salesStats['total_importer_orders'])); ?></h3>
                    <p class="mb-0 text-muted">طلبات المستوردين</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon warning">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e(number_format($salesStats['total_importer_revenue'])); ?></h3>
                    <p class="mb-0 text-muted">إجمالي الإيرادات</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e(number_format($taskStats['total'])); ?></h3>
                    <p class="mb-0 text-muted">المهام المخصصة</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- إحصائيات المبيعات الشهرية -->
    <div class="col-lg-8 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    إحصائيات المبيعات الشهرية
                </h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات المستوردين -->
    <div class="col-lg-4 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-industry me-2"></i>
                    إحصائيات المستوردين
                </h5>
            </div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $importerStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted"><?php echo e($stat->status === 'new' ? 'جدد' : ($stat->status === 'contacted' ? 'تم التواصل' : 'مؤهلين')); ?></span>
                        <span class="fw-bold"><?php echo e($stat->count); ?></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center text-muted py-4">
                    <i class="fas fa-industry fa-3x mb-3"></i>
                    <p>لا توجد إحصائيات متاحة</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- طلبات المستوردين الحديثة -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-industry me-2"></i>
                    طلبات المستوردين الحديثة
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    <?php $__empty_1 = true; $__currentLoopData = $recentImporterOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1"><?php echo e($order->order_number ?? '#' . $order->id); ?></h6>
                                <p class="mb-1 text-muted"><?php echo e($order->importer->company_name ?? 'غير محدد'); ?></p>
                                <small class="text-muted"><?php echo e($order->created_at->diffForHumans()); ?></small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-<?php echo e($order->status === 'new' ? 'primary' : ($order->status === 'completed' ? 'success' : 'info')); ?>">
                                    <?php echo e($order->status === 'new' ? 'جديد' : ($order->status === 'completed' ? 'مكتمل' : 'قيد المعالجة')); ?>

                                </span>
                                <div class="mt-1">
                                    <strong><?php echo e(number_format($order->final_cost)); ?> ريال</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-industry fa-3x mb-3"></i>
                        <p>لا توجد طلبات مستوردين حديثة</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- طلبات المستوردين الحديثة -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-industry me-2"></i>
                    طلبات المستوردين الحديثة
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    <?php $__empty_1 = true; $__currentLoopData = $recentImporterOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1"><?php echo e($order->order_number); ?></h6>
                                <p class="mb-1 text-muted"><?php echo e($order->importer->name ?? 'مستورد'); ?></p>
                                <small class="text-muted"><?php echo e($order->created_at->diffForHumans()); ?></small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-<?php echo e($order->status === 'new' ? 'warning' : ($order->status === 'completed' ? 'success' : 'info')); ?>">
                                    <?php echo e($order->status === 'new' ? 'جديد' : ($order->status === 'completed' ? 'مكتمل' : 'قيد المعالجة')); ?>

                                </span>
                                <div class="mt-1">
                                    <strong><?php echo e(number_format($order->final_cost)); ?> ريال</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-industry fa-3x mb-3"></i>
                        <p>لا توجد طلبات مستوردين حديثة</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- المهام المخصصة -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tasks me-2 text-primary"></i>
                    المهام المخصصة
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    <?php $__empty_1 = true; $__currentLoopData = $urgentTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1"><?php echo e($task->title); ?></h6>
                                <p class="mb-1 text-muted"><?php echo e(Str::limit($task->description, 100)); ?></p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    <?php echo e($task->due_date ? $task->due_date->format('Y-m-d') : 'بدون تاريخ'); ?>

                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-<?php echo e($task->priority === 'urgent' ? 'danger' : ($task->priority === 'high' ? 'warning' : 'info')); ?>">
                                    <?php echo e($task->priority === 'urgent' ? 'عاجل' : ($task->priority === 'high' ? 'عالي' : 'متوسط')); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-tasks fa-3x mb-3 text-muted"></i>
                        <p>لا توجد مهام مخصصة</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- المستوردين الجدد -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-plus me-2"></i>
                    المستوردين الجدد
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    <?php $__empty_1 = true; $__currentLoopData = $newImporters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $importer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1"><?php echo e($importer->name); ?></h6>
                                <p class="mb-1 text-muted"><?php echo e($importer->company_name); ?></p>
                                <small class="text-muted"><?php echo e($importer->created_at->diffForHumans()); ?></small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">جديد</span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-user-plus fa-3x mb-3"></i>
                        <p>لا توجد مستوردين جدد</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- النشاط الأخير -->
<div class="row">
    <div class="col-12 mb-4">
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
                        <a href="<?php echo e(route('sales.orders')); ?>" class="btn btn-primary w-100">
                            <i class="fas fa-shopping-cart me-2"></i>
                            عرض الطلبات
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('sales.importers')); ?>" class="btn btn-info w-100">
                            <i class="fas fa-industry me-2"></i>
                            المستوردين
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('sales.tasks')); ?>" class="btn btn-success w-100">
                            <i class="fas fa-tasks me-2"></i>
                            المهام
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="<?php echo e(route('sales.reports')); ?>" class="btn btn-warning w-100">
                            <i class="fas fa-chart-bar me-2"></i>
                            التقارير
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// رسم بياني للمبيعات الشهرية
const salesCtx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: [
            'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو',
            'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'
        ],
        datasets: [{
            label: 'المبيعات (ريال)',
            data: [
                <?php $__currentLoopData = $monthlySales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($sale->total ?? 0); ?>,
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ],
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString() + ' ريال';
                    }
                }
            }
        }
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.sales-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views/sales/dashboard.blade.php ENDPATH**/ ?>