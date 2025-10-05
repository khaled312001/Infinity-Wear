@extends('layouts.dashboard')

@section('title', 'الملف الشخصي')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'الملف الشخصي')
@section('page-subtitle', 'إدارة معلوماتك الشخصية وإعدادات الحساب')
@section('profile-route', route('admin.profile'))
@section('settings-route', route('admin.settings'))

@section('content')
<div class="row g-4">
    <!-- معلومات الملف الشخصي -->
    <div class="col-lg-8">
        <div class="dashboard-card">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2 text-primary"></i>
                    معلومات الملف الشخصي
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">الاسم الكامل</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="phone" class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $admin->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="role" class="form-label">الدور</label>
                            <input type="text" class="form-control" value="{{ $admin->role }}" readonly>
                        </div>
                        
                        <div class="col-12">
                            <label for="bio" class="form-label">نبذة شخصية</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                      id="bio" name="bio" rows="4" 
                                      placeholder="اكتب نبذة مختصرة عنك...">{{ old('bio', $admin->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- معلومات إضافية -->
    <div class="col-lg-4">
        <!-- تغيير كلمة المرور -->
        <div class="dashboard-card">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-lock me-2 text-warning"></i>
                    تغيير كلمة المرور
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.profile.password.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">كلمة المرور الجديدة</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>
                    
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="fas fa-key me-2"></i>
                        تغيير كلمة المرور
                    </button>
                </form>
            </div>
        </div>
        
        <!-- معلومات الحساب -->
        <div class="dashboard-card mt-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2 text-info"></i>
                    معلومات الحساب
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">تاريخ الإنشاء:</span>
                    <span class="fw-bold">{{ $admin->created_at->format('Y/m/d') }}</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">آخر تحديث:</span>
                    <span class="fw-bold">{{ $admin->updated_at->format('Y/m/d H:i') }}</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">حالة الحساب:</span>
                    <span class="badge bg-{{ $admin->is_active ? 'success' : 'danger' }}">
                        {{ $admin->is_active ? 'نشط' : 'معطل' }}
                    </span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">معرف المشرف:</span>
                    <span class="fw-bold text-muted">#{{ $admin->id }}</span>
                </div>
            </div>
        </div>
        
        <!-- إحصائيات سريعة -->
        <div class="dashboard-card mt-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2 text-success"></i>
                    إحصائيات سريعة
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3 text-center">
                    <div class="col-6">
                        <div class="stats-icon primary mx-auto mb-2" style="width: 50px; height: 50px; font-size: 20px;">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h6 class="mb-1">{{ $admin->tasks()->count() ?? 0 }}</h6>
                        <small class="text-muted">المهام</small>
                    </div>
                    
                    <div class="col-6">
                        <div class="stats-icon success mx-auto mb-2" style="width: 50px; height: 50px; font-size: 20px;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h6 class="mb-1">{{ $admin->tasks()->where('status', 'completed')->count() ?? 0 }}</h6>
                        <small class="text-muted">مكتملة</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // إضافة تأثيرات تفاعلية للنماذج
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
    });
    
    // تأكيد تغيير كلمة المرور
    document.querySelector('form[action*="password"]').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('كلمة المرور الجديدة وتأكيدها غير متطابقتين');
            return false;
        }
        
        if (password.length < 8) {
            e.preventDefault();
            alert('كلمة المرور يجب أن تكون 8 أحرف على الأقل');
            return false;
        }
    });
</script>
@endpush
