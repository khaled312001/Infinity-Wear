@extends('layouts.app')

@section('title', 'أطلب الآن - Infinity Wear')

@push('styles')
<link href="{{ asset('css/importer-form-new.css') }}" rel="stylesheet">
<link href="{{ asset('css/model-viewer-enhancements.css') }}" rel="stylesheet">
<link href="{{ asset('css/importer-form-fixes.css') }}" rel="stylesheet">
<style>
/* Inline critical styles */
body {
    background: transparent !important;
}
.importer-form-wrapper {
    direction: rtl;
    text-align: right;
}
</style>
@endpush

@push('scripts')
<!-- Three.js for 3D Model -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
<script src="{{ asset('js/form-init-fix.js') }}"></script>
<script src="{{ asset('js/model-viewer-enhanced.js') }}"></script>
<script src="{{ asset('js/importer-form-new.js') }}"></script>
@endpush

@section('content')
<div class="importer-form-wrapper">
<div class="form-container">
    <div class="main-card">
        <!-- Header -->
        <div class="form-header">
            <h1>
                <i class="fas fa-tshirt me-2"></i>
                صمم ملابسك المخصصة
            </h1>
            <p>قم بتصميم وطلب ملابسك الرياضية أو المؤسسية بكل سهولة</p>
        </div>

        <!-- Progress Bar -->
        <div class="progress-bar-container">
            <div class="steps-wrapper">
                <div class="step-line-bg"></div>
                <div class="step-line-progress" id="progressLine"></div>
                
                <div class="step-item active" data-step="1">
                    <div class="step-circle">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="step-label">معلومات أساسية</div>
                </div>
                
                <div class="step-item" data-step="2">
                    <div class="step-circle">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div class="step-label">التصميم</div>
                </div>
                
                <div class="step-item" data-step="3">
                    <div class="step-circle">
                        <i class="fas fa-ruler"></i>
                    </div>
                    <div class="step-label">المقاسات</div>
                </div>
                
                <div class="step-item" data-step="4">
                    <div class="step-circle">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="step-label">تأكيد الطلب</div>
                </div>
            </div>
        </div>

        <form action="{{ route('importers.submit') }}" method="POST" id="orderForm" enctype="multipart/form-data">
            @csrf
            
            <div class="form-content">
                <!-- 3D Viewer Sidebar (على اليسار) -->
                <div class="viewer-sidebar">
                    <div class="viewer-card">
                        <h3 class="viewer-title">
                            <i class="fas fa-eye me-2"></i>
                            معاينة التصميم
                        </h3>
                        
                        <div class="viewer-container">
                            <div id="model-viewer"></div>
                            <div class="model-placeholder" id="modelPlaceholder">
                                <i class="fas fa-tshirt"></i>
                                <p>ابدأ بتصميم ملابسك<br>لمعاينتها هنا</p>
                            </div>
                        </div>
                        
                        <div class="viewer-controls">
                            <button type="button" id="rotateLeft">
                                <i class="fas fa-undo"></i>
                            </button>
                            <button type="button" id="rotateRight">
                                <i class="fas fa-redo"></i>
                            </button>
                            <button type="button" id="zoomIn">
                                <i class="fas fa-search-plus"></i>
                            </button>
                            <button type="button" id="zoomOut">
                                <i class="fas fa-search-minus"></i>
                            </button>
                            <button type="button" id="resetView">
                                <i class="fas fa-sync"></i>
                            </button>
                        </div>
                        
                        <div class="design-summary" id="designSummary">
                            <div class="summary-item">
                                <span class="summary-label">قطع الملابس:</span>
                                <span class="summary-value" id="summaryPieces">-</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">اللون الرئيسي:</span>
                                <span class="summary-value" id="summaryColor">-</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">إجمالي القطع:</span>
                                <span class="summary-value" id="summaryTotal">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Steps (على اليمين) -->
                <div class="steps-container">
                    <!-- Step 1: Basic Information -->
                    <div class="form-step active" id="step1">
                        <div class="step-header">
                            <h2 class="step-title">معلومات أساسية</h2>
                            <p class="step-description">أخبرنا عن مؤسستك ومتطلباتك</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                اسم الشركة / المؤسسة
                                <span class="required">*</span>
                            </label>
                            <input type="text" name="company_name" class="form-control" 
                                   placeholder="مثال: أكاديمية النصر الرياضية" 
                                   value="{{ old('company_name') }}" required>
                            @error('company_name')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        الاسم الكامل
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" name="name" class="form-control" 
                                           placeholder="الاسم الكامل" 
                                           value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        نوع النشاط
                                        <span class="required">*</span>
                                    </label>
                                    <select name="business_type" class="form-control form-select" required>
                                        <option value="">اختر نوع النشاط</option>
                                        <option value="academy">أكاديمية رياضية</option>
                                        <option value="school">مدرسة</option>
                                        <option value="hospital">مستشفى</option>
                                        <option value="company">شركة</option>
                                        <option value="store">متجر ملابس</option>
                                        <option value="other">أخرى</option>
                                    </select>
                                    @error('business_type')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        البريد الإلكتروني
                                        <span class="required">*</span>
                                    </label>
                                    <input type="email" name="email" class="form-control" 
                                           placeholder="example@domain.com" 
                                           value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        رقم الهاتف
                                        <span class="required">*</span>
                                    </label>
                                    <input type="tel" name="phone" class="form-control" 
                                           placeholder="05xxxxxxxx" 
                                           value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        كلمة المرور
                                        <span class="required">*</span>
                                    </label>
                                    <input type="password" name="password" class="form-control" 
                                           placeholder="••••••••" required>
                                    <div class="form-text">على الأقل 8 أحرف</div>
                                    @error('password')
                                        <div class="form-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        تأكيد كلمة المرور
                                        <span class="required">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" class="form-control" 
                                           placeholder="••••••••" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                وصف مختصر لطلبك
                                <span class="required">*</span>
                            </label>
                            <textarea name="requirements" class="form-control" rows="4" 
                                      placeholder="مثال: نحتاج إلى زي رياضي كامل لفريق كرة القدم (قميص، شورت، شراب) بألوان الأزرق والأبيض مع شعار النادي" 
                                      required>{{ old('requirements') }}</textarea>
                            <div class="form-text">
                                <i class="fas fa-lightbulb"></i>
                                كن مفصلاً قدر الإمكان لنتمكن من تلبية احتياجاتك بدقة
                            </div>
                            @error('requirements')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Step 2: Design -->
                    <div class="form-step" id="step2">
                        <div class="step-header">
                            <h2 class="step-title">اختر تصميمك</h2>
                            <p class="step-description">حدد كيفية تصميم ملابسك</p>
                        </div>

                        <div class="design-options-grid">
                            <label class="design-option-card" id="optionText">
                                <input type="radio" name="design_option" value="text" checked>
                                <div class="design-option-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="design-option-title">وصف نصي</div>
                                <div class="design-option-desc">صف التصميم المطلوب</div>
                            </label>

                            <label class="design-option-card" id="optionUpload">
                                <input type="radio" name="design_option" value="upload">
                                <div class="design-option-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="design-option-title">رفع ملف</div>
                                <div class="design-option-desc">ارفع تصميمك الجاهز</div>
                            </label>

                            <label class="design-option-card" id="optionCustom">
                                <input type="radio" name="design_option" value="custom">
                                <div class="design-option-icon">
                                    <i class="fas fa-magic"></i>
                                </div>
                                <div class="design-option-title">صمم بنفسك</div>
                                <div class="design-option-desc">استخدم أداة التصميم</div>
                            </label>
                        </div>

                        <!-- Text Design Detail -->
                        <div id="designTextDetail">
                            <div class="form-group">
                                <label class="form-label">وصف التصميم</label>
                                <textarea name="design_details_text" class="form-control" rows="5" 
                                          placeholder="مثال: قميص أزرق بخطوط بيضاء على الأكمام، شعار النادي على الصدر بحجم متوسط...">{{ old('design_details_text') }}</textarea>
                            </div>
                        </div>

                        <!-- Upload Design Detail -->
                        <div id="designUploadDetail" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">اختر ملف التصميم</label>
                                <input type="file" name="design_file" class="form-control" 
                                       accept="image/*,.pdf,.ai,.psd">
                                <div class="form-text">
                                    الصيغ المدعومة: JPG, PNG, PDF, AI, PSD (حتى 10 ميجابايت)
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">ملاحظات على التصميم</label>
                                <textarea name="design_upload_notes" class="form-control" rows="3" 
                                          placeholder="أي ملاحظات إضافية على التصميم المرفق...">{{ old('design_upload_notes') }}</textarea>
                            </div>
                        </div>

                        <!-- Custom Design Detail -->
                        <div id="designCustomDetail" style="display: none;">
                            <div class="custom-design-panel">
                                <!-- Clothing Pieces -->
                                <div class="panel-section">
                                    <h3 class="panel-section-title">
                                        <i class="fas fa-tshirt"></i>
                                        اختر قطع الملابس
                                    </h3>
                                    <div class="pieces-grid">
                                        <label class="piece-card" data-piece="shirt">
                                            <input type="checkbox" name="clothing_pieces[]" value="shirt">
                                            <div class="piece-icon">
                                                <i class="fas fa-tshirt"></i>
                                            </div>
                                            <div class="piece-name">قميص</div>
                                        </label>

                                        <label class="piece-card" data-piece="shorts">
                                            <input type="checkbox" name="clothing_pieces[]" value="shorts">
                                            <div class="piece-icon">
                                                <i class="fas fa-running"></i>
                                            </div>
                                            <div class="piece-name">شورت</div>
                                        </label>

                                        <label class="piece-card" data-piece="pants">
                                            <input type="checkbox" name="clothing_pieces[]" value="pants">
                                            <div class="piece-icon">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                            <div class="piece-name">بنطلون</div>
                                        </label>

                                        <label class="piece-card" data-piece="jacket">
                                            <input type="checkbox" name="clothing_pieces[]" value="jacket">
                                            <div class="piece-icon">
                                                <i class="fas fa-vest"></i>
                                            </div>
                                            <div class="piece-name">جاكيت</div>
                                        </label>

                                        <label class="piece-card" data-piece="socks">
                                            <input type="checkbox" name="clothing_pieces[]" value="socks">
                                            <div class="piece-icon">
                                                <i class="fas fa-socks"></i>
                                            </div>
                                            <div class="piece-name">شراب</div>
                                        </label>

                                        <label class="piece-card" data-piece="shoes">
                                            <input type="checkbox" name="clothing_pieces[]" value="shoes">
                                            <div class="piece-icon">
                                                <i class="fas fa-shoe-prints"></i>
                                            </div>
                                            <div class="piece-name">حذاء</div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Colors -->
                                <div class="panel-section" id="colorsSection" style="display: none;">
                                    <h3 class="panel-section-title">
                                        <i class="fas fa-palette"></i>
                                        اختر الألوان الرئيسية
                                    </h3>
                                    <div class="color-palette">
                                        <div class="color-option" data-color="#1e40af" style="background: #1e40af;"></div>
                                        <div class="color-option" data-color="#dc2626" style="background: #dc2626;"></div>
                                        <div class="color-option" data-color="#16a34a" style="background: #16a34a;"></div>
                                        <div class="color-option" data-color="#eab308" style="background: #eab308;"></div>
                                        <div class="color-option" data-color="#ea580c" style="background: #ea580c;"></div>
                                        <div class="color-option" data-color="#7c3aed" style="background: #7c3aed;"></div>
                                        <div class="color-option" data-color="#ec4899" style="background: #ec4899;"></div>
                                        <div class="color-option" data-color="#06b6d4" style="background: #06b6d4;"></div>
                                        <div class="color-option" data-color="#ffffff" style="background: #ffffff; border: 2px solid #e5e7eb;"></div>
                                        <div class="color-option" data-color="#000000" style="background: #000000;"></div>
                                        <div class="color-option" data-color="#6b7280" style="background: #6b7280;"></div>
                                        <div class="color-option" data-color="#f59e0b" style="background: #f59e0b;"></div>
                                        <div class="color-option" data-color="#8b5cf6" style="background: #8b5cf6;"></div>
                                        <div class="color-option" data-color="#14b8a6" style="background: #14b8a6;"></div>
                                        <div class="color-option" data-color="#f43f5e" style="background: #f43f5e;"></div>
                                        <div class="color-option" data-color="#84cc16" style="background: #84cc16;"></div>
                                    </div>
                                    <input type="hidden" name="primary_color" id="primaryColor">
                                </div>

                                <!-- Logo Upload -->
                                <div class="panel-section" id="logoSection" style="display: none;">
                                    <h3 class="panel-section-title">
                                        <i class="fas fa-image"></i>
                                        إضافة شعار (اختياري)
                                    </h3>
                                    <div class="form-group">
                                        <input type="file" name="logo_file" class="form-control" accept="image/*">
                                        <div class="form-text">ارفع شعار مؤسستك (PNG أو JPG بخلفية شفافة يفضل)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Sizes -->
                    <div class="form-step" id="step3">
                        <div class="step-header">
                            <h2 class="step-title">المقاسات والكميات</h2>
                            <p class="step-description">حدد المقاسات المطلوبة والكميات</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                الكمية الإجمالية التقريبية
                                <span class="required">*</span>
                            </label>
                            <input type="number" name="quantity" class="form-control" 
                                   min="1" value="{{ old('quantity', 10) }}" required>
                            <div class="form-text">يمكنك تحديد الكميات بشكل تفصيلي أدناه</div>
                        </div>

                        <div id="sizesContainer">
                            <!-- Shirt Sizes -->
                            <div class="panel-section size-section" id="shirtSizes" style="display: none;">
                                <h3 class="panel-section-title">
                                    <i class="fas fa-tshirt"></i>
                                    مقاسات القميص
                                </h3>
                                <div class="sizes-grid">
                                    <div class="size-item">
                                        <div class="size-label">XS</div>
                                        <input type="number" name="sizes[shirt][xs]" class="size-input" 
                                               min="0" value="0" placeholder="0">
                                    </div>
                                    <div class="size-item">
                                        <div class="size-label">S</div>
                                        <input type="number" name="sizes[shirt][s]" class="size-input" 
                                               min="0" value="0" placeholder="0">
                                    </div>
                                    <div class="size-item">
                                        <div class="size-label">M</div>
                                        <input type="number" name="sizes[shirt][m]" class="size-input" 
                                               min="0" value="0" placeholder="0">
                                    </div>
                                    <div class="size-item">
                                        <div class="size-label">L</div>
                                        <input type="number" name="sizes[shirt][l]" class="size-input" 
                                               min="0" value="0" placeholder="0">
                                    </div>
                                    <div class="size-item">
                                        <div class="size-label">XL</div>
                                        <input type="number" name="sizes[shirt][xl]" class="size-input" 
                                               min="0" value="0" placeholder="0">
                                    </div>
                                    <div class="size-item">
                                        <div class="size-label">XXL</div>
                                        <input type="number" name="sizes[shirt][xxl]" class="size-input" 
                                               min="0" value="0" placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Shorts/Pants Sizes -->
                            <div class="panel-section size-section" id="bottomSizes" style="display: none;">
                                <h3 class="panel-section-title">
                                    <i class="fas fa-running"></i>
                                    مقاسات الشورت / البنطلون
                                </h3>
                                <div class="sizes-grid">
                                    <div class="size-item">
                                        <div class="size-label">S</div>
                                        <input type="number" name="sizes[bottom][s]" class="size-input" 
                                               min="0" value="0" placeholder="0">
                                    </div>
                                    <div class="size-item">
                                        <div class="size-label">M</div>
                                        <input type="number" name="sizes[bottom][m]" class="size-input" 
                                               min="0" value="0" placeholder="0">
                                    </div>
                                    <div class="size-item">
                                        <div class="size-label">L</div>
                                        <input type="number" name="sizes[bottom][l]" class="size-input" 
                                               min="0" value="0" placeholder="0">
                                    </div>
                                    <div class="size-item">
                                        <div class="size-label">XL</div>
                                        <input type="number" name="sizes[bottom][xl]" class="size-input" 
                                               min="0" value="0" placeholder="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 2rem;">
                            <label class="form-label">ملاحظات على المقاسات (اختياري)</label>
                            <textarea name="sizes_notes" class="form-control" rows="3" 
                                      placeholder="أي ملاحظات خاصة بالمقاسات...">{{ old('sizes_notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Step 4: Summary -->
                    <div class="form-step" id="step4">
                        <div class="step-header">
                            <h2 class="step-title">مراجعة وتأكيد الطلب</h2>
                            <p class="step-description">تأكد من صحة جميع البيانات قبل الإرسال</p>
                        </div>

                        <div class="summary-section">
                            <h3 class="summary-section-title">
                                <i class="fas fa-building"></i>
                                معلومات المؤسسة
                            </h3>
                            <div class="summary-row">
                                <span class="summary-label">الشركة:</span>
                                <span class="summary-value" id="finalCompany">-</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">الاسم:</span>
                                <span class="summary-value" id="finalName">-</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">البريد الإلكتروني:</span>
                                <span class="summary-value" id="finalEmail">-</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">الهاتف:</span>
                                <span class="summary-value" id="finalPhone">-</span>
                            </div>
                        </div>

                        <div class="summary-section">
                            <h3 class="summary-section-title">
                                <i class="fas fa-palette"></i>
                                تفاصيل التصميم
                            </h3>
                            <div class="summary-row">
                                <span class="summary-label">طريقة التصميم:</span>
                                <span class="summary-value" id="finalDesignOption">-</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">قطع الملابس:</span>
                                <span class="summary-value" id="finalPieces">-</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">اللون الرئيسي:</span>
                                <span class="summary-value" id="finalColor">-</span>
                            </div>
                        </div>

                        <div class="summary-section">
                            <h3 class="summary-section-title">
                                <i class="fas fa-ruler"></i>
                                الكميات
                            </h3>
                            <div class="summary-row">
                                <span class="summary-label">الكمية الإجمالية:</span>
                                <span class="summary-value" id="finalQuantity">-</span>
                            </div>
                        </div>

                        <div class="terms-checkbox">
                            <label>
                                <input type="checkbox" name="terms" required>
                                <span>
                                    أوافق على 
                                    <a href="#" target="_blank">الشروط والأحكام</a>
                                    و
                                    <a href="#" target="_blank">سياسة الخصوصية</a>
                                    <span class="required">*</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="form-navigation">
                <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">
                    <i class="fas fa-arrow-right"></i>
                    السابق
                </button>
                <div style="flex: 1;"></div>
                <button type="button" class="btn btn-primary" id="nextBtn">
                    التالي
                    <i class="fas fa-arrow-left"></i>
                </button>
                <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
                    <i class="fas fa-check"></i>
                    إرسال الطلب
                </button>
            </div>
        </form>
    </div>
</div>

@if ($errors->any())
<script>
    alert('يوجد أخطاء في النموذج. يرجى مراجعة البيانات المدخلة.');
</script>
@endif
</div>
@endsection

