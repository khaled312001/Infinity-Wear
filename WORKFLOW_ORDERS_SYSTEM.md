# نظام إدارة الطلبات (Workflow Orders System)

## نظرة عامة

تم إنشاء نظام شامل لإدارة الطلبات مع 10 مراحل مترابطة:

1. **التسويق** (Marketing)
2. **المبيعات** (Sales)
3. **التصميم** (Design)
4. **العينة الأولى** (First Sample)
5. **اعتماد الشغل** (Work Approval)
6. **التصنيع** (Manufacturing)
7. **الشحن** (Shipping)
8. **استلام وتسليم** (Receipt & Delivery)
9. **التحصيل** (Collection)
10. **خدمة ما بعد البيع** (After Sales)

## الملفات المُنشأة

### 1. قاعدة البيانات

#### Migration
- `database/migrations/2025_11_19_142011_create_workflow_orders_table.php`
  - جدول `workflow_orders`: يحتوي على جميع بيانات الطلب ومراحله
  - جدول `workflow_order_stages`: لتتبع تفاصيل كل مرحلة

#### Models
- `app/Models/WorkflowOrder.php`: النموذج الرئيسي للطلبات
- `app/Models/WorkflowOrderStage.php`: نموذج مراحل الطلب

### 2. Controllers

- `app/Http/Controllers/WorkflowOrderController.php`: Controller عام لتتبع الطلبات
- `app/Http/Controllers/Admin/WorkflowOrderController.php`: إدارة الطلبات للمدير
- `app/Http/Controllers/Marketing/WorkflowOrderController.php`: إدارة طلبات التسويق
- `app/Http/Controllers/Sales/WorkflowOrderController.php`: إدارة طلبات المبيعات
- `app/Http/Controllers/Importer/WorkflowOrderController.php`: عرض طلبات المستورد

### 3. Routes

تم إضافة Routes في `routes/web.php`:

#### Routes عامة (للعملاء)
- `GET /track-order`: صفحة تتبع الطلب
- `GET /order/{orderNumber}`: عرض تفاصيل الطلب

#### Routes للمدير
- `GET /admin/workflow-orders`: قائمة الطلبات
- `GET /admin/workflow-orders/create`: إنشاء طلب جديد
- `POST /admin/workflow-orders`: حفظ الطلب
- `GET /admin/workflow-orders/{id}`: عرض تفاصيل الطلب
- `PUT /admin/workflow-orders/{id}`: تحديث الطلب
- `DELETE /admin/workflow-orders/{id}`: حذف الطلب
- `POST /admin/workflow-orders/{id}/update-stage`: تحديث حالة المرحلة

#### Routes للتسويق
- `GET /marketing/workflow-orders`: قائمة طلبات التسويق
- `GET /marketing/workflow-orders/{id}`: عرض تفاصيل الطلب
- `POST /marketing/workflow-orders/{id}/update-stage`: تحديث حالة مرحلة التسويق

#### Routes للمبيعات
- `GET /sales/workflow-orders`: قائمة طلبات المبيعات
- `GET /sales/workflow-orders/{id}`: عرض تفاصيل الطلب
- `POST /sales/workflow-orders/{id}/update-stage`: تحديث حالة مرحلة المبيعات

#### Routes للمستورد
- `GET /importers/workflow-orders`: قائمة طلبات المستورد
- `GET /importers/workflow-orders/{id}`: عرض تفاصيل الطلب

## الميزات الرئيسية

### 1. تتبع المراحل
- كل مرحلة لها حالة منفصلة (pending, in_progress, completed, rejected)
- تتبع تواريخ البدء والانتهاء لكل مرحلة
- تعيين مستخدم لكل مرحلة

### 2. التكامل بين المستخدمين
- كل نوع مستخدم يرى فقط الطلبات المتعلقة به
- المدير يرى جميع الطلبات ويمكنه إدارتها بالكامل
- التسويق يبدأ العملية
- المبيعات تأخذ الطلب بعد التسويق
- المستورد يتابع طلباته فقط

### 3. تتبع للعملاء
- يمكن للعميل تتبع طلبه باستخدام رقم الطلب
- عرض جميع المراحل وحالتها

## الخطوات التالية المطلوبة

### 1. تشغيل Migration
```bash
php artisan migrate
```

### 2. إنشاء Views

يجب إنشاء الملفات التالية:

