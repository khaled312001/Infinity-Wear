

<?php $__env->startSection('title', 'المستوردين - فريق المبيعات'); ?>
<?php $__env->startSection('dashboard-title', 'المستوردين'); ?>
<?php $__env->startSection('page-title', 'قائمة المستوردين'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة وتتبع المستوردين'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-industry me-2"></i>
            قائمة المستوردين
        </h5>
    </div>
    <div class="card-body">
        <?php if($importers->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>اسم الشركة</th>
                            <th>جهة الاتصال</th>
                            <th>الهاتف</th>
                            <th>البريد الإلكتروني</th>
                            <th>الحالة</th>
                            <th>تاريخ التسجيل</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $importers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $importer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($importer->company_name ?? 'غير محدد'); ?></td>
                                <td><?php echo e($importer->contact_name ?? 'غير محدد'); ?></td>
                                <td><?php echo e($importer->phone ?? 'غير محدد'); ?></td>
                                <td><?php echo e($importer->email ?? 'غير محدد'); ?></td>
                                <td>
                                    <?php switch($importer->status):
                                        case ('new'): ?>
                                            <span class="badge bg-primary">جديد</span>
                                            <?php break; ?>
                                        <?php case ('contacted'): ?>
                                            <span class="badge bg-info">تم التواصل</span>
                                            <?php break; ?>
                                        <?php case ('qualified'): ?>
                                            <span class="badge bg-success">مؤهل</span>
                                            <?php break; ?>
                                        <?php case ('unqualified'): ?>
                                            <span class="badge bg-danger">غير مؤهل</span>
                                            <?php break; ?>
                                        <?php default: ?>
                                            <span class="badge bg-secondary"><?php echo e($importer->status); ?></span>
                                    <?php endswitch; ?>
                                </td>
                                <td><?php echo e($importer->created_at->format('Y-m-d H:i')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('sales.importers.show', $importer)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($importers->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-industry fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">لا يوجد مستوردين حالياً</h5>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.sales-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\sales\importers\index.blade.php ENDPATH**/ ?>