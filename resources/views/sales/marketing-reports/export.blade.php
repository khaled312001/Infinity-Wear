@extends('layouts.sales-dashboard')

@section('title', 'تصدير تقارير المندوبين التسويقيين')
@section('dashboard-title', 'تصدير تقارير المندوبين التسويقيين')
@section('page-title', 'تصدير تقارير المندوبين التسويقيين')
@section('page-subtitle', 'نتائج تصدير تقارير المندوبين التسويقيين')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-download me-2"></i>
                        نتائج التصدير
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('sales.marketing-reports.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    تم العثور على {{ $reports->count() }} تقرير مطابق لمعايير التصدير.
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المندوب</th>
                                <th>الجهة</th>
                                <th>نوع الزيارة</th>
                                <th>حالة الاتفاق</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $index => $report)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $report->representative_name }}</td>
                                <td>{{ $report->company_name }}</td>
                                <td>{{ $report->getVisitTypeText() }}</td>
                                <td>{{ $report->getAgreementStatusText() }}</td>
                                <td>
                                    <span class="badge bg-{{ $report->getStatusBadgeClass() }}">
                                        {{ $report->getStatusText() }}
                                    </span>
                                </td>
                                <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                                        <p>لا توجد تقارير مطابقة لمعايير التصدير</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($reports->count() > 0)
                <div class="mt-4">
                    <div class="alert alert-success">
                        <h6 class="alert-heading">ملخص التصدير</h6>
                        <ul class="mb-0">
                            <li>إجمالي التقارير: {{ $reports->count() }}</li>
                            <li>تقارير تم الاتفاق: {{ $reports->where('agreement_status', 'agreed')->count() }}</li>
                            <li>تقارير تم الرفض: {{ $reports->where('agreement_status', 'rejected')->count() }}</li>
                            <li>تقارير بحاجة إلى وقت: {{ $reports->where('agreement_status', 'needs_time')->count() }}</li>
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
