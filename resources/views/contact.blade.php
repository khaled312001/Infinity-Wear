@extends('layouts.app')

@section('title', 'تواصل معنا - Infinity Wear')
@section('description', 'تواصل معنا في إنفينيتي وير للحصول على أفضل الخدمات في مجال الملابس الرياضية والزي الموحد')

@section('styles')
<link href="{{ asset('css/infinity-home.css') }}" rel="stylesheet">
<link href="{{ asset('css/contact-page.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="contact-page-wrapper">
    <!-- Hero Section -->
    <section class="contact-hero-section">
        <div class="container">
            <div class="contact-hero-content">
                <h1 class="contact-hero-title">تواصل معنا</h1>
                <p class="contact-hero-subtitle">نحن هنا لمساعدتك في تحقيق رؤيتك وتقديم أفضل الخدمات في مجال الملابس الرياضية والزي الموحد</p>
                <div class="contact-hero-stats">
                    <div class="contact-stat-item">
                        <i class="fas fa-clock contact-stat-icon"></i>
                        <span class="contact-stat-text">استجابة خلال 24 ساعة</span>
                    </div>
                    <div class="contact-stat-item">
                        <i class="fas fa-users contact-stat-icon"></i>
                        <span class="contact-stat-text">فريق متخصص</span>
                    </div>
                    <div class="contact-stat-item">
                        <i class="fas fa-award contact-stat-icon"></i>
                        <span class="contact-stat-text">جودة مضمونة</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form & Map Section -->
    <section class="contact-main-section">
        <div class="contact-layout-container">
            <!-- Contact Form -->
            <div class="contact-form-section">
                <div class="contact-form-header">
                    <h2 class="contact-form-title">أرسل لنا رسالة</h2>
                    <p class="contact-form-subtitle">سنرد عليك في أقرب وقت ممكن</p>
                    
                    <!-- Push Notifications Toggle -->
                    <div class="push-notifications-toggle" style="margin-top: 15px; padding: 10px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e9ecef;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-bell" style="color: #007bff;"></i>
                                <span style="font-size: 14px; color: #495057;">تفعيل الإشعارات للرد السريع</span>
                            </div>
                            <button type="button" id="enableNotifications" class="btn btn-sm btn-outline-primary" style="font-size: 12px;">
                                <i class="fas fa-bell"></i> تفعيل
                            </button>
                        </div>
                        <div id="notificationStatus" style="margin-top: 8px; font-size: 12px; color: #6c757d; display: none;">
                            <i class="fas fa-check-circle" style="color: #28a745;"></i>
                            <span>الإشعارات مفعلة - ستتلقى إشعار عند الرد</span>
                        </div>
                    </div>
                </div>
                
                @if(session('success'))
                    <div class="contact-alert contact-alert-success">
                        <i class="fas fa-check-circle contact-alert-icon"></i>
                        <div class="contact-alert-content">
                            <h6>تم إرسال رسالتك بنجاح!</h6>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="contact-alert contact-alert-danger">
                        <i class="fas fa-exclamation-triangle contact-alert-icon"></i>
                        <div class="contact-alert-content">
                            <h6>يرجى تصحيح الأخطاء التالية:</h6>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="contact-form" id="contactForm">
                    @csrf
                    <div class="contact-form-row">
                        <div class="contact-form-group">
                            <label for="name" class="contact-form-label">
                                <i class="fas fa-user"></i>
                                الاسم الكامل
                            </label>
                            <input type="text" id="name" name="name" class="contact-form-input @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="contact-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="contact-form-group">
                            <label for="email" class="contact-form-label">
                                <i class="fas fa-envelope"></i>
                                البريد الإلكتروني
                            </label>
                            <input type="email" id="email" name="email" class="contact-form-input @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <div class="contact-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="contact-form-row">
                        <div class="contact-form-group">
                            <label for="phone" class="contact-form-label">
                                <i class="fas fa-phone"></i>
                                رقم الهاتف
                            </label>
                            <input type="tel" id="phone" name="phone" class="contact-form-input @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <div class="contact-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="contact-form-group">
                            <label for="subject" class="contact-form-label">
                                <i class="fas fa-tag"></i>
                                موضوع الرسالة
                            </label>
                            <select id="subject" name="subject" class="contact-form-input @error('subject') is-invalid @enderror" required>
                                <option value="">اختر موضوع الرسالة</option>
                                <option value="استفسار عام" {{ old('subject') == 'استفسار عام' ? 'selected' : '' }}>استفسار عام</option>
                                <option value="طلب عرض سعر" {{ old('subject') == 'طلب عرض سعر' ? 'selected' : '' }}>طلب عرض سعر</option>
                                <option value="دعم فني" {{ old('subject') == 'دعم فني' ? 'selected' : '' }}>دعم فني</option>
                                <option value="شكوى" {{ old('subject') == 'شكوى' ? 'selected' : '' }}>شكوى</option>
                                <option value="اقتراح" {{ old('subject') == 'اقتراح' ? 'selected' : '' }}>اقتراح</option>
                                <option value="أخرى" {{ old('subject') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                            </select>
                            @error('subject')
                                <div class="contact-invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="contact-form-group">
                        <label for="message" class="contact-form-label">
                            <i class="fas fa-comment"></i>
                            الرسالة
                        </label>
                        <textarea id="message" name="message" rows="6" class="contact-form-input contact-form-textarea @error('message') is-invalid @enderror" 
                                  placeholder="اكتب رسالتك هنا..." required>{{ old('message') }}</textarea>
                        <div class="contact-char-counter">
                            <span id="charCount">0</span>/1000
                        </div>
                        @error('message')
                            <div class="contact-invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="contact-submit-section">
                        <button type="submit" class="contact-submit-btn">
                            <span class="contact-btn-text">
                                <i class="fas fa-paper-plane"></i>
                                إرسال الرسالة
                            </span>
                            <span class="contact-btn-loading">
                                <i class="fas fa-spinner fa-spin"></i>
                                جاري الإرسال...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Map & Contact Info -->
            <div class="contact-info-section">
                <!-- Interactive Map -->
                <div class="contact-map-container">
                    <div class="contact-map-header">
                        <h3 class="contact-map-title">موقعنا</h3>
                        <p class="contact-map-subtitle">{{ \App\Models\Setting::get('address', 'الرياض، المملكة العربية السعودية') }}</p>
                    </div>
                    <div class="contact-map-wrapper">
                        <div class="contact-map-placeholder">
                            <i class="fas fa-map-marker-alt"></i>
                            <h4>موقعنا على الخريطة</h4>
                            <p>{{ \App\Models\Setting::get('address', 'شارع الملك فهد، حي النخيل، الرياض') }}</p>
                            <button class="contact-btn contact-btn-primary">
                                <i class="fas fa-directions"></i>
                                احصل على الاتجاهات
                            </button>
                        </div>
                        <div class="contact-map-overlay">
                            <div class="contact-map-info">
                                <h4>العنوان</h4>
                                <p>{{ \App\Models\Setting::get('address', 'شارع الملك فهد، حي النخيل، الرياض، المملكة العربية السعودية') }}</p>
                                <button class="contact-btn contact-btn-primary">
                                    <i class="fas fa-external-link-alt"></i>
                                    فتح في خرائط جوجل
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Information -->
                <div class="contact-cards-grid">
                    <div class="contact-info-card">
                        <div class="contact-card-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-card-content">
                            <h4 class="contact-card-title">اتصل بنا</h4>
                            <div class="contact-card-links">
                                <a href="tel:{{ \App\Models\Setting::get('contact_phone') }}" class="contact-card-link">{{ \App\Models\Setting::get('contact_phone') }}</a>
                                @if(\App\Models\Setting::get('emergency_contact'))
                                    <a href="tel:{{ \App\Models\Setting::get('emergency_contact') }}" class="contact-card-link">{{ \App\Models\Setting::get('emergency_contact') }}</a>
                                @endif
                            </div>
                            <p class="contact-card-description">{{ \App\Models\Setting::get('business_hours', 'متاح من 8 صباحاً إلى 6 مساءً') }}</p>
                        </div>
                    </div>
                    
                    <div class="contact-info-card">
                        <div class="contact-card-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-card-content">
                            <h4 class="contact-card-title">راسلنا</h4>
                            <div class="contact-card-links">
                                <a href="mailto:{{ \App\Models\Setting::get('contact_email') }}" class="contact-card-link">{{ \App\Models\Setting::get('contact_email') }}</a>
                                @if(\App\Models\Setting::get('support_email'))
                                    <a href="mailto:{{ \App\Models\Setting::get('support_email') }}" class="contact-card-link">{{ \App\Models\Setting::get('support_email') }}</a>
                                @endif
                            </div>
                            <p class="contact-card-description">نرد خلال 24 ساعة</p>
                        </div>
                    </div>
                    
                    <div class="contact-info-card">
                        <div class="contact-card-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="contact-card-content">
                            <h4 class="contact-card-title">واتساب</h4>
                            <div class="contact-card-links">
                                <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', \App\Models\Setting::get('whatsapp_number')) }}" target="_blank" class="contact-card-link">{{ \App\Models\Setting::get('whatsapp_number') }}</a>
                            </div>
                            <p class="contact-card-description">تواصل مباشر وسريع</p>
                        </div>
                    </div>
                    
                    <div class="contact-info-card">
                        <div class="contact-card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-card-content">
                            <h4 class="contact-card-title">ساعات العمل</h4>
                            <div class="contact-working-hours">
                                <div class="contact-hour-item">
                                    <span class="contact-hour-day">{{ \App\Models\Setting::get('business_hours', 'الأحد - الخميس: 8:00 ص - 6:00 م') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="contact-features-section">
        <div class="contact-features-container">
            <div class="contact-section-header">
                <h2 class="contact-section-title">لماذا تختارنا؟</h2>
                <p class="contact-section-subtitle">نقدم أفضل الخدمات والحلول المخصصة لاحتياجاتك</p>
            </div>
            <div class="contact-features-grid">
                <div class="contact-feature-card">
                    <div class="contact-feature-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h4 class="contact-feature-title">سرعة في التنفيذ</h4>
                    <p class="contact-feature-description">نقدم خدماتنا بسرعة وكفاءة عالية لضمان إنجاز مشروعك في الوقت المحدد</p>
                </div>
                <div class="contact-feature-card">
                    <div class="contact-feature-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h4 class="contact-feature-title">تصاميم مخصصة</h4>
                    <p class="contact-feature-description">نصمم حلولاً مخصصة تناسب احتياجاتك وتجسد رؤيتك بشكل مثالي</p>
                </div>
                <div class="contact-feature-card">
                    <div class="contact-feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4 class="contact-feature-title">دعم مستمر</h4>
                    <p class="contact-feature-description">نوفر دعم فني مستمر وخدمة عملاء متميزة لضمان رضاك التام</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="contact-faq-section">
        <div class="contact-faq-container">
            <div class="contact-section-header">
                <h2 class="contact-section-title">الأسئلة الشائعة</h2>
                <p class="contact-section-subtitle">إجابات على أكثر الأسئلة شيوعاً</p>
            </div>
            <div class="contact-faq-container">
                <div class="contact-faq-item">
                    <div class="contact-faq-question">
                        <h4>كم يستغرق تنفيذ المشروع؟</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="contact-faq-answer">
                        <p>مدة التنفيذ تعتمد على حجم وتعقيد المشروع. عادة ما يستغرق المشروع البسيط من أسبوع إلى أسبوعين، بينما المشاريع المعقدة قد تحتاج من شهر إلى شهرين.</p>
                    </div>
                </div>
                
                <div class="contact-faq-item">
                    <div class="contact-faq-question">
                        <h4>هل تقدمون ضمان على الخدمات؟</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="contact-faq-answer">
                        <p>نعم، نقدم ضمان شامل على جميع خدماتنا لمدة 6 أشهر من تاريخ التسليم، مع دعم فني مجاني خلال فترة الضمان.</p>
                    </div>
                </div>
                
                <div class="contact-faq-item">
                    <div class="contact-faq-question">
                        <h4>ما هي طرق الدفع المتاحة؟</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="contact-faq-answer">
                        <p>نقبل جميع طرق الدفع المتاحة في المملكة العربية السعودية، بما في ذلك التحويل البنكي، الدفع الإلكتروني، والدفع عند التسليم.</p>
                    </div>
                </div>
                
                <div class="contact-faq-item">
                    <div class="contact-faq-question">
                        <h4>هل يمكنني طلب تعديلات على التصميم؟</h4>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="contact-faq-answer">
                        <p>بالطبع، نسمح بثلاث مراجعات مجانية للتصميم قبل الموافقة النهائية. أي تعديلات إضافية بعد ذلك ستكون برسوم رمزية.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/infinity-home.js') }}"></script>
<script src="{{ asset('js/contact-page.js') }}"></script>

<script>
// Push Notifications for Contact Page
document.addEventListener('DOMContentLoaded', function() {
    const enableButton = document.getElementById('enableNotifications');
    const statusDiv = document.getElementById('notificationStatus');
    
    if (enableButton && window.pushNotificationManager) {
        // Check current subscription status
        window.pushNotificationManager.getSubscriptionStatus().then(function(status) {
            if (status.isSubscribed) {
                enableButton.innerHTML = '<i class="fas fa-bell-slash"></i> إلغاء';
                enableButton.className = 'btn btn-sm btn-outline-danger';
                statusDiv.style.display = 'block';
            } else if (status.permission === 'denied') {
                enableButton.innerHTML = '<i class="fas fa-exclamation-triangle"></i> مرفوض';
                enableButton.className = 'btn btn-sm btn-outline-warning';
                enableButton.disabled = true;
            }
        });
        
        // Handle button click
        enableButton.addEventListener('click', async function() {
            if (this.innerHTML.includes('إلغاء')) {
                // Unsubscribe
                const success = await window.pushNotificationManager.unsubscribe();
                if (success) {
                    this.innerHTML = '<i class="fas fa-bell"></i> تفعيل';
                    this.className = 'btn btn-sm btn-outline-primary';
                    statusDiv.style.display = 'none';
                }
            } else {
                // Subscribe
                const success = await window.pushNotificationManager.subscribe('admin');
                if (success) {
                    this.innerHTML = '<i class="fas fa-bell-slash"></i> إلغاء';
                    this.className = 'btn btn-sm btn-outline-danger';
                    statusDiv.style.display = 'block';
                }
            }
        });
    }
});
</script>
@endsection
