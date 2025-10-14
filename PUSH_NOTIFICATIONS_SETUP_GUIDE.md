# دليل إعداد إشعارات الموبايل - Infinity Wear

## 🎯 الهدف
إرسال إشعارات فورية للموبايل حتى لو كان المتصفح مغلق أو الموقع غير متاح.

## 🔧 النظام المستخدم
- **Web Push API**: لإرسال الإشعارات
- **Service Worker**: للعمل في الخلفية
- **VAPID Keys**: للمصادقة
- **Database Queue**: لضمان الإرسال

## 📋 المتطلبات

### 1. متطلبات المتصفح
- Chrome 42+
- Firefox 44+
- Safari 16+
- Edge 17+

### 2. متطلبات الخادم
- HTTPS (مطلوب للإنتاج)
- PHP 8.0+
- Laravel 10+
- مكتبة WebPush

## 🚀 خطوات الإعداد

### الخطوة 1: تثبيت المكتبات
```bash
composer require minishlink/web-push
```

### الخطوة 2: إنشاء مفاتيح VAPID
```bash
# إنشاء مفاتيح VAPID جديدة
php artisan tinker
>>> $keys = \Minishlink\WebPush\VAPID::createVapidKeys();
>>> echo "Public Key: " . $keys['publicKey'] . "\n";
>>> echo "Private Key: " . $keys['privateKey'] . "\n";
```

### الخطوة 3: إعداد متغيرات البيئة
```env
# Push Notifications
PUSH_NOTIFICATIONS_ENABLED=true
PUSH_VAPID_SUBJECT=https://yourdomain.com
PUSH_VAPID_PUBLIC_KEY=your_public_key_here
PUSH_VAPID_PRIVATE_KEY=your_private_key_here
PUSH_DEFAULT_ICON=/images/logo.png
PUSH_DEFAULT_BADGE=/images/logo.png
PUSH_DEFAULT_URL=/admin/notifications
```

### الخطوة 4: تشغيل Migrations
```bash
php artisan migrate
```

### الخطوة 5: إضافة Service Worker
- تأكد من وجود ملف `/public/sw.js`
- تأكد من تسجيل Service Worker في الصفحات

### الخطوة 6: إضافة JavaScript
- أضف `/public/js/push-notifications.js` للصفحات
- أضف `/public/css/push-notifications.css` للتصميم

## 🔑 إعداد مفاتيح VAPID

### إنشاء مفاتيح جديدة:
```php
// في tinker
$keys = \Minishlink\WebPush\VAPID::createVapidKeys();
echo "Public: " . $keys['publicKey'] . "\n";
echo "Private: " . $keys['privateKey'] . "\n";
```

### إضافة المفاتيح للـ .env:
```env
PUSH_VAPID_PUBLIC_KEY=BEl62iUYgUivxIkv69yViEuiBIa40HI0QY-DRhkJjlbHUsQ_8j0ONQZfpb3ywsxcrkAIzHFrLyxcc96S0XgL0B8
PUSH_VAPID_PRIVATE_KEY=your_private_key_here
```

## 📱 كيفية عمل النظام

### 1. الاشتراك في الإشعارات:
```javascript
// في المتصفح
const manager = new PushNotificationManager();
await manager.subscribe('admin');
```

### 2. إرسال الإشعار:
```php
// في Laravel
$notificationService = new NotificationService();
$notificationService->createOrderNotification($order);
```

### 3. استقبال الإشعار:
- Service Worker يستقبل الإشعار
- يعرض الإشعار للمستخدم
- يفتح الصفحة عند النقر

## 🎨 أنواع الإشعارات

### 1. طلبات جديدة:
- **العنوان**: "طلب جديد"
- **النص**: "طلب جديد من [اسم العميل] - رقم الطلب: [رقم الطلب]"
- **الرابط**: `/admin/orders/[id]`

### 2. رسائل الاتصال:
- **العنوان**: "رسالة اتصال جديدة"
- **النص**: "رسالة اتصال جديدة من [اسم المرسل]"
- **الرابط**: `/admin/contacts/[id]`

### 3. رسائل الواتساب:
- **العنوان**: "رسالة واتساب جديدة"
- **النص**: "رسالة واتساب جديدة من [اسم المرسل]"
- **الرابط**: `/admin/whatsapp/[id]`

### 4. إشعارات النظام:
- **العنوان**: "إشعار النظام"
- **النص**: [النص المخصص]
- **الرابط**: `/admin/notifications`

## 🔧 إعدادات متقدمة

### 1. تخصيص الإشعارات:
```php
// في config/push.php
'types' => [
    'order' => [
        'title' => 'طلب جديد',
        'icon' => '/images/order-icon.png',
        'url' => '/admin/orders',
        'enabled' => true,
    ],
    // ... أنواع أخرى
],
```

