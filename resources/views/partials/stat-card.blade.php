<!-- Statistics Card -->
<div class="text-center">
    <div class="stat-card">
        <div class="stat-icon mb-3">
            <i class="{{ $content->icon }} fa-3x" style="color: {{ $content->icon_color }};"></i>
        </div>
        <h3 class="stat-number" style="color: {{ $content->icon_color }};">
            {{ $content->extra_data['number'] ?? '0' }}{{ $content->extra_data['suffix'] ?? '' }}
        </h3>
        <p class="stat-label">{{ $content->title }}</p>
    </div>
</div>