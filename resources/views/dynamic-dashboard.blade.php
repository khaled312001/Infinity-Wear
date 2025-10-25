@extends('layouts.dashboard')

@section('title', 'لوحة التحكم')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        مرحباً {{ $user->name }}
                    </h4>
                    <p class="card-text">مرحباً بك في لوحة التحكم المخصصة لك</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Widgets -->
    <div class="row">
        @foreach($widgets as $widgetKey => $widget)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-chart-pie me-2"></i>
                            {{ $widget['title'] }}
                        </h6>
                    </div>
                    <div class="card-body">
                        @switch($widgetKey)
                            @case('notifications_widget')
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>إشعارات جديدة</span>
                                    <span class="badge bg-danger">5</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span>إجمالي الإشعارات</span>
                                    <span class="badge bg-info">25</span>
                                </div>
                                @break
                            @case('contacts_widget')
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>رسائل جديدة</span>
                                    <span class="badge bg-warning">3</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span>إجمالي الرسائل</span>
                                    <span class="badge bg-info">12</span>
                                </div>
                                @break
                            @case('tasks_widget')
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>مهام معلقة</span>
                                    <span class="badge bg-danger">8</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span>مهام مكتملة</span>
                                    <span class="badge bg-success">15</span>
                                </div>
                                @break
                            @case('financial_widget')
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>إجمالي الإيرادات</span>
                                    <span class="text-success">$12,500</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span>المصروفات</span>
                                    <span class="text-danger">$8,200</span>
                                </div>
                                @break
                            @default
                                <p class="text-muted">محتوى الودجت</p>
                        @endswitch
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-sm btn-outline-primary">عرض التفاصيل</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Quick Actions -->
    @if(count($sidebarItems) > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        الإجراءات السريعة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($sidebarItems as $key => $item)
                            @if($key !== 'dashboard' && $key !== 'profile')
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <a href="{{ route($item['route']) }}" class="btn btn-outline-primary w-100">
                                        <i class="{{ $item['icon'] }} me-2"></i>
                                        {{ $item['title'] }}
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- User Permissions Info (for debugging) -->
    @if(config('app.debug'))
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">صلاحيات المستخدم (للتطوير فقط)</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-md-3 mb-2">
                                <span class="badge bg-info">{{ $permission->display_name }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
