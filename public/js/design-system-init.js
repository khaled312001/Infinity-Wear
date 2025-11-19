/**
 * Design System Initialization
 * Auto-initialization and integration with existing form
 */

(function() {
    'use strict';
    
    // Wait for DOM to be ready
    const init = () => {
        console.log('🎨 Initializing Enhanced 3D Design System...');
        
        // Check if design option custom is selected
        const designOptionCustom = document.getElementById('design_option_custom');
        if (designOptionCustom) {
            designOptionCustom.addEventListener('change', function() {
                if (this.checked) {
                    // Hide other design details
                    document.querySelectorAll('.design-detail').forEach(el => {
                        el.style.display = 'none';
                    });
                    
                    // Show enhanced design tools
                    const customDetail = document.getElementById('design_custom_detail');
                    if (customDetail) {
                        customDetail.style.display = 'block';
                    }
                    
                    console.log('✓ Enhanced design tools activated');
                }
            });
        }
        
        // Auto-update quantity from size inputs
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('size-input') || 
                e.target.classList.contains('size-quantity')) {
                updateTotalQuantity();
            }
        });
        
        // Bind clothing piece checkboxes
        document.querySelectorAll('.clothing-piece-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const pieceType = this.dataset.pieceType || this.value;
                const sizeContainer = document.getElementById(`size-${pieceType}`);
                
                if (this.checked && sizeContainer) {
                    sizeContainer.style.display = 'block';
                } else if (sizeContainer) {
                    sizeContainer.style.display = 'none';
                    // Reset quantities
                    sizeContainer.querySelectorAll('input[type="number"]').forEach(input => {
                        input.value = 0;
                    });
                }
                
                updateTotalQuantity();
            });
        });
        
        // Update color value display
        const mainColorPicker = document.getElementById('main-color-picker');
        const colorValueDisplay = document.getElementById('color-value-display');
        if (mainColorPicker && colorValueDisplay) {
            mainColorPicker.addEventListener('input', function() {
                colorValueDisplay.textContent = this.value.toUpperCase();
            });
            // Set initial value
            if (colorValueDisplay) {
                colorValueDisplay.textContent = mainColorPicker.value.toUpperCase();
            }
        }
        
        // Update piece item active state
        document.querySelectorAll('.iw-cd-piece-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const pieceItem = this.closest('.iw-cd-piece-item');
                if (pieceItem) {
                    if (this.checked) {
                        pieceItem.classList.add('active');
                    } else {
                        pieceItem.classList.remove('active');
                    }
                }
            });
        });
        
        // Update pattern item active state
        document.querySelectorAll('.iw-cd-pattern-item').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.iw-cd-pattern-item').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Update part button active state
        document.querySelectorAll('.part-selector-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.part-selector-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Logo upload functionality
        setupLogoUpload();
        
        // Preset colors functionality
        setupPresetColors();
        
        // Add text button functionality
        setupAddTextButton();
        
        // Update position options based on piece selection
        setupPositionOptions();
        
        // Setup sizes display when pieces are selected
        setupSizesDisplay();
        
        // Setup view buttons
        setupViewButtons();
    };
    
    function setupLogoUpload() {
        const logoUploadArea = document.getElementById('logo-upload-area');
        const logoFileInput = document.getElementById('logo_file');
        
        if (logoUploadArea && logoFileInput) {
            // Click to upload
            logoUploadArea.addEventListener('click', function() {
                logoFileInput.click();
            });
            
            // Drag and drop
            logoUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                logoUploadArea.classList.add('dragover');
            });
            
            logoUploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                logoUploadArea.classList.remove('dragover');
            });
            
            logoUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                logoUploadArea.classList.remove('dragover');
                
                if (e.dataTransfer.files.length > 0) {
                    logoFileInput.files = e.dataTransfer.files;
                    handleLogoFile(logoFileInput.files[0]);
                }
            });
            
            // File input change
            logoFileInput.addEventListener('change', function(e) {
                if (this.files.length > 0) {
                    handleLogoFile(this.files[0]);
                }
            });
        }
    }
    
    function handleLogoFile(file) {
        if (!file.type.startsWith('image/')) {
            alert('الرجاء اختيار ملف صورة');
            return;
        }
        
        if (file.size > 5 * 1024 * 1024) {
            alert('حجم الملف يجب أن يكون أقل من 5MB');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const logoList = document.getElementById('logo-list');
            if (logoList) {
                const logoItem = document.createElement('div');
                logoItem.className = 'logo-item';
                logoItem.innerHTML = `
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <img src="${e.target.result}" style="width: 40px; height: 40px; object-fit: contain; border-radius: 4px;">
                        <span style="font-size: 0.85rem; font-weight: 600;">${file.name}</span>
                    </div>
                    <button type="button" class="eds-btn" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                logoList.appendChild(logoItem);
            }
        };
        reader.readAsDataURL(file);
    }
    
    function setupPresetColors() {
        const presetColors = document.querySelectorAll('.iw-cd-preset-color');
        const mainColorPicker = document.getElementById('main-color-picker');
        
        presetColors.forEach(preset => {
            preset.addEventListener('click', function() {
                const color = this.dataset.color;
                if (mainColorPicker) {
                    mainColorPicker.value = color;
                    mainColorPicker.dispatchEvent(new Event('input'));
                }
                
                // Update active state
                presetColors.forEach(p => p.classList.remove('selected'));
                this.classList.add('selected');
            });
        });
    }
    
    function setupAddTextButton() {
        const addTextBtn = document.getElementById('add-text-btn');
        const textContent = document.getElementById('text_content');
        const textList = document.getElementById('text-list');
        
        if (addTextBtn && textContent && textList) {
            addTextBtn.addEventListener('click', function() {
                const text = textContent.value.trim();
                if (!text) {
                    alert('الرجاء إدخال النص');
                    return;
                }
                
                const pieceType = (document.getElementById('text_piece_type') || document.getElementById('cd-text_piece_type'))?.value;
                const position = (document.getElementById('cd-text_position') || document.getElementById('text_position'))?.value;
                const color = (document.getElementById('cd-text_color') || document.getElementById('text_color'))?.value || '#000000';
                const size = (document.getElementById('cd-text_size') || document.getElementById('text_size'))?.value || '0.30';
                const style = (document.getElementById('cd-text_style') || document.getElementById('text_style'))?.value || 'normal';
                
                if (!pieceType || !position) {
                    alert('الرجاء اختيار القطعة والموضع');
                    return;
                }
                
                const textItem = document.createElement('div');
                textItem.className = 'text-item';
                textItem.innerHTML = `
                    <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                        <span style="font-weight: 600; font-size: 0.9rem;">${text}</span>
                        <span style="font-size: 0.75rem; color: #6c757d;">${pieceType} - ${position}</span>
                    </div>
                    <button type="button" class="eds-btn" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                textList.appendChild(textItem);
                
                // Reset form
                textContent.value = '';
            });
        }
    }
    
    function setupPositionOptions() {
        const logoPieceType = document.getElementById('logo_piece_type') || document.getElementById('cd-logo_piece_type');
        const logoPosition = document.getElementById('cd-logo_position') || document.getElementById('logo_position');
        const textPieceType = document.getElementById('text_piece_type') || document.getElementById('cd-text_piece_type');
        const textPosition = document.getElementById('cd-text_position') || document.getElementById('text_position');
        
        const positionOptions = {
            shirt: [
                { value: 'front', label: 'منتصف الصدر' },
                { value: 'back', label: 'منتصف الظهر' },
                { value: 'leftSleeve', label: 'الذراع الأيسر' },
                { value: 'rightSleeve', label: 'الذراع الأيمن' },
                { value: 'collar', label: 'الياقة' }
            ],
            pants: [
                { value: 'front', label: 'الجبهة' },
                { value: 'back', label: 'الظهر' },
                { value: 'leftLeg', label: 'الساق الأيسر' },
                { value: 'rightLeg', label: 'الساق الأيمن' }
            ],
            shorts: [
                { value: 'front', label: 'الجبهة' },
                { value: 'back', label: 'الظهر' },
                { value: 'leftLeg', label: 'الساق الأيسر' },
                { value: 'rightLeg', label: 'الساق الأيمن' }
            ],
            jacket: [
                { value: 'front', label: 'منتصف الصدر' },
                { value: 'back', label: 'منتصف الظهر' },
                { value: 'leftSleeve', label: 'الذراع الأيسر' },
                { value: 'rightSleeve', label: 'الذراع الأيمن' }
            ],
            socks: [
                { value: 'leftSock', label: 'الشراب الأيسر' },
                { value: 'rightSock', label: 'الشراب الأيمن' }
            ]
        };
        
        function updatePositionOptions(selectElement, pieceType) {
            if (!selectElement) return;
            
            selectElement.innerHTML = '<option value="">اختر الموضع</option>';
            
            if (pieceType && positionOptions[pieceType]) {
                positionOptions[pieceType].forEach(option => {
                    const optionElement = document.createElement('option');
                    optionElement.value = option.value;
                    optionElement.textContent = option.label;
                    selectElement.appendChild(optionElement);
                });
            }
        }
        
        if (logoPieceType && logoPosition) {
            logoPieceType.addEventListener('change', function() {
                updatePositionOptions(logoPosition, this.value);
            });
        }
        
        if (textPieceType && textPosition) {
            textPieceType.addEventListener('change', function() {
                updatePositionOptions(textPosition, this.value);
            });
        }
    }
    
    function setupSizesDisplay() {
        const pieceCheckboxes = document.querySelectorAll('.clothing-piece-checkbox');
        const sizesContainer = document.getElementById('sizes-container');
        
        const sizesData = {
            shirt: {
                title: 'مقاسات القميص',
                sizes: ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL']
            },
            pants: {
                title: 'مقاسات البنطلون',
                sizes: ['28', '30', '32', '34', '36', '38', '40', '42']
            },
            shorts: {
                title: 'مقاسات الشورت',
                sizes: ['XS', 'S', 'M', 'L', 'XL', 'XXL']
            },
            jacket: {
                title: 'مقاسات الجاكيت',
                sizes: ['XS', 'S', 'M', 'L', 'XL', 'XXL']
            },
            shoes: {
                title: 'مقاسات الحذاء',
                sizes: ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45']
            },
            socks: {
                title: 'مقاسات الشراب',
                sizes: ['S', 'M', 'L', 'XL']
            }
        };
        
        pieceCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const pieceType = this.dataset.pieceType || this.value;
                updateSizesDisplay(pieceType, this.checked);
            });
        });
        
        function updateSizesDisplay(pieceType, isChecked) {
            if (!sizesContainer) return;
            
            // Remove empty state if exists
            const emptyState = sizesContainer.querySelector('.iw-cd-empty-state');
            if (emptyState && isChecked) {
                emptyState.remove();
            }
            
            if (!isChecked) {
                // Remove this piece's sizes group
                const existingGroup = sizesContainer.querySelector(`[data-piece="${pieceType}"]`);
                if (existingGroup) {
                    existingGroup.remove();
                }
                
                // Show empty state if no pieces selected
                if (sizesContainer.children.length === 0) {
                    sizesContainer.innerHTML = `
                        <div class="iw-cd-empty-state">
                            <i class="fas fa-info-circle" style="font-size: 2rem; color: #6c757d; margin-bottom: 0.5rem;"></i>
                            <p style="text-align: center; color: #6c757d; margin: 0;">اختر قطع الملابس أولاً</p>
                        </div>
                    `;
                }
                return;
            }
            
            const pieceData = sizesData[pieceType];
            if (!pieceData) return;
            
            // Check if already exists
            if (sizesContainer.querySelector(`[data-piece="${pieceType}"]`)) {
                return;
            }
            
            const sizesGroup = document.createElement('div');
            sizesGroup.className = 'piece-sizes-group';
            sizesGroup.setAttribute('data-piece', pieceType);
            
            let sizesHTML = `<h6 class="piece-sizes-title">${pieceData.title}</h6>`;
            sizesHTML += '<div class="sizes-grid">';
            
            pieceData.sizes.forEach(size => {
                sizesHTML += `
                    <div class="size-item">
                        <label class="size-label">${size}</label>
                        <input type="number" class="form-control size-quantity" 
                               name="${pieceType}_sizes[${size}]" min="0" value="0" placeholder="0">
                    </div>
                `;
            });
            
            sizesHTML += '</div>';
            sizesHTML += `
                <div class="total-quantity">
                    <span class="total-label">المجموع:</span>
                    <span class="total-value" id="${pieceType}_total">0</span>
                </div>
            `;
            
            sizesGroup.innerHTML = sizesHTML;
            sizesContainer.appendChild(sizesGroup);
            
            // Bind quantity inputs
            sizesGroup.querySelectorAll('.size-quantity').forEach(input => {
                input.addEventListener('input', function() {
                    updatePieceTotal(pieceType);
                    updateTotalQuantity();
                });
            });
        }
        
        function updatePieceTotal(pieceType) {
            const group = sizesContainer.querySelector(`[data-piece="${pieceType}"]`);
            if (!group) return;
            
            let total = 0;
            group.querySelectorAll('.size-quantity').forEach(input => {
                total += parseInt(input.value) || 0;
            });
            
            const totalElement = document.getElementById(`${pieceType}_total`);
            if (totalElement) {
                totalElement.textContent = total;
            }
        }
    }
    
    function setupViewButtons() {
        const viewButtons = document.querySelectorAll('.iw-cd-view-btn');
        viewButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                viewButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const view = this.dataset.view;
                console.log('Switching to view:', view);
                
                // Handle view change if viewer is available
                if (window.designInterface && window.designInterface.viewer) {
                    window.designInterface.viewer.setView(view);
                }
            });
        });
    }
    
    function updateTotalQuantity() {
        let total = 0;
        let pieceCount = 0;
        
        document.querySelectorAll('.size-input, .size-quantity').forEach(input => {
            const value = parseInt(input.value) || 0;
            total += value;
            if (value > 0) {
                // Count pieces with quantities
            }
        });
        
        // Count selected pieces
        document.querySelectorAll('.clothing-piece-checkbox:checked').forEach(() => {
            pieceCount++;
        });
        
        // Update displays
        const totalPiecesEl = document.getElementById('total-pieces');
        if (totalPiecesEl) totalPiecesEl.textContent = total;
        
        const pieceCountEl = document.getElementById('piece-count');
        if (pieceCountEl) pieceCountEl.textContent = pieceCount;
        
        const summaryQuantity = document.getElementById('summary_quantity');
        if (summaryQuantity) summaryQuantity.textContent = total;
        
        // Update hidden field
        const quantityField = document.getElementById('cd-quantity') || document.getElementById('quantity');
        if (quantityField) quantityField.value = total;
    }
    
    // Update piece count when checkboxes change
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('clothing-piece-checkbox')) {
            updateTotalQuantity();
        }
    });
    
    // Initialize when ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

