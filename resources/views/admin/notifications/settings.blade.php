@extends('layouts.dashboard')

@section('title', 'إعدادات الإشعارات')
@section('page-title', 'إعدادات الإشعارات')
@section('page-subtitle', 'إدارة إعدادات الإشعارات عبر البريد الإلكتروني')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.notifications.index') }}">الإشعارات</a></li>
                        <li class="breadcrumb-item active">إعدادات الإشعارات</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    <i class="fas fa-cog me-2"></i>
                    إعدادات الإشعارات
                </h4>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.notifications.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- إعدادات البريد الإلكتروني -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-envelope me-2 text-primary"></i>
                            إعدادات البريد الإلكتروني
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- تفعيل الإشعارات -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="email_notifications_enabled" 
                                           name="email_notifications_enabled" 
                                           {{ old('email_notifications_enabled', $settings->email_notifications_enabled) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="email_notifications_enabled">
                                        <strong>تفعيل الإشعارات عبر البريد الإلكتروني</strong>
                                    </label>
                                </div>
                                <div class="form-text">عند التفعيل، سيتم إرسال الإشعارات عبر البريد الإلكتروني</div>
                            </div>
                        </div>

                        <!-- إعدادات SMTP -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="smtp_host" class="form-label">
                                    <i class="fas fa-server me-2 text-info"></i>
                                    خادم SMTP
                                </label>
                                <input type="text" 
                                       class="form-control @error('smtp_host') is-invalid @enderror" 
                                       id="smtp_host" 
                                       name="smtp_host" 
                                       value="{{ old('smtp_host', $settings->smtp_host) }}"
                                       placeholder="smtp.gmail.com">
                                @error('smtp_host')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="smtp_port" class="form-label">
                                    <i class="fas fa-plug me-2 text-warning"></i>
                                    المنفذ
                                </label>
                                <input type="number" 
                                       class="form-control @error('smtp_port') is-invalid @enderror" 
                                       id="smtp_port" 
                                       name="smtp_port" 
                                       value="{{ old('smtp_port', $settings->smtp_port) }}"
                                       placeholder="587">
                                @error('smtp_port')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="smtp_username" class="form-label">
                                    <i class="fas fa-user me-2 text-success"></i>
                                    اسم المستخدم
                                </label>
                                <input type="text" 
                                       class="form-control @error('smtp_username') is-invalid @enderror" 
                                       id="smtp_username" 
                                       name="smtp_username" 
                                       value="{{ old('smtp_username', $settings->smtp_username) }}"
                                       placeholder="your-email@gmail.com">
                                @error('smtp_username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="smtp_password" class="form-label">
                                    <i class="fas fa-lock me-2 text-danger"></i>
                                    كلمة المرور
                                </label>
                                <input type="password" 
                                       class="form-control @error('smtp_password') is-invalid @enderror" 
                                       id="smtp_password" 
                                       name="smtp_password" 
                                       value="{{ old('smtp_password', $settings->smtp_password) }}"
                                       placeholder="كلمة مرور التطبيق">
                                @error('smtp_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">استخدم كلمة مرور التطبيق لـ Gmail</div>
                            </div>

                            <div class="col-md-6">
                                <label for="smtp_encryption" class="form-label">
                                    <i class="fas fa-shield-alt me-2 text-primary"></i>
                                    التشفير
                                </label>
                                <select class="form-select @error('smtp_encryption') is-invalid @enderror" 
                                        id="smtp_encryption" 
                                        name="smtp_encryption">
                                    <option value="tls" {{ old('smtp_encryption', $settings->smtp_encryption) == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ old('smtp_encryption', $settings->smtp_encryption) == 'ssl' ? 'selected' : '' }}>SSL</option>
                                    <option value="null" {{ old('smtp_encryption', $settings->smtp_encryption) == 'null' ? 'selected' : '' }}>بدون تشفير</option>
                                </select>
                                @error('smtp_encryption')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="from_email" class="form-label">
                                    <i class="fas fa-at me-2 text-info"></i>
                                    بريد المرسل
                                </label>
                                <input type="email" 
                                       class="form-control @error('from_email') is-invalid @enderror" 
                                       id="from_email" 
                                       name="from_email" 
                                       value="{{ old('from_email', $settings->from_email) }}"
                                       placeholder="noreply@infinitywear.sa">
                                @error('from_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="from_name" class="form-label">
                                    <i class="fas fa-signature me-2 text-success"></i>
                                    اسم المرسل
                                </label>
                                <input type="text" 
                                       class="form-control @error('from_name') is-invalid @enderror" 
                                       id="from_name" 
                                       name="from_name" 
                                       value="{{ old('from_name', $settings->from_name) }}"
                                       placeholder="Infinity Wear">
                                @error('from_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="admin_email" class="form-label">
                                    <i class="fas fa-user-shield me-2 text-warning"></i>
                                    بريد المدير
                                </label>
                                <input type="email" 
                                       class="form-control @error('admin_email') is-invalid @enderror" 
                                       id="admin_email" 
                                       name="admin_email" 
                                       value="{{ old('admin_email', $settings->admin_email) }}"
                                       placeholder="admin@infinitywear.sa">
                                @error('admin_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">البريد الإلكتروني الذي سيستقبل الإشعارات</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- إعدادات أنواع الإشعارات -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bell me-2 text-success"></i>
                            أنواع الإشعارات
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notify_new_orders" 
                                           name="notify_new_orders" 
                                           {{ old('notify_new_orders', $settings->notify_new_orders) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="notify_new_orders">
                                        <i class="fas fa-shopping-cart me-2 text-primary"></i>
                                        إشعارات الطلبات الجديدة
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notify_contact_messages" 
                                           name="notify_contact_messages" 
                                           {{ old('notify_contact_messages', $settings->notify_contact_messages) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="notify_contact_messages">
                                        <i class="fas fa-envelope me-2 text-info"></i>
                                        إشعارات رسائل الاتصال
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notify_whatsapp_messages" 
                                           name="notify_whatsapp_messages" 
                                           {{ old('notify_whatsapp_messages', $settings->notify_whatsapp_messages) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="notify_whatsapp_messages">
                                        <i class="fab fa-whatsapp me-2 text-success"></i>
                                        إشعارات رسائل الواتساب
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notify_importer_orders" 
                                           name="notify_importer_orders" 
                                           {{ old('notify_importer_orders', $settings->notify_importer_orders) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="notify_importer_orders">
                                        <i class="fas fa-industry me-2 text-warning"></i>
                                        إشعارات طلبات المستوردين
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notify_system_updates" 
                                           name="notify_system_updates" 
                                           {{ old('notify_system_updates', $settings->notify_system_updates) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="notify_system_updates">
                                        <i class="fas fa-cogs me-2 text-secondary"></i>
                                        إشعارات تحديثات النظام
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الإعدادات الإضافية -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-sliders-h me-2 text-info"></i>
                            إعدادات إضافية
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="email_verification_enabled" 
                                       name="email_verification_enabled" 
                                       {{ old('email_verification_enabled', $settings->email_verification_enabled) ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_verification_enabled">
                                    تفعيل التحقق من البريد الإلكتروني
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email_rate_limit" class="form-label">
                                <i class="fas fa-tachometer-alt me-2 text-warning"></i>
                                حد الإرسال (بريد/دقيقة)
                            </label>
                            <input type="number" 
                                   class="form-control @error('email_rate_limit') is-invalid @enderror" 
                                   id="email_rate_limit" 
                                   name="email_rate_limit" 
                                   value="{{ old('email_rate_limit', $settings->email_rate_limit) }}"
                                   min="1" max="1000">
                            @error('email_rate_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="email_queue_enabled" 
                                       name="email_queue_enabled" 
                                       {{ old('email_queue_enabled', $settings->email_queue_enabled) ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_queue_enabled">
                                    تفعيل طابور الإرسال
                                </label>
                            </div>
                            <div class="form-text">إرسال الإيميلات في الخلفية</div>
                        </div>
                    </div>
                </div>

                <!-- اختبار البريد الإلكتروني -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-vial me-2 text-success"></i>
                            اختبار البريد الإلكتروني
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="test_email" class="form-label">البريد الإلكتروني للاختبار</label>
                            <input type="email" class="form-control" id="test_email" placeholder="test@example.com">
                        </div>
                        <button type="button" class="btn btn-outline-success w-100" id="testEmailBtn">
                            <i class="fas fa-paper-plane me-2"></i>
                            إرسال بريد تجريبي
                        </button>
                    </div>
                </div>

                <!-- إعادة تعيين الإعدادات -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-undo me-2 text-warning"></i>
                            إعادة تعيين الإعدادات
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">إعادة تعيين جميع الإعدادات للقيم الافتراضية</p>
                        <a href="{{ route('admin.notifications.settings.reset') }}" 
                           class="btn btn-outline-warning w-100"
                           onclick="return confirm('هل أنت متأكد من إعادة تعيين الإعدادات؟')">
                            <i class="fas fa-undo me-2"></i>
                            إعادة تعيين
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- أزرار الحفظ -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right me-2"></i>
                                العودة للإشعارات
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                حفظ الإعدادات
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // اختبار البريد الإلكتروني
    $('#testEmailBtn').click(function() {
        const testEmail = $('#test_email').val();
        
        if (!testEmail) {
            alert('يرجى إدخال بريد إلكتروني للاختبار');
            return;
        }

        const btn = $(this);
        const originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>جاري الإرسال...');

        $.ajax({
            url: '{{ route("admin.notifications.settings.test") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                test_email: testEmail
            },
            success: function(response) {
                if (response.success) {
                    alert('تم إرسال البريد التجريبي بنجاح!');
                } else {
                    alert('خطأ: ' + response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                alert('خطأ: ' + (response.message || 'حدث خطأ غير متوقع'));
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });
});
</script>
@endpush
