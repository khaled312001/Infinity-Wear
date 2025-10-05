@extends('layouts.sales-dashboard')

@section('title', 'التقارير - فريق المبيعات')
@section('dashboard-title', 'التقارير')
@section('page-title', 'تقارير المبيعات')
@section('page-subtitle', 'عرض وتحليل بيانات المبيعات والمستوردين')

@section('content')
<div class="row">
    <!-- تقرير المبيعات الشهرية -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    تقرير المبيعات الشهرية - {{ date('Y') }}
                </h5>
            </div>
            <div class="card-body">
                <canvas id="monthlySalesChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- إحصائيات المستوردين -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-industry me-2"></i>
                    إحصائيات المستوردين
                </h5>
            </div>
            <div class="card-body">
                <canvas id="importerStatsChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- جدول المبيعات الشهرية -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>
                    تفاصيل المبيعات الشهرية
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>الشهر</th>
                                <th>عدد الطلبات</th>
                                <th>إجمالي الإيرادات</th>
                                <th>متوسط قيمة الطلب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $months = [
                                    1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
                                    5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
                                    9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
                                ];
                            @endphp
                            @foreach($monthlyReport as $report)
                                <tr>
                                    <td>{{ $months[$report->month] ?? $report->month }}</td>
                                    <td>{{ number_format($report->orders_count) }}</td>
                                    <td>{{ number_format($report->total_revenue) }} ريال</td>
                                    <td>{{ $report->orders_count > 0 ? number_format($report->total_revenue / $report->orders_count) : 0 }} ريال</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات المستوردين التفصيلية -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    تفاصيل المستوردين
                </h5>
            </div>
            <div class="card-body">
                @foreach($importerReport as $report)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0">
                                @switch($report->status)
                                    @case('new')
                                        <span class="badge bg-primary">جديد</span>
                                        @break
                                    @case('contacted')
                                        <span class="badge bg-info">تم التواصل</span>
                                        @break
                                    @case('qualified')
                                        <span class="badge bg-success">مؤهل</span>
                                        @break
                                    @case('unqualified')
                                        <span class="badge bg-danger">غير مؤهل</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $report->status }}</span>
                                @endswitch
                            </h6>
                        </div>
                        <div>
                            <span class="h5 mb-0">{{ $report->count }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- ملخص الإحصائيات -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    ملخص الإحصائيات
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon primary">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="mb-0">{{ number_format($monthlyReport->sum('orders_count')) }}</h3>
                                    <p class="mb-0 text-muted">إجمالي الطلبات</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon success">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="mb-0">{{ number_format($monthlyReport->sum('total_revenue')) }}</h3>
                                    <p class="mb-0 text-muted">إجمالي الإيرادات</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon warning">
                                    <i class="fas fa-industry"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="mb-0">{{ number_format($importerReport->sum('count')) }}</h3>
                                    <p class="mb-0 text-muted">إجمالي المستوردين</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon info">
                                    <i class="fas fa-calculator"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="mb-0">
                                        {{ $monthlyReport->sum('orders_count') > 0 ? number_format($monthlyReport->sum('total_revenue') / $monthlyReport->sum('orders_count')) : 0 }}
                                    </h3>
                                    <p class="mb-0 text-muted">متوسط قيمة الطلب</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // رسم مخطط المبيعات الشهرية
    const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
    const monthlySalesData = @json($monthlyReport);
    
    const months = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 
                   'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
    
    const monthlyLabels = monthlySalesData.map(item => months[item.month - 1]);
    const monthlyOrders = monthlySalesData.map(item => item.orders_count);
    const monthlyRevenue = monthlySalesData.map(item => item.total_revenue);
    
    new Chart(monthlySalesCtx, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'عدد الطلبات',
                data: monthlyOrders,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                yAxisID: 'y'
            }, {
                label: 'الإيرادات (ريال)',
                data: monthlyRevenue,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'الشهر'
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'عدد الطلبات'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'الإيرادات (ريال)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });

    // رسم مخطط إحصائيات المستوردين
    const importerStatsCtx = document.getElementById('importerStatsChart').getContext('2d');
    const importerStatsData = @json($importerReport);
    
    const statusLabels = importerStatsData.map(item => {
        switch(item.status) {
            case 'new': return 'جديد';
            case 'contacted': return 'تم التواصل';
            case 'qualified': return 'مؤهل';
            case 'unqualified': return 'غير مؤهل';
            default: return item.status;
        }
    });
    const statusCounts = importerStatsData.map(item => item.count);
    const statusColors = ['#3b82f6', '#06b6d4', '#10b981', '#ef4444'];
    
    new Chart(importerStatsCtx, {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusCounts,
                backgroundColor: statusColors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>
@endsection
