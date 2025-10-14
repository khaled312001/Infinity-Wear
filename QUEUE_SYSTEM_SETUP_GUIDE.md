# دليل إعداد نظام الإشعارات الخارجية - Infinity Wear

## 🎯 الهدف
ضمان إرسال الإشعارات عبر البريد الإلكتروني حتى لو كان الموقع مغلقاً أو غير متاح.

## 🔧 النظام المستخدم
- **Queue System**: Database Queue (Laravel)
- **Background Jobs**: تعمل في الخلفية
- **Failed Jobs**: تتبع المهام الفاشلة
- **Queue Worker**: معالج المهام

## 📋 المتطلبات

### 1. إعدادات قاعدة البيانات
```bash
# تأكد من أن الجداول التالية موجودة:
- jobs (للمهام المعلقة)
- failed_jobs (للمهام الفاشلة)
- notification_settings (إعدادات الإشعارات)
```

### 2. إعدادات البيئة (.env)
```env
# Queue Configuration
QUEUE_CONNECTION=database
DB_QUEUE_TABLE=jobs
DB_QUEUE_RETRY_AFTER=90

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Infinity Wear"
```

## 🚀 خطوات الإعداد

### الخطوة 1: إعداد إعدادات الإشعارات
1. انتقل إلى: `http://127.0.0.1:8000/admin/notifications/settings`
2. أدخل إعدادات Gmail:
   - **خادم SMTP**: `smtp.gmail.com`
   - **المنفذ**: `587`
   - **التشفير**: `TLS`
   - **اسم المستخدم**: بريدك الإلكتروني
   - **كلمة المرور**: كلمة مرور التطبيق
3. **فعّل "تفعيل طابور الإرسال"** ✅
4. احفظ الإعدادات

### الخطوة 2: تشغيل Queue Worker
```bash
# في terminal منفصل (مهم جداً!)
php artisan queue:work --daemon

# أو للتشغيل المستمر
php artisan queue:work --daemon --sleep=3 --tries=3
```

### الخطوة 3: إعداد Supervisor (للإنتاج)
```ini
# /etc/supervisor/conf.d/laravel-worker.conf
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/worker.log
stopwaitsecs=3600
```

## 🔄 كيفية عمل النظام

### 1. عند استلام طلب جديد:
```php
// في NotificationService
if ($settings->email_queue_enabled) {
    Mail::to($adminEmail)->queue(new OrderNotificationMail($data, $adminEmail));
} else {
    Mail::to($adminEmail)->send(new OrderNotificationMail($data, $adminEmail));
}
```

### 2. النظام يضع المهمة في جدول `jobs`:
```sql
INSERT INTO jobs (queue, payload, attempts, reserved_at, available_at, created_at)
VALUES ('default', '{"job":"Illuminate\\Mail\\SendQueuedMailable",...}', 0, NULL, NOW(), NOW());
```

### 3. Queue Worker يعالج المهام:
- يقرأ المهام من جدول `jobs`
- يرسل البريد الإلكتروني
- يحذف المهمة عند النجاح
- يضع المهمة في `failed_jobs` عند الفشل

## 📊 مراقبة النظام

### 1. عرض المهام المعلقة:
```bash
php artisan queue:monitor
```

### 2. عرض المهام الفاشلة:
```bash
php artisan queue:failed
```

### 3. إعادة تشغيل المهام الفاشلة:
```bash
php artisan queue:retry all
```

### 4. حذف المهام الفاشلة:
```bash
php artisan queue:flush
```

## 🛠️ أوامر مفيدة

### إدارة Queue Worker:
```bash
# تشغيل worker
php artisan queue:work

# تشغيل worker مع إعدادات محددة
php artisan queue:work --queue=default --sleep=3 --tries=3 --max-time=3600

# إيقاف worker
php artisan queue:restart

# عرض حالة المهام
php artisan queue:monitor
```

### إدارة المهام الفاشلة:
```bash
# عرض المهام الفاشلة
php artisan queue:failed

# إعادة تشغيل مهمة فاشلة
php artisan queue:retry {id}

# إعادة تشغيل جميع المهام الفاشلة
php artisan queue:retry all

# حذف مهمة فاشلة
php artisan queue:forget {id}

# حذف جميع المهام الفاشلة
php artisan queue:flush
```

## 🔍 استكشاف الأخطاء

### 1. المهام لا تعمل:
```bash
# تحقق من وجود worker
ps aux | grep "queue:work"

# تحقق من المهام المعلقة
php artisan queue:monitor

# تحقق من المهام الفاشلة
php artisan queue:failed
```

### 2. البريد الإلكتروني لا يرسل:
```bash
# تحقق من إعدادات البريد
php artisan tinker
>>> config('mail')

# اختبر إرسال بريد
php artisan tinker
>>> Mail::raw('Test', function($msg) { $msg->to('test@example.com')->subject('Test'); });
```

### 3. مشاكل قاعدة البيانات:
```bash
# تحقق من اتصال قاعدة البيانات
php artisan migrate:status

# إعادة تشغيل migrations
php artisan migrate:refresh
```

## 📱 إعداد Gmail

### 1. تفعيل 2-Step Verification:
1. اذهب إلى Google Account Settings
2. Security → 2-Step Verification
3. فعّل المصادقة الثنائية

### 2. إنشاء App Password:
1. Security → App passwords
2. اختر "Mail" كتطبيق
3. انسخ كلمة المرور الجديدة
4. استخدمها في إعدادات SMTP

## 🚨 نصائح مهمة

### 1. للبيئة المحلية:
```bash
# شغل worker في terminal منفصل
php artisan queue:work --daemon
```

### 2. للبيئة الإنتاجية:
- استخدم Supervisor أو Systemd
- راقب المهام الفاشلة
- أعد تشغيل worker عند الحاجة

### 3. الأمان:
- لا تشارك كلمة مرور التطبيق
- استخدم HTTPS في الإنتاج
- راقب سجلات النظام

## 📈 مراقبة الأداء

### 1. سجلات النظام:
```bash
# سجلات Laravel
tail -f storage/logs/laravel.log

# سجلات Worker (إذا تم إعدادها)
tail -f storage/logs/worker.log
```

### 2. قاعدة البيانات:
```sql
-- عدد المهام المعلقة
SELECT COUNT(*) FROM jobs;

-- عدد المهام الفاشلة
SELECT COUNT(*) FROM failed_jobs;

-- آخر المهام المعالجة
SELECT * FROM jobs ORDER BY created_at DESC LIMIT 10;
```

## ✅ التحقق من عمل النظام

### 1. اختبار الإعدادات:
1. انتقل إلى إعدادات الإشعارات
2. أدخل بريد إلكتروني للاختبار
3. اضغط "إرسال بريد تجريبي"
4. تحقق من وصول البريد

### 2. اختبار النظام الكامل:
1. أرسل طلب جديد من الموقع
2. تحقق من ظهور المهمة في جدول `jobs`
3. تأكد من معالجة المهمة
4. تحقق من وصول الإشعار

---

**ملاحظة مهمة**: يجب تشغيل `php artisan queue:work` في terminal منفصل لضمان عمل النظام حتى لو كان الموقع مغلقاً!

**تم التطوير بواسطة**: نظام Infinity Wear  
**تاريخ التحديث**: أكتوبر 2025
