@extends('layouts.app')

@section('title', 'Infinity Wear - مؤسسة اللباس اللامحدود')

@section('styles')
<style>
    /* Testimonials Section Styles */
    .testimonial-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .testimonial-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-bottom: 20px;
    }
    
    .testimonial-text {
        position: relative;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 10px;
        margin: 20px 0;
    }
    
    .testimonial-rating {
        color: #ffc107;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section home-hero">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <div class="hero-content reveal-stagger">
                    <h1 class="display-3 fw-bold mb-4 animate-fade-in">
                        مرحباً بك في <span class="text-warning">Infinity Wear</span>
                    </h1>
                    <p class="lead mb-4 animate-fade-in-delay">
                        مؤسسة سعودية متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية 
                        في المملكة العربية السعودية، نشارك في تحقيق رؤية 2030 من خلال دعم مكةة والتعليم
                    </p>
                    <div class="hero-stats mb-4 glass-effect">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="stat-item pulse-soft">
                                    <h3 class="text-warning">500+</h3>
                                    <p>عميل راضي</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item pulse-soft">
                                    <h3 class="text-warning">1000+</h3>
                                    <p>تصميم مخصص</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-item pulse-soft">
                                    <h3 class="text-warning">5</h3>
                                    <p>سنوات خبرة</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('services') }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-cogs me-2"></i>
                            خدماتنا
                        </a>
                        <a href="{{ route('custom-designs.create') }}" class="btn btn-outline-light btn-lg hover-lift">
                            <i class="fas fa-palette me-2"></i>
                            صمم زي موحد
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-light btn-lg hover-lift">
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
                            <!-- Logo content is added via CSS ::before -->
                        </div>
                        <div class="floating-elements">
                            <div class="floating-icon glass-effect" style="top: 10%; left: 10%;">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <div class="floating-icon glass-effect" style="top: 20%; right: 15%;">
                                <i class="fas fa-medal"></i>
                            </div>
                            <div class="floating-icon glass-effect" style="bottom: 30%; left: 20%;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="floating-icon glass-effect" style="bottom: 10%; right: 10%;">
                                <i class="fas fa-trophy"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="scroll-indicator">
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- Trust Badges Section -->
<section class="py-4 bg-white border-bottom reveal-on-scroll">
    <div class="container">
        <div class="row align-items-center justify-content-center reveal-stagger">
            <div class="col-md-2 col-6 text-center mb-3 mb-md-0">
                <div class="trust-badge glass-effect hover-lift">
                    <i class="fas fa-shield-check text-success mb-2 pulse-soft"></i>
                    <small>ضمان الجودة</small>
                </div>
            </div>
            <div class="col-md-2 col-6 text-center mb-3 mb-md-0">
                <div class="trust-badge glass-effect hover-lift">
                    <i class="fas fa-shipping-fast text-primary mb-2 pulse-soft"></i>
                    <small>شحن سريع</small>
                </div>
            </div>
            <div class="col-md-2 col-6 text-center mb-3 mb-md-0">
                <div class="trust-badge glass-effect hover-lift">
                    <i class="fas fa-headset text-info mb-2 pulse-soft"></i>
                    <small>دعم 24/7</small>
                </div>
            </div>
            <div class="col-md-2 col-6 text-center mb-3 mb-md-0">
                <div class="trust-badge glass-effect hover-lift">
                    <i class="fas fa-undo text-warning mb-2 pulse-soft"></i>
                    <small>إرجاع مجاني</small>
                </div>
            </div>
            <div class="col-md-2 col-6 text-center mb-3 mb-md-0">
                <div class="trust-badge glass-effect hover-lift">
                    <i class="fas fa-certificate text-danger mb-2 pulse-soft"></i>
                    <small>معتمد محلياً</small>
                </div>
            </div>
            <div class="col-md-2 col-6 text-center">
                <div class="trust-badge glass-effect hover-lift">
                    <i class="fas fa-heart text-pink mb-2 pulse-soft"></i>
                    <small>صنع بحب</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 testimonial-card glass-effect hover-lift">
                    <div class="card-body text-center">
                        <div class="testimonial-avatar mx-auto mb-3 pulse-soft">
                            <i class="fas fa-user-circle fa-3x"></i>
                        </div>
                        <h5 class="card-title">سارة عبدالله</h5>
                        <p class="text-muted mb-3">مديرة مدارس مكة</p>
                        <div class="testimonial-text">
                            <i class="fas fa-quote-right fa-xs text-primary"></i>
                            <p class="mb-0">الزي المدرسي الذي صممته وأنتجته مؤسسة اللباس اللامحدود كان ممتازاً من حيث الجودة والمتانة، والطلاب سعداء بالتصميم العصري.</p>
                        </div>
                        <div class="testimonial-rating mt-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 testimonial-card glass-effect hover-lift">
                    <div class="card-body text-center">
                        <div class="testimonial-avatar mx-auto mb-3 pulse-soft">
                            <i class="fas fa-user-circle fa-3x"></i>
                        </div>
                        <h5 class="card-title">خالد العتيبي</h5>
                        <p class="text-muted mb-3">مدير الموارد البشرية - شركة الاتصالات</p>
                        <div class="testimonial-text">
                            <i class="fas fa-quote-right fa-xs text-primary"></i>
                            <p class="mb-0">تعاملنا مع مؤسسة اللباس اللامحدود لتصميم الزي الموحد لموظفينا، وكانت النتيجة مبهرة من حيث الجودة والتصميم المميز.</p>
                        </div>
                        <div class="testimonial-rating mt-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('testimonials.index') }}" class="btn btn-primary btn-lg">
                جميع آراء العملاء
            </a>
        </div>
    </div>
