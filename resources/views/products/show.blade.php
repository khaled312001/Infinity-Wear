@extends('layouts.app')

@section('title', $product->name_ar . ' - Infinity Wear')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">المنتجات</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name_ar }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name_ar }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- صور المنتج -->
        <div class="col-lg-6">
            <div class="product-images">
                @if($product->images)
                    @php $images = json_decode($product->images); @endphp
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset($image) }}" class="d-block w-100 product-main-image" alt="{{ $product->name_ar }}">
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
                    
                    <!-- صور مصغرة -->
                    @if(count($images) > 1)
                        <div class="product-thumbnails mt-3">
                            <div class="row">
                                @foreach($images as $index => $image)
                                    <div class="col-3">
                                        <img src="{{ asset($image) }}" 
                                             class="img-thumbnail product-thumbnail {{ $index === 0 ? 'active' : '' }}" 
                                             data-bs-target="#productCarousel" 
                                             data-bs-slide-to="{{ $index }}"
                                             alt="{{ $product->name_ar }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <div class="product-no-image">
                        <div class="infinity-logo mx-auto" style="width: 200px; height: 200px;">
                            <i class="fas fa-tshirt"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- تفاصيل المنتج -->
        <div class="col-lg-6">
            <div class="product-details">
                <h1 class="product-title">{{ $product->name_ar }}</h1>
                <p class="product-category">
                    <a href="{{ route('categories.show', $product->category) }}" class="text-primary">
                        <i class="fas fa-tag me-1"></i>
                        {{ $product->category->name_ar }}
                    </a>
                </p>

                <div class="product-price mb-4">
                    @if($product->sale_price)
                        <span class="sale-price">{{ number_format($product->price, 2) }} ريال</span>
                        <span class="current-price">{{ number_format($product->sale_price, 2) }} ريال</span>
                        <span class="discount-badge">خصم {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</span>
                    @else
                        <span class="current-price">{{ number_format($product->price, 2) }} ريال</span>
                    @endif
                </div>

                <div class="product-description mb-4">
                    <h5>وصف المنتج</h5>
                    <p>{{ $product->description_ar }}</p>
                </div>

                <div class="product-info mb-4">
                    <div class="row">
                        <div class="col-6">
                            <div class="info-item">
                                <strong>كود المنتج:</strong>
                                <span>{{ $product->sku }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-item">
                                <strong>التوفر:</strong>
                                @if($product->stock_quantity > 0)
                                    <span class="text-success">
                                        <i class="fas fa-check me-1"></i>
                                        متوفر ({{ $product->stock_quantity }} قطعة)
                                    </span>
                                @else
                                    <span class="text-danger">
                                        <i class="fas fa-times me-1"></i>
                                        غير متوفر
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if($product->is_featured)
                    <div class="featured-badge mb-4">
                        <span class="badge bg-warning">
                            <i class="fas fa-star me-1"></i>
                            منتج مميز
                        </span>
                    </div>
                @endif

                <!-- أزرار العمل -->
                <div class="product-actions">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <button class="btn btn-primary btn-lg w-100" onclick="requestQuote()">
                                <i class="fas fa-calculator me-2"></i>
                                طلب عرض سعر
                            </button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('custom-designs.create') }}" class="btn btn-outline-primary btn-lg w-100">
                                <i class="fas fa-palette me-2"></i>
                                تصميم مخصص
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- المنتجات ذات الصلة -->
@if($relatedProducts->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">منتجات مشابهة</h2>
                <p class="lead">منتجات أخرى من نفس الفئة قد تعجبك</p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($relatedProducts as $relatedProduct)
                <div class="col-md-6 col-lg-3">
                    <div class="card product-card h-100">
                        <div class="product-image" 
                             style="background-image: url('{{ $relatedProduct->images ? asset(json_decode($relatedProduct->images)[0]) : '/images/placeholder.jpg' }}')">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $relatedProduct->name_ar }}</h5>
                            <p class="card-text">{{ Str::limit($relatedProduct->description_ar, 60) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    @if($relatedProduct->sale_price)
                                        <span class="product-sale-price">{{ number_format($relatedProduct->price, 2) }} ريال</span>
                                        <span class="product-price">{{ number_format($relatedProduct->sale_price, 2) }} ريال</span>
                                    @else
                                        <span class="product-price">{{ number_format($relatedProduct->price, 2) }} ريال</span>
                                    @endif
                                </div>
                                @if($relatedProduct->is_featured)
                                    <span class="badge bg-warning">مميز</span>
                                @endif
                            </div>
                            
                            <div class="d-grid">
                                <a href="{{ route('products.show', $relatedProduct) }}" class="btn btn-primary">
                                    <i class="fas fa-eye me-2"></i>
                                    عرض التفاصيل
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- نموذج طلب عرض سعر -->
<div class="modal fade" id="quoteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">طلب عرض سعر</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الاسم</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="tel" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الكمية المطلوبة</label>
                        <input type="number" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات إضافية</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">إرسال الطلب</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.product-main-image {
    height: 400px;
    object-fit: cover;
    border-radius: 10px;
}

.product-thumbnail {
    height: 80px;
    object-fit: cover;
    cursor: pointer;
    transition: all 0.3s ease;
}

.product-thumbnail.active,
.product-thumbnail:hover {
    border-color: var(--primary-color);
    transform: scale(1.05);
}

.product-no-image {
    height: 400px;
    background: #f8fafc;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-title {
    color: var(--primary-color);
    font-weight: 700;
    margin-bottom: 10px;
}

.product-category {
    margin-bottom: 20px;
}

.product-price {
    font-size: 1.5rem;
}

.current-price {
    color: var(--primary-color);
    font-weight: 700;
}

.sale-price {
    text-decoration: line-through;
    color: #6b7280;
    margin-left: 10px;
}

.discount-badge {
    background: var(--danger-color);
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    margin-right: 10px;
}

.info-item {
    margin-bottom: 10px;
}

.featured-badge {
    margin-bottom: 20px;
}

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

@section('scripts')
<script>
function requestQuote() {
    const modal = new bootstrap.Modal(document.getElementById('quoteModal'));
    modal.show();
}
</script>
@endsection
