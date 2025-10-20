@extends('layouts.dashboard')

@section('title', 'طلباتي - لوحة تحكم المستورد')
@section('dashboard-title', 'لوحة المستورد')
@section('page-title', 'طلباتي')
@section('page-subtitle', 'إدارة ومتابعة طلباتك')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>
                        طلباتي
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary">{{ $orders->total() }} طلب</span>
                        <a href="{{ route('importers.form') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            إنشاء طلب جديد
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>التاريخ</th>
                                        <th>الكمية</th>
                                        <th>الحالة</th>
                                        <th>المتطلبات</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>
                                                <strong>#{{ $order->order_number }}</strong>
                                            </td>
                                            <td>
                                                {{ $order->created_at->format('Y-m-d') }}
                                                <br>
                                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $order->quantity }} قطعة</span>
                                            </td>
                                            <td>
                                                @switch($order->status)
                                                    @case('new')
                                                        <span class="badge bg-warning">جديد</span>
                                                        @break
                                                    @case('in_progress')
                                                        <span class="badge bg-primary">قيد التنفيذ</span>
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
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;" title="{{ $order->requirements }}">
                                                    {{ Str::limit($order->requirements, 50) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#orderModal{{ $order->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
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
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد طلبات بعد</h5>
                            <p class="text-muted">لم تقم بإنشاء أي طلبات حتى الآن</p>
                            <a href="{{ route('importers.form') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                إنشاء طلب جديد
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modals -->
@foreach($orders as $order)
<div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تفاصيل الطلب #{{ $order->order_number }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>معلومات الطلب</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>رقم الطلب:</strong></td>
                                <td>#{{ $order->order_number }}</td>
                            </tr>
                            <tr>
                                <td><strong>التاريخ:</strong></td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>الكمية:</strong></td>
                                <td>{{ $order->quantity }} قطعة</td>
                            </tr>
                            <tr>
                                <td><strong>الحالة:</strong></td>
                                <td>
                                    @switch($order->status)
                                        @case('new')
                                            <span class="badge bg-warning">جديد</span>
                                            @break
                                        @case('in_progress')
                                            <span class="badge bg-primary">قيد التنفيذ</span>
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
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>المتطلبات</h6>
                        <div class="border rounded p-3">
                            <p>{{ $order->requirements }}</p>
                        </div>
                    </div>
                </div>
                
                @if($order->design_details)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>تفاصيل التصميم</h6>
                            <div class="border rounded p-3">
                                @php
                                    $designDetails = json_decode($order->design_details, true);
                                @endphp
                                
                                @if(isset($designDetails['option']))
                                    <p><strong>نوع التصميم:</strong> 
                                        @switch($designDetails['option'])
                                            @case('text')
                                                نص مكتوب
                                                @break
                                            @case('upload')
                                                ملف مرفوع
                                                @break
                                            @case('template')
                                                قالب ثلاثي الأبعاد
                                                @break
                                        @endswitch
                                    </p>
                                @endif
                                
                                @if(isset($designDetails['text']))
                                    <p><strong>النص:</strong> {{ $designDetails['text'] }}</p>
                                @endif
                                
                                @if(isset($designDetails['file_path']))
                                    <p><strong>الملف:</strong> 
                                        <a href="{{ asset('storage/' . $designDetails['file_path']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download me-1"></i>
                                            تحميل الملف
                                        </a>
                                    </p>
                                @endif
                                
                                @if(isset($designDetails['notes']))
                                    <p><strong>ملاحظات:</strong> {{ $designDetails['notes'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
