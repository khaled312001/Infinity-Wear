<?php $__env->startSection('title', 'طلباتي'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة العميل'); ?>
<?php $__env->startSection('page-title', 'طلباتي'); ?>
<?php $__env->startSection('page-subtitle', 'عرض وتتبع جميع طلباتك'); ?>
<?php $__env->startSection('profile-route', route('customer.profile')); ?>
<?php $__env->startSection('settings-route', route('customer.settings')); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <a href="<?php echo e(route('customer.dashboard')); ?>" class="nav-link">
        <i class="fas fa-tachometer-alt me-2"></i>
        الرئيسية
    </a>
    <a href="<?php echo e(route('customer.orders')); ?>" class="nav-link active">
        <i class="fas fa-shopping-cart me-2"></i>
        طلباتي
    </a>
    <a href="<?php echo e(route('customer.profile')); ?>" class="nav-link">
        <i class="fas fa-user me-2"></i>
        الملف الشخصي
    </a>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-shopping-cart me-2 text-primary"></i>
                    جميع الطلبات
                </h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="statusFilter">
                        <option value="">جميع الحالات</option>
                        <option value="pending">قيد المعالجة</option>
                        <option value="processing">قيد التنفيذ</option>
                        <option value="completed">مكتمل</option>
                        <option value="cancelled">ملغي</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php if($orders->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>المنتج</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>الحالة</th>
                                <th>تاريخ الطلب</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-status="<?php echo e($order->status); ?>">
                                    <td>
                                        <strong>#<?php echo e($order->id); ?></strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if($order->product && $order->product->image): ?>
                                                <img src="<?php echo e(asset('storage/' . $order->product->image)); ?>" 
                                                     class="rounded me-3" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-tshirt text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <?php if($order->product): ?>
                                                    <strong><?php echo e($order->product->name); ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?php echo e($order->product->category->name ?? 'غير محدد'); ?></small>
                                                <?php else: ?>
                                                    <strong>تصميم مخصص</strong>
                                                    <br>
                                                    <small class="text-muted">طلب خاص</small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark"><?php echo e($order->quantity ?? 1); ?></span>
                                    </td>
                                    <td>
                                        <strong><?php echo e(number_format($order->total_price ?? 0, 2)); ?> ر.س</strong>
                                    </td>
                                    <td>
                                        <?php switch($order->status):
                                            case ('pending'): ?>
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i>
                                                    قيد المعالجة
                                                </span>
                                                <?php break; ?>
                                            <?php case ('processing'): ?>
                                                <span class="badge bg-info">
                                                    <i class="fas fa-cog me-1"></i>
                                                    قيد التنفيذ
                                                </span>
                                                <?php break; ?>
                                            <?php case ('completed'): ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>
                                                    مكتمل
                                                </span>
                                                <?php break; ?>
                                            <?php case ('cancelled'): ?>
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>
                                                    ملغي
                                                </span>
                                                <?php break; ?>
                                            <?php default: ?>
                                                <span class="badge bg-secondary"><?php echo e($order->status); ?></span>
                                        <?php endswitch; ?>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?php echo e($order->created_at->format('Y-m-d')); ?></strong>
                                            <br>
                                            <small class="text-muted"><?php echo e($order->created_at->format('H:i')); ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#orderModal<?php echo e($order->id); ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <?php if($order->status == 'pending'): ?>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="cancelOrder(<?php echo e($order->id); ?>)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Order Details Modal -->
                                <div class="modal fade" id="orderModal<?php echo e($order->id); ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">تفاصيل الطلب #<?php echo e($order->id); ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>معلومات الطلب</h6>
                                                        <table class="table table-sm">
                                                            <tr>
                                                                <td><strong>رقم الطلب:</strong></td>
                                                                <td>#<?php echo e($order->id); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>التاريخ:</strong></td>
                                                                <td><?php echo e($order->created_at->format('Y-m-d H:i')); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>الحالة:</strong></td>
                                                                <td>
                                                                    <?php switch($order->status):
                                                                        case ('pending'): ?>
                                                                            <span class="badge bg-warning">قيد المعالجة</span>
                                                                            <?php break; ?>
                                                                        <?php case ('processing'): ?>
                                                                            <span class="badge bg-info">قيد التنفيذ</span>
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
                                                            <tr>
                                                                <td><strong>الكمية:</strong></td>
                                                                <td><?php echo e($order->quantity ?? 1); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>السعر الإجمالي:</strong></td>
                                                                <td><strong><?php echo e(number_format($order->total_price ?? 0, 2)); ?> ر.س</strong></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>معلومات المنتج</h6>
                                                        <?php if($order->product): ?>
                                                            <div class="text-center mb-3">
                                                                <?php if($order->product->image): ?>
                                                                    <img src="<?php echo e(asset('storage/' . $order->product->image)); ?>" 
                                                                         class="img-fluid rounded" 
                                                                         style="max-height: 200px;">
                                                                <?php endif; ?>
                                                            </div>
                                                            <table class="table table-sm">
                                                                <tr>
                                                                    <td><strong>اسم المنتج:</strong></td>
                                                                    <td><?php echo e($order->product->name); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>الفئة:</strong></td>
                                                                    <td><?php echo e($order->product->category->name ?? 'غير محدد'); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>السعر:</strong></td>
                                                                    <td><?php echo e($order->product->price); ?> ر.س</td>
                                                                </tr>
                                                            </table>
                                                        <?php else: ?>
                                                            <div class="alert alert-info">
                                                                <i class="fas fa-info-circle me-2"></i>
                                                                هذا طلب تصميم مخصص
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                
                                                <?php if($order->notes): ?>
                                                    <div class="mt-3">
                                                        <h6>ملاحظات إضافية</h6>
                                                        <div class="alert alert-light">
                                                            <?php echo e($order->notes); ?>

                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <?php if($order->status == 'pending'): ?>
                                                    <button type="button" class="btn btn-danger" onclick="cancelOrder(<?php echo e($order->id); ?>)">
                                                        <i class="fas fa-times me-2"></i>
                                                        إلغاء الطلب
                                                    </button>
                                                <?php endif; ?>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد طلبات حتى الآن</h4>
                    <p class="text-muted mb-4">تواصل معنا لإنشاء طلبك الأول</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        // Status filter functionality
        document.getElementById('statusFilter').addEventListener('change', function() {
            const selectedStatus = this.value;
            const rows = document.querySelectorAll('tbody tr[data-status]');
            
            rows.forEach(row => {
                if (selectedStatus === '' || row.dataset.status === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Cancel order function
        function cancelOrder(orderId) {
            if (confirm('هل أنت متأكد من إلغاء هذا الطلب؟')) {
                // Here you would typically send an AJAX request to cancel the order
                alert('سيتم إضافة وظيفة إلغاء الطلب قريباً');
            }
        }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\customer\orders.blade.php ENDPATH**/ ?>