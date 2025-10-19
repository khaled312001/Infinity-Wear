@extends('layouts.dashboard')

@section('title', 'تحليلات تقارير المندوبين')
@section('dashboard-title', 'تحليلات تقارير المندوبين')
@section('page-title', 'التحليلات والإحصائيات')
@section('page-subtitle', 'تحليل أداء المندوبين التسويقيين')

@section('content')
<div class="row">
    <!-- أداء المندوبين -->
    <div class="col-12 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    أداء المندوبين
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>المندوب</th>
                                <th>إجمالي التقارير</th>
                                <th>التقارير الموافق عليها</th>
                                <th>معدل الموافقة</th>
                                <th>التقارير المتفق عليها</th>
                                <th>معدل الاتفاق</th>
                                <th>متوسط الكمية المستهدفة</th>
                                <th>إجمالي الكمية المستهدفة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($representativePerformance as $rep)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            {{ substr($rep->representative_name, 0, 1) }}
                                        </div>
                                        <span class="fw-bold">{{ $rep->representative_name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $rep->total_reports }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $rep->approved_reports }}</span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: {{ $rep->total_reports > 0 ? ($rep->approved_reports / $rep->total_reports) * 100 : 0 }}%">
                                            {{ $rep->total_reports > 0 ? round(($rep->approved_reports / $rep->total_reports) * 100, 1) : 0 }}%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $rep->agreed_reports }}</span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-primary" role="progressbar" 
                                             style="width: {{ $rep->total_reports > 0 ? ($rep->agreed_reports / $rep->total_reports) * 100 : 0 }}%">
                                            {{ $rep->total_reports > 0 ? round(($rep->agreed_reports / $rep->total_reports) * 100, 1) : 0 }}%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($rep->avg_target_quantity, 0) }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">{{ number_format($rep->total_target_quantity) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-chart-bar fa-3x mb-3"></i>
                                        <p>لا توجد بيانات متاحة</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- الأداء الشهري -->
    <div class="col-lg-8 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    الأداء الشهري
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>الشهر</th>
                                <th>إجمالي التقارير</th>
                                <th>التقارير الموافق عليها</th>
                                <th>التقارير المتفق عليها</th>
                                <th>متوسط الكمية المستهدفة</th>
                                <th>متوسط الاستهلاك السنوي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($monthlyPerformance as $month)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{ $month->year }}/{{ str_pad($month->month, 2, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $month->total_reports }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $month->approved_reports }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $month->agreed_reports }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($month->avg_target_quantity, 0) }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ number_format($month->avg_annual_consumption, 0) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-chart-line fa-3x mb-3"></i>
                                        <p>لا توجد بيانات متاحة</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- أداء حسب نوع النشاط -->
    <div class="col-lg-4 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-building me-2"></i>
                    أداء حسب نوع النشاط
                </h5>
            </div>
            <div class="card-body">
                @forelse($activityPerformance as $activity)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">
                            @switch($activity->company_activity)
                                @case('sports_academy') أكاديمية رياضية @break
                                @case('school') مدرسة @break
                                @case('institution_company') مؤسسة / شركة @break
                                @case('wholesale_store') محل جملة @break
                                @case('retail_store') محل تجزئة @break
                                @case('other') أخرى @break
                                @default غير محدد
                            @endswitch
                        </span>
                        <span class="badge bg-info">{{ $activity->total_reports }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="text-muted">التقارير المتفق عليها</small>
                        <small class="fw-bold">{{ $activity->agreed_reports }}</small>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">متوسط الكمية المستهدفة</small>
                        <small class="fw-bold">{{ number_format($activity->avg_target_quantity, 0) }}</small>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-building fa-3x mb-3"></i>
                    <p>لا توجد بيانات متاحة</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- إحصائيات الاتفاق حسب نوع الزيارة -->
    <div class="col-12 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-route me-2"></i>
                    إحصائيات الاتفاق حسب نوع الزيارة
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($visitTypeAgreement as $visit)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title">
                                    @switch($visit->visit_type)
                                        @case('office_visit') زيارة مقر @break
                                        @case('phone_call') اتصال @break
                                        @case('whatsapp') رسائل Whatsapp @break
                                        @default غير محدد
                                    @endswitch
                                </h6>
                                <div class="mb-3">
                                    <span class="badge bg-info fs-6">{{ $visit->total_reports }} تقرير</span>
                                </div>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="text-success">
                                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                                            <div class="fw-bold">{{ $visit->agreed_reports }}</div>
                                            <small class="text-muted">متفق عليها</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-danger">
                                            <i class="fas fa-times-circle fa-2x mb-2"></i>
                                            <div class="fw-bold">{{ $visit->rejected_reports }}</div>
                                            <small class="text-muted">مرفوضة</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-warning">
                                            <i class="fas fa-clock fa-2x mb-2"></i>
                                            <div class="fw-bold">{{ $visit->needs_time_reports }}</div>
                                            <small class="text-muted">تحتاج وقت</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-route fa-3x mb-3"></i>
                            <p>لا توجد بيانات متاحة</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.marketing-reports.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-right me-2"></i>
                العودة للقائمة
            </a>
            <button class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print me-2"></i>
                طباعة التقرير
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// إضافة تأثيرات بصرية للجداول
document.addEventListener('DOMContentLoaded', function() {
    // إضافة تأثير hover للصفوف
    const tableRows = document.querySelectorAll('table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
    
    // إضافة تأثيرات للبطاقات
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
            this.style.transition = 'all 0.3s ease';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });
});
</script>
@endpush
