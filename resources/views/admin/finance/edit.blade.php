@extends('layouts.dashboard')

@section('title', 'تعديل المعاملة المالية')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'تعديل المعاملة المالية')
@section('page-subtitle', 'تعديل معاملة رقم ' . $transaction->id)
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

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2 text-primary"></i>
                            تعديل المعاملة المالية
                        </h5>
                        <div>
                            <a href="{{ route('admin.finance.show', $transaction) }}" class="btn btn-outline-info me-2">
                                <i class="fas fa-eye me-2"></i>
                                عرض
                            </a>
                            <a href="{{ route('admin.finance.transactions') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                العودة
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.finance.update', $transaction) }}" method="POST" id="transactionForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- نوع المعاملة -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">نوع المعاملة <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-card">
                                            <input class="form-check-input" type="radio" name="type" id="income" value="income" 
                                                   {{ $transaction->type === 'income' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="income">
                                                <div class="card border-success">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-arrow-up fa-2x text-success mb-2"></i>
                                                        <h6 class="card-title text-success">إيراد</h6>
                                                        <p class="card-text small text-muted">دخل أو مبيعات</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-card">
                                            <input class="form-check-input" type="radio" name="type" id="expense" value="expense" 
                                                   {{ $transaction->type === 'expense' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="expense">
                                                <div class="card border-danger">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-arrow-down fa-2x text-danger mb-2"></i>
                                                        <h6 class="card-title text-danger">مصروف</h6>
                                                        <p class="card-text small text-muted">تكلفة أو نفقة</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- الفئة -->
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">الفئة <span class="text-danger">*</span></label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">اختر الفئة</option>
                                    <optgroup label="الإيرادات" id="income-categories" style="{{ $transaction->type === 'income' ? '' : 'display: none;' }}">
                                        @foreach($incomeCategories as $category)
                                            <option value="{{ $category }}" {{ $transaction->category === $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="المصروفات" id="expense-categories" style="{{ $transaction->type === 'expense' ? '' : 'display: none;' }}">
                                        @foreach($expenseCategories as $category)
                                            <option value="{{ $category }}" {{ $transaction->category === $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('category')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- المبلغ -->
                            <div class="col-md-6 mb-3">
                                <label for="amount" class="form-label">المبلغ (ريال) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="amount" name="amount" 
                                           step="0.01" min="0.01" value="{{ $transaction->amount }}" required>
                                    <span class="input-group-text">ريال</span>
                                </div>
                                @error('amount')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- الوصف -->
                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3" 
                                      placeholder="وصف تفصيلي للمعاملة" required>{{ $transaction->description }}</textarea>
                            @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- تاريخ المعاملة -->
                            <div class="col-md-6 mb-3">
                                <label for="transaction_date" class="form-label">تاريخ المعاملة <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="transaction_date" name="transaction_date" 
                                       value="{{ $transaction->transaction_date->format('Y-m-d') }}" required>
                                @error('transaction_date')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- طريقة الدفع -->
                            <div class="col-md-6 mb-3">
                                <label for="payment_method" class="form-label">طريقة الدفع</label>
                                <select class="form-select" id="payment_method" name="payment_method">
                                    <option value="">اختر طريقة الدفع</option>
                                    @foreach($paymentMethods as $method)
                                        <option value="{{ $method }}" {{ $transaction->payment_method === $method ? 'selected' : '' }}>
                                            {{ $method }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('payment_method')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- الحالة -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">الحالة <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="completed" {{ $transaction->status === 'completed' ? 'selected' : '' }}>مكتملة</option>
                                    <option value="pending" {{ $transaction->status === 'pending' ? 'selected' : '' }}>معلقة</option>
                                    <option value="cancelled" {{ $transaction->status === 'cancelled' ? 'selected' : '' }}>ملغية</option>
                                </select>
                                @error('status')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- المرجع -->
                            <div class="col-md-6 mb-3">
                                <label for="reference_type" class="form-label">نوع المرجع</label>
                                <select class="form-select" id="reference_type" name="reference_type">
                                    <option value="general" {{ $transaction->reference_type === 'general' ? 'selected' : '' }}>عام</option>
                                    <option value="order" {{ $transaction->reference_type === 'order' ? 'selected' : '' }}>طلب</option>
                                    <option value="invoice" {{ $transaction->reference_type === 'invoice' ? 'selected' : '' }}>فاتورة</option>
                                    <option value="refund" {{ $transaction->reference_type === 'refund' ? 'selected' : '' }}>استرداد</option>
                                </select>
                                @error('reference_type')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- معرف المرجع -->
                        @if($transaction->reference_id)
                        <div class="mb-3">
                            <label for="reference_id" class="form-label">معرف المرجع</label>
                            <input type="text" class="form-control" id="reference_id" name="reference_id" 
                                   value="{{ $transaction->reference_id }}" placeholder="معرف المرجع">
                            @error('reference_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        <!-- ملاحظات -->
                        <div class="mb-4">
                            <label for="notes" class="form-label">ملاحظات إضافية</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" 
                                      placeholder="أي ملاحظات إضافية حول المعاملة">{{ $transaction->notes }}</textarea>
                            @error('notes')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- أزرار الإجراءات -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.finance.show', $transaction) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>
                                إلغاء
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.form-check-card {
    margin-bottom: 0;
}

.form-check-card .form-check-input {
    position: absolute;
    opacity: 0;
}

.form-check-card .form-check-input:checked + .form-check-label .card {
    border-width: 2px;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-check-card .form-check-label {
    cursor: pointer;
    width: 100%;
}

.form-check-card .card {
    transition: all 0.3s ease;
    border: 2px solid #e9ecef;
}

.form-check-card .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

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

.card-body {
    padding: 2rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
}

.btn {
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const categorySelect = document.getElementById('category');
    const incomeCategories = document.getElementById('income-categories');
    const expenseCategories = document.getElementById('expense-categories');

    // تحديث الفئات عند تغيير نوع المعاملة
    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'income') {
                incomeCategories.style.display = 'block';
                expenseCategories.style.display = 'none';
            } else if (this.value === 'expense') {
                incomeCategories.style.display = 'none';
                expenseCategories.style.display = 'block';
            }
        });
    });

    // تنسيق المبلغ
    const amountInput = document.getElementById('amount');
    amountInput.addEventListener('input', function() {
        let value = this.value;
        if (value && !isNaN(value)) {
            this.value = parseFloat(value).toFixed(2);
        }
    });

    // التحقق من صحة النموذج قبل الإرسال
    document.getElementById('transactionForm').addEventListener('submit', function(e) {
        const type = document.querySelector('input[name="type"]:checked');
        const category = document.getElementById('category').value;
        const amount = document.getElementById('amount').value;
        const description = document.getElementById('description').value;

        if (!type || !category || !amount || !description) {
            e.preventDefault();
            alert('يرجى ملء جميع الحقول المطلوبة');
            return false;
        }

        if (parseFloat(amount) <= 0) {
            e.preventDefault();
            alert('المبلغ يجب أن يكون أكبر من صفر');
            return false;
        }
    });

    // إضافة تأثيرات بصرية للأزرار
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
@endpush
