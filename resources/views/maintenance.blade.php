<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الموقع تحت الصيانة - {{ \App\Helpers\SettingsHelper::get('site_name', 'Infinity Wear') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo.png') }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .maintenance-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            max-width: 600px;
            width: 90%;
        }
        
        .maintenance-icon {
            font-size: 5rem;
            color: #667eea;
            margin-bottom: 2rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .maintenance-title {
            color: #2d3748;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .maintenance-message {
            color: #4a5568;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .contact-info {
            background: #f7fafc;
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 2rem;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
            color: #4a5568;
        }
        
        .contact-item i {
            margin-left: 0.5rem;
            color: #667eea;
        }
        
        .progress-bar {
            background: #e2e8f0;
            border-radius: 10px;
            height: 8px;
            margin: 2rem 0;
            overflow: hidden;
        }
        
        .progress-fill {
            background: linear-gradient(90deg, #667eea, #764ba2);
            height: 100%;
            width: 75%;
            border-radius: 10px;
            animation: progress 3s ease-in-out infinite;
        }
        
        @keyframes progress {
            0% { width: 0%; }
            50% { width: 75%; }
            100% { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">
            <i class="fas fa-tools"></i>
        </div>
        
        <h1 class="maintenance-title">الموقع تحت الصيانة</h1>
        
        <p class="maintenance-message">
            نعمل حالياً على تحسين الموقع وتطويره لخدمتكم بشكل أفضل.<br>
            سنعود قريباً بخدمات محسنة ومميزات جديدة.
        </p>
        
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>
        
        <div class="contact-info">
            <h5 class="mb-3">
                <i class="fas fa-phone me-2"></i>
                للاستفسارات الطارئة
            </h5>
            
            @php
                $contactInfo = \App\Helpers\SettingsHelper::getContactInfo();
            @endphp
            
            @if($contactInfo['phone'])
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>{{ $contactInfo['phone'] }}</span>
                </div>
            @endif
            
            @if($contactInfo['whatsapp'])
                <div class="contact-item">
                    <i class="fab fa-whatsapp"></i>
                    <span>{{ $contactInfo['whatsapp'] }}</span>
                </div>
            @endif
            
            @if($contactInfo['email'])
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>{{ $contactInfo['email'] }}</span>
                </div>
            @endif
        </div>
        
        <div class="mt-4">
            <small class="text-muted">
                <i class="fas fa-clock me-1"></i>
                آخر تحديث: {{ now()->format('Y-m-d H:i') }}
            </small>
        </div>
    </div>
    
    <script>
        // Auto refresh every 30 seconds to check if maintenance is over
        setTimeout(() => {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
