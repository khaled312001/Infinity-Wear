@extends('layouts.app')

@section('title', 'اتصل بنا - Infinity Wear')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-4">اتصل بنا</h1>
                <p class="lead">نحن هنا لخدمتكم في أي وقت</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">أرسل لنا رسالة</h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">الاسم</label>
                                    <input type="text" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">رقم الهاتف</label>
                                    <input type="tel" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">الموضوع</label>
                                    <select class="form-select" required>
                                        <option value="">اختر الموضوع</option>
                                        <option value="استفسار">استفسار</option>
                                        <option value="طلب عرض سعر">طلب عرض سعر</option>
                                        <option value="شكوى">شكوى</option>
                                        <option value="اقتراح">اقتراح</option>
                                        <option value="أخرى">أخرى</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">الرسالة</label>
                                <textarea class="form-control" rows="5" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                إرسال الرسالة
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">معلومات التواصل</h4>
                    </div>
                    <div class="card-body">
                        <div class="contact-info">
                            <div class="contact-item mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="infinity-logo me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">الهاتف</h6>
                                        <p class="mb-0">+966 50 123 4567</p>
                                        <p class="mb-0">+966 11 234 5678</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-item mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="infinity-logo me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">البريد الإلكتروني</h6>
                                        <p class="mb-0">info@infinitywear.sa</p>
                                        <p class="mb-0">sales@infinitywear.sa</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-item mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="infinity-logo me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">العنوان</h6>
                                        <p class="mb-0">الرياض المملكة العربية السعودية</p>
                                        <p class="mb-0">شارع الملك فهد حي النخيل</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="d-flex align-items-center">
                                    <div class="infinity-logo me-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">ساعات العمل</h6>
                                        <p class="mb-0">الأحد - الخميس: 8:00 ص - 6:00 م</p>
                                        <p class="mb-0">الجمعة - السبت: مغلق</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="mb-0">تابعنا</h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="social-links">
                            <a href="#" class="btn btn-outline-primary me-2 mb-2">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info me-2 mb-2">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger me-2 mb-2">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary me-2 mb-2">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="btn btn-outline-success me-2 mb-2">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="section-title">الأسئلة الشائعة</h2>
                <p class="lead">إجابات على أكثر الأسئلة شيوعا</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                ما هي مدة التسليم
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                مدة التسليم تتراوح بين 7-14 يوم عمل حسب الكمية والتصميم المطلوب.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                هل يمكن تخصيص التصميم
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                نعم يمكنكم تخصيص التصميم باستخدام أداة التصميم المخصصة على الموقع.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                ما هي طرق الدفع المتاحة
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                نقبل الدفع نقدا عند التسليم التحويل البنكي والدفع الإلكتروني.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                هل تقدمون خدمة التوصيل
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                نعم نقدم خدمة التوصيل لجميع أنحاء المملكة العربية السعودية.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
