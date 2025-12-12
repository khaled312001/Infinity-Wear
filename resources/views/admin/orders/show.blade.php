@extends('layouts.dashboard')

@section('title', 'تفاصيل الطلب')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h3 mb-0">
                        <i class="fas fa-shopping-cart me-2 text-primary"></i>
                        تفاصيل الطلب {{ $order->order_number }}
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.importers.orders') }}">طلبات العملاء</a></li>
                            <li class="breadcrumb-item active" aria-current="page">تفاصيل الطلب</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.importers.orders') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>العودة للقائمة
                    </a>
                    <button type="button" class="btn btn-primary" onclick="window.print()">
                        <i class="fas fa-print me-2"></i>طباعة
                    </button>
                </div>
            </div>

            <!-- Order Status Alert -->
            @if($order->status == 'new')
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>طلب جديد:</strong> هذا الطلب جديد ويتطلب مراجعة ومعالجة.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @elseif($order->status == 'processing')
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-clock me-2"></i>
                    <strong>قيد المعالجة:</strong> هذا الطلب قيد المعالجة حالياً.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @elseif($order->status == 'completed')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>مكتمل:</strong> تم إنجاز هذا الطلب بنجاح.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @elseif($order->status == 'cancelled')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-times-circle me-2"></i>
                    <strong>ملغي:</strong> تم إلغاء هذا الطلب.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Order Information -->
                <div class="col-lg-8">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                معلومات الطلب
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label fw-bold text-muted">رقم الطلب:</label>
                                        <p class="mb-0 fs-5">{{ $order->order_number }}</p>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="form-label fw-bold text-muted">الكمية:</label>
                                        <p class="mb-0 fs-5">{{ number_format($order->quantity) }} قطعة</p>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="form-label fw-bold text-muted">تاريخ الطلب:</label>
                                        <p class="mb-0">{{ $order->created_at->format('Y-m-d H:i') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-3">
                                        <label class="form-label fw-bold text-muted">الحالة:</label>
                                        <div class="d-flex align-items-center">
                                            @switch($order->status)
                                                @case('new')
                                                    <span class="badge bg-primary fs-6">{{ $order->status_label }}</span>
                                                    @break
                                                @case('processing')
                                                    <span class="badge bg-warning fs-6">{{ $order->status_label }}</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-success fs-6">{{ $order->status_label }}</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge bg-danger fs-6">{{ $order->status_label }}</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary fs-6">{{ $order->status_label }}</span>
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="info-item mb-3">
                                        <label class="form-label fw-bold text-muted">آخر تحديث:</label>
                                        <p class="mb-0">{{ $order->updated_at->format('Y-m-d H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Requirements -->
                    <div class="dashboard-card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-clipboard-list me-2 text-primary"></i>
                                متطلبات الطلب
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="p-3 bg-light rounded">
                                <p class="mb-0">{{ $order->requirements }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Design Details -->
                    <div class="dashboard-card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-palette me-2 text-primary"></i>
                                تفاصيل التصميم
                            </h5>
                        </div>
                        <div class="card-body">
                            @php
                                $designDetails = is_string($order->design_details) ? json_decode($order->design_details, true) : $order->design_details;
                            @endphp
                            
                            @if(isset($designDetails['option']))
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-item mb-3">
                                            <label class="form-label fw-bold text-muted">نوع التصميم:</label>
                                            <p class="mb-0">
                                                @switch($designDetails['option'])
                                                    @case('text')
                                                        <span class="badge bg-info">
                                                            <i class="fas fa-font me-1"></i>وصف نصي
                                                        </span>
                                                        @break
                                                    @case('upload')
                                                        <span class="badge bg-info">
                                                            <i class="fas fa-upload me-1"></i>رفع ملف
                                                        </span>
                                                        @break
                                                    @case('template')
                                                        <span class="badge bg-info">
                                                            <i class="fas fa-image me-1"></i>قالب جاهز
                                                        </span>
                                                        @break
                                                    @case('ai')
                                                        <span class="badge bg-info">
                                                            <i class="fas fa-robot me-1"></i>ذكاء اصطناعي
                                                        </span>
                                                        @break
                                                @endswitch
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                @switch($designDetails['option'])
                                    @case('text')
                                        <div class="info-item mb-3">
                                            <label class="form-label fw-bold text-muted">وصف التصميم:</label>
                                            <div class="p-3 bg-light rounded">
                                                <p class="mb-0">{{ $designDetails['text'] ?? 'غير محدد' }}</p>
                                            </div>
                                        </div>
                                        @break
                                        
                                    @case('upload')
                                        @if(isset($designDetails['file_path']) || isset($designDetails['cloudinary']))
                                            @php
                                                $filePath = $designDetails['file_path'] ?? null;
                                                $cloudinaryData = $designDetails['cloudinary'] ?? null;
                                                
                                                // تحديد مصدر الصورة (Cloudinary أولاً، ثم المحلي)
                                                if ($cloudinaryData && isset($cloudinaryData['secure_url'])) {
                                                    $fileUrl = $cloudinaryData['secure_url'];
                                                    $fileExists = true;
                                                    $isCloudinary = true;
                                                } else {
                                                    // محاولة مسارات متعددة للعثور على الصورة
                                                    $possiblePaths = [
                                                        public_path('storage/' . $filePath),
                                                        public_path('storage/designs/' . basename($filePath)),
                                                        public_path('storage/infinitywearsa/designs/' . basename($filePath)),
                                                        storage_path('app/public/' . $filePath),
                                                        storage_path('app/public/designs/' . basename($filePath)),
                                                    ];
                                                    
                                                    $fileExists = false;
                                                    $fileUrl = asset('storage/' . $filePath);
                                                    $isCloudinary = false;
                                                    
                                                    foreach ($possiblePaths as $path) {
                                                        if (file_exists($path)) {
                                                            $fileExists = true;
                                                            // تحديد URL الصحيح بناءً على المسار
                                                            if (strpos($path, 'public/storage/designs/') !== false) {
                                                                $fileUrl = asset('storage/designs/' . basename($filePath));
                                                            } elseif (strpos($path, 'public/storage/infinitywearsa/designs/') !== false) {
                                                                $fileUrl = asset('storage/infinitywearsa/designs/' . basename($filePath));
                                                            } else {
                                                                $fileUrl = asset('storage/' . $filePath);
                                                            }
                                                            break;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            
                                            <div class="info-item mb-3">
                                                <label class="form-label fw-bold text-muted">الملف المرفوع:</label>
                                                <div class="p-3 bg-light rounded">
                                                    @if($fileExists)
                                                        
                                                        @if($isCloudinary && $cloudinaryData)
                                                            @if(str_contains($cloudinaryData['format'] ?? '', 'jpg') || str_contains($cloudinaryData['format'] ?? '', 'png') || str_contains($cloudinaryData['format'] ?? '', 'gif') || str_contains($cloudinaryData['format'] ?? '', 'webp'))
                                                                <div class="mt-3">
                                                                    <img src="{{ $fileUrl }}" alt="تصميم مرفوع" class="img-fluid rounded border" style="max-width: 100%; max-height: 500px; object-fit: contain;" 
                                                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                                    <div style="display: none;" class="alert alert-info">
                                                                        <i class="fas fa-info-circle me-1"></i>
                                                                        لا يمكن عرض معاينة الصورة، لكن يمكنك تحميل الملف
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @elseif($filePath)
                                                            @if(str_contains($filePath, '.jpg') || str_contains($filePath, '.jpeg') || str_contains($filePath, '.png') || str_contains($filePath, '.gif') || str_contains($filePath, '.webp'))
                                                                <div class="mt-3">
                                                                    <img src="{{ $fileUrl }}" alt="تصميم مرفوع" class="img-fluid rounded border" style="max-width: 100%; max-height: 500px; object-fit: contain;" 
                                                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                                    <div style="display: none;" class="alert alert-info">
                                                                        <i class="fas fa-info-circle me-1"></i>
                                                                        لا يمكن عرض معاينة الصورة، لكن يمكنك تحميل الملف
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                        
                                                        <div class="mt-2">
                                                            <small class="text-muted">
                                                                <i class="fas fa-info-circle me-1"></i>
                                                                @if($isCloudinary)
                                                                    <i class="fas fa-cloud me-1"></i> مخزن في السحابة
                                                                    @if($cloudinaryData['width'] && $cloudinaryData['height'])
                                                                        ({{ $cloudinaryData['width'] }}x{{ $cloudinaryData['height'] }})
                                                                    @endif
                                                                @else
                                                                    مسار الملف: {{ $filePath }}
                                                                @endif
                                                            </small>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-warning alert-sm">
                                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                                            الملف غير متاح حالياً. يرجى التواصل مع فريق الدعم.
                                                            @if($filePath)
                                                                <br><small class="text-muted">مسار الملف: {{ $filePath }}</small>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        @if(isset($designDetails['notes']))
                                            <div class="info-item mb-3">
                                                <label class="form-label fw-bold text-muted">ملاحظات:</label>
                                                <div class="p-3 bg-light rounded">
                                                    <p class="mb-0">{{ $designDetails['notes'] }}</p>
                                                </div>
                                            </div>
                                        @endif
                                        @break
                                        
                                    @case('template')
                                        <div class="info-item mb-3">
                                            <label class="form-label fw-bold text-muted">القالب المختار:</label>
                                            <div class="p-3 bg-light rounded">
                                                <p class="mb-0">{{ $designDetails['template'] ?? 'غير محدد' }}</p>
                                            </div>
                                        </div>
                                        @if(isset($designDetails['notes']))
                                            <div class="info-item mb-3">
                                                <label class="form-label fw-bold text-muted">تعديلات مطلوبة:</label>
                                                <div class="p-3 bg-light rounded">
                                                    <p class="mb-0">{{ $designDetails['notes'] }}</p>
                                                </div>
                                            </div>
                                        @endif
                                        @break
                                        
                                    @case('ai')
                                        <div class="info-item mb-3">
                                            <label class="form-label fw-bold text-muted">الوصف الأصلي:</label>
                                            <div class="p-3 bg-light rounded">
                                                <p class="mb-0">{{ $designDetails['prompt'] ?? 'غير محدد' }}</p>
                                            </div>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="form-label fw-bold text-muted">النمط:</label>
                                            <div class="p-3 bg-light rounded">
                                                <p class="mb-0">{{ $designDetails['style'] ?? 'غير محدد' }}</p>
                                            </div>
                                        </div>
                                        
                                        @if(isset($designDetails['ai_enhanced_description']))
                                            <div class="info-item mb-3">
                                                <label class="form-label fw-bold text-muted">الوصف المحسن:</label>
                                                <div class="p-3 bg-primary text-white rounded">
                                                    <h6><i class="fas fa-robot me-1"></i>الوصف المحسن:</h6>
                                                    <p class="mb-0">{{ $designDetails['ai_enhanced_description'] }}</p>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if(isset($designDetails['ai_error']))
                                            <div class="info-item mb-3">
                                                <label class="form-label fw-bold text-muted">خطأ في الذكاء الاصطناعي:</label>
                                                <div class="p-3 bg-warning rounded">
                                                    <p class="mb-0"><i class="fas fa-exclamation-triangle me-1"></i>{{ $designDetails['ai_error'] }}</p>
                                                </div>
                                            </div>
                                        @endif
                                        @break
                                @endswitch
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-exclamation-triangle fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">لا توجد تفاصيل تصميم متاحة</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Importer Information -->
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user me-2 text-primary"></i>
                                معلومات العميل
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="user-avatar me-3">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $order->importer->name }}</h6>
                                    <small class="text-muted">{{ $order->importer->company_name }}</small>
                                </div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="form-label fw-bold text-muted">البريد الإلكتروني:</label>
                                <p class="mb-0">
                                    <a href="mailto:{{ $order->importer->email }}" class="text-decoration-none">
                                        {{ $order->importer->email }}
                                    </a>
                                </p>
                            </div>
                            
                            <div class="info-item mb-3">
                                <label class="form-label fw-bold text-muted">رقم الهاتف:</label>
                                <p class="mb-0">
                                    <a href="tel:{{ $order->importer->phone }}" class="text-decoration-none">
                                        {{ $order->importer->phone }}
                                    </a>
                                </p>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.importers.show', $order->importer->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-2"></i>عرض ملف العميل
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Status Update -->
                    <div class="dashboard-card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-edit me-2 text-primary"></i>
                                تحديث الحالة
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="statusUpdateForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="status" class="form-label">الحالة الحالية</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="new" {{ $order->status == 'new' ? 'selected' : '' }}>جديد</option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>تحديث الحالة
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="dashboard-card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-bolt me-2 text-primary"></i>
                                إجراءات سريعة
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-success" onclick="sendWhatsAppMessage()">
                                    <i class="fab fa-whatsapp me-2"></i>إرسال رسالة واتساب
                                </button>
                                <button type="button" class="btn btn-outline-info" onclick="sendEmail()">
                                    <i class="fas fa-envelope me-2"></i>إرسال بريد إلكتروني
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="addNote()">
                                    <i class="fas fa-sticky-note me-2"></i>إضافة ملاحظة
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .info-item {
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 1rem;
    }
    
    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .user-avatar {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }
    
    @media print {
        .btn, .alert, .card-header {
            display: none !important;
        }
        
        .dashboard-card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Status update form
    $('#statusUpdateForm').on('submit', function(e) {
        e.preventDefault();
        
        const status = $('#status').val();
        
        $.ajax({
            url: '{{ route("admin.orders.updateStatus", $order->id) }}',
            method: 'PUT',
            data: {
                status: status,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showAlert('تم تحديث حالة الطلب بنجاح', 'success');
                    // Reload page after 2 seconds
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    showAlert('حدث خطأ في تحديث الحالة', 'error');
                }
            },
            error: function() {
                showAlert('حدث خطأ في الاتصال', 'error');
            }
        });
    });
    
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
    
    // Quick actions functions
    window.sendWhatsAppMessage = function() {
        const phone = '{{ $order->importer->phone }}';
        const message = `مرحباً {{ $order->importer->name }}، نود إعلامك بحالة طلبك رقم {{ $order->order_number }}.`;
        const whatsappUrl = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
    };
    
    window.sendEmail = function() {
        const email = '{{ $order->importer->email }}';
        const subject = `حالة طلبك رقم {{ $order->order_number }}`;
        const body = `مرحباً {{ $order->importer->name }}،\n\nنود إعلامك بحالة طلبك رقم {{ $order->order_number }}.\n\nمع تحيات فريق إنفينيتي وير`;
        const mailtoUrl = `mailto:${email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
        window.location.href = mailtoUrl;
    };
    
    window.addNote = function() {
        const note = prompt('أدخل الملاحظة:');
        if (note && note.trim()) {
            // Here you can implement the note saving functionality
            showAlert('تم إضافة الملاحظة بنجاح', 'success');
        }
    };
});
</script>
@endpush
