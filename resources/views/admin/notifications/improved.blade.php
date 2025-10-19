@extends('layouts.dashboard')

@section('title', 'الإشعارات المحسنة')
@section('dashboard-title', 'الإشعارات المحسنة')
@section('page-title', 'نظام إشعارات محسن')
@section('page-subtitle', 'عرض سريع ومبسط للإشعارات')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-bell me-2"></i>
                    الإشعارات المحسنة
                </h3>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="loadNotifications()">
                        <i class="fas fa-sync-alt"></i>
                        تحديث
                    </button>
                    <button class="btn btn-outline-success btn-sm" onclick="markAllAsRead()">
                        <i class="fas fa-check-double"></i>
                        تحديد الكل كمقروء
                    </button>
                    <button class="btn btn-outline-info btn-sm" onclick="createTestNotification()">
                        <i class="fas fa-plus"></i>
                        إشعار تجريبي
                    </button>
                    <button class="btn btn-outline-warning btn-sm" onclick="debugSystem()">
                        <i class="fas fa-bug"></i>
                        تشخيص
                    </button>
                </div>
            </div>
                
            <div class="card-body">
                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="stat-card text-center p-3 bg-primary text-white rounded">
                            <h4 id="total-unread">0</h4>
                            <small>غير مقروءة</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="stat-card text-center p-3 bg-success text-white rounded">
                            <h4 id="orders-count">0</h4>
                            <small>الطلبات</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="stat-card text-center p-3 bg-info text-white rounded">
                            <h4 id="contacts-count">0</h4>
                            <small>الرسائل</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="stat-card text-center p-3 bg-warning text-white rounded">
                            <h4 id="whatsapp-count">0</h4>
                            <small>الواتساب</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="stat-card text-center p-3 bg-danger text-white rounded">
                            <h4 id="importer-count">0</h4>
                            <small>المستوردين</small>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="stat-card text-center p-3 bg-secondary text-white rounded">
                            <h4 id="total-count">0</h4>
                            <small>الكل</small>
                        </div>
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="notification-tabs mb-4">
                    <ul class="nav nav-pills" id="filter-tabs">
                        <li class="nav-item">
                            <button class="nav-link active" data-filter="all">
                                <i class="fas fa-list me-2"></i>
                                الكل <span class="badge bg-primary ms-1" id="all-badge">0</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-filter="unread">
                                <i class="fas fa-envelope me-2"></i>
                                غير مقروءة <span class="badge bg-danger ms-1" id="unread-badge">0</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-filter="order">
                                <i class="fas fa-shopping-cart me-2"></i>
                                الطلبات <span class="badge bg-success ms-1" id="orders-badge">0</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-filter="contact">
                                <i class="fas fa-envelope me-2"></i>
                                الرسائل <span class="badge bg-info ms-1" id="contacts-badge">0</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-filter="whatsapp">
                                <i class="fab fa-whatsapp me-2"></i>
                                الواتساب <span class="badge bg-warning ms-1" id="whatsapp-badge">0</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-filter="importer_order">
                                <i class="fas fa-truck me-2"></i>
                                المستوردين <span class="badge bg-danger ms-1" id="importer-badge">0</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Loading State -->
                <div id="loading-state" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">جاري التحميل...</span>
                    </div>
                    <p class="mt-3 text-muted">جاري تحميل الإشعارات...</p>
                </div>

                <!-- Notifications Container -->
                <div id="notifications-container" style="display: none;">
                    <!-- Notifications will be loaded here -->
                </div>

                <!-- Empty State -->
                <div id="empty-state" class="text-center py-5" style="display: none;">
                    <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد إشعارات</h4>
                    <p class="text-muted">لم يتم العثور على إشعارات في النظام</p>
                    <button class="btn btn-outline-primary btn-sm" onclick="createTestNotification()">
                        <i class="fas fa-plus"></i>
                        إنشاء إشعار تجريبي
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
class ImprovedNotificationManager {
    constructor() {
        this.currentFilter = 'all';
        this.notifications = [];
        this.stats = {};
        this.isLoading = false;
        
        this.init();
    }

    init() {
        console.log('Initializing Improved Notification Manager...');
        this.setupEventListeners();
        this.loadNotifications();
    }

