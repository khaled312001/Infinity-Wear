@extends('layouts.dashboard')

@section('title', 'التقارير المالية')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'التقارير المالية')
@section('page-subtitle', 'تقارير مفصلة عن الإيرادات والمصروفات')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('content')
<style>
    .finance-reports-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    
    .reports-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .stats-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2);
    }
    
    .finance-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .finance-icon::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));
        border-radius: 20px;
    }
    
    .finance-icon i {
        position: relative;
        z-index: 1;
        font-size: 2rem;
    }
    
    .chart-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .table-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
    }
    
    .modern-table {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .modern-table thead th {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 1.5rem 1rem;
        font-weight: 600;
        text-align: center;
    }
    
    .modern-table tbody td {
        border: none;
        padding: 1.5rem 1rem;
        text-align: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .modern-table tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: scale(1.01);
    }
    
    .btn-modern {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        border-radius: 15px;
        padding: 0.75rem 2rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .btn-outline-modern {
        border: 2px solid #667eea;
        border-radius: 15px;
        padding: 0.75rem 2rem;
        color: #667eea;
        font-weight: 600;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
    }
    
    .btn-outline-modern:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }
    
    .form-control-modern {
        border: 2px solid rgba(102, 126, 234, 0.2);
        border-radius: 15px;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
    }
    
    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        background: white;
    }
    
    .badge-modern {
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .text-gradient {
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }
    
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .floating-elements {
        position: absolute;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }
    
    .floating-elements:nth-child(1) {
        top: 10%;
        left: 10%;
        animation-delay: 0s;
    }
    
    .floating-elements:nth-child(2) {
        top: 20%;
        right: 10%;
        animation-delay: 2s;
    }
    
    .floating-elements:nth-child(3) {
        bottom: 20%;
        left: 20%;
        animation-delay: 4s;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
</style>

<div class="finance-reports-container">
    <div class="floating-elements"></div>
    <div class="floating-elements"></div>
    <div class="floating-elements"></div>
    
    <div class="container-fluid">
        <!-- Enhanced Header -->
        <div class="reports-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2 text-gradient">
                        <i class="fas fa-chart-line me-3"></i>
                        التقارير المالية
                    </h1>
                    <p class="text-muted mb-0 fs-5">تقارير مفصلة عن الإيرادات والمصروفات والأرباح</p>
                </div>
                <div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-modern" onclick="exportReport('excel')">
                            <i class="fas fa-file-excel me-2"></i>
                            تصدير Excel
                        </button>
                        <button type="button" class="btn btn-outline-modern" onclick="exportReport('pdf')">
                            <i class="fas fa-file-pdf me-2"></i>
                            تصدير PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Year Selector -->
        <div class="stats-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-3 text-gradient">
                        <i class="fas fa-calendar-alt me-2"></i>
                        فلترة التقارير
                    </h5>
                    <form method="GET" action="{{ route('admin.finance.reports') }}" class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">السنة</label>
                            <select name="year" class="form-control-modern" onchange="this.form.submit()">
                                @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">الشهر</label>
                            <select name="month" class="form-control-modern" onchange="this.form.submit()">
                                <option value="">جميع الأشهر</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->locale('ar')->monthName }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-modern w-100">
                                <i class="fas fa-filter me-2"></i>
                                تطبيق الفلتر
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 text-center">
                    <div class="pulse-animation">
                        <i class="fas fa-chart-pie fa-3x text-gradient"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Summary Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="text-center">
                        <div class="finance-icon" style="background: linear-gradient(135deg, #28a745, #20c997);">
                            <i class="fas fa-arrow-up fa-2x text-white"></i>
                        </div>
                        <h2 class="mt-3 mb-2 text-success fw-bold">{{ number_format($yearlyStats['revenue'], 2) }} ريال</h2>
                        <p class="text-muted mb-2 fs-5">إجمالي الإيرادات</p>
                        <span class="badge badge-modern bg-success">{{ $year }}</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="text-center">
                        <div class="finance-icon" style="background: linear-gradient(135deg, #dc3545, #fd7e14);">
                            <i class="fas fa-arrow-down fa-2x text-white"></i>
                        </div>
                        <h2 class="mt-3 mb-2 text-danger fw-bold">{{ number_format($yearlyStats['expenses'], 2) }} ريال</h2>
                        <p class="text-muted mb-2 fs-5">إجمالي المصروفات</p>
                        <span class="badge badge-modern bg-danger">{{ $year }}</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="text-center">
                        <div class="finance-icon {{ $yearlyStats['profit'] >= 0 ? 'bg-success' : 'bg-danger' }}" 
                             style="background: linear-gradient(135deg, {{ $yearlyStats['profit'] >= 0 ? '#28a745, #20c997' : '#dc3545, #fd7e14' }});">
                            <i class="fas fa-chart-line fa-2x text-white"></i>
                        </div>
                        <h2 class="mt-3 mb-2 {{ $yearlyStats['profit'] >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                            {{ number_format($yearlyStats['profit'], 2) }} ريال
                        </h2>
                        <p class="text-muted mb-2 fs-5">صافي الربح</p>
                        <span class="badge badge-modern {{ $yearlyStats['profit'] >= 0 ? 'bg-success' : 'bg-danger' }}">{{ $year }}</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="text-center">
                        <div class="finance-icon" style="background: linear-gradient(135deg, #17a2b8, #6f42c1);">
                            <i class="fas fa-exchange-alt fa-2x text-white"></i>
                        </div>
                        <h2 class="mt-3 mb-2 text-info fw-bold">{{ number_format($yearlyStats['transactions_count']) }}</h2>
                        <p class="text-muted mb-2 fs-5">إجمالي المعاملات</p>
                        <span class="badge badge-modern bg-info">{{ $year }}</span>
                    </div>
                </div>
            </div>
        </div>

    <!-- Growth Comparison -->
    @if($previousYearStats['revenue'] > 0 || $previousYearStats['expenses'] > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2 text-primary"></i>
                        مقارنة مع السنة الماضية
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <h6 class="text-muted">نمو الإيرادات</h6>
                                <h4 class="{{ $growth['revenue'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    <i class="fas fa-arrow-{{ $growth['revenue'] >= 0 ? 'up' : 'down' }} me-1"></i>
                                    {{ number_format($growth['revenue'], 1) }}%
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h6 class="text-muted">نمو المصروفات</h6>
                                <h4 class="{{ $growth['expenses'] >= 0 ? 'text-danger' : 'text-success' }}">
                                    <i class="fas fa-arrow-{{ $growth['expenses'] >= 0 ? 'up' : 'down' }} me-1"></i>
                                    {{ number_format($growth['expenses'], 1) }}%
                                </h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h6 class="text-muted">نمو الربح</h6>
                                <h4 class="{{ $growth['profit'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    <i class="fas fa-arrow-{{ $growth['profit'] >= 0 ? 'up' : 'down' }} me-1"></i>
                                    {{ number_format($growth['profit'], 1) }}%
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Monthly Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        الإيرادات والمصروفات الشهرية - {{ $year }}
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Breakdown -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-arrow-up me-2 text-success"></i>
                        الإيرادات حسب الفئة
                    </h5>
                </div>
                <div class="card-body">
                    @if($incomeByCategory->count() > 0)
                        @foreach($incomeByCategory as $category)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-medium">{{ $category->category }}</span>
                                        <span class="text-success fw-bold">{{ number_format($category->total, 2) }} ريال</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" 
                                             style="width: {{ $incomeByCategory->max('total') > 0 ? round(($category->total / $incomeByCategory->max('total')) * 100, 1) : 0 }}%">
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $category->count }} معاملة</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-3"></i>
                            <p>لا توجد إيرادات مسجلة</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-arrow-down me-2 text-danger"></i>
                        المصروفات حسب الفئة
                    </h5>
                </div>
                <div class="card-body">
                    @if($expenseByCategory->count() > 0)
                        @foreach($expenseByCategory as $category)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-medium">{{ $category->category }}</span>
                                        <span class="text-danger fw-bold">{{ number_format($category->total, 2) }} ريال</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-danger" 
                                             style="width: {{ $expenseByCategory->max('total') > 0 ? round(($category->total / $expenseByCategory->max('total')) * 100, 1) : 0 }}%">
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $category->count }} معاملة</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-3"></i>
                            <p>لا توجد مصروفات مسجلة</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Statistics Table -->
    <div class="row">
        <div class="col-12">
        <!-- Enhanced Monthly Statistics Table -->
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-gradient mb-0">
                    <i class="fas fa-chart-bar me-3"></i>
                    الإحصائيات الشهرية - {{ $year }}
                </h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-modern btn-sm" onclick="exportTable('excel')">
                        <i class="fas fa-file-excel me-1"></i>
                        Excel
                    </button>
                    <button class="btn btn-outline-modern btn-sm" onclick="exportTable('pdf')">
                        <i class="fas fa-file-pdf me-1"></i>
                        PDF
                    </button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-calendar me-2"></i>الشهر</th>
                            <th><i class="fas fa-arrow-up me-2"></i>الإيرادات</th>
                            <th><i class="fas fa-arrow-down me-2"></i>المصروفات</th>
                            <th><i class="fas fa-chart-line me-2"></i>صافي الربح</th>
                            <th><i class="fas fa-receipt me-2"></i>عدد المعاملات</th>
                            <th><i class="fas fa-percentage me-2"></i>معدل الربحية</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlyStats as $monthData)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-calendar-alt text-primary"></i>
                                        </div>
                                        <span class="fw-bold">{{ $monthData['month_name_ar'] }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fas fa-arrow-up text-success me-2"></i>
                                        <span class="text-success fw-bold fs-5">{{ number_format($monthData['revenue'], 2) }} ريال</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fas fa-arrow-down text-danger me-2"></i>
                                        <span class="text-danger fw-bold fs-5">{{ number_format($monthData['expenses'], 2) }} ريال</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fas fa-{{ $monthData['profit'] >= 0 ? 'trending-up' : 'trending-down' }} {{ $monthData['profit'] >= 0 ? 'text-success' : 'text-danger' }} me-2"></i>
                                        <span class="fw-bold fs-5 {{ $monthData['profit'] >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($monthData['profit'], 2) }} ريال
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-modern bg-info fs-6">{{ $monthData['transactions_count'] }}</span>
                                </td>
                                <td>
                                    @if($monthData['revenue'] > 0)
                                        <span class="badge badge-modern bg-{{ $monthData['profit_margin'] >= 0 ? 'success' : 'danger' }} fs-6">
                                            <i class="fas fa-percentage me-1"></i>
                                            {{ number_format($monthData['profit_margin'], 1) }}%
                                        </span>
                                    @else
                                        <span class="text-muted fs-5">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.dashboard-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    border: none;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    padding: 1.5rem;
}

