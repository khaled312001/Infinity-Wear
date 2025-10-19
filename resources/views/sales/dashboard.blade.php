@extends('layouts.sales-dashboard')

@section('title', 'لوحة التحكم - فريق المبيعات')
@section('dashboard-title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')
@section('page-subtitle', 'مرحباً بك في لوحة تحكم فريق المبيعات')

@section('content')
<div class="row">
    <!-- إحصائيات المستوردين -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon primary">
                    <i class="fas fa-industry"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ number_format($salesStats['total_importers']) }}</h3>
                    <p class="mb-0 text-muted">إجمالي المستوردين</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon success">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ number_format($salesStats['total_importer_orders']) }}</h3>
                    <p class="mb-0 text-muted">طلبات المستوردين</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon warning">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ number_format($salesStats['total_importer_revenue']) }}</h3>
                    <p class="mb-0 text-muted">إجمالي الإيرادات</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ number_format($taskStats['total']) }}</h3>
                    <p class="mb-0 text-muted">المهام المخصصة</p>
                </div>
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

    <!-- إحصائيات المستوردين -->
    <div class="col-lg-4 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-industry me-2"></i>
                    إحصائيات المستوردين
                </h5>
            </div>
            <div class="card-body">
                @forelse($importerStats as $stat)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">{{ $stat->status === 'new' ? 'جدد' : ($stat->status === 'contacted' ? 'تم التواصل' : 'مؤهلين') }}</span>
                        <span class="fw-bold">{{ $stat->count }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-industry fa-3x mb-3"></i>
                    <p>لا توجد إحصائيات متاحة</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- طلبات المستوردين الحديثة -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-industry me-2"></i>
                    طلبات المستوردين الحديثة
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($recentImporterOrders as $order)
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $order->order_number ?? '#' . $order->id }}</h6>
                                <p class="mb-1 text-muted">{{ $order->importer->company_name ?? 'غير محدد' }}</p>
                                <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $order->status === 'new' ? 'primary' : ($order->status === 'completed' ? 'success' : 'info') }}">
                                    {{ $order->status === 'new' ? 'جديد' : ($order->status === 'completed' ? 'مكتمل' : 'قيد المعالجة') }}
                                </span>
                                <div class="mt-1">
                                    <strong>{{ number_format($order->final_cost) }} ريال</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-industry fa-3x mb-3"></i>
                        <p>لا توجد طلبات مستوردين حديثة</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- طلبات المستوردين الحديثة -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-industry me-2"></i>
                    طلبات المستوردين الحديثة
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($recentImporterOrders as $order)
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $order->order_number }}</h6>
                                <p class="mb-1 text-muted">{{ $order->importer->name ?? 'مستورد' }}</p>
                                <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $order->status === 'new' ? 'warning' : ($order->status === 'completed' ? 'success' : 'info') }}">
                                    {{ $order->status === 'new' ? 'جديد' : ($order->status === 'completed' ? 'مكتمل' : 'قيد المعالجة') }}
                                </span>
                                <div class="mt-1">
                                    <strong>{{ number_format($order->final_cost) }} ريال</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-industry fa-3x mb-3"></i>
                        <p>لا توجد طلبات مستوردين حديثة</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- المهام المخصصة -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tasks me-2 text-primary"></i>
                    المهام المخصصة
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($urgentTasks as $task)
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $task->title }}</h6>
                                <p class="mb-1 text-muted">{{ Str::limit($task->description, 100) }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'بدون تاريخ' }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $task->priority === 'urgent' ? 'danger' : ($task->priority === 'high' ? 'warning' : 'info') }}">
                                    {{ $task->priority === 'urgent' ? 'عاجل' : ($task->priority === 'high' ? 'عالي' : 'متوسط') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-tasks fa-3x mb-3 text-muted"></i>
                        <p>لا توجد مهام مخصصة</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- المستوردين الجدد -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-plus me-2"></i>
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
                        <i class="fas fa-user-plus fa-3x mb-3"></i>
                        <p>لا توجد مستوردين جدد</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- النشاط الأخير -->
<div class="row">
    <div class="col-12 mb-4">
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

<!-- أزرار سريعة -->
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    إجراءات سريعة
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('sales.importers') }}" class="btn btn-info w-100">
                            <i class="fas fa-industry me-2"></i>
                            المستوردين
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('sales.tasks') }}" class="btn btn-success w-100">
                            <i class="fas fa-tasks me-2"></i>
                            المهام
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="{{ route('sales.reports') }}" class="btn btn-warning w-100">
                            <i class="fas fa-chart-bar me-2"></i>
                            التقارير
                        </a>
                    </div>
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
const salesChart = new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: [
            'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو',
            'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'
        ],
        datasets: [{
            label: 'المبيعات (ريال)',
            data: [
                @foreach($monthlySales as $sale)
                {{ $sale->total ?? 0 }},
                @endforeach
            ],
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
</script>
@endpush
