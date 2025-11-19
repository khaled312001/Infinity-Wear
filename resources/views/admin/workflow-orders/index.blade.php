@extends('layouts.dashboard')

@section('title', 'إدارة الطلبات')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0">
                    <i class="fas fa-shopping-bag me-2 text-primary"></i>
                    إدارة الطلبات
                </h2>
                <a href="{{ route('admin.workflow-orders.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    إنشاء طلب جديد
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Statistics Cards -->
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
                                        <i class="fas fa-plus-circle"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="mb-0">{{ $stats['new'] }}</h3>
                                    <p class="text-muted mb-0">طلبات جديدة</p>
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
                    <form method="GET" action="{{ route('admin.workflow-orders.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">البحث</label>
                            <input type="text" name="search" class="form-control" placeholder="رقم الطلب، اسم العميل، البريد..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">الحالة</label>
                            <select name="status" class="form-select">
                                <option value="">جميع الحالات</option>
                                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>جديد</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">المرحلة</label>
                            <select name="stage" class="form-select">
                                <option value="">جميع المراحل</option>
                                <option value="marketing" {{ request('stage') == 'marketing' ? 'selected' : '' }}>التسويق</option>
                                <option value="sales" {{ request('stage') == 'sales' ? 'selected' : '' }}>المبيعات</option>
                                <option value="design" {{ request('stage') == 'design' ? 'selected' : '' }}>التصميم</option>
                                <option value="manufacturing" {{ request('stage') == 'manufacturing' ? 'selected' : '' }}>التصنيع</option>
                                <option value="shipping" {{ request('stage') == 'shipping' ? 'selected' : '' }}>الشحن</option>
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

            <!-- Orders Table -->
            <div class="dashboard-card">
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>العميل</th>
                                        <th>المرحلة الحالية</th>
                                        <th>الحالة العامة</th>
                                        <th>التكلفة</th>
                                        <th>تاريخ الإنشاء</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $orderItem)
                                    <tr>
                                        <td>
                                            <strong class="text-primary">{{ $orderItem->order_number }}</strong>
                                            @if(isset($orderItem->type) && $orderItem->type == 'importer')
                                                <br><small class="badge bg-secondary">طلب قديم</small>
                                            @else
                                                <br><small class="badge bg-success">طلب جديد</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $orderItem->customer_name }}</strong><br>
                                                <small class="text-muted">{{ $orderItem->customer_email }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            @if(isset($orderItem->type) && $orderItem->type == 'importer')
                                                <span class="badge bg-secondary">قديم</span>
                                            @else
                                                <div>
                                                    <span class="badge bg-info mb-2 d-block">{{ $orderItem->current_stage ?? 'غير محدد' }}</span>
                                                    @if(isset($orderItem->progress_percentage))
                                                        <div class="progress" style="height: 8px;">
                                                            <div class="progress-bar 
                                                                @if($orderItem->progress_percentage == 100) bg-success
                                                                @elseif($orderItem->progress_percentage >= 50) bg-info
                                                                @elseif($orderItem->progress_percentage >= 25) bg-warning
                                                                @else bg-secondary
                                                                @endif" 
                                                                role="progressbar" 
                                                                style="width: {{ $orderItem->progress_percentage }}%"
                                                                aria-valuenow="{{ $orderItem->progress_percentage }}" 
                                                                aria-valuemin="0" 
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">{{ $orderItem->progress_percentage }}%</small>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'new' => 'secondary',
                                                    'in_progress' => 'warning',
                                                    'processing' => 'warning',
                                                    'completed' => 'success',
                                                    'cancelled' => 'danger'
                                                ];
                                                $color = $statusColors[$orderItem->overall_status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}">{{ $orderItem->overall_status_label ?? $orderItem->overall_status }}</span>
                                        </td>
                                        <td>
                                            @if($orderItem->final_cost)
                                                <strong>{{ number_format($orderItem->final_cost, 2) }} ريال</strong>
                                            @elseif($orderItem->estimated_cost)
                                                <span class="text-muted">{{ number_format($orderItem->estimated_cost, 2) }} ريال (مقدر)</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $orderItem->created_at->format('Y-m-d H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                @if(isset($orderItem->type) && $orderItem->type == 'importer')
                                                    <a href="{{ route('admin.orders.show', $orderItem->id) }}" class="btn btn-outline-primary" title="عرض التفاصيل">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.importers.orders') }}" class="btn btn-outline-info" title="عرض في الطلبات القديمة">
                                                        <i class="fas fa-list"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin.workflow-orders.show', $orderItem->order) }}" class="btn btn-outline-primary" title="عرض التفاصيل">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('order.show', $orderItem->order_number) }}" class="btn btn-outline-info" title="تتبع الطلب" target="_blank">
                                                        <i class="fas fa-search"></i>
                                                    </a>
                                                @endif
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
                            <p class="text-muted">لم يتم إنشاء أي طلبات بعد</p>
                            <a href="{{ route('admin.workflow-orders.create') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-plus me-2"></i>إنشاء طلب جديد
                            </a>
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

