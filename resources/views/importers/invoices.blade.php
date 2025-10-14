@extends('layouts.dashboard')

@section('title', 'الفواتير - لوحة تحكم المستورد')
@section('dashboard-title', 'لوحة المستورد')
@section('page-title', 'الفواتير')
@section('page-subtitle', 'إدارة ومتابعة فواتيرك')

@section('content')
<div class="container-fluid">
    <!-- إحصائيات الفواتير -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-file-invoice fa-2x text-primary me-3"></i>
                        <div>
                            <h4 class="mb-0">{{ $totalInvoices }}</h4>
                            <small class="text-muted">إجمالي الفواتير</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-money-bill-wave fa-2x text-success me-3"></i>
                        <div>
                            <h4 class="mb-0">{{ number_format($totalAmount, 2) }}</h4>
                            <small class="text-muted">إجمالي المبلغ (ريال)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-check-circle fa-2x text-info me-3"></i>
                        <div>
                            <h4 class="mb-0">{{ number_format($paidAmount, 2) }}</h4>
                            <small class="text-muted">المبلغ المدفوع (ريال)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-clock fa-2x text-warning me-3"></i>
                        <div>
                            <h4 class="mb-0">{{ number_format($pendingAmount, 2) }}</h4>
                            <small class="text-muted">المبلغ المعلق (ريال)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- فلاتر البحث -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <label for="statusFilter" class="form-label">فلتر حسب الحالة</label>
                            <select class="form-select" id="statusFilter" onchange="filterInvoices()">
                                <option value="">جميع الفواتير</option>
                                <option value="completed">مكتملة</option>
                                <option value="partially_paid">مدفوعة جزئياً</option>
                                <option value="paid">مدفوعة</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="dateFrom" class="form-label">من تاريخ</label>
                            <input type="date" class="form-control" id="dateFrom" onchange="filterInvoices()">
                        </div>
                        <div class="col-md-3">
                            <label for="dateTo" class="form-label">إلى تاريخ</label>
                            <input type="date" class="form-control" id="dateTo" onchange="filterInvoices()">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button class="btn btn-outline-secondary" onclick="resetFilters()">
                                    <i class="fas fa-undo me-1"></i>
                                    إعادة تعيين
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- جدول الفواتير -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-invoice me-2"></i>
                        قائمة الفواتير
                    </h5>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary" onclick="exportInvoices()">
                            <i class="fas fa-download me-1"></i>
                            تصدير
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="printInvoices()">
                            <i class="fas fa-print me-1"></i>
                            طباعة
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    @if($invoices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="invoicesTable">
                                <thead>
                                    <tr>
                                        <th>رقم الفاتورة</th>
                                        <th>رقم الطلب</th>
                                        <th>التاريخ</th>
                                        <th>المبلغ</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الاستحقاق</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoices as $invoice)
                                        <tr>
                                            <td>
                                                <strong>INV-{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                            </td>
                                            <td>
                                                <a href="{{ route('importers.orders') }}" class="text-decoration-none">
                                                    #{{ $invoice->order_number }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $invoice->created_at->format('Y-m-d') }}
                                                <br>
                                                <small class="text-muted">{{ $invoice->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ number_format($invoice->final_cost ?? $invoice->estimated_cost ?? ($invoice->quantity * 50), 2) }} ريال</strong>
                                            </td>
                                            <td>
                                                @switch($invoice->status)
                                                    @case('completed')
                                                        <span class="badge bg-success">مكتملة</span>
                                                        @break
                                                    @case('partially_paid')
                                                        <span class="badge bg-warning">مدفوعة جزئياً</span>
                                                        @break
                                                    @case('paid')
                                                        <span class="badge bg-info">مدفوعة</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $invoice->status }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                @php
                                                    $dueDate = $invoice->created_at->addDays(30);
                                                @endphp
                                                <span class="{{ $dueDate->isPast() && $invoice->status != 'paid' ? 'text-danger' : 'text-muted' }}">
                                                    {{ $dueDate->format('Y-m-d') }}
                                                </span>
                                                @if($dueDate->isPast() && $invoice->status != 'paid')
                                                    <br><small class="text-danger">متأخرة</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('importers.invoices.show', $invoice->id) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="عرض الفاتورة">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-success" 
                                                            onclick="downloadInvoice({{ $invoice->id }})" title="تحميل PDF">
                                                        <i class="fas fa-download"></i>
                                                    </button>
                                                    @if($invoice->status != 'paid')
                                                        <button type="button" class="btn btn-sm btn-outline-warning" 
                                                                onclick="markAsPaid({{ $invoice->id }})" title="تحديد كمدفوعة">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $invoices->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد فواتير</h5>
                            <p class="text-muted">لم يتم إنشاء أي فواتير بعد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal تأكيد الدفع -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تأكيد الدفع</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من أنك قمت بدفع هذه الفاتورة؟</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    سيتم تحديث حالة الفاتورة إلى "مدفوعة" وستظهر في التقارير المالية.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-success" onclick="confirmPayment()">
                    <i class="fas fa-check me-1"></i>
                    تأكيد الدفع
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentInvoiceId = null;

function filterInvoices() {
    const status = document.getElementById('statusFilter').value;
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    
    // إعادة تحميل الصفحة مع المعاملات
    const params = new URLSearchParams();
    if (status) params.append('status', status);
    if (dateFrom) params.append('date_from', dateFrom);
    if (dateTo) params.append('date_to', dateTo);
    
    window.location.href = '{{ route("importers.invoices") }}?' + params.toString();
}

function resetFilters() {
    document.getElementById('statusFilter').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    window.location.href = '{{ route("importers.invoices") }}';
}

function downloadInvoice(invoiceId) {
    // محاكاة تحميل الفاتورة
    alert('جاري تحميل الفاتورة رقم: ' + invoiceId);
    
    // يمكن إضافة منطق تحميل PDF فعلي
    // window.open('/importers/invoices/' + invoiceId + '/download', '_blank');
}

function markAsPaid(invoiceId) {
    currentInvoiceId = invoiceId;
    const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
    modal.show();
}

function confirmPayment() {
    if (currentInvoiceId) {
        // محاكاة تحديث حالة الدفع
        alert('تم تحديث حالة الفاتورة رقم: ' + currentInvoiceId + ' إلى مدفوعة');
        
        // يمكن إضافة AJAX call لتحديث الحالة
        // fetch('/importers/invoices/' + currentInvoiceId + '/mark-paid', {
        //     method: 'POST',
        //     headers: {
        //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //     }
        // }).then(() => location.reload());
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
        modal.hide();
    }
}

function exportInvoices() {
    // محاكاة تصدير الفواتير
    alert('جاري تصدير الفواتير...');
    
    // يمكن إضافة منطق تصدير فعلي
    // window.open('/importers/invoices/export', '_blank');
}

function printInvoices() {
    // طباعة الجدول
    const printContent = document.getElementById('invoicesTable').outerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>طباعة الفواتير</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: right; }
                    th { background-color: #f2f2f2; }
                </style>
            </head>
            <body>
                <h2>قائمة الفواتير</h2>
                ${printContent}
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

// تحديث تلقائي للإحصائيات كل دقيقة
setInterval(function() {
    // يمكن إضافة AJAX call لتحديث الإحصائيات
    console.log('تحديث إحصائيات الفواتير...');
}, 60000);
</script>
@endsection
