/**
 * Infinity Wear - نموذج المستوردين الجديد
 * نظام متعدد الخطوات مع مجسم 3D تفاعلي
 */

class ImporterForm {
    constructor() {
        this.currentStep = 1;
        this.totalSteps = 4;
        this.selectedPieces = new Set();
        this.selectedColor = null;
        this.scene = null;
        this.camera = null;
        this.renderer = null;
        this.controls = null;
        this.model = null;
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.updateProgressBar();
        this.init3DViewer();
        this.updateSummary();
    }

    setupEventListeners() {
        // Navigation buttons
        document.getElementById('nextBtn').addEventListener('click', () => this.nextStep());
        document.getElementById('prevBtn').addEventListener('click', () => this.prevStep());

        // Design option change
        document.querySelectorAll('input[name="design_option"]').forEach(radio => {
            radio.addEventListener('change', (e) => this.handleDesignOptionChange(e.target.value));
        });

        // Clothing pieces selection
        document.querySelectorAll('input[name="clothing_pieces[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', (e) => this.handlePieceSelection(e));
        });

        // Color palette
        document.querySelectorAll('.color-option').forEach(colorDiv => {
            colorDiv.addEventListener('click', () => this.handleColorSelection(colorDiv));
        });

        // 3D viewer controls
        document.getElementById('rotateLeft').addEventListener('click', () => this.rotateModel(-45));
        document.getElementById('rotateRight').addEventListener('click', () => this.rotateModel(45));
        document.getElementById('zoomIn').addEventListener('click', () => this.zoomModel(0.9));
        document.getElementById('zoomOut').addEventListener('click', () => this.zoomModel(1.1));
        document.getElementById('resetView').addEventListener('click', () => this.resetView());

        // Form inputs change
        document.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('change', () => this.updateSummary());
        });

        // Size inputs
        document.querySelectorAll('.size-input').forEach(input => {
            input.addEventListener('input', () => this.calculateTotal());
        });
    }

    nextStep() {
        if (this.validateStep(this.currentStep)) {
            if (this.currentStep < this.totalSteps) {
                this.currentStep++;
                this.showStep(this.currentStep);
            }
        }
    }

    prevStep() {
        if (this.currentStep > 1) {
            this.currentStep--;
            this.showStep(this.currentStep);
        }
    }

    showStep(step) {
        // Hide all steps
        document.querySelectorAll('.form-step').forEach(stepEl => {
            stepEl.classList.remove('active');
        });

        // Show current step
        document.getElementById(`step${step}`).classList.add('active');

        // Update step indicators
        document.querySelectorAll('.step-item').forEach((item, index) => {
            if (index + 1 < step) {
                item.classList.add('completed');
                item.classList.remove('active');
            } else if (index + 1 === step) {
                item.classList.add('active');
                item.classList.remove('completed');
            } else {
                item.classList.remove('active', 'completed');
            }
        });

        // Update buttons
        document.getElementById('prevBtn').style.display = step === 1 ? 'none' : 'inline-flex';
        document.getElementById('nextBtn').style.display = step === this.totalSteps ? 'none' : 'inline-flex';
        document.getElementById('submitBtn').style.display = step === this.totalSteps ? 'inline-flex' : 'none';

        // Update progress bar
        this.updateProgressBar();

        // Update summary if on final step
        if (step === this.totalSteps) {
            this.updateFinalSummary();
        }

        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    validateStep(step) {
        const currentStepEl = document.getElementById(`step${step}`);
        const requiredFields = currentStepEl.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value || (field.type === 'checkbox' && !field.checked)) {
                field.style.borderColor = '#ef4444';
                isValid = false;
            } else {
                field.style.borderColor = '';
            }
        });

        if (!isValid) {
            alert('يرجى ملء جميع الحقول المطلوبة');
        }

        return isValid;
    }

    updateProgressBar() {
        const progress = ((this.currentStep - 1) / (this.totalSteps - 1)) * 100;
        document.getElementById('progressLine').style.width = `${progress}%`;
    }

    handleDesignOptionChange(option) {
        // Hide all design details
        document.getElementById('designTextDetail').style.display = 'none';
        document.getElementById('designUploadDetail').style.display = 'none';
        document.getElementById('designCustomDetail').style.display = 'none';

        // Show selected option
        switch(option) {
            case 'text':
                document.getElementById('designTextDetail').style.display = 'block';
                break;
            case 'upload':
                document.getElementById('designUploadDetail').style.display = 'block';
                break;
            case 'custom':
                document.getElementById('designCustomDetail').style.display = 'block';
                break;
        }

        // Update option cards styling
        document.querySelectorAll('.design-option-card').forEach(card => {
            card.classList.remove('selected');
        });
        event.target.closest('.design-option-card').classList.add('selected');
    }

    handlePieceSelection(e) {
        const piece = e.target.value;
        const isChecked = e.target.checked;
        const card = e.target.closest('.piece-card');

        if (isChecked) {
            this.selectedPieces.add(piece);
            card.classList.add('selected');
            this.show3DPiece(piece);
            this.showSizeSection(piece);
        } else {
            this.selectedPieces.delete(piece);
            card.classList.remove('selected');
            this.hide3DPiece(piece);
            this.hideSizeSection(piece);
        }

        // Show/hide colors and logo sections
        if (this.selectedPieces.size > 0) {
            document.getElementById('colorsSection').style.display = 'block';
            document.getElementById('logoSection').style.display = 'block';
        } else {
            document.getElementById('colorsSection').style.display = 'none';
            document.getElementById('logoSection').style.display = 'none';
        }

        this.updateSummary();
    }

    showSizeSection(piece) {
        if (piece === 'shirt' || piece === 'jacket') {
            document.getElementById('shirtSizes').style.display = 'block';
        } else if (piece === 'shorts' || piece === 'pants') {
            document.getElementById('bottomSizes').style.display = 'block';
        }
    }

    hideSizeSection(piece) {
        const shirtPieces = Array.from(this.selectedPieces).filter(p => p === 'shirt' || p === 'jacket');
        const bottomPieces = Array.from(this.selectedPieces).filter(p => p === 'shorts' || p === 'pants');

        if (shirtPieces.length === 0) {
            document.getElementById('shirtSizes').style.display = 'none';
        }
        if (bottomPieces.length === 0) {
            document.getElementById('bottomSizes').style.display = 'none';
        }
    }

    handleColorSelection(colorDiv) {
        const color = colorDiv.dataset.color;

        // Remove previous selection
        document.querySelectorAll('.color-option').forEach(opt => {
            opt.classList.remove('selected');
        });

        // Select new color
        colorDiv.classList.add('selected');
        this.selectedColor = color;
        document.getElementById('primaryColor').value = color;

        // Update 3D model color
        this.updateModelColor(color);
        this.updateSummary();
    }

    calculateTotal() {
        let total = 0;
        document.querySelectorAll('.size-input').forEach(input => {
            total += parseInt(input.value) || 0;
        });
        document.getElementById('summaryTotal').textContent = total;
    }

    updateSummary() {
        // Pieces summary
        const piecesText = this.selectedPieces.size > 0 
            ? Array.from(this.selectedPieces).map(p => this.getPieceNameAr(p)).join('، ')
            : '-';
        document.getElementById('summaryPieces').textContent = piecesText;

        // Color summary
        document.getElementById('summaryColor').textContent = this.selectedColor 
            ? '●' 
            : '-';
        if (this.selectedColor) {
            document.getElementById('summaryColor').style.color = this.selectedColor;
        }

        // Total
        this.calculateTotal();
    }

    updateFinalSummary() {
        // Company info
        document.getElementById('finalCompany').textContent = 
            document.querySelector('[name="company_name"]').value || '-';
        document.getElementById('finalName').textContent = 
            document.querySelector('[name="name"]').value || '-';
        document.getElementById('finalEmail').textContent = 
            document.querySelector('[name="email"]').value || '-';
        document.getElementById('finalPhone').textContent = 
            document.querySelector('[name="phone"]').value || '-';

        // Design option
        const designOption = document.querySelector('[name="design_option"]:checked');
        let designOptionText = '-';
        if (designOption) {
            switch(designOption.value) {
                case 'text': designOptionText = 'وصف نصي'; break;
                case 'upload': designOptionText = 'رفع ملف'; break;
                case 'custom': designOptionText = 'تصميم مخصص'; break;
            }
        }
        document.getElementById('finalDesignOption').textContent = designOptionText;

        // Pieces
        document.getElementById('finalPieces').textContent = 
            this.selectedPieces.size > 0 
                ? Array.from(this.selectedPieces).map(p => this.getPieceNameAr(p)).join('، ')
                : 'حسب الوصف';

        // Color
        if (this.selectedColor) {
            document.getElementById('finalColor').innerHTML = 
                `<span style="color: ${this.selectedColor}; font-size: 1.5rem;">●</span> ${this.selectedColor}`;
        } else {
            document.getElementById('finalColor').textContent = 'حسب الوصف';
        }

        // Quantity
        const quantity = document.querySelector('[name="quantity"]').value;
        document.getElementById('finalQuantity').textContent = quantity ? `${quantity} قطعة` : '-';
    }

    getPieceNameAr(piece) {
        const names = {
            'shirt': 'قميص',
            'shorts': 'شورت',
            'pants': 'بنطلون',
            'jacket': 'جاكيت',
            'socks': 'شراب',
            'shoes': 'حذاء'
        };
        return names[piece] || piece;
    }

    // ===== 3D Viewer Methods =====

    init3DViewer() {
        try {
            // Use enhanced model viewer if available
            if (typeof EnhancedModelViewer !== 'undefined') {
                this.viewer3D = new EnhancedModelViewer('model-viewer');
                
                // Hide placeholder
                setTimeout(() => {
                    document.getElementById('modelPlaceholder').style.display = 'none';
                }, 500);
                
                // Handle window resize
                window.addEventListener('resize', () => {
                    if (this.viewer3D) {
                        this.viewer3D.onWindowResize();
                    }
                });
            } else {
                console.warn('EnhancedModelViewer not found, using fallback');
                this.initFallback3DViewer();
            }
        } catch (error) {
            console.error('Error initializing 3D viewer:', error);
            this.initFallback3DViewer();
        }
    }

    initFallback3DViewer() {
        const container = document.getElementById('model-viewer');
        if (!container) return;

        const placeholder = document.getElementById('modelPlaceholder');
        if (placeholder) {
            placeholder.innerHTML = `
                <i class="fas fa-tshirt" style="font-size: 4rem; color: #9ca3af;"></i>
                <p style="margin-top: 1rem;">المجسم 3D غير متاح حالياً<br>سيتم عرض تصميمك بعد الإرسال</p>
            `;
        }
    }

    // Mannequin creation is now handled by EnhancedModelViewer

    show3DPiece(piece) {
        // Handled by EnhancedModelViewer
        console.log('Showing piece:', piece);
    }

    hide3DPiece(piece) {
        // Handled by EnhancedModelViewer
        console.log('Hiding piece:', piece);
    }

    updateModelColor(color) {
        if (this.viewer3D && this.viewer3D.updateClothingColor) {
            // Update all selected pieces
            this.selectedPieces.forEach(piece => {
                this.viewer3D.updateClothingColor(piece, color);
            });
        }
    }

    rotateModel(degrees) {
        if (this.viewer3D && this.viewer3D.rotate) {
            this.viewer3D.rotate(degrees);
        }
    }

    zoomModel(factor) {
        if (this.viewer3D && this.viewer3D.zoom) {
            this.viewer3D.zoom(factor);
        }
    }

    resetView() {
        if (this.viewer3D && this.viewer3D.reset) {
            this.viewer3D.reset();
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.importerForm = new ImporterForm();
});

