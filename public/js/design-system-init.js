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
    };
    
    function updateTotalQuantity() {
        let total = 0;
        document.querySelectorAll('.size-input, .size-quantity').forEach(input => {
            total += parseInt(input.value) || 0;
        });
        
        // Update displays
        const displays = ['total-pieces', 'summary_quantity'];
        displays.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = total;
        });
        
        // Update hidden field
        const quantityField = document.getElementById('quantity');
        if (quantityField) quantityField.value = total;
    }
    
    // Initialize when ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

