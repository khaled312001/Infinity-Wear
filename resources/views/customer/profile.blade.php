@extends('layouts.dashboard')

@section('title', 'الملف الشخصي')
@section('dashboard-title', 'لوحة العميل')
@section('page-title', 'الملف الشخصي')
@section('page-subtitle', 'إدارة وتحديث معلوماتك الشخصية')
@section('profile-route', route('customer.profile'))
@section('settings-route', route('customer.settings'))

@section('sidebar-menu')
    <a href="{{ route('customer.dashboard') }}" class="nav-link">
        <i class="fas fa-tachometer-alt me-2"></i>
        الرئيسية
    </a>
    <a href="{{ route('customer.orders') }}" class="nav-link">
        <i class="fas fa-shopping-cart me-2"></i>
        طلباتي
    </a>
    <a href="{{ route('customer.designs') }}" class="nav-link">
        <i class="fas fa-palette me-2"></i>
        تصاميمي
    </a>
    <a href="{{ route('products.index') }}" class="nav-link">
        <i class="fas fa-tshirt me-2"></i>
        المنتجات
    </a>
    <a href="{{ route('custom-designs.create') }}" class="nav-link">
        <i class="fas fa-plus me-2"></i>
        تصميم جديد
    </a>
    <a href="{{ route('customer.profile') }}" class="nav-link active">
        <i class="fas fa-user me-2"></i>
        الملف الشخصي
    </a>
@endsection

@section('content')
    <div class="row g-4">
        <!-- Profile Information -->
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2 text-primary"></i>
                        المعلومات الشخصية
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">الاسم الكامل</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">رقم الهاتف</label>
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="city" class="form-label">المدينة</label>
                                <input type="text" 
                                       class="form-control @error('city') is-invalid @enderror" 
                                       id="city" 
                                       name="city" 
                                       value="{{ old('city', $user->city) }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">العنوان</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" 
                                          name="address" 
                                          rows="3">{{ old('address', $user->address) }}</textarea>
                                @error('address')
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

            <!-- Change Password -->
            <div class="dashboard-card mt-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-lock me-2 text-warning"></i>
                        تغيير كلمة المرور
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.password.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password" 
                                       required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">كلمة المرور الجديدة</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required 
                                       minlength="8">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required 
                                       minlength="8">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key me-2"></i>
                                تحديث كلمة المرور
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Profile Summary -->
        <div class="col-lg-4">
            <!-- Account Summary -->
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2 text-info"></i>
                        ملخص الحساب
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="stats-icon primary mx-auto mb-3" style="width: 80px; height: 80px; font-size: 32px;">
                            <i class="fas fa-user"></i>
                        </div>
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <p class="text-muted">{{ $user->email }}</p>
                        <span class="badge bg-success">عميل نشط</span>
                    </div>

                    <div class="border-top pt-3">
                        <div class="row text-center">
                            <div class="col-6 border-end">
                                <h5 class="text-primary mb-0">{{ $user->orders()->count() }}</h5>
                                <small class="text-muted">إجمالي الطلبات</small>
                            </div>
                            <div class="col-6">
                                <h5 class="text-info mb-0">{{ $user->customDesigns()->count() }}</h5>
                                <small class="text-muted">التصاميم المخصصة</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Details -->
            <div class="dashboard-card mt-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar me-2 text-success"></i>
                        تفاصيل الحساب
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">تاريخ التسجيل</span>
                        <strong>{{ $user->created_at->format('Y-m-d') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">آخر تحديث</span>
                        <strong>{{ $user->updated_at->diffForHumans() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">نوع الحساب</span>
                        <span class="badge bg-primary">{{ ucfirst($user->user_type) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">حالة الحساب</span>
                        <span class="badge bg-success">نشط</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="dashboard-card mt-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2 text-warning"></i>
                        إجراءات سريعة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('customer.orders') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart me-2"></i>
                            عرض الطلبات
                        </a>
                        <a href="{{ route('customer.designs') }}" class="btn btn-outline-info">
                            <i class="fas fa-palette me-2"></i>
                            عرض التصاميم
                        </a>
                        <a href="{{ route('custom-designs.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-plus me-2"></i>
                            تصميم جديد
                        </a>
                        <a href="{{ route('customer.settings') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-cog me-2"></i>
                            الإعدادات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Password confirmation validation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;
            
            if (password !== confirmation) {
                this.setCustomValidity('كلمة المرور غير متطابقة');
            } else {
                this.setCustomValidity('');
            }
        });

        // Form validation feedback
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });
            });
        });
    </script>
@endpush