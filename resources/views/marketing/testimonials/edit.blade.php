@extends('layouts.marketing-dashboard')

@section('title', 'تعديل التقييم - فريق التسويق')
@section('dashboard-title', 'تعديل التقييم')
@section('page-title', 'تعديل التقييم')
@section('page-subtitle', 'تعديل تقييم العميل')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    تعديل التقييم: {{ $testimonial->client_name }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('marketing.testimonials.update', $testimonial) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="client_name" class="form-label">اسم العميل *</label>
                            <input type="text" class="form-control @error('client_name') is-invalid @enderror" 
                                   id="client_name" name="client_name" value="{{ old('client_name', $testimonial->client_name) }}" required>
                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="client_title" class="form-label">منصب العميل *</label>
                            <input type="text" class="form-control @error('client_title') is-invalid @enderror" 
                                   id="client_title" name="client_title" value="{{ old('client_title', $testimonial->client_title) }}" required>
                            @error('client_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">نص التقييم *</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="4" required>{{ old('content', $testimonial->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="rating" class="form-label">التقييم *</label>
                        <select class="form-select @error('rating') is-invalid @enderror" 
                                id="rating" name="rating" required>
                            <option value="">اختر التقييم</option>
                            <option value="1" {{ old('rating', $testimonial->rating) == '1' ? 'selected' : '' }}>⭐ (1 نجمة)</option>
                            <option value="2" {{ old('rating', $testimonial->rating) == '2' ? 'selected' : '' }}>⭐⭐ (2 نجمة)</option>
                            <option value="3" {{ old('rating', $testimonial->rating) == '3' ? 'selected' : '' }}>⭐⭐⭐ (3 نجمة)</option>
                            <option value="4" {{ old('rating', $testimonial->rating) == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4 نجمة)</option>
                            <option value="5" {{ old('rating', $testimonial->rating) == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 نجمة)</option>
                        </select>
                        @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                تقييم مميز
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('marketing.testimonials') }}" class="btn btn-secondary">
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
