@extends('layouts.dashboard')

@section('title', 'إنشاء حملة تسويقية')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'إنشاء حملة تسويقية')
@section('page-subtitle', 'إرسال رسالة تسويقية للعملاء والفرق')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.email-marketing.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right me-2"></i>
            العودة للقائمة
        </a>
    </div>
@endsection

@push('styles')
<style>
    .form-section {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    
    .form-section-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        margin: 0;
    }
    
    .form-section-body {
        padding: 2rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .form-control, .form-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .recipient-card {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .recipient-card:hover {
        border-color: #667eea;
        background-color: #f8f9ff;
    }
    
    .recipient-card.selected {
        border-color: #667eea;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%);
    }
    
    .recipient-card input[type="checkbox"] {
        transform: scale(1.2);
        margin-left: 0.5rem;
    }
    
    .recipient-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }
    
    .recipient-icon.customers {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }
    
    .recipient-icon.importers {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .recipient-icon.sales {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    .recipient-icon.marketing {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }
    
    .recipient-icon.all {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .preview-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 1rem;
    }
    
    .email-preview {
        background: white;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 0 auto;
    }
    
    .btn-send {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-send:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
    }
    
    .btn-preview {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-preview:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .character-count {
        font-size: 0.8rem;
        color: #6c757d;
        text-align: left;
    }
    
    .character-count.warning {
        color: #fd7e14;
    }
    
    .character-count.danger {
        color: #dc3545;
    }
    
    .recipient-count {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<form action="{{ route('admin.email-marketing.store') }}" method="POST" id="emailMarketingForm">
    @csrf
    
    <!-- Recipients Section -->
    <div class="form-section">
        <div class="form-section-header">
            <h4 class="mb-0">
                <i class="fas fa-users me-2"></i>
                اختيار المستلمين
            </h4>
        </div>
        <div class="form-section-body">
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="recipient-card" onclick="toggleRecipient('all')">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" name="recipients[]" value="all" id="recipient_all" class="form-check-input">
                            <div class="recipient-icon all mx-3">
                                <i class="fas fa-globe"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">جميع المستخدمين</h6>
                                <small class="text-muted">إرسال لجميع المستخدمين في النظام</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-3">
                    <div class="recipient-card" onclick="toggleRecipient('customers')">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" name="recipients[]" value="customers" id="recipient_customers" class="form-check-input">
                            <div class="recipient-icon customers mx-3">
                                <i class="fas fa-user-friends"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">العملاء</h6>
                                <small class="text-muted">إرسال للعملاء المسجلين فقط</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-3">
                    <div class="recipient-card" onclick="toggleRecipient('importers')">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" name="recipients[]" value="importers" id="recipient_importers" class="form-check-input">
                            <div class="recipient-icon importers mx-3">
                                <i class="fas fa-industry"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">المستوردين</h6>
                                <small class="text-muted">إرسال للمستوردين المسجلين</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-3">
                    <div class="recipient-card" onclick="toggleRecipient('sales')">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" name="recipients[]" value="sales" id="recipient_sales" class="form-check-input">
                            <div class="recipient-icon sales mx-3">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">فريق المبيعات</h6>
                                <small class="text-muted">إرسال لفريق المبيعات</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-3">
                    <div class="recipient-card" onclick="toggleRecipient('marketing')">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" name="recipients[]" value="marketing" id="recipient_marketing" class="form-check-input">
                            <div class="recipient-icon marketing mx-3">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">فريق التسويق</h6>
                                <small class="text-muted">إرسال لفريق التسويق</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <span class="recipient-count" id="recipientCount">0 مستلم محدد</span>
            </div>
        </div>
    </div>
    
    <!-- Email Content Section -->
    <div class="form-section">
        <div class="form-section-header">
            <h4 class="mb-0">
                <i class="fas fa-edit me-2"></i>
                محتوى الرسالة
            </h4>
        </div>
        <div class="form-section-body">
            <div class="row">
                <div class="col-12 mb-3">
                    <label for="subject" class="form-label">عنوان الرسالة</label>
                    <input type="text" class="form-control" id="subject" name="subject" 
                           placeholder="أدخل عنوان الرسالة..." required maxlength="255">
                    <div class="character-count" id="subjectCount">0/255</div>
                </div>
                
                <div class="col-12 mb-3">
                    <label for="content" class="form-label">محتوى الرسالة</label>
                    <textarea class="form-control" id="content" name="content" rows="8" 
                              placeholder="أدخل محتوى الرسالة..." required></textarea>
                    <div class="character-count" id="contentCount">0 حرف</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Preview Section -->
    <div class="form-section">
        <div class="form-section-header">
            <h4 class="mb-0">
                <i class="fas fa-eye me-2"></i>
                معاينة الرسالة
            </h4>
        </div>
        <div class="form-section-body">
            <div class="preview-section">
                <div class="email-preview" id="emailPreview">
                    <div class="text-center mb-3">
                        <h5 class="text-primary">معاينة الرسالة</h5>
                        <p class="text-muted">ستظهر معاينة الرسالة هنا</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="form-section">
        <div class="form-section-body text-center">
            <button type="button" class="btn btn-preview me-3" onclick="previewEmail()">
                <i class="fas fa-eye me-2"></i>
                معاينة الرسالة
            </button>
            <button type="submit" class="btn btn-send" id="sendBtn">
                <i class="fas fa-paper-plane me-2"></i>
                إرسال الرسالة
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Handle URL parameters for quick actions
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const type = urlParams.get('type');
    
    if (type) {
        switch(type) {
            case 'customers':
                toggleRecipient('customers');
                break;
            case 'importers':
                toggleRecipient('importers');
                break;
            case 'teams':
                toggleRecipient('sales');
                toggleRecipient('marketing');
                break;
        }
    }
});

function toggleRecipient(type) {
    const checkbox = document.getElementById(`recipient_${type}`);
    const card = checkbox.closest('.recipient-card');
    
    checkbox.checked = !checkbox.checked;
    
    if (checkbox.checked) {
        card.classList.add('selected');
    } else {
        card.classList.remove('selected');
    }
    
    updateRecipientCount();
}

function updateRecipientCount() {
    const checkedBoxes = document.querySelectorAll('input[name="recipients[]"]:checked');
    const count = checkedBoxes.length;
    const countElement = document.getElementById('recipientCount');
    
    if (count === 0) {
        countElement.textContent = '0 مستلم محدد';
    } else if (count === 1) {
        const label = checkedBoxes[0].closest('.recipient-card').querySelector('h6').textContent;
        countElement.textContent = `1 مستلم محدد: ${label}`;
    } else {
        countElement.textContent = `${count} مستلم محدد`;
    }
}

// Character counting
document.getElementById('subject').addEventListener('input', function() {
    const count = this.value.length;
    const countElement = document.getElementById('subjectCount');
    countElement.textContent = `${count}/255`;
    
    if (count > 200) {
        countElement.className = 'character-count danger';
    } else if (count > 150) {
        countElement.className = 'character-count warning';
    } else {
        countElement.className = 'character-count';
    }
});

document.getElementById('content').addEventListener('input', function() {
    const count = this.value.length;
    const countElement = document.getElementById('contentCount');
    countElement.textContent = `${count} حرف`;
    
    if (count > 1000) {
        countElement.className = 'character-count danger';
    } else if (count > 500) {
        countElement.className = 'character-count warning';
    } else {
        countElement.className = 'character-count';
    }
});

function previewEmail() {
    const subject = document.getElementById('subject').value;
    const content = document.getElementById('content').value;
    const preview = document.getElementById('emailPreview');
    
    if (!subject && !content) {
        preview.innerHTML = `
            <div class="text-center mb-3">
                <h5 class="text-primary">معاينة الرسالة</h5>
                <p class="text-muted">أدخل العنوان والمحتوى لرؤية المعاينة</p>
            </div>
        `;
        return;
    }
    
    preview.innerHTML = `
        <div class="mb-3">
            <strong>من:</strong> Infinity Wear &lt;noreply@infinitywear.sa&gt;
        </div>
        <div class="mb-3">
            <strong>إلى:</strong> المستلمين المحددين
        </div>
        <div class="mb-3">
            <strong>الموضوع:</strong> ${subject || 'بدون عنوان'}
        </div>
        <hr>
        <div class="content-preview">
            ${content ? content.replace(/\n/g, '<br>') : 'بدون محتوى'}
        </div>
    `;
}

// Form validation
document.getElementById('emailMarketingForm').addEventListener('submit', function(e) {
    const checkedBoxes = document.querySelectorAll('input[name="recipients[]"]:checked');
    const subject = document.getElementById('subject').value.trim();
    const content = document.getElementById('content').value.trim();
    
    if (checkedBoxes.length === 0) {
        e.preventDefault();
        alert('يرجى اختيار فئة واحدة على الأقل من المستلمين');
        return;
    }
    
    if (!subject) {
        e.preventDefault();
        alert('يرجى إدخال عنوان الرسالة');
        return;
    }
    
    if (!content) {
        e.preventDefault();
        alert('يرجى إدخال محتوى الرسالة');
        return;
    }
    
    // Show loading state
    const sendBtn = document.getElementById('sendBtn');
    const originalText = sendBtn.innerHTML;
    sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الإرسال...';
    sendBtn.disabled = true;
    
    // Re-enable button after 10 seconds (in case of error)
    setTimeout(() => {
        sendBtn.innerHTML = originalText;
        sendBtn.disabled = false;
    }, 10000);
});
</script>
@endpush



