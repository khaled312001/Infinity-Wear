@extends('layouts.dashboard')

@section('title', 'إرسال الإشعارات')
@section('dashboard-title', 'إرسال الإشعارات')
@section('page-title', 'إدارة إرسال الإشعارات')
@section('page-subtitle', 'إنشاء وإرسال إشعارات مخصصة للمستخدمين')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-paper-plane me-2"></i>
                    إرسال الإشعارات
                </h3>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.notifications.admin.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-2"></i>
                        إشعار جديد
                    </a>
                    <button class="btn btn-outline-primary btn-sm" onclick="loadAdminNotifications()">
                        <i class="fas fa-sync-alt"></i>
                        تحديث
                    </button>
                </div>
            </div>
            
            <div class="card-body p-0">
                <!-- Admin Notification Stats -->
                <div class="notification-stats">
                    <div class="stat-item">
                        <span class="stat-label">إجمالي الإشعارات</span>
                        <span class="stat-value" id="total-notifications">{{ $stats['total'] ?? 0 }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">مرسلة</span>
                        <span class="stat-value" id="sent-notifications">{{ $stats['sent'] ?? 0 }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">معلقة</span>
                        <span class="stat-value" id="pending-notifications">{{ $stats['pending'] ?? 0 }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">مجدولة</span>
                        <span class="stat-value" id="scheduled-notifications">{{ $stats['scheduled'] ?? 0 }}</span>
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="nav-tabs-container">
                    <ul class="nav nav-tabs" id="adminNotificationTabs">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-target="#all-admin-notifications">
                                الكل <span class="badge bg-secondary" id="all-count">{{ $notifications->total() }}</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-target="#sent-admin-notifications">
                                مرسلة <span class="badge bg-success" id="sent-count">{{ $stats['sent'] ?? 0 }}</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-target="#pending-admin-notifications">
                                معلقة <span class="badge bg-warning" id="pending-count">{{ $stats['pending'] ?? 0 }}</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-target="#scheduled-admin-notifications">
                                مجدولة <span class="badge bg-info" id="scheduled-count">{{ $stats['scheduled'] ?? 0 }}</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- All Notifications -->
                    <div class="tab-pane fade show active" id="all-admin-notifications">
                        @if($notifications->count() > 0)
                            <div class="admin-notifications-list">
                                @foreach($notifications as $notification)
                                    <div class="admin-notification-item {{ $notification->is_sent ? 'sent' : 'pending' }}">
                                        <div class="notification-icon">
                                            <i class="fas fa-paper-plane"></i>
                                        </div>
                                        <div class="notification-content">
                                            <div class="notification-title">{{ $notification->title }}</div>
                                            <div class="notification-message">{{ Str::limit($notification->message, 100) }}</div>
                                            <div class="notification-meta">
                                                <span class="notification-type">{{ $notification->type }}</span>
                                                <span class="notification-priority priority-{{ $notification->priority }}">{{ $notification->priority }}</span>
                                                <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div class="notification-actions">
                                            <a href="{{ route('admin.notifications.admin.show', $notification) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(!$notification->is_sent)
                                                <form method="POST" action="{{ route('admin.notifications.admin.send', $notification) }}" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('هل تريد إرسال هذا الإشعار الآن؟')">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form method="POST" action="{{ route('admin.notifications.admin.destroy', $notification) }}" style="display: inline;" onsubmit="return confirm('هل تريد حذف هذا الإشعار؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            <div class="pagination-container">
                                {{ $notifications->links() }}
                            </div>
                        @else
                            <div class="notifications-empty text-center py-5">
                                <i class="fas fa-paper-plane fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">لا توجد إشعارات</h4>
                                <p class="text-muted">لم يتم إنشاء أي إشعارات بعد</p>
                                <a href="{{ route('admin.notifications.admin.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    إنشاء إشعار جديد
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Sent Notifications -->
                    <div class="tab-pane fade" id="sent-admin-notifications">
                        <div class="notifications-empty text-center py-5">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h4 class="text-muted">الإشعارات المرسلة</h4>
                            <p class="text-muted">سيتم عرض الإشعارات المرسلة هنا</p>
                        </div>
                    </div>

                    <!-- Pending Notifications -->
                    <div class="tab-pane fade" id="pending-admin-notifications">
                        <div class="notifications-empty text-center py-5">
                            <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                            <h4 class="text-muted">الإشعارات المعلقة</h4>
                            <p class="text-muted">سيتم عرض الإشعارات المعلقة هنا</p>
                        </div>
                    </div>

                    <!-- Scheduled Notifications -->
                    <div class="tab-pane fade" id="scheduled-admin-notifications">
                        <div class="notifications-empty text-center py-5">
                            <i class="fas fa-calendar fa-3x text-info mb-3"></i>
                            <h4 class="text-muted">الإشعارات المجدولة</h4>
                            <p class="text-muted">سيتم عرض الإشعارات المجدولة هنا</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Admin Notification Management
class AdminNotificationManager {
    constructor() {
        this.currentTab = 'all';
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupTabs();
    }

    setupEventListeners() {
        // Tab switching
        document.querySelectorAll('#adminNotificationTabs button').forEach(tab => {
            tab.addEventListener('click', (e) => {
                const target = e.target.getAttribute('data-bs-target').replace('#', '');
                this.switchTab(target);
            });
        });
    }

    setupTabs() {
        // Initialize tab content
        this.tabs = {
            'all': document.getElementById('all-admin-notifications'),
            'sent': document.getElementById('sent-admin-notifications'),
            'pending': document.getElementById('pending-admin-notifications'),
            'scheduled': document.getElementById('scheduled-admin-notifications')
        };
    }

    switchTab(tabName) {
        this.currentTab = tabName;
        
        // Update active tab
        document.querySelectorAll('#adminNotificationTabs .nav-link').forEach(tab => {
            tab.classList.remove('active');
        });
        document.querySelector(`#adminNotificationTabs button[data-bs-target="#${tabName}"]`).classList.add('active');
        
        // Update active content
        document.querySelectorAll('.tab-pane').forEach(pane => {
            pane.classList.remove('show', 'active');
        });
        document.getElementById(tabName).classList.add('show', 'active');
    }

    async loadAdminNotifications() {
        try {
            const response = await fetch('{{ route("admin.notifications.admin.api.stats") }}', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.updateStats(data.stats);
            }
        } catch (error) {
            console.error('Failed to load admin notifications:', error);
        }
    }

    updateStats(stats) {
        document.getElementById('total-notifications').textContent = stats.total || 0;
        document.getElementById('sent-notifications').textContent = stats.sent || 0;
        document.getElementById('pending-notifications').textContent = stats.pending || 0;
        document.getElementById('scheduled-notifications').textContent = stats.scheduled || 0;
        
        // Update badge counts
        document.getElementById('all-count').textContent = stats.total || 0;
        document.getElementById('sent-count').textContent = stats.sent || 0;
        document.getElementById('pending-count').textContent = stats.pending || 0;
        document.getElementById('scheduled-count').textContent = stats.scheduled || 0;
    }
}

// Global function for refresh button
function loadAdminNotifications() {
    if (window.adminNotificationManager) {
        window.adminNotificationManager.loadAdminNotifications();
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.adminNotificationManager = new AdminNotificationManager();
});
</script>
@endsection

@section('styles')
<style>
.notification-stats {
    display: flex;
    gap: 20px;
    padding: 20px;
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    flex-wrap: wrap;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 120px;
}

.stat-label {
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 5px;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--primary-color);
}

.nav-tabs-container {
    border-bottom: 1px solid #dee2e6;
    padding: 0 20px;
}

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

.admin-notifications-list {
    max-height: 600px;
    overflow-y: auto;
}

.admin-notification-item {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.3s ease;
}

.admin-notification-item:hover {
    background-color: #f8f9fa;
}

.admin-notification-item.sent {
    border-left: 4px solid #28a745;
}

.admin-notification-item.pending {
    border-left: 4px solid #ffc107;
}

.notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: var(--primary-color);
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
    color: #2d3748;
    margin-bottom: 5px;
}

.notification-message {
    color: #718096;
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.notification-meta {
    display: flex;
    gap: 15px;
    font-size: 0.8rem;
}

.notification-type {
    background-color: #e2e8f0;
    color: #4a5568;
    padding: 2px 8px;
    border-radius: 12px;
}

.notification-priority {
    padding: 2px 8px;
    border-radius: 12px;
    font-weight: 500;
}

.priority-high {
    background-color: #fed7d7;
    color: #c53030;
}

.priority-medium {
    background-color: #fef5e7;
    color: #dd6b20;
}

.priority-low {
    background-color: #e6fffa;
    color: #319795;
}

.notification-time {
    color: #a0aec0;
}

.notification-actions {
    display: flex;
    gap: 5px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.admin-notification-item:hover .notification-actions {
    opacity: 1;
}

.notifications-empty {
    padding: 60px 20px;
}

.notifications-empty i {
    margin-bottom: 20px;
}

.pagination-container {
    padding: 20px;
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .notification-stats {
        flex-direction: column;
        gap: 10px;
    }
    
    .stat-item {
        min-width: auto;
    }
    
    .admin-notification-item {
        padding: 12px 15px;
    }
    
    .notification-icon {
        width: 35px;
        height: 35px;
        font-size: 14px;
        margin-left: 10px;
    }
    
    .notification-actions {
        opacity: 1;
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
