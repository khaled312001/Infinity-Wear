

<?php $__env->startSection('title', 'اختبار الواتساب'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'اختبار الواتساب'); ?>
<?php $__env->startSection('page-subtitle', 'اختبار إرسال واستقبال الرسائل عبر الواتساب'); ?>
<?php $__env->startSection('profile-route', '#'); ?>
<?php $__env->startSection('settings-route', '#'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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

    <div class="row g-4">
        <!-- اختبار الاتصال -->
        <div class="col-lg-6">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-wifi me-2 text-primary"></i>
                        اختبار الاتصال
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div id="connectionStatus" class="connection-indicator">
                            <i class="fas fa-question-circle fa-3x text-muted"></i>
                            <p class="mt-2 text-muted">لم يتم اختبار الاتصال بعد</p>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary" id="testConnectionBtn">
                            <i class="fas fa-vial me-2"></i>
                            اختبار الاتصال
                        </button>
                        <a href="<?php echo e(route('admin.whatsapp.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            العودة للواتساب
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- إرسال رسالة تجريبية -->
        <div class="col-lg-6">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fab fa-whatsapp me-2 text-success"></i>
                        إرسال رسالة تجريبية
                    </h5>
                </div>
                <div class="card-body">
                    <form id="testMessageForm">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="testPhoneNumber" class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" id="testPhoneNumber" name="to_number" 
                                   placeholder="966501234567" value="966599476482" required>
                            <div class="form-text">أدخل الرقم بصيغة دولية (بدون +)</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="testMessage" class="form-label">نص الرسالة</label>
                            <textarea class="form-control" id="testMessage" name="message_content" rows="3" 
                                      placeholder="أدخل نص الرسالة التجريبية" required>مرحباً! هذه رسالة تجريبية من نظام Infinity Wear. 🚀</textarea>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success" id="sendTestBtn">
                                <i class="fab fa-whatsapp me-2"></i>
                                إرسال رسالة تجريبية
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- معلومات النظام -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2 text-info"></i>
                        معلومات النظام
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>إعدادات الواتساب:</h6>
                            <ul class="list-unstyled">
                                <li><strong>الرقم الأساسي:</strong> <?php echo e(config('whatsapp.primary_number', 'غير محدد')); ?></li>
                                <li><strong>API مفعل:</strong> 
                                    <?php if(config('whatsapp.api.enabled', false)): ?>
                                        <span class="badge bg-success">مفعل</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">معطل</span>
                                    <?php endif; ?>
                                </li>
                                <li><strong>مزود الخدمة:</strong> 
                                    <?php if(config('whatsapp.api.provider', 'auto_api') === 'auto_api'): ?>
                                        <span class="badge bg-success">Auto API (إرسال تلقائي)</span>
                                    <?php else: ?>
                                        <span class="badge bg-info"><?php echo e(config('whatsapp.api.provider', 'auto_api')); ?></span>
                                    <?php endif; ?>
                                </li>
                                <li><strong>API Token:</strong> 
                                    <?php if(config('whatsapp.api.api_token')): ?>
                                        <span class="badge bg-success">موجود</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">غير مطلوب (Free API)</span>
                                    <?php endif; ?>
                                </li>
                                <li><strong>WhatsApp Web:</strong> 
                                    <?php if(config('whatsapp.web.enabled', true)): ?>
                                        <span class="badge bg-success">مفعل</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">معطل</span>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>إحصائيات سريعة:</h6>
                            <ul class="list-unstyled">
                                <li><strong>إجمالي الرسائل:</strong> <span id="totalMessages">-</span></li>
                                <li><strong>آخر رسالة:</strong> <span id="lastMessage">-</span></li>
                                <li><strong>حالة النظام:</strong> <span id="systemStatus" class="badge bg-secondary">غير محدد</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- سجل الاختبارات -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2 text-warning"></i>
                        سجل الاختبارات
                    </h5>
                </div>
                <div class="card-body">
                    <div id="testLog" class="test-log">
                        <div class="text-center text-muted py-3">
                            <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                            <p>لم يتم إجراء أي اختبارات بعد</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.connection-indicator {
    padding: 2rem;
    border-radius: 10px;
    background-color: #f8f9fa;
    border: 2px dashed #dee2e6;
    transition: all 0.3s ease;
}

.connection-indicator.connected {
    background-color: #d1edff;
    border-color: #0d6efd;
    color: #0d6efd;
}

.connection-indicator.error {
    background-color: #f8d7da;
    border-color: #dc3545;
    color: #dc3545;
}

.test-log {
    max-height: 300px;
    overflow-y: auto;
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 1rem;
}

.test-log-entry {
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    border-radius: 6px;
    border-left: 4px solid;
}

.test-log-entry.success {
    background-color: #d1edff;
    border-left-color: #0d6efd;
}

.test-log-entry.error {
    background-color: #f8d7da;
    border-left-color: #dc3545;
}

.test-log-entry.info {
    background-color: #fff3cd;
    border-left-color: #ffc107;
}

.btn-loading {
    position: relative;
    pointer-events: none;
}

.btn-loading::after {
    content: "";
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    margin-left: -8px;
    margin-top: -8px;
    border: 2px solid transparent;
    border-top-color: #ffffff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const testConnectionBtn = document.getElementById('testConnectionBtn');
    const testMessageForm = document.getElementById('testMessageForm');
    const sendTestBtn = document.getElementById('sendTestBtn');
    const connectionStatus = document.getElementById('connectionStatus');
    const testLog = document.getElementById('testLog');

    // اختبار الاتصال
    testConnectionBtn.addEventListener('click', function() {
        testConnectionBtn.classList.add('btn-loading');
        testConnectionBtn.disabled = true;
        
        addLogEntry('info', 'جاري اختبار الاتصال...');
        
        fetch('/admin/whatsapp/test-connection', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                connectionStatus.innerHTML = `
                    <i class="fas fa-check-circle fa-3x text-success"></i>
                    <p class="mt-2 text-success">الاتصال ناجح</p>
                `;
                connectionStatus.className = 'connection-indicator connected';
                addLogEntry('success', 'تم اختبار الاتصال بنجاح');
            } else {
                connectionStatus.innerHTML = `
                    <i class="fas fa-times-circle fa-3x text-danger"></i>
                    <p class="mt-2 text-danger">فشل الاتصال</p>
                `;
                connectionStatus.className = 'connection-indicator error';
                addLogEntry('error', 'فشل اختبار الاتصال: ' + (data.message || 'خطأ غير معروف'));
            }
        })
        .catch(error => {
            connectionStatus.innerHTML = `
                <i class="fas fa-times-circle fa-3x text-danger"></i>
                <p class="mt-2 text-danger">خطأ في الاتصال</p>
            `;
            connectionStatus.className = 'connection-indicator error';
            addLogEntry('error', 'خطأ في الاتصال: ' + error.message);
        })
        .finally(() => {
            testConnectionBtn.classList.remove('btn-loading');
            testConnectionBtn.disabled = false;
        });
    });

    // إرسال رسالة تجريبية
    testMessageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        sendTestBtn.classList.add('btn-loading');
        sendTestBtn.disabled = true;
        
        const formData = new FormData(this);
        const phoneNumber = formData.get('to_number');
        const message = formData.get('message_content');
        
        addLogEntry('info', `جاري إرسال رسالة إلى ${phoneNumber}...`);
        
        fetch('/admin/whatsapp/test', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // التحقق من نوع الإرسال
                if (data.data && data.data.auto_sent) {
                    addLogEntry('success', `تم إرسال الرسالة تلقائياً إلى ${phoneNumber} عبر ${data.data.service_used || 'خدمة غير معروفة'}`);
                    showAlert('success', '🎉 تم إرسال الرسالة تلقائياً بنجاح!\n\nالرسالة وصلت مباشرة إلى WhatsApp بدون الحاجة لفتح التطبيق!');
                } else {
                    addLogEntry('success', `تم إنشاء رابط WhatsApp إلى ${phoneNumber}`);
                    
                    // عرض رابط WhatsApp Web
                    if (data.data && data.data.whatsapp_url) {
                        const whatsappUrl = data.data.whatsapp_url;
                        const openWhatsApp = confirm('تم إنشاء رابط WhatsApp بنجاح!\n\nهل تريد فتح WhatsApp Web لإرسال الرسالة؟');
                        
                        if (openWhatsApp) {
                            window.open(whatsappUrl, '_blank');
                            addLogEntry('info', `تم فتح WhatsApp Web: ${whatsappUrl}`);
                        } else {
                            // نسخ الرابط للحافظة
                            navigator.clipboard.writeText(whatsappUrl).then(() => {
                                addLogEntry('info', 'تم نسخ رابط WhatsApp إلى الحافظة');
                                showAlert('success', 'تم نسخ رابط WhatsApp إلى الحافظة!\n\nيمكنك مشاركة الرابط لإرسال الرسالة.');
                            }).catch(() => {
                                addLogEntry('info', `رابط WhatsApp: ${whatsappUrl}`);
                                showAlert('info', 'رابط WhatsApp:\n' + whatsappUrl);
                            });
                        }
                    }
                    
                    showAlert('info', 'تم إنشاء رابط WhatsApp (الإرسال التلقائي غير متاح حالياً)');
                }
            } else {
                addLogEntry('error', `فشل إرسال الرسالة: ${data.message || 'خطأ غير معروف'}`);
                showAlert('error', 'فشل إرسال الرسالة: ' + (data.message || 'خطأ غير معروف'));
            }
        })
        .catch(error => {
            addLogEntry('error', `خطأ في إرسال الرسالة: ${error.message}`);
            showAlert('error', 'خطأ في إرسال الرسالة: ' + error.message);
        })
        .finally(() => {
            sendTestBtn.classList.remove('btn-loading');
            sendTestBtn.disabled = false;
        });
    });

    // إضافة إدخال إلى سجل الاختبارات
    function addLogEntry(type, message) {
        const timestamp = new Date().toLocaleString('ar-SA');
        const entry = document.createElement('div');
        entry.className = `test-log-entry ${type}`;
        entry.innerHTML = `
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <strong>${getTypeLabel(type)}</strong>
                    <p class="mb-0">${message}</p>
                </div>
                <small class="text-muted">${timestamp}</small>
            </div>
        `;
        
        // إزالة الرسالة الافتراضية إذا كانت موجودة
        const defaultMessage = testLog.querySelector('.text-center');
        if (defaultMessage) {
            defaultMessage.remove();
        }
        
        testLog.insertBefore(entry, testLog.firstChild);
        
        // الاحتفاظ بآخر 10 إدخالات فقط
        const entries = testLog.querySelectorAll('.test-log-entry');
        if (entries.length > 10) {
            entries[entries.length - 1].remove();
        }
    }

    // الحصول على تسمية النوع
    function getTypeLabel(type) {
        const labels = {
            'success': 'نجح',
            'error': 'فشل',
            'info': 'معلومات'
        };
        return labels[type] || type;
    }

    // إظهار تنبيه
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // إدراج التنبيه في أعلى المحتوى
        const content = document.querySelector('.container-fluid');
        content.insertBefore(alertDiv, content.firstChild);
        
        // إزالة التنبيه تلقائياً بعد 5 ثوان
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // تحميل الإحصائيات
    loadStats();
    
    function loadStats() {
        // يمكن إضافة AJAX call هنا لتحميل الإحصائيات الحقيقية
        document.getElementById('totalMessages').textContent = '0';
        document.getElementById('lastMessage').textContent = 'لم يتم إرسال رسائل بعد';
        document.getElementById('systemStatus').textContent = 'جاهز للاختبار';
        document.getElementById('systemStatus').className = 'badge bg-info';
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\whatsapp\test.blade.php ENDPATH**/ ?>