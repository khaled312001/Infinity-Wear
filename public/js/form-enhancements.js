/**
 * Form Enhancements & Dynamic Interactions
 * Professional interactions and animations
 */

(function() {
    'use strict';

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        initCounterAnimations();
        initHoverEffects();
        initScrollAnimations();
        initFormValidations();
        initProgressTracking();
        initTooltips();
        initParticleEffects();
    }

    // ==================== Counter Animations ====================
    function initCounterAnimations() {
        const counters = document.querySelectorAll('.summary-value, .total-value');
        
        counters.forEach(counter => {
            const observer = new MutationObserver(() => {
                animateCounter(counter);
            });
            
            observer.observe(counter, {
                childList: true,
                characterData: true,
                subtree: true
            });
        });
    }

    function animateCounter(element) {
        element.classList.add('changed');
        setTimeout(() => {
            element.classList.remove('changed');
        }, 500);
    }

    // ==================== Hover Effects ====================
    function initHoverEffects() {
        // Add ripple effect to buttons
        document.querySelectorAll('.btn, .piece-option, .pattern-option').forEach(element => {
            element.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.5);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s ease-out;
                    pointer-events: none;
                    z-index: 1000;
                `;
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        });

        // Add style for ripple animation
        if (!document.getElementById('ripple-styles')) {
            const style = document.createElement('style');
            style.id = 'ripple-styles';
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }

    // ==================== Scroll Animations ====================
    function initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe elements
        document.querySelectorAll('.control-section, .form-step, .design-option-card').forEach(el => {
            observer.observe(el);
        });
    }

    // ==================== Form Validations ====================
    function initFormValidations() {
        const inputs = document.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            // Real-time validation
            input.addEventListener('blur', function() {
                validateField(this);
            });

            // Success feedback
            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateField(this);
                }
                
                if (this.value && !this.classList.contains('is-invalid')) {
                    this.classList.add('is-valid');
                    addSuccessCheckmark(this);
                }
            });
        });
    }

    function validateField(field) {
        const isValid = field.checkValidity();
        
        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
            addSuccessCheckmark(field);
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
            removeSuccessCheckmark(field);
        }
    }

    function addSuccessCheckmark(field) {
        if (field.nextElementSibling?.classList.contains('success-checkmark')) {
            return;
        }
        
        const checkmark = document.createElement('span');
        checkmark.className = 'success-checkmark';
        checkmark.innerHTML = '✓';
        checkmark.style.cssText = `
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #28a745;
            font-weight: bold;
            font-size: 1.2rem;
            animation: checkmarkPop 0.3s ease;
        `;
        
        field.parentElement.style.position = 'relative';
        field.parentElement.appendChild(checkmark);

        // Add animation
        if (!document.getElementById('checkmark-styles')) {
            const style = document.createElement('style');
            style.id = 'checkmark-styles';
            style.textContent = `
                @keyframes checkmarkPop {
                    0% { transform: translateY(-50%) scale(0); }
                    50% { transform: translateY(-50%) scale(1.2); }
                    100% { transform: translateY(-50%) scale(1); }
                }
            `;
            document.head.appendChild(style);
        }
    }

    function removeSuccessCheckmark(field) {
        const checkmark = field.parentElement.querySelector('.success-checkmark');
        if (checkmark) {
            checkmark.remove();
        }
    }

    // ==================== Progress Tracking ====================
    function initProgressTracking() {
        const steps = document.querySelectorAll('.step-item');
        let currentStep = 1;

        // Update progress on step change
        const observer = new MutationObserver(() => {
            updateProgressAnimation();
        });

        document.querySelectorAll('.form-step').forEach(step => {
            observer.observe(step, {
                attributes: true,
                attributeFilter: ['class', 'style']
            });
        });
    }

    function updateProgressAnimation() {
        const activeStep = document.querySelector('.form-step.active');
        if (activeStep) {
            const stepNumber = activeStep.id.replace('step', '');
            animateProgressBar(parseInt(stepNumber));
        }
    }

    function animateProgressBar(stepNumber) {
        const percentage = (stepNumber / 4) * 100;
        const progressBar = document.querySelector('.progress-bar');
        
        if (progressBar) {
            progressBar.style.width = percentage + '%';
            progressBar.style.transition = 'width 0.8s ease';
        }

        // Animate step indicators
        document.querySelectorAll('.step-item').forEach((item, index) => {
            if (index < stepNumber) {
                item.classList.add('completed');
                item.classList.add('pulse-once');
                setTimeout(() => item.classList.remove('pulse-once'), 1000);
            }
        });
    }

    // ==================== Tooltips ====================
    function initTooltips() {
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        
        tooltipElements.forEach(element => {
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            tooltip.textContent = element.dataset.tooltip;
            tooltip.style.cssText = `
                position: absolute;
                background: rgba(0, 0, 0, 0.9);
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 6px;
                font-size: 0.85rem;
                white-space: nowrap;
                pointer-events: none;
                z-index: 10000;
                opacity: 0;
                transform: translateY(10px);
                transition: all 0.3s ease;
            `;
            
            document.body.appendChild(tooltip);
            
            element.addEventListener('mouseenter', function(e) {
                const rect = this.getBoundingClientRect();
                tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
                tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
                tooltip.style.opacity = '1';
                tooltip.style.transform = 'translateY(0)';
            });
            
            element.addEventListener('mouseleave', function() {
                tooltip.style.opacity = '0';
                tooltip.style.transform = 'translateY(10px)';
            });
        });
    }

    // ==================== Particle Effects ====================
    function initParticleEffects() {
        const hero = document.querySelector('.hero-inner-section');
        if (!hero) return;

        // Create particles container
        const particlesContainer = document.createElement('div');
        particlesContainer.className = 'particles-container';
        particlesContainer.style.cssText = `
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        `;
        
        hero.style.position = 'relative';
        hero.insertBefore(particlesContainer, hero.firstChild);

        // Create floating particles
        for (let i = 0; i < 20; i++) {
            createParticle(particlesContainer);
        }
    }

    function createParticle(container) {
        const particle = document.createElement('div');
        const size = Math.random() * 6 + 2;
        const duration = Math.random() * 10 + 10;
        const delay = Math.random() * 5;
        const startX = Math.random() * 100;
        
        particle.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            background: rgba(102, 126, 234, ${Math.random() * 0.3 + 0.1});
            border-radius: 50%;
            left: ${startX}%;
            bottom: -10px;
            animation: floatUp ${duration}s ease-in ${delay}s infinite;
        `;
        
        container.appendChild(particle);

        // Add animation keyframes if not exists
        if (!document.getElementById('particle-styles')) {
            const style = document.createElement('style');
            style.id = 'particle-styles';
            style.textContent = `
                @keyframes floatUp {
                    0% {
                        transform: translateY(0) translateX(0) rotate(0deg);
                        opacity: 0;
                    }
                    10% {
                        opacity: 1;
                    }
                    90% {
                        opacity: 1;
                    }
                    100% {
                        transform: translateY(-100vh) translateX(${Math.random() * 100 - 50}px) rotate(360deg);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }

    // ==================== Size Input Enhancement ====================
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('size-input') || 
            e.target.classList.contains('size-quantity')) {
            
            const input = e.target;
            const group = input.closest('.size-input-group, .size-item');
            
            if (input.value > 0) {
                group.classList.add('has-value');
                input.style.fontWeight = 'bold';
                input.style.color = '#667eea';
            } else {
                group.classList.remove('has-value');
                input.style.fontWeight = 'normal';
                input.style.color = '';
            }
        }
    });

    // ==================== Smooth Scroll to Active Step ====================
    function scrollToActiveStep() {
        const activeStep = document.querySelector('.form-step.active');
        if (activeStep) {
            activeStep.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }
    }

    // Listen for step changes
    const stepObserver = new MutationObserver(() => {
        scrollToActiveStep();
    });

    document.querySelectorAll('.form-step').forEach(step => {
        stepObserver.observe(step, {
            attributes: true,
            attributeFilter: ['class']
        });
    });

    // ==================== Loading State for Form Submission ====================
    const form = document.getElementById('multiStepForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>جاري الإرسال...';
                submitBtn.disabled = true;
            }
        });
    }

    // ==================== Auto-save Draft (Optional) ====================
    let autoSaveTimeout;
    document.addEventListener('input', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            // Save form data to localStorage
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            localStorage.setItem('formDraft', JSON.stringify(data));
            
            // Show save indicator
            showSaveIndicator();
        }, 2000);
    });

    function showSaveIndicator() {
        let indicator = document.getElementById('auto-save-indicator');
        if (!indicator) {
            indicator = document.createElement('div');
            indicator.id = 'auto-save-indicator';
            indicator.style.cssText = `
                position: fixed;
                bottom: 20px;
                left: 20px;
                background: #28a745;
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 6px;
                font-size: 0.85rem;
                opacity: 0;
                transition: opacity 0.3s ease;
                z-index: 10000;
            `;
            indicator.textContent = '✓ تم الحفظ تلقائياً';
            document.body.appendChild(indicator);
        }
        
        indicator.style.opacity = '1';
        setTimeout(() => {
            indicator.style.opacity = '0';
        }, 2000);
    }

    console.log('✨ Form enhancements initialized');
})();

