<?php $__env->startSection('title', 'إدارة المستوردين'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'إدارة المستوردين'); ?>
<?php $__env->startSection('page-subtitle', 'عرض وإدارة جميع المستوردين في النظام'); ?>
<?php $__env->startSection('profile-route', '#'); ?>
<?php $__env->startSection('settings-route', '#'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('admin.importers.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        إضافة مستورد جديد
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2 text-primary"></i>
                    جميع المستوردين
                </h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="البحث في المستوردين..." id="searchInput">
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php if($importers->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الهاتف</th>
                                <th>نوع النشاط</th>
                                <th>الحالة</th>
                                <th>تاريخ التسجيل</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $importers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $importer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($importer->id); ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0"><?php echo e($importer->name); ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo e($importer->email); ?></td>
                                <td><?php echo e($importer->phone ?? 'غير محدد'); ?></td>
                                <td><?php echo e($importer->business_type_label ?? 'غير محدد'); ?></td>
                                <td>
                                    <?php if($importer->status == 'new'): ?>
                                        <span class="badge bg-primary">جديد</span>
                                    <?php elseif($importer->status == 'contacted'): ?>
                                        <span class="badge bg-info">تم التواصل</span>
                                    <?php elseif($importer->status == 'qualified'): ?>
                                        <span class="badge bg-warning">مؤهل</span>
                                    <?php elseif($importer->status == 'proposal'): ?>
                                        <span class="badge bg-secondary">تم تقديم عرض</span>
                                    <?php elseif($importer->status == 'negotiation'): ?>
                                        <span class="badge bg-warning">قيد التفاوض</span>
                                    <?php elseif($importer->status == 'closed_won'): ?>
                                        <span class="badge bg-success">تم إغلاق الصفقة بنجاح</span>
                                    <?php elseif($importer->status == 'closed_lost'): ?>
                                        <span class="badge bg-danger">تم إغلاق الصفقة بدون نجاح</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?php echo e($importer->status); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($importer->created_at->format('Y-m-d')); ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.importers.show', $importer->id)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.importers.edit', $importer->id)); ?>" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.importers.destroy', $importer->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المستورد؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($importers->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا يوجد مستوردين حتى الآن</h4>
                    <p class="text-muted mb-4">ابدأ بإضافة مستورد جديد للنظام</p>
                    <a href="<?php echo e(route('admin.importers.create')); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        إضافة مستورد جديد
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // البحث في المستوردين
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\importers\index.blade.php ENDPATH**/ ?>