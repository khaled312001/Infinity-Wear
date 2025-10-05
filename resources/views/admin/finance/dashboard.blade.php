@extends('layouts.dashboard')

@section('title', 'لوحة التحكم المالية')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'لوحة التحكم المالية')
@section('page-subtitle', 'إدارة الإيرادات والمصروفات')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection


@section('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    /* Enhanced Finance Cards */
    .finance-card {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border-radius: 20px;
        padding: 30px;
        color: white;
        box-shadow: 0 20px 40px rgba(30, 58, 138, 0.15);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .finance-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .finance-card:hover::before {
        opacity: 1;
    }

    .finance-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px rgba(30, 58, 138, 0.25);
    }

    .finance-card.expense {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
    }

    .finance-card.profit {
        background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
    }

    .finance-card.neutral {
        background: linear-gradient(135deg, #6b7280 0%, #9ca3af 50%, #d1d5db 100%);
    }

    .finance-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 20px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .finance-card:hover .finance-icon {
        transform: scale(1.1) rotate(5deg);
        background: rgba(255, 255, 255, 0.25);
    }

    /* Enhanced Chart Container */
    .chart-container {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .chart-container:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    /* Enhanced Transaction Items */
    .transaction-item {
        background: white;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border-left: 5px solid var(--primary-color);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .transaction-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.02) 0%, rgba(59, 130, 246, 0.01) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .transaction-item:hover::before {
        opacity: 1;
    }

    .transaction-item:hover {
        transform: translateX(-8px) translateY(-2px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        border-left-width: 6px;
    }

    .transaction-item.income {
        border-left-color: #10b981;
    }

    .transaction-item.income::before {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.02) 0%, rgba(16, 185, 129, 0.01) 100%);
    }

    .transaction-item.expense {
        border-left-color: #ef4444;
    }

    .transaction-item.expense::before {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.02) 0%, rgba(239, 68, 68, 0.01) 100%);
    }

    /* Enhanced Progress Bars */
    .category-progress {
        margin-bottom: 20px;
    }

    .category-progress .progress {
        height: 12px;
        border-radius: 15px;
        background: #f1f5f9;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .category-progress .progress-bar {
        border-radius: 15px;
        background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
        transition: width 0.6s ease;
    }

    .category-progress .progress-bar.bg-success {
        background: linear-gradient(90deg, #059669 0%, #10b981 100%);
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .category-progress .progress-bar.bg-danger {
        background: linear-gradient(90deg, #dc2626 0%, #ef4444 100%);
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    /* Enhanced Quick Actions */
    .quick-actions {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
    }

    .quick-action-btn {
        width: 65px;
        height: 65px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        border: none;
        box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);
        margin-bottom: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .quick-action-btn:hover {
        transform: scale(1.15) translateY(-3px);
        color: white;
        box-shadow: 0 12px 35px rgba(30, 58, 138, 0.4);
    }

    /* Enhanced Badges */
    .badge {
        border-radius: 12px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 0.85rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Enhanced Buttons */
    .btn {
        border-radius: 12px;
        font-weight: 600;
        padding: 12px 24px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border: none;
    }

    .btn-outline-primary {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        background: transparent;
    }

    .btn-outline-primary:hover {
        background: var(--primary-color);
        color: white;
    }

    /* Enhanced Typography */
    .h3 {
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .text-muted {
        opacity: 0.8;
    }

    /* Loading Animation */
    .loading-shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    /* Responsive Enhancements */
    @media (max-width: 768px) {
        .finance-card {
            margin-bottom: 20px;
            padding: 20px;
        }
        
        .finance-icon {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }
        
        .chart-container {
            padding: 20px;
        }
        
        .transaction-item {
            padding: 20px;
        }
        
        .quick-actions {
            bottom: 20px;
            right: 20px;
        }
        
        .quick-action-btn {
            width: 55px;
            height: 55px;
            font-size: 18px;
        }
    }

    @media (max-width: 576px) {
        .finance-card {
            padding: 16px;
        }
        
        .chart-container {
            padding: 16px;
        }
        
        .transaction-item {
            padding: 16px;
        }
    }

    /* Transaction Icons */
    .transaction-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: white;
    }

    .transaction-icon.income {
        background: linear-gradient(135deg, #10b981, #34d399);
    }

    .transaction-icon.expense {
        background: linear-gradient(135deg, #ef4444, #f87171);
    }

    /* Amount Badges */
    .amount-badge {
        font-weight: 700;
        font-size: 1.1rem;
        padding: 8px 16px;
        border-radius: 12px;
        color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .amount-badge.income {
        background: linear-gradient(135deg, #10b981, #34d399);
    }

    .amount-badge.expense {
        background: linear-gradient(135deg, #ef4444, #f87171);
    }

    /* Status Badges */
    .status-badge {
        font-size: 0.8rem;
        padding: 6px 12px;
        border-radius: 10px;
        font-weight: 600;
    }

    .status-badge.status-completed {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: white;
    }

    .status-badge.status-pending {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
        color: white;
    }

    .status-badge.status-cancelled {
        background: linear-gradient(135deg, #6b7280, #9ca3af);
        color: white;
    }

    /* Empty State */
    .empty-state {
        padding: 2rem;
    }

    /* Scrollbar Styling */
    .transactions-list::-webkit-scrollbar {
        width: 6px;
    }

    .transactions-list::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .transactions-list::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 10px;
    }

    .transactions-list::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, var(--dark-color), var(--primary-color));
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .chart-container {
            background: #1f2937;
            border-color: #374151;
        }
        
        .transaction-item {
            background: #1f2937;
            border-color: #374151;
        }

        .transactions-list::-webkit-scrollbar-track {
            background: #374151;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Enhanced Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="me-4">
                        <div class="finance-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); margin-bottom: 0;">
                            <i class="fas fa-chart-line text-white" style="font-size: 32px;"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="h2 mb-2 fw-bold text-dark">
                            لوحة التحكم المالية
                        </h1>
                        <p class="text-muted mb-0 fs-5">
                            <i class="fas fa-calendar-alt me-2"></i>
                            {{ Carbon\Carbon::now()->format('d F Y') }}
                        </p>
                        <p class="text-muted mb-0">إدارة الإيرادات والمصروفات بشكل ذكي</p>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <a href="{{ route('admin.finance.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        معاملة جديدة
                    </a>
                    <a href="{{ route('admin.finance.reports') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-file-alt me-2"></i>
                        التقارير
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog me-2"></i>
                            المزيد
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.finance.transactions') }}">
                                <i class="fas fa-list me-2"></i>جميع المعاملات
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.finance.export') }}">
                                <i class="fas fa-download me-2"></i>تصدير البيانات
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>الإعدادات
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Statistics Cards -->
    <div class="row mb-5">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="finance-card" data-aos="fade-up" data-aos-duration="800">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="finance-icon">
                        <i class="fas fa-trending-up"></i>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-light text-success">
                            <i class="fas fa-arrow-up me-1"></i>
                            +12.5%
                        </span>
                    </div>
                </div>
                <h2 class="mb-2 fw-bold">{{ number_format($stats['monthly_revenue'], 2) }} ريال</h2>
                <p class="mb-2 fs-6">إيرادات هذا الشهر</p>
                <div class="d-flex align-items-center">
                    <i class="fas fa-calendar-alt me-2 opacity-75"></i>
                    <small class="opacity-75">{{ Carbon\Carbon::now()->format('F Y') }}</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="finance-card expense" data-aos="fade-up" data-aos-delay="100" data-aos-duration="800">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="finance-icon">
                        <i class="fas fa-trending-down"></i>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-light text-danger">
                            <i class="fas fa-arrow-up me-1"></i>
                            +8.2%
                        </span>
                    </div>
                </div>
                <h2 class="mb-2 fw-bold">{{ number_format($stats['monthly_expenses'], 2) }} ريال</h2>
                <p class="mb-2 fs-6">مصروفات هذا الشهر</p>
                <div class="d-flex align-items-center">
                    <i class="fas fa-calendar-alt me-2 opacity-75"></i>
                    <small class="opacity-75">{{ Carbon\Carbon::now()->format('F Y') }}</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="finance-card profit" data-aos="fade-up" data-aos-delay="200" data-aos-duration="800">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="finance-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="text-end">
                        @if($stats['monthly_profit'] > 0)
                            <span class="badge bg-light text-success">
                                <i class="fas fa-arrow-up me-1"></i>
                                ربح
                            </span>
                        @elseif($stats['monthly_profit'] < 0)
                            <span class="badge bg-light text-danger">
                                <i class="fas fa-arrow-down me-1"></i>
                                خسارة
                            </span>
                        @else
                            <span class="badge bg-light text-warning">
                                <i class="fas fa-minus me-1"></i>
                                متوازن
                            </span>
                        @endif
                    </div>
                </div>
                <h2 class="mb-2 fw-bold">{{ number_format($stats['monthly_profit'], 2) }} ريال</h2>
                <p class="mb-2 fs-6">صافي الربح الشهري</p>
                <div class="d-flex align-items-center">
                    <i class="fas fa-chart-pie me-2 opacity-75"></i>
                    <small class="opacity-75">تحليل الأداء</small>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="finance-card neutral" data-aos="fade-up" data-aos-delay="300" data-aos-duration="800">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="finance-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-light text-info">
                            <i class="fas fa-chart-bar me-1"></i>
                            نشط
                        </span>
                    </div>
                </div>
                <h2 class="mb-2 fw-bold">{{ number_format($stats['yearly_stats']['transactions_count']) }}</h2>
                <p class="mb-2 fs-6">إجمالي المعاملات</p>
                <div class="d-flex align-items-center">
                    <i class="fas fa-calendar me-2 opacity-75"></i>
                    <small class="opacity-75">هذا العام</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Enhanced Chart Section -->
        <div class="col-lg-8 mb-4">
            <div class="chart-container" data-aos="fade-up" data-aos-duration="1000">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-1 fw-bold text-dark">
                            <i class="fas fa-chart-line me-3 text-primary"></i>
                            الإيرادات والمصروفات الشهرية
                        </h4>
                        <p class="text-muted mb-0">تحليل الأداء المالي الشهري</p>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-primary active" onclick="updateChart('monthly')">
                                <i class="fas fa-calendar-alt me-1"></i>شهري
                            </button>
                            <button class="btn btn-sm btn-outline-primary" onclick="updateChart('yearly')">
                                <i class="fas fa-calendar me-1"></i>سنوي
                            </button>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-download me-1"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="exportChart('png')">
                                    <i class="fas fa-image me-2"></i>PNG
                                </a></li>
                                <li><a class="dropdown-item" href="#" onclick="exportChart('pdf')">
                                    <i class="fas fa-file-pdf me-2"></i>PDF
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="position-relative">
                    <canvas id="financeChart" height="350"></canvas>
                    <div id="chartLoading" class="position-absolute top-50 start-50 translate-middle text-center" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">جاري التحميل...</span>
                        </div>
                        <p class="mt-2 text-muted">جاري تحميل البيانات...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Recent Transactions -->
        <div class="col-lg-4 mb-4">
            <div class="chart-container" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-1 fw-bold text-dark">
                            <i class="fas fa-history me-3 text-primary"></i>
                            أحدث المعاملات
                        </h4>
                        <p class="text-muted mb-0">آخر 10 معاملات مالية</p>
                    </div>
                    <a href="{{ route('admin.finance.transactions') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-external-link-alt me-1"></i>
                        عرض الكل
                    </a>
                </div>
                
                <div class="transactions-list" style="max-height: 500px; overflow-y: auto;">
                    @forelse($recentTransactions as $transaction)
                        <div class="transaction-item {{ $transaction->type }}" data-aos="fade-left" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="me-3">
                                            <div class="transaction-icon {{ $transaction->type }}">
                                                <i class="fas fa-{{ $transaction->type === 'income' ? 'arrow-up' : 'arrow-down' }}"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-semibold">{{ Str::limit($transaction->description, 35) }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ $transaction->transaction_date->format('d/m/Y') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-light text-dark me-2">
                                            <i class="fas fa-tag me-1"></i>
                                            {{ $transaction->category }}
                                        </span>
                                        @if($transaction->payment_method)
                                            <span class="badge bg-light text-secondary">
                                                <i class="fas fa-credit-card me-1"></i>
                                                {{ $transaction->payment_method }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="amount-badge {{ $transaction->type }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }} ريال
                                    </div>
                                    <div class="mt-2">
                                        <span class="status-badge status-{{ $transaction->status }}">
                                            @if($transaction->status === 'completed')
                                                <i class="fas fa-check-circle me-1"></i>مكتملة
                                            @elseif($transaction->status === 'pending')
                                                <i class="fas fa-clock me-1"></i>معلقة
                                            @else
                                                <i class="fas fa-times-circle me-1"></i>ملغية
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <div class="empty-state">
                                <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                                <h5 class="mb-2">لا توجد معاملات حديثة</h5>
                                <p class="mb-3">ابدأ بإضافة معاملة مالية جديدة</p>
                                <a href="{{ route('admin.finance.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>
                                    إضافة معاملة
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
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
                                 style="width: {{ $incomeCategories->max('total') > 0 ? round(($category->total / $incomeCategories->max('total')) * 100, 1) : 0 }}%">
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
                                 style="width: {{ $expenseCategories->max('total') > 0 ? round(($category->total / $expenseCategories->max('total')) * 100, 1) : 0 }}%">
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
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS animations
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

    // Chart data
    const chartData = @json($chartData);
    
    // Enhanced chart configuration
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
                    borderWidth: 4,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#10b981',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 4
                },
                {
                    label: 'المصروفات',
                    data: chartData.map(item => item.expenses),
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderWidth: 4,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ef4444',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#ef4444',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 4
                },
                {
                    label: 'صافي الربح',
                    data: chartData.map(item => item.profit),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 4,
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#3b82f6',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            family: 'Cairo',
                            size: 14,
                            weight: '600'
                        },
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: 'rgba(255, 255, 255, 0.2)',
                    borderWidth: 1,
                    cornerRadius: 12,
                    padding: 12,
                    titleFont: {
                        family: 'Cairo',
                        size: 14,
                        weight: '600'
                    },
                    bodyFont: {
                        family: 'Cairo',
                        size: 13
                    },
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
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: 'Cairo',
                            size: 12
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            family: 'Cairo',
                            size: 12
                        },
                        callback: function(value) {
                            return new Intl.NumberFormat('ar-SA', {
                                style: 'currency',
                                currency: 'SAR',
                                minimumFractionDigits: 0
                            }).format(value);
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });

    // Enhanced chart update function
    function updateChart(type) {
        // Show loading indicator
        document.getElementById('chartLoading').style.display = 'block';
        
        // Update active buttons
        document.querySelectorAll('.btn-group .btn').forEach(btn => {
            btn.classList.remove('active', 'btn-primary');
            btn.classList.add('btn-outline-primary');
        });
        event.target.classList.add('active', 'btn-primary');
        event.target.classList.remove('btn-outline-primary');

        // Simulate data loading
        setTimeout(() => {
            document.getElementById('chartLoading').style.display = 'none';
            console.log('تم تحديث الرسم البياني إلى:', type);
            
            // Here you would typically fetch new data and update the chart
            // For now, we'll just show a success message
            showNotification('تم تحديث البيانات بنجاح', 'success');
        }, 1500);
    }

    // Chart export function
    function exportChart(format) {
        const link = document.createElement('a');
        link.download = `finance-chart-${new Date().toISOString().split('T')[0]}.${format}`;
        link.href = financeChart.toBase64Image();
        link.click();
        
        showNotification(`تم تصدير الرسم البياني بصيغة ${format.toUpperCase()}`, 'success');
    }

    // Notification system
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 3000);
    }

    // Auto-refresh data every 5 minutes
    setInterval(function() {
        fetch('/admin/finance/quick-stats')
            .then(response => response.json())
            .then(data => {
                console.log('تحديث الإحصائيات:', data);
                // Update statistics cards here if needed
                showNotification('تم تحديث البيانات تلقائياً', 'info');
            })
            .catch(error => {
                console.log('خطأ في تحديث الإحصائيات:', error);
            });
    }, 300000); // 5 minutes

    // Add smooth scrolling for transaction list
    document.querySelectorAll('.transaction-item').forEach((item, index) => {
        item.style.animationDelay = `${index * 0.1}s`;
    });

    // Add hover effects to finance cards
    document.querySelectorAll('.finance-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endsection