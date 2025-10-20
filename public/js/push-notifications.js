/**
 * Push Notifications Manager for Infinity Wear
 * Handles Web Push API integration
 */

class PushNotificationManager {
    constructor() {
        this.isSupported = 'serviceWorker' in navigator && 'PushManager' in window;
        this.registration = null;
        this.subscription = null;
        this.vapidPublicKey = null;
		this.unavailableReason = null;
        
        this.init();
    }

    /**
     * Initialize push notifications
     */
    async init() {
		if (!this.isSupported) {
            console.log('Push notifications are not supported in this browser');
            return false;
        }

		// Respect session-scoped unavailability (e.g., private mode or prior hard failure)
		try {
			const storedReason = sessionStorage.getItem('push_unavailable_reason');
			if (storedReason) {
				this.unavailableReason = storedReason;
				return false;
			}
		} catch (e) {}

        try {
            // Register service worker
            this.registration = await navigator.serviceWorker.register('/sw.js');
            console.log('Service Worker registered successfully');

            // Get VAPID public key
            await this.getVapidPublicKey();

            // Check current subscription
            this.subscription = await this.registration.pushManager.getSubscription();

            // Set up event listeners
            this.setupEventListeners();

            return true;
		} catch (error) {
			console.error('Error initializing push notifications:', error);
			return false;
		}
    }

    /**
     * Get VAPID public key from server
     */
    async getVapidPublicKey() {
        try {
            const response = await fetch('/api/push/vapid-key');
            const data = await response.json();
            this.vapidPublicKey = data.public_key;
        } catch (error) {
            console.error('Error getting VAPID key:', error);
        }
    }

    /**
     * Set up event listeners
     */
    setupEventListeners() {
        // Listen for service worker messages
        navigator.serviceWorker.addEventListener('message', (event) => {
            console.log('Message from service worker:', event.data);
        });

        // Listen for push events
        navigator.serviceWorker.addEventListener('push', (event) => {
            console.log('Push event received:', event);
        });

        // Listen for notification clicks
        navigator.serviceWorker.addEventListener('notificationclick', (event) => {
            console.log('Notification clicked:', event);
        });
    }

    /**
     * Request permission for push notifications
     */
    async requestPermission() {
        if (!this.isSupported) {
            throw new Error('Push notifications are not supported');
        }

		// Skip permission prompts if previously marked unavailable for this session
		if (this.unavailableReason) {
			return false;
		}

        try {
            const permission = await Notification.requestPermission();
            
            if (permission === 'granted') {
                console.log('Push notification permission granted');
                return true;
            } else if (permission === 'denied') {
                console.log('Push notification permission denied');
                return false;
            } else {
                console.log('Push notification permission dismissed');
                return false;
            }
		} catch (error) {
			console.error('Error requesting permission:', error);
			return false;
		}
    }

    /**
     * Subscribe to push notifications
     */
    async subscribe(userType = 'admin') {
		if (!this.isSupported || !this.vapidPublicKey) {
            throw new Error('Push notifications not supported or VAPID key not available');
        }

		// Avoid repeated attempts within same session
		if (this.unavailableReason) {
			this.showErrorMessage('الإشعارات غير متاحة حالياً');
			return false;
		}

        try {
            // Request permission first
            const hasPermission = await this.requestPermission();
            if (!hasPermission) {
                throw new Error('Permission denied for push notifications');
            }

			// Create subscription with a timeout guard
			this.subscription = await this.withTimeout(
				this.registration.pushManager.subscribe({
					userVisibleOnly: true,
					applicationServerKey: this.urlBase64ToUint8Array(this.vapidPublicKey)
				}),
				5000
			);

            // Send subscription to server
            const success = await this.sendSubscriptionToServer(this.subscription, userType);
            
            if (success) {
                console.log('Successfully subscribed to push notifications');
                this.showSuccessMessage('تم الاشتراك في الإشعارات بنجاح');
                return true;
            } else {
                throw new Error('Failed to save subscription to server');
            }

		} catch (error) {
			console.error('Error subscribing to push notifications:', error);
			const reason = this.normalizePushError(error);
			this.setUnavailableReason(reason);
			this.showErrorMessage('حدث خطأ في الاشتراك في الإشعارات');
			return false;
		}
    }

    /**
     * Unsubscribe from push notifications
     */
    async unsubscribe() {
        if (!this.subscription) {
            console.log('No active subscription to unsubscribe from');
            return true;
        }

        try {
            // Unsubscribe from push manager
            await this.subscription.unsubscribe();

            // Notify server
            await this.sendUnsubscribeToServer(this.subscription);

            this.subscription = null;
            console.log('Successfully unsubscribed from push notifications');
            this.showSuccessMessage('تم إلغاء الاشتراك في الإشعارات بنجاح');
            return true;

        } catch (error) {
            console.error('Error unsubscribing from push notifications:', error);
            this.showErrorMessage('حدث خطأ في إلغاء الاشتراك: ' + error.message);
            return false;
        }
    }

