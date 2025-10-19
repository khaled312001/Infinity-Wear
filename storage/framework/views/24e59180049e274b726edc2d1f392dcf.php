<?php $__env->startSection('title', 'فريق المبيعات'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'فريق المبيعات'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة فريق المبيعات ومتابعة الأداء'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-actions'); ?>
    <a href="#" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        إضافة عضو جديد
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-users me-2 text-primary"></i>
                أعضاء فريق المبيعات
            </h5>
        </div>
        <div class="card-body">
            <?php if($salesTeam->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>المنصب</th>
                                <th>القسم</th>
                                <th>الهاتف</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $salesTeam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo e($member->admin->name ?? 'غير محدد'); ?></h6>
                                            <small class="text-muted"><?php echo e($member->bio ?? 'لا يوجد وصف'); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo e($member->position ?? 'غير محدد'); ?></td>
                                <td><?php echo e($member->department ?? 'غير محدد'); ?></td>
                                <td><?php echo e($member->phone ?? 'غير محدد'); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($member->is_active ? 'success' : 'secondary'); ?>">
                                        <?php echo e($member->is_active ? 'نشط' : 'غير نشط'); ?>

                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($salesTeam->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا يوجد أعضاء في فريق المبيعات</h4>
                    <p class="text-muted mb-4">ابدأ بإضافة أعضاء جدد لفريق المبيعات</p>
                    <a href="#" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        إضافة عضو جديد
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\sales_team\index.blade.php ENDPATH**/ ?>