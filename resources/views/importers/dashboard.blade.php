@extends('layouts.dashboard')

@section('title', 'لوحة تحكم المستورد')
@section('dashboard-title', 'لوحة المستورد')
@section('page-title', 'مرحبا ' . $importer->name)
@section('page-subtitle', 'إدارة طلباتك وعمليات الاستيراد')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    <a href="{{ route('importers.dashboard') }}" class="nav-link active">
        <i class="fas fa-tachometer-alt me-2"></i>
        الرئيسية
    </a>
    <a href="#" class="nav-link">
        <i class="fas fa-shopping-cart me-2"></i>
        طلباتي
    </a>
    <a href="#" class="nav-link">
        <i class="fas fa-truck me-2"></i>
        عمليات الاستيراد
    </a>
    <a href="#" class="nav-link">
        <i class="fas fa-chart-line me-2"></i>
        التقارير
    </a>
    <a href="#" class="nav-link">
        <i class="fas fa-user me-2"></i>
        الملف الشخصي
    </a>
    <a href="#" class="nav-link">
        <i class="fas fa-cog me-2"></i>
        الإعدادات
    </a>
@endsection

@section('page-actions')
    <a href="#" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        طلب استيراد جديد
    </a>
@endsection

@section('content')
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon primary me-3">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $orders->count() }}</h3>
                        <p class="text-muted mb-0">إجمالي الطلبات</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon warning me-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $orders->where('status', 'pending')->count() }}</h3>
                        <p class="text-muted mb-0">طلبات قيد المراجعة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon success me-3">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $orders->where('status', 'approved')->count() }}</h3>
                        <p class="text-muted mb-0">طلبات معتمدة</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon danger me-3">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $orders->where('status', 'rejected')->count() }}</h3>
                        <p class="text-muted mb-0">طلبات مرفوضة</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Importer Information -->
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2 text-primary"></i>
                        معلومات المستورد
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="stats-icon primary mx-auto mb-3" style="width: 80px; height: 80px; font-size: 32px;">
                            <i class="fas fa-user"></i>
                        </div>
                        <h4 class="mb-1">{{ $importer->name }}</h4>
                        <p class="text-muted mb-2">{{ $importer->email }}</p>
                        <span class="badge bg-success">مستورد نشط</span>
                    </div>

                    <div class="border-top pt-3">
                        <div class="mb-3">
                            <strong>نوع العمل:</strong>
                            <span class="float-end">
                                @if($importer->business_type == 'individual')
                                    <span class="badge bg-info">فرد</span>
                                @elseif($importer->business_type == 'company')
                                    <span class="badge bg-primary">شركة</span>
                                @else
                                    <span class="badge bg-secondary">آخر</span>
                                @endif
                            </span>
                        </div>

                        @if($importer->business_type == 'company')
                            <div class="mb-3">
                                <strong>اسم الشركة:</strong>
                                <div class="text-muted">{{ $importer->company_name }}</div>
                            </div>
                            <div class="mb-3">
                                <strong>المنصب:</strong>
                                <div class="text-muted">{{ $importer->company_position }}</div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <strong>رقم الهاتف:</strong>
                            <div class="text-muted">{{ $importer->phone }}</div>
                        </div>

                        <div class="mb-0">
                            <strong>العنوان:</strong>
                            <div class="text-muted">{{ $importer->address }}, {{ $importer->city }}, {{ $importer->country }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2 text-primary"></i>
                            الطلبات
                        </h5>
                        <a href="#" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            طلب جديد
                        </a>
                    </div>
                </div>
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>المتطلبات</th>
                                        <th>الكمية</th>
                                        <th>الحالة</th>
                                        <th>التاريخ</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td><strong>#{{ $order->id }}</strong></td>
                                            <td>{{ Str::limit($order->requirements, 50) }}</td>
                                            <td><span class="badge bg-light text-dark">{{ $order->quantity }}</span></td>
                                            <td>
                                                @switch($order->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-clock me-1"></i>
                                                            قيد المراجعة
                                                        </span>
                                                        @break
                                                    @case('approved')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check me-1"></i>
                                                            معتمد
                                                        </span>
                                                        @break
                                                    @case('rejected')
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times me-1"></i>
                                                            مرفوض
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                                @endswitch
                                            </td>
                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#orderModal{{ $order->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Order Details Modal -->
                                        <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">تفاصيل الطلب #{{ $order->id }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h6>معلومات الطلب</h6>
                                                                <table class="table table-sm">
                                                                    <tr>
                                                                        <td><strong>رقم الطلب:</strong></td>
                                                                        <td>#{{ $order->id }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>التاريخ:</strong></td>
                                                                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>الحالة:</strong></td>
                                                                        <td>
                                                                            @switch($order->status)
                                                                                @case('pending')
                                                                                    <span class="badge bg-warning">قيد المراجعة</span>
                                                                                    @break
                                                                                @case('approved')
                                                                                    <span class="badge bg-success">معتمد</span>
                                                                                    @break
                                                                                @case('rejected')
                                                                                    <span class="badge bg-danger">مرفوض</span>
                                                                                    @break
                                                                                @default
                                                                                    <span class="badge bg-secondary">{{ $order->status }}</span>
                                                                            @endswitch
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>الكمية:</strong></td>
                                                                        <td>{{ $order->quantity }}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h6>تفاصيل التصميم</h6>
                                                                @php
                                                                    $designDetails = json_decode($order->design_details, true);
                                                                @endphp

                                                                @if(isset($designDetails['option']))
                                                                    <div class="mb-2">
                                                                        <strong>نوع التصميم:</strong>
                                                                        @switch($designDetails['option'])
                                                                            @case('text')
                                                                                <span class="badge bg-info">وصف نصي</span>
                                                                                @break
                                                                            @case('upload')
                                                                                <span class="badge bg-primary">تصميم مرفوع</span>
                                                                                @break
                                                                            @case('template')
                                                                                <span class="badge bg-success">تصميم جاهز</span>
                                                                                @break
                                                                            @case('ai')
                                                                                <span class="badge bg-warning">ذكاء اصطناعي</span>
                                                                                @break
                                                                            @default
                                                                                <span class="badge bg-secondary">غير محدد</span>
                                                                        @endswitch
                                                                    </div>

                                                                    @switch($designDetails['option'])
                                                                        @case('text')
                                                                            <div class="alert alert-light">
                                                                                <strong>الوصف:</strong><br>
                                                                                {{ $designDetails['text'] ?? 'لا يوجد وصف' }}
                                                                            </div>
                                                                            @break
                                                                        @case('upload')
                                                                            @if(isset($designDetails['file_path']))
                                                                                @php
                                                                                    $filePath = $designDetails['file_path'];
                                                                                    $fullPath = public_path('storage/' . $filePath);
                                                                                    $fileExists = file_exists($fullPath);
                                                                                    $fileUrl = asset('storage/' . $filePath);
                                                                                    
                                                                                    // معالجة إضافية للتحقق من وجود الملف
                                                                                    if (!$fileExists) {
                                                                                        // محاولة مسارات بديلة
                                                                                        $alternativePath1 = public_path('storage/designs/' . basename($filePath));
                                                                                        $alternativePath2 = storage_path('app/public/' . $filePath);
                                                                                        
                                                                                        if (file_exists($alternativePath1)) {
                                                                                            $fileExists = true;
                                                                                            $fullPath = $alternativePath1;
                                                                                            $fileUrl = asset('storage/designs/' . basename($filePath));
                                                                                        } elseif (file_exists($alternativePath2)) {
                                                                                            $fileExists = true;
                                                                                            $fullPath = $alternativePath2;
                                                                                            $fileUrl = asset('storage/' . $filePath);
                                                                                        }
                                                                                    }
                                                                                @endphp
                                                                                
                                                                                @if($fileExists)
                                                                                    <div class="d-flex gap-2">
                                                                                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                                            <i class="fas fa-eye me-1"></i> عرض الملف
                                                                                        </a>
                                                                                        <a href="{{ $fileUrl }}" download class="btn btn-sm btn-outline-success">
                                                                                            <i class="fas fa-download me-1"></i> تحميل
                                                                                        </a>
                                                                                    </div>
                                                                                    
                                                                                    @if(str_contains($filePath, '.jpg') || str_contains($filePath, '.jpeg') || str_contains($filePath, '.png') || str_contains($filePath, '.gif') || str_contains($filePath, '.webp'))
                                                                                        <div class="mt-2">
                                                                                            <img src="{{ $fileUrl }}" alt="تصميم مرفوع" class="img-thumbnail" style="max-width: 200px; max-height: 200px;" 
                                                                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                                                            <div style="display: none;" class="alert alert-info alert-sm">
                                                                                                <i class="fas fa-info-circle me-1"></i>
                                                                                                لا يمكن عرض معاينة الصورة، لكن يمكنك تحميل الملف
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                    
                                                                                    <div class="mt-1">
                                                                                        <small class="text-muted">
                                                                                            <i class="fas fa-info-circle me-1"></i>
                                                                                            {{ $filePath }}
                                                                                        </small>
                                                                                    </div>
                                                                                @else
                                                                                    <div class="alert alert-warning alert-sm">
                                                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                                                        الملف غير متاح حالياً. يرجى التواصل مع فريق الدعم.
                                                                                        <br><small class="text-muted">{{ $filePath }}</small>
                                                                                    </div>
                                                                                @endif
                                                                            @else
                                                                                <div class="alert alert-info alert-sm">
                                                                                    <i class="fas fa-info-circle me-1"></i>
                                                                                    لم يتم رفع ملف تصميم
                                                                                </div>
                                                                            @endif
                                                                            @break
                                                                        @case('template')
                                                                            <div class="alert alert-light">
                                                                                <strong>التصميم:</strong>
                                                                                @switch($designDetails['template'] ?? '')
                                                                                    @case('template1')
                                                                                        التصميم الكلاسيكي
                                                                                        @break
                                                                                    @case('template2')
                                                                                        التصميم المكي
                                                                                        @break
                                                                                    @case('template3')
                                                                                        التصميم العصري
                                                                                        @break
                                                                                    @default
                                                                                        غير محدد
                                                                                @endswitch
                                                                            </div>
                                                                            @break
                                                                        @case('ai')
                                                                            <div class="alert alert-light">
                                                                                <strong>الوصف:</strong><br>
                                                                                {{ $designDetails['prompt'] ?? 'لا يوجد وصف' }}
                                                                            </div>
                                                                            @break
                                                                    @endswitch
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mt-3">
                                                            <h6>المتطلبات</h6>
                                                            <div class="alert alert-info">
                                                                {{ $order->requirements }}
                                                            </div>
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
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">لا توجد طلبات حتى الآن</h4>
                            <p class="text-muted mb-4">ابدأ بإنشاء طلب استيراد جديد</p>
                            <a href="#" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                طلب استيراد جديد
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection