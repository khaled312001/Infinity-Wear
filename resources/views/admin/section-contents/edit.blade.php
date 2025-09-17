@extends('layouts.dashboard')

@section('title', 'تحرير محتوى القسم: ' . $sectionContent->title)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>تحرير المحتوى: {{ $sectionContent->title }}</h1>
        <a href="{{ route('admin.home-sections.section-contents.index', $sectionContent->homeSection) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> العودة
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>قسم: {{ $sectionContent->homeSection->name }} ({{ $sectionContent->homeSection->section_type }})</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.section-contents.update', $sectionContent) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="content_type" class="form-label">نوع المحتوى *</label>
                            <select class="form-control @error('content_type') is-invalid @enderror" 
                                    id="content_type" name="content_type" required>
                                <option value="">اختر نوع المحتوى</option>
                                <option value="text" {{ old('content_type', $sectionContent->content_type) == 'text' ? 'selected' : '' }}>نص</option>
                                <option value="image" {{ old('content_type', $sectionContent->content_type) == 'image' ? 'selected' : '' }}>صورة</option>
                                <option value="video" {{ old('content_type', $sectionContent->content_type) == 'video' ? 'selected' : '' }}>فيديو</option>
                                <option value="icon" {{ old('content_type', $sectionContent->content_type) == 'icon' ? 'selected' : '' }}>أيقونة</option>
                                <option value="button" {{ old('content_type', $sectionContent->content_type) == 'button' ? 'selected' : '' }}>زر</option>
                                <option value="card" {{ old('content_type', $sectionContent->content_type) == 'card' ? 'selected' : '' }}>بطاقة</option>
                                <option value="testimonial" {{ old('content_type', $sectionContent->content_type) == 'testimonial' ? 'selected' : '' }}>شهادة</option>
                            </select>
                            @error('content_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">العنوان *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $sectionContent->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subtitle" class="form-label">العنوان الفرعي</label>
                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror" 
                                   id="subtitle" name="subtitle" value="{{ old('subtitle', $sectionContent->subtitle) }}">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $sectionContent->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_text" class="form-label">نص الزر</label>
                                    <input type="text" class="form-control @error('button_text') is-invalid @enderror" 
                                           id="button_text" name="button_text" value="{{ old('button_text', $sectionContent->button_text) }}">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_link" class="form-label">رابط الزر</label>
                                    <input type="url" class="form-control @error('button_link') is-invalid @enderror" 
                                           id="button_link" name="button_link" value="{{ old('button_link', $sectionContent->button_link) }}">
                                    @error('button_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="button_style" class="form-label">نمط الزر</label>
                            <select class="form-control @error('button_style') is-invalid @enderror" 
                                    id="button_style" name="button_style">
                                <option value="primary" {{ old('button_style', $sectionContent->button_style) == 'primary' ? 'selected' : '' }}>أساسي</option>
                                <option value="secondary" {{ old('button_style', $sectionContent->button_style) == 'secondary' ? 'selected' : '' }}>ثانوي</option>
                                <option value="outline" {{ old('button_style', $sectionContent->button_style) == 'outline' ? 'selected' : '' }}>مفرغ</option>
                                <option value="link" {{ old('button_style', $sectionContent->button_style) == 'link' ? 'selected' : '' }}>رابط</option>
                            </select>
                            @error('button_style')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="video_url" class="form-label">رابط الفيديو</label>
                            <input type="url" class="form-control @error('video_url') is-invalid @enderror" 
                                   id="video_url" name="video_url" value="{{ old('video_url', $sectionContent->video_url) }}">
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">الصورة</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @if($sectionContent->image)
                                <div class="mt-2">
                                    <small class="text-muted">الصورة الحالية:</small><br>
                                    <img src="{{ asset('storage/' . $sectionContent->image) }}" alt="Current image" 
                                         class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                </div>
                            @endif
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="icon_class" class="form-label">الأيقونة (Font Awesome)</label>
                            <input type="text" class="form-control @error('icon_class') is-invalid @enderror" 
                                   id="icon_class" name="icon_class" value="{{ old('icon_class', $sectionContent->icon_class) }}" 
                                   placeholder="fa-star">
                            <small class="form-text text-muted">مثل: fa-star أو fa-home</small>
                            @error('icon_class')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">الترتيب</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $sectionContent->sort_order) }}">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" 
                                       name="is_active" value="1" {{ old('is_active', $sectionContent->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    نشط
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