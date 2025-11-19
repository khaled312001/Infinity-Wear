@extends('layouts.dashboard')

@section('title', 'تفاصيل الطلب - ' . $workflowOrder->order_number)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-0">
                        <i class="fas fa-shopping-bag me-2 text-primary"></i>
                        طلب رقم: <strong>{{ $workflowOrder->order_number }}</strong>
                    </h2>
                    <p class="text-muted mb-0">تاريخ الإنشاء: {{ $workflowOrder->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('importer.workflow-orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>العودة
                    </a>
                    <a href="{{ route('order.show', $workflowOrder->order_number) }}" class="btn btn-outline-info" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>تتبع الطلب
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Order Information -->
                <div class="col-md-4">
                    <div class="dashboard-card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>معلومات الطلب</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>الكمية:</strong> {{ number_format($workflowOrder->quantity) }} قطعة
                            </div>
                            <div class="mb-3">
                                <strong>التكلفة المقدرة:</strong><br>
                                @if($workflowOrder->estimated_cost)
                                    {{ number_format($workflowOrder->estimated_cost, 2) }} ريال
                                @else
                                    <span class="text-muted">غير محدد</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <strong>التكلفة النهائية:</strong><br>
                                @if($workflowOrder->final_cost)
                                    <strong class="text-success">{{ number_format($workflowOrder->final_cost, 2) }} ريال</strong>
                                @else
                                    <span class="text-muted">غير محدد</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <strong>الحالة العامة:</strong><br>
                                @php
                                    $statusColors = [
                                        'new' => 'secondary',
                                        'in_progress' => 'warning',
                                        'completed' => 'success',
                                        'cancelled' => 'danger'
                                    ];
                                    $color = $statusColors[$workflowOrder->overall_status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }}">{{ $workflowOrder->overall_status_label }}</span>
                            </div>
                            @if($workflowOrder->requirements)
                            <div class="mb-3">
                                <strong>المتطلبات:</strong><br>
                                <p class="text-muted">{{ $workflowOrder->requirements }}</p>
                            </div>
                            @endif
                            @if($workflowOrder->tracking_number)
                            <div class="mb-3">
                                <strong>رقم التتبع:</strong><br>
                                <code>{{ $workflowOrder->tracking_number }}</code>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Workflow Stages -->
                <div class="col-md-8">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>مراحل الطلب</h5>
                        </div>
                        <div class="card-body">
                            @php
                                $stages = [
                                    'marketing' => ['name' => 'التسويق', 'icon' => 'fas fa-bullhorn', 'status' => $workflowOrder->marketing_status],
                                    'sales' => ['name' => 'المبيعات', 'icon' => 'fas fa-handshake', 'status' => $workflowOrder->sales_status],
                                    'design' => ['name' => 'التصميم', 'icon' => 'fas fa-palette', 'status' => $workflowOrder->design_status],
                                    'first_sample' => ['name' => 'العينة الأولى', 'icon' => 'fas fa-clipboard-check', 'status' => $workflowOrder->first_sample_status],
                                    'work_approval' => ['name' => 'اعتماد الشغل', 'icon' => 'fas fa-check-circle', 'status' => $workflowOrder->work_approval_status],
                                    'manufacturing' => ['name' => 'التصنيع', 'icon' => 'fas fa-industry', 'status' => $workflowOrder->manufacturing_status],
                                    'shipping' => ['name' => 'الشحن', 'icon' => 'fas fa-truck', 'status' => $workflowOrder->shipping_status],
                                    'receipt_delivery' => ['name' => 'استلام وتسليم', 'icon' => 'fas fa-box-open', 'status' => $workflowOrder->receipt_delivery_status],
                                    'collection' => ['name' => 'التحصيل', 'icon' => 'fas fa-money-bill-wave', 'status' => $workflowOrder->collection_status],
                                    'after_sales' => ['name' => 'خدمة ما بعد البيع', 'icon' => 'fas fa-headset', 'status' => $workflowOrder->after_sales_status],
                                ];
                            @endphp

                            @foreach($stages as $stageKey => $stageInfo)
                                @php
                                    $status = $stageInfo['status'];
                                    $statusColors = [
                                        'pending' => 'secondary',
                                        'in_progress' => 'warning',
                                        'completed' => 'success',
                                        'rejected' => 'danger',
                                        'approved' => 'success'
                                    ];
                                    $color = $statusColors[$status] ?? 'secondary';
                                    
                                    $statusLabels = [
                                        'pending' => 'في الانتظار',
                                        'in_progress' => 'قيد التنفيذ',
                                        'completed' => 'مكتمل',
                                        'rejected' => 'مرفوض',
                                        'approved' => 'معتمد'
                                    ];
                                    $label = $statusLabels[$status] ?? $status;
                                @endphp
                                <div class="workflow-stage-item mb-3 p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="stage-icon me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                                                <i class="{{ $stageInfo['icon'] }}"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $stageInfo['name'] }}</h6>
                                            </div>
                                        </div>
                                        <span class="badge bg-{{ $color }}">{{ $label }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.workflow-stage-item {
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.workflow-stage-item:hover {
    background: #e9ecef;
}

.stage-icon {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
</style>
@endsection

