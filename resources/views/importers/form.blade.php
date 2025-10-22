@extends('layouts.app')

@section('title', 'أطلب الآن - Infinity Wear')

@push('styles')
<link href="{{ asset('css/multi-step-form.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/multi-step-form.js') }}"></script>
@endpush

<style>
/* Multi-step Form Styles - Inline for immediate loading */
.form-step {
    display: none !important;
    opacity: 0;
    visibility: hidden;
}

.form-step.active {
    display: block !important;
    opacity: 1;
    visibility: visible;
}

.form-step:not(.active) {
    display: none !important;
    opacity: 0 !important;
    visibility: hidden !important;
    height: 0 !important;
    overflow: hidden !important;
    margin: 0 !important;
    padding: 0 !important;
}

.step-item.active .step-circle {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #667eea;
    transform: scale(1.15);
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
}

.step-1 {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
    border-color: #667eea !important;
}

.step-2 {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    color: white !important;
    border-color: #28a745 !important;
}

.step-3 {
    background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%) !important;
    color: white !important;
    border-color: #17a2b8 !important;
}

.step-4 {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
    color: white !important;
    border-color: #ffc107 !important;
}
</style>

<script>
// Multi-step Form JavaScript - Inline for immediate loading
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 4;
    
    // Elements
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    
    // Business type change handler
    const businessTypeSelect = document.getElementById('business_type');
    const otherBusinessTypeDiv = document.getElementById('other_business_type_div');
    
    if (businessTypeSelect) {
        businessTypeSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                otherBusinessTypeDiv.style.display = 'block';
                otherBusinessTypeDiv.querySelector('input').required = true;
            } else {
                otherBusinessTypeDiv.style.display = 'none';
                otherBusinessTypeDiv.querySelector('input').required = false;
            }
        });
    }
    
    // Design option change handler
    const designOptions = document.querySelectorAll('.design-option');
    const designDetails = document.querySelectorAll('.design-detail');
    
    designOptions.forEach(option => {
        option.addEventListener('change', function() {
            const selectedOption = this.value;
            
            // Hide all design details
            designDetails.forEach(detail => {
                detail.style.display = 'none';
            });
            
            // Show selected design detail
            const selectedDetail = document.getElementById(`design_${selectedOption}_detail`);
            if (selectedDetail) {
                selectedDetail.style.display = 'block';
            }
        });
    });
    
    // Password toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }
    
    // Navigation functions
    function showStep(step) {
        // Hide all steps first
        document.querySelectorAll('.form-step').forEach((stepElement) => {
            stepElement.classList.remove('active');
            stepElement.style.display = 'none';
        });
        
        // Show current step
        const currentStepElement = document.getElementById(`step${step}`);
        if (currentStepElement) {
            currentStepElement.classList.add('active');
            currentStepElement.style.display = 'block';
        }
        
        // Update step indicators
        document.querySelectorAll('.step-item').forEach((item, index) => {
            item.classList.toggle('active', index + 1 === step);
            item.classList.toggle('completed', index + 1 < step);
        });
        
        // Update navigation buttons
        prevBtn.style.display = step === 1 ? 'none' : 'inline-block';
        nextBtn.style.display = step === totalSteps ? 'none' : 'inline-block';
        submitBtn.style.display = step === totalSteps ? 'inline-block' : 'none';
    }
    
    function nextStep() {
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    }
    
    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    }
    
    // Event listeners
    if (nextBtn) nextBtn.addEventListener('click', nextStep);
    if (prevBtn) prevBtn.addEventListener('click', prevStep);
    
    // Initialize
    showStep(currentStep);
});
</script>

@section('content')
<!-- قسم العنوان الرئيسي -->
<section class="hero-section hero-inner-section bg-light py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-end">
                <h1 class="display-4 fw-bold mb-3">أطلب الآن</h1>
                <p class="lead mb-4">اطلب ملابسك المخصصة واستفد من خدماتنا المميزة في توريد الملابس بالجملة</p>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/importer-register.svg') }}" alt="أطلب الآن" class="img-fluid" style="max-height: 300px;">
            </div>
        </div>
    </div>
</section>

