<?php $__env->startSection('title', 'تفاصيل الملاحظة'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'تفاصيل الملاحظة'); ?>
<?php $__env->startSection('page-subtitle', 'عرض تفاصيل ملاحظة العميل'); ?>
<?php $__env->startSection('profile-route', '#'); ?>
<?php $__env->startSection('settings-route', '#'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-sticky-note me-2 text-primary"></i>
                            <?php echo e($customerNote->title); ?>

                        </h5>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e(route('admin.customer-notes.edit', $customerNote)); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit me-1"></i>
                                تعديل
                            </a>
                            <a href="<?php echo e(route('admin.customer-notes.index')); ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-right me-1"></i>
                                العودة
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- معلومات الملاحظة -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">نوع الملاحظة:</label>
                                <span class="badge bg-<?php echo e($customerNote->note_type_color); ?> fs-6">
                                    <?php echo e($customerNote->note_type_label); ?>

                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">الأولوية:</label>
                                <span class="badge bg-<?php echo e($customerNote->priority_color); ?> fs-6">
                                    <?php echo e($customerNote->priority_label); ?>

                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">تاريخ الإضافة:</label>
                                <span class="info-value"><?php echo e($customerNote->created_at->format('Y-m-d H:i')); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">آخر تحديث:</label>
                                <span class="info-value"><?php echo e($customerNote->updated_at->format('Y-m-d H:i')); ?></span>
                            </div>
                        </div>
                        <?php if($customerNote->follow_up_date): ?>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">تاريخ المتابعة:</label>
                                <span class="info-value text-warning">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <?php echo e($customerNote->follow_up_date->format('Y-m-d H:i')); ?>

                                </span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">أضيف بواسطة:</label>
                                <span class="info-value"><?php echo e($customerNote->addedBy->name); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- التصنيفات -->
                    <?php if($customerNote->tags && count($customerNote->tags) > 0): ?>
                    <div class="mb-4">
                        <label class="info-label">التصنيفات:</label>
                        <div class="mt-2">
                            <?php $__currentLoopData = $customerNote->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge bg-light text-dark me-2 mb-2">
                                    <i class="fas fa-tag me-1"></i>
                                    <?php echo e($tag); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- محتوى الملاحظة -->
                    <div class="mb-4">
                        <label class="info-label">محتوى الملاحظة:</label>
                        <div class="note-content p-3 bg-light rounded">
                            <?php echo nl2br(e($customerNote->content)); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- معلومات العميل -->
            <div class="dashboard-card mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-user me-2 text-primary"></i>
                        معلومات العميل
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="customer-avatar me-3">
                            <i class="fas fa-user-circle fa-3x text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-1"><?php echo e($customerNote->customer->name); ?></h6>
                            <small class="text-muted"><?php echo e($customerNote->customer->email); ?></small>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <label class="info-label">تاريخ التسجيل:</label>
                        <span class="info-value"><?php echo e($customerNote->customer->created_at->format('Y-m-d')); ?></span>
                    </div>
                    
                    <?php if($customerNote->customer->phone): ?>
                    <div class="info-item">
                        <label class="info-label">الهاتف:</label>
                        <span class="info-value"><?php echo e($customerNote->customer->phone); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($customerNote->customer->city): ?>
                    <div class="info-item">
                        <label class="info-label">المدينة:</label>
                        <span class="info-value"><?php echo e($customerNote->customer->city); ?></span>
                    </div>
                    <?php endif; ?>

                    <div class="mt-3">
                        <a href="<?php echo e(route('admin.customer-notes.customer-notes', $customerNote->customer)); ?>" class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-sticky-note me-1"></i>
                            جميع ملاحظات هذا العميل
                        </a>
                    </div>
                </div>
            </div>

            <!-- الإجراءات السريعة -->
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-cogs me-2 text-primary"></i>
                        الإجراءات السريعة
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('admin.customer-notes.edit', $customerNote)); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>
                            تعديل الملاحظة
                        </a>
                        
                        <?php if($customerNote->status == 'active'): ?>
                        <form action="<?php echo e(route('admin.customer-notes.archive', $customerNote)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-warning w-100" onclick="return confirm('هل أنت متأكد من أرشفة هذه الملاحظة؟')">
                                <i class="fas fa-archive me-2"></i>
                                أرشفة الملاحظة
                            </button>
                        </form>
                        <?php else: ?>
                        <form action="<?php echo e(route('admin.customer-notes.restore', $customerNote)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-success w-100">
                                <i class="fas fa-undo me-2"></i>
                                استعادة الملاحظة
                            </button>
                        </form>
                        <?php endif; ?>
                        
                        <form action="<?php echo e(route('admin.customer-notes.destroy', $customerNote)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-outline-danger w-100" onclick="return confirm('هل أنت متأكد من حذف هذه الملاحظة نهائياً؟')">
                                <i class="fas fa-trash me-2"></i>
                                حذف الملاحظة
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.info-item {
    margin-bottom: 1rem;
}

.info-label {
    font-weight: 600;
    color: #6c757d;
    display: block;
    margin-bottom: 0.25rem;
}

.info-value {
    color: #212529;
    font-weight: 500;
}

.note-content {
    line-height: 1.6;
    font-size: 1rem;
}

.customer-avatar {
    text-align: center;
}
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\customer-notes\show.blade.php ENDPATH**/ ?>