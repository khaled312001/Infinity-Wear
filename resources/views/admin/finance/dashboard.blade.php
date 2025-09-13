@extends('layouts.app')

@section('title', 'لوحة التحكم المالية - Infinity Wear')

@section('styles')
<style>
    .finance-card {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 15px;
        padding: 25px;
        color: white;
        box-shadow: 0 10px 30px rgba(30, 58, 138, 0.2);
        transition: all 0.3s ease;
        border: none;
    }

    .finance-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(30, 58, 138, 0.3);
    }

    .finance-card.expense {
        background: linear-gradient(135deg, #dc2626, #ef4444);
    }

    .finance-card.profit {
        background: linear-gradient(135deg, #059669, #10b981);
    }

    .finance-card.neutral {
        background: linear-gradient(135deg, #6b7280, #9ca3af);
    }

    .finance-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .transaction-item {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
        border-left: 4px solid var(--primary-color);
        transition: all 0.3s ease;
    }

    .transaction-item:hover {
        transform: translateX(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .transaction-item.income {
        border-left-color: #10b981;
    }

    .transaction-item.expense {
        border-left-color: #ef4444;
    }

    .category-progress {
        margin-bottom: 15px;
    }

    .category-progress .progress {
        height: 8px;
        border-radius: 10px;
        background: #e5e7eb;
    }

    .category-progress .progress-bar {
        border-radius: 10px;
    }

    .quick-actions {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
    }

    .quick-action-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        box-shadow: 0 5px 20px rgba(30, 58, 138, 0.3);
        margin-bottom: 10px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quick-action-btn:hover {
        transform: scale(1.1);
        color: white;
    }

    @media (max-width: 768px) {
        .finance-card {
            margin-bottom: 20px;
        }
        
        .quick-actions {
            bottom: 20px;
            right: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-chart-line me-3 text-primary"></i>
                        لوحة التحكم المالية
                    </h1>
                    <p class="text-muted mb-0">إدارة الإيرادات والمصروفات</p>
                </div>
                <div>
                    <a href="{{ route('admin.finance.create') }}" class="btn btn-primary me-2">
                        <i class="fas fa-plus me-2"></i>
                        معاملة جديدة
                    </a>
                    <a href="{{ route('admin.finance.reports') }}" class="btn btn-outline-primary">
                        <i class="fas fa-file-alt me-2"></i>
                        التقارير
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات سريعة -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="finance-card" data-aos="fade-up">
                <div class="finance-icon">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <h3 class="mb-1">{{ number_format($stats['monthly_revenue'], 2) }} ريال</h3>
                <p class="mb-0">إيرادات هذا الشهر</p>
                <small class="opacity-75">
                    <i class="fas fa-calendar-alt me-1"></i>
                    {{ Carbon\Carbon::now()->format('F Y') }}
                </small>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="finance-card expense" data-aos="fade-up" data-aos-delay="100">
                <div class="finance-icon">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <h3 class="mb-1">{{ number_format($stats['monthly_expenses'], 2) }} ريال</h3>
                <p class="mb-0">مصروفات هذا الشهر</p>
                <small class="opacity-75">
                    <i class="fas fa-calendar-alt me-1"></i>
                    {{ Carbon\Carbon::now()->format('F Y') }}
                </small>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="finance-card profit" data-aos="fade-up" data-aos-delay="200">
                <div class="finance-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="mb-1">{{ number_format($stats['monthly_profit'], 2) }} ريال</h3>
                <p class="mb-0">صافي الربح الشهري</p>
                <small class="opacity-75">
                    @if($stats['monthly_profit'] > 0)
                        <i class="fas fa-arrow-up text-success me-1"></i>ربح
                    @elseif($stats['monthly_profit'] < 0)
                        <i class="fas fa-arrow-down text-danger me-1"></i>خسارة
                    @else
                        <i class="fas fa-minus text-warning me-1"></i>متوازن
                    @endif
                </small>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="finance-card neutral" data-aos="fade-up" data-aos-delay="300">
                <div class="finance-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <h3 class="mb-1">{{ number_format($stats['yearly_stats']['transactions_count']) }}</h3>
                <p class="mb-0">إجمالي المعاملات</p>
                <small class="opacity-75">
                    <i class="fas fa-calendar me-1"></i>
                    هذا العام
                </small>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- الرسم البياني -->
        <div class="col-lg-8 mb-4">
            <div class="chart-container" data-aos="fade-up">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        الإيرادات والمصروفات الشهرية
                    </h5>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary active" onclick="updateChart('monthly')">شهري</button>
                        <button class="btn btn-sm btn-outline-primary" onclick="updateChart('yearly')">سنوي</button>
                    </div>
                </div>
                <canvas id="financeChart" height="300"></canvas>
            </div>
        </div>

        <!-- أحدث المعاملات -->
        <div class="col-lg-4 mb-4">
            <div class="chart-container" data-aos="fade-up" data-aos-delay="100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2 text-primary"></i>
                        أحدث المعاملات
                    </h5>
                    <a href="{{ route('admin.finance.transactions') }}" class="btn btn-sm btn-outline-primary">
                        عرض الكل
                    </a>
                </div>
                
                @forelse($recentTransactions as $transaction)
                    <div class="transaction-item {{ $transaction->type }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ Str::limit($transaction->description, 40) }}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $transaction->transaction_date->format('d/m/Y') }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $transaction->type === 'income' ? 'success' : 'danger' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }} ريال
                                </span>
                                <div class="mt-1">
                                    <span class="badge bg-{{ $transaction->status === 'completed' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'secondary') }}">
                                        {{ $transaction->status === 'completed' ? 'مكتملة' : ($transaction->status === 'pending' ? 'معلقة' : 'ملغية') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-inbox fa-2x mb-3"></i>
                        <p>لا توجد معاملات حديثة</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- إحصائيات الفئات -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="chart-container" data-aos="fade-up">
                <h5 class="mb-4">
                    <i class="fas fa-arrow-up me-2 text-success"></i>
                    إيرادات حسب الفئة
                </h5>
                
                @forelse($incomeCategories as $category)
                    <div class="category-progress">
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $category->category }}</span>
                            <span class="text-success fw-bold">{{ number_format($category->total, 2) }} ريال</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" 
                                 style="width: {{ $incomeCategories->max('total') > 0 ? ($category->total / $incomeCategories->max('total')) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <p>لا توجد إيرادات مسجلة</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="chart-container" data-aos="fade-up" data-aos-delay="100">
                <h5 class="mb-4">
                    <i class="fas fa-arrow-down me-2 text-danger"></i>
                    مصروفات حسب الفئة
                </h5>
                
                @forelse($expenseCategories as $category)
                    <div class="category-progress">
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $category->category }}</span>
                            <span class="text-danger fw-bold">{{ number_format($category->total, 2) }} ريال</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-danger" 
                                 style="width: {{ $expenseCategories->max('total') > 0 ? ($category->total / $expenseCategories->max('total')) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <p>لا توجد مصروفات مسجلة</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- المعاملات المعلقة -->
    @if($pendingTransactions->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="chart-container" data-aos="fade-up">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">
                        <i class="fas fa-clock me-2 text-warning"></i>
                        المعاملات المعلقة
                    </h5>
                    <span class="badge bg-warning">{{ $pendingTransactions->count() }} معاملة</span>
                </div>
                
                <div class="row">
                    @foreach($pendingTransactions as $transaction)
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="transaction-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ Str::limit($transaction->description, 30) }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $transaction->transaction_date->format('d/m/Y') }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-{{ $transaction->type === 'income' ? 'success' : 'danger' }}">
                                            {{ number_format($transaction->amount, 2) }} ريال
                                        </span>
                                        <div class="mt-2">
                                            <a href="{{ route('admin.finance.show', $transaction) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- أزرار الإجراءات السريعة -->
<div class="quick-actions">
    <button class="quick-action-btn" onclick="location.href='{{ route('admin.finance.create') }}'" title="معاملة جديدة">
        <i class="fas fa-plus"></i>
    </button>
    <button class="quick-action-btn" onclick="location.href='{{ route('admin.finance.reports') }}'" title="التقارير">
        <i class="fas fa-chart-pie"></i>
    </button>
    <button class="quick-action-btn" onclick="location.href='{{ route('admin.finance.transactions') }}'" title="جميع المعاملات">
        <i class="fas fa-list"></i>
    </button>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // بيانات الرسم البياني
    const chartData = @json($chartData);
    
    // إنشاء الرسم البياني
    const ctx = document.getElementById('financeChart').getContext('2d');
    const financeChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.map(item => item.month_name_ar),
            datasets: [
                {
                    label: 'الإيرادات',
                    data: chartData.map(item => item.revenue),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'المصروفات',
                    data: chartData.map(item => item.expenses),
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'صافي الربح',
                    data: chartData.map(item => item.profit),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: false,
                    tension: 0.4
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

    // تحديث الرسم البياني
    function updateChart(type) {
        // تحديث الأزرار النشطة
        document.querySelectorAll('.btn-group .btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');

        // يمكن إضافة منطق تحديث البيانات هنا
        console.log('تحديث الرسم البياني إلى:', type);
    }

    // تحديث البيانات كل 5 دقائق
    setInterval(function() {
        fetch('/admin/finance/quick-stats')
            .then(response => response.json())
            .then(data => {
                console.log('تحديث الإحصائيات:', data);
                // يمكن تحديث الإحصائيات في الصفحة هنا
            })
            .catch(error => {
                console.log('خطأ في تحديث الإحصائيات:', error);
            });
    }, 300000); // 5 دقائق
</script>
@endsection