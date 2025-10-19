<?php $__env->startSection('title', 'عرض بيانات المستورد'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'عرض بيانات المستورد'); ?>
<?php $__env->startSection('page-subtitle', 'عرض بيانات المستورد: ' . $importer->name); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2 text-primary"></i>
                    بيانات المستورد
                </h5>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('admin.importers.edit', $importer->id)); ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>
                        تعديل
                    </a>
                    <a href="<?php echo e(route('admin.importers.index')); ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-right me-1"></i>
                        العودة
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">الاسم:</label>
                                <p class="form-control-plaintext"><?php echo e($importer->name); ?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">البريد الإلكتروني:</label>
                                <p class="form-control-plaintext"><?php echo e($importer->email); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">الهاتف:</label>
                                <p class="form-control-plaintext"><?php echo e($importer->phone ?? 'غير محدد'); ?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">اسم الشركة:</label>
                                <p class="form-control-plaintext"><?php echo e($importer->company_name ?? 'غير محدد'); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">نوع النشاط:</label>
                                <p class="form-control-plaintext"><?php echo e($importer->business_type_label); ?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">الحالة:</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-info"><?php echo e($importer->status_label); ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">المدينة:</label>
                                <p class="form-control-plaintext"><?php echo e($importer->city ?? 'غير محدد'); ?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">البلد:</label>
                                <p class="form-control-plaintext"><?php echo e($importer->country ?? 'غير محدد'); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <?php if($importer->address): ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">العنوان:</label>
                        <p class="form-control-plaintext"><?php echo e($importer->address); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($importer->notes): ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">ملاحظات:</label>
                        <p class="form-control-plaintext"><?php echo e($importer->notes); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">تاريخ التسجيل:</label>
                                <p class="form-control-plaintext"><?php echo e($importer->created_at->format('Y-m-d H:i')); ?></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">آخر تحديث:</label>
                                <p class="form-control-plaintext"><?php echo e($importer->updated_at->format('Y-m-d H:i')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-user-circle fa-5x text-primary"></i>
                            </div>
                            <h5><?php echo e($importer->name); ?></h5>
                            <p class="text-muted"><?php echo e($importer->business_type_label); ?></p>
                            <span class="badge bg-info"><?php echo e($importer->status_label); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if($orders->count() > 0): ?>
            <div class="mt-4">
                <h6 class="mb-3">طلبات المستورد</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>المنتج</th>
                                <th>الكمية</th>
                                <th>الحالة</th>
                                <th>تاريخ الطلب</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($order->id); ?></td>
                                <td><?php echo e($order->product_name ?? 'غير محدد'); ?></td>
                                <td><?php echo e($order->quantity ?? 'غير محدد'); ?></td>
                                <td>
                                    <span class="badge bg-secondary"><?php echo e($order->status ?? 'غير محدد'); ?></span>
                                </td>
                                <td><?php echo e($order->created_at->format('Y-m-d')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\importers\show.blade.php ENDPATH**/ ?>