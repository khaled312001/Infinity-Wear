{{-- Content Item --}}
<div class="content-item content-{{ $content->content_type }} animate-on-scroll" data-animation="fadeInUp">
    @switch($content->content_type)
        @case('card')
            <div class="feature-card">
                @if($content->image)
                    <div class="card-image">
                        <img src="{{ $content->image_url }}" alt="{{ $content->title }}" class="img-fluid">
                    </div>
                @elseif($content->icon_class)
                    <div class="card-icon">
                        <i class="{{ $content->full_icon_class }}"></i>
                    </div>
                @endif
                
                <div class="card-content">
                    <h4 class="card-title">{{ $content->title }}</h4>
                    
                    @if($content->subtitle)
                        <p class="card-subtitle">{{ $content->subtitle }}</p>
                    @endif
                    
                    @if($content->description)
                        <p class="card-description">{{ $content->description }}</p>
                    @endif
                    
                    @if($content->button_text && $content->button_link)
                        <a href="{{ $content->button_link }}" class="btn btn-{{ $content->button_style }} card-btn">
                            {{ $content->button_text }}
                            <i class="fas fa-arrow-left me-2"></i>
                        </a>
                    @endif
                </div>
            </div>
            @break
            
        @case('testimonial')
            <div class="testimonial-card">
                <div class="testimonial-content">
                    <div class="testimonial-quote">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    
                    @if($content->description)
                        <p class="testimonial-text">{{ $content->description }}</p>
                    @endif
                    
                    <div class="testimonial-author">
                        @if($content->image)
                            <img src="{{ $content->image_url }}" alt="{{ $content->title }}" class="author-avatar">
                        @endif
                        
                        <div class="author-info">
                            <h5 class="author-name">{{ $content->title }}</h5>
                            @if($content->subtitle)
                                <p class="author-position">{{ $content->subtitle }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @break
            
        @case('image')
            <div class="image-content">
                @if($content->image)
                    <img src="{{ $content->image_url }}" alt="{{ $content->title }}" class="img-fluid rounded">
                @endif
                
                @if($content->title || $content->description)
                    <div class="image-caption mt-3">
                        @if($content->title)
                            <h4>{{ $content->title }}</h4>
                        @endif
                        @if($content->description)
                            <p>{{ $content->description }}</p>
                        @endif
                    </div>
                @endif
            </div>
            @break
            
        @case('video')
            <div class="video-content">
                @if($content->video_url)
                    <div class="video-wrapper">
                        <iframe src="{{ $content->video_url }}" frameborder="0" allowfullscreen></iframe>
                    </div>
                @endif
                
                @if($content->title || $content->description)
                    <div class="video-caption mt-3">
                        @if($content->title)
                            <h4>{{ $content->title }}</h4>
                        @endif
                        @if($content->description)
                            <p>{{ $content->description }}</p>
                        @endif
                    </div>
                @endif
            </div>
            @break
            
        @case('icon')
            <div class="icon-content text-center">
                @if($content->icon_class)
                    <div class="icon-wrapper mb-3">
                        <i class="{{ $content->full_icon_class }}"></i>
                    </div>
                @endif
                
                <div class="stat-counter" data-count="{{ preg_replace('/\D/', '', $content->title) }}">
                    {{ $content->title }}
                </div>
                
                @if($content->subtitle)
                    <h5 class="stat-label">{{ $content->subtitle }}</h5>
                @endif
                
                @if($content->description)
                    <p class="stat-description">{{ $content->description }}</p>
                @endif
            </div>
            @break
            
        @case('button')
            <div class="button-content text-center">
                @if($content->button_text && $content->button_link)
                    <a href="{{ $content->button_link }}" class="btn btn-{{ $content->button_style }} btn-lg">
                        {{ $content->button_text }}
                        <i class="fas fa-arrow-left me-2"></i>
                    </a>
                @endif
            </div>
            @break
            
        @default
            {{-- Default Text Content --}}
            <div class="text-content">
                <h4>{{ $content->title }}</h4>
                
                @if($content->subtitle)
                    <p class="text-subtitle">{{ $content->subtitle }}</p>
                @endif
                
                @if($content->description)
                    <p>{{ $content->description }}</p>
                @endif
            </div>
    @endswitch
</div>