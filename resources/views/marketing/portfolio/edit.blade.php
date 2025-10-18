@extends('layouts.marketing-dashboard')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'تعديل المشروع - فريق التسويق')
@section('dashboard-title', 'تعديل المشروع')
@section('page-title', 'تعديل المشروع')
@section('page-subtitle', 'تعديل مشروع في معرض الأعمال')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    تعديل المشروع: {{ $portfolioItem->title }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('marketing.portfolio.update', $portfolioItem) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">عنوان المشروع *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $portfolioItem->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="client_name" class="form-label">اسم العميل *</label>
                            <input type="text" class="form-control @error('client_name') is-invalid @enderror" 
                                   id="client_name" name="client_name" value="{{ old('client_name', $portfolioItem->client_name) }}" required>
                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">الفئة *</label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">اختر الفئة</option>
                                <option value="football" {{ old('category', $portfolioItem->category) == 'football' ? 'selected' : '' }}>كرة قدم</option>
                                <option value="basketball" {{ old('category', $portfolioItem->category) == 'basketball' ? 'selected' : '' }}>كرة سلة</option>
                                <option value="school" {{ old('category', $portfolioItem->category) == 'school' ? 'selected' : '' }}>مدرسة</option>
                                <option value="company" {{ old('category', $portfolioItem->category) == 'company' ? 'selected' : '' }}>شركة</option>
                                <option value="other" {{ old('category', $portfolioItem->category) == 'other' ? 'selected' : '' }}>أخرى</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="completion_date" class="form-label">تاريخ الإنجاز *</label>
                            <input type="date" class="form-control @error('completion_date') is-invalid @enderror" 
                                   id="completion_date" name="completion_date" value="{{ old('completion_date', $portfolioItem->completion_date) }}" required>
                            @error('completion_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">وصف المشروع *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required>{{ old('description', $portfolioItem->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    @if($portfolioItem->image)
                    <div class="mb-3">
                        <label class="form-label">الصورة الحالية</label>
                        <div>
                            <img src="{{ $portfolioItem->image_url }}" alt="{{ $portfolioItem->title }}" 
                                 class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">صورة المشروع الرئيسية</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <div class="form-text">اتركه فارغاً للاحتفاظ بالصورة الحالية</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="gallery" class="form-label">معرض الصور</label>
                        <input type="file" class="form-control @error('gallery') is-invalid @enderror" 
                               id="gallery" name="gallery[]" accept="image/*" multiple>
                        <div class="form-text">يمكنك اختيار عدة صور للمعرض</div>
                        @error('gallery')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   {{ old('is_featured', $portfolioItem->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                مشروع مميز
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('marketing.portfolio') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            إلغاء
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
