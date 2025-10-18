<?php $__env->startSection('title', 'من نحن - Infinity Wear'); ?>
<?php $__env->startSection('description', 'تعرف على مؤسسة الزي اللامحدود - شركة سعودية رائدة في تصميم وإنتاج الملابس الرياضية والزي الموحد للفرق والمدارس والشركات'); ?>

<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('css/infinity-home.css')); ?>" rel="stylesheet">
<style>
/* تصميم محسن لصفحة About */
.about-hero-section {
    min-height: 80vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.about-hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="aboutPattern" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23aboutPattern)"/></svg>');
    pointer-events: none;
}

.about-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
}

.about-hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    text-shadow: 0 4px 8px rgba(0,0,0,0.3);
    animation: slideInFromTop 1s ease-out;
}

.about-hero-subtitle {
    font-size: 1.3rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
    animation: slideInFromBottom 1s ease-out 0.3s both;
}

@keyframes slideInFromTop {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInFromBottom {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* تحسينات الأقسام */
.about-content-section {
    padding: 5rem 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    position: relative;
}

.about-content-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="contentPattern" width="30" height="30" patternUnits="userSpaceOnUse"><circle cx="15" cy="15" r="0.5" fill="%23000" opacity="0.02"/></pattern></defs><rect width="100" height="100" fill="url(%23contentPattern)"/></svg>');
    pointer-events: none;
}

.about-main-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border-radius: 25px;
    padding: 4rem;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    position: relative;
    overflow: hidden;
    margin-bottom: 3rem;
}

.about-main-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.02) 0%, rgba(118, 75, 162, 0.02) 100%);
    z-index: 1;
}

.about-main-content {
    position: relative;
    z-index: 2;
}

.about-company-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2d3748;
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
}

.about-company-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
}

.about-company-description {
    font-size: 1.2rem;
    color: #4a5568;
    text-align: center;
    line-height: 1.8;
    margin-bottom: 3rem;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

/* بطاقات الرؤية والرسالة */
.about-vision-mission {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.about-vision-card, .about-mission-card {
    background: linear-gradient(135deg, #ffffff 0%, #f7fafc 100%);
    padding: 2.5rem;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    border: 1px solid rgba(102, 126, 234, 0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.about-vision-card::before, .about-mission-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.03) 0%, rgba(118, 75, 162, 0.03) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.about-vision-card:hover::before, .about-mission-card:hover::before {
    opacity: 1;
}

.about-vision-card:hover, .about-mission-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(102, 126, 234, 0.15);
}

.about-vision-icon, .about-mission-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
}

.about-vision-card:hover .about-vision-icon, .about-mission-card:hover .about-mission-icon {
    transform: scale(1.1) rotate(5deg);
}

.about-vision-title, .about-mission-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1rem;
}

.about-vision-text, .about-mission-text {
    color: #4a5568;
    line-height: 1.7;
    font-size: 1rem;
}

/* قسم القيم */
.about-values-section {
    margin-top: 3rem;
}

.about-values-title {
    font-size: 2rem;
    font-weight: 600;
    color: #2d3748;
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
}

.about-values-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
}

.about-values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.about-value-item {
    background: linear-gradient(135deg, #ffffff 0%, #f7fafc 100%);
    padding: 2rem;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    border: 1px solid rgba(102, 126, 234, 0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.about-value-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.02) 0%, rgba(118, 75, 162, 0.02) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.about-value-item:hover::before {
    opacity: 1;
}

.about-value-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.1);
}

.about-value-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
    transition: all 0.3s ease;
}

.about-value-item:hover .about-value-icon {
    transform: scale(1.1);
}

.about-value-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.about-value-text {
    color: #4a5568;
    font-size: 0.9rem;
    line-height: 1.6;
}

/* قسم رؤية 2030 */
.about-vision2030-section {
    padding: 5rem 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.about-vision2030-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="vision2030Pattern" width="40" height="40" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23vision2030Pattern)"/></svg>');
    pointer-events: none;
}

