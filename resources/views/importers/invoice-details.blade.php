@extends('layouts.dashboard')

@section('title', 'تفاصيل الفاتورة - لوحة تحكم المستورد')
@section('dashboard-title', 'لوحة المستورد')
@section('page-title', 'تفاصيل الفاتورة')
@section('page-subtitle', 'عرض تفاصيل الفاتورة والمدفوعات')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <!-- تفاصيل الفاتورة -->
            <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-invoice me-2"></i>
                        فاتورة رقم INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                    </h5>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary" onclick="printInvoice()">
                            <i class="fas fa-print me-1"></i>
                            طباعة
                        </button>
                        <button class="btn btn-sm btn-outline-success" onclick="downloadPDF()">
                            <i class="fas fa-download me-1"></i>
                            تحميل PDF
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- معلومات الشركة والعميل -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">من:</h6>
                            <div class="border rounded p-3">
                                <h5 class="mb-1">إنفينيتي وير</h5>
                                <p class="mb-1">شركة سعودية رائدة في تصميم وإنتاج الملابس الرياضية</p>
                                <p class="mb-1"><i class="fas fa-phone me-2"></i>+966500982394</p>
                                <p class="mb-1"><i class="fas fa-envelope me-2"></i>info@infinitywear.sa</p>
                                <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>الرياض، حي النخيل، المملكة العربية السعودية</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">إلى:</h6>
                            <div class="border rounded p-3">
                                <h5 class="mb-1">{{ $importer->name }}</h5>
                                <p class="mb-1">{{ $importer->company_name }}</p>
                                <p class="mb-1"><i class="fas fa-phone me-2"></i>{{ $importer->phone }}</p>
                                <p class="mb-1"><i class="fas fa-envelope me-2"></i>{{ $importer->email }}</p>
                                @if($importer->address)
                                    <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>{{ $importer->address }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- تفاصيل الفاتورة -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>رقم الفاتورة:</strong></td>
                                    <td>INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>رقم الطلب:</strong></td>
                                    <td>#{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>تاريخ الفاتورة:</strong></td>
                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>تاريخ الاستحقاق:</strong></td>
                                    <td>{{ $order->created_at->addDays(30)->format('Y-m-d') }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>حالة الفاتورة:</strong></td>
                                    <td>
                                        @switch($order->status)
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
                                                <span class="badge bg-secondary">{{ $order->status }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>طريقة الدفع:</strong></td>
                                    <td>تحويل بنكي</td>
                                </tr>
                                <tr>
                                    <td><strong>البنك:</strong></td>
                                    <td>البنك الأهلي السعودي</td>
                                </tr>
                                <tr>
                                    <td><strong>رقم الحساب:</strong></td>
                                    <td>SA1234567890123456789012</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <!-- تفاصيل الطلب -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">تفاصيل الطلب:</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>الوصف</th>
                                        <th>الكمية</th>
                                        <th>سعر الوحدة</th>
                                        <th>المجموع</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>ملابس رياضية مخصصة</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($order->requirements, 100) }}</small>
                                        </td>
                                        <td>{{ $order->quantity }}</td>
                                        <td>50.00 ريال</td>
                                        <td>{{ number_format($order->quantity * 50, 2) }} ريال</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>المجموع الفرعي:</strong></td>
                                        <td><strong>{{ number_format($order->quantity * 50, 2) }} ريال</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>ضريبة القيمة المضافة (15%):</strong></td>
                                        <td><strong>{{ number_format(($order->quantity * 50) * 0.15, 2) }} ريال</strong></td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td colspan="3" class="text-end"><strong>المجموع الكلي:</strong></td>
                                        <td><strong>{{ number_format(($order->quantity * 50) * 1.15, 2) }} ريال</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <!-- ملاحظات -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">ملاحظات:</h6>
                        <div class="border rounded p-3 bg-light">
                            <p class="mb-2">
                                <strong>شروط الدفع:</strong> الدفع خلال 30 يوم من تاريخ الفاتورة
                            </p>
                            <p class="mb-2">
                                <strong>شروط التسليم:</strong> سيتم تسليم الطلب خلال 7-14 يوم عمل
                            </p>
                            <p class="mb-0">
                                <strong>ملاحظة:</strong> في حالة التأخير في الدفع، قد يتم تطبيق رسوم تأخير
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- حالة الدفع -->
            <div class="dashboard-card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-credit-card me-2"></i>
                        حالة الدفع
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="text-center mb-3">
                        @switch($order->status)
                            @case('paid')
                                <i class="fas fa-check-circle fa-3x text-success mb-2"></i>
                                <h5 class="text-success">مدفوعة بالكامل</h5>
                                @break
                            @case('partially_paid')
                                <i class="fas fa-clock fa-3x text-warning mb-2"></i>
                                <h5 class="text-warning">مدفوعة جزئياً</h5>
                                @break
                            @default
                                <i class="fas fa-exclamation-circle fa-3x text-danger mb-2"></i>
                                <h5 class="text-danger">غير مدفوعة</h5>
                        @endswitch
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>المبلغ المطلوب:</span>
                            <strong>{{ number_format(($order->quantity * 50) * 1.15, 2) }} ريال</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>المبلغ المدفوع:</span>
                            <strong>{{ number_format($order->status == 'paid' ? ($order->quantity * 50) * 1.15 : 0, 2) }} ريال</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>المبلغ المتبقي:</span>
                            <strong class="{{ $order->status == 'paid' ? 'text-success' : 'text-danger' }}">
                                {{ number_format($order->status == 'paid' ? 0 : ($order->quantity * 50) * 1.15, 2) }} ريال
                            </strong>
                        </div>
                    </div>
                    
                    @if($order->status != 'paid')
                        <div class="d-grid gap-2">
                            <button class="btn btn-success" onclick="markAsPaid()">
                                <i class="fas fa-check me-2"></i>
                                تحديد كمدفوعة
                            </button>
                            <button class="btn btn-outline-primary" onclick="sendReminder()">
                                <i class="fas fa-bell me-2"></i>
                                إرسال تذكير
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- معلومات إضافية -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        معلومات إضافية
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">نوع النشاط</label>
                        <p class="mb-0">
                            @switch($importer->business_type)
                                @case('academy')
                                    أكاديمية
                                    @break
                                @case('school')
                                    مدرسة
                                    @break
                                @case('store')
                                    متجر
                                    @break
                                @case('hospital')
                                    مستشفى
                                    @break
                                @case('other')
                                    {{ $importer->business_type_other ?? 'أخرى' }}
                                    @break
                            @endswitch
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">المدينة</label>
                        <p class="mb-0">{{ $importer->city ?? 'غير محدد' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">تاريخ إنشاء الطلب</label>
                        <p class="mb-0">{{ $order->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">آخر تحديث</label>
                        <p class="mb-0">{{ $order->updated_at->format('Y-m-d H:i') }}</p>
                    </div>
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
function printInvoice() {
    const printContent = document.querySelector('.dashboard-card').outerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>فاتورة رقم INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</title>
                <style>
                    body { font-family: Arial, sans-serif; direction: rtl; }
                    .card { border: none; box-shadow: none; }
                    .card-header { background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; }
                    .table { border-collapse: collapse; width: 100%; }
                    .table th, .table td { border: 1px solid #dee2e6; padding: 8px; text-align: right; }
                    .table-light { background-color: #f8f9fa; }
                    .table-primary { background-color: #cfe2ff; }
                    .btn { display: none; }
                </style>
            </head>
            <body>
                ${printContent}
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

function downloadPDF() {
    alert('جاري تحميل الفاتورة كملف PDF...');
    // يمكن إضافة منطق تحميل PDF فعلي
}

function markAsPaid() {
    const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
    modal.show();
}

function confirmPayment() {
    alert('تم تحديث حالة الفاتورة إلى مدفوعة');
    // يمكن إضافة AJAX call لتحديث الحالة
    // location.reload();
    
    const modal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
    modal.hide();
}

function sendReminder() {
    alert('تم إرسال تذكير بالدفع');
    // يمكن إضافة منطق إرسال تذكير فعلي
}
</script>
@endsection
