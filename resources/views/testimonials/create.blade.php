@extends('layouts.app')

@section('title', 'إضافة شهادة جديدة - مؤسسة اللباس اللامحدود')

@section('styles')
<style>
    .create-testimonial-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
        padding: 120px 0 80px;
    }
    
    .create-testimonial-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="stars" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="10" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="40" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23stars)"/></svg>');
        opacity: 0.3;
    }
    
    .create-testimonial-hero .hero-content {
        position: relative;
        z-index: 2;
        color: white;
    }
    
    .create-testimonial-hero h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }
    
    .create-testimonial-hero .lead {
        font-size: 1.3rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .enhanced-form-card {
        background: white;
        border-radius: 25px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        overflow: hidden;
        position: relative;
    }
    
    .enhanced-form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }
    
    .form-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 2rem;
        text-align: center;
        border-bottom: 1px solid #e9ecef;
    }
    
    .form-title {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
    }
    
    .form-subtitle {
        color: #718096;
        margin: 0.5rem 0 0 0;
    }
    
    .form-body {
        padding: 3rem;
    }
    
    .form-group {
        margin-bottom: 2rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
        display: block;
    }
    
    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
    }
    
    .rating-container {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 1rem;
    }
    
    .rating-option {
        position: relative;
    }
    
    .rating-option input[type="radio"] {
        display: none;
    }
    
    .rating-option label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f8f9fa;
        min-width: 80px;
    }
    
    .rating-option label:hover {
        border-color: #667eea;
        background: white;
        transform: translateY(-2px);
    }
    
    .rating-option input[type="radio"]:checked + label {
        border-color: #667eea;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        transform: translateY(-2px);
    }
    
    .rating-stars {
        display: flex;
        gap: 2px;
    }
    
    .rating-stars i {
        color: #ffc107;
        font-size: 1.2rem;
    }
    
    .rating-option input[type="radio"]:checked + label .rating-stars i {
        color: white;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
        padding: 1rem 3rem;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        color: white;
    }
    
    .btn-submit::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-submit:hover::before {
        left: 100%;
    }
    
    .file-upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .file-upload-area:hover {
        border-color: #667eea;
        background: white;
    }
    
    .file-upload-area.dragover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }
    
    .upload-icon {
        font-size: 3rem;
        color: #667eea;
        margin-bottom: 1rem;
    }
    
    .back-button {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
        padding: 0.75rem 2rem;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    
    .back-button:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .create-testimonial-hero h1 {
            font-size: 2.5rem;
        }
        
        .form-body {
            padding: 2rem 1.5rem;
        }
        
        .rating-container {
            flex-wrap: wrap;
        }
    }
</style>
@endsection

@section('content')
<!-- Enhanced Hero Section -->
<section class="create-testimonial-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hero-content text-center">
                    <h1 data-aos="fade-up">أضف شهادتك</h1>
                    <p class="lead" data-aos="fade-up" data-aos-delay="200">شاركنا تجربتك مع منتجاتنا وخدماتنا</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Form Section -->
<section class="py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="enhanced-form-card" data-aos="fade-up">
                    <div class="form-header">
                        <h2 class="form-title">نموذج إضافة شهادة</h2>
                        <p class="form-subtitle">شاركنا تجربتك مع منتجاتنا وخدماتنا</p>
                    </div>
                    
                    <div class="form-body">
                        @if ($errors->any())
                            <div class="alert alert-danger" style="border-radius: 12px; border: none; background: #fee2e2; color: #dc2626;">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data" id="testimonialForm">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="client_name" class="form-label">
                                            <i class="fas fa-user me-2"></i>الاسم الكامل <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="client_name" name="client_name" value="{{ old('client_name') }}" required placeholder="أدخل اسمك الكامل">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="client_position" class="form-label">
                                            <i class="fas fa-briefcase me-2"></i>المسمى الوظيفي <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="client_position" name="client_position" value="{{ old('client_position') }}" required placeholder="مثال: مدير التسويق">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="client_company" class="form-label">
                                    <i class="fas fa-building me-2"></i>اسم الشركة أو المؤسسة <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="client_company" name="client_company" value="{{ old('client_company') }}" required placeholder="أدخل اسم الشركة أو المؤسسة">
                            </div>
                            
                            <div class="form-group">
                                <label for="content" class="form-label">
                                    <i class="fas fa-comment me-2"></i>نص الشهادة <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="content" name="content" rows="5" required placeholder="اكتب تجربتك مع منتجاتنا أو خدماتنا...">{{ old('content') }}</textarea>
                                <small class="text-muted">يرجى كتابة تجربتك مع منتجاتنا أو خدماتنا (10 أحرف على الأقل)</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-camera me-2"></i>صورة شخصية (اختياري)
                                </label>
                                <div class="file-upload-area" id="fileUploadArea">
                                    <div class="upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <h5>اسحب وأفلت الصورة هنا</h5>
                                    <p class="text-muted">أو انقر للاختيار</p>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" style="display: none;">
                                    <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('image').click()">
                                        <i class="fas fa-plus me-2"></i>اختيار صورة
                                    </button>
                                </div>
                                <small class="text-muted">الصيغ المسموحة: JPG, PNG, GIF (الحد الأقصى: 2MB)</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-star me-2"></i>التقييم <span class="text-danger">*</span>
                                </label>
                                <div class="rating-container">
                                    @for($i = 5; $i >= 1; $i--)
                                        <div class="rating-option">
                                            <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" {{ old('rating', 5) == $i ? 'checked' : '' }}>
                                            <label for="rating{{ $i }}">
                                                <div class="rating-stars">
                                                    @for($j = 1; $j <= $i; $j++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor
                                                </div>
                                                <span>{{ $i }}</span>
                                            </label>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-paper-plane me-2"></i>إرسال الشهادة
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('testimonials.index') }}" class="back-button">
                        <i class="fas fa-arrow-left me-2"></i>العودة إلى التقييمات
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Initialize AOS animations
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
    
    // File upload area functionality
    const fileUploadArea = document.getElementById('fileUploadArea');
    const fileInput = document.getElementById('image');
    
    fileUploadArea.addEventListener('click', () => {
        fileInput.click();
    });
    
    fileUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileUploadArea.classList.add('dragover');
    });
    
    fileUploadArea.addEventListener('dragleave', () => {
        fileUploadArea.classList.remove('dragover');
    });
    
    fileUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        fileUploadArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            updateFileDisplay(files[0]);
        }
    });
    
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            updateFileDisplay(e.target.files[0]);
        }
    });
    
    function updateFileDisplay(file) {
        const uploadIcon = fileUploadArea.querySelector('.upload-icon i');
        const title = fileUploadArea.querySelector('h5');
        const subtitle = fileUploadArea.querySelector('p');
        
        uploadIcon.className = 'fas fa-check-circle';
        uploadIcon.style.color = '#38a169';
        title.textContent = file.name;
        subtitle.textContent = `حجم الملف: ${(file.size / 1024 / 1024).toFixed(2)} MB`;
    }
    
    // Form validation
    document.getElementById('testimonialForm').addEventListener('submit', function(e) {
        const content = document.getElementById('content').value.trim();
        if (content.length < 10) {
            e.preventDefault();
            alert('يرجى كتابة نص الشهادة (10 أحرف على الأقل)');
            return false;
        }
    });
</script>
@endsection