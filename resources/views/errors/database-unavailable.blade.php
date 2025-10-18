<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>خدمة غير متاحة - Infinity Wear</title>
    <style>
        body {
            font-family: 'Cairo', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            margin: 20px;
        }
        .icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 28px;
        }
        p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .retry-btn {
            background: #667eea;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }
        .retry-btn:hover {
            background: #5a6fd8;
        }
        .info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            border-left: 4px solid #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">⚠️</div>
        <h1>خدمة غير متاحة مؤقتاً</h1>
        <p>
            نعتذر عن هذا الإزعاج. نحن نواجه مشكلة تقنية مؤقتة مع قاعدة البيانات.
            يرجى المحاولة مرة أخرى خلال بضع دقائق.
        </p>
        
        <a href="javascript:location.reload()" class="retry-btn">
            🔄 المحاولة مرة أخرى
        </a>
        
        <div class="info">
            <strong>معلومات إضافية:</strong><br>
            تم تجاوز حد الاتصالات بقاعدة البيانات (500 اتصال في الساعة).<br>
            سيتم حل هذه المشكلة تلقائياً خلال ساعة واحدة.
        </div>
    </div>
</body>
</html>
