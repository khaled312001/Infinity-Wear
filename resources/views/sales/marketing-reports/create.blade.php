@extends('layouts.sales-dashboard')

@section('title', 'تقرير مندوب تسويقي جديد')
@section('dashboard-title', 'تقرير مندوب تسويقي جديد')
@section('page-title', 'تقرير مندوب تسويقي جديد')
@section('page-subtitle', 'إنشاء تقرير جديد للمندوب التسويقي')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus me-2"></i>
                    تقرير مندوب تسويقي جديد
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sales.marketing-reports.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <!-- معلومات المندوب -->
                        <div class="col-12 mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-user me-2"></i>
                                معلومات المندوب
                            </h6>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم المندوب <span class="text-danger">*</span></label>
                            <select name="representative_name" class="form-select @error('representative_name') is-invalid @enderror" required>
                                <option value="">اختر المندوب</option>
                                <option value="عمرو الدسوقي" {{ old('representative_name') == 'عمرو الدسوقي' ? 'selected' : '' }}>عمرو الدسوقي</option>
                                <option value="محمد علي" {{ old('representative_name') == 'محمد علي' ? 'selected' : '' }}>محمد علي</option>
                            </select>
                            @error('representative_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- معلومات الجهة -->
                        <div class="col-12 mb-4 mt-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-building me-2"></i>
                                معلومات الجهة
                            </h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم الجهة <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" 
                                   value="{{ old('company_name') }}" required>
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">نشاط الجهة <span class="text-danger">*</span></label>
                            <select name="company_activity" class="form-select @error('company_activity') is-invalid @enderror" required>
                                <option value="">اختر نشاط الجهة</option>
                                <option value="sports_academy" {{ old('company_activity') == 'sports_academy' ? 'selected' : '' }}>أكاديمية رياضية</option>
                                <option value="school" {{ old('company_activity') == 'school' ? 'selected' : '' }}>مدرسة</option>
                                <option value="institution_company" {{ old('company_activity') == 'institution_company' ? 'selected' : '' }}>مؤسسة / شركة</option>
                                <option value="wholesale_store" {{ old('company_activity') == 'wholesale_store' ? 'selected' : '' }}>محل جملة</option>
                                <option value="retail_store" {{ old('company_activity') == 'retail_store' ? 'selected' : '' }}>محل تجزئة</option>
                                <option value="other" {{ old('company_activity') == 'other' ? 'selected' : '' }}>أخرى</option>
                            </select>
                            @error('company_activity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">عنوان الجهة التفصيلي <span class="text-danger">*</span></label>
                            <textarea name="company_address" class="form-control @error('company_address') is-invalid @enderror" 
                                      rows="3" required>{{ old('company_address') }}</textarea>
                            @error('company_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">صورة المكان الذي تم زيارته</label>
                            <input type="file" name="company_images[]" class="form-control @error('company_images.*') is-invalid @enderror" 
                                   multiple accept="image/*">
                            <div class="form-text">يمكنك تحميل ما يصل إلى 5 ملفات متوافقة. الحد الأقصى هو 10 MB لكل ملف.</div>
                            @error('company_images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- معلومات المسئول -->
                        <div class="col-12 mb-4 mt-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-user-tie me-2"></i>
                                معلومات المسئول
                            </h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">اسم المسئول <span class="text-danger">*</span></label>
                            <input type="text" name="responsible_name" class="form-control @error('responsible_name') is-invalid @enderror" 
                                   value="{{ old('responsible_name') }}" required>
                            @error('responsible_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">رقم الجوال <span class="text-danger">*</span></label>
                            <input type="tel" name="responsible_phone" class="form-control @error('responsible_phone') is-invalid @enderror" 
                                   value="{{ old('responsible_phone') }}" required>
                            @error('responsible_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">المنصب <span class="text-danger">*</span></label>
                            <input type="text" name="responsible_position" class="form-control @error('responsible_position') is-invalid @enderror" 
                                   value="{{ old('responsible_position') }}" required>
                            @error('responsible_position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- تفاصيل الزيارة -->
                        <div class="col-12 mb-4 mt-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-calendar-check me-2"></i>
                                تفاصيل الزيارة
                            </h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">نوع الزيارة <span class="text-danger">*</span></label>
                            <select name="visit_type" class="form-select @error('visit_type') is-invalid @enderror" required>
                                <option value="">اختر نوع الزيارة</option>
                                <option value="office_visit" {{ old('visit_type') == 'office_visit' ? 'selected' : '' }}>زيارة مقر</option>
                                <option value="phone_call" {{ old('visit_type') == 'phone_call' ? 'selected' : '' }}>اتصال</option>
                                <option value="whatsapp" {{ old('visit_type') == 'whatsapp' ? 'selected' : '' }}>رسائل Whatsapp</option>
                            </select>
                            @error('visit_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">حالة الاتفاق <span class="text-danger">*</span></label>
                            <select name="agreement_status" class="form-select @error('agreement_status') is-invalid @enderror" required>
                                <option value="">اختر حالة الاتفاق</option>
                                <option value="agreed" {{ old('agreement_status') == 'agreed' ? 'selected' : '' }}>تم الاتفاق</option>
                                <option value="rejected" {{ old('agreement_status') == 'rejected' ? 'selected' : '' }}>تم الرفض</option>
                                <option value="needs_time" {{ old('agreement_status') == 'needs_time' ? 'selected' : '' }}>بحاجة إلى وقت</option>
                            </select>
                            @error('agreement_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">مخاوف العميل</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="customer_concerns[]" value="الخامة" 
                                               {{ in_array('الخامة', old('customer_concerns', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label">الخامة</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="customer_concerns[]" value="الجودة" 
                                               {{ in_array('الجودة', old('customer_concerns', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label">الجودة</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="customer_concerns[]" value="وقت التسليم" 
                                               {{ in_array('وقت التسليم', old('customer_concerns', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label">وقت التسليم</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="customer_concerns[]" value="السعر" 
                                               {{ in_array('السعر', old('customer_concerns', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label">السعر</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input type="text" name="customer_concerns[]" class="form-control" placeholder="أخرى:" 
                                       value="{{ old('customer_concerns.4') }}">
                            </div>
                        </div>

                        <!-- التفاصيل التجارية -->
                        <div class="col-12 mb-4 mt-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-chart-line me-2"></i>
                                التفاصيل التجارية
                            </h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">الكمية المستهدفة <span class="text-danger">*</span></label>
                            <input type="text" name="target_quantity" class="form-control @error('target_quantity') is-invalid @enderror" 
                                   value="{{ old('target_quantity') }}" required>
                            @error('target_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">الاستهلاك السنوي أو عدد الطلبيات السنوية المتوقعة <span class="text-danger">*</span></label>
                            <input type="text" name="annual_consumption" class="form-control @error('annual_consumption') is-invalid @enderror" 
                                   value="{{ old('annual_consumption') }}" required>
                            @error('annual_consumption')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- التوصيات والخطوات -->
                        <div class="col-12 mb-4 mt-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-lightbulb me-2"></i>
                                التوصيات والخطوات
                            </h6>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">توصيات مقترحة وملاحظات</label>
                            <textarea name="recommendations" class="form-control @error('recommendations') is-invalid @enderror" 
                                      rows="4">{{ old('recommendations') }}</textarea>
                            @error('recommendations')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">الخطوات اللاحقة التي ستم تنفيذها مع هذا العميل</label>
                            <textarea name="next_steps" class="form-control @error('next_steps') is-invalid @enderror" 
                                      rows="4">{{ old('next_steps') }}</textarea>
                            @error('next_steps')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">ملاحظات إضافية</label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" 
                                      rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('sales.marketing-reports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            إلغاء
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            حفظ التقرير
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
