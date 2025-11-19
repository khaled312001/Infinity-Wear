/**
 * إصلاحات التهيئة للفورم
 */

(function() {
    'use strict';
    
    // إصلاح التهيئة عند تحميل الصفحة
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFormFixes);
    } else {
        initFormFixes();
    }
    
    function initFormFixes() {
        console.log('Initializing form fixes...');
        
        // إصلاح اتجاه النص
        const wrapper = document.querySelector('.importer-form-wrapper');
        if (wrapper) {
            wrapper.setAttribute('dir', 'rtl');
        }
        
        // إصلاح عرض المجسم
        const viewer = document.getElementById('model-viewer');
        if (viewer) {
            viewer.style.width = '100%';
            viewer.style.height = '100%';
        }
        
        // إصلاح placeholder المجسم
        const placeholder = document.getElementById('modelPlaceholder');
        if (placeholder) {
            placeholder.style.display = 'flex';
            placeholder.style.flexDirection = 'column';
            placeholder.style.alignItems = 'center';
            placeholder.style.justifyContent = 'center';
            placeholder.style.height = '100%';
        }
        
        // إصلاح الأزرار
        const buttons = document.querySelectorAll('.importer-form-wrapper .btn');
        buttons.forEach(btn => {
            btn.style.display = 'inline-flex';
            btn.style.alignItems = 'center';
            btn.style.gap = '0.5rem';
        });
        
        // إصلاح Grid
        const rows = document.querySelectorAll('.importer-form-wrapper .row');
        rows.forEach(row => {
            row.style.display = 'flex';
            row.style.flexWrap = 'wrap';
            row.style.marginRight = '-0.75rem';
            row.style.marginLeft = '-0.75rem';
        });
        
        // إصلاح Form Content
        const formContent = document.querySelector('.importer-form-wrapper .form-content');
        if (formContent) {
            formContent.style.display = 'flex';
            formContent.style.flexDirection = 'row-reverse';
        }
        
        // إصلاح Viewer Sidebar
        const viewerSidebar = document.querySelector('.importer-form-wrapper .viewer-sidebar');
        if (viewerSidebar) {
            viewerSidebar.style.order = '1';
            viewerSidebar.style.flexShrink = '0';
        }
        
        // إصلاح Steps Container
        const stepsContainer = document.querySelector('.importer-form-wrapper .steps-container');
        if (stepsContainer) {
            stepsContainer.style.order = '2';
            stepsContainer.style.flex = '1';
        }
        
        console.log('Form fixes applied successfully');
    }
    
    // إصلاح عند تغيير حجم النافذة
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // إعادة حساب أبعاد المجسم
            if (window.importerForm && window.importerForm.viewer3D) {
                window.importerForm.viewer3D.onWindowResize();
            }
        }, 250);
    });
    
})();

