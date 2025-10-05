<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'لوحة التحكم'); ?> - Infinity Wear</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('images/logo.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('images/logo.png')); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('images/logo.svg')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('images/logo.png')); ?>">
    
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
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-color) 100%);
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

        /* Notification Badge Styling */
        .notification-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            border-radius: 12px;
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 700;
            line-height: 1;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
            z-index: 10;
            animation: notificationPulse 2s infinite;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        /* For larger numbers, make it wider */
        .notification-badge:not([style*="display: none"]):has-text("9") {
            min-width: 24px;
        }

        .notification-badge:not([style*="display: none"]):has-text("99") {
            min-width: 28px;
        }

        @keyframes notificationPulse {
            0% {
                transform: scale(1);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }
            50% {
                transform: scale(1.1);
                box-shadow: 0 4px 8px rgba(239, 68, 68, 0.4);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }
        }

        .notification-badge:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }

        /* Responsive adjustments for notification badge */
        @media (max-width: 768px) {
            .notification-badge {
                top: 6px;
                right: 6px;
                min-width: 18px;
                height: 18px;
                font-size: 0.6rem;
            }
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

        .stats-card.enhanced {
            padding: 20px;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        }

        .stats-card.enhanced::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stats-label {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .stats-trend {
            margin-top: 8px;
            font-size: 0.8rem;
        }

        .stats-chart {
            position: absolute;
            top: 20px;
            right: 20px;
            opacity: 0.3;
        }

        /* Welcome Card Styles */
        .welcome-card {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
        }

        .welcome-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .welcome-actions .btn {
            border-radius: 8px;
            font-weight: 500;
        }

        .welcome-actions .btn-outline-primary {
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .welcome-actions .btn-outline-primary:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
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

        .stats-icon.primary { background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); }
        .stats-icon.success { background: linear-gradient(135deg, #10b981, #34d399); }
        .stats-icon.warning { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
        .stats-icon.danger { background: linear-gradient(135deg, #ef4444, #f87171); }
        .stats-icon.info { background: linear-gradient(135deg, #3b82f6, #60a5fa); }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
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
            background: linear-gradient(135deg, #60a5fa, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        }

        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .table {
            margin: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
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

        .navbar-brand {
            font-weight: 800;
            color: var(--primary-color) !important;
        }

        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 15px 0;
        }

        /* Brand Section Styles */
        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .brand-name {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-bottom: 0;
        }

        .brand-subtitle {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: -2px;
        }

        /* Search Container Styles */
        .search-container {
            min-width: 300px;
        }

        .search-container .input-group-text {
            border-radius: 10px 0 0 10px;
            border-color: #e2e8f0;
        }

        .search-container .form-control {
            border-radius: 0 10px 10px 0;
            border-color: #e2e8f0;
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .search-container .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
        }

        .search-container .btn {
            border-radius: 0 10px 10px 0;
            border-color: #e2e8f0;
        }

        /* Quick Actions Styles */
        .quick-actions .btn {
            position: relative;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.85rem;
        }

        .quick-actions .badge {
            font-size: 0.7rem;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Notification Dropdown Styles */
        .notification-dropdown {
            width: 350px;
            max-height: 400px;
            overflow-y: auto;
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .notification-item {
            padding: 15px 20px;
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .notification-item:hover {
            background-color: #f8fafc;
        }
        
        .notification-item.unread {
            background-color: #e3f2fd;
            border-left: 3px solid #2196f3;
        }
        
        .notification-item.read {
            opacity: 0.7;
        }
        
        .notification-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: #f8f9fa;
        }
        
        .notification-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .notification-message {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .notification-actions {
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        
        .notification-item:hover .notification-actions {
            opacity: 1;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-icon {
            width: 35px;
            height: 35px;
            background: #f1f5f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .notification-content h6 {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .notification-content p {
            font-size: 0.8rem;
            line-height: 1.4;
        }

        /* User Dropdown Styles */
        .user-dropdown {
            width: 280px;
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
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
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
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
            color: var(--primary-color);
        }

        .user-role {
            font-size: 0.75rem;
        }

        /* Badge Animations */
        .badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* Hover Effects */
        .navbar .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .brand-icon:hover {
            transform: rotate(360deg);
            transition: transform 0.5s ease;
        }

        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .infinity-logo::before {
            content: "∞";
            font-size: 1.2em;
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-bottom: 20px;
            }
            
            .stats-card {
                margin-bottom: 15px;
            }
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        .recent-activity {
            max-height: 400px;
            overflow-y: auto;
        }

        .activity-item {
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
            transition: background-color 0.3s ease;
        }

        .activity-item:hover {
            background-color: #f8fafc;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .progress {
            height: 8px;
            border-radius: 10px;
        }

        .progress-bar {
            border-radius: 10px;
        }

        /* Website Link Button Styles */
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

        .btn-outline-success:focus {
            box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
        }

        /* تحسينات إضافية للوحة التحكم */
        .stats-card {
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .stats-card:hover::before {
            height: 6px;
        }

        .dashboard-card {
            position: relative;
        }

        .dashboard-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .dashboard-card:hover::after {
            opacity: 1;
        }

        /* تحسينات للرسم البياني */
        .chart-container {
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            border-radius: 10px;
            padding: 20px;
        }

        /* تحسينات للنشاط الأخير */
        .activity-item {
            position: relative;
            padding-left: 20px;
        }

        .activity-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            background: var(--primary-color);
            border-radius: 50%;
        }

        .activity-item:hover::before {
            background: var(--secondary-color);
            transform: translateY(-50%) scale(1.2);
        }

        /* تحسينات للأزرار */
        .btn {
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.3s ease, height 0.3s ease;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        /* تحسينات للشريط الجانبي */
        .sidebar .nav-link {
            position: relative;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: rgba(255, 255, 255, 0.2);
            transition: width 0.3s ease;
        }

        .sidebar .nav-link:hover::before,
        .sidebar .nav-link.active::before {
            width: 4px;
        }

        /* تحسينات للتنبيهات */
        .alert {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #10b981, #34d399);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(135deg, #ef4444, #f87171);
            color: white;
        }

        .alert-warning {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: white;
        }

        .alert-info {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            color: white;
        }

        /* Mobile Responsive Styles */
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
                background: var(--primary-color);
                color: white;
                border: none;
                padding: 10px 15px;
                border-radius: 8px;
                font-size: 18px;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .mobile-menu-btn:hover {
                background: var(--dark-color);
                transform: scale(1.05);
            }

            .stats-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 15px;
                margin-bottom: 20px;
            }

            .stats-card {
                padding: 20px;
                text-align: center;
            }

            .stats-card h3 {
                font-size: 2rem;
                margin-bottom: 10px;
            }

            .stats-card p {
                font-size: 0.9rem;
                margin-bottom: 5px;
            }

            .chart-container {
                height: 300px;
                margin-bottom: 20px;
            }

            .activity-list {
                max-height: 400px;
                overflow-y: auto;
            }

            .activity-item {
                padding: 15px;
                margin-bottom: 10px;
                border-radius: 10px;
                background: white;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }

            .btn-group {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
                margin-bottom: 15px;
            }

            .btn-group .btn {
                flex: 1;
                min-width: 80px;
                font-size: 0.8rem;
                padding: 8px 12px;
            }

            .table-responsive {
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }

            .table {
                font-size: 0.85rem;
            }

            .table th,
            .table td {
                padding: 8px 12px;
                vertical-align: middle;
            }

            .card {
                margin-bottom: 20px;
                border-radius: 15px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            }

            .card-header {
                padding: 15px 20px;
                background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
                border-bottom: 1px solid #e2e8f0;
                border-radius: 15px 15px 0 0 !important;
            }

            .card-body {
                padding: 20px;
            }

            .form-control,
            .form-select {
                border-radius: 8px;
                border: 2px solid #e2e8f0;
                padding: 12px 15px;
                font-size: 0.9rem;
                transition: all 0.3s ease;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
            }

            .btn {
                border-radius: 8px;
                padding: 10px 20px;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                border: none;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
            }

            .modal-dialog {
                margin: 10px;
                max-width: calc(100% - 20px);
            }

            .modal-content {
                border-radius: 15px;
                border: none;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            }

            .modal-header {
                border-bottom: 1px solid #e2e8f0;
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }

            .modal-body {
                padding: 20px;
            }

            .modal-footer {
                border-top: 1px solid #e2e8f0;
                border-radius: 0 0 15px 15px;
                padding: 20px;
            }

            .navbar {
                padding: 10px 15px;
                background: white;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                border-radius: 10px;
                margin-bottom: 20px;
            }

            .navbar-brand {
                font-size: 1.2rem;
                font-weight: 700;
                color: var(--primary-color);
            }

            .dropdown-menu {
                border-radius: 10px;
                border: none;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                padding: 10px 0;
            }

            .dropdown-item {
                padding: 10px 20px;
                transition: all 0.3s ease;
            }

            .dropdown-item:hover {
                background: var(--light-color);
                color: var(--primary-color);
            }

            .badge {
                font-size: 0.75rem;
                padding: 6px 10px;
                border-radius: 20px;
            }

            .text-truncate {
                max-width: 150px;
            }

            .d-flex {
                flex-wrap: wrap;
            }

            .justify-content-between {
                justify-content: center !important;
                gap: 10px;
            }

            .align-items-center {
                align-items: flex-start !important;
            }

            .mb-3 {
                margin-bottom: 15px !important;
            }

            .mb-4 {
                margin-bottom: 20px !important;
            }

            .p-3 {
                padding: 15px !important;
            }

            .p-4 {
                padding: 20px !important;
            }

            .h-100 {
                height: auto !important;
            }

            .w-100 {
                width: 100% !important;
            }

            .col-md-6,
            .col-lg-4,
            .col-lg-6,
            .col-lg-8,
            .col-xl-4,
            .col-xl-6,
            .col-xl-8 {
                margin-bottom: 20px;
            }

            .row {
                margin: 0 -10px;
            }

            .row > * {
                padding: 0 10px;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 10px;
            }

            .mobile-header {
                padding: 10px;
                margin-bottom: 15px;
            }

            .stats-card {
                padding: 15px;
            }

            .stats-card h3 {
                font-size: 1.5rem;
            }

            .chart-container {
                height: 250px;
            }

            .card-body {
                padding: 15px;
            }

            .btn {
                padding: 8px 15px;
                font-size: 0.85rem;
            }

            .table {
                font-size: 0.8rem;
            }

            .table th,
            .table td {
                padding: 6px 8px;
            }

            .modal-dialog {
                margin: 5px;
                max-width: calc(100% - 10px);
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding: 15px;
            }
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="admin-authenticated">
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top shadow-sm">
        <div class="container-fluid">
            <!-- Brand Section -->
            <div class="d-flex align-items-center">
                <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('admin.dashboard')); ?>">
                    <div class="brand-icon me-3">
                        <i class="fas fa-infinity text-primary"></i>
                    </div>
                    <div class="brand-text">
                        <strong class="brand-name">Infinity Wear</strong>
                        <small class="brand-subtitle d-block">لوحة التحكم الإدارية</small>
                    </div>
                </a>
            </div>

            <!-- Center Section - Search & Quick Actions -->
            <div class="d-flex align-items-center flex-grow-1 justify-content-center mx-4">
              

                <!-- Quick Actions -->
                <div class="quick-actions d-none d-lg-flex">
                    <a href="<?php echo e(route('admin.tasks.index')); ?>" class="btn btn-outline-warning btn-sm me-2" title="المهام المعلقة">
                        <i class="fas fa-tasks me-1"></i>
                        <span class="badge bg-warning position-absolute top-0 start-100 translate-middle rounded-pill" id="pendingTasksBadge">0</span>
                    </a>
                    <a href="<?php echo e(route('admin.importers.index')); ?>" class="btn btn-outline-info btn-sm me-2" title="المستوردين الجدد">
                        <i class="fas fa-industry me-1"></i>
                        <span class="badge bg-info position-absolute top-0 start-100 translate-middle rounded-pill" id="newImportersBadge">0</span>
                    </a>
                </div>
            </div>

            <!-- Right Section - User -->
            <div class="d-flex align-items-center">

                <!-- Website Link -->
                <a href="<?php echo e(route('home')); ?>" target="_blank" class="btn btn-outline-success me-3" title="الذهاب للموقع الإلكتروني">
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
                            <div class="user-name">
                                <?php if(Auth::guard('admin')->check()): ?>
                                    <?php echo e(Auth::guard('admin')->user()->name); ?>

                                <?php else: ?>
                                    <?php echo e(Auth::user()->name); ?>

                                <?php endif; ?>
                            </div>
                            <small class="user-role text-muted">
                                <?php if(Auth::guard('admin')->check()): ?>
                                    مدير النظام
                                <?php else: ?>
                                    <?php echo e(Auth::user()->user_type_label); ?>

                                <?php endif; ?>
                            </small>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end user-dropdown">
                        <li class="dropdown-header">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar-large me-3">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">
                                        <?php if(Auth::guard('admin')->check()): ?>
                                            <?php echo e(Auth::guard('admin')->user()->name); ?>

                                        <?php else: ?>
                                            <?php echo e(Auth::user()->name); ?>

                                        <?php endif; ?>
                                    </div>
                                    <small class="text-muted">
                                        <?php if(Auth::guard('admin')->check()): ?>
                                            <?php echo e(Auth::guard('admin')->user()->email); ?>

                                        <?php else: ?>
                                            <?php echo e(Auth::user()->email); ?>

                                        <?php endif; ?>
                                    </small>
                                </div>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo e(Auth::guard('admin')->check() ? route('admin.profile') : route(Auth::user()->user_type . '.profile')); ?>"><i class="fas fa-user me-2"></i>الملف الشخصي</a></li>
                        <?php if(Auth::guard('admin')->check()): ?>
                            <li><a class="dropdown-item" href="<?php echo e(route('admin.admin-settings')); ?>"><i class="fas fa-cog me-2"></i>الإعدادات</a></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="#" onclick="toggleDarkMode()"><i class="fas fa-moon me-2"></i>الوضع الليلي</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="<?php echo e(Auth::guard('admin')->check() ? route('admin.logout') : route('logout')); ?>" class="d-inline">
                                <?php echo csrf_field(); ?>
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
            <i class="fas fa-tachometer-alt me-2"></i>
            لوحة التحكم
        </h5>
        <div class="dropdown">
            <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-user-circle me-1"></i>
                <?php if(Auth::guard('admin')->check()): ?>
                    <?php echo e(Auth::guard('admin')->user()->name); ?>

                <?php else: ?>
                    <?php echo e(Auth::user()->name); ?>

                <?php endif; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?php echo e(Auth::guard('admin')->check() ? route('admin.profile') : route(Auth::user()->user_type . '.profile')); ?>"><i class="fas fa-user me-2"></i>الملف الشخصي</a></li>
                <?php if(Auth::guard('admin')->check()): ?>
                    <li><a class="dropdown-item" href="<?php echo e(route('admin.admin-settings')); ?>"><i class="fas fa-cog me-2"></i>الإعدادات</a></li>
                <?php endif; ?>
                <li><a class="dropdown-item" href="#" onclick="toggleDarkMode()"><i class="fas fa-moon me-2"></i>الوضع الليلي</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="<?php echo e(Auth::guard('admin')->check() ? route('admin.logout') : route('logout')); ?>" class="d-inline">
                        <?php echo csrf_field(); ?>
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
                            <?php echo $__env->yieldContent('dashboard-title', 'لوحة التحكم'); ?>
                        </h5>
                    </div>
                    
                    <nav class="nav flex-column px-3">
                        <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9">
                <div class="main-content">
                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="page-title"><?php echo $__env->yieldContent('page-title', 'الرئيسية'); ?></h1>
                            <p class="page-subtitle"><?php echo $__env->yieldContent('page-subtitle', 'مرحبا بك في لوحة التحكم'); ?></p>
                        </div>
                        <div>
                            <?php echo $__env->yieldContent('page-actions'); ?>
                        </div>
                    </div>

                    <!-- Alerts -->
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Main Content -->
                    <?php echo $__env->yieldContent('content'); ?>
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
            const menuBtn = document.querySelector('.mobile-menu-btn');
            
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

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize popovers
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });

        // Global Search Functionality - Disabled until search input is added
        // document.getElementById('globalSearch').addEventListener('input', function(e) {
        //     const searchTerm = e.target.value.toLowerCase();
        //     if (searchTerm.length > 2) {
        //         // Implement search functionality here
        //         console.log('Searching for:', searchTerm);
        //     }
        // });

        // Update notification badges with real data (excluding notifications badge)
        function updateNotificationBadges() {
            // Check if required elements exist before making the request
            const pendingTasksBadge = document.getElementById('pendingTasksBadge');
            const newImportersBadge = document.getElementById('newImportersBadge');
            
            if (!pendingTasksBadge && !newImportersBadge) {
                // If neither badge exists, this page doesn't need notification badges
                return;
            }
            
            // If only one badge exists, we can still update it
            if (!pendingTasksBadge || !newImportersBadge) {
                console.log('Some notification badge elements not found, updating available ones');
            }
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.warn('CSRF token not found');
                return;
            }

            console.log('Fetching notification stats from:', '<?php echo e(route("admin.notifications.stats")); ?>');
            
            fetch('<?php echo e(route("admin.notifications.stats")); ?>', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                console.log('Stats response status:', response.status);
                if (response.status === 401 || response.status === 403) {
                    // User not authenticated, hide badges
                    console.log('User not authenticated for stats');
                    if (pendingTasksBadge) {
                        pendingTasksBadge.textContent = '0';
                        pendingTasksBadge.style.display = 'none';
                    }
                    if (newImportersBadge) {
                        newImportersBadge.textContent = '0';
                        newImportersBadge.style.display = 'none';
                    }
                    // Hide sidebar notification badge
                    const sidebarBadge = document.getElementById('sidebarNotificationsBadge');
                    if (sidebarBadge) {
                        sidebarBadge.textContent = '0';
                        sidebarBadge.style.display = 'none';
                    }
                    return null;
                }
                if (!response.ok) {
                    console.error('Stats response not ok:', response.status, response.statusText);
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (!data) return; // Handle authentication error
                if (data.success) {
                    const stats = data.stats;
                    
                    if (pendingTasksBadge) {
                        pendingTasksBadge.textContent = stats.importer_orders || 0;
                        pendingTasksBadge.style.display = (stats.importer_orders || 0) > 0 ? 'flex' : 'none';
                    }
                    
                    if (newImportersBadge) {
                        newImportersBadge.textContent = stats.contacts || 0;
                        newImportersBadge.style.display = (stats.contacts || 0) > 0 ? 'flex' : 'none';
                    }
                    
                    // Update sidebar notification badge
                    const sidebarBadge = document.getElementById('sidebarNotificationsBadge');
                    if (sidebarBadge) {
                        const unreadCount = stats.total_unread || 0;
                        sidebarBadge.textContent = unreadCount;
                        
                        if (unreadCount > 0) {
                            sidebarBadge.style.display = 'flex';
                            // Add special styling for high numbers
                            if (unreadCount > 99) {
                                sidebarBadge.textContent = '99+';
                                sidebarBadge.style.minWidth = '32px';
                            } else if (unreadCount > 9) {
                                sidebarBadge.style.minWidth = '24px';
                            } else {
                                sidebarBadge.style.minWidth = '20px';
                            }
                        } else {
                            sidebarBadge.style.display = 'none';
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching notification stats:', error);
                // Set default values on error
                if (pendingTasksBadge) {
                    pendingTasksBadge.textContent = '0';
                    pendingTasksBadge.style.display = 'none';
                }
                if (newImportersBadge) {
                    newImportersBadge.textContent = '0';
                    newImportersBadge.style.display = 'none';
                }
                // Hide sidebar notification badge on error
                const sidebarBadge = document.getElementById('sidebarNotificationsBadge');
                if (sidebarBadge) {
                    sidebarBadge.textContent = '0';
                    sidebarBadge.style.display = 'none';
                }
            });
        }

        // Update badges on page load
        updateNotificationBadges();

        // Update badges every 30 seconds
        setInterval(updateNotificationBadges, 30000);

        // Initialize sidebar notification badge on page load
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarBadge = document.getElementById('sidebarNotificationsBadge');
            if (sidebarBadge) {
                // Ensure badge is hidden initially
                sidebarBadge.style.display = 'none';
            }
        });

        // Initialize notification system (simplified)
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing notification system...');
            updateNotificationBadges();
            console.log('Notification system initialized');
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
            
            // Show notification
            if (typeof showNotification === 'function') {
                showNotification(isDarkMode ? 'تم تفعيل الوضع الليلي' : 'تم إلغاء الوضع الليلي', 'success');
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
        
        // Also load dark mode when DOM is ready (for dynamic content)
        document.addEventListener('DOMContentLoaded', function() {
            loadDarkModePreference();
        });

        // Add dark mode styles
        const darkModeStyles = `
            .dark-mode {
                background-color: #1a1a1a !important;
                color: #ffffff !important;
            }
            .dark-mode .navbar {
                background-color: #2d2d2d !important;
                border-bottom-color: #404040 !important;
            }
            .dark-mode .navbar-brand,
            .dark-mode .navbar-nav .nav-link {
                color: #ffffff !important;
            }
            .dark-mode .sidebar {
                background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%) !important;
            }
            .dark-mode .dashboard-card,
            .dark-mode .stats-card,
            .dark-mode .card {
                background-color: #2d2d2d !important;
                color: #ffffff !important;
                border-color: #404040 !important;
            }
            .dark-mode .card-header {
                background-color: #3d3d3d !important;
                border-bottom-color: #404040 !important;
                color: #ffffff !important;
            }
            .dark-mode .form-control {
                background-color: #404040 !important;
                border-color: #555555 !important;
                color: #ffffff !important;
            }
            .dark-mode .form-control:focus {
                background-color: #404040 !important;
                border-color: #667eea !important;
                color: #ffffff !important;
                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
            }
            .dark-mode .dropdown-menu {
                background-color: #2d2d2d !important;
                border-color: #404040 !important;
            }
            .dark-mode .dropdown-item {
                color: #ffffff !important;
            }
            .dark-mode .dropdown-item:hover {
                background-color: #404040 !important;
            }
            .dark-mode .table {
                color: #ffffff !important;
            }
            .dark-mode .table th,
            .dark-mode .table td {
                border-color: #404040 !important;
            }
            .dark-mode .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(255, 255, 255, 0.05) !important;
            }
            .dark-mode .btn-primary {
                background-color: #667eea !important;
                border-color: #667eea !important;
            }
            .dark-mode .btn-primary:hover {
                background-color: #5a67d8 !important;
                border-color: #5a67d8 !important;
            }
            .dark-mode .text-muted {
                color: #a0a0a0 !important;
            }
            .dark-mode .border {
                border-color: #404040 !important;
            }
            .dark-mode .alert {
                background-color: #2d2d2d !important;
                border-color: #404040 !important;
                color: #ffffff !important;
            }
        `;

        // Add dark mode styles to head
        const styleSheet = document.createElement('style');
        styleSheet.textContent = darkModeStyles;
        document.head.appendChild(styleSheet);

        // Dark mode toggle is handled by onclick attribute
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH F:\infinity\Infinity-Wear\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>