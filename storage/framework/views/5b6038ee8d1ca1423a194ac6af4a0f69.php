

<?php $__env->startSection('title', 'إعدادات المشرف - لوحة التحكم'); ?>
<?php $__env->startSection('dashboard-title', 'إعدادات المشرف'); ?>
<?php $__env->startSection('page-title', 'إعدادات المشرف'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة إعداداتك الشخصية وتفضيلات النظام'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cog me-2"></i>
                    الإعدادات العامة
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.admin-settings.update')); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="language" class="form-label">اللغة</label>
                            <select class="form-select" id="language" name="language" required>
                                <option value="ar" <?php echo e($admin->language == 'ar' ? 'selected' : ''); ?>>العربية</option>
                                <option value="en" <?php echo e($admin->language == 'en' ? 'selected' : ''); ?>>English</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="timezone" class="form-label">المنطقة الزمنية</label>
                            <select class="form-select" id="timezone" name="timezone" required>
                                <option value="Asia/Riyadh" <?php echo e($admin->timezone == 'Asia/Riyadh' ? 'selected' : ''); ?>>الرياض (GMT+3)</option>
                                <option value="Asia/Dubai" <?php echo e($admin->timezone == 'Asia/Dubai' ? 'selected' : ''); ?>>دبي (GMT+4)</option>
                                <option value="Europe/London" <?php echo e($admin->timezone == 'Europe/London' ? 'selected' : ''); ?>>لندن (GMT+0)</option>
                                <option value="America/New_York" <?php echo e($admin->timezone == 'America/New_York' ? 'selected' : ''); ?>>نيويورك (GMT-5)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="mb-3">إعدادات الإشعارات</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="email_notifications" 
                                           name="notifications[email]" value="1" 
                                           <?php echo e(json_decode($admin->notification_settings ?? '{}', true)['email'] ?? false ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="email_notifications">
                                        الإشعارات عبر البريد الإلكتروني
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="sms_notifications" 
                                           name="notifications[sms]" value="1"
                                           <?php echo e(json_decode($admin->notification_settings ?? '{}', true)['sms'] ?? false ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="sms_notifications">
                                        الإشعارات عبر الرسائل النصية
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="push_notifications" 
                                           name="notifications[push]" value="1"
                                           <?php echo e(json_decode($admin->notification_settings ?? '{}', true)['push'] ?? false ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="push_notifications">
                                        الإشعارات الفورية
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>حفظ الإعدادات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-palette me-2"></i>
                    تفضيلات العرض
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">الوضع الليلي</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="darkModeToggle" 
                               onchange="toggleDarkMode()">
                        <label class="form-check-label" for="darkModeToggle">
                            تفعيل الوضع الليلي
                        </label>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">كثافة العرض</label>
                    <select class="form-select" id="displayDensity">
                        <option value="comfortable">مريح</option>
                        <option value="compact">مضغوط</option>
                        <option value="spacious">واسع</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">حجم الخط</label>
                    <select class="form-select" id="fontSize">
                        <option value="small">صغير</option>
                        <option value="medium" selected>متوسط</option>
                        <option value="large">كبير</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shield-alt me-2"></i>
                    الأمان والخصوصية
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>جلسة آمنة</span>
                        <span class="badge bg-success">مفعلة</span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>مصادقة ثنائية</span>
                        <span class="badge bg-warning">غير مفعلة</span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>تسجيل الدخول الأخير</span>
                        <small class="text-muted"><?php echo e($admin->updated_at->diffForHumans()); ?></small>
                    </div>
                </div>
                
                <div class="d-grid">
                    <a href="<?php echo e(route('admin.profile')); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-user me-2"></i>تعديل الملف الشخصي
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Dark mode toggle functionality
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    const isDarkMode = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDarkMode);
    
    // Update toggle switch
    const toggle = document.getElementById('darkModeToggle');
    if (toggle) {
        toggle.checked = isDarkMode;
    }
    
    // Show notification
    showNotification(isDarkMode ? 'تم تفعيل الوضع الليلي' : 'تم إلغاء الوضع الليلي', 'success');
}

// Load dark mode preference
document.addEventListener('DOMContentLoaded', function() {
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    if (isDarkMode) {
        document.body.classList.add('dark-mode');
        const toggle = document.getElementById('darkModeToggle');
        if (toggle) {
            toggle.checked = true;
        }
    }
});

// Display density change
document.getElementById('displayDensity').addEventListener('change', function() {
    const density = this.value;
    document.body.className = document.body.className.replace(/density-\w+/g, '');
    document.body.classList.add('density-' + density);
    localStorage.setItem('displayDensity', density);
    showNotification('تم تغيير كثافة العرض', 'info');
});

// Font size change
document.getElementById('fontSize').addEventListener('change', function() {
    const fontSize = this.value;
    document.body.className = document.body.className.replace(/font-\w+/g, '');
    document.body.classList.add('font-' + fontSize);
    localStorage.setItem('fontSize', fontSize);
    showNotification('تم تغيير حجم الخط', 'info');
});

// Load saved preferences
document.addEventListener('DOMContentLoaded', function() {
    const savedDensity = localStorage.getItem('displayDensity');
    const savedFontSize = localStorage.getItem('fontSize');
    
    if (savedDensity) {
        document.getElementById('displayDensity').value = savedDensity;
        document.body.classList.add('density-' + savedDensity);
    }
    
    if (savedFontSize) {
        document.getElementById('fontSize').value = savedFontSize;
        document.body.classList.add('font-' + savedFontSize);
    }
});

function showNotification(message, type = 'info') {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'error' ? 'alert-danger' : 
                      type === 'warning' ? 'alert-warning' : 'alert-info';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 
                               type === 'error' ? 'exclamation-circle' : 
                               type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        const alert = document.querySelector('.alert:last-of-type');
        if (alert) {
            alert.remove();
        }
    }, 3000);
}
</script>

<style>
/* Display density styles */
.density-compact .dashboard-card {
    padding: 15px;
}

.density-compact .card-body {
    padding: 15px;
}

.density-spacious .dashboard-card {
    padding: 30px;
}

.density-spacious .card-body {
    padding: 30px;
}

/* Font size styles */
.font-small {
    font-size: 0.875rem;
}

.font-large {
    font-size: 1.125rem;
}

.font-large .card-title {
    font-size: 1.25rem;
}

.font-large .form-label {
    font-size: 1rem;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\settings\index.blade.php ENDPATH**/ ?>