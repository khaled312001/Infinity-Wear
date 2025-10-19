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
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .subject {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        .content {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 30px;
        }
        .message {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
        .info {
            background-color: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        .timestamp {
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Infinity Wear</div>
            <div class="subject">{{ $subject }}</div>
        </div>

        <div class="content">
            <p>مرحباً،</p>
            
            <div class="info">
                <p><strong>هذا إيميل تجريبي</strong> للتأكد من عمل نظام البريد الإلكتروني في منصة Infinity Wear بشكل صحيح.</p>
            </div>

            <div class="message">
                <strong>الرسالة:</strong><br>
                {{ $message }}
            </div>

            <p>إذا وصل إليك هذا الإيميل، فهذا يعني أن:</p>
            <ul>
                <li class="success">✅ إعدادات البريد الإلكتروني تعمل بشكل صحيح</li>
                <li class="success">✅ الخادم يمكنه إرسال الإيميلات</li>
                <li class="success">✅ نظام الإشعارات جاهز للعمل</li>
                <li class="success">✅ جميع أنواع الإشعارات ستعمل بشكل طبيعي</li>
            </ul>

            <div class="info">
                <p><strong>تفاصيل الإرسال:</strong></p>
                <p>📧 من: {{ $company_email }}</p>
                <p>🏢 الشركة: {{ $company_name }}</p>
                <p>⏰ الوقت: {{ $timestamp }}</p>
            </div>
        </div>

        <div class="footer">
            <p><strong>{{ $company_name }}</strong></p>
            <p>البريد الإلكتروني: {{ $company_email }}</p>
            <p class="timestamp">تم إرسال هذا الإيميل تلقائياً من نظام Infinity Wear</p>
        </div>
    </div>
</body>
</html>
