{{-- Default Home Sections --}}

{{-- Services Section --}}
<section class="home-section section-services py-5" id="services">
    <div class="container">
        <div class="section-header text-center mb-5">
            <div class="section-subtitle animate-on-scroll" data-animation="fadeInUp">
                خدماتنا المميزة
            </div>
            <h2 class="section-title animate-on-scroll" data-animation="fadeInUp" data-delay="200">
                نقدم لكم أفضل الحلول
            </h2>
            <p class="section-description animate-on-scroll" data-animation="fadeInUp" data-delay="400">
                نحن نقدم مجموعة شاملة من الخدمات المتخصصة في مجال الملابس والزي الرسمي
            </p>
            <div class="section-divider animate-on-scroll" data-animation="scaleX" data-delay="600"></div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card animate-on-scroll" data-animation="fadeInUp" data-delay="200">
                    <div class="card-icon">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">تصنيع الملابس</h4>
                        <p class="card-description">
                            نصنع جميع أنواع الملابس بأعلى معايير الجودة وأحدث التقنيات
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="feature-card animate-on-scroll" data-animation="fadeInUp" data-delay="400">
                    <div class="card-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">التصاميم المخصصة</h4>
                        <p class="card-description">
                            فريق من المصممين المحترفين لإنشاء تصاميم فريدة حسب متطلباتكم
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="feature-card animate-on-scroll" data-animation="fadeInUp" data-delay="600">
                    <div class="card-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">التوصيل السريع</h4>
                        <p class="card-description">
                            خدمة توصيل سريعة وآمنة لجميع أنحاء المملكة العربية السعودية
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- About Section --}}
<section class="home-section section-about py-5 bg-light" id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-content animate-on-scroll" data-animation="fadeInRight">
                    <div class="section-subtitle">نبذة عنا</div>
                    <h2 class="section-title">رائدون في صناعة الملابس</h2>
                    <p class="section-description">
                        مؤسسة اللباس اللامحدود هي شركة رائدة في مجال تصنيع وتوريد الملابس والزي الرسمي 
                        للشركات والمؤسسات. نحن نجمع بين الخبرة العريقة والتقنيات الحديثة لنقدم لعملائنا 
                        أفضل المنتجات بأعلى معايير الجودة.
                    </p>
                    
                    <div class="about-features">
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>أكثر من 10 سنوات من الخبرة</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>فريق متخصص ومحترف</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>جودة عالية وأسعار تنافسية</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('about') }}" class="btn btn-primary btn-lg mt-4">
                        اعرف المزيد
                        <i class="fas fa-arrow-left me-2"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="about-image animate-on-scroll" data-animation="fadeInLeft">
                    <img src="{{ asset('images/sections/uniform-design.svg') }}" alt="About Us" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Portfolio Section --}}
<section class="home-section section-portfolio py-5" id="portfolio">
    <div class="container">
        <div class="section-header text-center mb-5">
            <div class="section-subtitle animate-on-scroll" data-animation="fadeInUp">
                أعمالنا
            </div>
            <h2 class="section-title animate-on-scroll" data-animation="fadeInUp" data-delay="200">
                معرض أعمالنا المميزة
            </h2>
            <p class="section-description animate-on-scroll" data-animation="fadeInUp" data-delay="400">
                شاهد مجموعة من أفضل أعمالنا والمشاريع التي نفذناها بنجاح
            </p>
            <div class="section-divider animate-on-scroll" data-animation="scaleX" data-delay="600"></div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item animate-on-scroll" data-animation="zoomIn" data-delay="200">
                    <img src="{{ asset('images/portfolio/school_uniform_1.jpg') }}" alt="School Uniform" class="img-fluid">
                    <div class="portfolio-overlay">
                        <h5>زي مدرسي</h5>
                        <p>تصميم وتنفيذ الزي المدرسي</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item animate-on-scroll" data-animation="zoomIn" data-delay="400">
                    <img src="{{ asset('images/portfolio/corporate_uniform_1.jpg') }}" alt="Corporate Uniform" class="img-fluid">
                    <div class="portfolio-overlay">
                        <h5>زي شركات</h5>
                        <p>زي رسمي للشركات والمؤسسات</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="portfolio-item animate-on-scroll" data-animation="zoomIn" data-delay="600">
                    <img src="{{ asset('images/portfolio/sports_wear_1.jpg') }}" alt="Sports Wear" class="img-fluid">
                    <div class="portfolio-overlay">
                        <h5>ملابس رياضية</h5>
                        <p>تصميم الملابس الرياضية المتخصصة</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('portfolio.index') }}" class="btn btn-outline-primary btn-lg">
                عرض جميع الأعمال
                <i class="fas fa-arrow-left me-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- Contact Section --}}
<section class="home-section section-contact py-5 bg-primary text-white" id="contact">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="contact-content animate-on-scroll" data-animation="fadeInRight">
                    <h2 class="section-title text-white">هل لديك مشروع؟ دعنا نساعدك</h2>
                    <p class="section-description text-white-50">
                        تواصل معنا اليوم واحصل على استشارة مجانية لمشروعك القادم
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4 text-end">
                <div class="contact-buttons animate-on-scroll" data-animation="fadeInLeft">
                    <a href="{{ route('contact') }}" class="btn btn-light btn-lg me-3">
                        تواصل معنا
                        <i class="fas fa-phone me-2"></i>
                    </a>
                    <a href="{{ route('importers.form') }}" class="btn btn-outline-light btn-lg">
                        طلب تصميم
                        <i class="fas fa-palette me-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>