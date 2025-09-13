<!-- Dynamic Sections -->
@foreach($homeSections as $section)
<section class="dynamic-section" 
         style="background-color: {{ $section->background_color }}; color: {{ $section->text_color }};">
    <div class="container">
        <!-- Section Header -->
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title" data-aos="fade-up">{{ $section->title }}</h2>
                @if($section->subtitle)
                <p class="lead" data-aos="fade-up" data-aos-delay="100">{{ $section->subtitle }}</p>
                @endif
                @if($section->description)
                <p data-aos="fade-up" data-aos-delay="200">{{ $section->description }}</p>
                @endif
            </div>
        </div>

        <!-- Section Content -->
        @if($section->contents->count() > 0)
        <div class="row g-4">
            @foreach($section->contents as $content)
            <div class="col-lg-{{ $section->section_type === 'testimonials' ? '4' : ($section->contents->count() <= 3 ? '4' : '3') }} col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="section-content-item">
                    @if($section->section_type === 'testimonials')
                        @include('partials.testimonial-card', ['content' => $content])
                    @elseif($section->section_type === 'stats')
                        @include('partials.stat-card', ['content' => $content])
                    @else
                        @include('partials.content-card', ['content' => $content])
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endforeach

@if($homeSections->count() === 0)
<!-- Default sections if no sections exist -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="section-title">مرحباً بك في لوحة التحكم</h2>
        <p class="lead">يمكنك الآن إدارة محتوى الموقع بالكامل من لوحة التحكم</p>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-cog me-2"></i>
            الذهاب إلى لوحة التحكم
        </a>
    </div>
</section>
@endif