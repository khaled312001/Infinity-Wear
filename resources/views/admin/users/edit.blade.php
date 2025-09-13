@extends('layouts.dashboard')

@section('title', 'تعديل العميل - ' . $user->name)
@section('dashboard-title', 'إدارة العملاء')
@section('page-title', 'تعديل بيانات العميل')
@section('page-subtitle', 'تحديث معلومات العميل')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" class="nav-link">
        <i class="fas fa-tachometer-alt me-2"></i>
        الرئيسية
    </a>
    
    <!-- إدارة المحتوى -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-store me-2"></i>
            إدارة المحتوى
        </div>
        <a href="{{ route('admin.orders.index') }}" class="nav-link">
            <i class="fas fa-shopping-cart me-2"></i>
            الطلبات
        </a>
        <a href="{{ route('admin.products.index') }}" class="nav-link">
            <i class="fas fa-tshirt me-2"></i>
            المنتجات
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-link">
            <i class="fas fa-tags me-2"></i>
            الفئات
        </a>
        <a href="{{ route('admin.custom-designs.index') }}" class="nav-link">
            <i class="fas fa-palette me-2"></i>
            التصاميم المخصصة
        </a>
        <a href="{{ route('admin.portfolio.index') }}" class="nav-link">
            <i class="fas fa-image me-2"></i>
            معرض الأعمال
        </a>
        <a href="{{ route('admin.testimonials.index') }}" class="nav-link">
            <i class="fas fa-star me-2"></i>
            الشهادات والتقييمات
        </a>
    </div>
    
    <!-- إدارة المستخدمين -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-users me-2"></i>
            إدارة المستخدمين
        </div>
        <a href="{{ route('admin.users.index') }}" class="nav-link active">
            <i class="fas fa-user me-2"></i>
            العملاء
        </a>
        <a href="{{ route('admin.admins.index') }}" class="nav-link">
            <i class="fas fa-user-shield me-2"></i>
            المشرفين
        </a>
        <a href="{{ route('admin.importers.index') }}" class="nav-link">
            <i class="fas fa-truck me-2"></i>
            المستوردين
        </a>
    </div>
    
    <!-- إدارة الفرق -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-users-cog me-2"></i>
            إدارة الفرق
        </div>
        <a href="{{ route('admin.marketing.index') }}" class="nav-link">
            <i class="fas fa-bullhorn me-2"></i>
            فريق التسويق
        </a>
        <a href="{{ route('admin.sales.index') }}" class="nav-link">
            <i class="fas fa-chart-line me-2"></i>
            فريق المبيعات
        </a>
        <a href="{{ route('admin.tasks.index') }}" class="nav-link">
            <i class="fas fa-tasks me-2"></i>
            إدارة المهام
        </a>
    </div>
    
    <!-- النظام المالي -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-money-bill-wave me-2"></i>
            النظام المالي
        </div>
        <a href="{{ route('admin.finance.dashboard') }}" class="nav-link">
            <i class="fas fa-chart-pie me-2"></i>
            لوحة المالية
        </a>
        <a href="{{ route('admin.finance.transactions') }}" class="nav-link">
            <i class="fas fa-exchange-alt me-2"></i>
            المعاملات المالية
        </a>
        <a href="{{ route('admin.finance.reports') }}" class="nav-link">
            <i class="fas fa-file-invoice-dollar me-2"></i>
            التقارير المالية
        </a>
    </div>
    
    <!-- إدارة المحتوى والـ SEO -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-search me-2"></i>
            المحتوى والـ SEO
        </div>
        <a href="{{ route('admin.content.index') }}" class="nav-link">
            <i class="fas fa-file-alt me-2"></i>
            إدارة المحتوى
        </a>
        <a href="{{ route('admin.content.seo') }}" class="nav-link">
            <i class="fas fa-search-plus me-2"></i>
            إعدادات SEO
        </a>
    </div>
    
    <!-- التقارير والإحصائيات -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-chart-bar me-2"></i>
            التقارير والإحصائيات
        </div>
        <a href="{{ route('admin.reports') }}" class="nav-link">
            <i class="fas fa-analytics me-2"></i>
            تقارير شاملة
        </a>
    </div>
    
    <!-- الإعدادات -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-cog me-2"></i>
            إعدادات النظام
        </div>
        <a href="{{ route('admin.settings') }}" class="nav-link">
            <i class="fas fa-sliders-h me-2"></i>
            الإعدادات العامة
        </a>
    </div>
@endsection