</section>

<!-- Partners Section -->
<section class="py-5 bg-white reveal-on-scroll">
    <div class="container">
        <div class="row text-center mb-5 reveal-fade-up">
            <div class="col-12">
                <h2 class="section-title">شركاؤنا وعملاؤنا</h2>
                <p class="lead">نفتخر بثقة عملائنا وشراكتنا مع أفضل المؤسسات</p>
            </div>
        </div>
        
        <div class="row align-items-center justify-content-center reveal-stagger">
            <div class="col-md-2 col-6 mb-4">
                <div class="partner-logo glass-effect hover-lift">
                    <div class="partner-placeholder">
                        <i class="fas fa-university text-primary float-icon"></i>
                        <small>جامعة الملك سعود</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-4">
                <div class="partner-logo glass-effect hover-lift">
                    <div class="partner-placeholder">
                        <i class="fas fa-futbol text-success float-icon"></i>
                        <small>الاتحاد السعودي</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-4">
                <div class="partner-logo glass-effect hover-lift">
                    <div class="partner-placeholder">
                        <i class="fas fa-school text-info float-icon"></i>
                        <small>مدارس مكة</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-4">
                <div class="partner-logo glass-effect hover-lift">
                    <div class="partner-placeholder">
                        <i class="fas fa-running text-warning float-icon"></i>
                        <small>أكاديمية مكةة</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-4">
                <div class="partner-logo glass-effect hover-lift">
                    <div class="partner-placeholder">
                        <i class="fas fa-building text-danger float-icon"></i>
                        <small>الشركات الكبرى</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-6 mb-4">
                <div class="partner-logo glass-effect hover-lift">
                    <div class="partner-placeholder">
                        <i class="fas fa-medal text-purple float-icon"></i>
                        <small>الأندية مكةية</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision 2030 Section -->
