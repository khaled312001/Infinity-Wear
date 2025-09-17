{{-- Hero Slider Section --}}
<section class="hero-slider" id="heroSlider">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            @forelse($heroSliders ?? [] as $slider)
                <div class="swiper-slide">
                    <div class="hero-slide" 
                         style="background-image: linear-gradient(rgba(0,0,0,{{ $slider->overlay_opacity ?? 0.5 }}), rgba(0,0,0,{{ $slider->overlay_opacity ?? 0.5 }})), url('{{ $slider->image_url }}');">
                        <div class="container">
                            <div class="row align-items-center min-vh-100">
                                <div class="col-lg-8 mx-auto text-center">
                                    <div class="hero-content" data-animation="{{ $slider->animation_type ?? 'fade' }}" style="color: {{ $slider->text_color ?? '#ffffff' }}">
                                        @if($slider->subtitle)
                                            <div class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">
                                                {{ $slider->subtitle }}
                                            </div>
                                        @endif
                                        
                                        <h1 class="hero-title animate__animated animate__fadeInUp animate__delay-2s">
                                            {{ $slider->title }}
                                        </h1>
                                        
                                        @if($slider->description)
                                            <p class="hero-description animate__animated animate__fadeInUp animate__delay-3s">
                                                {{ $slider->description }}
                                            </p>
                                        @endif
                                        
                                        @if($slider->button_text && $slider->button_link)
                                            <div class="hero-buttons animate__animated animate__fadeInUp animate__delay-4s">
                                                <a href="{{ $slider->button_link }}" class="btn btn-primary btn-lg hero-btn">
                                                    {{ $slider->button_text }}
                                                    <i class="fas fa-arrow-left me-2"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Decorative Elements --}}
                        <div class="hero-decorations">
                            <div class="decoration-circle circle-1"></div>
                            <div class="decoration-circle circle-2"></div>
                            <div class="decoration-circle circle-3"></div>
                        </div>
                        
                        {{-- Scroll Indicator --}}
                        <div class="scroll-indicator">
                            <div class="scroll-mouse">
                                <div class="scroll-wheel"></div>
                            </div>
                            <span class="scroll-text">اسحب للأسفل</span>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Default Hero Slide --}}
                <div class="swiper-slide">
                    <div class="hero-slide" style="background-image: linear-gradient(rgba(30,58,138,0.7), rgba(30,64,175,0.7)), url('{{ asset('images/hero/home-hero.svg') }}');">
                        <div class="container">
                            <div class="row align-items-center min-vh-100">
                                <div class="col-lg-8 mx-auto text-center">
                                    <div class="hero-content" style="color: #ffffff">
                                        <div class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">
                                            مرحباً بكم في
                                        </div>
                                        
                                        <h1 class="hero-title animate__animated animate__fadeInUp animate__delay-2s">
                                            Infinity Wear
                                        </h1>
                                        
                                        <p class="hero-description animate__animated animate__fadeInUp animate__delay-3s">
                                            مؤسسة اللباس اللامحدود - رائدون في تصنيع وتوريد أجود أنواع الملابس والزي الرسمي للشركات والمؤسسات
                                        </p>
                                        
                                        <div class="hero-buttons animate__animated animate__fadeInUp animate__delay-4s">
                                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg hero-btn me-3">
                                                تصفح المنتجات
                                                <i class="fas fa-arrow-left me-2"></i>
                                            </a>
                                            <a href="{{ route('importers.form') }}" class="btn btn-outline-light btn-lg hero-btn">
                                                تصميم مخصص
                                                <i class="fas fa-palette me-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Decorative Elements --}}
                        <div class="hero-decorations">
                            <div class="decoration-circle circle-1"></div>
                            <div class="decoration-circle circle-2"></div>
                            <div class="decoration-circle circle-3"></div>
                        </div>
                        
                        {{-- Scroll Indicator --}}
                        <div class="scroll-indicator">
                            <div class="scroll-mouse">
                                <div class="scroll-wheel"></div>
                            </div>
                            <span class="scroll-text">اسحب للأسفل</span>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        
        {{-- Navigation --}}
        @if(($heroSliders ?? collect())->count() > 1)
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        @endif
    </div>
</section>