@extends('layouts.dashboard')

@section('title', 'تحرير القسم')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>تحرير القسم: {{ $homeSection->name }}</h1>
        <div>
            <a href="{{ route('admin.section-contents.index', $homeSection) }}" class="btn btn-info me-2">
                <i class="fas fa-list"></i> إدارة المحتوى
            </a>
            <a href="{{ route('admin.home-sections.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> العودة
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.home-sections.update', $homeSection) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم القسم *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $homeSection->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">العنوان الرئيسي</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $homeSection->title) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subtitle" class="form-label">العنوان الفرعي</label>
                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror" 
                                   id="subtitle" name="subtitle" value="{{ old('subtitle', $homeSection->subtitle) }}">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $homeSection->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="section_type" class="form-label">نوع القسم *</label>
                                    <select class="form-control @error('section_type') is-invalid @enderror" 
                                            id="section_type" name="section_type" required>
                                        <option value="">اختر نوع القسم</option>
                                        <option value="services" {{ old('section_type', $homeSection->section_type) == 'services' ? 'selected' : '' }}>خدماتنا</option>
                                        <option value="features" {{ old('section_type', $homeSection->section_type) == 'features' ? 'selected' : '' }}>مميزاتنا</option>
                                        <option value="about" {{ old('section_type', $homeSection->section_type) == 'about' ? 'selected' : '' }}>من نحن</option>
                                        <option value="portfolio" {{ old('section_type', $homeSection->section_type) == 'portfolio' ? 'selected' : '' }}>معرض أعمالنا</option>
                                        <option value="testimonials" {{ old('section_type', $homeSection->section_type) == 'testimonials' ? 'selected' : '' }}>آراء العملاء</option>
                                        <option value="contact" {{ old('section_type', $homeSection->section_type) == 'contact' ? 'selected' : '' }}>اتصل بنا</option>
                                        <option value="custom" {{ old('section_type', $homeSection->section_type) == 'custom' ? 'selected' : '' }}>قسم مخصص</option>
                                    </select>
                                    @error('section_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="layout_type" class="form-label">نوع التخطيط *</label>
                                    <select class="form-control @error('layout_type') is-invalid @enderror" 
                                            id="layout_type" name="layout_type" required>
                                        <option value="container" {{ old('layout_type', $homeSection->layout_type) == 'container' ? 'selected' : '' }}>حاوي عادي</option>
                                        <option value="full_width" {{ old('layout_type', $homeSection->layout_type) == 'full_width' ? 'selected' : '' }}>عرض كامل</option>
                                        <option value="grid_2" {{ old('layout_type', $homeSection->layout_type) == 'grid_2' ? 'selected' : '' }}>شبكة 2 أعمدة</option>
                                        <option value="grid_3" {{ old('layout_type', $homeSection->layout_type) == 'grid_3' ? 'selected' : '' }}>شبكة 3 أعمدة</option>
                                        <option value="grid_4" {{ old('layout_type', $homeSection->layout_type) == 'grid_4' ? 'selected' : '' }}>شبكة 4 أعمدة</option>
                                        <option value="carousel" {{ old('layout_type', $homeSection->layout_type) == 'carousel' ? 'selected' : '' }}>عرض دائري</option>
                                    </select>
                                    @error('layout_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="custom_css" class="form-label">CSS مخصص</label>
                            <textarea class="form-control @error('custom_css') is-invalid @enderror" 
                                      id="custom_css" name="custom_css" rows="4" 
                                      placeholder="أضف CSS مخصص هنا...">{{ old('custom_css', $homeSection->custom_css) }}</textarea>
                            @error('custom_css')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="background_image" class="form-label">صورة الخلفية</label>
                            @if($homeSection->background_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $homeSection->background_image) }}" 
                                         alt="{{ $homeSection->name }}" 
                                         class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('background_image') is-invalid @enderror" 
                                   id="background_image" name="background_image" accept="image/*">
                            <small class="form-text text-muted">اتركه فارغاً للاحتفاظ بالصورة الحالية</small>
                            @error('background_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="background_color" class="form-label">لون الخلفية</label>
                                    <input type="color" class="form-control @error('background_color') is-invalid @enderror" 
                                           id="background_color" name="background_color" value="{{ old('background_color', $homeSection->background_color) }}">
                                    @error('background_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="text_color" class="form-label">لون النص</label>
                                    <input type="color" class="form-control @error('text_color') is-invalid @enderror" 
                                           id="text_color" name="text_color" value="{{ old('text_color', $homeSection->text_color) }}">
                                    @error('text_color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" 
                                       name="is_active" value="1" {{ old('is_active', $homeSection->is_active) ? 'checked' : '' }}>
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