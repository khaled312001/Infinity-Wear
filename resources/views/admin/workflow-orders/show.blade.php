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
                    <a href="{{ route('admin.workflow-orders.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>العودة
                    </a>
                    <a href="{{ route('order.show', $workflowOrder->order_number) }}" class="btn btn-outline-info" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>عرض للعميل
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Order Information -->
                <div class="col-md-4">
                    <div class="dashboard-card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>معلومات الطلب</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>العميل:</strong><br>
                                {{ $workflowOrder->customer_name }}<br>
                                <small class="text-muted">{{ $workflowOrder->customer_email }}</small><br>
                                <small class="text-muted">{{ $workflowOrder->customer_phone }}</small>
                            </div>
                            @if($workflowOrder->importer)
                            <div class="mb-3">
                                <strong>المستورد:</strong><br>
                                {{ $workflowOrder->importer->name }}
                            </div>
                            @endif
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
                        </div>
                    </div>

                    <!-- Update Order Form -->
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>تحديث الطلب</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.workflow-orders.update', $workflowOrder) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label">التكلفة النهائية</label>
                                    <input type="number" name="final_cost" class="form-control" value="{{ $workflowOrder->final_cost }}" step="0.01" min="0">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">تاريخ التسليم المتوقع</label>
                                    <input type="date" name="expected_delivery_date" class="form-control" value="{{ $workflowOrder->expected_delivery_date?->format('Y-m-d') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">رقم التتبع</label>
                                    <input type="text" name="tracking_number" class="form-control" value="{{ $workflowOrder->tracking_number }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ملاحظات</label>
                                    <textarea name="notes" class="form-control" rows="3">{{ $workflowOrder->notes }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>حفظ التحديثات
                                </button>
                            </form>
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
                                    'marketing' => ['name' => 'التسويق', 'icon' => 'fas fa-bullhorn', 'user' => $workflowOrder->marketingUser],
                                    'sales' => ['name' => 'المبيعات', 'icon' => 'fas fa-handshake', 'user' => $workflowOrder->salesUser],
                                    'design' => ['name' => 'التصميم', 'icon' => 'fas fa-palette', 'user' => $workflowOrder->designUser],
                                    'first_sample' => ['name' => 'العينة الأولى', 'icon' => 'fas fa-clipboard-check', 'user' => $workflowOrder->firstSampleUser],
                                    'work_approval' => ['name' => 'اعتماد الشغل', 'icon' => 'fas fa-check-circle', 'user' => $workflowOrder->workApprovalUser],
                                    'manufacturing' => ['name' => 'التصنيع', 'icon' => 'fas fa-industry', 'user' => $workflowOrder->manufacturingUser],
                                    'shipping' => ['name' => 'الشحن', 'icon' => 'fas fa-truck', 'user' => $workflowOrder->shippingUser],
                                    'receipt_delivery' => ['name' => 'استلام وتسليم', 'icon' => 'fas fa-box-open', 'user' => $workflowOrder->receiptDeliveryUser],
                                    'collection' => ['name' => 'التحصيل', 'icon' => 'fas fa-money-bill-wave', 'user' => $workflowOrder->collectionUser],
                                    'after_sales' => ['name' => 'خدمة ما بعد البيع', 'icon' => 'fas fa-headset', 'user' => $workflowOrder->afterSalesUser],
                                ];
                            @endphp

                            @foreach($stages as $stageKey => $stageInfo)
                                @php
                                    $statusField = $stageKey . '_status';
                                    $status = $workflowOrder->$statusField;
                                    $startedAtField = $stageKey . '_started_at';
                                    $completedAtField = $stageKey . '_completed_at';
                                    $userIdField = $stageKey . '_user_id';
                                    
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
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="stage-icon me-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                                                    <i class="{{ $stageInfo['icon'] }}"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $stageInfo['name'] }}</h6>
                                                    @if($workflowOrder->$startedAtField)
                                                        <small class="text-muted">بدأ: {{ $workflowOrder->$startedAtField->format('Y-m-d H:i') }}</small>
                                                    @endif
                                                    @if($workflowOrder->$completedAtField)
                                                        <small class="text-muted"> | اكتمل: {{ $workflowOrder->$completedAtField->format('Y-m-d H:i') }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($stageInfo['user'])
                                                <p class="mb-1"><small><i class="fas fa-user me-1"></i>معين ل: {{ $stageInfo['user']->name }}</small></p>
                                            @endif
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-{{ $color }} mb-2 d-block">{{ $label }}</span>
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateStageModal{{ $loop->index }}" onclick="setStageData('{{ $stageKey }}', '{{ $status }}', '{{ $workflowOrder->$userIdField }}')">
                                                <i class="fas fa-edit"></i> تحديث
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Update Stage Modal -->
                                <div class="modal fade" id="updateStageModal{{ $loop->index }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">تحديث مرحلة {{ $stageInfo['name'] }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.workflow-orders.update-stage', $workflowOrder) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="stage" value="{{ $stageKey }}">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">الحالة</label>
                                                        <select name="status" class="form-select" required>
                                                            @if($stageKey == 'work_approval')
                                                                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                                                <option value="in_progress" {{ $status == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                                                <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>معتمد</option>
                                                                <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                                                            @else
                                                                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                                                <option value="in_progress" {{ $status == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                                                <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                                                <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    @if($stageKey == 'marketing' && $marketingUsers->count() > 0)
                                                    <div class="mb-3">
                                                        <label class="form-label">تعيين لمستخدم</label>
                                                        <select name="user_id" class="form-select">
                                                            <option value="">اختر مستخدم</option>
                                                            @foreach($marketingUsers as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @elseif($stageKey == 'sales' && $salesUsers->count() > 0)
                                                    <div class="mb-3">
                                                        <label class="form-label">تعيين لمستخدم</label>
                                                        <select name="user_id" class="form-select">
                                                            <option value="">اختر مستخدم</option>
                                                            @foreach($salesUsers as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @elseif($stageKey == 'design' && $designUsers->count() > 0)
                                                    <div class="mb-3">
                                                        <label class="form-label">تعيين لمستخدم</label>
                                                        <select name="user_id" class="form-select">
                                                            <option value="">اختر مستخدم</option>
                                                            @foreach($designUsers as $user)
                                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @endif
                                                    <div class="mb-3">
                                                        <label class="form-label">ملاحظات</label>
                                                        <textarea name="notes" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                                </div>
                                            </form>
                                        </div>
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
    transform: translateX(-5px);
}

.stage-icon {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
</style>

<script>
function setStageData(stage, status, userId) {
    // يمكن إضافة JavaScript هنا إذا لزم الأمر
}
</script>
@endsection