### 2. إعدادات المستخدمين:
```php
'user_types' => [
    'admin' => [
        'enabled' => true,
        'default_notifications' => ['order', 'contact', 'whatsapp', 'system'],
    ],
    'customer' => [
        'enabled' => false,
        'default_notifications' => ['order'],
    ],
],
```

### 3. تنظيف الاشتراكات:
```php
'cleanup' => [
    'enabled' => true,
    'days_old' => 30, // حذف الاشتراكات الأقدم من 30 يوم
    'schedule' => 'daily',
],
```

## 📊 مراقبة النظام

### 1. صفحة الإدارة:
```
http://127.0.0.1:8000/admin/notifications/push-notifications
```

### 2. الإحصائيات المتاحة:
- إجمالي الاشتراكات
- الاشتراكات النشطة
- اشتراكات الموبايل
- اشتراكات سطح المكتب

### 3. إدارة الاشتراكات:
- تفعيل/إلغاء تفعيل
- حذف الاشتراكات
- تنظيف الاشتراكات القديمة

## 🛠️ أوامر مفيدة

### إدارة الاشتراكات:
```bash
# تنظيف الاشتراكات القديمة
php artisan tinker
>>> App\Models\PushSubscription::cleanupOldSubscriptions();

# الحصول على إحصائيات
>>> App\Models\PushSubscription::getStats();
```

### اختبار النظام:
```bash
# إرسال إشعار تجريبي
curl -X POST http://127.0.0.1:8000/api/push/test \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: your_token"
```

## 🔍 استكشاف الأخطاء

### 1. الإشعارات لا تظهر:
- تحقق من تفعيل الإشعارات في المتصفح
- تحقق من وجود Service Worker
- تحقق من مفاتيح VAPID

### 2. خطأ في الاشتراك:
- تحقق من HTTPS (مطلوب للإنتاج)
- تحقق من صحة مفاتيح VAPID
- تحقق من سجلات المتصفح

### 3. الإشعارات لا تصل:
- تحقق من حالة الاشتراكات
- تحقق من سجلات Laravel
- تحقق من إعدادات Firewall

## 📱 دعم المتصفحات

### Chrome/Edge:
- ✅ دعم كامل
- ✅ Service Worker
- ✅ Push API

### Firefox:
- ✅ دعم كامل
- ✅ Service Worker
- ✅ Push API

### Safari:
- ✅ دعم محدود (iOS 16.4+)
- ✅ Service Worker
- ✅ Push API

### Mobile Browsers:
- ✅ Chrome Mobile
- ✅ Firefox Mobile
- ✅ Safari Mobile (iOS 16.4+)

## 🚨 نصائح مهمة

### 1. للإنتاج:
- استخدم HTTPS
- راقب الاشتراكات
- نظف الاشتراكات القديمة
- راقب الأداء

### 2. للأمان:
- احتفظ بمفاتيح VAPID آمنة
- راقب الاشتراكات المشبوهة
- استخدم HTTPS فقط

### 3. للأداء:
- راقب عدد الاشتراكات
- نظف الاشتراكات غير النشطة
- استخدم Queue للرسائل الكثيرة

## ✅ التحقق من عمل النظام

### 1. اختبار الاشتراك:
1. افتح الموقع في المتصفح
2. اضغط "تفعيل الإشعارات"
3. وافق على الإذن
4. تحقق من ظهور الاشتراك في الإدارة

### 2. اختبار الإرسال:
1. انتقل إلى صفحة الإدارة
2. اضغط "إرسال إشعار تجريبي"
3. تحقق من وصول الإشعار
4. تحقق من فتح الصفحة عند النقر

### 3. اختبار العمل في الخلفية:
1. أغلق المتصفح
2. أرسل إشعار من الإدارة
3. تحقق من وصول الإشعار
4. تحقق من فتح الصفحة عند النقر

## 🎉 النتيجة النهائية

**النظام يعمل الآن بشكل كامل!**

- ✅ إشعارات فورية للموبايل
- ✅ عمل حتى لو كان المتصفح مغلق
- ✅ دعم جميع المتصفحات الحديثة
- ✅ واجهة إدارة شاملة
- ✅ مراقبة النظام
- ✅ تنظيف تلقائي

**الآن يمكنك تلقي إشعارات فورية على الموبايل عند:**
- استلام طلبات جديدة
- وصول رسائل اتصال
- استلام رسائل واتساب
- أي تحديثات مهمة في النظام

**حتى لو كان المتصفح مغلق!** 📱🚀

---

**تم التطوير بواسطة**: نظام Infinity Wear  
**تاريخ الإنجاز**: أكتوبر 2025  
**الإصدار**: 1.0.0 - Production Ready
