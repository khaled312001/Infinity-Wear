{{-- Enhanced Design Tools V2 - Modern & Isolated --}}
<div class="enhanced-design-system">
    <div class="eds-main-grid">
        <!-- Left Panel: Controls -->
        <div class="eds-controls-panel">
            
            <!-- Activity Type -->
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

            <!-- Clothing Pieces -->
            <div class="eds-section">
                <h5 class="eds-section-title">
                    <i class="fas fa-tshirt"></i>
                    قطع الملابس
                </h5>
                <div class="eds-piece-grid">
                    <label class="eds-piece-item">
                        <input type="checkbox" class="eds-piece-checkbox clothing-piece-checkbox" 
                               data-piece-type="shirt" id="piece_shirt" name="clothing_pieces[]" value="shirt">
                        <span class="eds-piece-icon">👕</span>
                        <span class="eds-piece-label">تيشرت</span>
                    </label>
                    
                    <label class="eds-piece-item">
                        <input type="checkbox" class="eds-piece-checkbox clothing-piece-checkbox" 
                               data-piece-type="pants" id="piece_pants" name="clothing_pieces[]" value="pants">
                        <span class="eds-piece-icon">👖</span>
                        <span class="eds-piece-label">بنطلون</span>
                    </label>
                    
                    <label class="eds-piece-item">
                        <input type="checkbox" class="eds-piece-checkbox clothing-piece-checkbox" 
                               data-piece-type="shorts" id="piece_shorts" name="clothing_pieces[]" value="shorts">
                        <span class="eds-piece-icon">🩳</span>
                        <span class="eds-piece-label">شورت</span>
                    </label>
                    
                    <label class="eds-piece-item">
                        <input type="checkbox" class="eds-piece-checkbox clothing-piece-checkbox" 
                               data-piece-type="jacket" id="piece_jacket" name="clothing_pieces[]" value="jacket">
                        <span class="eds-piece-icon">🧥</span>
                        <span class="eds-piece-label">جاكيت</span>
                    </label>
                    
                    <label class="eds-piece-item">
                        <input type="checkbox" class="eds-piece-checkbox clothing-piece-checkbox" 
                               data-piece-type="shoes" id="piece_shoes" name="clothing_pieces[]" value="shoes">
                        <span class="eds-piece-icon">👟</span>
                        <span class="eds-piece-label">حذاء</span>
                    </label>
                    
                    <label class="eds-piece-item">
                        <input type="checkbox" class="eds-piece-checkbox clothing-piece-checkbox" 
                               data-piece-type="socks" id="piece_socks" name="clothing_pieces[]" value="socks">
                        <span class="eds-piece-icon">🧦</span>
                        <span class="eds-piece-label">شراب</span>
                    </label>
                </div>
            </div>

            <!-- Sizes & Quantities -->
            <div class="eds-section">
                <h5 class="eds-section-title">
                    <i class="fas fa-ruler"></i>
                    المقاسات والكميات
                </h5>
                <div id="sizes-container">
                    <p style="text-align: center; color: #6c757d;">اختر قطع الملابس أولاً</p>
                </div>
            </div>

            <!-- Color Customization -->
            <div class="eds-section">
                <h5 class="eds-section-title">
                    <i class="fas fa-palette"></i>
                    تخصيص الألوان
                </h5>
                
                <div class="eds-color-parts">
                    <button type="button" class="eds-part-btn active part-selector-btn" data-part="body">
                        الجسم
                    </button>
                    <button type="button" class="eds-part-btn part-selector-btn" data-part="sleeves">
                        الأكمام
                    </button>
                    <button type="button" class="eds-part-btn part-selector-btn" data-part="collar">
                        الياقة
                    </button>
                </div>

                <div class="eds-color-picker-wrap">
                    <input type="color" class="eds-color-picker color-picker" id="main-color-picker" value="#4A90E2">
                </div>

                <div class="eds-preset-colors">
                    <button type="button" class="eds-preset-color preset-color" data-color="#FF6B6B" style="background-color: #FF6B6B;" title="أحمر"></button>
                    <button type="button" class="eds-preset-color preset-color" data-color="#4ECDC4" style="background-color: #4ECDC4;" title="أزرق فاتح"></button>
                    <button type="button" class="eds-preset-color preset-color" data-color="#45B7D1" style="background-color: #45B7D1;" title="أزرق"></button>
                    <button type="button" class="eds-preset-color preset-color" data-color="#FFA07A" style="background-color: #FFA07A;" title="برتقالي"></button>
                    <button type="button" class="eds-preset-color preset-color" data-color="#98D8C8" style="background-color: #98D8C8;" title="أخضر فاتح"></button>
                    <button type="button" class="eds-preset-color preset-color" data-color="#F7DC6F" style="background-color: #F7DC6F;" title="أصفر"></button>
                    <button type="button" class="eds-preset-color preset-color" data-color="#BB8FCE" style="background-color: #BB8FCE;" title="بنفسجي"></button>
                    <button type="button" class="eds-preset-color preset-color" data-color="#85929E" style="background-color: #85929E;" title="رمادي"></button>
                    <button type="button" class="eds-preset-color preset-color" data-color="#2C3E50" style="background-color: #2C3E50;" title="أسود"></button>
                    <button type="button" class="eds-preset-color preset-color" data-color="#FFFFFF" style="background-color: #FFFFFF; border: 2px solid #ddd;" title="أبيض"></button>
                    <button type="button" class="eds-preset-color preset-color" data-color="#E74C3C" style="background-color: #E74C3C;" title="أحمر داكن"></button>
                    <button type="button" class="eds-preset-color preset-color" data-color="#3498DB" style="background-color: #3498DB;" title="أزرق ملكي"></button>
                </div>
            </div>

            <!-- Patterns -->
            <div class="eds-section">
                <h5 class="eds-section-title">
                    <i class="fas fa-border-style"></i>
                    الزخارف
                </h5>
                <div class="eds-pattern-grid">
                    <button type="button" class="eds-pattern-item active pattern-option" data-pattern="solid">
                        <span class="eds-pattern-icon">▬</span>
                        <span class="eds-pattern-label">لون موحد</span>
                    </button>
                    <button type="button" class="eds-pattern-item pattern-option" data-pattern="stripes">
                        <span class="eds-pattern-icon">|||</span>
                        <span class="eds-pattern-label">خطوط</span>
                    </button>
                    <button type="button" class="eds-pattern-item pattern-option" data-pattern="dots">
                        <span class="eds-pattern-icon">⋮⋮⋮</span>
                        <span class="eds-pattern-label">نقاط</span>
                    </button>
                    <button type="button" class="eds-pattern-item pattern-option" data-pattern="gradient">
                        <span class="eds-pattern-icon">⬌</span>
                        <span class="eds-pattern-label">تدرج</span>
                    </button>
                </div>
            </div>

            <!-- Logo Upload -->
            <div class="eds-section">
                <h5 class="eds-section-title">
                    <i class="fas fa-image"></i>
                    الشعار
                </h5>
                
                <div class="eds-upload-area" id="logo-upload-area">
                    <i class="fas fa-cloud-upload-alt eds-upload-icon"></i>
                    <p class="eds-upload-text">اسحب الشعار هنا أو انقر للاختيار</p>
                    <p class="eds-upload-hint">JPG, PNG, SVG حتى 5MB</p>
                    <input type="file" id="logo_file" name="logo_file" accept="image/*" style="display: none;">
                </div>
                
                <div style="margin-top: 1rem;">
                    <select class="eds-form-control" style="margin-bottom: 0.5rem;" id="logo_piece_type" name="logo_piece_type">
                        <option value="">اختر القطعة</option>
                        <option value="shirt">التيشرت</option>
                        <option value="pants">البنطلون</option>
                        <option value="shorts">الشورت</option>
                        <option value="jacket">الجاكيت</option>
                        <option value="socks">الشراب</option>
                    </select>
                    
                    <select class="eds-form-control" style="margin-bottom: 0.5rem;" id="logo_position" name="logo_position">
                        <option value="">اختر الموضع</option>
                    </select>
                    
                    <select class="eds-form-control" id="logo_size" name="logo_size">
                        <option value="0.15">صغير</option>
                        <option value="0.20" selected>متوسط</option>
                        <option value="0.30">كبير</option>
                    </select>
                </div>
                
                <div id="logo-list" style="margin-top: 1rem;"></div>
            </div>

            <!-- Text -->
            <div class="eds-section">
                <h5 class="eds-section-title">
                    <i class="fas fa-font"></i>
                    النصوص
                </h5>
                
                <input type="text" class="eds-form-control" style="margin-bottom: 0.5rem;" id="text_content" 
                       placeholder="مثال: اسم المؤسسة" maxlength="50">
                
                <select class="eds-form-control" style="margin-bottom: 0.5rem;" id="text_piece_type" name="text_piece_type">
                    <option value="">اختر القطعة</option>
                    <option value="shirt">التيشرت</option>
                    <option value="pants">البنطلون</option>
                    <option value="shorts">الشورت</option>
                    <option value="jacket">الجاكيت</option>
                </select>
                
                <select class="eds-form-control" style="margin-bottom: 0.5rem;" id="text_position" name="text_position">
                    <option value="">اختر الموضع</option>
                </select>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <div>
                        <label style="font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 0.25rem;">لون النص</label>
                        <input type="color" class="eds-form-control" style="height: 45px; padding: 0.25rem;" id="text_color" value="#000000">
                    </div>
                    <div>
                        <label style="font-size: 0.85rem; font-weight: 600; display: block; margin-bottom: 0.25rem;">حجم النص</label>
                        <select class="eds-form-control" id="text_size">
                            <option value="0.25">صغير</option>
                            <option value="0.30" selected>متوسط</option>
                            <option value="0.40">كبير</option>
                        </select>
                    </div>
                </div>
                
                <select class="eds-form-control" style="margin-bottom: 0.5rem;" id="text_style">
                    <option value="normal">عادي</option>
                    <option value="bold" selected>عريض</option>
                    <option value="italic">مائل</option>
                </select>
                
                <button type="button" class="eds-btn eds-btn-primary" style="width: 100%;" id="add-text-btn">
                    <i class="fas fa-plus"></i>
                    إضافة النص
                </button>
                
                <div id="text-list" style="margin-top: 1rem;"></div>
            </div>

            <!-- Summary -->
            <div class="eds-section">
                <h5 class="eds-section-title">
                    <i class="fas fa-list-check"></i>
                    ملخص الطلب
                </h5>
                <div class="eds-summary">
                    <div class="eds-summary-item">
                        <span class="eds-summary-label">إجمالي القطع:</span>
                        <span class="eds-summary-value" id="total-pieces">0</span>
                    </div>
                    <div class="eds-summary-item">
                        <span class="eds-summary-label">عدد الأصناف:</span>
                        <span class="eds-summary-value" id="piece-count">0</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel: 3D Viewer -->
        <div class="eds-viewer-panel">
            <div class="eds-viewer-header">
                <div class="eds-viewer-title">
                    <i class="fas fa-cube"></i>
                    معاينة ثلاثية الأبعاد
                </div>
                <div>
                    <button type="button" class="eds-btn" style="padding: 0.5rem 1rem; background: rgba(255,255,255,0.2); color: white; border: none;" id="toggle-auto-rotate" title="دوران تلقائي">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button type="button" class="eds-btn" style="padding: 0.5rem 1rem; background: rgba(255,255,255,0.2); color: white; border: none;" id="capture-screenshot" title="التقاط صورة">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
            </div>
            
            <div class="eds-viewer-body">
                <div id="3d-viewer" class="eds-3d-container"></div>
                
                <!-- Viewer Controls -->
                <div class="eds-viewer-controls">
                    <button type="button" class="eds-control-btn" id="rotate-model" title="تدوير">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button type="button" class="eds-control-btn" id="zoom-in" title="تكبير">
                        <i class="fas fa-search-plus"></i>
                    </button>
                    <button type="button" class="eds-control-btn" id="zoom-out" title="تصغير">
                        <i class="fas fa-search-minus"></i>
                    </button>
                    <button type="button" class="eds-control-btn" id="reset-view" title="إعادة تعيين">
                        <i class="fas fa-home"></i>
                    </button>
                </div>
                
                <!-- View Switcher -->
                <div class="eds-view-switcher">
                    <button type="button" class="eds-view-btn active" id="view-front" data-view="front">
                        <i class="fas fa-user"></i>
                    </button>
                    <button type="button" class="eds-view-btn" id="view-back" data-view="back">
                        <i class="fas fa-user-slash"></i>
                    </button>
                    <button type="button" class="eds-view-btn" id="view-left" data-view="left">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button type="button" class="eds-view-btn" id="view-right" data-view="right">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Fields -->
<input type="hidden" id="design_3d_data" name="design_3d_data">
<input type="hidden" id="design_preview_image" name="design_preview_image">
<input type="hidden" id="quantity" name="quantity" value="0">

