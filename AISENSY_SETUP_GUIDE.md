# دليل إعداد AiSensy - مجاني مدى الحياة

## 🎯 لماذا AiSensy؟
- ✅ **مجاني للأبد** - بدون أيام تجريبية
- ✅ **WhatsApp Business API مجاني**
- ✅ **500 روبية مجانية** للإعلانات
- ✅ **50 روبية مجانية** للمحادثات
- ✅ **Blue Tick مجاني** (قيمة 650-18000 روبية/شهر)

## 📋 خطوات التسجيل

### الخطوة 1: التسجيل
1. اذهب إلى: https://app.aisensy.com/signup
2. اضغط "Signup For FREE"
3. املأ البيانات المطلوبة
4. اضغط "Complete Signup"

### الخطوة 2: التطبيق للحصول على WhatsApp Business API
1. بعد التسجيل، ستجد زر "Apply for FREE WhatsApp Business API"
2. اضغط عليه واملأ البيانات
3. انتظر الموافقة (عادة 24-48 ساعة)

### الخطوة 3: ربط رقم الواتساب
1. بعد الموافقة، ستجد QR Code
2. افتح الواتساب على هاتفك
3. اذهب إلى: **الإعدادات** > **الأجهزة المرتبطة** > **ربط جهاز** > **مسح رمز QR**
4. امسح الرمز من لوحة التحكم

### الخطوة 4: الحصول على API Token
1. بعد ربط الهاتف، ستجد API Token في لوحة التحكم
2. انسخ هذا الرمز

### الخطوة 5: إضافة الإعدادات في ملف .env
```env
WHATSAPP_PRIMARY_NUMBER=966599476482
WHATSAPP_API_ENABLED=true
WHATSAPP_API_TOKEN=YOUR_AISENSY_TOKEN_HERE
WHATSAPP_WEB_ENABLED=true
```

## 🔧 تحديث النظام ليعمل مع AiSensy

سأقوم بتحديث النظام ليعمل مع AiSensy API:

### 1. تحديث API Endpoint
```php
// في app/Http/Controllers/Admin/WhatsAppController.php
private function sendWhatsAppMessageViaAPI($message)
{
    try {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('whatsapp.api_token', ''),
        ])->post('https://backend.aisensy.com/campaign/t1/api/v2/send', [
            'phone' => $message->to_number,
            'message' => $message->message_content
        ]);

        if ($response->successful()) {
            \Log::info('WhatsApp message sent successfully via AiSensy', [
                'message_id' => $message->message_id,
                'to' => $message->to_number,
                'response' => $response->json()
            ]);
            return true;
        } else {
            \Log::error('AiSensy API error', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return false;
        }
    } catch (\Exception $e) {
        \Log::error('AiSensy API exception: ' . $e->getMessage());
        return false;
    }
}
```

## 📊 ما تحصل عليه مجاناً في AiSensy:

### ✅ مجاني للأبد:
- **WhatsApp Business API** - بدون رسوم
- **Live Chat** - للرد على العملاء
- **رسائل خدمة غير محدودة** - للرد على العملاء
- **500 روبية مجانية** - لرصيد الإعلانات
- **50 روبية مجانية** - لمحادثات الواتساب
- **Blue Tick مجاني** - للتحقق من الحساب
- **إدارة جهات الاتصال** - مع tags و attributes

### ❌ غير متوفر في الخطة المجانية:
- **رسائل جماعية** (Broadcasting)
- **Chatbot متقدم**
- **تكاملات متقدمة**
- **دعم مكالمات**

## 🎯 ملاحظات مهمة:

1. **الرقم الأساسي**: +966 59 947 6482
2. **تنسيق الأرقام**: يجب أن تكون بصيغة دولية (مثال: 966501234567)
3. **الأمان**: لا تشارك API Token مع أي شخص
4. **الحدود**: الخطة المجانية مناسبة للاستخدام الشخصي والصغير

## 🚀 الخطوات التالية:

1. **سجل في AiSensy** الآن: https://app.aisensy.com/signup
2. **تقدم بطلب للحصول على WhatsApp Business API**
3. **اربط رقم الواتساب** (+966 59 947 6482)
4. **احصل على API Token**
5. **أضف الإعدادات** في ملف .env
6. **اختبر النظام** في صفحة الاختبار

---

**AiSensy هو الخيار الأفضل لك لأنه مجاني مدى الحياة بدون أي قيود زمنية!**