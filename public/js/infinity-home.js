// ===== إنفينيتي وير - جافا سكريبت متقدم =====

// تهيئة الموقع عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    initializeInfinityWear();
});

// دالة التهيئة الرئيسية
function initializeInfinityWear() {
    initMobileMenu();
    initSmoothScrolling();
    initScrollAnimations();
    initCounterAnimations();
    initTestimonialSlider();
    initProductFiltering();
    initPortfolioFiltering();
    initContactForm();
    initScrollEffects();
    initIntersectionObserver();
    initPerformanceOptimizations();
    initAccessibilityFeatures();
    initAdvancedAnimations();
}


// القائمة المحمولة
function initMobileMenu() {
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('nav-menu');
    const navLinks = document.querySelectorAll('.nav-link');

    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            hamburger.classList.toggle('active');

            // إضافة انيميشن للـ hamburger
            const spans = hamburger.querySelectorAll('span');
            if (hamburger.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
            } else {
                spans[0].style.transform = 'rotate(0) translate(0, 0)';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'rotate(0) translate(0, 0)';
            }
        });

        // إغلاق القائمة عند النقر على رابط
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navMenu.classList.remove('active');
                hamburger.classList.remove('active');

                const spans = hamburger.querySelectorAll('span');
                spans[0].style.transform = 'rotate(0) translate(0, 0)';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'rotate(0) translate(0, 0)';
            });
        });

        // إغلاق القائمة عند النقر خارجها
        document.addEventListener('click', function(e) {
            if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
                navMenu.classList.remove('active');
                hamburger.classList.remove('active');

                const spans = hamburger.querySelectorAll('span');
                spans[0].style.transform = 'rotate(0) translate(0, 0)';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'rotate(0) translate(0, 0)';
            }
        });
    }
}

// التمرير السلس
function initSmoothScrolling() {
    const links = document.querySelectorAll('a[href^="#"]');

    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                const offsetTop = targetElement.offsetTop - 80; // حساب ارتفاع الشريط العلوي

                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });

                // تحديث الرابط النشط
                updateActiveNavLink(this);
            }
        });
    });
}

// تحديث الرابط النشط في القائمة
function updateActiveNavLink(activeLink) {
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => link.classList.remove('active'));
    activeLink.classList.add('active');
}

// انيميشن الظهور عند التمرير
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;

                // إضافة انيميشن بناءً على نوع العنصر
                if (element.classList.contains('service-card')) {
                    element.style.animation = 'fadeInUp 0.8s ease forwards';
                } else if (element.classList.contains('product-card')) {
                    element.style.animation = 'fadeInUp 0.6s ease forwards';
                } else if (element.classList.contains('portfolio-item')) {
                    element.style.animation = 'fadeInUp 0.7s ease forwards';
                } else if (element.classList.contains('testimonial-card')) {
                    element.style.animation = 'fadeInUp 0.8s ease forwards';
                } else {
                    element.style.animation = 'fadeInUp 0.8s ease forwards';
                }

                observer.unobserve(element);
            }
        });
    }, observerOptions);

    // مراقبة العناصر المختلفة
    const animatedElements = document.querySelectorAll('.service-card, .product-card, .portfolio-item, .testimonial-card, .section-header');
    animatedElements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.animationDelay = `${index * 0.1}s`;
        observer.observe(element);
    });
}

// انيميشن العدادات
function initCounterAnimations() {
    const counters = document.querySelectorAll('.stat-number');

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000; // 2 ثانية
                const increment = target / (duration / 16); // 60fps
                let current = 0;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target.toLocaleString();
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current).toLocaleString();
                    }
                }, 16);

                counterObserver.unobserve(counter);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => {
        counterObserver.observe(counter);
    });
}

