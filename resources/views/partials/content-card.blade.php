<!-- Regular Content Card -->
<div class="content-card">
    @if($content->image)
        <img src="{{ asset('storage/' . $content->image) }}" alt="{{ $content->title }}" class="content-image">
    @elseif($content->icon)
        <div class="content-icon" style="background-color: {{ $content->icon_color }};">
            <i class="{{ $content->icon }}"></i>
        </div>
    @endif
    
    <h5 class="card-title mb-3">{{ $content->title }}</h5>
    
    @if($content->description)
    <p class="card-text mb-4">{{ $content->description }}</p>
    @endif
    
    @if($content->button_text && $content->button_url)
    <a href="{{ $content->button_url }}" class="btn btn-primary">
        <i class="fas fa-arrow-left me-2"></i>
        {{ $content->button_text }}
    </a>
    @endif
</div>