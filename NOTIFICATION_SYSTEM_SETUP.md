# نظام الإشعارات المتقدم - Infinity Wear

## نظرة عامة

تم تطوير نظام إشعارات احترافي ومتقدم لجميع الأدوار في النظام (الإدارة، المبيعات، التسويق، المستوردين) مع دعم:

- **إشعارات المتصفح (Browser Notifications)**
- **إشعارات Push (حتى مع إغلاق المتصفح)**
- **البث المباشر عبر WebSocket**
- **إشعارات البريد الإلكتروني**
- **إشعارات مجدولة**
- **Rate Limiting**
- **تنظيف تلقائي للإشعارات القديمة**

## الميزات الرئيسية

### 1. أنواع الإشعارات المدعومة
- **الطلبات الجديدة** - إشعارات فورية عند وصول طلب جديد
- **رسائل الاتصال** - إشعارات عند وصول رسالة من نموذج الاتصال
- **رسائل الواتساب** - إشعارات عند وصول رسالة واتساب
- **طلبات المستوردين** - إشعارات طلبات المستوردين الجديدة
- **إشعارات النظام** - إشعارات عامة من النظام
- **المهام** - إشعارات المهام الجديدة والمحدثة
- **التقارير التسويقية** - إشعارات التقارير
- **تقارير المبيعات** - إشعارات تقارير المبيعات

### 2. الأدوار المدعومة
- **الإدارة** - جميع أنواع الإشعارات
- **المبيعات** - الطلبات، الرسائل، المهام، تقارير المبيعات
- **التسويق** - الرسائل، الواتساب، المهام، التقارير التسويقية
- **المستوردين** - طلبات المستوردين، إشعارات النظام

### 3. قنوات الإشعارات
- **قاعدة البيانات** - تخزين الإشعارات في قاعدة البيانات
- **البريد الإلكتروني** - إرسال إشعارات عبر البريد الإلكتروني
- **Push Notifications** - إشعارات المتصفح حتى مع إغلاقه
- **WebSocket** - بث مباشر للإشعارات
- **Toast Notifications** - إشعارات منبثقة في الواجهة

## التثبيت والإعداد

### 1. تشغيل Migrations

```bash
php artisan migrate
```

### 2. توليد مفاتيح VAPID

```bash
php artisan notifications:generate-vapid-keys
```

أضف المفاتيح إلى ملف `.env`:

```env
PUSH_NOTIFICATIONS_ENABLED=true
PUSH_VAPID_PUBLIC_KEY=your_public_key_here
PUSH_VAPID_PRIVATE_KEY=your_private_key_here
PUSH_VAPID_SUBJECT=mailto:admin@infinitywear.com
```

### 3. إعداد Broadcasting (اختياري)

لتفعيل البث المباشر، أضف إلى `.env`:

```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=mt1
```

### 4. إعداد Queue Worker

```bash
php artisan queue:work
```

### 5. إعداد Scheduled Tasks

أضف إلى `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // معالجة الإشعارات المجدولة كل دقيقة
    $schedule->command('notifications:process-scheduled')->everyMinute();
    
    // تنظيف الإشعارات القديمة يومياً
    $schedule->command('notifications:cleanup')->daily();
}
```

## الاستخدام

### 1. إرسال إشعار بسيط

```php
use App\Services\NotificationService;

$notificationService = app(NotificationService::class);

// إشعار طلب جديد
$notificationService->createOrderNotification($order);

// إشعار رسالة اتصال
$notificationService->createContactNotification($contact);

// إشعار نظام
$notificationService->createSystemNotification(
    'عنوان الإشعار',
    'محتوى الإشعار',
    ['data' => 'additional_data']
);
```

### 2. إرسال إشعار متقدم

```php
$notificationService->sendAdvancedNotification(
    'order',                    // نوع الإشعار
    'طلب جديد',                // العنوان
    'تم استلام طلب جديد',      // المحتوى
    ['order_id' => 123],       // بيانات إضافية
    [1, 2, 3],                 // المستخدمين المستهدفين (اختياري)
    'admin'                    // نوع المستخدمين
);
```

### 3. إدارة الإشعارات في الواجهة

