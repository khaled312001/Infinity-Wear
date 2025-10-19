# نظام الإيميل الرسمي - Infinity Wear

## نظرة عامة
تم إعداد نظام إيميل رسمي شامل لشركة Infinity Wear باستخدام الإيميل الرسمي `info@infinitywearsa.com` من Hostinger.

## إعدادات الإيميل

### الإيميل الرسمي
- **الإيميل:** `info@infinitywearsa.com`
- **كلمة المرور:** `Info2025#*`
- **الخادم:** Hostinger

### إعدادات SMTP (الإرسال)
- **المضيف:** `smtp.hostinger.com`
- **المنفذ:** `465`
- **التشفير:** `SSL`
- **المصادقة:** مطلوبة

### إعدادات IMAP (الاستقبال)
- **المضيف:** `imap.hostinger.com`
- **المنفذ:** `993`
- **التشفير:** `SSL`

### إعدادات POP (الاستقبال البديل)
- **المضيف:** `pop.hostinger.com`
- **المنفذ:** `995`
- **التشفير:** `SSL`

## الملفات المحدثة

### 1. إعدادات الإيميل
- `config/mail.php` - تم تحديث إعدادات SMTP و IMAP و POP
- `email_config.txt` - ملف يحتوي على جميع إعدادات الإيميل

### 2. خدمات الإيميل
- `app/Services/EmailService.php` - خدمة شاملة لإدارة الإيميلات
- `app/Http/Controllers/EmailTestController.php` - controller لاختبار الإيميل

### 3. قوالب الإيميل
- `app/Mail/ContactFormMail.php` - إيميل نموذج التواصل
- `app/Mail/NotificationMail.php` - إيميل الإشعارات العامة
- `app/Mail/TaskNotificationMail.php` - إيميل إشعارات المهام
- `app/Mail/ImporterRequestMail.php` - إيميل طلبات المستوردين

### 4. قوالب HTML
- `resources/views/emails/contact-form.blade.php` - قالب إيميل نموذج التواصل
- `resources/views/emails/notification.blade.php` - قالب إيميل الإشعارات
- `resources/views/emails/task-notification.blade.php` - قالب إيميل المهام
- `resources/views/emails/importer-request.blade.php` - قالب إيميل طلبات المستوردين

### 5. صفحة الاختبار
- `resources/views/email-test.blade.php` - صفحة اختبار شاملة لنظام الإيميل
- Route: `/email-test` - للوصول لصفحة الاختبار

## الميزات المتاحة

### 1. إرسال الإيميلات التلقائية
- **نموذج التواصل:** إرسال تلقائي عند استلام رسالة جديدة
- **طلبات المستوردين:** إرسال تلقائي عند تسجيل مستورد جديد
- **إشعارات المهام:** إرسال عند إنشاء أو تحديث المهام
- **تنبيهات النظام:** إرسال تنبيهات للمدير

### 2. أنواع الإيميلات المدعومة
- إيميلات HTML مع تصميم احترافي
- إيميلات متعددة اللغات (عربي/إنجليزي)
- قوالب قابلة للتخصيص
- دعم المرفقات (يمكن إضافتها لاحقاً)

### 3. نظام الإشعارات
- إشعارات فورية عند الأحداث المهمة
- إشعارات مجمعة للتقارير اليومية
- تنبيهات النظام للمشاكل التقنية
- إشعارات مخصصة للمستخدمين

## كيفية الاستخدام

### 1. اختبار النظام
```
https://infinitywear.sa/email-test
```

### 2. استخدام خدمة الإيميل في الكود
```php
use App\Services\EmailService;

// إرسال إيميل نموذج التواصل
$emailService = app(EmailService::class);
$emailService->sendContactForm($data);

// إرسال إشعار
$emailService->sendNotification($email, $subject, $message, $type);

// إرسال تنبيه نظام
$emailService->sendSystemAlert($subject, $message, $level);
```

### 3. API Endpoints المتاحة
- `GET /email-test/status` - حالة إعدادات الإيميل
- `GET /email-test/test` - اختبار إرسال إيميل أساسي
- `POST /email-test/send-notification` - إرسال إشعار مخصص
- `POST /email-test/send-alert` - إرسال تنبيه نظام
- `POST /email-test/test-contact-form` - اختبار نموذج التواصل
- `POST /email-test/test-importer-request` - اختبار طلب مستورد

## التكامل مع النظام

### 1. نموذج التواصل
تم تحديث `ContactController` لاستخدام خدمة الإيميل الجديدة.

### 2. طلبات المستوردين
يمكن دمج خدمة الإيميل مع `ImporterController` لإرسال إيميلات تلقائية.

### 3. نظام المهام
يمكن دمج خدمة الإيميل مع `TaskController` لإرسال إشعارات المهام.

### 4. الإشعارات العامة
تم دمج خدمة الإيميل مع نظام الإشعارات الموجود.

## الأمان والموثوقية

### 1. حماية كلمة المرور
- كلمة المرور محفوظة في متغيرات البيئة
- تشفير SSL لجميع الاتصالات
- مصادقة آمنة مع خادم Hostinger

### 2. معالجة الأخطاء
- تسجيل جميع محاولات الإرسال
- معالجة الأخطاء بشكل آمن
- عدم فشل النظام عند فشل الإيميل

### 3. المراقبة
- تسجيل مفصل لجميع الإيميلات المرسلة
- إحصائيات الإرسال والنجاح
- تنبيهات عند فشل الإرسال

## الصيانة والتطوير

### 1. إضافة أنواع إيميل جديدة
1. إنشاء Mail class جديد في `app/Mail/`
2. إنشاء template في `resources/views/emails/`
3. إضافة method جديد في `EmailService`
4. إضافة route للاختبار

### 2. تخصيص القوالب
- جميع القوالب في `resources/views/emails/`
- دعم CSS و JavaScript
- تصميم متجاوب للجوال

### 3. إضافة مرفقات
- يمكن إضافة دعم المرفقات في `EmailService`
- دعم أنواع ملفات متعددة
- حدود حجم آمنة

## استكشاف الأخطاء

### 1. مشاكل الاتصال
- التحقق من إعدادات SMTP
- التأكد من صحة كلمة المرور
- فحص اتصال الإنترنت

### 2. مشاكل الإرسال
- مراجعة logs في `storage/logs/`
- اختبار الاتصال من صفحة الاختبار
- التحقق من صحة عنوان الإيميل

### 3. مشاكل القوالب
- التحقق من صحة Blade syntax
- فحص مسارات الملفات
- اختبار القوالب منفصلة

## الدعم الفني

للحصول على الدعم الفني أو الإبلاغ عن مشاكل:
- الإيميل: `info@infinitywearsa.com`
- صفحة الاختبار: `/email-test`
- Logs النظام: `storage/logs/laravel.log`

---

**تم التطوير بواسطة فريق Infinity Wear**  
**آخر تحديث:** {{ date('Y-m-d H:i:s') }}
