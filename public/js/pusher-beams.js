// Pusher Beams Configuration for Infinity Wear
document.addEventListener('DOMContentLoaded', function() {
    // Check if Pusher Beams is available
    if (typeof PusherPushNotifications !== 'undefined') {
        console.log('Pusher Beams SDK loaded successfully');
        
        // Initialize Pusher Beams client
        const beamsClient = new PusherPushNotifications.Client({
            instanceId: '6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186',
        });

        // Start the client and subscribe to interests
        beamsClient.start()
            .then(() => {
                console.log('Pusher Beams client started successfully');
                
                // Subscribe to general notifications
                return beamsClient.addDeviceInterest('notifications');
            })
            .then(() => {
                console.log('Successfully subscribed to notifications interest');
                
                // Subscribe to admin notifications
                return beamsClient.addDeviceInterest('admin-notifications');
            })
            .then(() => {
                console.log('Successfully subscribed to admin-notifications interest');
                
                // Subscribe to contact form notifications
                return beamsClient.addDeviceInterest('contact-form');
            })
            .then(() => {
                console.log('Successfully subscribed to contact-form interest');
                
                // Subscribe to importer notifications
                return beamsClient.addDeviceInterest('importer-requests');
            })
            .then(() => {
                console.log('Successfully subscribed to importer-requests interest');
                
                // Subscribe to task notifications
                return beamsClient.addDeviceInterest('task-updates');
            })
            .then(() => {
                console.log('Successfully subscribed to task-updates interest');
                console.log('All Pusher Beams subscriptions completed successfully!');
            })
            .catch(error => {
                console.error('Error setting up Pusher Beams:', error);
            });

        // Handle notification clicks
        beamsClient.on('notification', function(notification) {
            console.log('Received notification:', notification);
            
            // Handle different types of notifications
            if (notification.data && notification.data.type) {
                switch(notification.data.type) {
                    case 'contact_form':
                        // Redirect to contact management page
                        if (window.location.pathname !== '/admin/contacts') {
                            window.location.href = '/admin/contacts';
                        }
                        break;
                    case 'importer_request':
                        // Redirect to importer management page
                        if (window.location.pathname !== '/admin/importers') {
                            window.location.href = '/admin/importers';
                        }
                        break;
                    case 'task_update':
                        // Redirect to task management page
                        if (window.location.pathname !== '/admin/tasks') {
                            window.location.href = '/admin/tasks';
                        }
                        break;
                    case 'system_alert':
                        // Show system alert modal or redirect to admin dashboard
                        if (window.location.pathname !== '/admin') {
                            window.location.href = '/admin';
                        }
                        break;
                    default:
                        console.log('Unknown notification type:', notification.data.type);
                }
            }
        });

        // Handle notification permission changes
        beamsClient.on('permission', function(permission) {
            console.log('Notification permission:', permission);
            
            if (permission === 'granted') {
                console.log('Notification permission granted');
                showNotificationPermissionMessage('تم تفعيل الإشعارات بنجاح!', 'success');
            } else if (permission === 'denied') {
                console.log('Notification permission denied');
                showNotificationPermissionMessage('تم رفض الإشعارات. يمكنك تفعيلها من إعدادات المتصفح.', 'warning');
            }
        });

    } else {
        console.error('Pusher Beams SDK not loaded');
    }
});

// Function to show notification permission messages
function showNotificationPermissionMessage(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <strong>إشعار:</strong> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}

// Function to request notification permission
function requestNotificationPermission() {
    if ('Notification' in window) {
        if (Notification.permission === 'default') {
            Notification.requestPermission().then(function(permission) {
                console.log('Notification permission:', permission);
            });
        } else if (Notification.permission === 'denied') {
            showNotificationPermissionMessage('الإشعارات معطلة. يرجى تفعيلها من إعدادات المتصفح.', 'warning');
        }
    } else {
        console.log('This browser does not support notifications');
        showNotificationPermissionMessage('المتصفح لا يدعم الإشعارات.', 'warning');
    }
}

// Function to send test notification (for admin use)
function sendTestNotification() {
    if (typeof beamsClient !== 'undefined') {
        // This would typically be called from the server side
        console.log('Test notification request sent');
    }
}

// Export functions for global use
window.requestNotificationPermission = requestNotificationPermission;
window.sendTestNotification = sendTestNotification;
