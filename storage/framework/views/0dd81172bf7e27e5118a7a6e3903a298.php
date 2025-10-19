

<?php $__env->startSection('title', 'جميع الطلبات'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'جميع الطلبات'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة جميع طلبات المستوردين'); ?>
<?php $__env->startSection('profile-route', '#'); ?>
<?php $__env->startSection('settings-route', '#'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-shopping-cart me-3 text-primary"></i>
                        جميع الطلبات
                    </h1>
                    <p class="text-muted mb-0">إدارة جميع طلبات المستوردين</p>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="statusFilter">
                        <option value="">جميع الحالات</option>
                        <option value="new">جديد</option>
                        <option value="processing">قيد المعالجة</option>
                        <option value="completed">مكتمل</option>
                        <option value="cancelled">ملغي</option>
                    </select>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <?php if($orders->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>المستورد</th>
                                        <th>نوع التصميم</th>
                                        <th>الكمية</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الطلب</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">#<?php echo e($order->id); ?></span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <div class="avatar-title bg-light text-primary rounded-circle">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0"><?php echo e($order->importer->company_name ?? 'غير محدد'); ?></h6>
                                                        <small class="text-muted"><?php echo e($order->importer->user->name ?? 'غير محدد'); ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?php if($order->design_type === 'text'): ?>
                                                        وصف نصي
                                                    <?php elseif($order->design_type === 'upload'): ?>
                                                        رفع ملف
                                                    <?php elseif($order->design_type === 'template'): ?>
                                                        قالب جاهز
                                                    <?php elseif($order->design_type === 'ai'): ?>
                                                        ذكاء اصطناعي
                                                    <?php else: ?>
                                                        <?php echo e($order->design_type); ?>

                                                    <?php endif; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-bold"><?php echo e($order->quantity); ?></span>
                                            </td>
                                            <td>
                                                <?php if($order->status === 'new'): ?>
                                                    <span class="badge bg-warning">جديد</span>
                                                <?php elseif($order->status === 'processing'): ?>
                                                    <span class="badge bg-info">قيد المعالجة</span>
                                                <?php elseif($order->status === 'completed'): ?>
                                                    <span class="badge bg-success">مكتمل</span>
                                                <?php elseif($order->status === 'cancelled'): ?>
                                                    <span class="badge bg-danger">ملغي</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><?php echo e($order->status); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?php echo e($order->created_at->format('d/m/Y H:i')); ?>

                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo e(route('admin.importers.show', $order->importer)); ?>" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="عرض المستورد">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <form action="<?php echo e(route('admin.orders.updateStatus', $order->id)); ?>" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <select name="status" 
                                                                class="form-select form-select-sm" 
                                                                onchange="this.form.submit()"
                                                                style="width: auto;">
                                                            <option value="new" <?php echo e($order->status === 'new' ? 'selected' : ''); ?>>جديد</option>
                                                            <option value="processing" <?php echo e($order->status === 'processing' ? 'selected' : ''); ?>>قيد المعالجة</option>
                                                            <option value="completed" <?php echo e($order->status === 'completed' ? 'selected' : ''); ?>>مكتمل</option>
                                                            <option value="cancelled" <?php echo e($order->status === 'cancelled' ? 'selected' : ''); ?>>ملغي</option>
                                                        </select>
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
                            <?php echo e($orders->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-shopping-cart fa-3x mb-3 text-muted"></i>
                                <h5 class="mb-2">لا توجد طلبات</h5>
                                <p class="text-muted">لم يتم العثور على أي طلبات في النظام</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Filter functionality
    document.getElementById('statusFilter').addEventListener('change', function() {
        const status = this.value;
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            if (status === '' || row.querySelector('.badge').textContent.includes(status)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\orders\index.blade.php ENDPATH**/ ?>