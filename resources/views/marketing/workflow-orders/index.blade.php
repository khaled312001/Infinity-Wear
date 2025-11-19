@extends('layouts.marketing-dashboard')

@section('title', 'طلبات التسويق')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0">
                    <i class="fas fa-bullhorn me-2 text-primary"></i>
                    طلبات التسويق
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
                                    <div class="stat-icon bg-info">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0">{{ $stats['pending'] }}</h3>
                                    <p class="text-muted mb-0">في الانتظار</p>
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
            </div>

            <!-- Filters -->
            <div class="dashboard-card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('marketing.workflow-orders.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">الحالة</label>
                            <select name="status" class="form-select">
                                <option value="">جميع الحالات</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i>بحث
                            </button>
                        </div>
                    </form>
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
                                        <th>العميل</th>
                                        <th>حالة التسويق</th>
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
                                            <div>
                                                <strong>{{ $order->customer_name }}</strong><br>
                                                <small class="text-muted">{{ $order->customer_email }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'secondary',
                                                    'in_progress' => 'warning',
                                                    'completed' => 'success',
                                                    'rejected' => 'danger'
                                                ];
                                                $color = $statusColors[$order->marketing_status] ?? 'secondary';
                                                $labels = [
                                                    'pending' => 'في الانتظار',
                                                    'in_progress' => 'قيد التنفيذ',
                                                    'completed' => 'مكتمل',
                                                    'rejected' => 'مرفوض'
                                                ];
                                                $label = $labels[$order->marketing_status] ?? $order->marketing_status;
                                            @endphp
                                            <span class="badge bg-{{ $color }}">{{ $label }}</span>
                                        </td>
                                        <td>
                                            <small>{{ $order->created_at->format('Y-m-d H:i') }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('marketing.workflow-orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>عرض
                                            </a>
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
                            <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد طلبات</h5>
                            <p class="text-muted">لم يتم تعيين أي طلبات لك بعد</p>
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

