@extends('layouts.app')

@section('title', 'Infinity Wear - مؤسسة اللباس اللامحدود')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="display-3 fw-bold mb-4 animate-fade-in">
                    مرحباً بك في <span class="text-warning">Infinity Wear</span>
                </h1>
                    <p class="lead mb-4 animate-fade-in-delay">
                    مؤسسة سعودية متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية 
                    في المملكة العربية السعودية، نشارك في تحقيق رؤية 2030 من خلال دعم الرياضة والتعليم
                </p>
                    <div class="hero-stats mb-4">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3 class="text-warning">500+</h3>
                                    <p>عميل راضي</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3 class="text-warning">1000+</h3>
                                    <p>تصميم مخصص</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item">
                                    <h3 class="text-warning">5</h3>
                                    <p>سنوات خبرة</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('products.index') }}" class="btn btn-warning btn-lg animate-bounce">
                        <i class="fas fa-shopping-bag me-2"></i>
                        تصفح المنتجات
                    </a>
                    <a href="{{ route('custom-designs.create') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-palette me-2"></i>
                        صمم زي موحد
                    </a>
                        <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-phone me-2"></i>
                            اتصل بنا
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center position-relative">
                    <div class="hero-image-container">
                        <div class="hero-infinity-logo animate-float">
                        </div>
                        <div class="floating-elements">
                            <div class="floating-icon" style="top: 10%; left: 10%;">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <div class="floating-icon" style="top: 20%; right: 15%;">
                                <i class="fas fa-medal"></i>
                            </div>
                            <div class="floating-icon" style="bottom: 30%; left: 20%;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="floating-icon" style="bottom: 10%; right: 10%;">
                                <i class="fas fa-trophy"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="scroll-indicator">
        <i class="fas fa-chevron-down animate-bounce"></i>
    </div>
</section>

<!-- Trust Badges Section -->
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-2 col-6 text-center mb-3 mb-md-0">
                <div class="trust-badge">
                    <i class="fas fa-shield-check text-success mb-2"></i>
                    <small>ضمان الجودة</small>
                </div>
            </div>
            <div class="col-md-2 col-6 text-center mb-3 mb-md-0">
                <div class="trust-badge">
                    <i class="fas fa-shipping-fast text-primary mb-2"></i>
                    <small>شحن سريع</small>
                </div>
            </div>
            <div class="col-md-2 col-6 text-center mb-3 mb-md-0">
                <div class="trust-badge">
                    <i class="fas fa-headset text-info mb-2"></i>
                    <small>دعم 24/7</small>
                </div>
            </div>
            <div class="col-md-2 col-6 text-center mb-3 mb-md-0">
                <div class="trust-badge">
                    <i class="fas fa-undo text-warning mb-2"></i>
                    <small>إرجاع مجاني</small>
                </div>
            </div>
            <div class="col-md-2 col-6 text-center mb-3 mb-md-0">
                <div class="trust-badge">
                    <i class="fas fa-certificate text-danger mb-2"></i>
                    <small>معتمد محلياً</small>
                </div>
            </div>
            <div class="col-md-2 col-6 text-center">
                <div class="trust-badge">
                    <i class="fas fa-heart text-pink mb-2"></i>
                    <small>صنع بحب</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">شركاؤنا وعملاؤنا</h2>
                <p class="lead">نفتخر بثقة عملائنا وشراكتنا مع أفضل المؤسسات</p>
            </div>
        </div>
        
        <div class="row align-items-center justify-content-center">
            <div class="col-md-2 col-6 mb-4">
                <div class="partner-logo">
                    <div class="partner-placeholder">
                        <i class="fas fa-university text-primary"></i>
                        <small>جامعة الملك سعود</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-4">
                <div class="partner-logo">
                    <div class="partner-placeholder">
                        <i class="fas fa-futbol text-success"></i>
                        <small>الاتحاد السعودي</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-4">
                <div class="partner-logo">
                    <div class="partner-placeholder">
                        <i class="fas fa-school text-info"></i>
                        <small>مدارس الرياض</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-4">
                <div class="partner-logo">
                    <div class="partner-placeholder">
                        <i class="fas fa-running text-warning"></i>
                        <small>أكاديمية الرياضة</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-4">
                <div class="partner-logo">
                    <div class="partner-placeholder">
                        <i class="fas fa-building text-danger"></i>
                        <small>الشركات الكبرى</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-4">
                <div class="partner-logo">
                    <div class="partner-placeholder">
                        <i class="fas fa-medal text-purple"></i>
                        <small>الأندية الرياضية</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision 2030 Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">رؤية 2030</h2>
                <p class="lead">نشارك في تحقيق رؤية المملكة العربية السعودية 2030</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-running"></i>
                        </div>
                        <h5 class="card-title">دعم الرياضة</h5>
                        <p class="card-text">نساهم في تطوير الرياضة السعودية من خلال توفير أفضل الملابس الرياضية للأكاديميات والفرق</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h5 class="card-title">التعليم والتدريب</h5>
                        <p class="card-text">نوفر زي موحد عالي الجودة للمدارس والأكاديميات لتعزيز الهوية والانتماء</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-industry"></i>
                        </div>
                        <h5 class="card-title">التصنيع المحلي</h5>
                        <p class="card-text">نساهم في التنويع الاقتصادي من خلال التصنيع المحلي للملابس الرياضية</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">قيمنا ومبادئنا</h2>
                <p class="lead">نلتزم بأعلى معايير الجودة والاحترافية في كل ما نقدمه</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5 class="card-title">ثقة</h5>
                        <p class="card-text">نحن نثق في جودة منتجاتنا ونضمن رضا عملائنا الكرام</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h5 class="card-title">سرعة</h5>
                        <p class="card-text">نوفر خدمات سريعة وفعالة لتلبية احتياجات عملائنا في الوقت المحدد</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h5 class="card-title">مصداقية</h5>
                        <p class="card-text">نلتزم بالشفافية والمصداقية في جميع تعاملاتنا مع العملاء</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-star"></i>
                        </div>
                        <h5 class="card-title">جودة</h5>
                        <p class="card-text">نستخدم أفضل المواد والتقنيات في تصنيع منتجاتنا</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-palette"></i>
                        </div>
                        <h5 class="card-title">تصميم</h5>
                        <p class="card-text">نقدم تصاميم عصرية ومبتكرة تناسب جميع الأذواق والاحتياجات</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h5 class="card-title">احترافية</h5>
                        <p class="card-text">فريق عمل محترف ومتخصص في مجال الملابس الرياضية</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
