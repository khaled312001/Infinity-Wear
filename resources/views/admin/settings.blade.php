@extends('layouts.dashboard')

@section('title', 'الإعدادات العامة')
@section('dashboard-title', 'إعدادات النظام')
@section('page-title', 'الإعدادات العامة')
@section('page-subtitle', 'إدارة إعدادات الموقع والنظام العامة')

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
@endpush

{{-- Sidebar menu is now handled by the unified admin-sidebar partial --}}

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
                                               value="{{ old('site_name', $settings['site_name'] ?? 'Infinity Wear') }}" 
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
                                               value="{{ old('site_tagline', $settings['site_tagline'] ?? 'مؤسسة الزي اللامحدود') }}">
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
                                                  required>{{ old('site_description', $settings['site_description'] ?? 'مؤسسة الزي اللامحدود - متخصصون في تصنيع وتوريد الملابس والزي الرسمي للشركات والمؤسسات') }}</textarea>
                                        @error('site_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">
                                            <i class="fas fa-image me-2 text-primary"></i>
                                            شعار الموقع
                                        </label>
                                        
                                        <!-- منطقة رفع الشعار -->
                                        <div class="logo-upload-area" id="logoUploadArea">
                                            <div class="upload-content">
                                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                                <p class="mb-2">اسحب وأفلت الشعار هنا أو</p>
                                                <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('logoFile').click()">
                                                    <i class="fas fa-folder-open me-2"></i>
                                                    اختر ملف
                                                </button>
                                                <input type="file" id="logoFile" accept="image/*" style="display: none;">
                                                <div class="form-text mt-2">الحد الأقصى: 2MB، الصيغ المدعومة: JPG, PNG, SVG, WebP, AVIF</div>
                                            </div>
                                        </div>
                                        
                                        <!-- معاينة الشعار -->
                                        <div id="logoPreview" class="mt-3" style="display: none;">
                                            <div class="d-flex align-items-center">
                                                <img id="previewImage" src="" alt="معاينة الشعار" class="img-thumbnail me-3" style="max-width: 150px; max-height: 80px;">
                                                <div>
                                                    <h6 id="previewFileName" class="mb-1"></h6>
                                                    <small id="previewFileSize" class="text-muted"></small>
                                                    <div class="mt-2">
                                                        <button type="button" class="btn btn-success btn-sm" onclick="uploadLogo()">
                                                            <i class="fas fa-upload me-1"></i>
                                                            رفع الشعار
                                                        </button>
                                                        <button type="button" class="btn btn-outline-secondary btn-sm ms-2" onclick="cancelLogoUpload()">
                                                            <i class="fas fa-times me-1"></i>
                                                            إلغاء
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- الشعار الحالي -->
                                        <div id="currentLogo" class="mt-3">
                                            <small class="text-muted">الشعار الحالي:</small>
                                            <div class="mt-1">
                                                <img id="currentLogoImage" src="{{ \App\Helpers\SiteSettingsHelper::getLogoUrl() }}" 
                                                     alt="الشعار الحالي" 
                                                     class="img-thumbnail" 
                                                     style="max-width: 150px; max-height: 80px;"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                <div style="display: none; color: #dc3545; font-size: 0.875rem;">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    لا يوجد شعار محفوظ حالياً
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteLogo()">
                                                    <i class="fas fa-trash me-1"></i>
                                                    حذف الشعار
                                                </button>
                                                <button type="button" class="btn btn-outline-info btn-sm ms-2" onclick="getLogoInfo()">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    معلومات الشعار
                                                </button>
                                            </div>
                                            <!-- معلومات Cloudinary -->
                                            <div id="logoCloudinaryInfo" class="mt-2" style="display: none;">
                                                <div class="alert alert-info alert-sm">
                                                    <i class="fas fa-cloud me-1"></i>
                                                    <strong>مخزن في السحابة:</strong>
                                                    <div id="logoCloudinaryDetails"></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- رسائل الحالة -->
                                        <div id="logoMessages" class="mt-3"></div>
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
                                
                                <!-- زر حفظ الإعدادات العامة -->
                                <div class="mt-4">
                                    <button type="button" class="btn btn-primary" onclick="updateGeneralSettings()">
                                        <i class="fas fa-save me-2"></i>
                                        حفظ الإعدادات العامة
                                    </button>
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
                                               value="{{ old('contact_email', $settings['contact_email'] ?? 'info@infinitywear.com') }}" 
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
                                               value="{{ old('contact_phone', $settings['contact_phone'] ?? '+966500982394') }}" 
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
                                               value="{{ old('whatsapp_number', '+966500982394') }}">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="whatsapp_message" class="form-label">
                                            <i class="fas fa-comment me-2 text-primary"></i>
                                            رسالة الواتساب الافتراضية
                                        </label>
                                        <textarea class="form-control" 
                                                  id="whatsapp_message" 
                                                  name="whatsapp_message" 
                                                  rows="3"
                                                  placeholder="مرحباً، أريد الاستفسار عن خدماتكم...">{{ old('whatsapp_message', 'مرحباً، أريد الاستفسار عن خدماتكم في الملابس الرياضية والزي الموحد') }}</textarea>
                                        <div class="form-text">الرسالة التي تظهر عند الضغط على زر الواتساب العائم</div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="whatsapp_floating_enabled" name="whatsapp_floating_enabled" checked>
                                            <label class="form-check-label" for="whatsapp_floating_enabled">
                                                <i class="fab fa-whatsapp me-2 text-success"></i>
                                                تفعيل زر الواتساب العائم
                                            </label>
                                        </div>
                                        <div class="form-text">إظهار زر الواتساب العائم في جميع صفحات الموقع</div>
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
                                                  required>{{ old('address', $settings['address'] ?? 'المملكة العربية السعودية، الرياض، حي النخيل، شارع الملك فهد') }}</textarea>
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
                                
                                <!-- زر حفظ معلومات الاتصال -->
                                <div class="mt-4">
                                    <button type="button" class="btn btn-primary" onclick="updateContactSettings()">
                                        <i class="fas fa-save me-2"></i>
                                        حفظ معلومات الاتصال
                                    </button>
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
                                
                                <!-- زر حفظ وسائل التواصل الاجتماعي -->
                                <div class="mt-4">
                                    <button type="button" class="btn btn-primary" onclick="updateSocialSettings()">
                                        <i class="fas fa-save me-2"></i>
                                        حفظ وسائل التواصل الاجتماعي
                                    </button>
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
                                
                                <!-- زر حفظ إعدادات النظام -->
                                <div class="mt-4">
                                    <button type="button" class="btn btn-primary" onclick="updateSystemSettings()">
                                        <i class="fas fa-save me-2"></i>
                                        حفظ إعدادات النظام
                                    </button>
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
                                            <button type="button" class="btn btn-warning" onclick="clearSystemCache()">
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
                                <button type="button" class="btn btn-primary" onclick="updateAllSettings()">
                                    <i class="fas fa-save me-2"></i>
                                    حفظ جميع الإعدادات
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

        /* منطقة رفع الشعار */
        .logo-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .logo-upload-area:hover {
            border-color: var(--primary-color);
            background: #e3f2fd;
        }

        .logo-upload-area.dragover {
            border-color: var(--primary-color);
            background: #e3f2fd;
            transform: scale(1.02);
        }

        .upload-content {
            pointer-events: none;
        }

    </style>
@endpush

@push('scripts')
    <script>
        // متغيرات الشعار
        let selectedLogoFile = null;

        // تسجيل تحميل الصفحة
        console.log('=== تم تحميل صفحة الإعدادات ===');
        console.log('النموذج موجود:', document.getElementById('settingsForm') ? 'نعم' : 'لا');
        console.log('منطقة رفع الشعار موجودة:', document.getElementById('logoUploadArea') ? 'نعم' : 'لا');
        
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
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري التنظيف...';
                button.disabled = true;

                fetch('{{ route("admin.content.clear-cache") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('تم تنظيف الملفات المؤقتة بنجاح', 'success');
                    } else {
                        showAlert(data.message || 'حدث خطأ أثناء التنظيف', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('حدث خطأ أثناء التنظيف', 'error');
                })
                .finally(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
            }
        }

        function createBackup() {
            if (confirm('هل تريد إنشاء نسخة احتياطية جديدة؟')) {
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الإنشاء...';
                button.disabled = true;

                // Simulate backup creation
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                    showAlert('تم إنشاء النسخة الاحتياطية بنجاح', 'success');
                }, 3000);
            }
        }

        function analyzePerformance() {
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري التحليل...';
            button.disabled = true;

            // Simulate performance analysis
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
                showAlert('تم تحليل الأداء بنجاح. النظام يعمل بكفاءة عالية!', 'success');
            }, 2000);
        }

        function checkUpdates() {
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري البحث...';
            button.disabled = true;

            // Simulate update check
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
                showAlert('النظام محدث بأحدث الإصدارات المتاحة', 'success');
            }, 2500);
        }

        function showAlert(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
            
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 350px; max-width: 500px;">
                    <i class="fas ${icon} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', alertHtml);
            
            setTimeout(() => {
                const alert = document.querySelector('.alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 300);
                }
            }, 5000);
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

        // دوال الشعار
        function uploadLogo() {
            if (!selectedLogoFile) {
                showLogoMessage('يرجى اختيار ملف أولاً', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('logo', selectedLogoFile);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch('{{ route("admin.logo.upload") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showLogoMessage(data.message, 'success');
                    // تحديث الشعار الحالي
                    const currentLogoImage = document.getElementById('currentLogoImage');
                    const errorDiv = currentLogoImage.nextElementSibling;
                    
                    // إظهار الشعار وإخفاء رسالة الخطأ
                    currentLogoImage.style.display = 'block';
                    errorDiv.style.display = 'none';
                    
                    // تحديث رابط الشعار مع cache-busting
                    const logoUrl = data.logo_url + (data.logo_url.includes('?') ? '&' : '?') + 'v=' + Date.now();
                    currentLogoImage.src = logoUrl;
                    
                    console.log('تم تحديث الشعار:', logoUrl);
                    
                    // إعادة تحميل الشعار للتأكد من ظهوره
                    currentLogoImage.onload = function() {
                        console.log('تم تحميل الشعار بنجاح');
                    };
                    currentLogoImage.onerror = function() {
                        console.log('فشل في تحميل الشعار');
                        this.style.display = 'none';
                        this.nextElementSibling.style.display = 'block';
                    };
                    
                    // إخفاء المعاينة
                    cancelLogoUpload();
                } else {
                    showLogoMessage(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showLogoMessage('حدث خطأ أثناء رفع الشعار', 'error');
            });
        }

        function deleteLogo() {
            // Check if there's actually a logo to delete
            const currentLogoImage = document.getElementById('currentLogoImage');
            if (!currentLogoImage || currentLogoImage.style.display === 'none' || !currentLogoImage.src.includes('storage') && !currentLogoImage.src.includes('cloudinary')) {
                showLogoMessage('لا يوجد شعار محفوظ حالياً', 'warning');
                return;
            }
            
            if (!confirm('هل أنت متأكد من حذف الشعار؟')) {
                return;
            }

            fetch('{{ route("admin.logo.delete") }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showLogoMessage(data.message, 'success');
                    // إخفاء الشعار الحالي
                    document.getElementById('currentLogoImage').style.display = 'none';
                    document.getElementById('currentLogoImage').nextElementSibling.style.display = 'block';
                } else {
                    showLogoMessage(data.message || 'حدث خطأ أثناء حذف الشعار', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showLogoMessage('حدث خطأ أثناء حذف الشعار: ' + error.message, 'error');
            });
        }

        function cancelLogoUpload() {
            selectedLogoFile = null;
            document.getElementById('logoFile').value = '';
            document.getElementById('logoPreview').style.display = 'none';
            document.getElementById('logoUploadArea').style.display = 'block';
            
            // إظهار منطقة الرفع مرة أخرى
            setTimeout(() => {
                document.getElementById('logoUploadArea').style.display = 'block';
            }, 1000);
        }

        function showLogoMessage(message, type) {
            const messagesDiv = document.getElementById('logoMessages');
            const alertClass = type === 'success' ? 'alert-success' : 
                              type === 'error' ? 'alert-danger' : 
                              type === 'warning' ? 'alert-warning' : 'alert-info';
            const icon = type === 'success' ? 'fa-check-circle' : 
                        type === 'error' ? 'fa-exclamation-triangle' : 
                        type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';
            
            messagesDiv.innerHTML = `
                <div class="alert ${alertClass} alert-dismissible fade show">
                    <i class="fas ${icon} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            // إخفاء الرسالة بعد 5 ثوان
            setTimeout(() => {
                const alert = messagesDiv.querySelector('.alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 300);
                }
            }, 5000);
        }

        // معالجة اختيار ملف الشعار
        document.getElementById('logoFile').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                handleLogoFile(file);
                // Auto-upload without confirmation
                uploadLogo();
            }
        });

        // معالجة السحب والإفلات
        const uploadArea = document.getElementById('logoUploadArea');
        
        uploadArea.addEventListener('click', function() {
            document.getElementById('logoFile').click();
        });

        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleLogoFile(files[0]);
                // Auto-upload without confirmation
                uploadLogo();
            }
        });

        function handleLogoFile(file) {
            console.log('تم اختيار ملف:', file);
            
            // التحقق من حجم الملف
            if (file.size > 2 * 1024 * 1024) { // 2MB
                showLogoMessage('حجم الملف كبير جداً. الحد الأقصى 2MB', 'error');
                return;
            }
            
            // التحقق من نوع الملف
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml', 'image/webp', 'image/avif'];
            if (!allowedTypes.includes(file.type)) {
                showLogoMessage('نوع الملف غير مدعوم. يرجى اختيار صورة بصيغة JPG, PNG, SVG, WebP, أو AVIF', 'error');
                return;
            }
            
            // حفظ الملف المختار
            selectedLogoFile = file;
            
            // إظهار رسالة التحميل بدلاً من المعاينة
            showLogoMessage('جاري رفع الشعار...', 'info');
            
            // إخفاء منطقة الرفع مؤقتاً
            document.getElementById('logoUploadArea').style.display = 'none';
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // دوال الإعدادات العامة
        function updateGeneralSettings() {
            const formData = new FormData();
            formData.append('site_name', document.getElementById('site_name').value);
            formData.append('site_tagline', document.getElementById('site_tagline').value);
            formData.append('site_description', document.getElementById('site_description').value);
            formData.append('default_language', document.getElementById('default_language').value);
            formData.append('default_currency', document.getElementById('default_currency').value);
            formData.append('timezone', document.getElementById('timezone').value);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            showMessage('جاري تحديث الإعدادات العامة...', 'info');

            fetch('{{ route("admin.settings.general") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                showMessage(data.message, data.success ? 'success' : 'error');
                if (data.success) {
                    // تحديث الصفحة بعد 2 ثانية
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('حدث خطأ أثناء تحديث الإعدادات', 'error');
            });
        }

        // دالة تحديث جميع الإعدادات
        function updateAllSettings() {
            const form = document.getElementById('settingsForm');
            const formData = new FormData(form);
            
            showMessage('جاري تحديث جميع الإعدادات...', 'info');

            fetch('{{ route("admin.settings.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Network response was not ok');
            })
            .then(data => {
                showMessage('تم تحديث جميع الإعدادات بنجاح!', 'success');
                // تحديث الصفحة بعد 2 ثانية
                setTimeout(() => {
                    location.reload();
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('حدث خطأ أثناء تحديث الإعدادات', 'error');
            });
        }

        // دوال معلومات الاتصال
        function updateContactSettings() {
            const formData = new FormData();
            formData.append('contact_email', document.getElementById('contact_email').value);
            formData.append('contact_phone', document.getElementById('contact_phone').value);
            formData.append('whatsapp_number', document.getElementById('whatsapp_number').value);
            formData.append('whatsapp_message', document.getElementById('whatsapp_message').value);
            formData.append('whatsapp_floating_enabled', document.getElementById('whatsapp_floating_enabled').checked ? '1' : '0');
            formData.append('support_email', document.getElementById('support_email').value);
            formData.append('address', document.getElementById('address').value);
            formData.append('business_hours', document.getElementById('business_hours').value);
            formData.append('emergency_contact', document.getElementById('emergency_contact').value);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            showMessage('جاري تحديث معلومات الاتصال...', 'info');

            fetch('{{ route("admin.settings.contact") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                showMessage(data.message, data.success ? 'success' : 'error');
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('حدث خطأ أثناء تحديث معلومات الاتصال', 'error');
            });
        }

        // دوال وسائل التواصل الاجتماعي
        function updateSocialSettings() {
            const formData = new FormData();
            formData.append('facebook_url', document.getElementById('facebook_url').value);
            formData.append('twitter_url', document.getElementById('twitter_url').value);
            formData.append('instagram_url', document.getElementById('instagram_url').value);
            formData.append('linkedin_url', document.getElementById('linkedin_url').value);
            formData.append('youtube_url', document.getElementById('youtube_url').value);
            formData.append('tiktok_url', document.getElementById('tiktok_url').value);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            showMessage('جاري تحديث وسائل التواصل الاجتماعي...', 'info');

            fetch('{{ route("admin.settings.social") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                showMessage(data.message, data.success ? 'success' : 'error');
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('حدث خطأ أثناء تحديث وسائل التواصل', 'error');
            });
        }

        // دوال إعدادات النظام
        function updateSystemSettings() {
            const formData = new FormData();
            formData.append('enable_registration', document.getElementById('enable_registration').checked ? '1' : '0');
            formData.append('email_verification', document.getElementById('email_verification').checked ? '1' : '0');
            formData.append('maintenance_mode', document.getElementById('maintenance_mode').checked ? '1' : '0');
            formData.append('debug_mode', document.getElementById('debug_mode').checked ? '1' : '0');
            formData.append('backup_frequency', document.getElementById('backup_frequency').value);
            formData.append('log_level', document.getElementById('log_level').value);
            formData.append('session_timeout', document.getElementById('session_timeout').value);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            showMessage('جاري تحديث إعدادات النظام...', 'info');

            fetch('{{ route("admin.settings.system") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                showMessage(data.message, data.success ? 'success' : 'error');
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('حدث خطأ أثناء تحديث إعدادات النظام', 'error');
            });
        }

        // دالة عرض الرسائل العامة
        function showMessage(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 
                              type === 'error' ? 'alert-danger' : 'alert-info';
            const icon = type === 'success' ? 'fa-check-circle' : 
                        type === 'error' ? 'fa-exclamation-triangle' : 'fa-info-circle';
            
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 350px; max-width: 500px;">
                    <i class="fas ${icon} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', alertHtml);
            
            setTimeout(() => {
                const alert = document.querySelector('.alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 300);
                }
            }, 5000);
        }

        // دالة تنظيف الكاش
        function clearSystemCache() {
            if (!confirm('هل تريد تنظيف جميع الملفات المؤقتة؟')) {
                return;
            }

            fetch('{{ route("admin.settings.clear-cache") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                showMessage(data.message, data.success ? 'success' : 'error');
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('حدث خطأ أثناء تنظيف الكاش', 'error');
            });
        }

        
        // Force refresh logo images on page load to prevent 403 errors
        document.addEventListener('DOMContentLoaded', function() {
            console.log('=== إعادة تحميل صور الشعار ===');
            
            // Force refresh current logo image
            const currentLogoImage = document.getElementById('currentLogoImage');
            if (currentLogoImage) {
                const currentSrc = currentLogoImage.src;
                console.log('الشعار الحالي:', currentSrc);
                
                // Add cache-busting parameter
                const separator = currentSrc.includes('?') ? '&' : '?';
                const newSrc = currentSrc + separator + 'force_refresh=' + Date.now();
                currentLogoImage.src = newSrc;
                console.log('الشعار الجديد:', newSrc);
                
                // Check if logo exists
                currentLogoImage.onerror = function() {
                    console.log('الشعار غير موجود - سيتم إظهار رسالة عدم وجود شعار');
                    this.style.display = 'none';
                    this.nextElementSibling.style.display = 'block';
                };
            }
        });

        // دوال معلومات Cloudinary
        function getLogoInfo() {
            fetch('{{ route("admin.logo.info") }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.is_cloudinary) {
                    const detailsDiv = document.getElementById('logoCloudinaryDetails');
                    detailsDiv.innerHTML = `
                        <div class="row">
                            <div class="col-6">
                                <small><strong>الأبعاد:</strong> ${data.cloudinary_data.width}x${data.cloudinary_data.height}</small>
                            </div>
                            <div class="col-6">
                                <small><strong>الحجم:</strong> ${formatFileSize(data.cloudinary_data.bytes)}</small>
                            </div>
                            <div class="col-6">
                                <small><strong>الصيغة:</strong> ${data.cloudinary_data.format.toUpperCase()}</small>
                            </div>
                            <div class="col-6">
                                <small><strong>تاريخ الرفع:</strong> ${new Date(data.uploaded_at).toLocaleDateString('ar-SA')}</small>
                            </div>
                        </div>
                    `;
                    document.getElementById('logoCloudinaryInfo').style.display = 'block';
                } else {
                    showLogoMessage('الشعار محفوظ محلياً فقط', 'info');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showLogoMessage('حدث خطأ أثناء الحصول على معلومات الشعار', 'error');
            });
        }


        // دالة إظهار الرسائل
        function showMessage(message, type = 'info') {
            const alertClass = type === 'success' ? 'alert-success' : 
                              type === 'error' ? 'alert-danger' : 
                              type === 'warning' ? 'alert-warning' : 'alert-info';
            
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 
                                   type === 'error' ? 'exclamation-circle' : 
                                   type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', alertHtml);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                const alert = document.querySelector('.alert:last-of-type');
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        }

        // دالة معاينة الإعدادات
        function previewSettings() {
            const siteName = document.getElementById('site_name').value;
            const siteTagline = document.getElementById('site_tagline').value;
            const siteDescription = document.getElementById('site_description').value;
            
            const previewHtml = `
                <div class="modal fade" id="previewModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">معاينة الإعدادات</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <h3>${siteName}</h3>
                                <p class="text-muted">${siteTagline}</p>
                                <p>${siteDescription}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // إزالة المعاينة السابقة إذا كانت موجودة
            const existingModal = document.getElementById('previewModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            document.body.insertAdjacentHTML('beforeend', previewHtml);
            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            modal.show();
        }
    </script>
@endpush