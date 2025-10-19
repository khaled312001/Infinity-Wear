

<?php $__env->startSection('title', 'إعدادات الإشعارات'); ?>
<?php $__env->startSection('page-title', 'إعدادات الإشعارات'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة إعدادات الإشعارات عبر البريد الإلكتروني'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">لوحة التحكم</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.notifications.index')); ?>">الإشعارات</a></li>
                        <li class="breadcrumb-item active">إعدادات الإشعارات</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    <i class="fas fa-cog me-2"></i>
                    إعدادات الإشعارات
                </h4>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.notifications.settings.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row">
            <!-- إعدادات البريد الإلكتروني -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-envelope me-2 text-primary"></i>
                            إعدادات البريد الإلكتروني
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- تفعيل الإشعارات -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="email_notifications_enabled" 
                                           name="email_notifications_enabled" 
                                           <?php echo e(old('email_notifications_enabled', $settings->email_notifications_enabled) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="email_notifications_enabled">
                                        <strong>تفعيل الإشعارات عبر البريد الإلكتروني</strong>
                                    </label>
                                </div>
                                <div class="form-text">عند التفعيل، سيتم إرسال الإشعارات عبر البريد الإلكتروني</div>
                            </div>
                        </div>

                        <!-- إعدادات SMTP -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="smtp_host" class="form-label">
                                    <i class="fas fa-server me-2 text-info"></i>
                                    خادم SMTP
                                </label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['smtp_host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="smtp_host" 
                                       name="smtp_host" 
                                       value="<?php echo e(old('smtp_host', $settings->smtp_host)); ?>"
                                       placeholder="smtp.gmail.com">
                                <?php $__errorArgs = ['smtp_host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="smtp_port" class="form-label">
                                    <i class="fas fa-plug me-2 text-warning"></i>
                                    المنفذ
                                </label>
                                <input type="number" 
                                       class="form-control <?php $__errorArgs = ['smtp_port'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="smtp_port" 
                                       name="smtp_port" 
                                       value="<?php echo e(old('smtp_port', $settings->smtp_port)); ?>"
                                       placeholder="587">
                                <?php $__errorArgs = ['smtp_port'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="smtp_username" class="form-label">
                                    <i class="fas fa-user me-2 text-success"></i>
                                    اسم المستخدم
                                </label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['smtp_username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="smtp_username" 
                                       name="smtp_username" 
                                       value="<?php echo e(old('smtp_username', $settings->smtp_username)); ?>"
                                       placeholder="your-email@gmail.com">
                                <?php $__errorArgs = ['smtp_username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="smtp_password" class="form-label">
                                    <i class="fas fa-lock me-2 text-danger"></i>
                                    كلمة المرور
                                </label>
                                <input type="password" 
                                       class="form-control <?php $__errorArgs = ['smtp_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="smtp_password" 
                                       name="smtp_password" 
                                       value="<?php echo e(old('smtp_password', $settings->smtp_password)); ?>"
                                       placeholder="كلمة مرور التطبيق">
                                <?php $__errorArgs = ['smtp_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">استخدم كلمة مرور التطبيق لـ Gmail</div>
                            </div>

                            <div class="col-md-6">
                                <label for="smtp_encryption" class="form-label">
                                    <i class="fas fa-shield-alt me-2 text-primary"></i>
                                    التشفير
                                </label>
                                <select class="form-select <?php $__errorArgs = ['smtp_encryption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="smtp_encryption" 
                                        name="smtp_encryption">
                                    <option value="tls" <?php echo e(old('smtp_encryption', $settings->smtp_encryption) == 'tls' ? 'selected' : ''); ?>>TLS</option>
                                    <option value="ssl" <?php echo e(old('smtp_encryption', $settings->smtp_encryption) == 'ssl' ? 'selected' : ''); ?>>SSL</option>
                                    <option value="null" <?php echo e(old('smtp_encryption', $settings->smtp_encryption) == 'null' ? 'selected' : ''); ?>>بدون تشفير</option>
                                </select>
                                <?php $__errorArgs = ['smtp_encryption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="from_email" class="form-label">
                                    <i class="fas fa-at me-2 text-info"></i>
                                    بريد المرسل
                                </label>
                                <input type="email" 
                                       class="form-control <?php $__errorArgs = ['from_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="from_email" 
                                       name="from_email" 
                                       value="<?php echo e(old('from_email', $settings->from_email)); ?>"
                                       placeholder="noreply@infinitywear.sa">
                                <?php $__errorArgs = ['from_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="from_name" class="form-label">
                                    <i class="fas fa-signature me-2 text-success"></i>
                                    اسم المرسل
                                </label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['from_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="from_name" 
                                       name="from_name" 
                                       value="<?php echo e(old('from_name', $settings->from_name)); ?>"
                                       placeholder="Infinity Wear">
                                <?php $__errorArgs = ['from_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label for="admin_email" class="form-label">
                                    <i class="fas fa-user-shield me-2 text-warning"></i>
                                    بريد المدير
                                </label>
                                <input type="email" 
                                       class="form-control <?php $__errorArgs = ['admin_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="admin_email" 
                                       name="admin_email" 
                                       value="<?php echo e(old('admin_email', $settings->admin_email)); ?>"
                                       placeholder="admin@infinitywear.sa">
                                <?php $__errorArgs = ['admin_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">البريد الإلكتروني الذي سيستقبل الإشعارات</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- إعدادات أنواع الإشعارات -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bell me-2 text-success"></i>
                            أنواع الإشعارات
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notify_new_orders" 
                                           name="notify_new_orders" 
                                           <?php echo e(old('notify_new_orders', $settings->notify_new_orders) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="notify_new_orders">
                                        <i class="fas fa-shopping-cart me-2 text-primary"></i>
                                        إشعارات الطلبات الجديدة
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notify_contact_messages" 
                                           name="notify_contact_messages" 
                                           <?php echo e(old('notify_contact_messages', $settings->notify_contact_messages) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="notify_contact_messages">
                                        <i class="fas fa-envelope me-2 text-info"></i>
                                        إشعارات رسائل الاتصال
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notify_whatsapp_messages" 
                                           name="notify_whatsapp_messages" 
                                           <?php echo e(old('notify_whatsapp_messages', $settings->notify_whatsapp_messages) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="notify_whatsapp_messages">
                                        <i class="fab fa-whatsapp me-2 text-success"></i>
                                        إشعارات رسائل الواتساب
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notify_importer_orders" 
                                           name="notify_importer_orders" 
                                           <?php echo e(old('notify_importer_orders', $settings->notify_importer_orders) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="notify_importer_orders">
                                        <i class="fas fa-industry me-2 text-warning"></i>
                                        إشعارات طلبات المستوردين
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="notify_system_updates" 
                                           name="notify_system_updates" 
                                           <?php echo e(old('notify_system_updates', $settings->notify_system_updates) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="notify_system_updates">
                                        <i class="fas fa-cogs me-2 text-secondary"></i>
                                        إشعارات تحديثات النظام
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الإعدادات الإضافية -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-sliders-h me-2 text-info"></i>
                            إعدادات إضافية
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="email_verification_enabled" 
                                       name="email_verification_enabled" 
                                       <?php echo e(old('email_verification_enabled', $settings->email_verification_enabled) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="email_verification_enabled">
                                    تفعيل التحقق من البريد الإلكتروني
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email_rate_limit" class="form-label">
                                <i class="fas fa-tachometer-alt me-2 text-warning"></i>
                                حد الإرسال (بريد/دقيقة)
                            </label>
                            <input type="number" 
                                   class="form-control <?php $__errorArgs = ['email_rate_limit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="email_rate_limit" 
                                   name="email_rate_limit" 
                                   value="<?php echo e(old('email_rate_limit', $settings->email_rate_limit)); ?>"
                                   min="1" max="1000">
                            <?php $__errorArgs = ['email_rate_limit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="email_queue_enabled" 
                                       name="email_queue_enabled" 
                                       <?php echo e(old('email_queue_enabled', $settings->email_queue_enabled) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="email_queue_enabled">
                                    تفعيل طابور الإرسال
                                </label>
                            </div>
                            <div class="form-text">إرسال الإيميلات في الخلفية</div>
                        </div>
                    </div>
                </div>

                <!-- اختبار البريد الإلكتروني -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-vial me-2 text-success"></i>
                            اختبار البريد الإلكتروني
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="test_email" class="form-label">البريد الإلكتروني للاختبار</label>
                            <input type="email" class="form-control" id="test_email" placeholder="test@example.com">
                        </div>
                        <button type="button" class="btn btn-outline-success w-100" id="testEmailBtn">
                            <i class="fas fa-paper-plane me-2"></i>
                            إرسال بريد تجريبي
                        </button>
                    </div>
                </div>

                <!-- إعادة تعيين الإعدادات -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-undo me-2 text-warning"></i>
                            إعادة تعيين الإعدادات
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">إعادة تعيين جميع الإعدادات للقيم الافتراضية</p>
                        <a href="<?php echo e(route('admin.notifications.settings.reset')); ?>" 
                           class="btn btn-outline-warning w-100"
                           onclick="return confirm('هل أنت متأكد من إعادة تعيين الإعدادات؟')">
                            <i class="fas fa-undo me-2"></i>
                            إعادة تعيين
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- أزرار الحفظ -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('admin.notifications.index')); ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-right me-2"></i>
                                العودة للإشعارات
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                حفظ الإعدادات
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // اختبار البريد الإلكتروني
    $('#testEmailBtn').click(function() {
        const testEmail = $('#test_email').val();
        
        if (!testEmail) {
            alert('يرجى إدخال بريد إلكتروني للاختبار');
            return;
        }

        const btn = $(this);
        const originalText = btn.html();
        
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>جاري الإرسال...');

        $.ajax({
            url: '<?php echo e(route("admin.notifications.settings.test")); ?>',
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                test_email: testEmail
            },
            success: function(response) {
                if (response.success) {
                    alert('تم إرسال البريد التجريبي بنجاح!');
                } else {
                    alert('خطأ: ' + response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                alert('خطأ: ' + (response.message || 'حدث خطأ غير متوقع'));
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\notifications\settings.blade.php ENDPATH**/ ?>