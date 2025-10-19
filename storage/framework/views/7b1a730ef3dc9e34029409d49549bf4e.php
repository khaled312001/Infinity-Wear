

<?php $__env->startSection('title', 'تتبع الشحنات - لوحة تحكم المستورد'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة المستورد'); ?>
<?php $__env->startSection('page-title', 'تتبع الشحنات'); ?>
<?php $__env->startSection('page-subtitle', 'متابعة حالة شحناتك في الوقت الفعلي'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- شريط البحث -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-2">
                                <i class="fas fa-search me-2"></i>
                                البحث عن شحنة
                            </h6>
                            <div class="input-group">
                                <input type="text" class="form-control" id="trackingNumber" placeholder="أدخل رقم التتبع أو رقم الطلب">
                                <button class="btn btn-primary" type="button" onclick="trackShipment()">
                                    <i class="fas fa-search me-1"></i>
                                    تتبع
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="d-flex justify-content-end align-items-center">
                                <span class="badge bg-success me-2">
                                    <i class="fas fa-shipping-fast me-1"></i>
                                    <?php echo e($shippedOrders->count()); ?> شحنة نشطة
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الشحنات النشطة -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-truck me-2"></i>
                        الشحنات النشطة
                    </h5>
                    <button class="btn btn-sm btn-outline-primary" onclick="refreshTracking()">
                        <i class="fas fa-sync-alt me-1"></i>
                        تحديث
                    </button>
                </div>
                
                <div class="card-body">
                    <?php if($shippedOrders->count() > 0): ?>
                        <div class="row">
                            <?php $__currentLoopData = $shippedOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-6 mb-4">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h6 class="card-title mb-1">طلب #<?php echo e($order->order_number); ?></h6>
                                                    <small class="text-muted"><?php echo e($order->created_at->format('Y-m-d')); ?></small>
                                                </div>
                                                <div>
                                                    <?php switch($order->status):
                                                        case ('shipped'): ?>
                                                            <span class="badge bg-info">تم الشحن</span>
                                                            <?php break; ?>
                                                        <?php case ('in_transit'): ?>
                                                            <span class="badge bg-primary">في الطريق</span>
                                                            <?php break; ?>
                                                        <?php case ('out_for_delivery'): ?>
                                                            <span class="badge bg-warning">خارج للتسليم</span>
                                                            <?php break; ?>
                                                        <?php case ('delivered'): ?>
                                                            <span class="badge bg-success">تم التسليم</span>
                                                            <?php break; ?>
                                                    <?php endswitch; ?>
                                                </div>
                                            </div>
                                            
                                            <!-- شريط التقدم -->
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <small class="text-muted">تقدم الشحنة</small>
                                                    <small class="text-muted"><?php echo e($order->quantity); ?> قطعة</small>
                                                </div>
                                                <div class="progress" style="height: 8px;">
                                                    <?php
                                                        $progress = 0;
                                                        switch($order->status) {
                                                            case 'shipped': $progress = 25; break;
                                                            case 'in_transit': $progress = 50; break;
                                                            case 'out_for_delivery': $progress = 75; break;
                                                            case 'delivered': $progress = 100; break;
                                                        }
                                                    ?>
                                                    <div class="progress-bar bg-primary" role="progressbar" 
                                                         style="width: <?php echo e($progress); ?>%" 
                                                         aria-valuenow="<?php echo e($progress); ?>" 
                                                         aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            
                                            <!-- تفاصيل التتبع -->
                                            <div class="tracking-timeline">
                                                <div class="timeline-item <?php echo e($order->status == 'shipped' || in_array($order->status, ['in_transit', 'out_for_delivery', 'delivered']) ? 'active' : ''); ?>">
                                                    <div class="timeline-marker">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6>تم تجهيز الطلب</h6>
                                                        <small class="text-muted"><?php echo e($order->created_at->format('Y-m-d H:i')); ?></small>
                                                    </div>
                                                </div>
                                                
                                                <div class="timeline-item <?php echo e(in_array($order->status, ['in_transit', 'out_for_delivery', 'delivered']) ? 'active' : ''); ?>">
                                                    <div class="timeline-marker">
                                                        <i class="fas fa-shipping-fast"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6>في الطريق</h6>
                                                        <small class="text-muted">متوقع: <?php echo e($order->created_at->addDays(2)->format('Y-m-d')); ?></small>
                                                    </div>
                                                </div>
                                                
                                                <div class="timeline-item <?php echo e(in_array($order->status, ['out_for_delivery', 'delivered']) ? 'active' : ''); ?>">
                                                    <div class="timeline-marker">
                                                        <i class="fas fa-truck"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6>خارج للتسليم</h6>
                                                        <small class="text-muted">متوقع: <?php echo e($order->created_at->addDays(3)->format('Y-m-d')); ?></small>
                                                    </div>
                                                </div>
                                                
                                                <div class="timeline-item <?php echo e($order->status == 'delivered' ? 'active' : ''); ?>">
                                                    <div class="timeline-marker">
                                                        <i class="fas fa-check-circle"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6>تم التسليم</h6>
                                                        <small class="text-muted"><?php echo e($order->updated_at->format('Y-m-d H:i')); ?></small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- معلومات إضافية -->
                                            <div class="mt-3 pt-3 border-top">
                                                <div class="row text-center">
                                                    <div class="col-4">
                                                        <small class="text-muted d-block">رقم التتبع</small>
                                                        <strong>TRK<?php echo e($order->id); ?><?php echo e($order->order_number); ?></strong>
                                                    </div>
                                                    <div class="col-4">
                                                        <small class="text-muted d-block">الشركة</small>
                                                        <strong>إنفينيتي وير</strong>
                                                    </div>
                                                    <div class="col-4">
                                                        <small class="text-muted d-block">التوقيت المتوقع</small>
                                                        <strong><?php echo e($order->created_at->addDays(3)->format('Y-m-d')); ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد شحنات نشطة</h5>
                            <p class="text-muted">لم يتم شحن أي طلبات بعد</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- الشحنات المكتملة -->
    <?php if($completedOrders->count() > 0): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-check-circle me-2"></i>
                        الشحنات المكتملة مؤخراً
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>تاريخ التسليم</th>
                                    <th>الكمية</th>
                                    <th>رقم التتبع</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $completedOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><strong>#<?php echo e($order->order_number); ?></strong></td>
                                        <td><?php echo e($order->updated_at->format('Y-m-d')); ?></td>
                                        <td><?php echo e($order->quantity); ?> قطعة</td>
                                        <td>TRK<?php echo e($order->id); ?><?php echo e($order->order_number); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    onclick="viewOrderDetails(<?php echo e($order->id); ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.tracking-timeline {
    position: relative;
    padding-left: 30px;
}

.tracking-timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
    opacity: 0.5;
    transition: all 0.3s ease;
}

