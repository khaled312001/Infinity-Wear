@extends('layouts.dashboard')

@section('title', 'لوحة التحكم - الموظف')
@section('dashboard-title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')
@section('page-subtitle', 'مرحباً بك في لوحة تحكم الموظف')

@section('content')
<div class="row">
    <!-- إحصائيات المهام -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon primary">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $taskStats['total'] }}</h3>
                    <p class="mb-0 text-muted">إجمالي المهام</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $taskStats['pending'] }}</h3>
                    <p class="mb-0 text-muted">مهام معلقة</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-play"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $taskStats['in_progress'] }}</h3>
                    <p class="mb-0 text-muted">قيد التنفيذ</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon success">
                    <i class="fas fa-check"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $taskStats['completed'] }}</h3>
                    <p class="mb-0 text-muted">مهام مكتملة</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- المهام العاجلة -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
                    المهام العاجلة
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($urgentTasks as $task)
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $task->title }}</h6>
                                <p class="mb-1 text-muted">{{ Str::limit($task->description, 100) }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'بدون تاريخ' }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-danger">عاجل</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                        <p>لا توجد مهام عاجلة</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- المهام المستحقة قريباً -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2 text-warning"></i>
                    المهام المستحقة قريباً
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($upcomingTasks as $task)
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $task->title }}</h6>
                                <p class="mb-1 text-muted">{{ Str::limit($task->description, 100) }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $task->due_date->format('Y-m-d') }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-warning">قريباً</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-calendar-check fa-3x mb-3 text-info"></i>
                        <p>لا توجد مهام مستحقة قريباً</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- إحصائيات الأداء الشهرية -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    الأداء الشهري
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <h3 class="text-primary">{{ $monthlyPerformance['tasks_completed'] }}</h3>
                            <p class="text-muted mb-0">مهام مكتملة</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h3 class="text-success">{{ $monthlyPerformance['hours_worked'] }}</h3>
                            <p class="text-muted mb-0">ساعات عمل</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- معلومات الموظف -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>
                    معلومات الموظف
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <i class="fas fa-id-badge fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">{{ $employee->employee_id }}</h6>
                        <p class="text-muted mb-0">رقم الموظف</p>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <i class="fas fa-building fa-2x text-info"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">{{ $employee->department_label }}</h6>
                        <p class="text-muted mb-0">القسم</p>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-briefcase fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">{{ $employee->position }}</h6>
                        <p class="text-muted mb-0">المنصب</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- النشاط الأخير -->
    <div class="col-lg-12 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>
                    النشاط الأخير
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($recentActivity as $activity)
                    <div class="activity-item">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="fas {{ $activity['icon'] }} text-{{ $activity['color'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $activity['title'] }}</h6>
                                <p class="mb-1 text-muted">{{ $activity['description'] }}</p>
                                <small class="text-muted">{{ $activity['time']->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-history fa-3x mb-3"></i>
                        <p>لا يوجد نشاط حديث</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- أزرار سريعة -->
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    إجراءات سريعة
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('employee.tasks') }}" class="btn btn-primary w-100">
                            <i class="fas fa-tasks me-2"></i>
                            عرض جميع المهام
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('employee.profile') }}" class="btn btn-info w-100">
                            <i class="fas fa-user me-2"></i>
                            الملف الشخصي
                        </a>
                    </div>
                    @if(Auth::user()->hasPermission('orders.view'))
                    <div class="col-md-3 mb-3">
                        <a href="#" class="btn btn-success w-100">
                            <i class="fas fa-shopping-cart me-2"></i>
                            عرض الطلبات
                        </a>
                    </div>
                    @endif
                    @if(Auth::user()->hasPermission('transactions.view'))
                    <div class="col-md-3 mb-3">
                        <a href="#" class="btn btn-warning w-100">
                            <i class="fas fa-money-bill-wave me-2"></i>
                            المعاملات المالية
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
