@extends('layouts.dashboard')

@section('title', 'الإشعارات الجديدة')
@section('dashboard-title', 'الإشعارات الجديدة')
@section('page-title', 'نظام إشعارات محسن')
@section('page-subtitle', 'عرض سريع ومبسط للإشعارات')

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
let notifications = [];
let stats = {};

// Load notifications on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded, loading notifications...');
    loadNotifications();
});

async function loadNotifications() {
    console.log('Loading notifications...');
    showLoading();
    
    try {
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
            notifications = data.notifications || [];
            stats = data.stats || {};
            renderNotifications();
            updateStats();
        } else {
            throw new Error(data.message || 'فشل في تحميل الإشعارات');
        }

    } catch (error) {
        console.error('Error loading notifications:', error);
        showError('فشل في تحميل الإشعارات: ' + error.message);
    } finally {
        hideLoading();
    }
}

function renderNotifications() {
    const container = document.getElementById('notifications-container');
    const emptyState = document.getElementById('empty-state');
    
    if (notifications.length === 0) {
        container.style.display = 'none';
        emptyState.style.display = 'block';
        return;
    }

    container.style.display = 'block';
    emptyState.style.display = 'none';
    
    container.innerHTML = notifications.map(notification => 
        createNotificationElement(notification)
    ).join('');

    // Add event listeners
    addNotificationEventListeners();
}

function createNotificationElement(notification) {
    const timeAgo = formatTimeAgo(notification.created_at);
    const isRead = notification.is_read ? 'read' : '';
    const icon = getNotificationIcon(notification.type);
    
    return `
        <div class="notification-item ${isRead} mb-3 p-3 border rounded" data-id="${notification.id}">
            <div class="d-flex align-items-start">
                <div class="notification-icon me-3">
                    <i class="${icon}"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-1">${notification.title}</h6>
                    <p class="mb-2 text-muted">${notification.message}</p>
                    <small class="text-muted">${timeAgo}</small>
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

function addNotificationEventListeners() {
    document.querySelectorAll('.mark-read').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const id = e.currentTarget.getAttribute('data-id');
            markAsRead(id);
        });
    });

    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', (e) => {
            if (!e.target.closest('.notification-actions')) {
                const id = item.getAttribute('data-id');
                markAsRead(id);
            }
        });
    });
}

async function markAsRead(notificationId) {
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
            const notification = notifications.find(n => n.id == notificationId);
            if (notification) {
                notification.is_read = true;
                notification.read_at = new Date().toISOString();
            }
            
            // Re-render
            renderNotifications();
            updateStats();
            
            showSuccess('تم تحديد الإشعار كمقروء');
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        console.error('Error marking as read:', error);
        showError('فشل في تحديث الإشعار');
    }
}

async function markAllAsRead() {
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
            notifications.forEach(n => {
                n.is_read = true;
                n.read_at = new Date().toISOString();
            });
            
            // Re-render
            renderNotifications();
            updateStats();
            
            showSuccess(data.message);
        } else {
            throw new Error(data.message);
        }
    } catch (error) {
        console.error('Error marking all as read:', error);
        showError('فشل في تحديث الإشعارات');
    }
}

async function createTestNotification() {
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
        
        notifications.unshift(testNotification);
        renderNotifications();
        updateStats();
        
        showSuccess('تم إنشاء إشعار تجريبي بنجاح');
    } catch (error) {
        console.error('Error creating test notification:', error);
        showError('فشل في إنشاء الإشعار التجريبي');
    }
}

function updateStats() {
    document.getElementById('total-unread').textContent = stats.total_unread || 0;
    document.getElementById('orders-count').textContent = stats.orders || 0;
    document.getElementById('contacts-count').textContent = stats.contacts || 0;
    document.getElementById('whatsapp-count').textContent = stats.whatsapp || 0;
    document.getElementById('importer-count').textContent = stats.importer_orders || 0;
    document.getElementById('total-count').textContent = stats.total || 0;
}

function showLoading() {
    document.getElementById('loading-state').style.display = 'block';
    document.getElementById('notifications-container').style.display = 'none';
    document.getElementById('empty-state').style.display = 'none';
}

function hideLoading() {
    document.getElementById('loading-state').style.display = 'none';
}

function showError(message) {
    showToast(message, 'error');
}

function showSuccess(message) {
    showToast(message, 'success');
}

function showToast(message, type = 'info') {
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
    setTimeout(() => removeToast(toast), 5000);
    
    toast.querySelector('.toast-close').addEventListener('click', () => {
        removeToast(toast);
    });
}

function removeToast(toast) {
    toast.classList.add('hide');
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 300);
}

function getNotificationIcon(type) {
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

function formatTimeAgo(timestamp) {
    const date = new Date(timestamp);
    const now = new Date();
    const diff = now - date;
    
    if (diff < 60000) return 'الآن';
    if (diff < 3600000) return `${Math.floor(diff / 60000)} دقيقة`;
    if (diff < 86400000) return `${Math.floor(diff / 3600000)} ساعة`;
    return date.toLocaleDateString('ar-SA');
}
</script>

<style>
.stat-card {
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.notification-item {
    transition: all 0.3s ease;
    cursor: pointer;
}

.notification-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

.notification-item.read {
    opacity: 0.6;
    background-color: #f8f9fa;
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
    
    .toast-notification {
        right: 10px;
        left: 10px;
        min-width: auto;
        max-width: none;
    }
}
</style>
@endsection
