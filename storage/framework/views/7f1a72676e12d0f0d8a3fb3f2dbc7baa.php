
<div class="section-content-wrapper">
    <?php switch($section->layout_type):
        case ('grid_2'): ?>
            <div class="row g-4">
                <?php $__currentLoopData = $section->contents->chunk(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rowContents): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $rowContents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-6">
                            <?php echo $__env->make('partials.content-item', ['content' => $content], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php break; ?>
            
        <?php case ('grid_3'): ?>
            <div class="row g-4">
                <?php $__currentLoopData = $section->contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6">
                        <?php echo $__env->make('partials.content-item', ['content' => $content], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php break; ?>
            
        <?php case ('grid_4'): ?>
            <div class="row g-4">
                <?php $__currentLoopData = $section->contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-3 col-md-6">
                        <?php echo $__env->make('partials.content-item', ['content' => $content], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php break; ?>
            
        <?php case ('carousel'): ?>
            <div class="swiper section-carousel">
                <div class="swiper-wrapper">
                    <?php $__currentLoopData = $section->contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                            <?php echo $__env->make('partials.content-item', ['content' => $content], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <?php break; ?>
            
        <?php default: ?>
            
            <div class="row g-4">
                <?php $__currentLoopData = $section->contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-12">
                        <?php echo $__env->make('partials.content-item', ['content' => $content], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
    <?php endswitch; ?>
</div><?php /**PATH F:\infinity\Infinity-Wear\resources\views\partials\section-content.blade.php ENDPATH**/ ?>