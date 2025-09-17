@extends('layouts.dashboard')

@section('title', 'لوحة تحكم العميل')
@section('dashboard-title', 'لوحة العميل')
@section('page-title', 'مرحبا ' . Auth::user()->name)
@section('page-subtitle', 'إليك نظرة عامة على حسابك وطلباتك')
@section('profile-route', route('customer.profile'))
@section('settings-route', route('customer.settings'))

@section('sidebar-menu')
    <a href="{{ route('customer.dashboard') }}" class="nav-link active">
        <i class="fas fa-tachometer-alt me-2"></i>
        الرئيسية
    </a>
    <a href="{{ route('customer.orders') }}" class="nav-link">
        <i class="fas fa-shopping-cart me-2"></i>
        طلباتي
    </a>
    <a href="{{ route('customer.designs') }}" class="nav-link">
        <i class="fas fa-palette me-2"></i>
        تصاميمي
    </a>
    <a href="{{ route('customer.profile') }}" class="nav-link">
        <i class="fas fa-user me-2"></i>
        الملف الشخصي
    </a>
@endsection

@section('page-actions')
                <a href="{{ route('importers.form') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        تصميم جديد
    </a>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon primary me-3">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $totalOrders }}</h3>
                        <p class="text-muted mb-0">إجمالي الطلبات</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon warning me-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $pendingOrders }}</h3>
                        <p class="text-muted mb-0">طلبات قيد المعالجة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon success me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $completedOrders }}</h3>
                        <p class="text-muted mb-0">طلبات مكتملة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon info me-3">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $totalDesigns }}</h3>
                        <p class="text-muted mb-0">التصاميم المخصصة</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-shopping-cart me-2 text-primary"></i>
                            أحدث الطلبات
                        </h5>
                        <a href="{{ route('customer.orders') }}" class="btn btn-sm btn-outline-primary">
                            عرض الكل
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>المنتج</th>
                                        <th>الحالة</th>
                                        <th>التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td><strong>#{{ $order->id }}</strong></td>
                                            <td>
                                                @if($order->product)
                                                    {{ $order->product->name }}
                                                @else
                                                    تصميم مخصص
                                                @endif
                                            </td>
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
                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد طلبات حتى الآن</h5>
                            <p class="text-muted">ابدأ بتصفح منتجاتنا وإنشاء طلبك الأول</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                تصفح المنتجات
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions & Recent Designs -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="dashboard-card mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2 text-warning"></i>
                        إجراءات سريعة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('importers.form') }}" class="btn btn-primary">
                            <i class="fas fa-palette me-2"></i>
                            إنشاء تصميم مخصص
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-tshirt me-2"></i>
                            تصفح المنتجات
                        </a>
                        <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-history me-2"></i>
                            تتبع الطلبات
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Designs -->
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-palette me-2 text-info"></i>
                            أحدث التصاميم
                        </h5>
                        <a href="{{ route('customer.designs') }}" class="btn btn-sm btn-outline-primary">
                            عرض الكل
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentDesigns->count() > 0)
                        <div class="recent-activity">
                            @foreach($recentDesigns as $design)
                                <div class="activity-item">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon info me-3" style="width: 40px; height: 40px; font-size: 16px;">
                                            <i class="fas fa-palette"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ Str::limit($design->title, 30) }}</h6>
                                            <small class="text-muted">{{ $design->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-palette fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">لا توجد تصاميم حتى الآن</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Add some interactivity if needed
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
@endpush