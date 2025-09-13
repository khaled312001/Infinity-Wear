@extends('layouts.app')

@section('title', 'آراء العملاء - مؤسسة اللباس اللامحدود')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hero-content text-center">
                    <h1>آراء عملائنا</h1>
                    <p class="lead">نفتخر بثقة عملائنا ونسعد بمشاركة تجاربهم معنا</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-4 mb-4">
                <div class="stats-card glass-effect hover-lift h-100">
                    <div class="stats-card-body">
                        <div class="stats-icon">
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <h3>{{ number_format($averageRating, 1) }}</h3>
                        <p>متوسط التقييم</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stats-card glass-effect hover-lift h-100">
                    <div class="stats-card-body">
                        <div class="stats-icon">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                        <h3>{{ $testimonialCount }}</h3>
                        <p>عدد التقييمات</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stats-card glass-effect hover-lift h-100">
                    <div class="stats-card-body">
                        <div class="stats-icon">
                            <i class="fas fa-certificate text-success"></i>
                        </div>
                        <h3>100%</h3>
                        <p>رضا العملاء</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @foreach($testimonials as $testimonial)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 testimonial-card glass-effect hover-lift">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="testimonial-avatar me-3">
                                @if($testimonial->image)
                                    <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->client_name }}" class="rounded-circle">
                                @else
                                    <i class="fas fa-user-circle fa-3x"></i>
                                @endif
                            </div>
                            <div>
                                <h5 class="card-title mb-0">{{ $testimonial->client_name }}</h5>
                                <p class="text-muted small mb-0">{{ $testimonial->client_position }}, {{ $testimonial->client_company }}</p>
                            </div>
                        </div>
                        <div class="testimonial-rating mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testimonial->rating)
                                    <i class="fas fa-star text-warning"></i>
                                @elseif($i - 0.5 <= $testimonial->rating)
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                        </div>
                        <div class="testimonial-text">
                            <i class="fas fa-quote-right fa-xs text-primary"></i>
                            <p class="mb-0">{{ $testimonial->content }}</p>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-end">
                        <small class="text-muted">{{ $testimonial->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $testimonials->links() }}
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('testimonials.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle me-2"></i>أضف شهادتك
            </a>
        </div>
    </div>
</section>
@endsection