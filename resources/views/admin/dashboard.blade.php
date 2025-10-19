@extends('layouts.dashboard')

@section('title', 'لوحة التحكم - الأدمن')
@section('dashboard-title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')
@section('page-subtitle', 'مرحباً بك في لوحة تحكم الأدمن')

@section('content')
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-card dashboard-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="welcome-title mb-2">
                            مرحباً بك، {{ Auth::guard('admin')->user()->name }}! 👋
                        </h2>
                        <p class="welcome-subtitle mb-0">
                            إليك نظرة عامة على أداء النظام اليوم
                        </p>
                    </div>
                    <div class="welcome-actions">
                        <button class="btn btn-outline-primary me-2" onclick="refreshDashboard()">
                            <i class="fas fa-sync-alt me-2"></i>تحديث
                        </button>
                        <button class="btn btn-primary" onclick="exportReport()">
                            <i class="fas fa-download me-2"></i>تصدير تقرير
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card enhanced">
            <div class="d-flex align-items-center">
                <div class="stats-icon primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 class="mb-0 stats-number">{{ number_format($stats['total_users']) }}</h3>
                    <p class="mb-0 text-muted stats-label">إجمالي المستخدمين</p>
                    <div class="stats-trend">
                        <i class="fas fa-arrow-up text-success me-1"></i>
                        <span class="text-success">+12%</span>
                        <small class="text-muted">من الشهر الماضي</small>
                    </div>
                </div>
            </div>
            <div class="stats-chart">
                <canvas id="usersChart" width="60" height="30"></canvas>
            </div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card enhanced">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-industry"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 class="mb-0 stats-number">{{ number_format($stats['total_importers']) }}</h3>
                    <p class="mb-0 text-muted stats-label">إجمالي المستوردين</p>
                    <div class="stats-trend">
                        <i class="fas fa-arrow-up text-success me-1"></i>
                        <span class="text-success">+15%</span>
                        <small class="text-muted">من الشهر الماضي</small>
                    </div>
                </div>
            </div>
            <div class="stats-chart">
                <canvas id="importersChart" width="60" height="30"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card enhanced">
            <div class="d-flex align-items-center">
                <div class="stats-icon success">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 class="mb-0 stats-number">{{ number_format($stats['total_tasks']) }}</h3>
                    <p class="mb-0 text-muted stats-label">إجمالي المهام</p>
                    <div class="stats-trend">
                        <i class="fas fa-arrow-down text-danger me-1"></i>
                        <span class="text-danger">-5%</span>
                        <small class="text-muted">من الشهر الماضي</small>
                    </div>
                </div>
            </div>
            <div class="stats-chart">
                <canvas id="tasksChart" width="60" height="30"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- إحصائيات إضافية -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card enhanced">
            <div class="d-flex align-items-center">
                <div class="stats-icon warning">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 class="mb-0 stats-number">{{ number_format($stats['total_marketing_reports']) }}</h3>
                    <p class="mb-0 text-muted stats-label">تقارير المندوبين</p>
                    <div class="stats-trend">
                        <i class="fas fa-arrow-up text-success me-1"></i>
                        <span class="text-success">+8%</span>
                        <small class="text-muted">من الشهر الماضي</small>
                    </div>
                </div>
            </div>
            <div class="stats-chart">
                <canvas id="marketingReportsChart" width="60" height="30"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card enhanced">
            <div class="d-flex align-items-center">
                <div class="stats-icon danger">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 class="mb-0 stats-number">{{ number_format($stats['pending_marketing_reports']) }}</h3>
                    <p class="mb-0 text-muted stats-label">تقارير معلقة</p>
                    <div class="stats-trend">
                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                        <span class="text-warning">تحتاج مراجعة</span>
                    </div>
                </div>
            </div>
            <div class="stats-chart">
                <canvas id="pendingReportsChart" width="60" height="30"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card enhanced">
            <div class="d-flex align-items-center">
                <div class="stats-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 class="mb-0 stats-number">{{ number_format($stats['approved_marketing_reports']) }}</h3>
                    <p class="mb-0 text-muted stats-label">تقارير موافق عليها</p>
                    <div class="stats-trend">
                        <i class="fas fa-arrow-up text-success me-1"></i>
                        <span class="text-success">+12%</span>
                        <small class="text-muted">من الشهر الماضي</small>
                    </div>
                </div>
            </div>
            <div class="stats-chart">
                <canvas id="approvedReportsChart" width="60" height="30"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card enhanced">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <h3 class="mb-0 stats-number">{{ number_format($stats['total_transactions']) }}</h3>
                    <p class="mb-0 text-muted stats-label">إجمالي المعاملات</p>
                    <div class="stats-trend">
                        <i class="fas fa-arrow-up text-success me-1"></i>
                        <span class="text-success">+15%</span>
                        <small class="text-muted">من الشهر الماضي</small>
                    </div>
                </div>
            </div>
            <div class="stats-chart">
                <canvas id="transactionsChart" width="60" height="30"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- إحصائيات المبيعات الشهرية -->
    <div class="col-lg-8 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    إحصائيات المبيعات الشهرية
                </h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات المعاملات المالية -->
    <div class="col-lg-4 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-money-bill-wave me-2"></i>
                    المعاملات المالية
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">إجمالي الإيرادات</span>
                        <span class="fw-bold text-success">{{ number_format($financialStats['total_income']) }} ريال</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">إجمالي المصروفات</span>
                        <span class="fw-bold text-danger">{{ number_format($financialStats['total_expenses']) }} ريال</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">إيرادات الشهر الحالي</span>
                        <span class="fw-bold text-success">{{ number_format($financialStats['monthly_income']) }} ريال</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">مصروفات الشهر الحالي</span>
                        <span class="fw-bold text-danger">{{ number_format($financialStats['monthly_expenses']) }} ريال</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- الطلبات الحديثة -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-shopping-cart me-2"></i>
                    الطلبات الحديثة
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($recentOrders as $order)
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $order->order_number }}</h6>
                                <p class="mb-1 text-muted">{{ $order->customer_name }}</p>
                                <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'completed' ? 'success' : 'info') }}">
                                    {{ $order->status === 'pending' ? 'معلق' : ($order->status === 'completed' ? 'مكتمل' : 'قيد المعالجة') }}
                                </span>
                                <div class="mt-1">
                                    <strong>{{ number_format($order->total) }} ريال</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                        <p>لا توجد طلبات حديثة</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- المهام المعلقة -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tasks me-2"></i>
                    المهام المعلقة
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($pendingTasks as $task)
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $task->title }}</h6>
                                <p class="mb-1 text-muted">{{ $task->description }}</p>
                                <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $task->priority === 'urgent' ? 'danger' : ($task->priority === 'high' ? 'warning' : 'info') }}">
                                    {{ $task->priority === 'urgent' ? 'عاجل' : ($task->priority === 'high' ? 'عالي' : 'عادي') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-tasks fa-3x mb-3"></i>
                        <p>لا توجد مهام معلقة</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- المستوردين الجدد -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-industry me-2"></i>
                    المستوردين الجدد
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($newImporters as $importer)
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $importer->name }}</h6>
                                <p class="mb-1 text-muted">{{ $importer->company_name }}</p>
                                <small class="text-muted">{{ $importer->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-success">جديد</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-industry fa-3x mb-3"></i>
                        <p>لا توجد مستوردين جدد</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- النشاط الأخير -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>
                    النشاط الأخير
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($recentActivity as $activity)
                    <div class="activity-item">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="fas {{ $activity['icon'] }} text-{{ $activity['color'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $activity['title'] }}</h6>
                                <p class="mb-1 text-muted">{{ $activity['description'] }}</p>
                                <small class="text-muted">{{ $activity['time']->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-history fa-3x mb-3"></i>
                        <p>لا يوجد نشاط حديث</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- تقارير المندوبين التسويقيين -->
<div class="row">
    <!-- التقارير الحديثة -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        تقارير المندوبين الحديثة
                    </h5>
                    <a href="{{ route('admin.marketing-reports.index') }}" class="btn btn-sm btn-outline-primary">
                        عرض الكل
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($recentMarketingReports as $report)
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $report->company_name }}</h6>
                                <p class="mb-1 text-muted">{{ $report->representative_name }}</p>
                                <small class="text-muted">{{ $report->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $report->getStatusBadgeClass() }}">
                                    {{ $report->getStatusText() }}
                                </span>
                                <div class="mt-1">
                                    <a href="{{ route('admin.marketing-reports.show', $report) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                        <p>لا توجد تقارير حديثة</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- التقارير التي تحتاج مراجعة -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                        تقارير تحتاج مراجعة
                    </h5>
                    <a href="{{ route('admin.marketing-reports.index') }}" class="btn btn-sm btn-outline-warning">
                        مراجعة الكل
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($reportsNeedingReview as $report)
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $report->company_name }}</h6>
                                <p class="mb-1 text-muted">{{ $report->representative_name }}</p>
                                <small class="text-muted">{{ $report->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $report->getStatusBadgeClass() }}">
                                    {{ $report->getStatusText() }}
                                </span>
                                <div class="mt-1">
                                    <a href="{{ route('admin.marketing-reports.show', $report) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                        <p>جميع التقارير تم مراجعتها</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// رسم بياني للمبيعات الشهرية
