<?php $__env->startSection('title', 'آراء العملاء - مؤسسة الزي اللامحدود'); ?>

<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('css/enhanced-pages.css')); ?>" rel="stylesheet">
<style>
    /* Testimonials Specific Styles - Fallback */
    .testimonials-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 100px 0 60px;
        color: white;
        text-align: center;
        min-height: 300px;
        display: flex;
        align-items: center;
    }
    
    .testimonials-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .testimonials-hero .lead {
        font-size: 1.2rem;
        opacity: 0.9;
    }
    
    .stats-section {
        background: #f8f9fa;
        padding: 60px 0;
        min-height: 400px;
    }
    
    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin: 0 auto 1rem;
    }
    
    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }
    
    .stats-label {
        color: #718096;
        font-size: 1rem;
    }
    
    .testimonial-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        transition: transform 0.3s ease;
    }
    
    .testimonial-card:hover {
        transform: translateY(-5px);
    }
    
    .testimonial-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .testimonial-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-left: 1rem;
        flex-shrink: 0;
    }
    
    .testimonial-info h5 {
        margin: 0;
        color: #2d3748;
        font-weight: 600;
    }
    
    .testimonial-info p {
        margin: 0;
        color: #718096;
        font-size: 0.9rem;
    }
    
    .testimonial-rating {
        text-align: center;
        margin-bottom: 1rem;
    }
    
    .testimonial-rating i {
        color: #ffc107;
        margin: 0 2px;
    }
    
    .testimonial-text {
        color: #4a5568;
        line-height: 1.6;
        font-style: italic;
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 10px;
        border-right: 4px solid #667eea;
    }
    
    .testimonial-date {
        color: #718096;
        font-size: 0.85rem;
        text-align: left;
        margin-top: 1rem;
    }
    
    .cta-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 3rem 2rem;
        border-radius: 20px;
        color: white;
        text-align: center;
        margin-top: 3rem;
    }
    
    .btn-cta {
        background: white;
        color: #667eea;
        border: none;
        padding: 1rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        color: #667eea;
    }
    
    @media (max-width: 768px) {
        .testimonials-hero h1 {
            font-size: 2rem;
        }
        
        .testimonial-header {
            flex-direction: column;
            text-align: center;
        }
        
        .testimonial-avatar {
            margin: 0 0 1rem 0;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="testimonials-hero">
    <div class="container">
        <h1>آراء عملائنا</h1>
        <p class="lead">نفتخر بثقة عملائنا ونسعد بمشاركة تجاربهم معنا</p>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="stats-number"><?php echo e(number_format($averageRating, 1)); ?></h3>
                    <p class="stats-label">متوسط التقييم</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="stats-number"><?php echo e($testimonialCount); ?></h3>
                    <p class="stats-label">عدد التقييمات</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3 class="stats-number">100%</h3>
                    <p class="stats-label">رضا العملاء</p>
                </div>
            </div>
        </div>

        <!-- Testimonials Grid -->
        <div class="row">
            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar">
                            <?php if($testimonial->image): ?>
                                <img src="<?php echo e(asset('storage/' . $testimonial->image)); ?>" alt="<?php echo e($testimonial->client_name); ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            <?php else: ?>
                                <i class="fas fa-user"></i>
                            <?php endif; ?>
                        </div>
                        <div class="testimonial-info">
                            <h5><?php echo e($testimonial->client_name); ?></h5>
                            <p><?php echo e($testimonial->client_position); ?></p>
                            <p><?php echo e($testimonial->client_company); ?></p>
                        </div>
                    </div>
                    
                    <div class="testimonial-rating">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <?php if($i <= $testimonial->rating): ?>
                                <i class="fas fa-star"></i>
                            <?php else: ?>
                                <i class="far fa-star"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    
                    <div class="testimonial-text">
                        <?php echo e($testimonial->content); ?>

                    </div>
                    
                    <div class="testimonial-date">
                        <?php echo e($testimonial->created_at->diffForHumans()); ?>

                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($testimonials->links()); ?>

        </div>

        <!-- Call to Action Section -->
        <div class="cta-section">
            <h3>شاركنا تجربتك</h3>
            <p>هل استفدت من خدماتنا؟ نود أن نسمع رأيك</p>
            <a href="<?php echo e(route('testimonials.create')); ?>" class="btn btn-cta">
                <i class="fas fa-plus-circle me-2"></i>
                أضف شهادتك
            </a>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Simple page initialization
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Testimonials page loaded successfully');
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\testimonials\index.blade.php ENDPATH**/ ?>