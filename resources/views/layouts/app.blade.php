<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Infinity Wear - مؤسسة اللباس اللامحدود')</title>
    <meta name="description" content="@yield('description', 'Infinity Wear - مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية')">
    
    <!-- Bootstrap RTL CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
            --accent-color: #60a5fa;
            --dark-blue: #1e40af;
            --light-blue: #dbeafe;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8fafc;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--accent-color) !important;
            transform: translateY(-2px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 58, 138, 0.4);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .footer {
            background: linear-gradient(135deg, var(--primary-color), var(--dark-blue));
            color: white;
            padding: 40px 0;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 80px 0;
        }
        
        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 30px;
        }
        
        .infinity-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, var(--secondary-color), var(--accent-color));
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="infinity-logo"></span>
                Infinity Wear
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">المنتجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">الفئات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('services') }}">خدماتنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">من نحن</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">اتصل بنا</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('custom-designs.index') }}">
                                <i class="fas fa-palette"></i> تصميمي
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> إنشاء حساب
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="mb-3">
                        <span class="infinity-logo"></span>
                        Infinity Wear
                    </h5>
                    <p>مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية</p>
                    <div class="mt-3">
                        <h6>قيمنا:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success"></i> ثقة</li>
                            <li><i class="fas fa-check text-success"></i> سرعة</li>
                            <li><i class="fas fa-check text-success"></i> مصداقية</li>
                            <li><i class="fas fa-check text-success"></i> جودة</li>
                            <li><i class="fas fa-check text-success"></i> تصميم</li>
                            <li><i class="fas fa-check text-success"></i> احترافية</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <h5 class="mb-3">روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-light text-decoration-none">الرئيسية</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-light text-decoration-none">المنتجات</a></li>
                        <li><a href="{{ route('categories.index') }}" class="text-light text-decoration-none">الفئات</a></li>
                        <li><a href="{{ route('services') }}" class="text-light text-decoration-none">خدماتنا</a></li>
                        <li><a href="{{ route('about') }}" class="text-light text-decoration-none">من نحن</a></li>
                        <li><a href="{{ route('contact') }}" class="text-light text-decoration-none">اتصل بنا</a></li>
                    </ul>
                </div>
                
                <div class="col-md-4">
                    <h5 class="mb-3">تواصل معنا</h5>
                    <div class="mb-3">
                        <i class="fas fa-phone me-2"></i>
                        <span>+966 50 123 4567</span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-envelope me-2"></i>
                        <span>info@infinitywear.sa</span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <span>الرياض، المملكة العربية السعودية</span>
                    </div>
                    <div class="mt-3">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; 2025 Infinity Wear. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
