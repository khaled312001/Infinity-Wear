<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رسالة جديدة من موقع Infinity Wear</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .contact-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .contact-info h3 {
            color: #667eea;
            margin-top: 0;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
            color: #555;
        }
        .info-value {
            flex: 1;
        }
        .message-content {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .message-content h3 {
            color: #667eea;
            margin-top: 0;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 5px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>رسالة جديدة من موقع Infinity Wear</h1>
            <p>تم استلام رسالة جديدة من أحد زوار الموقع</p>
        </div>
        
        <div class="content">
            <div class="contact-info">
                <h3>معلومات المرسل</h3>
                <div class="info-row">
                    <span class="info-label">الاسم:</span>
                    <span class="info-value">{{ $contact->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">البريد الإلكتروني:</span>
                    <span class="info-value">{{ $contact->email }}</span>
                </div>
                @if($contact->phone)
                <div class="info-row">
                    <span class="info-label">رقم الهاتف:</span>
                    <span class="info-value">{{ $contact->phone }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">الموضوع:</span>
                    <span class="info-value">{{ $contact->subject }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">التاريخ:</span>
                    <span class="info-value">{{ $contact->created_at->format('Y-m-d H:i') }}</span>
                </div>
            </div>
            
            <div class="message-content">
                <h3>نص الرسالة</h3>
                <p style="white-space: pre-wrap;">{{ $contact->message }}</p>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('admin.contacts.index') }}" class="btn">عرض في لوحة الإدارة</a>
            </div>
        </div>
        
        <div class="footer">
            <p>هذه رسالة تلقائية من نظام Infinity Wear</p>
            <p>يرجى عدم الرد على هذا البريد الإلكتروني</p>
        </div>
    </div>
</body>
</html>
