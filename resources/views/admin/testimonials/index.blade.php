@extends('layouts.dashboard')

@section('title', 'إدارة التقييمات')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'إدارة التقييمات')
@section('page-subtitle', 'عرض وإدارة جميع شهادات العملاء')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('page-actions')
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        إضافة تقييم جديد
    </a>
@endsection

@section('content')
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-quote-left me-2 text-primary"></i>
                    جميع التقييمات
                </h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="البحث في التقييمات..." id="searchInput">
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($testimonials->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>صورة العميل</th>
                                <th>اسم العميل</th>
                                <th>المنصب</th>
                                <th>الشركة</th>
                                <th>التقييم</th>
                                <th>المحتوى</th>
                                <th>الحالة</th>
                                <th>ترتيب العرض</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $testimonial)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($testimonial->image)
                                            <img src="{{ asset('storage/' . $testimonial->image) }}" 
                                                 alt="{{ $testimonial->client_name }}" 
                                                 class="rounded-circle me-3" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-0">{{ $testimonial->client_name }}</h6>
                                    </div>
                                </td>
                                <td>{{ $testimonial->client_position ?? 'غير محدد' }}</td>
                                <td>{{ $testimonial->client_company ?? 'غير محدد' }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $testimonial->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-muted"></i>
                                            @endif
                                        @endfor
                                        <span class="ms-2 text-muted">({{ $testimonial->rating }}/5)</span>
                                    </div>
                                </td>
                                <td>{{ Str::limit($testimonial->content, 50) }}</td>
                                <td>
                                    @if($testimonial->is_active)
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary">غير نشط</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $testimonial->sort_order ?? 0 }}</span>
                                </td>
                                <td>{{ $testimonial->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذه التقييم؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $testimonials->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-quote-left fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد شهادات حتى الآن</h4>
                    <p class="text-muted mb-4">ابدأ بإضافة تقييم جديد لعرض آراء عملائك</p>
                    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        إضافة تقييم جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // البحث في التقييمات
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endpush