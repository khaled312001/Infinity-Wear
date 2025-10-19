@extends('layouts.app')

@section('title', 'اختبار البريد الإلكتروني')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-envelope me-2"></i>
                        اختبار البريد الإلكتروني - Infinity Wear
                    </h3>
                </div>
                
                <div class="card-body">
                    <!-- إعدادات البريد الإلكتروني -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-cog me-2"></i>
                                        إعدادات البريد الإلكتروني
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4"><strong>الخادم:</strong></div>
                                        <div class="col-sm-8">smtp.hostinger.com</div>
                                        
                                        <div class="col-sm-4"><strong>المنفذ:</strong></div>
                                        <div class="col-sm-8">465 (SSL)</div>
                                        
                                        <div class="col-sm-4"><strong>البريد:</strong></div>
                                        <div class="col-sm-8">info@infinitywearsa.com</div>
                                        
                                        <div class="col-sm-4"><strong>التشفير:</strong></div>
                                        <div class="col-sm-8">SSL</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-server me-2"></i>
                                        خوادم البريد الوارد
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4"><strong>IMAP:</strong></div>
                                        <div class="col-sm-8">imap.hostinger.com:993 (SSL)</div>
                                        
                                        <div class="col-sm-4"><strong>POP:</strong></div>
                                        <div class="col-sm-8">pop.hostinger.com:995 (SSL)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- اختبار الاتصال -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-plug me-2"></i>
                                        اختبار الاتصال
                                    </h5>
                                    <button class="btn btn-primary" onclick="testConnection()">
                                        <i class="fas fa-play me-1"></i>
                                        اختبار الاتصال
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="connection-result" class="alert alert-info" style="display: none;">
                                        <i class="fas fa-spinner fa-spin me-2"></i>
                                        جاري اختبار الاتصال...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- اختبار إرسال إيميل -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        اختبار إرسال إيميل
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form id="test-email-form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="test-email" class="form-label">البريد الإلكتروني المستهدف</label>
                                                    <input type="email" class="form-control" id="test-email" name="to" 
                                                           placeholder="example@email.com" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="test-subject" class="form-label">الموضوع (اختياري)</label>
                                                    <input type="text" class="form-control" id="test-subject" name="subject" 
                                                           placeholder="اختبار البريد الإلكتروني">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="test-message" class="form-label">الرسالة (اختياري)</label>
                                            <textarea class="form-control" id="test-message" name="message" rows="3" 
                                                      placeholder="هذه رسالة تجريبية لاختبار النظام"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-send me-1"></i>
                                            إرسال إيميل تجريبي
                                        </button>
                                    </form>
                                    
                                    <div id="email-result" class="alert mt-3" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- اختبار الإشعارات -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-bell me-2"></i>
                                        اختبار إشعارات النظام
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form id="test-notification-form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="notification-email" class="form-label">البريد الإلكتروني المستهدف</label>
                                                    <input type="email" class="form-control" id="notification-email" name="to" 
                                                           placeholder="example@email.com" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="notification-type" class="form-label">نوع الإشعار</label>
                                                    <select class="form-control" id="notification-type" name="type" required>
                                                        <option value="order">طلب جديد</option>
                                                        <option value="contact">رسالة اتصال</option>
                                                        <option value="whatsapp">رسالة واتساب</option>
                                                        <option value="importer_order">طلب مستورد</option>
                                                        <option value="system">إشعار نظام</option>
                                                        <option value="task">مهمة جديدة</option>
                                                        <option value="marketing">تقرير تسويقي</option>
                                                        <option value="sales">تقرير مبيعات</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-bell me-1"></i>
                                            إرسال إشعار تجريبي
                                        </button>
                                    </form>
                                    
                                    <div id="notification-result" class="alert mt-3" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- اختبار شامل -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-cogs me-2"></i>
                                        اختبار شامل للنظام
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">
                                        هذا الاختبار سيقوم بفحص جميع مكونات النظام:
                                    </p>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-check text-success me-2"></i> اختبار الاتصال بالخادم</li>
                                        <li><i class="fas fa-check text-success me-2"></i> اختبار إرسال إيميل بسيط</li>
                                        <li><i class="fas fa-check text-success me-2"></i> اختبار جميع أنواع الإشعارات</li>
                                        <li><i class="fas fa-check text-success me-2"></i> اختبار Push Notifications</li>
                                    </ul>
                                    
                                    <form id="full-test-form">
                                        <div class="mb-3">
                                            <label for="full-test-email" class="form-label">البريد الإلكتروني المستهدف</label>
                                            <input type="email" class="form-control" id="full-test-email" name="to" 
                                                   placeholder="example@email.com" required>
                                        </div>
                                        <button type="submit" class="btn btn-danger btn-lg">
                                            <i class="fas fa-play me-2"></i>
                                            بدء الاختبار الشامل
                                        </button>
                                    </form>
                                    
                                    <div id="full-test-result" class="alert mt-3" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// اختبار الاتصال
