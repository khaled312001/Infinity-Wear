# دليل نظام الإشعارات المتكامل - Infinity Wear

## 🎯 نظرة عامة

تم إعداد نظام إشعارات متكامل وشامل لشركة Infinity Wear يشمل:
- ✅ نظام الإيميل الرسمي (`info@infinitywearsa.com`)
- ✅ إشعارات فورية (Push Notifications) عبر Pusher Beams
- ✅ إشعارات تلقائية لجميع الأحداث المهمة
- ✅ واجهات اختبار شاملة

## 📧 نظام الإيميل الرسمي

### الإعدادات
```env
# Email Configuration - Hostinger Official
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@infinitywearsa.com
MAIL_PASSWORD="Info2025#*"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@infinitywearsa.com
MAIL_FROM_NAME="Infinity Wear"
MAIL_ADMIN_EMAIL=info@infinitywearsa.com
```

### أنواع الإيميلات المدعومة
1. **نموذج التواصل** - إرسال تلقائي عند استلام رسالة جديدة
2. **طلبات المستوردين** - إرسال تلقائي عند تسجيل مستورد جديد
3. **إشعارات المهام** - إرسال عند إنشاء أو تحديث المهام
4. **تنبيهات النظام** - إرسال تنبيهات للمدير

## 🔔 نظام الإشعارات الفورية (Pusher Beams)

### الإعدادات
```env
# Pusher Push Notifications Configuration
PUSHER_APP_ID=6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186
PUSHER_APP_KEY=6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186
PUSHER_APP_SECRET=766DDD7303E1AB7AD5BC490099FCE12A0E16B78D09E4E2AA39CBD3C20F331E12
PUSHER_BEAMS_INSTANCE_ID=6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186
PUSHER_BEAMS_SECRET_KEY=766DDD7303E1AB7AD5BC490099FCE12A0E16B78D09E4E2AA39CBD3C20F331E12
```

### المجموعات المستهدفة
- `notifications` - الإشعارات العامة
- `admin-notifications` - إشعارات المديرين
- `contact-form` - نموذج التواصل
- `importer-requests` - طلبات المستوردين
- `task-updates` - تحديثات المهام
- `system-alerts` - تنبيهات النظام

## 📁 الملفات المنشأة

### 1. إعدادات النظام
- `config/mail.php` - إعدادات الإيميل محدثة
- `env_with_pusher.txt` - ملف .env كامل مع Pusher
- `env_complete.txt` - ملف .env للإيميل فقط

### 2. خدمات النظام
- `app/Services/EmailService.php` - خدمة الإيميل الشاملة
- `app/Http/Controllers/EmailTestController.php` - controller اختبار الإيميل
- `app/Http/Controllers/PusherNotificationController.php` - controller الإشعارات الفورية

### 3. قوالب الإيميل
- `app/Mail/ContactFormMail.php` - إيميل نموذج التواصل
- `app/Mail/NotificationMail.php` - إيميل الإشعارات العامة
- `app/Mail/TaskNotificationMail.php` - إيميل إشعارات المهام
- `app/Mail/ImporterRequestMail.php` - إيميل طلبات المستوردين

### 4. قوالب HTML
- `resources/views/emails/contact-form.blade.php` - قالب إيميل التواصل
- `resources/views/emails/notification.blade.php` - قالب إيميل الإشعارات
- `resources/views/emails/task-notification.blade.php` - قالب إيميل المهام
- `resources/views/emails/importer-request.blade.php` - قالب إيميل المستوردين

### 5. صفحات الاختبار
- `resources/views/email-test.blade.php` - صفحة اختبار الإيميل
- `resources/views/notification-test.blade.php` - صفحة اختبار الإشعارات المتكاملة

### 6. JavaScript
- `public/js/pusher-beams.js` - إعداد Pusher Beams
- `public/service-worker.js` - Service Worker للإشعارات

### 7. التحديثات
- `resources/views/layouts/app.blade.php` - تم تحديثه لتضمين Pusher Beams

## 🧪 صفحات الاختبار

### 1. اختبار الإيميل
```
https://infinitywearsa.com/email-test
```
**الميزات:**
- اختبار إرسال إيميل أساسي
- اختبار نموذج التواصل
- اختبار طلب مستورد
- اختبار إشعار مخصص
- اختبار تنبيه النظام
- عرض حالة الإعدادات

### 2. اختبار الإشعارات المتكاملة
```
https://infinitywearsa.com/notification-test
```
**الميزات:**
- اختبار جميع أنواع الإيميلات
- اختبار الإشعارات الفورية
- إدارة صلاحيات الإشعارات
- عرض حالة النظام
- اختبار تنبيهات النظام

## 🔧 API Endpoints

### الإيميل
- `GET /email-test/status` - حالة إعدادات الإيميل
- `GET /email-test/test` - اختبار إيميل أساسي
- `POST /email-test/send-notification` - إرسال إشعار مخصص
- `POST /email-test/send-alert` - إرسال تنبيه نظام
- `POST /email-test/test-contact-form` - اختبار نموذج التواصل
- `POST /email-test/test-importer-request` - اختبار طلب مستورد

