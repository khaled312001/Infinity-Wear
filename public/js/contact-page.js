/* ===== صفحة الاتصال - JavaScript محسن ===== */

document.addEventListener('DOMContentLoaded', function() {
    
    // تهيئة جميع الوظائف
    initContactForm();
    initFAQAccordion();
    initCharCounter();
    initFormValidation();
    initAnimations();
    
    // تهيئة نموذج الاتصال
    function initContactForm() {
        const form = document.getElementById('contactForm');
        const submitBtn = document.querySelector('.contact-submit-btn');
        
        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // إظهار حالة التحميل
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                
                // محاكاة إرسال النموذج (يمكن استبدالها بالكود الفعلي)
                setTimeout(() => {
                    // إعادة تعيين النموذج
                    form.reset();
                    updateCharCounter();
                    
                    // إخفاء حالة التحميل
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                    
                    // إظهار رسالة نجاح
                    showSuccessMessage('تم إرسال رسالتك بنجاح! سنرد عليك في أقرب وقت ممكن.');
                    
                }, 2000);
            });
        }
    }
    
    // تهيئة نظام الأسئلة الشائعة
    function initFAQAccordion() {
        const faqItems = document.querySelectorAll('.contact-faq-item');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.contact-faq-question');
            
            if (question) {
                question.addEventListener('click', function() {
                    const isActive = item.classList.contains('active');
                    
                    // إغلاق جميع العناصر الأخرى
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                        }
                    });
                    
                    // تبديل الحالة الحالية
                    if (isActive) {
                        item.classList.remove('active');
                    } else {
                        item.classList.add('active');
                    }
                });
            }
        });
    }
    
    // تهيئة عداد الأحرف
    function initCharCounter() {
        const messageTextarea = document.getElementById('message');
        const charCountElement = document.getElementById('charCount');
        
        if (messageTextarea && charCountElement) {
            messageTextarea.addEventListener('input', updateCharCounter);
            
            function updateCharCounter() {
                const currentLength = messageTextarea.value.length;
                const maxLength = 1000;
                
                charCountElement.textContent = currentLength;
                
                // تغيير لون العداد عند الاقتراب من الحد الأقصى
                if (currentLength > maxLength * 0.9) {
                    charCountElement.style.color = '#ef4444';
                } else if (currentLength > maxLength * 0.7) {
                    charCountElement.style.color = '#f59e0b';
                } else {
                    charCountElement.style.color = '#2563eb';
                }
            }
            
            // تحديث العداد عند التحميل
            updateCharCounter();
        }
    }
    
    // تهيئة التحقق من صحة النموذج
    function initFormValidation() {
        const form = document.getElementById('contactForm');
        const inputs = form ? form.querySelectorAll('.contact-form-input') : [];
        
        inputs.forEach(input => {
            // التحقق عند فقدان التركيز
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            // التحقق أثناء الكتابة
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateField(this);
                }
            });
        });
    }
    
    // التحقق من صحة حقل واحد
    function validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name;
        let isValid = true;
        let errorMessage = '';
        
        // التحقق من الحقول المطلوبة
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'هذا الحقل مطلوب';
        }
        
        // التحقق من البريد الإلكتروني
        if (fieldName === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'يرجى إدخال بريد إلكتروني صحيح';
            }
        }
        
        // التحقق من رقم الهاتف
        if (fieldName === 'phone' && value) {
            const phoneRegex = /^[\+]?[0-9\s\-\(\)]{10,}$/;
            if (!phoneRegex.test(value)) {
                isValid = false;
                errorMessage = 'يرجى إدخال رقم هاتف صحيح';
            }
        }
        
        // التحقق من طول الرسالة
        if (fieldName === 'message' && value) {
            if (value.length < 10) {
                isValid = false;
                errorMessage = 'يجب أن تكون الرسالة أكثر من 10 أحرف';
            } else if (value.length > 1000) {
                isValid = false;
                errorMessage = 'يجب أن تكون الرسالة أقل من 1000 حرف';
            }
        }
        
        // تطبيق النتيجة
        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
        }
        
        // إظهار أو إخفاء رسالة الخطأ
        showFieldError(field, errorMessage);
        
        return isValid;
    }
    
    // إظهار رسالة خطأ للحقل
    function showFieldError(field, message) {
        // إزالة رسائل الخطأ السابقة
        const existingError = field.parentNode.querySelector('.contact-invalid-feedback');
        if (existingError) {
            existingError.remove();
        }
        
        // إضافة رسالة الخطأ الجديدة
        if (message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'contact-invalid-feedback';
            errorDiv.textContent = message;
            field.parentNode.appendChild(errorDiv);
        }
    }
    
    // تهيئة الأنيميشنز
    function initAnimations() {
        // أنيميشن العناصر عند الظهور
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
        
        // مراقبة العناصر
        const animatedElements = document.querySelectorAll('.contact-feature-card, .contact-info-card, .contact-faq-item');
        animatedElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
        
        // أنيميشن الإحصائيات
        animateStats();
    }
    
    // أنيميشن الإحصائيات
    function animateStats() {
        const statItems = document.querySelectorAll('.contact-stat-item');
        
        statItems.forEach((item, index) => {
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, index * 200);
        });
    }
    
    // إظهار رسالة نجاح
    function showSuccessMessage(message) {
        // إنشاء عنصر التنبيه
        const alertDiv = document.createElement('div');
        alertDiv.className = 'contact-alert contact-alert-success';
        alertDiv.innerHTML = `
            <i class="fas fa-check-circle contact-alert-icon"></i>
            <div class="contact-alert-content">
                <h6>تم بنجاح!</h6>
                <p>${message}</p>
            </div>
        `;
        
        // إدراج التنبيه في بداية النموذج
        const form = document.getElementById('contactForm');
        if (form) {
            form.insertBefore(alertDiv, form.firstChild);
            
            // إزالة التنبيه بعد 5 ثوان
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
    }
    
    // تحديث عداد الأحرف (دالة عامة)
    function updateCharCounter() {
        const messageTextarea = document.getElementById('message');
        const charCountElement = document.getElementById('charCount');
        
        if (messageTextarea && charCountElement) {
            const currentLength = messageTextarea.value.length;
            charCountElement.textContent = currentLength;
        }
    }
    
    // تحسين تجربة المستخدم للأجهزة المحمولة
    function initMobileOptimizations() {
        // منع التكبير عند التركيز على الحقول
        const inputs = document.querySelectorAll('.contact-form-input');
        inputs.forEach(input => {
            if (input.type === 'tel' || input.type === 'email') {
                input.addEventListener('focus', function() {
                    if (window.innerWidth < 768) {
                        setTimeout(() => {
                            window.scrollTo(0, 0);
                        }, 300);
                    }
                });
            }
        });
    }
    
    // تهيئة التحسينات للأجهزة المحمولة
    initMobileOptimizations();
    
    // إضافة تأثيرات تفاعلية للبطاقات
    function initCardInteractions() {
        const cards = document.querySelectorAll('.contact-info-card, .contact-feature-card');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    }
    
    // تهيئة التفاعلات
    initCardInteractions();
    
    // تحسين الأداء
    function optimizePerformance() {
        // تأخير تحميل الصور غير الضرورية
        const images = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
    }
    
    // تهيئة تحسينات الأداء
    optimizePerformance();
    
    // إضافة تأثيرات صوتية (اختيارية)
    function initSoundEffects() {
        const buttons = document.querySelectorAll('.contact-submit-btn, .contact-btn');
        
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                // يمكن إضافة صوت نقر هنا
                // playClickSound();
            });
        });
    }
    
    // تهيئة التأثيرات الصوتية
    initSoundEffects();
    
    // إضافة دعم لوحة المفاتيح
    function initKeyboardSupport() {
        document.addEventListener('keydown', function(e) {
            // إغلاق FAQ بالضغط على Escape
            if (e.key === 'Escape') {
                const activeFAQ = document.querySelector('.contact-faq-item.active');
                if (activeFAQ) {
                    activeFAQ.classList.remove('active');
                }
            }
            
            // إرسال النموذج بالضغط على Ctrl+Enter
            if (e.ctrlKey && e.key === 'Enter') {
                const form = document.getElementById('contactForm');
                if (form) {
                    form.dispatchEvent(new Event('submit'));
                }
            }
        });
    }
    
    // تهيئة دعم لوحة المفاتيح
    initKeyboardSupport();
    
    // إضافة تحليلات الأحداث (اختيارية)
    function trackEvents() {
        // تتبع النقرات على الأزرار
        const buttons = document.querySelectorAll('.contact-submit-btn, .contact-card-link');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                // يمكن إضافة تتبع الأحداث هنا
                // analytics.track('button_click', { button: this.textContent });
            });
        });
        
        // تتبع فتح/إغلاق FAQ
        const faqItems = document.querySelectorAll('.contact-faq-item');
        faqItems.forEach(item => {
            item.addEventListener('click', function() {
                const question = this.querySelector('.contact-faq-question h4').textContent;
                // analytics.track('faq_toggle', { question: question });
            });
        });
    }
    
    // تهيئة تتبع الأحداث
    trackEvents();
    
    console.log('صفحة الاتصال تم تحميلها بنجاح! 🚀');
});

