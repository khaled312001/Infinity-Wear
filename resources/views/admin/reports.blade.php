@extends('layouts.dashboard')

@section('title', 'التقارير والإحصائيات')
@section('dashboard-title', 'التقارير والإحصائيات')
@section('page-title', 'تقارير شاملة')
@section('page-subtitle', 'تحليلات وإحصائيات شاملة لأداء النظام')

{{-- Sidebar menu is now handled by the unified admin-sidebar partial --}}

@section('page-actions')
    <div class="d-flex gap-2">
        <button class="btn btn-success" onclick="exportReport('excel')">
            <i class="fas fa-file-excel me-2"></i>
            تصدير Excel
        </button>
        <button class="btn btn-danger" onclick="exportReport('pdf')">
            <i class="fas fa-file-pdf me-2"></i>
            تصدير PDF
        </button>
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-filter me-2"></i>
                فترة التقرير
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" onclick="changePeriod('today')">اليوم</a></li>
                <li><a class="dropdown-item" href="#" onclick="changePeriod('week')">هذا الأسبوع</a></li>
                <li><a class="dropdown-item" href="#" onclick="changePeriod('month')">هذا الشهر</a></li>
                <li><a class="dropdown-item" href="#" onclick="changePeriod('quarter')">هذا الربع</a></li>
                <li><a class="dropdown-item" href="#" onclick="changePeriod('year')">هذا العام</a></li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <!-- إحصائيات سريعة -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon primary me-3">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ number_format($monthlySales->sum('total') ?? 125000) }}</h3>
                        <p class="text-muted mb-0">إجمالي المبيعات (ر.س)</p>
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>
                            +18% من الشهر الماضي
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon success me-3">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ array_sum($importersByStatus ?? []) }}</h3>
                        <p class="text-muted mb-0">إجمالي المستوردين</p>
                        <small class="text-info">
                            <i class="fas fa-info-circle me-1"></i>
                            {{ $importersByStatus['approved'] ?? 0 }} مستورد نشط
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon warning me-3">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $tasksByDepartment->sum('total') ?? 0 }}</h3>
                        <p class="text-muted mb-0">إجمالي المهام</p>
                        <small class="text-warning">
                            <i class="fas fa-clock me-1"></i>
                            {{ $tasksByDepartment->sum('total') - $tasksByDepartment->sum('completed') ?? 0 }} مهمة معلقة
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon info me-3">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">
                            {{ $tasksByDepartment->sum('total') > 0 ? round(($tasksByDepartment->sum('completed') / $tasksByDepartment->sum('total')) * 100, 1) : 0 }}%
                        </h3>
                        <p class="text-muted mb-0">معدل إنجاز المهام</p>
                        <small class="text-success">
                            <i class="fas fa-check me-1"></i>
                            {{ $tasksByDepartment->sum('completed') ?? 0 }} مهمة مكتملة
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- تقرير المبيعات الشهرية -->
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-area me-2 text-primary"></i>
                            تقرير المبيعات الشهرية
                        </h5>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-outline-primary active" onclick="updateSalesChart('6months')">6 أشهر</button>
                            <button class="btn btn-sm btn-outline-primary" onclick="updateSalesChart('year')">سنة</button>
                            <button class="btn btn-sm btn-outline-primary" onclick="updateSalesChart('2years')">سنتان</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- توزيع المستوردين حسب الحالة -->
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2 text-success"></i>
                        توزيع المستوردين
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="importersChart"></canvas>
                    </div>
                    <div class="mt-3">
                        @if(isset($importersByStatus) && count($importersByStatus) > 0)
                            @foreach($importersByStatus as $status => $count)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="status-indicator status-{{ $status }} me-2"></div>
                                        <span>{{ ucfirst($status) }}</span>
                                    </div>
                                    <span class="fw-bold">{{ $count }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- تقارير الأقسام -->
    <div class="row g-4 mt-4">
        <div class="col-lg-6">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-users-cog me-2 text-warning"></i>
                        أداء الأقسام
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>القسم</th>
                                    <th>إجمالي المهام</th>
                                    <th>المكتملة</th>
                                    <th>معدل الإنجاز</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($tasksByDepartment) && $tasksByDepartment->count() > 0)
                                    @foreach($tasksByDepartment as $department)
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">{{ ucfirst($department->department) }}</span>
                                            </td>
                                            <td>{{ $department->total }}</td>
                                            <td>
                                                <span class="text-success fw-bold">{{ $department->completed }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $percentage = $department->total > 0 ? round(($department->completed / $department->total) * 100, 1) : 0;
                                                @endphp
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar 
                                                        @if($percentage >= 80) bg-success
                                                        @elseif($percentage >= 60) bg-warning
                                                        @else bg-danger
                                                        @endif" 
                                                        role="progressbar" 
                                                        style="width: {{ $percentage }}%">
                                                        {{ $percentage }}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            لا توجد بيانات للأقسام
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2 text-info"></i>
                        أداء فريق المبيعات
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($salesPerformance) && $salesPerformance->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>المندوب</th>
                                        <th>العملاء</th>
                                        <th>الصفقات المربحة</th>
                                        <th>معدل النجاح</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($salesPerformance as $performance)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-2">
                                                        <div class="avatar-initial bg-info rounded-circle">
                                                            {{ substr($performance->admin->name ?? 'غير محدد', 0, 1) }}
                                                        </div>
                                                    </div>
                                                    <span>{{ $performance->admin->name ?? 'غير محدد' }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $performance->total_importers }}</td>
                                            <td>
                                                <span class="text-success fw-bold">{{ $performance->won_deals }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $successRate = $performance->total_importers > 0 ? 
                                                        round(($performance->won_deals / $performance->total_importers) * 100, 1) : 0;
                                                @endphp
                                                <span class="badge 
                                                    @if($successRate >= 70) bg-success
                                                    @elseif($successRate >= 50) bg-warning
                                                    @else bg-danger
                                                    @endif">
                                                    {{ $successRate }}%
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">لا توجد بيانات لفريق المبيعات</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- تقرير فريق التسويق -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-bullhorn me-2 text-warning"></i>
                        أداء فريق التسويق
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($marketingPerformance) && $marketingPerformance->count() > 0)
                        <div class="row g-3">
                            @foreach($marketingPerformance as $performance)
                                <div class="col-lg-3 col-md-6">
                                    <div class="team-member-card">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar me-3">
                                                <div class="avatar-initial bg-warning rounded-circle">
                                                    {{ substr($performance->admin->name ?? 'غير محدد', 0, 1) }}
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $performance->admin->name ?? 'غير محدد' }}</h6>
                                                <small class="text-muted">فريق التسويق</small>
                                            </div>
                                        </div>
                                        <div class="stats-grid-small">
                                            <div class="stat-item-small">
                                                <div class="stat-value-small text-primary">{{ $performance->total_tasks }}</div>
                                                <div class="stat-label-small">إجمالي المهام</div>
                                            </div>
                                            <div class="stat-item-small">
                                                <div class="stat-value-small text-success">{{ $performance->completed_tasks }}</div>
                                                <div class="stat-label-small">المكتملة</div>
                                            </div>
                                        </div>
                                        <div class="progress mt-3" style="height: 8px;">
                                            @php
                                                $completionRate = $performance->total_tasks > 0 ? 
                                                    ($performance->completed_tasks / $performance->total_tasks) * 100 : 0;
                                            @endphp
                                            <div class="progress-bar bg-warning" 
                                                 role="progressbar" 
                                                 style="width: {{ $completionRate }}%">
                                            </div>
                                        </div>
                                        <small class="text-muted mt-2 d-block">
                                            معدل الإنجاز: {{ round($completionRate, 1) }}%
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد بيانات لفريق التسويق</h5>
                            <p class="text-muted">لم يتم العثور على أي بيانات أداء لفريق التسويق</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .chart-container {
            position: relative;
            height: 300px;
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .status-pending { background-color: #f59e0b; }
        .status-approved { background-color: #10b981; }
        .status-rejected { background-color: #ef4444; }
        .status-new { background-color: #3b82f6; }
        .status-qualified { background-color: #8b5cf6; }

        .avatar-initial {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 0.875rem;
        }

        .team-member-card {
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
        }

        .stats-grid-small {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .stat-item-small {
            text-align: center;
        }

        .stat-value-small {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .stat-label-small {
            font-size: 0.75rem;
            color: #64748b;
        }

        .progress {
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            transition: width 0.6s ease;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // رسم بياني للمبيعات الشهرية
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: [
                    @if(isset($monthlySales) && $monthlySales->count() > 0)
                        @foreach($monthlySales as $sale)
                            '{{ $sale->month }}/{{ $sale->year }}',
                        @endforeach
                    @else
                        'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'
                    @endif
                ],
                datasets: [{
                    label: 'المبيعات (ر.س)',
                    data: [
                        @if(isset($monthlySales) && $monthlySales->count() > 0)
                            @foreach($monthlySales as $sale)
                                {{ $sale->total }},
                            @endforeach
                        @else
                            12000, 19000, 15000, 25000, 22000, 30000
                        @endif
                    ],
                    borderColor: '#1e3a8a',
                    backgroundColor: 'rgba(30, 58, 138, 0.1)',
                    borderWidth: 3,
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
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString() + ' ر.س';
                            }
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    }
                }
            }
        });

        // رسم بياني دائري للمستوردين
        const importersCtx = document.getElementById('importersChart').getContext('2d');
        const importersChart = new Chart(importersCtx, {
            type: 'doughnut',
            data: {
                labels: [
                    @if(isset($importersByStatus) && count($importersByStatus) > 0)
                        @foreach(array_keys($importersByStatus) as $status)
                            '{{ ucfirst($status) }}',
                        @endforeach
                    @else
                        'معلق', 'موافق عليه', 'مرفوض'
                    @endif
                ],
                datasets: [{
                    data: [
                        @if(isset($importersByStatus) && count($importersByStatus) > 0)
                            @foreach(array_values($importersByStatus) as $count)
                                {{ $count }},
                            @endforeach
                        @else
                            15, 45, 8
                        @endif
                    ],
                    backgroundColor: [
                        '#f59e0b',
                        '#10b981', 
                        '#ef4444',
                        '#3b82f6',
                        '#8b5cf6'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        function updateSalesChart(period) {
            // إزالة الفئة النشطة من جميع الأزرار
            document.querySelectorAll('.btn-group .btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // إضافة الفئة النشطة للزر المضغوط
            event.target.classList.add('active');
            
            // هنا يمكن إضافة منطق تحديث البيانات بناءً على الفترة
            console.log('تحديث الرسم البياني للفترة:', period);
        }

        function changePeriod(period) {
            console.log('تغيير فترة التقرير إلى:', period);
            // هنا يمكن إضافة منطق تحديث التقرير
        }

        function exportReport(format) {
            console.log('تصدير التقرير بصيغة:', format);
            // هنا يمكن إضافة منطق التصدير
            alert('سيتم تصدير التقرير بصيغة ' + format.toUpperCase());
        }
    </script>
@endpush