@extends('layouts.sales-dashboard')

@section('title', 'تفاصيل الطلب - فريق المبيعات')
@section('dashboard-title', 'تفاصيل الطلب')
@section('page-title', 'تفاصيل الطلب #' . $order->order_number)
@section('page-subtitle', 'عرض تفاصيل الطلب')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>
                    تفاصيل الطلب
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>معلومات الطلب</h6>
                        <ul class="list-unstyled">
                            <li><strong>رقم الطلب:</strong> #{{ $order->order_number ?? $order->id }}</li>
                            <li><strong>العميل:</strong> {{ $order->customer_name ?? 'غير محدد' }}</li>
                            <li><strong>المبلغ الإجمالي:</strong> {{ number_format($order->total) }} ريال</li>
                            <li><strong>الحالة:</strong> 
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
                                @endswitch
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>معلومات إضافية</h6>
                        <ul class="list-unstyled">
                            <li><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</li>
                            <li><strong>آخر تحديث:</strong> {{ $order->updated_at->format('Y-m-d H:i') }}</li>
                        </ul>
                    </div>
                </div>
                
                @if($order->notes)
                    <div class="mt-3">
                        <h6>ملاحظات</h6>
                        <div class="alert alert-info">
                            {{ $order->notes }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    إدارة الطلب
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('sales.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="status" class="form-label">تغيير الحالة</label>
                        <select name="status" id="status" class="form-select">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>معلق</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>مكتمل</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>ملغي</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">ملاحظات</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3">{{ $order->notes }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>
                        حفظ التغييرات
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