function testConnection() {
    const resultDiv = document.getElementById('connection-result');
    resultDiv.style.display = 'block';
    resultDiv.className = 'alert alert-info';
    resultDiv.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جاري اختبار الاتصال...';
    
    fetch('/mail-test/settings')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                resultDiv.className = 'alert alert-success';
                resultDiv.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>تم الاتصال بنجاح!</strong><br>
                    ${data.data.message}<br>
                    <small>الخادم: ${data.data.server}</small>
                `;
            } else {
                resultDiv.className = 'alert alert-danger';
                resultDiv.innerHTML = `
                    <i class="fas fa-times-circle me-2"></i>
                    <strong>فشل في الاتصال!</strong><br>
                    ${data.message}
                `;
            }
        })
        .catch(error => {
            resultDiv.className = 'alert alert-danger';
            resultDiv.innerHTML = `
                <i class="fas fa-times-circle me-2"></i>
                <strong>خطأ في الاتصال!</strong><br>
                ${error.message}
            `;
        });
}

// اختبار إرسال إيميل
document.getElementById('test-email-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const resultDiv = document.getElementById('email-result');
    
    resultDiv.style.display = 'block';
    resultDiv.className = 'alert alert-info';
    resultDiv.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جاري إرسال الإيميل...';
    
    fetch('/mail-test/send', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.className = 'alert alert-success';
            resultDiv.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                <strong>تم إرسال الإيميل بنجاح!</strong><br>
                إلى: ${data.data.to}<br>
                الموضوع: ${data.data.subject}<br>
                الوقت: ${new Date(data.data.sent_at).toLocaleString('ar-SA')}
            `;
        } else {
            resultDiv.className = 'alert alert-danger';
            resultDiv.innerHTML = `
                <i class="fas fa-times-circle me-2"></i>
                <strong>فشل في إرسال الإيميل!</strong><br>
                ${data.message}
            `;
        }
    })
    .catch(error => {
        resultDiv.className = 'alert alert-danger';
        resultDiv.innerHTML = `
            <i class="fas fa-times-circle me-2"></i>
            <strong>خطأ في الإرسال!</strong><br>
            ${error.message}
        `;
    });
});

// اختبار الإشعارات
document.getElementById('test-notification-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const resultDiv = document.getElementById('notification-result');
    
    resultDiv.style.display = 'block';
    resultDiv.className = 'alert alert-info';
    resultDiv.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جاري إرسال الإشعار...';
    
    fetch('/mail-test/notification', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.className = 'alert alert-success';
            resultDiv.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                <strong>تم إرسال الإشعار بنجاح!</strong><br>
                إلى: ${data.data.to}<br>
                النوع: ${data.data.type}<br>
                الوقت: ${new Date(data.data.sent_at).toLocaleString('ar-SA')}
            `;
        } else {
            resultDiv.className = 'alert alert-danger';
            resultDiv.innerHTML = `
                <i class="fas fa-times-circle me-2"></i>
                <strong>فشل في إرسال الإشعار!</strong><br>
                ${data.message}
            `;
        }
    })
    .catch(error => {
        resultDiv.className = 'alert alert-danger';
        resultDiv.innerHTML = `
            <i class="fas fa-times-circle me-2"></i>
            <strong>خطأ في الإرسال!</strong><br>
            ${error.message}
        `;
    });
});

// الاختبار الشامل
document.getElementById('full-test-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const resultDiv = document.getElementById('full-test-result');
    
    resultDiv.style.display = 'block';
    resultDiv.className = 'alert alert-info';
    resultDiv.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جاري إجراء الاختبار الشامل...';
    
    fetch('/mail-test/full-test', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultDiv.className = 'alert alert-success';
            let html = '<i class="fas fa-check-circle me-2"></i><strong>تم الاختبار الشامل بنجاح!</strong><br><br>';
            
            // عرض نتائج كل اختبار
            if (data.data.connection) {
                html += `<div class="mb-2"><strong>الاتصال:</strong> <span class="text-success">✅ ${data.data.connection.message}</span></div>`;
            }
            if (data.data.simple_email) {
                html += `<div class="mb-2"><strong>الإيميل البسيط:</strong> <span class="text-success">✅ ${data.data.simple_email.message}</span></div>`;
            }
            if (data.data.notifications) {
                html += '<div class="mb-2"><strong>الإشعارات:</strong></div><ul class="list-unstyled ms-3">';
                Object.entries(data.data.notifications).forEach(([type, result]) => {
                    const status = result.status === 'success' ? '✅' : '❌';
                    html += `<li>${type}: ${status} ${result.message}</li>`;
                });
                html += '</ul>';
            }
            if (data.data.push_notifications) {
                html += `<div class="mb-2"><strong>Push Notifications:</strong> <span class="text-success">✅ ${data.data.push_notifications.message}</span></div>`;
            }
            
            resultDiv.innerHTML = html;
        } else {
            resultDiv.className = 'alert alert-danger';
            resultDiv.innerHTML = `
                <i class="fas fa-times-circle me-2"></i>
                <strong>فشل في الاختبار الشامل!</strong><br>
                ${data.message}
            `;
        }
    })
    .catch(error => {
        resultDiv.className = 'alert alert-danger';
        resultDiv.innerHTML = `
            <i class="fas fa-times-circle me-2"></i>
            <strong>خطأ في الاختبار!</strong><br>
            ${error.message}
        `;
    });
});
</script>
@endsection
