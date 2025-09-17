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
    <!-- Main CSS -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    
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
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
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
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5>روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-light text-decoration-none">الرئيسية</a></li>
                        <li><a href="{{ route('services') }}" class="text-light text-decoration-none">خدماتنا</a></li>
                        <li><a href="{{ route('portfolio.index') }}" class="text-light text-decoration-none">معرض أعمالنا</a></li>
                        <li><a href="{{ route('about') }}" class="text-light text-decoration-none">من نحن</a></li>
                        <li><a href="{{ route('contact') }}" class="text-light text-decoration-none">اتصل بنا</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5>خدماتنا</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">تصميم الأزياء</a></li>
                        <li><a href="#" class="text-light text-decoration-none">الزي الموحد للأكاديميات</a></li>
                        <li><a href="#" class="text-light text-decoration-none">ملابس الفرق الرياضية</a></li>
                        <li><a href="#" class="text-light text-decoration-none">الطباعة على الملابس</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5>تواصل معنا</h5>
                    <div class="contact-info">
                        <div><i class="fas fa-phone-alt"></i> +966 50 123 4567</div>
                        <div><i class="fas fa-envelope"></i> info@infinitywear.sa</div>
                        <div><i class="fas fa-map-marker-alt"></i> مكة، المملكة العربية السعودية</div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            <div class="copyright">
                <p>&copy; 2025 Infinity Wear. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Main JavaScript -->
    <script src="{{ asset('js/main.js') }}"></script>
    
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
        if(!f._fbq)f._fbq=n;n.push=n.loaded=!0;n.version='2.0';
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
    @php
        $structuredData = [
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => "Infinity Wear",
            "alternateName" => "مؤسسة اللباس اللامحدود",
            "url" => url('/'),
            "logo" => asset('images/infinity-wear-logo.png'),
            "description" => app('seo')['site_description'] ?? 'مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية',
            "address" => [
                "@type" => "PostalAddress",
                "addressCountry" => "SA",
                "addressLocality" => "مكة المكرمة"
            ],
            "contactPoint" => [
                "@type" => "ContactPoint",
                "telephone" => "+966501234567",
                "contactType" => "customer service",
                "availableLanguage" => ["Arabic", "English"]
            ],
            "sameAs" => [
                "https://facebook.com/infinitywear",
                "https://twitter.com/infinitywear",
                "https://instagram.com/infinitywear"
            ]
        ];
    @endphp
    <script type="application/ld+json">
    {!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
</body>
</html>