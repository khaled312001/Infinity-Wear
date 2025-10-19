# تعليمات نسخ الإعدادات إلى ملف .env

## 📋 الخطوات المطلوبة

### 1. افتح ملف `.env` الحالي
```bash
nano .env
# أو
notepad .env
# أو أي محرر نصوص آخر
```

### 2. استبدل المحتوى كاملاً
انسخ المحتوى من ملف `env_complete.txt` واستبدل به محتوى ملف `.env` الحالي.

### 3. احفظ الملف
احفظ الملف بعد النسخ.

### 4. مسح الـ Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

## 📄 محتوى ملف .env الكامل

```env
APP_NAME=Infinity-Wear
APP_ENV=production
APP_KEY=base64:tBH1f6j6dVHAfgToZTUR3G8qhYg2upCIEyKx51dfER8=
APP_DEBUG=false
APP_URL=https://infinitywearsa.com/

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=auth-db2000.hstgr.io
DB_PORT=3306
DB_DATABASE=u790947786_infinitywearsa
DB_USERNAME=u790947786_infinitywearsa
DB_PASSWORD=support@Passord123

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Email Configuration - Hostinger Official
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@infinitywearsa.com
MAIL_PASSWORD="Info2025#*"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@infinitywearsa.com
MAIL_FROM_NAME="Infinity Wear"

# Admin Email
MAIL_ADMIN_EMAIL=info@infinitywearsa.com

# IMAP Configuration for receiving emails
MAIL_IMAP_HOST=imap.hostinger.com
MAIL_IMAP_PORT=993
MAIL_IMAP_ENCRYPTION=ssl

# POP Configuration
MAIL_POP_HOST=pop.hostinger.com
MAIL_POP_PORT=995
MAIL_POP_ENCRYPTION=ssl

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="Infinity Wear"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

## ✅ التحقق من التحديث

### 1. اختبار الإعدادات
```bash
php artisan config:show mail
```

### 2. اختبار الإيميل
- اذهب إلى: `https://infinitywearsa.com/email-test`
- اختبر جميع أنواع الإيميلات

### 3. اختبار نموذج التواصل
- اذهب إلى: `https://infinitywearsa.com/contact`
- أرسل رسالة تجريبية

## 🎯 النتيجة المتوقعة

بعد التحديث ستحصل على:
- ✅ إيميلات تلقائية من `info@infinitywearsa.com`
- ✅ إشعارات فورية لجميع الأحداث
- ✅ نظام إيميل احترافي ومتكامل
- ✅ واجهة اختبار شاملة

## 📞 الدعم

إذا واجهت أي مشاكل:
1. تأكد من نسخ المحتوى كاملاً
2. تحقق من حفظ الملف
3. امسح الـ cache
4. اختبر النظام من صفحة الاختبار

---

**جاهز للاستخدام الفوري!** 🚀
