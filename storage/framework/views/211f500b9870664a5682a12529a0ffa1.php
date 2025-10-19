<!-- Regular Content Card -->
<div class="content-card">
    <?php if($content->image): ?>
        <img src="<?php echo e(asset('storage/' . $content->image)); ?>" alt="<?php echo e($content->title); ?>" class="content-image">
    <?php elseif($content->icon): ?>
        <div class="content-icon" style="background-color: <?php echo e($content->icon_color); ?>;">
            <i class="<?php echo e($content->icon); ?>"></i>
        </div>
    <?php endif; ?>
    
    <h5 class="card-title mb-3"><?php echo e($content->title); ?></h5>
    
    <?php if($content->description): ?>
    <p class="card-text mb-4"><?php echo e($content->description); ?></p>
    <?php endif; ?>
    
    <?php if($content->button_text && $content->button_url): ?>
    <a href="<?php echo e($content->button_url); ?>" class="btn btn-primary">
        <i class="fas fa-arrow-left me-2"></i>
        <?php echo e($content->button_text); ?>

    </a>
    <?php endif; ?>
</div><?php /**PATH F:\infinity\Infinity-Wear\resources\views\partials\content-card.blade.php ENDPATH**/ ?>