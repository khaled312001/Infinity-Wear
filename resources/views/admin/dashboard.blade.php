@extends('layouts.dashboard')

@section('title', 'لوحة التحكم الإدارية')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'مرحبا بك في لوحة التحكم')
@section('page-subtitle', 'إدارة شاملة لموقع Infinity Wear - مؤسسة اللباس اللامحدود')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    <a href="{{ route('admin.dashboard') }}" class="nav-link active">
        <i class="fas fa-tachometer-alt me-2"></i>
        الرئيسية
    </a>
    
    <!-- إدارة المحتوى -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-store me-2"></i>
            إدارة المحتوى
        </div>
        <a href="{{ route('admin.orders.index') }}" class="nav-link">
            <i class="fas fa-shopping-cart me-2"></i>
            الطلبات
        </a>
        <a href="{{ route('admin.products.index') }}" class="nav-link">
            <i class="fas fa-tshirt me-2"></i>
            المنتجات
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-link">
            <i class="fas fa-tags me-2"></i>
            الفئات
        </a>
        <a href="{{ route('admin.custom-designs.index') }}" class="nav-link">
            <i class="fas fa-palette me-2"></i>
            التصاميم المخصصة
        </a>
        <a href="{{ route('admin.portfolio.index') }}" class="nav-link">
            <i class="fas fa-image me-2"></i>
            معرض الأعمال
        </a>
        <a href="{{ route('admin.testimonials.index') }}" class="nav-link">
            <i class="fas fa-star me-2"></i>
            الشهادات والتقييمات
        </a>
    </div>
    
    <!-- إدارة المستخدمين -->
    <div class="nav-group">
        <div class="nav-group-title">
            <i class="fas fa-users me-2"></i>
            إدارة المستخدمين
        </div>
        <a href="{{ route('admin.users.index') }}" class="nav-link">
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
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            <i class="fas fa-plus me-2"></i>
            إضافة جديد
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('admin.products.create') }}"><i class="fas fa-tshirt me-2"></i>منتج جديد</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.categories.create') }}"><i class="fas fa-tags me-2"></i>فئة جديدة</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.orders.create') }}"><i class="fas fa-shopping-cart me-2"></i>طلب جديد</a></li>
        </ul>
    </div>
@endsection

