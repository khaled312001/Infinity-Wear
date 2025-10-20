@extends('layouts.dashboard')

@section('title', 'إشعارات الموبايل')
@section('page-title', 'إشعارات الموبايل')
@section('page-subtitle', 'إدارة الإشعارات الفورية للموبايل')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.notifications.index') }}">الإشعارات</a></li>
                        <li class="breadcrumb-item active">إشعارات الموبايل</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    <i class="fas fa-mobile-alt me-2"></i>
                    إشعارات الموبايل
                </h4>
            </div>
        </div>
    </div>

    <!-- إحصائيات النظام -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card enhanced">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon primary me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h3 class="stats-number" id="total-subscriptions">{{ $stats['total_subscriptions'] }}</h3>
                            <p class="stats-label">إجمالي الاشتراكات</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card enhanced">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon success me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h3 class="stats-number" id="active-subscriptions">{{ $stats['active_subscriptions'] }}</h3>
                            <p class="stats-label">اشتراكات نشطة</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card enhanced">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon info me-3">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div>
                            <h3 class="stats-number" id="mobile-subscriptions">{{ $stats['mobile_subscriptions'] }}</h3>
                            <p class="stats-label">موبايل</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card enhanced">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon warning me-3">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div>
                            <h3 class="stats-number" id="desktop-subscriptions">{{ $stats['desktop_subscriptions'] }}</h3>
                            <p class="stats-label">سطح المكتب</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- أزرار التحكم -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        أدوات التحكم
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-outline-primary" id="refresh-stats">
                            <i class="fas fa-sync-alt me-2"></i>
                            تحديث الإحصائيات
                        </button>
                        
                        <button type="button" class="btn btn-outline-success" id="test-notification">
                            <i class="fas fa-paper-plane me-2"></i>
                            إرسال إشعار تجريبي
                        </button>
                        
                        <button type="button" class="btn btn-outline-warning" id="cleanup-subscriptions">
                            <i class="fas fa-broom me-2"></i>
                            تنظيف الاشتراكات القديمة
                        </button>
                        
                        <button type="button" class="btn btn-outline-info" id="subscribe-btn" style="display: none;">
                            <i class="fas fa-bell me-2"></i>
                            تفعيل الإشعارات
                        </button>
                        
                        <button type="button" class="btn btn-outline-danger" id="unsubscribe-btn" style="display: none;">
                            <i class="fas fa-bell-slash me-2"></i>
                            إلغاء الإشعارات
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- إرسال إشعار مخصص -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-paper-plane me-2"></i>
                        إرسال إشعار مخصص
                    </h5>
                </div>
                <div class="card-body">
                    <form id="send-notification-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="notification-title" class="form-label">عنوان الإشعار</label>
                                    <input type="text" class="form-control" id="notification-title" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="notification-url" class="form-label">رابط الإشعار</label>
                                    <input type="url" class="form-control" id="notification-url" name="url" placeholder="/admin/notifications">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="notification-body" class="form-label">نص الإشعار</label>
                            <textarea class="form-control" id="notification-body" name="body" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user-type" class="form-label">نوع المستخدم</label>
                                    <select class="form-select" id="user-type" name="user_type">
                                        <option value="admin">المديرين</option>
                                        <option value="importer">المستوردين</option>
                                        <option value="sales">المبيعات</option>
                                        <option value="marketing">التسويق</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user-id" class="form-label">معرف المستخدم (اختياري)</label>
                                    <input type="number" class="form-control" id="user-id" name="user_id" placeholder="اتركه فارغاً لإرسال للجميع">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>
                            إرسال الإشعار
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- قائمة الاشتراكات -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        قائمة الاشتراكات
                    </h5>
                </div>
                <div class="card-body">
                    @if($subscriptions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>المستخدم</th>
                                        <th>نوع المستخدم</th>
                                        <th>نوع الجهاز</th>
                                        <th>الحالة</th>
                                        <th>آخر استخدام</th>
                                        <th>عدد الإشعارات</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscriptions as $subscription)
                                    <tr>
                                        <td>
                                            @if($subscription->user)
                                                {{ $subscription->user->name ?? 'غير محدد' }}
                                            @else
                                                <span class="text-muted">غير محدد</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $type = $subscription->user_type;
                                                $labelMap = [
                                                    'admin' => 'مدير',
                                                    'importer' => 'مستورد',
                                                    'sales' => 'مبيعات',
                                                    'marketing' => 'تسويق',
                                                ];
                                                $classMap = [
                                                    'admin' => 'primary',
                                                    'importer' => 'warning',
                                                    'sales' => 'success',
                                                    'marketing' => 'info',
                                                ];
                                                $label = $labelMap[$type] ?? $type;
                                                $class = $classMap[$type] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $class }}">{{ $label }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $subscription->device_type == 'mobile' ? 'info' : ($subscription->device_type == 'tablet' ? 'warning' : 'secondary') }}">
                                                {{ $subscription->device_type == 'mobile' ? 'موبايل' : ($subscription->device_type == 'tablet' ? 'تابلت' : 'سطح المكتب') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $subscription->is_active ? 'success' : 'danger' }}">
                                                {{ $subscription->is_active ? 'نشط' : 'غير نشط' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($subscription->last_used_at)
                                                {{ $subscription->last_used_at->diffForHumans() }}
                                            @else
                                                <span class="text-muted">لم يتم الاستخدام</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $subscription->notification_count }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $toggleBtnClass = $subscription->is_active ? 'warning' : 'success';
                                                $iconClass = $subscription->is_active ? 'pause' : 'play';
                                            @endphp
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-{{ $toggleBtnClass }} btn-toggle-sub" data-id="{{ $subscription->id }}">
                                                    <i class="fas fa-{{ $iconClass }}"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-delete-sub" data-id="{{ $subscription->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $subscriptions->links() }}
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-bell-slash fa-3x mb-3"></i>
                            <p>لا توجد اشتراكات في الإشعارات</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="/js/push-notifications.js"></script>
<script>
$(document).ready(function() {
    // تحديث الإحصائيات كل 30 ثانية
    setInterval(function() {
        refreshStats();
    }, 30000);

    // تحديث الإحصائيات عند النقر على الزر
    $('#refresh-stats').click(function() {
        refreshStats();
    });

    // إرسال إشعار تجريبي
    $('#test-notification').click(function() {
        if (window.pushNotificationManager) {
            window.pushNotificationManager.testNotification();
        } else {
            alert('نظام الإشعارات غير متاح');
        }
    });

    // تنظيف الاشتراكات القديمة
    $('#cleanup-subscriptions').click(function() {
        if (confirm('هل تريد تنظيف الاشتراكات القديمة؟')) {
            $.ajax({
                url: '{{ route("admin.notifications.push-notifications.cleanup") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert('تم تنظيف الاشتراكات بنجاح: ' + response.message);
                        location.reload();
                    } else {
                        alert('خطأ: ' + response.message);
                    }
                },
                error: function() {
                    alert('حدث خطأ في تنظيف الاشتراكات');
                }
            });
        }
    });

    // إرسال إشعار مخصص
    $('#send-notification-form').submit(function(e) {
        e.preventDefault();
        
        const formData = {
            title: $('#notification-title').val(),
            body: $('#notification-body').val(),
            url: $('#notification-url').val(),
            user_type: $('#user-type').val(),
            user_id: $('#user-id').val() || null,
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: '{{ route("admin.notifications.push-notifications.send") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert('تم إرسال الإشعار بنجاح: ' + response.message);
                    $('#send-notification-form')[0].reset();
                } else {
                    alert('خطأ: ' + response.message);
                }
            },
            error: function() {
                alert('حدث خطأ في إرسال الإشعار');
            }
        });
    });

    // تحديث أزرار الاشتراك
    updateSubscriptionButtons();
});

