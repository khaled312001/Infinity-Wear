@extends('layouts.dashboard')

@section('title', 'إدارة المحتوى الشاملة')
@section('dashboard-title', 'إدارة المحتوى')
@section('page-title', 'إدارة المحتوى الشاملة')
@section('page-subtitle', 'إدارة جميع محتويات الموقع من مكان واحد')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-layer-group me-2 text-primary"></i>
                    إدارة المحتوى الشاملة
                </h5>
                <a href="{{ route('admin.content-management.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    إضافة محتوى جديد
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($content && is_object($content) && method_exists($content, 'count') && $content->count() > 0)
                    <div class="accordion" id="contentAccordion">
                        @foreach($content as $pageName => $pageContent)
                            @if(is_object($pageContent) && method_exists($pageContent, 'count'))
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $loop->iteration }}">
                                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" 
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->iteration }}" 
                                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}" 
                                            aria-controls="collapse{{ $loop->iteration }}">
                                        <i class="fas fa-file-alt me-2 text-primary"></i>
                                        <strong>{{ ucfirst($pageName) }}</strong>
                                        <span class="badge bg-primary ms-2">{{ $pageContent->count() }} عنصر</span>
                                    </button>
                                </h2>
                                <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                                     aria-labelledby="heading{{ $loop->iteration }}" data-bs-parent="#contentAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            @foreach($pageContent as $item)
                                                @if($item && is_object($item))
                                                <div class="col-lg-6 col-xl-4 mb-4">
                                                    <div class="card h-100 border-0 shadow-sm">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                                <h6 class="card-title mb-0">
                                                                    <i class="fas fa-{{ $item->content_type === 'text' ? 'file-text' : ($item->content_type === 'image' ? 'image' : ($item->content_type === 'gallery' ? 'images' : ($item->content_type === 'video' ? 'video' : 'layer-group'))) }} me-2 text-primary"></i>
                                                                    {{ $item->title_ar ?: $item->title_en ?: 'بدون عنوان' }}
                                                                </h6>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                        <i class="fas fa-ellipsis-v"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a class="dropdown-item" href="{{ route('admin.content-management.edit', $item) }}">
                                                                                <i class="fas fa-edit me-2"></i>تعديل
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <button class="dropdown-item toggle-status" data-id="{{ $item->id }}">
                                                                                <i class="fas fa-{{ $item->is_active ? 'eye-slash' : 'eye' }} me-2"></i>
                                                                                {{ $item->is_active ? 'إخفاء' : 'إظهار' }}
                                                                            </button>
                                                                        </li>
                                                                        <li><hr class="dropdown-divider"></li>
                                                                        <li>
                                                                            <form action="{{ route('admin.content-management.destroy', $item) }}" method="POST" class="d-inline">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                                                    <i class="fas fa-trash me-2"></i>حذف
                                                                                </button>
                                                                            </form>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <span class="badge bg-secondary me-2">{{ ucfirst($item->section_name) }}</span>
                                                                <span class="badge bg-info">{{ ucfirst($item->content_type) }}</span>
                                                            </div>
                                                            
                                                            @if($item->description_ar || $item->description_en)
                                                                <p class="card-text text-muted small">
                                                                    {{ Str::limit($item->description_ar ?: $item->description_en, 100) }}
                                                                </p>
                                                            @endif
                                                            
                                                            @if($item->image_path)
                                                                <div class="mb-3">
                                                                    <img src="{{ asset('storage/' . $item->image_path) }}" 
                                                                         alt="{{ $item->title_ar ?: $item->title_en }}" 
                                                                         class="img-fluid rounded" style="max-height: 100px;">
                                                                </div>
                                                            @endif
                                                            
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <span class="badge bg-{{ $item->is_active ? 'success' : 'danger' }}">
                                                                        {{ $item->is_active ? 'نشط' : 'غير نشط' }}
                                                                    </span>
                                                                    @if($item->is_featured)
                                                                        <span class="badge bg-warning ms-1">مميز</span>
                                                                    @endif
                                                                </div>
                                                                <small class="text-muted">
                                                                    {{ $item->created_at->diffForHumans() }}
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-layer-group fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">لا يوجد محتوى بعد</h5>
                        <p class="text-muted">ابدأ بإنشاء محتوى جديد للموقع</p>
                        <a href="{{ route('admin.content-management.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            إضافة محتوى جديد
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle status functionality
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function() {
            const contentId = this.dataset.id;
            const button = this;
            
            fetch(`/admin/content-management/${contentId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button text and icon
                    const icon = button.querySelector('i');
                    if (data.is_active) {
                        icon.className = 'fas fa-eye-slash me-2';
                        button.innerHTML = '<i class="fas fa-eye-slash me-2"></i>إخفاء';
                    } else {
                        icon.className = 'fas fa-eye me-2';
                        button.innerHTML = '<i class="fas fa-eye me-2"></i>إظهار';
                    }
                    
                    // Reload page to update status badges
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء تحديث الحالة');
            });
        });
    });
});
</script>
@endpush
