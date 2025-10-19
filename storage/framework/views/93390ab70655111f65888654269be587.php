<!-- Statistics Card -->
<div class="text-center">
    <div class="stat-card">
        <div class="stat-icon mb-3">
            <i class="<?php echo e($content->icon); ?> fa-3x" style="color: <?php echo e($content->icon_color); ?>;"></i>
        </div>
        <h3 class="stat-number" style="color: <?php echo e($content->icon_color); ?>;">
            <?php echo e($content->extra_data['number'] ?? '0'); ?><?php echo e($content->extra_data['suffix'] ?? ''); ?>

        </h3>
        <p class="stat-label"><?php echo e($content->title); ?></p>
    </div>
</div><?php /**PATH F:\infinity\Infinity-Wear\resources\views\partials\stat-card.blade.php ENDPATH**/ ?>