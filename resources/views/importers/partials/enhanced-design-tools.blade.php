{{-- Enhanced Design Tools Partial --}}
<div class="enhanced-design-system">
    <div class="eds-main-grid">
        <!-- Control Panel -->
        <div class="eds-controls-panel">
            <!-- Activity Type Section -->
            <div class="eds-section">
                <h5 class="eds-section-title">
                    <i class="fas fa-building"></i>
                    نوع النشاط
                </h5>
                <select class="eds-form-control" id="design_activity_type" name="design_activity_type">
                <option value="">اختر نوع النشاط</option>
                <option value="academy">أكاديمية رياضية</option>
                <option value="school">مدرسة</option>
                <option value="hospital">مستشفى</option>
                <option value="company">شركة</option>
                <option value="other">أخرى</option>
            </select>
        </div>

            <!-- Clothing Pieces Section -->
            <div class="eds-section">
                <h5 class="eds-section-title">
                    <i class="fas fa-tshirt"></i>
                    قطع الملابس
                </h5>
                <div class="eds-piece-grid">
                <label class="piece-option">
                    <input type="checkbox" class="clothing-piece-checkbox" 
                           data-piece-type="shirt" id="piece_shirt" name="clothing_pieces[]" value="shirt">
                    <span class="piece-icon">👕</span>
                    <span class="piece-label">تيشرت</span>
                </label>
                
                <label class="piece-option">
                    <input type="checkbox" class="clothing-piece-checkbox" 
                           data-piece-type="pants" id="piece_pants" name="clothing_pieces[]" value="pants">
                    <span class="piece-icon">👖</span>
                    <span class="piece-label">بنطلون</span>
                </label>
                
                <label class="piece-option">
                    <input type="checkbox" class="clothing-piece-checkbox" 
                           data-piece-type="shorts" id="piece_shorts" name="clothing_pieces[]" value="shorts">
                    <span class="piece-icon">🩳</span>
                    <span class="piece-label">شورت</span>
                </label>
                
                <label class="piece-option">
                    <input type="checkbox" class="clothing-piece-checkbox" 
                           data-piece-type="jacket" id="piece_jacket" name="clothing_pieces[]" value="jacket">
                    <span class="piece-icon">🧥</span>
                    <span class="piece-label">جاكيت</span>
                </label>
                
                <label class="piece-option">
                    <input type="checkbox" class="clothing-piece-checkbox" 
                           data-piece-type="shoes" id="piece_shoes" name="clothing_pieces[]" value="shoes">
                    <span class="piece-icon">👟</span>
                    <span class="piece-label">حذاء</span>
                </label>
                
                <label class="piece-option">
                    <input type="checkbox" class="clothing-piece-checkbox" 
                           data-piece-type="socks" id="piece_socks" name="clothing_pieces[]" value="socks">
                    <span class="piece-icon">🧦</span>
                    <span class="piece-label">شراب</span>
                </label>
            </div>
        </div>

        <!-- Sizes Section -->
        <div class="control-section">
            <h5 class="section-title">
                <i class="fas fa-ruler"></i>
                المقاسات والكميات
            </h5>
            <div id="sizes-container">
                <p class="text-muted text-center">اختر قطع الملابس أولاً</p>
            </div>
        </div>

        <!-- Color Customization Section -->
        <div class="control-section">
            <h5 class="section-title">
                <i class="fas fa-palette"></i>
                تخصيص الألوان
            </h5>
            
            <!-- Part Selection -->
            <div class="color-parts">
                <button type="button" class="part-selector-btn active" data-part="body">
                    الجسم
                </button>
                <button type="button" class="part-selector-btn" data-part="sleeves">
                    الأكمام
                </button>
                <button type="button" class="part-selector-btn" data-part="collar">
                    الياقة
                </button>
            </div>

            <!-- Color Picker -->
            <div class="color-picker-group">
                <div class="color-picker-wrapper">
                    <input type="color" class="color-picker" id="main-color-picker" value="#4A90E2">
                    <div class="color-preview" style="background-color: #4A90E2;"></div>
                </div>
            </div>

            <!-- Preset Colors -->
            <div class="preset-colors">
                <button type="button" class="preset-color" data-color="#FF6B6B" style="background-color: #FF6B6B;" title="أحمر"></button>
                <button type="button" class="preset-color" data-color="#4ECDC4" style="background-color: #4ECDC4;" title="أزرق فاتح"></button>
                <button type="button" class="preset-color" data-color="#45B7D1" style="background-color: #45B7D1;" title="أزرق"></button>
                <button type="button" class="preset-color" data-color="#FFA07A" style="background-color: #FFA07A;" title="برتقالي"></button>
                <button type="button" class="preset-color" data-color="#98D8C8" style="background-color: #98D8C8;" title="أخضر فاتح"></button>
                <button type="button" class="preset-color" data-color="#F7DC6F" style="background-color: #F7DC6F;" title="أصفر"></button>
                <button type="button" class="preset-color" data-color="#BB8FCE" style="background-color: #BB8FCE;" title="بنفسجي"></button>
                <button type="button" class="preset-color" data-color="#85929E" style="background-color: #85929E;" title="رمادي"></button>
                <button type="button" class="preset-color" data-color="#2C3E50" style="background-color: #2C3E50;" title="أسود"></button>
                <button type="button" class="preset-color" data-color="#FFFFFF" style="background-color: #FFFFFF; border: 2px solid #ddd;" title="أبيض"></button>
                <button type="button" class="preset-color" data-color="#E74C3C" style="background-color: #E74C3C;" title="أحمر داكن"></button>
                <button type="button" class="preset-color" data-color="#3498DB" style="background-color: #3498DB;" title="أزرق ملكي"></button>
            </div>
        </div>

        <!-- Patterns Section -->
        <div class="control-section">
            <h5 class="section-title">
                <i class="fas fa-border-style"></i>
                الزخارف
            </h5>
            <div class="pattern-options">
                <button type="button" class="pattern-option active" data-pattern="solid">
                    <span class="pattern-icon">▬</span>
                    <span class="pattern-label">لون موحد</span>
                </button>
                <button type="button" class="pattern-option" data-pattern="stripes">
                    <span class="pattern-icon">|||</span>
                    <span class="pattern-label">خطوط</span>
                </button>
                <button type="button" class="pattern-option" data-pattern="dots">
                    <span class="pattern-icon">⋮⋮⋮</span>
                    <span class="pattern-label">نقاط</span>
                </button>
                <button type="button" class="pattern-option" data-pattern="gradient">
                    <span class="pattern-icon">⬌</span>
                    <span class="pattern-label">تدرج</span>
                </button>
            </div>
        </div>

        <!-- Logo Upload Section -->
        <div class="control-section">
            <h5 class="section-title">
                <i class="fas fa-image"></i>
                الشعار
            </h5>
            
            <div class="logo-upload-area" id="logo-upload-area">
                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                <p class="upload-text">اسحب الشعار هنا أو انقر للاختيار</p>
                <p class="upload-hint">JPG, PNG, SVG حتى 5MB</p>
                <input type="file" id="logo_file" name="logo_file" accept="image/*" style="display: none;">
            </div>
            
            <div class="logo-input mt-3">
                <label class="form-label">موضع الشعار</label>
                <select class="form-control-modern" id="logo_piece_type" name="logo_piece_type">
                    <option value="">اختر القطعة</option>
                    <option value="shirt">التيشرت</option>
                    <option value="pants">البنطلون</option>
                    <option value="shorts">الشورت</option>
                    <option value="jacket">الجاكيت</option>
                    <option value="socks">الشراب</option>
                </select>
                
                <select class="form-control-modern mt-2" id="logo_position" name="logo_position">
                    <option value="">اختر الموضع</option>
                </select>
                
                <div class="mt-2">
                    <label class="form-label">حجم الشعار</label>
                    <select class="form-control-modern" id="logo_size" name="logo_size">
                        <option value="0.15">صغير</option>
                        <option value="0.20" selected>متوسط</option>
                        <option value="0.30">كبير</option>
                    </select>
                </div>
            </div>
            
            <div id="logo-list" class="mt-3"></div>
        </div>

        <!-- Text Section -->
        <div class="control-section">
            <h5 class="section-title">
                <i class="fas fa-font"></i>
                النصوص
            </h5>
            
            <div class="text-input">
                <input type="text" class="form-control-modern" id="text_content" 
                       placeholder="مثال: اسم المؤسسة" maxlength="50">
                
                <select class="form-control-modern mt-2" id="text_piece_type" name="text_piece_type">
                    <option value="">اختر القطعة</option>
                    <option value="shirt">التيشرت</option>
                    <option value="pants">البنطلون</option>
                    <option value="shorts">الشورت</option>
                    <option value="jacket">الجاكيت</option>
                </select>
                
                <select class="form-control-modern mt-2" id="text_position" name="text_position">
                    <option value="">اختر الموضع</option>
                </select>
                
                <div class="row mt-2">
                    <div class="col-6">
                        <label class="form-label">لون النص</label>
                        <input type="color" class="form-control-modern" id="text_color" value="#000000">
                    </div>
                    <div class="col-6">
                        <label class="form-label">حجم النص</label>
                        <select class="form-control-modern" id="text_size">
                            <option value="0.25">صغير</option>
                            <option value="0.30" selected>متوسط</option>
                            <option value="0.40">كبير</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-2">
                    <label class="form-label">نمط النص</label>
                    <select class="form-control-modern" id="text_style">
                        <option value="normal">عادي</option>
                        <option value="bold" selected>عريض</option>
                        <option value="italic">مائل</option>
                    </select>
                </div>
                
                <button type="button" class="btn-modern btn-primary-modern w-100 mt-2" id="add-text-btn">
                    <i class="fas fa-plus"></i>
                    إضافة النص
                </button>
            </div>
            
            <div id="text-list" class="mt-3"></div>
        </div>

        <!-- Summary Section -->
        <div class="control-section">
            <h5 class="section-title">
                <i class="fas fa-list-check"></i>
                ملخص الطلب
            </h5>
            <div class="summary-card">
                <div class="summary-item">
                    <span class="summary-label">إجمالي القطع:</span>
                    <span class="summary-value" id="total-pieces">0</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">عدد الأصناف:</span>
                    <span class="summary-value" id="piece-count">0</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 3D Viewer Panel -->
    <div class="viewer-panel">
        <div class="viewer-header">
            <div class="viewer-title">
                <i class="fas fa-cube"></i>
                معاينة ثلاثية الأبعاد
            </div>
            <div class="viewer-actions">
                <button type="button" class="btn btn-sm btn-light" id="toggle-auto-rotate" title="دوران تلقائي">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button type="button" class="btn btn-sm btn-light" id="capture-screenshot" title="التقاط صورة">
                    <i class="fas fa-camera"></i>
                </button>
            </div>
        </div>
        
        <div class="viewer-container">
            <div id="3d-viewer"></div>
            
            <!-- Viewer Controls -->
            <div class="viewer-controls">
                <div class="viewer-controls-row">
                    <button type="button" class="viewer-btn" id="rotate-model" title="تدوير">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button type="button" class="viewer-btn" id="zoom-in" title="تكبير">
                        <i class="fas fa-search-plus"></i>
                    </button>
                </div>
                <div class="viewer-controls-row">
                    <button type="button" class="viewer-btn" id="zoom-out" title="تصغير">
                        <i class="fas fa-search-minus"></i>
                    </button>
                    <button type="button" class="viewer-btn" id="reset-view" title="إعادة تعيين">
                        <i class="fas fa-home"></i>
                    </button>
                </div>
            </div>
            
            <!-- View Switcher -->
            <div class="view-switcher">
                <button type="button" class="view-btn active" id="view-front" data-view="front">
                    <i class="fas fa-user"></i>
                </button>
                <button type="button" class="view-btn" id="view-back" data-view="back">
                    <i class="fas fa-user-slash"></i>
                </button>
                <button type="button" class="view-btn" id="view-left" data-view="left">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <button type="button" class="view-btn" id="view-right" data-view="right">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Fields for Form Submission -->