@section('content')
    <!-- الإحصائيات السريعة -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon primary me-3">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['total_orders'] ?? 156 }}</h3>
                        <p class="text-muted mb-0">إجمالي الطلبات</p>
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>
                            +12% من الشهر الماضي
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon success me-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['total_users'] ?? 89 }}</h3>
                        <p class="text-muted mb-0">العملاء المسجلين</p>
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>
                            +8% من الشهر الماضي
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon warning me-3">
                        <i class="fas fa-palette"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ $stats['total_designs'] ?? 43 }}</h3>
                        <p class="text-muted mb-0">التصاميم المخصصة</p>
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>
                            +25% من الشهر الماضي
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon danger me-3">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">{{ number_format($stats['monthly_revenue'] ?? 25000) }}</h3>
                        <p class="text-muted mb-0">إيرادات الشهر (ر.س)</p>
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>
                            +15% من الشهر الماضي
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- الإجراءات السريعة -->
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2 text-warning"></i>
                        إجراءات سريعة
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.orders.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart me-2"></i>
                            طلب جديد
                        </a>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-tshirt me-2"></i>
                            منتج جديد
                        </a>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-info">
                            <i class="fas fa-tags me-2"></i>
                            فئة جديدة
                        </a>
                        <a href="#" class="btn btn-outline-warning">
                            <i class="fas fa-chart-pie me-2"></i>
                            تقرير مالي
                        </a>
                        <a href="#" class="btn btn-outline-secondary">
                            <i class="fas fa-cog me-2"></i>
                            إعدادات النظام
                        </a>
                    </div>
                </div>
            </div>

            <!-- حالة النظام -->
            <div class="dashboard-card mt-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-server me-2 text-success"></i>
                        حالة النظام
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                            <span>الموقع الإلكتروني</span>
                        </div>
                        <span class="badge bg-success">متصل</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                            <span>قاعدة البيانات</span>
                        </div>
                        <span class="badge bg-success">متصلة</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                            <span>مساحة التخزين</span>
                        </div>
                        <span class="badge bg-warning">75%</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded-circle me-2" style="width: 12px; height: 12px;"></div>
                            <span>النسخ الاحتياطي</span>
                        </div>
                        <span class="badge bg-success">محدث</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- الرسم البياني -->
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-area me-2 text-primary"></i>
                            نظرة عامة على الأداء
                        </h5>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-outline-primary active" onclick="updateChart('7days')">7 أيام</button>
                            <button class="btn btn-sm btn-outline-primary" onclick="updateChart('30days')">30 يوم</button>
                            <button class="btn btn-sm btn-outline-primary" onclick="updateChart('3months')">3 أشهر</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- النشاط الأخير والطلبات المعلقة -->
    <div class="row g-4 mt-4">
        <div class="col-lg-6">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2 text-primary"></i>
                            النشاط الأخير
                        </h5>
                        <a href="#" class="btn btn-sm btn-outline-primary">عرض الكل</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="recent-activity">
                        <div class="activity-item">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon success me-3" style="width: 40px; height: 40px; font-size: 16px;">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">طلب جديد #1234</h6>
                                    <small class="text-muted">منذ 5 دقائق</small>
                                </div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon info me-3" style="width: 40px; height: 40px; font-size: 16px;">
                                    <i class="fas fa-palette"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">تصميم مخصص جديد</h6>
                                    <small class="text-muted">منذ 15 دقيقة</small>
                                </div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon warning me-3" style="width: 40px; height: 40px; font-size: 16px;">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">عميل جديد مسجل</h6>
                                    <small class="text-muted">منذ ساعة</small>
                                </div>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon danger me-3" style="width: 40px; height: 40px; font-size: 16px;">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">تحديث مطلوب للنظام</h6>
                                    <small class="text-muted">منذ 3 ساعات</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-clock me-2 text-warning"></i>
                            الطلبات المعلقة
                        </h5>
                        <span class="badge bg-warning">{{ $stats['pending_orders'] ?? 5 }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($pendingOrders) && $pendingOrders->count() > 0)
                        <div class="recent-activity">
                            @foreach($pendingOrders as $order)
                            <div class="activity-item">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon warning me-3" style="width: 40px; height: 40px; font-size: 16px;">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">طلب #{{ $order->id }} - {{ $order->customer_name }}</h6>
                                            <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                        عرض
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h6 class="text-muted">لا توجد طلبات معلقة</h6>
                            <p class="text-muted mb-0">جميع الطلبات تمت معالجتها</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- روابط سريعة للأقسام -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-th-large me-2 text-primary"></i>
                        إدارة الأقسام
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                <div class="fw-bold">الطلبات</div>
                                <small class="text-muted">إدارة الطلبات</small>
                            </a>
                        </div>

                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-tshirt fa-2x mb-2"></i>
                                <div class="fw-bold">المنتجات</div>
                                <small class="text-muted">إدارة المنتجات</small>
                            </a>
                        </div>

                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('admin.custom-designs.index') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-palette fa-2x mb-2"></i>
                                <div class="fw-bold">التصاميم</div>
                                <small class="text-muted">التصاميم المخصصة</small>
                            </a>
                        </div>

                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="#" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-chart-line fa-2x mb-2"></i>
                                <div class="fw-bold">المالية</div>
                                <small class="text-muted">الإيرادات والمصروفات</small>
                            </a>
                        </div>

                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="{{ route('admin.importers.index') }}" class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-truck fa-2x mb-2"></i>
                                <div class="fw-bold">المستوردين</div>
                                <small class="text-muted">إدارة المستوردين</small>
                            </a>
                        </div>

                        <div class="col-lg-2 col-md-4 col-6">
                            <a href="#" class="btn btn-outline-dark w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i class="fas fa-cog fa-2x mb-2"></i>
                                <div class="fw-bold">الإعدادات</div>
                                <small class="text-muted">إعدادات النظام</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // رسم بياني للأداء
        const ctx = document.getElementById('performanceChart').getContext('2d');
        let performanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت', 'الأحد'],
                datasets: [
                    {
                        label: 'الطلبات',
                        data: [12, 19, 3, 5, 2, 3, 9],
                        borderColor: '#1e3a8a',
                        backgroundColor: 'rgba(30, 58, 138, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'التصاميم',
                        data: [2, 3, 20, 5, 1, 4, 6],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'العملاء الجدد',
                        data: [3, 10, 13, 15, 22, 30, 25],
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                family: 'Cairo'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    }
                }
            }
        });

        // تحديث الرسم البياني
        function updateChart(period) {
            // إزالة الفئة النشطة من جميع الأزرار
            document.querySelectorAll('.btn-group .btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // إضافة الفئة النشطة للزر المضغوط
            event.target.classList.add('active');
            
            // بيانات مختلفة للفترات المختلفة
            let newData;
            switch(period) {
                case '7days':
                    newData = {
                        labels: ['الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت', 'الأحد'],
                        datasets: [
                            {
                                ...performanceChart.data.datasets[0],
                                data: [12, 19, 3, 5, 2, 3, 9]
                            },
                            {
                                ...performanceChart.data.datasets[1],
                                data: [2, 3, 20, 5, 1, 4, 6]
                            },
                            {
                                ...performanceChart.data.datasets[2],
                                data: [3, 10, 13, 15, 22, 30, 25]
                            }
                        ]
                    };
                    break;
                case '30days':
                    newData = {
                        labels: ['الأسبوع 1', 'الأسبوع 2', 'الأسبوع 3', 'الأسبوع 4'],
                        datasets: [
                            {
                                ...performanceChart.data.datasets[0],
                                data: [45, 52, 38, 61]
                            },
                            {
                                ...performanceChart.data.datasets[1],
                                data: [15, 23, 18, 28]
                            },
                            {
                                ...performanceChart.data.datasets[2],
                                data: [32, 45, 38, 52]
                            }
                        ]
                    };
                    break;
                case '3months':
                    newData = {
                        labels: ['الشهر 1', 'الشهر 2', 'الشهر 3'],
                        datasets: [
                            {
                                ...performanceChart.data.datasets[0],
                                data: [156, 189, 234]
                            },
                            {
                                ...performanceChart.data.datasets[1],
                                data: [67, 89, 123]
                            },
                            {
                                ...performanceChart.data.datasets[2],
                                data: [234, 298, 367]
                            }
                        ]
                    };
                    break;
            }
            
            performanceChart.data = newData;
            performanceChart.update();
        }

        // تحديث الإحصائيات كل دقيقة (يمكن إضافة AJAX)
        setInterval(function() {
            console.log('تحديث الإحصائيات...');
            // هنا يمكن إضافة استدعاء AJAX لتحديث الإحصائيات
        }, 60000);

        // تأثيرات التفاعل للبطاقات
        document.querySelectorAll('.stats-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
@endpush