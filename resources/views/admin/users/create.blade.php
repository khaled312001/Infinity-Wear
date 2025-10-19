@extends('layouts.dashboard')

@section('title', 'إضافة مستخدم جديد')
@section('page-title', 'إضافة مستخدم جديد')
@section('page-subtitle', 'إضافة مستخدم جديد إلى النظام')

@section('page-actions')
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-right"></i> العودة للقائمة
    </a>
@endsection

@section('content')
<div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">بيانات المستخدم</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <!-- الاسم -->
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">الاسم <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- البريد الإلكتروني -->
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- كلمة المرور -->
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">كلمة المرور <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- تأكيد كلمة المرور -->
                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation" required>
                                    </div>

                                    <!-- نوع المستخدم -->
                                    <div class="col-md-6 mb-3">
                                        <label for="user_type" class="form-label">نوع المستخدم <span class="text-danger">*</span></label>
                                        <select class="form-select @error('user_type') is-invalid @enderror" 
                                                id="user_type" name="user_type" required onchange="toggleUserTypeFields()">
                                            <option value="">اختر نوع المستخدم</option>
                                            @foreach($userTypes as $value => $label)
                                                <option value="{{ $value }}" {{ old('user_type') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- رقم الهاتف -->
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">رقم الهاتف</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- المدينة -->
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">المدينة</label>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                               id="city" name="city" value="{{ old('city') }}">
                                        @error('city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- العنوان -->
                                    <div class="col-md-6 mb-3">
                                        <label for="address" class="form-label">العنوان</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                                  id="address" name="address" rows="3">{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- الصورة الشخصية -->
                                    <div class="col-md-6 mb-3">
                                        <label for="avatar" class="form-label">الصورة الشخصية</label>
                                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" 
                                               id="avatar" name="avatar" accept="image/*">
                                        @error('avatar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">الحد الأقصى: 2MB، الأنواع المسموحة: JPG, PNG, GIF</div>
                                    </div>

                                    <!-- نبذة شخصية -->
                                    <div class="col-md-6 mb-3">
                                        <label for="bio" class="form-label">نبذة شخصية</label>
                                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                                                  id="bio" name="bio" rows="3">{{ old('bio') }}</textarea>
                                        @error('bio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- الحالة -->
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                                   value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                تفعيل المستخدم
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- حقول إضافية حسب نوع المستخدم -->
                                <div id="importer-fields" style="display: none;">
                                    <hr>
                                    <h6 class="text-primary">بيانات المستورد</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="company_name" class="form-label">اسم الشركة</label>
                                            <input type="text" class="form-control" id="company_name" name="company_name" 
                                                   value="{{ old('company_name') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="company_type" class="form-label">نوع الشركة</label>
                                            <select class="form-select" id="company_type" name="company_type">
                                                <option value="">اختر نوع الشركة</option>
                                                <option value="individual" {{ old('company_type') == 'individual' ? 'selected' : '' }}>فرد</option>
                                                <option value="company" {{ old('company_type') == 'company' ? 'selected' : '' }}>شركة</option>
                                                <option value="institution" {{ old('company_type') == 'institution' ? 'selected' : '' }}>مؤسسة</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="business_license" class="form-label">رقم السجل التجاري</label>
                                            <input type="text" class="form-control" id="business_license" name="business_license" 
                                                   value="{{ old('business_license') }}">
                                        </div>
                                    </div>
                                </div>

                                <div id="marketing-fields" style="display: none;">
                                    <hr>
                                    <h6 class="text-primary">بيانات فريق التسويق</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="department" class="form-label">القسم</label>
                                            <input type="text" class="form-control" id="department" name="department" 
                                                   value="{{ old('department', 'تسويق') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="position" class="form-label">المنصب</label>
                                            <input type="text" class="form-control" id="position" name="position" 
                                                   value="{{ old('position', 'موظف تسويق') }}">
                                        </div>
                                    </div>
                                </div>

                                <div id="sales-fields" style="display: none;">
                                    <hr>
                                    <h6 class="text-primary">بيانات فريق المبيعات</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="department" class="form-label">القسم</label>
                                            <input type="text" class="form-control" id="department" name="department" 
                                                   value="{{ old('department', 'مبيعات') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="position" class="form-label">المنصب</label>
                                            <input type="text" class="form-control" id="position" name="position" 
                                                   value="{{ old('position', 'مندوب مبيعات') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> إلغاء
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> حفظ المستخدم
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">معلومات إضافية</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> ملاحظات مهمة</h6>
                                <ul class="mb-0">
                                    <li>سيتم إرسال بيانات الدخول للمستخدم عبر البريد الإلكتروني</li>
                                    <li>يمكن للمستخدم تغيير كلمة المرور بعد تسجيل الدخول</li>
                                    <li>المستوردون سيظهرون في صفحة المستوردين تلقائياً</li>
                                    <li>يمكن إدارة صلاحيات المستخدم من صفحة الصلاحيات</li>
                                </ul>
                            </div>

                            <div class="alert alert-warning">
                                <h6><i class="fas fa-exclamation-triangle"></i> تحذير</h6>
                                <p class="mb-0">تأكد من صحة البيانات المدخلة قبل الحفظ، خاصة البريد الإلكتروني ورقم الهاتف.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

@section('scripts')
<script>
    function toggleUserTypeFields() {
        const userType = document.getElementById('user_type').value;
        
        // إخفاء جميع الحقول الإضافية
        document.getElementById('importer-fields').style.display = 'none';
        document.getElementById('marketing-fields').style.display = 'none';
        document.getElementById('sales-fields').style.display = 'none';
        
        // إظهار الحقول المناسبة
        if (userType === 'importer') {
            document.getElementById('importer-fields').style.display = 'block';
        } else if (userType === 'marketing') {
            document.getElementById('marketing-fields').style.display = 'block';
        } else if (userType === 'sales') {
            document.getElementById('sales-fields').style.display = 'block';
        }
    }

    // تشغيل الدالة عند تحميل الصفحة
    document.addEventListener('DOMContentLoaded', function() {
        toggleUserTypeFields();
    });
</script>
@endsection