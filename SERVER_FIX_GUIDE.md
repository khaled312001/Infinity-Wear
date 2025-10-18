# دليل إصلاح مشاكل الصور والملفات الثابتة على الخادم

## المشكلة
- الصور والملفات الثابتة (JS, CSS, SVG) لا تظهر على الموقع المباشر
- الملفات تعمل محلياً ولكن لا تعمل على الاستضافة
- أخطاء 404 للملفات الثابتة

## الحلول المطلوبة

### 1. التحقق من صلاحيات الملفات
```bash
# في SSH على الخادم
cd domains/infinitywearsa.com/public_html
chmod -R 755 public/
chmod -R 755 storage/
chmod 644 public/.htaccess
```

### 2. التحقق من ملف .htaccess
تأكد من وجود ملف .htaccess في مجلد public/ بالمحتوى الصحيح:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On
    
    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Handle storage files (backup for symlink issues)
    RewriteCond %{REQUEST_URI} ^/storage/(.*)$
    RewriteCond %{DOCUMENT_ROOT}/../storage/app/public/%1 -f
    RewriteRule ^storage/(.*)$ /../storage/app/public/$1 [L]
    
    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### 3. إنشاء symlink للتخزين
```bash
# في SSH على الخادم
cd domains/infinitywearsa.com/public_html
ln -sf ../storage/app/public public/storage
```

### 4. التحقق من إعدادات Laravel
```bash
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

### 5. التحقق من ملف .env
تأكد من وجود ملف .env بالمحتوى الصحيح:

```env
APP_NAME="Infinity Wear"
APP_ENV=production
APP_KEY=base64:YourAppKeyHere
APP_DEBUG=false
APP_URL=https://infinitywearsa.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u790947786_infinity
DB_USERNAME=u790947786_infinity
DB_PASSWORD=your_password

# باقي الإعدادات...
```

### 6. إصلاح مشكلة MIME Types
إنشاء ملف .htaccess إضافي في المجلد الجذر:

```apache
# في domains/infinitywearsa.com/public_html/.htaccess
<IfModule mod_mime.c>
    AddType application/javascript .js
    AddType text/css .css
    AddType image/svg+xml .svg
    AddType application/manifest+json .webmanifest
</IfModule>

# منع الوصول للملفات الحساسة
<Files ".env">
    Order allow,deny
    Deny from all
</Files>

<Files "composer.json">
    Order allow,deny
    Deny from all
</Files>

<Files "composer.lock">
    Order allow,deny
    Deny from all
</Files>
```

### 7. التحقق من إعدادات Apache
تأكد من تفعيل mod_rewrite في Apache:

```bash
# التحقق من تفعيل mod_rewrite
apache2ctl -M | grep rewrite
```

### 8. اختبار الملفات
```bash
# اختبار وصول الملفات
curl -I https://infinitywearsa.com/logo.svg
curl -I https://infinitywearsa.com/js/infinity-home.js
curl -I https://infinitywearsa.com/css/infinity-home.css
```

## خطوات التنفيذ على الخادم

### الخطوة 1: الاتصال بالخادم
```bash
ssh -p 65002 u790947786@82.25.113.20
cd domains/infinitywearsa.com/public_html
```

### الخطوة 2: إصلاح الصلاحيات
```bash
chmod -R 755 public/
chmod -R 755 storage/
chmod 644 public/.htaccess
chmod 644 .htaccess
```

### الخطوة 3: إنشاء symlink
```bash
ln -sf ../storage/app/public public/storage
```

### الخطوة 4: تنظيف الكاش
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
```

### الخطوة 5: اختبار الموقع
```bash
curl -I https://infinitywearsa.com/logo.svg
```

## نصائح إضافية

1. **تأكد من أن Document Root يشير إلى مجلد public/**
2. **تحقق من إعدادات PHP في cPanel**
3. **تأكد من تفعيل mod_rewrite**
4. **تحقق من إعدادات MySQL**

## إذا لم تعمل الحلول

1. تحقق من logs الأخطاء:
```bash
tail -f storage/logs/laravel.log
```

2. تحقق من logs Apache:
```bash
tail -f /var/log/apache2/error.log
```

3. اتصل بدعم الاستضافة لتفعيل mod_rewrite
