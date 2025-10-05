@extends('layouts.dashboard')

@section('title', 'المعاملات المالية')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'المعاملات المالية')
@section('page-subtitle', 'عرض وإدارة جميع المعاملات المالية')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Enhanced Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="me-4">
                        <div class="finance-icon" style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); margin-bottom: 0; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-list text-white" style="font-size: 24px;"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="h3 mb-1 fw-bold text-dark">
                            المعاملات المالية
                        </h1>
                        <p class="text-muted mb-0">عرض وإدارة جميع المعاملات المالية</p>
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ Carbon\Carbon::now()->format('d F Y') }}
                        </small>
                    </div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.finance.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        معاملة جديدة
                    </a>
                    <a href="{{ route('admin.finance.reports') }}" class="btn btn-outline-primary">
                        <i class="fas fa-chart-bar me-2"></i>
                        التقارير
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog me-2"></i>
                            المزيد
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.finance.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>لوحة التحكم
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="exportTransactions('excel')">
                                <i class="fas fa-file-excel me-2"></i>تصدير Excel
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="exportTransactions('pdf')">
                                <i class="fas fa-file-pdf me-2"></i>تصدير PDF
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-filter me-2"></i>
                            فلاتر البحث
                        </h5>
                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
                <div class="collapse show" id="filterCollapse">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.finance.transactions') }}" id="filterForm">
                            <div class="row g-3">
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-exchange-alt me-1 text-primary"></i>
                                        نوع المعاملة
                                    </label>
                                    <select name="type" class="form-select">
                                        <option value="">جميع الأنواع</option>
                                        <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>إيرادات</option>
                                        <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>مصروفات</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-tags me-1 text-primary"></i>
                                        الفئة
                                    </label>
                                    <select name="category" class="form-select">
                                        <option value="">جميع الفئات</option>
                                        @foreach($incomeCategories as $category)
                                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                        @foreach($expenseCategories as $category)
                                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-info-circle me-1 text-primary"></i>
                                        الحالة
                                    </label>
                                    <select name="status" class="form-select">
                                        <option value="">جميع الحالات</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتملة</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>معلقة</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغية</option>
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-calendar-alt me-1 text-primary"></i>
                                        من تاريخ
                                    </label>
                                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                </div>
                            </div>
                            <div class="row g-3 mt-2">
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-calendar-alt me-1 text-primary"></i>
                                        إلى تاريخ
                                    </label>
                                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-search me-1 text-primary"></i>
                                        البحث
                                    </label>
                                    <input type="text" name="search" class="form-control" placeholder="البحث في الوصف..." value="{{ request('search') }}">
                                </div>
                                <div class="col-lg-6 col-md-12 d-flex align-items-end gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>
                                        تطبيق الفلاتر
                                    </button>
                                    <a href="{{ route('admin.finance.transactions') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>
                                        مسح الفلاتر
                                    </a>
                                    <button type="button" class="btn btn-outline-info" onclick="saveFilterPreset()">
                                        <i class="fas fa-save me-2"></i>
                                        حفظ الفلتر
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    @if($transactions->count() > 0)
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card bg-gradient-success text-white">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ number_format($transactions->where('type', 'income')->sum('amount'), 2) }} ريال</h4>
                        <small>إجمالي الإيرادات</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card bg-gradient-danger text-white">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ number_format($transactions->where('type', 'expense')->sum('amount'), 2) }} ريال</h4>
                        <small>إجمالي المصروفات</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card bg-gradient-info text-white">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $transactions->where('status', 'completed')->count() }}</h4>
                        <small>معاملات مكتملة</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stats-card bg-gradient-warning text-white">
                <div class="d-flex align-items-center">
                    <div class="stats-icon me-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $transactions->where('status', 'pending')->count() }}</h4>
                        <small>معاملات معلقة</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Enhanced Transactions Table -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-table me-2"></i>
                            قائمة المعاملات
                        </h5>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-light text-dark">
                                إجمالي: {{ $transactions->total() }} معاملة
                            </span>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-light" onclick="exportTransactions('excel')" title="تصدير Excel">
                                    <i class="fas fa-file-excel me-1"></i>
                                    Excel
                                </button>
                                <button type="button" class="btn btn-sm btn-light" onclick="exportTransactions('pdf')" title="تصدير PDF">
                                    <i class="fas fa-file-pdf me-1"></i>
                                    PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($transactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>النوع</th>
                                        <th>الفئة</th>
                                        <th>الوصف</th>
                                        <th>المبلغ</th>
                                        <th>الحالة</th>
                                        <th>طريقة الدفع</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold">{{ $transaction->transaction_date->format('d/m/Y') }}</span>
                                                    <small class="text-muted">{{ $transaction->transaction_date->format('H:i') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $transaction->type === 'income' ? 'success' : 'danger' }}">
                                                    <i class="fas fa-arrow-{{ $transaction->type === 'income' ? 'up' : 'down' }} me-1"></i>
                                                    {{ $transaction->type === 'income' ? 'إيراد' : 'مصروف' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $transaction->category }}</span>
                                            </td>
                                            <td>
                                                <div class="transaction-description">
                                                    <span class="fw-medium">{{ Str::limit($transaction->description, 50) }}</span>
                                                    @if($transaction->notes)
                                                        <br><small class="text-muted">{{ Str::limit($transaction->notes, 30) }}</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-{{ $transaction->type === 'income' ? 'success' : 'danger' }}">
                                                    {{ $transaction->type === 'income' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }} ريال
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $transaction->status === 'completed' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'secondary') }}">
                                                    {{ $transaction->status === 'completed' ? 'مكتملة' : ($transaction->status === 'pending' ? 'معلقة' : 'ملغية') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($transaction->payment_method)
                                                    <span class="badge bg-info">{{ $transaction->payment_method }}</span>
                                                @else
                                                    <span class="text-muted">غير محدد</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.finance.show', $transaction) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="عرض">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.finance.edit', $transaction) }}" 
                                                       class="btn btn-sm btn-outline-warning" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger delete-transaction-btn" 
                                                            data-transaction-id="{{ $transaction->id }}" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="card-footer bg-white border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    عرض {{ $transactions->firstItem() }} إلى {{ $transactions->lastItem() }} من {{ $transactions->total() }} معاملة
                                </div>
                                <div>
                                    {{ $transactions->links() }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد معاملات</h5>
                            <p class="text-muted">لم يتم العثور على معاملات تطابق المعايير المحددة</p>
                            <a href="{{ route('admin.finance.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                إضافة معاملة جديدة
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تأكيد الحذف</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من حذف هذه المعاملة؟</p>
                    <p class="text-danger small">هذا الإجراء لا يمكن التراجع عنه.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Enhanced Finance Styles */
    .dashboard-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .dashboard-card:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .card-header {
        border-radius: 20px 20px 0 0 !important;
        padding: 1.5rem;
        border: none;
    }

    .bg-gradient-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important;
    }

    .bg-gradient-success {
        background: linear-gradient(135deg, #10b981, #059669) !important;
    }

    .bg-gradient-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
    }

    .bg-gradient-info {
        background: linear-gradient(135deg, #06b6d4, #0891b2) !important;
    }

    .bg-gradient-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706) !important;
    }

    .stats-card {
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: none;
    }

    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }

    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }

    .table th {
        border-top: none;
        font-weight: 600;
        color: #374151;
        background-color: #f8f9fa;
        padding: 1rem 0.75rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .table td {
        vertical-align: middle;
        border-color: #e5e7eb;
        padding: 1rem 0.75rem;
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8fafc;
        transform: scale(1.01);
    }

    .transaction-description {
        max-width: 200px;
    }

    .btn-group .btn {
        border-radius: 8px;
        margin: 0 2px;
        transition: all 0.2s ease;
    }

    .btn-group .btn:hover {
        transform: translateY(-1px);
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-weight: 600;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        transform: translateY(-1px);
    }

    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border: none;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
    }

    .btn-outline-primary {
        border: 2px solid #3b82f6;
        color: #3b82f6;
        background: transparent;
    }

    .btn-outline-primary:hover {
        background: #3b82f6;
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-secondary {
        border: 2px solid #6b7280;
        color: #6b7280;
        background: transparent;
    }

    .btn-outline-secondary:hover {
        background: #6b7280;
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-info {
        border: 2px solid #06b6d4;
        color: #06b6d4;
        background: transparent;
    }

    .btn-outline-info:hover {
        background: #06b6d4;
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-warning {
        border: 2px solid #f59e0b;
        color: #f59e0b;
        background: transparent;
    }

    .btn-outline-warning:hover {
        background: #f59e0b;
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-danger {
        border: 2px solid #ef4444;
        color: #ef4444;
        background: transparent;
    }

    .btn-outline-danger:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-1px);
    }

    .finance-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    /* Enhanced Modal Styles */
    .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .modal-header {
        border-bottom: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border-radius: 20px 20px 0 0;
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
        .dashboard-card {
            border-radius: 15px;
        }
        
        .stats-card {
            padding: 1rem;
        }
        
        .stats-icon {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }
        
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .btn-group .btn {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        .dashboard-card {
            background: #1f2937;
            border-color: #374151;
        }
        
        .table th {
            background-color: #374151;
            color: #f9fafb;
        }
        
        .table td {
            color: #f9fafb;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Enhanced Finance Transactions JavaScript
    
    function deleteTransaction(transactionId) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/admin/finance/transactions/${transactionId}`;
        
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    function exportTransactions(format) {
        showNotification('جاري تصدير البيانات...', 'info');
        
        const form = document.getElementById('filterForm');
        const action = form.action;
        
        // إضافة معامل التصدير
        const url = new URL(action);
        url.searchParams.set('export', format);
        
        // فتح الرابط في نافذة جديدة
        window.open(url.toString(), '_blank');
        
        setTimeout(() => {
            showNotification(`تم تصدير البيانات بصيغة ${format.toUpperCase()}`, 'success');
        }, 2000);
    }

    function saveFilterPreset() {
        const form = document.getElementById('filterForm');
        const formData = new FormData(form);
        const filters = {};
        
        for (let [key, value] of formData.entries()) {
            if (value) filters[key] = value;
        }
        
        localStorage.setItem('finance_filters', JSON.stringify(filters));
        showNotification('تم حفظ إعدادات الفلتر', 'success');
    }

    function loadFilterPreset() {
        const savedFilters = localStorage.getItem('finance_filters');
        if (savedFilters) {
            const filters = JSON.parse(savedFilters);
            const form = document.getElementById('filterForm');
            
            Object.keys(filters).forEach(key => {
                const element = form.querySelector(`[name="${key}"]`);
                if (element) {
                    element.value = filters[key];
                }
            });
        }
    }

    // Show notification function
    function showNotification(message, type = 'info') {
        const alertClass = {
            'success': 'alert-success',
            'error': 'alert-danger',
            'warning': 'alert-warning',
            'info': 'alert-info'
        }[type] || 'alert-info';

        const icon = {
            'success': 'fas fa-check-circle',
            'error': 'fas fa-exclamation-circle',
            'warning': 'fas fa-exclamation-triangle',
            'info': 'fas fa-info-circle'
        }[type] || 'fas fa-info-circle';

        const alert = document.createElement('div');
        alert.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alert.innerHTML = `
            <i class="${icon} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(alert);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Load saved filters
        loadFilterPreset();
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Add event listeners for delete buttons
        document.querySelectorAll('.delete-transaction-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const transactionId = this.getAttribute('data-transaction-id');
                deleteTransaction(transactionId);
            });
        });

        // Add enhanced hover effects to table rows
        document.querySelectorAll('.table tbody tr').forEach((row, index) => {
            row.style.transition = 'all 0.2s ease';
            row.style.animationDelay = `${index * 0.05}s`;
            
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8fafc';
                this.style.transform = 'scale(1.01)';
                this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.1)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
                this.style.transform = 'scale(1)';
                this.style.boxShadow = 'none';
            });
        });

        // Add animation to stats cards
        document.querySelectorAll('.stats-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate__animated', 'animate__fadeInUp');
        });

        // Auto-refresh functionality
        setInterval(function() {
            // Check for new transactions (you can implement this with AJAX)
            console.log('Checking for new transactions...');
        }, 30000); // Every 30 seconds
    });

    // Enhanced filter form handling
    document.getElementById('filterForm').addEventListener('change', function() {
        // Auto-save filter changes
        const formData = new FormData(this);
        const filters = {};
        
        for (let [key, value] of formData.entries()) {
            if (value) filters[key] = value;
        }
        
        localStorage.setItem('finance_filters', JSON.stringify(filters));
    });

    // Quick filter buttons
    function applyQuickFilter(type) {
        const form = document.getElementById('filterForm');
        const typeSelect = form.querySelector('[name="type"]');
        
        if (typeSelect) {
            typeSelect.value = type;
            form.submit();
        }
    }

    // Add quick filter buttons to the page
    document.addEventListener('DOMContentLoaded', function() {
        const filterContainer = document.querySelector('.card-body');
        if (filterContainer) {
            const quickFilters = document.createElement('div');
            quickFilters.className = 'mb-3';
            quickFilters.innerHTML = `
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-sm btn-outline-success" onclick="applyQuickFilter('income')">
                        <i class="fas fa-arrow-up me-1"></i>الإيرادات فقط
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="applyQuickFilter('expense')">
                        <i class="fas fa-arrow-down me-1"></i>المصروفات فقط
                    </button>
                    <button class="btn btn-sm btn-outline-warning" onclick="applyQuickFilter('')">
                        <i class="fas fa-list me-1"></i>جميع المعاملات
                    </button>
                </div>
            `;
            filterContainer.insertBefore(quickFilters, filterContainer.firstChild);
        }
    });

    // Enhanced search functionality
    document.querySelector('[name="search"]').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('.table tbody tr');
        
        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
                row.style.animation = 'fadeIn 0.3s ease';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Add fadeIn animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
