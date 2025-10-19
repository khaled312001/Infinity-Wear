

<?php $__env->startSection('title', 'تصدير تقارير المندوبين التسويقيين'); ?>
<?php $__env->startSection('dashboard-title', 'تصدير تقارير المندوبين التسويقيين'); ?>
<?php $__env->startSection('page-title', 'تصدير تقارير المندوبين التسويقيين'); ?>
<?php $__env->startSection('page-subtitle', 'نتائج تصدير تقارير المندوبين التسويقيين'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-download me-2"></i>
                        نتائج التصدير
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('sales.marketing-reports.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    تم العثور على <?php echo e($reports->count()); ?> تقرير مطابق لمعايير التصدير.
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المندوب</th>
                                <th>الجهة</th>
                                <th>نوع الزيارة</th>
                                <th>حالة الاتفاق</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($report->representative_name); ?></td>
                                <td><?php echo e($report->company_name); ?></td>
                                <td><?php echo e($report->getVisitTypeText()); ?></td>
                                <td><?php echo e($report->getAgreementStatusText()); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($report->getStatusBadgeClass()); ?>">
                                        <?php echo e($report->getStatusText()); ?>

                                    </span>
                                </td>
                                <td><?php echo e($report->created_at->format('Y-m-d H:i')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                                        <p>لا توجد تقارير مطابقة لمعايير التصدير</p>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if($reports->count() > 0): ?>
                <div class="mt-4">
                    <div class="alert alert-success">
                        <h6 class="alert-heading">ملخص التصدير</h6>
                        <ul class="mb-0">
                            <li>إجمالي التقارير: <?php echo e($reports->count()); ?></li>
                            <li>تقارير تم الاتفاق: <?php echo e($reports->where('agreement_status', 'agreed')->count()); ?></li>
                            <li>تقارير تم الرفض: <?php echo e($reports->where('agreement_status', 'rejected')->count()); ?></li>
                            <li>تقارير بحاجة إلى وقت: <?php echo e($reports->where('agreement_status', 'needs_time')->count()); ?></li>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sales-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\sales\marketing-reports\export.blade.php ENDPATH**/ ?>