    setupEventListeners() {
        // Filter tabs
        document.querySelectorAll('#filter-tabs .nav-link').forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                const filter = e.currentTarget.getAttribute('data-filter');
                this.switchFilter(filter);
            });
        });
    }

    async loadNotifications() {
        if (this.isLoading) return;
        
        this.isLoading = true;
        this.showLoading();
        
        try {
            console.log('Loading notifications...');
            
            const response = await fetch('{{ route("admin.notifications.unread") }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
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
            } else {
                throw new Error(data.message || 'فشل في تحميل الإشعارات');
            }

        } catch (error) {
            console.error('Error loading notifications:', error);
            this.showError('فشل في تحميل الإشعارات: ' + error.message);
        } finally {
            this.isLoading = false;
            this.hideLoading();
        }
    }

    switchFilter(filter) {
        console.log('Switching to filter:', filter);
        this.currentFilter = filter;
        
        // Update active tab
        document.querySelectorAll('#filter-tabs .nav-link').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelector(`[data-filter="${filter}"]`).classList.add('active');
        
        this.renderNotifications();
    }

    renderNotifications() {
        const container = document.getElementById('notifications-container');
        const emptyState = document.getElementById('empty-state');
        
        let filteredNotifications = this.notifications;
        
        // Filter based on current filter
        if (this.currentFilter === 'unread') {
            filteredNotifications = this.notifications.filter(n => !n.is_read);
        } else if (this.currentFilter !== 'all') {
            filteredNotifications = this.notifications.filter(n => n.type === this.currentFilter);
        }
        
        if (filteredNotifications.length === 0) {
            container.style.display = 'none';
            emptyState.style.display = 'block';
            return;
        }

        container.style.display = 'block';
        emptyState.style.display = 'none';
        
        container.innerHTML = filteredNotifications.map(notification => 
            this.createNotificationElement(notification)
        ).join('');

        // Add event listeners
        this.addNotificationEventListeners();
    }

    createNotificationElement(notification) {
        const timeAgo = this.formatTimeAgo(notification.created_at);
        const isRead = notification.is_read ? 'read' : '';
        const icon = this.getNotificationIcon(notification.type);
        
        return `
            <div class="notification-item ${isRead} mb-3 p-3 border rounded" data-id="${notification.id}">
                <div class="d-flex align-items-start">
                    <div class="notification-icon me-3">
                        <i class="${icon}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">${notification.title}</h6>
                        <p class="mb-2 text-muted">${notification.message}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">${timeAgo}</small>
                            <span class="badge bg-${this.getNotificationColor(notification.type)}">${this.getNotificationTypeLabel(notification.type)}</span>
                        </div>
                    </div>
                    <div class="notification-actions">
                        <button class="btn btn-sm btn-outline-primary mark-read" data-id="${notification.id}">
                            <i class="fas fa-check"></i>
                        </button>
                    </div>
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
            const response = await fetch('{{ route("admin.notifications.mark-read") }}', {
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
            const response = await fetch('{{ route("admin.notifications.mark-all-read") }}', {
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

    createTestNotification() {
        try {
            // Create a simple test notification locally
            const testNotification = {
                id: Date.now(),
                type: 'system',
                title: 'إشعار تجريبي',
                message: 'هذا إشعار تجريبي تم إنشاؤه في ' + new Date().toLocaleString('ar-SA'),
                icon: 'fas fa-bell',
                color: 'primary',
                is_read: false,
                created_at: new Date().toISOString()
            };
            
            this.notifications.unshift(testNotification);
            this.renderNotifications();
            this.updateStats();
            
            this.showSuccess('تم إنشاء إشعار تجريبي بنجاح');
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

    showLoading() {
        document.getElementById('loading-state').style.display = 'block';
        document.getElementById('notifications-container').style.display = 'none';
        document.getElementById('empty-state').style.display = 'none';
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
        console.log('=== Improved Notification System Debug ===');
        console.log('Current filter:', this.currentFilter);
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

    getNotificationColor(type) {
        const colors = {
            'order': 'success',
            'contact': 'info',
            'whatsapp': 'warning',
            'importer_order': 'danger',
            'system': 'primary',
            'task': 'secondary',
            'marketing': 'dark',
            'sales': 'light'
        };
        return colors[type] || 'primary';
    }

    getNotificationTypeLabel(type) {
        const labels = {
            'order': 'طلب',
            'contact': 'رسالة',
            'whatsapp': 'واتساب',
            'importer_order': 'مستورد',
            'system': 'نظام',
            'task': 'مهمة',
            'marketing': 'تسويق',
            'sales': 'مبيعات'
        };
        return labels[type] || 'إشعار';
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

// Global functions for button handlers
function loadNotifications() {
    if (window.improvedNotificationManager) {
        window.improvedNotificationManager.loadNotifications();
    }
}

function markAllAsRead() {
    if (window.improvedNotificationManager) {
        window.improvedNotificationManager.markAllAsRead();
    }
}

function createTestNotification() {
    if (window.improvedNotificationManager) {
        window.improvedNotificationManager.createTestNotification();
    }
}

function debugSystem() {
    if (window.improvedNotificationManager) {
        window.improvedNotificationManager.debugSystem();
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    console.log('Initializing Improved Notification Manager...');
    window.improvedNotificationManager = new ImprovedNotificationManager();
});
</script>

<style>
.stat-card {
    transition: transform 0.3s ease;
    cursor: pointer;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.notification-tabs {
    background: white;
    border-radius: 8px;
    padding: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.notification-tabs .nav-link {
    border: none;
    border-radius: 20px;
    color: #6c757d;
    font-weight: 500;
    padding: 8px 16px;
    transition: all 0.3s ease;
    margin: 0 2px;
}

.notification-tabs .nav-link:hover {
    color: #495057;
    background: #f8f9fa;
}

.notification-tabs .nav-link.active {
    color: white;
    background: #007bff;
}

.notification-item {
    transition: all 0.3s ease;
    cursor: pointer;
    border-left: 4px solid #007bff !important;
}

.notification-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.notification-item.read {
    opacity: 0.6;
    background-color: #f8f9fa;
    border-left-color: #6c757d !important;
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
    font-size: 16px;
    flex-shrink: 0;
}

.notification-actions {
    display: flex;
    gap: 5px;
    flex-shrink: 0;
}

.loading-state {
    padding: 40px;
}

.empty-state {
    padding: 40px;
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
    .stat-card {
        margin-bottom: 10px;
    }
    
    .notification-tabs .nav-link {
        padding: 6px 12px;
        font-size: 0.9rem;
        margin: 2px 1px;
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
