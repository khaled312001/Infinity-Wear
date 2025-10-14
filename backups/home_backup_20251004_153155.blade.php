@extends('layouts.app')

@section('title', 'إنفينيتي وير - ملابس رياضية احترافية')
@section('description', 'إنفينيتي وير - شركة سعودية رائدة في تصميم وإنتاج الملابس الرياضية والزي الموحد للفرق والمدارس والشركات')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/infinity-home.css') }}" rel="stylesheet">
    <!-- Home Page Responsive CSS -->
    <link href="{{ asset('css/home-responsive.css') }}" rel="stylesheet">
    
    <!-- Loading Screen Styles -->
    <style>
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 952%;
            height: 952%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 952%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }

        .loading-spinner {
            text-align: center;
            color: white;
        }

        .spinner-ring {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin: 0 auto 1rem;
        }

        .spinner-text {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: 2px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
@endsection

@section('content')
    <!-- Loading Screen -->
    <div id="loading-screen" class="loading-screen">
        <div class="loading-spinner">
            <div class="spinner-ring"></div>
            <div class="spinner-text">إنفينيتي وير</div>
        </div>
    </div>

    <!-- Hero Section -->
    <section id="home" class="infinity-hero">
        <!-- Animated Sky Background -->
        <div class="infinity-hero-background">
            <div class="stars-container">
                <div class="stars"></div>
                <div class="stars2"></div>
                <div class="stars3"></div>
            </div>
            <div class="moon"></div>
            <div class="clouds">
                <div class="cloud cloud1"></div>
                <div class="cloud cloud2"></div>
                <div class="cloud cloud3"></div>
            </div>
            <div class="infinity-hero-overlay"></div>
        </div>
        
        <!-- Floating Elements -->
        <div class="floating-elements">
            <div class="floating-shape shape1"></div>
            <div class="floating-shape shape2"></div>
            <div class="floating-shape shape3"></div>
            <div class="floating-shape shape4"></div>
        </div>
        
        <div class="container">
            <div class="infinity-hero-content">
                <div class="infinity-hero-text">
                    <h1 class="infinity-hero-title">
                        <span class="title-line animate-text">ملابس رياضية احترافية</span>
                        <span class="title-highlight animate-text-delay">جودة لا تُضاهى</span>
                    </h1>
                    <p class="infinity-hero-subtitle animate-fade-in">
                        نحن نقدم أفضل الحلول في تصميم وإنتاج الملابس الرياضية والزي الموحد
                        للفرق والمدارس والشركات في المملكة العربية السعودية
                    </p>
                    <div class="infinity-hero-actions animate-slide-up">
                        <a href="#portfolio" class="btn btn-primary btn-large btn-glow">
                            <i class="fas fa-eye"></i>
                            <span>تصفح أعمالنا</span>
                        </a>
                        <a href="#contact" class="btn btn-outline btn-large btn-pulse">
                            <i class="fas fa-phone"></i>
                            <span>تواصل معنا</span>
                        </a>
                    </div>
                </div>
                <div class="infinity-hero-stats">
                    <div class="stat-item animate-counter">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number" data-target="173">0</div>
                        <div class="stat-label">عميل راضي</div>
                    </div>
                    <div class="stat-item animate-counter">
                        <div class="stat-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="stat-number" data-target="952">0</div>
                        <div class="stat-label">مشروع مكتمل</div>
                    </div>
                    <div class="stat-item animate-counter">
                        <div class="stat-icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <div class="stat-number" data-target="50">0</div>
                        <div class="stat-label">فريق عمل</div>
                    </div>
                    <div class="stat-item animate-counter">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stat-number" data-target="5">0</div>
                        <div class="stat-label">سنوات خبرة</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Scroll Indicator -->
        <div class="scroll-indicator">
            <div class="scroll-arrow">
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="scroll-text">اكتشف المزيد</div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="infinity-about">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">من نحن</h2>
                <p class="section-subtitle">شركة سعودية رائدة في مجال الملابس الرياضية والزي الموحد</p>
            </div>

            <div class="infinity-about-content">
                <div class="infinity-about-text">
                    <h3>رؤيتنا</h3>
                    <p>
                        أن نكون الخيار الأول في المملكة العربية السعودية للملابس الرياضية والزي الموحد،
                        من خلال تقديم منتجات عالية الجودة وخدمة عملاء متميزة تلبي احتياجات عملائنا وتتجاوز توقعاتهم.
                    </p>

                    <h3>رسالتنا</h3>
                    <p>
                        نقدم حلولاً شاملة في تصميم وإنتاج الملابس الرياضية والزي الموحد باستخدام أحدث التقنيات
                        والمواد عالية الجودة، مع الحرص على إرضاء عملائنا وتحقيق أهدافهم بكفاءة واحترافية عالية.
                    </p>

                    <div class="infinity-about-features">
                        <div class="feature-item">
                            <i class="fas fa-award"></i>
                            <span>جودة مضمونة</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-clock"></i>
                            <span>تسليم سريع</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-handshake"></i>
                            <span>خدمة عملاء متميزة</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-palette"></i>
                            <span>تصاميم مخصصة</span>
                        </div>
                    </div>
                </div>

                <div class="infinity-about-image">
                    <img src="{{ asset('images/about.png') }}" alt="فريق العمل">
                    <div class="image-overlay">
                        <div class="overlay-text">
                            <span class="years">5+</span>
                            <span class="label">سنوات خبرة</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="infinity-services">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">خدماتنا</h2>
                <p class="section-subtitle">نقدم مجموعة شاملة من الخدمات المتخصصة في الملابس الرياضية</p>
            </div>

            <div class="infinity-services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="service-title">زي الفرق الرياضية</h3>
                    <p class="service-description">
                        تصميم وإنتاج أزياء متكاملة للفرق الرياضية بمختلف الأنواع (كرة قدم، كرة سلة، كرة طائرة، إلخ)
                    </p>
                    <ul class="service-features">
                        <li>تصاميم عصرية وجذابة</li>
                        <li>مواد مقاومة للعرق والرطوبة</li>
                        <li>ألوان ثابتة لا تبهت</li>
                        <li>مقاسات متنوعة ومريحة</li>
                    </ul>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="service-title">زي المدارس والجامعات</h3>
                    <p class="service-description">
                        زي موحد للمدارس والجامعات يجمع بين الأناقة والراحة والمتانة للاستخدام اليومي
                    </p>
                    <ul class="service-features">
                        <li>تصاميم رسمية ومناسبة</li>
                        <li>أقمشة عالية الجودة</li>
                        <li>سهولة في الصيانة والغسيل</li>
                        <li>أسعار تنافسية للكميات الكبيرة</li>
                    </ul>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 class="service-title">زي الشركات والمؤسسات</h3>
                    <p class="service-description">
                        ملابس عمل رسمية وأنيقة تعكس هوية الشركة وتعزز من المظهر المهني للموظفين
                    </p>
                    <ul class="service-features">
                        <li>تصاميم احترافية</li>
                        <li>ألوان وشعارات مخصصة</li>
                        <li>مقاسات متعددة</li>
                        <li>كميات مرنة حسب الحاجة</li>
                    </ul>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h3 class="service-title">تصاميم مخصصة</h3>
                    <p class="service-description">
                        خدمة تصميم مخصصة بالكامل حسب متطلبات العميل ورؤيته الخاصة
                    </p>
                    <ul class="service-features">
                        <li>فريق تصميم محترف</li>
                        <li>نماذج ثلاثية الأبعاد</li>
                        <li>مراجعات متعددة</li>
                        <li>تنفيذ دقيق للتصميم</li>
                    </ul>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-print"></i>
                    </div>
                    <h3 class="service-title">الطباعة والتطريز</h3>
                    <p class="service-description">
                        خدمات طباعة وتطريز عالية الجودة للشعارات والأسماء والأرقام
                    </p>
                    <ul class="service-features">
                        <li>تقنيات طباعة حديثة</li>
                        <li>تطريز دقيق ومتين</li>
                        <li>ألوان ثابتة وواضحة</li>
                        <li>تنفيذ سريع وبدقة عالية</li>
                    </ul>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3 class="service-title">التوصيل والتوزيع</h3>
                    <p class="service-description">
                        خدمة توصيل وتوزيع شاملة تغطي جميع مناطق المملكة العربية السعودية
                    </p>
                    <ul class="service-features">
                        <li>توصيل مجاني للطلبات الكبيرة</li>
                        <li>تغليف آمن ومحترف</li>
                        <li>تتبع الشحنات</li>
                        <li>خدمة عملاء على مدار الساعة</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

   
    <!-- Portfolio Section -->
    <section id="portfolio" class="infinity-portfolio">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">أعمالنا السابقة</h2>
                <p class="section-subtitle">نماذج من مشاريعنا الناجحة مع عملاء مرموقين</p>
            </div>


            <div class="infinity-portfolio-grid">
                <div class="portfolio-item" data-category="football">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/football_team_1.jpg') }}" alt="فريق كرة قدم الرياض">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>فريق كرة قدم الرياض</h3>
                                <p>تصميم متكامل لفريق كرة قدم مع جيرسي وشورت وجوارب</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="basketball">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/basketball_team_1.jpg') }}" alt="نادي كرة السلة الأهلي">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>نادي كرة السلة الأهلي</h3>
                                <p>تصميم احترافي لفريق كرة سلة بألوان مميزة</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="schools">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/school_uniform_1.jpg') }}" alt="مدرسة الرياض الدولية">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>مدرسة الرياض الدولية</h3>
                                <p>زي رياضي موحد للمدرسة بتصميم عصري</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="companies">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/corporate_uniform_1.jpg') }}" alt="شركة الاتصالات السعودية">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>شركة الاتصالات السعودية</h3>
                                <p>زي عمل احترافي لموظفي الشركة</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="medical">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/medical_uniform_1.jpg') }}" alt="مستشفى الملك فهد">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>مستشفى الملك فهد</h3>
                                <p>زي طبي عالي الجودة للمستشفيات والعيادات</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="football">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/football_team_2.jpg') }}" alt="أكاديمية كرة القدم">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>أكاديمية كرة القدم</h3>
                                <p>زي تدريب لأكاديمية كرة قدم</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="basketball">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/basketball_team_2.jpg') }}" alt="فريق كرة السلة النسائي">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>فريق كرة السلة النسائي</h3>
                                <p>تصميم مخصص للفريق النسائي</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="schools">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/school_uniform_2.jpg') }}" alt="جامعة الملك سعود">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>جامعة الملك سعود</h3>
                                <p>زي رياضي لفرق الجامعة</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="basketball">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/sports_wear_1.jpg') }}" alt="نادي كرة السلة الأهلي">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>نادي كرة السلة الأهلي</h3>
                                <p>جيرسي وشورت لفريق كرة سلة محترف</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item" data-category="football">
                    <div class="portfolio-image">
                        <img src="{{ asset('images/portfolio/football_kit_1.jpg') }}" alt="أكاديمية كرة القدم">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>أكاديمية كرة القدم</h3>
                                <p>زي تدريب لأكاديمية كرة قدم</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="infinity-testimonials">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">آراء عملائنا</h2>
                <p class="section-subtitle">ما يقوله عملاؤنا عن خدماتنا ومنتجاتنا</p>
            </div>

            <div class="testimonials-container">
                <div class="testimonials-slider">
                    <div class="testimonial-card active">
                        <div class="testimonial-content">
                            <div class="testimonial-quote">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <div class="testimonial-text">
                                "خدمة ممتازة وجودة عالية في المنتجات. فريق العمل محترف ومتعاون.
                                تم تسليم الطلب في الموعد المحدد وبأفضل جودة ممكنة. أنصح بالتعامل معهم بشدة."
                            </div>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="{{ asset('images/avatar-1.svg') }}" alt="أحمد محمد">
                                    <div class="avatar-ring"></div>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">أحمد محمد</h4>
                                    <p class="author-title">مدرب فريق كرة قدم</p>
                                    <div class="author-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="testimonial-quote">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <div class="testimonial-text">
                                "تعامل راقي ومنتجات عالية الجودة. التصاميم المقدمة كانت إبداعية ومميزة.
                                سنتعامل معهم في جميع مشاريعنا المستقبلية. فريق عمل متميز جداً."
                            </div>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="{{ asset('images/avatar-2.svg') }}" alt="سارة أحمد">
                                    <div class="avatar-ring"></div>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">سارة أحمد</h4>
                                    <p class="author-title">مديرة مدرسة دولية</p>
                                    <div class="author-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="testimonial-quote">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <div class="testimonial-text">
                                "شركة محترفة وملتزمة بالمواعيد. الجودة تفوق التوقعات والأسعار تنافسية.
                                أنصح بالتعامل معهم لأي مشروع رياضي. خدمة عملاء متميزة."
                            </div>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="{{ asset('images/avatar-3.svg') }}" alt="محمد علي">
                                    <div class="avatar-ring"></div>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">محمد علي</h4>
                                    <p class="author-title">مدير شركة رياضية</p>
                                    <div class="author-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="testimonial-quote">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <div class="testimonial-text">
                                "تجربة رائعة من البداية للنهاية. التصاميم عصرية والتنفيذ دقيق.
                                فريق العمل متعاون ويستمع لاحتياجات العميل. جودة لا تُضاهى."
                            </div>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="{{ asset('images/avatar-1.svg') }}" alt="فاطمة السعد">
                                    <div class="avatar-ring"></div>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">فاطمة السعد</h4>
                                    <p class="author-title">مديرة أكاديمية رياضية</p>
                                    <div class="author-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="testimonial-quote">
                                <i class="fas fa-quote-right"></i>
                            </div>
                            <div class="testimonial-text">
                                "أفضل شركة في مجال الملابس الرياضية. المواد عالية الجودة والألوان ثابتة.
                                التوصيل سريع والتغليف احترافي. شكراً لكم على الخدمة المتميزة."
                            </div>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="{{ asset('images/avatar-2.svg') }}" alt="خالد الرشيد">
                                    <div class="avatar-ring"></div>
                                </div>
                                <div class="author-info">
                                    <h4 class="author-name">خالد الرشيد</h4>
                                    <p class="author-title">رئيس نادي رياضي</p>
                                    <div class="author-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Controls -->
                <div class="testimonials-navigation">
                    <button class="nav-btn prev-btn" aria-label="السابق">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <button class="nav-btn next-btn" aria-label="التالي">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>

                <!-- Progress Bar -->
                <div class="testimonials-progress">
                    <div class="progress-bar">
                        <div class="progress-fill"></div>
                    </div>
                </div>

                <!-- Indicators -->
                <div class="testimonials-indicators">
                    <button class="indicator active" data-slide="0" aria-label="عرض الرأي الأول"></button>
                    <button class="indicator" data-slide="1" aria-label="عرض الرأي الثاني"></button>
                    <button class="indicator" data-slide="2" aria-label="عرض الرأي الثالث"></button>
                    <button class="indicator" data-slide="3" aria-label="عرض الرأي الرابع"></button>
                    <button class="indicator" data-slide="4" aria-label="عرض الرأي الخامس"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="infinity-contact">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">تواصل معنا</h2>
                <p class="section-subtitle">نحن هنا لمساعدتك في تحقيق رؤيتك الرياضية</p>
            </div>

            <!-- معلومات التواصل -->
            <div class="infinity-contact-info">
                <div class="contact-info-header">
                    <h3>معلومات التواصل</h3>
                    <p>تواصل معنا عبر القنوات التالية</p>
                </div>

                <div class="infinity-contact-cards">
                    <div class="infinity-contact-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="infinity-contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="icon-pulse"></div>
                        </div>
                        <div class="infinity-contact-details">
                            <h3>عنواننا</h3>
                            <p>الرياض، حي النخيل<br>شارع الملك فهد<br>المملكة العربية السعودية</p>
                            <a href="https://maps.google.com" target="_blank" class="contact-link">
                                <i class="fas fa-external-link-alt"></i>
                                عرض على الخريطة
                            </a>
                        </div>
                    </div>

                    <div class="infinity-contact-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="infinity-contact-icon">
                            <i class="fas fa-phone"></i>
                            <div class="icon-pulse"></div>
                        </div>
                        <div class="infinity-contact-details">
                            <h3>الهاتف</h3>
                            <p>+966500982394<br>+966 11 234 5678</p>
                            <a href="tel:+966501234567" class="contact-link">
                                <i class="fas fa-phone"></i>
                                اتصل بنا الآن
                            </a>
                        </div>
                    </div>

                    <div class="infinity-contact-card" data-aos="fade-up" data-aos-delay="300">
                        <div class="infinity-contact-icon">
                            <i class="fas fa-envelope"></i>
                            <div class="icon-pulse"></div>
                        </div>
                        <div class="infinity-contact-details">
                            <h3>البريد الإلكتروني</h3>
                            <p>info@infinitywear.sa<br>sales@infinitywear.sa</p>
                            <a href="mailto:info@infinitywear.sa" class="contact-link">
                                <i class="fas fa-envelope"></i>
                                أرسل بريد إلكتروني
                            </a>
                        </div>
                    </div>

                    <div class="infinity-contact-card" data-aos="fade-up" data-aos-delay="400">
                        <div class="infinity-contact-icon">
                            <i class="fas fa-clock"></i>
                            <div class="icon-pulse"></div>
                        </div>
                        <div class="infinity-contact-details">
                            <h3>ساعات العمل</h3>
                            <p>الأحد - الخميس: 8:00 ص - 6:00 م<br>الجمعة - السبت: مغلق</p>
                            <div class="working-status">
                                <span class="status-indicator online"></span>
                                <span class="status-text">نحن متاحون الآن</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- وسائل التواصل الاجتماعي -->
                <div class="contact-social-links">
                    <h4>تابعنا على</h4>
                    <div class="social-links">
                        <a href="#" class="social-link whatsapp" title="واتساب">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="social-link instagram" title="إنستغرام">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link twitter" title="تويتر">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link linkedin" title="لينكد إن">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="social-link snapchat" title="سناب شات">
                            <i class="fab fa-snapchat"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- قسم الخريطة والنموذج -->
            <div class="infinity-contact-content">
                <!-- خريطة تفاعلية -->
                <div class="contact-map-section" data-aos="fade-right" data-aos-delay="500">
                    <div class="map-header">
                        <h3>موقعنا على الخريطة</h3>
                        <p>زيارتنا في مكتبنا الرئيسي بالرياض</p>
                    </div>
                    <div class="map-container">
                        <!-- Google Maps -->
                        <iframe 
                            id="googleMap"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3624.5!2d46.6753!3d24.7136!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2ee2b5b5b5b5b5%3A0x3e2ee2b5b5b5b5b5!2sRiyadh%2C%20Saudi%20Arabia!5e0!3m2!1sen!2ssa!4v1234567890123!5m2!1sen!2ssa"
                            width="100%" 
                            height="400" 
                            style="border:0; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="موقع إنفينيتي وير على الخريطة - الرياض، المملكة العربية السعودية">
                        </iframe>
                        
                        <!-- OpenStreetMap as fallback -->
                        <iframe 
                            id="openStreetMap"
                            src="https://www.openstreetmap.org/export/embed.html?bbox=46.6%2C24.6%2C46.8%2C24.8&layer=mapnik&marker=24.7136%2C46.6753"
                            width="100%" 
                            height="400" 
                            style="border:0; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); display: none;" 
                            title="موقع إنفينيتي وير على الخريطة - الرياض، المملكة العربية السعودية">
                        </iframe>
                        
                        <div class="map-overlay">
                            <div class="map-info">
                                <h4>إنفينيتي وير</h4>
                                <p>الرياض، حي النخيل، شارع الملك فهد</p>
                                <a href="https://maps.google.com/?q=Riyadh,Saudi+Arabia" target="_blank" class="btn btn-outline btn-sm">
                                    <i class="fas fa-external-link-alt"></i>
                                    فتح في خرائط جوجل
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- نموذج التواصل المحسن -->
                <div class="infinity-contact-form-container" data-aos="fade-left" data-aos-delay="600">
                    <div class="form-header">
                        <h3>أرسل لنا رسالة</h3>
                        <p>سنرد عليك خلال 24 ساعة</p>
                    </div>

                    <form class="infinity-contact-form" id="contactForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">
                                    <i class="fas fa-user"></i>
                                    الاسم الكامل *
                                </label>
                                <input type="text" id="name" name="name" required class="form-control">
                                <div class="input-focus-line"></div>
                            </div>
                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope"></i>
                                    البريد الإلكتروني *
                                </label>
                                <input type="email" id="email" name="email" required class="form-control">
                                <div class="input-focus-line"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">
                                    <i class="fas fa-phone"></i>
                                    رقم الهاتف
                                </label>
                                <input type="tel" id="phone" name="phone" class="form-control" placeholder="+966500982394">
                                <div class="input-focus-line"></div>
                            </div>
                            <div class="form-group">
                                <label for="company">
                                    <i class="fas fa-building"></i>
                                    اسم الشركة/المؤسسة
                                </label>
                                <input type="text" id="company" name="company" class="form-control">
                                <div class="input-focus-line"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subject">
                                <i class="fas fa-tag"></i>
                                موضوع الاستفسار *
                            </label>
                            <select id="subject" name="subject" required class="form-control">
                                <option value="">اختر موضوع الاستفسار</option>
                                <option value="طلب عرض سعر">طلب عرض سعر</option>
                                <option value="استفسار عن منتج">استفسار عن منتج</option>
                                <option value="تصميم مخصص">تصميم مخصص</option>
                                <option value="طلب عينة">طلب عينة</option>
                                <option value="الشكاوى والمقترحات">الشكاوى والمقترحات</option>
                                <option value="الدعم الفني">الدعم الفني</option>
                                <option value="الشراكة والتعاون">الشراكة والتعاون</option>
                                <option value="أخرى">أخرى</option>
                            </select>
                            <div class="input-focus-line"></div>
                        </div>

                        <div class="form-group">
                            <label for="message">
                                <i class="fas fa-comment"></i>
                                الرسالة *
                            </label>
                            <textarea id="message" name="message" rows="5" required 
                                placeholder="اكتب رسالتك هنا... أخبرنا عن احتياجاتك وسنساعدك في تحقيقها" 
                                class="form-control"></textarea>
                            <div class="input-focus-line"></div>
                            <div class="char-counter">
                                <span class="current-count">0</span>/<span class="max-count">500</span>
                            </div>
                        </div>

                        <!-- خيارات إضافية -->
                        <div class="form-options">
                            <div class="checkbox-group">
                                <input type="checkbox" id="newsletter" name="newsletter">
                                <label for="newsletter">
                                    <span class="checkmark"></span>
                                    أريد الاشتراك في النشرة الإخبارية
                                </label>
                            </div>
                            <div class="checkbox-group">
                                <input type="checkbox" id="callback" name="callback">
                                <label for="callback">
                                    <span class="checkmark"></span>
                                    أريد اتصال هاتفي للرد على استفساري
                                </label>
                            </div>
                        </div>
        
                        <button type="submit" class="btn btn-primary btn-full btn-submit">
                            <span class="btn-text">
                                <i class="fas fa-paper-plane"></i>
                                إرسال الرسالة
                            </span>
                            <span class="btn-loading">
                                <i class="fas fa-spinner fa-spin"></i>
                                جاري الإرسال...
                            </span>
                        </button>

                        <div class="form-footer">
                            <p>
                                <i class="fas fa-shield-alt"></i>
                                معلوماتك محمية ومشفرة. لن نشاركها مع أي طرف ثالث.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <!-- Custom JavaScript -->
    <script src="{{ asset('js/infinity-home.js') }}"></script>
    <!-- Home Page Responsive JavaScript -->
    <script src="{{ asset('js/home-responsive.js') }}"></script>
    <!-- Football Animation JavaScript -->
    <script src="{{ asset('js/football-debug.js') }}"></script>
    
    <!-- Map Fallback Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const googleMap = document.getElementById('googleMap');
            const openStreetMap = document.getElementById('openStreetMap');
            
            // Check if Google Maps loads successfully
            googleMap.addEventListener('error', function() {
                console.log('Google Maps failed to load, switching to OpenStreetMap');
                googleMap.style.display = 'none';
                openStreetMap.style.display = 'block';
            });
            
            // Fallback timer - if Google Maps doesn't load within 5 seconds, show OpenStreetMap
            setTimeout(function() {
                if (googleMap.offsetHeight === 0 || googleMap.contentDocument === null) {
                    console.log('Google Maps timeout, switching to OpenStreetMap');
                    googleMap.style.display = 'none';
                    openStreetMap.style.display = 'block';
                }
            }, 5000);
        });
    </script>
@endsection
