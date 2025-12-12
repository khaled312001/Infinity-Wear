@extends('layouts.app')

@section('title', $portfolioItem->title . ' - Infinity Wear')

@section('content')
<!-- قسم تفاصيل المشروع -->
<section class="portfolio-detail py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8">
                <img src="{{ $portfolioItem->image_url }}" alt="{{ $portfolioItem->title }}" class="img-fluid rounded main-image mb-4">
                
                @if($portfolioItem->gallery && count($portfolioItem->gallery) > 0)
                <div class="row g-2 gallery-images">
                    @foreach($portfolioItem->gallery_urls as $imageUrl)
                    <div class="col-4 col-md-3">
                        <a href="{{ $imageUrl }}" data-lightbox="portfolio-gallery">
                            <img src="{{ $imageUrl }}" alt="{{ $portfolioItem->title }}" class="img-fluid rounded gallery-thumb">
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            
            <div class="col-lg-4">
                <div class="project-info card">
                    <div class="card-body">
                        <h1 class="card-title h3 mb-4">{{ $portfolioItem->title }}</h1>
                        
                        <div class="project-meta mb-4">
                            <div class="row mb-2">
                                <div class="col-5 text-muted">العميل:</div>
                                <div class="col-7 fw-bold">{{ $portfolioItem->client_name }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 text-muted">الفئة:</div>
                                <div class="col-7">{{ $portfolioItem->category }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 text-muted">تاريخ الإنجاز:</div>
                                <div class="col-7">{{ $portfolioItem->completion_date->format('Y/m/d') }}</div>
                            </div>
                        </div>
                        
                        <div class="project-description">
                            <h5 class="mb-3">وصف المشروع</h5>
                            <p>{{ $portfolioItem->description }}</p>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('contact.index') }}" class="btn btn-primary w-100">طلب مشروع مماثل</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- المشاريع ذات الصلة -->
        @if(count($relatedItems) > 0)
        <div class="related-projects">
            <h3 class="mb-4">مشاريع مشابهة</h3>
            <div class="row g-4">
                @foreach($relatedItems as $item)
                <div class="col-md-4">
                    <div class="card portfolio-card h-100">
                        <img src="{{ $item->image_url }}" class="card-img-top" alt="{{ $item->title }}">
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
        @endif
        
        <div class="text-center mt-5">
            <a href="{{ route('portfolio.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-right me-2"></i>
                العودة إلى معرض الأعمال
            </a>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .main-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }
    
    .gallery-thumb {
        height: 100px;
        width: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }
    
    .gallery-thumb:hover {
        opacity: 0.8;
        transform: scale(1.03);
    }
    
    .project-info {
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border: none;
        height: 100%;
    }
    
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
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // تفعيل معرض الصور
        if(typeof lightbox !== 'undefined') {
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true
            });
        }
    });
</script>
@endsection