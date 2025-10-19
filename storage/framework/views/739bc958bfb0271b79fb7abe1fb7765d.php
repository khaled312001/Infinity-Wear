

<?php $__env->startSection('title', 'تفاصيل التقرير'); ?>
<?php $__env->startSection('dashboard-title', 'تفاصيل التقرير'); ?>
<?php $__env->startSection('page-title', 'تفاصيل تقرير المندوب التسويقي'); ?>
<?php $__env->startSection('page-subtitle', 'مراجعة تفاصيل التقرير'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- تفاصيل التقرير -->
    <div class="col-lg-8 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        تفاصيل التقرير
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('admin.marketing-reports.edit', $marketingReport)); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>
                            تعديل
                        </a>
                        <a href="<?php echo e(route('admin.marketing-reports.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">اسم المندوب</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->representative_name); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">اسم الشركة</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->company_name); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">نوع النشاط</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->getCompanyActivityText()); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">نوع الزيارة</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->getVisitTypeText()); ?></p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">عنوان الشركة</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->company_address); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">اسم المسؤول</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->responsible_name); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">هاتف المسؤول</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->responsible_phone); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">منصب المسؤول</label>
                        <p class="form-control-plaintext"><?php echo e($marketingReport->responsible_position); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">حالة الاتفاق</label>
                        <span class="badge bg-<?php echo e($marketingReport->agreement_status === 'agreed' ? 'success' : ($marketingReport->agreement_status === 'rejected' ? 'danger' : 'warning')); ?>">
                            <?php echo e($marketingReport->getAgreementStatusText()); ?>

                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">الكمية المستهدفة</label>
                        <p class="form-control-plaintext"><?php echo e(number_format($marketingReport->target_quantity)); ?></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">الاستهلاك السنوي</label>
                        <p class="form-control-plaintext"><?php echo e(number_format($marketingReport->annual_consumption)); ?></p>
                    </div>
                </div>

                <?php if($marketingReport->customer_concerns && count($marketingReport->customer_concerns) > 0): ?>
                <div class="mb-3">
                    <label class="form-label fw-bold">مخاوف العميل</label>
                    <ul class="list-group">
                        <?php $__currentLoopData = $marketingReport->customer_concerns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $concern): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item"><?php echo e($concern); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label fw-bold">التوصيات</label>
                    <p class="form-control-plaintext"><?php echo e($marketingReport->recommendations); ?></p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">الخطوات التالية</label>
                    <p class="form-control-plaintext"><?php echo e($marketingReport->next_steps); ?></p>
                </div>

                <?php if($marketingReport->notes): ?>
                <div class="mb-3">
                    <label class="form-label fw-bold">ملاحظات المندوب</label>
                    <p class="form-control-plaintext"><?php echo e($marketingReport->notes); ?></p>
                </div>
                <?php endif; ?>

                <?php if($marketingReport->admin_notes): ?>
                <div class="mb-3">
                    <label class="form-label fw-bold">ملاحظات الإدارة</label>
                    <p class="form-control-plaintext"><?php echo e($marketingReport->admin_notes); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- معلومات إضافية -->
    <div class="col-lg-4 mb-4">
        <!-- حالة التقرير -->
        <div class="dashboard-card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    حالة التقرير
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">الحالة الحالية</label>
                    <div>
                        <span class="badge bg-<?php echo e($marketingReport->getStatusBadgeClass()); ?> fs-6">
                            <?php echo e($marketingReport->getStatusText()); ?>

                        </span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">تاريخ الإنشاء</label>
                    <p class="form-control-plaintext"><?php echo e($marketingReport->created_at->format('Y-m-d H:i')); ?></p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">آخر تحديث</label>
                    <p class="form-control-plaintext"><?php echo e($marketingReport->updated_at->format('Y-m-d H:i')); ?></p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">أنشأ بواسطة</label>
                    <p class="form-control-plaintext"><?php echo e($marketingReport->creator->name ?? 'غير محدد'); ?></p>
                </div>

                <?php if($marketingReport->reviewed_at): ?>
                <div class="mb-3">
                    <label class="form-label fw-bold">تم المراجعة في</label>
                    <p class="form-control-plaintext"><?php echo e($marketingReport->reviewed_at->format('Y-m-d H:i')); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- تحديث الحالة -->
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    تحديث الحالة
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.marketing-reports.update-status', $marketingReport)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    
                    <div class="mb-3">
                        <label class="form-label">الحالة الجديدة</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" <?php echo e($marketingReport->status === 'pending' ? 'selected' : ''); ?>>قيد المراجعة</option>
                            <option value="under_review" <?php echo e($marketingReport->status === 'under_review' ? 'selected' : ''); ?>>قيد المراجعة</option>
                            <option value="approved" <?php echo e($marketingReport->status === 'approved' ? 'selected' : ''); ?>>موافق عليه</option>
                            <option value="rejected" <?php echo e($marketingReport->status === 'rejected' ? 'selected' : ''); ?>>مرفوض</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ملاحظات الإدارة</label>
                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="أضف ملاحظاتك هنا..."><?php echo e($marketingReport->admin_notes); ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>
                        تحديث الحالة
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- صور الشركة -->
<?php if($marketingReport->company_images && count($marketingReport->company_images) > 0): ?>
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-images me-2"></i>
                    صور الشركة
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php $__currentLoopData = $marketingReport->company_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <img src="<?php echo e(asset('storage/' . $image)); ?>" class="card-img-top" alt="صورة الشركة" style="height: 200px; object-fit: cover;">
                            <div class="card-body p-2">
                                <small class="text-muted"><?php echo e($image); ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\marketing-reports\show.blade.php ENDPATH**/ ?>