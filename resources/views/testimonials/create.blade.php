@extends('layouts.app')

@section('title', 'إضافة شهادة جديدة - مؤسسة اللباس اللامحدود')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hero-content text-center">
                    <h1>أضف شهادتك</h1>
                    <p class="lead">شاركنا تجربتك مع منتجاتنا وخدماتنا</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonial Form Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card glass-effect hover-lift">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-4 text-center">نموذج إضافة شهادة</h4>
                        
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="client_name" class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="client_name" name="client_name" value="{{ old('client_name') }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="client_position" class="form-label">المسمى الوظيفي <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="client_position" name="client_position" value="{{ old('client_position') }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="client_company" class="form-label">اسم الشركة أو المؤسسة <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="client_company" name="client_company" value="{{ old('client_company') }}" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="content" class="form-label">نص الشهادة <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
                                <small class="text-muted">يرجى كتابة تجربتك مع منتجاتنا أو خدماتنا (10 أحرف على الأقل)</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">صورة شخصية (اختياري)</label>
                                <input type="file" class="form-control" id="image" name="image">
                                <small class="text-muted">الصيغ المسموحة: JPG, PNG, GIF (الحد الأقصى: 2MB)</small>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">التقييم <span class="text-danger">*</span></label>
                                <div class="rating-input d-flex">
                                    @for($i = 5; $i >= 1; $i--)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" {{ old('rating', 5) == $i ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rating{{ $i }}">
                                                {{ $i }} <i class="fas fa-star text-warning"></i>
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>إرسال الشهادة
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('testimonials.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>العودة إلى التقييمات
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection