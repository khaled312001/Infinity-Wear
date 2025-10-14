<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }
        
        .header .subtitle {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        .message-content {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 30px;
            color: #34495e;
        }
        
        .message-content p {
            margin-bottom: 15px;
        }
        
        .cta-section {
            text-align: center;
            margin: 30px 0;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
        }
        
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        
        .footer h3 {
            margin: 0 0 15px 0;
            font-size: 20px;
        }
        
        .footer p {
            margin: 5px 0;
            font-size: 14px;
            opacity: 0.8;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: white;
            text-decoration: none;
            font-size: 18px;
        }
        
        .divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #667eea, transparent);
            margin: 30px 0;
        }
        
        .unsubscribe {
            font-size: 12px;
            color: #7f8c8d;
            text-align: center;
            margin-top: 20px;
        }
        
        .unsubscribe a {
            color: #7f8c8d;
            text-decoration: none;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                box-shadow: none;
            }
            
            .header, .content, .footer {
                padding: 20px 15px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .content {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Infinity Wear</h1>
            <p class="subtitle">الملابس الأنيقة للجميع</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">
                مرحباً {{ $recipient->name }}،
            </div>
            
            <div class="message-content">
                {!! nl2br(e($content)) !!}
            </div>
            
            <div class="divider"></div>
            
            <div class="cta-section">
                <a href="{{ route('home') }}" class="cta-button">
                    زيارة موقعنا
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <h3>تواصل معنا</h3>
            <p>📧 info@infinitywear.sa</p>
            <p>📞 +966 XX XXX XXXX</p>
            <p>🌐 www.infinitywear.sa</p>
            
            <div class="social-links">
                <a href="#" title="فيسبوك">📘</a>
                <a href="#" title="تويتر">🐦</a>
                <a href="#" title="إنستغرام">📷</a>
                <a href="#" title="لينكد إن">💼</a>
            </div>
            
            <p>نشكرك لثقتك في Infinity Wear</p>
        </div>
        
        <!-- Unsubscribe -->
        <div class="unsubscribe">
            <p>
                إذا كنت لا ترغب في تلقي هذه الرسائل، يمكنك 
                <a href="#">إلغاء الاشتراك</a>
            </p>
        </div>
    </div>
</body>
</html>



