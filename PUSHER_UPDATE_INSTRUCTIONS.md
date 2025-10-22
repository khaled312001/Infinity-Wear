# تعليمات تحديث إعدادات Pusher

## 🔧 التحديثات المطلوبة

استبدل إعدادات Pusher في ملف `.env`:

### من:
```env
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

### إلى:
```env
# Pusher Push Notifications Configuration
PUSHER_APP_ID=6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186
PUSHER_APP_KEY=6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186
PUSHER_APP_SECRET=766DDD7303E1AB7AD5BC490099FCE12A0E16B78D09E4E2AA39CBD3C20F331E12
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

# Pusher Beams Configuration
PUSHER_BEAMS_INSTANCE_ID=6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186
PUSHER_BEAMS_SECRET_KEY=766DDD7303E1AB7AD5BC490099FCE12A0E16B78D09E4E2AA39CBD3C20F331E12

VITE_APP_NAME="Infinity Wear"
VITE_PUSHER_APP_KEY="6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186"
VITE_PUSHER_HOST=""
VITE_PUSHER_PORT="443"
VITE_PUSHER_SCHEME="https"
VITE_PUSHER_APP_CLUSTER="mt1"
VITE_PUSHER_BEAMS_INSTANCE_ID="6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186"
```

## 📄 ملف .env المحدث كاملاً

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

# Pusher Push Notifications Configuration
PUSHER_APP_ID=6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186
PUSHER_APP_KEY=6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186
PUSHER_APP_SECRET=766DDD7303E1AB7AD5BC490099FCE12A0E16B78D09E4E2AA39CBD3C20F331E12
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

# Pusher Beams Configuration
PUSHER_BEAMS_INSTANCE_ID=6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186
PUSHER_BEAMS_SECRET_KEY=766DDD7303E1AB7AD5BC490099FCE12A0E16B78D09E4E2AA39CBD3C20F331E12

VITE_APP_NAME="Infinity Wear"
VITE_PUSHER_APP_KEY="6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186"
VITE_PUSHER_HOST=""
VITE_PUSHER_PORT="443"
VITE_PUSHER_SCHEME="https"
VITE_PUSHER_APP_CLUSTER="mt1"
VITE_PUSHER_BEAMS_INSTANCE_ID="6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186"
```

## 🚀 خطوات التحديث

1. **انسخ المحتوى أعلاه**
2. **استبدل محتوى ملف `.env` الحالي**
3. **احفظ الملف**
4. **امسح الـ cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   ```

## ✅ اختبار النظام

بعد التحديث، اختبر النظام من:
- **صفحة اختبار الإشعارات:** `https://infinitywearsa.com/notification-test`
- **صفحة اختبار الإيميل:** `https://infinitywearsa.com/email-test`

## 🔔 إعدادات Pusher المحدثة

- **Instance ID:** `6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186`
- **Secret Key:** `766DDD7303E1AB7AD5BC490099FCE12A0E16B78D09E4E2AA39CBD3C20F331E12`
- **App Key:** `6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186`
- **Cluster:** `mt1`

## 📱 الميزات المتاحة

- ✅ إشعارات فورية مباشرة في المتصفح
- ✅ إشعارات متعددة المجموعات
- ✅ إشعارات تلقائية لجميع الأحداث
- ✅ واجهة اختبار شاملة

---

**جاهز للاستخدام الفوري!** 🚀




