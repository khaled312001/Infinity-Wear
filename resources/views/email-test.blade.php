<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار نظام الإيميل - Infinity Wear</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .content {
            padding: 40px;
        }

        .status-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 5px solid #667eea;
        }

        .status-section h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .status-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .status-label {
            font-weight: bold;
            color: #495057;
            margin-bottom: 5px;
        }

        .status-value {
            color: #6c757d;
            font-family: monospace;
        }

        .test-section {
            margin-bottom: 30px;
        }

        .test-section h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .test-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .test-card {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .test-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .test-card h4 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .test-card p {
            color: #6c757d;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #495057;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        }

        .result {
            margin-top: 15px;
            padding: 15px;
            border-radius: 5px;
            font-weight: bold;
        }

        .result.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .result.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .result.info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .loading {
            display: none;
            text-align: center;
            margin-top: 10px;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
        }

        @media (max-width: 768px) {
            .content {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .test-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📧 اختبار نظام الإيميل</h1>
            <p>Infinity Wear - Email System Testing</p>
        </div>

        <div class="content">
            <!-- Email Status Section -->
            <div class="status-section">
                <h3>📊 حالة إعدادات الإيميل</h3>
                <div class="status-grid" id="emailStatus">
                    <div class="status-item">
                        <div class="status-label">الإيميل الافتراضي:</div>
                        <div class="status-value" id="adminEmail">جاري التحميل...</div>
                    </div>
                    <div class="status-item">
                        <div class="status-label">خادم SMTP:</div>
                        <div class="status-value" id="smtpHost">جاري التحميل...</div>
                    </div>
                    <div class="status-item">
                        <div class="status-label">المنفذ:</div>
                        <div class="status-value" id="smtpPort">جاري التحميل...</div>
                    </div>
                    <div class="status-item">
                        <div class="status-label">التشفير:</div>
                        <div class="status-value" id="smtpEncryption">جاري التحميل...</div>
                    </div>
                </div>
            </div>

            <!-- Test Sections -->
            <div class="test-section">
                <h3>🧪 اختبارات الإيميل</h3>
                <div class="test-grid">
                    <!-- Basic Email Test -->
                    <div class="test-card">
                        <h4>📤 اختبار إرسال إيميل أساسي</h4>
                        <p>اختبار إرسال إيميل بسيط للتأكد من عمل النظام</p>
                        <button class="btn" onclick="testBasicEmail()">إرسال إيميل اختبار</button>
                        <div class="loading" id="basicLoading">
                            <div class="spinner"></div>
                        </div>
                        <div class="result" id="basicResult"></div>
                    </div>

                    <!-- Contact Form Test -->
                    <div class="test-card">
                        <h4>📝 اختبار نموذج التواصل</h4>
                        <p>اختبار إرسال إيميل نموذج التواصل</p>
                        <button class="btn btn-success" onclick="testContactForm()">اختبار نموذج التواصل</button>
                        <div class="loading" id="contactLoading">
                            <div class="spinner"></div>
                        </div>
                        <div class="result" id="contactResult"></div>
                    </div>

                    <!-- Importer Request Test -->
                    <div class="test-card">
                        <h4>🏢 اختبار طلب مستورد</h4>
                        <p>اختبار إرسال إيميل طلب مستورد</p>
                        <button class="btn btn-warning" onclick="testImporterRequest()">اختبار طلب مستورد</button>
                        <div class="loading" id="importerLoading">
                            <div class="spinner"></div>
                        </div>
                        <div class="result" id="importerResult"></div>
                    </div>

                    <!-- Custom Notification Test -->
                    <div class="test-card">
                        <h4>🔔 اختبار إشعار مخصص</h4>
                        <p>إرسال إشعار مخصص مع رسالة مخصصة</p>
                        <div class="form-group">
                            <label>الإيميل المستلم:</label>
                            <input type="email" id="notificationEmail" value="info@infinitywearsa.com" placeholder="example@domain.com">
                        </div>
                        <div class="form-group">
                            <label>الموضوع:</label>
                            <input type="text" id="notificationSubject" value="اختبار إشعار مخصص" placeholder="موضوع الإشعار">
                        </div>
                        <div class="form-group">
                            <label>الرسالة:</label>
                            <textarea id="notificationMessage" placeholder="اكتب رسالتك هنا...">هذا اختبار لإرسال إشعار مخصص من نظام Infinity Wear</textarea>
                        </div>
                        <div class="form-group">
                            <label>نوع الإشعار:</label>
                            <select id="notificationType">
                                <option value="test">اختبار</option>
                                <option value="general">عام</option>
                                <option value="system_alert">تنبيه نظام</option>
                                <option value="warning">تحذير</option>
                                <option value="success">نجاح</option>
                            </select>
                        </div>
                        <button class="btn" onclick="testCustomNotification()">إرسال إشعار مخصص</button>
                        <div class="loading" id="customLoading">
                            <div class="spinner"></div>
                        </div>
                        <div class="result" id="customResult"></div>
                    </div>

                    <!-- System Alert Test -->
                    <div class="test-card">
                        <h4>⚠️ اختبار تنبيه النظام</h4>
                        <p>إرسال تنبيه نظام للمدير</p>
                        <div class="form-group">
                            <label>الموضوع:</label>
                            <input type="text" id="alertSubject" value="تنبيه نظام - اختبار" placeholder="موضوع التنبيه">
                        </div>
                        <div class="form-group">
                            <label>الرسالة:</label>
                            <textarea id="alertMessage" placeholder="اكتب رسالة التنبيه...">هذا تنبيه نظام للاختبار من نظام Infinity Wear</textarea>
                        </div>
                        <div class="form-group">
                            <label>مستوى التنبيه:</label>
                            <select id="alertLevel">
                                <option value="info">معلومات</option>
                                <option value="warning">تحذير</option>
                                <option value="error">خطأ</option>
                                <option value="critical">حرج</option>
                            </select>
                        </div>
                        <button class="btn btn-danger" onclick="testSystemAlert()">إرسال تنبيه نظام</button>
                        <div class="loading" id="alertLoading">
                            <div class="spinner"></div>
                        </div>
                        <div class="result" id="alertResult"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p><strong>Infinity Wear</strong> - نظام إدارة الإيميلات | تم التطوير بواسطة فريق Infinity Wear</p>
        </div>
    </div>

    <script>
        // Set CSRF token for all requests
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Load email status on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadEmailStatus();
        });

        // Load email status
        async function loadEmailStatus() {
            try {
                const response = await fetch('/email-test/status');
                const data = await response.json();
                
                if (data.success) {
                    const status = data.status;
                    document.getElementById('adminEmail').textContent = status.admin_email || 'غير محدد';
                    document.getElementById('smtpHost').textContent = status.host || 'غير محدد';
                    document.getElementById('smtpPort').textContent = status.port || 'غير محدد';
                    document.getElementById('smtpEncryption').textContent = status.encryption || 'غير محدد';
                } else {
                    showResult('emailStatus', 'خطأ في تحميل حالة الإيميل: ' + data.message, 'error');
                }
            } catch (error) {
                showResult('emailStatus', 'خطأ في الاتصال: ' + error.message, 'error');
            }
        }

        // Test basic email
        async function testBasicEmail() {
            const loading = document.getElementById('basicLoading');
            const result = document.getElementById('basicResult');
            
            loading.style.display = 'block';
            result.style.display = 'none';
            
            try {
                const response = await fetch('/email-test/test', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    }
                });
                
                const data = await response.json();
                loading.style.display = 'none';
                
                if (data.success) {
                    showResult('basicResult', '✅ تم إرسال الإيميل بنجاح!', 'success');
                } else {
                    showResult('basicResult', '❌ فشل في إرسال الإيميل: ' + data.message, 'error');
                }
            } catch (error) {
                loading.style.display = 'none';
                showResult('basicResult', '❌ خطأ في الاتصال: ' + error.message, 'error');
            }
        }

        // Test contact form
        async function testContactForm() {
            const loading = document.getElementById('contactLoading');
            const result = document.getElementById('contactResult');
            
            loading.style.display = 'block';
            result.style.display = 'none';
            
            try {
                const response = await fetch('/email-test/test-contact-form', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    }
                });
                
                const data = await response.json();
                loading.style.display = 'none';
                
                if (data.success) {
                    showResult('contactResult', '✅ تم إرسال إيميل نموذج التواصل بنجاح!', 'success');
                } else {
                    showResult('contactResult', '❌ فشل في إرسال إيميل نموذج التواصل: ' + data.message, 'error');
                }
            } catch (error) {
                loading.style.display = 'none';
                showResult('contactResult', '❌ خطأ في الاتصال: ' + error.message, 'error');
            }
        }

        // Test importer request
        async function testImporterRequest() {
            const loading = document.getElementById('importerLoading');
            const result = document.getElementById('importerResult');
            
            loading.style.display = 'block';
            result.style.display = 'none';
            
            try {
                const response = await fetch('/email-test/test-importer-request', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    }
                });
                
                const data = await response.json();
                loading.style.display = 'none';
                
                if (data.success) {
                    showResult('importerResult', '✅ تم إرسال إيميل طلب مستورد بنجاح!', 'success');
                } else {
                    showResult('importerResult', '❌ فشل في إرسال إيميل طلب مستورد: ' + data.message, 'error');
                }
            } catch (error) {
                loading.style.display = 'none';
                showResult('importerResult', '❌ خطأ في الاتصال: ' + error.message, 'error');
            }
        }

        // Test custom notification
        async function testCustomNotification() {
            const loading = document.getElementById('customLoading');
            const result = document.getElementById('customResult');
            
            const email = document.getElementById('notificationEmail').value;
            const subject = document.getElementById('notificationSubject').value;
            const message = document.getElementById('notificationMessage').value;
            const type = document.getElementById('notificationType').value;
            
            if (!email || !subject || !message) {
                showResult('customResult', '❌ يرجى ملء جميع الحقول المطلوبة', 'error');
                return;
            }
            
            loading.style.display = 'block';
            result.style.display = 'none';
            
            try {
                const response = await fetch('/email-test/send-notification', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        subject: subject,
                        message: message,
                        type: type
                    })
                });
                
                const data = await response.json();
                loading.style.display = 'none';
                
                if (data.success) {
                    showResult('customResult', '✅ تم إرسال الإشعار المخصص بنجاح!', 'success');
                } else {
                    showResult('customResult', '❌ فشل في إرسال الإشعار المخصص: ' + data.message, 'error');
                }
            } catch (error) {
                loading.style.display = 'none';
                showResult('customResult', '❌ خطأ في الاتصال: ' + error.message, 'error');
            }
        }

        // Test system alert
        async function testSystemAlert() {
            const loading = document.getElementById('alertLoading');
            const result = document.getElementById('alertResult');
            
            const subject = document.getElementById('alertSubject').value;
            const message = document.getElementById('alertMessage').value;
            const level = document.getElementById('alertLevel').value;
            
            if (!subject || !message) {
                showResult('alertResult', '❌ يرجى ملء جميع الحقول المطلوبة', 'error');
                return;
            }
            
            loading.style.display = 'block';
            result.style.display = 'none';
            
            try {
                const response = await fetch('/email-test/send-alert', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        subject: subject,
                        message: message,
                        level: level
                    })
                });
                
                const data = await response.json();
                loading.style.display = 'none';
                
                if (data.success) {
                    showResult('alertResult', '✅ تم إرسال تنبيه النظام بنجاح!', 'success');
                } else {
                    showResult('alertResult', '❌ فشل في إرسال تنبيه النظام: ' + data.message, 'error');
                }
            } catch (error) {
                loading.style.display = 'none';
                showResult('alertResult', '❌ خطأ في الاتصال: ' + error.message, 'error');
            }
        }

        // Show result
        function showResult(elementId, message, type) {
            const element = document.getElementById(elementId);
            element.textContent = message;
            element.className = 'result ' + type;
            element.style.display = 'block';
        }
    </script>
</body>
</html>
