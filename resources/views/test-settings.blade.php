<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار الإعدادات - {{ $siteSettings['name'] }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo.png') }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-5">
                    <i class="fas fa-cog text-primary me-3"></i>
                    اختبار الإعدادات
                </h1>
            </div>
        </div>

        <div class="row g-4">
            <!-- Site Information -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-globe me-2"></i>
                            معلومات الموقع
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><strong>اسم الموقع:</strong> {{ $siteSettings['name'] }}</p>
                        <p><strong>الشعار:</strong> {{ $siteSettings['tagline'] }}</p>
                        <p><strong>الوصف:</strong> {{ $siteSettings['description'] }}</p>
                        @if($siteSettings['logo'])
                            <p><strong>الشعار:</strong> <img src="{{ asset('storage/' . $siteSettings['logo']) }}" alt="Logo" style="max-height: 50px;"></p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-phone me-2"></i>
                            معلومات الاتصال
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><strong>البريد الإلكتروني:</strong> {{ $contactSettings['email'] }}</p>
                        <p><strong>الهاتف:</strong> {{ $contactSettings['phone'] }}</p>
                        @if($contactSettings['whatsapp'])
                            <p><strong>الواتساب:</strong> {{ $contactSettings['whatsapp'] }}</p>
                        @endif
                        <p><strong>العنوان:</strong> {{ $contactSettings['address'] }}</p>
                        @if($contactSettings['business_hours'])
                            <p><strong>ساعات العمل:</strong> {{ $contactSettings['business_hours'] }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-share-alt me-2"></i>
                            وسائل التواصل الاجتماعي
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($socialSettings['facebook'])
                            <p><i class="fab fa-facebook text-primary me-2"></i> <a href="{{ $socialSettings['facebook'] }}" target="_blank">فيسبوك</a></p>
                        @endif
                        @if($socialSettings['twitter'])
                            <p><i class="fab fa-twitter text-info me-2"></i> <a href="{{ $socialSettings['twitter'] }}" target="_blank">تويتر</a></p>
                        @endif
                        @if($socialSettings['instagram'])
                            <p><i class="fab fa-instagram text-danger me-2"></i> <a href="{{ $socialSettings['instagram'] }}" target="_blank">إنستغرام</a></p>
                        @endif
                        @if($socialSettings['linkedin'])
                            <p><i class="fab fa-linkedin text-primary me-2"></i> <a href="{{ $socialSettings['linkedin'] }}" target="_blank">لينكد إن</a></p>
                        @endif
                        @if($socialSettings['youtube'])
                            <p><i class="fab fa-youtube text-danger me-2"></i> <a href="{{ $socialSettings['youtube'] }}" target="_blank">يوتيوب</a></p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- System Settings -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-server me-2"></i>
                            إعدادات النظام
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><strong>اللغة الافتراضية:</strong> {{ $systemSettings['default_language'] }}</p>
                        <p><strong>العملة الافتراضية:</strong> {{ $systemSettings['default_currency'] }}</p>
                        <p><strong>المنطقة الزمنية:</strong> {{ $systemSettings['timezone'] }}</p>
                        <p><strong>التسجيل مسموح:</strong> 
                            @if($systemSettings['enable_registration'])
                                <span class="badge bg-success">نعم</span>
                            @else
                                <span class="badge bg-danger">لا</span>
                            @endif
                        </p>
                        <p><strong>وضع الصيانة:</strong> 
                            @if($systemSettings['maintenance_mode'])
                                <span class="badge bg-danger">مفعل</span>
                            @else
                                <span class="badge bg-success">معطل</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('admin.settings') }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>
                    تعديل الإعدادات
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-home me-2"></i>
                    العودة للرئيسية
                </a>
            </div>
        </div>
    </div>
</body>
</html>
