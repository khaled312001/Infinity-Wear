@extends('layouts.dashboard')

@section('title', 'طلباتي')
@section('dashboard-title', 'لوحة العميل')
@section('page-title', 'طلباتي')
@section('page-subtitle', 'عرض وتتبع جميع طلباتك')
@section('profile-route', route('customer.profile'))
@section('settings-route', route('customer.settings'))

@section('sidebar-menu')
    <a href="{{ route('customer.dashboard') }}" class="nav-link">
        <i class="fas fa-tachometer-alt me-2"></i>
        الرئيسية
    </a>
    <a href="{{ route('customer.orders') }}" class="nav-link active">
        <i class="fas fa-shopping-cart me-2"></i>
        طلباتي
    </a>
    <a href="{{ route('customer.profile') }}" class="nav-link">
        <i class="fas fa-user me-2"></i>
        الملف الشخصي
    </a>
@endsection


@section('content')
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-shopping-cart me-2 text-primary"></i>
                    جميع الطلبات
                </h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="statusFilter">
                        <option value="">جميع الحالات</option>
                        <option value="pending">قيد المعالجة</option>
                        <option value="processing">قيد التنفيذ</option>
                        <option value="completed">مكتمل</option>
                        <option value="cancelled">ملغي</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>رقم الطلب</th>
                                <th>المنتج</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>الحالة</th>
                                <th>تاريخ الطلب</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr data-status="{{ $order->status }}">
                                    <td>
                                        <strong>#{{ $order->id }}</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($order->product && $order->product->image)
                                                <img src="{{ asset('storage/' . $order->product->image) }}" 
                                                     class="rounded me-3" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-tshirt text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                @if($order->product)
                                                    <strong>{{ $order->product->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $order->product->category->name ?? 'غير محدد' }}</small>
                                                @else
                                                    <strong>تصميم مخصص</strong>
                                                    <br>
                                                    <small class="text-muted">طلب خاص</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $order->quantity ?? 1 }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ number_format($order->total_price ?? 0, 2) }} ر.س</strong>
                                    </td>
                                    <td>
                                        @switch($order->status)
                                            @case('pending')
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i>
                                                    قيد المعالجة
                                                </span>
                                                @break
                                            @case('processing')
                                                <span class="badge bg-info">
                                                    <i class="fas fa-cog me-1"></i>
                                                    قيد التنفيذ
                                                </span>
                                                @break
                                            @case('completed')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>
                                                    مكتمل
                                                </span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>
                                                    ملغي
                                                </span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $order->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $order->created_at->format('Y-m-d') }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#orderModal{{ $order->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($order->status == 'pending')
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="cancelOrder({{ $order->id }})">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Order Details Modal -->
                                <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">تفاصيل الطلب #{{ $order->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6>معلومات الطلب</h6>
                                                        <table class="table table-sm">
                                                            <tr>
                                                                <td><strong>رقم الطلب:</strong></td>
                                                                <td>#{{ $order->id }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>التاريخ:</strong></td>
                                                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>الحالة:</strong></td>
                                                                <td>
                                                                    @switch($order->status)
                                                                        @case('pending')
                                                                            <span class="badge bg-warning">قيد المعالجة</span>
                                                                            @break
                                                                        @case('processing')
                                                                            <span class="badge bg-info">قيد التنفيذ</span>
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
                                                            </tr>
                                                            <tr>
                                                                <td><strong>الكمية:</strong></td>
                                                                <td>{{ $order->quantity ?? 1 }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>السعر الإجمالي:</strong></td>
                                                                <td><strong>{{ number_format($order->total_price ?? 0, 2) }} ر.س</strong></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6>معلومات المنتج</h6>
                                                        @if($order->product)
                                                            <div class="text-center mb-3">
                                                                @if($order->product->image)
                                                                    <img src="{{ asset('storage/' . $order->product->image) }}" 
                                                                         class="img-fluid rounded" 
                                                                         style="max-height: 200px;">
                                                                @endif
                                                            </div>
                                                            <table class="table table-sm">
                                                                <tr>
                                                                    <td><strong>اسم المنتج:</strong></td>
                                                                    <td>{{ $order->product->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>الفئة:</strong></td>
                                                                    <td>{{ $order->product->category->name ?? 'غير محدد' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong>السعر:</strong></td>
                                                                    <td>{{ $order->product->price }} ر.س</td>
                                                                </tr>
                                                            </table>
                                                        @else
                                                            <div class="alert alert-info">
                                                                <i class="fas fa-info-circle me-2"></i>
                                                                هذا طلب تصميم مخصص
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                @if($order->notes)
                                                    <div class="mt-3">
                                                        <h6>ملاحظات إضافية</h6>
                                                        <div class="alert alert-light">
                                                            {{ $order->notes }}
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                @if($order->status == 'pending')
                                                    <button type="button" class="btn btn-danger" onclick="cancelOrder({{ $order->id }})">
                                                        <i class="fas fa-times me-2"></i>
                                                        إلغاء الطلب
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد طلبات حتى الآن</h4>
                    <p class="text-muted mb-4">تواصل معنا لإنشاء طلبك الأول</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Status filter functionality
        document.getElementById('statusFilter').addEventListener('change', function() {
            const selectedStatus = this.value;
            const rows = document.querySelectorAll('tbody tr[data-status]');
            
            rows.forEach(row => {
                if (selectedStatus === '' || row.dataset.status === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Cancel order function
        function cancelOrder(orderId) {
            if (confirm('هل أنت متأكد من إلغاء هذا الطلب؟')) {
                // Here you would typically send an AJAX request to cancel the order
                alert('سيتم إضافة وظيفة إلغاء الطلب قريباً');
            }
        }
    </script>
@endpush