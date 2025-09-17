@extends('layouts.app')

@section('title', $category->name_ar . ' - Infinity Wear')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">الفئات</a></li>
            <li class="breadcrumb-item active">{{ $category->name_ar }}</li>
        </ol>
    </nav>

    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="section-title">{{ $category->name_ar }}</h1>
            <p class="lead">{{ $category->description_ar }}</p>
        </div>
    </div>
    
    <!-- تفاصيل الفئة -->
    <div class="row mb-5">
        <div class="col-md-6">
            @if($category->image)
                <img src="{{ asset($category->image) }}" alt="{{ $category->name_ar }}" class="img-fluid rounded shadow">
            @else
                <div class="placeholder-image bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <div class="category-details">
                <h3 class="mb-4">تفاصيل الفئة</h3>
                <div class="mb-3">
                    <h5>الاسم بالعربية:</h5>
                    <p class="text-muted">{{ $category->name_ar }}</p>
                </div>
                <div class="mb-3">
                    <h5>الاسم بالإنجليزية:</h5>
                    <p class="text-muted">{{ $category->name_en }}</p>
                </div>
                <div class="mb-3">
                    <h5>الوصف بالعربية:</h5>
                    <p class="text-muted">{{ $category->description_ar }}</p>
                </div>
                <div class="mb-3">
                    <h5>الوصف بالإنجليزية:</h5>
                    <p class="text-muted">{{ $category->description_en }}</p>
                </div>
                <div class="mb-4">
                    <h5>الحالة:</h5>
                    <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $category->is_active ? 'نشطة' : 'غير نشطة' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- دعوة للتصميم المخصص -->
    <div class="row">
        <div class="col-12 text-center">
            <div class="alert alert-info">
                <h4 class="alert-heading">
                    <i class="fas fa-palette me-2"></i>
                    هل تريد تصميم مخصص لـ {{ $category->name_ar }}؟
                </h4>
                <p class="mb-3">استخدم أداة التصميم المتقدمة لإنشاء تصميم فريد يناسب احتياجاتك</p>
                <a href="{{ route('importers.form') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-magic me-2"></i>
                    ابدأ التصميم المخصص
                </a>
            </div>
        </div>
    </div>
</div>

<!-- قسم الدعوة للتصميم المخصص -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h2 class="mb-4">هل تريد تصميم مخصص لـ {{ $category->name_ar }}؟</h2>
                <p class="lead mb-4">استخدم أداة التصميم المتقدمة لإنشاء تصميم فريد يناسب احتياجاتك</p>
                <a href="{{ route('importers.form') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-palette me-2"></i>
                    ابدأ التصميم المخصص
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.category-details h5 {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.placeholder-image {
    border: 2px dashed #dee2e6;
}

.section-title {
    color: var(--primary-color);
    font-weight: 700;
    margin-bottom: 1rem;
}

.alert-info {
    border-left: 4px solid var(--primary-color);
}
</style>
@endsection