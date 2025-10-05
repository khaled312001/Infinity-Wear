@extends('layouts.dashboard')

@section('title', 'الإشعارات')
@section('page-title', 'الإشعارات')
@section('page-subtitle', 'إدارة جميع الإشعارات')

@section('content')
<div class="row">
    <!-- إحصائيات الإشعارات -->
    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-md-3">
                <div class="stats-card enhanced">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon primary me-3">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div>
                            <h3 class="stats-number">{{ $stats['total_unread'] }}</h3>
                            <p class="stats-label">إجمالي غير المقروءة</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card enhanced">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon success me-3">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div>
                            <h3 class="stats-number">{{ $stats['orders'] }}</h3>
                            <p class="stats-label">طلبات جديدة</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card enhanced">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon info me-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h3 class="stats-number">{{ $stats['contacts'] }}</h3>
                            <p class="stats-label">رسائل اتصال</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card enhanced">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon warning me-3">
                            <i class="fas fa-industry"></i>
                        </div>
                        <div>
                            <h3 class="stats-number">{{ $stats['importer_orders'] }}</h3>
                            <p class="stats-label">طلبات مستوردين</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- فلترة الإشعارات -->
    <div class="col-12 mb-4">
        <div class="dashboard-card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.notifications.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="type" class="form-label">نوع الإشعار</label>
                        <select name="type" id="type" class="form-select">
                            <option value="">جميع الأنواع</option>
                            <option value="order" {{ request('type') == 'order' ? 'selected' : '' }}>طلبات</option>
                            <option value="contact" {{ request('type') == 'contact' ? 'selected' : '' }}>رسائل اتصال</option>
                            <option value="whatsapp" {{ request('type') == 'whatsapp' ? 'selected' : '' }}>واتساب</option>
                            <option value="importer_order" {{ request('type') == 'importer_order' ? 'selected' : '' }}>طلبات مستوردين</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">الحالة</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">جميع الحالات</option>
                            <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>غير مقروءة</option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>مقروءة</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>فلترة
                            </button>
                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>مسح
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-success" onclick="markAllAsRead()">
                                <i class="fas fa-check-double me-1"></i>تحديد الكل كمقروء
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- قائمة الإشعارات -->
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bell me-2"></i>
                    قائمة الإشعارات
                </h5>
            </div>
            <div class="card-body p-0">
                @if($notifications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>النوع</th>
                                    <th>العنوان</th>
                                    <th>الرسالة</th>
                                    <th>التاريخ</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $notification)
                                    <tr class="{{ !$notification->is_read ? 'table-warning' : '' }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="notification-icon me-2">
                                                    <i class="{{ $notification->icon }} text-{{ $notification->color }}"></i>
                                                </div>
                                                <span class="badge bg-{{ $notification->color }}">
                                                    @switch($notification->type)
                                                        @case('order') طلب @break
                                                        @case('contact') اتصال @break
                                                        @case('whatsapp') واتساب @break
                                                        @case('importer_order') مستورد @break
                                                        @default {{ $notification->type }}
                                                    @endswitch
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ $notification->title }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ Str::limit($notification->message, 50) }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($notification->is_read)
                                                <span class="badge bg-success">مقروءة</span>
                                            @else
                                                <span class="badge bg-warning">غير مقروءة</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-info" onclick="previewNotification({{ $notification->id }})" title="معاينة">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if(!$notification->is_read)
                                                    <button class="btn btn-outline-primary" onclick="markAsRead({{ $notification->id }})" title="تحديد كمقروء">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                                <button class="btn btn-outline-danger" onclick="archiveNotification({{ $notification->id }})" title="أرشفة">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="card-footer">
                        {{ $notifications->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center p-5">
                        <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">لا توجد إشعارات</h5>
                        <p class="text-muted">لم يتم العثور على أي إشعارات تطابق المعايير المحددة</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal للمعاينة -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">
                    <i class="fas fa-eye me-2"></i>معاينة الإشعار
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <div class="text-center p-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">جاري التحميل...</span>
                    </div>
                    <p class="mt-2">جاري تحميل التفاصيل...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary" id="viewDetailsBtn" style="display: none;">
                    <i class="fas fa-external-link-alt me-1"></i>عرض التفاصيل الكاملة
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.notification-preview {
    padding: 1rem;
}

.notification-preview .notification-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: #f8f9fa;
}

.notification-preview .alert {
    border-radius: 10px;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.notification-preview .alert h6 {
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.notification-preview .alert p {
    margin-bottom: 0.5rem;
}

.notification-preview .alert p:last-child {
    margin-bottom: 0;
}
</style>
@endpush

@push('scripts')
<script>
// Preview notification
function previewNotification(notificationId) {
    const modal = new bootstrap.Modal(document.getElementById('previewModal'));
    const previewContent = document.getElementById('previewContent');
    const viewDetailsBtn = document.getElementById('viewDetailsBtn');
    
    // Reset modal content
    previewContent.innerHTML = `
        <div class="text-center p-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">جاري التحميل...</span>
            </div>
            <p class="mt-2">جاري تحميل التفاصيل...</p>
        </div>
    `;
    viewDetailsBtn.style.display = 'none';
    
    // Show modal
    modal.show();
    
    // Fetch notification details
    fetch(`/admin/notifications/${notificationId}/preview`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            previewContent.innerHTML = data.html;
            
            // Show view details button if there's a related item
            if (data.related_url) {
                viewDetailsBtn.style.display = 'inline-block';
                viewDetailsBtn.onclick = function() {
                    window.open(data.related_url, '_blank');
                };
            }
        } else {
            previewContent.innerHTML = `
                <div class="text-center p-4">
                    <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                    <h5>خطأ في تحميل التفاصيل</h5>
                    <p class="text-muted">${data.message || 'حدث خطأ غير متوقع'}</p>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        previewContent.innerHTML = `
            <div class="text-center p-4">
                <i class="fas fa-exclamation-triangle text-danger fa-3x mb-3"></i>
                <h5>خطأ في الاتصال</h5>
                <p class="text-muted">تعذر تحميل التفاصيل. يرجى المحاولة مرة أخرى.</p>
            </div>
        `;
    });
}

// Mark notification as read
function markAsRead(notificationId) {
    fetch('{{ route("admin.notifications.mark-read") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            notification_id: notificationId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('حدث خطأ في تحديث الإشعار');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ في تحديث الإشعار');
    });
}

// Mark all notifications as read
function markAllAsRead() {
    if (confirm('هل أنت متأكد من تحديد جميع الإشعارات كمقروءة؟')) {
        fetch('{{ route("admin.notifications.mark-all-read") }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ في تحديث الإشعارات');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ في تحديث الإشعارات');
        });
    }
}

// Archive notification
function archiveNotification(notificationId) {
    if (confirm('هل أنت متأكد من أرشفة هذا الإشعار؟')) {
        fetch('{{ route("admin.notifications.archive") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                notification_id: notificationId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ في أرشفة الإشعار');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ في أرشفة الإشعار');
        });
    }
}
</script>
@endpush