// شريط تمرير التقييمات المحسن
function initTestimonialSlider() {
    const testimonials = document.querySelectorAll('.testimonial-card');
    const indicators = document.querySelectorAll('.indicator');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const progressFill = document.querySelector('.progress-fill');
    
    let currentSlide = 0;
    let autoSlideInterval;
    let progressInterval;
    const slideInterval = 6000; // 6 ثواني
    const progressDuration = slideInterval; // نفس مدة الشريط

    // تهيئة الشريط
    function initSlider() {
        if (testimonials.length === 0) return;
        
        // إخفاء جميع الشريطات عدا الأول
        testimonials.forEach((testimonial, index) => {
            testimonial.classList.remove('active', 'prev', 'next');
            if (index === 0) {
                testimonial.classList.add('active');
            } else if (index === testimonials.length - 1) {
                testimonial.classList.add('prev');
            } else if (index === 1) {
                testimonial.classList.add('next');
            }
        });

        // تحديث المؤشرات
        updateIndicators();
        
        // بدء التبديل التلقائي
        startAutoSlide();
        
        // بدء شريط التقدم
        startProgress();
    }

    function showSlide(index, direction = 'next') {
        if (index === currentSlide) return;

        const prevSlide = currentSlide;
        currentSlide = index;

        // إزالة الفئات من جميع الشريطات
        testimonials.forEach(testimonial => {
            testimonial.classList.remove('active', 'prev', 'next');
        });

        // إضافة الفئات المناسبة
        testimonials.forEach((testimonial, i) => {
            if (i === currentSlide) {
                testimonial.classList.add('active');
            } else if (i === (currentSlide - 1 + testimonials.length) % testimonials.length) {
                testimonial.classList.add('prev');
            } else if (i === (currentSlide + 1) % testimonials.length) {
                testimonial.classList.add('next');
            }
        });

        // تحديث المؤشرات
        updateIndicators();
        
        // إعادة تشغيل شريط التقدم
        restartProgress();
    }

    function nextSlide() {
        const nextIndex = (currentSlide + 1) % testimonials.length;
        showSlide(nextIndex, 'next');
    }

    function prevSlide() {
        const prevIndex = (currentSlide - 1 + testimonials.length) % testimonials.length;
        showSlide(prevIndex, 'prev');
    }

    function updateIndicators() {
        indicators.forEach((indicator, i) => {
            indicator.classList.toggle('active', i === currentSlide);
        });
    }

    function startAutoSlide() {
        clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(nextSlide, slideInterval);
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    function startProgress() {
        clearInterval(progressInterval);
        if (progressFill) {
            progressFill.style.width = '0%';
            progressFill.style.transition = `width ${progressDuration}ms linear`;
            
            setTimeout(() => {
                progressFill.style.width = '100%';
            }, 50);
        }
    }

    function restartProgress() {
        startProgress();
    }

    // إضافة تفاعل للمؤشرات
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            stopAutoSlide();
            showSlide(index);
            startAutoSlide();
        });
    });

    // إضافة تفاعل لأزرار التنقل
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            stopAutoSlide();
            prevSlide();
            startAutoSlide();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            stopAutoSlide();
            nextSlide();
            startAutoSlide();
        });
    }

    // إيقاف التبديل التلقائي عند التمرير فوق الشريط
    const sliderContainer = document.querySelector('.testimonials-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', stopAutoSlide);
        sliderContainer.addEventListener('mouseleave', startAutoSlide);
    }

    // دعم التنقل بلوحة المفاتيح
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            stopAutoSlide();
            prevSlide();
            startAutoSlide();
        } else if (e.key === 'ArrowRight') {
            stopAutoSlide();
            nextSlide();
            startAutoSlide();
        }
    });

    // دعم اللمس للأجهزة المحمولة
    let touchStartX = 0;
    let touchEndX = 0;

    if (sliderContainer) {
        sliderContainer.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            stopAutoSlide();
        });

        sliderContainer.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
            startAutoSlide();
        });
    }

    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // مسح لليسار - التالي
                nextSlide();
            } else {
                // مسح لليمين - السابق
                prevSlide();
            }
        }
    }

    // إضافة تأثيرات بصرية متقدمة
    testimonials.forEach((testimonial, index) => {
        testimonial.addEventListener('transitionstart', function() {
            if (this.classList.contains('active')) {
                this.style.transform = 'translateX(0) scale(1)';
            }
        });

        testimonial.addEventListener('transitionend', function() {
            if (this.classList.contains('active')) {
                this.style.transform = 'translateX(0) scale(1)';
            }
        });
    });

    // تهيئة الشريط
    initSlider();

    // تنظيف المؤقتات عند إغلاق الصفحة
    window.addEventListener('beforeunload', () => {
        clearInterval(autoSlideInterval);
        clearInterval(progressInterval);
    });
}

// فلترة المنتجات
function initProductFiltering() {
    const categoryTabs = document.querySelectorAll('.category-tab');
    const productCards = document.querySelectorAll('.product-card');

    categoryTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const category = this.getAttribute('data-category');

            // تحديث التبويبات النشطة
            categoryTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            // فلترة المنتجات
            productCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');

                if (category === 'all' || cardCategory === category) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
}