#### للمدير
- `resources/views/admin/workflow-orders/index.blade.php`: قائمة الطلبات
- `resources/views/admin/workflow-orders/create.blade.php`: إنشاء طلب جديد
- `resources/views/admin/workflow-orders/show.blade.php`: عرض تفاصيل الطلب

#### للتسويق
- `resources/views/marketing/workflow-orders/index.blade.php`: قائمة طلبات التسويق
- `resources/views/marketing/workflow-orders/show.blade.php`: عرض تفاصيل الطلب

#### للمبيعات
- `resources/views/sales/workflow-orders/index.blade.php`: قائمة طلبات المبيعات
- `resources/views/sales/workflow-orders/show.blade.php`: عرض تفاصيل الطلب

#### للمستورد
- `resources/views/importer/workflow-orders/index.blade.php`: قائمة طلبات المستورد
- `resources/views/importer/workflow-orders/show.blade.php`: عرض تفاصيل الطلب

#### للعملاء (عام)
- `resources/views/workflow-orders/track.blade.php`: صفحة تتبع الطلب
- `resources/views/workflow-orders/show.blade.php`: عرض تفاصيل الطلب للعميل

### 3. تحديث Sidebars

يجب إضافة روابط للطلبات في:

- `resources/views/partials/dynamic-sidebar.blade.php` (للمدير)
- `resources/views/partials/marketing-sidebar.blade.php` (للتسويق)
- `resources/views/partials/sales-sidebar.blade.php` (للمبيعات)
- `resources/views/partials/importer-sidebar.blade.php` (للمستورد)

مثال:
```blade
<li class="nav-item">
    <a class="nav-link" href="{{ route('admin.workflow-orders.index') }}">
        <i class="fas fa-shopping-cart"></i>
        <span>الطلبات</span>
    </a>
</li>
```

### 4. إضافة Controllers للمراحل الأخرى

يحتاج النظام إلى Controllers إضافية للمراحل الأخرى:
- Design (التصميم)
- First Sample (العينة الأولى)
- Work Approval (اعتماد الشغل)
- Manufacturing (التصنيع)
- Shipping (الشحن)
- Receipt & Delivery (استلام وتسليم)
- Collection (التحصيل)
- After Sales (خدمة ما بعد البيع)

أو يمكن دمجها في Controller واحد مع فلترة حسب نوع المستخدم.

## استخدام النظام

### إنشاء طلب جديد (المدير)
1. الذهاب إلى `/admin/workflow-orders/create`
2. ملء بيانات العميل والطلب
3. اختيار مستخدم التسويق
4. حفظ الطلب

### معالجة الطلب (التسويق)
1. الذهاب إلى `/marketing/workflow-orders`
2. اختيار طلب
3. تحديث حالة المرحلة إلى `in_progress`
4. بعد الانتهاء، تحديث الحالة إلى `completed`

### معالجة الطلب (المبيعات)
1. بعد إكمال مرحلة التسويق، يظهر الطلب في قائمة المبيعات
2. تحديث حالة مرحلة المبيعات
3. بعد الإكمال، ينتقل الطلب للمرحلة التالية

### تتبع الطلب (العميل)
1. الذهاب إلى `/track-order`
2. إدخال رقم الطلب
3. عرض جميع المراحل وحالتها

## ملاحظات مهمة

1. **الأمان**: تأكد من إضافة Middleware للصلاحيات المناسبة
2. **الإشعارات**: يمكن إضافة نظام إشعارات عند تغيير حالة المرحلة
3. **التقارير**: يمكن إضافة تقارير عن أداء كل مرحلة
4. **الملفات**: يمكن إضافة رفع ملفات لكل مرحلة (مثل صور التصميم، العينات، إلخ)

## البنية التقنية

### الجداول
- `workflow_orders`: جدول رئيسي يحتوي على جميع بيانات الطلب
- `workflow_order_stages`: جدول تفصيلي لتتبع كل مرحلة

### العلاقات
- WorkflowOrder belongsTo Importer
- WorkflowOrder belongsTo User (customer)
- WorkflowOrder hasMany WorkflowOrderStage
- WorkflowOrder belongsTo User (لكل مرحلة - marketing_user, sales_user, etc.)

### الحالات
- `pending`: في الانتظار
- `in_progress`: قيد التنفيذ
- `completed`: مكتمل
- `rejected`: مرفوض
- `approved`: معتمد (لمرحلة اعتماد الشغل فقط)

## الدعم

لأي استفسارات أو مشاكل، يرجى التواصل مع فريق التطوير.

