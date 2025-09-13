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
                <img src="{{ asset('images/importer-register.svg') }}" alt="تسجيل مستورد" class="img-fluid" style="max-height: 300px;" onerror="this.onerror=null;this.src='{{ asset('images/default-image.png') }}';">
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
                                        <small>اختر إحدى الطرق التالية لتحديد التصميم المطلوب. سيظهر القسم المناسب تلقائياً بناءً على اختيارك.</small>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input design-option" type="radio" name="design_option" id="design_option_text" value="text" {{ old('design_option') == 'text' ? 'checked' : '' }} checked>
                                            <label class="form-check-label" for="design_option_text">
                                                وصف التصميم نصياً
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input design-option" type="radio" name="design_option" id="design_option_upload" value="upload" {{ old('design_option') == 'upload' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="design_option_upload">
                                                رفع تصميم جاهز
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input design-option" type="radio" name="design_option" id="design_option_template" value="template" {{ old('design_option') == 'template' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="design_option_template">
                                                اختيار من تصاميمنا الجاهزة
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input design-option" type="radio" name="design_option" id="design_option_ai" value="ai" {{ old('design_option') == 'ai' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="design_option_ai">
                                                تصميم بواسطة الذكاء الاصطناعي
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <!-- وصف التصميم نصياً -->
                                    <div id="design_text_section" class="design-section">
                                        <div class="mb-3">
                                            <label for="design_details_text" class="form-label">وصف التصميم <span class="text-danger design-text-required">*</span></label>
                                            <textarea class="form-control" id="design_details_text" name="design_details_text" rows="3">{{ old('design_details_text') }}</textarea>
                                            <div class="form-text">يرجى وصف التصميم المطلوب بالتفاصيل (الألوان، الشعارات، النمط، إلخ)</div>
                                        </div>
                                    </div>
                                    
                                    <!-- رفع تصميم جاهز -->
                                    <div id="design_upload_section" class="design-section" style="display: none;">
                                        <div class="mb-3">
                                            <label for="design_file" class="form-label">ملف التصميم <span class="text-danger design-upload-required">*</span></label>
                                            <input type="file" class="form-control" id="design_file" name="design_file" accept="image/jpeg,image/png,application/pdf">
                                            <div class="form-text">يمكنك رفع ملفات بصيغة JPG, PNG, PDF بحجم أقصى 5MB</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="design_upload_notes" class="form-label">ملاحظات إضافية</label>
                                            <textarea class="form-control" id="design_upload_notes" name="design_upload_notes" rows="2">{{ old('design_upload_notes') }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <!-- اختيار من تصاميمنا الجاهزة -->
                                    <div id="design_template_section" class="design-section" style="display: none;">
                                        <div class="mb-3">
                                            <label class="form-label">اختر تصميماً <span class="text-danger design-template-required">*</span></label>
                                            <div class="row row-cols-1 row-cols-md-3 g-3">
                                                <div class="col">
                                                    <div class="card h-100">
                                                        <div class="form-check position-absolute m-2">
                                                            <input class="form-check-input" type="radio" name="design_template" id="template1" value="template1" {{ old('design_template') == 'template1' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="template1"></label>
                                                        </div>
                                                        <img src="{{ asset('images/template1.jpg') }}" class="card-img-top" alt="تصميم 1" onerror="this.onerror=null;this.src='{{ asset('images/default-image.png') }}';">
                                                        <div class="card-body">
                                                            <h6 class="card-title">التصميم الكلاسيكي</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card h-100">
                                                        <div class="form-check position-absolute m-2">
                                                            <input class="form-check-input" type="radio" name="design_template" id="template2" value="template2" {{ old('design_template') == 'template2' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="template2"></label>
                                                        </div>
                                                        <img src="{{ asset('images/template2.jpg') }}" class="card-img-top" alt="تصميم 2" onerror="this.onerror=null;this.src='{{ asset('images/default-image.png') }}';">
                                                        <div class="card-body">
                                                            <h6 class="card-title">التصميم مكةي</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="card h-100">
                                                        <div class="form-check position-absolute m-2">
                                                            <input class="form-check-input" type="radio" name="design_template" id="template3" value="template3" {{ old('design_template') == 'template3' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="template3"></label>
                                                        </div>
                                                        <img src="{{ asset('images/template3.jpg') }}" class="card-img-top" alt="تصميم 3" onerror="this.onerror=null;this.src='{{ asset('images/default-image.png') }}';">
                                                        <div class="card-body">
                                                            <h6 class="card-title">التصميم العصري</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="design_template_notes" class="form-label">تعديلات مطلوبة على التصميم</label>
                                            <textarea class="form-control" id="design_template_notes" name="design_template_notes" rows="2">{{ old('design_template_notes') }}</textarea>
                                            <div class="form-text">يمكنك ذكر أي تعديلات ترغب في إجرائها على التصميم المختار</div>
                                        </div>
                                    </div>
                                    
                                    <!-- تصميم بواسطة الذكاء الاصطناعي -->
                                    <div id="design_ai_section" class="design-section" style="display: none;">
                                        <div class="mb-3">
                                            <label for="design_ai_prompt" class="form-label">وصف التصميم للذكاء الاصطناعي <span class="text-danger design-ai-required">*</span></label>
                                            <textarea class="form-control" id="design_ai_prompt" name="design_ai_prompt" rows="3" placeholder="مثال: زي رياضي أزرق مع خطوط بيضاء على الجانبين وشعار النادي على الصدر">{{ old('design_ai_prompt') }}</textarea>
                                            <div class="form-text">صف التصميم الذي ترغب به بالتفصيل ليقوم الذكاء الاصطناعي بإنشائه</div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">نمط التصميم</label>
                                            <select class="form-select" name="design_ai_style">
                                                <option value="realistic" {{ old('design_ai_style') == 'realistic' ? 'selected' : '' }}>واقعي</option>
                                                <option value="modern" {{ old('design_ai_style') == 'modern' ? 'selected' : '' }}>عصري</option>
                                                <option value="minimalist" {{ old('design_ai_style') == 'minimalist' ? 'selected' : '' }}>بسيط</option>
                                                <option value="sporty" {{ old('design_ai_style') == 'sporty' ? 'selected' : '' }}>رياضي</option>
                                                <option value="elegant" {{ old('design_ai_style') == 'elegant' ? 'selected' : '' }}>أنيق</option>
                                            </select>
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

@section('scripts')
<script>
    $(document).ready(function() {
        // إخفاء جميع علامات النجمة في البداية
        $('.design-text-required, .design-upload-required, .design-template-required, .design-ai-required').hide();
        
        // إظهار/إخفاء حقل "نوع النشاط (آخر)" عند اختيار "أخرى"
        $('#business_type').change(function() {
            if ($(this).val() === 'other') {
                $('#other_business_type_div').show();
                $('#business_type_other').prop('required', true);
            } else {
                $('#other_business_type_div').hide();
                $('#business_type_other').prop('required', false);
            }
        });
        
        // تنفيذ تغيير خيار التصميم عند تحميل الصفحة
        if ($('input[name="design_option"]:checked').length > 0) {
            $('input[name="design_option"]:checked').trigger('change');
        } else {
            // إذا لم يكن هناك خيار محدد، حدد الخيار الأول افتراضياً
            $('input[name="design_option"]:first').prop('checked', true).trigger('change');
        }
        
        // تشغيل الدالة عند تحميل الصفحة للتحقق من القيمة الأولية
        if ($('#business_type').val() === 'other') {
            $('#other_business_type_div').show();
            $('#business_type_other').prop('required', true);
        }
        
        // إدارة خيارات التصميم
        $('.design-option').change(function() {
            // إخفاء جميع أقسام التصميم
            $('.design-section').hide();
            
            // إخفاء جميع علامات النجمة
            $('.design-text-required, .design-upload-required, .design-template-required, .design-ai-required').hide();
            
            // إلغاء خاصية required من جميع حقول التصميم
            $('#design_details_text').prop('required', false);
            $('#design_file').prop('required', false);
            $('input[name="design_template"]').prop('required', false);
            $('#design_ai_prompt').prop('required', false);
            
            // إظهار القسم المناسب بناءً على الخيار المحدد وتفعيل الحقول المطلوبة
            var selectedOption = $('input[name="design_option"]:checked').val();
            console.log('تم اختيار: ' + selectedOption); // للتأكد من الخيار المحدد
            
            switch(selectedOption) {
                case 'text':
                    $('#design_text_section').show();
                    $('#design_details_text').prop('required', true);
                    $('.design-text-required').show();
                    break;
                case 'upload':
                    $('#design_upload_section').show();
                    $('#design_file').prop('required', true);
                    $('.design-upload-required').show();
                    break;
                case 'template':
                    $('#design_template_section').show();
                    $('input[name="design_template"]').prop('required', true);
                    $('.design-template-required').show();
                    break;
                case 'ai':
                    $('#design_ai_section').show();
                    $('#design_ai_prompt').prop('required', true);
                    $('.design-ai-required').show();
                    break;
            }
        });
        
        // تنفيذ الدالة عند تحميل الصفحة لإظهار القسم المناسب
        // التأكد من وجود خيار محدد، وإذا لم يكن هناك خيار محدد، يتم تحديد الخيار الأول
        if ($('.design-option:checked').length === 0) {
            $('.design-option:first').prop('checked', true);
        }
        $('.design-option:checked').change();
    });
</script>
@endsection