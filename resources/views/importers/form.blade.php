@extends('layouts.app')

@section('title', 'تسجيل كمستورد - Infinity Wear')

@section('content')
<!-- قسم العنوان الرئيسي -->
<section class="hero-section hero-inner-section bg-light py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-end">
                <h1 class="display-4 fw-bold mb-3">تسجيل كمستورد</h1>
                <p class="lead mb-4">انضم إلينا كمستورد واستفد من خدماتنا المميزة في توريد الملابس بالجملة</p>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/importer-register.svg') }}" alt="تسجيل مستورد" class="img-fluid" style="max-height: 300px;">
            </div>
        </div>
    </div>
</section>

<!-- قسم نموذج التسجيل -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h3 class="mb-0">استمارة تسجيل مستورد جديد</h3>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('importers.submit') }}" method="POST" class="needs-validation" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- رسالة ترحيبية -->
                            <div class="alert alert-success text-center mb-4">
                                <i class="fas fa-magic me-2"></i>
                                <strong>مرحباً بك في مصمم التيشرت!</strong>
                                <br>
                                <small>اكتب وصفاً بسيطاً للتصميم وسيتم إنشاؤه تلقائياً في ثوانٍ معدودة</small>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-12 mb-3">
                                    <h4 class="border-bottom pb-2">المعلومات الشخصية</h4>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">كلمة المرور <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-12 mb-3">
                                    <h4 class="border-bottom pb-2">معلومات الشركة</h4>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="company_name" class="form-label">اسم الشركة/المؤسسة <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name') }}" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="business_type" class="form-label">نوع النشاط <span class="text-danger">*</span></label>
                                    <select class="form-select" id="business_type" name="business_type" required>
                                        <option value="" selected disabled>اختر نوع النشاط</option>
                                        <option value="academy" {{ old('business_type') == 'academy' ? 'selected' : '' }}>أكاديمية رياضية</option>
                                        <option value="school" {{ old('business_type') == 'school' ? 'selected' : '' }}>مدرسة</option>
                                        <option value="store" {{ old('business_type') == 'store' ? 'selected' : '' }}>متجر ملابس</option>
                                        <option value="hospital" {{ old('business_type') == 'hospital' ? 'selected' : '' }}>مستشفى</option>
                                        <option value="other" {{ old('business_type') == 'other' ? 'selected' : '' }}>أخرى</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3" id="other_business_type_div" style="display: none;">
                                    <label for="business_type_other" class="form-label">نوع النشاط (آخر) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="business_type_other" name="business_type_other" value="{{ old('business_type_other') }}">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">العنوان</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">المدينة</label>
                                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">الدولة</label>
                                    <input type="text" class="form-control" id="country" name="country" value="{{ old('country', 'المملكة العربية السعودية') }}">
                                </div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-12 mb-3">
                                    <h4 class="border-bottom pb-2">تفاصيل الطلب</h4>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <label for="requirements" class="form-label">متطلبات الطلب <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="requirements" name="requirements" rows="4" required>{{ old('requirements') }}</textarea>
                                    <div class="form-text">يرجى وصف احتياجاتك من الملابس بالتفصيل (النوع، الكمية، المواصفات، إلخ)</div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="quantity" class="form-label">الكمية المطلوبة <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', 100) }}" min="1" required>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <label class="form-label">طريقة تحديد التصميم <span class="text-danger">*</span></label>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>اختر إحدى الطرق التالية لتحديد التصميم المطلوب. سيظهر القسم المناسب تلقائياً بناءً على اختيارك.</strong>
                                    </div>
                                    
                                    <!-- Design Option Cards -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-6 col-lg-3">
                                            <div class="design-option-card" data-option="text">
                                                <div class="form-check">
                                                    <input class="form-check-input design-option" type="radio" name="design_option" id="design_option_text" value="text" {{ old('design_option') == 'text' ? 'checked' : '' }} checked>
                                                    <label class="form-check-label w-100" for="design_option_text">
                                                        <div class="text-center">
                                                            <i class="fas fa-font fa-3x text-primary mb-2"></i>
                                                            <h6 class="mb-1">وصف التصميم نصياً</h6>
                                                            <small class="text-muted">اكتب وصفاً مفصلاً للتصميم المطلوب</small>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 col-lg-3">
                                            <div class="design-option-card" data-option="upload">
                                                <div class="form-check">
                                                    <input class="form-check-input design-option" type="radio" name="design_option" id="design_option_upload" value="upload" {{ old('design_option') == 'upload' ? 'checked' : '' }}>
                                                    <label class="form-check-label w-100" for="design_option_upload">
                                                        <div class="text-center">
                                                            <i class="fas fa-upload fa-3x text-success mb-2"></i>
                                                            <h6 class="mb-1">رفع تصميم جاهز</h6>
                                                            <small class="text-muted">ارفع ملف التصميم الجاهز</small>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 col-lg-3">
                                            <div class="design-option-card" data-option="template">
                                                <div class="form-check">
                                                    <input class="form-check-input design-option" type="radio" name="design_option" id="design_option_template" value="template" {{ old('design_option') == 'template' ? 'checked' : '' }}>
                                                    <label class="form-check-label w-100" for="design_option_template">
                                                        <div class="text-center">
                                                            <i class="fas fa-cube fa-3x text-success mb-2"></i>
                                                            <h6 class="mb-1">صمم بنفسك الآن</h6>
                                                            <small class="text-muted">مجسم ثلاثي الأبعاد للرياضة</small>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <!-- وصف التصميم نصياً -->
                                    <div id="design_text_section" class="design-section" style="display: none;">
                                        <div class="card border-primary">
                                            <div class="card-header bg-primary text-white">
                                                <h6 class="mb-0">
                                                    <i class="fas fa-font me-2"></i>
                                                    وصف التصميم نصياً
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="design_details_text" class="form-label">وصف التصميم <span class="text-danger design-text-required">*</span></label>
                                                    <textarea class="form-control" id="design_details_text" name="design_details_text" rows="4" placeholder="مثال: زي رياضي أزرق مع خطوط بيضاء على الجانبين، شعار النادي على الصدر، واسم اللاعب على الظهر">{{ old('design_details_text') }}</textarea>
                                                    <div class="form-text">
                                                        <i class="fas fa-lightbulb me-1"></i>
                                                        <strong>نصائح:</strong> اذكر الألوان، الشعارات، النمط، المواد، والتفاصيل المطلوبة
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- رفع تصميم جاهز -->
                                    <div id="design_upload_section" class="design-section" style="display: none;">
                                        <div class="card border-success">
                                            <div class="card-header bg-success text-white">
                                                <h6 class="mb-0">
                                                    <i class="fas fa-upload me-2"></i>
                                                    رفع تصميم جاهز
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="design_file" class="form-label">ملف التصميم <span class="text-danger design-upload-required">*</span></label>
                                                    <input type="file" class="form-control" id="design_file" name="design_file" accept="image/*,application/pdf,.psd,.ai,.eps">
                                                    <div class="form-text">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        يمكنك رفع أي نوع من ملفات الصور (JPG, PNG, GIF, BMP, TIFF, WebP, SVG, ICO, PSD, AI, EPS) أو PDF بحجم أقصى 5MB
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="design_upload_notes" class="form-label">ملاحظات إضافية</label>
                                                    <textarea class="form-control" id="design_upload_notes" name="design_upload_notes" rows="3" placeholder="أي تعديلات أو ملاحظات إضافية على التصميم المرفوع">{{ old('design_upload_notes') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- مصمم الملابس الرياضية ثلاثي الأبعاد -->
                                    <div id="design_template_section" class="design-section" style="display: none;">
                                        <div class="card border-success">
                                            <div class="card-header bg-success text-white">
                                                <h6 class="mb-0">
                                                    <i class="fas fa-cube me-2"></i>
                                                    مصمم الملابس الرياضية ثلاثي الأبعاد
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    <strong>مرحباً بك في مصمم الملابس الرياضية!</strong>
                                                    <br>
                                                    صمم مجموعتك الرياضية المكونة من التيشرت والشورت والشراب خطوة بخطوة
                                                                </div>

                                                <!-- مرحلة التيشرت -->
                                                <div class="design-stage mb-4">
                                                    <h5 class="stage-title">
                                                        <i class="fas fa-tshirt me-2"></i>
                                                        مرحلة 1: تصميم التيشرت
                                                        <span class="badge bg-primary ms-2">مطلوب</span>
                                                    </h5>
                                                    <div class="stage-content p-3 border rounded">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="form-label">لون التيشرت</label>
                                                                <select class="form-select" name="design_3d_tshirt[color]">
                                                                    <option value="">اختر اللون</option>
                                                                    <option value="white" {{ (old('design_3d_tshirt.color') ?? '') == 'white' ? 'selected' : '' }}>أبيض</option>
                                                                    <option value="black" {{ (old('design_3d_tshirt.color') ?? '') == 'black' ? 'selected' : '' }}>أسود</option>
                                                                    <option value="red" {{ (old('design_3d_tshirt.color') ?? '') == 'red' ? 'selected' : '' }}>أحمر</option>
                                                                    <option value="blue" {{ (old('design_3d_tshirt.color') ?? '') == 'blue' ? 'selected' : '' }}>أزرق</option>
                                                                    <option value="green" {{ (old('design_3d_tshirt.color') ?? '') == 'green' ? 'selected' : '' }}>أخضر</option>
                                                                    <option value="yellow" {{ (old('design_3d_tshirt.color') ?? '') == 'yellow' ? 'selected' : '' }}>أصفر</option>
                                                                </select>
                                                                </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">نوع اللوجو</label>
                                                                <select class="form-select" name="design_3d_tshirt[logo_type]">
                                                                    <option value="">اختر النوع</option>
                                                                    <option value="academy" {{ (old('design_3d_tshirt.logo_type') ?? '') == 'academy' ? 'selected' : '' }}>لوجو أكاديمي</option>
                                                                    <option value="institution" {{ (old('design_3d_tshirt.logo_type') ?? '') == 'institution' ? 'selected' : '' }}>لوجو المنشأة</option>
                                                                    <option value="none" {{ (old('design_3d_tshirt.logo_type') ?? '') == 'none' ? 'selected' : '' }}>بدون لوجو</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label">موضع الخطوط</label>
                                                                <select class="form-select" name="design_3d_tshirt[lines_position]">
                                                                    <option value="">اختر الموضع</option>
                                                                    <option value="shoulder" {{ (old('design_3d_tshirt.lines_position') ?? '') == 'shoulder' ? 'selected' : '' }}>على الكتف</option>
                                                                    <option value="sleeve" {{ (old('design_3d_tshirt.lines_position') ?? '') == 'sleeve' ? 'selected' : '' }}>في الزراع</option>
                                                                    <option value="chest" {{ (old('design_3d_tshirt.lines_position') ?? '') == 'chest' ? 'selected' : '' }}>على الصدر</option>
                                                                    <option value="back" {{ (old('design_3d_tshirt.lines_position') ?? '') == 'back' ? 'selected' : '' }}>على الظهر</option>
                                                                </select>
                                                                </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">نص إضافي</label>
                                                                <input type="text" class="form-control" name="design_3d_tshirt[custom_text]" value="{{ old('design_3d_tshirt.custom_text') }}" placeholder="نص مخصص على التيشرت">
                                                                </div>
                                                            </div>
                                                        </div>
                                                                </div>

                                                <!-- مرحلة الشورت -->
                                                <div class="design-stage mb-4">
                                                    <h5 class="stage-title">
                                                        <i class="fas fa-user-md me-2"></i>
                                                        مرحلة 2: تصميم الشورت
                                                        <span class="badge bg-secondary ms-2">اختياري</span>
                                                    </h5>
                                                    <div class="stage-content p-3 border rounded">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="form-label">لون الشورت</label>
                                                                <select class="form-select" name="design_3d_shorts[color]">
                                                                    <option value="">اختر اللون</option>
                                                                    <option value="white" {{ (old('design_3d_shorts.color') ?? '') == 'white' ? 'selected' : '' }}>أبيض</option>
                                                                    <option value="black" {{ (old('design_3d_shorts.color') ?? '') == 'black' ? 'selected' : '' }}>أسود</option>
                                                                    <option value="red" {{ (old('design_3d_shorts.color') ?? '') == 'red' ? 'selected' : '' }}>أحمر</option>
                                                                    <option value="blue" {{ (old('design_3d_shorts.color') ?? '') == 'blue' ? 'selected' : '' }}>أزرق</option>
                                                                    <option value="green" {{ (old('design_3d_shorts.color') ?? '') == 'green' ? 'selected' : '' }}>أخضر</option>
                                                                    <option value="yellow" {{ (old('design_3d_shorts.color') ?? '') == 'yellow' ? 'selected' : '' }}>أصفر</option>
                                                                </select>
                                                                </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">نوع اللوجو</label>
                                                                <select class="form-select" name="design_3d_shorts[logo_type]">
                                                                    <option value="">اختر النوع</option>
                                                                    <option value="academy" {{ (old('design_3d_shorts.logo_type') ?? '') == 'academy' ? 'selected' : '' }}>لوجو أكاديمي</option>
                                                                    <option value="institution" {{ (old('design_3d_shorts.logo_type') ?? '') == 'institution' ? 'selected' : '' }}>لوجو المنشأة</option>
                                                                    <option value="none" {{ (old('design_3d_shorts.logo_type') ?? '') == 'none' ? 'selected' : '' }}>بدون لوجو</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label">موضع الخطوط</label>
                                                                <select class="form-select" name="design_3d_shorts[lines_position]">
                                                                    <option value="">اختر الموضع</option>
                                                                    <option value="side" {{ (old('design_3d_shorts.lines_position') ?? '') == 'side' ? 'selected' : '' }}>على الجانبين</option>
                                                                    <option value="front" {{ (old('design_3d_shorts.lines_position') ?? '') == 'front' ? 'selected' : '' }}>على الأمام</option>
                                                                    <option value="back" {{ (old('design_3d_shorts.lines_position') ?? '') == 'back' ? 'selected' : '' }}>على الخلف</option>
                                                                </select>
                                                    </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">نص إضافي</label>
                                                                <input type="text" class="form-control" name="design_3d_shorts[custom_text]" value="{{ old('design_3d_shorts.custom_text') }}" placeholder="نص مخصص على الشورت">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                                <!-- مرحلة الشراب -->
                                                <div class="design-stage mb-4">
                                                    <h5 class="stage-title">
                                                        <i class="fas fa-socks me-2"></i>
                                                        مرحلة 3: تصميم الشراب
                                                        <span class="badge bg-secondary ms-2">اختياري</span>
                                                    </h5>
                                                    <div class="stage-content p-3 border rounded">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="form-label">لون الشراب</label>
                                                                <select class="form-select" name="design_3d_socks[color]">
                                                                    <option value="">اختر اللون</option>
                                                                    <option value="white" {{ (old('design_3d_socks.color') ?? '') == 'white' ? 'selected' : '' }}>أبيض</option>
                                                                    <option value="black" {{ (old('design_3d_socks.color') ?? '') == 'black' ? 'selected' : '' }}>أسود</option>
                                                                    <option value="red" {{ (old('design_3d_socks.color') ?? '') == 'red' ? 'selected' : '' }}>أحمر</option>
                                                                    <option value="blue" {{ (old('design_3d_socks.color') ?? '') == 'blue' ? 'selected' : '' }}>أزرق</option>
                                                                    <option value="green" {{ (old('design_3d_socks.color') ?? '') == 'green' ? 'selected' : '' }}>أخضر</option>
                                                                    <option value="yellow" {{ (old('design_3d_socks.color') ?? '') == 'yellow' ? 'selected' : '' }}>أصفر</option>
                                                                </select>
                                            </div>
                                                        <div class="col-md-6">
                                                                <label class="form-label">نوع اللوجو</label>
                                                                <select class="form-select" name="design_3d_socks[logo_type]">
                                                                    <option value="">اختر النوع</option>
                                                                    <option value="academy" {{ (old('design_3d_socks.logo_type') ?? '') == 'academy' ? 'selected' : '' }}>لوجو أكاديمي</option>
                                                                    <option value="institution" {{ (old('design_3d_socks.logo_type') ?? '') == 'institution' ? 'selected' : '' }}>لوجو المنشأة</option>
                                                                    <option value="none" {{ (old('design_3d_socks.logo_type') ?? '') == 'none' ? 'selected' : '' }}>بدون لوجو</option>
                                                                </select>
                                                                        </div>
                                                                </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label">موضع الخطوط</label>
                                                                <select class="form-select" name="design_3d_socks[lines_position]">
                                                                    <option value="">اختر الموضع</option>
                                                                    <option value="top" {{ (old('design_3d_socks.lines_position') ?? '') == 'top' ? 'selected' : '' }}>أعلى الشراب</option>
                                                                    <option value="bottom" {{ (old('design_3d_socks.lines_position') ?? '') == 'bottom' ? 'selected' : '' }}>أسفل الشراب</option>
                                                                    <option value="side" {{ (old('design_3d_socks.lines_position') ?? '') == 'side' ? 'selected' : '' }}>على الجانبين</option>
                                                                </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                                <label class="form-label">نص إضافي</label>
                                                                <input type="text" class="form-control" name="design_3d_socks[custom_text]" value="{{ old('design_3d_socks.custom_text') }}" placeholder="نص مخصص على الشراب">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- أدوات التصميم ثلاثي الأبعاد -->
                                                <div class="row mt-4">
                                                    <div class="col-md-6">
                                                        <h6><i class="fas fa-tools me-2"></i>أدوات التصميم</h6>
                                                        <div class="btn-group-vertical w-100" role="group">
                                                            <button type="button" class="btn btn-outline-primary" id="preview-3d-btn">
                                                                <i class="fas fa-eye me-2"></i>معاينة ثلاثية الأبعاد
                                                            </button>
                                                            <button type="button" class="btn btn-outline-warning" id="animate-toggle-btn">
                                                                <i class="fas fa-play me-2"></i>تشغيل الحركة
                                                            </button>
                                                            <button type="button" class="btn btn-outline-success" id="save-design-btn">
                                                                <i class="fas fa-save me-2"></i>حفظ التصميم
                                                            </button>
                                                            <button type="button" class="btn btn-outline-info" id="download-design-btn">
                                                                <i class="fas fa-download me-2"></i>تحميل التصميم
                                                            </button>
                                                        </div>
                                                            </div>
                                                    <div class="col-md-6">
                                                        <h6><i class="fas fa-cube me-2"></i>معاينة التصميم ثلاثي الأبعاد</h6>
                                                        <div class="design-preview-container">
                                                            <div class="preview-header text-center mb-2">
                                                                <small class="text-muted">
                                                                    <i class="fas fa-info-circle me-1"></i>
                                                                    قم بتغيير خيارات التصميم لترى التحديث فورًا على المجسم
                                                                </small>
                                                                <div class="mt-1">
                                                                    <small class="text-success">
                                                                        <i class="fas fa-check-circle me-1"></i>
                                                                        مجسم محدث: FinalBaseMesh.obj - مجسم عالي الجودة
                                                                    </small>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <a href="{{ route('3d.model.viewer') }}" class="btn btn-sm btn-primary" target="_blank">
                                                                        <i class="fas fa-cube me-1"></i>فتح المجسم ثلاثي الأبعاد
                                                                    </a>
                                                                </div>
                                                                <div class="mt-1">
                                                                    <small class="text-primary">
                                                                        <i class="fas fa-mouse-pointer me-1"></i>
                                                                        اسحب بالماوس للدوران • استخدم عجلة الماوس للتكبير
                                                                    </small>
                                                                </div>
                                                                <div class="mt-1">
                                                                    <small class="text-muted">
                                                                        <i class="fas fa-info-circle me-1"></i>
                                                                        مجسم ثلاثي الأبعاد عالي الجودة مع تفاصيل دقيقة
                                                                    </small>
                                                                </div>
                                                                <div class="mt-1">
                                                                    <small class="text-warning">
                                                                        <i class="fas fa-lightbulb me-1"></i>
                                                                        انقر على "فتح المجسم ثلاثي الأبعاد" لتحميل ملف FinalBaseMesh.obj
                                                                    </small>
                                                                </div>
                                                                <div class="mt-1">
                                                                    <small class="text-success">
                                                                        <i class="fas fa-keyboard me-1"></i>
                                                                        مفاتيح الكيبورد: أسهم للدوران • W/A/S/D للحركة • Z/X للتكبير • R للإعادة تعيين
                                                                    </small>
                                                                </div>
                                                                <div class="mt-1">
                                                                    <small class="text-primary">
                                                                        <i class="fas fa-star me-1"></i>
                                                                        مجسم عالي الجودة مع تفاصيل دقيقة للتصميم الاحترافي
                                                                    </small>
                                                                </div>
                                                    </div>
                                                            <div id="design-preview-canvas" style="width: 100%; height: 400px; border: 2px solid #e0e0e0; border-radius: 10px; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                                                <i class="fas fa-cube fa-3x text-muted mb-3"></i>
                                                                <h5 class="text-muted">معاينة المجسم ثلاثي الأبعاد</h5>
                                                                <p class="text-muted text-center">انقر على "فتح المجسم ثلاثي الأبعاد" لتحميل FinalBaseMesh.obj</p>
                                                                <a href="{{ route('3d.model.viewer') }}" class="btn btn-primary" target="_blank">
                                                                    <i class="fas fa-external-link-alt me-2"></i>فتح في نافذة جديدة
                                                                </a>
                                                            </div>
                                                            <div class="canvas-controls mt-2">
                                                                <button type="button" class="btn btn-sm btn-outline-secondary me-1" id="rotate-left-3d" title="دوران يسار">
                                                                    <i class="fas fa-undo"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-secondary me-1" id="rotate-right-3d" title="دوران يمين">
                                                                    <i class="fas fa-redo"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-secondary me-1" id="reset-3d-view" title="إعادة تعيين العرض">
                                                                    <i class="fas fa-home"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-secondary me-1" id="zoom-in-3d" title="تكبير">
                                                                    <i class="fas fa-search-plus"></i>
                                                        </button>
                                                                <button type="button" class="btn btn-sm btn-outline-secondary" id="zoom-out-3d" title="تصغير">
                                                                    <i class="fas fa-search-minus"></i>
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
                            
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    أوافق على <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">الشروط والأحكام</a> <span class="text-danger">*</span>
                                </label>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">تسجيل كمستورد</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal للشروط والأحكام -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">الشروط والأحكام</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>شروط التسجيل كمستورد</h5>
                <p>يرجى قراءة الشروط والأحكام التالية بعناية قبل التسجيل كمستورد في منصة Infinity Wear:</p>
                
                <ol>
                    <li>يجب أن تكون جميع المعلومات المقدمة في نموذج التسجيل صحيحة ودقيقة.</li>
                    <li>يجب أن يكون المستورد كيانًا تجاريًا قانونيًا مسجلًا.</li>
                    <li>الحد الأدنى للطلب هو 100 قطعة للمنتج الواحد.</li>
                    <li>تخضع جميع الطلبات للمراجعة والموافقة من قبل فريقنا.</li>
                    <li>سيتم التواصل معك خلال 48 ساعة من تقديم الطلب.</li>
                    <li>تحتفظ Infinity Wear بالحق في رفض أي طلب دون إبداء الأسباب.</li>
                </ol>
                
                <h5>سياسة الخصوصية</h5>
                <p>نحن نحترم خصوصية بياناتك ونلتزم بحمايتها وفقًا لسياسة الخصوصية الخاصة بنا.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.design-option-card {
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
    background: white;
    height: 100%;
}

.design-option-card:hover {
    border-color: #007bff;
    background-color: rgba(0, 123, 255, 0.05);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
}

.design-option-card.selected {
    border-color: #007bff;
    background-color: rgba(0, 123, 255, 0.1);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
}

.design-option-card .form-check-input {
    position: absolute;
    opacity: 0;
}

.design-option-card .form-check-label {
    cursor: pointer;
    margin: 0;
}

.design-template-item {
    border: 3px solid transparent;
    border-radius: 10px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
    background: white;
}

.design-template-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    border-color: #ffc107;
}

.design-template-item.selected {
    border-color: #ffc107;
    box-shadow: 0 10px 20px rgba(255, 193, 7, 0.3);
}

.design-template-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.design-section {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.card-header {
    font-weight: 600;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
}

.alert {
    border-radius: 8px;
}

.btn {
    border-radius: 6px;
    font-weight: 500;
}

.form-control, .form-select {
    border-radius: 6px;
    border: 1px solid #ced4da;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* 3D T-Shirt Designer Styles */
.design-mode-card {
    border: 3px solid #e0e0e0;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
    background: white;
    position: relative;
    overflow: hidden;
}

.design-mode-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.5s;
}

.design-mode-card:hover::before {
    left: 100%;
}

.design-mode-card:hover {
    border-color: #28a745;
    background-color: rgba(40, 167, 69, 0.05);
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.2);
}

.design-mode-card.selected {
    border-color: #28a745;
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.05));
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
    transform: translateY(-3px);
}

