<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
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
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .message {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
            margin: 20px 0;
            font-size: 16px;
            line-height: 1.8;
        }
        .email-content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            margin: 20px 0;
            font-size: 15px;
            line-height: 1.7;
        }
        .priority {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .priority-urgent {
            background-color: #dc3545;
            color: white;
        }
        .priority-high {
            background-color: #fd7e14;
            color: white;
        }
        .priority-normal {
            background-color: #007bff;
            color: white;
        }
        .priority-low {
            background-color: #28a745;
            color: white;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            margin: 20px 0;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .category {
            background-color: #e9ecef;
            color: #495057;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            display: inline-block;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><?php echo e($title); ?></h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                مرحباً <?php echo e($user->name); ?> 👋
            </div>
            
            <?php if($notification->category): ?>
                <div class="category"><?php echo e($notification->category); ?></div>
            <?php endif; ?>
            
            <div class="priority priority-<?php echo e($notification->priority); ?>">
                <?php echo e($notification->priority_label); ?>

            </div>
            
            <div class="message">
                <?php echo e($notification->message); ?>

            </div>
            
            <?php if($notification->email_content): ?>
                <div class="email-content">
                    <?php echo nl2br(e($notification->email_content)); ?>

                </div>
            <?php endif; ?>
            
            <div style="text-align: center;">
                <a href="<?php echo e(url('/dashboard')); ?>" class="btn">عرض التفاصيل</a>
            </div>
        </div>
        
        <div class="footer">
            <p>هذا الإيميل تم إرساله من منصة Infinity Wear</p>
            <p>إذا لم تطلب هذا الإيميل، يمكنك تجاهله بأمان</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH F:\infinity\Infinity-Wear\resources\views\emails\admin-notification.blade.php ENDPATH**/ ?>