@extends('layouts.dashboard')

@section('title', 'تفاصيل العميل - ' . $user->name)
@section('dashboard-title', 'إدارة العملاء')
@section('page-title', 'تفاصيل العميل')
@section('page-subtitle', 'عرض معلومات العميل وإحصائياته')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" class="nav-link">
        <i class="fas fa-tachometer-alt me-2"></i>
        الرئيسية
    </a>
    
    <!-- إدارة المحتوى -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-store me-2"></i>
            إدارة المحتوى
        </div>
        <a href="{{ route('admin.portfolio.index') }}" class="nav-link">
            <i class="fas fa-tshirt me-2"></i>
            المنتجات
        </a>
        <a href="{{ route('admin.portfolio.index') }}" class="nav-link">
            <i class="fas fa-image me-2"></i>
            معرض الأعمال
        </a>
        <a href="{{ route('admin.testimonials.index') }}" class="nav-link">
            <i class="fas fa-star me-2"></i>
            التقييمات
        </a>
    </div>
    
    <!-- إدارة المستخدمين -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-users me-2"></i>
            إدارة المستخدمين
        </div>
        <a href="{{ route('admin.users.index') }}" class="nav-link active">
            <i class="fas fa-user me-2"></i>
            العملاء
        </a>
        <a href="{{ route('admin.admins.index') }}" class="nav-link">
            <i class="fas fa-user-shield me-2"></i>
            المشرفين
        </a>
        <a href="{{ route('admin.importers.index') }}" class="nav-link">
            <i class="fas fa-truck me-2"></i>
            المستوردين
        </a>
    </div>
    
    <!-- إدارة الفرق -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-users-cog me-2"></i>
            إدارة الفرق
        </div>
        <a href="{{ route('admin.marketing.index') }}" class="nav-link">
            <i class="fas fa-bullhorn me-2"></i>
            فريق التسويق
        </a>
        <a href="{{ route('admin.sales.index') }}" class="nav-link">
            <i class="fas fa-chart-line me-2"></i>
            فريق المبيعات
        </a>
        <a href="{{ route('admin.tasks.index') }}" class="nav-link">
            <i class="fas fa-tasks me-2"></i>
            إدارة المهام
        </a>
    </div>
    
    <!-- النظام المالي -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-money-bill-wave me-2"></i>
            النظام المالي
        </div>
        <a href="{{ route('admin.finance.dashboard') }}" class="nav-link">
            <i class="fas fa-chart-pie me-2"></i>
            لوحة المالية
        </a>
        <a href="{{ route('admin.finance.transactions') }}" class="nav-link">
            <i class="fas fa-exchange-alt me-2"></i>
            المعاملات المالية
        </a>
        <a href="{{ route('admin.finance.reports') }}" class="nav-link">
            <i class="fas fa-file-invoice-dollar me-2"></i>
            التقارير المالية
        </a>
    </div>
    
    <!-- إدارة المحتوى والـ SEO -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-search me-2"></i>
            المحتوى والـ SEO
        </div>
        <a href="{{ route('admin.content.index') }}" class="nav-link">
            <i class="fas fa-file-alt me-2"></i>
            إدارة المحتوى
        </a>
        <a href="{{ route('admin.content.seo') }}" class="nav-link">
            <i class="fas fa-search-plus me-2"></i>
            إعدادات SEO
        </a>
    </div>
    
    <!-- التقارير والإحصائيات -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-chart-bar me-2"></i>
            التقارير والإحصائيات
        </div>
        <a href="{{ route('admin.reports') }}" class="nav-link">
            <i class="fas fa-analytics me-2"></i>
            تقارير شاملة
        </a>
    </div>
    
    <!-- الإعدادات -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-cog me-2"></i>
            إعدادات النظام
        </div>
        <a href="{{ route('admin.settings') }}" class="nav-link">
            <i class="fas fa-sliders-h me-2"></i>
            الإعدادات العامة
        </a>
    </div>
@endsection

