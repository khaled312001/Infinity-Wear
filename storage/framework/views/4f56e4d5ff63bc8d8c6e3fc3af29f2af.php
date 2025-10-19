<!-- Testimonial Card -->
<div class="testimonial-card hover-lift">
    <div class="testimonial-content">
        <?php if($content->extra_data && isset($content->extra_data['rating'])): ?>
        <div class="stars mb-3">
            <?php for($i = 1; $i <= 5; $i++): ?>
                <i class="fas fa-star <?php echo e($i <= $content->extra_data['rating'] ? 'text-warning' : 'text-muted'); ?>"></i>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
        <p class="mb-4">"<?php echo e($content->description); ?>"</p>
    </div>
    <div class="testimonial-author">
        <div class="author-avatar">
            <?php if($content->image): ?>
                <img src="<?php echo e(asset('storage/' . $content->image)); ?>" alt="<?php echo e($content->title); ?>" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
            <?php else: ?>
                <i class="fas fa-user"></i>
            <?php endif; ?>
        </div>
        <div class="author-info">
            <h6><?php echo e($content->title); ?></h6>
            <?php if($content->extra_data && isset($content->extra_data['position'])): ?>
            <small><?php echo e($content->extra_data['position']); ?></small>
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH F:\infinity\Infinity-Wear\resources\views\partials\testimonial-card.blade.php ENDPATH**/ ?>