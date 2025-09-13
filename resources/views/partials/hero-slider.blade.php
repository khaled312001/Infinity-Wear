<!-- Hero Slider -->
<section class="hero-slider">
    <div class="swiper heroSwiper">
        <div class="swiper-wrapper">
            @forelse($heroSliders as $slide)
            <div class="swiper-slide">
                <div class="hero-slide" style="background-image: url('{{ asset('storage/' . $slide->image) }}')">
                    <div class="hero-overlay"></div>
                    <div class="hero-content">
                        <h1 class="hero-title" data-aos="fade-up">{{ $slide->title }}</h1>
                        @if($slide->subtitle)
                        <h2 class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $slide->subtitle }}</h2>
                        @endif
                        @if($slide->description)
                        <p class="hero-description" data-aos="fade-up" data-aos-delay="200">{{ $slide->description }}</p>
                        @endif
                        @if($slide->button_text && $slide->button_url)
                        <a href="{{ $slide->button_url }}" 
                           class="btn btn-lg" 
                           style="background-color: {{ $slide->button_color }}; border-color: {{ $slide->button_color }};"
                           data-aos="fade-up" 
                           data-aos-delay="300">
                            {{ $slide->button_text }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <!-- Default slide if no slides exist -->
            <div class="swiper-slide">
                <div class="hero-slide" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
                    <div class="hero-content">
                        <h1 class="hero-title" data-aos="fade-up">مرحباً بك في Infinity Wear</h1>
                        <h2 class="hero-subtitle" data-aos="fade-up" data-aos-delay="100">مؤسسة اللباس اللامحدود</h2>
                        <p class="hero-description" data-aos="fade-up" data-aos-delay="200">
                            مؤسسة سعودية متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية
                        </p>
                        <a href="{{ route('services') }}" class="btn btn-warning btn-lg" data-aos="fade-up" data-aos-delay="300">
                            <i class="fas fa-cogs me-2"></i>
                            اكتشف خدماتنا
                        </a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>