@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>
            تعديل
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            العودة للقائمة
        </a>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- معلومات العميل الأساسية -->
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="user-avatar mb-3">
                        <div class="avatar-large">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    </div>
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">عميل مسجل</p>
                    
                    <div class="mb-3">
                        @if($user->email_verified_at)
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check-circle me-1"></i>
                                حساب مفعل
                            </span>
                        @else
                            <span class="badge bg-warning fs-6">
                                <i class="fas fa-clock me-1"></i>
                                في انتظار التفعيل
                            </span>
                        @endif
                    </div>

                    <div class="user-info">
                        <div class="info-item">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                {{ $user->email }}
                            </a>
                        </div>
                        
                        @if($user->phone)
                            <div class="info-item">
                                <i class="fas fa-phone text-success me-2"></i>
                                <a href="tel:{{ $user->phone }}" class="text-decoration-none">
                                    {{ $user->phone }}
                                </a>
                            </div>
                        @endif
                        
                        @if($user->address)
                            <div class="info-item">
                                <i class="fas fa-map-marker-alt text-info me-2"></i>
                                {{ $user->address }}
                            </div>
                        @endif
                        
                        <div class="info-item">
                            <i class="fas fa-calendar text-warning me-2"></i>
                            عضو منذ {{ $user->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- إحصائيات سريعة -->
            <div class="dashboard-card mt-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>
                        إحصائيات سريعة
                    </h6>
                </div>
                <div class="card-body">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value text-primary">{{ $user->orders()->count() }}</div>
                            <div class="stat-label">إجمالي الطلبات</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value text-success">{{ $user->orders()->where('status', 'completed')->count() }}</div>
                            <div class="stat-label">طلبات مكتملة</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value text-warning">{{ $user->orders()->where('status', 'pending')->count() }}</div>
                            <div class="stat-label">طلبات معلقة</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- تفاصيل النشاط -->
        <div class="col-lg-8">
            <!-- علامات التبويب -->
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <ul class="nav nav-tabs card-header-tabs" id="userTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">
                                <i class="fas fa-shopping-cart me-2"></i>
                                الطلبات
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">
                                <i class="fas fa-history me-2"></i>
                                سجل النشاط
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="userTabsContent">
                        <!-- الطلبات -->
                        <div class="tab-pane fade show active" id="orders" role="tabpanel">
                            @if($user->orders()->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>رقم الطلب</th>
                                                <th>المنتجات</th>
                                                <th>المبلغ</th>
                                                <th>الحالة</th>
                                                <th>التاريخ</th>
                                                <th>الإجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user->orders()->latest()->take(10)->get() as $order)
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-primary">#{{ $order->id }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <div class="fw-bold">{{ $order->product_name ?? 'طلب مخصص' }}</div>
                                                                <small class="text-muted">الكمية: {{ $order->quantity ?? 1 }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold text-success">
                                                            {{ number_format($order->total_amount ?? 0) }} ر.س
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @switch($order->status)
                                                            @case('pending')
                                                                <span class="badge bg-warning">معلق</span>
                                                                @break
                                                            @case('processing')
                                                                <span class="badge bg-info">قيد المعالجة</span>
                                                                @break
                                                            @case('completed')
                                                                <span class="badge bg-success">مكتمل</span>
                                                                @break
                                                            @case('cancelled')
                                                                <span class="badge bg-danger">ملغي</span>
                                                                @break
                                                            @default
                                                                <span class="badge bg-secondary">غير محدد</span>
                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        <div>
                                                            {{ $order->created_at->format('d/m/Y') }}
                                                            <small class="d-block text-muted">
                                                                {{ $order->created_at->diffForHumans() }}
                                                            </small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted">غير متاح</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">لا توجد طلبات</h5>
                                    <p class="text-muted">لم يقم هذا العميل بأي طلبات حتى الآن</p>
                                </div>
                            @endif
                        </div>


                        <!-- سجل النشاط -->
                        <div class="tab-pane fade" id="activity" role="tabpanel">
                            <div class="activity-timeline">
                                <div class="activity-item">
                                    <div class="activity-icon bg-success">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h6>تسجيل الحساب</h6>
                                        <p class="text-muted mb-1">تم تسجيل الحساب بنجاح</p>
                                        <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>

                                @if($user->email_verified_at)
                                    <div class="activity-item">
                                        <div class="activity-icon bg-info">
                                            <i class="fas fa-envelope-check"></i>
                                        </div>
                                        <div class="activity-content">
                                            <h6>تفعيل البريد الإلكتروني</h6>
                                            <p class="text-muted mb-1">تم تفعيل البريد الإلكتروني</p>
                                            <small class="text-muted">{{ $user->email_verified_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                @endif

                                @foreach($user->orders()->latest()->take(5)->get() as $order)
                                    <div class="activity-item">
                                        <div class="activity-icon bg-primary">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                        <div class="activity-content">
                                            <h6>طلب جديد #{{ $order->id }}</h6>
                                            <p class="text-muted mb-1">تم إنشاء طلب جديد</p>
                                            <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                @endforeach

                                @if($user->orders()->count() == 0)
                                    <div class="text-center py-5">
                                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">لا يوجد نشاط</h5>
                                        <p class="text-muted">لا يوجد نشاط إضافي لهذا العميل</p>
                                    </div>
                                @endif
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
        .avatar-large {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 600;
            color: white;
            margin: 0 auto;
        }

        .user-info .info-item {
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
        }

        .user-info .info-item:last-child {
            border-bottom: none;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #64748b;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #64748b;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
            background: none;
        }

        .activity-timeline {
            position: relative;
            padding-left: 2rem;
        }

        .activity-timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e2e8f0;
        }

        .activity-item {
            position: relative;
            margin-bottom: 2rem;
        }

        .activity-icon {
            position: absolute;
            left: -2rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
        }

        .activity-content h6 {
            margin-bottom: 0.5rem;
            color: #374151;
        }

        .activity-content p {
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }
    </style>
@endpush