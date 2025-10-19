# نظام الإشعارات المخصصة للأدمن

## نظرة عامة
تم إنشاء نظام شامل لإدارة الإشعارات المخصصة للأدمن يتيح إرسال رسائل وإيميلات للمستخدمين في الموقع. النظام يدعم إرسال الإشعارات لجميع المستخدمين أو فئات محددة أو مستخدمين محددين.

## المميزات الرئيسية

### 1. أنواع الإرسال
- **إشعار فقط**: إرسال إشعار في لوحة تحكم المستخدم
- **إيميل فقط**: إرسال إيميل للمستخدم
- **إشعار وإيميل**: إرسال كليهما معاً

### 2. أنواع المستهدفين
- **جميع المستخدمين**: إرسال لجميع المستخدمين النشطين
- **نوع مستخدم محدد**: إرسال لفئة معينة (مدير، موظف، مستورد، عميل، مندوب مبيعات، موظف تسويق)
- **مستخدمين محددين**: اختيار مستخدمين معينين من قائمة

### 3. الأولويات
- **منخفضة**: إشعارات عادية
- **عادية**: إشعارات مهمة
- **عالية**: إشعارات مهمة جداً
- **عاجلة**: إشعارات عاجلة

### 4. الجدولة
- إرسال فوري
- جدولة الإرسال لوقت محدد في المستقبل

### 5. التتبع والإحصائيات
- تتبع عدد المرسل إليهم
- تتبع عدد الفاشلين
- عرض تفاصيل الأخطاء
- إحصائيات شاملة

## الملفات المضافة

### 1. قاعدة البيانات
- **Migration**: `2025_10_19_104543_create_admin_notifications_table_v2.php`
- **Permission**: `2025_10_19_104820_add_admin_notifications_permission.php`

### 2. النماذج
- **AdminNotification**: `app/Models/AdminNotification.php`

### 3. Controllers
- **AdminNotificationController**: `app/Http/Controllers/Admin/AdminNotificationController.php`

### 4. Notifications
- **AdminNotification**: `app/Notifications/AdminNotification.php`

### 5. Views
- **Index**: `resources/views/admin/notifications/index.blade.php`
- **Create**: `resources/views/admin/notifications/create.blade.php`
- **Show**: `resources/views/admin/notifications/show.blade.php`

### 6. Email Templates
- **Admin Notification**: `resources/views/emails/admin-notification.blade.php`

### 7. Routes
تم إضافة الروتات التالية في `routes/web.php`:
```php
// إدارة الإشعارات المخصصة للأدمن
Route::get('/admin/notifications/admin', [AdminNotificationController::class, 'index'])->name('admin.notifications.admin.index');
Route::get('/admin/notifications/admin/create', [AdminNotificationController::class, 'create'])->name('admin.notifications.admin.create');
Route::post('/admin/notifications/admin', [AdminNotificationController::class, 'store'])->name('admin.notifications.admin.store');
Route::get('/admin/notifications/admin/{notification}', [AdminNotificationController::class, 'show'])->name('admin.notifications.admin.show');
Route::post('/admin/notifications/admin/{notification}/send', [AdminNotificationController::class, 'send'])->name('admin.notifications.admin.send');
Route::delete('/admin/notifications/admin/{notification}', [AdminNotificationController::class, 'destroy'])->name('admin.notifications.admin.destroy');
Route::get('/admin/notifications/admin/api/users-by-type', [AdminNotificationController::class, 'getUsersByType'])->name('admin.notifications.admin.api.users-by-type');
Route::get('/admin/notifications/admin/api/stats', [AdminNotificationController::class, 'stats'])->name('admin.notifications.admin.api.stats');
```

## كيفية الاستخدام

### 1. الوصول للنظام
- تسجيل الدخول كأدمن
- الانتقال إلى "إرسال الإشعارات" في القائمة الجانبية
- يجب أن يكون لديك صلاحية `admin_notifications`

### 2. إنشاء إشعار جديد
1. اضغط على "إشعار جديد"
2. أدخل عنوان الإشعار
3. أدخل محتوى الإشعار
4. اختر نوع الإرسال (إشعار، إيميل، أو كليهما)
5. اختر المستهدفين
6. حدد الأولوية
7. اختر إرسال فوري أو جدولة
8. اضغط "إرسال الإشعار"

### 3. إدارة الإشعارات
- عرض قائمة الإشعارات مع الفلترة
- عرض تفاصيل الإشعار
- إرسال إشعارات مجدولة
- حذف الإشعارات

## التصميم والواجهة

### 1. التصميم المتجاوب
- تصميم متجاوب يعمل على جميع الأجهزة
- واجهة عربية بالكامل
- ألوان متناسقة مع هوية الموقع

### 2. التفاعلية
- معاينة فورية للإشعار
- فلترة متقدمة
- إحصائيات مباشرة
- تحديث تلقائي

### 3. سهولة الاستخدام
- واجهة بديهية
- تعليمات واضحة
- رسائل خطأ مفيدة
- تأكيدات قبل الإجراءات المهمة

## الأمان والصلاحيات

### 1. الصلاحيات
- صلاحية `admin_notifications` مطلوبة للوصول
- التحقق من الصلاحيات في جميع العمليات

### 2. التحقق من البيانات
- التحقق من صحة البيانات المدخلة
- التحقق من وجود المستخدمين المستهدفين
- التحقق من صحة محتوى الإيميل

### 3. الحماية
- حماية من CSRF
- التحقق من صحة البيانات
- تسجيل جميع العمليات

## الدعم الفني

### 1. معالجة الأخطاء
- تسجيل الأخطاء في ملفات اللوج
- رسائل خطأ واضحة للمستخدم
- إعادة المحاولة التلقائية

### 2. المراقبة
- تتبع حالة الإرسال
- إحصائيات مفصلة
- تقارير الأداء

## التطوير المستقبلي

### 1. مميزات مقترحة
- قوالب إشعارات جاهزة
- إرسال مجدول متكرر
- تحليلات متقدمة
- تكامل مع منصات التواصل الاجتماعي

### 2. التحسينات
- تحسين الأداء
- إضافة المزيد من خيارات التخصيص
- دعم المرفقات
- دعم الصور والفيديو

## الخلاصة

تم إنشاء نظام إشعارات شامل ومتقدم للأدمن يوفر:
- مرونة في اختيار المستهدفين
- أنواع متعددة من الإرسال
- جدولة متقدمة
- تتبع وإحصائيات مفصلة
- واجهة مستخدم جميلة وسهلة الاستخدام
- أمان وموثوقية عالية

النظام جاهز للاستخدام ويمكن الوصول إليه من خلال لوحة تحكم الأدمن.