    /**
     * Send subscription to server
     */
    async sendSubscriptionToServer(subscription, userType) {
        try {
            const response = await fetch('/api/push/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    endpoint: subscription.endpoint,
                    keys: {
                        p256dh: this.arrayBufferToBase64(subscription.getKey('p256dh')),
                        auth: this.arrayBufferToBase64(subscription.getKey('auth'))
                    },
                    user_type: userType
                })
            });

            const data = await response.json();
            return data.success;

        } catch (error) {
            console.error('Error sending subscription to server:', error);
            return false;
        }
    }

    /**
     * Send unsubscribe to server
     */
    async sendUnsubscribeToServer(subscription) {
        try {
            const response = await fetch('/api/push/unsubscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    endpoint: subscription.endpoint
                })
            });

            const data = await response.json();
            return data.success;

        } catch (error) {
            console.error('Error sending unsubscribe to server:', error);
            return false;
        }
    }

    /**
     * Check if user is subscribed
     */
    async isSubscribed() {
        if (!this.isSupported) {
            return false;
        }

        try {
            this.subscription = await this.registration.pushManager.getSubscription();
            return this.subscription !== null;
        } catch (error) {
            console.error('Error checking subscription status:', error);
            return false;
        }
    }

    /**
     * Get subscription status
     */
    async getSubscriptionStatus() {
		const isSubscribed = await this.isSubscribed();
		const permission = Notification.permission;

		return {
			isSupported: this.isSupported,
			isSubscribed: isSubscribed,
			permission: permission,
			canSubscribe: this.isSupported && permission === 'granted' && !isSubscribed && !this.unavailableReason,
			canUnsubscribe: this.isSupported && isSubscribed,
			unavailableReason: this.unavailableReason || null
		};
    }

    /**
     * Test push notification
     */
    async testNotification() {
        try {
            const response = await fetch('/api/push/test', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();
            
            if (data.success) {
                this.showSuccessMessage('تم إرسال إشعار تجريبي بنجاح');
            } else {
                this.showErrorMessage('فشل في إرسال الإشعار التجريبي: ' + data.message);
            }

            return data.success;

        } catch (error) {
            console.error('Error testing notification:', error);
            this.showErrorMessage('حدث خطأ في اختبار الإشعار');
            return false;
        }
    }

    /**
     * Utility: Convert ArrayBuffer to Base64
     */
    arrayBufferToBase64(buffer) {
        const bytes = new Uint8Array(buffer);
        let binary = '';
        for (let i = 0; i < bytes.byteLength; i++) {
            binary += String.fromCharCode(bytes[i]);
        }
        return window.btoa(binary);
    }

    /**
     * Utility: Convert Base64 to Uint8Array
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

    /**
     * Show success message
     */
    showSuccessMessage(message) {
        this.showMessage(message, 'success');
    }

    /**
     * Show error message
     */
    showErrorMessage(message) {
        this.showMessage(message, 'error');
    }

    /**
     * Show message
     */
    showMessage(message, type = 'info') {
        // Create toast notification
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span>${message}</span>
            </div>
        `;

        // Add to page
        document.body.appendChild(toast);

        // Show toast
        setTimeout(() => toast.classList.add('show'), 100);

        // Remove toast after 5 seconds
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => document.body.removeChild(toast), 300);
        }, 5000);
    }
}

// Initialize push notification manager when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
	if (!window.pushNotificationManager && window.PushNotificationManager) {
		window.pushNotificationManager = new PushNotificationManager();
	}
});

// Export for use in other scripts
window.PushNotificationManager = PushNotificationManager;

// Helper methods added to the class prototype without changing existing style
PushNotificationManager.prototype.withTimeout = function(promise, ms) {
	return new Promise((resolve, reject) => {
		const timer = setTimeout(() => {
			reject(new DOMException('Timeout', 'AbortError'));
		}, ms);
		promise.then(
			(value) => { clearTimeout(timer); resolve(value); },
			(error) => { clearTimeout(timer); reject(error); }
		);
	});
};

PushNotificationManager.prototype.normalizePushError = function(error) {
	if (error && (error.name === 'AbortError')) return 'timeout';
	if (error && (error.name === 'NotAllowedError')) return 'blocked_or_private';
	if (error && (error.name === 'InvalidStateError' || error.name === 'SecurityError')) return 'blocked_or_private';
	return 'unknown';
};

PushNotificationManager.prototype.setUnavailableReason = function(reason) {
	this.unavailableReason = reason || 'unknown';
	try { sessionStorage.setItem('push_unavailable_reason', this.unavailableReason); } catch (e) {}
};
