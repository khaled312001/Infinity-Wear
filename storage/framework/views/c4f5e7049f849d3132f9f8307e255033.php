

<?php $__env->startSection('title', 'مراقبة النظام'); ?>
<?php $__env->startSection('page-title', 'مراقبة النظام'); ?>
<?php $__env->startSection('page-subtitle', 'مراقبة حالة نظام الإشعارات والـ Queue'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">لوحة التحكم</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.notifications.index')); ?>">الإشعارات</a></li>
                        <li class="breadcrumb-item active">مراقبة النظام</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    مراقبة النظام
                </h4>
            </div>
        </div>
    </div>

    <!-- إحصائيات النظام -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card enhanced">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon primary me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h3 class="stats-number" id="pending-jobs"><?php echo e($stats['pending_jobs']); ?></h3>
                            <p class="stats-label">مهام معلقة</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card enhanced">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon success me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h3 class="stats-number" id="processed-jobs"><?php echo e($stats['processed_jobs']); ?></h3>
                            <p class="stats-label">مهام معالجة</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card enhanced">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon danger me-3">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h3 class="stats-number" id="failed-jobs"><?php echo e($stats['failed_jobs']); ?></h3>
                            <p class="stats-label">مهام فاشلة</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card enhanced">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon info me-3">
                            <i class="fas fa-server"></i>
                        </div>
                        <div>
                            <h3 class="stats-number" id="worker-status">
                                <span class="badge bg-<?php echo e($stats['worker_status'] == 'running' ? 'success' : 'danger'); ?>">
                                    <?php echo e($stats['worker_status'] == 'running' ? 'يعمل' : 'متوقف'); ?>

                                </span>
                            </h3>
                            <p class="stats-label">حالة Worker</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- أزرار التحكم -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        أدوات التحكم
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-outline-primary" id="refresh-stats">
                            <i class="fas fa-sync-alt me-2"></i>
                            تحديث الإحصائيات
                        </button>
                        
                        <button type="button" class="btn btn-outline-warning" id="retry-failed-jobs">
                            <i class="fas fa-redo me-2"></i>
                            إعادة تشغيل المهام الفاشلة
                        </button>
                        
                        <button type="button" class="btn btn-outline-danger" id="flush-failed-jobs">
                            <i class="fas fa-trash me-2"></i>
                            حذف المهام الفاشلة
                        </button>
                        
                        <button type="button" class="btn btn-outline-info" id="restart-worker">
                            <i class="fas fa-power-off me-2"></i>
                            إعادة تشغيل Worker
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- المهام الأخيرة -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        المهام الأخيرة
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($recentJobs->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>النوع</th>
                                        <th>تاريخ الإنشاء</th>
                                        <th>المحاولات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recentJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($job->id); ?></td>
                                        <td>
                                            <span class="badge bg-primary">
                                                <?php echo e($job->queue ?? 'default'); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e(\Carbon\Carbon::parse($job->created_at)->format('Y-m-d H:i:s')); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo e($job->attempts > 0 ? 'warning' : 'success'); ?>">
                                                <?php echo e($job->attempts); ?>

                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>لا توجد مهام معلقة</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- المهام الفاشلة -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        المهام الفاشلة
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($failedJobs->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>النوع</th>
                                        <th>تاريخ الفشل</th>
                                        <th>الإجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $failedJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($job->id); ?></td>
                                        <td>
                                            <span class="badge bg-danger">
                                                <?php echo e($job->queue ?? 'default'); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e(\Carbon\Carbon::parse($job->failed_at)->format('Y-m-d H:i:s')); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="retryJob(<?php echo e($job->id); ?>)">
                                                <i class="fas fa-redo"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                            <p>لا توجد مهام فاشلة</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- معلومات إضافية -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        معلومات النظام
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>حالة النظام:</h6>
                            <p>
                                <span class="badge bg-<?php echo e($stats['queue_status'] == 'idle' ? 'success' : ($stats['queue_status'] == 'active' ? 'warning' : 'danger')); ?>">
                                    <?php echo e($stats['queue_status'] == 'idle' ? 'خامل' : ($stats['queue_status'] == 'active' ? 'نشط' : 'مشغول')); ?>

                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>حالة Worker:</h6>
                            <p>
                                <span class="badge bg-<?php echo e($stats['worker_status'] == 'running' ? 'success' : 'danger'); ?>">
                                    <?php echo e($stats['worker_status'] == 'running' ? 'يعمل' : 'متوقف'); ?>

                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-3">
                        <h6><i class="fas fa-lightbulb me-2"></i>نصائح مهمة:</h6>
                        <ul class="mb-0">
                            <li>تأكد من تشغيل <code>php artisan queue:work</code> في terminal منفصل</li>
                            <li>راقب المهام الفاشلة وأعد تشغيلها عند الحاجة</li>
                            <li>استخدم Supervisor في البيئة الإنتاجية</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // تحديث الإحصائيات كل 30 ثانية
    setInterval(function() {
        refreshStats();
    }, 30000);

    // تحديث الإحصائيات عند النقر على الزر
    $('#refresh-stats').click(function() {
        refreshStats();
    });

    // إعادة تشغيل المهام الفاشلة
    $('#retry-failed-jobs').click(function() {
        if (confirm('هل تريد إعادة تشغيل جميع المهام الفاشلة؟')) {
            $.ajax({
                url: '<?php echo e(route("admin.notifications.queue-monitor.retry-failed")); ?>',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        alert('تم إعادة تشغيل المهام الفاشلة بنجاح');
                        location.reload();
                    } else {
                        alert('خطأ: ' + response.message);
                    }
                },
                error: function() {
                    alert('حدث خطأ في إعادة تشغيل المهام الفاشلة');
                }
            });
        }
    });

    // حذف المهام الفاشلة
    $('#flush-failed-jobs').click(function() {
        if (confirm('هل تريد حذف جميع المهام الفاشلة؟ هذا الإجراء لا يمكن التراجع عنه.')) {
            $.ajax({
                url: '<?php echo e(route("admin.notifications.queue-monitor.flush-failed")); ?>',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        alert('تم حذف المهام الفاشلة بنجاح');
                        location.reload();
                    } else {
                        alert('خطأ: ' + response.message);
                    }
                },
                error: function() {
                    alert('حدث خطأ في حذف المهام الفاشلة');
                }
            });
        }
    });

    // إعادة تشغيل Worker
    $('#restart-worker').click(function() {
        if (confirm('هل تريد إعادة تشغيل Queue Worker؟')) {
            $.ajax({
                url: '<?php echo e(route("admin.notifications.queue-monitor.restart-worker")); ?>',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        alert('تم إعادة تشغيل Worker بنجاح');
                        location.reload();
                    } else {
                        alert('خطأ: ' + response.message);
                    }
                },
                error: function() {
                    alert('حدث خطأ في إعادة تشغيل Worker');
                }
            });
        }
    });
});

function refreshStats() {
    $.ajax({
        url: '<?php echo e(route("admin.notifications.queue-monitor.stats")); ?>',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                $('#pending-jobs').text(response.stats.pending_jobs);
                $('#processed-jobs').text(response.stats.processed_jobs);
                $('#failed-jobs').text(response.stats.failed_jobs);
                
                // تحديث حالة Worker
                const workerStatus = response.stats.worker_status;
                const workerBadge = $('#worker-status .badge');
                workerBadge.removeClass('bg-success bg-danger')
                          .addClass(workerStatus == 'running' ? 'bg-success' : 'bg-danger')
                          .text(workerStatus == 'running' ? 'يعمل' : 'متوقف');
            }
        },
        error: function() {
            console.log('خطأ في تحديث الإحصائيات');
        }
    });
}

function retryJob(jobId) {
    if (confirm('هل تريد إعادة تشغيل هذه المهمة؟')) {
        // يمكن إضافة AJAX call لإعادة تشغيل مهمة محددة
        alert('سيتم إضافة هذه الميزة قريباً');
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\notifications\queue-monitor.blade.php ENDPATH**/ ?>