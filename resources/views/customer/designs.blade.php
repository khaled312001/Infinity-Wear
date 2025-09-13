@extends('layouts.dashboard')

@section('title', 'تصاميمي المخصصة')
@section('dashboard-title', 'لوحة العميل')
@section('page-title', 'تصاميمي المخصصة')
@section('page-subtitle', 'عرض وإدارة جميع تصاميمك المخصصة')
@section('profile-route', route('customer.profile'))
@section('settings-route', route('customer.settings'))

@section('sidebar-menu')
    <a href="{{ route('customer.dashboard') }}" class="nav-link">
        <i class="fas fa-tachometer-alt me-2"></i>
        الرئيسية
    </a>
    <a href="{{ route('customer.orders') }}" class="nav-link">
        <i class="fas fa-shopping-cart me-2"></i>
        طلباتي
    </a>
    <a href="{{ route('customer.designs') }}" class="nav-link active">
        <i class="fas fa-palette me-2"></i>
        تصاميمي
    </a>
    <a href="{{ route('products.index') }}" class="nav-link">
        <i class="fas fa-tshirt me-2"></i>
        المنتجات
    </a>
    <a href="{{ route('custom-designs.create') }}" class="nav-link">
        <i class="fas fa-plus me-2"></i>
        تصميم جديد
    </a>
    <a href="{{ route('customer.profile') }}" class="nav-link">
        <i class="fas fa-user me-2"></i>
        الملف الشخصي
    </a>
@endsection

@section('page-actions')
    <a href="{{ route('custom-designs.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        تصميم جديد
    </a>
@endsection

