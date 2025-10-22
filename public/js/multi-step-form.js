/**
 * Multi-Step Form Handler
 * Enhanced JavaScript for Infinity Wear Importer Registration Form
 */

class MultiStepForm {
    constructor() {
        this.currentStep = 1;
        this.totalSteps = 4;
        this.formData = {};
        this.init();
    }

    init() {
        this.bindEvents();
        this.initializeForm();
        this.setupValidation();
    }

    bindEvents() {
        // Navigation buttons
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        if (nextBtn) nextBtn.addEventListener('click', () => this.nextStep());
        if (prevBtn) prevBtn.addEventListener('click', () => this.prevStep());
        
        // Form submission
        const multiStepForm = document.getElementById('multiStepForm');
        if (multiStepForm) {
            multiStepForm.addEventListener('submit', (e) => this.handleSubmit(e));
        }
        
        // Business type change
        const businessType = document.getElementById('business_type');
        if (businessType) {
            businessType.addEventListener('change', (e) => this.handleBusinessTypeChange(e));
        }
        
        // Design option changes
        document.querySelectorAll('.design-option').forEach(option => {
            option.addEventListener('change', (e) => this.handleDesignOptionChange(e));
        });
        
        // Password toggle
        const togglePassword = document.getElementById('togglePassword');
        if (togglePassword) {
            togglePassword.addEventListener('click', () => this.togglePassword());
        }
        
        // Real-time validation
        document.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('blur', () => this.validateField(field));
            field.addEventListener('input', () => this.clearFieldError(field));
        });
        
        // Terms agreement
        const termsAgreement = document.getElementById('terms_agreement');
        if (termsAgreement) {
            termsAgreement.addEventListener('change', () => this.handleTermsChange());
        }
    }

    initializeForm() {
        // Hide all steps initially
        document.querySelectorAll('.form-step').forEach((stepElement) => {
            stepElement.style.display = 'none';
            stepElement.classList.remove('active');
        });
        
        this.showStep(this.currentStep);
        this.updateProgressBar();
    }

    setupValidation() {
        // Add real-time validation to form inputs
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });
    }

    validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name;
        let isValid = true;
        let errorMessage = '';

        // Required field validation
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'هذا الحقل مطلوب';
        }

        // Email validation
        if (fieldName === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'يرجى إدخال بريد إلكتروني صحيح';
            }
        }

        // Phone validation
        if (fieldName === 'phone' && value) {
            const phoneRegex = /^[\d\s\-\+\(\)]+$/;
            if (!phoneRegex.test(value)) {
                isValid = false;
                errorMessage = 'يرجى إدخال رقم هاتف صحيح';
            }
        }

        // Password validation
        if (fieldName === 'password' && value) {
            if (value.length < 8) {
                isValid = false;
                errorMessage = 'كلمة المرور يجب أن تكون 8 أحرف على الأقل';
            }
        }

        // Password confirmation validation
        if (fieldName === 'password_confirmation' && value) {
            const password = document.getElementById('password').value;
            if (value !== password) {
                isValid = false;
                errorMessage = 'كلمة المرور غير متطابقة';
            }
        }

        // Quantity validation
        if (fieldName === 'quantity' && value) {
            const quantity = parseInt(value);
            if (isNaN(quantity) || quantity < 1) {
                isValid = false;
                errorMessage = 'الكمية يجب أن تكون رقم أكبر من 0';
            }
        }

        if (!isValid) {
            this.showFieldError(field, errorMessage);
        } else {
            this.clearFieldError(field);
        }

        return isValid;
    }

    showFieldError(field, message) {
        field.classList.add('is-invalid');
        field.classList.remove('is-valid');
        
        let feedback = field.parentNode.querySelector('.invalid-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            field.parentNode.appendChild(feedback);
        }
        feedback.textContent = message;
    }

    clearFieldError(field) {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
        
        const feedback = field.parentNode.querySelector('.invalid-feedback');
        if (feedback) {
            feedback.textContent = '';
        }
    }

    showStep(step) {
        // Hide all steps first
        document.querySelectorAll('.form-step').forEach((stepElement) => {
            stepElement.classList.remove('active');
            stepElement.style.display = 'none';
        });
        
        // Show current step
        const currentStepElement = document.getElementById(`step${step}`);
        if (currentStepElement) {
            currentStepElement.classList.add('active');
            currentStepElement.style.display = 'block';
        }
        
        // Update step indicators
        document.querySelectorAll('.step-item').forEach((item, index) => {
            item.classList.toggle('active', index + 1 === step);
            item.classList.toggle('completed', index + 1 < step);
        });
        
        // Update navigation buttons
        this.updateNavigationButtons(step);
        
        // Update progress bar
        this.updateProgressBar(step);
        
        // Update summary if on confirmation step
        if (step === 4) {
            this.updateSummary();
        }
        
        // Add animation
        this.animateStepTransition(step);
    }

    updateNavigationButtons(step) {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');
        
        prevBtn.style.display = step === 1 ? 'none' : 'inline-block';
        nextBtn.style.display = step === this.totalSteps ? 'none' : 'inline-block';
        submitBtn.style.display = step === this.totalSteps ? 'inline-block' : 'none';
    }

    updateProgressBar(step = this.currentStep) {
        const progress = (step / this.totalSteps) * 100;
        const progressContainer = document.querySelector('.progress-container');
        
        if (progressContainer) {
            progressContainer.style.setProperty('--progress', `${progress}%`);
            progressContainer.classList.add('animate');
            
            // Remove animation class after animation completes
            setTimeout(() => {
                progressContainer.classList.remove('animate');
            }, 500);
        }
    }

    animateStepTransition(step) {
        const currentStepElement = document.getElementById(`step${step}`);
        if (currentStepElement) {
            currentStepElement.style.animation = 'none';
            currentStepElement.offsetHeight; // Trigger reflow
            currentStepElement.style.animation = 'slideInRight 0.6s ease-out';
        }
    }

    nextStep() {
        if (this.validateStep(this.currentStep)) {
            this.saveStepData(this.currentStep);
            
            if (this.currentStep < this.totalSteps) {
                this.currentStep++;
                this.showStep(this.currentStep);
                this.scrollToTop();
            }
        } else {
            this.showValidationErrors();
        }
    }

    prevStep() {
        if (this.currentStep > 1) {
            this.currentStep--;
            this.showStep(this.currentStep);
            this.scrollToTop();
        }
    }

    validateStep(step) {
        let isValid = true;
        const currentStepElement = document.getElementById(`step${step}`);
        const requiredFields = currentStepElement.querySelectorAll('input[required], select[required], textarea[required]');
        
        // Clear previous errors
        this.clearStepErrors(step);
        
        // Validate required fields
        requiredFields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });
        
        // Step-specific validation
        if (step === 1) {
            isValid = this.validatePasswordMatch() && isValid;
            // Add custom design validation if custom option is selected
            const designOption = document.querySelector('input[name="design_option"]:checked');
            if (designOption && designOption.value === 'custom') {
                isValid = this.validateCustomDesign() && isValid;
            }
        } else if (step === 3) {
            isValid = this.validateDesignOption() && isValid;
        }
        
        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';
        
        // Required field validation
        if (field.hasAttribute('required') && !value) {
            errorMessage = 'هذا الحقل مطلوب';
            isValid = false;
        }
        
        // Email validation
        if (field.type === 'email' && value && !this.isValidEmail(value)) {
            errorMessage = 'يرجى إدخال بريد إلكتروني صحيح';
            isValid = false;
        }
        
        // Phone validation
        if (field.name === 'phone' && value && !this.isValidPhone(value)) {
            errorMessage = 'يرجى إدخال رقم هاتف صحيح';
            isValid = false;
        }
        
        // Quantity validation
        if (field.name === 'quantity' && value && (parseInt(value) < 1)) {
            errorMessage = 'الحد الأدنى للكمية هو 1 قطعة';
            isValid = false;
        }
        
        if (!isValid) {
            this.showFieldError(field, errorMessage);
        } else {
            this.clearFieldError(field);
        }
        
        return isValid;
    }

    validatePasswordMatch() {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        
        if (password !== passwordConfirmation) {
            this.showFieldError(document.getElementById('password_confirmation'), 'كلمة المرور غير متطابقة');
            return false;
        }
        
        return true;
    }

    validateDesignOption() {
        const designOption = document.querySelector('input[name="design_option"]:checked');
        
        if (!designOption) {
            this.showStepError(3, 'يرجى اختيار طريقة تحديد التصميم');
            return false;
        }
        
        return true;
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    isValidPhone(phone) {
        const phoneRegex = /^[\+]?[0-9\s\-\(\)]{10,}$/;
        return phoneRegex.test(phone);
    }

    showFieldError(field, message) {
        field.classList.add('is-invalid');
        const feedback = field.parentNode.querySelector('.invalid-feedback') || 
                        field.parentNode.parentNode.querySelector('.invalid-feedback');
        
        if (feedback) {
            feedback.textContent = message;
            feedback.style.display = 'block';
        }
    }

    clearFieldError(field) {
        field.classList.remove('is-invalid');
        const feedback = field.parentNode.querySelector('.invalid-feedback') || 
                        field.parentNode.parentNode.querySelector('.invalid-feedback');
        
        if (feedback) {
            feedback.style.display = 'none';
        }
    }

    clearStepErrors(step) {
        const currentStepElement = document.getElementById(`step${step}`);
        const invalidFields = currentStepElement.querySelectorAll('.is-invalid');
        
        invalidFields.forEach(field => {
            this.clearFieldError(field);
        });
    }

    showStepError(step, message) {
        const currentStepElement = document.getElementById(`step${step}`);
        let errorAlert = currentStepElement.querySelector('.step-error-alert');
        
        if (!errorAlert) {
            errorAlert = document.createElement('div');
            errorAlert.className = 'alert alert-danger step-error-alert';
            currentStepElement.querySelector('.step-content').insertBefore(errorAlert, currentStepElement.querySelector('.step-content').firstChild);
        }
        
        errorAlert.innerHTML = `<i class="fas fa-exclamation-triangle me-2"></i>${message}`;
        errorAlert.style.display = 'block';
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            errorAlert.style.display = 'none';
        }, 5000);
    }

    showValidationErrors() {
        this.showStepError(this.currentStep, 'يرجى تصحيح الأخطاء قبل المتابعة');
    }

    handleBusinessTypeChange(e) {
        const otherDiv = document.getElementById('other_business_type_div');
        const otherInput = document.getElementById('business_type_other');
        
        if (e.target.value === 'other') {
            otherDiv.style.display = 'block';
            otherInput.required = true;
        } else {
            otherDiv.style.display = 'none';
            otherInput.required = false;
            otherInput.value = '';
        }
    }

    handleDesignOptionChange(e) {
        const selectedOption = e.target.value;
        const designDetails = document.querySelectorAll('.design-detail');
        
        // Hide all design details
        designDetails.forEach(detail => {
            detail.style.display = 'none';
        });
        
        // Show selected design detail
        const selectedDetail = document.getElementById(`design_${selectedOption}_detail`);
        if (selectedDetail) {
            selectedDetail.style.display = 'block';
            
            // Initialize custom design interface if selected
            if (selectedOption === 'custom') {
                this.initializeCustomDesignInterface();
            }
        }
        
        // Add visual feedback
        this.highlightDesignOption(e.target);
    }

    highlightDesignOption(selectedInput) {
        // Remove previous highlights
        document.querySelectorAll('.design-option-card').forEach(card => {
            card.classList.remove('selected');
        });
        
        // Highlight selected option
        const selectedCard = selectedInput.closest('.design-option-card');
        if (selectedCard) {
            selectedCard.classList.add('selected');
        }
    }

    togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');
        const icon = toggleButton.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    handleTermsChange() {
        const termsCheckbox = document.getElementById('terms_agreement');
        const submitBtn = document.getElementById('submitBtn');
        
        if (termsCheckbox.checked) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('disabled');
        }
    }

    saveStepData(step) {
        const currentStepElement = document.getElementById(`step${step}`);
        const inputs = currentStepElement.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            if (input.type === 'radio' || input.type === 'checkbox') {
                if (input.checked) {
                    this.formData[input.name] = input.value;
                }
            } else {
                this.formData[input.name] = input.value;
            }
        });
    }

    updateSummary() {
        // Order details (step 1)
        document.getElementById('summary_quantity').textContent = this.formData.quantity || '-';
        const designOption = document.querySelector('input[name="design_option"]:checked');
        const designOptionText = designOption ? designOption.nextElementSibling.querySelector('.fw-semibold').textContent : '-';
        document.getElementById('summary_design_option').textContent = designOptionText;
        document.getElementById('summary_requirements').textContent = this.formData.requirements || '-';
        
        // Company info (step 2)
        document.getElementById('summary_company').textContent = this.formData.company_name || '-';
        const businessTypeSelect = document.getElementById('business_type');
        const businessTypeText = businessTypeSelect.options[businessTypeSelect.selectedIndex]?.text || '-';
        document.getElementById('summary_business_type').textContent = businessTypeText;
        document.getElementById('summary_city').textContent = this.formData.city || '-';
        
        // Personal info (step 3)
        document.getElementById('summary_name').textContent = this.formData.name || '-';
        document.getElementById('summary_email').textContent = this.formData.email || '-';
        document.getElementById('summary_phone').textContent = this.formData.phone || '-';
    }

    handleSubmit(e) {
        if (!this.validateStep(this.currentStep)) {
            e.preventDefault();
            this.showValidationErrors();
            return;
        }
        
        // Show loading state
        this.showLoadingState();
        
        // Save all form data
        for (let i = 1; i <= this.totalSteps; i++) {
            this.saveStepData(i);
        }
    }

    showLoadingState() {
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الطلب...';
        submitBtn.disabled = true;
        submitBtn.classList.add('loading');
        
        // Reset after 3 seconds (in case of error)
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            submitBtn.classList.remove('loading');
        }, 3000);
    }

    scrollToTop() {
        const formContainer = document.querySelector('.card');
        if (formContainer) {
            formContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Custom Design Interface Methods
    initializeCustomDesignInterface() {
        this.setupClothingPiecesSelection();
        this.setupColorSelection();
        this.setupLogoUpload();
        this.setupTextAddition();
        this.setup3DViewer();
        this.setupViewerControls();
    }

    setupClothingPiecesSelection() {
        const clothingPieces = document.querySelectorAll('.piece-item input[type="checkbox"]');
        clothingPieces.forEach(piece => {
            piece.addEventListener('change', (e) => {
                this.handleClothingPieceChange(e);
            });
        });
    }

    handleClothingPieceChange(e) {
        const pieceType = e.target.value;
        const isChecked = e.target.checked;
        
        if (isChecked) {
            this.addClothingPieceToViewer(pieceType);
        } else {
            this.removeClothingPieceFromViewer(pieceType);
        }
        
        this.update3DViewer();
    }

    addClothingPieceToViewer(pieceType) {
        if (this.viewer3D) {
            const piece = this.viewer3D.addClothingPiece(pieceType);
            if (piece) {
                // Store reference for later use
                this.clothingPieces = this.clothingPieces || new Map();
                this.clothingPieces.set(pieceType, piece);
            }
        }
    }

    removeClothingPieceFromViewer(pieceType) {
        if (this.viewer3D) {
            this.viewer3D.removeClothingPiece(pieceType);
            if (this.clothingPieces) {
                this.clothingPieces.delete(pieceType);
            }
        }
    }

    selectClothingPiece(pieceElement) {
        // Remove previous selection
        document.querySelectorAll('.clothing-piece.selected').forEach(piece => {
            piece.classList.remove('selected');
        });
        
        // Select current piece
        pieceElement.classList.add('selected');
        this.selectedPiece = pieceElement;
        
        // Update 3D viewer selection
        if (this.viewer3D) {
            this.viewer3D.selectPiece(pieceElement);
        }
    }

    setupColorSelection() {
        const colorOptions = document.querySelectorAll('.color-option');
        colorOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                this.handleColorSelection(e);
            });
        });
    }

    handleColorSelection(e) {
        const selectedColor = e.target.dataset.color;
        
        // Remove previous selection
        document.querySelectorAll('.color-option.selected').forEach(option => {
            option.classList.remove('selected');
        });
        
        // Select current color
        e.target.classList.add('selected');
        
        // Apply color to selected piece in 3D viewer
        if (this.viewer3D && this.selectedPiece) {
            const pieceType = this.selectedPiece.userData?.type;
            if (pieceType) {
                this.viewer3D.updateClothingPieceColor(pieceType, selectedColor);
            }
        }
        
        // Update selected colors hidden input
        this.updateSelectedColors();
    }

    updateSelectedColors() {
        const selectedColors = Array.from(document.querySelectorAll('.color-option.selected'))
            .map(option => option.dataset.color);
        
        const hiddenInput = document.getElementById('selected_colors');
        if (hiddenInput) {
            hiddenInput.value = JSON.stringify(selectedColors);
        }
    }

    setupLogoUpload() {
        const logoUpload = document.getElementById('logo_upload');
        if (logoUpload) {
            logoUpload.addEventListener('change', (e) => {
                this.handleLogoUpload(e);
            });
        }
    }

    handleLogoUpload(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                this.addLogoToViewer(event.target.result);
            };
            reader.readAsDataURL(file);
        }
    }

    addLogoToViewer(logoDataUrl) {
        if (this.viewer3D) {
            this.viewer3D.addLogo(logoDataUrl);
        }
    }

    setupTextAddition() {
        const designText = document.getElementById('design_text');
        if (designText) {
            designText.addEventListener('input', (e) => {
                this.handleTextAddition(e);
            });
        }
    }

    handleTextAddition(e) {
        const text = e.target.value;
        
        if (this.viewer3D) {
            if (text) {
                this.viewer3D.addText(text);
            }
        }
    }

    setup3DViewer() {
        const viewer = document.getElementById('3d-viewer');
        if (viewer && window.Design3DViewer) {
            // Initialize 3D viewer with Three.js
            this.viewer3D = new Design3DViewer('3d-viewer');
            this.viewer3D.loadHumanModel();
            
            // Handle window resize
            window.addEventListener('resize', () => {
                this.viewer3D.resize();
            });
        }
    }

    update3DViewer() {
        const viewer = document.getElementById('3d-viewer');
        const placeholder = viewer.querySelector('.model-placeholder');
        const hasPieces = this.clothingPieces && this.clothingPieces.size > 0;
        
        if (hasPieces) {
            if (placeholder) {
                placeholder.style.display = 'none';
            }
        } else {
            if (placeholder) {
                placeholder.style.display = 'block';
            }
        }
    }

    setupViewerControls() {
        const rotateBtn = document.getElementById('rotate-model');
        const zoomInBtn = document.getElementById('zoom-in');
        const zoomOutBtn = document.getElementById('zoom-out');
        const resetBtn = document.getElementById('reset-view');
        
        if (rotateBtn) {
            rotateBtn.addEventListener('click', () => this.rotateModel());
        }
        
        if (zoomInBtn) {
            zoomInBtn.addEventListener('click', () => this.zoomIn());
        }
        
        if (zoomOutBtn) {
            zoomOutBtn.addEventListener('click', () => this.zoomOut());
        }
        
        if (resetBtn) {
            resetBtn.addEventListener('click', () => this.resetView());
        }
    }

    rotateModel() {
        if (this.viewer3D) {
            this.viewer3D.rotateModel(90, 0);
        }
    }

    zoomIn() {
        if (this.viewer3D) {
            this.viewer3D.zoomModel(-1);
        }
    }

    zoomOut() {
        if (this.viewer3D) {
            this.viewer3D.zoomModel(1);
        }
    }

    resetView() {
        if (this.viewer3D) {
            this.viewer3D.resetView();
        }
    }

    // Enhanced validation for custom design
    validateCustomDesign() {
        const clothingPieces = document.querySelectorAll('input[name="clothing_pieces[]"]:checked');
        const businessType = document.getElementById('design_business_type').value;
        
        if (clothingPieces.length === 0) {
            this.showStepError(1, 'يرجى اختيار قطعة ملابس واحدة على الأقل');
            return false;
        }
        
        if (!businessType) {
            this.showStepError(1, 'يرجى اختيار نوع النشاط');
            return false;
        }
        
        return true;
    }
}

// Initialize the form when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new MultiStepForm();
});

// Add some utility functions
window.MultiStepFormUtils = {
    // Function to go to specific step (useful for debugging)
    goToStep: function(step) {
        if (window.multiStepForm) {
            window.multiStepForm.currentStep = step;
            window.multiStepForm.showStep(step);
        }
    },
    
    // Function to get form data
    getFormData: function() {
        return window.multiStepForm ? window.multiStepForm.formData : {};
    },
    
    // Function to validate specific step
    validateStep: function(step) {
        return window.multiStepForm ? window.multiStepForm.validateStep(step) : false;
    }
};

// Make the form instance globally available for debugging
document.addEventListener('DOMContentLoaded', function() {
    // Check if the form exists before initializing
    if (document.getElementById('multiStepForm')) {
        window.multiStepForm = new MultiStepForm();
    }
});
