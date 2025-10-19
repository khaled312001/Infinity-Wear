

<?php $__env->startSection('title', 'تفاصيل المستورد - فريق المبيعات'); ?>
<?php $__env->startSection('dashboard-title', 'تفاصيل المستورد'); ?>
<?php $__env->startSection('page-title', 'تفاصيل المستورد'); ?>
<?php $__env->startSection('page-subtitle', 'عرض تفاصيل المستورد'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-industry me-2"></i>
                    تفاصيل المستورد
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>معلومات الشركة</h6>
                        <ul class="list-unstyled">
                            <li><strong>اسم الشركة:</strong> <?php echo e($importer->company_name ?? 'غير محدد'); ?></li>
                            <li><strong>جهة الاتصال:</strong> <?php echo e($importer->contact_name ?? 'غير محدد'); ?></li>
                            <li><strong>الهاتف:</strong> <?php echo e($importer->phone ?? 'غير محدد'); ?></li>
                            <li><strong>البريد الإلكتروني:</strong> <?php echo e($importer->email ?? 'غير محدد'); ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>معلومات إضافية</h6>
                        <ul class="list-unstyled">
                            <li><strong>الحالة:</strong> 
                                <?php switch($importer->status):
                                    case ('new'): ?>
                                        <span class="badge bg-primary">جديد</span>
                                        <?php break; ?>
                                    <?php case ('contacted'): ?>
                                        <span class="badge bg-info">تم التواصل</span>
                                        <?php break; ?>
                                    <?php case ('qualified'): ?>
                                        <span class="badge bg-success">مؤهل</span>
                                        <?php break; ?>
                                    <?php case ('unqualified'): ?>
                                        <span class="badge bg-danger">غير مؤهل</span>
                                        <?php break; ?>
                                <?php endswitch; ?>
                            </li>
                            <li><strong>تاريخ التسجيل:</strong> <?php echo e($importer->created_at->format('Y-m-d H:i')); ?></li>
                            <li><strong>آخر تحديث:</strong> <?php echo e($importer->updated_at->format('Y-m-d H:i')); ?></li>
                        </ul>
                    </div>
                </div>
                
                <?php if($importer->notes): ?>
                    <div class="mt-3">
                        <h6>ملاحظات</h6>
                        <div class="alert alert-info">
                            <?php echo e($importer->notes); ?>

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
                    إدارة المستورد
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('sales.importers.update-status', $importer)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="mb-3">
                        <label for="status" class="form-label">تغيير الحالة</label>
                        <select name="status" id="status" class="form-select">
                            <option value="new" <?php echo e($importer->status === 'new' ? 'selected' : ''); ?>>جديد</option>
                            <option value="contacted" <?php echo e($importer->status === 'contacted' ? 'selected' : ''); ?>>تم التواصل</option>
                            <option value="qualified" <?php echo e($importer->status === 'qualified' ? 'selected' : ''); ?>>مؤهل</option>
                            <option value="unqualified" <?php echo e($importer->status === 'unqualified' ? 'selected' : ''); ?>>غير مؤهل</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">ملاحظات</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3"><?php echo e($importer->notes); ?></textarea>
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

<?php echo $__env->make('layouts.sales-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\sales\importers\show.blade.php ENDPATH**/ ?>