<?php
use Illuminate\Support\Facades\Storage;
?>

<?php $__env->startSection('title', $portfolioItem->title . ' - Infinity Wear'); ?>

<?php $__env->startSection('content'); ?>
<!-- قسم تفاصيل المشروع -->
<section class="portfolio-detail py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8">
                <img src="<?php echo e($portfolioItem->image_url); ?>" alt="<?php echo e($portfolioItem->title); ?>" class="img-fluid rounded main-image mb-4">
                
                <?php if($portfolioItem->gallery && count($portfolioItem->gallery) > 0): ?>
                <div class="row g-2 gallery-images">
                    <?php $__currentLoopData = $portfolioItem->gallery_urls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imageUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-4 col-md-3">
                        <a href="<?php echo e($imageUrl); ?>" data-lightbox="portfolio-gallery">
                            <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($portfolioItem->title); ?>" class="img-fluid rounded gallery-thumb">
                        </a>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="col-lg-4">
                <div class="project-info card">
                    <div class="card-body">
                        <h1 class="card-title h3 mb-4"><?php echo e($portfolioItem->title); ?></h1>
                        
                        <div class="project-meta mb-4">
                            <div class="row mb-2">
                                <div class="col-5 text-muted">العميل:</div>
                                <div class="col-7 fw-bold"><?php echo e($portfolioItem->client_name); ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 text-muted">الفئة:</div>
                                <div class="col-7"><?php echo e($portfolioItem->category); ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 text-muted">تاريخ الإنجاز:</div>
                                <div class="col-7"><?php echo e($portfolioItem->completion_date->format('Y/m/d')); ?></div>
                            </div>
                        </div>
                        
                        <div class="project-description">
                            <h5 class="mb-3">وصف المشروع</h5>
                            <p><?php echo e($portfolioItem->description); ?></p>
                        </div>
                        
                        <div class="mt-4">
                            <a href="<?php echo e(route('contact.index')); ?>" class="btn btn-primary w-100">طلب مشروع مماثل</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- المشاريع ذات الصلة -->
        <?php if(count($relatedItems) > 0): ?>
        <div class="related-projects">
            <h3 class="mb-4">مشاريع مشابهة</h3>
            <div class="row g-4">
                <?php $__currentLoopData = $relatedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4">
                    <div class="card portfolio-card h-100">
                        <img src="<?php echo e(Storage::url($item->image)); ?>" class="card-img-top" alt="<?php echo e($item->title); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($item->title); ?></h5>
                            <p class="card-text text-muted"><?php echo e($item->category); ?></p>
                            <a href="<?php echo e(route('portfolio.show', $item->id)); ?>" class="btn btn-outline-primary">عرض التفاصيل</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="text-center mt-5">
            <a href="<?php echo e(route('portfolio.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-right me-2"></i>
                العودة إلى معرض الأعمال
            </a>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .main-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }
    
    .gallery-thumb {
        height: 100px;
        width: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }
    
    .gallery-thumb:hover {
        opacity: 0.8;
        transform: scale(1.03);
    }
    
    .project-info {
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border: none;
        height: 100%;
    }
    
    .portfolio-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .portfolio-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .portfolio-card img {
        height: 200px;
        object-fit: cover;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
        // تفعيل معرض الصور
        if(typeof lightbox !== 'undefined') {
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\portfolio\show.blade.php ENDPATH**/ ?>