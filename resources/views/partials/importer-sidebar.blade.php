<!-- الرئيسية -->
<div class="nav-group">
    <div class="nav-group-title">الرئيسية</div>
    <a href="{{ route('importers.dashboard') }}" class="nav-link {{ request()->routeIs('importers.dashboard') ? 'active' : '' }}">
        <i class="fas fa-tachometer-alt me-2"></i>
        لوحة التحكم
    </a>
</div>

<!-- إدارة الطلبات -->
<div class="nav-group">
    <div class="nav-group-title">إدارة الطلبات</div>
    <a href="{{ route('importers.orders') }}" class="nav-link {{ request()->routeIs('importers.orders*') ? 'active' : '' }}">
        <i class="fas fa-shopping-cart me-2"></i>
        طلباتي
    </a>
    <a href="{{ route('importers.tracking') }}" class="nav-link {{ request()->routeIs('importers.tracking*') ? 'active' : '' }}">
        <i class="fas fa-truck me-2"></i>
        تتبع الشحنات
    </a>
    <a href="{{ route('importers.invoices') }}" class="nav-link {{ request()->routeIs('importers.invoices*') ? 'active' : '' }}">
        <i class="fas fa-file-invoice me-2"></i>
        الفواتير
    </a>
</div>

<!-- إدارة الحساب -->
<div class="nav-group">
    <div class="nav-group-title">إدارة الحساب</div>
    <a href="{{ route('importers.profile') }}" class="nav-link {{ request()->routeIs('importers.profile*') ? 'active' : '' }}">
        <i class="fas fa-user me-2"></i>
        الملف الشخصي
    </a>
    <a href="{{ route('importers.payment-methods') }}" class="nav-link {{ request()->routeIs('importers.payment-methods*') ? 'active' : '' }}">
        <i class="fas fa-credit-card me-2"></i>
        طرق الدفع
    </a>
    <a href="{{ route('importers.notifications') }}" class="nav-link {{ request()->routeIs('importers.notifications*') ? 'active' : '' }}">
        <i class="fas fa-bell me-2"></i>
        الإشعارات
        @if($unreadNotificationsCount > 0)
            <span class="notification-badge" id="sidebarNotificationsBadge">{{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}</span>
        @else
            <span class="notification-badge" id="sidebarNotificationsBadge" style="display: none;">0</span>
        @endif
    </a>
</div>

<!-- الدعم والمساعدة -->
<div class="nav-group">
    <div class="nav-group-title">الدعم والمساعدة</div>
    <a href="{{ route('importers.help') }}" class="nav-link {{ request()->routeIs('importers.help*') ? 'active' : '' }}">
        <i class="fas fa-question-circle me-2"></i>
        المساعدة
    </a>
    <a href="{{ route('importers.support') }}" class="nav-link {{ request()->routeIs('importers.support*') ? 'active' : '' }}">
        <i class="fas fa-headset me-2"></i>
        الدعم الفني
    </a>
    <a href="{{ route('importers.contact') }}" class="nav-link {{ request()->routeIs('importers.contact*') ? 'active' : '' }}">
        <i class="fas fa-comments me-2"></i>
        التواصل معنا
    </a>
</div>

<style>
.notification-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background-color: #dc3545;
    color: white;
    border-radius: 50%;
    min-width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: bold;
    z-index: 10;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

.nav-link {
    position: relative;
}
</style>

<script>
// تحديث عداد الإشعارات تلقائياً
function updateNotificationBadge() {
    fetch('/importers/notifications/unread-count', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const badge = document.getElementById('sidebarNotificationsBadge');
        if (badge) {
            const unreadCount = data.unread_count || 0;
            
            if (unreadCount > 0) {
                badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
                badge.style.display = 'flex';
                
                // تحسين العرض للأرقام الكبيرة
                if (unreadCount > 99) {
                    badge.style.minWidth = '32px';
                } else if (unreadCount > 9) {
                    badge.style.minWidth = '24px';
                } else {
                    badge.style.minWidth = '20px';
                }
            } else {
                badge.style.display = 'none';
            }
        }
    })
    .catch(error => {
        console.error('Error updating notification badge:', error);
    });
}

// تحديث العداد عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    updateNotificationBadge();
});

// تحديث العداد كل 30 ثانية
setInterval(updateNotificationBadge, 30000);
</script>