@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-info">
            <i class="fas fa-eye me-2"></i>
            عرض التفاصيل
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            العودة للقائمة
        </a>
    </div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3">
                            <div class="avatar-medium">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        </div>
                        <div>
                            <h5 class="mb-0">
                                <i class="fas fa-user-edit me-2 text-primary"></i>
                                تعديل بيانات العميل
                            </h5>
                            <small class="text-muted">آخر تحديث: {{ $user->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" id="userForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <!-- الاسم -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2 text-primary"></i>
                                    الاسم الكامل
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required
                                       placeholder="أدخل الاسم الكامل">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- البريد الإلكتروني -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2 text-primary"></i>
                                    البريد الإلكتروني
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required
                                       placeholder="example@domain.com">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- رقم الهاتف -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone me-2 text-primary"></i>
                                    رقم الهاتف
                                </label>
                                <input type="tel" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $user->phone) }}"
                                       placeholder="+966 50 123 4567">
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- حالة التفعيل -->
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-check-circle me-2 text-primary"></i>
                                    حالة التفعيل
                                </label>
                                <div class="form-control d-flex align-items-center">
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success me-2">
                                            <i class="fas fa-check me-1"></i>
                                            مفعل
                                        </span>
                                        <small class="text-muted">
                                            تم التفعيل في {{ $user->email_verified_at->format('d/m/Y H:i') }}
                                        </small>
                                    @else
                                        <span class="badge bg-warning me-2">
                                            <i class="fas fa-clock me-1"></i>
                                            غير مفعل
                                        </span>
                                        <small class="text-muted">في انتظار التفعيل</small>
                                    @endif
                                </div>
                            </div>

                            <!-- كلمة المرور الجديدة -->
                            <div class="col-md-6">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2 text-primary"></i>
                                    كلمة المرور الجديدة
                                    <small class="text-muted">(اتركه فارغاً إذا لم ترد التغيير)</small>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="أدخل كلمة مرور جديدة">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="passwordIcon"></i>
                                    </button>
                                </div>
                                <div class="form-text">
                                    كلمة المرور يجب أن تحتوي على 8 أحرف على الأقل
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- تأكيد كلمة المرور -->
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-2 text-primary"></i>
                                    تأكيد كلمة المرور الجديدة
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="أعد إدخال كلمة المرور">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye" id="passwordConfirmationIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- العنوان -->
                            <div class="col-12">
                                <label for="address" class="form-label">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                    العنوان
                                </label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" 
                                          name="address" 
                                          rows="3"
                                          placeholder="أدخل العنوان الكامل">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- معلومات إضافية -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="info-card">
                                    <div class="info-icon text-primary">
                                        <i class="fas fa-calendar-plus"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">تاريخ التسجيل</div>
                                        <div class="info-value">{{ $user->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card">
                                    <div class="info-icon text-success">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">إجمالي الطلبات</div>
                                        <div class="info-value">{{ $user->orders()->count() }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-card">
                                    <div class="info-icon text-info">
                                        <i class="fas fa-palette"></i>
                                    </div>
                                    <div class="info-content">
                                        <div class="info-label">التصاميم المخصصة</div>
                                        <div class="info-value">{{ $user->customDesigns()->count() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- أزرار الحفظ -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>
                                إلغاء
                            </a>
                            <div>
                                <button type="button" class="btn btn-outline-primary me-2" onclick="resetForm()">
                                    <i class="fas fa-redo me-2"></i>
                                    إعادة تعيين
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    حفظ التغييرات
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .avatar-medium {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: 600;
            color: white;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
        }
        
        .input-group .btn {
            border-color: #d1d5db;
        }
        
        .is-invalid {
            border-color: #ef4444;
        }
        
        .invalid-feedback {
            display: block;
            color: #ef4444;
        }
        
        .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .info-card {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }

        .info-icon {
            font-size: 1.5rem;
            margin-left: 0.75rem;
        }

        .info-label {
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1.125rem;
            font-weight: 600;
            color: #374151;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + 'Icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                field.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }

        function resetForm() {
            if (confirm('هل أنت متأكد من إعادة تعيين النموذج؟ سيتم فقدان جميع التغييرات غير المحفوظة.')) {
                document.getElementById('userForm').reset();
            }
        }

        // التحقق من تطابق كلمات المرور
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmation = this.value;
            
            if (password && confirmation && password !== confirmation) {
                this.setCustomValidity('كلمات المرور غير متطابقة');
            } else {
                this.setCustomValidity('');
            }
        });

        // تنسيق رقم الهاتف
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('966')) {
                value = value.substring(3);
            }
            if (value.startsWith('0')) {
                value = value.substring(1);
            }
            
            // تنسيق الرقم
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

        // التحقق من صحة البريد الإلكتروني
        document.getElementById('email').addEventListener('blur', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                this.setCustomValidity('يرجى إدخال بريد إلكتروني صحيح');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
@endpush