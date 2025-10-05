@extends('layouts.dashboard')

@section('title', 'إدارة الخدمات')
@section('page-title', 'إدارة الخدمات')
@section('page-subtitle', 'إدارة وتعديل محتوى صفحة الخدمات')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    إدارة محتوى صفحة الخدمات
                </h5>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('services') }}" target="_blank" class="btn btn-outline-primary">
                                <i class="fas fa-external-link-alt me-2"></i>
                                عرض صفحة الخدمات
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                                <i class="fas fa-plus me-2"></i>
                                إضافة خدمة جديدة
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid gap-2">
                            <button class="btn btn-warning" onclick="activateAllServices()">
                                <i class="fas fa-toggle-on me-2"></i>
                                تفعيل جميع الخدمات
                            </button>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <!-- Services List -->
                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-bold mb-3">قائمة الخدمات:</h6>
                        
                        @if($services->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>الترتيب</th>
                                            <th>الصورة</th>
                                            <th>العنوان</th>
                                            <th>الوصف</th>
                                            <th>الميزات</th>
                                            <th>الحالة</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($services as $service)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $service->order }}</span>
                                                </td>
                                                <td>
                                                    @if($service->image)
                                                        <img src="{{ $service->image_url }}" alt="{{ $service->title }}" 
                                                             class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                                             style="width: 60px; height: 60px;">
                                                            <i class="{{ $service->icon ?? 'fas fa-cog' }} text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $service->title }}</strong>
                                                </td>
                                                <td>
                                                    <small class="text-muted">{{ Str::limit($service->description, 100) }}</small>
                                                </td>
                                                <td>
                                                    @if($service->features && count($service->features) > 0)
                                                        <small class="text-muted">{{ count($service->features) }} ميزة</small>
                                                    @else
                                                        <small class="text-muted">لا توجد ميزات</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($service->is_active)
                                                        <span class="badge bg-success">مفعل</span>
                                                    @else
                                                        <span class="badge bg-danger">معطل</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.services.edit', $service->id) }}" 
                                                           class="btn btn-sm btn-outline-primary" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form method="POST" action="{{ route('admin.services.toggle-status', $service->id) }}" 
                                                              style="display: inline;" onsubmit="return confirm('هل أنت متأكد من تغيير حالة هذه الخدمة؟')">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-outline-{{ $service->is_active ? 'warning' : 'success' }}" 
                                                                    title="{{ $service->is_active ? 'تعطيل' : 'تفعيل' }}">
                                                                <i class="fas fa-{{ $service->is_active ? 'pause' : 'play' }}"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}" 
                                                              style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذه الخدمة؟ لا يمكن التراجع عن هذا الإجراء.')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
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
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-cogs fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">لا توجد خدمات</h5>
                                <p class="text-muted">ابدأ بإضافة خدمة جديدة</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">
                    <i class="fas fa-plus me-2"></i>
                    إضافة خدمة جديدة
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">عنوان الخدمة <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="icon" class="form-label">الأيقونة</label>
                                <input type="text" class="form-control" id="icon" name="icon" 
                                       placeholder="مثال: fas fa-tshirt">
                                <small class="form-text text-muted">استخدم Font Awesome icons</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">وصف الخدمة <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">صورة الخدمة</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/jpg,image/png,image/gif,image/svg+xml">
                        <small class="form-text text-muted">الصور المقبولة: JPEG, JPG, PNG, GIF, SVG (حد أقصى 2MB)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ميزات الخدمة</label>
                        <div id="featuresContainer">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="features[]" placeholder="أدخل ميزة">
                                <button type="button" class="btn btn-outline-danger" onclick="removeFeature(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addFeature()">
                            <i class="fas fa-plus me-1"></i> إضافة ميزة
                        </button>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order" class="form-label">ترتيب العرض</label>
                                <input type="number" class="form-control" id="order" name="order" min="0" value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                                    <input type="hidden" name="is_active" value="0">
                                    <label class="form-check-label" for="is_active">
                                        تفعيل الخدمة
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">عنوان SEO</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title">
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">وصف SEO</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        حفظ الخدمة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Simple functions for feature management
function addFeature() {
    const container = document.getElementById('featuresContainer');
    if (!container) return;
    
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="features[]" placeholder="أدخل ميزة">
        <button type="button" class="btn btn-outline-danger" onclick="removeFeature(this)">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(div);
}

function removeFeature(button) {
    if (button && button.parentElement) {
        button.parentElement.remove();
    }
}

// Function to activate all services
function activateAllServices() {
    if (confirm('هل أنت متأكد من تفعيل جميع الخدمات؟')) {
        fetch('/admin/services/activate-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('تم تفعيل جميع الخدمات بنجاح');
                location.reload();
            } else {
                alert('حدث خطأ أثناء تفعيل الخدمات');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تفعيل الخدمات');
        });
    }
}
</script>
@endsection
