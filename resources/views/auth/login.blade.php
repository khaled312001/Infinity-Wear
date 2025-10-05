@extends('layouts.app')

@section('title', 'تسجيل الدخول - Infinity Wear')
@section('description', 'سجل دخولك إلى حسابك في إنفينيتي وير للوصول إلى جميع الخدمات والمميزات')

@section('styles')
<link href="{{ asset('css/infinity-home.css') }}" rel="stylesheet">
<style>
    .customer-login-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    
    .login-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 100%;
        max-width: 450px;
        margin: 0 auto;
    }
    
    .login-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        padding: 2.5rem 2rem;
        text-align: center;
        position: relative;
    }
    
    .login-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }
    
    .login-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        position: relative;
        z-index: 1;
    }
    
    .login-icon i {
        font-size: 1.8rem;
        color: white;
    }
    
    .login-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }
    
    .login-header p {
        font-size: 1rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }
    
    .login-form {
        padding: 2.5rem 2rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.95rem;
    }
    
    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e1e8ed;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
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
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
        border: none;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
    }
    
    .btn-login:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
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
        accent-color: #3498db;
    }
    
    .remember-me label {
        margin-bottom: 0;
        font-size: 0.9rem;
        color: #2c3e50;
        cursor: pointer;
    }
    
    .error-message {
        background: #fee;
        color: #e74c3c;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        border: 1px solid #fcc;
        font-size: 0.9rem;
    }
    
    .success-message {
        background: #efe;
        color: #27ae60;
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
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-left: 0.5rem;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .login-footer {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e1e8ed;
    }
    
    .login-footer a {
        color: #3498db;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .login-footer a:hover {
        color: #2980b9;
        text-decoration: underline;
    }
    
    .admin-link {
        text-align: center;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e1e8ed;
    }
    
    .admin-link a {
        color: #95a5a6;
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    
    .admin-link a:hover {
        color: #7f8c8d;
        text-decoration: underline;
    }
    
    @media (max-width: 480px) {
        .login-card {
            margin: 1rem;
            max-width: none;
        }
        
        .login-header {
            padding: 2rem 1.5rem;
        }
        
        .login-form {
            padding: 2rem 1.5rem;
        }
        
        .login-header h1 {
            font-size: 1.6rem;
        }
    }
    
    .login-card {
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
@endsection

@section('content')
    <div class="customer-login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">
                    <i class="fas fa-user"></i>
                </div>
                <h1>تسجيل الدخول</h1>
                <p>مرحباً بك في إنفينيتي وير</p>
            </div>

            <div class="login-form">
                @if ($errors->any())
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email">البريد الإلكتروني</label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-group-icon"></i>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   class="form-control" 
                                   value="{{ old('email') }}" 
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
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">تذكرني</label>
                    </div>

                    <button type="submit" class="btn-login" id="loginBtn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span id="btnText">تسجيل الدخول</span>
                        <div class="loading-spinner" id="loadingSpinner"></div>
                    </button>
                </form>

                <div class="login-footer">
                    <p>ليس لديك حساب؟ 
                        <a href="{{ route('register') }}">إنشاء حساب جديد</a>
                    </p>
                </div>

                <div class="admin-link">
                    <a href="{{ route('admin.login') }}">
                        <i class="fas fa-shield-alt"></i>
                        تسجيل دخول الأدمن
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="{{ asset('js/infinity-home.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
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

    console.log('🔐 Customer Login System Loaded');
});
</script>
@endsection
