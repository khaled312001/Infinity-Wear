@extends('layouts.dashboard')

@section('title', 'إدارة الطلبات - Infinity Wear')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'إدارة الطلبات')
@section('page-subtitle', 'عرض وإدارة طلبات العملاء')

@section('content')
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            
            <!-- Orders Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">قائمة الطلبات</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>العميل</th>
                                    <th>المبلغ</th>
                                    <th>الحالة</th>
                                    <th>التاريخ</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td>#{{ $order->order_number ?? $order->id }}</td>
                                    <td>{{ $order->user->name ?? $order->customer_name ?? 'غير معروف' }}</td>
                                    <td>{{ $order->total ?? 0 }} ريال</td>
                                    <td>
                                        @switch($order->status)
                                            @case('pending')
                                                <span class="badge bg-warning">قيد الانتظار</span>
                                                @break
                                            @case('processing')
                                                <span class="badge bg-info">قيد المعالجة</span>
                                                @break
                                            @case('shipped')
                                                <span class="badge bg-primary">تم الشحن</span>
                                                @break
                                            @case('delivered')
                                                <span class="badge bg-success">تم التسليم</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-danger">ملغي</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $order->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">لا توجد طلبات حتى الآن</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection