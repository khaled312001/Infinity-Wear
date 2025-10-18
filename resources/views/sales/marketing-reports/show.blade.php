@extends('layouts.sales-dashboard')

@section('title', 'عرض تقرير المندوب التسويقي')
@section('dashboard-title', 'عرض تقرير المندوب التسويقي')
@section('page-title', 'عرض تقرير المندوب التسويقي')
@section('page-subtitle', 'تفاصيل تقرير المندوب التسويقي')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        تقرير المندوب التسويقي
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('sales.marketing-reports.edit', $marketingReport) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>
                            تعديل
                        </a>
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#statusModal">
                            <i class="fas fa-flag me-2"></i>
                            تغيير الحالة
                        </button>
                        <a href="{{ route('sales.marketing-reports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- معلومات المندوب -->
                    <div class="col-12 mb-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-user me-2"></i>
                            معلومات المندوب
                        </h6>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">اسم المندوب</label>
                        <p class="form-control-plaintext">{{ $marketingReport->representative_name }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">تاريخ الإنشاء</label>
                        <p class="form-control-plaintext">{{ $marketingReport->created_at->format('Y-m-d H:i') }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">منشئ التقرير</label>
                        <p class="form-control-plaintext">{{ $marketingReport->creator->name ?? 'غير محدد' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">حالة التقرير</label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-{{ $marketingReport->getStatusBadgeClass() }}">
                                {{ $marketingReport->getStatusText() }}
                            </span>
                        </p>
                    </div>

                    <!-- معلومات الجهة -->
                    <div class="col-12 mb-4 mt-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-building me-2"></i>
                            معلومات الجهة
                        </h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">اسم الجهة</label>
                        <p class="form-control-plaintext">{{ $marketingReport->company_name }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">نشاط الجهة</label>
                        <p class="form-control-plaintext">{{ $marketingReport->getCompanyActivityText() }}</p>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">عنوان الجهة التفصيلي</label>
                        <p class="form-control-plaintext">{{ $marketingReport->company_address }}</p>
                    </div>

                    @if($marketingReport->company_images && count($marketingReport->company_images) > 0)
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">صور المكان</label>
                        <div class="row">
                            @foreach($marketingReport->company_images as $image)
                            <div class="col-md-3 mb-2">
                                <img src="{{ Storage::url($image) }}" class="img-thumbnail" style="width: 100%; height: 200px; object-fit: cover;" alt="صورة المكان">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- معلومات المسئول -->
                    <div class="col-12 mb-4 mt-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-user-tie me-2"></i>
                            معلومات المسئول
                        </h6>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">اسم المسئول</label>
                        <p class="form-control-plaintext">{{ $marketingReport->responsible_name }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">رقم الجوال</label>
                        <p class="form-control-plaintext">
                            <a href="tel:{{ $marketingReport->responsible_phone }}" class="text-decoration-none">
                                {{ $marketingReport->responsible_phone }}
                            </a>
                        </p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">المنصب</label>
                        <p class="form-control-plaintext">{{ $marketingReport->responsible_position }}</p>
                    </div>

                    <!-- تفاصيل الزيارة -->
                    <div class="col-12 mb-4 mt-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-calendar-check me-2"></i>
                            تفاصيل الزيارة
                        </h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">نوع الزيارة</label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-info">
                                {{ $marketingReport->getVisitTypeText() }}
                            </span>
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">حالة الاتفاق</label>
                        <p class="form-control-plaintext">
                            <span class="badge bg-{{ $marketingReport->agreement_status === 'agreed' ? 'success' : ($marketingReport->agreement_status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ $marketingReport->getAgreementStatusText() }}
                            </span>
                        </p>
                    </div>

                    @if($marketingReport->customer_concerns && count($marketingReport->customer_concerns) > 0)
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">مخاوف العميل</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($marketingReport->customer_concerns as $concern)
                            <span class="badge bg-warning">{{ $concern }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- التفاصيل التجارية -->
                    <div class="col-12 mb-4 mt-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-chart-line me-2"></i>
                            التفاصيل التجارية
                        </h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">الكمية المستهدفة</label>
                        <p class="form-control-plaintext">{{ $marketingReport->target_quantity }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">الاستهلاك السنوي أو عدد الطلبيات السنوية المتوقعة</label>
                        <p class="form-control-plaintext">{{ $marketingReport->annual_consumption }}</p>
                    </div>

                    <!-- التوصيات والخطوات -->
                    <div class="col-12 mb-4 mt-4">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-lightbulb me-2"></i>
                            التوصيات والخطوات
                        </h6>
                    </div>

                    @if($marketingReport->recommendations)
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">توصيات مقترحة وملاحظات</label>
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0">{{ $marketingReport->recommendations }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($marketingReport->next_steps)
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">الخطوات اللاحقة التي ستم تنفيذها مع هذا العميل</label>
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0">{{ $marketingReport->next_steps }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($marketingReport->notes)
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">ملاحظات إضافية</label>
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0">{{ $marketingReport->notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal تغيير الحالة -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تغيير حالة التقرير</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sales.marketing-reports.update-status', $marketingReport) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">الحالة الجديدة</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $marketingReport->status == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                            <option value="approved" {{ $marketingReport->status == 'approved' ? 'selected' : '' }}>موافق عليه</option>
                            <option value="rejected" {{ $marketingReport->status == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                            <option value="under_review" {{ $marketingReport->status == 'under_review' ? 'selected' : '' }}>قيد المراجعة</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="أضف ملاحظات حول تغيير الحالة...">{{ $marketingReport->notes }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
