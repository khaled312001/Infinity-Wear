@extends('layouts.marketing-dashboard')

@section('title', 'التقييمات - فريق التسويق')
@section('dashboard-title', 'التقييمات')
@section('page-title', 'التقييمات')
@section('page-subtitle', 'إدارة تقييمات العملاء')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-star me-2"></i>
                    تقييمات العملاء
                </h5>
                <a href="{{ route('marketing.testimonials.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    إضافة تقييم جديد
                </a>
            </div>
            <div class="card-body">
                @if($testimonials->count() > 0)
                    <div class="row">
                        @foreach($testimonials as $testimonial)
                        <div class="col-lg-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="card-title mb-1">{{ $testimonial->client_name }}</h6>
                                            <small class="text-muted">{{ $testimonial->client_title }}</small>
                                        </div>
                                        <div class="text-end">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                            @if($testimonial->is_featured)
                                                <span class="badge bg-warning ms-2">مميز</span>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="card-text">{{ $testimonial->content }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $testimonial->created_at->format('Y-m-d') }}
                                    </small>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group w-100" role="group">
                                        <a href="{{ route('marketing.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('marketing.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذا التقييم؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $testimonials->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-star fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">لا توجد تقييمات</h5>
                        <p class="text-muted">ابدأ بإضافة تقييم جديد من العملاء</p>
                        <a href="{{ route('marketing.testimonials.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            إضافة تقييم جديد
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