.about-vision2030-content {
    position: relative;
    z-index: 2;
}

.about-vision2030-title {
    font-size: 2.5rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.about-vision2030-subtitle {
    font-size: 1.2rem;
    text-align: center;
    opacity: 0.9;
    margin-bottom: 3rem;
}

.about-vision2030-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.about-vision2030-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 2.5rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.about-vision2030-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.about-vision2030-card:hover::before {
    opacity: 1;
}

.about-vision2030-card:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
}

.about-vision2030-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
    transition: all 0.3s ease;
}

.about-vision2030-card:hover .about-vision2030-icon {
    transform: scale(1.1);
    background: rgba(255, 255, 255, 0.3);
}

.about-vision2030-card-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.about-vision2030-card-text {
    opacity: 0.9;
    line-height: 1.7;
}

/* قسم الخدمات */
.about-services-section {
    padding: 5rem 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.about-services-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2d3748;
    text-align: center;
    margin-bottom: 1rem;
    position: relative;
}

.about-services-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
}

.about-services-subtitle {
    font-size: 1.2rem;
    color: #4a5568;
    text-align: center;
    margin-bottom: 3rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.about-services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.about-service-card {
    background: linear-gradient(135deg, #ffffff 0%, #f7fafc 100%);
    border-radius: 20px;
    padding: 2.5rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    border: 1px solid rgba(102, 126, 234, 0.1);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.about-service-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.03) 0%, rgba(118, 75, 162, 0.03) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.about-service-card:hover::before {
    opacity: 1;
}

.about-service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(102, 126, 234, 0.15);
}

.about-service-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
    transition: all 0.3s ease;
}

.about-service-card:hover .about-service-icon {
    transform: scale(1.1) rotate(5deg);
}

.about-service-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 1rem;
}

.about-service-text {
    color: #4a5568;
    line-height: 1.7;
}

/* قسم الفريق */
.about-team-section {
    padding: 5rem 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.about-team-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="teamPattern" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23teamPattern)"/></svg>');
    pointer-events: none;
}

.about-team-content {
    position: relative;
    z-index: 2;
}

.about-team-title {
    font-size: 2.5rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 1rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.about-team-subtitle {
    font-size: 1.2rem;
    text-align: center;
    opacity: 0.9;
    margin-bottom: 3rem;
}

.about-team-visual {
    text-align: center;
    margin-bottom: 3rem;
}

.about-team-image {
    height: 200px;
    background-image: url('<?php echo e(asset('images/sections/team-collaboration.svg')); ?>');
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat;
    margin: 2rem 0;
    filter: brightness(1.2);
}

.about-team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.about-team-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 2.5rem;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.about-team-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.about-team-card:hover::before {
    opacity: 1;
}

.about-team-card:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
}

.about-team-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
    transition: all 0.3s ease;
}

.about-team-card:hover .about-team-icon {
    transform: scale(1.1);
    background: rgba(255, 255, 255, 0.3);
}

