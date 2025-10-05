@extends('layouts.sales-dashboard')

@section('title', 'الطلبات - فريق المبيعات')
@section('dashboard-title', 'الطلبات')
@section('page-title', 'قائمة الطلبات')
@section('page-subtitle', 'إدارة وتتبع جميع الطلبات')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-shopping-cart me-2"></i>
            قائمة الطلبات
        </h5>
    </div>
    <div class="card-body">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>العميل</th>
                            <th>المبلغ</th>
                            <th>الحالة</th>
                            <th>تاريخ الطلب</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>#{{ $order->order_number ?? $order->id }}</td>
                                <td>{{ $order->customer_name ?? 'غير محدد' }}</td>
                                <td>{{ number_format($order->total) }} ريال</td>
                                <td>
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="badge bg-warning">معلق</span>
                                            @break
                                        @case('processing')
                                            <span class="badge bg-info">قيد المعالجة</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-success">مكتمل</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">ملغي</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $order->status }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('sales.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
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
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">لا توجد طلبات حالياً</h5>
            </div>
        @endif
    </div>
</div>
@endsection
