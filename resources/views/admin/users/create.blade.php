@extends('layouts.dashboard')

@section('title', 'إضافة عميل جديد')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'إضافة عميل جديد')
@section('page-subtitle', 'إضافة عميل جديد إلى النظام')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('page-actions')
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        العودة للقائمة
    </a>
@endsection

@section('content')
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="h3 mb-1 text-dark">
                        <i class="fas fa-user-plus text-primary me-3"></i>
                        إضافة عميل جديد
                    </h2>
                    <p class="text-muted mb-0">قم بإضافة عميل جديد إلى النظام مع جميع البيانات المطلوبة</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        العودة للقائمة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white border-0">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        بيانات العميل الأساسية
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.users.store') }}" method="POST" id="userForm" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- Personal Information Section -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-id-card me-2"></i>
                                المعلومات الشخصية
                            </h6>
                            <div class="row g-3">
                                <!-- الاسم -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        الاسم الكامل
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name') }}" 
                                               required
                                               placeholder="أدخل الاسم الكامل">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- البريد الإلكتروني -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        البريد الإلكتروني
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-envelope text-muted"></i>
                                        </span>
                                        <input type="email" 
                                               class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email') }}" 
                                               required
                                               placeholder="example@domain.com">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- رقم الهاتف -->
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-semibold">
                                        <i class="fas fa-phone text-primary me-2"></i>
                                        رقم الهاتف
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-phone text-muted"></i>
                                        </span>
                                        <input type="tel" 
                                               class="form-control border-start-0 @error('phone') is-invalid @enderror" 
                                               id="phone" 
                                               name="phone" 
                                               value="{{ old('phone') }}"
                                               placeholder="+966 50 123 4567">
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- العنوان -->
                                <div class="col-md-6">
                                    <label for="address" class="form-label fw-semibold">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        العنوان
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-map-marker-alt text-muted"></i>
                                        </span>
                                        <textarea class="form-control border-start-0 @error('address') is-invalid @enderror" 
                                                  id="address" 
                                                  name="address" 
                                                  rows="1"
                                                  placeholder="أدخل العنوان الكامل">{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Section -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-shield-alt me-2"></i>
                                معلومات الأمان
                            </h6>
                            <div class="row g-3">
                                <!-- كلمة المرور -->
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="fas fa-lock text-primary me-2"></i>
                                        كلمة المرور
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="password" 
                                               class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               required
                                               placeholder="أدخل كلمة مرور قوية">
                                        <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword('password')">
                                            <i class="fas fa-eye" id="passwordIcon"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل
                                    </div>
                                </div>

                                <!-- تأكيد كلمة المرور -->
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        <i class="fas fa-lock text-primary me-2"></i>
                                        تأكيد كلمة المرور
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="password" 
                                               class="form-control border-start-0" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               required
                                               placeholder="أعد إدخال كلمة المرور">
                                        <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword('password_confirmation')">
                                            <i class="fas fa-eye" id="passwordConfirmationIcon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>
                                إلغاء
                            </a>
                            <button type="button" class="btn btn-outline-primary" onclick="resetForm()">
                                <i class="fas fa-redo me-2"></i>
                                إعادة تعيين
                            </button>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>
                                حفظ العميل
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-info text-white border-0">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        معلومات إضافية
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>نصيحة:</strong> تأكد من صحة جميع البيانات المدخلة قبل الحفظ.
                    </div>
                    
                    <div class="alert alert-warning border-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>تنبيه:</strong> كلمة المرور ستكون مطلوبة للعميل للدخول إلى حسابه.
                    </div>

                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <small class="text-muted">البيانات المطلوبة</small>
                                    <div class="fw-semibold">الاسم والبريد الإلكتروني</div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <small class="text-muted">اختيارية</small>
                                    <div class="fw-semibold">رقم الهاتف والعنوان</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .bg-gradient-primary {
            background: var(--primary-gradient) !important;
        }

        .bg-gradient-info {
            background: var(--info-gradient) !important;
        }

        .card {
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
            border: none;
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
            transform: translateY(-1px);
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
            border: 2px solid #e5e7eb;
            border-right: none;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .input-group .btn {
            border-radius: 0 10px 10px 0;
            border: 2px solid #e5e7eb;
            border-left: none;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transition: all 0.3s ease;
        }

        .input-group .btn:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: translateY(-1px);
        }
        
        .is-invalid {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.15) !important;
        }
        
        .invalid-feedback {
            display: block;
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .btn {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }

        .btn-outline-secondary {
            border: 2px solid #d1d5db;
            color: #6b7280;
        }

        .btn-outline-secondary:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
            color: #374151;
        }

        .btn-outline-primary {
            border: 2px solid #667eea;
            color: #667eea;
        }

        .btn-outline-primary:hover {
            background: #667eea;
            border-color: #667eea;
            color: white;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
        }

        .alert-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
        }

        .list-group-item {
            border-radius: 10px !important;
            margin-bottom: 0.5rem;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background: #f8fafc;
            transform: translateX(5px);
        }

        .text-primary {
            color: #667eea !important;
        }

        .form-text {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 0.5rem;
        }

        .border-top {
            border-top: 2px solid #e5e7eb !important;
        }

        .shadow-sm {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
        }

        /* Animation for form validation */
        .needs-validation .form-control:invalid {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Loading state for submit button */
        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Password toggle functionality
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + 'Icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'fas fa-eye-slash';
                icon.style.color = '#667eea';
            } else {
                field.type = 'password';
                icon.className = 'fas fa-eye';
                icon.style.color = '#6b7280';
            }
        }

        // Reset form functionality
        function resetForm() {
            if (confirm('هل أنت متأكد من إعادة تعيين النموذج؟ سيتم فقدان جميع البيانات المدخلة.')) {
                document.getElementById('userForm').reset();
                // Reset password icons
                document.getElementById('passwordIcon').className = 'fas fa-eye';
                document.getElementById('passwordConfirmationIcon').className = 'fas fa-eye';
                // Clear any validation states
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                document.querySelectorAll('.invalid-feedback').forEach(el => el.style.display = 'none');
            }
        }

        // Form validation and submission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('userForm');
            const submitBtn = form.querySelector('button[type="submit"]');
            
            // Password confirmation validation
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('password_confirmation');
            
            function validatePasswordMatch() {
                if (confirmPasswordField.value && passwordField.value !== confirmPasswordField.value) {
                    confirmPasswordField.setCustomValidity('كلمات المرور غير متطابقة');
                    confirmPasswordField.classList.add('is-invalid');
                } else {
                    confirmPasswordField.setCustomValidity('');
                    confirmPasswordField.classList.remove('is-invalid');
                }
            }
            
            passwordField.addEventListener('input', validatePasswordMatch);
            confirmPasswordField.addEventListener('input', validatePasswordMatch);

            // Phone number formatting
            const phoneField = document.getElementById('phone');
            phoneField.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.startsWith('966')) {
                    value = value.substring(3);
                }
                if (value.startsWith('0')) {
                    value = value.substring(1);
                }
                
                // Format the number
                if (value.length > 0) {
                    if (value.length <= 2) {
                        value = `+966 ${value}`;
                    } else if (value.length <= 5) {
                        value = `+966 ${value.substring(0, 2)} ${value.substring(2)}`;
                    } else if (value.length <= 8) {
                        value = `+966 ${value.substring(0, 2)} ${value.substring(2, 5)} ${value.substring(5)}`;
                    } else {
                        value = `+966 ${value.substring(0, 2)} ${value.substring(2, 5)} ${value.substring(5, 9)}`;
                    }
                }
                
                e.target.value = value;
            });

            // Email validation
            const emailField = document.getElementById('email');
            emailField.addEventListener('blur', function() {
                const email = this.value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (email && !emailRegex.test(email)) {
                    this.setCustomValidity('يرجى إدخال بريد إلكتروني صحيح');
                    this.classList.add('is-invalid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                }
            });

            // Real-time validation for required fields
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                field.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });
                
                field.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.classList.remove('is-invalid');
                    }
                });
            });

            // Form submission with loading state
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate form
                if (!form.checkValidity()) {
                    e.stopPropagation();
                    form.classList.add('was-validated');
                    
                    // Show first invalid field
                    const firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalid.focus();
                    }
                    return;
                }
                
                // Show loading state
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
                
                // Submit form
                setTimeout(() => {
                    form.submit();
                }, 500);
            });

            // Add smooth animations to form elements
            const formElements = form.querySelectorAll('.form-control, .btn');
            formElements.forEach(element => {
                element.addEventListener('focus', function() {
                    this.style.transform = 'translateY(-1px)';
                });
                
                element.addEventListener('blur', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });

        // Add some interactive feedback
        document.addEventListener('DOMContentLoaded', function() {
            // Add ripple effect to buttons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>
    
    <style>
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
@endpush