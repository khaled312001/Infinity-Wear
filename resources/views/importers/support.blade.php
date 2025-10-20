@extends('layouts.dashboard')

@section('title', 'الدعم الفني - لوحة تحكم المستورد')
@section('dashboard-title', 'لوحة المستورد')
@section('page-title', 'الدعم الفني')
@section('page-subtitle', 'تواصل مع فريق الدعم لحل مشاكلك')

@section('content')
<div class="container-fluid">
    <!-- إحصائيات التذاكر -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-ticket-alt fa-2x text-primary me-3"></i>
                        <div>
                            <h4 class="mb-0">{{ $ticketStats['totalCount'] ?? $supportTickets->total() }}</h4>
                            <small class="text-muted">إجمالي التذاكر</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-clock fa-2x text-warning me-3"></i>
                        <div>
                            <h4 class="mb-0">{{ $ticketStats['openCount'] ?? 0 }}</h4>
                            <small class="text-muted">مفتوحة</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-cog fa-2x text-info me-3"></i>
                        <div>
                            <h4 class="mb-0">{{ $ticketStats['inProgressCount'] ?? 0 }}</h4>
                            <small class="text-muted">قيد المعالجة</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-check-circle fa-2x text-success me-3"></i>
                        <div>
                            <h4 class="mb-0">{{ $ticketStats['resolvedCount'] ?? 0 }}</h4>
                            <small class="text-muted">محلولة</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- إنشاء تذكرة جديدة -->
        <div class="col-lg-4 mb-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus-circle me-2"></i>
                        إنشاء تذكرة دعم جديدة
                    </h5>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('importers.support.create-ticket') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="subject" class="form-label">موضوع التذكرة</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label">فئة المشكلة</label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">اختر الفئة</option>
                                <option value="technical">مشكلة تقنية</option>
                                <option value="billing">مشكلة في الفواتير</option>
                                <option value="shipping">مشكلة في الشحن</option>
                                <option value="general">استفسار عام</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="priority" class="form-label">الأولوية</label>
                            <select class="form-select" id="priority" name="priority" required>
                                <option value="low">منخفضة</option>
                                <option value="medium" selected>متوسطة</option>
                                <option value="high">عالية</option>
                                <option value="urgent">عاجلة</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">وصف المشكلة</label>
                            <textarea class="form-control" id="description" name="description" rows="4" 
                                      placeholder="اشرح مشكلتك بالتفصيل..." required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="attachments" class="form-label">مرفقات (اختياري)</label>
                            <input type="file" class="form-control" id="attachments" name="attachments[]" 
                                   multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            <small class="text-muted">يمكن رفع حتى 5 ملفات، الحد الأقصى 5MB لكل ملف</small>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>
                                إرسال التذكرة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- قائمة التذاكر -->
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        تذاكر الدعم
                    </h5>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-secondary" onclick="refreshTickets()">
                            <i class="fas fa-sync-alt me-1"></i>
                            تحديث
                        </button>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    @if($supportTickets->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>رقم التذكرة</th>
                                        <th>الموضوع</th>
                                        <th>الحالة</th>
                                        <th>الأولوية</th>
                                        <th>تاريخ الإنشاء</th>
                                        <th>آخر رد</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($supportTickets as $ticket)
                                        <tr>
                                            <td>
                                                <strong>#{{ $ticket->id }}</strong>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-ticket-alt me-2 text-muted"></i>
                                                    <span>{{ $ticket->subject }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @switch($ticket->status)
                                                    @case('open')
                                                        <span class="badge bg-warning">مفتوحة</span>
                                                        @break
                                                    @case('in_progress')
                                                        <span class="badge bg-info">قيد المعالجة</span>
                                                        @break
                                                    @case('resolved')
                                                        <span class="badge bg-success">محلولة</span>
                                                        @break
                                                    @case('closed')
                                                        <span class="badge bg-secondary">مغلقة</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($ticket->priority)
                                                    @case('low')
                                                        <span class="badge bg-success">منخفضة</span>
                                                        @break
                                                    @case('medium')
                                                        <span class="badge bg-warning">متوسطة</span>
                                                        @break
                                                    @case('high')
                                                        <span class="badge bg-danger">عالية</span>
                                                        @break
                                                    @case('urgent')
                                                        <span class="badge bg-dark">عاجلة</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ optional($ticket->created_at)->format('Y-m-d') }}<br>
                                                    {{ optional($ticket->created_at)->format('H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ optional($ticket->updated_at ?? $ticket->replied_at ?? $ticket->read_at ?? $ticket->created_at)->diffForHumans() }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button class="btn btn-outline-primary" 
                                                            onclick="viewTicket('{{ $ticket->id }}')" 
                                                            title="عرض التفاصيل">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-success" 
                                                            onclick="replyTicket('{{ $ticket->id }}')" 
                                                            title="رد">
                                                        <i class="fas fa-reply"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3">
                            {{ $supportTickets->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد تذاكر دعم</h5>
                            <p class="text-muted">لم تقم بإنشاء أي تذاكر دعم بعد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- معلومات الدعم -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        معلومات الدعم الفني
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <i class="fas fa-clock fa-2x text-primary mb-2"></i>
                                <h6>أوقات العمل</h6>
                                <p class="text-muted small">الأحد - الخميس<br>8:00 ص - 6:00 م</p>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <i class="fas fa-phone fa-2x text-success mb-2"></i>
                                <h6>الهاتف</h6>
                                <p class="text-muted small">+966500982394</p>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <i class="fas fa-envelope fa-2x text-info mb-2"></i>
                                <h6>البريد الإلكتروني</h6>
                                <p class="text-muted small">support@infinitywear.sa</p>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <i class="fab fa-whatsapp fa-2x text-success mb-2"></i>
                                <h6>واتساب</h6>
                                <p class="text-muted small">+966500982394</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal عرض تفاصيل التذكرة -->
<div class="modal fade" id="ticketModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تفاصيل التذكرة #<span id="ticketId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="ticketDetails">
                    <!-- محتوى التذكرة -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary" onclick="replyTicket()">
                    <i class="fas fa-reply me-1"></i>
                    رد
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal الرد على التذكرة -->
<div class="modal fade" id="replyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">الرد على التذكرة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="replyForm">
                    <div class="mb-3">
                        <label for="replyMessage" class="form-label">الرسالة</label>
                        <textarea class="form-control" id="replyMessage" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="replyAttachments" class="form-label">مرفقات (اختياري)</label>
                        <input type="file" class="form-control" id="replyAttachments" name="attachments[]" multiple>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" onclick="sendReply()">
                    <i class="fas fa-paper-plane me-1"></i>
                    إرسال الرد
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.badge {
    font-size: 0.75em;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}

.dashboard-card .card-body {
    padding: 1.5rem;
}
</style>

<script>
function viewTicket(ticketId) {
    // محاكاة جلب تفاصيل التذكرة
    document.getElementById('ticketId').textContent = ticketId;
    document.getElementById('ticketDetails').innerHTML = `
        <div class="ticket-info mb-4">
            <div class="row">
                <div class="col-md-6">
                    <strong>الموضوع:</strong> مشكلة في تحميل الفاتورة
                </div>
                <div class="col-md-6">
                    <strong>الحالة:</strong> <span class="badge bg-warning">مفتوحة</span>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <strong>الأولوية:</strong> <span class="badge bg-danger">عالية</span>
                </div>
                <div class="col-md-6">
                    <strong>تاريخ الإنشاء:</strong> ${new Date().toLocaleDateString('ar-SA')}
                </div>
            </div>
        </div>
        
        <div class="ticket-messages">
            <h6>المحادثة:</h6>
            <div class="message mb-3 p-3 bg-light rounded">
                <div class="d-flex justify-content-between">
                    <strong>أنت</strong>
                    <small class="text-muted">${new Date().toLocaleString('ar-SA')}</small>
                </div>
                <p class="mb-0 mt-2">لا أستطيع تحميل الفاتورة من الموقع. يظهر خطأ عند الضغط على زر التحميل.</p>
            </div>
            
            <div class="message mb-3 p-3 bg-primary text-white rounded">
                <div class="d-flex justify-content-between">
                    <strong>فريق الدعم</strong>
                    <small>${new Date().toLocaleString('ar-SA')}</small>
                </div>
                <p class="mb-0 mt-2">نعتذر عن هذه المشكلة. يرجى تجربة المتصفح Chrome أو Firefox. إذا استمرت المشكلة، يرجى إرسال لقطة شاشة للخطأ.</p>
            </div>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('ticketModal'));
    modal.show();
}

function replyTicket(ticketId) {
    const modal = new bootstrap.Modal(document.getElementById('replyModal'));
    modal.show();
}

function sendReply() {
    const message = document.getElementById('replyMessage').value;
    if (!message.trim()) {
        alert('يرجى كتابة رسالة');
        return;
    }
    
    // محاكاة إرسال الرد
    alert('تم إرسال الرد بنجاح');
    
    const modal = bootstrap.Modal.getInstance(document.getElementById('replyModal'));
    modal.hide();
    
    // إعادة تحميل الصفحة
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

function refreshTickets() {
    window.location.reload();
}

// تحديث تلقائي للتذاكر كل دقيقة
setInterval(function() {
    console.log('تحديث التذاكر...');
}, 60000);
</script>
@endsection