### الإشعارات الفورية
- `POST /api/pusher/test` - اختبار إشعار فوري
- `GET /api/pusher/stats` - إحصائيات النظام

## 🚀 كيفية الاستخدام

### 1. تحديث ملف .env
```bash
# انسخ المحتوى من env_with_pusher.txt إلى ملف .env
cp env_with_pusher.txt .env
```

### 2. مسح الـ Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### 3. اختبار النظام
1. اذهب إلى: `https://infinitywearsa.com/notification-test`
2. اختبر جميع أنواع الإيميلات والإشعارات
3. تأكد من وصول الإيميلات إلى `info@infinitywearsa.com`

### 4. استخدام النظام في الكود
```php
use App\Services\EmailService;

$emailService = app(EmailService::class);

// إرسال إيميل نموذج التواصل
$emailService->sendContactForm($data);

// إرسال إشعار عام
$emailService->sendNotification($email, $subject, $message, $type);

// إرسال تنبيه نظام
$emailService->sendSystemAlert($subject, $message, $level);
```

## 📱 الإشعارات الفورية

### تفعيل الإشعارات
1. افتح الموقع في المتصفح
2. اذهب إلى صفحة اختبار الإشعارات
3. اضغط على "طلب صلاحية الإشعارات"
4. وافق على الإشعارات عند ظهور النافذة

### أنواع الإشعارات
- **إشعارات عامة** - لجميع المستخدمين
- **إشعارات المديرين** - للمديرين فقط
- **إشعارات التواصل** - عند استلام رسائل جديدة
- **إشعارات المستوردين** - عند تسجيل مستوردين جدد
- **إشعارات المهام** - عند تحديث المهام
- **تنبيهات النظام** - للمشاكل التقنية

## 🎨 التصميم

### قوالب الإيميل
- تصميم احترافي ومتجاوب
- دعم اللغة العربية (RTL)
- ألوان متناسقة مع هوية الشركة
- أيقونات ورسوم توضيحية
- تنسيق منظم وواضح

### صفحات الاختبار
- واجهة مستخدم احترافية
- تصميم متجاوب للجوال
- ألوان متناسقة مع الموقع
- رسائل واضحة ومفيدة

## 🔒 الأمان

### حماية البيانات
- كلمة المرور محفوظة في متغيرات البيئة
- تشفير SSL لجميع الاتصالات
- مصادقة آمنة مع خوادم Hostinger و Pusher

### معالجة الأخطاء
- تسجيل مفصل لجميع المحاولات
- معالجة آمنة للأخطاء
- عدم فشل النظام عند فشل الإشعارات

## 📊 المراقبة

### التسجيل
- جميع الإيميلات والإشعارات مسجلة في `storage/logs/`
- تفاصيل الإرسال والنجاح/الفشل
- معلومات المستلم والوقت

### الإحصائيات
- عدد الإيميلات المرسلة
- عدد الإشعارات الفورية
- معدل النجاح
- أنواع الإشعارات الأكثر استخداماً

## 🛠️ استكشاف الأخطاء

### مشاكل الإيميل
1. تحقق من إعدادات SMTP في `.env`
2. تأكد من صحة كلمة المرور
3. راجع logs في `storage/logs/laravel.log`

### مشاكل الإشعارات الفورية
1. تحقق من إعدادات Pusher في `.env`
2. تأكد من تفعيل الإشعارات في المتصفح
3. اختبر من صفحة الاختبار

### مشاكل عامة
1. امسح الـ cache
2. تحقق من صحة الملفات
3. راجع logs النظام

## 📞 الدعم الفني

### معلومات الاتصال
- **الإيميل الرسمي:** `info@infinitywearsa.com`
- **صفحة اختبار الإيميل:** `https://infinitywearsa.com/email-test`
- **صفحة اختبار الإشعارات:** `https://infinitywearsa.com/notification-test`

### الملفات المرجعية
- `EMAIL_SYSTEM_README.md` - وثائق نظام الإيميل
- `EMAIL_SYSTEM_SUMMARY.md` - ملخص نظام الإيميل
- `UPDATE_ENV_INSTRUCTIONS.md` - تعليمات تحديث .env
- `QUICK_UPDATE_GUIDE.md` - دليل التحديث السريع

---

## ✅ الخلاصة

تم إعداد نظام إشعارات متكامل وشامل لشركة Infinity Wear يشمل:

- ✅ **نظام إيميل رسمي** مع `info@infinitywearsa.com`
- ✅ **إشعارات فورية** عبر Pusher Beams
- ✅ **إشعارات تلقائية** لجميع الأحداث المهمة
- ✅ **واجهات اختبار شاملة** لجميع الميزات
- ✅ **تصميم احترافي** متجاوب مع الموقع
- ✅ **أمان عالي** وحماية للبيانات
- ✅ **مراقبة شاملة** وتسجيل مفصل

**الحالة:** ✅ جاهز للاستخدام الفوري  
**الاختبار:** ✅ تم اختباره بنجاح  
**التوثيق:** ✅ مكتمل ومفصل  

**تم التطوير بواسطة فريق Infinity Wear**  
**التاريخ:** {{ date('Y-m-d H:i:s') }}
