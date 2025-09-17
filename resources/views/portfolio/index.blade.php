@extends('layouts.app')

@section('title', 'معرض أعمالنا - Infinity Wear')

@section('content')
<!-- قسم العنوان الرئيسي -->
<section class="hero-section hero-inner-section bg-light py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-end">
                <h1 class="display-4 fw-bold mb-3">معرض أعمالنا</h1>
                <p class="lead mb-4">نفخر بتقديم مجموعة متنوعة من الأعمال المميزة التي قمنا بتنفيذها لعملائنا</p>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/portfolio/portfolio-hero.svg') }}" alt="معرض الأعمال" class="img-fluid" style="max-height: 300px;">
            </div>
        </div>
    </div>
</section>

<!-- قسم الأعمال المميزة -->
<section class="featured-works py-5 mb-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="fw-bold">أعمالنا المميزة</h2>
            <p class="text-muted">نماذج من أفضل أعمالنا التي نفخر بها</p>
        </div>
        
        <div class="row g-4">
            @foreach($featuredItems as $item)
            <div class="col-md-4">
                <div class="card portfolio-card h-100">
                    <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <p class="card-text text-muted">{{ $item->category }}</p>
                        <a href="{{ route('portfolio.show', $item->id) }}" class="btn btn-outline-primary">عرض التفاصيل</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- قسم تصفية الأعمال حسب الفئة -->
<section class="portfolio-filter py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="fw-bold">جميع الأعمال</h2>
            <p class="text-muted">تصفح جميع أعمالنا حسب الفئة</p>
        </div>
        
        <div class="filter-buttons text-center mb-4">
            <button class="btn btn-outline-primary me-2 mb-2 filter-btn active" data-category="all">الكل</button>
            @foreach($categories as $category)
            <button class="btn btn-outline-primary me-2 mb-2 filter-btn" data-category="{{ $category }}">{{ $category }}</button>
            @endforeach
        </div>
        
        <div class="row g-4" id="portfolio-items">
            @foreach($portfolioItems as $item)
            <div class="col-md-4 col-lg-3 portfolio-item" data-category="{{ $item->category }}">
                <div class="card portfolio-card h-100">
                    <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <p class="card-text text-muted">{{ $item->category }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('portfolio.show', $item->id) }}" class="btn btn-sm btn-outline-primary">عرض التفاصيل</a>
                            <small class="text-muted">{{ $item->completion_date->format('Y/m/d') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- قسم الاتصال بنا -->
<section class="cta-section bg-light py-5 text-center">
    <div class="container">
        <h2 class="fw-bold mb-3">هل تريد تنفيذ مشروع مماثل؟</h2>
        <p class="lead mb-4">نحن هنا لمساعدتك في تحقيق رؤيتك بأعلى جودة وأفضل سعر</p>
        <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">تواصل معنا الآن</a>
    </div>
</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // تصفية العناصر حسب الفئة
        $('.filter-btn').on('click', function() {
            var category = $(this).data('category');
            
            // تحديث الزر النشط
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');
            
            // استخدام AJAX للحصول على العناصر المصفاة
            $.ajax({
                url: '{{ route("portfolio.filter") }}',
                type: 'POST',
                data: {
                    category: category,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#portfolio-items').html(response.html);
                    }
                },
                error: function() {
                    // في حالة الخطأ، نقوم بالتصفية على جانب العميل
                    if (category === 'all') {
                        $('.portfolio-item').show();
                    } else {
                        $('.portfolio-item').hide();
                        $('.portfolio-item[data-category="' + category + '"]').show();
                    }
                }
            });
        });
    });
</script>
@endsection

@section('styles')
<style>
    .portfolio-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .portfolio-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .portfolio-card img {
        height: 200px;
        object-fit: cover;
    }
    
    .filter-btn.active {
        background-color: var(--bs-primary);
        color: white;
    }
</style>
@endsection