// دوال مساعدة عامة
window.ContactPage = {
    // إعادة تعيين النموذج
    resetForm: function() {
        const form = document.getElementById('contactForm');
        if (form) {
            form.reset();
            updateCharCounter();
            
            // إزالة جميع رسائل الخطأ
            const errorMessages = form.querySelectorAll('.contact-invalid-feedback');
            errorMessages.forEach(error => error.remove());
            
            // إزالة فئات التحقق
            const inputs = form.querySelectorAll('.contact-form-input');
            inputs.forEach(input => {
                input.classList.remove('is-valid', 'is-invalid');
            });
        }
    },
    
    // إظهار رسالة مخصصة
    showMessage: function(message, type = 'success') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `contact-alert contact-alert-${type}`;
        alertDiv.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} contact-alert-icon"></i>
            <div class="contact-alert-content">
                <h6>${type === 'success' ? 'تم بنجاح!' : 'تنبيه!'}</h6>
                <p>${message}</p>
            </div>
        `;
        
        const form = document.getElementById('contactForm');
        if (form) {
            form.insertBefore(alertDiv, form.firstChild);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
    },
    
    // فتح/إغلاق FAQ
    toggleFAQ: function(index) {
        const faqItems = document.querySelectorAll('.contact-faq-item');
        if (faqItems[index]) {
            faqItems[index].classList.toggle('active');
        }
    }
};
