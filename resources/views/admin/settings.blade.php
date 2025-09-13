@extends('layouts.dashboard')

@section('title', 'الإعدادات العامة')
@section('dashboard-title', 'إعدادات النظام')
@section('page-title', 'الإعدادات العامة')
@section('page-subtitle', 'إدارة إعدادات الموقع والنظام العامة')

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
        <a href="{{ route('admin.users.index') }}" class="nav-link">
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
        <a href="{{ route('admin.settings') }}" class="nav-link active">
            <i class="fas fa-sliders-h me-2"></i>
            الإعدادات العامة
        </a>
    </div>
@endsection

@section('page-actions')
    <div class="d-flex gap-2">
        <button class="btn btn-success" onclick="backupSettings()">
            <i class="fas fa-download me-2"></i>
            نسخ احتياطي
        </button>
        <button class="btn btn-warning" onclick="resetSettings()">
            <i class="fas fa-undo me-2"></i>
            استعادة الافتراضية
        </button>
    </div>
@endsection

@section('content')
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

    <div class="row g-4">
        <!-- علامات التبويب -->
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <ul class="nav nav-tabs card-header-tabs" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                                <i class="fas fa-cog me-2"></i>
                                الإعدادات العامة
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab">
                                <i class="fas fa-phone me-2"></i>
                                معلومات الاتصال
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab">
                                <i class="fas fa-share-alt me-2"></i>
                                وسائل التواصل
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="system-tab" data-bs-toggle="tab" data-bs-target="#system" type="button" role="tab">
                                <i class="fas fa-server me-2"></i>
                                إعدادات النظام
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="maintenance-tab" data-bs-toggle="tab" data-bs-target="#maintenance" type="button" role="tab">
                                <i class="fas fa-tools me-2"></i>
                                الصيانة
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="tab-content" id="settingsTabsContent">
                            <!-- الإعدادات العامة -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="site_name" class="form-label">
                                            <i class="fas fa-globe me-2 text-primary"></i>
                                            اسم الموقع
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('site_name') is-invalid @enderror" 
                                               id="site_name" 
                                               name="site_name" 
                                               value="{{ old('site_name', 'Infinity Wear') }}" 
                                               required>
                                        @error('site_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="site_tagline" class="form-label">
                                            <i class="fas fa-tag me-2 text-primary"></i>
                                            شعار الموقع
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="site_tagline" 
                                               name="site_tagline" 
                                               value="{{ old('site_tagline', 'مؤسسة اللباس اللامحدود') }}">
                                    </div>

                                    <div class="col-12">
                                        <label for="site_description" class="form-label">
                                            <i class="fas fa-align-left me-2 text-primary"></i>
                                            وصف الموقع
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control @error('site_description') is-invalid @enderror" 
                                                  id="site_description" 
                                                  name="site_description" 
                                                  rows="3" 
                                                  required>{{ old('site_description', 'مؤسسة اللباس اللامحدود - متخصصون في تصنيع وتوريد الملابس والزي الرسمي للشركات والمؤسسات') }}</textarea>
                                        @error('site_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="site_logo" class="form-label">
                                            <i class="fas fa-image me-2 text-primary"></i>
                                            شعار الموقع
                                        </label>
                                        <input type="file" 
                                               class="form-control" 
                                               id="site_logo" 
                                               name="site_logo" 
                                               accept="image/*">
                                        <div class="form-text">الحد الأقصى: 2MB، الصيغ المدعومة: JPG, PNG, SVG</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="site_favicon" class="form-label">
                                            <i class="fas fa-star me-2 text-primary"></i>
                                            أيقونة الموقع (Favicon)
                                        </label>
                                        <input type="file" 
                                               class="form-control" 
                                               id="site_favicon" 
                                               name="site_favicon" 
                                               accept="image/*">
                                        <div class="form-text">الحجم المفضل: 32x32px أو 16x16px</div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="default_language" class="form-label">
                                            <i class="fas fa-language me-2 text-primary"></i>
                                            اللغة الافتراضية
                                        </label>
                                        <select class="form-select" id="default_language" name="default_language">
                                            <option value="ar" selected>العربية</option>
                                            <option value="en">الإنجليزية</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="default_currency" class="form-label">
                                            <i class="fas fa-money-bill me-2 text-primary"></i>
                                            العملة الافتراضية
                                        </label>
                                        <select class="form-select" id="default_currency" name="default_currency">
                                            <option value="SAR" selected>ريال سعودي (ر.س)</option>
                                            <option value="USD">دولار أمريكي ($)</option>
                                            <option value="EUR">يورو (€)</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="timezone" class="form-label">
                                            <i class="fas fa-clock me-2 text-primary"></i>
                                            المنطقة الزمنية
                                        </label>
                                        <select class="form-select" id="timezone" name="timezone">
                                            <option value="Asia/Riyadh" selected>الرياض (GMT+3)</option>
                                            <option value="Asia/Dubai">دبي (GMT+4)</option>
                                            <option value="UTC">UTC (GMT+0)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- معلومات الاتصال -->
                            <div class="tab-pane fade" id="contact" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="contact_email" class="form-label">
                                            <i class="fas fa-envelope me-2 text-primary"></i>
                                            البريد الإلكتروني
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" 
                                               class="form-control @error('contact_email') is-invalid @enderror" 
                                               id="contact_email" 
                                               name="contact_email" 
                                               value="{{ old('contact_email', 'info@infinitywear.com') }}" 
                                               required>
                                        @error('contact_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="contact_phone" class="form-label">
                                            <i class="fas fa-phone me-2 text-primary"></i>
                                            رقم الهاتف
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="tel" 
                                               class="form-control @error('contact_phone') is-invalid @enderror" 
                                               id="contact_phone" 
                                               name="contact_phone" 
                                               value="{{ old('contact_phone', '+966 50 123 4567') }}" 
                                               required>
                                        @error('contact_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="whatsapp_number" class="form-label">
                                            <i class="fab fa-whatsapp me-2 text-success"></i>
                                            رقم الواتساب
                                        </label>
                                        <input type="tel" 
                                               class="form-control" 
                                               id="whatsapp_number" 
                                               name="whatsapp_number" 
                                               value="{{ old('whatsapp_number', '+966 50 123 4567') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="support_email" class="form-label">
                                            <i class="fas fa-life-ring me-2 text-info"></i>
                                            بريد الدعم الفني
                                        </label>
                                        <input type="email" 
                                               class="form-control" 
                                               id="support_email" 
                                               name="support_email" 
                                               value="{{ old('support_email', 'support@infinitywear.com') }}">
                                    </div>

                                    <div class="col-12">
                                        <label for="address" class="form-label">
                                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                            العنوان
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                                  id="address" 
                                                  name="address" 
                                                  rows="3" 
                                                  required>{{ old('address', 'المملكة العربية السعودية، الرياض، حي النخيل، شارع الملك فهد') }}</textarea>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="business_hours" class="form-label">
                                            <i class="fas fa-business-time me-2 text-warning"></i>
                                            ساعات العمل
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="business_hours" 
                                               name="business_hours" 
                                               value="{{ old('business_hours', 'الأحد - الخميس: 8:00 ص - 6:00 م') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="emergency_contact" class="form-label">
                                            <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
                                            رقم الطوارئ
                                        </label>
                                        <input type="tel" 
                                               class="form-control" 
                                               id="emergency_contact" 
                                               name="emergency_contact" 
                                               value="{{ old('emergency_contact', '+966 50 987 6543') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- وسائل التواصل الاجتماعي -->
                            <div class="tab-pane fade" id="social" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="facebook_url" class="form-label">
                                            <i class="fab fa-facebook me-2 text-primary"></i>
                                            فيسبوك
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('facebook_url') is-invalid @enderror" 
                                               id="facebook_url" 
                                               name="facebook_url" 
                                               value="{{ old('facebook_url', 'https://facebook.com/infinitywear') }}"
                                               placeholder="https://facebook.com/yourpage">
                                        @error('facebook_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="twitter_url" class="form-label">
                                            <i class="fab fa-twitter me-2 text-info"></i>
                                            تويتر
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('twitter_url') is-invalid @enderror" 
                                               id="twitter_url" 
                                               name="twitter_url" 
                                               value="{{ old('twitter_url', 'https://twitter.com/infinitywear') }}"
                                               placeholder="https://twitter.com/youraccount">
                                        @error('twitter_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="instagram_url" class="form-label">
                                            <i class="fab fa-instagram me-2 text-danger"></i>
                                            إنستغرام
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('instagram_url') is-invalid @enderror" 
                                               id="instagram_url" 
                                               name="instagram_url" 
                                               value="{{ old('instagram_url', 'https://instagram.com/infinitywear') }}"
                                               placeholder="https://instagram.com/youraccount">
                                        @error('instagram_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="linkedin_url" class="form-label">
                                            <i class="fab fa-linkedin me-2 text-primary"></i>
                                            لينكد إن
                                        </label>
                                        <input type="url" 
                                               class="form-control @error('linkedin_url') is-invalid @enderror" 
                                               id="linkedin_url" 
                                               name="linkedin_url" 
                                               value="{{ old('linkedin_url', 'https://linkedin.com/company/infinitywear') }}"
                                               placeholder="https://linkedin.com/company/yourcompany">
                                        @error('linkedin_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="youtube_url" class="form-label">
                                            <i class="fab fa-youtube me-2 text-danger"></i>
                                            يوتيوب
                                        </label>
                                        <input type="url" 
                                               class="form-control" 
                                               id="youtube_url" 
                                               name="youtube_url" 
                                               value="{{ old('youtube_url', 'https://youtube.com/c/infinitywear') }}"
                                               placeholder="https://youtube.com/c/yourchannel">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="tiktok_url" class="form-label">
                                            <i class="fab fa-tiktok me-2 text-dark"></i>
                                            تيك توك
                                        </label>
                                        <input type="url" 
                                               class="form-control" 
                                               id="tiktok_url" 
                                               name="tiktok_url" 
                                               value="{{ old('tiktok_url') }}"
                                               placeholder="https://tiktok.com/@youraccount">
                                    </div>
                                </div>
                            </div>

                            <!-- إعدادات النظام -->
                            <div class="tab-pane fade" id="system" role="tabpanel">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-shield-alt me-2"></i>
                                            الأمان والحماية
                                        </h6>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="enable_registration" name="enable_registration" checked>
                                            <label class="form-check-label" for="enable_registration">
                                                السماح بالتسجيل الجديد
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="email_verification" name="email_verification" checked>
                                            <label class="form-check-label" for="email_verification">
                                                تفعيل البريد الإلكتروني مطلوب
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode">
                                            <label class="form-check-label" for="maintenance_mode">
                                                وضع الصيانة
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="debug_mode" name="debug_mode">
                                            <label class="form-check-label" for="debug_mode">
                                                وضع التطوير (Debug)
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <hr>
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-database me-2"></i>
                                            إعدادات قاعدة البيانات
                                        </h6>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="backup_frequency" class="form-label">
                                            <i class="fas fa-clock me-2 text-warning"></i>
                                            تكرار النسخ الاحتياطي
                                        </label>
                                        <select class="form-select" id="backup_frequency" name="backup_frequency">
                                            <option value="daily" selected>يومياً</option>
                                            <option value="weekly">أسبوعياً</option>
                                            <option value="monthly">شهرياً</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="log_level" class="form-label">
                                            <i class="fas fa-file-alt me-2 text-info"></i>
                                            مستوى السجلات
                                        </label>
                                        <select class="form-select" id="log_level" name="log_level">
                                            <option value="error">أخطاء فقط</option>
                                            <option value="warning" selected>تحذيرات وأخطاء</option>
                                            <option value="info">معلومات شاملة</option>
                                            <option value="debug">تفاصيل كاملة</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="session_timeout" class="form-label">
                                            <i class="fas fa-user-clock me-2 text-danger"></i>
                                            مهلة الجلسة (دقيقة)
                                        </label>
                                        <input type="number" 
                                               class="form-control" 
                                               id="session_timeout" 
                                               name="session_timeout" 
                                               value="120" 
                                               min="30" 
                                               max="1440">
                                    </div>
                                </div>
                            </div>

                            <!-- الصيانة -->
                            <div class="tab-pane fade" id="maintenance" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="maintenance-card">
                                            <div class="maintenance-icon">
                                                <i class="fas fa-broom text-warning"></i>
                                            </div>
                                            <h6>تنظيف الملفات المؤقتة</h6>
                                            <p class="text-muted">حذف الملفات المؤقتة وذاكرة التخزين المؤقت</p>
                                            <button type="button" class="btn btn-warning" onclick="clearCache()">
                                                <i class="fas fa-trash me-2"></i>
                                                تنظيف الآن
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="maintenance-card">
                                            <div class="maintenance-icon">
                                                <i class="fas fa-download text-success"></i>
                                            </div>
                                            <h6>نسخة احتياطية</h6>
                                            <p class="text-muted">إنشاء نسخة احتياطية من قاعدة البيانات</p>
                                            <button type="button" class="btn btn-success" onclick="createBackup()">
                                                <i class="fas fa-download me-2"></i>
                                                إنشاء نسخة
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="maintenance-card">
                                            <div class="maintenance-icon">
                                                <i class="fas fa-chart-line text-info"></i>
                                            </div>
                                            <h6>تحليل الأداء</h6>
                                            <p class="text-muted">فحص أداء النظام وسرعة الاستجابة</p>
                                            <button type="button" class="btn btn-info" onclick="analyzePerformance()">
                                                <i class="fas fa-play me-2"></i>
                                                بدء التحليل
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="maintenance-card">
                                            <div class="maintenance-icon">
                                                <i class="fas fa-sync text-primary"></i>
                                            </div>
                                            <h6>تحديث النظام</h6>
                                            <p class="text-muted">البحث عن تحديثات جديدة للنظام</p>
                                            <button type="button" class="btn btn-primary" onclick="checkUpdates()">
                                                <i class="fas fa-search me-2"></i>
                                                فحص التحديثات
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-info-circle fa-2x me-3"></i>
                                                <div>
                                                    <h6 class="alert-heading mb-1">معلومات النظام</h6>
                                                    <p class="mb-0">
                                                        إصدار PHP: {{ PHP_VERSION }} | 
                                                        إصدار Laravel: {{ app()->version() }} | 
                                                        مساحة القرص المتاحة: {{ round(disk_free_space('/') / 1024 / 1024 / 1024, 2) }} GB
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- أزرار الحفظ -->
                        <hr class="my-4">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                <i class="fas fa-undo me-2"></i>
                                إعادة تعيين
                            </button>
                            <div>
                                <button type="button" class="btn btn-outline-primary me-2" onclick="previewSettings()">
                                    <i class="fas fa-eye me-2"></i>
                                    معاينة
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    حفظ الإعدادات
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
        .nav-tabs .nav-link {
            border: none;
            color: #64748b;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
            background: none;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .maintenance-card {
            text-align: center;
            padding: 2rem;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .maintenance-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .maintenance-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .maintenance-card h6 {
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .maintenance-card p {
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function resetForm() {
            if (confirm('هل أنت متأكد من إعادة تعيين جميع الإعدادات؟')) {
                document.getElementById('settingsForm').reset();
            }
        }

        function previewSettings() {
            // معاينة الإعدادات قبل الحفظ
            const formData = new FormData(document.getElementById('settingsForm'));
            console.log('معاينة الإعدادات:', Object.fromEntries(formData));
            alert('سيتم فتح معاينة الإعدادات في نافذة جديدة');
        }

        function backupSettings() {
            if (confirm('هل تريد إنشاء نسخة احتياطية من الإعدادات الحالية؟')) {
                alert('تم إنشاء النسخة الاحتياطية بنجاح');
            }
        }

        function resetSettings() {
            if (confirm('هل أنت متأكد من استعادة الإعدادات الافتراضية؟ سيتم فقدان جميع التخصيصات الحالية!')) {
                alert('تم استعادة الإعدادات الافتراضية');
                location.reload();
            }
        }

        function clearCache() {
            if (confirm('هل تريد تنظيف جميع الملفات المؤقتة؟')) {
                alert('تم تنظيف الملفات المؤقتة بنجاح');
            }
        }

        function createBackup() {
            if (confirm('هل تريد إنشاء نسخة احتياطية جديدة؟')) {
                alert('جاري إنشاء النسخة الاحتياطية...');
            }
        }

        function analyzePerformance() {
            alert('جاري تحليل أداء النظام...');
        }

        function checkUpdates() {
            alert('جاري البحث عن التحديثات...');
        }

        // تنسيق رقم الهاتف
        document.querySelectorAll('input[type="tel"]').forEach(input => {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.startsWith('966')) {
                    value = value.substring(3);
                }
                if (value.startsWith('0')) {
                    value = value.substring(1);
                }
                
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
        });

        // التحقق من صحة الروابط
        document.querySelectorAll('input[type="url"]').forEach(input => {
            input.addEventListener('blur', function() {
                const url = this.value;
                if (url && !url.match(/^https?:\/\/.+/)) {
                    this.setCustomValidity('يرجى إدخال رابط صحيح يبدأ بـ http:// أو https://');
                } else {
                    this.setCustomValidity('');
                }
            });
        });
    </script>
@endpush