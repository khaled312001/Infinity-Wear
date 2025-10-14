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
                <div class="infinity-hero-stats" style="width: 100%; margin-top: 2rem;">
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

   
    <!-- Portfolio Section -->
    <section id="portfolio" class="infinity-portfolio">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">أعمالنا السابقة</h2>
                <p class="section-subtitle">نماذج من مشاريعنا الناجحة مع عملاء مرموقين</p>
            </div>


            <div class="infinity-portfolio-grid">
                @forelse($featuredPortfolio as $item)
                <div class="portfolio-item" data-category="{{ $item->category }}">
                    <div class="portfolio-image">
                        @if($item->image)
                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" 
                                 class="portfolio-dynamic-image">
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
    // Handle image loading errors for portfolio images
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.portfolio-dynamic-image').forEach(function(img) {
            img.addEventListener('error', function() {
                this.src = '{{ asset("images/default-image.png") }}';
            });
        });

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
    });
    </script>
@endsection