// فلترة الأعمال
function initPortfolioFiltering() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');

            // تحديث الأزرار النشطة
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // فلترة الأعمال
            portfolioItems.forEach(item => {
                const itemCategory = item.getAttribute('data-category');

                if (filter === 'all' || itemCategory === filter) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
}

// نموذج التواصل المحسن
function initContactForm() {
    const contactForm = document.getElementById('contactForm');
    const submitBtn = contactForm?.querySelector('.btn-submit');
    const messageTextarea = contactForm?.querySelector('#message');
    const charCounter = contactForm?.querySelector('.char-counter .current-count');
    const maxCount = contactForm?.querySelector('.char-counter .max-count');

    if (contactForm) {
        // تحديث عداد الأحرف
        if (messageTextarea && charCounter && maxCount) {
            const maxLength = parseInt(maxCount.textContent) || 500;
            
            messageTextarea.addEventListener('input', function() {
                const currentLength = this.value.length;
                charCounter.textContent = currentLength;
                
                // تغيير لون العداد عند الاقتراب من الحد الأقصى
                if (currentLength > maxLength * 0.9) {
                    charCounter.style.color = '#dc3545';
                } else if (currentLength > maxLength * 0.7) {
                    charCounter.style.color = '#ffc107';
                } else {
                    charCounter.style.color = 'var(--primary-color)';
                }
            });
        }

        // تحسين تجربة المستخدم للحقول
        const formControls = contactForm.querySelectorAll('.form-control');
        formControls.forEach(control => {
            // تأثير التركيز
            control.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            control.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
                validateField(this);
            });

            // تأثير الكتابة
            control.addEventListener('input', function() {
                if (this.value.length > 0) {
                    this.parentElement.classList.add('has-value');
                } else {
                    this.parentElement.classList.remove('has-value');
                }
            });
        });

        // تحسين الخانات المخصصة
        const checkboxes = contactForm.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const label = this.nextElementSibling;
                if (this.checked) {
                    label.classList.add('checked');
                } else {
                    label.classList.remove('checked');
                }
            });
        });

        // إرسال النموذج
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // التحقق من صحة البيانات
            if (validateForm(this)) {
                // إظهار حالة التحميل
                showLoadingState(submitBtn);

                // إرسال البيانات عبر API
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);

                // إضافة معلومات إضافية
                data.timestamp = new Date().toISOString();
                data.userAgent = navigator.userAgent;
                data.referrer = document.referrer;

                fetch('/contact', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(result => {
                    if (result.success) {
                        showSuccessMessage(result.message || 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.');
                        this.reset();
                        resetFormState();
                    } else {
                        showErrorMessage(result.message || 'حدث خطأ أثناء إرسال الرسالة');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (error.message.includes('419')) {
                        showErrorMessage('انتهت صلاحية الجلسة. يرجى تحديث الصفحة والمحاولة مرة أخرى.');
                    } else if (error.message.includes('422')) {
                        showErrorMessage('يرجى التحقق من البيانات المدخلة والمحاولة مرة أخرى.');
                    } else {
                        showErrorMessage('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.');
                    }
                })
                .finally(() => {
                    hideLoadingState(submitBtn);
                });
            }
        });

        // التحقق من الحقول أثناء الكتابة
        const inputs = contactForm.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
        });

        // تحسين تجربة الهاتف
        const phoneInput = contactForm.querySelector('#phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function() {
                // تنسيق رقم الهاتف
                let value = this.value.replace(/\D/g, '');
                if (value.startsWith('966')) {
                    value = '+' + value;
                } else if (value.startsWith('0')) {
                    value = '+966' + value.substring(1);
                } else if (value.length > 0 && !value.startsWith('+')) {
                    value = '+966' + value;
                }
                this.value = value;
            });
        }
    }
}

// إعادة تعيين حالة النموذج
function resetFormState() {
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        const formGroups = contactForm.querySelectorAll('.form-group');
        formGroups.forEach(group => {
            group.classList.remove('focused', 'has-value');
        });

        const checkboxes = contactForm.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            const label = checkbox.nextElementSibling;
            label.classList.remove('checked');
        });

        const charCounter = contactForm.querySelector('.char-counter .current-count');
        if (charCounter) {
            charCounter.textContent = '0';
            charCounter.style.color = 'var(--primary-color)';
        }
    }
}

