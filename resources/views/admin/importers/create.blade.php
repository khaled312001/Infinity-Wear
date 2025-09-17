@extends('layouts.dashboard')

@section('title', 'إضافة مستورد جديد')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'إضافة مستورد جديد')
@section('page-subtitle', 'إضافة مستورد جديد للنظام')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('content')
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-user-plus me-2 text-primary"></i>
                إضافة مستورد جديد
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.importers.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">الاسم <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">الهاتف</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="company_name" class="form-label">اسم الشركة</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                   id="company_name" name="company_name" value="{{ old('company_name') }}">
                            @error('company_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="business_type" class="form-label">نوع النشاط <span class="text-danger">*</span></label>
                            <select class="form-select @error('business_type') is-invalid @enderror" 
                                    id="business_type" name="business_type" required>
                                <option value="">اختر نوع النشاط</option>
                                <option value="academy" {{ old('business_type') == 'academy' ? 'selected' : '' }}>أكاديمية</option>
                                <option value="school" {{ old('business_type') == 'school' ? 'selected' : '' }}>مدرسة</option>
                                <option value="store" {{ old('business_type') == 'store' ? 'selected' : '' }}>متجر</option>
                                <option value="hospital" {{ old('business_type') == 'hospital' ? 'selected' : '' }}>مستشفى</option>
                                <option value="other" {{ old('business_type') == 'other' ? 'selected' : '' }}>أخرى</option>
                            </select>
                            @error('business_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3" id="business_type_other_div" style="display: none;">
                            <label for="business_type_other" class="form-label">تحديد نوع النشاط</label>
                            <input type="text" class="form-control @error('business_type_other') is-invalid @enderror" 
                                   id="business_type_other" name="business_type_other" value="{{ old('business_type_other') }}">
                            @error('business_type_other')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="city" class="form-label">المدينة</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city') }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="country" class="form-label">البلد</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                   id="country" name="country" value="{{ old('country') }}">
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="address" class="form-label">العنوان</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" name="address" rows="3">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="notes" class="form-label">ملاحظات</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                              id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.importers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        حفظ المستورد
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // إظهار/إخفاء حقل نوع النشاط الآخر
    document.getElementById('business_type').addEventListener('change', function() {
        const otherDiv = document.getElementById('business_type_other_div');
        const otherInput = document.getElementById('business_type_other');
        
        if (this.value === 'other') {
            otherDiv.style.display = 'block';
            otherInput.required = true;
        } else {
            otherDiv.style.display = 'none';
            otherInput.required = false;
            otherInput.value = '';
        }
    });
    
    // إظهار الحقل إذا كان محدد مسبقاً
    if (document.getElementById('business_type').value === 'other') {
        document.getElementById('business_type_other_div').style.display = 'block';
        document.getElementById('business_type_other').required = true;
    }
</script>
@endpush