@section('content')
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-palette me-2 text-primary"></i>
                    جميع التصاميم
                </h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="statusFilter">
                        <option value="">جميع الحالات</option>
                        <option value="pending">قيد المراجعة</option>
                        <option value="approved">معتمد</option>
                        <option value="rejected">مرفوض</option>
                        <option value="in_progress">قيد التنفيذ</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($designs->count() > 0)
                <div class="row g-4">
                    @foreach($designs as $design)
                        <div class="col-lg-4 col-md-6" data-status="{{ $design->status ?? 'pending' }}">
                            <div class="card border-0 shadow-sm h-100">
                                @if($design->image)
                                    <img src="{{ asset('storage/' . $design->image) }}" 
                                         class="card-img-top" 
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="fas fa-palette fa-3x text-muted"></i>
                                    </div>
                                @endif
                                
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title mb-0">{{ Str::limit($design->title, 30) }}</h5>
                                        @switch($design->status ?? 'pending')
                                            @case('pending')
                                                <span class="badge bg-warning">قيد المراجعة</span>
                                                @break
                                            @case('approved')
                                                <span class="badge bg-success">معتمد</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-danger">مرفوض</span>
                                                @break
                                            @case('in_progress')
                                                <span class="badge bg-info">قيد التنفيذ</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $design->status }}</span>
                                        @endswitch
                                    </div>
                                    
                                    <p class="card-text text-muted small mb-3">
                                        {{ Str::limit($design->description, 100) }}
                                    </p>
                                    
                                    <div class="row text-center mb-3">
                                        <div class="col-6">
                                            <small class="text-muted">تاريخ الإنشاء</small>
                                            <div class="fw-bold">{{ $design->created_at->format('Y-m-d') }}</div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">آخر تحديث</small>
                                            <div class="fw-bold">{{ $design->updated_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-white border-top">
                                    <div class="d-flex gap-2">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary flex-fill"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#designModal{{ $design->id }}">
                                            <i class="fas fa-eye me-1"></i>
                                            عرض
                                        </button>
                                        <a href="{{ route('custom-designs.edit', $design) }}" 
                                           class="btn btn-sm btn-outline-secondary flex-fill">
                                            <i class="fas fa-edit me-1"></i>
                                            تعديل
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="deleteDesign({{ $design->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Design Details Modal -->
                        <div class="modal fade" id="designModal{{ $design->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ $design->title }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                @if($design->image)
                                                    <img src="{{ asset('storage/' . $design->image) }}" 
                                                         class="img-fluid rounded mb-3">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" 
                                                         style="height: 300px;">
                                                        <i class="fas fa-palette fa-4x text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <h6>معلومات التصميم</h6>
                                                <table class="table table-sm">
                                                    <tr>
                                                        <td><strong>العنوان:</strong></td>
                                                        <td>{{ $design->title }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>الحالة:</strong></td>
                                                        <td>
                                                            @switch($design->status ?? 'pending')
                                                                @case('pending')
                                                                    <span class="badge bg-warning">قيد المراجعة</span>
                                                                    @break
                                                                @case('approved')
                                                                    <span class="badge bg-success">معتمد</span>
                                                                    @break
                                                                @case('rejected')
                                                                    <span class="badge bg-danger">مرفوض</span>
                                                                    @break
                                                                @case('in_progress')
                                                                    <span class="badge bg-info">قيد التنفيذ</span>
                                                                    @break
                                                                @default
                                                                    <span class="badge bg-secondary">{{ $design->status }}</span>
                                                            @endswitch
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>تاريخ الإنشاء:</strong></td>
                                                        <td>{{ $design->created_at->format('Y-m-d H:i') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>آخر تحديث:</strong></td>
                                                        <td>{{ $design->updated_at->format('Y-m-d H:i') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        @if($design->description)
                                            <div class="mt-3">
                                                <h6>الوصف</h6>
                                                <div class="alert alert-light">
                                                    {{ $design->description }}
                                                </div>
                                            </div>
                                        @endif

                                        @if($design->requirements)
                                            <div class="mt-3">
                                                <h6>المتطلبات</h6>
                                                <div class="alert alert-info">
                                                    {{ $design->requirements }}
                                                </div>
                                            </div>
                                        @endif

                                        @if($design->admin_notes)
                                            <div class="mt-3">
                                                <h6>ملاحظات الإدارة</h6>
                                                <div class="alert alert-warning">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    {{ $design->admin_notes }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        @if($design->status === 'approved')
                                            <button type="button" class="btn btn-success">
                                                <i class="fas fa-shopping-cart me-2"></i>
                                                تحويل لطلب
                                            </button>
                                        @endif
                                        <a href="{{ route('custom-designs.edit', $design) }}" class="btn btn-primary">
                                            <i class="fas fa-edit me-2"></i>
                                            تعديل التصميم
                                        </a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $designs->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-palette fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد تصاميم حتى الآن</h4>
                    <p class="text-muted mb-4">ابدأ بإنشاء تصميمك المخصص الأول</p>
                    <a href="{{ route('custom-designs.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        إنشاء تصميم جديد
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mt-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon warning me-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $designs->where('status', 'pending')->count() }}</h3>
                        <p class="text-muted mb-0">قيد المراجعة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon success me-3">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $designs->where('status', 'approved')->count() }}</h3>
                        <p class="text-muted mb-0">معتمدة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon info me-3">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $designs->where('status', 'in_progress')->count() }}</h3>
                        <p class="text-muted mb-0">قيد التنفيذ</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon danger me-3">
                        <i class="fas fa-times"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $designs->where('status', 'rejected')->count() }}</h3>
                        <p class="text-muted mb-0">مرفوضة</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Status filter functionality
        document.getElementById('statusFilter').addEventListener('change', function() {
            const selectedStatus = this.value;
            const cards = document.querySelectorAll('.col-lg-4[data-status]');
            
            cards.forEach(card => {
                if (selectedStatus === '' || card.dataset.status === selectedStatus) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Delete design function
        function deleteDesign(designId) {
            if (confirm('هل أنت متأكد من حذف هذا التصميم؟')) {
                // Here you would typically send an AJAX request to delete the design
                alert('سيتم إضافة وظيفة حذف التصميم قريباً');
            }
        }
    </script>
@endpush