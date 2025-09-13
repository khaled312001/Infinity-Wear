@extends('layouts.app')

@section('title', 'Infinity Wear - مؤسسة اللباس اللامحدود | الرائدون في تصنيع الملابس والزي الرسمي')

@section('description', 'مؤسسة اللباس اللامحدود - شركة سعودية رائدة متخصصة في تصنيع وتوريد أجود أنواع الملابس والزي الرسمي للشركات والمؤسسات التعليمية والرياضية بأعلى معايير الجودة')

@section('keywords', 'ملابس رياضية، زي موحد، زي مدرسي، زي شركات، تصميم ملابس، infinity wear، اللباس اللامحدود، السعودية، الرياض، جودة عالية، تصنيع ملابس')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
@include('partials.hero-styles')

<style>
/* Advanced Home Page Enhancements */
.loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary-color), var(--dark-blue));
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    transition: opacity 0.5s ease;
}

.loading-screen.hidden {
    opacity: 0;
    pointer-events: none;
}

.loader {
    width: 60px;
    height: 60px;
    border: 4px solid rgba(255,255,255,0.3);
    border-top: 4px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Enhanced Statistics Section */
.stats-section {
    background: linear-gradient(135deg, var(--primary-color), var(--dark-blue));
    color: white;
    position: relative;
    overflow: hidden;
}

.stats-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.stat-counter {
    font-size: 3rem;
    font-weight: 900;
    margin-bottom: 0.5rem;
    background: linear-gradient(45deg, #ffc107, #ff9800);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Enhanced Feature Cards */
.feature-card {
    background: white;
    border-radius: 20px;
    padding: 40px 30px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    height: 100%;
    position: relative;
    overflow: hidden;
    border: 2px solid transparent;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    opacity: 0;
    transition: opacity 0.4s ease;
}

.feature-card:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: 0 25px 50px rgba(0,0,0,0.2);
    border-color: var(--primary-color);
}

.feature-card:hover::before {
    opacity: 0.95;
}

.feature-card:hover .card-content {
    color: white;
    position: relative;
    z-index: 2;
}

.feature-card:hover .card-icon {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.2) rotate(360deg);
}

.card-icon {
        width: 80px;
        height: 80px;
    margin: 0 auto 30px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    z-index: 2;
}

.card-icon::before {
    content: '';
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    background: linear-gradient(135deg, var(--accent-color), var(--secondary-color));
    border-radius: 50%;
    z-index: -1;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.feature-card:hover .card-icon::before {
    opacity: 1;
}

/* Advanced Testimonials */
.testimonial-card {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.testimonial-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
}

.testimonial-quote {
    font-size: 3rem;
    color: var(--primary-color);
    opacity: 0.3;
    position: absolute;
    top: 20px;
    right: 30px;
}

.testimonial-text {
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 30px;
    color: #555;
    position: relative;
    z-index: 2;
}

.author-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    margin-left: 15px;
    border: 3px solid var(--primary-color);
}

.author-name {
    font-weight: 700;
    color: #333;
    margin-bottom: 5px;
}

.author-position {
    color: #666;
    font-size: 0.9rem;
    margin: 0;
}

/* Portfolio Hover Effects */
.portfolio-item {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    background: #f8f9fa;
    transition: all 0.4s ease;
    cursor: pointer;
}

.portfolio-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
    opacity: 0;
    transition: opacity 0.4s ease;
    z-index: 1;
}

.portfolio-item:hover::before {
    opacity: 0.9;
}

.portfolio-item:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.portfolio-item img {
    width: 100%;
    height: 280px;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.portfolio-item:hover img {
    transform: scale(1.1);
}

.portfolio-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.9));
    color: white;
    padding: 40px 25px 25px;
    transform: translateY(100%);
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    z-index: 2;
}

.portfolio-item:hover .portfolio-overlay {
    transform: translateY(0);
}

/* Floating Action Button */
.floating-whatsapp {
    position: fixed;
    bottom: 30px;
    left: 30px;
    width: 60px;
    height: 60px;
    background: #25D366;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    font-size: 1.5rem;
    box-shadow: 0 5px 20px rgba(37, 211, 102, 0.4);
    z-index: 1000;
    transition: all 0.3s ease;
    animation: pulse 2s infinite;
}

.floating-whatsapp:hover {
    transform: scale(1.1);
    color: white;
    text-decoration: none;
}

@keyframes pulse {
    0% { box-shadow: 0 5px 20px rgba(37, 211, 102, 0.4); }
    50% { box-shadow: 0 5px 30px rgba(37, 211, 102, 0.6), 0 0 0 10px rgba(37, 211, 102, 0.1); }
    100% { box-shadow: 0 5px 20px rgba(37, 211, 102, 0.4); }
}

/* Scroll to Top Button */
.scroll-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: var(--primary-color);
    border: none;
    border-radius: 50%;
    color: white;
    font-size: 1.2rem;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1000;
}

.scroll-to-top.visible {
    opacity: 1;
    visibility: visible;
}

.scroll-to-top:hover {
    background: var(--dark-blue);
    transform: translateY(-3px);
}

/* Advanced Animations */
@keyframes slideInFromLeft {
    0% { transform: translateX(-100%); opacity: 0; }
    100% { transform: translateX(0); opacity: 1; }
}

