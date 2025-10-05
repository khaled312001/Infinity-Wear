<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المستوردين - Infinity Wear</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo.png') }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .dashboard-header {
            background: var(--success-gradient);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        
        .sidebar {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            height: fit-content;
        }
        
        .nav-link {
            color: #6c757d;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            background: var(--success-gradient);
            color: white;
            transform: translateX(5px);
        }
        
        .demo-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff6b6b;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="demo-badge">DEMO</div>
    
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-2">
                        <i class="fas fa-truck me-3"></i>
                        لوحة تحكم المستوردين
                    </h1>
                    <p class="mb-0 opacity-75">مرحباً بك في لوحة التحكم المخصصة للمستوردين</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-flex gap-2 justify-content-end">
                        <button class="btn btn-light">
                            <i class="fas fa-bell me-2"></i>
                            الإشعارات
                        </button>
                        <button class="btn btn-light">
                            <i class="fas fa-user me-2"></i>
                            الملف الشخصي
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="sidebar">
                    <h5 class="mb-3">
                        <i class="fas fa-bars me-2"></i>
                        القائمة الرئيسية
                    </h5>
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            لوحة التحكم
                        </a>
                        <a class="nav-link" href="#">
                            <i class="fas fa-shopping-cart me-2"></i>
                            طلباتي
                        </a>
                        <a class="nav-link" href="#">
                            <i class="fas fa-plus-circle me-2"></i>
                            طلب جديد
                        </a>
                        <a class="nav-link" href="#">
                            <i class="fas fa-palette me-2"></i>
                            التصميمات المخصصة
                        </a>
                        <a class="nav-link" href="#">
                            <i class="fas fa-images me-2"></i>
                            معرض الأعمال
                        </a>
                        <a class="nav-link" href="#">
                            <i class="fas fa-star me-2"></i>
                            الشهادات
                        </a>
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-bar me-2"></i>
                            التقارير
                        </a>
                        <a class="nav-link" href="#">
                            <i class="fas fa-cog me-2"></i>
                            الإعدادات
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-primary me-3">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0">24</h4>
                                    <small class="text-muted">إجمالي الطلبات</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-success me-3">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0">18</h4>
                                    <small class="text-muted">طلبات مكتملة</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-warning me-3">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0">4</h4>
                                    <small class="text-muted">طلبات قيد التنفيذ</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon bg-info me-3">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0">45,000</h4>
                                    <small class="text-muted">إجمالي المبيعات (ر.س)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="row">
                    <div class="col-12">
                        <div class="stat-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">
                                    <i class="fas fa-list me-2"></i>
                                    الطلبات الأخيرة
                                </h5>
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i>
                                    طلب جديد
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>رقم الطلب</th>
                                            <th>التاريخ</th>
                                            <th>النوع</th>
                                            <th>الكمية</th>
                                            <th>الحالة</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#INV-001</td>
                                            <td>2024-01-15</td>
                                            <td>قمصان رسمية</td>
                                            <td>100 قطعة</td>
                                            <td><span class="badge bg-success">مكتمل</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#INV-002</td>
                                            <td>2024-01-14</td>
                                            <td>بناطيل عمل</td>
                                            <td>50 قطعة</td>
                                            <td><span class="badge bg-warning">قيد التنفيذ</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>#INV-003</td>
                                            <td>2024-01-13</td>
                                            <td>بدلات رسمية</td>
                                            <td>25 قطعة</td>
                                            <td><span class="badge bg-info">جديد</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Demo functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Add click animations
            document.querySelectorAll('.stat-card').forEach(card => {
                card.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'translateY(-5px)';
                    }, 150);
                });
            });

            // Simulate real-time updates
            setInterval(() => {
                const badges = document.querySelectorAll('.badge');
                badges.forEach(badge => {
                    if (Math.random() > 0.8) {
                        badge.style.animation = 'pulse 0.5s ease-in-out';
                        setTimeout(() => {
                            badge.style.animation = '';
                        }, 500);
                    }
                });
            }, 3000);
        });
    </script>
</body>
</html>
