{{-- Section Header --}}
@if($section->title || $section->subtitle || $section->description)
    <div class="section-header text-center mb-5">
        @if($section->subtitle)
            <div class="section-subtitle animate-on-scroll" data-animation="fadeInUp">
                {{ $section->subtitle }}
            </div>
        @endif
        
        @if($section->title)
            <h2 class="section-title animate-on-scroll" data-animation="fadeInUp" data-delay="200">
                {{ $section->title }}
            </h2>
        @endif
        
        @if($section->description)
            <p class="section-description animate-on-scroll" data-animation="fadeInUp" data-delay="400">
                {{ $section->description }}
            </p>
        @endif
        
        <div class="section-divider animate-on-scroll" data-animation="scaleX" data-delay="600"></div>
    </div>
@endif