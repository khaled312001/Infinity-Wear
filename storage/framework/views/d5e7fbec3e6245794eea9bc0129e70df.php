

<?php
use Illuminate\Support\Facades\Storage;
?>

<?php $__env->startSection('title', 'معرض الأعمال - فريق التسويق'); ?>
<?php $__env->startSection('dashboard-title', 'معرض الأعمال'); ?>
<?php $__env->startSection('page-title', 'معرض الأعمال'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة مشاريع المعرض'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-images me-2"></i>
                    مشاريع المعرض
                </h5>
                <a href="<?php echo e(route('marketing.portfolio.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    إضافة مشروع جديد
                </a>
            </div>
            <div class="card-body">
                <?php if($portfolio->count() > 0): ?>
                    <div class="row">
                        <?php $__currentLoopData = $portfolio; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <img src="<?php echo e($item->image_url); ?>" class="card-img-top" alt="<?php echo e($item->title); ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title"><?php echo e($item->title); ?></h6>
                                    <p class="card-text text-muted"><?php echo e(Str::limit($item->description, 100)); ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted"><?php echo e($item->client_name); ?></small>
                                        <?php if($item->is_featured): ?>
                                            <span class="badge bg-warning">مميز</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group w-100" role="group">
                                        <a href="<?php echo e(route('marketing.portfolio.edit', $item)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('marketing.portfolio.destroy', $item)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المشروع؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        <?php echo e($portfolio->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-images fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">لا توجد مشاريع في المعرض</h5>
                        <p class="text-muted">ابدأ بإضافة مشروع جديد لعرض أعمالك</p>
                        <a href="<?php echo e(route('marketing.portfolio.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            إضافة مشروع جديد
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\marketing\portfolio\index.blade.php ENDPATH**/ ?>