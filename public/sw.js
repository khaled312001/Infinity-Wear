// Service Worker for Push Notifications
// Infinity Wear - Mobile Push Notifications

const CACHE_NAME = 'infinity-wear-v1';
const urlsToCache = [
    '/',
    '/css/app.css',
    '/js/app.js',
    '/images/logo.png'
];

// Install Service Worker
self.addEventListener('install', function(event) {
    console.log('Service Worker: Installing...');
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function(cache) {
                console.log('Service Worker: Caching files');
                return cache.addAll(urlsToCache);
            })
    );
});

// Activate Service Worker
self.addEventListener('activate', function(event) {
    console.log('Service Worker: Activating...');
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.map(function(cacheName) {
                    if (cacheName !== CACHE_NAME) {
                        console.log('Service Worker: Deleting old cache');
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// Handle Push Notifications
self.addEventListener('push', function(event) {
    console.log('Service Worker: Push received');
    
    let notificationData = {
        title: 'Infinity Wear',
        body: 'لديك إشعار جديد',
        icon: '/images/logo.png',
        badge: '/images/logo.png',
        tag: 'infinity-wear-notification',
        requireInteraction: true,
        actions: [
            {
                action: 'view',
                title: 'عرض',
                icon: '/images/view-icon.png'
            },
            {
                action: 'close',
                title: 'إغلاق',
                icon: '/images/close-icon.png'
            }
        ],
        data: {
            url: '/admin/notifications'
        }
    };

    // Parse push data if available
    if (event.data) {
        try {
            const pushData = event.data.json();
            notificationData = {
                ...notificationData,
                ...pushData
            };
        } catch (e) {
            console.log('Service Worker: Error parsing push data', e);
            notificationData.body = event.data.text() || notificationData.body;
        }
    }

    const promiseChain = self.registration.showNotification(
        notificationData.title,
        notificationData
    );

    event.waitUntil(promiseChain);
});

// Handle Notification Click
self.addEventListener('notificationclick', function(event) {
    console.log('Service Worker: Notification clicked');
    
    event.notification.close();

    if (event.action === 'close') {
        return;
    }

    const urlToOpen = event.notification.data?.url || '/admin/notifications';
    
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

// Handle Background Sync (for offline notifications)
self.addEventListener('sync', function(event) {
    console.log('Service Worker: Background sync');
    
    if (event.tag === 'notification-sync') {
        event.waitUntil(
            // Sync notifications when back online
            syncNotifications()
        );
    }
});

// Sync notifications function
async function syncNotifications() {
    try {
        const response = await fetch('/api/notifications/sync', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': await getCSRFToken()
            }
        });
        
        if (response.ok) {
            console.log('Service Worker: Notifications synced');
        }
    } catch (error) {
        console.log('Service Worker: Sync failed', error);
    }
}

// Get CSRF token for API calls
async function getCSRFToken() {
    try {
        const response = await fetch('/api/csrf-token');
        const data = await response.json();
        return data.csrf_token;
    } catch (error) {
        console.log('Service Worker: Failed to get CSRF token', error);
        return '';
    }
}

// Handle Message from Main Thread
self.addEventListener('message', function(event) {
    console.log('Service Worker: Message received', event.data);
    
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
});

// Handle Fetch Events (for offline support)
self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request)
            .then(function(response) {
                // Return cached version or fetch from network
                return response || fetch(event.request);
            }
        )
    );
});

// Handle Push Subscription Changes
self.addEventListener('pushsubscriptionchange', function(event) {
    console.log('Service Worker: Push subscription changed');
    
    event.waitUntil(
        // Re-subscribe to push notifications
        self.registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(
                'BEl62iUYgUivxIkv69yViEuiBIa40HI0QY-DRhkJjlbHUsQ_8j0ONQZfpb3ywsxcrkAIzHFrLyxcc96S0XgL0B8' // VAPID Public Key
            )
        }).then(function(subscription) {
            // Send new subscription to server
            return fetch('/api/push/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': event.oldSubscription ? 'renewal' : 'new'
                },
                body: JSON.stringify(subscription)
            });
        })
    );
});

// Convert VAPID key
function urlBase64ToUint8Array(base64String) {
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

console.log('Service Worker: Loaded successfully');
