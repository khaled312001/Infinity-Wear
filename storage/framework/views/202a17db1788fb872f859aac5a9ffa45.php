<?php $__env->startSection('title', 'لوحة تحكم المستورد'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة المستورد'); ?>
<?php $__env->startSection('page-title', 'مرحبا ' . $importer->name); ?>
<?php $__env->startSection('page-subtitle', 'إدارة طلباتك وعمليات الاستيراد'); ?>
<?php $__env->startSection('profile-route', '#'); ?>
<?php $__env->startSection('settings-route', '#'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <a href="<?php echo e(route('importers.dashboard')); ?>" class="nav-link active">
        <i class="fas fa-tachometer-alt me-2"></i>
        الرئيسية
    </a>
    <a href="#" class="nav-link">
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
    <a href="#" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        طلب استيراد جديد
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon primary me-3">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div>
                        <h3 class="mb-0"><?php echo e($orders->count()); ?></h3>
                        <p class="text-muted mb-0">إجمالي الطلبات</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon warning me-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h3 class="mb-0"><?php echo e($orders->where('status', 'pending')->count()); ?></h3>
                        <p class="text-muted mb-0">طلبات قيد المراجعة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon success me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0"><?php echo e($orders->where('status', 'approved')->count()); ?></h3>
                        <p class="text-muted mb-0">طلبات معتمدة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon danger me-3">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0"><?php echo e($orders->where('status', 'rejected')->count()); ?></h3>
                        <p class="text-muted mb-0">طلبات مرفوضة</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Importer Information -->
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2 text-primary"></i>
                        معلومات المستورد
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="stats-icon primary mx-auto mb-3" style="width: 80px; height: 80px; font-size: 32px;">
                            <i class="fas fa-user"></i>
                        </div>
                        <h4 class="mb-1"><?php echo e($importer->name); ?></h4>
                        <p class="text-muted mb-2"><?php echo e($importer->email); ?></p>
                        <span class="badge bg-success">مستورد نشط</span>
                    </div>

                    <div class="border-top pt-3">
                        <div class="mb-3">
                            <strong>نوع العمل:</strong>
                            <span class="float-end">
                                <?php if($importer->business_type == 'individual'): ?>
                                    <span class="badge bg-info">فرد</span>
                                <?php elseif($importer->business_type == 'company'): ?>
                                    <span class="badge bg-primary">شركة</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">آخر</span>
                                <?php endif; ?>
                            </span>
                        </div>

                        <?php if($importer->business_type == 'company'): ?>
                            <div class="mb-3">
                                <strong>اسم الشركة:</strong>
                                <div class="text-muted"><?php echo e($importer->company_name); ?></div>
                            </div>
                            <div class="mb-3">
                                <strong>المنصب:</strong>
                                <div class="text-muted"><?php echo e($importer->company_position); ?></div>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <strong>رقم الهاتف:</strong>
                            <div class="text-muted"><?php echo e($importer->phone); ?></div>
                        </div>

                        <div class="mb-0">
                            <strong>العنوان:</strong>
                            <div class="text-muted"><?php echo e($importer->address); ?>, <?php echo e($importer->city); ?>, <?php echo e($importer->country); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2 text-primary"></i>
                            الطلبات
                        </h5>
                        <a href="#" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            طلب جديد
                        </a>
                    </div>
                </div>
                    <?php if($orders->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>المتطلبات</th>
                                        <th>الكمية</th>
                                        <th>الحالة</th>
                                        <th>التاريخ</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><strong>#<?php echo e($order->id); ?></strong></td>
                                            <td><?php echo e(Str::limit($order->requirements, 50)); ?></td>
                                            <td><span class="badge bg-light text-dark"><?php echo e($order->quantity); ?></span></td>
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
                                            <td><?php echo e($order->created_at->format('Y-m-d')); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#orderModal<?php echo e($order->id); ?>">
                                                    <i class="fas fa-eye"></i>
                                                </button>
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
                                                                                    <span class="badge bg-warning">قيد المراجعة</span>
                                                                                    <?php break; ?>
                                                                                <?php case ('approved'): ?>
                                                                                    <span class="badge bg-success">معتمد</span>
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
                                                                        <td><?php echo e($order->quantity); ?></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>تفاصيل التصميم</h6>
                                                                <?php
                                                                    $designDetails = json_decode($order->design_details, true);
                                                                ?>

                                                                <?php if(isset($designDetails['option'])): ?>
                                                                    <div class="mb-2">
                                                                        <strong>نوع التصميم:</strong>
                                                                        <?php switch($designDetails['option']):
                                                                            case ('text'): ?>
                                                                                <span class="badge bg-info">وصف نصي</span>
                                                                                <?php break; ?>
                                                                            <?php case ('upload'): ?>
                                                                                <span class="badge bg-primary">تصميم مرفوع</span>
                                                                                <?php break; ?>
                                                                            <?php case ('template'): ?>
                                                                                <span class="badge bg-success">تصميم جاهز</span>
                                                                                <?php break; ?>
                                                                            <?php case ('ai'): ?>
                                                                                <span class="badge bg-warning">ذكاء اصطناعي</span>
                                                                                <?php break; ?>
                                                                            <?php default: ?>
                                                                                <span class="badge bg-secondary">غير محدد</span>
                                                                        <?php endswitch; ?>
                                                                    </div>

                                                                    <?php switch($designDetails['option']):
                                                                        case ('text'): ?>
                                                                            <div class="alert alert-light">
                                                                                <strong>الوصف:</strong><br>
                                                                                <?php echo e($designDetails['text'] ?? 'لا يوجد وصف'); ?>

                                                                            </div>
                                                                            <?php break; ?>
                                                                        <?php case ('upload'): ?>
                                                                            <?php if(isset($designDetails['file_path'])): ?>
                                                                                <a href="<?php echo e(asset('storage/' . $designDetails['file_path'])); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                                    <i class="fas fa-download me-1"></i> عرض الملف
                                                                                </a>
                                                                            <?php endif; ?>
                                                                            <?php break; ?>
                                                                        <?php case ('template'): ?>
                                                                            <div class="alert alert-light">
                                                                                <strong>التصميم:</strong>
                                                                                <?php switch($designDetails['template'] ?? ''):
                                                                                    case ('template1'): ?>
                                                                                        التصميم الكلاسيكي
                                                                                        <?php break; ?>
                                                                                    <?php case ('template2'): ?>
                                                                                        التصميم المكي
                                                                                        <?php break; ?>
                                                                                    <?php case ('template3'): ?>
                                                                                        التصميم العصري
                                                                                        <?php break; ?>
                                                                                    <?php default: ?>
                                                                                        غير محدد
                                                                                <?php endswitch; ?>
                                                                            </div>
                                                                            <?php break; ?>
                                                                        <?php case ('ai'): ?>
                                                                            <div class="alert alert-light">
                                                                                <strong>الوصف:</strong><br>
                                                                                <?php echo e($designDetails['prompt'] ?? 'لا يوجد وصف'); ?>

                                                                            </div>
                                                                            <?php break; ?>
                                                                    <?php endswitch; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mt-3">
                                                            <h6>المتطلبات</h6>
                                                            <div class="alert alert-info">
                                                                <?php echo e($order->requirements); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">لا توجد طلبات حتى الآن</h4>
                            <p class="text-muted mb-4">ابدأ بإنشاء طلب استيراد جديد</p>
                            <a href="#" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                طلب استيراد جديد
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\importers\dashboard.blade.php ENDPATH**/ ?>