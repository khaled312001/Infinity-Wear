@extends('layouts.dashboard')

@section('title', 'طلبات المستوردين')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0">
                    <i class="fas fa-shopping-cart me-2 text-primary"></i>
                    طلبات المستوردين
                </h2>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="statusFilter">
                        <option value="">جميع الحالات</option>
                        <option value="new">جديد</option>
                        <option value="processing">قيد المعالجة</option>
                        <option value="completed">مكتمل</option>
                        <option value="cancelled">ملغي</option>
                    </select>
                    <select class="form-select form-select-sm" id="designTypeFilter">
                        <option value="">جميع أنواع التصميم</option>
                        <option value="text">وصف نصي</option>
                        <option value="upload">رفع ملف</option>
                        <option value="template">قالب جاهز</option>
                        <option value="ai">ذكاء اصطناعي</option>
                    </select>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="dashboard-card">
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="ordersTable">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>المستورد</th>
                                        <th>نوع التصميم</th>
                                        <th>الكمية</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الطلب</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <strong>{{ $order->order_number }}</strong>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <i class="fas fa-user text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $order->importer->name }}</h6>
                                                    <small class="text-muted">{{ $order->importer->company_name }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $designDetails = is_string($order->design_details) ? json_decode($order->design_details, true) : $order->design_details;
                                                $designType = $designDetails['option'] ?? 'غير محدد';
                                            @endphp
                                            <span class="badge bg-info">
                                                @switch($designType)
                                                    @case('text')
                                                        <i class="fas fa-font me-1"></i>وصف نصي
                                                        @break
                                                    @case('upload')
                                                        <i class="fas fa-upload me-1"></i>رفع ملف
                                                        @break
                                                    @case('template')
                                                        <i class="fas fa-image me-1"></i>قالب جاهز
                                                        @break
                                                    @case('ai')
                                                        <i class="fas fa-robot me-1"></i>ذكاء اصطناعي
                                                        @break
                                                    @default
                                                        غير محدد
                                                @endswitch
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ number_format($order->quantity) }} قطعة</span>
                                        </td>
                                        <td>
                                            <select class="form-select form-select-sm status-select" data-order-id="{{ $order->id }}">
                                                <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>جديد</option>
                                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                            </select>
                                        </td>
                                        <td>
                                            <small>{{ $order->created_at->format('Y-m-d H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <a href="{{ route('admin.importers.show', $order->importer->id) }}" class="btn btn-outline-info">
                                                    <i class="fas fa-user"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Order Details Modal -->
                                    <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">تفاصيل الطلب {{ $order->order_number }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6>معلومات المستورد:</h6>
                                                            <p><strong>الاسم:</strong> {{ $order->importer->name }}</p>
                                                            <p><strong>الشركة:</strong> {{ $order->importer->company_name }}</p>
                                                            <p><strong>البريد:</strong> {{ $order->importer->email }}</p>
                                                            <p><strong>الهاتف:</strong> {{ $order->importer->phone }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6>معلومات الطلب:</h6>
                                                            <p><strong>الكمية:</strong> {{ number_format($order->quantity) }} قطعة</p>
                                                            <p><strong>الحالة:</strong> {{ $order->status_label }}</p>
                                                            <p><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <hr>
                                                    
                                                    <h6>متطلبات الطلب:</h6>
                                                    <div class="p-3 bg-light rounded">
                                                        {{ $order->requirements }}
                                                    </div>
                                                    
                                                    <hr>
                                                    
                                                    <h6>تفاصيل التصميم:</h6>
                                                    <div class="p-3 bg-light rounded">
                                                        @php
                                                            $designDetails = is_string($order->design_details) ? json_decode($order->design_details, true) : $order->design_details;
                                                        @endphp
                                                        
                                                        @if(isset($designDetails['option']))
                                                            <p><strong>نوع التصميم:</strong> 
                                                                @switch($designDetails['option'])
                                                                    @case('text')
                                                                        وصف نصي
                                                                        @break
                                                                    @case('upload')
                                                                        رفع ملف
                                                                        @break
                                                                    @case('template')
                                                                        قالب جاهز
                                                                        @break
                                                                    @case('ai')
                                                                        ذكاء اصطناعي
                                                                        @break
                                                                @endswitch
                                                            </p>
                                                            
                                                            @switch($designDetails['option'])
                                                                @case('text')
                                                                    <p><strong>وصف التصميم:</strong></p>
                                                                    <p>{{ $designDetails['text'] ?? 'غير محدد' }}</p>
                                                                    @break
                                                                    
                                                                @case('upload')
                                                                    @if(isset($designDetails['file_path']))
                                                                        <p><strong>الملف المرفوع:</strong></p>
                                                                        <a href="{{ Storage::url($designDetails['file_path']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                            <i class="fas fa-download me-1"></i>تحميل الملف
                                                                        </a>
                                                                    @endif
                                                                    @if(isset($designDetails['notes']))
                                                                        <p><strong>ملاحظات:</strong> {{ $designDetails['notes'] }}</p>
                                                                    @endif
                                                                    @break
                                                                    
                                                                @case('template')
                                                                    <p><strong>القالب المختار:</strong> {{ $designDetails['template'] ?? 'غير محدد' }}</p>
                                                                    @if(isset($designDetails['notes']))
                                                                        <p><strong>تعديلات مطلوبة:</strong> {{ $designDetails['notes'] }}</p>
                                                                    @endif
                                                                    @break
                                                                    
                                                                @case('ai')
                                                                    <p><strong>الوصف الأصلي:</strong></p>
                                                                    <p>{{ $designDetails['prompt'] ?? 'غير محدد' }}</p>
                                                                    <p><strong>النمط:</strong> {{ $designDetails['style'] ?? 'غير محدد' }}</p>
                                                                    
                                                                    @if(isset($designDetails['ai_enhanced_description']))
                                                                        <div class="mt-3 p-3 bg-primary text-white rounded">
                                                                            <h6><i class="fas fa-robot me-1"></i>الوصف المحسن:</h6>
                                                                            <p class="mb-0">{{ $designDetails['ai_enhanced_description'] }}</p>
                                                                        </div>
                                                                    @endif
                                                                    
                                                                    @if(isset($designDetails['ai_error']))
                                                                        <div class="mt-3 p-3 bg-warning rounded">
                                                                            <p class="mb-0"><i class="fas fa-exclamation-triangle me-1"></i>{{ $designDetails['ai_error'] }}</p>
                                                                        </div>
                                                                    @endif
                                                                    @break
                                                            @endswitch
                                                        @else
                                                            <p class="text-muted">لا توجد تفاصيل تصميم متاحة</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد طلبات</h5>
                            <p class="text-muted">لم يتم تقديم أي طلبات من المستوردين بعد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Status filter
    $('#statusFilter').change(function() {
        const status = $(this).val();
        filterTable();
    });
    
    // Design type filter
    $('#designTypeFilter').change(function() {
        const designType = $(this).val();
        filterTable();
    });
    
    // Status update
    $('.status-select').change(function() {
        const orderId = $(this).data('order-id');
        const newStatus = $(this).val();
        
        $.ajax({
            url: '{{ route("admin.orders.updateStatus", ":id") }}'.replace(':id', orderId),
            method: 'PUT',
            data: {
                status: newStatus,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showAlert('تم تحديث حالة الطلب بنجاح', 'success');
                } else {
                    showAlert('حدث خطأ في تحديث الحالة', 'error');
                }
            },
            error: function() {
                showAlert('حدث خطأ في الاتصال', 'error');
            }
        });
    });
    
    function filterTable() {
        const status = $('#statusFilter').val();
        const designType = $('#designTypeFilter').val();
        
        $('#ordersTable tbody tr').each(function() {
            let showRow = true;
            
            if (status) {
                const rowStatus = $(this).find('.status-select').val();
                if (rowStatus !== status) {
                    showRow = false;
                }
            }
            
            if (designType && showRow) {
                const rowDesignType = $(this).find('.badge').text().trim();
                if (!rowDesignType.includes(getDesignTypeText(designType))) {
                    showRow = false;
                }
            }
            
            if (showRow) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
    
    function getDesignTypeText(type) {
        const types = {
            'text': 'وصف نصي',
            'upload': 'رفع ملف',
            'template': 'قالب جاهز',
            'ai': 'ذكاء اصطناعي'
        };
        return types[type] || '';
    }
    
    function showAlert(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alert = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('.container-fluid').prepend(alert);
        
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 3000);
    }
});
</script>
@endpush
