@extends('layouts.dashboard')

@section('title', 'تفاصيل الطلب - Infinity Wear')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'تفاصيل الطلب')
@section('page-subtitle', 'عرض تفاصيل الطلب المحدد')

@section('content')
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="section-title">تفاصيل الطلب #{{ $order->id }}</h2>
                <p class="text-muted">تاريخ الطلب: {{ $order->created_at->format('Y-m-d') }}</p>
            </div>
            <div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-right me-2"></i>
                    العودة للطلبات
                </a>
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
            
            <div class="row">
                <!-- Order Details -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">تفاصيل الطلب</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="fw-bold">معلومات العميل</h6>
                                    <p><strong>الاسم:</strong> {{ $order->user->name ?? 'غير معروف' }}</p>
                                    <p><strong>البريد الإلكتروني:</strong> {{ $order->user->email ?? 'غير معروف' }}</p>
                                    <p><strong>رقم الهاتف:</strong> {{ $order->user->phone ?? 'غير معروف' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold">معلومات الشحن</h6>
                                    <p><strong>العنوان:</strong> {{ $order->shipping_address ?? 'غير متوفر' }}</p>
                                    <p><strong>المدينة:</strong> {{ $order->shipping_city ?? 'غير متوفر' }}</p>
                                    <p><strong>الرمز البريدي:</strong> {{ $order->shipping_postal_code ?? 'غير متوفر' }}</p>
                                </div>
                            </div>
                            
                            <h6 class="fw-bold mb-3">المنتجات</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>المنتج</th>
                                            <th>السعر</th>
                                            <th>الكمية</th>
                                            <th>المجموع</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product && $item->product->image)
                                                    <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                    <div class="bg-light me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $item->product->name ?? 'منتج غير متوفر' }}</h6>
                                                        @if($item->product && $item->product->sku)
                                                        <small class="text-muted">SKU: {{ $item->product->sku }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $item->price }} ريال</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->price * $item->quantity }} ريال</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>المجموع الفرعي:</strong></td>
                                            <td>{{ $order->subtotal ?? $order->total_amount }} ريال</td>
                                        </tr>
                                        @if(isset($order->shipping_cost))
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>تكلفة الشحن:</strong></td>
                                            <td>{{ $order->shipping_cost }} ريال</td>
                                        </tr>
                                        @endif
                                        @if(isset($order->tax))
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>الضريبة:</strong></td>
                                            <td>{{ $order->tax }} ريال</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>المجموع الكلي:</strong></td>
                                            <td><strong>{{ $order->total_amount }} ريال</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order Status -->
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">حالة الطلب</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">الحالة الحالية</h6>
                                @switch($order->status)
                                    @case('pending')
                                        <div class="alert alert-warning">قيد الانتظار</div>
                                        @break
                                    @case('processing')
                                        <div class="alert alert-info">قيد المعالجة</div>
                                        @break
                                    @case('shipped')
                                        <div class="alert alert-primary">تم الشحن</div>
                                        @break
                                    @case('delivered')
                                        <div class="alert alert-success">تم التسليم</div>
                                        @break
                                    @case('cancelled')
                                        <div class="alert alert-danger">ملغي</div>
                                        @break
                                    @default
                                        <div class="alert alert-secondary">{{ $order->status }}</div>
                                @endswitch
                            </div>
                            
                            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="status" class="form-label">تحديث الحالة</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>تم التسليم</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
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
                            
                            <hr>
                            
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟ لا يمكن التراجع عن هذا الإجراء.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fas fa-trash-alt me-2"></i>
                                    حذف الطلب
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection