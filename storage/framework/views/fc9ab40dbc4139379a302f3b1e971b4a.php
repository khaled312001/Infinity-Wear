
<?php if($section->title || $section->subtitle || $section->description): ?>
    <div class="section-header text-center mb-5">
        <?php if($section->subtitle): ?>
            <div class="section-subtitle animate-on-scroll" data-animation="fadeInUp">
                <?php echo e($section->subtitle); ?>

            </div>
        <?php endif; ?>
        
        <?php if($section->title): ?>
            <h2 class="section-title animate-on-scroll" data-animation="fadeInUp" data-delay="200">
                <?php echo e($section->title); ?>

            </h2>
        <?php endif; ?>
        
        <?php if($section->description): ?>
            <p class="section-description animate-on-scroll" data-animation="fadeInUp" data-delay="400">
                <?php echo e($section->description); ?>

            </p>
        <?php endif; ?>
        
        <div class="section-divider animate-on-scroll" data-animation="scaleX" data-delay="600"></div>
    </div>
<?php endif; ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\partials\section-header.blade.php ENDPATH**/ ?>