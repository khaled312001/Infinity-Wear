@extends('layouts.dashboard')

@section('title', 'تعديل التقرير')
@section('dashboard-title', 'تعديل التقرير')
@section('page-title', 'تعديل تقرير المندوب التسويقي')
@section('page-subtitle', 'تعديل تفاصيل التقرير')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>
                        تعديل التقرير
                    </h5>
                    <a href="{{ route('admin.marketing-reports.show', $marketingReport) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        العودة
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.marketing-reports.update', $marketingReport) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم المندوب <span class="text-danger">*</span></label>
                            <input type="text" name="representative_name" class="form-control" value="{{ old('representative_name', $marketingReport->representative_name) }}" required>
                            @error('representative_name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم الشركة <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $marketingReport->company_name) }}" required>
                            @error('company_name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">عنوان الشركة <span class="text-danger">*</span></label>
                            <textarea name="company_address" class="form-control" rows="2" required>{{ old('company_address', $marketingReport->company_address) }}</textarea>
                            @error('company_address')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">نوع النشاط <span class="text-danger">*</span></label>
                            <select name="company_activity" class="form-select" required>
                                <option value="sports_academy" {{ old('company_activity', $marketingReport->company_activity) === 'sports_academy' ? 'selected' : '' }}>أكاديمية رياضية</option>
                                <option value="school" {{ old('company_activity', $marketingReport->company_activity) === 'school' ? 'selected' : '' }}>مدرسة</option>
                                <option value="institution_company" {{ old('company_activity', $marketingReport->company_activity) === 'institution_company' ? 'selected' : '' }}>مؤسسة / شركة</option>
                                <option value="wholesale_store" {{ old('company_activity', $marketingReport->company_activity) === 'wholesale_store' ? 'selected' : '' }}>محل جملة</option>
                                <option value="retail_store" {{ old('company_activity', $marketingReport->company_activity) === 'retail_store' ? 'selected' : '' }}>محل تجزئة</option>
                                <option value="other" {{ old('company_activity', $marketingReport->company_activity) === 'other' ? 'selected' : '' }}>أخرى</option>
                            </select>
                            @error('company_activity')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">نوع الزيارة <span class="text-danger">*</span></label>
                            <select name="visit_type" class="form-select" required>
                                <option value="office_visit" {{ old('visit_type', $marketingReport->visit_type) === 'office_visit' ? 'selected' : '' }}>زيارة مقر</option>
                                <option value="phone_call" {{ old('visit_type', $marketingReport->visit_type) === 'phone_call' ? 'selected' : '' }}>اتصال</option>
                                <option value="whatsapp" {{ old('visit_type', $marketingReport->visit_type) === 'whatsapp' ? 'selected' : '' }}>رسائل Whatsapp</option>
                            </select>
                            @error('visit_type')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">اسم المسؤول <span class="text-danger">*</span></label>
                            <input type="text" name="responsible_name" class="form-control" value="{{ old('responsible_name', $marketingReport->responsible_name) }}" required>
                            @error('responsible_name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">هاتف المسؤول <span class="text-danger">*</span></label>
                            <input type="text" name="responsible_phone" class="form-control" value="{{ old('responsible_phone', $marketingReport->responsible_phone) }}" required>
                            @error('responsible_phone')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">منصب المسؤول <span class="text-danger">*</span></label>
                            <input type="text" name="responsible_position" class="form-control" value="{{ old('responsible_position', $marketingReport->responsible_position) }}" required>
                            @error('responsible_position')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">حالة الاتفاق <span class="text-danger">*</span></label>
                            <select name="agreement_status" class="form-select" required>
                                <option value="agreed" {{ old('agreement_status', $marketingReport->agreement_status) === 'agreed' ? 'selected' : '' }}>تم الاتفاق</option>
                                <option value="rejected" {{ old('agreement_status', $marketingReport->agreement_status) === 'rejected' ? 'selected' : '' }}>تم الرفض</option>
                                <option value="needs_time" {{ old('agreement_status', $marketingReport->agreement_status) === 'needs_time' ? 'selected' : '' }}>بحاجة إلى وقت</option>
                            </select>
                            @error('agreement_status')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الكمية المستهدفة <span class="text-danger">*</span></label>
                            <input type="number" name="target_quantity" class="form-control" value="{{ old('target_quantity', $marketingReport->target_quantity) }}" min="0" required>
                            @error('target_quantity')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الاستهلاك السنوي <span class="text-danger">*</span></label>
                            <input type="number" name="annual_consumption" class="form-control" value="{{ old('annual_consumption', $marketingReport->annual_consumption) }}" min="0" required>
                            @error('annual_consumption')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">حالة التقرير <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ old('status', $marketingReport->status) === 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                                <option value="under_review" {{ old('status', $marketingReport->status) === 'under_review' ? 'selected' : '' }}>قيد المراجعة</option>
                                <option value="approved" {{ old('status', $marketingReport->status) === 'approved' ? 'selected' : '' }}>موافق عليه</option>
                                <option value="rejected" {{ old('status', $marketingReport->status) === 'rejected' ? 'selected' : '' }}>مرفوض</option>
                            </select>
                            @error('status')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">التوصيات <span class="text-danger">*</span></label>
                            <textarea name="recommendations" class="form-control" rows="3" required>{{ old('recommendations', $marketingReport->recommendations) }}</textarea>
                            @error('recommendations')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">الخطوات التالية <span class="text-danger">*</span></label>
                            <textarea name="next_steps" class="form-control" rows="3" required>{{ old('next_steps', $marketingReport->next_steps) }}</textarea>
                            @error('next_steps')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">ملاحظات المندوب</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $marketingReport->notes) }}</textarea>
                            @error('notes')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label">ملاحظات الإدارة</label>
                            <textarea name="admin_notes" class="form-control" rows="3">{{ old('admin_notes', $marketingReport->admin_notes) }}</textarea>
                            @error('admin_notes')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.marketing-reports.show', $marketingReport) }}" class="btn btn-secondary">
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
