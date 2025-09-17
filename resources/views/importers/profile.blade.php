@extends('layouts.dashboard')

@section('title', 'الملف الشخصي للمستورد')
@section('dashboard-title', 'لوحة المستورد')
@section('page-title', 'الملف الشخصي')
@section('page-subtitle', 'إدارة وتحديث معلوماتك الشخصية')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    <a href="{{ route('importers.dashboard') }}" class="nav-link">
        <i class="fas fa-tachometer-alt me-2"></i>
        الرئيسية
    </a>
    <a href="{{ route('importers.orders') }}" class="nav-link">
        <i class="fas fa-shopping-cart me-2"></i>
        طلباتي
    </a>
    <a href="#" class="nav-link">
        <i class="fas fa-truck me-2"></i>
        عمليات الاستيراد
    </a>
    <a href="#" class="nav-link">
        <i class="fas fa-chart-line me-2"></i>
        التقارير
    </a>
    <a href="#" class="nav-link active">
        <i class="fas fa-user me-2"></i>
        الملف الشخصي
    </a>
    <a href="#" class="nav-link">
        <i class="fas fa-cog me-2"></i>
        الإعدادات
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
                    <form method="POST" action="{{ route('importers.profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">اسم الشركة/المؤسسة</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $importer->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="contact_person" class="form-label">اسم الشخص المسؤول</label>
                                <input type="text" 
                                       class="form-control @error('contact_person') is-invalid @enderror" 
                                       id="contact_person" 
                                       name="contact_person" 
                                       value="{{ old('contact_person', $importer->contact_person) }}" 
                                       required>
                                @error('contact_person')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">البريد الإلكتروني</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $importer->email) }}" 
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
                                       value="{{ old('phone', $importer->phone) }}"
                                       required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="commercial_register" class="form-label">رقم السجل التجاري</label>
                                <input type="text" 
                                       class="form-control @error('commercial_register') is-invalid @enderror" 
                                       id="commercial_register" 
                                       name="commercial_register" 
                                       value="{{ old('commercial_register', $importer->commercial_register) }}">
                                @error('commercial_register')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="tax_number" class="form-label">الرقم الضريبي</label>
                                <input type="text" 
                                       class="form-control @error('tax_number') is-invalid @enderror" 
                                       id="tax_number" 
                                       name="tax_number" 
                                       value="{{ old('tax_number', $importer->tax_number) }}">
                                @error('tax_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="city" class="form-label">المدينة</label>
                                <input type="text" 
                                       class="form-control @error('city') is-invalid @enderror" 
                                       id="city" 
                                       name="city" 
                                       value="{{ old('city', $importer->city) }}"
                                       required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="country" class="form-label">البلد</label>
                                <input type="text" 
                                       class="form-control @error('country') is-invalid @enderror" 
                                       id="country" 
                                       name="country" 
                                       value="{{ old('country', $importer->country) }}"
                                       required>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">العنوان التفصيلي</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" 
                                          name="address" 
                                          rows="3"
                                          required>{{ old('address', $importer->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="business_type" class="form-label">نوع النشاط التجاري</label>
                                <select class="form-select @error('business_type') is-invalid @enderror" 
                                        id="business_type" 
                                        name="business_type">
                                    <option value="">اختر نوع النشاط</option>
                                    <option value="retail" {{ old('business_type', $importer->business_type) == 'retail' ? 'selected' : '' }}>تجارة التجزئة</option>
                                    <option value="wholesale" {{ old('business_type', $importer->business_type) == 'wholesale' ? 'selected' : '' }}>تجارة الجملة</option>
                                    <option value="manufacturing" {{ old('business_type', $importer->business_type) == 'manufacturing' ? 'selected' : '' }}>التصنيع</option>
                                    <option value="distribution" {{ old('business_type', $importer->business_type) == 'distribution' ? 'selected' : '' }}>التوزيع</option>
                                    <option value="other" {{ old('business_type', $importer->business_type) == 'other' ? 'selected' : '' }}>أخرى</option>
                                </select>
                                @error('business_type')
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
                            <i class="fas fa-building"></i>
                        </div>
                        <h4 class="mb-1">{{ $importer->name }}</h4>
                        <p class="text-muted">{{ $importer->email }}</p>
                        <span class="badge bg-{{ $importer->status == 'active' ? 'success' : 'warning' }}">
                            {{ $importer->status == 'active' ? 'نشط' : 'قيد المراجعة' }}
                        </span>
                    </div>

                    <div class="border-top pt-3">
                        <div class="row text-center">
                            <div class="col-6 border-end">
                                <h5 class="text-primary mb-0">{{ $importer->orders()->count() }}</h5>
                                <small class="text-muted">إجمالي الطلبات</small>
                            </div>
                            <div class="col-6">
                                <h5 class="text-info mb-0">{{ $importer->orders()->where('status', 'completed')->count() }}</h5>
                                <small class="text-muted">طلبات مكتملة</small>
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
                        <strong>{{ $importer->created_at->format('Y-m-d') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">آخر تحديث</span>
                        <strong>{{ $importer->updated_at->diffForHumans() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">نوع النشاط</span>
                        <span class="badge bg-primary">{{ ucfirst($importer->business_type ?? 'غير محدد') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">حالة الحساب</span>
                        <span class="badge bg-{{ $importer->status == 'active' ? 'success' : 'warning' }}">
                            {{ $importer->status == 'active' ? 'نشط' : 'قيد المراجعة' }}
                        </span>
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
                        <a href="{{ route('importers.orders') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart me-2"></i>
                            عرض الطلبات
                        </a>
                        <a href="{{ route('importers.form') }}" class="btn btn-outline-success">
                            <i class="fas fa-plus me-2"></i>
                            طلب استيراد جديد
                        </a>
                        <a href="#" class="btn btn-outline-info">
                            <i class="fas fa-chart-line me-2"></i>
                            التقارير
                        </a>
                        <a href="#" class="btn btn-outline-secondary">
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
        // Form validation feedback
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });
            }
        });
    </script>
@endpush