<section class="py-5 bg-light reveal-on-scroll section-with-bg">
    <div class="container">
        <div class="row text-center mb-5 reveal-fade-up">
            <div class="col-12">
                <h2 class="section-title">رؤية 2030</h2>
                <p class="lead">نشارك في تحقيق رؤية المملكة العربية السعودية 2030</p>
            </div>
        </div>
        
        <div class="row g-4 reveal-stagger">
            <div class="col-md-4">
                <div class="card h-100 text-center glass-effect hover-lift">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-running float-icon"></i>
                        </div>
                        <h5 class="card-title">دعم مكةة</h5>
                        <p class="card-text">نساهم في تطوير مكةة السعودية من خلال توفير أفضل الملابس الرياضية للأكاديميات والفرق</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 text-center glass-effect hover-lift">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-graduation-cap float-icon"></i>
                        </div>
                        <h5 class="card-title">التعليم والتدريب</h5>
                        <p class="card-text">نوفر زي موحد عالي الجودة للمدارس والأكاديميات لتعزيز الهوية والانتماء</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 text-center glass-effect hover-lift">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-industry float-icon"></i>
                        </div>
                        <h5 class="card-title">التصنيع المحلي</h5>
                        <p class="card-text">نساهم في التنويع الاقتصادي من خلال التصنيع المحلي للملابس مكةية</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 reveal-on-scroll">
    <div class="container">
        <div class="row text-center mb-5 reveal-fade-up">
            <div class="col-12">
                <h2 class="section-title">قيمنا ومبادئنا</h2>
                <p class="lead">نلتزم بأعلى معايير الجودة والاحترافية في كل ما نقدمه</p>
            </div>
        </div>
        
        <div class="row g-4 reveal-stagger">
            <div class="col-md-4">
                <div class="card h-100 text-center glass-effect hover-lift">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-shield-alt float-icon"></i>
                        </div>
                        <h5 class="card-title">ثقة</h5>
                        <p class="card-text">نحن نثق في جودة منتجاتنا ونضمن رضا عملائنا الكرام</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 text-center glass-effect hover-lift">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-bolt float-icon"></i>
                        </div>
                        <h5 class="card-title">سرعة</h5>
                        <p class="card-text">نوفر خدمات سريعة وفعالة لتلبية احتياجات عملائنا في الوقت المحدد</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 text-center glass-effect hover-lift">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-handshake float-icon"></i>
                        </div>
                        <h5 class="card-title">مصداقية</h5>
                        <p class="card-text">نلتزم بالشفافية والمصداقية في جميع تعاملاتنا مع العملاء</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 text-center glass-effect hover-lift">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-star float-icon"></i>
                        </div>
                        <h5 class="card-title">جودة</h5>
                        <p class="card-text">نستخدم أفضل المواد والتقنيات في تصنيع منتجاتنا</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 text-center glass-effect hover-lift">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-palette float-icon"></i>
                        </div>
                        <h5 class="card-title">تصميم</h5>
                        <p class="card-text">نقدم تصاميم عصرية ومبتكرة تناسب جميع الأذواق والاحتياجات</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 text-center glass-effect hover-lift">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-user-tie float-icon"></i>
                        </div>
                        <h5 class="card-title">احترافية</h5>
                        <p class="card-text">فريق عمل محترف ومتخصص في مجال الملابس مكةية</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5 bg-light reveal-on-scroll section-with-bg">
    <div class="container">
        <div class="row text-center mb-5 reveal-fade-up">
            <div class="col-12">
                <h2 class="section-title">خدماتنا</h2>
                <p class="lead">اكتشف مجموعتنا المتنوعة من الخدمات المتميزة</p>
            </div>
        </div>
        
        <div class="row g-4 reveal-stagger">
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 glass-effect hover-lift">
                    <div class="card-body text-center">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-tshirt float-icon"></i>
                        </div>
                        <h5 class="card-title">الملابس مكةية</h5>
                        <p class="card-text">تصميم وإنتاج ملابس رياضية عالية الجودة للأندية والأكاديميات</p>
                        <a href="{{ route('services') }}" class="btn btn-primary">
                            عرض التفاصيل
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 glass-effect hover-lift">
                    <div class="card-body text-center">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-graduation-cap float-icon"></i>
                        </div>
                        <h5 class="card-title">الزي المدرسي</h5>
                        <p class="card-text">توفير زي مدرسي موحد بأعلى معايير الجودة للمدارس والمؤسسات التعليمية</p>
                        <a href="{{ route('services') }}" class="btn btn-primary">
                            عرض التفاصيل
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 glass-effect hover-lift">
                    <div class="card-body text-center">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-building float-icon"></i>
                        </div>
                        <h5 class="card-title">الزي الموحد للشركات</h5>
                        <p class="card-text">تصميم وإنتاج زي موحد احترافي للشركات والمؤسسات</p>
                        <a href="{{ route('services') }}" class="btn btn-primary">
                            عرض التفاصيل
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 glass-effect hover-lift">
                    <div class="card-body text-center">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-palette float-icon"></i>
                        </div>
                        <h5 class="card-title">التصميم المخصص</h5>
                        <p class="card-text">خدمات تصميم مخصصة لتلبية احتياجاتك الفريدة</p>
                        <a href="{{ route('custom-designs.create') }}" class="btn btn-primary">
                            طلب تصميم
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">معرض أعمالنا</h2>
                <p class="lead">نماذج من أعمالنا السابقة التي نفخر بها</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 glass-effect hover-lift">
                    <div class="card-body text-center">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-tshirt float-icon"></i>
                        </div>
                        <h5 class="card-title">أكاديمية مكةة</h5>
                        <p class="card-text">تصميم وإنتاج زي رياضي موحد لأكاديمية مكةة</p>
                        <a href="{{ route('portfolio.index') }}" class="btn btn-primary">
                            عرض المزيد
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 glass-effect hover-lift">
                    <div class="card-body text-center">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-graduation-cap float-icon"></i>
                        </div>
                        <h5 class="card-title">مدارس مكة</h5>
                        <p class="card-text">تصميم وإنتاج زي مدرسي موحد لمدارس مكة</p>
                        <a href="{{ route('portfolio.index') }}" class="btn btn-primary">
                            عرض المزيد
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 glass-effect hover-lift">
                    <div class="card-body text-center">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-building float-icon"></i>
                        </div>
                        <h5 class="card-title">شركة الاتصالات</h5>
                        <p class="card-text">تصميم وإنتاج زي موحد لشركة الاتصالات</p>
                        <a href="{{ route('portfolio.index') }}" class="btn btn-primary">
                            عرض المزيد
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 glass-effect hover-lift">
                    <div class="card-body text-center">
                        <div class="infinity-logo mx-auto mb-3 pulse-soft" style="width: 60px; height: 60px;">
                            <i class="fas fa-futbol float-icon"></i>
                        </div>
                        <h5 class="card-title">نادي الهلال</h5>
                        <p class="card-text">تصميم وإنتاج زي رياضي لنادي الهلال</p>
                        <a href="{{ route('portfolio.index') }}" class="btn btn-primary">
                            عرض المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <a href="{{ route('portfolio.index') }}" class="btn btn-primary btn-lg">
                عرض جميع الأعمال
            </a>
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



<!-- CTA Section -->
<section class="py-5 bg-gradient-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <div class="cta-content">
                    <h2 class="display-5 fw-bold mb-4">هل تريد تصميم زي موحد مخصص؟</h2>
                    <p class="lead mb-4">استخدم أداة التصميم المتقدمة لإنشاء زي موحد فريد يناسب احتياجاتك</p>
                    <div class="cta-buttons">
                       
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