@if($categories->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">فئات منتجاتنا</h2>
                <p class="lead">اكتشف مجموعتنا المتنوعة من الملابس الرياضية والزي الموحد</p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-4 col-lg-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="infinity-logo mx-auto mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <h5 class="card-title">{{ $category->name_ar }}</h5>
                        <p class="card-text">{{ Str::limit($category->description_ar, 100) }}</p>
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-primary">
                            عرض المنتجات
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Featured Products Section -->
@if($featuredProducts->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">منتجات مميزة</h2>
                <p class="lead">أفضل منتجاتنا المختارة بعناية لتناسب احتياجاتكم</p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-md-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name_ar }}</h5>
                        <p class="card-text">{{ Str::limit($product->description_ar, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 text-primary">{{ number_format($product->current_price, 2) }} ريال</span>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-sm">
                                عرض التفاصيل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                عرض جميع المنتجات
            </a>
        </div>
    </div>
</section>
@endif

<!-- Gallery Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">معرض أعمالنا</h2>
                <p class="lead">شاهد بعض من أفضل التصاميم التي أنجزناها لعملائنا</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="gallery-item">
                    <div class="gallery-image">
                        <div class="sample-jersey" style="background: linear-gradient(45deg, #1e40af, #3b82f6);">
                            <div class="jersey-text">الهلال</div>
                            <div class="jersey-number">10</div>
                        </div>
                    </div>
                    <div class="gallery-caption">
                        <h5>نادي الهلال</h5>
                        <p>تصميم مخصص للنادي الأهلي</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="gallery-item">
                    <div class="gallery-image">
                        <div class="sample-jersey" style="background: linear-gradient(45deg, #dc2626, #ef4444);">
                            <div class="jersey-text">الأهلي</div>
                            <div class="jersey-number">7</div>
                        </div>
                    </div>
                    <div class="gallery-caption">
                        <h5>نادي الأهلي</h5>
                        <p>زي رياضي احترافي</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="gallery-item">
                    <div class="gallery-image">
                        <div class="sample-jersey" style="background: linear-gradient(45deg, #059669, #10b981);">
                            <div class="jersey-text">الاتحاد</div>
                            <div class="jersey-number">9</div>
                        </div>
                    </div>
                    <div class="gallery-caption">
                        <h5>نادي الاتحاد</h5>
                        <p>تصميم عصري ومميز</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">ماذا يقول عملاؤنا</h2>
                <p class="lead">آراء عملائنا الكرام في خدماتنا</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="stars mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p>"خدمة ممتازة وجودة عالية. التصاميم احترافية والتسليم في الوقت المحدد."</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="author-info">
                            <h6>أحمد محمد</h6>
                            <small>مدير أكاديمية رياضية</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="stars mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p>"أفضل مكان للحصول على زي موحد عالي الجودة. أنصح الجميع بالتعامل معهم."</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="author-info">
                            <h6>سارة العلي</h6>
                            <small>مديرة مدرسة</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="stars mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p>"التصاميم المخصصة رائعة والفريق متعاون جداً. تجربة ممتازة من البداية للنهاية."</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="author-info">
                            <h6>خالد السعد</h6>
                            <small>مدير شركة</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h3 class="mb-3">اشترك في نشرتنا الإخبارية</h3>
                <p class="mb-0">احصل على آخر العروض والتحديثات مباشرة في بريدك الإلكتروني</p>
            </div>
            <div class="col-lg-6">
                <form class="newsletter-form">
                    <div class="input-group">
                        <input type="email" class="form-control form-control-lg" placeholder="بريدك الإلكتروني">
                        <button class="btn btn-warning btn-lg" type="submit">
                            <i class="fas fa-paper-plane me-2"></i>
                            اشترك
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-gradient-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <div class="cta-content">
                    <h2 class="display-5 fw-bold mb-4">هل تريد تصميم زي موحد مخصص؟</h2>
                    <p class="lead mb-4">استخدم أداة التصميم المتقدمة لإنشاء زي موحد فريد يناسب احتياجاتك</p>
                    <div class="cta-buttons">
                        <a href="{{ route('custom-designs.create') }}" class="btn btn-warning btn-lg me-3 mb-2">
                    <i class="fas fa-palette me-2"></i>
                    ابدأ التصميم الآن
                </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg mb-2">
                            <i class="fas fa-phone me-2"></i>
                            تحدث معنا
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
