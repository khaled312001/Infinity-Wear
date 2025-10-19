# دليل التحديث السريع - نظام الإيميل

## 🚀 تحديث فوري لملف .env

### الخطوة 1: تحديث إعدادات الإيميل
استبدل هذه الأسطر في ملف `.env`:

```env
# من هذا:
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME=""

# إلى هذا:
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@infinitywearsa.com
MAIL_PASSWORD="Info2025#*"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@infinitywearsa.com
MAIL_FROM_NAME="Infinity Wear"

# إضافة هذه الأسطر الجديدة:
MAIL_ADMIN_EMAIL=info@infinitywearsa.com
MAIL_IMAP_HOST=imap.hostinger.com
MAIL_IMAP_PORT=993
MAIL_IMAP_ENCRYPTION=ssl
MAIL_POP_HOST=pop.hostinger.com
MAIL_POP_PORT=995
MAIL_POP_ENCRYPTION=ssl
```

### الخطوة 2: تحديث البيئة
```env
APP_ENV=production
APP_DEBUG=false
VITE_APP_NAME="Infinity Wear"
```

### الخطوة 3: مسح الـ Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

## ✅ اختبار النظام

### 1. صفحة الاختبار
```
https://infinitywearsa.com/email-test
```

### 2. نموذج التواصل
```
https://infinitywearsa.com/contact
```

## 📧 الإيميل الرسمي

- **الإيميل:** `info@infinitywearsa.com`
- **كلمة المرور:** `Info2025#*`
- **الخادم:** Hostinger
- **الحالة:** ✅ جاهز للاستخدام

## 🔧 الملفات المهمة

- `config/mail.php` - إعدادات محدثة
- `app/Services/EmailService.php` - خدمة الإيميل
- `resources/views/email-test.blade.php` - صفحة الاختبار
- `UPDATE_ENV_INSTRUCTIONS.md` - تعليمات مفصلة

## 🎯 النتيجة المتوقعة

بعد التحديث ستحصل على:
- ✅ إيميلات تلقائية من `info@infinitywearsa.com`
- ✅ إشعارات فورية لجميع الأحداث
- ✅ نظام إيميل احترافي ومتكامل
- ✅ واجهة اختبار شاملة

---

**جاهز للاستخدام الفوري!** 🚀
