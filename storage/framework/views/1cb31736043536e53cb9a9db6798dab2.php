<?php $__env->startSection('title', 'خدماتنا - Infinity Wear'); ?>
<?php $__env->startSection('description', 'نقدم مجموعة شاملة من الخدمات المتخصصة في مجال الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية'); ?>

<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('css/infinity-home.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <section class="infinity-hero services-hero">
        <div class="infinity-hero-background"></div>
        <div class="container">
            <div class="infinity-hero-content">
                <div class="infinity-hero-text">
                    <h1 class="infinity-hero-title">خدماتنا</h1>
                    <p class="infinity-hero-subtitle">نقدم مجموعة شاملة من الخدمات المتخصصة في مجال الملابس الرياضية</p>
                </div>
            </div>
        </div>
    </section>

<!-- Services Content -->
<section class="py-5">
    <div class="container">
        <?php if($services && $services->count() > 0): ?>
            <div class="row g-4">
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 text-center">
                            <div class="card-img-top" style="height: 200px; background-image: url('<?php echo e($service->image_url); ?>'); background-size: cover; background-position: center; background-color: #f8f9fa;">
                                <?php if($service->image): ?>
                                    <img src="<?php echo e($service->image_url); ?>" alt="<?php echo e($service->title); ?>" style="width: 100%; height: 100%; object-fit: cover; display: none;" onerror="this.style.display='none'; this.parentElement.style.backgroundImage='url(<?php echo e(asset('images/default-service.jpg')); ?>)';">
                                <?php else: ?>
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background-color: #e9ecef;">
                                        <i class="<?php echo e($service->icon ?? 'fas fa-cog'); ?> fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <div class="infinity-logo mx-auto mb-4" style="width: 80px; height: 80px;">
                                    <?php if($service->icon): ?>
                                        <i class="<?php echo e($service->icon); ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-cog"></i>
                                    <?php endif; ?>
                                </div>
                                <h4 class="card-title"><?php echo e($service->title); ?></h4>
                                <p class="card-text">
                                    <?php echo e($service->description); ?>

                                </p>
                                <?php if($service->features && count($service->features) > 0): ?>
                                    <ul class="list-unstyled text-start">
                                        <?php $__currentLoopData = $service->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><i class="fas fa-check text-success me-2"></i> <?php echo e($feature); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <!-- Default Services if no services in database -->
            <div class="row g-4">
                <!-- خدمة الملابس الرياضية -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 text-center">
                        <div class="card-img-top" style="height: 200px; background-image: url('<?php echo e(asset('images/sections/sports-equipment.svg')); ?>'); background-size: cover; background-position: center;"></div>
                        <div class="card-body">
                            <div class="infinity-logo mx-auto mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <h4 class="card-title">ملابس رياضية</h4>
                            <p class="card-text">
                                نقدم أفضل الملابس الرياضية للأكاديميات والفرق الرياضية 
                                بأعلى معايير الجودة والراحة
                            </p>
                            <ul class="list-unstyled text-start">
                                <li><i class="fas fa-check text-success me-2"></i> قمصان رياضية</li>
                                <li><i class="fas fa-check text-success me-2"></i> شورتات رياضية</li>
                                <li><i class="fas fa-check text-success me-2"></i> جوارب رياضية</li>
                                <li><i class="fas fa-check text-success me-2"></i> أحذية رياضية</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- خدمة الزي المدرسي -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 text-center">
                        <div class="card-img-top" style="height: 200px; background-image: url('<?php echo e(asset('images/sections/uniform-design.svg')); ?>'); background-size: cover; background-position: center;"></div>
                        <div class="card-body">
                            <div class="infinity-logo mx-auto mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h4 class="card-title">زي مدرسي</h4>
                            <p class="card-text">
                                زي موحد أنيق ومريح للمدارس والأكاديميات 
                                مصمم ليكون عمليا ومريحا للطلاب
                            </p>
                            <ul class="list-unstyled text-start">
                                <li><i class="fas fa-check text-success me-2"></i> قمصان مدرسية</li>
                                <li><i class="fas fa-check text-success me-2"></i> بنطلونات مدرسية</li>
                                <li><i class="fas fa-check text-success me-2"></i> جاكيتات مدرسية</li>
                                <li><i class="fas fa-check text-success me-2"></i> حقائب مدرسية</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- خدمة زي الشركات -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 text-center">
                        <div class="card-img-top" style="height: 200px; background-image: url('<?php echo e(asset('images/sections/quality-manufacturing.svg')); ?>'); background-size: cover; background-position: center;"></div>
                        <div class="card-body">
                            <div class="infinity-logo mx-auto mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-building"></i>
                            </div>
                            <h4 class="card-title">زي شركات</h4>
                            <p class="card-text">
                                زي موحد احترافي للشركات والمؤسسات 
                                يعكس هوية الشركة ويوفر مظهرا موحدا
                            </p>
                            <ul class="list-unstyled text-start">
                                <li><i class="fas fa-check text-success me-2"></i> قمصان عمل</li>
                                <li><i class="fas fa-check text-success me-2"></i> بدلات عمل</li>
                                <li><i class="fas fa-check text-success me-2"></i> معاطف عمل</li>
                                <li><i class="fas fa-check text-success me-2"></i> إكسسوارات</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- خدمة التصميم المخصص -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 text-center">
                        <div class="card-img-top" style="height: 200px; background-image: url('<?php echo e(asset('images/sections/custom-design.svg')); ?>'); background-size: cover; background-position: center;"></div>
                        <div class="card-body">
                            <div class="infinity-logo mx-auto mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-palette"></i>
                            </div>
                            <h4 class="card-title">تصميم مخصص</h4>
                            <p class="card-text">
                                نقدم خدمة التصميم المخصص لإنشاء زي موحد 
                                يناسب احتياجاتكم ومتطلباتكم الخاصة
                            </p>
                            <ul class="list-unstyled text-start">
                                <li><i class="fas fa-check text-success me-2"></i> تصميم الشعار</li>
                                <li><i class="fas fa-check text-success me-2"></i> اختيار الألوان</li>
                                <li><i class="fas fa-check text-success me-2"></i> تخصيص النصوص</li>
                                <li><i class="fas fa-check text-success me-2"></i> معاينة التصميم</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- خدمة الطباعة -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 text-center">
                        <div class="card-img-top" style="height: 200px; background-image: url('<?php echo e(asset('images/sections/printing-service.svg')); ?>'); background-size: cover; background-position: center;"></div>
                        <div class="card-body">
                            <div class="infinity-logo mx-auto mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-print"></i>
                            </div>
                            <h4 class="card-title">طباعة عالية الجودة</h4>
                            <p class="card-text">
                                نستخدم أحدث تقنيات الطباعة لضمان 
                                جودة عالية وديمومة في التصاميم
                            </p>
                            <ul class="list-unstyled text-start">
                                <li><i class="fas fa-check text-success me-2"></i> طباعة الشاشة</li>
                                <li><i class="fas fa-check text-success me-2"></i> طباعة النقل الحراري</li>
                                <li><i class="fas fa-check text-success me-2"></i> طباعة التطريز</li>
                                <li><i class="fas fa-check text-success me-2"></i> طباعة DTG</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- خدمة التوصيل -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 text-center">
                        <div class="card-img-top" style="height: 200px; background-image: url('<?php echo e(asset('images/sections/customer-service.svg')); ?>'); background-size: cover; background-position: center;"></div>
                        <div class="card-body">
                            <div class="infinity-logo mx-auto mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <h4 class="card-title">توصيل سريع</h4>
                            <p class="card-text">
                                نقدم خدمة التوصيل السريع لجميع أنحاء 
                                المملكة العربية السعودية
                            </p>
                            <ul class="list-unstyled text-start">
                                <li><i class="fas fa-check text-success me-2"></i> توصيل مجاني</li>
                                <li><i class="fas fa-check text-success me-2"></i> توصيل سريع</li>
                                <li><i class="fas fa-check text-success me-2"></i> تتبع الشحنة</li>
                                <li><i class="fas fa-check text-success me-2"></i> خدمة عملاء 24/7</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Process Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">كيف نعمل</h2>
                <p class="lead">خطوات بسيطة للحصول على أفضل النتائج</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="infinity-logo mx-auto mb-3" style="width: 80px; height: 80px;">
                        <span class="h3">1</span>
                    </div>
                    <h5>التواصل</h5>
                    <p>تواصل معنا وشاركنا متطلباتكم</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="infinity-logo mx-auto mb-3" style="width: 80px; height: 80px;">
                        <span class="h3">2</span>
                    </div>
                    <h5>التصميم</h5>
                    <p>نصمم لكم الحل الأمثل</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="infinity-logo mx-auto mb-3" style="width: 80px; height: 80px;">
                        <span class="h3">3</span>
                    </div>
                    <h5>التصنيع</h5>
                    <p>نصنع المنتج بأعلى جودة</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <div class="infinity-logo mx-auto mb-3" style="width: 80px; height: 80px;">
                        <span class="h3">4</span>
                    </div>
                    <h5>التسليم</h5>
                    <p>نسلم المنتج في الوقت المحدد</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h2 class="mb-4">هل تريد بدء مشروعك معنا</h2>
                <p class="lead mb-4">تواصل معنا الآن واحصل على عرض سعر مجاني</p>
                <a href="<?php echo e(route('contact.index')); ?>" class="btn btn-warning btn-lg me-3">
                    <i class="fas fa-phone me-2"></i>
                    اتصل بنا
                </a>
               
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/infinity-home.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views/services.blade.php ENDPATH**/ ?>