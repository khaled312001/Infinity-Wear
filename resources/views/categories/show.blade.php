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
    
    <!-- فلاتر البحث -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" action="{{ route('categories.show', $category) }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" 
                           value="{{ request('search') }}" placeholder="ابحث في {{ $category->name_ar }}...">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <form method="GET" action="{{ route('categories.show', $category) }}">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>الأحدث</option>
                    <option value="name_ar" {{ request('sort') == 'name_ar' ? 'selected' : '' }}>الاسم</option>
                    <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>السعر (الأقل)</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>السعر (الأعلى)</option>
                </select>
            </form>
        </div>
    </div>
    
    <!-- المنتجات -->
    @if($products->count() > 0)
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card product-card h-100">
                        <div class="product-image" 
                             style="background-image: url('{{ $product->images ? asset(json_decode($product->images)[0]) : '/images/placeholder.jpg' }}')">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name_ar }}</h5>
                            <p class="card-text">{{ Str::limit($product->description_ar, 80) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    @if($product->sale_price)
                                        <span class="product-sale-price">{{ number_format($product->price, 2) }} ريال</span>
                                        <span class="product-price">{{ number_format($product->sale_price, 2) }} ريال</span>
                                    @else
                                        <span class="product-price">{{ number_format($product->price, 2) }} ريال</span>
                                    @endif
                                </div>
                                @if($product->is_featured)
                                    <span class="badge bg-warning">مميز</span>
                                @endif
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-primary">
                                    <i class="fas fa-eye me-2"></i>
                                    عرض التفاصيل
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="row mt-5">
            <div class="col-12">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    @if(request('search'))
                        لا توجد منتجات تطابق بحثك "{{ request('search') }}" في فئة {{ $category->name_ar }}
                    @else
                        لا توجد منتجات في فئة {{ $category->name_ar }} حالياً
                    @endif
                </div>
                <a href="{{ route('categories.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-right me-2"></i>
                    تصفح الفئات الأخرى
                </a>
            </div>
        </div>
    @endif
</div>

<!-- قسم الدعوة للتصميم المخصص -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h2 class="mb-4">هل تريد تصميم مخصص لـ {{ $category->name_ar }}؟</h2>
                <p class="lead mb-4">استخدم أداة التصميم المتقدمة لإنشاء تصميم فريد يناسب احتياجاتك</p>
            
            </div>
        </div>
    </div>
</section>

<style>
.product-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.product-image {
    height: 200px;
    background-size: cover;
    background-position: center;
    background-color: #f3f4f6;
}

.product-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-color);
}

.product-sale-price {
    color: var(--danger-color);
    text-decoration: line-through;
    font-size: 0.9rem;
}
</style>
@endsection 