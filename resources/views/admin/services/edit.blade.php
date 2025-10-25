@extends('layouts.dashboard')

@section('title', 'تعديل الخدمة')
@section('page-title', 'تعديل الخدمة')
@section('page-subtitle', 'تعديل بيانات الخدمة')


@section('content')
<script>
// Define functions immediately to ensure they're available
window.addFeature = function() {
    const container = document.getElementById('featuresContainer');
    if (!container) return;
    
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="features[]" placeholder="أدخل ميزة">
        <button type="button" class="btn btn-outline-danger" data-action="remove-feature">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(div);
};

window.removeFeature = function(button) {
    if (button && button.parentElement) {
        button.parentElement.remove();
    }
};

// Also define as regular functions for backward compatibility
function addFeature() {
    window.addFeature();
}

function removeFeature(button) {
    window.removeFeature(button);
}

console.log('Feature functions defined at page start');

// Add event delegation for dynamic buttons
document.addEventListener('click', function(e) {
    if (e.target.closest('button[data-action="remove-feature"]')) {
        e.preventDefault();
        const button = e.target.closest('button[data-action="remove-feature"]');
        removeFeature(button);
    }
    
    if (e.target.closest('button[data-action="add-feature"]')) {
        e.preventDefault();
        addFeature();
    }
    
    // Fallback for onclick attributes
    if (e.target.closest('button[onclick*="removeFeature"]')) {
        e.preventDefault();
        const button = e.target.closest('button[onclick*="removeFeature"]');
        removeFeature(button);
    }
    
    if (e.target.closest('button[onclick*="addFeature"]')) {
        e.preventDefault();
        addFeature();
    }
});
</script>

<div class="row">
    <div class="col-12">
        <div class="card dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    تعديل الخدمة: {{ $service->title }}
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
                <form method="POST" action="{{ route('admin.services.update', $service->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">عنوان الخدمة <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $service->title) }}" required>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="icon" class="form-label">الأيقونة</label>
                                <input type="text" class="form-control" id="icon" name="icon" 
                                       value="{{ old('icon', $service->icon) }}"
                                       placeholder="مثال: fas fa-tshirt">
                                <small class="form-text text-muted">استخدم Font Awesome icons</small>
                                @error('icon')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">وصف الخدمة <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">صورة الخدمة</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/jpg,image/png,image/gif,image/svg+xml">
                        <small class="form-text text-muted">اترك فارغاً للاحتفاظ بالصورة الحالية. الصور المقبولة: JPEG, JPG, PNG, GIF, SVG (حد أقصى 2MB)</small>
                        @if($service->image)
                            <div class="mt-2">
                                <small class="text-muted">الصورة الحالية:</small><br>
                                <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                        @endif
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ميزات الخدمة</label>
                        <div id="featuresContainer">
                            @if($service->features && count($service->features) > 0)
                                @foreach($service->features as $feature)
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="features[]" value="{{ $feature }}">
                                        <button type="button" class="btn btn-outline-danger" data-action="remove-feature" onclick="if(typeof removeFeature === 'function') removeFeature(this); else console.error('removeFeature not defined');">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="features[]" placeholder="أدخل ميزة">
                                    <button type="button" class="btn btn-outline-danger" data-action="remove-feature" onclick="if(typeof removeFeature === 'function') removeFeature(this); else console.error('removeFeature not defined');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-action="add-feature" id="addFeatureBtn" onclick="if(typeof addFeature === 'function') addFeature(); else console.error('addFeature not defined');">
                            <i class="fas fa-plus me-1"></i> إضافة ميزة
                        </button>
                        @error('features')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order" class="form-label">ترتيب العرض</label>
                                <input type="number" class="form-control" id="order" name="order" min="0" value="{{ old('order', $service->order) }}">
                                @error('order')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                           {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                                    <input type="hidden" name="is_active" value="0">
                                    <label class="form-check-label" for="is_active">
                                        تفعيل الخدمة
                                    </label>
                                    <small class="form-text text-muted">الخدمة ستكون مفعلة تلقائياً عند الحفظ</small>
                                </div>
                                @error('is_active')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">عنوان SEO</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title', $service->meta_title) }}">
                        @error('meta_title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">وصف SEO</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $service->meta_description) }}</textarea>
                        @error('meta_description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            حفظ التغييرات
                        </button>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            العودة للقائمة
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Ensure functions are available globally
window.addFeature = function() {
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
};

window.removeFeature = function(button) {
    if (button && button.parentElement) {
        button.parentElement.remove();
    }
};

// Also define as regular functions for backward compatibility
function addFeature() {
    window.addFeature();
}

function removeFeature(button) {
    window.removeFeature(button);
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Services edit page loaded');
    console.log('addFeature function available:', typeof window.addFeature);
    console.log('removeFeature function available:', typeof window.removeFeature);
    
    // Ensure all remove buttons work
    const removeButtons = document.querySelectorAll('button[onclick*="removeFeature"]');
    removeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            removeFeature(this);
        });
    });
    
    // Ensure add button works
    const addButton = document.getElementById('addFeatureBtn');
    if (addButton) {
        addButton.addEventListener('click', function(e) {
            e.preventDefault();
            addFeature();
        });
    }
});
</script>
@endsection