<!-- قسم نموذج التسجيل متعدد المراحل -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <!-- Header -->
                    <div class="card-header bg-gradient-primary text-center py-4">
                        <h3 class="mb-0 fw-bold custom-title-gold">
                            <i class="fas fa-shopping-cart me-2"></i>
                            استمارة طلب ملابس مخصصة
                        </h3>
                        <p class="mb-0 mt-2 text-white opacity-75">مرحباً بك في عالم الملابس المميزة</p>
                    </div>
                    
                    <div class="card-body p-0">
                        @if ($errors->any())
                            <div class="alert alert-danger m-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Dynamic Progress Bar -->
                        <div class="progress-container bg-light p-4">
                            <div class="progress-steps d-flex justify-content-between align-items-center">
                                <div class="step-item active" data-step="1">
                                    <div class="step-circle step-1">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <div class="step-label">تفاصيل الطلب</div>
                                </div>
                                <div class="step-line"></div>
                                <div class="step-item" data-step="2">
                                    <div class="step-circle step-2">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div class="step-label">معلومات الشركة</div>
                                </div>
                                <div class="step-line"></div>
                                <div class="step-item" data-step="3">
                                    <div class="step-circle step-3">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="step-label">المعلومات الشخصية</div>
                                </div>
                                <div class="step-line"></div>
                                <div class="step-item" data-step="4">
                                    <div class="step-circle step-4">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="step-label">تأكيد البيانات</div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('importers.submit') }}" method="POST" class="needs-validation" enctype="multipart/form-data" id="multiStepForm">
                            @csrf
                            
                            <!-- Step 1: Order Details -->
                            <div class="form-step active" id="step1">
                                <div class="step-content p-4">
                                    <div class="step-header text-center mb-4">
                                        <h4 class="text-primary fw-bold">
                                            <i class="fas fa-shopping-cart me-2"></i>
                                            المرحلة الأولى: تفاصيل الطلب
                                        </h4>
                                        <p class="text-muted">يرجى تحديد متطلباتك من الملابس والتصميم</p>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <label for="requirements" class="form-label fw-semibold">
                                                متطلبات الطلب <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control form-control-lg" id="requirements" name="requirements" 
                                                      rows="4" required placeholder="يرجى وصف احتياجاتك من الملابس بالتفصيل...">{{ old('requirements') }}</textarea>
                                            <div class="form-text">
                                                <i class="fas fa-lightbulb me-1 text-warning"></i>
                                                مثال: تيشرتات رياضية أزرق، شورتات بيضاء، أحجام مختلفة، شعار النادي
                                            </div>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="quantity" class="form-label fw-semibold">
                                                الكمية المطلوبة <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control form-control-lg" id="quantity" name="quantity" 
                                                   value="{{ old('quantity', 1) }}" min="1" required>
                                            <div class="form-text">الحد الأدنى 1 قطعة</div>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">
                                                طريقة تحديد التصميم <span class="text-danger">*</span>
                                            </label>
                                            <div class="design-options">
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <div class="design-option-card" data-option="text">
                                                            <div class="form-check">
                                                                <input class="form-check-input design-option" type="radio" 
                                                                       name="design_option" id="design_option_text" value="text" 
                                                                       {{ old('design_option') == 'text' ? 'checked' : '' }} checked>
                                                                <label class="form-check-label w-100" for="design_option_text">
                                                                    <div class="text-center p-3">
                                                                        <i class="fas fa-font fa-2x text-primary mb-2"></i>
                                                                        <div class="fw-semibold">وصف نصي</div>
                                                                        <small class="text-muted">اكتب وصف التصميم</small>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4 mb-3">
                                                        <div class="design-option-card" data-option="upload">
                                                            <div class="form-check">
                                                                <input class="form-check-input design-option" type="radio" 
                                                                       name="design_option" id="design_option_upload" value="upload" 
                                                                       {{ old('design_option') == 'upload' ? 'checked' : '' }}>
                                                                <label class="form-check-label w-100" for="design_option_upload">
                                                                    <div class="text-center p-3">
                                                                        <i class="fas fa-upload fa-2x text-success mb-2"></i>
                                                                        <div class="fw-semibold">رفع ملف</div>
                                                                        <small class="text-muted">ارفع تصميمك</small>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4 mb-3">
                                                        <div class="design-option-card" data-option="template">
                                                            <div class="form-check">
                                                                <input class="form-check-input design-option" type="radio" 
                                                                       name="design_option" id="design_option_template" value="template" 
                                                                       {{ old('design_option') == 'template' ? 'checked' : '' }}>
                                                                <label class="form-check-label w-100" for="design_option_template">
                                                                    <div class="text-center p-3">
                                                                        <i class="fas fa-cube fa-2x text-info mb-2"></i>
                                                                        <div class="fw-semibold">قالب جاهز</div>
                                                                        <small class="text-muted">اختر من القوالب</small>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Design Details based on selection -->
                                        <div class="col-12" id="design_details">
                                            <!-- Text Design -->
                                            <div class="design-detail" id="design_text_detail" style="display: block;">
                                                <div class="mb-3">
                                                    <label for="design_details_text" class="form-label fw-semibold">
                                                        وصف التصميم <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea class="form-control form-control-lg" id="design_details_text" 
                                                              name="design_details_text" rows="4" 
                                                              placeholder="مثال: زي رياضي أزرق مع خطوط بيضاء على الجانبين، شعار النادي على الصدر، واسم اللاعب على الظهر">{{ old('design_details_text') }}</textarea>
                                                    <div class="form-text">
                                                        <i class="fas fa-lightbulb me-1"></i>
                                                        كن مفصلاً قدر الإمكان لضمان الحصول على التصميم المطلوب
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            
                                            <!-- Upload Design -->
                                            <div class="design-detail" id="design_upload_detail" style="display: none;">
                                                <div class="mb-3">
                                                    <label for="design_file" class="form-label fw-semibold">
                                                        ملف التصميم <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="file" class="form-control form-control-lg" id="design_file" 
                                                           name="design_file" accept="image/*,application/pdf,.psd,.ai,.eps" 
                                                           onchange="previewFile(this)">
                                                    <div class="form-text">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        الصيغ المدعومة: JPG, PNG, PDF, PSD, AI, EPS
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                    
                                                    <!-- معاينة الملف -->
                                                    <div id="file-preview" class="mt-3" style="display: none;">
                                                        <div class="alert alert-info">
                                                            <i class="fas fa-file me-1"></i>
                                                            <span id="file-name"></span>
                                                            <span id="file-size" class="text-muted"></span>
                                                        </div>
                                                        <div id="image-preview" class="mt-2"></div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="design_upload_notes" class="form-label fw-semibold">ملاحظات إضافية</label>
                                                    <textarea class="form-control form-control-lg" id="design_upload_notes" 
                                                              name="design_upload_notes" rows="3" 
                                                              placeholder="أي ملاحظات إضافية حول التصميم...">{{ old('design_upload_notes') }}</textarea>
                                                </div>
                                            </div>
                                            
                                            <!-- Template Design -->
                                            <div class="design-detail" id="design_template_detail" style="display: none;">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">اختر القالب</label>
                                                    <div class="row">
                                                        <div class="col-md-4 mb-3">
                                                            <div class="template-card">
                                                                <input type="radio" class="form-check-input" name="template_selected" 
                                                                       id="template1" value="template1">
                                                                <label for="template1" class="w-100">
                                                                    <img src="{{ asset('images/template1.jpg') }}" class="img-fluid rounded" alt="قالب 1">
                                                                    <div class="text-center mt-2 fw-semibold">قالب رياضي كلاسيكي</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <div class="template-card">
                                                                <input type="radio" class="form-check-input" name="template_selected" 
                                                                       id="template2" value="template2">
                                                                <label for="template2" class="w-100">
                                                                    <img src="{{ asset('images/template2.jpg') }}" class="img-fluid rounded" alt="قالب 2">
                                                                    <div class="text-center mt-2 fw-semibold">قالب عصري</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <div class="template-card">
                                                                <input type="radio" class="form-check-input" name="template_selected" 
                                                                       id="template3" value="template3">
                                                                <label for="template3" class="w-100">
                                                                    <img src="{{ asset('images/template3.jpg') }}" class="img-fluid rounded" alt="قالب 3">
                                                                    <div class="text-center mt-2 fw-semibold">قالب احترافي</div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Company Information -->
                            <div class="form-step" id="step2">
                                <div class="step-content p-4">
                                    <div class="step-header text-center mb-4">
                                        <h4 class="text-success fw-bold">
                                            <i class="fas fa-building me-2"></i>
                                            المرحلة الثانية: معلومات الشركة
                                        </h4>
                                        <p class="text-muted">يرجى إدخال معلومات شركتك أو مؤسستك</p>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="company_name" class="form-label fw-semibold">
                                                اسم الشركة/المؤسسة <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-lg" id="company_name" 
                                                   name="company_name" value="{{ old('company_name') }}" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="business_type" class="form-label fw-semibold">
                                                نوع النشاط <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select form-select-lg" id="business_type" name="business_type" required>
                                                <option value="" selected disabled>اختر نوع النشاط</option>
                                                <option value="academy" {{ old('business_type') == 'academy' ? 'selected' : '' }}>أكاديمية رياضية</option>
                                                <option value="school" {{ old('business_type') == 'school' ? 'selected' : '' }}>مدرسة</option>
                                                <option value="store" {{ old('business_type') == 'store' ? 'selected' : '' }}>متجر ملابس</option>
                                                <option value="hospital" {{ old('business_type') == 'hospital' ? 'selected' : '' }}>مستشفى</option>
                                                <option value="other" {{ old('business_type') == 'other' ? 'selected' : '' }}>أخرى</option>
                                            </select>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3" id="other_business_type_div" style="display: none;">
                                            <label for="business_type_other" class="form-label fw-semibold">
                                                نوع النشاط (آخر) <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-lg" id="business_type_other" 
                                                   name="business_type_other" value="{{ old('business_type_other') }}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="address" class="form-label fw-semibold">العنوان</label>
                                            <input type="text" class="form-control form-control-lg" id="address" name="address" 
                                                   value="{{ old('address') }}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="city" class="form-label fw-semibold">المدينة</label>
                                            <input type="text" class="form-control form-control-lg" id="city" name="city" 
                                                   value="{{ old('city') }}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="country" class="form-label fw-semibold">الدولة</label>
                                            <input type="text" class="form-control form-control-lg" id="country" name="country" 
                                                   value="{{ old('country', 'المملكة العربية السعودية') }}">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Personal Information -->
                            <div class="form-step" id="step3">
                                <div class="step-content p-4">
                                    <div class="step-header text-center mb-4">
                                        <h4 class="text-info fw-bold">
                                            <i class="fas fa-user me-2"></i>
                                            المرحلة الثالثة: المعلومات الشخصية
                                        </h4>
                                        <p class="text-muted">يرجى إدخال بياناتك الشخصية الأساسية</p>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label fw-semibold">
                                                الاسم الكامل <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-lg" id="name" name="name" 
                                                   value="{{ old('name') }}" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label fw-semibold">
                                                البريد الإلكتروني <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                                   value="{{ old('email') }}" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label fw-semibold">
                                                رقم الهاتف <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control form-control-lg" id="phone" name="phone" 
                                                   value="{{ old('phone') }}" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label fw-semibold">
                                                كلمة المرور <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label fw-semibold">
                                                تأكيد كلمة المرور <span class="text-danger">*</span>
                                            </label>
                                            <input type="password" class="form-control form-control-lg" id="password_confirmation" 
                                                   name="password_confirmation" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4: Confirmation -->
                            <div class="form-step" id="step4">
                                <div class="step-content p-4">
                                    <div class="step-header text-center mb-4">
                                        <h4 class="text-warning fw-bold">
                                            <i class="fas fa-check-circle me-2"></i>
                                            المرحلة الرابعة: تأكيد البيانات
                                        </h4>
                                        <p class="text-muted">يرجى مراجعة بياناتك قبل إرسال الطلب</p>
                                    </div>
                                    
                                    <div class="confirmation-summary">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="summary-card mb-4">
                                                    <h5 class="card-title text-primary">
                                                        <i class="fas fa-shopping-cart me-2"></i>
                                                        تفاصيل الطلب
                                                    </h5>
                                                    <div class="summary-content">
                                                        <p><strong>الكمية المطلوبة:</strong> <span id="summary_quantity">-</span> قطعة</p>
                                                        <p><strong>طريقة التصميم:</strong> <span id="summary_design_option">-</span></p>
                                                        <p><strong>متطلبات الطلب:</strong></p>
                                                        <div class="bg-light p-3 rounded">
                                                            <span id="summary_requirements">-</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="summary-card mb-4">
                                                    <h5 class="card-title text-success">
                                                        <i class="fas fa-building me-2"></i>
                                                        معلومات الشركة
                                                    </h5>
                                                    <div class="summary-content">
                                                        <p><strong>اسم الشركة:</strong> <span id="summary_company">-</span></p>
                                                        <p><strong>نوع النشاط:</strong> <span id="summary_business_type">-</span></p>
                                                        <p><strong>المدينة:</strong> <span id="summary_city">-</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-12">
                                                <div class="summary-card mb-4">
                                                    <h5 class="card-title text-info">
                                                        <i class="fas fa-user me-2"></i>
                                                        المعلومات الشخصية
                                                    </h5>
                                                    <div class="summary-content">
                                                        <p><strong>الاسم:</strong> <span id="summary_name">-</span></p>
                                                        <p><strong>البريد الإلكتروني:</strong> <span id="summary_email">-</span></p>
                                                        <p><strong>رقم الهاتف:</strong> <span id="summary_phone">-</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="terms-section text-center">
                                            <div class="form-check d-inline-block">
                                                <input class="form-check-input" type="checkbox" id="terms_agreement" required>
                                                <label class="form-check-label fw-semibold" for="terms_agreement">
                                                    أوافق على <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal" class="text-primary">الشروط والأحكام</a> <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="form-navigation bg-light p-4">
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary btn-lg" id="prevBtn" style="display: none;">
                                        <i class="fas fa-arrow-right me-2"></i>
                                        السابق
                                    </button>
                                    <div class="ms-auto">
                                        <button type="button" class="btn btn-primary btn-lg" id="nextBtn">
                                            التالي
                                            <i class="fas fa-arrow-left ms-2"></i>
                                        </button>
                                        <button type="submit" class="btn btn-success btn-lg" id="submitBtn" style="display: none;">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            أطلب الآن
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">الشروط والأحكام</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>شروط الطلب</h5>
                <p>يرجى قراءة الشروط والأحكام التالية بعناية قبل تقديم طلبك في منصة Infinity Wear:</p>
                
                <ol>
                    <li>يجب أن تكون جميع المعلومات المقدمة في نموذج الطلب صحيحة ودقيقة.</li>
                    <li>يجب أن يكون العميل كيانًا تجاريًا قانونيًا مسجلًا.</li>
                    <li>لا يوجد حد أدنى لكمية الطلب.</li>
                    <li>تخضع جميع الطلبات للمراجعة والموافقة من قبل فريقنا.</li>
                    <li>سيتم التواصل معك خلال 48 ساعة من تقديم الطلب.</li>
                    <li>تحتفظ Infinity Wear بالحق في رفض أي طلب دون إبداء الأسباب.</li>
                    <li>جميع الأسعار قابلة للتغيير حسب السوق والمواد المستخدمة.</li>
                    <li>يتم احتساب تكلفة الشحن حسب الوزن والمسافة.</li>
                    <li>مدة التسليم تتراوح بين 7-14 يوم عمل حسب كمية الطلب.</li>
                    <li>يمكن إلغاء الطلب خلال 24 ساعة من تقديمه فقط.</li>
                </ol>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>ملاحظة:</strong> عند الموافقة على هذه الشروط، فإنك توافق على معالجة بياناتك الشخصية وفقاً لسياسة الخصوصية الخاصة بنا.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
