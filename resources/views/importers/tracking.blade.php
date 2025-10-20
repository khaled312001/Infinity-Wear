@extends('layouts.dashboard')

@section('title', 'تتبع الشحنات - لوحة تحكم المستورد')
@section('dashboard-title', 'لوحة المستورد')
@section('page-title', 'تتبع الشحنات')
@section('page-subtitle', 'متابعة حالة شحناتك في الوقت الفعلي')

@section('content')
<div class="container-fluid">
    <!-- شريط البحث -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-2">
                                <i class="fas fa-search me-2"></i>
                                البحث عن شحنة
                            </h6>
                            <div class="input-group">
                                <input type="text" class="form-control" id="trackingNumber" placeholder="أدخل رقم التتبع أو رقم الطلب">
                                <button class="btn btn-primary" type="button" onclick="trackShipment()">
                                    <i class="fas fa-search me-1"></i>
                                    تتبع
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="d-flex justify-content-end align-items-center">
                                <span class="badge bg-success me-2">
                                    <i class="fas fa-shipping-fast me-1"></i>
                                    {{ $shippedOrders->count() }} شحنة نشطة
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الشحنات النشطة -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-truck me-2"></i>
                        الشحنات النشطة
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('importers.form') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            إنشاء طلب جديد
                        </a>
                        <button class="btn btn-sm btn-outline-primary" onclick="refreshTracking()">
                            <i class="fas fa-sync-alt me-1"></i>
                            تحديث
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    @if($shippedOrders->count() > 0)
                        <div class="row">
                            @foreach($shippedOrders as $order)
                                <div class="col-lg-6 mb-4">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h6 class="card-title mb-1">طلب #{{ $order->order_number }}</h6>
                                                    <small class="text-muted">{{ $order->created_at->format('Y-m-d') }}</small>
                                                </div>
                                                <div>
                                                    @switch($order->status)
                                                        @case('in_progress')
                                                            <span class="badge bg-secondary">قيد التجهيز</span>
                                                            @break
                                                        @case('shipped')
                                                            <span class="badge bg-info">تم الشحن</span>
                                                            @break
                                                        @case('in_transit')
                                                            <span class="badge bg-primary">في الطريق</span>
                                                            @break
                                                        @case('out_for_delivery')
                                                            <span class="badge bg-warning">خارج للتسليم</span>
                                                            @break
                                                        @case('delivered')
                                                            <span class="badge bg-success">تم التسليم</span>
                                                            @break
                                                    @endswitch
                                                </div>
                                            </div>
                                            
                                            <!-- شريط التقدم -->
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <small class="text-muted">تقدم الشحنة</small>
                                                    <small class="text-muted">{{ $order->quantity }} قطعة</small>
                                                </div>
                                                <div class="progress" style="height: 8px;">
                                                    @php
                                                        $progress = 0;
                                                        switch($order->status) {
                                                            case 'in_progress': $progress = 10; break;
                                                            case 'shipped': $progress = 25; break;
                                                            case 'in_transit': $progress = 50; break;
                                                            case 'out_for_delivery': $progress = 75; break;
                                                            case 'delivered': $progress = 100; break;
                                                        }
                                                    @endphp
                                                    <div class="progress-bar bg-primary js-progress" role="progressbar" 
                                                         data-progress="{{ $progress }}" 
                                                         aria-valuenow="{{ $progress }}" 
                                                         aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            
                                            <!-- تفاصيل التتبع -->
                                            <div class="tracking-timeline">
                                                <div class="timeline-item {{ in_array($order->status, ['in_progress', 'shipped', 'in_transit', 'out_for_delivery', 'delivered']) ? 'active' : '' }}">
                                                    <div class="timeline-marker">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6>تم تجهيز الطلب</h6>
                                                        <small class="text-muted">{{ $order->created_at->format('Y-m-d H:i') }}</small>
                                                    </div>
                                                </div>
                                                
                                                <div class="timeline-item {{ in_array($order->status, ['in_transit', 'out_for_delivery', 'delivered']) ? 'active' : '' }}">
                                                    <div class="timeline-marker">
                                                        <i class="fas fa-shipping-fast"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6>في الطريق</h6>
                                                        <small class="text-muted">متوقع: {{ $order->created_at->addDays(2)->format('Y-m-d') }}</small>
                                                    </div>
                                                </div>
                                                
                                                <div class="timeline-item {{ in_array($order->status, ['out_for_delivery', 'delivered']) ? 'active' : '' }}">
                                                    <div class="timeline-marker">
                                                        <i class="fas fa-truck"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6>خارج للتسليم</h6>
                                                        <small class="text-muted">متوقع: {{ $order->created_at->addDays(3)->format('Y-m-d') }}</small>
                                                    </div>
                                                </div>
                                                
                                                <div class="timeline-item {{ $order->status == 'delivered' ? 'active' : '' }}">
                                                    <div class="timeline-marker">
                                                        <i class="fas fa-check-circle"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6>تم التسليم</h6>
                                                        <small class="text-muted">{{ $order->updated_at->format('Y-m-d H:i') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- معلومات إضافية -->
                                            <div class="mt-3 pt-3 border-top">
                                                <div class="row text-center">
                                                    <div class="col-4">
                                                        <small class="text-muted d-block">رقم التتبع</small>
                                                        <strong>TRK{{ $order->id }}{{ $order->order_number }}</strong>
                                                    </div>
                                                    <div class="col-4">
                                                        <small class="text-muted d-block">الشركة</small>
                                                        <strong>إنفينيتي وير</strong>
                                                    </div>
                                                    <div class="col-4">
                                                        <small class="text-muted d-block">التوقيت المتوقع</small>
                                                        <strong>{{ $order->created_at->addDays(3)->format('Y-m-d') }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد شحنات نشطة</h5>
                            <p class="text-muted">لم يتم شحن أي طلبات بعد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- الشحنات المكتملة -->
    @if($completedOrders->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-check-circle me-2"></i>
                        الشحنات المكتملة مؤخراً
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>تاريخ التسليم</th>
                                    <th>الكمية</th>
                                    <th>رقم التتبع</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($completedOrders as $order)
                                    <tr>
                                        <td><strong>#{{ $order->order_number }}</strong></td>
                                        <td>{{ $order->updated_at->format('Y-m-d') }}</td>
                                        <td>{{ $order->quantity }} قطعة</td>
                                        <td>TRK{{ $order->id }}{{ $order->order_number }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary js-view-order" 
                                                    data-order-id="{{ $order->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.tracking-timeline {
    position: relative;
    padding-left: 30px;
}

.tracking-timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
    opacity: 0.5;
    transition: all 0.3s ease;
}

.timeline-item.active {
    opacity: 1;
}

.timeline-item.active .timeline-marker {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #e9ecef;
    border: 2px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: #6c757d;
}

.timeline-content h6 {
    margin-bottom: 5px;
    font-size: 14px;
    font-weight: 600;
}

.timeline-content small {
    font-size: 12px;
}

.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}
</style>

<script>
function trackShipment() {
    const trackingNumber = document.getElementById('trackingNumber').value.trim();
    
    if (!trackingNumber) {
        alert('يرجى إدخال رقم التتبع');
        return;
    }
    
    // محاكاة البحث عن الشحنة
    alert('جاري البحث عن الشحنة: ' + trackingNumber);
    
    // هنا يمكن إضافة منطق البحث الفعلي
    // window.location.href = '/importers/tracking/search/' + trackingNumber;
}

function refreshTracking() {
    // إعادة تحميل الصفحة لتحديث البيانات
    window.location.reload();
}

function viewOrderDetails(orderId) {
    // عرض تفاصيل الطلب
    alert('عرض تفاصيل الطلب رقم: ' + orderId);
    
    // يمكن إضافة modal أو redirect لصفحة التفاصيل
    // window.location.href = '/importers/orders/' + orderId;
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.js-progress').forEach(function(el){
        var p = parseInt(el.getAttribute('data-progress') || '0', 10);
        if (!isNaN(p)) {
            el.style.width = p + '%';
        }
    });

    document.querySelectorAll('.js-view-order').forEach(function(btn){
        btn.addEventListener('click', function(){
            var id = this.getAttribute('data-order-id');
            viewOrderDetails(id);
        });
    });
});

// تحديث تلقائي كل 30 ثانية
setInterval(function() {
    // يمكن إضافة AJAX call لتحديث البيانات بدون إعادة تحميل الصفحة
    console.log('تحديث بيانات التتبع...');
}, 30000);
</script>
@endsection
