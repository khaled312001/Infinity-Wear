@extends('layouts.dashboard')

@section('title', 'الإشعارات')
@section('dashboard-title', 'الإشعارات')
@section('page-title', 'إدارة الإشعارات')
@section('page-subtitle', 'مراقبة وإدارة جميع إشعارات النظام')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-bell me-2"></i>
                        الإشعارات
                    </h3>
                    <div class="d-flex gap-2">
                        <div class="connection-status disconnected">
                            <span class="status-text">جاري الاتصال...</span>
                        </div>
                        <button class="btn btn-outline-primary btn-sm" onclick="window.notificationManager.loadNotifications()">
                            <i class="fas fa-sync-alt"></i>
                            تحديث
                        </button>
                        <button class="btn btn-outline-success btn-sm mark-all-read">
                            <i class="fas fa-check-double"></i>
                            تحديد الكل كمقروء
                        </button>
                        <button class="btn btn-outline-warning btn-sm archive-read">
                            <i class="fas fa-archive"></i>
                            أرشفة المقروءة
                        </button>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <!-- Notification Stats -->
                    <div class="notification-stats">
                        <div class="stat-item">
                            <span class="stat-label">إجمالي غير المقروءة</span>
                            <span class="stat-value" id="total-unread">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">الطلبات</span>
                            <span class="stat-value" id="orders-count">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">الرسائل</span>
                            <span class="stat-value" id="contacts-count">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">الواتساب</span>
                            <span class="stat-value" id="whatsapp-count">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">طلبات المستوردين</span>
                            <span class="stat-value" id="importer-orders-count">0</span>
                        </div>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="border-bottom">
                        <ul class="nav nav-tabs" id="notificationTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                                    الكل
                                    <span class="badge bg-primary ms-1" id="all-badge">0</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="unread-tab" data-bs-toggle="tab" data-bs-target="#unread" type="button" role="tab">
                                    غير مقروءة
                                    <span class="badge bg-danger ms-1" id="unread-badge">0</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">
                                    الطلبات
                                    <span class="badge bg-success ms-1" id="orders-tab-badge">0</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts" type="button" role="tab">
                                    الرسائل
                                    <span class="badge bg-info ms-1" id="contacts-tab-badge">0</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="whatsapp-tab" data-bs-toggle="tab" data-bs-target="#whatsapp" type="button" role="tab">
                                    الواتساب
                                    <span class="badge bg-success ms-1" id="whatsapp-tab-badge">0</span>
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content" id="notificationTabContent">
                        <!-- All Notifications -->
                        <div class="tab-pane fade show active" id="all" role="tabpanel">
                            <div class="notifications-container" id="all-notifications">
                                <div class="notifications-loading">
                                    <i class="fas fa-spinner"></i>
                                    <p>جاري تحميل الإشعارات...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Unread Notifications -->
                        <div class="tab-pane fade" id="unread" role="tabpanel">
                            <div class="notifications-container" id="unread-notifications">
                                <div class="notifications-loading">
                                    <i class="fas fa-spinner"></i>
                                    <p>جاري تحميل الإشعارات غير المقروءة...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Orders -->
                        <div class="tab-pane fade" id="orders" role="tabpanel">
                            <div class="notifications-container" id="orders-notifications">
                                <div class="notifications-loading">
                                    <i class="fas fa-spinner"></i>
                                    <p>جاري تحميل إشعارات الطلبات...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Contacts -->
                        <div class="tab-pane fade" id="contacts" role="tabpanel">
                            <div class="notifications-container" id="contacts-notifications">
                                <div class="notifications-loading">
                                    <i class="fas fa-spinner"></i>
                                    <p>جاري تحميل إشعارات الرسائل...</p>
                                </div>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="tab-pane fade" id="whatsapp" role="tabpanel">
                            <div class="notifications-container" id="whatsapp-notifications">
                                <div class="notifications-loading">
                                    <i class="fas fa-spinner"></i>
                                    <p>جاري تحميل إشعارات الواتساب...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Notification Settings Modal -->
