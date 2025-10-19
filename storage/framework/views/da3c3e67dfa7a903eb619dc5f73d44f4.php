<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار رسالة واتساب جديدة</title>
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
            border-bottom: 3px solid #25d366;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #25d366;
            margin: 0;
            font-size: 24px;
        }
        .whatsapp-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .whatsapp-info h3 {
            color: #25d366;
            margin-top: 0;
            display: flex;
            align-items: center;
        }
        .whatsapp-info h3::before {
            content: "📱";
            margin-left: 10px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
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
        .message-content {
            background-color: #dcf8c6;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .message-content h3 {
            color: #25d366;
            margin-top: 0;
            display: flex;
            align-items: center;
        }
        .message-content h3::before {
            content: "💬";
            margin-left: 10px;
        }
        .message-text {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #25d366;
            margin-top: 15px;
            white-space: pre-wrap;
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
            background-color: #25d366;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #1da851;
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
        .whatsapp-link {
            background-color: #25d366;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin: 10px 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>إشعار رسالة واتساب جديدة</h1>
            <p>تم استلام رسالة جديدة عبر الواتساب</p>
        </div>

        <div class="priority">
            <strong>⚠️ تنبيه:</strong> يرجى الرد على رسالة العميل عبر الواتساب في أقرب وقت ممكن
        </div>

        <div class="whatsapp-info">
            <h3>معلومات المرسل</h3>
            <div class="info-row">
                <span class="info-label">رقم الهاتف:</span>
                <span class="info-value"><?php echo e($whatsappMessage->from_number ?? 'غير محدد'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">اسم المرسل:</span>
                <span class="info-value"><?php echo e($whatsappMessage->contact_name ?? 'غير محدد'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">تاريخ الإرسال:</span>
                <span class="info-value"><?php echo e($whatsappMessage->created_at ? $whatsappMessage->created_at->format('Y-m-d H:i') : 'غير محدد'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">نوع الرسالة:</span>
                <span class="info-value"><?php echo e($whatsappMessage->message_type ?? 'نص'); ?></span>
            </div>
        </div>

        <div class="message-content">
            <h3>نص الرسالة</h3>
            <div class="message-text"><?php echo e($whatsappMessage->message ?? 'لا يوجد نص للرسالة'); ?></div>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="<?php echo e(url('/admin/whatsapp')); ?>" class="btn">عرض جميع الرسائل</a>
            <a href="https://wa.me/<?php echo e(str_replace(['+', ' ', '-'], '', $whatsappMessage->from_number ?? '')); ?>" 
               class="whatsapp-link" target="_blank">الرد عبر الواتساب</a>
        </div>

        <div class="footer">
            <p>هذا إشعار تلقائي من نظام Infinity Wear</p>
            <p>يرجى عدم الرد على هذا البريد الإلكتروني</p>
            <p>© <?php echo e(date('Y')); ?> Infinity Wear - جميع الحقوق محفوظة</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH F:\infinity\Infinity-Wear\resources\views\emails\whatsapp-notification.blade.php ENDPATH**/ ?>