@extends('layouts.app')

@section('title', 'آراء العملاء - مؤسسة اللباس اللامحدود')

@section('styles')
<style>
    .testimonials-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
        padding: 120px 0 80px;
    }
    
    .testimonials-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    
    .testimonials-hero .hero-content {
        position: relative;
        z-index: 2;
        color: white;
    }
    
    .testimonials-hero h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }
    
    .testimonials-hero .lead {
        font-size: 1.3rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .floating-elements {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }
    
    .floating-star {
        position: absolute;
        color: rgba(255,255,255,0.1);
        animation: float 6s ease-in-out infinite;
    }
    
    .floating-star:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
    .floating-star:nth-child(2) { top: 60%; left: 80%; animation-delay: 2s; }
    .floating-star:nth-child(3) { top: 30%; left: 70%; animation-delay: 4s; }
    .floating-star:nth-child(4) { top: 80%; left: 20%; animation-delay: 1s; }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }
    
    /* Enhanced Stats Cards */
    .enhanced-stats-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }
    
    .enhanced-stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }
    
    .enhanced-stats-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }
    
    .stats-card-inner {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .stats-icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        flex-shrink: 0;
    }
    
    .stats-content {
        flex: 1;
    }
    
    .stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
        line-height: 1;
    }
    
    .stats-label {
        color: #718096;
        font-size: 1.1rem;
        margin: 0.5rem 0;
    }
    
    .stats-progress {
        height: 6px;
        background: #e2e8f0;
        border-radius: 3px;
        overflow: hidden;
        margin-top: 1rem;
    }
    
    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #667eea, #764ba2);
        border-radius: 3px;
        transition: width 1s ease;
    }
    
    /* Enhanced Testimonial Cards */
    .enhanced-testimonial-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.2);
    }
    
    .enhanced-testimonial-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ffc107, #ff6b35, #e91e63);
    }
    
    .enhanced-testimonial-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 60px rgba(0,0,0,0.15);
    }
    
    .testimonial-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .testimonial-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
        border: 3px solid #e2e8f0;
    }
    
    .testimonial-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }
    
    .testimonial-info {
        flex: 1;
    }
    
    .client-name {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2d3748;
        margin: 0 0 0.25rem 0;
    }
    
    .client-details {
        color: #4a5568;
        font-size: 0.9rem;
        margin: 0 0 0.25rem 0;
    }
    
    .client-company {
        color: #718096;
        font-size: 0.85rem;
        margin: 0;
    }
    
    .testimonial-rating {
        margin-bottom: 1.5rem;
        text-align: center;
    }
    
    .testimonial-rating i {
        color: #ffc107;
        font-size: 1.2rem;
        margin: 0 2px;
    }
    
    .testimonial-content {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .quote-icon {
        position: absolute;
        top: -10px;
        right: -5px;
        color: #e2e8f0;
        font-size: 2rem;
        z-index: 1;
    }
    
    .testimonial-text {
        position: relative;
        z-index: 2;
        color: #4a5568;
        line-height: 1.6;
        font-style: italic;
        margin: 0;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        border-right: 4px solid #667eea;
    }
    
    .testimonial-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .testimonial-date {
        color: #718096;
        font-size: 0.85rem;
    }
    
    .testimonial-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #38a169;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    /* Enhanced Pagination */
    .enhanced-pagination {
        background: white;
        padding: 1rem 2rem;
        border-radius: 50px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .enhanced-pagination .pagination {
        margin: 0;
    }
    
    .enhanced-pagination .page-link {
        border: none;
        color: #667eea;
        padding: 0.75rem 1rem;
        margin: 0 0.25rem;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .enhanced-pagination .page-link:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }
    
    .enhanced-pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }
    
    /* Call to Action Section */
    .cta-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 3rem 2rem;
        border-radius: 25px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23dots)"/></svg>');
        opacity: 0.3;
    }
    
    .cta-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        position: relative;
        z-index: 2;
    }
    
    .cta-description {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 2rem;
        position: relative;
        z-index: 2;
    }
    
    .btn-cta {
        position: relative;
        background: white;
        color: #667eea;
        border: none;
        padding: 1rem 2.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        overflow: hidden;
        transition: all 0.3s ease;
        z-index: 2;
    }
    
    .btn-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        color: #667eea;
    }
    
    .btn-ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(102, 126, 234, 0.3);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }
    
    .btn-ripple.animate {
        animation: ripple 0.6s linear;
    }
    
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .testimonials-hero h1 {
            font-size: 2.5rem;
        }
        
        .stats-card-inner {
            flex-direction: column;
            text-align: center;
        }
        
        .testimonial-header {
            flex-direction: column;
            text-align: center;
        }
        
        .cta-title {
            font-size: 2rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Enhanced Hero Section -->
<section class="testimonials-hero">
    <div class="floating-elements">
        <i class="fas fa-star fa-2x floating-star"></i>
        <i class="fas fa-heart fa-lg floating-star"></i>
        <i class="fas fa-star fa-lg floating-star"></i>
        <i class="fas fa-heart fa-2x floating-star"></i>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hero-content text-center">
                    <h1 data-aos="fade-up">آراء عملائنا</h1>
                    <p class="lead" data-aos="fade-up" data-aos-delay="200">نفتخر بثقة عملائنا ونسعد بمشاركة تجاربهم معنا</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Stats Section -->
<section class="py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="enhanced-stats-card h-100">
                    <div class="stats-card-inner">
                        <div class="stats-icon-wrapper">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">{{ number_format($averageRating, 1) }}</h3>
                            <p class="stats-label">متوسط التقييم</p>
                            <div class="stats-progress">
                                <div class="progress-bar" data-width="{{ ($averageRating / 5) * 100 }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="enhanced-stats-card h-100">
                    <div class="stats-card-inner">
                        <div class="stats-icon-wrapper">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">{{ $testimonialCount }}</h3>
                            <p class="stats-label">عدد التقييمات</p>
                            <div class="stats-progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="enhanced-stats-card h-100">
                    <div class="stats-card-inner">
                        <div class="stats-icon-wrapper">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-number">100%</h3>
                            <p class="stats-label">رضا العملاء</p>
                            <div class="stats-progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Testimonials Grid -->
        <div class="row g-4">
            @foreach($testimonials as $index => $testimonial)
            <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                <div class="enhanced-testimonial-card h-100">
                    <div class="testimonial-header">
                        <div class="testimonial-avatar">
                            @if($testimonial->image)
                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->client_name }}">
                            @else
                                <div class="avatar-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div class="testimonial-info">
                            <h5 class="client-name">{{ $testimonial->client_name }}</h5>
                            <p class="client-details">{{ $testimonial->client_position }}</p>
                            <p class="client-company">{{ $testimonial->client_company }}</p>
                        </div>
                    </div>
                    
                    <div class="testimonial-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimonial->rating)
                                <i class="fas fa-star"></i>
                            @elseif($i - 0.5 <= $testimonial->rating)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    
                    <div class="testimonial-content">
                        <div class="quote-icon">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text">{{ $testimonial->content }}</p>
                    </div>
                    
                    <div class="testimonial-footer">
                        <span class="testimonial-date">{{ $testimonial->created_at->diffForHumans() }}</span>
                        <div class="testimonial-badge">
                            <i class="fas fa-check-circle"></i>
                            <span>موثق</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Enhanced Pagination -->
        <div class="d-flex justify-content-center mt-5">
            <div class="enhanced-pagination">
                {{ $testimonials->links() }}
            </div>
        </div>

        <!-- Call to Action Section -->
        <div class="text-center mt-5" data-aos="fade-up">
            <div class="cta-section">
                <h3 class="cta-title">شاركنا تجربتك</h3>
                <p class="cta-description">هل استفدت من خدماتنا؟ نود أن نسمع رأيك</p>
                <a href="{{ route('testimonials.create') }}" class="btn btn-cta">
                    <i class="fas fa-plus-circle me-2"></i>
                    <span>أضف شهادتك</span>
                    <div class="btn-ripple"></div>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Initialize AOS animations
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
    
    // Set progress bar widths
    document.addEventListener('DOMContentLoaded', function() {
        const progressBars = document.querySelectorAll('.progress-bar[data-width]');
        progressBars.forEach(bar => {
            const width = bar.getAttribute('data-width');
            bar.style.width = width + '%';
        });
    });
    
    // Add ripple effect to CTA button
    document.querySelector('.btn-cta').addEventListener('click', function(e) {
        const ripple = this.querySelector('.btn-ripple');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('animate');
        
        setTimeout(() => {
            ripple.classList.remove('animate');
        }, 600);
    });
</script>
@endsection