

<?php $__env->startSection('title', 'طلبات المستوردين - فريق المبيعات'); ?>
<?php $__env->startSection('dashboard-title', 'طلبات المستوردين'); ?>
<?php $__env->startSection('page-title', 'قائمة طلبات المستوردين'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة وتتبع طلبات المستوردين'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-truck me-2"></i>
            قائمة طلبات المستوردين
        </h5>
    </div>
    <div class="card-body">
        <p>عدد الطلبات: <?php echo e($orders->count()); ?></p>
        
        <?php if($orders->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>المستورد</th>
                            <th>التكلفة النهائية</th>
                            <th>الحالة</th>
                            <th>تاريخ الطلب</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>#<?php echo e($order->order_number ?? $order->id); ?></td>
                                <td><?php echo e($order->importer->company_name ?? 'غير محدد'); ?></td>
                                <td><?php echo e(number_format($order->final_cost)); ?> ريال</td>
                                <td>
                                    <?php switch($order->status):
                                        case ('new'): ?>
                                            <span class="badge bg-primary">جديد</span>
                                            <?php break; ?>
                                        <?php case ('processing'): ?>
                                            <span class="badge bg-info">قيد المعالجة</span>
                                            <?php break; ?>
                                        <?php case ('completed'): ?>
                                            <span class="badge bg-success">مكتمل</span>
                                            <?php break; ?>
                                        <?php case ('cancelled'): ?>
                                            <span class="badge bg-danger">ملغي</span>
                                            <?php break; ?>
                                        <?php default: ?>
                                            <span class="badge bg-secondary"><?php echo e($order->status); ?></span>
                                    <?php endswitch; ?>
                                </td>
                                <td><?php echo e($order->created_at->format('Y-m-d H:i')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('sales.importer-orders.show', $order)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($orders->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">لا توجد طلبات مستوردين حالياً</h5>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.sales-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\sales\importer-orders\index.blade.php ENDPATH**/ ?>