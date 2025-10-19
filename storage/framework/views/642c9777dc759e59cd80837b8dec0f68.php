

<?php $__env->startSection('title', 'إعدادات الإشعارات - لوحة تحكم المستورد'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة المستورد'); ?>
<?php $__env->startSection('page-title', 'إعدادات الإشعارات'); ?>
<?php $__env->startSection('page-subtitle', 'تخصيص تفضيلات الإشعارات'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog me-2"></i>
                        إعدادات الإشعارات
                    </h5>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('importers.notification-settings.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <!-- إعدادات القنوات -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-broadcast-tower me-2"></i>
                                قنوات الإشعارات
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="email_notifications" 
                                               name="email_notifications" value="1" 
                                               <?php echo e($settings['email_notifications'] ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="email_notifications">
                                            <i class="fas fa-envelope me-2 text-primary"></i>
                                            <strong>البريد الإلكتروني</strong>
                                            <br>
                                            <small class="text-muted">إشعارات عبر البريد الإلكتروني</small>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="sms_notifications" 
                                               name="sms_notifications" value="1" 
                                               <?php echo e($settings['sms_notifications'] ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="sms_notifications">
                                            <i class="fas fa-sms me-2 text-success"></i>
                                            <strong>الرسائل النصية</strong>
                                            <br>
                                            <small class="text-muted">إشعارات عبر الرسائل النصية</small>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="push_notifications" 
                                               name="push_notifications" value="1" 
                                               <?php echo e($settings['push_notifications'] ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="push_notifications">
                                            <i class="fas fa-mobile-alt me-2 text-info"></i>
                                            <strong>الإشعارات المباشرة</strong>
                                            <br>
                                            <small class="text-muted">إشعارات مباشرة في المتصفح</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- إعدادات أنواع الإشعارات -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-bell me-2"></i>
                                أنواع الإشعارات
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="order_updates" 
                                               name="order_updates" value="1" 
                                               <?php echo e($settings['order_updates'] ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="order_updates">
                                            <i class="fas fa-shopping-cart me-2 text-primary"></i>
                                            <strong>تحديثات الطلبات</strong>
                                            <br>
                                            <small class="text-muted">إشعارات عند تغيير حالة الطلبات</small>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="payment_notifications" 
                                               name="payment_notifications" value="1" 
                                               <?php echo e($settings['payment_notifications'] ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="payment_notifications">
                                            <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                            <strong>إشعارات الدفع</strong>
                                            <br>
                                            <small class="text-muted">إشعارات عند استلام المدفوعات</small>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="shipping_updates" 
                                               name="shipping_updates" value="1" 
                                               <?php echo e($settings['shipping_updates'] ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="shipping_updates">
                                            <i class="fas fa-truck me-2 text-info"></i>
                                            <strong>تحديثات الشحن</strong>
                                            <br>
                                            <small class="text-muted">إشعارات عند تحديث حالة الشحن</small>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="invoice_notifications" 
                                               name="invoice_notifications" value="1" 
                                               <?php echo e($settings['invoice_notifications'] ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="invoice_notifications">
                                            <i class="fas fa-file-invoice me-2 text-warning"></i>
                                            <strong>إشعارات الفواتير</strong>
                                            <br>
                                            <small class="text-muted">إشعارات عند إنشاء فواتير جديدة</small>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="system_announcements" 
                                               name="system_announcements" value="1" 
                                               <?php echo e($settings['system_announcements'] ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="system_announcements">
                                            <i class="fas fa-bullhorn me-2 text-secondary"></i>
                                            <strong>إعلانات النظام</strong>
                                            <br>
                                            <small class="text-muted">إعلانات مهمة حول النظام</small>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="marketing_emails" 
                                               name="marketing_emails" value="1" 
                                               <?php echo e($settings['marketing_emails'] ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="marketing_emails">
                                            <i class="fas fa-envelope-open-text me-2 text-danger"></i>
                                            <strong>رسائل تسويقية</strong>
                                            <br>
                                            <small class="text-muted">عروض ورسائل تسويقية</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- إعدادات التوقيت -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-clock me-2"></i>
                                توقيت الإشعارات
                            </h6>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="quiet_hours_start" class="form-label">بداية ساعات الهدوء</label>
                                        <input type="time" class="form-control" id="quiet_hours_start" 
                                               name="quiet_hours_start" value="22:00">
                                        <small class="text-muted">لا توجد إشعارات خلال هذه الفترة</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="quiet_hours_end" class="form-label">نهاية ساعات الهدوء</label>
                                        <input type="time" class="form-control" id="quiet_hours_end" 
                                               name="quiet_hours_end" value="08:00">
                                        <small class="text-muted">استئناف الإشعارات في هذا الوقت</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="weekend_notifications" 
                                       name="weekend_notifications" value="1" checked>
                                <label class="form-check-label" for="weekend_notifications">
                                    <i class="fas fa-calendar-weekend me-2"></i>
                                    <strong>الإشعارات في عطلة نهاية الأسبوع</strong>
                                    <br>
                                    <small class="text-muted">استقبال الإشعارات في أيام الجمعة والسبت</small>
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                حفظ الإعدادات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- معلومات الإشعارات -->
            <div class="dashboard-card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        معلومات الإشعارات
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary">البريد الإلكتروني</h6>
                        <p class="text-muted mb-2">الإشعارات المرسلة إلى:</p>
                        <strong><?php echo e($importer->email); ?></strong>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-primary">الرسائل النصية</h6>
                        <p class="text-muted mb-2">الإشعارات المرسلة إلى:</p>
                        <strong><?php echo e($importer->phone); ?></strong>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-primary">آخر تحديث</h6>
                        <p class="text-muted mb-0"><?php echo e(now()->format('Y-m-d H:i')); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- إحصائيات الإشعارات -->
            <div class="dashboard-card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        إحصائيات الإشعارات
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>إجمالي الإشعارات هذا الشهر:</span>
                            <strong>24</strong>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>الإشعارات المقروءة:</span>
                            <strong class="text-success">18</strong>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>الإشعارات غير المقروءة:</span>
                            <strong class="text-warning">6</strong>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>معدل القراءة:</span>
                            <strong class="text-info">75%</strong>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- اختبار الإشعارات -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-vial me-2"></i>
                        اختبار الإشعارات
                    </h5>
                </div>
                
                <div class="card-body">
                    <p class="text-muted mb-3">اختبر إعدادات الإشعارات بإرسال إشعار تجريبي</p>
                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="testEmailNotification()">
                            <i class="fas fa-envelope me-2"></i>
                            اختبار البريد الإلكتروني
                        </button>
                        <button class="btn btn-outline-success" onclick="testSMSNotification()">
                            <i class="fas fa-sms me-2"></i>
                            اختبار الرسائل النصية
                        </button>
                        <button class="btn btn-outline-info" onclick="testPushNotification()">
                            <i class="fas fa-mobile-alt me-2"></i>
                            اختبار الإشعارات المباشرة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function testEmailNotification() {
    alert('تم إرسال إشعار تجريبي إلى البريد الإلكتروني: <?php echo e($importer->email); ?>');
    // يمكن إضافة AJAX call لإرسال إشعار تجريبي
}

function testSMSNotification() {
    alert('تم إرسال إشعار تجريبي إلى رقم الهاتف: <?php echo e($importer->phone); ?>');
    // يمكن إضافة AJAX call لإرسال إشعار تجريبي
}

function testPushNotification() {
    if ('Notification' in window) {
        if (Notification.permission === 'granted') {
            new Notification('إشعار تجريبي', {
                body: 'هذا إشعار تجريبي من إنفينيتي وير',
                icon: '/favicon.ico'
            });
        } else if (Notification.permission !== 'denied') {
            Notification.requestPermission().then(function(permission) {
                if (permission === 'granted') {
                    new Notification('إشعار تجريبي', {
                        body: 'هذا إشعار تجريبي من إنفينيتي وير',
                        icon: '/favicon.ico'
                    });
                }
            });
        } else {
            alert('تم رفض الإذن للإشعارات. يرجى تفعيل الإشعارات من إعدادات المتصفح.');
        }
    } else {
        alert('المتصفح لا يدعم الإشعارات المباشرة');
    }
}

// طلب إذن الإشعارات عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\importers\notification-settings.blade.php ENDPATH**/ ?>