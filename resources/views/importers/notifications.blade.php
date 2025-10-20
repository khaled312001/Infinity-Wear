@extends('layouts.dashboard')

@section('title', 'الإشعارات - لوحة تحكم المستورد')
@section('dashboard-title', 'لوحة المستورد')
@section('page-title', 'الإشعارات')
@section('page-subtitle', 'متابعة آخر التحديثات والتنبيهات')

@section('content')
<div class="container-fluid">
    <!-- إحصائيات الإشعارات -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-bell fa-2x text-primary me-3"></i>
                        <div>
                            <h4 class="mb-0">{{ $totalCount }}</h4>
                            <small class="text-muted">إجمالي الإشعارات</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-envelope fa-2x text-warning me-3"></i>
                        <div>
                            <h4 class="mb-0">{{ $unreadCount }}</h4>
                            <small class="text-muted">غير مقروءة</small>
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
                            <h4 class="mb-0">{{ $totalCount - $unreadCount }}</h4>
                            <small class="text-muted">مقروءة</small>
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
                            <a href="{{ route('importers.notification-settings') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-cog me-1"></i>
                                الإعدادات
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- فلاتر الإشعارات -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <label for="typeFilter" class="form-label">فلتر حسب النوع</label>
                            <select class="form-select" id="typeFilter" onchange="filterNotifications()">
                                <option value="">جميع الإشعارات</option>
                                <option value="order_status">حالة الطلبات</option>
                                <option value="payment">المدفوعات</option>
                                <option value="shipping">الشحن</option>
                                <option value="invoice">الفواتير</option>
                                <option value="system">النظام</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="statusFilter" class="form-label">فلتر حسب الحالة</label>
                            <select class="form-select" id="statusFilter" onchange="filterNotifications()">
                                <option value="">جميع الإشعارات</option>
                                <option value="unread">غير مقروءة</option>
                                <option value="read">مقروءة</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="dateFilter" class="form-label">فلتر حسب التاريخ</label>
                            <select class="form-select" id="dateFilter" onchange="filterNotifications()">
                                <option value="">جميع التواريخ</option>
                                <option value="today">اليوم</option>
                                <option value="week">هذا الأسبوع</option>
                                <option value="month">هذا الشهر</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary" onclick="markAllAsRead()">
                                    <i class="fas fa-check-double me-1"></i>
                                    تحديد الكل كمقروء
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" onclick="resetFilters()">
                                    <i class="fas fa-undo me-1"></i>
                                    إعادة تعيين الفلاتر
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- قائمة الإشعارات -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bell me-2"></i>
                        الإشعارات
                    </h5>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-secondary" onclick="refreshNotifications()">
                            <i class="fas fa-sync-alt me-1"></i>
                            تحديث
                        </button>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    @if($notifications->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($notifications as $notification)
                                <div class="list-group-item notification-item {{ !$notification->is_read ? 'unread' : '' }}" 
                                     data-notification-id="{{ $notification->id }}"
                                     data-type="{{ $notification->type }}" 
                                     data-status="{{ $notification->is_read ? 'read' : 'unread' }}"
                                     data-date="{{ optional($notification->created_at)->format('Y-m-d') }}">
                                    
                                    <div class="d-flex align-items-start">
                                        <div class="notification-icon me-3">
                                            <div class="icon-wrapper bg-{{ $notification->color }}">
                                                <i class="{{ $notification->icon }}"></i>
                                            </div>
                                            @if(!$notification->is_read)
                                                <div class="unread-indicator"></div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <h6 class="notification-title mb-0 {{ !$notification->is_read ? 'fw-bold' : '' }}">
                                                    {{ $notification->title }}
                                                </h6>
                                                <div class="notification-actions">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        @if(!$notification->is_read)
                                                            <button class="btn btn-outline-primary btn-sm" 
                                                                    onclick="markAsRead('{{ $notification->id }}')" 
                                                                    title="تحديد كمقروء">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        @endif
                                                        <button class="btn btn-outline-danger btn-sm" 
                                                                onclick="deleteNotification('{{ $notification->id }}')" 
                                                                title="حذف">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <p class="notification-message text-muted mb-2">
                                                {{ $notification->message }}
                                            </p>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ optional($notification->created_at)->diffForHumans() }}
                                                </small>
                                                
                                                <div class="notification-badges">
                                                    <span class="badge bg-{{ $notification->color }} me-1">
                                                        @switch($notification->type)
                                                            @case('order_status')
                                                                حالة الطلب
                                                                @break
                                                            @case('payment')
                                                                دفع
                                                                @break
                                                            @case('shipping')
                                                                شحن
                                                                @break
                                                            @case('invoice')
                                                                فاتورة
                                                                @break
                                                            @case('system')
                                                                نظام
                                                                @break
                                                        @endswitch
                                                    </span>
                                                    
                                                    @if(!$notification->is_read)
                                                        <span class="badge bg-warning">جديد</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="p-3">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد إشعارات</h5>
                            <p class="text-muted">ستظهر الإشعارات الجديدة هنا عند توفرها</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.notification-item {
    border: none;
    border-bottom: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-item.unread {
    background-color: #f0f8ff;
    border-left: 4px solid #007bff;
}

.notification-icon {
    position: relative;
    flex-shrink: 0;
}

.icon-wrapper {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
}

.unread-indicator {
    position: absolute;
    top: -2px;
    right: -2px;
    width: 12px;
    height: 12px;
    background-color: #dc3545;
    border-radius: 50%;
    border: 2px solid white;
}

.notification-title {
    font-size: 14px;
    line-height: 1.4;
}

.notification-message {
    font-size: 13px;
    line-height: 1.4;
}

.notification-actions {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.notification-item:hover .notification-actions {
    opacity: 1;
}

.notification-badges .badge {
    font-size: 10px;
}

.bg-primary { background-color: #007bff !important; }
.bg-success { background-color: #28a745 !important; }
.bg-info { background-color: #17a2b8 !important; }
.bg-warning { background-color: #ffc107 !important; color: #000 !important; }
.bg-secondary { background-color: #6c757d !important; }

/* تحسينات إضافية */
.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.notification-item {
    transition: all 0.3s ease;
}

.notification-item:hover {
    transform: translateX(5px);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.alert {
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>

<script>
function filterNotifications() {
    const typeFilter = document.getElementById('typeFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const dateFilter = document.getElementById('dateFilter').value;
    
    const notifications = document.querySelectorAll('.notification-item');
    let visibleCount = 0;
    
    notifications.forEach(notification => {
        let show = true;
        
        // فلتر النوع
        if (typeFilter && notification.dataset.type !== typeFilter) {
            show = false;
        }
        
        // فلتر الحالة
        if (statusFilter && notification.dataset.status !== statusFilter) {
            show = false;
        }
        
        // فلتر التاريخ
        if (dateFilter) {
            const notificationDate = new Date(notification.dataset.date);
            const today = new Date();
            let shouldShow = false;
            
            switch(dateFilter) {
                case 'today':
                    shouldShow = notificationDate.toDateString() === today.toDateString();
                    break;
                case 'week':
                    const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                    shouldShow = notificationDate >= weekAgo;
                    break;
                case 'month':
                    const monthAgo = new Date(today.getTime() - 30 * 24 * 60 * 60 * 1000);
                    shouldShow = notificationDate >= monthAgo;
                    break;
            }
            
            if (!shouldShow) {
                show = false;
            }
        }
        
        notification.style.display = show ? 'block' : 'none';
        if (show) visibleCount++;
    });
    
    // إظهار رسالة إذا لم توجد نتائج
    const noResultsMsg = document.getElementById('no-results-message');
    if (visibleCount === 0) {
        if (!noResultsMsg) {
            const msg = document.createElement('div');
            msg.id = 'no-results-message';
            msg.className = 'text-center py-4 text-muted';
            msg.innerHTML = '<i class="fas fa-search me-2"></i>لا توجد إشعارات تطابق الفلتر المحدد';
            document.querySelector('.list-group').appendChild(msg);
        }
    } else {
        if (noResultsMsg) {
            noResultsMsg.remove();
        }
    }
}

function resetFilters() {
    // إعادة تعيين جميع الفلاتر
    document.getElementById('typeFilter').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('dateFilter').value = '';
    
    // إظهار جميع الإشعارات
    const notifications = document.querySelectorAll('.notification-item');
    notifications.forEach(notification => {
        notification.style.display = 'block';
    });
    
    // إزالة رسالة عدم وجود نتائج
    const noResultsMsg = document.getElementById('no-results-message');
    if (noResultsMsg) {
        noResultsMsg.remove();
    }
    
    showSuccessMessage('تم إعادة تعيين الفلاتر');
}

function markAsRead(notificationId) {
    fetch(`/importers/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // تحديث واجهة المستخدم
            const notification = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notification) {
                notification.classList.remove('unread');
                notification.setAttribute('data-status', 'read');
                const indicator = notification.querySelector('.unread-indicator');
                if (indicator) indicator.remove();
                notification.querySelector('.notification-title').classList.remove('fw-bold');
                
                // إخفاء زر تحديد كمقروء
                const markReadBtn = notification.querySelector('button[onclick*="markAsRead"]');
                if (markReadBtn) markReadBtn.style.display = 'none';
            }
            
            // تحديث العداد
            updateNotificationCount();
            
            // تحديث عداد الـ sidebar
            updateSidebarNotificationBadge();
            
            // إظهار رسالة نجاح
            showSuccessMessage('تم تحديد الإشعار كمقروء');
        } else {
            showErrorMessage('حدث خطأ أثناء تحديد الإشعار كمقروء');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorMessage('حدث خطأ في الاتصال');
    });
}

function markAllAsRead() {
    if (confirm('هل أنت متأكد من تحديد جميع الإشعارات كمقروءة؟')) {
        fetch('/importers/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // تحديث جميع الإشعارات
                document.querySelectorAll('.notification-item.unread').forEach(notification => {
                    notification.classList.remove('unread');
                    notification.setAttribute('data-status', 'read');
                    const indicator = notification.querySelector('.unread-indicator');
                    if (indicator) indicator.remove();
                    notification.querySelector('.notification-title').classList.remove('fw-bold');
                    
                    // إخفاء أزرار تحديد كمقروء
                    const markReadBtn = notification.querySelector('button[onclick*="markAsRead"]');
                    if (markReadBtn) markReadBtn.style.display = 'none';
                });
                
                // تحديث العداد
                updateNotificationCount();
                
                // تحديث عداد الـ sidebar
                updateSidebarNotificationBadge();
                
                // إظهار رسالة نجاح
                showSuccessMessage('تم تحديد جميع الإشعارات كمقروءة');
            } else {
                showErrorMessage('حدث خطأ أثناء تحديد الإشعارات كمقروءة');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorMessage('حدث خطأ في الاتصال');
        });
    }
}

function deleteNotification(notificationId) {
    if (confirm('هل أنت متأكد من حذف هذا الإشعار؟')) {
        fetch(`/importers/notifications/${notificationId}/delete`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // إزالة الإشعار من الواجهة
                const notification = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notification) {
                    notification.remove();
                }
                
                // تحديث العداد
                updateNotificationCount();
                
                // تحديث عداد الـ sidebar
                updateSidebarNotificationBadge();
                
                // إظهار رسالة نجاح
                showSuccessMessage('تم حذف الإشعار بنجاح');
            } else {
                showErrorMessage('حدث خطأ أثناء حذف الإشعار');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorMessage('حدث خطأ في الاتصال');
        });
    }
}

function refreshNotifications() {
    // إظهار رسالة تحميل
    showSuccessMessage('جاري تحديث الإشعارات...');
    
    // إعادة تحميل الصفحة لتحديث الإشعارات
    setTimeout(() => {
        window.location.reload();
    }, 500);
}

function updateNotificationCount() {
    // تحديث عداد الإشعارات غير المقروءة
    const unreadCount = document.querySelectorAll('.notification-item.unread').length;
    const unreadElement = document.querySelector('.text-warning h4');
    if (unreadElement) {
        unreadElement.textContent = unreadCount;
    }
    
    // تحديث عداد الإشعارات المقروءة
    const readCount = document.querySelectorAll('.notification-item:not(.unread)').length;
    const readElement = document.querySelector('.text-success h4');
    if (readElement) {
        readElement.textContent = readCount;
    }
    
    // تحديث العداد الإجمالي
    const totalCount = document.querySelectorAll('.notification-item').length;
    const totalElement = document.querySelector('.text-primary h4');
    if (totalElement) {
        totalElement.textContent = totalCount;
    }
}

// دوال إظهار الرسائل
function showSuccessMessage(message) {
    // إنشاء عنصر الرسالة
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        <i class="fas fa-check-circle me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // إزالة الرسالة تلقائياً بعد 3 ثوان
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 3000);
}

function showErrorMessage(message) {
    // إنشاء عنصر الرسالة
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed';
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        <i class="fas fa-exclamation-circle me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // إزالة الرسالة تلقائياً بعد 5 ثوان
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// دالة تحديث عداد الـ sidebar
function updateSidebarNotificationBadge() {
    fetch('/importers/notifications/unread-count', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const badge = document.getElementById('sidebarNotificationsBadge');
        if (badge) {
            const unreadCount = data.unread_count || 0;
            
            if (unreadCount > 0) {
                badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
                badge.style.display = 'flex';
                
                // تحسين العرض للأرقام الكبيرة
                if (unreadCount > 99) {
                    badge.style.minWidth = '32px';
                } else if (unreadCount > 9) {
                    badge.style.minWidth = '24px';
                } else {
                    badge.style.minWidth = '20px';
                }
            } else {
                badge.style.display = 'none';
            }
        }
    })
    .catch(error => {
        console.error('Error updating sidebar notification badge:', error);
    });
}

// تحديث تلقائي للإشعارات كل 30 ثانية
setInterval(function() {
    // يمكن إضافة AJAX call لتحديث الإشعارات بدون إعادة تحميل الصفحة
    console.log('تحديث الإشعارات...');
}, 30000);

// تحسين تجربة المستخدم
document.addEventListener('DOMContentLoaded', function() {
    // إضافة تأثيرات hover للأزرار
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
            this.style.transition = 'all 0.2s ease';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // إضافة تأثيرات للإشعارات
    const notifications = document.querySelectorAll('.notification-item');
    notifications.forEach(notification => {
        notification.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
            this.style.transition = 'all 0.3s ease';
        });
        
        notification.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
    
    // إضافة تأثيرات للفلاتر
    const filters = document.querySelectorAll('select');
    filters.forEach(filter => {
        filter.addEventListener('change', function() {
            this.style.transform = 'scale(1.02)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        });
    });
    
    // إضافة تأثيرات للأيقونات
    const icons = document.querySelectorAll('.fas');
    icons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
            this.style.transition = 'all 0.2s ease';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // إضافة تأثيرات للبطاقات
    const cards = document.querySelectorAll('.dashboard-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'all 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // إضافة تأثيرات للشارات
    const badges = document.querySelectorAll('.badge');
    badges.forEach(badge => {
        badge.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
            this.style.transition = 'all 0.2s ease';
        });
        
        badge.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
</script>
@endsection
