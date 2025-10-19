<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار نظام الإشعارات - Infinity Wear</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
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

        .test-section {
            margin-bottom: 40px;
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            border-left: 5px solid #667eea;
        }

        .test-section h3 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .test-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .test-card {
            background: white;
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

        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .status-online {
            background: #28a745;
        }

        .status-offline {
            background: #dc3545;
        }

        .status-unknown {
            background: #ffc107;
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
            <h1>🔔 اختبار نظام الإشعارات</h1>
            <p>Infinity Wear - Email & Push Notifications Testing</p>
        </div>

        <div class="content">
            <!-- System Status -->
            <div class="test-section">
                <h3>📊 حالة النظام</h3>
                <div id="systemStatus">
                    <p><span class="status-indicator status-unknown"></span>جاري فحص حالة النظام...</p>
                </div>
            </div>

            <!-- Email Tests -->
            <div class="test-section">
                <h3>📧 اختبارات الإيميل</h3>
                <div class="test-grid">
                    <!-- Basic Email Test -->
                    <div class="test-card">
                        <h4>📤 اختبار إيميل أساسي</h4>
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
                </div>
            </div>

            <!-- Push Notifications Tests -->
            <div class="test-section">
                <h3>🔔 اختبارات الإشعارات الفورية</h3>
                <div class="test-grid">
                    <!-- Test Push Notification -->
                    <div class="test-card">
                        <h4>📱 اختبار إشعار فوري</h4>
                        <p>إرسال إشعار فوري مباشر</p>
                        <div class="form-group">
                            <label>العنوان:</label>
                            <input type="text" id="pushTitle" value="اختبار إشعار فوري - Infinity Wear" placeholder="عنوان الإشعار">
                        </div>
                        <div class="form-group">
                            <label>الرسالة:</label>
                            <textarea id="pushMessage" placeholder="اكتب رسالتك هنا...">هذا اختبار للإشعارات الفورية من نظام Infinity Wear</textarea>
                        </div>
                        <div class="form-group">
                            <label>المجموعة المستهدفة:</label>
                            <select id="pushInterests">
                                <option value="notifications">عام</option>
                                <option value="admin-notifications">المديرين</option>
                                <option value="contact-form">نموذج التواصل</option>
                                <option value="importer-requests">طلبات المستوردين</option>
                                <option value="task-updates">تحديثات المهام</option>
                            </select>
                        </div>
                        <button class="btn" onclick="testPushNotification()">إرسال إشعار فوري</button>
                        <div class="loading" id="pushLoading">
                            <div class="spinner"></div>
                        </div>
                        <div class="result" id="pushResult"></div>
                    </div>

                    <!-- Test System Alert -->
                    <div class="test-card">
                        <h4>⚠️ اختبار تنبيه النظام</h4>
                        <p>إرسال تنبيه نظام للمدير</p>
                        <div class="form-group">
                            <label>العنوان:</label>
                            <input type="text" id="alertTitle" value="تنبيه نظام - اختبار" placeholder="عنوان التنبيه">
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

                    <!-- Notification Permission -->
                    <div class="test-card">
                        <h4>🔐 إدارة صلاحيات الإشعارات</h4>
                        <p>تفعيل أو إلغاء صلاحيات الإشعارات</p>
                        <button class="btn btn-success" onclick="requestNotificationPermission()">طلب صلاحية الإشعارات</button>
                        <button class="btn btn-warning" onclick="checkNotificationStatus()">فحص حالة الصلاحيات</button>
                        <div class="result" id="permissionResult"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p><strong>Infinity Wear</strong> - نظام الإشعارات المتكامل | تم التطوير بواسطة فريق Infinity Wear</p>
        </div>
    </div>

    <script>
        // Set CSRF token for all requests
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Load system status on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadSystemStatus();
        });

        // Load system status
        async function loadSystemStatus() {
            try {
                const response = await fetch('/api/pusher/stats');
                const data = await response.json();
                
                if (data.status === 'active') {
                    document.getElementById('systemStatus').innerHTML = `
                        <p><span class="status-indicator status-online"></span>النظام يعمل بشكل طبيعي</p>
                        <p><strong>Instance ID:</strong> ${data.instance_id}</p>
                        <p><strong>المجموعات المدعومة:</strong> ${data.supported_interests.join(', ')}</p>
                    `;
                } else {
                    document.getElementById('systemStatus').innerHTML = `
                        <p><span class="status-indicator status-offline"></span>النظام غير متاح</p>
                    `;
                }
            } catch (error) {
                document.getElementById('systemStatus').innerHTML = `
                    <p><span class="status-indicator status-offline"></span>خطأ في الاتصال: ${error.message}</p>
                `;
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

        // Test push notification
        async function testPushNotification() {
            const loading = document.getElementById('pushLoading');
            const result = document.getElementById('pushResult');
            
            const title = document.getElementById('pushTitle').value;
            const message = document.getElementById('pushMessage').value;
            const interests = document.getElementById('pushInterests').value;
            
            if (!title || !message) {
                showResult('pushResult', '❌ يرجى ملء جميع الحقول المطلوبة', 'error');
                return;
            }
            
            loading.style.display = 'block';
            result.style.display = 'none';
            
            try {
                const response = await fetch('/api/pusher/test', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        title: title,
                        message: message,
                        interests: [interests]
                    })
                });
                
                const data = await response.json();
                loading.style.display = 'none';
                
                if (data.success) {
                    showResult('pushResult', '✅ تم إرسال الإشعار الفوري بنجاح!', 'success');
                } else {
                    showResult('pushResult', '❌ فشل في إرسال الإشعار الفوري: ' + data.message, 'error');
                }
            } catch (error) {
                loading.style.display = 'none';
                showResult('pushResult', '❌ خطأ في الاتصال: ' + error.message, 'error');
            }
        }

        // Test system alert
        async function testSystemAlert() {
            const loading = document.getElementById('alertLoading');
            const result = document.getElementById('alertResult');
            
            const title = document.getElementById('alertTitle').value;
            const message = document.getElementById('alertMessage').value;
            const level = document.getElementById('alertLevel').value;
            
            if (!title || !message) {
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
                        subject: title,
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

        // Request notification permission
        function requestNotificationPermission() {
            if ('Notification' in window) {
                if (Notification.permission === 'default') {
                    Notification.requestPermission().then(function(permission) {
                        if (permission === 'granted') {
                            showResult('permissionResult', '✅ تم تفعيل الإشعارات بنجاح!', 'success');
                        } else {
                            showResult('permissionResult', '❌ تم رفض الإشعارات', 'error');
                        }
                    });
                } else if (Notification.permission === 'granted') {
                    showResult('permissionResult', '✅ الإشعارات مفعلة بالفعل', 'success');
                } else {
                    showResult('permissionResult', '❌ الإشعارات معطلة. يرجى تفعيلها من إعدادات المتصفح', 'error');
                }
            } else {
                showResult('permissionResult', '❌ المتصفح لا يدعم الإشعارات', 'error');
            }
        }

        // Check notification status
        function checkNotificationStatus() {
            if ('Notification' in window) {
                const status = Notification.permission;
                const statusText = {
                    'granted': '✅ مفعلة',
                    'denied': '❌ معطلة',
                    'default': '⚠️ لم يتم الطلب بعد'
                };
                
                showResult('permissionResult', `حالة الإشعارات: ${statusText[status]}`, status === 'granted' ? 'success' : 'info');
            } else {
                showResult('permissionResult', '❌ المتصفح لا يدعم الإشعارات', 'error');
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