.timeline-item.active {
    opacity: 1;
}

.timeline-item.active .timeline-marker {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #e9ecef;
    border: 2px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: #6c757d;
}

.timeline-content h6 {
    margin-bottom: 5px;
    font-size: 14px;
    font-weight: 600;
}

.timeline-content small {
    font-size: 12px;
}

.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}
</style>

<script>
function trackShipment() {
    const trackingNumber = document.getElementById('trackingNumber').value.trim();
    
    if (!trackingNumber) {
        alert('يرجى إدخال رقم التتبع');
        return;
    }
    
    // محاكاة البحث عن الشحنة
    alert('جاري البحث عن الشحنة: ' + trackingNumber);
    
    // هنا يمكن إضافة منطق البحث الفعلي
    // window.location.href = '/importers/tracking/search/' + trackingNumber;
}

function refreshTracking() {
    // إعادة تحميل الصفحة لتحديث البيانات
    window.location.reload();
}

function viewOrderDetails(orderId) {
    // عرض تفاصيل الطلب
    alert('عرض تفاصيل الطلب رقم: ' + orderId);
    
    // يمكن إضافة modal أو redirect لصفحة التفاصيل
    // window.location.href = '/importers/orders/' + orderId;
}

// تحديث تلقائي كل 30 ثانية
setInterval(function() {
    // يمكن إضافة AJAX call لتحديث البيانات بدون إعادة تحميل الصفحة
    console.log('تحديث بيانات التتبع...');
}, 30000);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\importers\tracking.blade.php ENDPATH**/ ?>