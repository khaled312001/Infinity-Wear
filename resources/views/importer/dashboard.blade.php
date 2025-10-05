@extends('layouts.dashboard')

@section('title', 'لوحة التحكم - المستورد')
@section('dashboard-title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')
@section('page-subtitle', 'مرحباً بك في لوحة تحكم المستورد')

@section('content')
<div class="row">
    <!-- إحصائيات الطلبات -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon primary">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $orderStats['total'] }}</h3>
                    <p class="mb-0 text-muted">إجمالي الطلبات</p>
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
                    <h3 class="mb-0">{{ $orderStats['new'] }}</h3>
                    <p class="mb-0 text-muted">طلبات جديدة</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-cogs"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $orderStats['processing'] }}</h3>
                    <p class="mb-0 text-muted">قيد المعالجة</p>
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
                    <h3 class="mb-0">{{ $orderStats['completed'] }}</h3>
                    <p class="mb-0 text-muted">طلبات مكتملة</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- إجمالي قيمة الطلبات -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-money-bill-wave me-2"></i>
                    إجمالي قيمة الطلبات
                </h5>
            </div>
            <div class="card-body text-center">
                <h2 class="text-primary mb-3">{{ number_format($totalValue) }} ريال</h2>
                <p class="text-muted">إجمالي قيمة جميع الطلبات</p>
            </div>
        </div>
    </div>

    <!-- معلومات المستورد -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-industry me-2"></i>
                    معلومات المستورد
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <i class="fas fa-building fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">{{ $importer->company_name }}</h6>
                        <p class="text-muted mb-0">اسم الشركة</p>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="me-3">
                        <i class="fas fa-briefcase fa-2x text-info"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">{{ $importer->business_type_label }}</h6>
                        <p class="text-muted mb-0">نوع النشاط</p>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-map-marker-alt fa-2x text-success"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">{{ $importer->city }}</h6>
                        <p class="text-muted mb-0">المدينة</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- الطلبات الحديثة -->
    <div class="col-lg-8 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>
                    الطلبات الحديثة
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($recentOrders as $order)
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $order->order_number }}</h6>
                                <p class="mb-1 text-muted">{{ Str::limit($order->requirements, 100) }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $order->created_at->format('Y-m-d H:i') }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $order->status === 'new' ? 'warning' : ($order->status === 'completed' ? 'success' : 'info') }}">
                                    {{ $order->status === 'new' ? 'جديد' : ($order->status === 'completed' ? 'مكتمل' : 'قيد المعالجة') }}
                                </span>
                                <div class="mt-1">
                                    <strong>{{ number_format($order->final_cost) }} ريال</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                        <p>لا توجد طلبات حديثة</p>
                        <a href="{{ route('importer.orders.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            إنشاء طلب جديد
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- النشاط الأخير -->
    <div class="col-lg-4 mb-4">
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

<!-- المهام المرتبطة -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tasks me-2"></i>
                    المهام المرتبطة
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($tasks as $task)
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
                                <span class="badge bg-{{ $task->priority === 'urgent' ? 'danger' : ($task->priority === 'high' ? 'warning' : 'info') }}">
                                    {{ $task->priority === 'urgent' ? 'عاجل' : ($task->priority === 'high' ? 'عالي' : 'عادي') }}
                                </span>
                                <div class="mt-1">
                                    <span class="badge bg-{{ $task->status === 'completed' ? 'success' : ($task->status === 'in_progress' ? 'info' : 'warning') }}">
                                        {{ $task->status === 'completed' ? 'مكتمل' : ($task->status === 'in_progress' ? 'قيد التنفيذ' : 'معلق') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-tasks fa-3x mb-3"></i>
                        <p>لا توجد مهام مرتبطة</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- معرض الأعمال -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-images me-2"></i>
                    معرض الأعمال
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($portfolio as $item)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <img src="{{ $item->image }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">{{ $item->title }}</h6>
                                <p class="card-text text-muted">{{ Str::limit($item->description, 100) }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $item->completion_date->format('Y-m-d') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted py-4">
                        <i class="fas fa-images fa-3x mb-3"></i>
                        <p>لا توجد مشاريع في المعرض</p>
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
                        <a href="{{ route('importer.orders.create') }}" class="btn btn-primary w-100">
                            <i class="fas fa-plus me-2"></i>
                            إنشاء طلب جديد
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('importer.orders') }}" class="btn btn-info w-100">
                            <i class="fas fa-shopping-cart me-2"></i>
                            عرض جميع الطلبات
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('importer.tasks') }}" class="btn btn-success w-100">
                            <i class="fas fa-tasks me-2"></i>
                            المهام المرتبطة
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('importer.contact') }}" class="btn btn-warning w-100">
                            <i class="fas fa-envelope me-2"></i>
                            اتصل بنا
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