@keyframes slideInFromRight {
    0% { transform: translateX(100%); opacity: 0; }
    100% { transform: translateX(0); opacity: 1; }
}

@keyframes fadeInScale {
    0% { transform: scale(0.8); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

/* Responsive Enhancements */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-description {
        font-size: 1.1rem;
    }
    
    .section-title {
        font-size: 2.2rem;
    }
    
    .hero-btn {
        padding: 12px 25px;
        font-size: 1rem;
        display: block;
        width: 100%;
        margin-bottom: 15px;
    }
    
    .hero-btn:last-child {
        margin-bottom: 0;
    }
    
    .feature-card {
        padding: 30px 20px;
    }
    
    .floating-whatsapp {
        bottom: 20px;
        left: 20px;
        width: 50px;
        height: 50px;
    }
    
    .scroll-to-top {
        bottom: 20px;
        right: 20px;
        width: 45px;
        height: 45px;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .stat-counter {
        font-size: 2rem;
    }
    }
</style>
@endsection

@section('content')
<!-- Loading Screen -->
<div class="loading-screen" id="loadingScreen">
    <div class="loader"></div>
        </div>
        
<!-- Hero Slider Section -->
@include('partials.hero-slider')

<!-- Dynamic Sections -->
@include('partials.dynamic-sections')

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/966501234567" class="floating-whatsapp" target="_blank" title="تواصل معنا عبر الواتساب">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- Scroll to Top Button -->
<button class="scroll-to-top" id="scrollToTop" title="العودة للأعلى">
    <i class="fas fa-arrow-up"></i>
</button>
@endsection

@section('scripts')
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
@include('partials.hero-scripts')

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS (Animate On Scroll)
    AOS.init({
        duration: 1000,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });

    // Hide loading screen
    setTimeout(() => {
        document.getElementById('loadingScreen').classList.add('hidden');
        setTimeout(() => {
            document.getElementById('loadingScreen').style.display = 'none';
        }, 500);
    }, 1500);

    // Scroll to top functionality
    const scrollToTopBtn = document.getElementById('scrollToTop');
    
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.add('visible');
        } else {
            scrollToTopBtn.classList.remove('visible');
        }
    });

    scrollToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Enhanced navbar scroll effect
    const navbar = document.querySelector('.navbar');
    let lastScrollY = window.scrollY;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }

        // Hide/show navbar on scroll
        if (window.scrollY > lastScrollY && window.scrollY > 500) {
            navbar.style.transform = 'translateY(-100%)';
        } else {
            navbar.style.transform = 'translateY(0)';
        }
        lastScrollY = window.scrollY;
    });

    // Intersection Observer for advanced animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                const animation = element.dataset.animation || 'fadeInUp';
                const delay = element.dataset.delay || 0;
                
                setTimeout(() => {
                    element.classList.add('animate__animated', `animate__${animation}`);
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, delay);
                
                observer.unobserve(element);
            }
        });
    }, observerOptions);

    // Observe all animated elements
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });

    // Advanced counter animation
    const counters = document.querySelectorAll('.stat-counter');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.textContent.replace(/\D/g, ''));
                const suffix = counter.textContent.replace(/\d/g, '');
                const duration = 2000;
                const increment = target / (duration / 16);
                let current = 0;
                
                const timer = setInterval(() => {
                    current += increment;
                    counter.textContent = Math.floor(current) + suffix;
                    
                    if (current >= target) {
                        counter.textContent = target + suffix;
                        clearInterval(timer);
                    }
                }, 16);
                
                counterObserver.unobserve(counter);
            }
        });
    });

    counters.forEach(counter => counterObserver.observe(counter));

    // Parallax effect for background elements
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.parallax');
        
        parallaxElements.forEach((element, index) => {
            const speed = 0.5 + (index * 0.1);
            const yPos = -(scrolled * speed);
            element.style.transform = `translate3d(0, ${yPos}px, 0)`;
        });
    });

    // Advanced hover effects for interactive elements
    const interactiveElements = document.querySelectorAll('.feature-card, .portfolio-item, .testimonial-card');
    
    interactiveElements.forEach(element => {
        element.addEventListener('mouseenter', function(e) {
            this.style.transform = 'translateY(-10px) scale(1.02)';
            
            // Add ripple effect
            const ripple = document.createElement('div');
            ripple.className = 'ripple';
            ripple.style.left = e.offsetX + 'px';
            ripple.style.top = e.offsetY + 'px';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 1000);
        });
        
        element.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Smooth reveal animations for sections
    const sections = document.querySelectorAll('.home-section');
    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('section-visible');
                sectionObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(50px)';
        section.style.transition = 'all 0.8s ease';
        sectionObserver.observe(section);
    });

    // Add CSS for section visibility
    const style = document.createElement('style');
    style.textContent = `
        .section-visible {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
        
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .navbar-scrolled {
            background: rgba(30, 58, 138, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        
        .navbar {
            transition: all 0.3s ease;
        }
    `;
    document.head.appendChild(style);
});

// Performance optimization
window.addEventListener('load', () => {
    // Preload critical images
    const criticalImages = [
        '{{ asset("images/hero/home-hero.svg") }}',
        '{{ asset("images/sections/quality-manufacturing.svg") }}',
        '{{ asset("images/sections/team-collaboration.svg") }}'
    ];
    
    criticalImages.forEach(src => {
        const img = new Image();
        img.src = src;
    });
});
</script>
@endsection