@extends('layouts.app')

@section('title', 'الفئات - Infinity Wear')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="section-title">فئات منتجاتنا</h1>
            <p class="lead">اكتشف مجموعتنا المتنوعة من الملابس الرياضية والزي الموحد</p>
        </div>
    </div>
    
    @if($categories->count() > 0)
        <div class="row g-4">
            @foreach($categories as $category)
                <div class="col-md-6 col-lg-4">
                    <div class="card category-card h-100">
                        <div class="category-image" 
                             style="background-image: url('{{ $category->image ? asset($category->image) : '/images/placeholder-category.jpg' }}')">
                            <div class="category-overlay">
                                <div class="category-info">
                                    <h4 class="category-title">{{ $category->name_ar }}</h4>
                                    <p class="category-count">{{ $category->products_count }} منتج</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->name_ar }}</h5>
                            <p class="card-text">{{ Str::limit($category->description_ar, 100) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    <i class="fas fa-box me-1"></i>
                                    {{ $category->products_count }} منتج
                                </span>
                                <a href="{{ route('categories.show', $category) }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    عرض المنتجات
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    لا توجد فئات متاحة حالياً
                </div>
            </div>
        </div>
    @endif
</div>

<!-- قسم الخدمات -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">خدماتنا المتخصصة</h2>
                <p class="lead">نقدم حلول شاملة لجميع احتياجاتكم</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card service-card text-center h-100">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-running"></i>
                        </div>
                        <h5 class="card-title">ملابس رياضية</h5>
                        <p class="card-text">أفضل الملابس الرياضية للأكاديميات والفرق الرياضية</p>
                        <a href="{{ route('products.index', ['category' => 'sports']) }}" class="btn btn-outline-primary">
                            تصفح المنتجات
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card service-card text-center h-100">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h5 class="card-title">زي مدرسي</h5>
                        <p class="card-text">زي موحد أنيق ومريح للمدارس والأكاديميات</p>
                        <a href="{{ route('products.index', ['category' => 'school']) }}" class="btn btn-outline-primary">
                            تصفح المنتجات
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card service-card text-center h-100">
                    <div class="card-body">
                        <div class="infinity-logo mx-auto mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-building"></i>
                        </div>
                        <h5 class="card-title">زي شركات</h5>
                        <p class="card-text">زي موحد احترافي للشركات والمؤسسات</p>
                        <a href="{{ route('products.index', ['category' => 'corporate']) }}" class="btn btn-outline-primary">
                            تصفح المنتجات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.category-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.category-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.category-image {
    height: 200px;
    background-size: cover;
    background-position: center;
    background-color: #f3f4f6;
    position: relative;
}

.category-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(30, 58, 138, 0.8), rgba(59, 130, 246, 0.6));
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.category-card:hover .category-overlay {
    opacity: 1;
}

.category-info {
    text-align: center;
    color: white;
}

.category-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.category-count {
    font-size: 1rem;
    margin: 0;
}

.service-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
</style>
@endsection 