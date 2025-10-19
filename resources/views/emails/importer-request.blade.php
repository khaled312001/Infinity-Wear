<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Importer Request - Infinity Wear</title>
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
        .business-info {
            background: #fff3e0;
            border-left-color: #ff9800;
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
        .urgent {
            background: #ffebee;
            border-left-color: #f44336;
            border: 2px solid #f44336;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏢 New Importer Request</h1>
            <p>Infinity Wear - Importer Registration</p>
        </div>

        <div class="field">
            <div class="field-label">👤 Full Name:</div>
            <div class="field-value">{{ $data['name'] ?? 'N/A' }}</div>
        </div>

        <div class="field">
            <div class="field-label">📧 Email:</div>
            <div class="field-value">{{ $data['email'] ?? 'N/A' }}</div>
        </div>

        @if(isset($data['phone']))
        <div class="field">
            <div class="field-label">📞 Phone:</div>
            <div class="field-value">{{ $data['phone'] }}</div>
        </div>
        @endif

        @if(isset($data['company']))
        <div class="field business-info">
            <div class="field-label">🏢 Company Name:</div>
            <div class="field-value">{{ $data['company'] }}</div>
        </div>
        @endif

        @if(isset($data['business_type']))
        <div class="field business-info">
            <div class="field-label">🏪 Business Type:</div>
            <div class="field-value">{{ $data['business_type'] }}</div>
        </div>
        @endif

        @if(isset($data['country']))
        <div class="field">
            <div class="field-label">🌍 Country:</div>
            <div class="field-value">{{ $data['country'] }}</div>
        </div>
        @endif

        @if(isset($data['city']))
        <div class="field">
            <div class="field-label">🏙️ City:</div>
            <div class="field-value">{{ $data['city'] }}</div>
        </div>
        @endif

        @if(isset($data['experience']))
        <div class="field">
            <div class="field-label">💼 Experience Level:</div>
            <div class="field-value">{{ $data['experience'] }}</div>
        </div>
        @endif

        @if(isset($data['expected_volume']))
        <div class="field business-info">
            <div class="field-label">📦 Expected Monthly Volume:</div>
            <div class="field-value">{{ $data['expected_volume'] }}</div>
        </div>
        @endif

        @if(isset($data['message']))
        <div class="field message-field">
            <div class="field-label">💬 Additional Message:</div>
            <div class="field-value" style="white-space: pre-wrap;">{{ $data['message'] }}</div>
        </div>
        @endif

        @if(isset($data['urgent']) && $data['urgent'])
        <div class="field urgent">
            <div class="field-label">⚠️ URGENT REQUEST</div>
            <div class="field-value">This importer has marked their request as urgent and requires immediate attention.</div>
        </div>
        @endif

        <div class="timestamp">
            <strong>📅 Received:</strong> {{ now()->format('Y-m-d H:i:s') }} ({{ now()->timezoneName }})
        </div>

        <div class="footer">
            <p><strong>Infinity Wear</strong> - Official Email System</p>
            <p>This email was sent automatically from the importer registration form on infinitywear.sa</p>
        </div>
    </div>
</body>
</html>