<div class="modal fade" id="notificationSettingsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-cog me-2"></i>
                    إعدادات الإشعارات
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="notificationSettingsForm">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>إشعارات المتصفح</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="browserNotifications" checked>
                                <label class="form-check-label" for="browserNotifications">
                                    تفعيل إشعارات المتصفح
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="soundNotifications" checked>
                                <label class="form-check-label" for="soundNotifications">
                                    تفعيل صوت الإشعارات
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>أنواع الإشعارات</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="orderNotifications" checked>
                                <label class="form-check-label" for="orderNotifications">
                                    إشعارات الطلبات
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="contactNotifications" checked>
                                <label class="form-check-label" for="contactNotifications">
                                    إشعارات الرسائل
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="whatsappNotifications" checked>
                                <label class="form-check-label" for="whatsappNotifications">
                                    إشعارات الواتساب
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" onclick="saveNotificationSettings()">حفظ الإعدادات</button>
            </div>
        </div>
    </div>
</div>

<!-- Test Notification Modal -->
<div class="modal fade" id="testNotificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-bell me-2"></i>
                    إشعار تجريبي
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>هل تريد إرسال إشعار تجريبي لاختبار النظام؟</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" onclick="sendTestNotification()">إرسال تجريبي</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Notification Management
class NotificationPageManager {
    constructor() {
        this.currentTab = 'all';
        this.notifications = [];
        this.init();
    }

    init() {
        this.loadNotifications();
        this.setupEventListeners();
        this.setupTabs();
    }

    setupEventListeners() {
        // Tab switching
        document.querySelectorAll('#notificationTabs button').forEach(tab => {
            tab.addEventListener('click', (e) => {
                const target = e.target.getAttribute('data-bs-target').replace('#', '');
                this.switchTab(target);
            });
        });

        // Global actions
        document.querySelector('.mark-all-read')?.addEventListener('click', () => {
            this.markAllAsRead();
        });

        document.querySelector('.archive-read')?.addEventListener('click', () => {
            this.archiveRead();
        });
    }

    setupTabs() {
        // Initialize tab content
        this.tabs = {
            'all': document.getElementById('all-notifications'),
            'unread': document.getElementById('unread-notifications'),
            'orders': document.getElementById('orders-notifications'),
            'contacts': document.getElementById('contacts-notifications'),
            'whatsapp': document.getElementById('whatsapp-notifications')
        };
    }

    async loadNotifications() {
        try {
            const response = await fetch('/api/notifications', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                throw new Error('Failed to load notifications');
            }

            const data = await response.json();
            this.notifications = data.notifications || [];
            this.updateStats(data.stats || {});
            this.renderNotifications();
            
        } catch (error) {
            console.error('Failed to load notifications:', error);
            this.showError('فشل في تحميل الإشعارات');
        }
    }

    switchTab(tabName) {
        this.currentTab = tabName;
        this.renderNotifications();
    }

    renderNotifications() {
        const container = this.tabs[this.currentTab];
        if (!container) return;

        let filteredNotifications = this.notifications;

        // Filter based on current tab
        switch (this.currentTab) {
            case 'unread':
                filteredNotifications = this.notifications.filter(n => !n.is_read);
                break;
            case 'orders':
                filteredNotifications = this.notifications.filter(n => n.type === 'order');
                break;
            case 'contacts':
                filteredNotifications = this.notifications.filter(n => n.type === 'contact');
                break;
            case 'whatsapp':
                filteredNotifications = this.notifications.filter(n => n.type === 'whatsapp');
                break;
        }

        if (filteredNotifications.length === 0) {
            container.innerHTML = `
                <div class="notifications-empty">
                    <i class="fas fa-bell-slash"></i>
                    <h4>لا توجد إشعارات</h4>
                    <p>لم يتم العثور على إشعارات في هذا القسم</p>
                </div>
            `;
            return;
        }

        container.innerHTML = filteredNotifications.map(notification => 
            this.createNotificationElement(notification)
        ).join('');

        // Add event listeners to notification elements
        container.querySelectorAll('.notification-item').forEach(item => {
            this.addNotificationEventListeners(item);
        });
    }

    createNotificationElement(notification) {
        const timeAgo = this.formatTimeAgo(notification.created_at);
        const isRead = notification.is_read ? 'read' : '';
        
        return `
            <div class="notification-item ${isRead}" data-notification-id="${notification.id}" data-type="${notification.type}">
                <div class="notification-icon">
                    <i class="${notification.icon}"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">${notification.title}</div>
                    <div class="notification-message">${notification.message}</div>
                    <div class="notification-time">${timeAgo}</div>
                </div>
                <div class="notification-actions">
                    <button class="btn btn-sm btn-outline-primary mark-read" data-id="${notification.id}">
                        <i class="fas fa-check"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary archive" data-id="${notification.id}">
                        <i class="fas fa-archive"></i>
                    </button>
                </div>
            </div>
        `;
    }

