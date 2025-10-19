<?php
use Illuminate\Support\Facades\Storage;
?>

<?php $__env->startSection('title', 'معرض أعمالنا - Infinity Wear'); ?>

<?php $__env->startSection('styles'); ?>
<style>
/* تصميم محسن لصفحة معرض الأعمال */
.portfolio-hero-section {
    min-height: 80vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.portfolio-hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="portfolioPattern" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23portfolioPattern)"/></svg>');
    pointer-events: none;
}

.portfolio-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
}

.portfolio-hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    text-shadow: 0 4px 8px rgba(0,0,0,0.3);
    animation: slideInFromTop 1s ease-out;
}

.portfolio-hero-subtitle {
    font-size: 1.3rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
    animation: slideInFromBottom 1s ease-out 0.3s both;
}

@keyframes slideInFromTop {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInFromBottom {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* تحسين تصميم بطاقات المعرض */
.portfolio-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    overflow: hidden;
}

.portfolio-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.portfolio-card .card-img-top {
    border-radius: 15px 15px 0 0;
    height: 250px;
    object-fit: cover;
}

.portfolio-card .card-title {
    color: #333;
    font-weight: 700;
    margin-bottom: 1rem;
}

.portfolio-card .card-text {
    color: #666;
    line-height: 1.6;
}

/* تحسين التجاوب */
@media (max-width: 768px) {
    .portfolio-hero-title {
        font-size: 2.5rem;
    }
    
    .portfolio-hero-subtitle {
        font-size: 1.1rem;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- قسم العنوان الرئيسي -->
<section class="portfolio-hero-section">
    <div class="container">
        <div class="portfolio-hero-content">
            <h1 class="portfolio-hero-title">معرض أعمالنا</h1>
            <p class="portfolio-hero-subtitle">نفخر بتقديم مجموعة متنوعة من الأعمال المميزة التي قمنا بتنفيذها لعملائنا</p>
        </div>
    </div>
</section>

<!-- قسم الأعمال المميزة -->
<section class="featured-works py-5 mb-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="fw-bold">أعمالنا المميزة</h2>
            <p class="text-muted">نماذج من أفضل أعمالنا التي نفخر بها</p>
        </div>
        
        <div class="row g-4">
            <?php $__currentLoopData = $featuredItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4">
                <div class="card portfolio-card h-100">
                    <img src="<?php echo e($item->image_url); ?>" class="card-img-top" alt="<?php echo e($item->title); ?>">
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
</section>

<!-- قسم جميع الأعمال -->
<section class="all-works py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="fw-bold">جميع أعمالنا</h2>
            <p class="text-muted">استكشف جميع مشاريعنا المتنوعة</p>
        </div>
        
        <div class="row g-4">
            <?php $__currentLoopData = $portfolioItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 col-lg-3">
                <div class="card portfolio-card h-100">
                    <img src="<?php echo e($item->image_url); ?>" class="card-img-top" alt="<?php echo e($item->title); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($item->title); ?></h5>
                        <p class="card-text text-muted"><?php echo e($item->category); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="<?php echo e(route('portfolio.show', $item->id)); ?>" class="btn btn-sm btn-outline-primary">عرض التفاصيل</a>
                            <?php if($item->is_featured): ?>
                                <span class="badge bg-warning">مميز</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- قسم الاتصال بنا -->
<section class="cta-section bg-light py-5 text-center">
    <div class="container">
        <h2 class="fw-bold mb-3">هل تريد تنفيذ مشروع مماثل؟</h2>
        <p class="lead mb-4">نحن هنا لمساعدتك في تحقيق رؤيتك بأعلى جودة وأفضل سعر</p>
        <a href="<?php echo e(route('contact.index')); ?>" class="btn btn-primary btn-lg">تواصل معنا الآن</a>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
        // تصفية العناصر حسب الفئة
        $('.filter-btn').on('click', function() {
            var category = $(this).data('category');
            
            // تحديث الزر النشط
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            
            // استخدام AJAX للحصول على العناصر المصفاة
            $.ajax({
                url: '<?php echo e(route("portfolio.filter")); ?>',
                type: 'POST',
                data: {
                    category: category,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        $('#portfolio-items').html(response.html);
                    }
                },
                error: function() {
                    // في حالة الخطأ، نقوم بالتصفية على جانب العميل
                    if (category === 'all') {
                        $('.portfolio-item').show();
                    } else {
                        $('.portfolio-item').hide();
                        $('.portfolio-item[data-category="' + category + '"]').show();
                    }
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
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
    
    .filter-btn.active {
        background-color: var(--bs-primary);
        color: white;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\portfolio\index.blade.php ENDPATH**/ ?>