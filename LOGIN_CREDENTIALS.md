# معلومات تسجيل الدخول - Infinity Wear

## حسابات تسجيل الدخول لكل نوع مستخدم

### 1. المدير (Admin)
- **الرابط**: `https://infinitywearsa.com/admin/login`
- **البريد الإلكتروني**: `admin@infinitywear.sa`
- **كلمة المرور**: `password123`

### 2. المستورد (Importer)
- **الرابط**: `https://infinitywearsa.com/login`
- **البريد الإلكتروني**: `importer@infinitywear.sa`
- **كلمة المرور**: `importer123`

### 3. فريق المبيعات (Sales)
- **الرابط**: `https://infinitywearsa.com/sales/login`
- **البريد الإلكتروني**: `sales@infinitywear.sa`
- **كلمة المرور**: `sales123`

### 4. فريق التسويق (Marketing)
- **الرابط**: `https://infinitywearsa.com/marketing/login`
- **البريد الإلكتروني**: `marketing@infinitywear.sa`
- **كلمة المرور**: `marketing123`

---

## الأوامر المتاحة

### لإنشاء/تحديث جميع المستخدمين:
```bash
php artisan db:seed --class=AllUsersLoginSeeder --force
```

### لاختبار تسجيل الدخول:
```bash
php artisan users:test-all-login
```

---

## ملاحظات

- جميع الحسابات نشطة ومفعّلة
- جميع كلمات المرور تم تشفيرها بشكل صحيح
- المستورد لديه سجل في جدول `importers`
- المدير موجود في جدول `admins` و `users`

