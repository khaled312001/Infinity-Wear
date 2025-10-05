@extends('layouts.dashboard')

@section('title', 'إضافة تقييم جديد')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'إضافة تقييم جديد')
@section('page-subtitle', 'إضافة تقييم جديد من العميل')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('page-actions')
    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        العودة للقائمة
    </a>
@endsection

@section('content')
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-plus me-2 text-primary"></i>
                إضافة تقييم جديد
            </h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="client_name" class="form-label">اسم العميل *</label>
                            <input type="text" class="form-control @error('client_name') is-invalid @enderror" 
                                   id="client_name" name="client_name" value="{{ old('client_name') }}" required>
                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_position" class="form-label">المنصب *</label>
                                    <input type="text" class="form-control @error('client_position') is-invalid @enderror" 
                                           id="client_position" name="client_position" value="{{ old('client_position') }}" required>
                                    @error('client_position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_company" class="form-label">الشركة *</label>
                                    <input type="text" class="form-control @error('client_company') is-invalid @enderror" 
                                           id="client_company" name="client_company" value="{{ old('client_company') }}" required>
                                    @error('client_company')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">محتوى التقييم *</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="4" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">صورة العميل</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*" onchange="validateImage(this)">
                            <small class="form-text text-muted">الحد الأقصى 2 ميجابايت (اختياري)</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">التقييم *</label>
                            <select class="form-control @error('rating') is-invalid @enderror" 
                                    id="rating" name="rating" required>
                                <option value="">اختر التقييم</option>
                                <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>⭐ (1)</option>
                                <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>⭐⭐ (2)</option>
                                <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3)</option>
                                <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4)</option>
                                <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5)</option>
                            </select>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">ترتيب العرض</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}">
                            <small class="form-text text-muted">رقم الترتيب (اختياري)</small>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" 
                                       name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    شهادة نشطة
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        حفظ التقييم
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function validateImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        
        if (!validTypes.includes(file.type)) {
            alert('يرجى اختيار ملف صورة صالح (JPEG, PNG, JPG, GIF)');
            input.value = '';
            return false;
        }
        
        if (file.size > 2048 * 1024) { // 2MB
            alert('حجم الملف كبير جداً. الحد الأقصى 2 ميجابايت');
            input.value = '';
            return false;
        }
    }
    return true;
}

// Debug form submission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const imageInput = document.getElementById('image');
            console.log('Image file:', imageInput.files[0]);
            console.log('Has file:', imageInput.files.length > 0);
        });
    }
});
</script>
@endpush
