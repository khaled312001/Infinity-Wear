# دليل إعداد Cloudinary لرفع الشعار والأيقونة

## الخطوة 1: إنشاء حساب Cloudinary

1. اذهب إلى [cloudinary.com](https://cloudinary.com)
2. أنشئ حساب جديد أو سجل الدخول إلى حسابك الموجود
3. بعد تسجيل الدخول، ستجد معلومات حسابك في Dashboard

## الخطوة 2: الحصول على معلومات الحساب

من Dashboard الخاص بك، ستحتاج إلى:

- **Cloud Name**: اسم السحابة الخاص بك (مثل: `mycompany`)
- **API Key**: مفتاح API
- **API Secret**: سر API

## الخطوة 3: تحديث ملف .env

أضف المعلومات التالية إلى ملف `.env`:

```env
CLOUDINARY_CLOUD_NAME=your_actual_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
CLOUDINARY_SECURE=true
```

## الخطوة 4: مسح الكاش

```bash
php artisan config:clear
php artisan config:cache
```

## الخطوة 5: اختبار النظام

بعد إعداد المعلومات الصحيحة، يمكنك اختبار النظام من خلال:

1. الذهاب إلى صفحة الإعدادات: `https://infinitywearsa.com/admin/settings`
2. رفع شعار جديد أو أيقونة جديدة
3. ستظهر رسالة نجاح مع معلومات Cloudinary

## الميزات الجديدة

### للشعار:
- ✅ رفع إلى Cloudinary مع نسخة احتياطية محلية
- ✅ عرض معلومات مفصلة (الأبعاد، الحجم، الصيغة)
- ✅ حذف من السحابة والمحلي
- ✅ معاينة محسنة

### للأيقونة:
- ✅ رفع إلى Cloudinary مع نسخة احتياطية محلية
- ✅ عرض معلومات مفصلة
- ✅ حذف من السحابة والمحلي
- ✅ معاينة محسنة

## استكشاف الأخطاء

إذا واجهت مشاكل:

1. **خطأ "Invalid cloud_name"**: تأكد من أن Cloud Name صحيح
2. **خطأ في الرفع**: تأكد من صحة API Key و API Secret
3. **مشاكل في العرض**: تأكد من مسح الكاش

## الدعم

إذا كنت بحاجة إلى مساعدة، يمكنك:
- مراجعة [وثائق Cloudinary](https://cloudinary.com/documentation)
- التواصل مع فريق الدعم الفني