const salesCtx = document.getElementById('salesChart').getContext('2d');
const monthlySalesData = [
    @if(isset($monthlySales))
        @foreach($monthlySales as $sale)
            {{ $sale->total ?? 0 }},
        @endforeach
    @else
        0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0
    @endif
];

const salesChart = new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: [
            'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو',
            'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'
        ],
        datasets: [{
            label: 'المبيعات (ريال)',
            data: monthlySalesData,
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString() + ' ريال';
                    }
                }
            }
        }
    }
});

// Mini charts for stats cards
function createMiniChart(canvasId, data, color) {
    const ctx = document.getElementById(canvasId).getContext('2d');
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['', '', '', '', '', ''],
            datasets: [{
                data: data,
                borderColor: color,
                backgroundColor: color + '20',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 0
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { display: false },
                y: { display: false }
            },
            elements: {
                point: { radius: 0 }
            }
        }
    });
}

// Create mini charts
createMiniChart('usersChart', [10, 15, 12, 18, 20, 25], '#3b82f6');
createMiniChart('importersChart', [2, 4, 6, 8, 10, 12], '#3b82f6');
createMiniChart('tasksChart', [20, 18, 15, 12, 10, 8], '#10b981');
createMiniChart('marketingReportsChart', [5, 8, 12, 15, 18, 22], '#f59e0b');
createMiniChart('pendingReportsChart', [3, 5, 4, 6, 8, 7], '#ef4444');
createMiniChart('approvedReportsChart', [8, 12, 15, 18, 20, 25], '#10b981');
createMiniChart('transactionsChart', [15, 18, 22, 25, 28, 30], '#3b82f6');

