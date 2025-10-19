<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار طلب جديد</title>
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
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        .order-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .order-info h3 {
            color: #28a745;
            margin-top: 0;
            display: flex;
            align-items: center;
        }
        .order-info h3::before {
            content: "🛒";
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
        .customer-info {
            background-color: #e3f2fd;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .customer-info h3 {
            color: #1976d2;
            margin-top: 0;
            display: flex;
            align-items: center;
        }
        .customer-info h3::before {
            content: "👤";
            margin-left: 10px;
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
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 5px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #0056b3;
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
            <h1>إشعار طلب جديد</h1>
            <p>تم استلام طلب جديد في نظام Infinity Wear</p>
        </div>

        <div class="priority">
            <strong>⚠️ تنبيه:</strong> يرجى مراجعة الطلب والرد على العميل في أقرب وقت ممكن
        </div>

        <div class="order-info">
            <h3>معلومات الطلب</h3>
            <div class="info-row">
                <span class="info-label">رقم الطلب:</span>
                <span class="info-value"><?php echo e($order->order_number ?? 'غير محدد'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">تاريخ الطلب:</span>
                <span class="info-value"><?php echo e($order->created_at ? $order->created_at->format('Y-m-d H:i') : 'غير محدد'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">المبلغ الإجمالي:</span>
                <span class="info-value"><?php echo e($order->total ?? 'غير محدد'); ?> ريال</span>
            </div>
            <div class="info-row">
                <span class="info-label">حالة الطلب:</span>
                <span class="info-value"><?php echo e($order->status ?? 'جديد'); ?></span>
            </div>
        </div>

        <div class="customer-info">
            <h3>معلومات العميل</h3>
            <div class="info-row">
                <span class="info-label">اسم العميل:</span>
                <span class="info-value"><?php echo e($order->customer_name ?? 'غير محدد'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">البريد الإلكتروني:</span>
                <span class="info-value"><?php echo e($order->customer_email ?? 'غير محدد'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">رقم الهاتف:</span>
                <span class="info-value"><?php echo e($order->customer_phone ?? 'غير محدد'); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">العنوان:</span>
                <span class="info-value"><?php echo e($order->customer_address ?? 'غير محدد'); ?></span>
            </div>
        </div>

        <?php if($order->notes): ?>
        <div class="order-info">
            <h3>ملاحظات إضافية</h3>
            <p><?php echo e($order->notes); ?></p>
        </div>
        <?php endif; ?>

        <div style="text-align: center; margin: 30px 0;">
            <a href="<?php echo e(url('/admin/orders/' . ($order->id ?? ''))); ?>" class="btn">عرض تفاصيل الطلب</a>
            <a href="<?php echo e(url('/admin/orders')); ?>" class="btn">جميع الطلبات</a>
        </div>

        <div class="footer">
            <p>هذا إشعار تلقائي من نظام Infinity Wear</p>
            <p>يرجى عدم الرد على هذا البريد الإلكتروني</p>
            <p>© <?php echo e(date('Y')); ?> Infinity Wear - جميع الحقوق محفوظة</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH F:\infinity\Infinity-Wear\resources\views\emails\order-notification.blade.php ENDPATH**/ ?>