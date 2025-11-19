@extends('layouts.sales-dashboard')

@section('title', 'تفاصيل الطلب - ' . $workflowOrder->order_number)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-0">
                        <i class="fas fa-handshake me-2 text-primary"></i>
                        طلب رقم: <strong>{{ $workflowOrder->order_number }}</strong>
                    </h2>
                    <p class="text-muted mb-0">مرحلة المبيعات</p>
                </div>
                <a href="{{ route('sales.workflow-orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-right me-2"></i>العودة
                </a>
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
                            @if($workflowOrder->requirements)
                            <div class="mb-3">
                                <strong>المتطلبات:</strong><br>
                                <p class="text-muted">{{ $workflowOrder->requirements }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sales Stage -->
                <div class="col-md-8">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-handshake me-2"></i>مرحلة المبيعات</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('sales.workflow-orders.update-stage', $workflowOrder) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">حالة المرحلة *</label>
                                    <select name="status" class="form-select" required>
                                        <option value="pending" {{ $workflowOrder->sales_status == 'pending' ? 'selected' : '' }}>في الانتظار</option>
                                        <option value="in_progress" {{ $workflowOrder->sales_status == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                        <option value="completed" {{ $workflowOrder->sales_status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                        <option value="rejected" {{ $workflowOrder->sales_status == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">التكلفة النهائية</label>
                                    <input type="number" name="final_cost" class="form-control" value="{{ $workflowOrder->final_cost }}" step="0.01" min="0" placeholder="أدخل التكلفة النهائية">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">ملاحظات</label>
                                    <textarea name="notes" class="form-control" rows="4" placeholder="أضف ملاحظات عن مرحلة المبيعات..."></textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>حفظ التغييرات
                                    </button>
                                </div>
                            </form>

                            @if($workflowOrder->sales_started_at)
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <i class="fas fa-play me-1"></i>
                                            بدأ: {{ $workflowOrder->sales_started_at->format('Y-m-d H:i') }}
                                        </small>
                                    </div>
                                    @if($workflowOrder->sales_completed_at)
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <i class="fas fa-check me-1"></i>
                                            اكتمل: {{ $workflowOrder->sales_completed_at->format('Y-m-d H:i') }}
                                        </small>
                                    </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Next Stage Preview -->
                    @if($workflowOrder->sales_status == 'completed')
                    <div class="dashboard-card mt-4">
                        <div class="card-body">
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>تم إكمال مرحلة المبيعات!</strong> الطلب جاهز للانتقال لمرحلة التصميم.
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

