/**
 * Infinity Wear - Advanced Notification System
 * Handles real-time notifications, push notifications, and WebSocket connections
 */

class NotificationManager {
    constructor() {
        this.isSupported = 'Notification' in window && 'serviceWorker' in navigator;
        this.permission = Notification.permission;
        this.subscription = null;
        this.websocket = null;
        this.notificationContainer = null;
        this.statsContainer = null;
        this.isConnected = false;
        
        this.init();
    }

    /**
     * Initialize notification system
     */
    async init() {
        if (!this.isSupported) {
            console.warn('Notifications not supported in this browser');
            return;
        }

        try {
            // Register service worker
            await this.registerServiceWorker();
            
            // Request notification permission
            await this.requestPermission();
            
            // Subscribe to push notifications
            await this.subscribeToPush();
            
            // Initialize WebSocket connection
            this.initWebSocket();
            
            // Initialize UI
            this.initUI();
            
            // Load existing notifications
            this.loadNotifications();
            
            console.log('Notification system initialized successfully');
            
        } catch (error) {
            console.error('Failed to initialize notification system:', error);
        }
    }

    /**
     * Register service worker
     */
    async registerServiceWorker() {
        try {
            const registration = await navigator.serviceWorker.register('/sw.js');
            console.log('Service Worker registered:', registration);
            
            // Listen for updates
            registration.addEventListener('updatefound', () => {
                const newWorker = registration.installing;
                newWorker.addEventListener('statechange', () => {
                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                        this.showUpdateNotification();
                    }
                });
            });
            
            return registration;
        } catch (error) {
            console.error('Service Worker registration failed:', error);
            throw error;
        }
    }

    /**
     * Request notification permission
     */
    async requestPermission() {
        if (this.permission === 'granted') {
            return true;
        }

        if (this.permission === 'denied') {
            console.warn('Notification permission denied');
            return false;
        }

        try {
            this.permission = await Notification.requestPermission();
            return this.permission === 'granted';
        } catch (error) {
            console.error('Failed to request notification permission:', error);
            return false;
        }
    }

    /**
     * Subscribe to push notifications
     */
    async subscribeToPush() {
        if (!this.isSupported || this.permission !== 'granted') {
            return false;
        }

        try {
            const registration = await navigator.serviceWorker.ready;
            const subscription = await registration.pushManager.getSubscription();
            
            if (subscription) {
                this.subscription = subscription;
                console.log('Already subscribed to push notifications');
                return true;
            }

            // Subscribe to push notifications
            const newSubscription = await registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: this.urlBase64ToUint8Array(this.getVapidPublicKey())
            });

            // Send subscription to server
            await this.sendSubscriptionToServer(newSubscription);
            
            this.subscription = newSubscription;
            console.log('Subscribed to push notifications');
            return true;
            
        } catch (error) {
            console.error('Failed to subscribe to push notifications:', error);
            return false;
        }
    }

    /**
     * Send subscription to server
     */
    async sendSubscriptionToServer(subscription) {
        try {
            const response = await fetch('/api/notifications/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.getCSRFToken()
                },
                body: JSON.stringify({
                    endpoint: subscription.endpoint,
                    keys: {
                        p256dh: this.arrayBufferToBase64(subscription.getKey('p256dh')),
                        auth: this.arrayBufferToBase64(subscription.getKey('auth'))
                    },
                    user_agent: navigator.userAgent,
                    device_type: this.getDeviceType()
                })
            });

            if (!response.ok) {
                throw new Error('Failed to send subscription to server');
            }

            const result = await response.json();
            console.log('Subscription sent to server:', result);
            
        } catch (error) {
            console.error('Failed to send subscription to server:', error);
            throw error;
        }
    }

    /**
     * Initialize WebSocket connection
     */
    initWebSocket() {
        try {
            const protocol = window.location.protocol === 'https:' ? 'wss:' : 'ws:';
            const wsUrl = `${protocol}//${window.location.host}/ws/notifications`;
            
            this.websocket = new WebSocket(wsUrl);
            
            this.websocket.onopen = () => {
                console.log('WebSocket connected');
                this.isConnected = true;
                this.updateConnectionStatus(true);
            };
            
            this.websocket.onmessage = (event) => {
                try {
                    const data = JSON.parse(event.data);
                    this.handleWebSocketMessage(data);
                } catch (error) {
                    console.error('Failed to parse WebSocket message:', error);
                }
            };
            
            this.websocket.onclose = () => {
                console.log('WebSocket disconnected');
                this.isConnected = false;
                this.updateConnectionStatus(false);
                
                // Reconnect after 5 seconds
                setTimeout(() => {
                    this.initWebSocket();
                }, 5000);
            };
            
            this.websocket.onerror = (error) => {
                console.error('WebSocket error:', error);
            };
            
        } catch (error) {
            console.error('Failed to initialize WebSocket:', error);
        }
    }

    /**
     * Handle WebSocket messages
     */
    handleWebSocketMessage(data) {
        switch (data.type) {
            case 'notification.sent':
                this.handleNewNotification(data);
                break;
            case 'notification.stats.updated':
                this.updateStats(data.stats);
                break;
            case 'notification.read':
                this.handleNotificationRead(data.notification_id);
                break;
            case 'notification.archived':
                this.handleNotificationArchived(data.notification_id);
                break;
            default:
                console.log('Unknown WebSocket message type:', data.type);
        }
    }

    /**
     * Handle new notification
     */
    handleNewNotification(data) {
        // Add to UI
        this.addNotificationToUI(data);
        
        // Update stats
        this.updateNotificationCount(1);
        
        // Show browser notification if permission granted
        if (this.permission === 'granted') {
            this.showBrowserNotification(data);
        }
        
        // Play sound
        this.playNotificationSound();
        
        // Show toast notification
        this.showToastNotification(data);
    }

    /**
     * Add notification to UI
     */
    addNotificationToUI(notification) {
        if (!this.notificationContainer) {
            return;
        }

        const notificationElement = this.createNotificationElement(notification);
        this.notificationContainer.insertBefore(notificationElement, this.notificationContainer.firstChild);
        
        // Add animation
        notificationElement.classList.add('notification-enter');
        
        // Remove old notifications if too many
        const notifications = this.notificationContainer.querySelectorAll('.notification-item');
        if (notifications.length > 50) {
            notifications[notifications.length - 1].remove();
        }
    }

    /**
     * Create notification element
     */
    createNotificationElement(notification) {
        const element = document.createElement('div');
        element.className = 'notification-item';
        element.dataset.notificationId = notification.id;
        element.dataset.type = notification.type;
        
        element.innerHTML = `
            <div class="notification-icon">
                <i class="${notification.icon}"></i>
            </div>
            <div class="notification-content">
                <div class="notification-title">${notification.title}</div>
                <div class="notification-message">${notification.message}</div>
                <div class="notification-time">${this.formatTime(notification.created_at)}</div>
            </div>
            <div class="notification-actions">
                <button class="btn btn-sm btn-outline-primary mark-read" data-id="${notification.id}">
                    <i class="fas fa-check"></i>
                </button>
                <button class="btn btn-sm btn-outline-secondary archive" data-id="${notification.id}">
                    <i class="fas fa-archive"></i>
                </button>
            </div>
        `;
        
        // Add event listeners
        element.querySelector('.mark-read').addEventListener('click', (e) => {
            e.stopPropagation();
            this.markAsRead(notification.id);
        });
        
        element.querySelector('.archive').addEventListener('click', (e) => {
            e.stopPropagation();
            this.archiveNotification(notification.id);
        });
        
        element.addEventListener('click', () => {
            this.markAsRead(notification.id);
            this.openNotification(notification);
        });
        
        return element;
    }

    /**
     * Show browser notification
     */
    showBrowserNotification(notification) {
        if (this.permission !== 'granted') {
            return;
        }

        const options = {
            body: notification.message,
            icon: notification.icon || '/images/notification-icon.png',
            badge: '/images/badge-icon.png',
            tag: `notification-${notification.type}-${notification.id}`,
            data: notification.data,
            requireInteraction: notification.type === 'urgent',
            vibrate: [200, 100, 200],
            timestamp: new Date(notification.created_at).getTime()
        };

        const browserNotification = new Notification(notification.title, options);
        
        browserNotification.onclick = () => {
            window.focus();
            this.openNotification(notification);
            browserNotification.close();
        };
        
        // Auto close after 5 seconds
        setTimeout(() => {
            browserNotification.close();
        }, 5000);
    }

    /**
     * Show toast notification
     */
    showToastNotification(notification) {
        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="${notification.icon}"></i>
            </div>
            <div class="toast-content">
                <div class="toast-title">${notification.title}</div>
                <div class="toast-message">${notification.message}</div>
            </div>
            <button class="toast-close">&times;</button>
        `;
        
        document.body.appendChild(toast);
        
        // Add animation
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            this.removeToast(toast);
        }, 5000);
        
        // Close button
        toast.querySelector('.toast-close').addEventListener('click', () => {
            this.removeToast(toast);
        });
    }

    /**
     * Remove toast notification
     */
    removeToast(toast) {
        toast.classList.add('hide');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }

    /**
     * Play notification sound
     */
    playNotificationSound() {
        try {
            const audio = new Audio('/sounds/notification.mp3');
            audio.volume = 0.5;
            audio.play().catch(error => {
                console.log('Could not play notification sound:', error);
            });
        } catch (error) {
            console.log('Notification sound not available:', error);
        }
    }

    /**
     * Load existing notifications
     */
    async loadNotifications() {
        try {
            const response = await fetch('/api/notifications', {
                headers: {
                    'X-CSRF-TOKEN': this.getCSRFToken()
                }
            });
            
            if (!response.ok) {
                throw new Error('Failed to load notifications');
            }
            
            const data = await response.json();
            this.updateNotificationCount(data.unread_count);
            
        } catch (error) {
            console.error('Failed to load notifications:', error);
        }
    }

    /**
     * Mark notification as read
     */
    async markAsRead(notificationId) {
        try {
            const response = await fetch(`/api/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.getCSRFToken()
                }
            });
            
            if (response.ok) {
                const element = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (element) {
                    element.classList.add('read');
                }
                this.updateNotificationCount(-1);
            }
            
        } catch (error) {
            console.error('Failed to mark notification as read:', error);
        }
    }

    /**
     * Archive notification
     */
    async archiveNotification(notificationId) {
        try {
            const response = await fetch(`/api/notifications/${notificationId}/archive`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.getCSRFToken()
                }
            });
            
            if (response.ok) {
                const element = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (element) {
                    element.remove();
                }
            }
            
        } catch (error) {
            console.error('Failed to archive notification:', error);
        }
    }

    /**
     * Open notification
     */
    openNotification(notification) {
        const url = this.getNotificationUrl(notification);
        if (url) {
            window.location.href = url;
        }
    }

    /**
     * Get notification URL
     */
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

    /**
     * Update notification count
     */
    updateNotificationCount(delta) {
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            const currentCount = parseInt(badge.textContent) || 0;
            const newCount = Math.max(0, currentCount + delta);
            badge.textContent = newCount;
            badge.style.display = newCount > 0 ? 'inline' : 'none';
        }
    }

    /**
     * Update stats
     */
    updateStats(stats) {
        if (this.statsContainer) {
            this.statsContainer.innerHTML = `
                <div class="stat-item">
                    <span class="stat-label">غير مقروءة:</span>
                    <span class="stat-value">${stats.total_unread}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">الطلبات:</span>
                    <span class="stat-value">${stats.orders}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">الرسائل:</span>
                    <span class="stat-value">${stats.contacts}</span>
                </div>
            `;
        }
    }

    /**
     * Update connection status
     */
    updateConnectionStatus(connected) {
        const statusElement = document.querySelector('.connection-status');
        if (statusElement) {
            statusElement.className = `connection-status ${connected ? 'connected' : 'disconnected'}`;
            statusElement.textContent = connected ? 'متصل' : 'غير متصل';
        }
    }

    /**
     * Initialize UI elements
     */
    initUI() {
        this.notificationContainer = document.querySelector('.notifications-container');
        this.statsContainer = document.querySelector('.notification-stats');
        
        // Add event listeners for global actions
        const markAllReadBtn = document.querySelector('.mark-all-read');
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', () => {
                this.markAllAsRead();
            });
        }
        
        const archiveReadBtn = document.querySelector('.archive-read');
        if (archiveReadBtn) {
            archiveReadBtn.addEventListener('click', () => {
                this.archiveRead();
            });
        }
    }

    /**
     * Mark all notifications as read
     */
    async markAllAsRead() {
        try {
            const response = await fetch('/api/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.getCSRFToken()
                }
            });
            
            if (response.ok) {
                const data = await response.json();
                this.updateNotificationCount(-data.count);
                
                // Update UI
                document.querySelectorAll('.notification-item').forEach(item => {
                    item.classList.add('read');
                });
            }
            
        } catch (error) {
            console.error('Failed to mark all as read:', error);
        }
    }

    /**
     * Archive read notifications
     */
    async archiveRead() {
        try {
            const response = await fetch('/api/notifications/archive-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.getCSRFToken()
                }
            });
            
            if (response.ok) {
                const data = await response.json();
                
                // Remove read notifications from UI
                document.querySelectorAll('.notification-item.read').forEach(item => {
                    item.remove();
                });
            }
            
        } catch (error) {
            console.error('Failed to archive read notifications:', error);
        }
    }

    /**
     * Utility functions
     */
    urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/-/g, '+')
            .replace(/_/g, '/');
        
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

    arrayBufferToBase64(buffer) {
        const bytes = new Uint8Array(buffer);
        let binary = '';
        for (let i = 0; i < bytes.byteLength; i++) {
            binary += String.fromCharCode(bytes[i]);
        }
        return window.btoa(binary);
    }

    getVapidPublicKey() {
        return document.querySelector('meta[name="vapid-public-key"]')?.getAttribute('content') || '';
    }

    getCSRFToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    getDeviceType() {
        const userAgent = navigator.userAgent.toLowerCase();
        if (/mobile|android|iphone|ipad|phone/i.test(userAgent)) {
            return 'mobile';
        } else if (/tablet|ipad/i.test(userAgent)) {
            return 'tablet';
        }
        return 'desktop';
    }

    formatTime(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diff = now - date;
        
        if (diff < 60000) { // Less than 1 minute
            return 'الآن';
        } else if (diff < 3600000) { // Less than 1 hour
            return `${Math.floor(diff / 60000)} دقيقة`;
        } else if (diff < 86400000) { // Less than 1 day
            return `${Math.floor(diff / 3600000)} ساعة`;
        } else {
            return date.toLocaleDateString('ar-SA');
        }
    }

    showUpdateNotification() {
        if (confirm('تحديث متاح! هل تريد إعادة تحميل الصفحة؟')) {
            window.location.reload();
        }
    }
}

// Initialize notification system when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.notificationManager = new NotificationManager();
});

// Export for global access
window.NotificationManager = NotificationManager;