function refreshStats() {
    $.ajax({
        url: '{{ route("admin.notifications.push-notifications.stats") }}',
        method: 'GET',
        success: function(response) {
            if (response.success) {
                $('#total-subscriptions').text(response.stats.total_subscriptions);
                $('#active-subscriptions').text(response.stats.active_subscriptions);
                $('#mobile-subscriptions').text(response.stats.mobile_subscriptions);
                $('#desktop-subscriptions').text(response.stats.desktop_subscriptions);
            }
        },
        error: function() {
            console.log('خطأ في تحديث الإحصائيات');
        }
    });
}

function toggleSubscription(id) {
    $.ajax({
        url: `/admin/notifications/push-notifications/${id}/toggle`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                alert(response.message);
                location.reload();
            } else {
                alert('خطأ: ' + response.message);
            }
        },
        error: function() {
            alert('حدث خطأ في تحديث الاشتراك');
        }
    });
}

function deleteSubscription(id) {
    if (confirm('هل تريد حذف هذا الاشتراك؟')) {
        $.ajax({
            url: `/admin/notifications/push-notifications/${id}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert('خطأ: ' + response.message);
                }
            },
            error: function() {
                alert('حدث خطأ في حذف الاشتراك');
            }
        });
    }
}

async function updateSubscriptionButtons() {
    if (window.pushNotificationManager) {
        try {
            const status = await window.pushNotificationManager.getSubscriptionStatus();
            
            if (status.canSubscribe) {
                $('#subscribe-btn').show();
                $('#unsubscribe-btn').hide();
                
                $('#subscribe-btn').click(async function() {
                    const success = await window.pushNotificationManager.subscribe('admin');
                    if (success) {
                        updateSubscriptionButtons();
                    }
                });
            } else if (status.canUnsubscribe) {
                $('#subscribe-btn').hide();
                $('#unsubscribe-btn').show();
                
                $('#unsubscribe-btn').click(async function() {
                    const success = await window.pushNotificationManager.unsubscribe();
                    if (success) {
                        updateSubscriptionButtons();
                    }
                });
            } else {
                $('#subscribe-btn').hide();
                $('#unsubscribe-btn').hide();
            }
        } catch (error) {
            console.log('Error updating subscription buttons:', error);
        }
    }
}
</script>
@endpush
