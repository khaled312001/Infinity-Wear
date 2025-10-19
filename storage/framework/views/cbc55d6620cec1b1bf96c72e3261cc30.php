

<?php $__env->startSection('title', 'عرض تقرير المندوب التسويقي'); ?>
<?php $__env->startSection('dashboard-title', 'عرض تقرير المندوب التسويقي'); ?>
<?php $__env->startSection('page-title', 'عرض تقرير المندوب التسويقي'); ?>
<?php $__env->startSection('page-subtitle', 'تفاصيل تقرير المندوب التسويقي'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        تقرير المندوب التسويقي
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('sales.marketing-reports.edit', $marketingReport)); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>
                            تعديل
                        </a>
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#statusModal">
                            <i class="fas fa-flag me-2"></i>
                            تغيير الحالة
                        </button>
                        <a href="<?php echo e(route('sales.marketing-reports.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- معلومات المندوب -->
                    <div class="col-12 mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-user me-2"></i>
                            معلومات المندوب
                        </h6>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">اسم المندوب</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->representative_name); ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">تاريخ الإنشاء</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->created_at->format('Y-m-d H:i')); ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">منشئ التقرير</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->creator->name ?? 'غير محدد'); ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">حالة التقرير</label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-<?php echo e($marketingReport->getStatusBadgeClass()); ?>">
                                <?php echo e($marketingReport->getStatusText()); ?>

                            </span>
                        </p>
                    </div>

                    <!-- معلومات الجهة -->
                    <div class="col-12 mb-4 mt-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-building me-2"></i>
                            معلومات الجهة
                        </h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">اسم الجهة</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->company_name); ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">نشاط الجهة</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->getCompanyActivityText()); ?></p>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">عنوان الجهة التفصيلي</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->company_address); ?></p>
                    </div>

                    <?php if($marketingReport->company_images && count($marketingReport->company_images) > 0): ?>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">صور المكان</label>
                        <div class="row">
                            <?php $__currentLoopData = $marketingReport->company_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-3 mb-2">
                                <img src="<?php echo e(Storage::url($image)); ?>" class="img-thumbnail" style="width: 100%; height: 200px; object-fit: cover;" alt="صورة المكان">
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- معلومات المسئول -->
                    <div class="col-12 mb-4 mt-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-user-tie me-2"></i>
                            معلومات المسئول
                        </h6>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">اسم المسئول</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->responsible_name); ?></p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">رقم الجوال</label>
                        <p class="form-control-plaintext">
                            <a href="tel:<?php echo e($marketingReport->responsible_phone); ?>" class="text-decoration-none">
                                <?php echo e($marketingReport->responsible_phone); ?>

                            </a>
                        </p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">المنصب</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->responsible_position); ?></p>
                    </div>

                    <!-- تفاصيل الزيارة -->
                    <div class="col-12 mb-4 mt-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-calendar-check me-2"></i>
                            تفاصيل الزيارة
                        </h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">نوع الزيارة</label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-info">
                                <?php echo e($marketingReport->getVisitTypeText()); ?>

                            </span>
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">حالة الاتفاق</label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-<?php echo e($marketingReport->agreement_status === 'agreed' ? 'success' : ($marketingReport->agreement_status === 'rejected' ? 'danger' : 'warning')); ?>">
                                <?php echo e($marketingReport->getAgreementStatusText()); ?>

                            </span>
                        </p>
                    </div>

                    <?php if($marketingReport->customer_concerns && count($marketingReport->customer_concerns) > 0): ?>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">مخاوف العميل</label>
                        <div class="d-flex flex-wrap gap-2">
                            <?php $__currentLoopData = $marketingReport->customer_concerns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $concern): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge bg-warning"><?php echo e($concern); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- التفاصيل التجارية -->
                    <div class="col-12 mb-4 mt-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-chart-line me-2"></i>
                            التفاصيل التجارية
                        </h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">الكمية المستهدفة</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->target_quantity); ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">الاستهلاك السنوي أو عدد الطلبيات السنوية المتوقعة</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->annual_consumption); ?></p>
                    </div>

                    <!-- التوصيات والخطوات -->
                    <div class="col-12 mb-4 mt-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-lightbulb me-2"></i>
                            التوصيات والخطوات
                        </h6>
                    </div>

                    <?php if($marketingReport->recommendations): ?>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">توصيات مقترحة وملاحظات</label>
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0"><?php echo e($marketingReport->recommendations); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($marketingReport->next_steps): ?>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">الخطوات اللاحقة التي ستم تنفيذها مع هذا العميل</label>
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0"><?php echo e($marketingReport->next_steps); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($marketingReport->notes): ?>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">ملاحظات إضافية</label>
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0"><?php echo e($marketingReport->notes); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal تغيير الحالة -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تغيير حالة التقرير</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('sales.marketing-reports.update-status', $marketingReport)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الحالة الجديدة</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" <?php echo e($marketingReport->status == 'pending' ? 'selected' : ''); ?>>قيد المراجعة</option>
                            <option value="approved" <?php echo e($marketingReport->status == 'approved' ? 'selected' : ''); ?>>موافق عليه</option>
                            <option value="rejected" <?php echo e($marketingReport->status == 'rejected' ? 'selected' : ''); ?>>مرفوض</option>
                            <option value="under_review" <?php echo e($marketingReport->status == 'under_review' ? 'selected' : ''); ?>>قيد المراجعة</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="أضف ملاحظات حول تغيير الحالة..."><?php echo e($marketingReport->notes); ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sales-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\sales\marketing-reports\show.blade.php ENDPATH**/ ?>