// التحقق من صحة النموذج
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            showFieldError(field, 'هذا الحقل مطلوب');
            isValid = false;
        } else {
            clearFieldError(field);
        }
    });

    // التحقق من البريد الإلكتروني
    const emailField = form.querySelector('input[type="email"]');
    if (emailField && emailField.value && !isValidEmail(emailField.value)) {
        showFieldError(emailField, 'البريد الإلكتروني غير صحيح');
        isValid = false;
    }

    return isValid;
}

// التحقق من صحة الحقل
function validateField(field) {
    const value = field.value.trim();

    if (field.hasAttribute('required') && !value) {
        showFieldError(field, 'هذا الحقل مطلوب');
        return false;
    }

    if (field.type === 'email' && value && !isValidEmail(value)) {
        showFieldError(field, 'البريد الإلكتروني غير صحيح');
        return false;
    }

    clearFieldError(field);
    return true;
}

// إظهار رسالة خطأ في الحقل
function showFieldError(field, message) {
    clearFieldError(field);

    field.classList.add('error');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.textContent = message;

    field.parentNode.appendChild(errorDiv);
}

// مسح رسالة الخطأ
function clearFieldError(field) {
    field.classList.remove('error');
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
}

// التحقق من صحة البريد الإلكتروني
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// إظهار حالة التحميل
function showLoadingState(button) {
    if (button) {
        button.classList.add('loading');
        button.disabled = true;
    }
}

// إخفاء حالة التحميل
function hideLoadingState(button) {
    if (button) {
        button.classList.remove('loading');
        button.disabled = false;
    }
}

// إظهار رسالة نجاح
function showSuccessMessage(customMessage = null) {
    const message = document.createElement('div');
    message.className = 'success-message';
    message.innerHTML = `
        <i class="fas fa-check-circle"></i>
        <div>
            <h4>${customMessage || 'تم إرسال رسالتك بنجاح!'}</h4>
            <p>سنتواصل معك قريباً</p>
        </div>
    `;

    document.body.appendChild(message);

    setTimeout(() => {
        message.style.opacity = '0';
        message.style.transform = 'translateY(-20px)';
        setTimeout(() => message.remove(), 300);
    }, 3000);
}

// إظهار رسالة خطأ
function showErrorMessage(errorMessage) {
    const message = document.createElement('div');
    message.className = 'error-message';
    message.innerHTML = `
        <i class="fas fa-exclamation-triangle"></i>
        <div>
            <h4>حدث خطأ!</h4>
            <p>${errorMessage}</p>
        </div>
    `;

    document.body.appendChild(message);

    setTimeout(() => {
        message.style.opacity = '0';
        message.style.transform = 'translateY(-20px)';
        setTimeout(() => message.remove(), 300);
    }, 5000);
}

// تأثيرات التمرير
function initScrollEffects() {
    let ticking = false;

    function updateScrollEffects() {
        const scrollY = window.pageYOffset;

        // تأثير الشريط العلوي
        const navbar = document.querySelector('.infinity-navbar');
        if (navbar) {
            if (scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }

        // تأثير الخلفية في قسم البطل
        const hero = document.querySelector('.infinity-hero');
        if (hero) {
            const heroBackground = hero.querySelector('.infinity-hero-background');
            if (heroBackground) {
                const speed = scrollY * 0.5;
                heroBackground.style.transform = `translateY(${speed}px)`;
            }
        }

        ticking = false;
    }

    function requestScrollUpdate() {
        if (!ticking) {
            requestAnimationFrame(updateScrollEffects);
            ticking = true;
        }
    }

    window.addEventListener('scroll', requestScrollUpdate);
}

// مراقب التقاطع للانيميشن
function initIntersectionObserver() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;

                // إضافة انيميشن بناءً على نوع العنصر
                if (element.classList.contains('animate-on-scroll')) {
                    element.classList.add('animate-in');
                }

                observer.unobserve(element);
            }
        });
    }, observerOptions);

    // مراقبة العناصر
    const scrollElements = document.querySelectorAll('.animate-on-scroll');
    scrollElements.forEach(element => {
        observer.observe(element);
    });
}

// تحسينات الأداء
function initPerformanceOptimizations() {
    // تحميل الصور بالكسل
    if ('loading' in HTMLImageElement.prototype) {
        const images = document.querySelectorAll('img[data-src]');
        images.forEach(img => {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
    } else {
        // Fallback للمتصفحات القديمة
        loadImagesLazily();
    }

    // تحسين التمرير
    let scrollTimer;
    window.addEventListener('scroll', function() {
        if (scrollTimer) {
            clearTimeout(scrollTimer);
        }
        scrollTimer = setTimeout(handleScroll, 16); // 60fps
    });
}

// تحميل الصور بالكسل (fallback)
function loadImagesLazily() {
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });

    const lazyImages = document.querySelectorAll('img[data-src]');
    lazyImages.forEach(img => imageObserver.observe(img));
}

