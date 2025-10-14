<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', \App\Helpers\SiteSettingsHelper::getPageTitle()); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', \App\Helpers\SiteSettingsHelper::getSiteDescription()); ?>">
    
    <!-- SEO Meta Tags -->
    <meta name="keywords" content="<?php echo $__env->yieldContent('keywords', app('seo')['site_keywords'] ?? 'ملابس رياضية، زي موحد، أكاديميات رياضية، السعودية، كرة قدم، تصميم ملابس، infinity wear، الزي اللامحدود'); ?>">
    <meta name="author" content="<?php echo e(\App\Helpers\SiteSettingsHelper::getSiteName()); ?>">
    <meta name="robots" content="index, follow">
    <meta name="language" content="Arabic">
    <meta name="revisit-after" content="7 days">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo $__env->yieldContent('title', \App\Helpers\SiteSettingsHelper::getPageTitle()); ?>">
    <meta property="og:description" content="<?php echo $__env->yieldContent('description', \App\Helpers\SiteSettingsHelper::getSiteDescription()); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:image" content="<?php echo e(\App\Helpers\SiteSettingsHelper::getLogoUrl()); ?>">
    <meta property="og:site_name" content="<?php echo e(\App\Helpers\SiteSettingsHelper::getSiteName()); ?>">
    <meta property="og:locale" content="ar_SA">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo $__env->yieldContent('title', \App\Helpers\SiteSettingsHelper::getPageTitle()); ?>">
    <meta name="twitter:description" content="<?php echo $__env->yieldContent('description', \App\Helpers\SiteSettingsHelper::getSiteDescription()); ?>">
    <meta name="twitter:image" content="<?php echo e(\App\Helpers\SiteSettingsHelper::getLogoUrl()); ?>">
    
    <!-- Google Site Verification -->
    <?php if(app('seo')['google_site_verification'] ?? false): ?>
    <meta name="google-site-verification" content="<?php echo e(app('seo')['google_site_verification']); ?>">
    <?php endif; ?>
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(\App\Helpers\SiteSettingsHelper::getFaviconUrl()); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(\App\Helpers\SiteSettingsHelper::getFaviconUrl()); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(\App\Helpers\SiteSettingsHelper::getFaviconUrl()); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(\App\Helpers\SiteSettingsHelper::getFaviconUrl()); ?>">
    <link rel="manifest" href="<?php echo e(asset('site.webmanifest')); ?>">
    
    <!-- Bootstrap RTL CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Main CSS -->
    <link href="<?php echo e(asset('css/infinity-home.css')); ?>" rel="stylesheet">
    <!-- Football Animation CSS -->
    <!-- WhatsApp Button CSS -->
    <link href="<?php echo e(asset('css/whatsapp-button.css')); ?>" rel="stylesheet">
    <!-- Push Notifications CSS -->
    <link href="<?php echo e(asset('css/push-notifications.css')); ?>" rel="stylesheet">
    
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <!-- Header -->
    <header class="infinity-header">

        <!-- Main Navigation -->
        <nav class="infinity-navbar">
            <div class="container">
                <div class="infinity-navbar-content">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="<?php echo e(route('home')); ?>">
                            <img src="<?php echo e(\App\Helpers\SiteSettingsHelper::getLogoUrl()); ?>" 
                                 alt="<?php echo e(\App\Helpers\SiteSettingsHelper::getSiteName()); ?>" 
                                 style="height: 50px;">
                        </a>
                    </div>

                    <!-- Navigation Menu -->
                    <ul class="nav-menu">
                        <li><a href="<?php echo e(route('home')); ?>" class="nav-link<?php echo e(request()->routeIs('home') ? ' active' : ''); ?>">الرئيسية</a></li>
                        <li><a href="<?php echo e(route('about')); ?>" class="nav-link<?php echo e(request()->routeIs('about') ? ' active' : ''); ?>">من نحن</a></li>
                        <li><a href="<?php echo e(route('services')); ?>" class="nav-link<?php echo e(request()->routeIs('services') ? ' active' : ''); ?>">خدماتنا</a></li>
                        <li><a href="<?php echo e(route('portfolio.index')); ?>" class="nav-link<?php echo e(request()->routeIs('portfolio.index') ? ' active' : ''); ?>">أعمالنا</a></li>
                        <li><a href="<?php echo e(route('contact.index')); ?>" class="nav-link<?php echo e(request()->routeIs('contact.index') ? ' active' : ''); ?>">تواصل معنا</a></li>
                    </ul>

                    <!-- Mobile Menu Toggle Button -->
                    <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="فتح القائمة">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                    <!-- Action Buttons -->
                    <div class="header-actions">
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('customer.dashboard')); ?>" class="btn btn-outline">لوحة التحكم</a>
                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary">تسجيل الخروج</button>
                            </form>
                        <?php elseif(Auth::guard('admin')->check()): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline">لوحة التحكم</a>
                            <form method="POST" action="<?php echo e(route('admin.logout')); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary">تسجيل الخروج</button>
                            </form>
                        <?php else: ?>
                            <a href="<?php echo e(route('importers.form')); ?>" class="btn btn-primary">تسجيل كمستورد</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Mobile Sidebar -->
    <div class="mobile-sidebar-overlay" id="mobileSidebarOverlay"></div>
    <div class="mobile-sidebar" id="mobileSidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <div class="infinity-logo">IW</div>
                <div class="sidebar-logo-text">إنفينيتي وير</div>
            </div>
            <button class="sidebar-close" id="sidebarClose" aria-label="إغلاق القائمة">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <nav class="sidebar-nav">
            <div class="sidebar-nav-item">
                <a href="<?php echo e(route('home')); ?>" class="sidebar-nav-link<?php echo e(request()->routeIs('home') ? ' active' : ''); ?>">
                    <i class="fas fa-home"></i>
                    الرئيسية
                </a>
            </div>
            <div class="sidebar-nav-item">
                <a href="<?php echo e(route('about')); ?>" class="sidebar-nav-link<?php echo e(request()->routeIs('about') ? ' active' : ''); ?>">
                    <i class="fas fa-info-circle"></i>
                    من نحن
                </a>
            </div>
            <div class="sidebar-nav-item">
                <a href="<?php echo e(route('services')); ?>" class="sidebar-nav-link<?php echo e(request()->routeIs('services') ? ' active' : ''); ?>">
                    <i class="fas fa-cogs"></i>
                    خدماتنا
                </a>
            </div>
            <div class="sidebar-nav-item">
                <a href="<?php echo e(route('portfolio.index')); ?>" class="sidebar-nav-link<?php echo e(request()->routeIs('portfolio.index') ? ' active' : ''); ?>">
                    <i class="fas fa-briefcase"></i>
                    أعمالنا
                </a>
            </div>
            <div class="sidebar-nav-item">
                <a href="<?php echo e(route('contact.index')); ?>" class="sidebar-nav-link<?php echo e(request()->routeIs('contact.index') ? ' active' : ''); ?>">
                    <i class="fas fa-envelope"></i>
                    تواصل معنا
                </a>
            </div>
        </nav>
        
        <div class="sidebar-user">
            <div class="sidebar-user-info">
                <div class="sidebar-user-avatar">
                    <?php if(auth()->guard()->check()): ?>
                        <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                    <?php else: ?>
                        <i class="fas fa-user"></i>
                    <?php endif; ?>
                </div>
                <div class="sidebar-user-details">
                    <?php if(auth()->guard()->check()): ?>
                        <h6><?php echo e(Auth::user()->name); ?></h6>
                        <p>مرحباً بك</p>
                    <?php else: ?>
                        <h6>زائر</h6>
                        <p>مرحباً بك</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="sidebar-user-actions">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('customer.dashboard')); ?>" class="btn btn-sidebar-primary">لوحة التحكم</a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-sidebar-outline">تسجيل الخروج</button>
                    </form>
                <?php elseif(Auth::guard('admin')->check()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-sidebar-primary">لوحة التحكم</a>
                    <form method="POST" action="<?php echo e(route('admin.logout')); ?>" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-sidebar-outline">تسجيل الخروج</button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('importers.form')); ?>" class="btn btn-sidebar-primary">تسجيل كمستورد</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="site-footer modern-footer">
        <div class="container">
            <div class="row gy-4 footer-main-content">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="footer-brand-section">
                        <div class="brand-logo-container">
                            <img src="<?php echo e(\App\Helpers\SiteSettingsHelper::getLogoUrl()); ?>" 
                                 alt="<?php echo e(\App\Helpers\SiteSettingsHelper::getSiteName()); ?>" 
                                 class="brand-logo">
                            <div class="brand-text-content">
                                <h3 class="brand-title"><?php echo e(\App\Helpers\SiteSettingsHelper::getSiteName()); ?></h3>
                                <p class="brand-subtitle"><?php echo e(\App\Helpers\SiteSettingsHelper::getSiteTagline()); ?></p>
                            </div>
                        </div>
                        <p class="footer-description"><?php echo e(\App\Helpers\SiteSettingsHelper::getSiteDescription()); ?></p>
                        <div class="social-media-links">
                            <?php if(\App\Models\Setting::get('facebook_url')): ?>
                                <a href="<?php echo e(\App\Models\Setting::get('facebook_url')); ?>" aria-label="Facebook" class="social-link facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <?php endif; ?>
                            <?php if(\App\Models\Setting::get('twitter_url')): ?>
                                <a href="<?php echo e(\App\Models\Setting::get('twitter_url')); ?>" aria-label="Twitter" class="social-link twitter" target="_blank"><i class="fab fa-twitter"></i></a>
                            <?php endif; ?>
                            <?php if(\App\Models\Setting::get('instagram_url')): ?>
                                <a href="<?php echo e(\App\Models\Setting::get('instagram_url')); ?>" aria-label="Instagram" class="social-link instagram" target="_blank"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                            <?php if(\App\Models\Setting::get('linkedin_url')): ?>
                                <a href="<?php echo e(\App\Models\Setting::get('linkedin_url')); ?>" aria-label="LinkedIn" class="social-link linkedin" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            <?php endif; ?>
                            <?php if(\App\Models\Setting::get('whatsapp_number')): ?>
                                <a href="https://wa.me/<?php echo e(str_replace(['+', ' ', '-'], '', \App\Models\Setting::get('whatsapp_number'))); ?>" aria-label="WhatsApp" class="social-link whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="footer-nav-section">
                        <h5 class="footer-section-heading">التنقل</h5>
                        <ul class="footer-nav-links">
                            <li><a href="<?php echo e(route('home')); ?>">الرئيسية</a></li>
                            <li><a href="<?php echo e(route('about')); ?>">من نحن</a></li>
                            <li><a href="<?php echo e(route('services')); ?>">خدماتنا</a></li>
                            <li><a href="<?php echo e(route('products.index')); ?>">منتجاتنا</a></li>
                            <li><a href="<?php echo e(route('portfolio.index')); ?>">معرض أعمالنا</a></li>
                            <li><a href="<?php echo e(route('testimonials.index')); ?>">آراء العملاء</a></li>
                            <li><a href="<?php echo e(route('contact.index')); ?>">اتصل بنا</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="footer-services-section">
                        <h5 class="footer-section-heading">خدماتنا</h5>
                        <ul class="footer-services-links">
                            <li><a href="<?php echo e(route('services')); ?>#fashion-design">تصميم الأزياء</a></li>
                            <li><a href="<?php echo e(route('services')); ?>#academy-uniforms">الزي الموحد للأكاديميات</a></li>
                            <li><a href="<?php echo e(route('services')); ?>#sports-teams">ملابس الفرق الرياضية</a></li>
                            <li><a href="<?php echo e(route('services')); ?>#clothing-printing">الطباعة على الملابس</a></li>
                            <li><a href="<?php echo e(route('services')); ?>#custom-design">التصميم المخصص</a></li>
                            <li><a href="<?php echo e(route('services')); ?>#ai-design">التصميم بالذكاء الاصطناعي</a></li>
                            <li><a href="<?php echo e(route('importers.form')); ?>">تسجيل كمستورد</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="footer-contact-section">
                        <h5 class="footer-section-heading">معلومات التواصل</h5>
                        <div class="footer-contact-info-list">
                            <?php if(\App\Models\Setting::get('contact_phone')): ?>
                                <div class="footer-contact-info-item">
                                    <i class="fas fa-phone-alt footer-contact-icon"></i>
                                    <span class="footer-contact-text"><?php echo e(\App\Models\Setting::get('contact_phone')); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if(\App\Models\Setting::get('contact_email')): ?>
                                <div class="footer-contact-info-item">
                                    <i class="fas fa-envelope footer-contact-icon"></i>
                                    <span class="footer-contact-text"><?php echo e(\App\Models\Setting::get('contact_email')); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if(\App\Models\Setting::get('address')): ?>
                                <div class="footer-contact-info-item">
                                    <i class="fas fa-map-marker-alt footer-contact-icon"></i>
                                    <span class="footer-contact-text"><?php echo e(\App\Models\Setting::get('address')); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if(\App\Models\Setting::get('business_hours')): ?>
                                <div class="footer-contact-info-item">
                                    <i class="fas fa-clock footer-contact-icon"></i>
                                    <span class="footer-contact-text"><?php echo e(\App\Models\Setting::get('business_hours')); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Quick Links Section -->
                        <div class="footer-quick-links mt-4">
                            <h6 class="footer-section-heading mb-3">روابط سريعة</h6>
                            <div class="quick-links-grid">
                                <a href="<?php echo e(route('login')); ?>" class="quick-link">
                                    <i class="fas fa-sign-in-alt"></i>
                                    تسجيل الدخول
                                </a>
                                <a href="<?php echo e(route('register')); ?>" class="quick-link">
                                    <i class="fas fa-user-plus"></i>
                                    إنشاء حساب
                                </a>
                                <a href="<?php echo e(route('testimonials.create')); ?>" class="quick-link">
                                    <i class="fas fa-star"></i>
                                    إضافة تقييم
                                </a>
                                <a href="<?php echo e(route('contact.index')); ?>" class="quick-link">
                                    <i class="fas fa-headset"></i>
                                    الدعم الفني
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="footer-divider">
            <div class="footer-bottom-section d-flex justify-content-center align-items-center" style="min-height: 50px;">
                <div class="footer-bottom-content">
                    <p class="copyright-text m-0 text-center">
                        &copy; <?php echo e(date('Y')); ?> <?php echo e(\App\Helpers\SiteSettingsHelper::getSiteName()); ?>. جميع الحقوق محفوظة.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Main JavaScript -->
    <script src="<?php echo e(asset('js/infinity-home.js')); ?>"></script>
    
    <!-- Responsive Navigation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile sidebar elements
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileSidebar = document.getElementById('mobileSidebar');
            const mobileSidebarOverlay = document.getElementById('mobileSidebarOverlay');
            const sidebarClose = document.getElementById('sidebarClose');
            
            // Navbar scroll effect
            const navbar = document.querySelector('.infinity-navbar');
            let lastScrollTop = 0;
            
            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > 100) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
                
                lastScrollTop = scrollTop;
            });
            
            // Mobile sidebar functions
            function openSidebar() {
                mobileSidebar.classList.add('show');
                mobileSidebarOverlay.classList.add('show');
                mobileMenuToggle.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
            
            function closeSidebar() {
                mobileSidebar.classList.remove('show');
                mobileSidebarOverlay.classList.remove('show');
                mobileMenuToggle.classList.remove('active');
                document.body.style.overflow = '';
            }
            
            // Event listeners for mobile sidebar
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', openSidebar);
            }
            
            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }
            
            if (mobileSidebarOverlay) {
                mobileSidebarOverlay.addEventListener('click', closeSidebar);
            }
            
            // Close sidebar on link click
            const sidebarLinks = document.querySelectorAll('.sidebar-nav-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', closeSidebar);
            });
            
            // Close sidebar on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && mobileSidebar.classList.contains('show')) {
                    closeSidebar();
                }
            });
            
            // Mobile menu close on link click (for desktop navbar)
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            const navbarCollapse = document.querySelector('.navbar-collapse');
            
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                            toggle: false
                        });
                        bsCollapse.hide();
                    }
                });
            });
            
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
            // Add animation classes on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, observerOptions);
            
            // Observe footer elements
            document.querySelectorAll('.infinity-footer-content > *').forEach(el => {
                observer.observe(el);
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 991) {
                    closeSidebar();
                }
            });
        });
    </script>
    
    <?php echo $__env->yieldContent('scripts'); ?>
    
    <!-- Google Analytics -->
    <?php if(app('seo')['google_analytics_id'] ?? false): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(app("seo")["google_analytics_id"]); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo e(app("seo")["google_analytics_id"]); ?>');
    </script>
    <?php endif; ?>
    
    <!-- Facebook Pixel -->
    <?php if(app('seo')['facebook_pixel_id'] ?? false): ?>
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?php echo e(app("seo")["facebook_pixel_id"]); ?>');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none" 
             src="https://www.facebook.com/tr?id=<?php echo e(app("seo")["facebook_pixel_id"]); ?>&ev=PageView&noscript=1" />
    </noscript>
    <?php endif; ?>
    
    <!-- Structured Data (JSON-LD) -->
    <?php
        $structuredData = [
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => "Infinity Wear",
            "alternateName" => "مؤسسة الزي اللامحدود",
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
    ?>
    <script type="application/ld+json">
    <?php echo json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>

    </script>
    
    <!-- WhatsApp Floating Button - Only show on non-admin pages and if enabled -->
    <?php if(!request()->is('admin*') && !request()->is('dashboard*') && !request()->is('customer*') && !request()->is('importer*') && !request()->is('employee*') && !request()->is('marketing*') && !request()->is('sales*') && \App\Models\Setting::get('whatsapp_floating_enabled', 1)): ?>
    <div id="whatsapp-float" class="whatsapp-float">
        <div class="whatsapp-button" onclick="openWhatsApp()">
            <i class="fab fa-whatsapp"></i>
            <span class="whatsapp-text">تواصل معنا</span>
        </div>
        <div class="whatsapp-tooltip">
            <span>أرسل لنا رسالة على واتساب</span>
            <div class="tooltip-arrow"></div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- WhatsApp Button JavaScript -->
    <script>
        function openWhatsApp() {
            // Get WhatsApp number and message from settings
            const phoneNumber = '<?php echo e(str_replace(["+", " ", "-"], "", \App\Models\Setting::get("whatsapp_number", "+966501234567"))); ?>';
            const message = encodeURIComponent('<?php echo e(\App\Models\Setting::get("whatsapp_message", "مرحباً، أريد الاستفسار عن خدماتكم في الملابس الرياضية والزي الموحد")); ?>');
            const whatsappUrl = `https://wa.me/${phoneNumber}?text=${message}`;
            window.open(whatsappUrl, '_blank');
        }
        
        // Show/hide tooltip on hover - only if button exists
        document.addEventListener('DOMContentLoaded', function() {
            const whatsappButton = document.querySelector('.whatsapp-button');
            const tooltip = document.querySelector('.whatsapp-tooltip');
            
            if (whatsappButton && tooltip) {
                whatsappButton.addEventListener('mouseenter', function() {
                    tooltip.style.opacity = '1';
                    tooltip.style.visibility = 'visible';
                });
                
                whatsappButton.addEventListener('mouseleave', function() {
                    tooltip.style.opacity = '0';
                    tooltip.style.visibility = 'hidden';
                });
            }
        });
    </script>

    <!-- Push Notifications JavaScript -->
    <script src="<?php echo e(asset('js/push-notifications.js')); ?>"></script>
    <script>
        // Initialize push notifications for contact forms
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize push notification manager
            if (window.PushNotificationManager) {
                window.pushNotificationManager = new PushNotificationManager();
            }

            // Handle contact form submissions
            const contactForms = document.querySelectorAll('form[id*="contact"], form[action*="contact"]');
            
            contactForms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    // Check if push notifications are available and user is subscribed
                    if (window.pushNotificationManager) {
                        // Try to subscribe to notifications if not already subscribed
                        window.pushNotificationManager.getSubscriptionStatus().then(function(status) {
                            if (!status.isSubscribed && status.canSubscribe) {
                                // Auto-subscribe to notifications when user submits contact form
                                window.pushNotificationManager.subscribe('admin').then(function(success) {
                                    if (success) {
                                        console.log('Auto-subscribed to push notifications');
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html><?php /**PATH F:\infinity\Infinity-Wear\resources\views/layouts/app.blade.php ENDPATH**/ ?>