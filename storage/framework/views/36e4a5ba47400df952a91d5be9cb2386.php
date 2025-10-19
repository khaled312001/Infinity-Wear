

<?php $__env->startSection('title', 'التقييمات - فريق التسويق'); ?>
<?php $__env->startSection('dashboard-title', 'التقييمات'); ?>
<?php $__env->startSection('page-title', 'التقييمات'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة تقييمات العملاء'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-star me-2"></i>
                    تقييمات العملاء
                </h5>
                <a href="<?php echo e(route('marketing.testimonials.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    إضافة تقييم جديد
                </a>
            </div>
            <div class="card-body">
                <?php if($testimonials->count() > 0): ?>
                    <div class="row">
                        <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="card-title mb-1"><?php echo e($testimonial->client_name); ?></h6>
                                            <small class="text-muted"><?php echo e($testimonial->client_title); ?></small>
                                        </div>
                                        <div class="text-end">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star <?php echo e($i <= $testimonial->rating ? 'text-warning' : 'text-muted'); ?>"></i>
                                            <?php endfor; ?>
                                            <?php if($testimonial->is_featured): ?>
                                                <span class="badge bg-warning ms-2">مميز</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <p class="card-text"><?php echo e($testimonial->content); ?></p>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        <?php echo e($testimonial->created_at->format('Y-m-d')); ?>

                                    </small>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group w-100" role="group">
                                        <a href="<?php echo e(route('marketing.testimonials.edit', $testimonial)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('marketing.testimonials.destroy', $testimonial)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذا التقييم؟')">
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
                        <?php echo e($testimonials->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-star fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">لا توجد تقييمات</h5>
                        <p class="text-muted">ابدأ بإضافة تقييم جديد من العملاء</p>
                        <a href="<?php echo e(route('marketing.testimonials.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            إضافة تقييم جديد
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\marketing\testimonials\index.blade.php ENDPATH**/ ?>