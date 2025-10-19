@extends('layouts.dashboard')

@section('title', 'الإشعارات الجديدة')
@section('dashboard-title', 'الإشعارات الجديدة')
@section('page-title', 'إدارة الإشعارات')
@section('page-subtitle', 'نظام إشعارات محسن وسريع')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-bell me-2"></i>
                    الإشعارات الجديدة
                </h3>
                <div class="d-flex gap-2">
                    <div class="connection-status" id="connection-status">
                        <span class="status-text">جاري التحميل...</span>
                    </div>
                    <button class="btn btn-outline-primary btn-sm" id="refresh-btn">
                        <i class="fas fa-sync-alt"></i>
                        تحديث
                    </button>
                    <button class="btn btn-outline-success btn-sm" id="mark-all-read-btn">
                        <i class="fas fa-check-double"></i>
                        تحديد الكل كمقروء
                    </button>
                    <button class="btn btn-outline-info btn-sm" id="create-test-btn">
                        <i class="fas fa-plus"></i>
                        إشعار تجريبي
                    </button>
                    <button class="btn btn-outline-warning btn-sm" id="debug-btn">
                        <i class="fas fa-bug"></i>
                        تشخيص
                    </button>
                </div>
            </div>
                
            <div class="card-body p-0">
                <!-- Statistics Section -->
                <div class="notification-stats p-3 bg-light border-bottom">
                    <div class="row text-center">
                        <div class="col-md-2">
                            <div class="stat-item">
                                <div class="stat-number text-primary" id="total-unread">0</div>
                                <div class="stat-label">غير مقروءة</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="stat-item">
                                <div class="stat-number text-success" id="orders-count">0</div>
                                <div class="stat-label">الطلبات</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="stat-item">
                                <div class="stat-number text-info" id="contacts-count">0</div>
                                <div class="stat-label">الرسائل</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="stat-item">
                                <div class="stat-number text-warning" id="whatsapp-count">0</div>
                                <div class="stat-label">الواتساب</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="stat-item">
                                <div class="stat-number text-danger" id="importer-count">0</div>
                                <div class="stat-label">المستوردين</div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="stat-item">
                                <div class="stat-number text-secondary" id="total-count">0</div>
                                <div class="stat-label">الكل</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="notification-tabs">
                    <ul class="nav nav-tabs" id="notification-tabs">
                        <li class="nav-item">
                            <button class="nav-link active" data-type="all">
                                <i class="fas fa-list me-2"></i>
                                الكل <span class="badge bg-primary ms-1" id="all-badge">0</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-type="unread">
                                <i class="fas fa-envelope me-2"></i>
                                غير مقروءة <span class="badge bg-danger ms-1" id="unread-badge">0</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-type="order">
                                <i class="fas fa-shopping-cart me-2"></i>
                                الطلبات <span class="badge bg-success ms-1" id="orders-badge">0</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-type="contact">
                                <i class="fas fa-envelope me-2"></i>
                                الرسائل <span class="badge bg-info ms-1" id="contacts-badge">0</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-type="whatsapp">
                                <i class="fab fa-whatsapp me-2"></i>
                                الواتساب <span class="badge bg-warning ms-1" id="whatsapp-badge">0</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-type="importer_order">
                                <i class="fas fa-truck me-2"></i>
                                المستوردين <span class="badge bg-danger ms-1" id="importer-badge">0</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Notifications Container -->
                <div class="notifications-container" id="notifications-container">
                    <div class="loading-state text-center py-5" id="loading-state">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">جاري التحميل...</span>
                        </div>
                        <p class="mt-3 text-muted">جاري تحميل الإشعارات...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
class NewNotificationManager {
    constructor() {
        this.currentType = 'all';
        this.notifications = [];
        this.stats = {};
        this.isLoading = false;
        
        this.init();
    }

    init() {
        console.log('Initializing New Notification Manager...');
        this.setupEventListeners();
        this.loadNotifications();
        this.updateConnectionStatus('loading');
    }

