@extends('layouts.dashboard')

@section('title', 'التواصل معنا - لوحة تحكم المستورد')
@section('dashboard-title', 'لوحة المستورد')
@section('page-title', 'التواصل معنا')
@section('page-subtitle', 'تواصل معنا مباشرة لأي استفسار أو مساعدة')

@section('content')
<div class="container-fluid">
    <!-- معلومات التواصل -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-phone fa-2x text-primary"></i>
                    </div>
                    <h6 class="card-title">الهاتف</h6>
                    <p class="text-muted mb-2">{{ $contactInfo['phone'] }}</p>
                    <a href="tel:{{ $contactInfo['phone'] }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-phone me-1"></i>
                        اتصل بنا
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-envelope fa-2x text-success"></i>
                    </div>
                    <h6 class="card-title">البريد الإلكتروني</h6>
                    <p class="text-muted mb-2">{{ $contactInfo['email'] }}</p>
                    <a href="mailto:{{ $contactInfo['email'] }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-envelope me-1"></i>
                        راسلنا
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="contact-icon mb-3">
                        <i class="fab fa-whatsapp fa-2x text-success"></i>
                    </div>
                    <h6 class="card-title">واتساب</h6>
                    <p class="text-muted mb-2">{{ $contactInfo['whatsapp'] }}</p>
                    <a href="https://wa.me/{{ str_replace(['+', ' '], '', $contactInfo['whatsapp']) }}" 
                       target="_blank" class="btn btn-outline-success btn-sm">
                        <i class="fab fa-whatsapp me-1"></i>
                        واتساب
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="contact-icon mb-3">
                        <i class="fas fa-map-marker-alt fa-2x text-danger"></i>
                    </div>
                    <h6 class="card-title">العنوان</h6>
                    <p class="text-muted mb-2">{{ $contactInfo['address'] }}</p>
                    <button class="btn btn-outline-danger btn-sm" onclick="showMap()">
                        <i class="fas fa-map me-1"></i>
                        عرض الخريطة
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- نموذج التواصل -->
        <div class="col-lg-8 mb-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-paper-plane me-2"></i>
                        أرسل لنا رسالة
                    </h5>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('importers.contact.send') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="subject" class="form-label">الموضوع</label>
                                    <select class="form-select" id="subject" name="subject" required>
                                        <option value="">اختر الموضوع</option>
                                        <option value="استفسار عام">استفسار عام</option>
                                        <option value="مشكلة تقنية">مشكلة تقنية</option>
                                        <option value="استفسار عن الطلبات">استفسار عن الطلبات</option>
                                        <option value="استفسار عن الشحن">استفسار عن الشحن</option>
                                        <option value="استفسار عن الفواتير">استفسار عن الفواتير</option>
                                        <option value="اقتراح">اقتراح</option>
                                        <option value="شكوى">شكوى</option>
                                        <option value="أخرى">أخرى</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_method" class="form-label">طريقة التواصل المفضلة</label>
                                    <select class="form-select" id="contact_method" name="contact_method" required>
                                        <option value="">اختر الطريقة</option>
                                        <option value="email">البريد الإلكتروني</option>
                                        <option value="phone">الهاتف</option>
                                        <option value="whatsapp">واتساب</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">الرسالة</label>
                            <textarea class="form-control" id="message" name="message" rows="6" 
                                      placeholder="اكتب رسالتك هنا..." required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="preferred_time" class="form-label">الوقت المناسب للتواصل (اختياري)</label>
                            <input type="text" class="form-control" id="preferred_time" name="preferred_time" 
                                   placeholder="مثال: بعد الساعة 2:00 مساءً">
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>
                                إرسال الرسالة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- معلومات إضافية -->
        <div class="col-lg-4">
            <!-- ساعات العمل -->
            <div class="dashboard-card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock me-2"></i>
                        ساعات العمل
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="working-hours">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>الأحد - الخميس</span>
                            <span class="badge bg-success">مفتوح</span>
                        </div>
                        <p class="text-muted mb-3">{{ $contactInfo['working_hours'] }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>الجمعة - السبت</span>
                            <span class="badge bg-warning">مغلق</span>
                        </div>
                        <p class="text-muted mb-0">عطلة نهاية الأسبوع</p>
                    </div>
                </div>
            </div>
            
            <!-- أوقات الاستجابة -->
            <div class="dashboard-card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-stopwatch me-2"></i>
                        أوقات الاستجابة
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="response-times">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>البريد الإلكتروني</span>
                                <span class="badge bg-info">24 ساعة</span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>الهاتف</span>
                                <span class="badge bg-success">فوري</span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>واتساب</span>
                                <span class="badge bg-success">2-4 ساعات</span>
                            </div>
                        </div>
                        
                        <div class="mb-0">
                            <div class="d-flex justify-content-between">
                                <span>تذاكر الدعم</span>
                                <span class="badge bg-warning">24-48 ساعة</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- جهات الاتصال الطارئة -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        جهات الاتصال الطارئة
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="emergency-contact">
                        <p class="text-muted mb-2">للمساعدة العاجلة خارج ساعات العمل:</p>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-phone text-danger me-2"></i>
                            <a href="tel:{{ $contactInfo['emergency_contact'] }}" class="text-decoration-none">
                                {{ $contactInfo['emergency_contact'] }}
                            </a>
                        </div>
                        <small class="text-muted">متاح 24/7 للمساعدة الطارئة</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- خريطة الموقع -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-map me-2"></i>
                        موقعنا على الخريطة
                    </h5>
                </div>
                
                <div class="card-body">
                    <div id="map" style="height: 400px; border-radius: 8px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                        <div class="text-center">
                            <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">خريطة الموقع</h6>
                            <p class="text-muted">{{ $contactInfo['address'] }}</p>
                            <button class="btn btn-primary" onclick="openGoogleMaps()">
                                <i class="fas fa-external-link-alt me-1"></i>
                                فتح في خرائط جوجل
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الأسئلة الشائعة -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-question-circle me-2"></i>
                        أسئلة شائعة
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="faq-item mb-3">
                                <h6 class="text-primary">كيف يمكنني التواصل معكم؟</h6>
                                <p class="text-muted small">يمكنك التواصل معنا عبر الهاتف، البريد الإلكتروني، واتساب، أو من خلال نموذج التواصل أعلاه.</p>
                            </div>
                            
                            <div class="faq-item mb-3">
                                <h6 class="text-primary">ما هي ساعات العمل؟</h6>
                                <p class="text-muted small">نعمل من الأحد إلى الخميس من 8:00 صباحاً إلى 6:00 مساءً. للطوارئ، يمكنك الاتصال بالرقم المخصص.</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="faq-item mb-3">
                                <h6 class="text-primary">كم يستغرق الرد على رسالتي؟</h6>
                                <p class="text-muted small">نرد على البريد الإلكتروني خلال 24 ساعة، والهاتف فورياً خلال ساعات العمل، وواتساب خلال 2-4 ساعات.</p>
                            </div>
                            
                            <div class="faq-item mb-3">
                                <h6 class="text-primary">هل يمكنني زيارة المكتب؟</h6>
                                <p class="text-muted small">نعم، يمكنك زيارة مكتبنا في الرياض. يرجى تحديد موعد مسبقاً لضمان توفر فريق العمل.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.contact-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.working-hours .badge {
    font-size: 0.75em;
}

.response-times .badge {
    font-size: 0.75em;
}

.faq-item h6 {
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

#map {
    border: 2px dashed #dee2e6;
}

.dashboard-card .card-body {
    padding: 1.5rem;
}
</style>

<script>
function showMap() {
    // محاكاة عرض الخريطة
    alert('سيتم فتح الخريطة في نافذة جديدة');
    openGoogleMaps();
}

function openGoogleMaps() {
    const address = encodeURIComponent('{{ $contactInfo["address"] }}');
    const url = `https://www.google.com/maps/search/?api=1&query=${address}`;
    window.open(url, '_blank');
}

// تحديث حالة ساعات العمل
function updateWorkingHours() {
    const now = new Date();
    const hour = now.getHours();
    const day = now.getDay(); // 0 = الأحد, 6 = السبت
    
    const isWorkingDay = day >= 0 && day <= 4; // الأحد إلى الخميس
    const isWorkingHour = hour >= 8 && hour < 18;
    
    const statusBadges = document.querySelectorAll('.working-hours .badge');
    
    if (isWorkingDay && isWorkingHour) {
        statusBadges[0].textContent = 'مفتوح الآن';
        statusBadges[0].className = 'badge bg-success';
    } else if (isWorkingDay) {
        statusBadges[0].textContent = 'مغلق الآن';
        statusBadges[0].className = 'badge bg-danger';
    } else {
        statusBadges[0].textContent = 'عطلة';
        statusBadges[0].className = 'badge bg-warning';
    }
}

// تحديث حالة ساعات العمل عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    updateWorkingHours();
    
    // تحديث كل دقيقة
    setInterval(updateWorkingHours, 60000);
});

// تحسين تجربة المستخدم للنموذج
document.getElementById('subject').addEventListener('change', function() {
    const messageTextarea = document.getElementById('message');
    const subject = this.value;
    
    if (subject) {
        messageTextarea.placeholder = `اكتب تفاصيل ${subject.toLowerCase()} هنا...`;
    } else {
        messageTextarea.placeholder = 'اكتب رسالتك هنا...';
    }
});

// تحسين تجربة المستخدم لطريقة التواصل
document.getElementById('contact_method').addEventListener('change', function() {
    const preferredTimeInput = document.getElementById('preferred_time');
    const method = this.value;
    
    switch(method) {
        case 'phone':
            preferredTimeInput.placeholder = 'مثال: بعد الساعة 2:00 مساءً';
            break;
        case 'whatsapp':
            preferredTimeInput.placeholder = 'مثال: في أي وقت مناسب';
            break;
        case 'email':
            preferredTimeInput.placeholder = 'مثال: خلال ساعات العمل';
            break;
        default:
            preferredTimeInput.placeholder = 'مثال: بعد الساعة 2:00 مساءً';
    }
});
</script>
@endsection
