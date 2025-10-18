#!/bin/bash

# سكريبت إصلاح مشاكل الخادم
echo "بدء إصلاح مشاكل الخادم..."

# الانتقال إلى مجلد المشروع
cd domains/infinitywearsa.com/public_html

echo "1. إصلاح صلاحيات الملفات..."
chmod -R 755 public/
chmod -R 755 storage/
chmod 644 public/.htaccess
chmod 644 .htaccess

echo "2. إنشاء symlink للتخزين..."
ln -sf ../storage/app/public public/storage

echo "3. تنظيف كاش Laravel..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "4. إعادة إنشاء الكاش..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "5. اختبار الملفات..."
echo "اختبار logo.svg:"
curl -I https://infinitywearsa.com/logo.svg

echo "اختبار infinity-home.js:"
curl -I https://infinitywearsa.com/js/infinity-home.js

echo "اختبار infinity-home.css:"
curl -I https://infinitywearsa.com/css/infinity-home.css

echo "تم الانتهاء من الإصلاح!"
