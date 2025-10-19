// Service Worker for Push Notifications
const CACHE_NAME = 'infinity-wear-notifications-v1';
const NOTIFICATION_ICON = '/images/notification-icon.png';
const NOTIFICATION_BADGE = '/images/badge-icon.png';

// Install event
self.addEventListener('install', function(event) {
    console.log('Service Worker installing...');
    self.skipWaiting();
});

// Activate event
self.addEventListener('activate', function(event) {
    console.log('Service Worker activating...');
    event.waitUntil(self.clients.claim());
});

// Push event - handle incoming push notifications
self.addEventListener('push', function(event) {
    console.log('Push notification received:', event);
    
    if (!event.data) {
        console.log('Push event but no data');
        return;
    }

    try {
        const data = event.data.json();
        console.log('Push data:', data);
        
        const options = {
            body: data.body || 'لديك إشعار جديد',
            icon: data.icon || NOTIFICATION_ICON,
            badge: data.badge || NOTIFICATION_BADGE,
            tag: data.type || 'notification',
            data: data.data || {},
            actions: [
                {
                    action: 'view',
                    title: 'عرض',
                    icon: '/images/view-icon.png'
                },
                {
                    action: 'dismiss',
                    title: 'إغلاق',
                    icon: '/images/close-icon.png'
                }
            ],
            requireInteraction: data.requireInteraction || false,
            silent: data.silent || false,
            vibrate: data.vibrate || [200, 100, 200],
            timestamp: data.timestamp || Date.now(),
            renotify: true,
            tag: `notification-${data.type}-${data.id || Date.now()}`
        };

        event.waitUntil(
            self.registration.showNotification(data.title || 'إشعار جديد', options)
        );
        
    } catch (error) {
        console.error('Error handling push event:', error);
        
        // Fallback notification
        event.waitUntil(
            self.registration.showNotification('إشعار جديد', {
                body: 'لديك إشعار جديد من Infinity Wear',
                icon: NOTIFICATION_ICON,
                badge: NOTIFICATION_BADGE
            })
        );
    }
});

// Notification click event
self.addEventListener('notificationclick', function(event) {
    console.log('Notification clicked:', event);
    
    event.notification.close();
    
    if (event.action === 'dismiss') {
        return;
    }
    
    const urlToOpen = event.notification.data?.url || '/dashboard';
    
    event.waitUntil(
        clients.matchAll({
            type: 'window',
            includeUncontrolled: true
        }).then(function(clientList) {
            // Check if there's already a window/tab open with the target URL
            for (let i = 0; i < clientList.length; i++) {
                const client = clientList[i];
                if (client.url.includes(urlToOpen) && 'focus' in client) {
                    return client.focus();
                }
            }
            
            // If no existing window, open a new one
            if (clients.openWindow) {
                return clients.openWindow(urlToOpen);
            }
        })
    );
});

// Background sync for offline notifications
self.addEventListener('sync', function(event) {
    console.log('Background sync:', event.tag);
    
    if (event.tag === 'notification-sync') {
        event.waitUntil(syncNotifications());
    }
});

// Sync notifications when back online
function syncNotifications() {
    return fetch('/api/notifications/sync', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCSRFToken()
        }
    }).then(response => {
        if (response.ok) {
            console.log('Notifications synced successfully');
        }
    }).catch(error => {
        console.error('Failed to sync notifications:', error);
    });
}

// Get CSRF token from meta tag
function getCSRFToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

// Handle notification close
self.addEventListener('notificationclose', function(event) {
    console.log('Notification closed:', event);
    
    // Track notification dismissal
    if (event.notification.data?.id) {
        fetch('/api/notifications/dismiss', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCSRFToken()
            },
            body: JSON.stringify({
                notification_id: event.notification.data.id
            })
        }).catch(error => {
            console.error('Failed to track notification dismissal:', error);
        });
    }
});

// Message event for communication with main thread
self.addEventListener('message', function(event) {
    console.log('Service Worker received message:', event.data);
    
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
    
    if (event.data && event.data.type === 'GET_VERSION') {
        event.ports[0].postMessage({
            version: CACHE_NAME
        });
    }
});

// Error handling
self.addEventListener('error', function(event) {
    console.error('Service Worker error:', event);
});

self.addEventListener('unhandledrejection', function(event) {
    console.error('Service Worker unhandled rejection:', event);
});

console.log('Service Worker loaded successfully');