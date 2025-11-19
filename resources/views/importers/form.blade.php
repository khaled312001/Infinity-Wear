@extends('layouts.app')

@section('title', 'أطلب الآن - Infinity Wear')

@push('styles')
<link href="{{ asset('css/modern-multi-step-form.css') }}?v={{ time() }}" rel="stylesheet">
<link href="{{ asset('css/iw-custom-designer.css') }}?v={{ time() }}" rel="stylesheet">
<link href="{{ asset('css/enhanced-form-animations.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@push('scripts')
<!-- Three.js and Extensions -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>

<!-- Enhanced 3D Viewer System -->
<script src="{{ asset('js/enhanced-3d-viewer.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/design-interface.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/design-system-init.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/form-enhancements.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/modern-multi-step.js') }}?v={{ time() }}"></script>
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
                                                        <div class="design-option-card" data-option="custom">
                                                            <div class="form-check">
                                                                <input class="form-check-input design-option" type="radio" 
                                                                       name="design_option" id="design_option_custom" value="custom" 
                                                                       {{ old('design_option') == 'custom' ? 'checked' : '' }}>
                                                                <label class="form-check-label w-100" for="design_option_custom">
                                                                    <div class="text-center p-3">
                                                                        <i class="fas fa-paint-brush fa-2x text-warning mb-2"></i>
                                                                        <div class="fw-semibold">صمم بنفسك</div>
                                                                        <small class="text-muted">تصميم تفاعلي للزي</small>
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
                                            
                                            <!-- Custom Design Interface -->
                                            <div class="design-detail" id="design_custom_detail" style="display: none;">
                                                @include('importers.partials.enhanced-design-tools-v2')
                                            </div>
                                            
                                            <!-- Legacy Design Interface (Hidden) -->
                                            <div class="design-detail" id="design_legacy_detail" style="display: none;">
                                                <div class="custom-design-interface">
                                                    <div class="row">
                                                        <!-- Design Controls Panel -->
                                                        <div class="col-lg-4">
                                                            <div class="design-controls-panel">
                                                                <h5 class="panel-title mb-3">
                                                                    <i class="fas fa-cogs me-2"></i>
                                                                    أدوات التصميم
                                                                </h5>
                                                                
                                                                <!-- Business Type Selection -->
                                                                <div class="control-group mb-4">
                                                                    <label class="control-label fw-semibold">نوع النشاط</label>
                                                                    <select class="form-select" id="design_business_type_legacy" name="design_business_type_legacy">
                                                                        <option value="">اختر نوع النشاط</option>
                                                                        <option value="academy">أكاديمية رياضية</option>
                                                                        <option value="school">مدرسة</option>
                                                                        <option value="hospital">مستشفى</option>
                                                                        <option value="company">شركة</option>
                                                                    </select>
                                                                </div>

                                                                <!-- Clothing Pieces Selection -->
                                                                <div class="control-group mb-4">
                                                                    <label class="control-label fw-semibold">قطع الملابس</label>
                                                                    <div class="clothing-pieces">
                                                                        <div class="piece-item" data-piece="shirt">
                                                                            <input type="checkbox" id="piece_shirt" name="clothing_pieces[]" value="shirt">
                                                                            <label for="piece_shirt">
                                                                                <i class="fas fa-tshirt"></i>
                                                                                قميص/تيشرت
                                                                            </label>
                                                                        </div>
                                                                        <div class="piece-item" data-piece="pants">
                                                                            <input type="checkbox" id="piece_pants" name="clothing_pieces[]" value="pants">
                                                                            <label for="piece_pants">
                                                                                <i class="fas fa-user-tie"></i>
                                                                                بنطلون
                                                                            </label>
                                                                        </div>
                                                                        <div class="piece-item" data-piece="shorts">
                                                                            <input type="checkbox" id="piece_shorts" name="clothing_pieces[]" value="shorts">
                                                                            <label for="piece_shorts">
                                                                                <i class="fas fa-running"></i>
                                                                                شورت
                                                                            </label>
                                                                        </div>
                                                                        <div class="piece-item" data-piece="jacket">
                                                                            <input type="checkbox" id="piece_jacket" name="clothing_pieces[]" value="jacket">
                                                                            <label for="piece_jacket">
                                                                                <i class="fas fa-vest"></i>
                                                                                جاكيت
                                                                            </label>
                                                                        </div>
                                                                        <div class="piece-item" data-piece="shoes">
                                                                            <input type="checkbox" id="piece_shoes" name="clothing_pieces[]" value="shoes">
                                                                            <label for="piece_shoes">
                                                                                <i class="fas fa-shoe-prints"></i>
                                                                                حذاء
                                                                            </label>
                                                                        </div>
                                                                        <div class="piece-item" data-piece="socks">
                                                                            <input type="checkbox" id="piece_socks" name="clothing_pieces[]" value="socks">
                                                                            <label for="piece_socks">
                                                                                <i class="fas fa-socks"></i>
                                                                                شراب
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Sizes and Quantities Management -->
                                                                <div class="control-group mb-4">
                                                                    <label class="control-label fw-semibold">المقاسات والكميات</label>
                                                                    <div class="sizes-quantities-container">
                                                                        <!-- Shirt Sizes -->
                                                                        <div class="piece-sizes-group" data-piece="shirt" style="display: none;">
                                                                            <h6 class="piece-sizes-title">مقاسات القميص</h6>
                                                                            <div class="sizes-grid">
                                                                                <div class="size-item">
                                                                                    <label class="size-label">XS</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shirt_sizes[XS]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">S</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shirt_sizes[S]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">M</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shirt_sizes[M]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">L</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shirt_sizes[L]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">XL</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shirt_sizes[XL]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">XXL</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shirt_sizes[XXL]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">XXXL</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shirt_sizes[XXXL]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                            </div>
                                                                            <div class="total-quantity">
                                                                                <span class="total-label">المجموع:</span>
                                                                                <span class="total-value" id="shirt_total">0</span>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Pants Sizes -->
                                                                        <div class="piece-sizes-group" data-piece="pants" style="display: none;">
                                                                            <h6 class="piece-sizes-title">مقاسات البنطلون</h6>
                                                                            <div class="sizes-grid">
                                                                                <div class="size-item">
                                                                                    <label class="size-label">28</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="pants_sizes[28]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">30</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="pants_sizes[30]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">32</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="pants_sizes[32]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">34</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="pants_sizes[34]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">36</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="pants_sizes[36]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">38</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="pants_sizes[38]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">40</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="pants_sizes[40]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">42</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="pants_sizes[42]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                            </div>
                                                                            <div class="total-quantity">
                                                                                <span class="total-label">المجموع:</span>
                                                                                <span class="total-value" id="pants_total">0</span>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Shorts Sizes -->
                                                                        <div class="piece-sizes-group" data-piece="shorts" style="display: none;">
                                                                            <h6 class="piece-sizes-title">مقاسات الشورت</h6>
                                                                            <div class="sizes-grid">
                                                                                <div class="size-item">
                                                                                    <label class="size-label">XS</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shorts_sizes[XS]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">S</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shorts_sizes[S]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">M</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shorts_sizes[M]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">L</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shorts_sizes[L]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">XL</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shorts_sizes[XL]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">XXL</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shorts_sizes[XXL]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                            </div>
                                                                            <div class="total-quantity">
                                                                                <span class="total-label">المجموع:</span>
                                                                                <span class="total-value" id="shorts_total">0</span>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Jacket Sizes -->
                                                                        <div class="piece-sizes-group" data-piece="jacket" style="display: none;">
                                                                            <h6 class="piece-sizes-title">مقاسات الجاكيت</h6>
                                                                            <div class="sizes-grid">
                                                                                <div class="size-item">
                                                                                    <label class="size-label">XS</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="jacket_sizes[XS]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">S</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="jacket_sizes[S]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">M</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="jacket_sizes[M]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">L</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="jacket_sizes[L]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">XL</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="jacket_sizes[XL]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">XXL</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="jacket_sizes[XXL]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                            </div>
                                                                            <div class="total-quantity">
                                                                                <span class="total-label">المجموع:</span>
                                                                                <span class="total-value" id="jacket_total">0</span>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Shoes Sizes -->
                                                                        <div class="piece-sizes-group" data-piece="shoes" style="display: none;">
                                                                            <h6 class="piece-sizes-title">مقاسات الحذاء</h6>
                                                                            <div class="sizes-grid">
                                                                                <div class="size-item">
                                                                                    <label class="size-label">36</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shoes_sizes[36]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">37</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shoes_sizes[37]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">38</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shoes_sizes[38]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">39</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shoes_sizes[39]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">40</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shoes_sizes[40]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">41</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shoes_sizes[41]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">42</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shoes_sizes[42]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">43</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shoes_sizes[43]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">44</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shoes_sizes[44]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">45</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="shoes_sizes[45]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                            </div>
                                                                            <div class="total-quantity">
                                                                                <span class="total-label">المجموع:</span>
                                                                                <span class="total-value" id="shoes_total">0</span>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Socks Sizes -->
                                                                        <div class="piece-sizes-group" data-piece="socks" style="display: none;">
                                                                            <h6 class="piece-sizes-title">مقاسات الشراب</h6>
                                                                            <div class="sizes-grid">
                                                                                <div class="size-item">
                                                                                    <label class="size-label">S</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="socks_sizes[S]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">M</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="socks_sizes[M]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">L</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="socks_sizes[L]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                                <div class="size-item">
                                                                                    <label class="size-label">XL</label>
                                                                                    <input type="number" class="form-control size-quantity" 
                                                                                           name="socks_sizes[XL]" min="0" value="0" placeholder="0">
                                                                                </div>
                                                                            </div>
                                                                            <div class="total-quantity">
                                                                                <span class="total-label">المجموع:</span>
                                                                                <span class="total-value" id="socks_total">0</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Order Summary -->
                                                                    <div class="order-summary mt-4">
                                                                        <h6 class="summary-title">ملخص الطلب</h6>
                                                                        <div class="summary-content">
                                                                            <div class="summary-item">
                                                                                <span class="item-label">إجمالي القطع:</span>
                                                                                <span class="item-value" id="total_pieces">0</span>
                                                                            </div>
                                                                            <div class="summary-item">
                                                                                <span class="item-label">عدد الأصناف:</span>
                                                                                <span class="item-value" id="total_varieties">0</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Advanced Color Selection -->
                                                                <div class="control-group mb-4">
                                                                    <label class="control-label fw-semibold">تخصيص الألوان لكل قطعة</label>
                                                                    
                                                                    <!-- Color Palette -->
                                                                    <div class="mb-3">
                                                                        <label class="form-label">لوحة الألوان</label>
                                                                        <div class="color-palette">
                                                                            <div class="color-option" data-color="#FF0000" style="background-color: #FF0000;"></div>
                                                                            <div class="color-option" data-color="#0000FF" style="background-color: #0000FF;"></div>
                                                                            <div class="color-option" data-color="#00FF00" style="background-color: #00FF00;"></div>
                                                                            <div class="color-option" data-color="#FFFF00" style="background-color: #FFFF00;"></div>
                                                                            <div class="color-option" data-color="#FF00FF" style="background-color: #FF00FF;"></div>
                                                                            <div class="color-option" data-color="#00FFFF" style="background-color: #00FFFF;"></div>
                                                                            <div class="color-option" data-color="#000000" style="background-color: #000000;"></div>
                                                                            <div class="color-option" data-color="#FFFFFF" style="background-color: #FFFFFF;"></div>
                                                                            <div class="color-option" data-color="#800080" style="background-color: #800080;"></div>
                                                                            <div class="color-option" data-color="#FFA500" style="background-color: #FFA500;"></div>
                                                                            <div class="color-option" data-color="#A52A2A" style="background-color: #A52A2A;"></div>
                                                                            <div class="color-option" data-color="#808080" style="background-color: #808080;"></div>
                                                                            <div class="color-option" data-color="#FFD700" style="background-color: #FFD700;"></div>
                                                                            <div class="color-option" data-color="#FF6B6B" style="background-color: #FF6B6B;"></div>
                                                                            <div class="color-option" data-color="#4ECDC4" style="background-color: #4ECDC4;"></div>
                                                                            <div class="color-option" data-color="#45B7D1" style="background-color: #45B7D1;"></div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Piece-specific Color Controls -->
                                                                    <div class="piece-color-controls">
                                                                        <!-- Shirt Colors -->
                                                                        <div class="piece-color-group" data-piece="shirt" style="display: none;">
                                                                            <h6 class="piece-color-title">ألوان القميص</h6>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">الجسم</label>
                                                                                    <div class="color-picker-group">
                                                                                        <input type="color" class="form-control form-control-color piece-color-input" 
                                                                                               id="shirt_body_color" data-piece="shirt" data-part="body" value="#667eea">
                                                                                        <span class="color-preview" id="shirt_body_preview" style="background-color: #667eea;"></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">الأكمام</label>
                                                                                    <div class="color-picker-group">
                                                                                        <input type="color" class="form-control form-control-color piece-color-input" 
                                                                                               id="shirt_sleeves_color" data-piece="shirt" data-part="sleeves" value="#667eea">
                                                                                        <span class="color-preview" id="shirt_sleeves_preview" style="background-color: #667eea;"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row mt-2">
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">الياقة</label>
                                                                                    <div class="color-picker-group">
                                                                                        <input type="color" class="form-control form-control-color piece-color-input" 
                                                                                               id="shirt_collar_color" data-piece="shirt" data-part="collar" value="#ffffff">
                                                                                        <span class="color-preview" id="shirt_collar_preview" style="background-color: #ffffff;"></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">الزخارف</label>
                                                                                    <div class="color-picker-group">
                                                                                        <input type="color" class="form-control form-control-color piece-color-input" 
                                                                                               id="shirt_trim_color" data-piece="shirt" data-part="trim" value="#000000">
                                                                                        <span class="color-preview" id="shirt_trim_preview" style="background-color: #000000;"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Pants Colors -->
                                                                        <div class="piece-color-group" data-piece="pants" style="display: none;">
                                                                            <h6 class="piece-color-title">ألوان البنطلون</h6>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">الجسم</label>
                                                                                    <div class="color-picker-group">
                                                                                        <input type="color" class="form-control form-control-color piece-color-input" 
                                                                                               id="pants_body_color" data-piece="pants" data-part="body" value="#2c3e50">
                                                                                        <span class="color-preview" id="pants_body_preview" style="background-color: #2c3e50;"></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">الحزام</label>
                                                                                    <div class="color-picker-group">
                                                                                        <input type="color" class="form-control form-control-color piece-color-input" 
                                                                                               id="pants_waist_color" data-piece="pants" data-part="waist" value="#34495e">
                                                                                        <span class="color-preview" id="pants_waist_preview" style="background-color: #34495e;"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Shorts Colors -->
                                                                        <div class="piece-color-group" data-piece="shorts" style="display: none;">
                                                                            <h6 class="piece-color-title">ألوان الشورت</h6>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">الجسم</label>
                                                                                    <div class="color-picker-group">
                                                                                        <input type="color" class="form-control form-control-color piece-color-input" 
                                                                                               id="shorts_body_color" data-piece="shorts" data-part="body" value="#e74c3c">
                                                                                        <span class="color-preview" id="shorts_body_preview" style="background-color: #e74c3c;"></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">الحزام</label>
                                                                                    <div class="color-picker-group">
                                                                                        <input type="color" class="form-control form-control-color piece-color-input" 
                                                                                               id="shorts_waist_color" data-piece="shorts" data-part="waist" value="#c0392b">
                                                                                        <span class="color-preview" id="shorts_waist_preview" style="background-color: #c0392b;"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Jacket Colors -->
                                                                        <div class="piece-color-group" data-piece="jacket" style="display: none;">
                                                                            <h6 class="piece-color-title">ألوان الجاكيت</h6>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">الجسم</label>
                                                                                    <div class="color-picker-group">
                                                                                        <input type="color" class="form-control form-control-color piece-color-input" 
                                                                                               id="jacket_body_color" data-piece="jacket" data-part="body" value="#8e44ad">
                                                                                        <span class="color-preview" id="jacket_body_preview" style="background-color: #8e44ad;"></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">الأكمام</label>
                                                                                    <div class="color-picker-group">
                                                                                        <input type="color" class="form-control form-control-color piece-color-input" 
                                                                                               id="jacket_sleeves_color" data-piece="jacket" data-part="sleeves" value="#8e44ad">
                                                                                        <span class="color-preview" id="jacket_sleeves_preview" style="background-color: #8e44ad;"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Shoes Colors -->
                                                                        <div class="piece-color-group" data-piece="shoes" style="display: none;">
                                                                            <h6 class="piece-color-title">ألوان الحذاء</h6>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">الجسم</label>
                                                                                    <div class="color-picker-group">
                                                                                        <input type="color" class="form-control form-control-color piece-color-input" 
                                                                                               id="shoes_body_color" data-piece="shoes" data-part="body" value="#2c3e50">
                                                                                        <span class="color-preview" id="shoes_body_preview" style="background-color: #2c3e50;"></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">النعل</label>
                                                                                    <div class="color-picker-group">
                                                                                        <input type="color" class="form-control form-control-color piece-color-input" 
                                                                                               id="shoes_sole_color" data-piece="shoes" data-part="sole" value="#34495e">
                                                                                        <span class="color-preview" id="shoes_sole_preview" style="background-color: #34495e;"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Socks Colors -->
                                                                        <div class="piece-color-group" data-piece="socks" style="display: none;">
                                                                            <h6 class="piece-color-title">ألوان الشراب</h6>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">الجسم</label>
                                                                                    <div class="color-picker-group">
                                                                                        <input type="color" class="form-control form-control-color piece-color-input" 
                                                                                               id="socks_body_color" data-piece="socks" data-part="body" value="#f39c12">
                                                                                        <span class="color-preview" id="socks_body_preview" style="background-color: #f39c12;"></span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label">الحافة</label>
                                                                                    <div class="color-picker-group">
                                                                                        <input type="color" class="form-control form-control-color piece-color-input" 
                                                                                               id="socks_cuff_color" data-piece="socks" data-part="cuff" value="#e67e22">
                                                                                        <span class="color-preview" id="socks_cuff_preview" style="background-color: #e67e22;"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Pattern Selection -->
                                                                    <div class="mb-3">
                                                                        <label class="form-label">الزخارف</label>
                                                                        <div class="pattern-options">
                                                                            <div class="pattern-option" data-pattern="solid">
                                                                                <div class="pattern-preview solid"></div>
                                                                                <span>لون موحد</span>
                                                                            </div>
                                                                            <div class="pattern-option" data-pattern="stripes">
                                                                                <div class="pattern-preview stripes"></div>
                                                                                <span>خطوط</span>
                                                                            </div>
                                                                            <div class="pattern-option" data-pattern="dots">
                                                                                <div class="pattern-preview dots"></div>
                                                                                <span>نقاط</span>
                                                                            </div>
                                                                            <div class="pattern-option" data-pattern="gradient">
                                                                                <div class="pattern-preview gradient"></div>
                                                                                <span>تدرج</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" id="selected_colors" name="selected_colors">
                                                                    <input type="hidden" id="selected_pattern" name="selected_pattern">
                                                                </div>

                                                                <!-- Logo Upload and Positioning -->
                                                                <div class="control-group mb-4">
                                                                    <label class="control-label fw-semibold">الشعار والمواضع</label>
                                                                    <input type="file" class="form-control mb-3" id="logo_upload" name="logo_upload" accept="image/*">
                                                                    
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label class="form-label">موضع الشعار</label>
                                                                            <select class="form-select" id="logo_position" name="logo_position">
                                                                                <option value="">اختر الموضع</option>
                                                                                <option value="front">منتصف الصدر</option>
                                                                                <option value="back">منتصف الظهر</option>
                                                                                <option value="leftSleeve">الذراع الأيسر</option>
                                                                                <option value="rightSleeve">الذراع الأيمن</option>
                                                                                <option value="collar">الياقة</option>
                                                                                <option value="leftSock">الشراب الأيسر</option>
                                                                                <option value="rightSock">الشراب الأيمن</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label">حجم الشعار</label>
                                                                            <select class="form-select" id="logo_size" name="logo_size">
                                                                                <option value="small">صغير</option>
                                                                                <option value="medium" selected>متوسط</option>
                                                                                <option value="large">كبير</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Text Addition and Positioning -->
                                                                <div class="control-group mb-4">
                                                                    <label class="control-label fw-semibold">النصوص والمواضع</label>
                                                                    <input type="text" class="form-control mb-3" id="design_text" name="design_text" placeholder="مثال: اسم المؤسسة">
                                                                    
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label class="form-label">موضع النص</label>
                                                                            <select class="form-select" id="text_position" name="text_position">
                                                                                <option value="">اختر الموضع</option>
                                                                                <option value="front">منتصف الصدر</option>
                                                                                <option value="back">منتصف الظهر</option>
                                                                                <option value="leftSleeve">الذراع الأيسر</option>
                                                                                <option value="rightSleeve">الذراع الأيمن</option>
                                                                                <option value="collar">الياقة</option>
                                                                                <option value="leftSock">الشراب الأيسر</option>
                                                                                <option value="rightSock">الشراب الأيمن</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label">لون النص</label>
                                                                            <input type="color" class="form-control form-control-color" id="text_color" name="text_color" value="#000000">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="row mt-2">
                                                                        <div class="col-md-6">
                                                                            <label class="form-label">حجم النص</label>
                                                                            <select class="form-select" id="text_size" name="text_size">
                                                                                <option value="small">صغير</option>
                                                                                <option value="medium" selected>متوسط</option>
                                                                                <option value="large">كبير</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label class="form-label">نمط النص</label>
                                                                            <select class="form-select" id="text_style" name="text_style">
                                                                                <option value="normal">عادي</option>
                                                                                <option value="bold">عريض</option>
                                                                                <option value="italic">مائل</option>
                                                                                <option value="outline">محدود</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- 3D Preview Panel -->
                                                        <div class="col-lg-8">
                                                            <div class="preview-panel">
                                                                <h5 class="panel-title mb-3">
                                                                    <i class="fas fa-cube me-2"></i>
                                                                    معاينة ثلاثية الأبعاد
                                                                </h5>
                                                                <div class="viewer-container">
                                                                    <div id="3d-viewer" class="viewer-3d">
                                                                        <!-- 3D Model will be loaded here -->
                                                                        <div class="model-placeholder">
                                                                            <i class="fas fa-user fa-5x text-muted"></i>
                                                                            <p class="mt-3">اختر قطع الملابس لبدء التصميم</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="viewer-controls">
                                                                        <button type="button" class="btn btn-sm btn-outline-primary" id="rotate-model">
                                                                            <i class="fas fa-sync-alt"></i> تدوير
                                                                        </button>
                                                                        <button type="button" class="btn btn-sm btn-outline-primary" id="zoom-in">
                                                                            <i class="fas fa-search-plus"></i> تكبير
                                                                        </button>
                                                                        <button type="button" class="btn btn-sm btn-outline-primary" id="zoom-out">
                                                                            <i class="fas fa-search-minus"></i> تصغير
                                                                        </button>
                                                                        <button type="button" class="btn btn-sm btn-outline-primary" id="reset-view">
                                                                            <i class="fas fa-home"></i> إعادة تعيين
                                                                        </button>
                                                                    </div>
                                                                </div>
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
                                                <option value="">اختر نوع النشاط</option>
                                                <option value="academy" {{ old('business_type') == 'academy' ? 'selected' : '' }}>أكاديمية رياضية</option>
                                                <option value="school" {{ old('business_type') == 'school' ? 'selected' : '' }}>مدرسة</option>
                                                <option value="store" {{ old('business_type') == 'store' ? 'selected' : '' }}>متجر ملابس</option>
                                                <option value="hospital" {{ old('business_type') == 'hospital' ? 'selected' : '' }}>مستشفى</option>
                                                <option value="company" {{ old('business_type') == 'company' ? 'selected' : '' }}>شركة</option>
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

