@extends('layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'إنفينيتي وير - ملابس رياضية احترافية')
@section('description', 'إنفينيتي وير - شركة سعودية رائدة في تصميم وإنتاج الملابس الرياضية والزي الموحد للفرق والمدارس والشركات')

@section('styles')
    <!-- Custom CSS -->
    <link href="{{ asset('css/infinity-home.css') }}" rel="stylesheet">
    <!-- Home Page Responsive CSS -->
    <link href="{{ asset('css/home-responsive.css') }}" rel="stylesheet">
    <!-- Hero Video CSS -->
    <link href="{{ asset('css/hero-video.css') }}" rel="stylesheet">
    
@endsection

@section('content')

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
                <div class="infinity-hero-text" style="width: 100%;">
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
                <!-- Video Section -->
                <div class="infinity-hero-video" style="width: 100%; margin-top: 2rem;">
                    <div class="video-container">
                        <video id="heroVideo" class="hero-video" preload="metadata" poster="{{ asset('images/hero/home-hero.svg') }}">
                            <source src="{{ asset('videos/intro.mp4') }}" type="video/mp4">
                            متصفحك لا يدعم تشغيل الفيديو
                        </video>
                        <div class="video-overlay">
                            <div class="play-button-container">
                                <button class="play-button" id="playButton">
                                    <div class="play-icon">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <div class="play-ripple"></div>
                                </button>
                                <div class="video-title">
                                    <h3>شاهد قصتنا</h3>
                                    <p>اكتشف رحلة إنفينيتي وير</p>
                                </div>
                            </div>
                        </div>
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
                <div class="infinity-about-text" style="width: 100%; margin-bottom: 2rem;">
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

                <div class="infinity-about-image" style="width: 100%;">
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
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">خدماتنا</h2>
                <p class="section-subtitle">نقدم مجموعة شاملة من الخدمات المتخصصة في الملابس الرياضية</p>
            </div>

            <div class="infinity-services-grid">
                @forelse($services as $index => $service)
                <div class="service-card" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
                    <div class="service-image">
                        @if($service->image)
                            <img src="{{ $service->image_url }}" alt="{{ $service->title }}">
                        @else
                            <div class="service-image-placeholder">
                                <i class="{{ $service->icon ?? 'fas fa-cog' }} fa-3x"></i>
                            </div>
                        @endif
                    </div>
                    <div class="service-content">
                        <div class="service-icon">
                            <i class="{{ $service->icon ?? 'fas fa-cog' }}"></i>
                        </div>
                        <h3 class="service-title">{{ $service->title }}</h3>
                        <p class="service-description">
                            {{ $service->description }}
                        </p>
                        @if($service->features && count($service->features) > 0)
                        <ul class="service-features">
                            @foreach($service->features as $feature)
                            <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
                @empty
                <!-- Default Services if no services in database -->
                <div class="service-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-image">
                        <img src="{{ asset('images/sections/sports-equipment.svg') }}" alt="زي الفرق الرياضية">
                    </div>
                    <div class="service-content">
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
                </div>

                <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-image">
                        <img src="{{ asset('images/sections/uniform-design.svg') }}" alt="زي المدارس والجامعات">
                    </div>
                    <div class="service-content">
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
                </div>

                <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-image">
                        <img src="{{ asset('images/sections/quality-manufacturing.svg') }}" alt="زي الشركات والمؤسسات">
                    </div>
                    <div class="service-content">
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
                </div>

                <div class="service-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-image">
                        <img src="{{ asset('images/sections/custom-design.svg') }}" alt="تصاميم مخصصة">
                    </div>
                    <div class="service-content">
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
                </div>

                <div class="service-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-image">
                        <img src="{{ asset('images/sections/printing-service.svg') }}" alt="الطباعة والتطريز">
                    </div>
                    <div class="service-content">
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
                </div>

                <div class="service-card" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-image">
                        <img src="{{ asset('images/sections/customer-service.svg') }}" alt="التوصيل والتوزيع">
                    </div>
                    <div class="service-content">
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
                @endforelse
            </div>
            
            <!-- Call to Action -->
            <div class="services-cta" data-aos="fade-up" data-aos-delay="700">
                <div class="cta-content">
                    <h3>هل تريد معرفة المزيد عن خدماتنا؟</h3>
                    <p>تواصل معنا اليوم للحصول على استشارة مجانية وتقدير سعر لمشروعك</p>
                    <div class="cta-buttons">
                        <a href="{{ route('services') }}" class="btn btn-primary btn-large">
                            <i class="fas fa-eye"></i>
                            عرض جميع الخدمات
                        </a>
                        <a href="#contact" class="btn btn-outline btn-large">
                            <i class="fas fa-phone"></i>
                            تواصل معنا
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Order Workflow Section -->
    <section id="workflow" class="infinity-workflow">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">مراحل تنفيذ طلبك</h2>
                <p class="section-subtitle">اكتشف رحلة طلبك معنا من البداية حتى التسليم النهائي</p>
                <div class="workflow-intro">
                    <p>نوفر لك شفافية كاملة في كل خطوة من خطوات تنفيذ طلبك. تابع معنا رحلة منتجك عبر 10 مراحل احترافية مصممة لضمان جودة عالية ورضا تام.</p>
                </div>
            </div>

            <div class="workflow-container">
                <div class="workflow-timeline">
                    @php
                        $stages = [
                            [
                                'name' => 'التسويق',
                                'icon' => 'fas fa-bullhorn',
                                'description' => 'مرحلة التسويق والترويج لطلبك',
                                'details' => 'نقوم بدراسة متطلباتك وتقديم أفضل الحلول المناسبة لمشروعك',
                                'color' => '#667eea',
                                'delay' => 0
                            ],
                            [
                                'name' => 'المبيعات',
                                'icon' => 'fas fa-handshake',
                                'description' => 'متابعة طلبك مع فريق المبيعات',
                                'details' => 'فريق المبيعات يتواصل معك لتأكيد التفاصيل والمواصفات المطلوبة',
                                'color' => '#f093fb',
                                'delay' => 100
                            ],
                            [
                                'name' => 'التصميم',
                                'icon' => 'fas fa-palette',
                                'description' => 'تصميم مخصص لطلبك',
                                'details' => 'فريق التصميم المحترف يقوم بإنشاء تصاميم فريدة تناسب رؤيتك',
                                'color' => '#4facfe',
                                'delay' => 200
                            ],
                            [
                                'name' => 'العينة الأولى',
                                'icon' => 'fas fa-clipboard-check',
                                'description' => 'إنتاج عينة أولية للموافقة',
                                'details' => 'نقوم بإنتاج عينة أولية لمراجعتها والموافقة عليها قبل التصنيع',
                                'color' => '#43e97b',
                                'delay' => 300
                            ],
                            [
                                'name' => 'اعتماد الشغل',
                                'icon' => 'fas fa-check-circle',
                                'description' => 'الموافقة النهائية على التصميم',
                                'details' => 'بعد موافقتك على العينة، نبدأ في عملية التصنيع الفعلية',
                                'color' => '#fa709a',
                                'delay' => 400
                            ],
                            [
                                'name' => 'التصنيع',
                                'icon' => 'fas fa-industry',
                                'description' => 'بدء عملية التصنيع',
                                'details' => 'نستخدم أحدث المعدات والمواد عالية الجودة لضمان جودة المنتج النهائي',
                                'color' => '#30cfd0',
                                'delay' => 500
                            ],
                            [
                                'name' => 'الشحن',
                                'icon' => 'fas fa-truck',
                                'description' => 'تجهيز الطلب للشحن',
                                'details' => 'نقوم بتغليف آمن واحترافي لضمان وصول منتجك بحالة ممتازة',
                                'color' => '#a8edea',
                                'delay' => 600
                            ],
                            [
                                'name' => 'استلام وتسليم',
                                'icon' => 'fas fa-box-open',
                                'description' => 'استلام وتسليم الطلب',
                                'details' => 'تسليم الطلب في الوقت المحدد مع التأكد من رضاكم التام',
                                'color' => '#ffecd2',
                                'delay' => 700
                            ],
                            [
                                'name' => 'التحصيل',
                                'icon' => 'fas fa-money-bill-wave',
                                'description' => 'إتمام عملية الدفع',
                                'details' => 'إتمام جميع المعاملات المالية بشكل آمن ومضمون',
                                'color' => '#ff9a9e',
                                'delay' => 800
                            ],
                            [
                                'name' => 'خدمة ما بعد البيع',
                                'icon' => 'fas fa-headset',
                                'description' => 'متابعة وخدمة ما بعد البيع',
                                'details' => 'نواصل متابعتك بعد التسليم لضمان رضاكم وتقديم الدعم اللازم',
                                'color' => '#a18cd1',
                                'delay' => 900
                            ]
                        ];
                    @endphp

                    @foreach($stages as $index => $stage)
                    <div class="workflow-step" data-aos="fade-up" data-aos-delay="{{ $stage['delay'] }}">
                        <div class="step-connector"></div>
                        <div class="step-card" style="--step-color: {{ $stage['color'] }}">
                            <div class="step-icon-wrapper">
                                <div class="step-icon" style="background: linear-gradient(135deg, {{ $stage['color'] }} 0%, {{ $stage['color'] }}dd 100%);">
                                    <i class="{{ $stage['icon'] }}"></i>
                                </div>
                                <div class="step-number">{{ $index + 1 }}</div>
                            </div>
                            <div class="step-content">
                                <h3 class="step-title">{{ $stage['name'] }}</h3>
                                <p class="step-description">{{ $stage['description'] }}</p>
                                @if(isset($stage['details']))
                                <p class="step-details">{{ $stage['details'] }}</p>
                                @endif
                            </div>
                            <div class="step-arrow">
                                <i class="fas fa-arrow-left"></i>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Call to Action -->
                <div class="workflow-cta" data-aos="fade-up" data-aos-delay="1000">
                    <div class="cta-card">
                        <div class="cta-background-pattern"></div>
                        <div class="cta-content">
                            <div class="cta-icon-wrapper">
                                <div class="cta-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <div class="cta-icon-glow"></div>
                            </div>
                            <h3>تتبع طلبك الآن</h3>
                            <p>أدخل رقم الطلب لمتابعة حالة طلبك في الوقت الفعلي</p>
                            <form class="track-order-form" action="{{ route('track-order') }}" method="GET">
                                <div class="form-group">
                                    <div class="input-wrapper">
                                        <i class="fas fa-hashtag input-icon"></i>
                                        <input type="text" name="order_number" placeholder="أدخل رقم الطلب" required>
                                    </div>
                                    <button type="submit" class="btn-track">
                                        <span class="btn-text">تتبع</span>
                                        <i class="fas fa-arrow-left btn-icon"></i>
                                        <div class="btn-ripple"></div>
                                    </button>
                                </div>
                            </form>
                            <div class="cta-features">
                                <style>
                                    .feature-item.custom-blue {
                                        background: #3267db;
                                        color:rgb(255, 255, 255);
                                        border-radius: 10px;
                                        padding: 12px 18px;
                                        display: inline-flex;
                                        align-items: center;
                                        gap: 8px;
                                        font-weight: 600;
                                        font-size: 1rem;
                                        margin-left: 8px;
                                        margin-bottom: 6px;
                                        transition: background 0.2s, color 0.2s;
                                    }
                                    .feature-item.custom-blue i {
                                        color:rgb(255, 255, 255);
                                        transition: color 0.2s;
                                    }
                                    .feature-item.custom-blue span {
                                        color:rgb(255, 255, 255);
                                        transition: color 0.2s;
                                    }
                                    .feature-item.custom-blue:hover, .feature-item.custom-blue:focus {
                                        background: #3267db;
                                        color: #fff;
                                    }
                                    .feature-item.custom-blue:hover i,
                                    .feature-item.custom-blue:hover span,
                                    .feature-item.custom-blue:focus i,
                                    .feature-item.custom-blue:focus span {
                                        color: #fff !important;
                                    }
                                </style>
                                <div class="feature-item custom-blue">
                                    <i class="fas fa-clock"></i>
                                    <span>متابعة فورية</span>
                                </div>
                                <div class="feature-item custom-blue">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>آمن ومضمون</span>
                                </div>
                                <div class="feature-item custom-blue">
                                    <i class="fas fa-bell"></i>
                                    <span>إشعارات تلقائية</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
                @forelse($portfolioItems as $item)
                <div class="portfolio-item" data-category="{{ $item->category }}">
                    <div class="portfolio-image">
                        @if($item->image)
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" 
                                 class="portfolio-dynamic-image"
                                 onerror="this.onerror=null; this.src='{{ asset('images/default-image.png') }}';">
                        @else
                            <img src="{{ asset('images/default-image.png') }}" alt="{{ $item->title }}">
                        @endif
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>{{ $item->title }}</h3>
                                <p>{{ Str::limit($item->description, 100) }}</p>
                                <div class="portfolio-meta">
                                    <small class="text-muted">{{ $item->client_name ?? 'غير محدد' }}</small>
                                    <span class="badge bg-primary">{{ $item->category }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-images fa-3x mb-3 opacity-50"></i>
                        <h5 class="mb-2">لا توجد أعمال متاحة حالياً</h5>
                        <p class="mb-3">سيتم إضافة أعمال جديدة قريباً</p>
                    </div>
                </div>
                @endforelse

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

            <div class="infinity-contact-content">
                <div class="infinity-contact-info" style="width: 100%; margin-bottom: 2rem;">
                    <div class="infinity-contact-card">
                        <div class="infinity-contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="infinity-contact-details">
                            <h3>عنواننا</h3>
                            <p>{{ \App\Models\Setting::get('address', 'الرياض، حي النخيل، المملكة العربية السعودية') }}</p>
                        </div>
                    </div>

                    <div class="infinity-contact-card">
                        <div class="infinity-contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="infinity-contact-details">
                            <h3>الهاتف</h3>
                            <p>{{ \App\Models\Setting::get('contact_phone') }}</p>
                        </div>
                    </div>

                    <div class="infinity-contact-card">
                        <div class="infinity-contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="infinity-contact-details">
                            <h3>البريد الإلكتروني</h3>
                            <p>{{ \App\Models\Setting::get('support_email', 'info@worldtripagency.com') }}</p>
                        </div>
                    </div>

                    <div class="infinity-contact-card">
                        <div class="infinity-contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="infinity-contact-details">
                            <h3>ساعات العمل</h3>
                            <p>{{ \App\Models\Setting::get('business_hours', 'الأحد - الخميس: 8:00 ص - 6:00 م') }}</p>
                        </div>
                    </div>
                </div>

                <div class="infinity-contact-form-container" style="width: 100%;">
                    <form class="infinity-contact-form" id="contactForm">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">الاسم الكامل *</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">البريد الإلكتروني *</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">رقم الهاتف</label>
                                <input type="tel" id="phone" name="phone">
                            </div>
                            <div class="form-group">
                                <label for="company">اسم الشركة/المؤسسة</label>
                                <input type="text" id="company" name="company">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subject">موضوع الاستفسار *</label>
                            <select id="subject" name="subject" required>
                                <option value="">اختر موضوع الاستفسار</option>
                                <option value="طلب عرض سعر">طلب عرض سعر</option>
                                <option value="استفسار عن منتج">استفسار عن منتج</option>
                                <option value="الشكاوى والمقترحات">الشكاوى والمقترحات</option>
                                <option value="الدعم الفني">الدعم الفني</option>
                                <option value="أخرى">أخرى</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message">الرسالة *</label>
                            <textarea id="message" name="message" rows="5" required placeholder="اكتب رسالتك هنا..."></textarea>
                        </div>

                        <!-- Push Notifications Toggle -->
                        <div class="push-notifications-toggle" style="margin: 15px 0; padding: 10px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-bell" style="color: #007bff;"></i>
                                    <span style="font-size: 14px; color: #495057;">تفعيل الإشعارات للرد السريع</span>
                                </div>
                                <button type="button" id="enableNotificationsHome" class="btn btn-sm btn-outline-primary" style="font-size: 12px;">
                                    <i class="fas fa-bell"></i> تفعيل
                                </button>
                            </div>
                            <div id="notificationStatusHome" style="margin-top: 8px; font-size: 12px; color: #6c757d; display: none;">
                                <i class="fas fa-check-circle" style="color: #28a745;"></i>
                                <span>الإشعارات مفعلة - ستتلقى إشعار عند الرد</span>
                            </div>
                        </div>
        
                        <button type="submit" class="btn btn-primary btn-full">
                            <i class="fas fa-paper-plane"></i>
                            إرسال الرسالة
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <!-- Custom JavaScript -->
    <script src="{{ asset('js/infinity-home.js') }}?v={{ time() }}"></script>
    <!-- Home Page Responsive JavaScript -->
    <script src="{{ asset('js/home-responsive.js') }}?v={{ time() }}"></script>
    
    <script>
    // Initialize AOS
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                offset: 100,
                delay: 0
            });
        }
        
    // Handle image loading errors for portfolio images
        document.querySelectorAll('.portfolio-dynamic-image').forEach(function(img) {
            img.addEventListener('error', function() {
                this.src = '{{ asset("images/default-image.png") }}';
            });
        });

        // Video Control
        const video = document.getElementById('heroVideo');
        const playButton = document.getElementById('playButton');
        const videoOverlay = document.querySelector('.video-overlay');
        const videoContainer = document.querySelector('.video-container');
        
        if (video && playButton) {
            // Play button click handler
            playButton.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleVideo();
            });
            
            // Video click handler
            video.addEventListener('click', function() {
                toggleVideo();
            });
            
            // Video ended handler
            video.addEventListener('ended', function() {
                showOverlay();
            });
            
            // Video playing handler
            video.addEventListener('play', function() {
                hideOverlay();
                videoContainer.classList.add('playing');
            });
            
            // Video paused handler
            video.addEventListener('pause', function() {
                showOverlay();
                videoContainer.classList.remove('playing');
            });
            
            // Video loading handler
            video.addEventListener('loadstart', function() {
                videoContainer.classList.add('loading');
            });
            
            video.addEventListener('canplay', function() {
                videoContainer.classList.remove('loading');
            });
            
            // Keyboard support
            video.addEventListener('keydown', function(e) {
                if (e.code === 'Space' || e.code === 'Enter') {
                    e.preventDefault();
                    toggleVideo();
                }
            });
            
            // Make video focusable
            video.setAttribute('tabindex', '0');
            
            function toggleVideo() {
                if (video.paused) {
                    video.play().catch(function(error) {
                        console.log('Video play failed:', error);
                        showOverlay();
                    });
                } else {
                    video.pause();
                    showOverlay();
                }
            }
            
            function showOverlay() {
                videoOverlay.style.opacity = '1';
                videoOverlay.style.visibility = 'visible';
                videoContainer.classList.remove('playing');
            }
            
            function hideOverlay() {
                videoOverlay.style.opacity = '0';
                videoOverlay.style.visibility = 'hidden';
                videoContainer.classList.add('playing');
            }
            
            // Add ripple effect to play button
            playButton.addEventListener('click', function(e) {
                const ripple = document.createElement('div');
                ripple.classList.add('play-ripple');
                ripple.style.animation = 'ripple 0.6s ease-out';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        }

        // Push Notifications for Home Page
        const enableButton = document.getElementById('enableNotificationsHome');
        const statusDiv = document.getElementById('notificationStatusHome');
        
        if (enableButton && window.pushNotificationManager) {
            // Check current subscription status
            window.pushNotificationManager.getSubscriptionStatus().then(function(status) {
                if (status.isSubscribed) {
                    enableButton.innerHTML = '<i class="fas fa-bell-slash"></i> إلغاء';
                    enableButton.className = 'btn btn-sm btn-outline-danger';
                    statusDiv.style.display = 'block';
                } else if (status.permission === 'denied') {
                    enableButton.innerHTML = '<i class="fas fa-exclamation-triangle"></i> مرفوض';
                    enableButton.className = 'btn btn-sm btn-outline-warning';
                    enableButton.disabled = true;
                }
            });
            
            // Handle button click
            enableButton.addEventListener('click', async function() {
                if (this.innerHTML.includes('إلغاء')) {
                    // Unsubscribe
                    const success = await window.pushNotificationManager.unsubscribe();
                    if (success) {
                        this.innerHTML = '<i class="fas fa-bell"></i> تفعيل';
                        this.className = 'btn btn-sm btn-outline-primary';
                        statusDiv.style.display = 'none';
                    }
                } else {
                    // Subscribe
                    const success = await window.pushNotificationManager.subscribe('admin');
                    if (success) {
                        this.innerHTML = '<i class="fas fa-bell-slash"></i> إلغاء';
                        this.className = 'btn btn-sm btn-outline-danger';
                        statusDiv.style.display = 'block';
                    }
                }
            });
        }

        // Workflow steps animation on scroll
        const workflowSteps = document.querySelectorAll('.workflow-step');
        const observerOptions = {
            threshold: 0.3,
            rootMargin: '0px 0px -100px 0px'
        };

        const stepObserver = new IntersectionObserver(function(entries) {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('animated');
                        const stepCard = entry.target.querySelector('.step-card');
                        if (stepCard) {
                            stepCard.style.animationDelay = `${index * 0.1}s`;
                        }
                    }, index * 100);
                }
            });
        }, observerOptions);

        workflowSteps.forEach(step => {
            stepObserver.observe(step);
        });

        // Add hover effect to workflow steps
        workflowSteps.forEach(step => {
            const stepCard = step.querySelector('.step-card');
            if (stepCard) {
                stepCard.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(-10px) translateY(-5px)';
                });
                
                stepCard.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0) translateY(0)';
                });
            }
        });
    });
    </script>
@endsection
