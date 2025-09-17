@extends('layouts.dashboard')

@section('title', 'الواتساب')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'الواتساب')
@section('page-subtitle', 'التواصل مع المستوردين وفريق التسويق والمبيعات')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- الإحصائيات السريعة -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon primary me-3">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['total_messages'] }}</h3>
                        <p class="text-muted mb-0">إجمالي الرسائل</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon success me-3">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['inbound_messages'] }}</h3>
                        <p class="text-muted mb-0">الرسائل الواردة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon info me-3">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['outbound_messages'] }}</h3>
                        <p class="text-muted mb-0">الرسائل الصادرة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon warning me-3">
                        <i class="fas fa-envelope-open"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['unread_messages'] }}</h3>
                        <p class="text-muted mb-0">رسائل غير مقروءة</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- قائمة المحادثات -->
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fab fa-whatsapp me-2 text-success"></i>
                            المحادثات
                        </h5>
                        <div class="btn-group">
                            <a href="{{ route('admin.whatsapp.test') }}" class="btn btn-sm btn-success">
                                <i class="fas fa-vial"></i>
                                اختبار
                            </a>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- الفلاتر -->
                    <div class="p-3 border-bottom">
                        <div class="row g-2">
                            <div class="col-12">
                                <input type="text" class="form-control form-control-sm" placeholder="البحث في المحادثات..." id="conversationSearch">
                            </div>
                            <div class="col-6">
                                <select class="form-select form-select-sm" id="contactTypeFilter">
                                    <option value="">جميع الأنواع</option>
                                    <option value="importer">مستوردين</option>
                                    <option value="marketing">تسويق</option>
                                    <option value="sales">مبيعات</option>
                                    <option value="customer">عملاء</option>
                                    <option value="external">خارجي</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <select class="form-select form-select-sm" id="directionFilter">
                                    <option value="">جميع الاتجاهات</option>
                                    <option value="inbound">واردة</option>
                                    <option value="outbound">صادرة</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- قائمة المحادثات -->
                    <div class="conversations-list" style="max-height: 500px; overflow-y: auto;">
                        @if($messages->count() > 0)
                            @php
                                $conversations = $messages->groupBy(function($message) {
                                    return $message->direction === 'inbound' ? $message->from_number : $message->to_number;
                                });
                            @endphp
                            
                            @foreach($conversations as $phoneNumber => $conversationMessages)
                                @php
                                    $lastMessage = $conversationMessages->first();
                                    $contact = $contacts->firstWhere('phone', $phoneNumber);
                                    $unreadCount = $conversationMessages->where('direction', 'inbound')->where('status', 'delivered')->count();
                                @endphp
                                
                                <div class="conversation-item p-3 border-bottom" data-phone="{{ $phoneNumber }}" style="cursor: pointer;">
                                    <div class="d-flex align-items-center">
                                        <div class="conversation-avatar me-3">
                                            <i class="fas fa-user-circle fa-2x text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">{{ $contact['name'] ?? 'جهة اتصال غير معروفة' }}</h6>
                                                    <small class="text-muted">{{ $phoneNumber }}</small>
                                                </div>
                                                @if($unreadCount > 0)
                                                    <span class="badge bg-danger">{{ $unreadCount }}</span>
                                                @endif
                                            </div>
                                            <p class="mb-0 text-muted small">
                                                {{ Str::limit($lastMessage->message_content, 50) }}
                                            </p>
                                            <small class="text-muted">
                                                {{ $lastMessage->sent_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fab fa-whatsapp fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">لا توجد محادثات</h6>
                                <p class="text-muted mb-0">ابدأ بإرسال رسالة جديدة</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- منطقة المحادثة -->
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-comments me-2 text-primary"></i>
                        المحادثة
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div id="conversationArea" class="text-center py-5">
                        <i class="fas fa-comments fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">اختر محادثة للبدء</h4>
                        <p class="text-muted">اختر محادثة من القائمة الجانبية لعرض الرسائل</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal إرسال رسالة جديدة -->
    <div class="modal fade" id="newMessageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">إرسال رسالة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="newMessageForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">جهة الاتصال</label>
                            <select name="contact_id" class="form-select" required>
                                <option value="">اختر جهة الاتصال</option>
                                @foreach($contacts as $contact)
                                    <option value="{{ $contact['id'] }}" data-phone="{{ $contact['phone'] }}" data-type="{{ $contact['type'] }}">
                                        {{ $contact['name'] }} ({{ $contact['phone'] }}) - {{ $contact['type_label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="text" name="to_number" class="form-control" placeholder="أدخل رقم الهاتف" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">نوع جهة الاتصال</label>
                            <select name="contact_type" class="form-select" required>
                                <option value="">اختر النوع</option>
                                <option value="importer">مستورد</option>
                                <option value="marketing">تسويق</option>
                                <option value="sales">مبيعات</option>
                                <option value="customer">عميل</option>
                                <option value="external">خارجي</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">الرسالة</label>
                            <textarea name="message_content" class="form-control" rows="4" placeholder="أدخل نص الرسالة" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fab fa-whatsapp me-2"></i>
                            إرسال
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.conversation-item:hover {
    background-color: #f8f9fa;
}

.conversation-avatar {
    text-align: center;
}

.stats-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stats-icon.primary { background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; }
.stats-icon.success { background-color: rgba(25, 135, 84, 0.1); color: #198754; }
.stats-icon.info { background-color: rgba(13, 202, 240, 0.1); color: #0dcaf0; }
.stats-icon.warning { background-color: rgba(255, 193, 7, 0.1); color: #ffc107; }
</style>
@endpush

@push('scripts')
<script>
    // تحميل المحادثة عند النقر على جهة اتصال
    document.querySelectorAll('.conversation-item').forEach(item => {
        item.addEventListener('click', function() {
            const phoneNumber = this.dataset.phone;
            loadConversation(phoneNumber);
        });
    });

    // تحميل المحادثة
    function loadConversation(phoneNumber) {
        // إخفاء رسالة "اختر محادثة"
        document.getElementById('conversationArea').style.display = 'none';
        
        // تحميل المحادثة عبر AJAX
        fetch(`/admin/whatsapp/conversation/${phoneNumber}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('conversationArea').innerHTML = html;
                document.getElementById('conversationArea').style.display = 'block';
            })
            .catch(error => {
                console.error('Error loading conversation:', error);
            });
    }

    // إرسال رسالة جديدة
    document.getElementById('newMessageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('/admin/whatsapp/send', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // إغلاق المودال
                bootstrap.Modal.getInstance(document.getElementById('newMessageModal')).hide();
                
                // إعادة تحميل الصفحة
                location.reload();
            } else {
                alert('حدث خطأ في إرسال الرسالة');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ في إرسال الرسالة');
        });
    });

    // تحديث رقم الهاتف عند اختيار جهة اتصال
    document.querySelector('select[name="contact_id"]').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const phone = selectedOption.dataset.phone;
            const type = selectedOption.dataset.type;
            
            document.querySelector('input[name="to_number"]').value = phone;
            document.querySelector('select[name="contact_type"]').value = type;
        }
    });

    // البحث في المحادثات
    document.getElementById('conversationSearch').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('.conversation-item').forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // فتح الواتساب
    function openWhatsApp(phoneNumber) {
        const cleanNumber = phoneNumber.replace(/[^0-9]/g, '');
        const whatsappUrl = `https://wa.me/${cleanNumber}`;
        window.open(whatsappUrl, '_blank');
    }

    // جعل الدالة متاحة عالمياً
    window.openWhatsApp = openWhatsApp;
</script>
@endpush