

<?php $__env->startSection('title', 'طلبات المستوردين'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0">
                    <i class="fas fa-shopping-cart me-2 text-primary"></i>
                    طلبات المستوردين
                </h2>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="statusFilter">
                        <option value="">جميع الحالات</option>
                        <option value="new">جديد</option>
                        <option value="processing">قيد المعالجة</option>
                        <option value="completed">مكتمل</option>
                        <option value="cancelled">ملغي</option>
                    </select>
                    <select class="form-select form-select-sm" id="designTypeFilter">
                        <option value="">جميع أنواع التصميم</option>
                        <option value="text">وصف نصي</option>
                        <option value="upload">رفع ملف</option>
                        <option value="template">قالب جاهز</option>
                        <option value="ai">ذكاء اصطناعي</option>
                    </select>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="dashboard-card">
                <div class="card-body">
                    <?php if($orders->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover" id="ordersTable">
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
                                            <strong><?php echo e($order->order_number); ?></strong>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <i class="fas fa-user text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?php echo e($order->importer->name); ?></h6>
                                                    <small class="text-muted"><?php echo e($order->importer->company_name); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                                $designDetails = is_string($order->design_details) ? json_decode($order->design_details, true) : $order->design_details;
                                                $designType = $designDetails['option'] ?? 'غير محدد';
                                            ?>
                                            <span class="badge bg-info">
                                                <?php switch($designType):
                                                    case ('text'): ?>
                                                        <i class="fas fa-font me-1"></i>وصف نصي
                                                        <?php break; ?>
                                                    <?php case ('upload'): ?>
                                                        <i class="fas fa-upload me-1"></i>رفع ملف
                                                        <?php break; ?>
                                                    <?php case ('template'): ?>
                                                        <i class="fas fa-image me-1"></i>قالب جاهز
                                                        <?php break; ?>
                                                    <?php case ('ai'): ?>
                                                        <i class="fas fa-robot me-1"></i>ذكاء اصطناعي
                                                        <?php break; ?>
                                                    <?php default: ?>
                                                        غير محدد
                                                <?php endswitch; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary"><?php echo e(number_format($order->quantity)); ?> قطعة</span>
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm status-select" data-order-id="<?php echo e($order->id); ?>">
                                                <option value="new" <?php echo e($order->status == 'new' ? 'selected' : ''); ?>>جديد</option>
                                                <option value="processing" <?php echo e($order->status == 'processing' ? 'selected' : ''); ?>>قيد المعالجة</option>
                                                <option value="completed" <?php echo e($order->status == 'completed' ? 'selected' : ''); ?>>مكتمل</option>
                                                <option value="cancelled" <?php echo e($order->status == 'cancelled' ? 'selected' : ''); ?>>ملغي</option>
                                            </select>
                                        </td>
                                        <td>
                                            <small><?php echo e($order->created_at->format('Y-m-d H:i')); ?></small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="btn btn-outline-primary" title="عرض تفاصيل الطلب">
                                                    <i class="fas fa-eye me-1"></i>عرض
                                                </a>
                                                <a href="<?php echo e(route('admin.importers.show', $order->importer->id)); ?>" class="btn btn-outline-info" title="عرض المستورد">
                                                    <i class="fas fa-user"></i>
                                                </a>
                                            </div>
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
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد طلبات</h5>
                            <p class="text-muted">لم يتم تقديم أي طلبات من المستوردين بعد</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // Status filter
    $('#statusFilter').change(function() {
        const status = $(this).val();
        filterTable();
    });
    
    // Design type filter
    $('#designTypeFilter').change(function() {
        const designType = $(this).val();
        filterTable();
    });
    
    // Status update
    $('.status-select').change(function() {
        const orderId = $(this).data('order-id');
        const newStatus = $(this).val();
        
        $.ajax({
            url: '<?php echo e(route("admin.orders.updateStatus", ":id")); ?>'.replace(':id', orderId),
            method: 'PUT',
            data: {
                status: newStatus,
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showAlert('تم تحديث حالة الطلب بنجاح', 'success');
                } else {
                    showAlert('حدث خطأ في تحديث الحالة', 'error');
                }
            },
            error: function() {
                showAlert('حدث خطأ في الاتصال', 'error');
            }
        });
    });
    
    function filterTable() {
        const status = $('#statusFilter').val();
        const designType = $('#designTypeFilter').val();
        
        $('#ordersTable tbody tr').each(function() {
            let showRow = true;
            
            if (status) {
                const rowStatus = $(this).find('.status-select').val();
                if (rowStatus !== status) {
                    showRow = false;
                }
            }
            
            if (designType && showRow) {
                const rowDesignType = $(this).find('.badge').text().trim();
                if (!rowDesignType.includes(getDesignTypeText(designType))) {
                    showRow = false;
                }
            }
            
            if (showRow) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
    
    function getDesignTypeText(type) {
        const types = {
            'text': 'وصف نصي',
            'upload': 'رفع ملف',
            'template': 'قالب جاهز',
            'ai': 'ذكاء اصطناعي'
        };
        return types[type] || '';
    }
    
    function showAlert(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alert = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('.container-fluid').prepend(alert);
        
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 3000);
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views/admin/importers/orders.blade.php ENDPATH**/ ?>