.design-mode-card .form-check-input {
    position: absolute;
    opacity: 0;
}

.design-mode-card .form-check-label {
    cursor: pointer;
    margin: 0;
}

.tshirt-preview-container {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    border: 2px dashed #dee2e6;
}

.tshirt-3d-view {
    position: relative;
    display: inline-block;
}

#tshirt-canvas {
    border: 2px solid #007bff;
    border-radius: 10px;
    background: white;
    cursor: crosshair;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.tshirt-controls {
    margin-top: 10px;
    display: flex;
    gap: 5px;
    justify-content: center;
}

.design-mode-section {
    animation: fadeIn 0.3s ease-in;
}

.btn-group .btn.active {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.form-control-color {
    height: 38px;
    padding: 0;
    border: 1px solid #ced4da;
    border-radius: 6px;
}

.form-range {
    height: 6px;
    background: #dee2e6;
    border-radius: 3px;
}

.form-range::-webkit-slider-thumb {
    background: #007bff;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.form-range::-moz-range-thumb {
    background: #007bff;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

/* 3D Design Preview Styles */
.design-preview-container {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    border: 2px dashed #dee2e6;
    position: relative;
    overflow: hidden;
}

.canvas-controls {
    display: flex;
    justify-content: center;
    gap: 5px;
    flex-wrap: wrap;
    margin-top: 10px;
}

.canvas-controls .btn {
    min-width: 35px;
    height: 35px;
    padding: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#design-preview-canvas {
    cursor: grab;
    transition: transform 0.1s ease;
}

#design-preview-canvas:active {
    cursor: grabbing;
}

/* Enhanced 3D Design Interactions */
.design-stage .stage-content {
    transition: all 0.3s ease;
}

.design-stage:hover .stage-content {
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
    transform: translateY(-2px);
}

/* Live preview indicator */
.design-preview-container::after {
    content: 'معاينة مباشرة';
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0, 123, 255, 0.9);
    color: white;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 500;
    z-index: 10;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 0.7; }
    50% { opacity: 1; }
    100% { opacity: 0.7; }
}

