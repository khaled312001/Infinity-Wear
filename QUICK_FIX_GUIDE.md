# دليل الإصلاح السريع - مشاكل الصور والملفات الثابتة

## المشكلة
الصور والملفات الثابتة لا تظهر على الموقع المباشر (infinitywearsa.com)

## الحل السريع

### 1. رفع الملفات المحدثة
```bash
# في SSH على الخادم
cd domains/infinitywearsa.com/public_html
git pull origin main
```

### 2. تنفيذ الأوامر التالية
```bash
# إصلاح الصلاحيات
chmod -R 755 public/
chmod -R 755 storage/
chmod 644 public/.htaccess
chmod 644 .htaccess

# إنشاء symlink
ln -sf ../storage/app/public public/storage

# تنظيف الكاش
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# إعادة إنشاء الكاش
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. اختبار الموقع
```bash
# اختبار الملفات
curl -I https://infinitywearsa.com/logo.svg
curl -I https://infinitywearsa.com/js/infinity-home.js
curl -I https://infinitywearsa.com/css/infinity-home.css
```

### 4. اختبار شامل
افتح في المتصفح:
```
https://infinitywearsa.com/test-server.php
```

## إذا لم تعمل الحلول

### تحقق من إعدادات cPanel:
1. **Apache Modules**: تأكد من تفعيل mod_rewrite
2. **PHP Settings**: تأكد من إعدادات PHP صحيحة
3. **File Manager**: تحقق من وجود الملفات في المجلدات الصحيحة

### تحقق من Document Root:
يجب أن يشير Document Root إلى مجلد `public_html/public/` وليس `public_html/`

### تحقق من ملف .env:
تأكد من وجود ملف .env مع الإعدادات الصحيحة:
```env
APP_URL=https://infinitywearsa.com
APP_ENV=production
APP_DEBUG=false
```

## نصائح مهمة

1. **احتفظ بنسخة احتياطية** قبل إجراء أي تغييرات
2. **تحقق من logs الأخطاء** في cPanel
3. **اتصل بدعم الاستضافة** إذا لم تعمل الحلول
4. **اختبر الموقع** بعد كل خطوة

## الملفات المطلوب رفعها

1. `public/.htaccess` - إعدادات Apache للمجلد العام
2. `.htaccess` - إعدادات Apache للمجلد الجذر
3. `public/test-server.php` - سكريبت اختبار الخادم
4. `fix_server_issues.sh` - سكريبت الإصلاح التلقائي

## تنفيذ السكريبت التلقائي

```bash
# جعل السكريبت قابل للتنفيذ
chmod +x fix_server_issues.sh

# تنفيذ السكريبت
./fix_server_issues.sh
```
