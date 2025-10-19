<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infinity Wear Notification</title>
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
        .notification-content {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #667eea;
            margin-bottom: 20px;
        }
        .notification-type {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 15px;
        }
        .type-general { background: #e3f2fd; color: #1976d2; }
        .type-system_alert { background: #fff3e0; color: #f57c00; }
        .type-test { background: #e8f5e8; color: #388e3c; }
        .type-warning { background: #fff3e0; color: #f57c00; }
        .type-error { background: #ffebee; color: #d32f2f; }
        .type-success { background: #e8f5e8; color: #388e3c; }
        .message-content {
            font-size: 16px;
            line-height: 1.8;
            white-space: pre-wrap;
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
            <h1>🔔 Infinity Wear Notification</h1>
            <p>System Notification</p>
        </div>

        <div class="notification-content">
            <div class="notification-type type-{{ $type }}">
                {{ ucfirst($type) }} Notification
            </div>
            <div class="message-content">{{ $message }}</div>
        </div>

        <div class="timestamp">
            <strong>📅 Sent:</strong> {{ now()->format('Y-m-d H:i:s') }} ({{ now()->timezoneName }})
        </div>

        <div class="footer">
            <p><strong>Infinity Wear</strong> - Official Email System</p>
            <p>This is an automated notification from infinitywear.sa</p>
        </div>
    </div>
</body>
</html>