```javascript
// التحقق من دعم الإشعارات
if (window.notificationManager) {
    // إرسال إشعار تجريبي
    window.notificationManager.sendTestNotification();
    
    // تحميل الإشعارات
    window.notificationManager.loadNotifications();
}
```

## API Endpoints

### الإشعارات

- `GET /api/notifications` - الحصول على الإشعارات
- `GET /api/notifications/stats` - إحصائيات الإشعارات
- `POST /api/notifications/{id}/read` - تحديد إشعار كمقروء
- `POST /api/notifications/mark-all-read` - تحديد الكل كمقروء
- `POST /api/notifications/{id}/archive` - أرشفة إشعار
- `POST /api/notifications/archive-read` - أرشفة المقروءة
- `DELETE /api/notifications/{id}` - حذف إشعار
- `POST /api/notifications/subscribe` - تسجيل اشتراك Push
- `POST /api/notifications/unsubscribe` - إلغاء اشتراك Push
- `POST /api/notifications/test` - إشعار تجريبي
- `POST /api/notifications/cleanup` - تنظيف الإشعارات

### Push Notifications

- `GET /api/push/vapid-key` - الحصول على مفتاح VAPID العام

## التخصيص

### 1. إضافة نوع إشعار جديد

1. أضف النوع إلى `config/push.php`:

```php
'types' => [
    'new_type' => [
        'title' => 'عنوان الإشعار',
        'icon' => '/images/icon.png',
        'url' => '/admin/new-type',
        'sound' => 'notification.mp3',
    ],
],
```

2. أضف الأيقونة واللون في `NotificationService`:

```php
private function getNotificationIcon($type)
{
    $icons = [
        'new_type' => 'fas fa-new-icon',
        // ...
    ];
    return $icons[$type] ?? 'fas fa-bell';
}
```

### 2. تخصيص الأصوات

ضع ملفات الصوت في `public/sounds/`:

- `notification.mp3` - الصوت الافتراضي
- `order-notification.mp3` - صوت الطلبات
- `contact-notification.mp3` - صوت الرسائل
- إلخ...

### 3. تخصيص الأيقونات

ضع ملفات الأيقونات في `public/images/`:

- `notification-icon.png` - الأيقونة الافتراضية
- `badge-icon.png` - أيقونة الشارة
- `order-icon.png` - أيقونة الطلبات
- إلخ...

## الأمان

### 1. Rate Limiting

النظام يدعم Rate Limiting لمنع إرسال إشعارات مفرطة:

```php
'rate_limiting' => [
    'enabled' => true,
    'max_per_minute' => 10,
    'max_per_hour' => 100,
    'max_per_day' => 1000,
],
```

### 2. VAPID Keys

مفاتيح VAPID محمية ولا يجب مشاركتها:

- المفتاح العام: آمن للمشاركة
- المفتاح الخاص: يجب الحفاظ عليه سرياً

### 3. CSRF Protection

جميع طلبات API محمية بـ CSRF tokens.

## استكشاف الأخطاء

### 1. الإشعارات لا تظهر

- تحقق من تفعيل الإشعارات في المتصفح
- تحقق من إعدادات VAPID keys
- تحقق من logs: `storage/logs/laravel.log`

### 2. Push Notifications لا تعمل

- تحقق من تسجيل Service Worker
- تحقق من صحة VAPID keys
- تحقق من دعم المتصفح للإشعارات

### 3. البث المباشر لا يعمل

- تحقق من إعدادات Broadcasting
- تحقق من اتصال WebSocket
- تحقق من إعدادات Pusher (إذا مستخدم)

## الصيانة

### 1. تنظيف الإشعارات القديمة

```bash
php artisan notifications:cleanup
```

### 2. معالجة الإشعارات المجدولة

```bash
php artisan notifications:process-scheduled
```

### 3. مراقبة الأداء

- تحقق من إحصائيات الإشعارات في `/admin/notifications`
- راقب logs النظام
- تحقق من حالة Queue Worker

## الدعم

للحصول على الدعم أو الإبلاغ عن مشاكل:

1. تحقق من logs النظام
2. راجع هذا الدليل
3. اتصل بفريق التطوير

---

**ملاحظة**: هذا النظام مصمم ليكون مرناً وقابلاً للتخصيص حسب احتياجات المشروع. يمكن إضافة ميزات جديدة أو تعديل الموجودة بسهولة.
