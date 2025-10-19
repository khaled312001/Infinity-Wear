<?php $__env->startSection('title', 'إدارة المشرفين'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'إدارة المشرفين'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة وعرض جميع المشرفين في النظام'); ?>

<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('admin.admins.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        إضافة مشرف جديد
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <?php if($admins->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الدور</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($admin->name); ?></td>
                                <td><?php echo e($admin->email); ?></td>
                                <td>
                                    <span class="badge bg-info"><?php echo e($admin->role_label ?? 'مشرف'); ?></span>
                                </td>
                                <td><?php echo e($admin->created_at->format('Y-m-d')); ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.admins.show', $admin)); ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.admins.edit', $admin)); ?>" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if($admin->id !== auth('admin')->id()): ?>
                                        <form method="POST" 
                                              action="<?php echo e(route('admin.admins.destroy', $admin)); ?>" 
                                              class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا المشرف؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center">
                    <?php echo e($admins->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <h4>لا يوجد مشرفين</h4>
                    <p>ابدأ بإضافة أول مشرف للنظام</p>
                    <a href="<?php echo e(route('admin.admins.create')); ?>" class="btn btn-primary">
                        إضافة مشرف جديد
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\admins\index.blade.php ENDPATH**/ ?>