// معاينة الملف المرفوع ورفعه فوراً إلى Cloudinary
function previewFile(input) {
    const filePreview = document.getElementById('file-preview');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const imagePreview = document.getElementById('image-preview');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // عرض معلومات الملف
        fileName.textContent = file.name;
        fileSize.textContent = `(${(file.size / 1024 / 1024).toFixed(2)} MB)`;
        
        // إخفاء معاينة الصورة السابقة
        imagePreview.innerHTML = '';
        
        // معاينة الصور
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.maxWidth = '300px';
                img.style.maxHeight = '300px';
                img.alt = 'معاينة التصميم';
                imagePreview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
        
        filePreview.style.display = 'block';
        
        // رفع الملف فوراً إلى Cloudinary
        uploadFileToCloudinary(file);
    } else {
        filePreview.style.display = 'none';
    }
}

// رفع الملف فوراً إلى Cloudinary
function uploadFileToCloudinary(file) {
    const formData = new FormData();
    formData.append('design_file', file);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    // إظهار مؤشر التحميل
    const filePreview = document.getElementById('file-preview');
    const uploadStatus = document.createElement('div');
    uploadStatus.id = 'upload-status';
    uploadStatus.className = 'alert alert-info mt-2';
    uploadStatus.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري رفع الملف إلى السحابة...';
    filePreview.appendChild(uploadStatus);
    
    fetch('{{ route("importers.upload-design") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        const uploadStatus = document.getElementById('upload-status');
        
        if (data.success) {
            uploadStatus.className = 'alert alert-success mt-2';
            uploadStatus.innerHTML = '<i class="fas fa-check-circle me-2"></i>تم رفع الملف بنجاح إلى السحابة!';
            
            // حفظ بيانات Cloudinary في hidden input
            if (data.data.cloudinary) {
                let cloudinaryData = document.getElementById('cloudinary_data');
                if (!cloudinaryData) {
                    cloudinaryData = document.createElement('input');
                    cloudinaryData.type = 'hidden';
                    cloudinaryData.name = 'cloudinary_data';
                    cloudinaryData.id = 'cloudinary_data';
                    document.getElementById('multiStepForm').appendChild(cloudinaryData);
                }
                cloudinaryData.value = JSON.stringify(data.data.cloudinary);
            }
            
            // حفظ بيانات المحلي في hidden input
            if (data.data.local) {
                let localData = document.getElementById('local_data');
                if (!localData) {
                    localData = document.createElement('input');
                    localData.type = 'hidden';
                    localData.name = 'local_data';
                    localData.id = 'local_data';
                    document.getElementById('multiStepForm').appendChild(localData);
                }
                localData.value = JSON.stringify(data.data.local);
            }
            
            console.log('File uploaded successfully:', data);
        } else {
            uploadStatus.className = 'alert alert-warning mt-2';
            uploadStatus.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + data.message;
            console.error('Upload failed:', data);
        }
    })
    .catch(error => {
        const uploadStatus = document.getElementById('upload-status');
        uploadStatus.className = 'alert alert-danger mt-2';
        uploadStatus.innerHTML = '<i class="fas fa-times-circle me-2"></i>حدث خطأ أثناء رفع الملف';
        console.error('Upload error:', error);
    });
}

