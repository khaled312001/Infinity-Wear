<?php $__env->startSection('title', 'طلبات الاستيراد'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة المستورد'); ?>
<?php $__env->startSection('page-title', 'طلبات الاستيراد'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة وتتبع جميع طلبات الاستيراد'); ?>
<?php $__env->startSection('profile-route', '#'); ?>
<?php $__env->startSection('settings-route', '#'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <a href="<?php echo e(route('importers.dashboard')); ?>" class="nav-link">
        <i class="fas fa-tachometer-alt me-2"></i>
        الرئيسية
    </a>
    <a href="<?php echo e(route('importers.orders')); ?>" class="nav-link active">
        <i class="fas fa-shopping-cart me-2"></i>
        طلباتي
    </a>
    <a href="#" class="nav-link">
        <i class="fas fa-truck me-2"></i>
        عمليات الاستيراد
    </a>
    <a href="#" class="nav-link">
        <i class="fas fa-chart-line me-2"></i>
        التقارير
    </a>
    <a href="#" class="nav-link">
        <i class="fas fa-user me-2"></i>
        الملف الشخصي
    </a>
    <a href="#" class="nav-link">
        <i class="fas fa-cog me-2"></i>
        الإعدادات
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-actions'); ?>
    <a href="<?php echo e(route('importers.form')); ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        طلب استيراد جديد
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-shopping-cart me-2 text-primary"></i>
                    جميع طلبات الاستيراد
                </h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="statusFilter">
                        <option value="">جميع الحالات</option>
                        <option value="pending">قيد المراجعة</option>
                        <option value="approved">معتمد</option>
                        <option value="in_progress">قيد التنفيذ</option>
                        <option value="completed">مكتمل</option>
                        <option value="rejected">مرفوض</option>
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
                                <th>نوع المنتج</th>
                                <th>الكمية</th>
                                <th>التكلفة المتوقعة</th>
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
                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-box text-muted"></i>
                                            </div>
                                            <div>
                                                <strong><?php echo e($order->product_type ?? 'منتج عام'); ?></strong>
                                                <br>
                                                <small class="text-muted"><?php echo e($order->category ?? 'غير محدد'); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark"><?php echo e($order->quantity ?? 1); ?></span>
                                    </td>
                                    <td>
                                        <strong><?php echo e(number_format($order->estimated_cost ?? 0, 2)); ?> ر.س</strong>
                                    </td>
                                    <td>
                                        <?php switch($order->status):
                                            case ('pending'): ?>
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i>
                                                    قيد المراجعة
                                                </span>
                                                <?php break; ?>
                                            <?php case ('approved'): ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>
                                                    معتمد
                                                </span>
                                                <?php break; ?>
                                            <?php case ('in_progress'): ?>
                                                <span class="badge bg-info">
                                                    <i class="fas fa-cog me-1"></i>
                                                    قيد التنفيذ
                                                </span>
                                                <?php break; ?>
                                            <?php case ('completed'): ?>
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    مكتمل
                                                </span>
                                                <?php break; ?>
                                            <?php case ('rejected'): ?>
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>
                                                    مرفوض
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
                                                <button type="button" class="btn btn-sm btn-outline-warning"
                                                        onclick="editOrder(<?php echo e($order->id); ?>)">
                                                    <i class="fas fa-edit"></i>
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
                                                <h5 class="modal-title">تفاصيل طلب الاستيراد #<?php echo e($order->id); ?></h5>
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
                                                                            <span class="badge bg-warning">قيد المراجعة</span>
                                                                            <?php break; ?>
                                                                        <?php case ('approved'): ?>
                                                                            <span class="badge bg-success">معتمد</span>
                                                                            <?php break; ?>
                                                                        <?php case ('in_progress'): ?>
                                                                            <span class="badge bg-info">قيد التنفيذ</span>
                                                                            <?php break; ?>
                                                                        <?php case ('completed'): ?>
                                                                            <span class="badge bg-primary">مكتمل</span>
                                                                            <?php break; ?>
                                                                        <?php case ('rejected'): ?>
                                                                            <span class="badge bg-danger">مرفوض</span>
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
                                                                <td><strong>التكلفة المتوقعة:</strong></td>
                                                                <td><strong><?php echo e(number_format($order->estimated_cost ?? 0, 2)); ?> ر.س</strong></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>تفاصيل المنتج</h6>
                                                        <table class="table table-sm">
                                                            <tr>
                                                                <td><strong>نوع المنتج:</strong></td>
                                                                <td><?php echo e($order->product_type ?? 'منتج عام'); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>الفئة:</strong></td>
                                                                <td><?php echo e($order->category ?? 'غير محدد'); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>المواصفات:</strong></td>
                                                                <td><?php echo e($order->specifications ?? 'غير محدد'); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>البلد المصدر:</strong></td>
                                                                <td><?php echo e($order->source_country ?? 'غير محدد'); ?></td>
                                                            </tr>
                                                        </table>
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

                                                <?php if($order->admin_notes): ?>
                                                    <div class="mt-3">
                                                        <h6>ملاحظات الإدارة</h6>
                                                        <div class="alert alert-info">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            <?php echo e($order->admin_notes); ?>

                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <?php if($order->status == 'pending'): ?>
                                                    <button type="button" class="btn btn-warning" onclick="editOrder(<?php echo e($order->id); ?>)">
                                                        <i class="fas fa-edit me-2"></i>
                                                        تعديل الطلب
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
                    <h4 class="text-muted">لا توجد طلبات استيراد حتى الآن</h4>
                    <p class="text-muted mb-4">ابدأ بإنشاء طلب استيراد جديد</p>
                    <a href="<?php echo e(route('importers.form')); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        طلب استيراد جديد
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mt-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon warning me-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h3 class="mb-0"><?php echo e($orders->where('status', 'pending')->count()); ?></h3>
                        <p class="text-muted mb-0">قيد المراجعة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon success me-3">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h3 class="mb-0"><?php echo e($orders->where('status', 'approved')->count()); ?></h3>
                        <p class="text-muted mb-0">معتمدة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon info me-3">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div>
                        <h3 class="mb-0"><?php echo e($orders->where('status', 'in_progress')->count()); ?></h3>
                        <p class="text-muted mb-0">قيد التنفيذ</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon primary me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0"><?php echo e($orders->where('status', 'completed')->count()); ?></h3>
                        <p class="text-muted mb-0">مكتملة</p>
                    </div>
                </div>
            </div>
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

        // Edit order function
        function editOrder(orderId) {
            // Redirect to edit form or open edit modal
            window.location.href = `/importers/orders/${orderId}/edit`;
        }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\importers\orders\index.blade.php ENDPATH**/ ?>