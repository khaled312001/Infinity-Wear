@extends('layouts.dashboard')

@section('title', 'اختبار الواتساب')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fab fa-whatsapp text-success"></i>
                        اختبار الواتساب
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> معلومات النظام</h5>
                        <p><strong>الرقم الأساسي للواتساب:</strong> +{{ config('whatsapp.primary_number', '966599476482') }}</p>
                        <p>يمكنك استخدام هذا الرقم لإرسال واستقبال الرسائل</p>
                    </div>

                    <div class="alert alert-success">
                        <h5><i class="icon fas fa-star"></i> التوصية: AiSensy (مجاني مدى الحياة)</h5>
                        <p>لإرسال الرسائل فعلياً، ننصح بـ:</p>
                        <ol>
                            <li>التسجيل في <a href="https://app.aisensy.com/signup" target="_blank" class="btn btn-sm btn-success">AiSensy (مجاني للأبد)</a></li>
                            <li>التقدم بطلب للحصول على WhatsApp Business API مجاني</li>
                            <li>ربط رقم الواتساب (+966 59 947 6482)</li>
                            <li>إضافة API Token في ملف .env</li>
                        </ol>
                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-warning" onclick="testConnection()">
                                <i class="fas fa-wifi"></i>
                                اختبار الاتصال
                            </button>
                            <a href="https://app.aisensy.com/signup" target="_blank" class="btn btn-sm btn-success">
                                <i class="fas fa-external-link-alt"></i>
                                سجل في AiSensy مجاناً
                            </a>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info-circle"></i> بديل: Whapi.Cloud</h5>
                        <p>إذا كنت تفضل Whapi.Cloud:</p>
                        <ol>
                            <li>التسجيل في <a href="https://whapi.cloud" target="_blank">Whapi.Cloud</a></li>
                            <li>ربط رقم الواتساب (+966 59 947 6482)</li>
                            <li>تغيير <code>WHATSAPP_API_PROVIDER=whapi</code> في ملف .env</li>
                            <li>إضافة API Token في ملف .env</li>
                        </ol>
                    </div>

                    <form id="testMessageForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="to_number">رقم المستقبل</label>
                                    <input type="text" class="form-control" id="to_number" name="to_number" 
                                           placeholder="مثال: +966501234567" required>
                                    <small class="form-text text-muted">أدخل رقم الهاتف مع رمز البلد</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="message_content">نص الرسالة</label>
                                    <textarea class="form-control" id="message_content" name="message_content" 
                                              rows="3" placeholder="اكتب رسالتك هنا..." required></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="fab fa-whatsapp"></i>
                                إرسال رسالة تجريبية
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="clearForm()">
                                <i class="fas fa-eraser"></i>
                                مسح النموذج
                            </button>
                        </div>
                    </form>

                    <div id="result" class="mt-4" style="display: none;">
                        <div class="alert alert-success">
                            <h5><i class="icon fas fa-check"></i> تم الإرسال بنجاح</h5>
                            <div id="resultContent"></div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>روابط سريعة للاختبار:</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="https://wa.me/{{ config('whatsapp.primary_number', '966599476482') }}" 
                                   target="_blank" class="btn btn-outline-success btn-block">
                                    <i class="fab fa-whatsapp"></i>
                                    فتح الواتساب
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('admin.whatsapp.index') }}" class="btn btn-outline-primary btn-block">
                                    <i class="fas fa-comments"></i>
                                    عرض جميع الرسائل
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('testMessageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const resultDiv = document.getElementById('result');
    const resultContent = document.getElementById('resultContent');
    
    // إظهار loading
    resultDiv.style.display = 'block';
    resultContent.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...';
    
    fetch('{{ route("admin.whatsapp.test") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultContent.innerHTML = `
                <p><strong>معرف الرسالة:</strong> ${data.data.message_id}</p>
                <p><strong>من:</strong> +${data.data.from_number}</p>
                <p><strong>إلى:</strong> +${data.data.to_number}</p>
                <p><strong>رابط الواتساب:</strong> <a href="${data.data.whatsapp_url}" target="_blank">فتح في الواتساب</a></p>
            `;
            resultDiv.className = 'mt-4 alert alert-success';
        } else {
            resultContent.innerHTML = `<p>خطأ: ${data.message}</p>`;
            resultDiv.className = 'mt-4 alert alert-danger';
        }
    })
    .catch(error => {
        resultContent.innerHTML = `<p>خطأ في الاتصال: ${error.message}</p>`;
        resultDiv.className = 'mt-4 alert alert-danger';
    });
});

function clearForm() {
    document.getElementById('testMessageForm').reset();
    document.getElementById('result').style.display = 'none';
}

function testConnection() {
    const resultDiv = document.getElementById('result');
    const resultContent = document.getElementById('resultContent');
    
    // إظهار loading
    resultDiv.style.display = 'block';
    resultContent.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري اختبار الاتصال...';
    
    fetch('{{ route("admin.whatsapp.test.connection") }}', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            resultContent.innerHTML = `
                <h5><i class="icon fas fa-check text-success"></i> ${data.message}</h5>
                <p><strong>حالة API:</strong> متصل</p>
                <p><strong>البيانات:</strong> <pre>${JSON.stringify(data.data, null, 2)}</pre></p>
            `;
            resultDiv.className = 'mt-4 alert alert-success';
        } else {
            resultContent.innerHTML = `
                <h5><i class="icon fas fa-times text-danger"></i> ${data.message}</h5>
                <p><strong>الخطأ:</strong> ${data.error || 'غير محدد'}</p>
            `;
            resultDiv.className = 'mt-4 alert alert-danger';
        }
    })
    .catch(error => {
        resultContent.innerHTML = `<h5><i class="icon fas fa-times text-danger"></i> خطأ في الاتصال</h5><p>${error.message}</p>`;
        resultDiv.className = 'mt-4 alert alert-danger';
    });
}
</script>
@endsection