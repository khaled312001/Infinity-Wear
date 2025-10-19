<?php $__env->startSection('title', 'عرض بيانات عضو فريق التسويق'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'عرض بيانات عضو فريق التسويق'); ?>
<?php $__env->startSection('page-subtitle', 'عرض بيانات عضو فريق التسويق: ' . $member->name); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2 text-primary"></i>
                    بيانات عضو فريق التسويق
                </h5>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('admin.marketing.edit', $member->id)); ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>
                        تعديل
                    </a>
                    <a href="<?php echo e(route('admin.marketing.index')); ?>" class="btn btn-secondary btn-sm">
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
                                <p class="form-control-plaintext"><?php echo e($member->name); ?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">البريد الإلكتروني:</label>
                                <p class="form-control-plaintext"><?php echo e($member->email); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">المنصب:</label>
                                <p class="form-control-plaintext"><?php echo e($member->position ?? 'غير محدد'); ?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">القسم:</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-info"><?php echo e($member->department ?? 'غير محدد'); ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">الهاتف:</label>
                                <p class="form-control-plaintext"><?php echo e($member->phone ?? 'غير محدد'); ?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">الحالة:</label>
                                <p class="form-control-plaintext">
                                    <?php if($member->is_active): ?>
                                        <span class="badge bg-success">نشط</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">غير نشط</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <?php if($member->bio): ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">نبذة شخصية:</label>
                        <p class="form-control-plaintext"><?php echo e($member->bio); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">تاريخ الانضمام:</label>
                                <p class="form-control-plaintext"><?php echo e($member->created_at->format('Y-m-d H:i')); ?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">آخر تحديث:</label>
                                <p class="form-control-plaintext"><?php echo e($member->updated_at->format('Y-m-d H:i')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <?php if($member->avatar): ?>
                                    <img src="<?php echo e(asset('storage/' . $member->avatar)); ?>" 
                                         alt="<?php echo e($member->name); ?>" 
                                         class="rounded-circle" 
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                <?php else: ?>
                                    <i class="fas fa-user-circle fa-5x text-primary"></i>
                                <?php endif; ?>
                            </div>
                            <h5><?php echo e($member->name); ?></h5>
                            <p class="text-muted"><?php echo e($member->position ?? 'عضو فريق التسويق'); ?></p>
                            <span class="badge bg-info"><?php echo e($member->department ?? 'التسويق'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if(isset($taskStats) && $taskStats['total'] > 0): ?>
            <div class="mt-4">
                <h6 class="mb-3">إحصائيات المهام</h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h4><?php echo e($taskStats['total']); ?></h4>
                                <p class="mb-0">إجمالي المهام</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <h4><?php echo e($taskStats['pending'] ?? 0); ?></h4>
                                <p class="mb-0">قيد الانتظار</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <h4><?php echo e($taskStats['in_progress'] ?? 0); ?></h4>
                                <p class="mb-0">قيد التنفيذ</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h4><?php echo e($taskStats['completed'] ?? 0); ?></h4>
                                <p class="mb-0">مكتملة</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if(isset($member->tasks) && $member->tasks->count() > 0): ?>
            <div class="mt-4">
                <h6 class="mb-3">المهام الأخيرة</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>عنوان المهمة</th>
                                <th>الحالة</th>
                                <th>الأولوية</th>
                                <th>تاريخ الإنشاء</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $member->tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($task->title); ?></td>
                                <td>
                                    <span class="badge bg-secondary"><?php echo e($task->status_label); ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?php echo e($task->priority_label); ?></span>
                                </td>
                                <td><?php echo e($task->created_at->format('Y-m-d')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\marketing_team\show.blade.php ENDPATH**/ ?>