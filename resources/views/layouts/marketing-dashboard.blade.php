<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم') - Infinity Wear</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap RTL -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
            --accent-color: #60a5fa;
            --dark-color: #1e40af;
            --light-color: #f8fafc;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --marketing-color: #8b5cf6;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--marketing-color) 0%, var(--primary-color) 100%);
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 2px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(-5px);
        }

        .nav-group {
            margin: 20px 0;
        }

        .nav-group-title {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 20px;
            margin-bottom: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-group .nav-link {
            padding: 10px 25px;
            font-size: 0.9rem;
            margin: 1px 0;
        }

        .main-content {
            padding: 20px;
        }

        .dashboard-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .stats-card {
            border: none;
            border-radius: 15px;
            padding: 25px;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--marketing-color), var(--primary-color));
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .stats-icon.primary { background: linear-gradient(135deg, var(--marketing-color), var(--primary-color)); }
        .stats-icon.success { background: linear-gradient(135deg, #10b981, #34d399); }
        .stats-icon.warning { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
        .stats-icon.danger { background: linear-gradient(135deg, #ef4444, #f87171); }
        .stats-icon.info { background: linear-gradient(135deg, #3b82f6, #60a5fa); }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--marketing-color);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        .brand-logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #8b5cf6, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--marketing-color), var(--primary-color));
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(139, 92, 246, 0.4);
        }

        /* Dark Mode Styles */
        .dark-mode {
            background-color: #1a1a1a !important;
            color: #e5e5e5 !important;
        }

        .dark-mode .navbar {
            background: #2d2d2d !important;
            border-bottom-color: #404040 !important;
        }

        .dark-mode .navbar-brand,
        .dark-mode .navbar-brand:hover {
            color: #e5e5e5 !important;
        }

        .dark-mode .btn-outline-primary {
            border-color: #3b82f6;
            color: #3b82f6;
        }

        .dark-mode .btn-outline-primary:hover {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: white;
        }

        .dark-mode .btn-outline-success {
            border-color: #10b981;
            color: #10b981;
        }

        .dark-mode .btn-outline-success:hover {
            background-color: #10b981;
            border-color: #10b981;
            color: white;
        }

        .dark-mode .dropdown-menu {
            background-color: #2d2d2d;
            border-color: #404040;
        }

        .dark-mode .dropdown-item {
            color: #e5e5e5;
        }

        .dark-mode .dropdown-item:hover {
            background-color: #404040;
            color: white;
        }

        .dark-mode .dropdown-header {
            color: #a0a0a0;
        }

        .dark-mode .dropdown-divider {
            border-color: #404040;
        }

        .dark-mode .card {
            background-color: #2d2d2d;
            border-color: #404040;
            color: #e5e5e5;
        }

        .dark-mode .card-header {
            background-color: #3a3a3a;
            border-bottom-color: #404040;
        }

        .dark-mode .table {
            color: #e5e5e5;
        }

        .dark-mode .table-hover tbody tr:hover {
            background-color: #404040;
        }

        .dark-mode .table-striped tbody tr:nth-of-type(odd) {
            background-color: #3a3a3a;
        }

        .dark-mode .stats-card {
            background-color: #2d2d2d;
            border-color: #404040;
        }

        .dark-mode .stats-card:hover {
            background-color: #3a3a3a;
        }

        .dark-mode .sidebar {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }

        .dark-mode .main-content {
            background-color: #1a1a1a;
        }

        .dark-mode .text-muted {
            color: #a0a0a0 !important;
        }

        .dark-mode .alert {
            background-color: #3a3a3a;
            border-color: #404040;
            color: #e5e5e5;
        }

        .dark-mode .alert-info {
            background-color: #1e3a8a;
            border-color: #3b82f6;
            color: #e5e5e5;
        }

        .dark-mode .form-control,
        .dark-mode .form-select {
            background-color: #3a3a3a;
            border-color: #404040;
            color: #e5e5e5;
        }

        .dark-mode .form-control:focus,
        .dark-mode .form-select:focus {
            background-color: #3a3a3a;
            border-color: #3b82f6;
            color: #e5e5e5;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .dark-mode .modal-content {
            background-color: #2d2d2d;
            border-color: #404040;
        }

        .dark-mode .modal-header {
            border-bottom-color: #404040;
        }

        .dark-mode .modal-footer {
            border-top-color: #404040;
        }

        .dark-mode .pagination .page-link {
            background-color: #3a3a3a;
            border-color: #404040;
            color: #e5e5e5;
        }

        .dark-mode .pagination .page-link:hover {
            background-color: #404040;
            border-color: #404040;
            color: white;
        }

        .dark-mode .pagination .page-item.active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 15px 0;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--marketing-color), var(--primary-color));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .brand-name {
            font-size: 1.2rem;
            color: var(--marketing-color);
            margin-bottom: 0;
        }

        .brand-subtitle {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: -2px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, var(--marketing-color), var(--primary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }

        .user-avatar-large {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--marketing-color), var(--primary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--marketing-color);
        }

        .user-role {
            font-size: 0.75rem;
        }

        .infinity-logo::before {
            content: "∞";
            font-size: 1.2em;
            background: linear-gradient(135deg, #8b5cf6, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .table thead th {
            background: linear-gradient(135deg, var(--marketing-color), var(--primary-color));
            color: white;
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table tbody td {
            padding: 15px;
            border-color: #e2e8f0;
        }

        .badge {
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 500;
        }

        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .btn-outline-success {
            border-color: #10b981;
            color: #10b981;
            transition: all 0.3s ease;
        }

        .btn-outline-success:hover {
            background-color: #10b981;
            border-color: #10b981;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-outline-primary {
            border-color: var(--marketing-color);
            color: var(--marketing-color);
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: var(--marketing-color);
            border-color: var(--marketing-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%;
                width: 280px;
                height: 100vh;
                z-index: 1050;
                transition: left 0.3s ease;
                overflow-y: auto;
            }

            .sidebar.show {
                left: 0;
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                display: none;
            }

            .sidebar-overlay.show {
                display: block;
            }

            .main-content {
                padding: 15px;
                margin-left: 0;
            }

            .mobile-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 15px;
                background: white;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                margin-bottom: 20px;
                border-radius: 10px;
            }

            .mobile-menu-btn {
                background: var(--marketing-color);
                color: white;
                border: none;
                padding: 10px 15px;
                border-radius: 8px;
                font-size: 18px;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .mobile-menu-btn:hover {
                background: var(--primary-color);
                transform: scale(1.05);
            }
        }
    </style>

    @stack('styles')
</head>
<body class="marketing-authenticated">
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top shadow-sm">
        <div class="container-fluid">
            <!-- Brand Section -->
            <div class="d-flex align-items-center">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('marketing.dashboard') }}">
                    <div class="brand-icon me-3">
                        <i class="fas fa-bullhorn text-primary"></i>
                    </div>
                    <div class="brand-text">
                        <strong class="brand-name">Infinity Wear</strong>
                        <small class="brand-subtitle d-block">لوحة تحكم التسويق</small>
                    </div>
                </a>
            </div>

            <!-- Center Section - Quick Actions -->
            <div class="d-flex align-items-center flex-grow-1 justify-content-center mx-4">
                <!-- Quick Actions -->
                <div class="quick-actions d-none d-lg-flex">
                    <a href="{{ route('marketing.portfolio.create') }}" class="btn btn-outline-primary btn-sm me-2" title="إضافة مشروع جديد">
                        <i class="fas fa-plus me-1"></i>
                        مشروع جديد
                    </a>
                    <a href="{{ route('marketing.testimonials.create') }}" class="btn btn-outline-success btn-sm me-2" title="إضافة تقييم جديد">
                        <i class="fas fa-star me-1"></i>
                        تقييم جديد
                    </a>
                </div>
            </div>

            <!-- Right Section - User -->
            <div class="d-flex align-items-center">
                <!-- Website Link -->
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-success me-3" title="الذهاب للموقع الإلكتروني">
                    <i class="fas fa-globe me-2"></i>
                    <span class="d-none d-md-inline">الموقع الإلكتروني</span>
                    <span class="d-md-none">الموقع</span>
                </a>
                
                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <div class="user-avatar me-2">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="user-info d-none d-md-block">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <small class="user-role text-muted">فريق التسويق</small>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="dropdown-header">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar-large me-3">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">{{ Auth::user()->name }}</div>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('marketing.profile') }}"><i class="fas fa-user me-2"></i>الملف الشخصي</a></li>
                        <li><a class="dropdown-item" href="#" onclick="toggleDarkMode()"><i class="fas fa-moon me-2"></i>الوضع الليلي</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Header -->
    <div class="mobile-header d-md-none">
        <button class="mobile-menu-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="mb-0 text-primary fw-bold">
            <i class="fas fa-bullhorn me-2"></i>
            لوحة تحكم التسويق
        </h5>
        <div class="dropdown">
            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-user-circle me-1"></i>
                {{ Auth::user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('marketing.profile') }}"><i class="fas fa-user me-2"></i>الملف الشخصي</a></li>
                <li><a class="dropdown-item" href="#" onclick="toggleDarkMode()"><i class="fas fa-moon me-2"></i>الوضع الليلي</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 p-0">
                <div class="sidebar">
                    <div class="p-3">
                        <h5 class="text-white mb-3">
                            <span class="infinity-logo me-2"></span>
                            @yield('dashboard-title', 'لوحة التحكم')
                        </h5>
                    </div>
                    
                    <nav class="nav flex-column px-3">
                        @include('partials.marketing-sidebar')
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9">
                <div class="main-content">
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="page-title">@yield('page-title', 'الرئيسية')</h1>
                            <p class="page-subtitle">@yield('page-subtitle', 'مرحبا بك في لوحة تحكم التسويق')</p>
                        </div>
                        <div>
                            @yield('page-actions')
                        </div>
                    </div>

                    <!-- Alerts -->
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

                    <!-- Main Content -->
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile sidebar toggle function
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        // Close sidebar when clicking on overlay
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            if (event.target === overlay) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        });

        // Close sidebar when clicking on a link (mobile)
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    const sidebar = document.querySelector('.sidebar');
                    const overlay = document.querySelector('.sidebar-overlay');
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        });

        // Dark mode toggle functionality
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            const isDarkMode = document.body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDarkMode);
            
            // Update the icon to show current state
            const moonIcon = document.querySelector('a[onclick="toggleDarkMode()"] i');
            if (moonIcon) {
                if (isDarkMode) {
                    moonIcon.className = 'fas fa-sun me-2';
                } else {
                    moonIcon.className = 'fas fa-moon me-2';
                }
            }
        }

        // Load dark mode preference
        function loadDarkModePreference() {
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            if (isDarkMode) {
                document.body.classList.add('dark-mode');
                
                // Update the icon to show current state
                const moonIcon = document.querySelector('a[onclick="toggleDarkMode()"] i');
                if (moonIcon) {
                    moonIcon.className = 'fas fa-sun me-2';
                }
            }
        }
        
        // Load dark mode on page load
        loadDarkModePreference();
        
        // Also load dark mode when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            loadDarkModePreference();
        });
    </script>
    
    @stack('scripts')
</body>
</html>