/* Design options highlighting */
.design-stage input:focus,
.design-stage select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* 3D Model enhancements */
#design-preview-canvas {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 10px;
    box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

#design-preview-canvas:hover {
    transform: scale(1.02);
    box-shadow: inset 0 0 30px rgba(0, 123, 255, 0.1);
}

/* Control buttons styling */
.canvas-controls .btn {
    transition: all 0.3s ease;
}

.canvas-controls .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

/* Stage badges */
.stage-title .badge {
    font-size: 0.75rem;
    padding: 4px 8px;
}

.stage-title .badge.bg-primary {
    background-color: #007bff !important;
}

.stage-title .badge.bg-secondary {
    background-color: #6c757d !important;
}

/* Animation button styling */
.btn-outline-warning {
    border-color: #ffc107;
    color: #ffc107;
}

.btn-outline-warning:hover {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #212529;
}

.btn-outline-danger {
    border-color: #dc3545;
    color: #dc3545;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #ffffff;
}

/* Enhanced canvas styling for 3D effect */
#design-preview-canvas {
    background: radial-gradient(ellipse at center, #f8f9fa 0%, #e9ecef 70%, #dee2e6 100%);
    border-radius: 15px;
    box-shadow:
        inset 0 0 30px rgba(0, 0, 0, 0.1),
        0 5px 25px rgba(0, 0, 0, 0.15);
    transition: all 0.4s ease;
}

#design-preview-canvas:hover {
    transform: scale(1.02);
    box-shadow:
        inset 0 0 40px rgba(0, 123, 255, 0.1),
        0 8px 35px rgba(0, 0, 0, 0.2);
}

/* Breathing animation indicator */
@keyframes breathe {
    0%, 100% { opacity: 0.7; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.02); }
}

#design-preview-canvas.breathing {
    animation: breathe 2s ease-in-out infinite;
}

.design-stage .stage-title {
    border-bottom: 2px solid #dee2e6;
    padding-bottom: 10px;
    margin-bottom: 15px;
}

.design-stage .stage-content {
    background: #f8f9fa;
    border-radius: 8px;
}

.preview-header {
    background: rgba(0, 123, 255, 0.1);
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid rgba(0, 123, 255, 0.2);
}

.preview-header small {
    font-size: 0.8rem;
    display: block;
    line-height: 1.4;
}

.preview-header .text-primary {
    font-weight: 500;
    margin-top: 4px;
}
</style>
@endsection

@section('scripts')
<!-- Three.js Library for 3D Model Loading -->
<script src="https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.160.0/examples/js/loaders/OBJLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.160.0/examples/js/controls/OrbitControls.js"></script>

