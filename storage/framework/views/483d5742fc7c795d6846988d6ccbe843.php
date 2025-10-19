<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار رسالة اتصال جديدة</title>
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
            border-bottom: 3px solid #17a2b8;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #17a2b8;
            margin: 0;
            font-size: 24px;
        }
        .contact-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .contact-info h3 {
            color: #17a2b8;
            margin-top: 0;
            display: flex;
            align-items: center;
        }
        .contact-info h3::before {
            content: "📧";
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
            background-color: #e3f2fd;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .message-content h3 {
            color: #1976d2;
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
            border-left: 4px solid #17a2b8;
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
            background-color: #17a2b8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #138496;
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
            <h1>إشعار رسالة اتصال جديدة</h1>
            <p>تم استلام رسالة جديدة من نموذج الاتصال</p>
        </div>

        <div class="priority">
            <strong>⚠️ تنبيه:</strong> يرجى الرد على رسالة العميل في أقرب وقت ممكن
        </div>

        <div class="contact-info">
            <h3>معلومات المرسل</h3>
            <div class="info-row">
                <span class="info-label">الاسم:</span>
                <span class="info-value"><?php echo e($contact->name ?? 'غير محدد'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">البريد الإلكتروني:</span>
                <span class="info-value"><?php echo e($contact->email ?? 'غير محدد'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">رقم الهاتف:</span>
                <span class="info-value"><?php echo e($contact->phone ?? 'غير محدد'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">اسم الشركة:</span>
                <span class="info-value"><?php echo e($contact->company ?? 'غير محدد'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">الموضوع:</span>
                <span class="info-value"><?php echo e($contact->subject ?? 'غير محدد'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">تاريخ الإرسال:</span>
                <span class="info-value"><?php echo e($contact->created_at ? $contact->created_at->format('Y-m-d H:i') : 'غير محدد'); ?></span>
            </div>
        </div>

        <div class="message-content">
            <h3>نص الرسالة</h3>
            <div class="message-text"><?php echo e($contact->message ?? 'لا يوجد نص للرسالة'); ?></div>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="<?php echo e(url('/admin/contacts/' . ($contact->id ?? ''))); ?>" class="btn">عرض تفاصيل الرسالة</a>
            <a href="<?php echo e(url('/admin/contacts')); ?>" class="btn">جميع الرسائل</a>
            <a href="mailto:<?php echo e($contact->email ?? ''); ?>" class="btn">الرد على العميل</a>
        </div>

        <div class="footer">
            <p>هذا إشعار تلقائي من نظام Infinity Wear</p>
            <p>يرجى عدم الرد على هذا البريد الإلكتروني</p>
            <p>© <?php echo e(date('Y')); ?> Infinity Wear - جميع الحقوق محفوظة</p>
        </div>
    </div>
</body>
</html><?php /**PATH F:\infinity\Infinity-Wear\resources\views\emails\contact-notification.blade.php ENDPATH**/ ?>