<input type="hidden" id="design_3d_data" name="design_3d_data">
<input type="hidden" id="design_preview_image" name="design_preview_image">
<input type="hidden" id="quantity" name="quantity" value="0">

<script>
// Make sure to bind the logo upload area click
document.addEventListener('DOMContentLoaded', function() {
    const logoUploadArea = document.getElementById('logo-upload-area');
    const logoFileInput = document.getElementById('logo_file');
    
    if (logoUploadArea && logoFileInput) {
        logoUploadArea.addEventListener('click', function() {
            logoFileInput.click();
        });
        
        // Drag and drop functionality
        logoUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            logoUploadArea.classList.add('drag-over');
        });
        
        logoUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            logoUploadArea.classList.remove('drag-over');
        });
        
        logoUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            logoUploadArea.classList.remove('drag-over');
            
            if (e.dataTransfer.files.length > 0) {
                logoFileInput.files = e.dataTransfer.files;
                const event = new Event('change', { bubbles: true });
                logoFileInput.dispatchEvent(event);
            }
        });
    }
    
    // Bind view switcher buttons
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            const view = btn.dataset.view;
            if (window.designInterface && window.designInterface.viewer) {
                window.designInterface.viewer.setView(view);
            }
        });
    });
    
    // Bind screenshot capture
    const captureBtn = document.getElementById('capture-screenshot');
    if (captureBtn) {
        captureBtn.addEventListener('click', function() {
            if (window.designInterface) {
                window.designInterface.capturePreview();
                window.designInterface.showNotification('تم التقاط الصورة', 'success');
            }
        });
    }
    
    // Bind auto-rotate toggle
    const autoRotateBtn = document.getElementById('toggle-auto-rotate');
    if (autoRotateBtn) {
        autoRotateBtn.addEventListener('click', function() {
            if (window.designInterface && window.designInterface.viewer) {
                const isRotating = window.designInterface.viewer.toggleAutoRotate();
                autoRotateBtn.classList.toggle('active', isRotating);
            }
        });
    }
    
    // Export design data before form submission
    const form = document.getElementById('multiStepForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (window.designInterface) {
                window.designInterface.exportDesignData();
                window.designInterface.capturePreview();
            }
        });
    }
});
</script>