.finance-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #374151;
    background-color: #f8f9fa;
}

.table td {
    vertical-align: middle;
    border-color: #e5e7eb;
}

.progress {
    border-radius: 10px;
    background-color: #e5e7eb;
}

.progress-bar {
    border-radius: 10px;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 2px solid #e5e7eb;
}

.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
}

.btn {
    border-radius: 8px;
    font-weight: 600;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    transform: translateY(-1px);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// بيانات الرسم البياني الشهري
const monthlyData = @json($chartData);

// إنشاء الرسم البياني الشهري
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
const monthlyChart = new Chart(monthlyCtx, {
    type: 'bar',
    data: {
        labels: monthlyData.map(item => item.month_name_ar),
        datasets: [
            {
                label: 'الإيرادات',
                data: monthlyData.map(item => item.revenue),
                backgroundColor: 'rgba(16, 185, 129, 0.8)',
                borderColor: '#10b981',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            },
            {
                label: 'المصروفات',
                data: monthlyData.map(item => item.expenses),
                backgroundColor: 'rgba(239, 68, 68, 0.8)',
                borderColor: '#ef4444',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            },
            {
                label: 'صافي الربح',
                data: monthlyData.map(item => item.profit),
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: '#3b82f6',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    font: {
                        family: 'Cairo'
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': ' + 
                               new Intl.NumberFormat('ar-SA', {
                                   style: 'currency',
                                   currency: 'SAR'
                               }).format(context.parsed.y);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return new Intl.NumberFormat('ar-SA', {
                            style: 'currency',
                            currency: 'SAR',
                            minimumFractionDigits: 0
                        }).format(value);
                    }
                }
            }
        }
    }
});

// تصدير التقارير
function exportReport(format) {
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.set('export', format);
    window.open(currentUrl.toString(), '_blank');
}

// إضافة تأثيرات بصرية للجدول
document.querySelectorAll('.table tbody tr').forEach(row => {
    row.addEventListener('mouseenter', function() {
        this.style.backgroundColor = '#f8f9fa';
    });
    
    row.addEventListener('mouseleave', function() {
        this.style.backgroundColor = '';
    });
});
</script>
@endpush
