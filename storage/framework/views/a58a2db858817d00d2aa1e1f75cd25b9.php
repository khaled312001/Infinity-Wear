

<?php $__env->startSection('title', 'تفاصيل طلب المستورد - فريق المبيعات'); ?>
<?php $__env->startSection('dashboard-title', 'تفاصيل طلب المستورد'); ?>
<?php $__env->startSection('page-title', 'تفاصيل طلب المستورد #' . $order->order_number); ?>
<?php $__env->startSection('page-subtitle', 'عرض تفاصيل طلب المستورد'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-truck me-2"></i>
                    تفاصيل طلب المستورد
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>معلومات الطلب</h6>
                        <ul class="list-unstyled">
                            <li><strong>رقم الطلب:</strong> #<?php echo e($order->order_number ?? $order->id); ?></li>
                            <li><strong>المستورد:</strong> <?php echo e($order->importer->company_name ?? 'غير محدد'); ?></li>
                            <li><strong>التكلفة النهائية:</strong> <?php echo e(number_format($order->final_cost)); ?> ريال</li>
                            <li><strong>الحالة:</strong> 
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
                                <?php endswitch; ?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>معلومات إضافية</h6>
                        <ul class="list-unstyled">
                            <li><strong>تاريخ الطلب:</strong> <?php echo e($order->created_at->format('Y-m-d H:i')); ?></li>
                            <li><strong>آخر تحديث:</strong> <?php echo e($order->updated_at->format('Y-m-d H:i')); ?></li>
                        </ul>
                    </div>
                </div>
                
                <?php if($order->notes): ?>
                    <div class="mt-3">
                        <h6>ملاحظات</h6>
                        <div class="alert alert-info">
                            <?php echo e($order->notes); ?>

                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    إدارة طلب المستورد
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('sales.importer-orders.update-status', $order)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="mb-3">
                        <label for="status" class="form-label">تغيير الحالة</label>
                        <select name="status" id="status" class="form-select">
                            <option value="new" <?php echo e($order->status === 'new' ? 'selected' : ''); ?>>جديد</option>
                            <option value="processing" <?php echo e($order->status === 'processing' ? 'selected' : ''); ?>>قيد المعالجة</option>
                            <option value="completed" <?php echo e($order->status === 'completed' ? 'selected' : ''); ?>>مكتمل</option>
                            <option value="cancelled" <?php echo e($order->status === 'cancelled' ? 'selected' : ''); ?>>ملغي</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">ملاحظات</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3"><?php echo e($order->notes); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>
                        حفظ التغييرات
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sales-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\sales\importer-orders\show.blade.php ENDPATH**/ ?>