// التأكد من صحة الملف عند إرسال النموذج
document.getElementById('multiStepForm').addEventListener('submit', function(e) {
    const designOption = document.querySelector('input[name="design_option"]:checked');
    const designFile = document.getElementById('design_file');
    
    if (designOption && designOption.value === 'upload' && !designFile.files[0]) {
        e.preventDefault();
        alert('يرجى اختيار ملف تصميم');
        designFile.focus();
        return false;
    }
});

// معالجة خطأ 419 (Page Expired)
window.addEventListener('load', function() {
    // فحص إذا كان هناك خطأ 419 في URL
    if (window.location.search.includes('error=419') || window.location.hash.includes('error=419')) {
        alert('انتهت صلاحية الجلسة. يرجى إعادة تحميل الصفحة والمحاولة مرة أخرى.');
        window.location.href = window.location.pathname;
    }
});

// إضافة CSRF token جديد عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    // تحديث CSRF token في النموذج
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        const tokenInput = document.querySelector('input[name="_token"]');
        if (tokenInput) {
            tokenInput.value = csrfToken.getAttribute('content');
        }
    }
});
</script>

<style>
.custom-title-gold {
    color: #FFD700 !important;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    font-size: 1.8rem;
}

.custom-title-gold:hover {
    color: #FFA500 !important;
    transition: color 0.3s ease;
}
</style>
