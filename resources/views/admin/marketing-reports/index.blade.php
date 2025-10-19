@extends('layouts.dashboard')

@section('title', 'تقارير المندوبين التسويقيين')
@section('dashboard-title', 'تقارير المندوبين التسويقيين')
@section('page-title', 'إدارة تقارير المندوبين التسويقيين')
@section('page-subtitle', 'مراجعة وإدارة تقارير المندوبين التسويقيين')

@section('content')
<div class="row">
    <!-- إحصائيات سريعة -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon primary">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ number_format($stats['total']) }}</h3>
                    <p class="mb-0 text-muted">إجمالي التقارير</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ number_format($stats['pending']) }}</h3>
                    <p class="mb-0 text-muted">قيد المراجعة</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ number_format($stats['approved']) }}</h3>
                    <p class="mb-0 text-muted">موافق عليها</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ number_format($stats['this_month']) }}</h3>
                    <p class="mb-0 text-muted">هذا الشهر</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- إحصائيات إضافية -->
<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon success">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ number_format($stats['under_review']) }}</h3>
                    <p class="mb-0 text-muted">قيد المراجعة</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon primary">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ number_format($stats['this_week']) }}</h3>
                    <p class="mb-0 text-muted">هذا الأسبوع</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon warning">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ number_format($stats['today']) }}</h3>
                    <p class="mb-0 text-muted">اليوم</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ number_format($salesStats['total_target_quantity']) }}</h3>
                    <p class="mb-0 text-muted">إجمالي الكمية المستهدفة</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- إحصائيات المندوبين -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>
                    أداء المندوبين
                </h5>
            </div>
            <div class="card-body">
                @forelse($representativeStats->take(5) as $stat)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">{{ $stat->representative_name }}</span>
                        <span class="fw-bold">{{ $stat->count }} تقرير</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-users fa-3x mb-3"></i>
                    <p>لا توجد إحصائيات متاحة</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- إحصائيات حالة الاتفاق -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-handshake me-2"></i>
                    إحصائيات حالة الاتفاق
                </h5>
            </div>
            <div class="card-body">
                @forelse($agreementStats as $stat)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">
                            @switch($stat->agreement_status)
                                @case('agreed') تم الاتفاق @break
                                @case('rejected') تم الرفض @break
                                @case('needs_time') بحاجة إلى وقت @break
                                @default غير محدد
                            @endswitch
                        </span>
                        <span class="fw-bold">{{ $stat->count }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-handshake fa-3x mb-3"></i>
                    <p>لا توجد إحصائيات متاحة</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- التقارير التي تحتاج مراجعة -->
@if($reportsNeedingReview->count() > 0)
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                    التقارير التي تحتاج مراجعة
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>المندوب</th>
                                <th>الجهة</th>
                                <th>نوع الزيارة</th>
                                <th>حالة الاتفاق</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportsNeedingReview as $report)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            {{ substr($report->representative_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $report->representative_name }}</h6>
                                            <small class="text-muted">{{ $report->creator->name ?? 'غير محدد' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-0">{{ $report->company_name }}</h6>
                                        <small class="text-muted">{{ $report->getCompanyActivityText() }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $report->getVisitTypeText() }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $report->agreement_status === 'agreed' ? 'success' : ($report->agreement_status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ $report->getAgreementStatusText() }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $report->getStatusBadgeClass() }}">
                                        {{ $report->getStatusText() }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <small class="text-muted">{{ $report->created_at->format('Y-m-d') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $report->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.marketing-reports.show', $report) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.marketing-reports.edit', $report) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
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

<!-- قائمة جميع التقارير -->
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        جميع التقارير
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.marketing-reports.analytics') }}" class="btn btn-outline-info">
                            <i class="fas fa-chart-bar me-2"></i>
                            التحليلات
                        </a>
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="fas fa-download me-2"></i>
                            تصدير
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>المندوب</th>
                                <th>الجهة</th>
                                <th>نوع الزيارة</th>
                                <th>حالة الاتفاق</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            {{ substr($report->representative_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $report->representative_name }}</h6>
                                            <small class="text-muted">{{ $report->creator->name ?? 'غير محدد' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-0">{{ $report->company_name }}</h6>
                                        <small class="text-muted">{{ $report->getCompanyActivityText() }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $report->getVisitTypeText() }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $report->agreement_status === 'agreed' ? 'success' : ($report->agreement_status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ $report->getAgreementStatusText() }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $report->getStatusBadgeClass() }}">
                                        {{ $report->getStatusText() }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <small class="text-muted">{{ $report->created_at->format('Y-m-d') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $report->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.marketing-reports.show', $report) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.marketing-reports.edit', $report) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.marketing-reports.destroy', $report) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقرير؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                                        <p>لا توجد تقارير متاحة</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal تصدير التقارير -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تصدير التقارير</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.marketing-reports.export') }}" method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">المندوب</label>
                            <select name="representative_name" class="form-select">
                                <option value="">جميع المندوبين</option>
                                @foreach($representativeStats as $stat)
                                <option value="{{ $stat->representative_name }}">{{ $stat->representative_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">حالة الاتفاق</label>
                            <select name="agreement_status" class="form-select">
                                <option value="">جميع الحالات</option>
                                <option value="agreed">تم الاتفاق</option>
                                <option value="rejected">تم الرفض</option>
                                <option value="needs_time">بحاجة إلى وقت</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">نوع الزيارة</label>
                            <select name="visit_type" class="form-select">
                                <option value="">جميع الأنواع</option>
                                <option value="office_visit">زيارة مقر</option>
                                <option value="phone_call">اتصال</option>
                                <option value="whatsapp">رسائل Whatsapp</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">من تاريخ</label>
                            <input type="date" name="date_from" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">إلى تاريخ</label>
                            <input type="date" name="date_to" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">تصدير</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
