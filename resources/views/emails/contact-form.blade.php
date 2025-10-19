<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
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
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            text-align: center;
            margin: -30px -30px 30px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .field {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #667eea;
        }
        .field-label {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        .field-value {
            color: #333;
            font-size: 16px;
        }
        .message-field {
            background: #e3f2fd;
            border-left-color: #2196f3;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            text-align: center;
            color: #666;
        }
        .timestamp {
            background: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 رسالة تواصل جديدة</h1>
            <p>Infinity Wear - نموذج التواصل</p>
        </div>

        <div class="field">
            <div class="field-label">👤 الاسم:</div>
            <div class="field-value">{{ $data['name'] ?? 'غير محدد' }}</div>
        </div>

        <div class="field">
            <div class="field-label">📧 البريد الإلكتروني:</div>
            <div class="field-value">{{ $data['email'] ?? 'غير محدد' }}</div>
        </div>

        @if(isset($data['phone']))
        <div class="field">
            <div class="field-label">📞 رقم الهاتف:</div>
            <div class="field-value">{{ $data['phone'] }}</div>
        </div>
        @endif

        @if(isset($data['company']))
        <div class="field">
            <div class="field-label">🏢 الشركة:</div>
            <div class="field-value">{{ $data['company'] }}</div>
        </div>
        @endif

        @if(isset($data['subject']))
        <div class="field">
            <div class="field-label">📋 الموضوع:</div>
            <div class="field-value">{{ $data['subject'] }}</div>
        </div>
        @endif

        <div class="field message-field">
            <div class="field-label">💬 الرسالة:</div>
            <div class="field-value" style="white-space: pre-wrap;">{{ $data['message'] ?? 'غير محدد' }}</div>
        </div>

        <div class="timestamp">
            <strong>📅 وقت الاستلام:</strong> {{ now()->format('Y-m-d H:i:s') }} ({{ now()->timezoneName }})
        </div>

        <div class="footer">
            <p><strong>Infinity Wear</strong> - نظام البريد الإلكتروني الرسمي</p>
            <p>تم إرسال هذا البريد الإلكتروني تلقائياً من نموذج التواصل على infinitywear.sa</p>
        </div>
    </div>
</body>
</html>
