@foreach($portfolioItems as $item)
<div class="col-md-4 col-lg-3 portfolio-item" data-category="{{ $item->category }}">
    <div class="card portfolio-card h-100">
        <img src="{{ asset($item->image) }}" class="card-img-top" alt="{{ $item->title }}">
        <div class="card-body">
            <h5 class="card-title">{{ $item->title }}</h5>
            <p class="card-text text-muted">{{ $item->category }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('portfolio.show', $item->id) }}" class="btn btn-sm btn-outline-primary">عرض التفاصيل</a>
                <small class="text-muted">{{ $item->completion_date->format('Y/m/d') }}</small>
            </div>
        </div>
    </div>
</div>
@endforeach