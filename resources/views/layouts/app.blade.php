<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', app('seo')['site_title'] ?? 'Infinity Wear - مؤسسة اللباس اللامحدود')</title>
    <meta name="description" content="@yield('description', app('seo')['site_description'] ?? 'Infinity Wear - مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية')">
    
    <!-- SEO Meta Tags -->
    <meta name="keywords" content="@yield('keywords', app('seo')['site_keywords'] ?? 'ملابس رياضية، زي موحد، أكاديميات رياضية، السعودية، كرة قدم، تصميم ملابس، infinity wear، اللباس اللامحدود')">
    <meta name="author" content="Infinity Wear">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Arabic">
    <meta name="revisit-after" content="7 days">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', app('seo')['site_title'] ?? 'Infinity Wear - مؤسسة اللباس اللامحدود')">
    <meta property="og:description" content="@yield('description', app('seo')['site_description'] ?? 'مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/infinity-wear-logo.png') }}">
    <meta property="og:site_name" content="Infinity Wear">
    <meta property="og:locale" content="ar_SA">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', app('seo')['site_title'] ?? 'Infinity Wear - مؤسسة اللباس اللامحدود')">
    <meta name="twitter:description" content="@yield('description', app('seo')['site_description'] ?? 'مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية')">
    <meta name="twitter:image" content="{{ asset('images/infinity-wear-logo.png') }}">
    
    <!-- Google Site Verification -->
    @if(app('seo')['google_site_verification'] ?? false)
    <meta name="google-site-verification" content="{{ app('seo')['google_site_verification'] }}">
    @endif
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicon.ico">
    <link rel="apple-touch-icon" href="{{ asset('images/infinity-wear-logo.png') }}">
    
    <!-- Bootstrap RTL CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Enhanced Hero Section CSS -->
    <link href="{{ asset('css/hero-enhanced.css') }}" rel="stylesheet" onerror="this.onerror=null;this.href='';">
    <!-- Enhanced Footer CSS -->
    <link href="{{ asset('css/footer-enhanced.css') }}" rel="stylesheet" onerror="this.onerror=null;this.href='';">
    <!-- Enhanced Pages CSS -->
    <link href="{{ asset('css/enhanced-pages.css') }}" rel="stylesheet" onerror="this.onerror=null;this.href='';">
    
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
            --accent-color: #60a5fa;
            --dark-blue: #1e40af;
            --light-blue: #dbeafe;
            --header-glow: 0 0 20px 2px #60a5fa55;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            padding-top: 0 !important;
            margin-top: 0 !important;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1 0 auto;
        }
        
        /* Enhanced Header Styles */
        .navbar {
            background: linear-gradient(120deg, var(--primary-color) 60%, var(--secondary-color) 100%);
            box-shadow: 0 4px 24px 0 rgba(30,58,138,0.15), 0 1.5px 0 0 var(--accent-color);
            height: auto;
            min-height: 80px;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            position: relative;
            z-index: 1030;
            transition: all 0.3s ease;
            padding: 0.5rem 0;
        }
        
        .navbar.scrolled {
            box-shadow: 0 8px 32px 0 rgba(30,58,138,0.25), 0 1.5px 0 0 var(--accent-color);
            padding: 0.3rem 0;
        }
        
        .navbar-brand {
            font-weight: 900;
            font-size: 2rem;
            color: var(--primary-color) !important;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            text-shadow: 0 2px 8px #dbeafe99;
            filter: drop-shadow(0 0 8px #60a5fa33);
            transition: transform 0.3s ease;
        }
        
        .navbar-brand:hover {
            transform: scale(1.05);
        }
        
        .navbar-brand .brand-text {
            margin-right: 8px;
            display:none;
        }
        
        .infinity-logo {
            width: 48px;
            height: 48px;
            background: linear-gradient(45deg, var(--secondary-color), var(--accent-color));
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
            font-size: 2rem;
            box-shadow: var(--header-glow);
            border: 2.5px solid #fff;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }
        
        .infinity-logo::before {
            content: "∞";
            font-size: 1.5em;
            text-shadow: 0 0 8px #60a5fa99;
        }
        
        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 600;
            font-size: 1.08rem;
            padding: 0.7rem 1.1rem;
            border-radius: 22px;
            margin: 0 0.2rem;
            transition: 
                background 0.25s,
                color 0.25s,
                box-shadow 0.25s,
                transform 0.2s;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }
        
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 0%;
            background: linear-gradient(90deg, var(--accent-color) 60%, var(--light-blue) 100%);
            transition: height 0.25s ease;
            z-index: -1;
            border-radius: 22px;
        }
        
        .navbar-nav .nav-link:hover::after, .navbar-nav .nav-link.active::after {
            height: 100%;
        }
        
        .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active {
            color: var(--primary-color) !important;
            box-shadow: 0 2px 12px 0 #60a5fa33;
            transform: translateY(-2px);
        }
        
        .navbar-toggler {
            border: none;
            background: var(--accent-color);
            border-radius: 50%;
            padding: 8px 12px;
            box-shadow: 0 2px 8px #60a5fa33;
            transition: transform 0.2s ease;
        }
        
        .navbar-toggler:hover {
            transform: rotate(10deg);
        }
        
        .navbar-toggler:focus {
            outline: none;
            box-shadow: 0 0 0 3px var(--accent-color);
        }
        
        .dropdown-menu {
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 #1e3a8a22;
            border: none;
            background: linear-gradient(120deg, #f8fafc 80%, #e0e7ef 100%);
            overflow: hidden;
            padding: 0.5rem;
        }
        
        .dropdown-item {
            font-weight: 500;
            color: var(--primary-color);
            border-radius: 12px;
            transition: all 0.2s ease;
            padding: 0.6rem 1rem;
            margin-bottom: 0.2rem;
        }
        
        .dropdown-item:hover {
            background: var(--accent-color);
            color: #fff;
            transform: translateX(-5px);
        }
        
        /* Enhanced Footer */
        .footer {
            background: linear-gradient(135deg, var(--primary-color), var(--dark-blue));
            color: white;
            padding: 40px 0 20px;
            margin-top: auto;
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
            box-shadow: 0 -5px 25px rgba(0,0,0,0.1);
        }
        
        .footer h5 {
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        .footer h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 3px;
        }
        
        .footer a.text-light {
            transition: all 0.2s ease;
            display: inline-block;
            margin-bottom: 8px;
        }
        
        .footer a.text-light:hover {
            color: var(--accent-color) !important;
            transform: translateX(-5px);
        }
        
        .footer .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            transition: all 0.3s ease;
            margin-right: 10px;
        }
        
        .footer .social-links a:hover {
            background: var(--accent-color);
            transform: translateY(-3px);
        }
        
        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .navbar {
                border-radius: 0 0 20px 20px;
            }
            
            .navbar-brand {
                font-size: 1.5rem;
            }
            
            .infinity-logo {
                width: 40px;
                height: 40px;
                font-size: 1.5rem;
            }
            
            .navbar-collapse {
                background: rgba(30, 58, 138, 0.95);
                border-radius: 15px;
                padding: 1rem;
                margin-top: 0.5rem;
                box-shadow: 0 10px 30px rgba(0,0,0,0.15);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
            }
            
            .navbar-nav .nav-link {
                padding: 0.8rem 1rem;
                margin-bottom: 0.3rem;
            }
        }
        
        @media (max-width: 767.98px) {
            .section-title {
                font-size: 1.8rem;
            }
            
            .footer {
                text-align: center;
            }
            
            .footer h5::after {
                left: 50%;
                transform: translateX(-50%);
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="infinity-logo pulse-soft"></span>
                <span class="brand-text">Infinity Wear</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('home') ? ' active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>الرئيسية
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle{{ request()->routeIs('custom-designs.*') ? ' active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-palette me-1"></i>أدوات التصميم
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('custom-designs.create') }}">
                                <i class="fas fa-paint-brush me-2"></i>أداة التصميم البسيطة
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('custom-designs.enhanced-create') }}">
                                <i class="fas fa-magic me-2"></i>أداة التصميم المتقدمة
                            </a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('importers.form') ? ' active' : '' }}" href="{{ route('importers.form') }}">
                            <i class="fas fa-file-import me-1"></i>طلب جديد للمستورد
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('services') ? ' active' : '' }}" href="{{ route('services') }}">
                            <i class="fas fa-concierge-bell me-1"></i>خدماتنا
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('portfolio.index') ? ' active' : '' }}" href="{{ route('portfolio.index') }}">
                            <i class="fas fa-briefcase me-1"></i>معرض أعمالنا
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('testimonials.index') ? ' active' : '' }}" href="{{ route('testimonials.index') }}">
                            <i class="fas fa-star me-1"></i>عملاؤنا السابقين
                        </a>
                    </li>
                  
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('about') ? ' active' : '' }}" href="{{ route('about') }}">
                            <i class="fas fa-info-circle me-1"></i>من نحن
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('contact') ? ' active' : '' }}" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-1"></i>اتصل بنا
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link{{ request()->routeIs('custom-designs.index') ? ' active' : '' }}" href="{{ route('custom-designs.index') }}">
                                <i class="fas fa-palette me-1"></i> تصميمي
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('custom-designs.index') }}"><i class="fas fa-palette me-2"></i>تصاميمي</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link{{ request()->routeIs('login') ? ' active' : '' }}" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> تسجيل الدخول
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ request()->routeIs('register') ? ' active' : '' }}" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i> إنشاء حساب
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                    <h5>
                        <span class="infinity-logo"></span>
                        Infinity Wear
                    </h5>
                    <p>مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية</p>
                    <div class="mt-3">
                        <h6>قيمنا:</h6>
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-1"><i class="fas fa-check-circle text-success me-2"></i> ثقة</p>
                                <p class="mb-1"><i class="fas fa-check-circle text-success me-2"></i> سرعة</p>
                                <p class="mb-1"><i class="fas fa-check-circle text-success me-2"></i> مصداقية</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1"><i class="fas fa-check-circle text-success me-2"></i> جودة</p>
                                <p class="mb-1"><i class="fas fa-check-circle text-success me-2"></i> تصميم</p>
                                <p class="mb-1"><i class="fas fa-check-circle text-success me-2"></i> احترافية</p>
                            </div>
                        </div>
                    </div>
                   
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5>روابط سريعة</h5>
                    <div class="row">
                        <div class="col-12">
                            <ul class="list-unstyled">
                                <li><a href="{{ route('home') }}" class="text-light text-decoration-none"><i class="fas fa-angle-left me-2"></i>الرئيسية</a></li>
                                <li><a href="{{ route('services') }}" class="text-light text-decoration-none"><i class="fas fa-angle-left me-2"></i>خدماتنا</a></li>
                                <li><a href="{{ route('portfolio.index') }}" class="text-light text-decoration-none"><i class="fas fa-angle-left me-2"></i>معرض أعمالنا</a></li>
                                <li><a href="{{ route('testimonials.index') }}" class="text-light text-decoration-none"><i class="fas fa-angle-left me-2"></i>عملاؤنا السابقين</a></li>
                                <li><a href="{{ route('about') }}" class="text-light text-decoration-none"><i class="fas fa-angle-left me-2"></i>من نحن</a></li>
                                <li><a href="{{ route('contact') }}" class="text-light text-decoration-none"><i class="fas fa-angle-left me-2"></i>اتصل بنا</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5>خدماتنا</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none"><i class="fas fa-angle-left me-2"></i>تصميم الأزياء مكةية</a></li>
                        <li><a href="#" class="text-light text-decoration-none"><i class="fas fa-angle-left me-2"></i>الزي الموحد للأكاديميات</a></li>
                        <li><a href="#" class="text-light text-decoration-none"><i class="fas fa-angle-left me-2"></i>ملابس الفرق مكةية</a></li>
                        <li><a href="#" class="text-light text-decoration-none"><i class="fas fa-angle-left me-2"></i>الطباعة على الملابس</a></li>
                        <li><a href="#" class="text-light text-decoration-none"><i class="fas fa-angle-left me-2"></i>التوريد للمؤسسات</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5>تواصل معنا</h5>
                    <div class="contact-info">
                        <div>
                            <i class="fas fa-phone-alt"></i>
                            <span>+966 50 123 4567</span>
                        </div>
                        <div>
                            <i class="fas fa-envelope"></i>
                            <span>info@infinitywear.sa</span>
                        </div>
                        <div>
                            <i class="fas fa-map-marker-alt"></i>
                            <span>مكة، المملكة العربية السعودية</span>
                        </div>
                        <div>
                            <i class="fas fa-clock"></i>
                            <span>الأحد - الخميس: 9 ص - 5 م</span>
                        </div>
                    </div>
                    <div class="mt-4 social-links">
                        <a href="#" aria-label="فيسبوك"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="تويتر"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="انستغرام"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="لينكد إن"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            <div class="copyright">
                <p>&copy; 2025 Infinity Wear. جميع الحقوق محفوظة.</p>
                <div class="copyright-links">
                    <a href="#">سياسة الخصوصية</a>
                    <a href="#">الشروط والأحكام</a>
                    <a href="#">سياسة الإرجاع</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Enhanced Hero Section JS -->
    <script src="{{ asset('js/hero-enhanced.js') }}"></script>
    
    <script>
        // Initialize AOS
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
            
            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
            
            // Initialize any tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    
    @yield('scripts')
    
    <!-- Google Analytics -->
    @if(app('seo')['google_analytics_id'] ?? false)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ app('seo')['google_analytics_id'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ app('seo')['google_analytics_id'] }}');
    </script>
    @endif
    
    <!-- Facebook Pixel -->
    @if(app('seo')['facebook_pixel_id'] ?? false)
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ app('seo')['facebook_pixel_id'] }}');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" 
             src="https://www.facebook.com/tr?id={{ app('seo')['facebook_pixel_id'] }}&ev=PageView&noscript=1" />
    </noscript>
    @endif
    
    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Infinity Wear",
        "alternateName": "مؤسسة اللباس اللامحدود",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/infinity-wear-logo.png') }}",
        "description": "{{ app('seo')['site_description'] ?? 'مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية' }}",
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "SA",
            "addressLocality": "مكة المكرمة"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+966501234567",
            "contactType": "customer service",
            "availableLanguage": ["Arabic", "English"]
        },
        "sameAs": [
            "https://facebook.com/infinitywear",
            "https://twitter.com/infinitywear",
            "https://instagram.com/infinitywear"
        ]
    }
    </script>
</body>
</html>