.about-team-title-text {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.about-team-text {
    opacity: 0.9;
    line-height: 1.7;
}

/* التصميم المتجاوب */
@media (max-width: 768px) {
    .about-hero-title {
        font-size: 2.5rem;
    }
    
    .about-hero-subtitle {
        font-size: 1.1rem;
    }
    
    .about-main-card {
        padding: 2rem;
    }
    
    .about-company-title {
        font-size: 2rem;
    }
    
    .about-company-description {
        font-size: 1.1rem;
    }
    
    .about-vision-mission {
        grid-template-columns: 1fr;
    }
    
    .about-values-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
    
    .about-vision2030-grid,
    .about-services-grid,
    .about-team-grid {
        grid-template-columns: 1fr;
    }
    
    .about-vision2030-title,
    .about-services-title,
    .about-team-title {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .about-hero-title {
        font-size: 2rem;
    }
    
    .about-main-card {
        padding: 1.5rem;
    }
    
    .about-company-title {
        font-size: 1.8rem;
    }
    
    .about-values-grid {
        grid-template-columns: 1fr;
    }
    
    .about-value-item,
    .about-vision-card,
    .about-mission-card,
    .about-vision2030-card,
    .about-service-card,
    .about-team-card {
        padding: 1.5rem;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <section class="about-hero-section">
        <div class="container">
            <div class="about-hero-content">
                <h1 class="about-hero-title">من نحن</h1>
                <p class="about-hero-subtitle">مؤسسة سعودية متخصصة في توريد الملابس الرياضية والزي الموحد</p>
            </div>
        </div>
    </section>

<!-- About Content -->
<section class="about-content-section">
    <div class="container">
        <div class="about-main-card">
            <div class="about-main-content">
                <h2 class="about-company-title">Infinity Wear</h2>
                <p class="about-company-description">
                    مؤسسة الزي اللامحدود - رؤيتنا هي توفير أفضل الملابس الرياضية والزي الموحد 
                    للأكاديميات الرياضية في المملكة العربية السعودية، نشارك في تحقيق رؤية 2030
                </p>
                
                <div class="about-vision-mission">
                    <div class="about-vision-card">
                        <div class="about-vision-icon">
                            <i class="fas fa-target"></i>
                        </div>
                        <h5 class="about-vision-title">رؤيتنا</h5>
                        <p class="about-vision-text">أن نكون الخيار الأول في توريد الملابس الرياضية والزي الموحد في المملكة العربية السعودية، ونساهم في تحقيق رؤية 2030</p>
                    </div>
                    
                    <div class="about-mission-card">
                        <div class="about-mission-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h5 class="about-mission-title">رسالتنا</h5>
                        <p class="about-mission-text">توفير منتجات عالية الجودة مع خدمة عملاء متميزة وابتكار في التصميم، مع دعم الرياضة والتعليم في المملكة</p>
                    </div>
                </div>
                
                <div class="about-values-section">
                    <h3 class="about-values-title">قيمنا</h3>
                    <div class="about-values-grid">
                        <div class="about-value-item">
                            <div class="about-value-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h6 class="about-value-title">ثقة</h6>
                            <p class="about-value-text">نحن نثق في جودة منتجاتنا ونضمن رضا عملائنا الكرام</p>
                        </div>
                        
                        <div class="about-value-item">
                            <div class="about-value-icon">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <h6 class="about-value-title">سرعة</h6>
                            <p class="about-value-text">نوفر خدمات سريعة وفعالة لتلبية احتياجات عملائنا في الوقت المحدد</p>
                        </div>
                        
                        <div class="about-value-item">
                            <div class="about-value-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h6 class="about-value-title">مصداقية</h6>
                            <p class="about-value-text">نلتزم بالشفافية والمصداقية في جميع تعاملاتنا مع العملاء</p>
                        </div>
                        
                        <div class="about-value-item">
                            <div class="about-value-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <h6 class="about-value-title">جودة</h6>
                            <p class="about-value-text">نستخدم أفضل المواد والتقنيات في تصنيع منتجاتنا</p>
                        </div>
                        
                        <div class="about-value-item">
                            <div class="about-value-icon">
                                <i class="fas fa-palette"></i>
                            </div>
                            <h6 class="about-value-title">تصميم</h6>
                            <p class="about-value-text">نقدم تصاميم عصرية ومبتكرة تناسب جميع الأذواق والاحتياجات</p>
                        </div>
                        
                        <div class="about-value-item">
                            <div class="about-value-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <h6 class="about-value-title">احترافية</h6>
                            <p class="about-value-text">فريق عمل محترف ومتخصص في مجال الملابس الرياضية</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision 2030 Section -->
<section class="about-vision2030-section">
    <div class="container">
        <div class="about-vision2030-content">
            <h2 class="about-vision2030-title">رؤية 2030</h2>
            <p class="about-vision2030-subtitle">نشارك في تحقيق رؤية المملكة العربية السعودية 2030</p>
            
            <div class="about-vision2030-grid">
                <div class="about-vision2030-card">
                    <div class="about-vision2030-icon">
                        <i class="fas fa-running"></i>
                    </div>
                    <h5 class="about-vision2030-card-title">دعم الرياضة</h5>
                    <p class="about-vision2030-card-text">نساهم في تطوير الرياضة السعودية من خلال توفير أفضل الملابس الرياضية للأكاديميات والفرق</p>
                </div>
                
                <div class="about-vision2030-card">
                    <div class="about-vision2030-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h5 class="about-vision2030-card-title">التعليم والتدريب</h5>
                    <p class="about-vision2030-card-text">نوفر زي موحد عالي الجودة للمدارس والأكاديميات لتعزيز الهوية والانتماء</p>
                </div>
                
                <div class="about-vision2030-card">
                    <div class="about-vision2030-icon">
                        <i class="fas fa-industry"></i>
                    </div>
                    <h5 class="about-vision2030-card-title">التصنيع المحلي</h5>
                    <p class="about-vision2030-card-text">نساهم في التنويع الاقتصادي من خلال التصنيع المحلي للملابس الرياضية</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="about-services-section">
    <div class="container">
        <h2 class="about-services-title">خدماتنا</h2>
        <p class="about-services-subtitle">نقدم مجموعة شاملة من الخدمات المتخصصة</p>
        
        <div class="about-services-grid">
            <div class="about-service-card">
                <div class="about-service-icon">
                    <i class="fas fa-tshirt"></i>
                </div>
                <h5 class="about-service-title">ملابس رياضية</h5>
                <p class="about-service-text">أفضل الملابس الرياضية للأكاديميات والفرق الرياضية</p>
            </div>
            
            <div class="about-service-card">
                <div class="about-service-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h5 class="about-service-title">زي مدرسي</h5>
                <p class="about-service-text">زي موحد أنيق ومريح للمدارس والأكاديميات</p>
            </div>
            
            <div class="about-service-card">
                <div class="about-service-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h5 class="about-service-title">زي شركات</h5>
                <p class="about-service-text">زي موحد احترافي للشركات والمؤسسات</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="about-team-section">
    <div class="container">
        <div class="about-team-content">
            <h2 class="about-team-title">فريق العمل</h2>
            <p class="about-team-subtitle">فريق محترف ومتخصص في خدمتكم</p>
            
            <div class="about-team-visual">
                <div class="about-team-image"></div>
            </div>
            
            <div class="about-team-grid">
                <div class="about-team-card">
                    <div class="about-team-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 class="about-team-title-text">فريق التصميم</h5>
                    <p class="about-team-text">مصممون محترفون يبتكرون أفضل التصاميم</p>
                </div>
                
                <div class="about-team-card">
                    <div class="about-team-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h5 class="about-team-title-text">فريق الإنتاج</h5>
                    <p class="about-team-text">خبراء في التصنيع والجودة</p>
                </div>
                
                <div class="about-team-card">
                    <div class="about-team-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5 class="about-team-title-text">خدمة العملاء</h5>
                    <p class="about-team-text">فريق دعم متاح لخدمتكم على مدار الساعة</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/infinity-home.js')); ?>"></script>
<script>
// أنيميشن إضافي لصفحة About
document.addEventListener('DOMContentLoaded', function() {
    // أنيميشن العناصر عند التمرير
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // مراقبة العناصر للأنيميشن
    const animatedElements = document.querySelectorAll('.about-vision-card, .about-mission-card, .about-value-item, .about-vision2030-card, .about-service-card, .about-team-card');
    
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });

    // تأثير hover للبطاقات
    const cards = document.querySelectorAll('.about-vision-card, .about-mission-card, .about-value-item, .about-vision2030-card, .about-service-card, .about-team-card');
    
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views/about.blade.php ENDPATH**/ ?>