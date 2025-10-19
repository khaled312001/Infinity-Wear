<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التقرير اليومي - <?php echo e($reportData['date_arabic']); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
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
        .date {
            font-size: 20px;
            color: #666;
            margin-bottom: 20px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .summary-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .summary-card h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .summary-card .number {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
        }
        .section {
            margin-bottom: 40px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }
        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .section-title i {
            margin-left: 10px;
            font-size: 24px;
        }
        .stats-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding: 10px;
            background: white;
            border-radius: 5px;
        }
        .stats-row .label {
            font-weight: bold;
            color: #555;
        }
        .stats-row .value {
            color: #007bff;
            font-weight: bold;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        .table th {
            background: #007bff;
            color: white;
            padding: 12px;
            text-align: right;
        }
        .table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-pending { background: #ffc107; color: #000; }
        .status-completed { background: #28a745; color: white; }
        .status-cancelled { background: #dc3545; color: white; }
        .status-processing { background: #17a2b8; color: white; }
        .priority-high { background: #dc3545; color: white; }
        .priority-medium { background: #ffc107; color: #000; }
        .priority-low { background: #28a745; color: white; }
        .footer {
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
        .highlight {
            background: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #ffc107;
            margin: 15px 0;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
        }
        .alert-info {
            background: #d1ecf1;
            border-left: 4px solid #17a2b8;
            color: #0c5460;
        }
        .alert-warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            color: #856404;
        }
        .alert-success {
            background: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Infinity Wear</div>
            <div class="date">التقرير اليومي - <?php echo e($reportData['date_arabic']); ?></div>
        </div>

        <!-- ملخص عام -->
        <div class="section">
            <h2 class="section-title">
                <i>📊</i>
                ملخص عام للأنشطة
            </h2>
            
            <div class="summary-grid">
                <div class="summary-card">
                    <h3>الطلبات</h3>
                    <p class="number"><?php echo e($reportData['summary']['total_orders']); ?></p>
                </div>
                <div class="summary-card">
                    <h3>رسائل الاتصال</h3>
                    <p class="number"><?php echo e($reportData['summary']['total_contacts']); ?></p>
                </div>
                <div class="summary-card">
                    <h3>رسائل الواتساب</h3>
                    <p class="number"><?php echo e($reportData['summary']['total_whatsapp']); ?></p>
                </div>
                <div class="summary-card">
                    <h3>طلبات المستوردين</h3>
                    <p class="number"><?php echo e($reportData['summary']['total_importer_orders']); ?></p>
                </div>
                <div class="summary-card">
                    <h3>المهام</h3>
                    <p class="number"><?php echo e($reportData['summary']['total_tasks']); ?></p>
                </div>
                <div class="summary-card">
                    <h3>التقارير التسويقية</h3>
                    <p class="number"><?php echo e($reportData['summary']['total_marketing_reports']); ?></p>
                </div>
                <div class="summary-card">
                    <h3>تقارير المبيعات</h3>
                    <p class="number"><?php echo e($reportData['summary']['total_sales_reports']); ?></p>
                </div>
                <div class="summary-card">
                    <h3>الإشعارات</h3>
                    <p class="number"><?php echo e($reportData['summary']['total_notifications']); ?></p>
                </div>
            </div>
        </div>

        <!-- الطلبات -->
        <?php if($reportData['orders']['count'] > 0): ?>
        <div class="section">
            <h2 class="section-title">
                <i>🛒</i>
                الطلبات (<?php echo e($reportData['orders']['count']); ?>)
            </h2>
            
            <div class="stats-row">
                <span class="label">إجمالي المبلغ:</span>
                <span class="value"><?php echo e(number_format($reportData['orders']['total_amount'], 2)); ?> ريال</span>
            </div>
            <div class="stats-row">
                <span class="label">متوسط قيمة الطلب:</span>
                <span class="value"><?php echo e(number_format($reportData['orders']['average_amount'], 2)); ?> ريال</span>
            </div>
            
            <?php if(count($reportData['orders']['recent_orders']) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>اسم العميل</th>
                        <th>المبلغ</th>
                        <th>الحالة</th>
                        <th>الوقت</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $reportData['orders']['recent_orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>#<?php echo e($order['id']); ?></td>
                        <td><?php echo e($order['customer_name']); ?></td>
                        <td><?php echo e(number_format($order['total'], 2)); ?> ريال</td>
                        <td><span class="status-badge status-<?php echo e($order['status']); ?>"><?php echo e($order['status']); ?></span></td>
                        <td><?php echo e($order['created_at']); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- رسائل الاتصال -->
        <?php if($reportData['contacts']['count'] > 0): ?>
        <div class="section">
            <h2 class="section-title">
                <i>📧</i>
                رسائل الاتصال (<?php echo e($reportData['contacts']['count']); ?>)
            </h2>
            
            <?php if(count($reportData['contacts']['recent_contacts']) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>الموضوع</th>
                        <th>الحالة</th>
                        <th>الوقت</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $reportData['contacts']['recent_contacts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($contact['name']); ?></td>
                        <td><?php echo e($contact['email']); ?></td>
                        <td><?php echo e($contact['subject']); ?></td>
                        <td><span class="status-badge status-<?php echo e($contact['status']); ?>"><?php echo e($contact['status']); ?></span></td>
                        <td><?php echo e($contact['created_at']); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- رسائل الواتساب -->
        <?php if($reportData['whatsapp']['count'] > 0): ?>
        <div class="section">
            <h2 class="section-title">
                <i>💬</i>
                رسائل الواتساب (<?php echo e($reportData['whatsapp']['count']); ?>)
            </h2>
            
            <?php if(count($reportData['whatsapp']['recent_messages']) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>اسم المرسل</th>
                        <th>رقم الهاتف</th>
                        <th>الرسالة</th>
                        <th>الحالة</th>
                        <th>الوقت</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $reportData['whatsapp']['recent_messages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($message['sender_name']); ?></td>
                        <td><?php echo e($message['from_number']); ?></td>
                        <td><?php echo e($message['message_content']); ?></td>
                        <td><span class="status-badge status-<?php echo e($message['status']); ?>"><?php echo e($message['status']); ?></span></td>
                        <td><?php echo e($message['created_at']); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- المهام -->
        <?php if($reportData['tasks']['count'] > 0): ?>
        <div class="section">
            <h2 class="section-title">
                <i>✅</i>
                المهام (<?php echo e($reportData['tasks']['count']); ?>)
            </h2>
            
            <?php if(count($reportData['tasks']['recent_tasks']) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>عنوان المهمة</th>
                        <th>الأولوية</th>
                        <th>الحالة</th>
                        <th>المكلف</th>
                        <th>الوقت</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $reportData['tasks']['recent_tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($task['title']); ?></td>
                        <td><span class="status-badge priority-<?php echo e($task['priority']); ?>"><?php echo e($task['priority']); ?></span></td>
                        <td><span class="status-badge status-<?php echo e($task['status']); ?>"><?php echo e($task['status']); ?></span></td>
                        <td><?php echo e($task['assigned_to']); ?></td>
                        <td><?php echo e($task['created_at']); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- إحصائيات إضافية -->
        <div class="section">
            <h2 class="section-title">
                <i>📈</i>
                إحصائيات إضافية
            </h2>
            
            <div class="stats-row">
                <span class="label">إجمالي الأنشطة:</span>
                <span class="value"><?php echo e($reportData['statistics']['total_activities']); ?></span>
            </div>
            <div class="stats-row">
                <span class="label">الساعة الأكثر نشاطاً:</span>
                <span class="value"><?php echo e($reportData['statistics']['most_active_hour']); ?></span>
            </div>
            <div class="stats-row">
                <span class="label">المهام عالية الأولوية:</span>
                <span class="value"><?php echo e($reportData['statistics']['top_priority_tasks']); ?></span>
            </div>
        </div>

        <!-- العناصر المعلقة -->
        <div class="section">
            <h2 class="section-title">
                <i>⏳</i>
                العناصر المعلقة
            </h2>
            
            <div class="alert alert-warning">
                <strong>تنبيه:</strong> يرجى مراجعة العناصر التالية التي تحتاج إلى متابعة:
            </div>
            
            <div class="stats-row">
                <span class="label">الطلبات المعلقة:</span>
                <span class="value"><?php echo e($reportData['statistics']['pending_items']['pending_orders']); ?></span>
            </div>
            <div class="stats-row">
                <span class="label">رسائل الاتصال المعلقة:</span>
                <span class="value"><?php echo e($reportData['statistics']['pending_items']['pending_contacts']); ?></span>
            </div>
            <div class="stats-row">
                <span class="label">المهام المعلقة:</span>
                <span class="value"><?php echo e($reportData['statistics']['pending_items']['pending_tasks']); ?></span>
            </div>
            <div class="stats-row">
                <span class="label">الإشعارات غير المقروءة:</span>
                <span class="value"><?php echo e($reportData['statistics']['pending_items']['unread_notifications']); ?></span>
            </div>
        </div>

        <div class="footer">
            <p><strong><?php echo e($company_name); ?></strong></p>
            <p>البريد الإلكتروني: <?php echo e($company_email); ?></p>
            <p class="timestamp">تم إنشاء هذا التقرير تلقائياً في <?php echo e($generated_at); ?></p>
        </div>
    </div>
</body>
</html>
<?php /**PATH F:\infinity\Infinity-Wear\resources\views/emails/daily-report.blade.php ENDPATH**/ ?>