<script>
    // 3D T-Shirt Designer - FinalBaseMesh.obj Integration
    // Vertices: 24,461 | Triangles: 48,918 | Size: 11.69 x 20.74 x 3.77
    // Volume: 120.08 | Surface: 267.18
    
    // Three.js variables for real 3D model loading
    var scene, camera, renderer, controls;
    var humanModel, tshirtMesh, shortsMesh, socksMesh;
    
    // Initialize 3D Scene - Auto load FinalBaseMesh.obj
    function initCanvas() {
        // Wait for DOM to be fully loaded
        if (document.readyState !== 'complete') {
            setTimeout(initCanvas, 100);
            return;
        }

        // Always initialize real 3D scene with FinalBaseMesh.obj
        if (typeof THREE !== 'undefined') {
            initReal3DScene();
        } else {
            console.error('Three.js not loaded');
        }
    }
    
    // Initialize real 3D scene with Three.js - Auto load FinalBaseMesh.obj
    function initReal3DScene() {
        const container = document.getElementById('design-preview-canvas');
        if (!container) {
            console.error('3D container not found');
            return;
        }
        
        // Clear container
        container.innerHTML = '';
        
        // Create scene
        scene = new THREE.Scene();
        scene.background = new THREE.Color(0xf0f0f0);
        
        // Create camera
        camera = new THREE.PerspectiveCamera(75, container.clientWidth / container.clientHeight, 0.1, 1000);
        camera.position.set(0, 0, 5);
        
        // Create renderer
        renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(container.clientWidth, container.clientHeight);
        renderer.shadowMap.enabled = true;
        renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        container.appendChild(renderer.domElement);
        
        // Add controls
        controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.05;
        
        // Add lighting
        const ambientLight = new THREE.AmbientLight(0x404040, 0.6);
        scene.add(ambientLight);
        
        const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
        directionalLight.position.set(10, 10, 5);
        directionalLight.castShadow = true;
        scene.add(directionalLight);
        
        // Auto load the human model
        loadHumanModel();
        
        // Start render loop
        animate();
        
        console.log('FinalBaseMesh.obj 3D scene initialized successfully');
    }
    
    
    // Load FinalBaseMesh.obj automatically
    function loadHumanModel() {
        const loader = new THREE.OBJLoader();
        
        // Show loading message
        const loadingMessage = document.getElementById('loading-message');
        if (loadingMessage) {
            loadingMessage.style.display = 'block';
        }
        
        loader.load(
            '{{ asset("images/FinalBaseMesh.obj") }}',
            function (object) {
                console.log('FinalBaseMesh.obj loaded successfully');
                
                // Hide loading message and show success message
                if (loadingMessage) {
                    loadingMessage.style.display = 'none';
                }
                
                const successMessage = document.getElementById('success-message');
                if (successMessage) {
                    successMessage.style.display = 'block';
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 3000);
                }
                
                // Scale and position the model
                object.scale.set(0.1, 0.1, 0.1);
                object.position.set(0, -2, 0);
                
                // Apply material to the model
                const material = new THREE.MeshLambertMaterial({ 
                    color: 0xffdbac,
                    transparent: true,
                    opacity: 0.9
                });
                
                object.traverse(function (child) {
                    if (child instanceof THREE.Mesh) {
                        child.material = material;
                        child.castShadow = true;
                        child.receiveShadow = true;
                    }
                });
                
                humanModel = object;
                scene.add(humanModel);
                
                // Create clothing meshes
                createClothingMeshes();
                
                // Update design when clothing options change
                updateClothingDesign();
                
            },
            function (progress) {
                console.log('Loading progress: ' + (progress.loaded / progress.total * 100) + '%');
                if (loadingMessage) {
                    loadingMessage.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>جاري تحميل FinalBaseMesh.obj... ' + Math.round(progress.loaded / progress.total * 100) + '%';
                }
            },
            function (error) {
                console.error('Error loading FinalBaseMesh.obj:', error);
                
                // Hide loading message and show error message
                if (loadingMessage) {
                    loadingMessage.style.display = 'none';
                }
                
                const errorMessage = document.getElementById('error-message');
                if (errorMessage) {
                    errorMessage.style.display = 'block';
                    setTimeout(() => {
                        errorMessage.style.display = 'none';
                    }, 5000);
                }
            }
        );
    }
    
    // Create clothing meshes for the human model
    function createClothingMeshes() {
        if (!humanModel) return;
        
        // Create t-shirt mesh
        const tshirtGeometry = new THREE.SphereGeometry(1.2, 32, 16, 0, Math.PI * 2, 0, Math.PI * 0.6);
        const tshirtMaterial = new THREE.MeshLambertMaterial({ 
            color: 0xff6b6b,
            transparent: true,
            opacity: 0.8
        });
        tshirtMesh = new THREE.Mesh(tshirtGeometry, tshirtMaterial);
        tshirtMesh.position.set(0, 0.5, 0);
        tshirtMesh.scale.set(0.1, 0.1, 0.1);
        scene.add(tshirtMesh);
        
        // Create shorts mesh
        const shortsGeometry = new THREE.CylinderGeometry(0.8, 0.6, 1.5, 16);
        const shortsMaterial = new THREE.MeshLambertMaterial({ 
            color: 0x4dabf7,
            transparent: true,
            opacity: 0.8
        });
        shortsMesh = new THREE.Mesh(shortsGeometry, shortsMaterial);
        shortsMesh.position.set(0, -1.2, 0);
        shortsMesh.scale.set(0.1, 0.1, 0.1);
        scene.add(shortsMesh);
        
        // Create socks mesh
        const socksGeometry = new THREE.CylinderGeometry(0.3, 0.25, 0.8, 16);
        const socksMaterial = new THREE.MeshLambertMaterial({ 
            color: 0xffffff,
            transparent: true,
            opacity: 0.9
        });
        socksMesh = new THREE.Mesh(socksGeometry, socksMaterial);
        socksMesh.position.set(0, -2.8, 0);
        socksMesh.scale.set(0.1, 0.1, 0.1);
        scene.add(socksMesh);
    }
    
    // Update clothing design based on current options
    function updateClothingDesign() {
        const designOptions = getCurrentDesignOptions();
        
        // Update t-shirt color
        if (tshirtMesh && designOptions.tshirt) {
            tshirtMesh.material.color.setHex(parseInt(designOptions.tshirt.color.replace('#', ''), 16));
        }
        
        // Update shorts color
        if (shortsMesh && designOptions.shorts) {
            shortsMesh.material.color.setHex(parseInt(designOptions.shorts.color.replace('#', ''), 16));
        }
        
        // Update socks color
        if (socksMesh && designOptions.socks) {
            socksMesh.material.color.setHex(parseInt(designOptions.socks.color.replace('#', ''), 16));
        }
    }
    
    // Animation loop for 3D scene
    function animate() {
        requestAnimationFrame(animate);
        
        if (controls) {
            controls.update();
        }
        
        if (renderer && scene && camera) {
            renderer.render(scene, camera);
        }
    }
    












    // Draw detailed torso with realistic muscles and anatomy
    function drawDetailedTorso(centerX, centerY, tshirtOptions) {
        const tshirtColor = tshirtOptions?.color || '#ff6b6b';

        // Main torso outline with updated proportions based on FinalBaseMesh.obj
        // Size X: 11.69, Size Y: 20.74 - More realistic athletic proportions
        ctx.beginPath();
        ctx.moveTo(centerX - 52, centerY - 72); // Wider shoulders for new mesh
        ctx.lineTo(centerX + 52, centerY - 72);
        ctx.lineTo(centerX + 45, centerY + 90); // Narrower waist, longer torso
        ctx.lineTo(centerX - 45, centerY + 90);
        ctx.closePath();
        ctx.fillStyle = tshirtColor;
        ctx.fill();

        // Torso outline
        ctx.strokeStyle = darkenColor(tshirtColor, 30);
        ctx.lineWidth = 2.5;
        ctx.stroke();

        // Chest muscles (pectoralis major) - more realistic shape
        ctx.beginPath();
        ctx.moveTo(centerX - 35, centerY - 60);
        ctx.lineTo(centerX - 15, centerY - 55);
        ctx.lineTo(centerX - 20, centerY - 35);
        ctx.lineTo(centerX - 35, centerY - 40);
        ctx.lineTo(centerX - 40, centerY - 50);
        ctx.closePath();
        ctx.fillStyle = lightenColor(tshirtColor, 20);
        ctx.fill();

        ctx.beginPath();
        ctx.moveTo(centerX + 35, centerY - 60);
        ctx.lineTo(centerX + 15, centerY - 55);
        ctx.lineTo(centerX + 20, centerY - 35);
        ctx.lineTo(centerX + 35, centerY - 40);
        ctx.lineTo(centerX + 40, centerY - 50);
        ctx.closePath();
        ctx.fillStyle = lightenColor(tshirtColor, 20);
        ctx.fill();

        // Chest separation line (sternum)
        ctx.strokeStyle = darkenColor(tshirtColor, 40);
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(centerX, centerY - 65);
        ctx.lineTo(centerX, centerY - 25);
        ctx.stroke();

        // Abdominal muscles (rectus abdominis) - 8-pack for athletic look
        const absY = centerY + 5;
        const absSpacing = 10;

        for (let row = 0; row < 4; row++) {
            for (let col = 0; col < 2; col++) {
                const absX = centerX - 5 + (col * absSpacing);
                const absCurrentY = absY + (row * absSpacing);

                ctx.beginPath();
                ctx.arc(absX, absCurrentY, 5, 0, 2 * Math.PI);
                ctx.fillStyle = darkenColor(tshirtColor, 15);
                ctx.fill();

                // Inner shadow for muscle definition
                ctx.beginPath();
                ctx.arc(absX - 1, absCurrentY - 1, 3, 0, 2 * Math.PI);
                ctx.fillStyle = darkenColor(tshirtColor, 25);
                ctx.fill();
            }
        }

        // Obliques (side abdominal muscles)
        ctx.fillStyle = lightenColor(tshirtColor, 10);

        ctx.beginPath();
        ctx.moveTo(centerX - 45, centerY - 20);
        ctx.lineTo(centerX - 35, centerY - 15);
        ctx.lineTo(centerX - 38, centerY + 20);
        ctx.lineTo(centerX - 48, centerY + 15);
        ctx.closePath();
        ctx.fill();

        ctx.beginPath();
        ctx.moveTo(centerX + 45, centerY - 20);
        ctx.lineTo(centerX + 35, centerY - 15);
        ctx.lineTo(centerX + 38, centerY + 20);
        ctx.lineTo(centerX + 48, centerY + 15);
        ctx.closePath();
        ctx.fill();

        // Apply T-shirt design elements
        if (tshirtOptions) {
            drawTshirtDesign(centerX, centerY, tshirtOptions);
        }
    }

    // Draw detailed arms with realistic muscles and anatomy
    function drawDetailedArms(centerX, centerY) {
        // Left Arm - Updated proportions for FinalBaseMesh.obj
        // More realistic arm proportions based on new mesh specifications
        ctx.beginPath();
        ctx.moveTo(centerX - 48, centerY - 65); // Shoulder joint - updated position
        ctx.lineTo(centerX - 78, centerY - 45); // Top of bicep - longer arm
        ctx.lineTo(centerX - 73, centerY - 25); // Bicep peak - updated
        ctx.lineTo(centerX - 63, centerY - 20); // Inside bicep - updated
        ctx.lineTo(centerX - 53, centerY - 40); // Bottom of bicep - updated
        ctx.lineTo(centerX - 48, centerY - 55); // Back to shoulder - updated
        ctx.closePath();
        ctx.fillStyle = '#ffdbac';
        ctx.fill();

        // Left arm outline
        ctx.strokeStyle = '#e6c29a';
        ctx.lineWidth = 2;
        ctx.stroke();

        // Left bicep muscle definition
        ctx.beginPath();
        ctx.moveTo(centerX - 65, centerY - 35);
        ctx.lineTo(centerX - 55, centerY - 30);
        ctx.lineTo(centerX - 60, centerY - 20);
        ctx.lineTo(centerX - 70, centerY - 25);
        ctx.closePath();
        ctx.fillStyle = '#ffb366';
        ctx.fill();

        // Left forearm (brachioradialis and flexor muscles)
        ctx.beginPath();
        ctx.moveTo(centerX - 75, centerY - 40);
        ctx.lineTo(centerX - 85, centerY + 5); // Elbow to wrist
        ctx.lineTo(centerX - 75, centerY + 10);
        ctx.lineTo(centerX - 70, centerY - 20);
        ctx.closePath();
        ctx.fillStyle = '#ffdbac';
        ctx.fill();
        ctx.strokeStyle = '#e6c29a';
        ctx.stroke();

        // Right Arm - Upper arm (biceps brachii)
        ctx.beginPath();
        ctx.moveTo(centerX + 45, centerY - 60); // Shoulder joint
        ctx.lineTo(centerX + 75, centerY - 40); // Top of bicep
        ctx.lineTo(centerX + 70, centerY - 20); // Bicep peak
        ctx.lineTo(centerX + 60, centerY - 15); // Inside bicep
        ctx.lineTo(centerX + 50, centerY - 35); // Bottom of bicep
        ctx.lineTo(centerX + 45, centerY - 50); // Back to shoulder
        ctx.closePath();
        ctx.fillStyle = '#ffdbac';
        ctx.fill();

        // Right arm outline
        ctx.strokeStyle = '#e6c29a';
        ctx.lineWidth = 2;
        ctx.stroke();

        // Right bicep muscle definition
        ctx.beginPath();
        ctx.moveTo(centerX + 65, centerY - 35);
        ctx.lineTo(centerX + 55, centerY - 30);
        ctx.lineTo(centerX + 60, centerY - 20);
        ctx.lineTo(centerX + 70, centerY - 25);
        ctx.closePath();
        ctx.fillStyle = '#ffb366';
        ctx.fill();

        // Right forearm
        ctx.beginPath();
        ctx.moveTo(centerX + 75, centerY - 40);
        ctx.lineTo(centerX + 85, centerY + 5); // Elbow to wrist
        ctx.lineTo(centerX + 75, centerY + 10);
        ctx.lineTo(centerX + 70, centerY - 20);
        ctx.closePath();
        ctx.fillStyle = '#ffdbac';
        ctx.fill();
        ctx.strokeStyle = '#e6c29a';
        ctx.stroke();

        // Add subtle muscle shadows for depth
        ctx.globalAlpha = 0.3;
        ctx.fillStyle = '#cc9966';

        // Left arm shadow
        ctx.beginPath();
        ctx.arc(centerX - 65, centerY - 30, 12, 0, 2 * Math.PI);
        ctx.fill();

        // Right arm shadow
        ctx.beginPath();
        ctx.arc(centerX + 65, centerY - 30, 12, 0, 2 * Math.PI);
        ctx.fill();

        ctx.globalAlpha = 1;
    }

    // Draw detailed legs with realistic muscles and anatomy
    function drawDetailedLegs(centerX, centerY, shortsOptions, socksOptions) {
        const shortsColor = shortsOptions?.color || '#4dabf7';
        const socksColor = socksOptions?.color || '#ffffff';

        // Left Thigh - Updated proportions for FinalBaseMesh.obj
        // More realistic leg proportions based on new mesh specifications
        ctx.beginPath();
        ctx.moveTo(centerX - 30, centerY + 90); // Hip joint - updated position
        ctx.lineTo(centerX - 42, centerY + 130); // Outside thigh - longer
        ctx.lineTo(centerX - 27, centerY + 155); // Knee front - updated
        ctx.lineTo(centerX - 17, centerY + 150); // Inside thigh - updated
        ctx.lineTo(centerX - 22, centerY + 95); // Back to hip - updated
        ctx.closePath();
        ctx.fillStyle = shortsColor;
        ctx.fill();

        // Left thigh outline
        ctx.strokeStyle = darkenColor(shortsColor, 30);
        ctx.lineWidth = 2.5;
        ctx.stroke();

        // Left quadriceps muscle definition (vastus lateralis)
        ctx.fillStyle = lightenColor(shortsColor, 15);
        ctx.beginPath();
        ctx.moveTo(centerX - 35, centerY + 100);
        ctx.lineTo(centerX - 25, centerY + 95);
        ctx.lineTo(centerX - 28, centerY + 115);
        ctx.lineTo(centerX - 38, centerY + 120);
        ctx.closePath();
        ctx.fill();

        // Left thigh inner muscle (vastus medialis)
        ctx.beginPath();
        ctx.moveTo(centerX - 22, centerY + 100);
        ctx.lineTo(centerX - 18, centerY + 105);
        ctx.lineTo(centerX - 22, centerY + 125);
        ctx.lineTo(centerX - 26, centerY + 120);
        ctx.closePath();
        ctx.fill();

        // Left Calf - Gastrocnemius and Soleus muscles
        ctx.beginPath();
        ctx.moveTo(centerX - 40, centerY + 125);
        ctx.lineTo(centerX - 45, centerY + 190); // Calf muscle bulge
        ctx.lineTo(centerX - 30, centerY + 195);
        ctx.lineTo(centerX - 25, centerY + 150);
        ctx.closePath();
        ctx.fillStyle = socksColor;
        ctx.fill();

        // Left calf outline
        ctx.strokeStyle = darkenColor(socksColor, 25);
        ctx.stroke();

        // Left calf muscle definition (gastrocnemius heads)
        ctx.fillStyle = lightenColor(socksColor, 10);
        ctx.beginPath();
        ctx.arc(centerX - 37, centerY + 155, 8, 0, 2 * Math.PI);
        ctx.fill();

        ctx.beginPath();
        ctx.arc(centerX - 33, centerY + 145, 6, 0, 2 * Math.PI);
        ctx.fill();

        // Right Thigh - Quadriceps femoris
        ctx.beginPath();
        ctx.moveTo(centerX + 28, centerY + 85); // Hip joint
        ctx.lineTo(centerX + 40, centerY + 125); // Outside thigh
        ctx.lineTo(centerX + 25, centerY + 150); // Knee front
        ctx.lineTo(centerX + 15, centerY + 145); // Inside thigh
        ctx.lineTo(centerX + 20, centerY + 90); // Back to hip
        ctx.closePath();
        ctx.fillStyle = shortsColor;
        ctx.fill();

        // Right thigh outline
        ctx.strokeStyle = darkenColor(shortsColor, 30);
        ctx.lineWidth = 2.5;
        ctx.stroke();

        // Right quadriceps muscle definition
        ctx.fillStyle = lightenColor(shortsColor, 15);
        ctx.beginPath();
        ctx.moveTo(centerX + 35, centerY + 100);
        ctx.lineTo(centerX + 25, centerY + 95);
        ctx.lineTo(centerX + 28, centerY + 115);
        ctx.lineTo(centerX + 38, centerY + 120);
        ctx.closePath();
        ctx.fill();

        ctx.beginPath();
        ctx.moveTo(centerX + 22, centerY + 100);
        ctx.lineTo(centerX + 18, centerY + 105);
        ctx.lineTo(centerX + 22, centerY + 125);
        ctx.lineTo(centerX + 26, centerY + 120);
        ctx.closePath();
        ctx.fill();

        // Right Calf
        ctx.beginPath();
        ctx.moveTo(centerX + 40, centerY + 125);
        ctx.lineTo(centerX + 45, centerY + 190); // Calf muscle bulge
        ctx.lineTo(centerX + 30, centerY + 195);
        ctx.lineTo(centerX + 25, centerY + 150);
        ctx.closePath();
        ctx.fillStyle = socksColor;
        ctx.fill();

        // Right calf outline
        ctx.strokeStyle = darkenColor(socksColor, 25);
        ctx.stroke();

        // Right calf muscle definition
        ctx.fillStyle = lightenColor(socksColor, 10);
        ctx.beginPath();
        ctx.arc(centerX + 37, centerY + 155, 8, 0, 2 * Math.PI);
        ctx.fill();

        ctx.beginPath();
        ctx.arc(centerX + 33, centerY + 145, 6, 0, 2 * Math.PI);
        ctx.fill();

        // Add subtle muscle shadows for depth
        ctx.globalAlpha = 0.25;
        ctx.fillStyle = '#cc9966';

        // Left thigh shadow
        ctx.beginPath();
        ctx.arc(centerX - 30, centerY + 110, 15, 0, 2 * Math.PI);
        ctx.fill();

        // Right thigh shadow
        ctx.beginPath();
        ctx.arc(centerX + 30, centerY + 110, 15, 0, 2 * Math.PI);
        ctx.fill();

        // Left calf shadow
        ctx.beginPath();
        ctx.arc(centerX - 37, centerY + 160, 10, 0, 2 * Math.PI);
        ctx.fill();

        // Right calf shadow
        ctx.beginPath();
        ctx.arc(centerX + 37, centerY + 160, 10, 0, 2 * Math.PI);
        ctx.fill();

        ctx.globalAlpha = 1;

        // Apply shorts and socks design elements
        if (shortsOptions) {
            drawShortsDesign(centerX, centerY, shortsOptions);
        }
        if (socksOptions) {
            drawSocksDesign(centerX, centerY, socksOptions);
        }
    }

    // Get current design options from form
    function getCurrentDesignOptions() {
        const options = {
            tshirt: {
                color: document.querySelector('select[name="design_3d_tshirt[color]"]')?.value || 'red',
                logo_type: document.querySelector('select[name="design_3d_tshirt[logo_type]"]')?.value || 'none',
                lines_position: document.querySelector('select[name="design_3d_tshirt[lines_position]"]')?.value || '',
                custom_text: document.querySelector('input[name="design_3d_tshirt[custom_text]"]')?.value || ''
            },
            shorts: {
                color: document.querySelector('select[name="design_3d_shorts[color]"]')?.value || 'blue',
                logo_type: document.querySelector('select[name="design_3d_shorts[logo_type]"]')?.value || 'none',
                lines_position: document.querySelector('select[name="design_3d_shorts[lines_position]"]')?.value || '',
                custom_text: document.querySelector('input[name="design_3d_shorts[custom_text]"]')?.value || ''
            },
            socks: {
                color: document.querySelector('select[name="design_3d_socks[color]"]')?.value || 'white',
                logo_type: document.querySelector('select[name="design_3d_socks[logo_type]"]')?.value || 'none',
                lines_position: document.querySelector('select[name="design_3d_socks[lines_position]"]')?.value || '',
                custom_text: document.querySelector('input[name="design_3d_socks[custom_text]"]')?.value || ''
            }
        };
        
        // Convert color names to hex values for 3D rendering
        const colorMap = {
            'red': '#ff6b6b',
            'blue': '#4dabf7',
            'white': '#ffffff',
            'black': '#000000',
            'green': '#51cf66',
            'yellow': '#ffd43b',
            'orange': '#ff922b',
            'purple': '#9775fa',
            'pink': '#f783ac',
            'gray': '#868e96'
        };
        
        // Update colors to hex values
        if (options.tshirt.color && colorMap[options.tshirt.color]) {
            options.tshirt.color = colorMap[options.tshirt.color];
        }
        if (options.shorts.color && colorMap[options.shorts.color]) {
            options.shorts.color = colorMap[options.shorts.color];
        }
        if (options.socks.color && colorMap[options.socks.color]) {
            options.socks.color = colorMap[options.socks.color];
        }
        
        return options;
    }

    // Draw T-shirt design elements
    function drawTshirtDesign(centerX, centerY, tshirtOptions) {
        if (!tshirtOptions) return;

        // Draw lines based on position
        if (tshirtOptions.lines_position) {
            ctx.strokeStyle = '#ffffff';
            ctx.lineWidth = 3;

            switch (tshirtOptions.lines_position) {
                case 'shoulder':
                    ctx.beginPath();
                    ctx.moveTo(centerX - 35, centerY - 50);
                    ctx.lineTo(centerX + 35, centerY - 50);
                    ctx.stroke();
                    break;
                case 'sleeve':
                    ctx.beginPath();
                    ctx.moveTo(centerX - 60, centerY - 20);
                    ctx.lineTo(centerX + 60, centerY - 20);
                    ctx.stroke();
                    break;
                case 'chest':
                    ctx.beginPath();
                    ctx.moveTo(centerX - 30, centerY - 10);
                    ctx.lineTo(centerX + 30, centerY - 10);
                    ctx.stroke();
                    break;
                case 'back':
                    // Lines on back - simplified representation
                    ctx.strokeStyle = '#ffffff';
                    ctx.lineWidth = 2;
                    ctx.beginPath();
                    ctx.moveTo(centerX - 25, centerY + 10);
                    ctx.lineTo(centerX + 25, centerY + 10);
                    ctx.stroke();
                    break;
            }
        }

        // Draw logo if selected
        if (tshirtOptions.logo_type && tshirtOptions.logo_type !== 'none') {
            const logoColor = tshirtOptions.logo_type === 'academy' ? '#ffd700' : '#ffffff';
            ctx.fillStyle = logoColor;

            // Simple logo representation (circle with letter)
            ctx.beginPath();
            ctx.arc(centerX - 20, centerY - 20, 8, 0, 2 * Math.PI);
            ctx.fill();
            ctx.stroke();

            // Logo letter
            ctx.fillStyle = '#000000';
            ctx.font = '10px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('A', centerX - 20, centerY - 17);
        }

        // Draw custom text if provided
        if (tshirtOptions.custom_text) {
            ctx.fillStyle = '#ffffff';
            ctx.font = '12px Arial';
            ctx.textAlign = 'center';
            ctx.fillText(tshirtOptions.custom_text, centerX, centerY + 40);
        }
    }

    // Draw Shorts design elements
    function drawShortsDesign(centerX, centerY, shortsOptions) {
        if (!shortsOptions) return;

        // Draw lines based on position
        if (shortsOptions.lines_position) {
            ctx.strokeStyle = '#ffffff';
            ctx.lineWidth = 3;

            switch (shortsOptions.lines_position) {
                case 'side':
                    ctx.beginPath();
                    ctx.moveTo(centerX - 20, centerY + 70);
                    ctx.lineTo(centerX - 20, centerY + 110);
                    ctx.moveTo(centerX + 20, centerY + 70);
                    ctx.lineTo(centerX + 20, centerY + 110);
                    ctx.stroke();
                    break;
                case 'front':
                    ctx.beginPath();
                    ctx.moveTo(centerX - 15, centerY + 80);
                    ctx.lineTo(centerX + 15, centerY + 80);
                    ctx.stroke();
                    break;
                case 'back':
                    ctx.beginPath();
                    ctx.moveTo(centerX - 15, centerY + 90);
                    ctx.lineTo(centerX + 15, centerY + 90);
                    ctx.stroke();
                    break;
            }
        }

        // Draw logo if selected
        if (shortsOptions.logo_type && shortsOptions.logo_type !== 'none') {
            const logoColor = shortsOptions.logo_type === 'academy' ? '#ffd700' : '#ffffff';
            ctx.fillStyle = logoColor;

            ctx.beginPath();
            ctx.arc(centerX + 20, centerY + 80, 6, 0, 2 * Math.PI);
            ctx.fill();
            ctx.stroke();

            ctx.fillStyle = '#000000';
            ctx.font = '8px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('S', centerX + 20, centerY + 83);
        }

        // Draw custom text if provided
        if (shortsOptions.custom_text) {
            ctx.fillStyle = '#ffffff';
            ctx.font = '10px Arial';
            ctx.textAlign = 'center';
            ctx.fillText(shortsOptions.custom_text, centerX, centerY + 100);
        }
    }

    // Draw Socks design elements
    function drawSocksDesign(centerX, centerY, socksOptions) {
        if (!socksOptions) return;

        // Draw socks at bottom of legs
        ctx.fillStyle = socksOptions.color;
        ctx.strokeStyle = darkenColor(socksOptions.color, 20);

        // Left sock
        ctx.beginPath();
        ctx.moveTo(centerX - 25, centerY + 110);
        ctx.lineTo(centerX - 25, centerY + 130);
        ctx.lineTo(centerX - 15, centerY + 130);
        ctx.lineTo(centerX - 15, centerY + 110);
        ctx.closePath();
        ctx.fill();
        ctx.stroke();

        // Right sock
        ctx.beginPath();
        ctx.moveTo(centerX + 25, centerY + 110);
        ctx.lineTo(centerX + 25, centerY + 130);
        ctx.lineTo(centerX + 15, centerY + 130);
        ctx.lineTo(centerX + 15, centerY + 110);
        ctx.closePath();
        ctx.fill();
        ctx.stroke();

        // Draw lines based on position
        if (socksOptions.lines_position) {
            ctx.strokeStyle = '#ffffff';
            ctx.lineWidth = 2;

            switch (socksOptions.lines_position) {
                case 'top':
                    ctx.beginPath();
                    ctx.moveTo(centerX - 20, centerY + 110);
                    ctx.lineTo(centerX + 20, centerY + 110);
                    ctx.stroke();
                    break;
                case 'bottom':
                    ctx.beginPath();
                    ctx.moveTo(centerX - 20, centerY + 125);
                    ctx.lineTo(centerX + 20, centerY + 125);
                    ctx.stroke();
                    break;
                case 'side':
                    ctx.beginPath();
                    ctx.moveTo(centerX - 25, centerY + 115);
                    ctx.lineTo(centerX - 25, centerY + 125);
                    ctx.moveTo(centerX + 25, centerY + 115);
                    ctx.lineTo(centerX + 25, centerY + 125);
                    ctx.stroke();
                    break;
            }
        }

        // Draw logo if selected
        if (socksOptions.logo_type && socksOptions.logo_type !== 'none') {
            const logoColor = socksOptions.logo_type === 'academy' ? '#ffd700' : '#ffffff';
            ctx.fillStyle = logoColor;

            ctx.beginPath();
            ctx.arc(centerX, centerY + 120, 4, 0, 2 * Math.PI);
            ctx.fill();

            ctx.fillStyle = '#000000';
            ctx.font = '6px Arial';
            ctx.textAlign = 'center';
            ctx.fillText('K', centerX, centerY + 123);
        }

        // Draw custom text if provided
        if (socksOptions.custom_text) {
            ctx.fillStyle = '#ffffff';
            ctx.font = '8px Arial';
            ctx.textAlign = 'center';
            ctx.fillText(socksOptions.custom_text, centerX, centerY + 135);
        }
    }

    // Utility function to darken colors
    function darkenColor(color, percent) {
        // Simple color darkening for demonstration
        const colors = {
            'white': '#f0f0f0',
            'black': '#333333',
            'red': '#cc0000',
            'blue': '#0066cc',
            'green': '#009900',
            'yellow': '#cccc00'
        };
        return colors[color] || color;
    }

    // Draw advanced 3D lighting and shadows with realistic lighting model
    function drawAdvanced3DEffects() {
        const centerX = 0;
        const centerY = 0;
        const model = window.humanModel;

        // Calculate lighting based on 3D light direction and surface normals
        calculate3DLighting();

        // Draw main ground shadow with perspective
        drawGroundShadow(centerX, centerY);

        // Draw self-shadows based on light direction
        drawSelfShadows(centerX, centerY);

        // Draw specular highlights for glossy surfaces
        drawSpecularHighlights(centerX, centerY);

        // Draw ambient occlusion for realistic depth
        drawAmbientOcclusion(centerX, centerY);
    }

    // Calculate 3D lighting for each surface
    function calculate3DLighting() {
        const model = window.humanModel;
        const light = model.lightDirection;

        // Normalize light direction
        const lightMagnitude = Math.sqrt(light.x * light.x + light.y * light.y + light.z * light.z);
        const normalizedLight = {
            x: light.x / lightMagnitude,
            y: light.y / lightMagnitude,
            z: light.z / lightMagnitude
        };

        // Store calculated lighting values for use in drawing functions
        model.calculatedLighting = {
            ambient: model.ambientLight,
            diffuse: model.diffuseLight,
            specular: 0.3,
            lightDirection: normalizedLight
        };
    }

    // Draw realistic ground shadow with perspective
    function drawGroundShadow(centerX, centerY) {
        const model = window.humanModel;
        const shadowScale = 1 + (model.positionZ / model.cameraDistance) * 0.5;

        ctx.globalAlpha = 0.4;
        ctx.fillStyle = '#000000';

        // Main body shadow (elliptical with perspective)
        ctx.save();
        ctx.translate(centerX, centerY + 200);
        ctx.scale(shadowScale, 0.3);
        ctx.beginPath();
        ctx.ellipse(0, 0, 35, 20, model.rotationZ, 0, 2 * Math.PI);
        ctx.fill();
        ctx.restore();

        // Head shadow
        ctx.save();
        ctx.translate(centerX, centerY + 120);
        ctx.scale(shadowScale * 0.7, 0.2);
        ctx.beginPath();
        ctx.arc(0, 0, 20, 0, 2 * Math.PI);
        ctx.fill();
        ctx.restore();

        ctx.globalAlpha = 1;
    }

    // Draw self-shadows based on light direction
    function drawSelfShadows(centerX, centerY) {
        const model = window.humanModel;
        const lighting = model.calculatedLighting;

        // Calculate shadow direction based on light
        const shadowOffsetX = lighting.lightDirection.x * -15;
        const shadowOffsetY = lighting.lightDirection.y * -15;

        ctx.globalAlpha = 0.25;
        ctx.fillStyle = '#000000';

        // Torso shadow (cast by chest on abs)
        ctx.save();
        ctx.translate(shadowOffsetX, shadowOffsetY);
        ctx.beginPath();
        ctx.moveTo(centerX - 35, centerY - 50);
        ctx.lineTo(centerX - 15, centerY - 45);
        ctx.lineTo(centerX - 20, centerY - 25);
        ctx.lineTo(centerX - 40, centerY - 30);
        ctx.closePath();
        ctx.fill();

        ctx.beginPath();
        ctx.moveTo(centerX + 35, centerY - 50);
        ctx.lineTo(centerX + 15, centerY - 45);
        ctx.lineTo(centerX + 20, centerY - 25);
        ctx.lineTo(centerX + 40, centerY - 30);
        ctx.closePath();
        ctx.fill();
        ctx.restore();

        // Arm shadows
        ctx.save();
        ctx.translate(shadowOffsetX * 0.7, shadowOffsetY * 0.7);

        // Left arm shadow
        ctx.beginPath();
        ctx.arc(centerX - 65, centerY - 30, 12, 0, 2 * Math.PI);
        ctx.fill();

        // Right arm shadow
        ctx.beginPath();
        ctx.arc(centerX + 65, centerY - 30, 12, 0, 2 * Math.PI);
        ctx.fill();

        ctx.restore();

        // Leg shadows
        ctx.save();
        ctx.translate(shadowOffsetX * 0.5, shadowOffsetY * 0.5);

        // Left thigh shadow
        ctx.beginPath();
        ctx.arc(centerX - 30, centerY + 110, 15, 0, 2 * Math.PI);
        ctx.fill();

        // Right thigh shadow
        ctx.beginPath();
        ctx.arc(centerX + 30, centerY + 110, 15, 0, 2 * Math.PI);
        ctx.fill();

        // Left calf shadow
        ctx.beginPath();
        ctx.arc(centerX - 37, centerY + 160, 10, 0, 2 * Math.PI);
        ctx.fill();

        // Right calf shadow
        ctx.beginPath();
        ctx.arc(centerX + 37, centerY + 160, 10, 0, 2 * Math.PI);
        ctx.fill();

        ctx.restore();

        ctx.globalAlpha = 1;
    }

    // Draw specular highlights for glossy/reflective surfaces
    function drawSpecularHighlights(centerX, centerY) {
        const model = window.humanModel;
        const lighting = model.calculatedLighting;

        // Calculate reflection vector for specular highlights
        const viewDirection = { x: 0, y: 0, z: 1 }; // Camera looking down Z-axis
        const reflection = reflectVector(lighting.lightDirection, { x: 0, y: 0, z: 1 });

        ctx.globalAlpha = 0.3;
        ctx.fillStyle = '#ffffff';

        // Chest highlights (collarbone area)
        if (reflection.z > 0) {
            ctx.beginPath();
            ctx.arc(centerX - 15, centerY - 55, 4, 0, 2 * Math.PI);
            ctx.fill();

            ctx.beginPath();
            ctx.arc(centerX + 15, centerY - 55, 4, 0, 2 * Math.PI);
            ctx.fill();
        }

        // Shoulder highlights
        ctx.beginPath();
        ctx.arc(centerX - 40, centerY - 45, 3, 0, 2 * Math.PI);
        ctx.fill();

        ctx.beginPath();
        ctx.arc(centerX + 40, centerY - 45, 3, 0, 2 * Math.PI);
        ctx.fill();

        // Bicep highlights
        ctx.beginPath();
        ctx.arc(centerX - 62, centerY - 28, 3, 0, 2 * Math.PI);
        ctx.fill();

        ctx.beginPath();
        ctx.arc(centerX + 62, centerY - 28, 3, 0, 2 * Math.PI);
        ctx.fill();

        ctx.globalAlpha = 1;
    }

    // Draw ambient occlusion for realistic depth perception
    function drawAmbientOcclusion(centerX, centerY) {
        ctx.globalAlpha = 0.15;
        ctx.fillStyle = '#000000';

        // Creases and joints where light doesn't reach
        const occlusionAreas = [
            // Armpits
            { x: centerX - 45, y: centerY - 50, radius: 8 },
            { x: centerX + 45, y: centerY - 50, radius: 8 },

            // Groin area
            { x: centerX, y: centerY + 80, radius: 12 },

            // Behind knees
            { x: centerX - 30, y: centerY + 125, radius: 6 },
            { x: centerX + 30, y: centerY + 125, radius: 6 },

            // Neck shadow
            { x: centerX, y: centerY - 70, radius: 5 }
        ];

        occlusionAreas.forEach(area => {
            ctx.beginPath();
            ctx.arc(area.x, area.y, area.radius, 0, 2 * Math.PI);
            ctx.fill();
        });

        ctx.globalAlpha = 1;
    }

    // Vector reflection utility for specular lighting
    function reflectVector(incident, normal) {
        const dot = incident.x * normal.x + incident.y * normal.y + incident.z * normal.z;
        return {
            x: incident.x - 2 * dot * normal.x,
            y: incident.y - 2 * dot * normal.y,
            z: incident.z - 2 * dot * normal.z
        };
    }

    // Utility function to lighten colors
    function lightenColor(color, percent) {
        const colors = {
            'white': '#ffffff',
            'black': '#1a1a1a',
            'red': '#ff9999',
            'blue': '#99ccff',
            'green': '#99ff99',
            'yellow': '#ffff99'
        };
        return colors[color] || color;
    }

    // Utility function to darken colors
    function darkenColor(color, percent) {
        const colors = {
            'white': '#f0f0f0',
            'black': '#333333',
            'red': '#cc0000',
            'blue': '#0066cc',
            'green': '#009900',
            'yellow': '#cccc00'
        };
        return colors[color] || color;
    }

    // Advanced 3D Mouse Controls
    let isRotating = false;
    let lastMouseX, lastMouseY;
    let rotationVelocity = { x: 0, y: 0, z: 0 };

    function init3DMouseControls() {
        canvas.addEventListener('mousedown', start3DRotate);
        canvas.addEventListener('mousemove', rotate3D);
        canvas.addEventListener('mouseup', stop3DRotate);
        canvas.addEventListener('mouseleave', stop3DRotate);
        canvas.addEventListener('wheel', zoom3D);
        canvas.addEventListener('contextmenu', preventDefault); // Prevent right-click menu
    }

    function start3DRotate(e) {
        isRotating = true;
        lastMouseX = e.clientX;
        lastMouseY = e.clientY;
        canvas.style.cursor = 'grabbing';
    }

    function rotate3D(e) {
        if (!isRotating) return;

        const deltaX = e.clientX - lastMouseX;
        const deltaY = e.clientY - lastMouseY;

        // Different rotation based on mouse button or modifier keys
        if (e.buttons === 1) { // Left mouse button - Yaw and Pitch
            window.humanModel.rotationY += deltaX * 0.01;
            window.humanModel.rotationX += deltaY * 0.01;
        } else if (e.buttons === 2) { // Right mouse button - Roll
            window.humanModel.rotationZ += deltaX * 0.01;
        }

        // Add momentum for smooth rotation
        rotationVelocity.x = deltaY * 0.001;
        rotationVelocity.y = deltaX * 0.001;

        lastMouseX = e.clientX;
        lastMouseY = e.clientY;

        draw3DHuman();
    }

    function stop3DRotate() {
        isRotating = false;
        canvas.style.cursor = 'grab';

        // Apply momentum decay for smooth stopping
        setTimeout(() => {
            rotationVelocity.x *= 0.95;
            rotationVelocity.y *= 0.95;
            if (Math.abs(rotationVelocity.x) > 0.001 || Math.abs(rotationVelocity.y) > 0.001) {
                window.humanModel.rotationX += rotationVelocity.x;
                window.humanModel.rotationY += rotationVelocity.y;
                draw3DHuman();
                setTimeout(arguments.callee, 16); // 60fps
            }
        }, 16);
    }

    function zoom3D(e) {
        e.preventDefault();
        const delta = e.deltaY > 0 ? 0.95 : 1.05;
        window.humanModel.scale *= delta;
        window.humanModel.scale = Math.max(0.3, Math.min(3, window.humanModel.scale));
        draw3DHuman();
    }

    function preventDefault(e) {
        e.preventDefault();
    }

    // 3D Keyboard Controls
    function init3DKeyboardControls() {
        document.addEventListener('keydown', handle3DKeyboard);
    }

    function handle3DKeyboard(e) {
        const model = window.humanModel;
        const moveSpeed = 0.05;
        const rotateSpeed = 0.02;

        switch(e.key.toLowerCase()) {
            // Rotation controls
            case 'arrowleft':
                model.rotationY -= rotateSpeed;
                break;
            case 'arrowright':
                model.rotationY += rotateSpeed;
                break;
            case 'arrowup':
                model.rotationX -= rotateSpeed;
                break;
            case 'arrowdown':
                model.rotationX += rotateSpeed;
                break;
            case 'q':
                model.rotationZ -= rotateSpeed;
                break;
            case 'e':
                model.rotationZ += rotateSpeed;
                break;

            // Position controls
            case 'a':
                model.positionX -= 10;
                break;
            case 'd':
                model.positionX += 10;
                break;
            case 'w':
                model.positionY -= 10;
                break;
            case 's':
                model.positionY += 10;
                break;

            // Scale controls
            case 'z':
                model.scale *= 0.9;
                break;
            case 'x':
                model.scale *= 1.1;
                break;

            // Reset
            case 'r':
                model.rotationX = model.rotationY = model.rotationZ = 0;
                model.scale = 1;
                model.positionX = canvas.width / 2;
                model.positionY = canvas.height / 2;
                break;

            default:
                return;
        }

        e.preventDefault();
        draw3DHuman();
    }

    // 3D Animation Loop with natural body movements
    function start3DAnimation() {
        let animationPhase = 0;

        function animate() {
            const model = window.humanModel;
            const canvas = document.getElementById('design-preview-canvas');

            if (model.isAnimating) {
                animationPhase += 0.05;

                // Breathing animation (chest rises and falls)
                const breatheIntensity = Math.sin(animationPhase * 0.3) * 0.015 + 1;
                const chestOffset = Math.sin(animationPhase * 0.3) * 2;

                // Apply breathing to torso
                model.chestAnimation = chestOffset;

                // Subtle idle animations
                const idleSway = Math.sin(animationPhase * 0.1) * 0.002;
                model.rotationZ += idleSway;

                // Subtle head movement
                model.headRotation = Math.sin(animationPhase * 0.15) * 0.01;

                // Eye blinking animation (occasional)
                if (Math.random() < 0.005) { // 0.5% chance per frame
                    model.eyeBlink = 0.8;
                    setTimeout(() => { model.eyeBlink = 1; }, 150);
                }

                // Muscle micro-movements for realism
                model.muscleTremor = Math.sin(animationPhase * 2) * 0.001;

                // Add breathing visual effect to canvas
                if (canvas) {
                    canvas.classList.add('breathing');
                }

                draw3DHuman();
            } else if (canvas) {
                canvas.classList.remove('breathing');
            }

            requestAnimationFrame(animate);
        }
        animate();
    }

    // Enhanced human model with animation properties
    function updateHumanModelStructure() {
        const model = window.humanModel;

        // Add animation properties if they don't exist
        if (model.chestAnimation === undefined) {
            model.chestAnimation = 0;
            model.headRotation = 0;
            model.eyeBlink = 1;
            model.muscleTremor = 0;
        }
    }

    // Clear Canvas (Empty Canvas)
    function drawTShirt() {
        draw3DHuman();
    }
    
    // Drawing functions
    function startDrawing(e) {
        if (!ctx || !canvas) return;
        isDrawing = true;
        draw(e);
    }
    
    function draw(e) {
        if (!isDrawing || !ctx || !canvas) return;
        
        const rect = canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        ctx.lineWidth = brushSize;
        ctx.strokeStyle = currentColor;
        
        if (currentTool === 'brush') {
            ctx.globalCompositeOperation = 'source-over';
        } else if (currentTool === 'eraser') {
            ctx.globalCompositeOperation = 'destination-out';
        }
        
        ctx.lineTo(x, y);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(x, y);
    }
    
    function stopDrawing() {
        if (!ctx) return;
        isDrawing = false;
        ctx.beginPath();
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize canvas first
        initCanvas();
        
        // إخفاء جميع علامات النجمة في البداية
        document.querySelectorAll('.design-text-required, .design-upload-required, .design-template-required').forEach(el => el.style.display = 'none');
        
        // إظهار/إخفاء حقل "نوع النشاط (آخر)" عند اختيار "أخرى"
        const businessTypeSelect = document.getElementById('business_type');
        if (businessTypeSelect) {
            businessTypeSelect.addEventListener('change', function() {
                const otherDiv = document.getElementById('other_business_type_div');
                const otherInput = document.getElementById('business_type_other');
                if (this.value === 'other') {
                    otherDiv.style.display = 'block';
                    otherInput.required = true;
                } else {
                    otherDiv.style.display = 'none';
                    otherInput.required = false;
                }
            });
        }
        
        // إدارة خيارات التصميم
        function showDesignSection(selectedOption) {
            console.log('تم اختيار: ' + selectedOption);
            
            // إخفاء جميع أقسام التصميم
            document.querySelectorAll('.design-section').forEach(section => {
                section.style.display = 'none';
            });
            
            // إخفاء جميع علامات النجمة
            document.querySelectorAll('.design-text-required, .design-upload-required, .design-template-required').forEach(el => {
                el.style.display = 'none';
            });
            
            // إلغاء خاصية required من جميع حقول التصميم
            const textArea = document.getElementById('design_details_text');
            const fileInput = document.getElementById('design_file');
            const templateInputs = document.querySelectorAll('input[name="design_template"]');
            if (textArea) textArea.required = false;
            if (fileInput) fileInput.required = false;
            templateInputs.forEach(input => input.required = false);
            
            // إزالة التحديد من جميع الكروت
            document.querySelectorAll('.design-option-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // إضافة التحديد للكارت المختار
            const selectedCard = document.querySelector('.design-option-card[data-option="' + selectedOption + '"]');
            if (selectedCard) {
                selectedCard.classList.add('selected');
            }
            
            // إظهار القسم المناسب
            switch(selectedOption) {
                case 'text':
                    const textSection = document.getElementById('design_text_section');
                    if (textSection) {
                        textSection.style.display = 'block';
                        if (textArea) textArea.required = true;
                        const textRequired = document.querySelector('.design-text-required');
                        if (textRequired) textRequired.style.display = 'inline';
                    }
                    break;
                case 'upload':
                    const uploadSection = document.getElementById('design_upload_section');
                    if (uploadSection) {
                        uploadSection.style.display = 'block';
                        if (fileInput) fileInput.required = true;
                        const uploadRequired = document.querySelector('.design-upload-required');
                        if (uploadRequired) uploadRequired.style.display = 'inline';
                    }
                    break;
                case 'template':
                    const templateSection = document.getElementById('design_template_section');
                    if (templateSection) {
                        templateSection.style.display = 'block';
                        templateInputs.forEach(input => input.required = true);
                        const templateRequired = document.querySelector('.design-template-required');
                        if (templateRequired) templateRequired.style.display = 'inline';
                    }
                    break;
            }
        }
        
        // ربط الحدث بتغيير خيار التصميم
        document.querySelectorAll('.design-option').forEach(option => {
            option.addEventListener('change', function() {
                const selectedOption = document.querySelector('input[name="design_option"]:checked');
                if (selectedOption) {
                    showDesignSection(selectedOption.value);
                }
            });
        });
        
        // تشغيل الدالة عند تحميل الصفحة
        if (businessTypeSelect && businessTypeSelect.value === 'other') {
            const otherDiv = document.getElementById('other_business_type_div');
            const otherInput = document.getElementById('business_type_other');
            if (otherDiv) otherDiv.style.display = 'block';
            if (otherInput) otherInput.required = true;
        }
        
        // تحديد الخيار الأول افتراضياً وإظهار القسم المناسب
        setTimeout(function() {
            const checkedOption = document.querySelector('input[name="design_option"]:checked');
            if (!checkedOption) {
                const firstOption = document.querySelector('input[name="design_option"]');
                if (firstOption) {
                    firstOption.checked = true;
                }
            }
            const initialOption = document.querySelector('input[name="design_option"]:checked');
            if (initialOption) {
                showDesignSection(initialOption.value);
            }
        }, 100);
        
        // إضافة تفاعل للكروت
        document.querySelectorAll('.design-option-card').forEach(card => {
            card.addEventListener('click', function() {
                const option = this.getAttribute('data-option');
                const radioInput = document.querySelector('input[name="design_option"][value="' + option + '"]');
                if (radioInput) {
                    radioInput.checked = true;
                    showDesignSection(option);
                }
            });
        });
        
        // إضافة تفاعل لاختيار القوالب
        document.querySelectorAll('.design-template-item').forEach(item => {
            item.addEventListener('click', function() {
                const template = this.getAttribute('data-template');
                const templateInput = document.querySelector('input[name="design_template"][value="' + template + '"]');
                if (templateInput) {
                    templateInput.checked = true;
                    document.querySelectorAll('.design-template-item').forEach(el => el.classList.remove('selected'));
                    this.classList.add('selected');
                }
            });
        });
        
        // 3D T-Shirt Designer - Global variables
        var canvas, ctx;
        var isDrawing = false;
        var currentTool = 'brush';
        var currentColor = '#000000';
        var brushSize = 5;
        var rotation = 0;
        
        
        // Draw T-Shirt Base (Empty Canvas)
        function drawTShirt() {
            if (!ctx || !canvas) {
                console.warn('Canvas or context not available for drawing');
                return;
            }
            
            // Clear the entire canvas - keep it completely empty
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // Set transparent background - completely empty canvas
            ctx.fillStyle = 'transparent';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            console.log('Canvas cleared - completely empty, ready for AI design');
        }
        
        // Drawing functions
        function startDrawing(e) {
            if (currentTool === 'brush' || currentTool === 'eraser') {
                isDrawing = true;
                ctx.beginPath();
                ctx.moveTo(e.offsetX, e.offsetY);
            }
        }
        
        function draw(e) {
            if (!isDrawing) return;
            
            if (currentTool === 'brush') {
                ctx.globalCompositeOperation = 'source-over';
                ctx.strokeStyle = currentColor;
                ctx.lineWidth = brushSize;
                ctx.lineTo(e.offsetX, e.offsetY);
                ctx.stroke();
            } else if (currentTool === 'eraser') {
                ctx.globalCompositeOperation = 'destination-out';
                ctx.lineWidth = brushSize * 2;
                ctx.lineTo(e.offsetX, e.offsetY);
                ctx.stroke();
            }
        }
        
        function stopDrawing() {
            isDrawing = false;
            ctx.beginPath();
        }
        
        // Design Mode Selection
        document.querySelectorAll('input[name="design_mode"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const mode = this.value;
                document.querySelectorAll('.design-mode-section').forEach(section => {
                    section.style.display = 'none';
                });
                document.querySelectorAll('.design-mode-card').forEach(card => {
                    card.classList.remove('selected');
                });
                
                if (mode === 'draw') {
                    document.getElementById('draw-design-mode').style.display = 'block';
                    initCanvas();
                }
                
                document.querySelector(`.design-mode-card[data-mode="${mode}"]`).classList.add('selected');
            });
        });
        
        // Drawing Tools
        document.querySelectorAll('[data-tool]').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('[data-tool]').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentTool = this.getAttribute('data-tool');
                
                if (currentTool === 'text') {
                    const text = prompt('أدخل النص:');
                    if (text) {
                        ctx.font = '20px Arial';
                        ctx.fillStyle = currentColor;
                        ctx.fillText(text, 100, 150);
                    }
                }
            });
        });
        
        // Color Picker
        const colorPicker = document.getElementById('color-picker');
        if (colorPicker) {
            colorPicker.addEventListener('change', function() {
                currentColor = this.value;
            });
        }
        
        // Brush Size
        const brushSizeSlider = document.getElementById('brush-size');
        const brushSizeValue = document.getElementById('brush-size-value');
        if (brushSizeSlider && brushSizeValue) {
            brushSizeSlider.addEventListener('input', function() {
                brushSize = this.value;
                brushSizeValue.textContent = this.value;
            });
        }
        
        // T-Shirt Controls
        document.getElementById('rotate-left')?.addEventListener('click', function() {
            rotation -= 15;
            drawTShirt();
        });
        
        document.getElementById('rotate-right')?.addEventListener('click', function() {
            rotation += 15;
            drawTShirt();
        });
        
        document.getElementById('reset-view')?.addEventListener('click', function() {
            rotation = 0;
            drawTShirt();
        });
        
        // Design Actions
        document.getElementById('preview-3d-btn')?.addEventListener('click', function() {
            // Toggle 3D preview mode
            const previewMode = this.getAttribute('data-mode') === '3d';
            if (previewMode) {
                // Switch to 2D mode
                this.setAttribute('data-mode', '2d');
                this.innerHTML = '<i class="fas fa-eye me-2"></i>معاينة ثلاثية الأبعاد';
                drawHumanBody(); // Draw 2D version
            } else {
                // Switch to 3D mode
                this.setAttribute('data-mode', '3d');
                this.innerHTML = '<i class="fas fa-eye-slash me-2"></i>معاينة ثنائية الأبعاد';
                draw3DHuman(); // Draw 3D version
            }
        });

        // Animation toggle button
        document.getElementById('animate-toggle-btn')?.addEventListener('click', function() {
            const model = window.humanModel;
            if (model) {
                model.isAnimating = !model.isAnimating;

                if (model.isAnimating) {
                    this.innerHTML = '<i class="fas fa-pause me-2"></i>إيقاف الحركة';
                    this.classList.remove('btn-outline-warning');
                    this.classList.add('btn-outline-danger');
                } else {
                    this.innerHTML = '<i class="fas fa-play me-2"></i>تشغيل الحركة';
                    this.classList.remove('btn-outline-danger');
                    this.classList.add('btn-outline-warning');
                }
            }
        });

        document.getElementById('save-design-btn')?.addEventListener('click', function() {
            if (!canvas) {
                alert('خطأ: لم يتم تهيئة الـ Canvas بشكل صحيح');
                return;
            }

            try {
            const dataURL = canvas.toDataURL('image/png');
            // Save to hidden input for form submission
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'design_image_data';
            hiddenInput.value = dataURL;
            document.querySelector('form').appendChild(hiddenInput);
            alert('تم حفظ التصميم بنجاح!');
            } catch (error) {
                console.error('Error saving design:', error);
                alert('خطأ في حفظ التصميم: ' + error.message);
            }
        });
        
        document.getElementById('download-design-btn')?.addEventListener('click', function() {
            if (!canvas) {
                alert('خطأ: لم يتم تهيئة الـ Canvas بشكل صحيح');
                return;
            }

            try {
            const link = document.createElement('a');
                link.download = 'sports-uniform-design.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
            } catch (error) {
                console.error('Error downloading design:', error);
                alert('خطأ في تحميل التصميم: ' + error.message);
            }
        });
        
        document.getElementById('clear-design-btn')?.addEventListener('click', function() {
            if (confirm('هل أنت متأكد من مسح التصميم؟')) {
                // Reset 3D model to initial state
                window.humanModel.rotationX = 0;
                window.humanModel.rotationY = 0;
                window.humanModel.scale = 1;
                draw3DHuman();
            }
        });

        // 3D Model Controls
        document.getElementById('rotate-left-3d')?.addEventListener('click', function() {
            window.humanModel.rotationY -= 0.2;
            draw3DHuman();
        });

        document.getElementById('rotate-right-3d')?.addEventListener('click', function() {
            window.humanModel.rotationY += 0.2;
            draw3DHuman();
        });

        document.getElementById('reset-3d-view')?.addEventListener('click', function() {
            window.humanModel.rotationX = 0;
            window.humanModel.rotationY = 0;
            window.humanModel.scale = 1;
            draw3DHuman();
        });

        document.getElementById('zoom-in-3d')?.addEventListener('click', function() {
            window.humanModel.scale *= 1.2;
            window.humanModel.scale = Math.min(2, window.humanModel.scale);
            draw3DHuman();
        });

        document.getElementById('zoom-out-3d')?.addEventListener('click', function() {
            window.humanModel.scale *= 0.8;
            window.humanModel.scale = Math.max(0.5, window.humanModel.scale);
            draw3DHuman();
        });
        
        // Remove auto-generation - only generate when button is clicked
        // The design will only be generated when user clicks the button

        // Manual generate function
        function generateDesign(prompt, isAuto = false) {
            if (!prompt) {
                alert('يرجى إدخال وصف التصميم أولاً');
                return;
            }
            
            const loading = document.getElementById('generate-loading');
            const button = document.getElementById('generate-design-btn');
            
            if (loading) loading.classList.remove('d-none');
            if (button) {
                button.disabled = true;
                if (!isAuto) {
                    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري إنشاء التصميم...';
                }
            }
            
            // Show progress message
            const progressDiv = document.createElement('div');
            progressDiv.className = 'alert alert-info mt-2';
            progressDiv.innerHTML = '<i class="fas fa-info-circle me-2"></i>جاري إنشاء التصميم، قد يستغرق هذا 15-30 ثانية...';
            if (button && button.parentNode) {
                button.parentNode.appendChild(progressDiv);
            }
            
            // Call AI API to generate design
            fetch('{{ route("api.ai.generate-design") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    prompt: prompt
                })
            })
            .then(response => {
                console.log('API Response Status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('API Response Data:', data);
                if (data.success && data.image_url) {
                    // Load generated image onto canvas
                    const img = new Image();
                    img.crossOrigin = 'anonymous'; // Enable CORS
                    
                    img.onload = function() {
                        console.log('Image loaded successfully:', img.src);
                        if (ctx && canvas) {
                            // Clear canvas and set white background
                            ctx.clearRect(0, 0, canvas.width, canvas.height);
                            ctx.fillStyle = '#ffffff';
                            ctx.fillRect(0, 0, canvas.width, canvas.height);
                            
                            // Draw the generated design in the center of canvas
                            const designWidth = Math.min(img.width, canvas.width - 40); // Max width with margin
                            const designHeight = Math.min(img.height, canvas.height - 40); // Max height with margin
                            const x = (canvas.width - designWidth) / 2;
                            const y = (canvas.height - designHeight) / 2;
                            
                            ctx.drawImage(img, x, y, designWidth, designHeight);
                            console.log('AI Design displayed on canvas at:', x, y, designWidth, designHeight);
                            
                            // Show success message
                            progressDiv.className = 'alert alert-success mt-2';
                            progressDiv.innerHTML = '<i class="fas fa-check-circle me-2"></i>تم إنشاء التصميم بنجاح! يمكنك الآن حفظه أو تحميله.';
                        } else {
                            console.error('Canvas or context not available');
                            progressDiv.className = 'alert alert-warning mt-2';
                            progressDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>تم إنشاء التصميم ولكن لا يمكن عرضه على التيشرت.';
                        }
                    };
                    
                    img.onerror = function() {
                        console.log('Image failed to load:', img.src);
                        // If image fails to load, draw a placeholder
                        if (ctx && canvas) {
                            // Clear canvas and set white background
                            ctx.clearRect(0, 0, canvas.width, canvas.height);
                            ctx.fillStyle = '#ffffff';
                            ctx.fillRect(0, 0, canvas.width, canvas.height);
                            
                            // Draw placeholder message
                            ctx.fillStyle = '#f0f0f0';
                            ctx.fillRect(50, 200, 300, 100);
                            ctx.strokeStyle = '#ccc';
                            ctx.lineWidth = 2;
                            ctx.strokeRect(50, 200, 300, 100);
                            
                            ctx.fillStyle = '#666';
                            ctx.font = '16px Arial';
                            ctx.textAlign = 'center';
                            ctx.fillText('خطأ في تحميل التصميم', 200, 230);
                            ctx.fillText('يرجى المحاولة مرة أخرى', 200, 250);
                            
                            progressDiv.className = 'alert alert-warning mt-2';
                            progressDiv.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>تم إنشاء التصميم ولكن هناك مشكلة في تحميل الصورة.';
                        } else {
                            progressDiv.className = 'alert alert-danger mt-2';
                            progressDiv.innerHTML = '<i class="fas fa-times-circle me-2"></i>خطأ: لا يمكن عرض التصميم على التيشرت.';
                        }
                    };
                    
                    console.log('Setting image source:', data.image_url);
                    img.src = data.image_url;
                } else {
                    progressDiv.className = 'alert alert-danger mt-2';
                    progressDiv.innerHTML = '<i class="fas fa-times-circle me-2"></i>خطأ: ' + (data.error || 'فشل في إنشاء التصميم');
                }
            })
            .catch(error => {
                progressDiv.className = 'alert alert-danger mt-2';
                progressDiv.innerHTML = '<i class="fas fa-times-circle me-2"></i>خطأ: حدث خطأ في الاتصال';
                console.error('Error:', error);
            })
            .finally(() => {
                if (loading) loading.classList.add('d-none');
                if (button) {
                    button.disabled = false;
                    button.innerHTML = '<i class="fas fa-magic me-2"></i>🎨 إنشاء التصميم';
                }
                
                // Remove progress message after 5 seconds
                setTimeout(() => {
                    if (progressDiv.parentNode) {
                        progressDiv.parentNode.removeChild(progressDiv);
                    }
                }, 5000);
            });
        }

        // Manual generate button click
        document.getElementById('generate-design-btn')?.addEventListener('click', function() {
            // AI design generation functionality removed
        });
        
        
        // Analyze Requirements
        const analyzeBtn = document.getElementById('analyze-requirements-btn');
        if (analyzeBtn) {
            analyzeBtn.addEventListener('click', function() {
                const requirementsInput = document.getElementById('requirements');
                const requirements = requirementsInput ? requirementsInput.value.trim() : '';
                
                if (!requirements) {
                    alert('يرجى إدخال متطلبات الطلب أولاً');
                    return;
                }
                
                // Show loading
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>جاري التحليل...';
                // AI analysis functionality removed
                
                // Call AI API
                fetch('{{ route("api.ai.analyze-requirements") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        requirements: requirements
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let analysisHtml = '<p>' + data.analysis + '</p>';
                        
                        if (data.suggestions && data.suggestions.length > 0) {
                            analysisHtml += '<h6 class="mt-3">اقتراحات للتحسين:</h6><ul>';
                            data.suggestions.forEach(function(suggestion) {
                                analysisHtml += '<li>' + suggestion + '</li>';
                            });
                            analysisHtml += '</ul>';
                        }
                        
                        const analysisContent = document.getElementById('ai-analysis-content');
                        if (analysisContent) analysisContent.innerHTML = analysisHtml;
                        // AI analysis display removed
                    } else {
                        alert('خطأ: ' + (data.error || 'فشل في تحليل المتطلبات'));
                    }
                })
                .catch(error => {
                    alert('خطأ: حدث خطأ في الاتصال');
                    console.error('Error:', error);
                })
                .finally(() => {
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-search me-1"></i>تحليل المتطلبات';
                });
            });
        }

        // 3D Design Options Event Listeners - Real-time updates
        function addDesignOptionListeners() {
            // T-shirt color change
            const tshirtColorSelect = document.querySelector('select[name="design_3d_tshirt[color]"]');
            if (tshirtColorSelect) {
                tshirtColorSelect.addEventListener('change', function() {
                    if (isReal3DMode) {
                        updateClothingDesign();
                    } else {
                    draw3DHuman();
                    }
                });
            }

            // T-shirt logo type change
            const tshirtLogoSelect = document.querySelector('select[name="design_3d_tshirt[logo_type]"]');
            if (tshirtLogoSelect) {
                tshirtLogoSelect.addEventListener('change', function() {
                    if (isReal3DMode) {
                        updateClothingDesign();
                    } else {
                    draw3DHuman();
                    }
                });
            }

            // T-shirt lines position change
            const tshirtLinesSelect = document.querySelector('select[name="design_3d_tshirt[lines_position]"]');
            if (tshirtLinesSelect) {
                tshirtLinesSelect.addEventListener('change', function() {
                    if (isReal3DMode) {
                        updateClothingDesign();
                    } else {
                    draw3DHuman();
                    }
                });
            }

            // T-shirt custom text change
            const tshirtTextInput = document.querySelector('input[name="design_3d_tshirt[custom_text]"]');
            if (tshirtTextInput) {
                tshirtTextInput.addEventListener('input', function() {
                    if (isReal3DMode) {
                        updateClothingDesign();
                    } else {
                    draw3DHuman();
                    }
                });
            }

            // Shorts color change
            const shortsColorSelect = document.querySelector('select[name="design_3d_shorts[color]"]');
            if (shortsColorSelect) {
                shortsColorSelect.addEventListener('change', function() {
                    if (isReal3DMode) {
                        updateClothingDesign();
                    } else {
                    draw3DHuman();
                    }
                });
            }

            // Shorts logo type change
            const shortsLogoSelect = document.querySelector('select[name="design_3d_shorts[logo_type]"]');
            if (shortsLogoSelect) {
                shortsLogoSelect.addEventListener('change', function() {
                    if (isReal3DMode) {
                        updateClothingDesign();
                    } else {
                    draw3DHuman();
                    }
                });
            }

            // Shorts lines position change
            const shortsLinesSelect = document.querySelector('select[name="design_3d_shorts[lines_position]"]');
            if (shortsLinesSelect) {
                shortsLinesSelect.addEventListener('change', function() {
                    if (isReal3DMode) {
                        updateClothingDesign();
                    } else {
                    draw3DHuman();
                    }
                });
            }

            // Shorts custom text change
            const shortsTextInput = document.querySelector('input[name="design_3d_shorts[custom_text]"]');
            if (shortsTextInput) {
                shortsTextInput.addEventListener('input', function() {
                    if (isReal3DMode) {
                        updateClothingDesign();
                    } else {
                    draw3DHuman();
                    }
                });
            }

            // Socks color change
            const socksColorSelect = document.querySelector('select[name="design_3d_socks[color]"]');
            if (socksColorSelect) {
                socksColorSelect.addEventListener('change', function() {
                    if (isReal3DMode) {
                        updateClothingDesign();
                    } else {
                    draw3DHuman();
                    }
                });
            }

            // Socks logo type change
            const socksLogoSelect = document.querySelector('select[name="design_3d_socks[logo_type]"]');
            if (socksLogoSelect) {
                socksLogoSelect.addEventListener('change', function() {
                    if (isReal3DMode) {
                        updateClothingDesign();
                    } else {
                    draw3DHuman();
                    }
                });
            }

            // Socks lines position change
            const socksLinesSelect = document.querySelector('select[name="design_3d_socks[lines_position]"]');
            if (socksLinesSelect) {
                socksLinesSelect.addEventListener('change', function() {
                    if (isReal3DMode) {
                        updateClothingDesign();
                    } else {
                    draw3DHuman();
                    }
                });
            }

            // Socks custom text change
            const socksTextInput = document.querySelector('input[name="design_3d_socks[custom_text]"]');
            if (socksTextInput) {
                socksTextInput.addEventListener('input', function() {
                    if (isReal3DMode) {
                        updateClothingDesign();
                    } else {
                    draw3DHuman();
                    }
                });
            }
        }

        // Initialize design option listeners
        addDesignOptionListeners();

        // Toggle 3D mode button
        document.getElementById('toggle-3d-mode')?.addEventListener('click', function() {
            isReal3DMode = !isReal3DMode;
            
            if (isReal3DMode) {
                this.innerHTML = '<i class="fas fa-cube me-1"></i>تبديل إلى المجسم الحقيقي';
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-outline-primary');
                initReal3DScene();
            } else {
                this.innerHTML = '<i class="fas fa-draw-polygon me-1"></i>تبديل إلى المجسم المرسوم';
                this.classList.remove('btn-outline-primary');
                this.classList.add('btn-outline-secondary');
                init2DCanvas();
            }
        });

        // Show 3D model when template option is selected
        const templateRadio = document.querySelector('input[name="design_option"][value="template"]');
        if (templateRadio && templateRadio.checked) {
            // Make sure 3D model is visible when template option is selected
            setTimeout(function() {
                if (isReal3DMode) {
                    updateClothingDesign();
                } else {
                draw3DHuman();
                }
            }, 500);
        }
    });
</script>
@endsection