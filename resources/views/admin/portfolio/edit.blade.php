@extends('layouts.dashboard')

@section('title', 'تحرير العمل: ' . $portfolioItem->title)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>تحرير العمل: {{ $portfolioItem->title }}</h1>
        <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> العودة
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.portfolio.update', $portfolioItem->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">العنوان *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $portfolioItem->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $portfolioItem->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="client_name" class="form-label">اسم العميل *</label>
                                    <input type="text" class="form-control @error('client_name') is-invalid @enderror" 
                                           id="client_name" name="client_name" value="{{ old('client_name', $portfolioItem->client_name) }}" required>
                                    @error('client_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="completion_date" class="form-label">تاريخ الإنجاز *</label>
                                    <input type="date" class="form-control @error('completion_date') is-invalid @enderror" 
                                           id="completion_date" name="completion_date" value="{{ old('completion_date', $portfolioItem->completion_date ? $portfolioItem->completion_date->format('Y-m-d') : '') }}" required>
                                    @error('completion_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">الفئة *</label>
                            <select class="form-control @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">اختر الفئة</option>
                                <option value="ملابس رياضية" {{ old('category', $portfolioItem->category) == 'ملابس رياضية' ? 'selected' : '' }}>ملابس رياضية</option>
                                <option value="ملابس مدرسية" {{ old('category', $portfolioItem->category) == 'ملابس مدرسية' ? 'selected' : '' }}>ملابس مدرسية</option>
                                <option value="ملابس طبية" {{ old('category', $portfolioItem->category) == 'ملابس طبية' ? 'selected' : '' }}>ملابس طبية</option>
                                <option value="ملابس شركات" {{ old('category', $portfolioItem->category) == 'ملابس شركات' ? 'selected' : '' }}>ملابس شركات</option>
                                <option value="أزياء موحدة" {{ old('category', $portfolioItem->category) == 'أزياء موحدة' ? 'selected' : '' }}>أزياء موحدة</option>
                                <option value="أخرى" {{ old('category', $portfolioItem->category) == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">الصورة الرئيسية</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*" onchange="validateImage(this)">
                            @if($portfolioItem->image)
                                <div class="mt-2">
                                    <small class="text-muted">الصورة الحالية:</small><br>
                                    <img src="{{ asset('storage/' . $portfolioItem->image) }}" alt="Current image" 
                                         class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                </div>
                            @endif
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gallery" class="form-label">معرض الصور</label>
                            <input type="file" class="form-control @error('gallery.*') is-invalid @enderror" 
                                   id="gallery" name="gallery[]" accept="image/*" multiple onchange="validateGallery(this)">
                            <small class="form-text text-muted">يمكنك اختيار عدة صور</small>
                            @error('gallery.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($portfolioItem->gallery && count($portfolioItem->gallery) > 0)
                            <div class="mb-3">
                                <label class="form-label">الصور الحالية في المعرض</label>
                                <div class="row">
                                    @foreach($portfolioItem->gallery as $index => $galleryImage)
                                        <div class="col-6 mb-2">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $galleryImage) }}" alt="Gallery image" 
                                                     class="img-thumbnail" style="width: 100%; height: 80px; object-fit: cover;">
                                                <div class="form-check position-absolute" style="top: 5px; right: 5px;">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="delete_gallery[]" value="{{ $index }}" 
                                                           id="delete_gallery_{{ $index }}">
                                                    <label class="form-check-label text-white" for="delete_gallery_{{ $index }}" 
                                                           style="text-shadow: 1px 1px 2px rgba(0,0,0,0.8);">
                                                        <i class="fas fa-trash"></i>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-muted">حدد الصور التي تريد حذفها</small>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">الترتيب</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $portfolioItem->sort_order) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" 
                                       name="is_featured" value="1" {{ old('is_featured', $portfolioItem->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    عمل مميز
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

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

function validateGallery(input) {
    if (input.files && input.files.length > 0) {
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        
        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            
            if (!validTypes.includes(file.type)) {
                alert('يرجى اختيار ملفات صورة صالحة (JPEG, PNG, JPG, GIF)');
                input.value = '';
                return false;
            }
            
            if (file.size > 2048 * 1024) { // 2MB
                alert('حجم الملف كبير جداً. الحد الأقصى 2 ميجابايت');
                input.value = '';
                return false;
            }
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