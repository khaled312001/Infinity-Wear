@extends('layouts.importer-dashboard')

@section('title', 'طلباتي')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0">
                    <i class="fas fa-shopping-bag me-2 text-primary"></i>
                    طلباتي
                </h2>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="stat-icon bg-primary">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0">{{ $stats['total'] }}</h3>
                                    <p class="text-muted mb-0">إجمالي الطلبات</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="stat-icon bg-warning">
                                        <i class="fas fa-spinner"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0">{{ $stats['in_progress'] }}</h3>
                                    <p class="text-muted mb-0">قيد التنفيذ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="stat-icon bg-success">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0">{{ $stats['completed'] }}</h3>
                                    <p class="text-muted mb-0">مكتملة</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="stat-icon bg-info">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0">{{ $stats['new'] }}</h3>
                                    <p class="text-muted mb-0">جديدة</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders List -->
            <div class="dashboard-card">
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>المرحلة الحالية</th>
                                        <th>الحالة</th>
                                        <th>التكلفة</th>
                                        <th>تاريخ الإنشاء</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <strong class="text-primary">{{ $order->order_number }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $order->current_stage }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'new' => 'secondary',
                                                    'in_progress' => 'warning',
                                                    'completed' => 'success',
                                                    'cancelled' => 'danger'
                                                ];
                                                $color = $statusColors[$order->overall_status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}">{{ $order->overall_status_label }}</span>
                                        </td>
                                        <td>
                                            @if($order->final_cost)
                                                <strong>{{ number_format($order->final_cost, 2) }} ريال</strong>
                                            @elseif($order->estimated_cost)
                                                <span class="text-muted">{{ number_format($order->estimated_cost, 2) }} ريال (مقدر)</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $order->created_at->format('Y-m-d H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('importer.workflow-orders.show', $order) }}" class="btn btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>عرض
                                                </a>
                                                <a href="{{ route('order.show', $order->order_number) }}" class="btn btn-outline-info" target="_blank">
                                                    <i class="fas fa-search me-1"></i>تتبع
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد طلبات</h5>
                            <p class="text-muted">لم يتم إنشاء أي طلبات لك بعد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}
</style>
@endsection

