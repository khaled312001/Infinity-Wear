@extends('layouts.app')

@section('title', $product->name_ar ?? $product->name . ' - Infinity Wear')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-6">
            <div class="product-image-container">
                @if($product->images)
                    @php
                        $images = json_decode($product->images);
                    @endphp
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ $image }}" class="d-block w-100" alt="{{ $product->name_ar ?? $product->name }}" style="height: 400px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                        @if(count($images) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>
                @else
                    <img src="{{ asset('images/placeholder.jpg') }}" class="img-fluid" alt="{{ $product->name_ar ?? $product->name }}" style="height: 400px; object-fit: cover;">
                @endif
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="product-details">
                <h1 class="product-title">{{ $product->name_ar ?? $product->name }}</h1>
                
                @if($product->category)
                    <p class="product-category">
                        <span class="badge bg-primary">{{ $product->category->name_ar ?? $product->category->name }}</span>
                    </p>
                @endif
                
                <div class="product-price-section mb-4">
                    @if($product->sale_price)
                        <span class="product-sale-price">{{ number_format($product->price, 2) }} ريال</span>
                        <span class="product-price">{{ number_format($product->sale_price, 2) }} ريال</span>
                        <span class="discount-badge">خصم {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</span>
                    @else
                        <span class="product-price">{{ number_format($product->price, 2) }} ريال</span>
                    @endif
                </div>
                
                <div class="product-description mb-4">
                    <h5>الوصف</h5>
                    <p>{{ $product->description_ar ?? $product->description }}</p>
                </div>
                
                @if($product->features)
                    <div class="product-features mb-4">
                        <h5>المميزات</h5>
                        <ul class="list-unstyled">
                            @foreach(json_decode($product->features) as $feature)
                                <li><i class="fas fa-check text-success me-2"></i>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="product-actions">
                    <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-phone me-2"></i>
                        اطلب الآن
                    </a>
                    <a href="{{ route('contact.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-palette me-2"></i>
                        تصميم مخصص
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">منتجات ذات صلة</h3>
                <div class="row g-4">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-md-4">
                            <div class="card product-card h-100">
                                <img src="{{ $relatedProduct->images ? json_decode($relatedProduct->images)[0] : asset('images/placeholder.jpg') }}" 
                                     class="card-img-top" alt="{{ $relatedProduct->name_ar ?? $relatedProduct->name }}" 
                                     style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $relatedProduct->name_ar ?? $relatedProduct->name }}</h5>
                                    <p class="card-text">{{ Str::limit($relatedProduct->description_ar ?? $relatedProduct->description, 60) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="product-price">{{ number_format($relatedProduct->price, 2) }} ريال</span>
                                        <a href="{{ route('portfolio.show', $relatedProduct) }}" class="btn btn-sm btn-outline-primary">عرض</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
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
@endsection