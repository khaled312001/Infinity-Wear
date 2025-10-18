# تعليمات تحديث الخادم المباشر

## الملفات المطلوب رفعها:

### 1. ملفات Migration الجديدة:
```
database/migrations/2025_10_18_184847_fix_department_column_in_tasks_table.php
database/migrations/2025_10_18_184909_fix_remaining_columns_in_tasks_table.php
```

### 2. ملفات Controller المحدثة (مع إصلاح مشكلة Authentication):
```
app/Http/Controllers/Admin/TaskManagementController.php
app/Http/Controllers/Marketing/TaskController.php
app/Http/Controllers/Sales/TaskController.php
```

**ملاحظة مهمة:** تم إصلاح مشكلة `created_by` التي كانت تسبب خطأ `Column 'created_by' cannot be null`

### 3. ملفات Middleware المحدثة:
```
app/Http/Middleware/CheckUserTypePermission.php
app/Http/Middleware/CheckAdminAuth.php
```

### 4. ملفات JavaScript المحدثة:
```
public/js/task-management.js
```

### 5. ملفات التكوين المحدثة:
```
config/app.php
resources/lang/ar/validation.php
```

## الأوامر المطلوب تنفيذها على الخادم:

```bash
# 1. رفع جميع الملفات أعلاه إلى الخادم

# 2. تطبيق migrations الجديدة
php artisan migrate

# 3. مسح جميع الـ caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 4. إعادة تحميل الخادم (إذا لزم الأمر)
# sudo systemctl reload nginx
# sudo systemctl reload php8.1-fpm
```

## التحقق من النجاح:

1. جرب إنشاء مهمة جديدة من لوحة الإدارة
2. تحقق من عدم ظهور خطأ 500
3. تأكد من ظهور رسالة نجاح

## إذا استمر الخطأ:

تحقق من ملف السجلات:
```bash
tail -f storage/logs/laravel.log
```

وستجد تفاصيل الخطأ الدقيقة في السجلات.
