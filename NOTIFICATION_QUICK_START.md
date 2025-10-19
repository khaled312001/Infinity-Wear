# نظام الإشعارات - دليل البدء السريع

## 🚀 التشغيل السريع

### 1. تشغيل Migrations
```bash
php artisan migrate
```

### 2. توليد مفاتيح VAPID
```bash
php artisan notifications:generate-vapid-keys
```

### 3. إضافة المفاتيح إلى .env
```env
PUSH_NOTIFICATIONS_ENABLED=true
PUSH_VAPID_PUBLIC_KEY=your_public_key_here
PUSH_VAPID_PRIVATE_KEY=your_private_key_here
PUSH_VAPID_SUBJECT=mailto:admin@infinitywear.com
```

### 4. تشغيل Queue Worker
```bash
php artisan queue:work
```

### 5. إضافة Scheduled Tasks (اختياري)
أضف إلى `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('notifications:process-scheduled')->everyMinute();
    $schedule->command('notifications:cleanup')->daily();
}
```

## 📱 الميزات المتاحة

### أنواع الإشعارات
- ✅ **الطلبات الجديدة** - إشعارات فورية عند وصول طلب
- ✅ **رسائل الاتصال** - إشعارات رسائل نموذج الاتصال
- ✅ **رسائل الواتساب** - إشعارات رسائل الواتساب
- ✅ **طلبات المستوردين** - إشعارات طلبات المستوردين
- ✅ **المهام** - إشعارات المهام الجديدة والمحدثة
- ✅ **التقارير التسويقية** - إشعارات التقارير التسويقية
- ✅ **تقارير المبيعات** - إشعارات تقارير المبيعات
- ✅ **إشعارات النظام** - إشعارات عامة من النظام

### قنوات الإشعارات
- ✅ **قاعدة البيانات** - تخزين الإشعارات
- ✅ **البريد الإلكتروني** - إرسال عبر البريد
- ✅ **Push Notifications** - إشعارات المتصفح
- ✅ **WebSocket** - بث مباشر
- ✅ **Toast Notifications** - إشعارات منبثقة

### الأدوار المدعومة
- ✅ **الإدارة** - جميع أنواع الإشعارات
- ✅ **المبيعات** - الطلبات، الرسائل، المهام، التقارير
- ✅ **التسويق** - الرسائل، الواتساب، المهام، التقارير
- ✅ **المستوردين** - طلبات المستوردين، إشعارات النظام

## 🔧 الاستخدام

### إرسال إشعار بسيط
```php
use App\Services\NotificationService;

$notificationService = app(NotificationService::class);

// إشعار طلب جديد
$notificationService->createOrderNotification($order);

// إشعار رسالة اتصال
$notificationService->createContactNotification($contact);
```

### إرسال إشعار متقدم
```php
$notificationService->sendAdvancedNotification(
    'order',                    // نوع الإشعار
    'طلب جديد',                // العنوان
    'تم استلام طلب جديد',      // المحتوى
    ['order_id' => 123],       // بيانات إضافية
    [1, 2, 3],                 // المستخدمين المستهدفين
    'admin'                    // نوع المستخدمين
);
```

## 🌐 الواجهة

### صفحة الإشعارات
- **URL**: `/admin/notifications`
- **الميزات**:
  - عرض جميع الإشعارات
  - فلترة حسب النوع
  - تحديد كمقروء/غير مقروء
  - أرشفة الإشعارات
  - إحصائيات مفصلة

### API Endpoints
- `GET /api/notifications` - الحصول على الإشعارات
- `POST /api/notifications/{id}/read` - تحديد كمقروء
- `POST /api/notifications/subscribe` - تسجيل Push Notifications
- `POST /api/notifications/test` - إشعار تجريبي

## 🛠️ الصيانة

### تنظيف الإشعارات القديمة
```bash
php artisan notifications:cleanup
```

### معالجة الإشعارات المجدولة
```bash
php artisan notifications:process-scheduled
```

## 🔍 استكشاف الأخطاء

### الإشعارات لا تظهر
1. تحقق من تفعيل الإشعارات في المتصفح
2. تحقق من إعدادات VAPID keys
3. تحقق من logs: `storage/logs/laravel.log`

### Push Notifications لا تعمل
1. تحقق من تسجيل Service Worker
2. تحقق من صحة VAPID keys
3. تحقق من دعم المتصفح

## 📞 الدعم

للحصول على الدعم:
1. راجع `NOTIFICATION_SYSTEM_SETUP.md` للتفاصيل الكاملة
2. تحقق من logs النظام
3. اتصل بفريق التطوير

---

**ملاحظة**: هذا النظام جاهز للاستخدام فوراً بعد اتباع خطوات التشغيل السريع!
