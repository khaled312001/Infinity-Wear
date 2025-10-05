@extends('layouts.dashboard')

@section('title', 'تفاصيل المعاملة المالية')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'تفاصيل المعاملة المالية')
@section('page-subtitle', 'عرض تفاصيل المعاملة رقم ' . $transaction->id)
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('content')
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-eye me-3 text-primary"></i>
                        تفاصيل المعاملة المالية
                    </h1>
                    <p class="text-muted mb-0">معاملة رقم #{{ $transaction->id }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.finance.transactions') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>
                        العودة للقائمة
                    </a>
                    <a href="{{ route('admin.finance.edit', $transaction) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-2"></i>
                        تعديل
                    </a>
                    <button type="button" class="btn btn-danger" onclick="deleteTransaction({{ $transaction->id }})">
                        <i class="fas fa-trash me-2"></i>
                        حذف
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- تفاصيل المعاملة -->
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        تفاصيل المعاملة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- نوع المعاملة -->
                        <div class="col-md-6 mb-4">
                            <div class="info-item">
                                <label class="info-label">نوع المعاملة</label>
                                <div class="info-value">
                                    <span class="badge badge-{{ $transaction->type === 'income' ? 'success' : 'danger' }} fs-6">
                                        <i class="fas fa-arrow-{{ $transaction->type === 'income' ? 'up' : 'down' }} me-1"></i>
                                        {{ $transaction->type === 'income' ? 'إيراد' : 'مصروف' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- المبلغ -->
                        <div class="col-md-6 mb-4">
                            <div class="info-item">
                                <label class="info-label">المبلغ</label>
                                <div class="info-value">
                                    <span class="amount-display {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}{{ number_format($transaction->amount, 2) }} ريال
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- الفئة -->
                        <div class="col-md-6 mb-4">
                            <div class="info-item">
                                <label class="info-label">الفئة</label>
                                <div class="info-value">
                                    <span class="badge bg-light text-dark fs-6">{{ $transaction->category }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- الحالة -->
                        <div class="col-md-6 mb-4">
                            <div class="info-item">
                                <label class="info-label">الحالة</label>
                                <div class="info-value">
                                    <span class="badge badge-{{ $transaction->status === 'completed' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'secondary') }} fs-6">
                                        {{ $transaction->status === 'completed' ? 'مكتملة' : ($transaction->status === 'pending' ? 'معلقة' : 'ملغية') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- تاريخ المعاملة -->
                        <div class="col-md-6 mb-4">
                            <div class="info-item">
                                <label class="info-label">تاريخ المعاملة</label>
                                <div class="info-value">
                                    <i class="fas fa-calendar-alt me-2 text-muted"></i>
                                    {{ $transaction->transaction_date->format('d/m/Y') }}
                                    <small class="text-muted d-block">{{ $transaction->transaction_date->format('H:i') }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- طريقة الدفع -->
                        <div class="col-md-6 mb-4">
                            <div class="info-item">
                                <label class="info-label">طريقة الدفع</label>
                                <div class="info-value">
                                    @if($transaction->payment_method)
                                        <span class="badge bg-info fs-6">{{ $transaction->payment_method }}</span>
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- المرجع -->
                        @if($transaction->reference_id)
                        <div class="col-md-6 mb-4">
                            <div class="info-item">
                                <label class="info-label">المرجع</label>
                                <div class="info-value">
                                    <span class="badge bg-secondary fs-6">{{ $transaction->reference_type }} #{{ $transaction->reference_id }}</span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- تاريخ الإنشاء -->
                        <div class="col-md-6 mb-4">
                            <div class="info-item">
                                <label class="info-label">تاريخ الإنشاء</label>
                                <div class="info-value">
                                    <i class="fas fa-clock me-2 text-muted"></i>
                                    {{ $transaction->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- الوصف -->
                    <div class="mb-4">
                        <div class="info-item">
                            <label class="info-label">الوصف</label>
                            <div class="info-value">
                                <p class="mb-0">{{ $transaction->description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- الملاحظات -->
                    @if($transaction->notes)
                    <div class="mb-4">
                        <div class="info-item">
                            <label class="info-label">ملاحظات إضافية</label>
                            <div class="info-value">
                                <div class="notes-box">
                                    <p class="mb-0">{{ $transaction->notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- معلومات إضافية -->
        <div class="col-lg-4">
            <!-- معلومات المنشئ -->
            <div class="dashboard-card mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2 text-primary"></i>
                        معلومات المنشئ
                    </h5>
                </div>
                <div class="card-body">
                    @if($transaction->createdBy)
                        <div class="d-flex align-items-center">
                            <div class="avatar me-3">
                                <i class="fas fa-user-circle fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">{{ $transaction->createdBy->name }}</h6>
                                <small class="text-muted">{{ $transaction->createdBy->email }}</small>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-user-slash fa-2x mb-2"></i>
                            <p class="mb-0">معلومات المنشئ غير متاحة</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- إجراءات سريعة -->
            <div class="dashboard-card mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2 text-primary"></i>
                        إجراءات سريعة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.finance.edit', $transaction) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>
                            تعديل المعاملة
                        </a>
                        
                        @if($transaction->status === 'pending')
                            <form method="POST" action="{{ route('admin.finance.update', $transaction) }}" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check me-2"></i>
                                    تأكيد المعاملة
                                </button>
                            </form>
                        @endif

                        @if($transaction->status === 'completed')
                            <form method="POST" action="{{ route('admin.finance.update', $transaction) }}" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="pending">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-clock me-2"></i>
                                    تعليق المعاملة
                                </button>
                            </form>
                        @endif

                        <button type="button" class="btn btn-danger" onclick="deleteTransaction({{ $transaction->id }})">
                            <i class="fas fa-trash me-2"></i>
                            حذف المعاملة
                        </button>
                    </div>
                </div>
            </div>

            <!-- معلومات النظام -->
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-cog me-2 text-primary"></i>
                        معلومات النظام
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <label class="info-label">معرف المعاملة</label>
                        <div class="info-value">
                            <code>{{ $transaction->id }}</code>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <label class="info-label">تاريخ الإنشاء</label>
                        <div class="info-value">
                            {{ $transaction->created_at->format('d/m/Y H:i:s') }}
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <label class="info-label">آخر تحديث</label>
                        <div class="info-value">
                            {{ $transaction->updated_at->format('d/m/Y H:i:s') }}
                        </div>
                    </div>
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
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>تحذير:</strong> هذا الإجراء لا يمكن التراجع عنه.
                    </div>
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

.info-item {
    margin-bottom: 1rem;
}

.info-label {
    font-weight: 600;
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    display: block;
}

.info-value {
    font-size: 1rem;
    color: #374151;
}

.amount-display {
    font-size: 1.5rem;
    font-weight: 700;
}

.badge {
    font-size: 0.875rem;
    padding: 0.5rem 0.75rem;
}

.badge-success {
    background-color: #10b981;
    color: white;
}

.badge-danger {
    background-color: #ef4444;
    color: white;
}

.badge-warning {
    background-color: #f59e0b;
    color: white;
}

.badge-secondary {
    background-color: #6b7280;
    color: white;
}

.notes-box {
    background-color: #f8f9fa;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 1rem;
}

.avatar {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn {
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border: none;
}

.btn-warning {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border: none;
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
}

.btn-success {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
}

.btn-outline-secondary {
    border: 2px solid #6b7280;
    color: #6b7280;
}

.btn-outline-secondary:hover {
    background-color: #6b7280;
    color: white;
}

code {
    background-color: #f3f4f6;
    color: #374151;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
<script>
function deleteTransaction(transactionId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/finance/transactions/${transactionId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// إضافة تأثيرات بصرية للأزرار
document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px)';
    });
    
    btn.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
});

// تأكيد تغيير حالة المعاملة
document.querySelectorAll('form[action*="update"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        const status = this.querySelector('input[name="status"]').value;
        const action = status === 'completed' ? 'تأكيد' : 'تعليق';
        
        if (!confirm(`هل أنت متأكد من ${action} هذه المعاملة؟`)) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
