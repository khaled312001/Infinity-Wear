@extends('layouts.dashboard')

@section('title', 'تفاصيل التقرير')
@section('dashboard-title', 'تفاصيل التقرير')
@section('page-title', 'تفاصيل تقرير المندوب التسويقي')
@section('page-subtitle', 'مراجعة تفاصيل التقرير')

@section('content')
<div class="row">
    <!-- تفاصيل التقرير -->
    <div class="col-lg-8 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        تفاصيل التقرير
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.marketing-reports.edit', $marketingReport) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>
                            تعديل
                        </a>
                        <a href="{{ route('admin.marketing-reports.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">اسم المندوب</label>
                        <p class="form-control-plaintext">{{ $marketingReport->representative_name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">اسم الشركة</label>
                        <p class="form-control-plaintext">{{ $marketingReport->company_name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">نوع النشاط</label>
                        <p class="form-control-plaintext">{{ $marketingReport->getCompanyActivityText() }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">نوع الزيارة</label>
                        <p class="form-control-plaintext">{{ $marketingReport->getVisitTypeText() }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold">عنوان الشركة</label>
                        <p class="form-control-plaintext">{{ $marketingReport->company_address }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">اسم المسؤول</label>
                        <p class="form-control-plaintext">{{ $marketingReport->responsible_name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">هاتف المسؤول</label>
                        <p class="form-control-plaintext">{{ $marketingReport->responsible_phone }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">منصب المسؤول</label>
                        <p class="form-control-plaintext">{{ $marketingReport->responsible_position }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">حالة الاتفاق</label>
                        <span class="badge bg-{{ $marketingReport->agreement_status === 'agreed' ? 'success' : ($marketingReport->agreement_status === 'rejected' ? 'danger' : 'warning') }}">
                            {{ $marketingReport->getAgreementStatusText() }}
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">الكمية المستهدفة</label>
                        <p class="form-control-plaintext">{{ number_format($marketingReport->target_quantity) }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">الاستهلاك السنوي</label>
                        <p class="form-control-plaintext">{{ number_format($marketingReport->annual_consumption) }}</p>
                    </div>
                </div>

                @if($marketingReport->customer_concerns && count($marketingReport->customer_concerns) > 0)
                <div class="mb-3">
                    <label class="form-label fw-bold">مخاوف العميل</label>
                    <ul class="list-group">
                        @foreach($marketingReport->customer_concerns as $concern)
                        <li class="list-group-item">{{ $concern }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label fw-bold">التوصيات</label>
                    <p class="form-control-plaintext">{{ $marketingReport->recommendations }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">الخطوات التالية</label>
                    <p class="form-control-plaintext">{{ $marketingReport->next_steps }}</p>
                </div>

                @if($marketingReport->notes)
                <div class="mb-3">
                    <label class="form-label fw-bold">ملاحظات المندوب</label>
                    <p class="form-control-plaintext">{{ $marketingReport->notes }}</p>
                </div>
                @endif

                @if($marketingReport->admin_notes)
                <div class="mb-3">
                    <label class="form-label fw-bold">ملاحظات الإدارة</label>
                    <p class="form-control-plaintext">{{ $marketingReport->admin_notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- معلومات إضافية -->
    <div class="col-lg-4 mb-4">
        <!-- حالة التقرير -->
        <div class="dashboard-card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    حالة التقرير
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">الحالة الحالية</label>
                    <div>
                        <span class="badge bg-{{ $marketingReport->getStatusBadgeClass() }} fs-6">
                            {{ $marketingReport->getStatusText() }}
                        </span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">تاريخ الإنشاء</label>
                    <p class="form-control-plaintext">{{ $marketingReport->created_at->format('Y-m-d H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">آخر تحديث</label>
                    <p class="form-control-plaintext">{{ $marketingReport->updated_at->format('Y-m-d H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">أنشأ بواسطة</label>
                    <p class="form-control-plaintext">{{ $marketingReport->creator->name ?? 'غير محدد' }}</p>
                </div>

                @if($marketingReport->reviewed_at)
                <div class="mb-3">
                    <label class="form-label fw-bold">تم المراجعة في</label>
                    <p class="form-control-plaintext">{{ $marketingReport->reviewed_at->format('Y-m-d H:i') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- تحديث الحالة -->
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    تحديث الحالة
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.marketing-reports.update-status', $marketingReport) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label class="form-label">الحالة الجديدة</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $marketingReport->status === 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                            <option value="under_review" {{ $marketingReport->status === 'under_review' ? 'selected' : '' }}>قيد المراجعة</option>
                            <option value="approved" {{ $marketingReport->status === 'approved' ? 'selected' : '' }}>موافق عليه</option>
                            <option value="rejected" {{ $marketingReport->status === 'rejected' ? 'selected' : '' }}>مرفوض</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">ملاحظات الإدارة</label>
                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="أضف ملاحظاتك هنا...">{{ $marketingReport->admin_notes }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>
                        تحديث الحالة
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- صور الشركة -->
@if($marketingReport->company_images && count($marketingReport->company_images) > 0)
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-images me-2"></i>
                    صور الشركة
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($marketingReport->company_images as $image)
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <img src="{{ asset('storage/' . $image) }}" class="card-img-top" alt="صورة الشركة" style="height: 200px; object-fit: cover;">
                            <div class="card-body p-2">
                                <small class="text-muted">{{ $image }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
