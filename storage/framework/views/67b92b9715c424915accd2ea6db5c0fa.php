<?php $__currentLoopData = $portfolioItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="col-md-4 col-lg-3 portfolio-item" data-category="<?php echo e($item->category); ?>">
    <div class="card portfolio-card h-100">
        <img src="<?php echo e(asset($item->image)); ?>" class="card-img-top" alt="<?php echo e($item->title); ?>">
        <div class="card-body">
            <h5 class="card-title"><?php echo e($item->title); ?></h5>
            <p class="card-text text-muted"><?php echo e($item->category); ?></p>
            <div class="d-flex justify-content-between align-items-center">
                <a href="<?php echo e(route('portfolio.show', $item->id)); ?>" class="btn btn-sm btn-outline-primary">عرض التفاصيل</a>
                <small class="text-muted"><?php echo e($item->completion_date->format('Y/m/d')); ?></small>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views/portfolio/partials/items.blade.php ENDPATH**/ ?>