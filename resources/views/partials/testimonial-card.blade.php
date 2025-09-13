<!-- Testimonial Card -->
<div class="testimonial-card hover-lift">
    <div class="testimonial-content">
        @if($content->extra_data && isset($content->extra_data['rating']))
        <div class="stars mb-3">
            @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star {{ $i <= $content->extra_data['rating'] ? 'text-warning' : 'text-muted' }}"></i>
            @endfor
        </div>
        @endif
        <p class="mb-4">"{{ $content->description }}"</p>
    </div>
    <div class="testimonial-author">
        <div class="author-avatar">
            @if($content->image)
                <img src="{{ asset('storage/' . $content->image) }}" alt="{{ $content->title }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
            @else
                <i class="fas fa-user"></i>
            @endif
        </div>
        <div class="author-info">
            <h6>{{ $content->title }}</h6>
            @if($content->extra_data && isset($content->extra_data['position']))
            <small>{{ $content->extra_data['position'] }}</small>
            @endif
        </div>
    </div>
</div>