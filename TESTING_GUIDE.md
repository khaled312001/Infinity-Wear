# دليل الاختبار الشامل - Infinity Wear

## نظرة عامة

تم إنشاء نظام اختبار شامل للتأكد من عمل جميع مدخلات النموذج في موقع Infinity Wear. يتضمن النظام ملفين رئيسيين:

1. **`test_form_comprehensive.html`** - واجهة اختبار تفاعلية
2. **`test_form_integration.js`** - ملف JavaScript للاختبار في الموقع الفعلي

## الملفات المطلوبة

### 1. ملف الاختبار التفاعلي
```
test_form_comprehensive.html
```

### 2. ملف الاختبار المتكامل
```
test_form_integration.js
```

## كيفية الاستخدام

### الطريقة الأولى: الاختبار التفاعلي

1. **افتح ملف الاختبار**:
   ```bash
   # افتح الملف في المتصفح
   open test_form_comprehensive.html
   ```

2. **استخدم الواجهة**:
   - اختبار سريع: يختبر العناصر الأساسية
   - اختبار شامل: يختبر جميع الوظائف
   - اختبار إعادة التعيين: يختبر إعادة تعيين النموذج
   - اختبار خيارات التصميم: يختبر واجهة التصميم

### الطريقة الثانية: الاختبار في الموقع الفعلي

1. **افتح صفحة الموقع**:
   ```
   https://infinitywearsa.com/importers/register
   ```

2. **افتح Console**:
   ```
   F12 → Console
   ```

3. **حمّل ملف الاختبار**:
   ```javascript
   // انسخ والصق محتوى test_form_integration.js في Console
   // أو استخدم:
   fetch('test_form_integration.js').then(r => r.text()).then(eval);
   ```

4. **شغّل الاختبارات**:
   ```javascript
   // اختبارات سريعة
   runQuickTests();
   
   // اختبارات شاملة
   runAllTests();
   
   // اختبار محدد
   testForm.runTest('اسم الاختبار', دالة الاختبار);
   ```

## الاختبارات المتاحة

### 1. اختبارات أساسية
- **تحميل الصفحة**: التأكد من تحميل الصفحة بنجاح
- **هيكل النموذج**: التحقق من وجود جميع العناصر المطلوبة
- **التنقل بين المراحل**: اختبار التنقل بين المراحل الأربع

### 2. اختبارات المرحلة الأولى
- **حقل الكمية**: اختبار إدخال الكمية المطلوبة
- **خيارات التصميم**: اختبار الخيارات الثلاثة (نصي، ملف، مخصص)
- **واجهة التصميم المخصص**: اختبار الواجهة التفاعلية

### 3. اختبارات المرحلة الثانية
- **نوع النشاط**: اختبار اختيار نوع النشاط
- **معلومات الشركة**: اختبار حقول اسم الشركة والمدينة

### 4. اختبارات المرحلة الثالثة
- **المعلومات الشخصية**: اختبار حقول الاسم والبريد والهاتف

### 5. اختبارات التحقق
- **التحقق من صحة البيانات**: اختبار رسائل الخطأ
- **عرض الملخص**: اختبار عرض البيانات في المرحلة الرابعة

### 6. اختبارات الإرسال
- **إرسال النموذج**: اختبار عملية الإرسال
- **إعادة تعيين النموذج**: اختبار إعادة التعيين بعد الإرسال

## النتائج المتوقعة

### ✅ اختبارات ناجحة
```
✅ [10:30:15] نجح: تحميل الصفحة
✅ [10:30:16] نجح: هيكل النموذج
✅ [10:30:17] نجح: خيارات التصميم
```

### ❌ اختبارات فاشلة
```
❌ [10:30:15] فشل: حقل الكمية - حقل الكمية غير موجود
❌ [10:30:16] فشل: نوع النشاط - فشل في اختيار نوع النشاط
```

### ⚠️ تحذيرات
```
⚠️ [10:30:15] تحذير: واجهة التصميم المخصص - 3D Viewer غير متاح
```

## استكشاف الأخطاء

### مشاكل شائعة

#### 1. "عناصر مفقودة"
```javascript
// تحقق من وجود العنصر
const element = document.getElementById('element_id');
console.log('Element exists:', !!element);
```

#### 2. "فشل في إدخال البيانات"
```javascript
// تحقق من نوع العنصر
const element = document.getElementById('element_id');
console.log('Element type:', element.type);
console.log('Element value:', element.value);
```

#### 3. "واجهة التصميم لم تظهر"
```javascript
// تحقق من خيار التصميم المخصص
const customOption = document.querySelector('input[value="custom"]');
console.log('Custom option checked:', customOption.checked);

// تحقق من واجهة التصميم
const customInterface = document.querySelector('.custom-design-interface');
console.log('Custom interface visible:', customInterface.style.display !== 'none');
```

### أدوات التشخيص

#### 1. فحص العناصر
```javascript
// فحص جميع المدخلات
testForm.runTest('فحص المدخلات', async () => {
    const inputs = document.querySelectorAll('input, select, textarea');
    console.log('Total inputs:', inputs.length);
    inputs.forEach((input, index) => {
        console.log(`Input ${index + 1}:`, {
            id: input.id,
            name: input.name,
            type: input.type,
            value: input.value,
            required: input.hasAttribute('required')
        });
    });
    return { success: true, error: null };
});
```

#### 2. فحص الأحداث
```javascript
// فحص مستمعي الأحداث
testForm.runTest('فحص الأحداث', async () => {
    const form = document.getElementById('registrationForm');
    if (form) {
        console.log('Form event listeners:', getEventListeners(form));
    }
    return { success: true, error: null };
});
```

## تخصيص الاختبارات

### إضافة اختبار جديد
```javascript
// إضافة اختبار مخصص
testForm.runTest('اختبار مخصص', async () => {
    // كود الاختبار هنا
    const result = await someTestFunction();
    return { success: result, error: result ? null : 'خطأ في الاختبار' };
});
```

### تعديل إعدادات الاختبار
```javascript
// تعديل الإعدادات
testForm.config.timeout = 15000; // زيادة المهلة الزمنية
testForm.config.debug = true;    // تفعيل وضع التصحيح
```

## التقارير

### تقرير HTML
```javascript
// إنشاء تقرير HTML
function generateHTMLReport() {
    const report = `
    <h2>تقرير الاختبار</h2>
    <p>إجمالي الاختبارات: ${testForm.results.total}</p>
    <p>نجح: ${testForm.results.passed}</p>
    <p>فشل: ${testForm.results.failed}</p>
    <p>تخطي: ${testForm.results.skipped}</p>
    `;
    
    const newWindow = window.open();
    newWindow.document.write(report);
}
```

### تقرير JSON
```javascript
// تصدير النتائج كـ JSON
function exportResults() {
    const dataStr = JSON.stringify(testForm.results, null, 2);
    const dataBlob = new Blob([dataStr], {type: 'application/json'});
    
    const link = document.createElement('a');
    link.href = URL.createObjectURL(dataBlob);
    link.download = 'test-results.json';
    link.click();
}
```

## الدعم

### في حالة وجود مشاكل
1. تحقق من Console للأخطاء
2. استخدم أدوات التشخيص
3. راجع دليل استكشاف الأخطاء
4. تأكد من تحديث الملفات

### الاتصال
- البريد الإلكتروني: support@infinitywearsa.com
- الهاتف: +966 50 123 4567

---

**ملاحظة**: تأكد من تشغيل الاختبارات في بيئة آمنة ولا تستخدم بيانات حقيقية في الاختبار.