    addNotificationEventListeners(item) {
        const notificationId = item.dataset.notificationId;
        
        // Mark as read
        item.querySelector('.mark-read')?.addEventListener('click', (e) => {
            e.stopPropagation();
            this.markAsRead(notificationId);
        });
        
        // Archive
        item.querySelector('.archive')?.addEventListener('click', (e) => {
            e.stopPropagation();
            this.archiveNotification(notificationId);
        });
        
        // Click to open
        item.addEventListener('click', () => {
            this.markAsRead(notificationId);
            this.openNotification(notificationId);
        });
    }

    async markAsRead(notificationId) {
        try {
            const response = await fetch(`/api/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                const item = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (item) {
                    item.classList.add('read');
                }
                this.updateStats();
            }
        } catch (error) {
            console.error('Failed to mark as read:', error);
        }
    }

    async markAllAsRead() {
        try {
            const response = await fetch('/api/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                this.loadNotifications();
                this.showSuccess('تم تحديد جميع الإشعارات كمقروءة');
            }
        } catch (error) {
            console.error('Failed to mark all as read:', error);
        }
    }

    async archiveNotification(notificationId) {
        try {
            const response = await fetch(`/api/notifications/${notificationId}/archive`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                const item = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (item) {
                    item.remove();
                }
            }
        } catch (error) {
            console.error('Failed to archive notification:', error);
        }
    }

    async archiveRead() {
        try {
            const response = await fetch('/api/notifications/archive-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                this.loadNotifications();
                this.showSuccess('تم أرشفة الإشعارات المقروءة');
            }
        } catch (error) {
            console.error('Failed to archive read notifications:', error);
        }
    }

    openNotification(notificationId) {
        const notification = this.notifications.find(n => n.id == notificationId);
        if (notification) {
            const url = this.getNotificationUrl(notification);
            if (url) {
                window.location.href = url;
            }
        }
    }

    getNotificationUrl(notification) {
        const urls = {
            'order': '/admin/orders',
            'contact': '/admin/contacts',
            'whatsapp': '/admin/whatsapp',
            'importer_order': '/admin/importer-orders',
            'system': '/admin/notifications',
            'task': '/admin/tasks',
            'marketing': '/admin/marketing',
            'sales': '/admin/sales'
        };
        
        return urls[notification.type] || '/admin/notifications';
    }

    updateStats(stats = null) {
        if (stats) {
            document.getElementById('total-unread').textContent = stats.total_unread || 0;
            document.getElementById('orders-count').textContent = stats.orders || 0;
            document.getElementById('contacts-count').textContent = stats.contacts || 0;
            document.getElementById('whatsapp-count').textContent = stats.whatsapp || 0;
            document.getElementById('importer-orders-count').textContent = stats.importer_orders || 0;
            
            // Update tab badges
            document.getElementById('all-badge').textContent = this.notifications.length;
            document.getElementById('unread-badge').textContent = stats.total_unread || 0;
            document.getElementById('orders-tab-badge').textContent = stats.orders || 0;
            document.getElementById('contacts-tab-badge').textContent = stats.contacts || 0;
            document.getElementById('whatsapp-tab-badge').textContent = stats.whatsapp || 0;
        }
    }

    formatTimeAgo(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diff = now - date;
        
        if (diff < 60000) {
            return 'الآن';
        } else if (diff < 3600000) {
            return `${Math.floor(diff / 60000)} دقيقة`;
        } else if (diff < 86400000) {
            return `${Math.floor(diff / 3600000)} ساعة`;
        } else {
            return date.toLocaleDateString('ar-SA');
        }
    }

    showSuccess(message) {
        // You can implement a toast notification here
        console.log('Success:', message);
    }

    showError(message) {
        // You can implement a toast notification here
        console.error('Error:', message);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.notificationPageManager = new NotificationPageManager();
});

// Global functions
function sendTestNotification() {
    if (window.notificationManager) {
        window.notificationManager.sendTestNotification();
    }
}

function saveNotificationSettings() {
    // Implement notification settings saving
    console.log('Saving notification settings...');
}
</script>
@endsection

@section('styles')
<link href="{{ asset('css/notifications.css') }}" rel="stylesheet">
@endsection