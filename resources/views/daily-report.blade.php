@extends('layouts.app')

@section('title', 'التقرير اليومي')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line me-2"></i>
                        التقرير اليومي - Infinity Wear
                    </h3>
                </div>
                
                <div class="card-body">
                    <!-- معلومات التقرير -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        معلومات التقرير
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>الوصف:</strong> تقرير يومي شامل لجميع الأنشطة في الموقع</p>
                                    <p><strong>التوقيت:</strong> يتم إرساله تلقائياً في الساعة 8:00 صباحاً</p>
                                    <p><strong>المستلم:</strong> المدير (info@infinitywearsa.com)</p>
                                    <p><strong>المحتوى:</strong> ملخص شامل للطلبات، الرسائل، المهام، والتقارير</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-cogs me-2"></i>
                                        إعدادات التقرير
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p><strong>التكرار:</strong> يومياً</p>
                                    <p><strong>المنطقة الزمنية:</strong> Asia/Riyadh</p>
                                    <p><strong>التنسيق:</strong> HTML مع جداول منظمة</p>
                                    <p><strong>اللغة:</strong> العربية</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- اختبار التقرير -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        اختبار التقرير اليومي
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form id="daily-report-form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="report-email" class="form-label">البريد الإلكتروني المستهدف</label>
                                                    <input type="email" class="form-control" id="report-email" name="email" 
                                                           value="info@infinitywearsa.com" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="report-date" class="form-label">التاريخ (اختياري)</label>
                                                    <input type="date" class="form-control" id="report-date" name="date" 
                                                           value="{{ date('Y-m-d', strtotime('-1 day')) }}">
                                                    <small class="form-text text-muted">اتركه فارغاً لإرسال تقرير أمس</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-send me-1"></i>
                                                إرسال التقرير
                                            </button>
                                            <a href="/daily-report/preview" target="_blank" class="btn btn-info">
                                                <i class="fas fa-eye me-1"></i>
                                                معاينة التقرير
                                            </a>
                                        </div>
                                    </form>
                                    
                                    <div id="report-result" class="alert mt-3" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- معلومات إضافية -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-list me-2"></i>
                                        محتويات التقرير
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>البيانات الأساسية:</h6>
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-check text-success me-2"></i> ملخص عام للأنشطة</li>
                                                <li><i class="fas fa-check text-success me-2"></i> إحصائيات الطلبات</li>
                                                <li><i class="fas fa-check text-success me-2"></i> رسائل الاتصال</li>
                                                <li><i class="fas fa-check text-success me-2"></i> رسائل الواتساب</li>
                                                <li><i class="fas fa-check text-success me-2"></i> طلبات المستوردين</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>البيانات الإضافية:</h6>
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-check text-success me-2"></i> المهام والأنشطة</li>
                                                <li><i class="fas fa-check text-success me-2"></i> التقارير التسويقية</li>
                                                <li><i class="fas fa-check text-success me-2"></i> تقارير المبيعات</li>
                                                <li><i class="fas fa-check text-success me-2"></i> الإشعارات</li>
                                                <li><i class="fas fa-check text-success me-2"></i> العناصر المعلقة</li>
                                            </ul>
                                        </div>
                                    </div>
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
// إرسال التقرير اليومي
document.getElementById('daily-report-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const resultDiv = document.getElementById('report-result');
    
    resultDiv.style.display = 'block';
    resultDiv.className = 'alert alert-info';
    resultDiv.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جاري إرسال التقرير...';
    
    fetch('/daily-report/send', {
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
                <strong>تم إرسال التقرير بنجاح!</strong><br>
                تم إرسال التقرير إلى: ${formData.get('email')}<br>
                التاريخ: ${formData.get('date') || 'أمس'}
            `;
        } else {
            resultDiv.className = 'alert alert-danger';
            resultDiv.innerHTML = `
                <i class="fas fa-times-circle me-2"></i>
                <strong>فشل في إرسال التقرير!</strong><br>
                ${data.message || 'حدث خطأ غير متوقع'}
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
</script>
@endsection