    setupEventListeners() {
        // Refresh button
        document.getElementById('refresh-btn').addEventListener('click', () => {
            this.loadNotifications();
        });

        // Mark all as read button
        document.getElementById('mark-all-read-btn').addEventListener('click', () => {
            this.markAllAsRead();
        });

        // Create test notification button
        document.getElementById('create-test-btn').addEventListener('click', () => {
            this.createTestNotification();
        });

        // Debug button
        document.getElementById('debug-btn').addEventListener('click', () => {
            this.debugSystem();
        });

        // Filter tabs
        document.querySelectorAll('#notification-tabs .nav-link').forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                const type = e.currentTarget.getAttribute('data-type');
                this.switchType(type);
            });
        });
    }

    async loadNotifications() {
        if (this.isLoading) return;
        
        this.isLoading = true;
        this.updateConnectionStatus('loading');
        this.showLoading();

        try {
            console.log('Loading notifications...');
            
            const response = await fetch('{{ route("admin.notifications.new.get") }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            console.log('Response status:', response.status);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Response data:', data);

            if (data.success) {
                this.notifications = data.notifications || [];
                this.stats = data.stats || {};
                this.renderNotifications();
                this.updateStats();
                this.updateConnectionStatus('connected');
            } else {
                throw new Error(data.message || 'فشل في تحميل الإشعارات');
            }

        } catch (error) {
            console.error('Error loading notifications:', error);
            this.showError('فشل في تحميل الإشعارات: ' + error.message);
            this.updateConnectionStatus('error');
        } finally {
            this.isLoading = false;
            this.hideLoading();
        }
    }

    switchType(type) {
        console.log('Switching to type:', type);
        this.currentType = type;
        
        // Update active tab
        document.querySelectorAll('#notification-tabs .nav-link').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelector(`[data-type="${type}"]`).classList.add('active');
        
        this.renderNotifications();
    }

    renderNotifications() {
        const container = document.getElementById('notifications-container');
        
        let filteredNotifications = this.notifications;
        
        // Filter based on current type
        if (this.currentType === 'unread') {
            filteredNotifications = this.notifications.filter(n => !n.is_read);
        } else if (this.currentType !== 'all') {
            filteredNotifications = this.notifications.filter(n => n.type === this.currentType);
        }

        if (filteredNotifications.length === 0) {
            container.innerHTML = `
                <div class="empty-state text-center py-5">
                    <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد إشعارات</h4>
                    <p class="text-muted">لم يتم العثور على إشعارات في هذا القسم</p>
                    <button class="btn btn-outline-primary btn-sm" onclick="notificationManager.createTestNotification()">
                        <i class="fas fa-plus"></i>
                        إنشاء إشعار تجريبي
                    </button>
                </div>
            `;
            return;
        }

        container.innerHTML = filteredNotifications.map(notification => 
            this.createNotificationElement(notification)
        ).join('');

        // Add event listeners to notification elements
        this.addNotificationEventListeners();
    }

    createNotificationElement(notification) {
        const timeAgo = this.formatTimeAgo(notification.created_at);
        const isRead = notification.is_read ? 'read' : '';
        const icon = this.getNotificationIcon(notification.type);
        
        return `
            <div class="notification-item ${isRead}" data-id="${notification.id}">
                <div class="notification-icon">
                    <i class="${icon}"></i>
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
                </div>
            </div>
        `;
    }

    addNotificationEventListeners() {
        document.querySelectorAll('.mark-read').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = e.currentTarget.getAttribute('data-id');
                this.markAsRead(id);
            });
        });

        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', (e) => {
                if (!e.target.closest('.notification-actions')) {
                    const id = item.getAttribute('data-id');
                    this.markAsRead(id);
                }
            });
        });
    }

    async markAsRead(notificationId) {
        try {
            const response = await fetch('{{ route("admin.notifications.new.mark-read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    notification_id: notificationId
                })
            });

            const data = await response.json();
            
            if (data.success) {
                // Update local data
                const notification = this.notifications.find(n => n.id == notificationId);
                if (notification) {
                    notification.is_read = true;
                    notification.read_at = new Date().toISOString();
                }
                
                // Re-render
                this.renderNotifications();
                this.updateStats();
                
                this.showSuccess('تم تحديد الإشعار كمقروء');
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error marking as read:', error);
            this.showError('فشل في تحديث الإشعار');
        }
    }

    async markAllAsRead() {
        try {
            const response = await fetch('{{ route("admin.notifications.new.mark-all-read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();
            
            if (data.success) {
                // Update local data
                this.notifications.forEach(n => {
                    n.is_read = true;
                    n.read_at = new Date().toISOString();
                });
                
                // Re-render
                this.renderNotifications();
                this.updateStats();
                
                this.showSuccess(data.message);
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error marking all as read:', error);
            this.showError('فشل في تحديث الإشعارات');
        }
    }

    async createTestNotification() {
        try {
            const response = await fetch('{{ route("admin.notifications.new.create-test") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();
            
            if (data.success) {
                this.showSuccess('تم إنشاء إشعار تجريبي بنجاح');
                this.loadNotifications(); // Reload notifications
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error creating test notification:', error);
            this.showError('فشل في إنشاء الإشعار التجريبي');
        }
    }

    updateStats() {
        document.getElementById('total-unread').textContent = this.stats.total_unread || 0;
        document.getElementById('orders-count').textContent = this.stats.orders || 0;
        document.getElementById('contacts-count').textContent = this.stats.contacts || 0;
        document.getElementById('whatsapp-count').textContent = this.stats.whatsapp || 0;
        document.getElementById('importer-count').textContent = this.stats.importer_orders || 0;
        document.getElementById('total-count').textContent = this.stats.total || 0;

        // Update badges
        document.getElementById('all-badge').textContent = this.stats.total || 0;
        document.getElementById('unread-badge').textContent = this.stats.total_unread || 0;
        document.getElementById('orders-badge').textContent = this.stats.orders || 0;
        document.getElementById('contacts-badge').textContent = this.stats.contacts || 0;
        document.getElementById('whatsapp-badge').textContent = this.stats.whatsapp || 0;
        document.getElementById('importer-badge').textContent = this.stats.importer_orders || 0;
    }

    updateConnectionStatus(status) {
        const statusElement = document.getElementById('connection-status');
        const statusText = statusElement.querySelector('.status-text');
        
        statusElement.className = `connection-status ${status}`;
        
        switch (status) {
            case 'loading':
                statusText.textContent = 'جاري التحميل...';
                break;
            case 'connected':
                statusText.textContent = 'متصل';
                break;
            case 'error':
                statusText.textContent = 'خطأ في الاتصال';
                break;
            default:
                statusText.textContent = 'غير متصل';
        }
    }

    showLoading() {
        document.getElementById('loading-state').style.display = 'block';
    }

    hideLoading() {
        document.getElementById('loading-state').style.display = 'none';
    }

    showError(message) {
        this.showToast(message, 'error');
    }

    showSuccess(message) {
        this.showToast(message, 'success');
    }

    showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast-notification ${type}`;
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : type === 'success' ? 'check-circle' : 'info-circle'}"></i>
            </div>
            <div class="toast-content">
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close">&times;</button>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => this.removeToast(toast), 5000);
        
        toast.querySelector('.toast-close').addEventListener('click', () => {
            this.removeToast(toast);
        });
    }

    removeToast(toast) {
        toast.classList.add('hide');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }

    debugSystem() {
        console.log('=== New Notification System Debug ===');
        console.log('Current type:', this.currentType);
        console.log('Notifications count:', this.notifications.length);
        console.log('Stats:', this.stats);
        console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'));
        console.log('Is loading:', this.isLoading);
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

    formatTimeAgo(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diff = now - date;
        
        if (diff < 60000) return 'الآن';
        if (diff < 3600000) return `${Math.floor(diff / 60000)} دقيقة`;
        if (diff < 86400000) return `${Math.floor(diff / 3600000)} ساعة`;
        return date.toLocaleDateString('ar-SA');
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    console.log('Initializing New Notification Manager...');
    window.notificationManager = new NewNotificationManager();
});
</script>

<style>
.notification-stats {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.stat-item {
    padding: 10px;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

.notification-tabs {
    background: white;
    border-bottom: 1px solid #dee2e6;
}

.notification-tabs .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    color: #6c757d;
    font-weight: 500;
    padding: 15px 20px;
    transition: all 0.3s ease;
}

.notification-tabs .nav-link:hover {
    color: #495057;
    background: #f8f9fa;
}

.notification-tabs .nav-link.active {
    color: #007bff;
    border-bottom-color: #007bff;
    background: #f8f9fa;
}

.notifications-container {
    max-height: 600px;
    overflow-y: auto;
}

.notification-item {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #f1f3f4;
    transition: all 0.3s ease;
    cursor: pointer;
}

.notification-item:hover {
    background: #f8f9fa;
}

.notification-item.read {
    opacity: 0.6;
    background: #f8f9fa;
}

.notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #007bff;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 15px;
    font-size: 16px;
}

.notification-content {
    flex: 1;
}

.notification-title {
    font-weight: 600;
    color: #212529;
    margin-bottom: 5px;
}

.notification-message {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 5px;
}

.notification-time {
    color: #adb5bd;
    font-size: 0.8rem;
}

.notification-actions {
    display: flex;
    gap: 5px;
}

.loading-state {
    padding: 40px;
}

.empty-state {
    padding: 40px;
}

.connection-status {
    display: flex;
    align-items: center;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.connection-status.loading {
    background: #fff3cd;
    color: #856404;
}

.connection-status.connected {
    background: #d4edda;
    color: #155724;
}

.connection-status.error {
    background: #f8d7da;
    color: #721c24;
}

/* Toast Notifications */
.toast-notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    padding: 16px;
    min-width: 300px;
    max-width: 400px;
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 12px;
    transform: translateX(100%);
    transition: transform 0.3s ease;
    border-right: 4px solid #007bff;
}

.toast-notification.error {
    border-right-color: #dc3545;
}

.toast-notification.success {
    border-right-color: #28a745;
}

.toast-notification.show {
    transform: translateX(0);
}

.toast-notification.hide {
    transform: translateX(100%);
}

.toast-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: white;
    background: #007bff;
}

.toast-notification.error .toast-icon {
    background: #dc3545;
}

.toast-notification.success .toast-icon {
    background: #28a745;
}

.toast-content {
    flex: 1;
}

.toast-message {
    color: #495057;
    font-size: 14px;
    line-height: 1.4;
}

.toast-close {
    background: none;
    border: none;
    font-size: 18px;
    color: #adb5bd;
    cursor: pointer;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.toast-close:hover {
    background-color: #f8f9fa;
    color: #495057;
}

@media (max-width: 768px) {
    .notification-stats .row {
        flex-direction: column;
    }
    
    .stat-item {
        margin-bottom: 10px;
    }
    
    .notification-tabs .nav-link {
        padding: 10px 15px;
        font-size: 0.9rem;
    }
    
    .notification-item {
        padding: 12px 15px;
    }
    
    .toast-notification {
        right: 10px;
        left: 10px;
        min-width: auto;
        max-width: none;
    }
}
</style>
@endsection
