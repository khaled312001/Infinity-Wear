@extends('layouts.app')

@section('title', 'إدارة الطلبات - Infinity Wear')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <span class="infinity-logo me-2"></span>
                        لوحة التحكم
                    </h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        الرئيسية
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tshirt me-2"></i>
                        المنتجات
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tags me-2"></i>
                        الفئات
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-shopping-cart me-2"></i>
                        الطلبات
                    </a>
                    <a href="{{ route('admin.custom-designs.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-palette me-2"></i>
                        التصاميم المخصصة
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-users me-2"></i>
                        العملاء
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-bar me-2"></i>
                        التقارير
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">
                        <i class="fas fa-cog me-2"></i>
                        الإعدادات
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="section-title">إدارة الطلبات</h2>
                        <p class="text-muted">عرض وإدارة طلبات العملاء</p>
                    </div>
                </div>
            </div>
            
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