
<div class="content-item content-<?php echo e($content->content_type); ?> animate-on-scroll" data-animation="fadeInUp">
    <?php switch($content->content_type):
        case ('card'): ?>
            <div class="feature-card">
                <?php if($content->image): ?>
                    <div class="card-image">
                        <img src="<?php echo e($content->image_url); ?>" alt="<?php echo e($content->title); ?>" class="img-fluid">
                    </div>
                <?php elseif($content->icon_class): ?>
                    <div class="card-icon">
                        <i class="<?php echo e($content->full_icon_class); ?>"></i>
                    </div>
                <?php endif; ?>
                
                <div class="card-content">
                    <h4 class="card-title"><?php echo e($content->title); ?></h4>
                    
                    <?php if($content->subtitle): ?>
                        <p class="card-subtitle"><?php echo e($content->subtitle); ?></p>
                    <?php endif; ?>
                    
                    <?php if($content->description): ?>
                        <p class="card-description"><?php echo e($content->description); ?></p>
                    <?php endif; ?>
                    
                    <?php if($content->button_text && $content->button_link): ?>
                        <a href="<?php echo e($content->button_link); ?>" class="btn btn-<?php echo e($content->button_style); ?> card-btn">
                            <?php echo e($content->button_text); ?>

                            <i class="fas fa-arrow-left me-2"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php break; ?>
            
        <?php case ('testimonial'): ?>
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="testimonial-quote">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    
                    <?php if($content->description): ?>
                        <p class="testimonial-text"><?php echo e($content->description); ?></p>
                    <?php endif; ?>
                    
                    <div class="testimonial-author">
                        <?php if($content->image): ?>
                            <img src="<?php echo e($content->image_url); ?>" alt="<?php echo e($content->title); ?>" class="author-avatar">
                        <?php endif; ?>
                        
                        <div class="author-info">
                            <h5 class="author-name"><?php echo e($content->title); ?></h5>
                            <?php if($content->subtitle): ?>
                                <p class="author-position"><?php echo e($content->subtitle); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php break; ?>
            
        <?php case ('image'): ?>
            <div class="image-content">
                <?php if($content->image): ?>
                    <img src="<?php echo e($content->image_url); ?>" alt="<?php echo e($content->title); ?>" class="img-fluid rounded">
                <?php endif; ?>
                
                <?php if($content->title || $content->description): ?>
                    <div class="image-caption mt-3">
                        <?php if($content->title): ?>
                            <h4><?php echo e($content->title); ?></h4>
                        <?php endif; ?>
                        <?php if($content->description): ?>
                            <p><?php echo e($content->description); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php break; ?>
            
        <?php case ('video'): ?>
            <div class="video-content">
                <?php if($content->video_url): ?>
                    <div class="video-wrapper">
                        <iframe src="<?php echo e($content->video_url); ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                <?php endif; ?>
                
                <?php if($content->title || $content->description): ?>
                    <div class="video-caption mt-3">
                        <?php if($content->title): ?>
                            <h4><?php echo e($content->title); ?></h4>
                        <?php endif; ?>
                        <?php if($content->description): ?>
                            <p><?php echo e($content->description); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php break; ?>
            
        <?php case ('icon'): ?>
            <div class="icon-content text-center">
                <?php if($content->icon_class): ?>
                    <div class="icon-wrapper mb-3">
                        <i class="<?php echo e($content->full_icon_class); ?>"></i>
                    </div>
                <?php endif; ?>
                
                <div class="stat-counter" data-count="<?php echo e(preg_replace('/\D/', '', $content->title)); ?>">
                    <?php echo e($content->title); ?>

                </div>
                
                <?php if($content->subtitle): ?>
                    <h5 class="stat-label"><?php echo e($content->subtitle); ?></h5>
                <?php endif; ?>
                
                <?php if($content->description): ?>
                    <p class="stat-description"><?php echo e($content->description); ?></p>
                <?php endif; ?>
            </div>
            <?php break; ?>
            
        <?php case ('button'): ?>
            <div class="button-content text-center">
                <?php if($content->button_text && $content->button_link): ?>
                    <a href="<?php echo e($content->button_link); ?>" class="btn btn-<?php echo e($content->button_style); ?> btn-lg">
                        <?php echo e($content->button_text); ?>

                        <i class="fas fa-arrow-left me-2"></i>
                    </a>
                <?php endif; ?>
            </div>
            <?php break; ?>
            
        <?php default: ?>
            
            <div class="text-content">
                <h4><?php echo e($content->title); ?></h4>
                
                <?php if($content->subtitle): ?>
                    <p class="text-subtitle"><?php echo e($content->subtitle); ?></p>
                <?php endif; ?>
                
                <?php if($content->description): ?>
                    <p><?php echo e($content->description); ?></p>
                <?php endif; ?>
            </div>
    <?php endswitch; ?>
</div><?php /**PATH F:\infinity\Infinity-Wear\resources\views\partials\content-item.blade.php ENDPATH**/ ?>