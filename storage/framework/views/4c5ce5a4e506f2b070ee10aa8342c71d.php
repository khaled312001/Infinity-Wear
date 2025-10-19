<?php $__env->startSection('title', 'عرض بيانات المشرف'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'عرض بيانات المشرف'); ?>
<?php $__env->startSection('page-subtitle', 'عرض بيانات المشرف: ' . $admin->name); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2 text-primary"></i>
                    بيانات المشرف
                </h5>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('admin.admins.edit', $admin)); ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>
                        تعديل
                    </a>
                    <a href="<?php echo e(route('admin.admins.index')); ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-right me-1"></i>
                        العودة
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">الاسم:</label>
                                <p class="form-control-plaintext"><?php echo e($admin->name); ?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">البريد الإلكتروني:</label>
                                <p class="form-control-plaintext"><?php echo e($admin->email); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">الدور:</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-info"><?php echo e($admin->role_label); ?></span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">الحالة:</label>
                                <p class="form-control-plaintext">
                                    <?php if($admin->is_active): ?>
                                        <span class="badge bg-success">نشط</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">غير نشط</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">تاريخ الإنشاء:</label>
                                <p class="form-control-plaintext"><?php echo e($admin->created_at->format('Y-m-d H:i')); ?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">آخر تحديث:</label>
                                <p class="form-control-plaintext"><?php echo e($admin->updated_at->format('Y-m-d H:i')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-user-circle fa-5x text-primary"></i>
                            </div>
                            <h5><?php echo e($admin->name); ?></h5>
                            <p class="text-muted"><?php echo e($admin->role_label); ?></p>
                            
                            <?php if($admin->id === auth('admin')->id()): ?>
                                <span class="badge bg-warning">أنت</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\admins\show.blade.php ENDPATH**/ ?>