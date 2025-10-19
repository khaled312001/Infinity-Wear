

<?php $__env->startSection('title', 'طلباتي - لوحة تحكم المستورد'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة المستورد'); ?>
<?php $__env->startSection('page-title', 'طلباتي'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة ومتابعة طلباتك'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>
                        طلباتي
                    </h5>
                    <span class="badge bg-primary"><?php echo e($orders->total()); ?> طلب</span>
                </div>
                
                <div class="card-body">
                    <?php if($orders->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>التاريخ</th>
                                        <th>الكمية</th>
                                        <th>الحالة</th>
                                        <th>المتطلبات</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <strong>#<?php echo e($order->order_number); ?></strong>
                                            </td>
                                            <td>
                                                <?php echo e($order->created_at->format('Y-m-d')); ?>

                                                <br>
                                                <small class="text-muted"><?php echo e($order->created_at->format('H:i')); ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?php echo e($order->quantity); ?> قطعة</span>
                                            </td>
                                            <td>
                                                <?php switch($order->status):
                                                    case ('new'): ?>
                                                        <span class="badge bg-warning">جديد</span>
                                                        <?php break; ?>
                                                    <?php case ('in_progress'): ?>
                                                        <span class="badge bg-primary">قيد التنفيذ</span>
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
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;" title="<?php echo e($order->requirements); ?>">
                                                    <?php echo e(Str::limit($order->requirements, 50)); ?>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#orderModal<?php echo e($order->id); ?>">
                                                        <i class="fas fa-eye"></i>
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
                            <?php echo e($orders->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد طلبات بعد</h5>
                            <p class="text-muted">لم تقم بإنشاء أي طلبات حتى الآن</p>
                            <a href="<?php echo e(route('importers.form')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                إنشاء طلب جديد
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modals -->
<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="orderModal<?php echo e($order->id); ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تفاصيل الطلب #<?php echo e($order->order_number); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>معلومات الطلب</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>رقم الطلب:</strong></td>
                                <td>#<?php echo e($order->order_number); ?></td>
                            </tr>
                            <tr>
                                <td><strong>التاريخ:</strong></td>
                                <td><?php echo e($order->created_at->format('Y-m-d H:i')); ?></td>
                            </tr>
                            <tr>
                                <td><strong>الكمية:</strong></td>
                                <td><?php echo e($order->quantity); ?> قطعة</td>
                            </tr>
                            <tr>
                                <td><strong>الحالة:</strong></td>
                                <td>
                                    <?php switch($order->status):
                                        case ('new'): ?>
                                            <span class="badge bg-warning">جديد</span>
                                            <?php break; ?>
                                        <?php case ('in_progress'): ?>
                                            <span class="badge bg-primary">قيد التنفيذ</span>
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
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>المتطلبات</h6>
                        <div class="border rounded p-3">
                            <p><?php echo e($order->requirements); ?></p>
                        </div>
                    </div>
                </div>
                
                <?php if($order->design_details): ?>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>تفاصيل التصميم</h6>
                            <div class="border rounded p-3">
                                <?php
                                    $designDetails = json_decode($order->design_details, true);
                                ?>
                                
                                <?php if(isset($designDetails['option'])): ?>
                                    <p><strong>نوع التصميم:</strong> 
                                        <?php switch($designDetails['option']):
                                            case ('text'): ?>
                                                نص مكتوب
                                                <?php break; ?>
                                            <?php case ('upload'): ?>
                                                ملف مرفوع
                                                <?php break; ?>
                                            <?php case ('template'): ?>
                                                قالب ثلاثي الأبعاد
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if(isset($designDetails['text'])): ?>
                                    <p><strong>النص:</strong> <?php echo e($designDetails['text']); ?></p>
                                <?php endif; ?>
                                
                                <?php if(isset($designDetails['file_path'])): ?>
                                    <p><strong>الملف:</strong> 
                                        <a href="<?php echo e(asset('storage/' . $designDetails['file_path'])); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download me-1"></i>
                                            تحميل الملف
                                        </a>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if(isset($designDetails['notes'])): ?>
                                    <p><strong>ملاحظات:</strong> <?php echo e($designDetails['notes']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\importers\orders.blade.php ENDPATH**/ ?>