<!-- Design Notes Section -->
<div class="row justify-content-center mt-4" id="design_notes_section" style="display: none;">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-primary">
                        <i class="fas fa-sticky-note me-2"></i>
                        ملاحظات على التصميم
                    </h4>
                    <p class="text-muted">يمكنك إضافة ملاحظات أو تعليمات خاصة للتصميم</p>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="form-group mb-4">
                            <label for="design_notes" class="form-label fw-semibold">
                                <i class="fas fa-edit me-2"></i>
                                ملاحظات التصميم
                            </label>
                            <textarea 
                                class="form-control" 
                                id="design_notes" 
                                name="design_notes" 
                                rows="6" 
                                placeholder="اكتب هنا أي ملاحظات أو تعليمات خاصة للتصميم...&#10;مثال:&#10;- تفضيل وضع الشعار في الوسط&#10;- استخدام ألوان مخصصة للشركة&#10;- إضافة تفاصيل معينة للزخارف&#10;- أي متطلبات خاصة أخرى"
                                style="resize: vertical; min-height: 150px;"></textarea>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                هذه الملاحظات ستساعد فريق التصميم في فهم متطلباتك بشكل أفضل
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Design Preferences -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="design_priority" class="form-label fw-semibold">
                                <i class="fas fa-star me-2"></i>
                                أولوية التصميم
                            </label>
                            <select class="form-select" id="design_priority" name="design_priority">
                                <option value="normal">عادية</option>
                                <option value="high">عالية</option>
                                <option value="urgent">عاجلة</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="delivery_preference" class="form-label fw-semibold">
                                <i class="fas fa-clock me-2"></i>
                                تفضيل التسليم
                            </label>
                            <select class="form-select" id="delivery_preference" name="delivery_preference">
                                <option value="standard">عادي (7-10 أيام)</option>
                                <option value="fast">سريع (3-5 أيام)</option>
                                <option value="express">عاجل (1-2 أيام)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Additional Requirements -->
                <div class="row">
                    <div class="col-12">
                        <div class="form-group mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-list-check me-2"></i>
                                متطلبات إضافية
                            </label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="require_sample" name="additional_requirements[]" value="sample">
                                        <label class="form-check-label" for="require_sample">
                                            <i class="fas fa-cut me-1"></i>
                                            عينة قبل الإنتاج
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="require_packaging" name="additional_requirements[]" value="packaging">
                                        <label class="form-check-label" for="require_packaging">
                                            <i class="fas fa-box me-1"></i>
                                            تغليف مخصص
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="require_delivery" name="additional_requirements[]" value="delivery">
                                        <label class="form-check-label" for="require_delivery">
                                            <i class="fas fa-truck me-1"></i>
                                            توصيل خاص
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Design Summary -->
                <div class="row">
                    <div class="col-12">
                        <div class="design-summary-card">
                            <h6 class="summary-title">
                                <i class="fas fa-clipboard-list me-2"></i>
                                ملخص التصميم
                            </h6>
                            <div class="summary-content" id="design_summary_content">
                                <!-- سيتم ملؤها بواسطة JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-outline-secondary me-3" id="back_to_design_btn">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة للتصميم
                        </button>
                        <button type="button" class="btn btn-primary me-3" id="save_design_btn">
                            <i class="fas fa-save me-2"></i>
                            حفظ التصميم
                        </button>
                        <button type="submit" class="btn btn-success" id="submit_design_btn">
                            <i class="fas fa-paper-plane me-2"></i>
                            إرسال الطلب
                        </button>
                    </div>
                </div>
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
document.addEventListener('DOMContentLoaded', function() {
    const multiStepForm = document.getElementById('multiStepForm');
    if (multiStepForm) {
        multiStepForm.addEventListener('submit', function(e) {
            const designOption = document.querySelector('input[name="design_option"]:checked');
            const designFile = document.getElementById('design_file');
            
            if (designOption && designOption.value === 'upload' && !designFile.files[0]) {
                e.preventDefault();
                alert('يرجى اختيار ملف تصميم');
                designFile.focus();
                return false;
            }
        });
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
