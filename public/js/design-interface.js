/**
 * Design Interface Controller
 * Connects the Enhanced 3D Viewer with the UI controls
 * @version 2.0.0
 */

class DesignInterface {
    constructor() {
        this.viewer = null;
        this.selectedPiece = null;
        this.selectedPart = 'body';
        this.currentActivityType = '';
        this.designData = {
            activityType: '',
            pieces: {},
            sizes: {},
            colors: {},
            patterns: {},
            logos: [],
            texts: []
        };
        
        this.init();
    }

    async init() {
        console.log('Initializing Design Interface...');
        
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setup());
        } else {
            this.setup();
        }
    }

    async setup() {
        try {
            // Initialize 3D Viewer
            await this.initialize3DViewer();
            
            // Bind UI events
            this.bindUIEvents();
            
            // Setup color pickers
            this.setupColorPickers();
            
            // Setup file uploads
            this.setupFileUploads();
            
            // Initialize tooltips
            this.initializeTooltips();
            
            console.log('✓ Design Interface initialized successfully');
        } catch (error) {
            console.error('Failed to initialize Design Interface:', error);
        }
    }

    async initialize3DViewer() {
        const viewerContainer = document.getElementById('3d-viewer');
        if (!viewerContainer) {
            console.error('3D Viewer container not found');
            return;
        }

        // Wait for Enhanced3DViewer to be available
        const waitForViewer = () => {
            return new Promise((resolve) => {
                const check = () => {
                    if (typeof Enhanced3DViewer !== 'undefined') {
                        resolve();
                    } else {
                        setTimeout(check, 100);
                    }
                };
                check();
            });
        };

        await waitForViewer();
        
        this.viewer = new Enhanced3DViewer('3d-viewer');
        
        // Listen for piece selection events
        window.addEventListener('pieceSelected', (e) => {
            this.onPieceSelected(e.detail);
        });
    }

    bindUIEvents() {
        // Activity type selection
        const activityType = document.getElementById('design_activity_type');
        if (activityType) {
            activityType.addEventListener('change', (e) => this.onActivityTypeChange(e.target.value));
        }

        // Clothing piece checkboxes
        const pieceCheckboxes = document.querySelectorAll('.clothing-piece-checkbox');
        pieceCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', (e) => {
                const pieceType = e.target.dataset.pieceType;
                if (e.target.checked) {
                    this.addPiece(pieceType);
                } else {
                    this.removePiece(pieceType);
                }
            });
        });

        // Size inputs
        const sizeInputs = document.querySelectorAll('.size-input');
        sizeInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                this.updateSizeSummary();
            });
        });

        // Color part selection
        const partButtons = document.querySelectorAll('.part-selector-btn');
        partButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                this.selectPart(e.target.dataset.part);
            });
        });

        // Pattern selection
        const patternOptions = document.querySelectorAll('.pattern-option');
        patternOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                const pattern = e.target.dataset.pattern;
                this.applyPattern(pattern);
            });
        });

        // Logo position selection
        const logoPosition = document.getElementById('logo_position');
        if (logoPosition) {
            logoPosition.addEventListener('change', (e) => {
                this.updateLogoPositionOptions(e.target.value);
            });
        }

        // Text position selection
        const textPosition = document.getElementById('text_position');
        if (textPosition) {
            textPosition.addEventListener('change', (e) => {
                this.updateTextPositionOptions(e.target.value);
            });
        }

        // Add text button
        const addTextBtn = document.getElementById('add-text-btn');
        if (addTextBtn) {
            addTextBtn.addEventListener('click', () => this.addText());
        }

        // View control buttons
        this.setupViewControls();
    }

    setupViewControls() {
        const controls = {
            'rotate-model': () => this.viewer.toggleAutoRotate(),
            'zoom-in': () => this.viewer.controls && (this.viewer.controls.dollyOut(0.9)),
            'zoom-out': () => this.viewer.controls && (this.viewer.controls.dollyIn(0.9)),
            'reset-view': () => this.viewer.resetView(),
            'view-front': () => this.viewer.setView('front'),
            'view-back': () => this.viewer.setView('back'),
            'view-left': () => this.viewer.setView('left'),
            'view-right': () => this.viewer.setView('right'),
            'toggle-grid': () => this.viewer.toggleGrid()
        };

        Object.entries(controls).forEach(([id, handler]) => {
            const btn = document.getElementById(id);
            if (btn) {
                btn.addEventListener('click', handler);
            }
        });
    }

    setupColorPickers() {
        // Listen for color changes on all color pickers
        const colorInputs = document.querySelectorAll('.color-picker');
        colorInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                this.onColorChange(e.target);
            });
        });

        // Preset colors
        const presetColors = document.querySelectorAll('.preset-color');
        presetColors.forEach(preset => {
            preset.addEventListener('click', (e) => {
                const color = e.target.dataset.color;
                this.applyPresetColor(color);
            });
        });
    }

    setupFileUploads() {
        // Logo file upload
        const logoUpload = document.getElementById('logo_file');
        if (logoUpload) {
            logoUpload.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    this.onLogoUpload(e.target.files[0]);
                }
            });
        }
    }

    initializeTooltips() {
        // Initialize Bootstrap tooltips if available
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(el => new bootstrap.Tooltip(el));
        }
    }

    // Event Handlers
    onActivityTypeChange(activityType) {
        this.currentActivityType = activityType;
        this.designData.activityType = activityType;
        
        console.log(`Activity type changed to: ${activityType}`);
        
        // Update UI based on activity type
        this.updateUIForActivityType(activityType);
    }

    updateUIForActivityType(activityType) {
        // You can customize piece suggestions based on activity type
        const suggestions = {
            'academy': ['shirt', 'shorts', 'socks'],
            'school': ['shirt', 'pants'],
            'hospital': ['shirt', 'pants', 'shoes'],
            'company': ['shirt', 'pants', 'jacket'],
            'other': []
        };

        const suggested = suggestions[activityType] || [];
        
        // Highlight suggested pieces
        const pieceCheckboxes = document.querySelectorAll('.clothing-piece-checkbox');
        pieceCheckboxes.forEach(checkbox => {
            const pieceType = checkbox.dataset.pieceType;
            const label = checkbox.closest('label') || checkbox.parentElement;
            
            if (suggested.includes(pieceType)) {
                label.classList.add('suggested-piece');
            } else {
                label.classList.remove('suggested-piece');
            }
        });
    }

    addPiece(pieceType) {
        if (!this.viewer) return;

        // Get default color for the piece
        const defaultColor = this.getDefaultColorForPiece(pieceType);
        
        // Add to viewer
        this.viewer.addClothingPiece(pieceType, { color: defaultColor });
        
        // Update design data
        this.designData.pieces[pieceType] = { color: defaultColor };
        
        // Show size inputs for this piece
        this.showSizeInputs(pieceType);
        
        // Show color controls for this piece
        this.showColorControls(pieceType);
        
        // Update piece count
        this.updatePieceCount();
        
        console.log(`Added piece: ${pieceType}`);
    }

    removePiece(pieceType) {
        if (!this.viewer) return;

        this.viewer.removeClothingPiece(pieceType);
        
        // Update design data
        delete this.designData.pieces[pieceType];
        delete this.designData.colors[pieceType];
        delete this.designData.patterns[pieceType];
        
        // Hide controls for this piece
        this.hideSizeInputs(pieceType);
        this.hideColorControls(pieceType);
        
        // Update piece count
        this.updatePieceCount();
        
        console.log(`Removed piece: ${pieceType}`);
    }

    getDefaultColorForPiece(pieceType) {
        const defaults = {
            'shirt': '#4A90E2',
            'tshirt': '#4A90E2',
            'pants': '#2C3E50',
            'shorts': '#E74C3C',
            'jacket': '#34495E',
            'shoes': '#2C3E50',
            'socks': '#FFFFFF'
        };
        
        return defaults[pieceType] || '#4A90E2';
    }

    showSizeInputs(pieceType) {
        const sizeContainer = document.getElementById(`size-${pieceType}`);
        if (sizeContainer) {
            sizeContainer.style.display = 'block';
            
            // Animate entrance
            sizeContainer.style.opacity = '0';
            sizeContainer.style.transform = 'translateY(10px)';
            
            setTimeout(() => {
                sizeContainer.style.transition = 'all 0.3s ease';
                sizeContainer.style.opacity = '1';
                sizeContainer.style.transform = 'translateY(0)';
            }, 10);
        }
    }

    hideSizeInputs(pieceType) {
        const sizeContainer = document.getElementById(`size-${pieceType}`);
        if (sizeContainer) {
            sizeContainer.style.transition = 'all 0.3s ease';
            sizeContainer.style.opacity = '0';
            sizeContainer.style.transform = 'translateY(-10px)';
            
            setTimeout(() => {
                sizeContainer.style.display = 'none';
            }, 300);
        }
    }

    showColorControls(pieceType) {
        const colorContainer = document.getElementById(`color-${pieceType}`);
        if (colorContainer) {
            colorContainer.style.display = 'block';
            
            // Animate entrance
            colorContainer.style.opacity = '0';
            setTimeout(() => {
                colorContainer.style.transition = 'all 0.3s ease';
                colorContainer.style.opacity = '1';
            }, 10);
        }
    }

    hideColorControls(pieceType) {
        const colorContainer = document.getElementById(`color-${pieceType}`);
        if (colorContainer) {
            colorContainer.style.transition = 'all 0.3s ease';
            colorContainer.style.opacity = '0';
            
            setTimeout(() => {
                colorContainer.style.display = 'none';
            }, 300);
        }
    }

    selectPart(part) {
        this.selectedPart = part;
        
        // Update UI to show selected part
        const partButtons = document.querySelectorAll('.part-selector-btn');
        partButtons.forEach(btn => {
            if (btn.dataset.part === part) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
        
        console.log(`Selected part: ${part}`);
    }

    onColorChange(input) {
        if (!this.viewer) return;

        const color = input.value;
        const pieceType = input.dataset.pieceType;
        const part = input.dataset.part || this.selectedPart || 'body';
        
        // Update viewer
        this.viewer.updateClothingColor(pieceType, color, part);
        
        // Update design data
        if (!this.designData.colors[pieceType]) {
            this.designData.colors[pieceType] = {};
        }
        this.designData.colors[pieceType][part] = color;
        
        // Update color preview
        this.updateColorPreview(input, color);
    }

    updateColorPreview(input, color) {
        const preview = input.parentElement.querySelector('.color-preview');
        if (preview) {
            preview.style.backgroundColor = color;
        }
    }

    applyPresetColor(color) {
        if (!this.selectedPiece) {
            // Apply to all visible pieces
            Object.keys(this.designData.pieces).forEach(pieceType => {
                this.viewer.updateClothingColor(pieceType, color, this.selectedPart);
                
                if (!this.designData.colors[pieceType]) {
                    this.designData.colors[pieceType] = {};
                }
                this.designData.colors[pieceType][this.selectedPart] = color;
            });
        } else {
            this.viewer.updateClothingColor(this.selectedPiece, color, this.selectedPart);
            
            if (!this.designData.colors[this.selectedPiece]) {
                this.designData.colors[this.selectedPiece] = {};
            }
            this.designData.colors[this.selectedPiece][this.selectedPart] = color;
        }
    }

    applyPattern(pattern) {
        if (!this.selectedPiece) {
            console.warn('No piece selected for pattern application');
            return;
        }

        const options = this.getPatternOptions(pattern);
        this.viewer.updateClothingPattern(this.selectedPiece, pattern, options);
        
        this.designData.patterns[this.selectedPiece] = { type: pattern, options };
        
        console.log(`Applied pattern ${pattern} to ${this.selectedPiece}`);
    }

    getPatternOptions(pattern) {
        // Get pattern options from UI if available
        const options = {};
        
        switch (pattern) {
            case 'stripes':
                options.color1 = document.getElementById('pattern-color1')?.value || '#ffffff';
                options.color2 = document.getElementById('pattern-color2')?.value || '#333333';
                options.stripeWidth = parseInt(document.getElementById('stripe-width')?.value) || 16;
                options.horizontal = document.getElementById('stripe-horizontal')?.checked || false;
                break;
            case 'dots':
                options.bgColor = document.getElementById('pattern-bg-color')?.value || '#ffffff';
                options.dotColor = document.getElementById('pattern-dot-color')?.value || '#333333';
                options.dotSize = parseInt(document.getElementById('dot-size')?.value) || 8;
                options.spacing = parseInt(document.getElementById('dot-spacing')?.value) || 24;
                break;
            case 'gradient':
                options.color1 = document.getElementById('gradient-color1')?.value || '#667eea';
                options.color2 = document.getElementById('gradient-color2')?.value || '#764ba2';
                options.angle = parseInt(document.getElementById('gradient-angle')?.value) || 45;
                break;
            case 'checkered':
                options.color1 = document.getElementById('checker-color1')?.value || '#ffffff';
                options.color2 = document.getElementById('checker-color2')?.value || '#333333';
                options.squareSize = parseInt(document.getElementById('checker-size')?.value) || 32;
                break;
        }
        
        return options;
    }

    async onLogoUpload(file) {
        if (!file) return;

        const pieceType = document.getElementById('logo_piece_type')?.value;
        const location = document.getElementById('logo_position')?.value;
        const size = parseFloat(document.getElementById('logo_size')?.value) || 0.2;

        if (!pieceType || !location) {
            this.showNotification('يرجى اختيار القطعة والموضع', 'warning');
            return;
        }

        try {
            await this.viewer.addLogo(pieceType, location, file, { size });
            
            this.designData.logos.push({
                pieceType,
                location,
                size,
                filename: file.name
            });
            
            this.showNotification('تم إضافة الشعار بنجاح', 'success');
            this.updateLogoList();
        } catch (error) {
            console.error('Error adding logo:', error);
            this.showNotification('حدث خطأ أثناء إضافة الشعار', 'error');
        }
    }

    addText() {
        const text = document.getElementById('text_content')?.value;
        const pieceType = document.getElementById('text_piece_type')?.value;
        const location = document.getElementById('text_position')?.value;
        const color = document.getElementById('text_color')?.value || '#000000';
        const size = parseFloat(document.getElementById('text_size')?.value) || 0.3;
        const fontWeight = document.getElementById('text_style')?.value || 'bold';

        if (!text || !pieceType || !location) {
            this.showNotification('يرجى إدخال النص واختيار القطعة والموضع', 'warning');
            return;
        }

        try {
            this.viewer.addText(pieceType, location, text, {
                color,
                size,
                fontWeight,
                fontSize: 80
            });
            
            this.designData.texts.push({
                text,
                pieceType,
                location,
                color,
                size,
                fontWeight
            });
            
            this.showNotification('تم إضافة النص بنجاح', 'success');
            this.updateTextList();
            
            // Clear input
            document.getElementById('text_content').value = '';
        } catch (error) {
            console.error('Error adding text:', error);
            this.showNotification('حدث خطأ أثناء إضافة النص', 'error');
        }
    }

    updateLogoList() {
        const listContainer = document.getElementById('logo-list');
        if (!listContainer) return;

        listContainer.innerHTML = '';
        
        this.designData.logos.forEach((logo, index) => {
            const item = document.createElement('div');
            item.className = 'logo-list-item';
            item.innerHTML = `
                <span>${logo.filename} - ${logo.pieceType} (${logo.location})</span>
                <button type="button" class="btn btn-sm btn-danger" onclick="designInterface.removeLogo(${index})">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            listContainer.appendChild(item);
        });
    }

    updateTextList() {
        const listContainer = document.getElementById('text-list');
        if (!listContainer) return;

        listContainer.innerHTML = '';
        
        this.designData.texts.forEach((textItem, index) => {
            const item = document.createElement('div');
            item.className = 'text-list-item';
            item.innerHTML = `
                <span>"${textItem.text}" - ${textItem.pieceType} (${textItem.location})</span>
                <button type="button" class="btn btn-sm btn-danger" onclick="designInterface.removeText(${index})">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            listContainer.appendChild(item);
        });
    }

    removeLogo(index) {
        this.viewer.removeLogo(index);
        this.designData.logos.splice(index, 1);
        this.updateLogoList();
        this.showNotification('تم حذف الشعار', 'info');
    }

    removeText(index) {
        this.viewer.removeText(index);
        this.designData.texts.splice(index, 1);
        this.updateTextList();
        this.showNotification('تم حذف النص', 'info');
    }

    updateLogoPositionOptions(pieceType) {
        const positionSelect = document.getElementById('logo_position');
        if (!positionSelect) return;

        const positions = this.getAvailablePositions(pieceType);
        
        positionSelect.innerHTML = '<option value="">اختر الموضع</option>';
        positions.forEach(pos => {
            const option = document.createElement('option');
            option.value = pos.value;
            option.textContent = pos.label;
            positionSelect.appendChild(option);
        });
    }

    updateTextPositionOptions(pieceType) {
        const positionSelect = document.getElementById('text_position');
        if (!positionSelect) return;

        const positions = this.getAvailablePositions(pieceType);
        
        positionSelect.innerHTML = '<option value="">اختر الموضع</option>';
        positions.forEach(pos => {
            const option = document.createElement('option');
            option.value = pos.value;
            option.textContent = pos.label;
            positionSelect.appendChild(option);
        });
    }

    getAvailablePositions(pieceType) {
        const positions = {
            'shirt': [
                { value: 'front-center', label: 'منتصف الصدر' },
                { value: 'front-left', label: 'الصدر الأيسر' },
                { value: 'front-right', label: 'الصدر الأيمن' },
                { value: 'back-center', label: 'منتصف الظهر' },
                { value: 'left-sleeve', label: 'الذراع الأيسر' },
                { value: 'right-sleeve', label: 'الذراع الأيمن' },
                { value: 'collar', label: 'الياقة' }
            ],
            'tshirt': [
                { value: 'front-center', label: 'منتصف الصدر' },
                { value: 'front-left', label: 'الصدر الأيسر' },
                { value: 'front-right', label: 'الصدر الأيمن' },
                { value: 'back-center', label: 'منتصف الظهر' },
                { value: 'left-sleeve', label: 'الذراع الأيسر' },
                { value: 'right-sleeve', label: 'الذراع الأيمن' }
            ],
            'pants': [
                { value: 'left-leg', label: 'الساق الأيسر' },
                { value: 'right-leg', label: 'الساق الأيمن' },
                { value: 'waist', label: 'الحزام' }
            ],
            'shorts': [
                { value: 'left-leg', label: 'الساق الأيسر' },
                { value: 'right-leg', label: 'الساق الأيمن' },
                { value: 'waist', label: 'الحزام' }
            ],
            'jacket': [
                { value: 'front-center', label: 'منتصف الصدر' },
                { value: 'back-center', label: 'منتصف الظهر' },
                { value: 'left-sleeve', label: 'الذراع الأيسر' },
                { value: 'right-sleeve', label: 'الذراع الأيمن' }
            ],
            'socks': [
                { value: 'left-sock', label: 'الشراب الأيسر' },
                { value: 'right-sock', label: 'الشراب الأيمن' }
            ],
            'shoes': [
                { value: 'left-shoe', label: 'الحذاء الأيسر' },
                { value: 'right-shoe', label: 'الحذاء الأيمن' }
            ]
        };
        
        return positions[pieceType] || [];
    }

    updateSizeSummary() {
        let totalPieces = 0;
        const sizeInputs = document.querySelectorAll('.size-input');
        
        sizeInputs.forEach(input => {
            const value = parseInt(input.value) || 0;
            totalPieces += value;
        });
        
        const totalDisplay = document.getElementById('total-pieces');
        if (totalDisplay) {
            totalDisplay.textContent = totalPieces;
        }
        
        // Update hidden form field
        const quantityInput = document.getElementById('quantity');
        if (quantityInput) {
            quantityInput.value = totalPieces;
        }
        
        this.designData.totalPieces = totalPieces;
    }

    updatePieceCount() {
        const pieceCount = Object.keys(this.designData.pieces).length;
        const countDisplay = document.getElementById('piece-count');
        if (countDisplay) {
            countDisplay.textContent = pieceCount;
        }
    }

    onPieceSelected(detail) {
        this.selectedPiece = detail.type;
        console.log(`Piece selected: ${detail.type}, part: ${detail.part}`);
        
        // Update UI to show this piece is selected
        this.highlightSelectedPiece(detail.type);
    }

    highlightSelectedPiece(pieceType) {
        // Add visual feedback for selected piece
        const checkboxes = document.querySelectorAll('.clothing-piece-checkbox');
        checkboxes.forEach(checkbox => {
            const label = checkbox.closest('label') || checkbox.parentElement;
            if (checkbox.dataset.pieceType === pieceType) {
                label.classList.add('piece-selected');
            } else {
                label.classList.remove('piece-selected');
            }
        });
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <i class="fas fa-${this.getNotificationIcon(type)} me-2"></i>
            <span>${message}</span>
        `;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    getNotificationIcon(type) {
        const icons = {
            'success': 'check-circle',
            'error': 'exclamation-circle',
            'warning': 'exclamation-triangle',
            'info': 'info-circle'
        };
        return icons[type] || 'info-circle';
    }

    // Export design data for form submission
    exportDesignData() {
        const designJSON = JSON.stringify(this.designData);
        
        // Set hidden form fields
        const designField = document.getElementById('design_3d_data');
        if (designField) {
            designField.value = designJSON;
        }
        
        return this.designData;
    }

    // Capture screenshot for preview
    capturePreview() {
        if (this.viewer) {
            const screenshot = this.viewer.captureScreenshot();
            
            // Set hidden form field
            const previewField = document.getElementById('design_preview_image');
            if (previewField) {
                previewField.value = screenshot;
            }
            
            return screenshot;
        }
        return null;
    }
}

// Initialize when DOM is ready
let designInterface;

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        designInterface = new DesignInterface();
        window.designInterface = designInterface;
    });
} else {
    designInterface = new DesignInterface();
    window.designInterface = designInterface;
}

