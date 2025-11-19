/**
 * Modern Multi-Step Form with Professional Animations
 * Version 2.0
 */

class ModernMultiStepForm {
    constructor() {
        this.currentStep = 1;
        this.totalSteps = 4;
        this.formData = {};
        
        this.init();
    }

    init() {
        console.log('Initializing Modern Multi-Step Form...');
        
        // Wait for DOM
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setup());
        } else {
            this.setup();
        }
    }

    setup() {
        this.setupEventListeners();
        this.updateProgressBar();
        this.showStep(this.currentStep);
        this.setupDesignOptionToggle();
        
        console.log('✓ Modern Multi-Step Form initialized');
    }

    setupEventListeners() {
        // Next buttons
        document.querySelectorAll('.btn-next').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.nextStep();
            });
        });

        // Previous buttons
        document.querySelectorAll('.btn-prev').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.prevStep();
            });
        });

        // Form submission
        const form = document.getElementById('importer-form');
        if (form) {
            form.addEventListener('submit', (e) => this.handleSubmit(e));
        }

        // Real-time validation
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => {
                if (input.classList.contains('is-invalid')) {
                    this.validateField(input);
                }
            });
        });

        // Auto-save functionality
        this.setupAutoSave();
    }

    setupDesignOptionToggle() {
        const designOptions = document.querySelectorAll('input[name="design_option"]');
        
        designOptions.forEach(option => {
            option.addEventListener('change', (e) => {
                // Hide all design details
                document.querySelectorAll('.design-detail').forEach(detail => {
                    detail.style.display = 'none';
                    this.addFadeOutAnimation(detail);
                });

                // Show selected design detail with animation
                const selectedValue = e.target.value;
                let detailId = '';
                
                switch(selectedValue) {
                    case 'text':
                        detailId = 'design_text_detail';
                        break;
                    case 'upload':
                        detailId = 'design_upload_detail';
                        break;
                    case 'custom':
                        detailId = 'design_custom_detail';
                        break;
                }

                if (detailId) {
                    const detailElement = document.getElementById(detailId);
                    if (detailElement) {
                        setTimeout(() => {
                            detailElement.style.display = 'block';
                            this.addFadeInAnimation(detailElement);
                        }, 300);
                    }
                }
            });
        });
    }

    nextStep() {
        if (!this.validateStep(this.currentStep)) {
            this.showValidationError();
            return;
        }

        if (this.currentStep < this.totalSteps) {
            this.saveStepData(this.currentStep);
            
            const currentStepEl = document.querySelector(`.step-content[data-step="${this.currentStep}"]`);
            this.addSlideOutAnimation(currentStepEl);

            setTimeout(() => {
                this.currentStep++;
                this.showStep(this.currentStep);
                this.updateProgressBar();
                this.scrollToTop();
            }, 300);
        }
    }

    prevStep() {
        if (this.currentStep > 1) {
            const currentStepEl = document.querySelector(`.step-content[data-step="${this.currentStep}"]`);
            this.addSlideOutAnimation(currentStepEl, true);

            setTimeout(() => {
                this.currentStep--;
                this.showStep(this.currentStep);
                this.updateProgressBar();
                this.scrollToTop();
            }, 300);
        }
    }

    showStep(stepNumber) {
        // Hide all steps
        document.querySelectorAll('.step-content').forEach(step => {
            step.classList.remove('active');
        });

        // Show current step with animation
        const currentStep = document.querySelector(`.step-content[data-step="${stepNumber}"]`);
        if (currentStep) {
            currentStep.classList.add('active');
            this.addSlideInAnimation(currentStep);
        }

        // Update step indicators
        document.querySelectorAll('.step-item').forEach((item, index) => {
            item.classList.remove('active', 'completed');
            
            if (index + 1 === stepNumber) {
                item.classList.add('active');
            } else if (index + 1 < stepNumber) {
                item.classList.add('completed');
            }
        });

        // Show/hide navigation buttons
        this.updateNavigationButtons();

        // Load saved data for this step
        this.loadStepData(stepNumber);
    }

    updateProgressBar() {
        const progressLine = document.querySelector('.progress-line');
        if (progressLine) {
            const progress = ((this.currentStep - 1) / (this.totalSteps - 1)) * 100;
            progressLine.style.width = `${progress}%`;
        }
    }

    updateNavigationButtons() {
        const prevButtons = document.querySelectorAll('.btn-prev');
        const nextButtons = document.querySelectorAll('.btn-next');
        const submitButton = document.querySelector('.btn-submit');

        // Show/hide previous button
        prevButtons.forEach(btn => {
            btn.style.display = this.currentStep === 1 ? 'none' : 'inline-flex';
        });

        // Show next or submit button
        if (this.currentStep === this.totalSteps) {
            nextButtons.forEach(btn => btn.style.display = 'none');
            if (submitButton) submitButton.style.display = 'inline-flex';
        } else {
            nextButtons.forEach(btn => btn.style.display = 'inline-flex');
            if (submitButton) submitButton.style.display = 'none';
        }
    }

    validateStep(stepNumber) {
        const stepElement = document.querySelector(`.step-content[data-step="${stepNumber}"]`);
        if (!stepElement) return true;

        const requiredFields = stepElement.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        let isValid = true;
        let errorMessage = '';

        // Skip hidden fields
        if (field.offsetParent === null) return true;

        // Check if required
        if (field.hasAttribute('required')) {
            if (field.type === 'checkbox') {
                isValid = field.checked;
                errorMessage = 'هذا الحقل مطلوب';
            } else if (field.type === 'radio') {
                const radioGroup = document.querySelectorAll(`input[name="${field.name}"]`);
                isValid = Array.from(radioGroup).some(radio => radio.checked);
                errorMessage = 'يرجى اختيار أحد الخيارات';
            } else {
                isValid = field.value.trim() !== '';
                errorMessage = 'هذا الحقل مطلوب';
            }
        }

        // Email validation
        if (field.type === 'email' && field.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            isValid = emailRegex.test(field.value);
            errorMessage = 'يرجى إدخال بريد إلكتروني صحيح';
        }

        // Phone validation
        if (field.type === 'tel' && field.value) {
            const phoneRegex = /^[0-9+\-\s()]+$/;
            isValid = phoneRegex.test(field.value) && field.value.length >= 10;
            errorMessage = 'يرجى إدخال رقم هاتف صحيح';
        }

        // Password confirmation
        if (field.name === 'password_confirmation') {
            const password = document.querySelector('input[name="password"]');
            if (password) {
                isValid = field.value === password.value;
                errorMessage = 'كلمتا المرور غير متطابقتين';
            }
        }

        // Min value validation
        if (field.hasAttribute('min') && field.value) {
            const minValue = parseFloat(field.getAttribute('min'));
            isValid = parseFloat(field.value) >= minValue;
            errorMessage = `القيمة يجب أن تكون ${minValue} أو أكثر`;
        }

        // Update field appearance
        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
            this.removeFieldError(field);
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
            this.showFieldError(field, errorMessage);
        }

        return isValid;
    }

    showFieldError(field, message) {
        this.removeFieldError(field);

        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';

        field.parentNode.appendChild(errorDiv);
    }

    removeFieldError(field) {
        const existingError = field.parentNode.querySelector('.invalid-feedback');
        if (existingError) {
            existingError.remove();
        }
    }

    showValidationError() {
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger';
        alert.innerHTML = `
            <i class="fas fa-exclamation-circle"></i>
            <span>يرجى ملء جميع الحقول المطلوبة بشكل صحيح</span>
        `;

        const stepContent = document.querySelector(`.step-content[data-step="${this.currentStep}"]`);
        if (stepContent) {
            stepContent.insertBefore(alert, stepContent.firstChild);
            
            setTimeout(() => {
                alert.remove();
            }, 5000);

            this.scrollToTop();
        }
    }

    saveStepData(stepNumber) {
        const stepElement = document.querySelector(`.step-content[data-step="${stepNumber}"]`);
        if (!stepElement) return;

        const formElements = stepElement.querySelectorAll('input, select, textarea');
        
        formElements.forEach(element => {
            if (element.type === 'checkbox') {
                this.formData[element.name] = element.checked;
            } else if (element.type === 'radio') {
                if (element.checked) {
                    this.formData[element.name] = element.value;
                }
            } else {
                this.formData[element.name] = element.value;
            }
        });

        // Save to localStorage
        localStorage.setItem('multiStepFormData', JSON.stringify(this.formData));
    }

    loadStepData(stepNumber) {
        const savedData = localStorage.getItem('multiStepFormData');
        if (!savedData) return;

        try {
            this.formData = JSON.parse(savedData);
        } catch (e) {
            console.error('Error loading saved data:', e);
            return;
        }

        const stepElement = document.querySelector(`.step-content[data-step="${stepNumber}"]`);
        if (!stepElement) return;

        const formElements = stepElement.querySelectorAll('input, select, textarea');
        
        formElements.forEach(element => {
            if (this.formData.hasOwnProperty(element.name)) {
                if (element.type === 'checkbox') {
                    element.checked = this.formData[element.name];
                } else if (element.type === 'radio') {
                    element.checked = element.value === this.formData[element.name];
                } else {
                    element.value = this.formData[element.name];
                }
            }
        });

        // Update summary if on last step
        if (stepNumber === this.totalSteps) {
            this.updateSummary();
        }
    }

    updateSummary() {
        // Update quantity
        const quantitySpan = document.querySelector('[data-summary="quantity"]');
        if (quantitySpan && this.formData.quantity) {
            quantitySpan.textContent = this.formData.quantity;
        }

        // Update design option
        const designOptionSpan = document.querySelector('[data-summary="design_option"]');
        if (designOptionSpan && this.formData.design_option) {
            const optionNames = {
                'text': 'وصف نصي',
                'upload': 'رفع ملف',
                'custom': 'تصميم تفاعلي'
            };
            designOptionSpan.textContent = optionNames[this.formData.design_option] || '-';
        }

        // Update requirements
        const requirementsDiv = document.querySelector('[data-summary="requirements"]');
        if (requirementsDiv && this.formData.requirements) {
            requirementsDiv.textContent = this.formData.requirements;
        }

        // Update company name
        const companyNameSpan = document.querySelector('[data-summary="company_name"]');
        if (companyNameSpan && this.formData.company_name) {
            companyNameSpan.textContent = this.formData.company_name;
        }

        // Update business type
        const businessTypeSpan = document.querySelector('[data-summary="business_type"]');
        if (businessTypeSpan && this.formData.business_type) {
            const typeNames = {
                'academy': 'أكاديمية رياضية',
                'school': 'مدرسة',
                'store': 'متجر ملابس',
                'hospital': 'مستشفى',
                'other': 'أخرى'
            };
            businessTypeSpan.textContent = typeNames[this.formData.business_type] || '-';
        }

        // Update city
        const citySpan = document.querySelector('[data-summary="city"]');
        if (citySpan && this.formData.city) {
            citySpan.textContent = this.formData.city;
        }

        // Update name
        const nameSpan = document.querySelector('[data-summary="name"]');
        if (nameSpan && this.formData.name) {
            nameSpan.textContent = this.formData.name;
        }

        // Update email
        const emailSpan = document.querySelector('[data-summary="email"]');
        if (emailSpan && this.formData.email) {
            emailSpan.textContent = this.formData.email;
        }

        // Update phone
        const phoneSpan = document.querySelector('[data-summary="phone"]');
        if (phoneSpan && this.formData.phone) {
            phoneSpan.textContent = this.formData.phone;
        }
    }

    setupAutoSave() {
        setInterval(() => {
            this.saveStepData(this.currentStep);
        }, 30000); // Save every 30 seconds
    }

    handleSubmit(e) {
        if (!this.validateStep(this.currentStep)) {
            e.preventDefault();
            this.showValidationError();
            return false;
        }

        // Show loading state
        const submitButton = e.target.querySelector('.btn-submit');
        if (submitButton) {
            submitButton.classList.add('loading');
            submitButton.disabled = true;
        }

        // Clear localStorage on successful submission
        localStorage.removeItem('multiStepFormData');

        return true;
    }

    scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Animation methods
    addSlideInAnimation(element) {
        element.style.animation = 'slideIn 0.5s ease-out';
    }

    addSlideOutAnimation(element, reverse = false) {
        element.style.animation = reverse ? 
            'slideOutReverse 0.3s ease-in' : 
            'slideOut 0.3s ease-in';
    }

    addFadeInAnimation(element) {
        element.style.animation = 'fadeIn 0.4s ease-out';
    }

    addFadeOutAnimation(element) {
        element.style.animation = 'fadeOut 0.3s ease-out';
    }
}

// Initialize on page load
let multiStepForm;
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        multiStepForm = new ModernMultiStepForm();
    });
} else {
    multiStepForm = new ModernMultiStepForm();
}

// Additional animations for CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(-30px);
        }
    }

    @keyframes slideOutReverse {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(30px);
        }
    }

    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
`;
document.head.appendChild(style);

