@extends('layouts.dashboard')

@section('title', 'تعديل المحتوى')
@section('dashboard-title', 'إدارة المحتوى')
@section('page-title', 'تعديل المحتوى')
@section('page-subtitle', 'تعديل المحتوى الموجود')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2 text-primary"></i>
                    تعديل المحتوى
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.content-management.update', $contentManagement) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- معلومات أساسية -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-info-circle me-2 text-primary"></i>
                                        المعلومات الأساسية
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="page_name" class="form-label">الصفحة <span class="text-danger">*</span></label>
                                        <select class="form-select @error('page_name') is-invalid @enderror" id="page_name" name="page_name" required>
                                            <option value="">اختر الصفحة</option>
                                            @foreach($pages as $key => $value)
                                                <option value="{{ $key }}" {{ (old('page_name', $contentManagement->page_name) == $key) ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('page_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="section_name" class="form-label">القسم <span class="text-danger">*</span></label>
                                        <select class="form-select @error('section_name') is-invalid @enderror" id="section_name" name="section_name" required>
                                            <option value="">اختر القسم</option>
                                            @foreach($sections as $key => $value)
                                                <option value="{{ $key }}" {{ (old('section_name', $contentManagement->section_name) == $key) ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('section_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="content_type" class="form-label">نوع المحتوى <span class="text-danger">*</span></label>
                                        <select class="form-select @error('content_type') is-invalid @enderror" id="content_type" name="content_type" required>
                                            <option value="">اختر نوع المحتوى</option>
                                            @foreach($contentTypes as $key => $value)
                                                <option value="{{ $key }}" {{ (old('content_type', $contentManagement->content_type) == $key) ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        @error('content_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="sort_order" class="form-label">ترتيب العرض</label>
                                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                               id="sort_order" name="sort_order" value="{{ old('sort_order', $contentManagement->sort_order) }}" min="0">
                                        @error('sort_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $contentManagement->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    نشط
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $contentManagement->is_featured) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_featured">
                                                    مميز
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- المحتوى -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-edit me-2 text-primary"></i>
                                        المحتوى
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="title_ar" class="form-label">العنوان (عربي)</label>
                                        <input type="text" class="form-control @error('title_ar') is-invalid @enderror" 
                                               id="title_ar" name="title_ar" value="{{ old('title_ar', $contentManagement->title_ar) }}">
                                        @error('title_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="title_en" class="form-label">العنوان (إنجليزي)</label>
                                        <input type="text" class="form-control @error('title_en') is-invalid @enderror" 
                                               id="title_en" name="title_en" value="{{ old('title_en', $contentManagement->title_en) }}">
                                        @error('title_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description_ar" class="form-label">الوصف (عربي)</label>
                                        <textarea class="form-control @error('description_ar') is-invalid @enderror" 
                                                  id="description_ar" name="description_ar" rows="3">{{ old('description_ar', $contentManagement->description_ar) }}</textarea>
                                        @error('description_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description_en" class="form-label">الوصف (إنجليزي)</label>
                                        <textarea class="form-control @error('description_en') is-invalid @enderror" 
                                                  id="description_en" name="description_en" rows="3">{{ old('description_en', $contentManagement->description_en) }}</textarea>
                                        @error('description_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="content_ar" class="form-label">المحتوى (عربي)</label>
                                        <textarea class="form-control @error('content_ar') is-invalid @enderror" 
                                                  id="content_ar" name="content_ar" rows="4">{{ old('content_ar', $contentManagement->content_ar) }}</textarea>
                                        @error('content_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="content_en" class="form-label">المحتوى (إنجليزي)</label>
                                        <textarea class="form-control @error('content_en') is-invalid @enderror" 
                                                  id="content_en" name="content_en" rows="4">{{ old('content_en', $contentManagement->content_en) }}</textarea>
                                        @error('content_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الوسائط -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-images me-2 text-primary"></i>
                                        الوسائط
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <!-- الصورة الحالية -->
                                    @if($contentManagement->image_path)
                                        <div class="mb-3">
                                            <label class="form-label">الصورة الحالية</label>
                                            <div>
                                                <img src="{{ asset('storage/' . $contentManagement->image_path) }}" 
                                                     alt="{{ $contentManagement->title_ar ?: $contentManagement->title_en }}" 
                                                     class="img-fluid rounded" style="max-height: 200px;">
                                            </div>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="image" class="form-label">تغيير الصورة الرئيسية</label>
                                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                                       id="image" name="image" accept="image/*">
                                                @error('image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="gallery_images" class="form-label">تغيير معرض الصور</label>
                                                <input type="file" class="form-control @error('gallery_images.*') is-invalid @enderror" 
                                                       id="gallery_images" name="gallery_images[]" accept="image/*" multiple>
                                                @error('gallery_images.*')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="video_url" class="form-label">رابط الفيديو</label>
                                                <input type="url" class="form-control @error('video_url') is-invalid @enderror" 
                                                       id="video_url" name="video_url" value="{{ old('video_url', $contentManagement->video_url) }}" 
                                                       placeholder="https://youtube.com/watch?v=...">
                                                @error('video_url')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- معرض الصور الحالي -->
                                    @if($contentManagement->gallery_images && count($contentManagement->gallery_images) > 0)
                                        <div class="mb-3">
                                            <label class="form-label">معرض الصور الحالي</label>
                                            <div class="row">
                                                @foreach($contentManagement->gallery_images as $image)
                                                    <div class="col-md-3 mb-2">
                                                        <img src="{{ asset('storage/' . $image) }}" 
                                                             alt="Gallery Image" 
                                                             class="img-fluid rounded" style="max-height: 100px;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الأزرار -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-mouse-pointer me-2 text-primary"></i>
                                        الأزرار
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="button_text_ar" class="form-label">نص الزر (عربي)</label>
                                                <input type="text" class="form-control @error('button_text_ar') is-invalid @enderror" 
                                                       id="button_text_ar" name="button_text_ar" value="{{ old('button_text_ar', $contentManagement->button_text_ar) }}">
                                                @error('button_text_ar')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="button_text_en" class="form-label">نص الزر (إنجليزي)</label>
                                                <input type="text" class="form-control @error('button_text_en') is-invalid @enderror" 
                                                       id="button_text_en" name="button_text_en" value="{{ old('button_text_en', $contentManagement->button_text_en) }}">
                                                @error('button_text_en')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="button_url" class="form-label">رابط الزر</label>
                                                <input type="url" class="form-control @error('button_url') is-invalid @enderror" 
                                                       id="button_url" name="button_url" value="{{ old('button_url', $contentManagement->button_url) }}">
                                                @error('button_url')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- أزرار التحكم -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.content-management.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            رجوع
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show/hide fields based on content type
    const contentTypeSelect = document.getElementById('content_type');
    const imageField = document.getElementById('image').closest('.mb-3');
    const galleryField = document.getElementById('gallery_images').closest('.mb-3');
    const videoField = document.getElementById('video_url').closest('.mb-3');
    
    function toggleFields() {
        const contentType = contentTypeSelect.value;
        
        // Hide all media fields initially
        imageField.style.display = 'none';
        galleryField.style.display = 'none';
        videoField.style.display = 'none';
        
        // Show relevant fields based on content type
        switch(contentType) {
            case 'image':
                imageField.style.display = 'block';
                break;
            case 'gallery':
                galleryField.style.display = 'block';
                break;
            case 'video':
                videoField.style.display = 'block';
                break;
            case 'mixed':
                imageField.style.display = 'block';
                galleryField.style.display = 'block';
                videoField.style.display = 'block';
                break;
        }
    }
    
    contentTypeSelect.addEventListener('change', toggleFields);
    toggleFields(); // Initial call
});
</script>
@endpush
