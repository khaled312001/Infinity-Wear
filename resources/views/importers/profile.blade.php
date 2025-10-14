@extends('layouts.dashboard')

@section('title', 'الملف الشخصي - لوحة تحكم المستورد')
@section('dashboard-title', 'لوحة المستورد')
@section('page-title', 'الملف الشخصي')
@section('page-subtitle', 'إدارة بياناتك الشخصية')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>
                        بياناتي الشخصية
                    </h5>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('importers.profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">الاسم الكامل <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $importer->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $importer->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $importer->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="company_name" class="form-label">اسم الشركة/المؤسسة <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                           id="company_name" name="company_name" value="{{ old('company_name', $importer->company_name) }}" required>
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
                                        <option value="academy" {{ old('business_type', $importer->business_type) == 'academy' ? 'selected' : '' }}>أكاديمية</option>
                                        <option value="school" {{ old('business_type', $importer->business_type) == 'school' ? 'selected' : '' }}>مدرسة</option>
                                        <option value="store" {{ old('business_type', $importer->business_type) == 'store' ? 'selected' : '' }}>متجر</option>
                                        <option value="hospital" {{ old('business_type', $importer->business_type) == 'hospital' ? 'selected' : '' }}>مستشفى</option>
                                        <option value="other" {{ old('business_type', $importer->business_type) == 'other' ? 'selected' : '' }}>أخرى</option>
                                    </select>
                                    @error('business_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3" id="business_type_other_div" style="{{ old('business_type', $importer->business_type) == 'other' ? '' : 'display: none;' }}">
                                    <label for="business_type_other" class="form-label">تحديد نوع النشاط</label>
                                    <input type="text" class="form-control @error('business_type_other') is-invalid @enderror" 
                                           id="business_type_other" name="business_type_other" 
                                           value="{{ old('business_type_other', $importer->business_type_other) }}">
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
                                           id="city" name="city" value="{{ old('city', $importer->city) }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="country" class="form-label">البلد</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror" 
                                           id="country" name="country" value="{{ old('country', $importer->country) }}">
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">العنوان</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3">{{ old('address', $importer->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        معلومات الحساب
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">تاريخ التسجيل</label>
                        <p class="mb-0">{{ $importer->created_at->format('Y-m-d') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">حالة الحساب</label>
                        <p class="mb-0">
                            @switch($importer->status)
                                @case('new')
                                    <span class="badge bg-warning">جديد</span>
                                    @break
                                @case('active')
                                    <span class="badge bg-success">نشط</span>
                                    @break
                                @case('suspended')
                                    <span class="badge bg-danger">معلق</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $importer->status }}</span>
                            @endswitch
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">إجمالي الطلبات</label>
                        <p class="mb-0">{{ $importer->orders()->count() }} طلب</p>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>
                        إعدادات الحساب
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-key me-2"></i>
                            تغيير كلمة المرور
                        </a>
                        <a href="#" class="btn btn-outline-secondary">
                            <i class="fas fa-bell me-2"></i>
                            إعدادات الإشعارات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const businessTypeSelect = document.getElementById('business_type');
    const businessTypeOtherDiv = document.getElementById('business_type_other_div');
    
    businessTypeSelect.addEventListener('change', function() {
        if (this.value === 'other') {
            businessTypeOtherDiv.style.display = 'block';
        } else {
            businessTypeOtherDiv.style.display = 'none';
        }
    });
});
</script>
@endsection