# نظام Trello للمهام - Infinity Wear

## نظرة عامة
تم إنشاء نظام Trello جديد ومحسن لإدارة المهام لفريق التسويق وفريق المبيعات. النظام يوفر تجربة سحب وإفلات سلسة مع تصميم عصري وجذاب.

## الميزات الجديدة

### 🎨 التصميم
- **تصميم عصري**: خلفية متدرجة جميلة مع تأثيرات الزجاج
- **3 أعمدة**: معلقة، قيد التنفيذ، مكتملة
- **بطاقات تفاعلية**: تأثيرات hover وانتقالات سلسة
- **تصميم متجاوب**: يعمل بشكل مثالي على جميع الأجهزة

### 🖱️ السحب والإفلات
- **سحب سهل**: اسحب البطاقات من أي مكان عليها
- **إفلات ذكي**: إفلات في أي عمود لتغيير الحالة
- **تحديث فوري**: تحديث الحالة عبر AJAX بدون إعادة تحميل
- **تأثيرات بصرية**: رسائل تأكيد وإشعارات

### 📊 الإحصائيات
- **عدادات ديناميكية**: تحديث تلقائي لعدد المهام في كل عمود
- **بطاقات إحصائية**: عرض إجمالي المهام وحالاتها
- **أيقونات ملونة**: تمييز بصري لكل نوع من المهام

## الملفات الجديدة

### 1. صفحات العرض
- `resources/views/marketing/tasks/index.blade.php` - صفحة مهام التسويق
- `resources/views/sales/tasks/index.blade.php` - صفحة مهام المبيعات

### 2. ملفات JavaScript
- `public/js/trello-drag-drop.js` - نظام السحب والإفلات

### 3. ملفات CSS
- `public/css/trello-board.css` - أنماط لوحة Trello

## كيفية الاستخدام

### للمطورين
```javascript
// تهيئة نظام Trello
const trello = new TrelloDragDrop({
    updateUrl: '/marketing/tasks/{taskId}/status',
    onStatusUpdate: function(taskId, newStatus, data) {
        console.log('تم تحديث المهمة:', taskId, newStatus);
    },
    onError: function(error) {
        console.error('خطأ:', error);
    }
});
```

### للمستخدمين
1. **عرض المهام**: المهام تظهر في الأعمدة حسب حالتها
2. **سحب المهام**: اضغط واسحب أي مهمة لتحريكها
3. **تغيير الحالة**: أفلت المهمة في العمود المطلوب
4. **عرض التفاصيل**: اضغط على أيقونة النقاط الثلاث لعرض التفاصيل

## المسارات المطلوبة

### التسويق
- `GET /marketing/tasks` - عرض صفحة المهام
- `PUT /marketing/tasks/{task}/status` - تحديث حالة المهمة

### المبيعات
- `GET /sales/tasks` - عرض صفحة المهام
- `PUT /sales/tasks/{task}/status` - تحديث حالة المهمة

## المتطلبات التقنية

### Frontend
- Bootstrap 5
- Font Awesome
- HTML5 Drag and Drop API
- CSS3 (Flexbox, Grid, Animations)

### Backend
- Laravel Framework
- CSRF Protection
- JSON API Responses

## التخصيص

### تغيير الألوان
```css
.trello-board {
    background: linear-gradient(135deg, #your-color-1, #your-color-2);
}
```

### إضافة أعمدة جديدة
```html
<div class="col-lg-4">
    <div class="trello-column" data-status="new-status">
        <!-- محتوى العمود -->
    </div>
</div>
```

### تخصيص الرسائل
```javascript
const trello = new TrelloDragDrop({
    onStatusUpdate: function(taskId, newStatus, data) {
        // رسالة مخصصة
        showCustomMessage('تم تحديث المهمة بنجاح!');
    }
});
```

## استكشاف الأخطاء

### مشاكل شائعة
1. **لا يعمل السحب**: تأكد من تحميل ملف JavaScript
2. **لا يتم التحديث**: تحقق من CSRF token
3. **مشاكل التصميم**: تأكد من تحميل ملف CSS

### رسائل الخطأ
- `CSRF token not found` - مشكلة في الأمان
- `HTTP error! status: 404` - مسار غير موجود
- `Update failed` - فشل في تحديث قاعدة البيانات

## الدعم

للحصول على الدعم أو الإبلاغ عن مشاكل:
1. تحقق من Console في المتصفح
2. راجع ملفات Log في Laravel
3. تأكد من صحة المسارات والصلاحيات

## التحديثات المستقبلية

### ميزات مخططة
- [ ] إضافة مهام جديدة من الواجهة
- [ ] فلترة المهام حسب الأولوية
- [ ] إشعارات فورية
- [ ] تصدير التقارير
- [ ] دعم المرفقات
- [ ] تعليقات على المهام

---

**تم إنشاؤه بواسطة**: فريق تطوير Infinity Wear  
**تاريخ الإنشاء**: {{ date('Y-m-d') }}  
**الإصدار**: 1.0.0
