@extends('layouts.app')

@section('title', 'Infinity Wear - ملابس موحدة مخصصة')

@section('content')
<div class="container-fluid py-5">
    <!-- Hero Section -->
    <div class="row align-items-center min-vh-100">
        <div class="col-lg-6">
            <div class="hero-content">
                <h1 class="display-4 fw-bold text-primary mb-4">
                    <i class="fas fa-infinity me-3"></i>
                    Infinity Wear
                </h1>
                <h2 class="h3 text-dark mb-4">ملابس موحدة مخصصة بجودة عالية</h2>
                <p class="lead text-muted mb-5">
                    نحن متخصصون في تصميم وتصنيع الملابس الموحدة للشركات والمؤسسات والأكاديميات الرياضية. 
                    نقدم حلولاً شاملة من التصميم إلى التسليم.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('importers.register') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        ابدأ التصميم الآن
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        لوحة التحكم
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="hero-image text-center">
                <div class="position-relative">
                    <div class="hero-bg"></div>
                    <i class="fas fa-tshirt hero-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row py-5">
        <div class="col-12">
            <h3 class="text-center fw-bold mb-5">لماذا تختار Infinity Wear؟</h3>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card text-center p-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-palette"></i>
                </div>
                <h5 class="fw-bold">تصميم مخصص</h5>
                <p class="text-muted">تصميم تفاعلي ثلاثي الأبعاد مع خيارات ألوان وأنماط لا محدودة</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card text-center p-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-cogs"></i>
                </div>
                <h5 class="fw-bold">جودة عالية</h5>
                <p class="text-muted">نستخدم أفضل المواد والتقنيات لضمان الجودة والراحة</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="feature-card text-center p-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h5 class="fw-bold">تسليم سريع</h5>
                <p class="text-muted">تسليم سريع وموثوق مع إمكانية التتبع المباشر</p>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div class="row py-5 bg-light rounded-3">
        <div class="col-12">
            <h3 class="text-center fw-bold mb-5">خدماتنا</h3>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="service-card text-center p-4">
                <div class="service-icon mb-3">
                    <i class="fas fa-building"></i>
                </div>
                <h6 class="fw-bold">ملابس الشركات</h6>
                <p class="small text-muted">قمصان، بناطيل، جاكيتات للشركات</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="service-card text-center p-4">
                <div class="service-icon mb-3">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h6 class="fw-bold">ملابس المدارس</h6>
                <p class="small text-muted">زي مدرسي مخصص للطلاب والمعلمين</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="service-card text-center p-4">
                <div class="service-icon mb-3">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h6 class="fw-bold">ملابس المستشفيات</h6>
                <p class="small text-muted">ملابس طبية مريحة وعملية</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="service-card text-center p-4">
                <div class="service-icon mb-3">
                    <i class="fas fa-futbol"></i>
                </div>
                <h6 class="fw-bold">ملابس رياضية</h6>
                <p class="small text-muted">ملابس للأكاديميات والفرق الرياضية</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="row py-5">
        <div class="col-12 text-center">
            <h3 class="fw-bold mb-4">ابدأ تصميمك الآن</h3>
            <p class="lead text-muted mb-4">تصميم تفاعلي ثلاثي الأبعاد مع خيارات لا محدودة</p>
            <a href="{{ route('importers.register') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-rocket me-2"></i>
                ابدأ التصميم
            </a>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.hero-content {
    padding: 2rem 0;
}

.hero-image {
    position: relative;
    height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-bg {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    height: 300px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    opacity: 0.1;
    animation: pulse 3s ease-in-out infinite;
}

.hero-icon {
    font-size: 8rem;
    color: #667eea;
    z-index: 2;
    position: relative;
    animation: float 3s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: translate(-50%, -50%) scale(1); }
    50% { transform: translate(-50%, -50%) scale(1.1); }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.feature-card, .service-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.feature-card:hover, .service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

.feature-icon, .service-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 2rem;
}

.service-icon {
    width: 60px;
    height: 60px;
    font-size: 1.5rem;
}

.bg-light {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
}

@media (max-width: 768px) {
    .hero-icon {
        font-size: 5rem;
    }
    
    .hero-bg {
        width: 200px;
        height: 200px;
    }
    
    .display-4 {
        font-size: 2.5rem;
    }
}
</style>
@endsection
