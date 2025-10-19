

<?php $__env->startSection('title', 'تقارير المندوبين التسويقيين'); ?>
<?php $__env->startSection('dashboard-title', 'تقارير المندوبين التسويقيين'); ?>
<?php $__env->startSection('page-title', 'تقارير المندوبين التسويقيين'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة تقارير المندوبين التسويقيين'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- إحصائيات التقارير -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e(number_format($stats['total'])); ?></h3>
                    <p class="mb-0 text-muted">إجمالي التقارير</p>
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
                    <h3 class="mb-0"><?php echo e(number_format($stats['pending'])); ?></h3>
                    <p class="mb-0 text-muted">قيد المراجعة</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e(number_format($stats['approved'])); ?></h3>
                    <p class="mb-0 text-muted">موافق عليها</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e(number_format($stats['this_month'])); ?></h3>
                    <p class="mb-0 text-muted">هذا الشهر</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- إحصائيات إضافية -->
<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon success">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e(number_format($stats['under_review'])); ?></h3>
                    <p class="mb-0 text-muted">قيد المراجعة</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon primary">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e(number_format($stats['this_week'])); ?></h3>
                    <p class="mb-0 text-muted">هذا الأسبوع</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon warning">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e(number_format($stats['today'])); ?></h3>
                    <p class="mb-0 text-muted">اليوم</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0"><?php echo e(number_format($salesStats['total_target_quantity'])); ?></h3>
                    <p class="mb-0 text-muted">إجمالي الكمية المستهدفة</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- إحصائيات المندوبين -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>
                    إحصائيات المندوبين
                </h5>
            </div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $representativeStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted"><?php echo e($stat->representative_name); ?></span>
                        <span class="fw-bold"><?php echo e($stat->count); ?> تقرير</span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center text-muted py-4">
                    <i class="fas fa-users fa-3x mb-3"></i>
                    <p>لا توجد إحصائيات متاحة</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- إحصائيات حالة الاتفاق -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-handshake me-2"></i>
                    إحصائيات حالة الاتفاق
                </h5>
            </div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $agreementStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">
                            <?php switch($stat->agreement_status):
                                case ('agreed'): ?> تم الاتفاق <?php break; ?>
                                <?php case ('rejected'): ?> تم الرفض <?php break; ?>
                                <?php case ('needs_time'): ?> بحاجة إلى وقت <?php break; ?>
                                <?php default: ?> غير محدد
                            <?php endswitch; ?>
                        </span>
                        <span class="fw-bold"><?php echo e($stat->count); ?></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center text-muted py-4">
                    <i class="fas fa-handshake fa-3x mb-3"></i>
                    <p>لا توجد إحصائيات متاحة</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- إحصائيات إضافية -->
<div class="row">
    <!-- إحصائيات نوع الزيارة -->
    <div class="col-lg-4 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-route me-2"></i>
                    إحصائيات نوع الزيارة
                </h5>
            </div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $visitTypeStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">
                            <?php switch($stat->visit_type):
                                case ('office_visit'): ?> زيارة مقر <?php break; ?>
                                <?php case ('phone_call'): ?> اتصال <?php break; ?>
                                <?php case ('whatsapp'): ?> رسائل Whatsapp <?php break; ?>
                                <?php default: ?> غير محدد
                            <?php endswitch; ?>
                        </span>
                        <span class="fw-bold"><?php echo e($stat->count); ?></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center text-muted py-4">
                    <i class="fas fa-route fa-3x mb-3"></i>
                    <p>لا توجد إحصائيات متاحة</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- إحصائيات نوع النشاط -->
    <div class="col-lg-4 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-building me-2"></i>
                    إحصائيات نوع النشاط
                </h5>
            </div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $activityStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">
                            <?php switch($stat->company_activity):
                                case ('sports_academy'): ?> أكاديمية رياضية <?php break; ?>
                                <?php case ('school'): ?> مدرسة <?php break; ?>
                                <?php case ('institution_company'): ?> مؤسسة / شركة <?php break; ?>
                                <?php case ('wholesale_store'): ?> محل جملة <?php break; ?>
                                <?php case ('retail_store'): ?> محل تجزئة <?php break; ?>
                                <?php case ('other'): ?> أخرى <?php break; ?>
                                <?php default: ?> غير محدد
                            <?php endswitch; ?>
                        </span>
                        <span class="fw-bold"><?php echo e($stat->count); ?></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center text-muted py-4">
                    <i class="fas fa-building fa-3x mb-3"></i>
                    <p>لا توجد إحصائيات متاحة</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- إحصائيات المبيعات -->
    <div class="col-lg-4 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    إحصائيات المبيعات
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">إجمالي الاستهلاك السنوي</span>
                        <span class="fw-bold"><?php echo e(number_format($salesStats['total_annual_consumption'])); ?></span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">متوسط الكمية المستهدفة</span>
                        <span class="fw-bold"><?php echo e(number_format($salesStats['avg_target_quantity'], 0)); ?></span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">متوسط الاستهلاك السنوي</span>
                        <span class="fw-bold"><?php echo e(number_format($salesStats['avg_annual_consumption'], 0)); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- قائمة التقارير -->
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        قائمة التقارير
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('sales.marketing-reports.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            تقرير جديد
                        </a>
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="fas fa-download me-2"></i>
                            تصدير
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>المندوب</th>
                                <th>الجهة</th>
                                <th>نوع الزيارة</th>
                                <th>حالة الاتفاق</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <?php echo e(substr($report->representative_name, 0, 1)); ?>

                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo e($report->representative_name); ?></h6>
                                            <small class="text-muted"><?php echo e($report->creator->name ?? 'غير محدد'); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-0"><?php echo e($report->company_name); ?></h6>
                                        <small class="text-muted"><?php echo e($report->getCompanyActivityText()); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <?php echo e($report->getVisitTypeText()); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($report->agreement_status === 'agreed' ? 'success' : ($report->agreement_status === 'rejected' ? 'danger' : 'warning')); ?>">
                                        <?php echo e($report->getAgreementStatusText()); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($report->getStatusBadgeClass()); ?>">
                                        <?php echo e($report->getStatusText()); ?>

                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <small class="text-muted"><?php echo e($report->created_at->format('Y-m-d')); ?></small>
                                        <br>
                                        <small class="text-muted"><?php echo e($report->created_at->format('H:i')); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('sales.marketing-reports.show', $report)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('sales.marketing-reports.edit', $report)); ?>" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('sales.marketing-reports.destroy', $report)); ?>" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقرير؟')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                                        <p>لا توجد تقارير متاحة</p>
                                        <a href="<?php echo e(route('sales.marketing-reports.create')); ?>" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>
                                            إنشاء تقرير جديد
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($reports->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal تصدير التقارير -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تصدير التقارير</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('sales.marketing-reports.export')); ?>" method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">المندوب</label>
                            <select name="representative_name" class="form-select">
                                <option value="">جميع المندوبين</option>
                                <?php $__currentLoopData = $representativeStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($stat->representative_name); ?>"><?php echo e($stat->representative_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">حالة الاتفاق</label>
                            <select name="agreement_status" class="form-select">
                                <option value="">جميع الحالات</option>
                                <option value="agreed">تم الاتفاق</option>
                                <option value="rejected">تم الرفض</option>
                                <option value="needs_time">بحاجة إلى وقت</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">نوع الزيارة</label>
                            <select name="visit_type" class="form-select">
                                <option value="">جميع الأنواع</option>
                                <option value="office_visit">زيارة مقر</option>
                                <option value="phone_call">اتصال</option>
                                <option value="whatsapp">رسائل Whatsapp</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">من تاريخ</label>
                            <input type="date" name="date_from" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">إلى تاريخ</label>
                            <input type="date" name="date_to" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">تصدير</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sales-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\sales\marketing-reports\index.blade.php ENDPATH**/ ?>