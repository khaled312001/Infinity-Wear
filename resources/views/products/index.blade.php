@extends('layouts.app')

@section('title', 'المنتجات - Infinity Wear')

@section('styles')
<style>
    .product-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    
    .product-image {
        height: 220px;
        background-size: cover;
        background-position: center;
        transition: all 0.5s ease;
        position: relative;
        overflow: hidden;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
        transition: transform 0.3s ease;
    }
    
    .product-card:hover .product-badge {
        transform: rotate(10deg) scale(1.1);
    }
    
    .product-price {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.1rem;
    }
    
    .product-sale-price {
        text-decoration: line-through;
        color: #6c757d;
        font-size: 0.9rem;
        margin-right: 8px;
    }
    
    .card-title {
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--primary-color);
    }
    
    .card-text {
        color: #6c757d;
        margin-bottom: 15px;
    }
    
    .filter-section {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .search-input {
        border-top-right-radius: 25px !important;
        border-bottom-right-radius: 25px !important;
        padding-right: 20px;
    }
    
    .search-btn {
        border-top-left-radius: 25px !important;
        border-bottom-left-radius: 25px !important;
        padding-left: 20px;
    }
    
    .category-select {
        border-radius: 25px;
        padding: 10px 20px;
    }
    
    .pagination {
        justify-content: center;
    }
    
    .page-link {
        border-radius: 50%;
        margin: 0 5px;
        border: none;
        color: var(--primary-color);
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .page-link:hover, .page-item.active .page-link {
        background-color: var(--primary-color);
        color: white;
        transform: scale(1.1);
    }
    
    .no-products {
        padding: 50px 0;
        text-align: center;
    }
    
    .no-products i {
        font-size: 3rem;
        color: var(--accent-color);
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5" data-aos="fade-down">
            <h1 class="section-title">منتجاتنا</h1>
            <p class="lead">اكتشف مجموعتنا المتنوعة من الملابس الرياضية والزي الموحد</p>
        </div>
    </div>
    
    <!-- فلاتر البحث -->
    <div class="filter-section" data-aos="fade-up">
        <div class="row g-3">
            <div class="col-md-8">
                <form method="GET" action="{{ route('products.index') }}">
                    <div class="input-group">
                        <input type="text" class="form-control search-input" name="search" 
                               value="{{ request('search') }}" placeholder="ابحث عن منتج...">
                        <button class="btn btn-primary search-btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <form method="GET" action="{{ route('products.index') }}">
                    <select name="category" class="form-select category-select" onchange="this.form.submit()">
                        <option value="">جميع الفئات</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" 
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name_ar ?? $category->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>
    
    <!-- المنتجات -->
    @if(isset($products) && $products->count() > 0)
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="card product-card h-100">
                        <div class="product-image" 
                             style="background-image: url('{{ $product->images ? json_decode($product->images)[0] : '/images/placeholder.jpg' }}')">
                            @if($product->is_featured)
                                <div class="product-badge">
                                    <span class="badge bg-warning">مميز</span>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name_ar ?? $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description_ar ?? $product->description, 80) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    @if($product->sale_price)
                                        <span class="product-sale-price">{{ number_format($product->price, 2) }} ريال</span>
                                        <span class="product-price">{{ number_format($product->sale_price, 2) }} ريال</span>
                                    @else
                                        <span class="product-price">{{ number_format($product->price, 2) }} ريال</span>
                                    @endif
                                </div>
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
                {{ $products->links() }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12 text-center no-products" data-aos="fade-up">
                <i class="fas fa-search"></i>
                <div class="alert alert-info d-inline-block">
                    <i class="fas fa-info-circle me-2"></i>
                    لا توجد منتجات متاحة حالياً
                </div>
            </div>
        </div>
    @endif
</div>
@endsection