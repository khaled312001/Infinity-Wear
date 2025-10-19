<?php $__env->startSection('title', 'إعداد الواتساب'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cog text-primary"></i>
                        إعداد الواتساب
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> معلومات النظام</h5>
                        <p><strong>الرقم الأساسي للواتساب:</strong> +<?php echo e(config('whatsapp.primary_number', '966599476482')); ?></p>
                        <p>هذا الرقم سيتم استخدامه لإرسال واستقبال الرسائل</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-external-link-alt"></i> الخطوة 1: التسجيل في Whapi.Cloud</h5>
                                </div>
                                <div class="card-body">
                                    <ol>
                                        <li>اذهب إلى <a href="https://whapi.cloud" target="_blank" class="btn btn-sm btn-primary">Whapi.Cloud</a></li>
                                        <li>اضغط على "Get Started Free"</li>
                                        <li>سجل حساب جديد (مجاني)</li>
                                        <li>ستحصل على 5 أيام مجانية للاختبار</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-mobile-alt"></i> الخطوة 2: ربط رقم الواتساب</h5>
                                </div>
                                <div class="card-body">
                                    <ol>
                                        <li>في لوحة التحكم، ستجد QR Code</li>
                                        <li>افتح الواتساب على هاتفك</li>
                                        <li>اذهب إلى: <strong>الإعدادات</strong> > <strong>الأجهزة المرتبطة</strong> > <strong>ربط جهاز</strong> > <strong>مسح رمز QR</strong></li>
                                        <li>امسح الرمز من لوحة التحكم</li>
                                        <li>انتظر حتى يظهر "Connected"</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-key"></i> الخطوة 3: الحصول على API Token</h5>
                                </div>
                                <div class="card-body">
                                    <ol>
                                        <li>بعد ربط الهاتف، ستجد API Token في لوحة التحكم</li>
                                        <li>انسخ هذا الرمز (سيبدو مثل: <code>i4sbo2dXBNB1SbBvVwccPwpCzBDhVmcs</code>)</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-file-code"></i> الخطوة 4: إضافة الإعدادات</h5>
                                </div>
                                <div class="card-body">
                                    <p>أضف هذه الإعدادات في ملف <code>.env</code>:</p>
                                    <pre class="bg-light p-3"><code>WHATSAPP_PRIMARY_NUMBER=966599476482
WHATSAPP_API_ENABLED=true
WHATSAPP_API_TOKEN=YOUR_ACTUAL_TOKEN_HERE
WHATSAPP_WEB_ENABLED=true</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fas fa-vial"></i> الخطوة 5: اختبار النظام</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>بعد إضافة الإعدادات:</p>
                                            <ol>
                                                <li>أعد تشغيل الخادم</li>
                                                <li>اذهب إلى صفحة الاختبار</li>
                                                <li>اضغط على "اختبار الاتصال"</li>
                                                <li>إذا نجح الاختبار، جرب إرسال رسالة</li>
                                            </ol>
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <a href="<?php echo e(route('admin.whatsapp.test')); ?>" class="btn btn-success btn-lg">
                                                <i class="fas fa-vial"></i>
                                                صفحة الاختبار
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-4">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> ملاحظات مهمة</h5>
                        <ul>
                            <li><strong>الرقم الأساسي:</strong> +966 59 947 6482 (رقم سعودي)</li>
                            <li><strong>تنسيق الأرقام:</strong> يجب أن تكون بصيغة دولية (مثال: 966501234567)</li>
                            <li><strong>الأمان:</strong> لا تشارك API Token مع أي شخص</li>
                            <li><strong>الحدود:</strong> Whapi.Cloud يوفر حدود مجانية للاختبار</li>
                        </ul>
                    </div>

                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-bug"></i> استكشاف الأخطاء</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>إذا ظهر "API Token غير محدد":</h6>
                                <ul>
                                    <li>تأكد من إضافة <code>WHATSAPP_API_TOKEN</code> في ملف <code>.env</code></li>
                                    <li>تأكد من عدم وجود مسافات إضافية</li>
                                    <li>أعد تشغيل الخادم بعد التعديل</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>إذا ظهر "فشل الاتصال":</h6>
                                <ul>
                                    <li>تأكد من صحة API Token</li>
                                    <li>تأكد من ربط رقم الواتساب في Whapi.Cloud</li>
                                    <li>تأكد من أن الرقم متصل بالإنترنت</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\whatsapp\setup.blade.php ENDPATH**/ ?>