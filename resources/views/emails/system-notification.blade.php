<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار نظام</title>
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
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #6c757d;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #6c757d;
            margin: 0;
            font-size: 24px;
        }
        .notification-content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .notification-content h3 {
            color: #6c757d;
            margin-top: 0;
            display: flex;
            align-items: center;
        }
        .notification-content h3::before {
            content: "🔔";
            margin-left: 10px;
        }
        .message-text {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #6c757d;
            margin-top: 15px;
            white-space: pre-wrap;
        }
        .data-info {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .data-info h3 {
            color: #495057;
            margin-top: 0;
            display: flex;
            align-items: center;
        }
        .data-info h3::before {
            content: "📊";
            margin-left: 10px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
        }
        .info-value {
            color: #6c757d;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #5a6268;
        }
        .priority {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>إشعار نظام</h1>
            <p>إشعار مهم من نظام Infinity Wear</p>
        </div>

        <div class="priority">
            <strong>ℹ️ معلومة:</strong> يرجى مراجعة هذا الإشعار واتخاذ الإجراء المناسب
        </div>

        <div class="notification-content">
            <h3>تفاصيل الإشعار</h3>
            <div class="message-text">{{ $message ?? 'لا يوجد نص للإشعار' }}</div>
        </div>

        @if(!empty($data))
        <div class="data-info">
            <h3>معلومات إضافية</h3>
            @foreach($data as $key => $value)
            <div class="info-row">
                <span class="info-label">{{ $key }}:</span>
                <span class="info-value">{{ is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value }}</span>
            </div>
            @endforeach
        </div>
        @endif

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/admin/dashboard') }}" class="btn">لوحة التحكم</a>
            <a href="{{ url('/admin/notifications') }}" class="btn">جميع الإشعارات</a>
        </div>

        <div class="footer">
            <p>هذا إشعار تلقائي من نظام Infinity Wear</p>
            <p>يرجى عدم الرد على هذا البريد الإلكتروني</p>
            <p>© {{ date('Y') }} Infinity Wear - جميع الحقوق محفوظة</p>
        </div>
    </div>
</body>
</html>
