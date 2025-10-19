<?php $__env->startSection('title', $product->name_ar ?? $product->name . ' - Infinity Wear'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row">
        <div class="col-lg-6">
            <div class="product-image-container">
                <?php if($product->images): ?>
                    <?php
                        $images = json_decode($product->images);
                    ?>
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                                    <img src="<?php echo e($image); ?>" class="d-block w-100" alt="<?php echo e($product->name_ar ?? $product->name); ?>" style="height: 400px; object-fit: cover;">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php if(count($images) > 1): ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <img src="<?php echo e(asset('images/placeholder.jpg')); ?>" class="img-fluid" alt="<?php echo e($product->name_ar ?? $product->name); ?>" style="height: 400px; object-fit: cover;">
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="product-details">
                <h1 class="product-title"><?php echo e($product->name_ar ?? $product->name); ?></h1>
                
                <?php if($product->category): ?>
                    <p class="product-category">
                        <span class="badge bg-primary"><?php echo e($product->category->name_ar ?? $product->category->name); ?></span>
                    </p>
                <?php endif; ?>
                
                <div class="product-price-section mb-4">
                    <?php if($product->sale_price): ?>
                        <span class="product-sale-price"><?php echo e(number_format($product->price, 2)); ?> ريال</span>
                        <span class="product-price"><?php echo e(number_format($product->sale_price, 2)); ?> ريال</span>
                        <span class="discount-badge">خصم <?php echo e(round((($product->price - $product->sale_price) / $product->price) * 100)); ?>%</span>
                    <?php else: ?>
                        <span class="product-price"><?php echo e(number_format($product->price, 2)); ?> ريال</span>
                    <?php endif; ?>
                </div>
                
                <div class="product-description mb-4">
                    <h5>الوصف</h5>
                    <p><?php echo e($product->description_ar ?? $product->description); ?></p>
                </div>
                
                <?php if($product->features): ?>
                    <div class="product-features mb-4">
                        <h5>المميزات</h5>
                        <ul class="list-unstyled">
                            <?php $__currentLoopData = json_decode($product->features); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><i class="fas fa-check text-success me-2"></i><?php echo e($feature); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <div class="product-actions">
                    <a href="<?php echo e(route('contact.index')); ?>" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-phone me-2"></i>
                        اطلب الآن
                    </a>
                    <a href="<?php echo e(route('contact.index')); ?>" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-palette me-2"></i>
                        تصميم مخصص
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <?php if(isset($relatedProducts) && $relatedProducts->count() > 0): ?>
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">منتجات ذات صلة</h3>
                <div class="row g-4">
                    <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-4">
                            <div class="card product-card h-100">
                                <img src="<?php echo e($relatedProduct->images ? json_decode($relatedProduct->images)[0] : asset('images/placeholder.jpg')); ?>" 
                                     class="card-img-top" alt="<?php echo e($relatedProduct->name_ar ?? $relatedProduct->name); ?>" 
                                     style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo e($relatedProduct->name_ar ?? $relatedProduct->name); ?></h5>
                                    <p class="card-text"><?php echo e(Str::limit($relatedProduct->description_ar ?? $relatedProduct->description, 60)); ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="product-price"><?php echo e(number_format($relatedProduct->price, 2)); ?> ريال</span>
                                        <a href="<?php echo e(route('portfolio.show', $relatedProduct)); ?>" class="btn btn-sm btn-outline-primary">عرض</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.product-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.product-price {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
}

.product-sale-price {
    font-size: 1.2rem;
    text-decoration: line-through;
    color: #6c757d;
    margin-left: 1rem;
}

.discount-badge {
    background: #dc3545;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    margin-right: 1rem;
}

.product-features ul li {
    padding: 0.25rem 0;
}

.product-actions {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #dee2e6;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\products\show.blade.php ENDPATH**/ ?>