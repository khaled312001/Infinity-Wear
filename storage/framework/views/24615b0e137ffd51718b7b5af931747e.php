<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول الأدمن - <?php echo e(\App\Helpers\SiteSettingsHelper::getSiteName()); ?></title>
    <meta name="description" content="تسجيل دخول لوحة تحكم الأدمن - <?php echo e(\App\Helpers\SiteSettingsHelper::getSiteName()); ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(\App\Helpers\SiteSettingsHelper::getFaviconUrl()); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(\App\Helpers\SiteSettingsHelper::getFaviconUrl()); ?>">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(\App\Helpers\SiteSettingsHelper::getFaviconUrl()); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(\App\Helpers\SiteSettingsHelper::getFaviconUrl()); ?>">
    
    <!-- Bootstrap RTL CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --dark-color: #34495e;
            --light-color: #ecf0f1;
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .admin-login-container {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            position: relative;
        }

        .admin-login-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-color) 100%);
            color: var(--white);
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .admin-login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .admin-login-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .admin-login-header p {
            font-size: 0.95rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .admin-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            position: relative;
            z-index: 1;
        }

        .admin-icon i {
            font-size: 1.5rem;
            color: var(--white);
        }

        .admin-login-form {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e1e8ed;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
            background: var(--white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-control::placeholder {
            color: #a0aec0;
        }

        .input-group {
            position: relative;
        }

        .input-group .form-control {
            padding-left: 3rem;
        }

        .input-group-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            z-index: 2;
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, var(--secondary-color) 0%, #2980b9 100%);
            color: var(--white);
            border: none;
            padding: 0.875rem 1.5rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-login i {
            margin-left: 0.5rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember-me input[type="checkbox"] {
            margin-left: 0.5rem;
            width: 18px;
            height: 18px;
            accent-color: var(--secondary-color);
        }

        .remember-me label {
            margin-bottom: 0;
            font-size: 0.9rem;
            color: var(--dark-color);
            cursor: pointer;
        }

        .error-message {
            background: #fee;
            color: var(--accent-color);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #fcc;
            font-size: 0.9rem;
        }

        .success-message {
            background: #efe;
            color: var(--success-color);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #cfc;
            font-size: 0.9rem;
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid var(--white);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 0.5rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .back-to-site {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e1e8ed;
        }

        .back-to-site a {
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .back-to-site a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        .security-badge {
            background: rgba(39, 174, 96, 0.1);
            color: var(--success-color);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            margin-top: 1rem;
        }

        .security-badge i {
            margin-left: 0.25rem;
        }

        @media (max-width: 480px) {
            .admin-login-container {
                margin: 10px;
                max-width: none;
            }
            
            .admin-login-header {
                padding: 1.5rem;
            }
            
            .admin-login-form {
                padding: 1.5rem;
            }
            
            .admin-login-header h1 {
                font-size: 1.5rem;
            }
        }

        /* Animation for form appearance */
        .admin-login-container {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="admin-login-container">
        <div class="admin-login-header">
            <div class="admin-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1>لوحة تحكم الأدمن</h1>
            <p>تسجيل دخول آمن ومحمي</p>
        </div>

        <div class="admin-login-form">
            <?php if($errors->any()): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('admin.login')); ?>" id="adminLoginForm">
                <?php echo csrf_field(); ?>
                
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-group-icon"></i>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-control" 
                               value="<?php echo e(old('email')); ?>" 
                               placeholder="أدخل بريدك الإلكتروني"
                               required 
                               autocomplete="email" 
                               autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-group-icon"></i>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-control" 
                               placeholder="أدخل كلمة المرور"
                               required 
                               autocomplete="current-password">
                    </div>
                </div>

                <div class="remember-me">
                    <input type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                    <label for="remember">تذكرني</label>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <i class="fas fa-sign-in-alt"></i>
                    <span id="btnText">تسجيل الدخول</span>
                    <div class="loading-spinner" id="loadingSpinner"></div>
                </button>
            </form>

            <div class="back-to-site">
                <a href="<?php echo e(route('home')); ?>">
                    <i class="fas fa-arrow-right"></i>
                    العودة للموقع الرئيسي
                </a>
            </div>

            <div class="security-badge">
                <i class="fas fa-shield-alt"></i>
                اتصال آمن ومشفر
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('adminLoginForm');
            const loginBtn = document.getElementById('loginBtn');
            const btnText = document.getElementById('btnText');
            const loadingSpinner = document.getElementById('loadingSpinner');

            // Handle form submission
            loginForm.addEventListener('submit', function(e) {
                btnText.style.display = 'none';
                loadingSpinner.style.display = 'inline-block';
                loginBtn.disabled = true;
                
                // Re-enable after 10 seconds (in case of error)
                setTimeout(function() {
                    btnText.style.display = 'inline';
                    loadingSpinner.style.display = 'none';
                    loginBtn.disabled = false;
                }, 10000);
            });

            // Auto-hide success/error messages after 5 seconds
            const messages = document.querySelectorAll('.error-message, .success-message');
            messages.forEach(function(message) {
                setTimeout(function() {
                    message.style.opacity = '0';
                    message.style.transform = 'translateY(-10px)';
                    setTimeout(function() {
                        message.remove();
                    }, 300);
                }, 5000);
            });

            console.log('🔐 Admin Login System Loaded');
        });
    </script>
</body>
</html>
<?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\auth\login.blade.php ENDPATH**/ ?>