// Dashboard functions
function refreshDashboard() {
    const btn = event.target.closest('button');
    const icon = btn.querySelector('i');
    
    // Add loading animation
    icon.classList.add('fa-spin');
    btn.disabled = true;
    
    // Simulate refresh
    setTimeout(() => {
        icon.classList.remove('fa-spin');
        btn.disabled = false;
        
        // Show success message
        showNotification('تم تحديث البيانات بنجاح', 'success');
        
        // Reload page
        location.reload();
    }, 2000);
}

function exportReport() {
    const btn = event.target.closest('button');
    const icon = btn.querySelector('i');
    
    // Add loading animation
    icon.classList.add('fa-spin');
    btn.disabled = true;
    
    // Simulate export
    setTimeout(() => {
        icon.classList.remove('fa-spin');
        btn.disabled = false;
        
        // Show success message
        showNotification('تم تصدير التقرير بنجاح', 'success');
        
        // Create and download file
        const data = 'تقرير لوحة التحكم\nتاريخ: ' + new Date().toLocaleDateString('ar-SA');
        const blob = new Blob([data], { type: 'text/plain' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'dashboard-report-' + new Date().toISOString().split('T')[0] + '.txt';
        a.click();
        window.URL.revokeObjectURL(url);
    }, 1500);
}

function showNotification(message, type = 'info') {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'error' ? 'alert-danger' : 
                      type === 'warning' ? 'alert-warning' : 'alert-info';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 
                               type === 'error' ? 'exclamation-circle' : 
                               type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        const alert = document.querySelector('.alert:last-of-type');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}

// Animate numbers on page load
function animateNumbers() {
    const numbers = document.querySelectorAll('.stats-number');
    numbers.forEach(number => {
        const finalValue = parseInt(number.textContent.replace(/,/g, ''));
        let currentValue = 0;
        const increment = finalValue / 50;
        
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                currentValue = finalValue;
                clearInterval(timer);
            }
            number.textContent = Math.floor(currentValue).toLocaleString();
        }, 30);
    });
}

// Initialize animations when page loads
document.addEventListener('DOMContentLoaded', function() {
    animateNumbers();
    
    // Add entrance animations to cards
    const cards = document.querySelectorAll('.stats-card, .dashboard-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endpush