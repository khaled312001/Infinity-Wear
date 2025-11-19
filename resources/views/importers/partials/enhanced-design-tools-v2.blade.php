{{-- Enhanced Design Tools V2 - Modern & Isolated --}}
<div class="iw-custom-designer">
    <div class="iw-cd-main-grid">
        <!-- Left Panel: 3D Viewer -->
        <div class="iw-cd-viewer-panel">
            <div class="iw-cd-viewer-header">
                <div class="iw-cd-viewer-title">
                    <i class="fas fa-cube"></i>
                    معاينة ثلاثية الأبعاد
                </div>
                <div>
                    <button type="button" class="iw-cd-btn" style="padding: 0.5rem 1rem; background: rgba(255,255,255,0.2); color: white; border: none;" id="toggle-auto-rotate" title="دوران تلقائي">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button type="button" class="iw-cd-btn" style="padding: 0.5rem 1rem; background: rgba(255,255,255,0.2); color: white; border: none;" id="capture-screenshot" title="التقاط صورة">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
            </div>
            
            <div class="iw-cd-viewer-body">
                <div id="3d-viewer" class="iw-cd-3d-container"></div>
                
                <!-- Viewer Controls -->
                <div class="iw-cd-viewer-controls">
                    <button type="button" class="iw-cd-control-btn" id="cd-rotate-model" title="تدوير">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <button type="button" class="iw-cd-control-btn" id="cd-zoom-in" title="تكبير">
                        <i class="fas fa-search-plus"></i>
                    </button>
                    <button type="button" class="iw-cd-control-btn" id="cd-zoom-out" title="تصغير">
                        <i class="fas fa-search-minus"></i>
                    </button>
                    <button type="button" class="iw-cd-control-btn" id="cd-reset-view" title="إعادة تعيين">
                        <i class="fas fa-home"></i>
                    </button>
                </div>
                
                <!-- View Switcher -->
                <div class="iw-cd-view-switcher">
                    <button type="button" class="iw-cd-view-btn active" id="cd-view-front" data-view="front">
                        <i class="fas fa-user"></i>
                    </button>
                    <button type="button" class="iw-cd-view-btn" id="cd-view-back" data-view="back">
                        <i class="fas fa-user-slash"></i>
                    </button>
                    <button type="button" class="iw-cd-view-btn" id="cd-view-left" data-view="left">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button type="button" class="iw-cd-view-btn" id="cd-view-right" data-view="right">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Panel: Controls -->
        <div class="iw-cd-controls-panel">
            
            <!-- Activity Type -->
            <div class="iw-cd-section">
                <h5 class="iw-cd-section-title">
                    <i class="fas fa-building"></i>
                    نوع النشاط
                </h5>
                <select class="iw-cd-form-control" id="design_activity_type" name="design_activity_type">
                    <option value="">اختر نوع النشاط</option>
                    <option value="academy">أكاديمية رياضية</option>
                    <option value="school">مدرسة</option>
                    <option value="hospital">مستشفى</option>
                    <option value="company">شركة</option>
                    <option value="other">أخرى</option>
                </select>
            </div>

            <!-- Clothing Pieces -->
            <div class="iw-cd-section">
                <h5 class="iw-cd-section-title">
                    <i class="fas fa-tshirt"></i>
                    قطع الملابس
                </h5>
                <div class="iw-cd-piece-grid">
                    <label class="iw-cd-piece-item">
                        <input type="checkbox" class="iw-cd-piece-checkbox clothing-piece-checkbox" 
                               data-piece-type="shirt" id="cd-piece_shirt" name="clothing_pieces[]" value="shirt">
                        <span class="iw-cd-piece-icon">👕</span>
                        <span class="iw-cd-piece-label">تيشرت</span>
                    </label>
                    
                    <label class="iw-cd-piece-item">
                        <input type="checkbox" class="iw-cd-piece-checkbox clothing-piece-checkbox" 
                               data-piece-type="pants" id="cd-piece_pants" name="clothing_pieces[]" value="pants">
                        <span class="iw-cd-piece-icon">👖</span>
                        <span class="iw-cd-piece-label">بنطلون</span>
                    </label>
                    
                    <label class="iw-cd-piece-item">
                        <input type="checkbox" class="iw-cd-piece-checkbox clothing-piece-checkbox" 
                               data-piece-type="shorts" id="cd-piece_shorts" name="clothing_pieces[]" value="shorts">
                        <span class="iw-cd-piece-icon">🩳</span>
                        <span class="iw-cd-piece-label">شورت</span>
                    </label>
                    
                    <label class="iw-cd-piece-item">
                        <input type="checkbox" class="iw-cd-piece-checkbox clothing-piece-checkbox" 
                               data-piece-type="jacket" id="cd-piece_jacket" name="clothing_pieces[]" value="jacket">
                        <span class="iw-cd-piece-icon">🧥</span>
                        <span class="iw-cd-piece-label">جاكيت</span>
                    </label>
                    
                    <label class="iw-cd-piece-item">
                        <input type="checkbox" class="iw-cd-piece-checkbox clothing-piece-checkbox" 
                               data-piece-type="shoes" id="cd-piece_shoes" name="clothing_pieces[]" value="shoes">
                        <span class="iw-cd-piece-icon">👟</span>
                        <span class="iw-cd-piece-label">حذاء</span>
                    </label>
                    
                    <label class="iw-cd-piece-item">
                        <input type="checkbox" class="iw-cd-piece-checkbox clothing-piece-checkbox" 
                               data-piece-type="socks" id="cd-piece_socks" name="clothing_pieces[]" value="socks">
                        <span class="iw-cd-piece-icon">🧦</span>
                        <span class="iw-cd-piece-label">شراب</span>
                    </label>
                </div>
            </div>

            <!-- Sizes & Quantities -->
            <div class="iw-cd-section">
                <h5 class="iw-cd-section-title">
                    <i class="fas fa-ruler"></i>
                    المقاسات والكميات
                </h5>
                <div id="sizes-container" class="iw-cd-sizes-container">
                    <div class="iw-cd-empty-state">
                        <i class="fas fa-info-circle" style="font-size: 2rem; color: #6c757d; margin-bottom: 0.5rem;"></i>
                        <p style="text-align: center; color: #6c757d; margin: 0;">اختر قطع الملابس أولاً</p>
                    </div>
                </div>
            </div>

            <!-- Color Customization -->
            <div class="iw-cd-section">
                <h5 class="iw-cd-section-title">
                    <i class="fas fa-palette"></i>
                    تخصيص الألوان
                </h5>
                
                <div class="iw-cd-color-section">
                    <label class="iw-cd-sub-label">اختر الجزء المراد تلوينه:</label>
                    <div class="iw-cd-color-parts">
                        <button type="button" class="iw-cd-part-btn active part-selector-btn" data-part="body">
                            <i class="fas fa-tshirt"></i>
                            <span>الجسم</span>
                        </button>
                        <button type="button" class="iw-cd-part-btn part-selector-btn" data-part="sleeves">
                            <i class="fas fa-hand-paper"></i>
                            <span>الأكمام</span>
                        </button>
                        <button type="button" class="iw-cd-part-btn part-selector-btn" data-part="collar">
                            <i class="fas fa-circle"></i>
                            <span>الياقة</span>
                        </button>
                    </div>

                    <label class="iw-cd-sub-label" style="margin-top: 1rem; margin-bottom: 0.5rem;">اختر اللون:</label>
                    <div class="iw-cd-color-picker-wrap">
                        <input type="color" class="iw-cd-color-picker color-picker" id="main-color-picker" value="#4A90E2">
                        <span class="iw-cd-color-value" id="color-value-display">#4A90E2</span>
                    </div>

                    <label class="iw-cd-sub-label" style="margin-top: 1rem; margin-bottom: 0.5rem;">ألوان جاهزة:</label>
                    <div class="iw-cd-preset-colors">
                        <button type="button" class="iw-cd-preset-color preset-color" data-color="#FF6B6B" style="background-color: #FF6B6B;" title="أحمر"></button>
                        <button type="button" class="iw-cd-preset-color preset-color" data-color="#4ECDC4" style="background-color: #4ECDC4;" title="أزرق فاتح"></button>
                        <button type="button" class="iw-cd-preset-color preset-color" data-color="#45B7D1" style="background-color: #45B7D1;" title="أزرق"></button>
                        <button type="button" class="iw-cd-preset-color preset-color" data-color="#FFA07A" style="background-color: #FFA07A;" title="برتقالي"></button>
                        <button type="button" class="iw-cd-preset-color preset-color" data-color="#98D8C8" style="background-color: #98D8C8;" title="أخضر فاتح"></button>
                        <button type="button" class="iw-cd-preset-color preset-color" data-color="#F7DC6F" style="background-color: #F7DC6F;" title="أصفر"></button>
                        <button type="button" class="iw-cd-preset-color preset-color" data-color="#BB8FCE" style="background-color: #BB8FCE;" title="بنفسجي"></button>
                        <button type="button" class="iw-cd-preset-color preset-color" data-color="#85929E" style="background-color: #85929E;" title="رمادي"></button>
                        <button type="button" class="iw-cd-preset-color preset-color" data-color="#2C3E50" style="background-color: #2C3E50;" title="أسود"></button>
                        <button type="button" class="iw-cd-preset-color preset-color" data-color="#FFFFFF" style="background-color: #FFFFFF; border: 2px solid #ddd;" title="أبيض"></button>
                        <button type="button" class="iw-cd-preset-color preset-color" data-color="#E74C3C" style="background-color: #E74C3C;" title="أحمر داكن"></button>
                        <button type="button" class="iw-cd-preset-color preset-color" data-color="#3498DB" style="background-color: #3498DB;" title="أزرق ملكي"></button>
                    </div>
                </div>
            </div>

            <!-- Patterns -->
            <div class="iw-cd-section">
                <h5 class="iw-cd-section-title">
                    <i class="fas fa-border-style"></i>
                    الزخارف
                </h5>
                <label class="iw-cd-sub-label" style="margin-bottom: 0.75rem;">اختر نوع الزخرفة:</label>
                <div class="iw-cd-pattern-grid">
                    <button type="button" class="iw-cd-pattern-item active pattern-option" data-pattern="solid">
                        <span class="iw-cd-pattern-icon">▬</span>
                        <span class="iw-cd-pattern-label">لون موحد</span>
                    </button>
                    <button type="button" class="iw-cd-pattern-item pattern-option" data-pattern="stripes">
                        <span class="iw-cd-pattern-icon">|||</span>
                        <span class="iw-cd-pattern-label">خطوط</span>
                    </button>
                    <button type="button" class="iw-cd-pattern-item pattern-option" data-pattern="dots">
                        <span class="iw-cd-pattern-icon">⋮⋮⋮</span>
                        <span class="iw-cd-pattern-label">نقاط</span>
                    </button>
                    <button type="button" class="iw-cd-pattern-item pattern-option" data-pattern="gradient">
                        <span class="iw-cd-pattern-icon">⬌</span>
                        <span class="iw-cd-pattern-label">تدرج</span>
                    </button>
                </div>
            </div>

            <!-- Logo Upload -->
            <div class="iw-cd-section">
                <h5 class="iw-cd-section-title">
                    <i class="fas fa-image"></i>
                    الشعار
                </h5>
                
                <div class="iw-cd-upload-area" id="logo-upload-area">
                    <i class="fas fa-cloud-upload-alt iw-cd-upload-icon"></i>
                    <p class="iw-cd-upload-text">اسحب الشعار هنا أو انقر للاختيار</p>
                    <p class="iw-cd-upload-hint">JPG, PNG, SVG حتى 5MB</p>
                    <input type="file" id="logo_file" name="logo_file" accept="image/*" style="display: none;">
                </div>
                
                <div class="iw-cd-logo-controls" style="margin-top: 1rem;">
                    <label class="iw-cd-sub-label">اختر القطعة:</label>
                    <select class="iw-cd-form-control" style="margin-bottom: 0.75rem;" id="logo_piece_type" name="logo_piece_type">
                        <option value="">اختر القطعة</option>
                        <option value="shirt">التيشرت</option>
                        <option value="pants">البنطلون</option>
                        <option value="shorts">الشورت</option>
                        <option value="jacket">الجاكيت</option>
                        <option value="socks">الشراب</option>
                    </select>
                    
                    <label class="iw-cd-sub-label">اختر الموضع:</label>
                    <select class="iw-cd-form-control" style="margin-bottom: 0.75rem;" id="cd-logo_position" name="logo_position">
                        <option value="">اختر الموضع</option>
                    </select>
                    
                    <label class="iw-cd-sub-label">حجم الشعار:</label>
                    <select class="iw-cd-form-control" id="cd-logo_size" name="logo_size">
                        <option value="0.15">صغير</option>
                        <option value="0.20" selected>متوسط</option>
                        <option value="0.30">كبير</option>
                    </select>
                </div>
                
                <div id="logo-list" class="iw-cd-logo-list" style="margin-top: 1rem;"></div>
            </div>

            <!-- Text -->
            <div class="iw-cd-section">
                <h5 class="iw-cd-section-title">
                    <i class="fas fa-font"></i>
                    النصوص
                </h5>
                
                <label class="iw-cd-sub-label">أدخل النص:</label>
                <input type="text" class="iw-cd-form-control" style="margin-bottom: 0.75rem;" id="text_content" 
                       placeholder="مثال: اسم المؤسسة" maxlength="50">
                
                <label class="iw-cd-sub-label">اختر القطعة:</label>
                <select class="iw-cd-form-control" style="margin-bottom: 0.75rem;" id="text_piece_type" name="text_piece_type">
                    <option value="">اختر القطعة</option>
                    <option value="shirt">التيشرت</option>
                    <option value="pants">البنطلون</option>
                    <option value="shorts">الشورت</option>
                    <option value="jacket">الجاكيت</option>
                </select>
                
                <label class="iw-cd-sub-label">اختر الموضع:</label>
                <select class="iw-cd-form-control" style="margin-bottom: 0.75rem;" id="cd-text_position" name="text_position">
                    <option value="">اختر الموضع</option>
                </select>
                
                <div class="iw-cd-text-options" style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 0.75rem;">
                    <div>
                        <label class="iw-cd-sub-label" style="margin-bottom: 0.25rem;">لون النص</label>
                        <input type="color" class="iw-cd-form-control" style="height: 45px; padding: 0.25rem;" id="cd-text_color" value="#000000">
                    </div>
                    <div>
                        <label class="iw-cd-sub-label" style="margin-bottom: 0.25rem;">حجم النص</label>
                        <select class="iw-cd-form-control" id="cd-text_size">
                            <option value="0.25">صغير</option>
                            <option value="0.30" selected>متوسط</option>
                            <option value="0.40">كبير</option>
                        </select>
                    </div>
                </div>
                
                <label class="iw-cd-sub-label">نمط النص:</label>
                <select class="iw-cd-form-control" style="margin-bottom: 0.75rem;" id="cd-text_style">
                    <option value="normal">عادي</option>
                    <option value="bold" selected>عريض</option>
                    <option value="italic">مائل</option>
                </select>
                
                <button type="button" class="iw-cd-btn iw-cd-btn-primary" style="width: 100%;" id="add-text-btn">
                    <i class="fas fa-plus"></i>
                    إضافة النص
                </button>
                
                <div id="text-list" class="iw-cd-text-list" style="margin-top: 1rem;"></div>
            </div>

            <!-- Summary -->
            <div class="iw-cd-section">
                <h5 class="iw-cd-section-title">
                    <i class="fas fa-list-check"></i>
                    ملخص الطلب
                </h5>
                <div class="iw-cd-summary">
                    <div class="iw-cd-summary-item">
                        <span class="iw-cd-summary-label">إجمالي القطع:</span>
                        <span class="iw-cd-summary-value" id="total-pieces">0</span>
                    </div>
                    <div class="iw-cd-summary-item">
                        <span class="iw-cd-summary-label">عدد الأصناف:</span>
                        <span class="iw-cd-summary-value" id="piece-count">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Fields -->
<input type="hidden" id="cd-design_3d_data" name="design_3d_data">
<input type="hidden" id="cd-design_preview_image" name="design_preview_image">
<input type="hidden" id="cd-quantity" name="cd_quantity" value="0">

