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
                        <button class="btn btn-outline-primary btn-sm" onclick="loadNotifications()">
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
<!-- Load notifications.js for full notification functionality -->
<script src="{{ asset('js/notifications.js') }}"></script>

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
        console.log('loadNotifications called');
        try {
            const url = '{{ route("admin.notifications.unread") }}';
            console.log('Fetching from URL:', url);
            
            // Try to use the admin notifications API first
            const response = await fetch(url, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Response error:', errorText);
                throw new Error('Failed to load notifications: ' + response.status);
            }

            const data = await response.json();
            console.log('Response data:', data);
            
            this.notifications = data.notifications || [];
            this.updateStats(data.stats || {});
            this.renderNotifications();
            
            console.log('Notifications loaded successfully, count:', this.notifications.length);
            
        } catch (error) {
            console.error('Failed to load notifications:', error);
            this.showError('فشل في تحميل الإشعارات: ' + error.message);
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
                <div class="notifications-empty text-center py-5">
                    <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد إشعارات</h4>
                    <p class="text-muted">لم يتم العثور على إشعارات في هذا القسم</p>
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
        const icon = this.getNotificationIcon(notification.type);
        
        return `
            <div class="notification-item ${isRead}" data-notification-id="${notification.id}" data-type="${notification.type}">
                <div class="notification-icon">
                    <i class="${icon}"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">${notification.title || notification.message}</div>
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

    getNotificationIcon(type) {
        const icons = {
            'order': 'fas fa-shopping-cart',
            'contact': 'fas fa-envelope',
            'whatsapp': 'fab fa-whatsapp',
            'importer_order': 'fas fa-truck',
            'system': 'fas fa-cog',
            'task': 'fas fa-tasks',
            'marketing': 'fas fa-bullhorn',
            'sales': 'fas fa-chart-line'
        };
        return icons[type] || 'fas fa-bell';
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
            const response = await fetch(`{{ route("admin.notifications.mark-read") }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ notification_id: notificationId })
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
            const response = await fetch('{{ route("admin.notifications.mark-all-read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
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
            const response = await fetch(`{{ route("admin.notifications.archive") }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ notification_id: notificationId })
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
            const response = await fetch('{{ route("admin.notifications.archive-read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
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
        // Create a simple toast notification
        const toast = document.createElement('div');
        toast.className = 'alert alert-success alert-dismissible fade show position-fixed';
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            <i class="fas fa-check-circle me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 3000);
    }

    showError(message) {
        // Create a simple toast notification
        const toast = document.createElement('div');
        toast.className = 'alert alert-danger alert-dismissible fade show position-fixed';
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            <i class="fas fa-exclamation-circle me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 5000);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM Content Loaded - Initializing NotificationPageManager');
    alert('JavaScript is executing! Check console for details.');
    try {
        window.notificationPageManager = new NotificationPageManager();
        console.log('NotificationPageManager initialized successfully');
    } catch (error) {
        console.error('Error initializing NotificationPageManager:', error);
        alert('Error initializing NotificationPageManager: ' + error.message);
    }
});

// Global functions for button onclick handlers
function loadNotifications() {
    if (window.notificationPageManager) {
        window.notificationPageManager.loadNotifications();
    } else if (window.notificationManager) {
        window.notificationManager.loadNotifications();
    }
}

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
<style>
/* Notification Page Styles */
.notification-stats {
    display: flex;
    justify-content: space-around;
    padding: 20px;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-bottom: 1px solid #e2e8f0;
    flex-wrap: wrap;
    gap: 15px;
}

.stat-item {
    text-align: center;
    min-width: 120px;
}

.stat-label {
    display: block;
    font-size: 0.85rem;
    color: #64748b;
    margin-bottom: 5px;
    font-weight: 500;
}

.stat-value {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
}

.notification-item {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.notification-item:hover {
    background-color: #f8fafc;
    transform: translateX(-2px);
}

.notification-item.read {
    opacity: 0.7;
    background-color: #f8fafc;
}

.notification-item.unread {
    background-color: #e3f2fd;
    border-left: 3px solid #2196f3;
}

.notification-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    font-size: 16px;
    margin-left: 15px;
    flex-shrink: 0;
}

.notification-content {
    flex: 1;
    min-width: 0;
}

.notification-title {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 5px;
    font-size: 0.95rem;
}

.notification-message {
    color: #64748b;
    font-size: 0.85rem;
    margin-bottom: 5px;
    line-height: 1.4;
}

.notification-time {
    color: #94a3b8;
    font-size: 0.75rem;
}

.notification-actions {
    display: flex;
    gap: 5px;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.notification-item:hover .notification-actions {
    opacity: 1;
}

.notification-actions .btn {
    padding: 5px 8px;
    font-size: 0.75rem;
    border-radius: 6px;
}

.notifications-empty {
    text-align: center;
    padding: 60px 20px;
    color: #64748b;
}

.notifications-empty i {
    color: #cbd5e1;
    margin-bottom: 20px;
}

.notifications-loading {
    text-align: center;
    padding: 40px 20px;
    color: #64748b;
}

.notifications-loading i {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 15px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.connection-status {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 500;
}

.connection-status.connected {
    background-color: #d1fae5;
    color: #065f46;
}

.connection-status.disconnected {
    background-color: #fee2e2;
    color: #991b1b;
}

.connection-status::before {
    content: '';
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-left: 8px;
    animation: pulse 2s infinite;
}

.connection-status.connected::before {
    background-color: #10b981;
}

.connection-status.disconnected::before {
    background-color: #ef4444;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* Tab Styles */
.nav-tabs .nav-link {
    border: none;
    border-radius: 8px 8px 0 0;
    margin-right: 5px;
    padding: 12px 20px;
    font-weight: 500;
    color: #64748b;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover {
    background-color: #f1f5f9;
    color: var(--primary-color);
}

.nav-tabs .nav-link.active {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.nav-tabs .nav-link .badge {
    font-size: 0.7rem;
    padding: 4px 8px;
    border-radius: 12px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .notification-stats {
        flex-direction: column;
        gap: 10px;
    }
    
    .stat-item {
        min-width: auto;
    }
    
    .notification-item {
        padding: 12px 15px;
    }
    
    .notification-icon {
        width: 35px;
        height: 35px;
        font-size: 14px;
        margin-left: 10px;
    }
    
    .notification-actions {
        opacity: 1; /* Always show on mobile */
    }
    
    .nav-tabs {
        flex-wrap: wrap;
    }
    
    .nav-tabs .nav-link {
        margin-bottom: 5px;
        font-size: 0.85rem;
        padding: 10px 15px;
    }
}
</style>
@endsection