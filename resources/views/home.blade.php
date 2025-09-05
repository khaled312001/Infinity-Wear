@extends('layouts.app')

@section('title', 'Infinity Wear - مؤسسة اللباس اللامحدود')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">
                    مرحباً بك في <span class="text-warning">Infinity Wear</span>
                </h1>
                <p class="lead mb-4">
                    مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-warning btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>
                        تصفح المنتجات
                    </a>
                    <a href="{{ route('custom-designs.create') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-palette me-2"></i>
                        صمم زي موحد
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <div class="infinity-logo" style="width: 200px; height: 200px; font-size: 4rem; margin: 0 auto;">
                        
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
                        <p class="card-text">نحن نثق في جودة منتجاتنا ونضمن رضا عملائنا</p>
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
                        <p class="card-text">نوفر خدمات سريعة وفعالة لتلبية احتياجات عملائنا</p>
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
                        <p class="card-text">نلتزم بالشفافية والمصداقية في جميع تعاملاتنا</p>
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
                        <p class="card-text">نقدم تصاميم عصرية ومبتكرة تناسب جميع الأذواق</p>
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
                <p class="lead">اكتشف مجموعتنا المتنوعة من الملابس الرياضية</p>
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
                <p class="lead">أفضل منتجاتنا المختارة بعناية</p>
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

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h2 class="mb-4">هل تريد تصميم زي موحد مخصص؟</h2>
                <p class="lead mb-4">استخدم أداة التصميم المخصصة لإنشاء زي موحد يناسب احتياجاتك</p>
                <a href="{{ route('custom-designs.create') }}" class="btn btn-warning btn-lg">
                    <i class="fas fa-palette me-2"></i>
                    ابدأ التصميم الآن
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