// معالجة التمرير
function handleScroll() {
    // يمكن إضافة منطق إضافي هنا
}

// ميزات الوصولية
function initAccessibilityFeatures() {
    // دعم التنقل باستخدام لوحة المفاتيح
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-navigation');
        }
    });

    document.addEventListener('mousedown', function() {
        document.body.classList.remove('keyboard-navigation');
    });

    // تحسين التركيز للأزرار
    const buttons = document.querySelectorAll('button, .btn');
    buttons.forEach(button => {
        button.addEventListener('focus', function() {
            this.classList.add('focused');
        });

        button.addEventListener('blur', function() {
            this.classList.remove('focused');
        });
    });
}

// انيميشن متقدمة
function initAdvancedAnimations() {
    // انيميشن الفقاعات في قسم البطل
    createFloatingBubbles();

    // انيميشن النجوم في الخلفية
    createStarField();

    // انيميشن النصوص المتحركة
    animateTypingText();
}

// إنشاء فقاعات متحركة
function createFloatingBubbles() {
    const hero = document.querySelector('.hero');
    if (!hero) return;

    const bubblesContainer = document.createElement('div');
    bubblesContainer.className = 'floating-bubbles';
    hero.appendChild(bubblesContainer);

    for (let i = 0; i < 20; i++) {
        setTimeout(() => {
            const bubble = document.createElement('div');
            bubble.className = 'bubble';
            bubble.style.left = Math.random() * 100 + '%';
            bubble.style.animationDelay = Math.random() * 3 + 's';
            bubble.style.animationDuration = (Math.random() * 3 + 2) + 's';
            bubblesContainer.appendChild(bubble);
        }, i * 200);
    }
}

// إنشاء حقل نجوم
function createStarField() {
    const sections = document.querySelectorAll('.hero, .about, .contact');
    sections.forEach(section => {
        if (section.querySelector('.stars')) return;

        const starsContainer = document.createElement('div');
        starsContainer.className = 'stars';

        for (let i = 0; i < 50; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            star.style.left = Math.random() * 100 + '%';
            star.style.top = Math.random() * 100 + '%';
            star.style.animationDelay = Math.random() * 3 + 's';
            starsContainer.appendChild(star);
        }

        section.insertBefore(starsContainer, section.firstChild);
    });
}

// انيميشن الكتابة للنصوص
function animateTypingText() {
    const typingElements = document.querySelectorAll('.typing-text');
    typingElements.forEach(element => {
        const text = element.textContent;
        element.textContent = '';
        element.style.opacity = '1';

        let i = 0;
        const timer = setInterval(() => {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
            } else {
                clearInterval(timer);
            }
        }, 100);
    });
}

// أدوات مساعدة
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// تهيئة الموقع عند التحميل الكامل
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeInfinityWear);
} else {
    initializeInfinityWear();
}

// إضافة CSS للانيميشن الديناميكي
if (!document.querySelector('#infinity-dynamic-styles')) {
    const dynamicStyles = document.createElement('style');
    dynamicStyles.id = 'infinity-dynamic-styles';
    dynamicStyles.textContent = `
    .bubble {
        position: absolute;
        width: 20px;
        height: 20px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .stars {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }

    .star {
        position: absolute;
        width: 2px;
        height: 2px;
        background: white;
        border-radius: 50%;
        animation: twinkle 3s ease-in-out infinite;
    }

    @keyframes twinkle {
        0%, 100% { opacity: 0.3; }
        50% { opacity: 1; }
    }

    .field-error {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .field-error::before {
        content: '⚠';
        font-size: 0.8rem;
    }

    .success-message {
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideInRight 0.3s ease;
    }

    .error-message {
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: slideInRight 0.3s ease;
    }

    .keyboard-navigation *:focus {
        outline: 3px solid #007bff !important;
        outline-offset: 2px !important;
    }

    .btn.loading {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .btn.loading::after {
        content: '';
        width: 20px;
        height: 20px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-left: 0.5rem;
    }

    .animate-on-scroll {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .animate-on-scroll.animate-in {
        opacity: 1;
        transform: translateY(0);
    }

    .infinity-navbar.scrolled {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.95) 0%, rgba(118, 75, 162, 0.95) 100%);
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
    }
`;

document.head.appendChild(dynamicStyles);
}
