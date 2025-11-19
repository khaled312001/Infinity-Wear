@extends('layouts.app')

@section('title', 'أطلب الآن - Infinity Wear')

@push('styles')
<style>
/* ========================================
   تصميم حديث ومتجاوب للنموذج - 2025
   ======================================== */

/* إعدادات عامة */
:root {
    --primary-color: #667eea;
    --primary-dark: #5568d3;
    --secondary-color: #764ba2;
    --success-color: #28a745;
    --info-color: #17a2b8;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
    --light-bg: #f8f9fa;
    --border-radius: 12px;
    --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    --transition: all 0.3s ease;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 60px 0;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.hero-section h1 {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.hero-section p {
    font-size: 1.3rem;
    opacity: 0.95;
}

/* Main Container with 3D Model on Left */
.form-container {
    max-width: 1600px;
    margin: 40px auto;
    padding: 0 20px;
}

.form-layout {
    display: grid;
    grid-template-columns: 400px 1fr;
    gap: 30px;
    align-items: start;
}

@media (max-width: 1200px) {
    .form-layout {
        grid-template-columns: 1fr;
    }
}

/* 3D Model Viewer - Fixed on Left */
.model-viewer-container {
    position: sticky;
    top: 20px;
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    padding: 20px;
    height: calc(100vh - 40px);
    max-height: 800px;
}

.model-viewer-header {
    text-align: center;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.model-viewer-header h3 {
    color: var(--primary-color);
    font-size: 1.4rem;
    font-weight: 700;
}

#model-canvas {
    width: 100%;
    height: calc(100% - 150px);
    border-radius: var(--border-radius);
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.model-controls {
    margin-top: 15px;
    display: flex;
    justify-content: center;
    gap: 10px;
}

.model-controls button {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: var(--transition);
}

.model-controls button:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.model-info {
    margin-top: 10px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
    font-size: 0.85rem;
    text-align: center;
}

/* Form Card */
.form-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    overflow: hidden;
}

.form-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    text-align: center;
}

.form-header h2 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.form-header p {
    font-size: 1.1rem;
    opacity: 0.9;
}

/* Progress Steps */
.progress-container {
    background: #f8f9fa;
    padding: 30px;
    border-bottom: 2px solid #e9ecef;
}

.progress-steps {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 800px;
    margin: 0 auto;
    position: relative;
}

.step-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
    position: relative;
    z-index: 2;
}

.step-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: white;
    border: 3px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #6c757d;
    transition: var(--transition);
    margin-bottom: 10px;
}

.step-item.active .step-circle {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #667eea;
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.step-item.completed .step-circle {
    background: var(--success-color);
    color: white;
    border-color: var(--success-color);
}

.step-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #6c757d;
    text-align: center;
    transition: var(--transition);
}

.step-item.active .step-label {
    color: var(--primary-color);
    font-weight: 700;
}

.step-line {
    position: absolute;
    top: 30px;
    left: 0;
    right: 0;
    height: 3px;
    background: #dee2e6;
    z-index: 1;
}

/* Form Steps */
.form-content {
    padding: 40px;
}

.form-step {
    display: none;
    animation: fadeInUp 0.5s ease;
}

.form-step.active {
    display: block;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.step-header {
    text-align: center;
    margin-bottom: 40px;
}

.step-header h4 {
    color: var(--primary-color);
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.step-header p {
    color: #6c757d;
    font-size: 1.1rem;
}

/* Form Controls */
.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
    font-size: 1rem;
}

.form-label .required {
    color: var(--danger-color);
    margin-right: 3px;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 1rem;
    transition: var(--transition);
    font-family: inherit;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-text {
    display: block;
    margin-top: 5px;
    font-size: 0.85rem;
    color: #6c757d;
}

/* Design Options */
.design-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.design-option-card {
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
}

.design-option-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
}

.design-option-card input[type="radio"] {
    display: none;
}

.design-option-card input[type="radio"]:checked + label {
    color: var(--primary-color);
}

.design-option-card.active {
    border-color: var(--primary-color);
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
}

.design-option-card i {
    font-size: 2.5rem;
    margin-bottom: 10px;
    display: block;
}

.design-option-card .title {
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 5px;
}

.design-option-card .description {
    font-size: 0.85rem;
    color: #6c757d;
}

/* Customization Panel */
.customization-panel {
    background: #f8f9fa;
    border-radius: var(--border-radius);
    padding: 25px;
    margin-top: 20px;
}

.customization-section {
    margin-bottom: 30px;
}

.customization-section:last-child {
    margin-bottom: 0;
}

.section-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e9ecef;
}

/* Clothing Pieces Selection */
.clothing-pieces {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 10px;
}

.piece-item {
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
}

.piece-item:hover {
    border-color: var(--primary-color);
    transform: scale(1.05);
}

.piece-item.selected {
    border-color: var(--primary-color);
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
}

.piece-item input[type="checkbox"] {
    display: none;
}

.piece-item i {
    font-size: 2rem;
    display: block;
    margin-bottom: 8px;
    color: var(--primary-color);
}

.piece-item span {
    font-weight: 600;
    font-size: 0.9rem;
}

/* Color Picker */
.color-picker-section {
    background: white;
    border-radius: 10px;
    padding: 20px;
    margin-top: 15px;
}

.color-groups {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.color-group {
    display: flex;
    flex-direction: column;
}

.color-group-label {
    font-weight: 600;
    margin-bottom: 10px;
    color: #495057;
}

.color-picker-wrapper {
    display: flex;
    gap: 10px;
    align-items: center;
}

.color-picker-wrapper input[type="color"] {
    width: 60px;
    height: 40px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    cursor: pointer;
}

.color-value {
    flex: 1;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    color: #6c757d;
}

/* Sizes and Quantities */
.sizes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 10px;
    margin-top: 15px;
}

.size-item {
    text-align: center;
}

.size-label {
    display: block;
    font-weight: 600;
    margin-bottom: 5px;
    color: #495057;
}

.size-input {
    width: 100%;
    padding: 8px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    text-align: center;
    font-weight: 600;
    transition: var(--transition);
}

.size-input:focus {
    outline: none;
    border-color: var(--primary-color);
}

/* Logo and Text Upload */
.upload-area {
    border: 2px dashed #e9ecef;
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
    background: white;
}

.upload-area:hover {
    border-color: var(--primary-color);
    background: rgba(102, 126, 234, 0.05);
}

.upload-area i {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 15px;
}

.upload-area input[type="file"] {
    display: none;
}

/* Order Summary */
.order-summary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    padding: 25px;
    margin-top: 30px;
}

.order-summary h4 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 20px;
    text-align: center;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.summary-item:last-child {
    border-bottom: none;
}

.summary-label {
    font-weight: 600;
}

.summary-value {
    font-weight: 700;
    font-size: 1.1rem;
}

/* Navigation Buttons */
.form-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 40px;
    padding-top: 30px;
    border-top: 2px solid #e9ecef;
}

.btn {
    padding: 12px 30px;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.btn-success {
    background: var(--success-color);
    color: white;
}

.btn-success:hover {
    background: #218838;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .hero-section h1 {
        font-size: 2rem;
    }
    
    .form-header h2 {
        font-size: 1.5rem;
    }
    
    .form-content {
        padding: 20px;
    }
    
    .progress-steps {
        flex-wrap: wrap;
    }
    
    .step-item {
        margin-bottom: 20px;
    }
    
    .form-navigation {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}

/* Loading Overlay */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.loading-overlay.active {
    display: flex;
}

.loading-content {
    background: white;
    padding: 40px;
    border-radius: 12px;
    text-align: center;
}

.spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid var(--primary-color);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
@endpush

@push('scripts')
<!-- Three.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1>🎨 أطلب زيّك المخصص الآن</h1>
        <p>صمم ملابسك بنفسك مع أدوات تصميم احترافية ومعاينة ثلاثية الأبعاد فورية</p>
    </div>
</section>

<!-- Main Form Container -->
<div class="form-container">
    <div class="form-layout">
        <!-- 3D Model Viewer - Fixed on Left -->
        <div class="model-viewer-container">
            <div class="model-viewer-header">
                <h3>👕 معاينة التصميم</h3>
                <p style="font-size: 0.9rem; color: #6c757d; margin: 5px 0 0 0;">شاهد تصميمك مباشرة</p>
            </div>
            
            <div id="model-canvas"></div>
            
            <div class="model-controls">
                <button type="button" id="rotate-left">↺ يسار</button>
                <button type="button" id="rotate-right">يمين ↻</button>
                <button type="button" id="zoom-in">+ تكبير</button>
                <button type="button" id="zoom-out">تصغير -</button>
                <button type="button" id="reset-view">⟲ إعادة</button>
            </div>
            
            <div class="model-info">
                <strong>💡 نصيحة:</strong> استخدم الماوس للتحكم بالمجسم
            </div>
            
            <!-- Real-time Design Summary -->
            <div class="order-summary" style="margin-top: 15px; padding: 15px;">
                <h4 style="font-size: 1.1rem; margin-bottom: 10px;">📋 ملخص التصميم</h4>
                <div class="summary-item">
                    <span class="summary-label">القطع المحددة:</span>
                    <span class="summary-value" id="selected-pieces-count">0</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">إجمالي الكمية:</span>
                    <span class="summary-value" id="total-quantity-display">0</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">اللون الرئيسي:</span>
                    <span class="summary-value" id="main-color-display">#3b82f6</span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <div class="form-header">
                <h2>📝 استمارة طلب ملابس مخصصة</h2>
                <p>أكمل المراحل التالية لإنشاء طلبك المثالي</p>
            </div>

            <!-- Progress Steps -->
            <div class="progress-container">
                <div class="progress-steps">
                    <div class="step-line"></div>
                    <div class="step-item active" data-step="1">
                        <div class="step-circle">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="step-label">تفاصيل الطلب</div>
                    </div>
                    <div class="step-item" data-step="2">
                        <div class="step-circle">
                            <i class="fas fa-palette"></i>
                        </div>
                        <div class="step-label">التصميم والتخصيص</div>
                    </div>
                    <div class="step-item" data-step="3">
                        <div class="step-circle">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="step-label">معلومات الشركة</div>
                    </div>
                    <div class="step-item" data-step="4">
                        <div class="step-circle">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="step-label">المعلومات الشخصية</div>
                    </div>
                    <div class="step-item" data-step="5">
                        <div class="step-circle">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="step-label">تأكيد الطلب</div>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('importers.submit') }}" method="POST" id="orderForm" enctype="multipart/form-data">
                @csrf
                
                <div class="form-content">
                    <!-- Step 1: Order Details -->
                    <div class="form-step active" data-step="1">
                        <div class="step-header">
                            <h4>📦 المرحلة الأولى: تفاصيل الطلب</h4>
                            <p>حدد نوع النشاط والكمية المطلوبة</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <span class="required">*</span> نوع النشاط
                            </label>
                            <select class="form-control" name="business_type" id="business_type" required>
                                <option value="">اختر نوع النشاط</option>
                                <option value="academy">🏃 أكاديمية رياضية</option>
                                <option value="school">🎓 مدرسة</option>
                                <option value="hospital">🏥 مستشفى</option>
                                <option value="company">🏢 شركة</option>
                                <option value="club">⚽ نادي رياضي</option>
                                <option value="hotel">🏨 فندق</option>
                                <option value="restaurant">🍽️ مطعم</option>
                                <option value="other">📋 أخرى</option>
                            </select>
                        </div>

                        <div class="form-group" id="other_business_type_div" style="display: none;">
                            <label class="form-label">
                                <span class="required">*</span> حدد نوع النشاط
                            </label>
                            <input type="text" class="form-control" name="other_business_type" id="other_business_type" placeholder="مثال: صالة رياضية">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <span class="required">*</span> وصف متطلبات الطلب
                            </label>
                            <textarea class="form-control" name="requirements" id="requirements" rows="5" required placeholder="مثال: تيشرتات رياضية زرقاء، شورتات بيضاء، مقاسات مختلفة، شعار النادي على الصدر..."></textarea>
                            <span class="form-text">💡 كن مفصلاً قدر الإمكان لضمان الحصول على التصميم المطلوب</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <span class="required">*</span> الكمية الإجمالية التقريبية
                            </label>
                            <input type="number" class="form-control" name="quantity" id="quantity" min="1" value="50" required>
                            <span class="form-text">📊 الحد الأدنى: قطعة واحدة (سيتم تحديد الكميات التفصيلية في المرحلة التالية)</span>
                        </div>

                        <div class="form-navigation">
                            <div></div>
                            <button type="button" class="btn btn-primary" onclick="nextStep()">
                                التالي
                                <i class="fas fa-arrow-left"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Design & Customization -->
                    <div class="form-step" data-step="2">
                        <div class="step-header">
                            <h4>🎨 المرحلة الثانية: التصميم والتخصيص</h4>
                            <p>صمم زيّك المثالي مع أدواتنا الاحترافية</p>
                        </div>

                        <!-- Clothing Pieces Selection -->
                        <div class="customization-panel">
                            <div class="customization-section">
                                <h3 class="section-title">👕 اختر قطع الملابس</h3>
                                <div class="clothing-pieces">
                                    <div class="piece-item" data-piece="shirt">
                                        <input type="checkbox" name="clothing_pieces[]" value="shirt" id="piece_shirt">
                                        <label for="piece_shirt" style="cursor: pointer; width: 100%;">
                                            <i class="fas fa-tshirt"></i>
                                            <span>تيشرت / قميص</span>
                                        </label>
                                    </div>
                                    <div class="piece-item" data-piece="pants">
                                        <input type="checkbox" name="clothing_pieces[]" value="pants" id="piece_pants">
                                        <label for="piece_pants" style="cursor: pointer; width: 100%;">
                                            <i class="fas fa-user-tie"></i>
                                            <span>بنطلون</span>
                                        </label>
                                    </div>
                                    <div class="piece-item" data-piece="shorts">
                                        <input type="checkbox" name="clothing_pieces[]" value="shorts" id="piece_shorts">
                                        <label for="piece_shorts" style="cursor: pointer; width: 100%;">
                                            <i class="fas fa-running"></i>
                                            <span>شورت</span>
                                        </label>
                                    </div>
                                    <div class="piece-item" data-piece="jacket">
                                        <input type="checkbox" name="clothing_pieces[]" value="jacket" id="piece_jacket">
                                        <label for="piece_jacket" style="cursor: pointer; width: 100%;">
                                            <i class="fas fa-vest"></i>
                                            <span>جاكيت</span>
                                        </label>
                                    </div>
                                    <div class="piece-item" data-piece="shoes">
                                        <input type="checkbox" name="clothing_pieces[]" value="shoes" id="piece_shoes">
                                        <label for="piece_shoes" style="cursor: pointer; width: 100%;">
                                            <i class="fas fa-shoe-prints"></i>
                                            <span>حذاء</span>
                                        </label>
                                    </div>
                                    <div class="piece-item" data-piece="socks">
                                        <input type="checkbox" name="clothing_pieces[]" value="socks" id="piece_socks">
                                        <label for="piece_socks" style="cursor: pointer; width: 100%;">
                                            <i class="fas fa-socks"></i>
                                            <span>شراب</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Color Customization -->
                            <div class="customization-section">
                                <h3 class="section-title">🎨 اختر الألوان</h3>
                                <div class="color-picker-section">
                                    <div class="color-groups">
                                        <div class="color-group">
                                            <label class="color-group-label">اللون الرئيسي</label>
                                            <div class="color-picker-wrapper">
                                                <input type="color" name="main_color" id="main_color" value="#3b82f6">
                                                <span class="color-value" id="main_color_value">#3b82f6</span>
                                            </div>
                                        </div>
                                        <div class="color-group">
                                            <label class="color-group-label">اللون الثانوي</label>
                                            <div class="color-picker-wrapper">
                                                <input type="color" name="secondary_color" id="secondary_color" value="#ffffff">
                                                <span class="color-value" id="secondary_color_value">#ffffff</span>
                                            </div>
                                        </div>
                                        <div class="color-group">
                                            <label class="color-group-label">لون التفاصيل</label>
                                            <div class="color-picker-wrapper">
                                                <input type="color" name="accent_color" id="accent_color" value="#fbbf24">
                                                <span class="color-value" id="accent_color_value">#fbbf24</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sizes and Quantities -->
                            <div class="customization-section">
                                <h3 class="section-title">📏 المقاسات والكميات</h3>
                                <div id="sizes-container">
                                    <p class="form-text" style="text-align: center; padding: 20px;">
                                        ⬆️ اختر قطع الملابس أولاً لتظهر خيارات المقاسات
                                    </p>
                                </div>
                            </div>

                            <!-- Logo Upload -->
                            <div class="customization-section">
                                <h3 class="section-title">🖼️ رفع الشعار</h3>
                                <div class="upload-area" onclick="document.getElementById('logo_file').click()">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <h4>اسحب الشعار هنا أو انقر للاختيار</h4>
                                    <p>JPG, PNG, SVG - حتى 5MB</p>
                                    <input type="file" name="logo_file" id="logo_file" accept="image/*" onchange="previewLogo(this)">
                                </div>
                                <div id="logo-preview" style="margin-top: 15px; text-align: center; display: none;"></div>
                            </div>

                            <!-- Logo Position -->
                            <div class="customization-section">
                                <h3 class="section-title">📍 موضع الشعار</h3>
                                <div class="form-group">
                                    <select class="form-control" name="logo_position">
                                        <option value="chest">منتصف الصدر</option>
                                        <option value="left_chest">الصدر الأيسر</option>
                                        <option value="right_chest">الصدر الأيمن</option>
                                        <option value="back">منتصف الظهر</option>
                                        <option value="left_sleeve">الكم الأيسر</option>
                                        <option value="right_sleeve">الكم الأيمن</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Text Customization -->
                            <div class="customization-section">
                                <h3 class="section-title">✍️ إضافة نصوص</h3>
                                <div class="form-group">
                                    <label class="form-label">النص على الصدر</label>
                                    <input type="text" class="form-control" name="text_front" placeholder="مثال: اسم الفريق">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">النص على الظهر</label>
                                    <input type="text" class="form-control" name="text_back" placeholder="مثال: رقم اللاعب أو الاسم">
                                </div>
                            </div>

                            <!-- Additional Notes -->
                            <div class="customization-section">
                                <h3 class="section-title">📝 ملاحظات إضافية</h3>
                                <textarea class="form-control" name="design_notes" rows="4" placeholder="أي ملاحظات أو تعليمات خاصة بالتصميم..."></textarea>
                            </div>
                        </div>

                        <div class="form-navigation">
                            <button type="button" class="btn btn-secondary" onclick="prevStep()">
                                <i class="fas fa-arrow-right"></i>
                                السابق
                            </button>
                            <button type="button" class="btn btn-primary" onclick="nextStep()">
                                التالي
                                <i class="fas fa-arrow-left"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Company Information -->
                    <div class="form-step" data-step="3">
                        <div class="step-header">
                            <h4>🏢 المرحلة الثالثة: معلومات الشركة</h4>
                            <p>أدخل بيانات شركتك أو مؤسستك</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <span class="required">*</span> اسم الشركة / المؤسسة
                            </label>
                            <input type="text" class="form-control" name="company_name" required placeholder="مثال: أكاديمية النجوم الرياضية">
                        </div>

                        <div class="form-group">
                            <label class="form-label">العنوان</label>
                            <input type="text" class="form-control" name="address" placeholder="مثال: شارع الملك فهد، حي النخيل">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span class="required">*</span> المدينة
                                    </label>
                                    <input type="text" class="form-control" name="city" required placeholder="مثال: الرياض">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <span class="required">*</span> الدولة
                                    </label>
                                    <input type="text" class="form-control" name="country" required value="المملكة العربية السعودية">
                                </div>
                            </div>
                        </div>

                        <div class="form-navigation">
                            <button type="button" class="btn btn-secondary" onclick="prevStep()">
                                <i class="fas fa-arrow-right"></i>
                                السابق
                            </button>
                            <button type="button" class="btn btn-primary" onclick="nextStep()">
                                التالي
                                <i class="fas fa-arrow-left"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 4: Personal Information -->
                    <div class="form-step" data-step="4">
                        <div class="step-header">
                            <h4>👤 المرحلة الرابعة: المعلومات الشخصية</h4>
                            <p>أدخل بياناتك الشخصية للتواصل</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <span class="required">*</span> الاسم الكامل
                            </label>
                            <input type="text" class="form-control" name="full_name" required placeholder="مثال: أحمد محمد العلي">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <span class="required">*</span> البريد الإلكتروني
                            </label>
                            <input type="email" class="form-control" name="email" required placeholder="example@email.com">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <span class="required">*</span> رقم الهاتف
                            </label>
                            <input type="tel" class="form-control" name="phone" required placeholder="+966 5XX XXX XXX">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <span class="required">*</span> كلمة المرور
                            </label>
                            <input type="password" class="form-control" name="password" required placeholder="أدخل كلمة مرور قوية">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <span class="required">*</span> تأكيد كلمة المرور
                            </label>
                            <input type="password" class="form-control" name="password_confirmation" required placeholder="أعد إدخال كلمة المرور">
                        </div>

                        <div class="form-navigation">
                            <button type="button" class="btn btn-secondary" onclick="prevStep()">
                                <i class="fas fa-arrow-right"></i>
                                السابق
                            </button>
                            <button type="button" class="btn btn-primary" onclick="nextStep()">
                                التالي
                                <i class="fas fa-arrow-left"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 5: Confirmation -->
                    <div class="form-step" data-step="5">
                        <div class="step-header">
                            <h4>✅ المرحلة الخامسة: تأكيد الطلب</h4>
                            <p>راجع بياناتك قبل إرسال الطلب</p>
                        </div>

                        <div class="customization-panel">
                            <div class="customization-section">
                                <h3 class="section-title">📦 ملخص الطلب</h3>
                                <div id="order-summary-review"></div>
                            </div>

                            <div class="customization-section">
                                <h3 class="section-title">🏢 معلومات الشركة</h3>
                                <div id="company-summary-review"></div>
                            </div>

                            <div class="customization-section">
                                <h3 class="section-title">👤 المعلومات الشخصية</h3>
                                <div id="personal-summary-review"></div>
                            </div>

                            <div class="form-group">
                                <label style="display: flex; align-items: center; cursor: pointer;">
                                    <input type="checkbox" name="terms" required style="margin-left: 10px; width: 20px; height: 20px;">
                                    <span>أوافق على <a href="#" style="color: var(--primary-color);">الشروط والأحكام</a></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-navigation">
                            <button type="button" class="btn btn-secondary" onclick="prevStep()">
                                <i class="fas fa-arrow-right"></i>
                                السابق
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane"></i>
                                إرسال الطلب
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-content">
        <div class="spinner"></div>
        <h3>جاري معالجة طلبك...</h3>
        <p>يرجى الانتظار</p>
    </div>
</div>

<script>
// ========================================
// نظام المراحل المتعددة
// ========================================
let currentStep = 1;
const totalSteps = 5;

function showStep(step) {
    // Hide all steps
    document.querySelectorAll('.form-step').forEach(el => {
        el.classList.remove('active');
    });
    
    // Show current step
    document.querySelector(`.form-step[data-step="${step}"]`).classList.add('active');
    
    // Update progress indicators
    document.querySelectorAll('.step-item').forEach((el, index) => {
        if (index + 1 < step) {
            el.classList.add('completed');
            el.classList.remove('active');
        } else if (index + 1 === step) {
            el.classList.add('active');
            el.classList.remove('completed');
        } else {
            el.classList.remove('active', 'completed');
        }
    });
    
    // Update summary in last step
    if (step === 5) {
        updateOrderSummary();
    }
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function nextStep() {
    if (currentStep < totalSteps) {
        if (validateStep(currentStep)) {
            currentStep++;
            showStep(currentStep);
        }
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
    }
}

function validateStep(step) {
    const currentStepEl = document.querySelector(`.form-step[data-step="${step}"]`);
    const requiredFields = currentStepEl.querySelectorAll('[required]');
    
    for (let field of requiredFields) {
        if (!field.value.trim()) {
            field.focus();
            alert('يرجى ملء جميع الحقول المطلوبة');
            return false;
        }
    }
    
    return true;
}

// ========================================
// نظام المجسم ثلاثي الأبعاد
// ========================================
let scene, camera, renderer, mannequin, controls;

function init3DModel() {
    const container = document.getElementById('model-canvas');
    
    // Scene
    scene = new THREE.Scene();
    scene.background = new THREE.Color(0xf0f0f0);
    
    // Camera
    camera = new THREE.PerspectiveCamera(
        45,
        container.clientWidth / container.clientHeight,
        0.1,
        1000
    );
    camera.position.set(0, 1.6, 3);
    
    // Renderer
    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.shadowMap.enabled = true;
    container.appendChild(renderer.domElement);
    
    // Orbit Controls
    controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.minDistance = 2;
    controls.maxDistance = 5;
    
    // Lights
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
    scene.add(ambientLight);
    
    const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
    directionalLight.position.set(5, 10, 5);
    directionalLight.castShadow = true;
    scene.add(directionalLight);
    
    // Ground
    const groundGeometry = new THREE.PlaneGeometry(10, 10);
    const groundMaterial = new THREE.MeshStandardMaterial({ 
        color: 0xe0e0e0,
        roughness: 0.8
    });
    const ground = new THREE.Mesh(groundGeometry, groundMaterial);
    ground.rotation.x = -Math.PI / 2;
    ground.receiveShadow = true;
    scene.add(ground);
    
    // Create simple mannequin
    createMannequin();
    
    // Animation loop
    animate();
    
    // Handle window resize
    window.addEventListener('resize', onWindowResize);
}

function createMannequin() {
    mannequin = new THREE.Group();
    
    // Body
    const bodyGeometry = new THREE.CylinderGeometry(0.3, 0.35, 1, 16);
    const bodyMaterial = new THREE.MeshStandardMaterial({ 
        color: 0x3b82f6,
        roughness: 0.7,
        metalness: 0.1
    });
    const body = new THREE.Mesh(bodyGeometry, bodyMaterial);
    body.position.y = 1.2;
    body.castShadow = true;
    body.name = 'body';
    mannequin.add(body);
    
    // Head
    const headGeometry = new THREE.SphereGeometry(0.15, 16, 16);
    const headMaterial = new THREE.MeshStandardMaterial({ color: 0xffdbac });
    const head = new THREE.Mesh(headGeometry, headMaterial);
    head.position.y = 1.85;
    head.castShadow = true;
    mannequin.add(head);
    
    // Arms
    const armGeometry = new THREE.CylinderGeometry(0.08, 0.08, 0.7, 12);
    const armMaterial = new THREE.MeshStandardMaterial({ 
        color: 0x3b82f6,
        roughness: 0.7
    });
    
    const leftArm = new THREE.Mesh(armGeometry, armMaterial);
    leftArm.position.set(-0.45, 1.3, 0);
    leftArm.rotation.z = Math.PI / 6;
    leftArm.castShadow = true;
    leftArm.name = 'leftArm';
    mannequin.add(leftArm);
    
    const rightArm = new THREE.Mesh(armGeometry, armMaterial);
    rightArm.position.set(0.45, 1.3, 0);
    rightArm.rotation.z = -Math.PI / 6;
    rightArm.castShadow = true;
    rightArm.name = 'rightArm';
    mannequin.add(rightArm);
    
    // Legs
    const legGeometry = new THREE.CylinderGeometry(0.1, 0.09, 0.9, 12);
    const legMaterial = new THREE.MeshStandardMaterial({ 
        color: 0x1e40af,
        roughness: 0.7
    });
    
    const leftLeg = new THREE.Mesh(legGeometry, legMaterial);
    leftLeg.position.set(-0.15, 0.25, 0);
    leftLeg.castShadow = true;
    leftLeg.name = 'leftLeg';
    mannequin.add(leftLeg);
    
    const rightLeg = new THREE.Mesh(legGeometry, legMaterial);
    rightLeg.position.set(0.15, 0.25, 0);
    rightLeg.castShadow = true;
    rightLeg.name = 'rightLeg';
    mannequin.add(rightLeg);
    
    scene.add(mannequin);
}

function animate() {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
}

function onWindowResize() {
    const container = document.getElementById('model-canvas');
    camera.aspect = container.clientWidth / container.clientHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(container.clientWidth, container.clientHeight);
}

// Model controls
document.getElementById('rotate-left').addEventListener('click', () => {
    mannequin.rotation.y += Math.PI / 4;
});

document.getElementById('rotate-right').addEventListener('click', () => {
    mannequin.rotation.y -= Math.PI / 4;
});

document.getElementById('zoom-in').addEventListener('click', () => {
    camera.position.z = Math.max(camera.position.z - 0.5, controls.minDistance);
});

document.getElementById('zoom-out').addEventListener('click', () => {
    camera.position.z = Math.min(camera.position.z + 0.5, controls.maxDistance);
});

document.getElementById('reset-view').addEventListener('click', () => {
    camera.position.set(0, 1.6, 3);
    mannequin.rotation.set(0, 0, 0);
});

// ========================================
// تحديث المجسم عند تغيير الألوان
// ========================================
function updateModelColor(partName, color) {
    if (!mannequin) return;
    
    const parts = mannequin.children.filter(child => 
        child.name === 'body' || child.name === 'leftArm' || child.name === 'rightArm'
    );
    
    parts.forEach(part => {
        part.material.color.setStyle(color);
    });
}

document.getElementById('main_color').addEventListener('input', (e) => {
    const color = e.target.value;
    updateModelColor('body', color);
    document.getElementById('main_color_value').textContent = color;
    document.getElementById('main-color-display').textContent = color;
});

document.getElementById('secondary_color').addEventListener('input', (e) => {
    document.getElementById('secondary_color_value').textContent = e.target.value;
});

document.getElementById('accent_color').addEventListener('input', (e) => {
    document.getElementById('accent_color_value').textContent = e.target.value;
});

// ========================================
// قطع الملابس
// ========================================
document.querySelectorAll('.piece-item').forEach(item => {
    item.addEventListener('click', function() {
        const checkbox = this.querySelector('input[type="checkbox"]');
        checkbox.checked = !checkbox.checked;
        this.classList.toggle('selected');
        updateSizesSection();
        updateSelectedPiecesCount();
    });
});

function updateSizesSection() {
    const selectedPieces = Array.from(document.querySelectorAll('.piece-item.selected'))
        .map(item => item.dataset.piece);
    
    const sizesContainer = document.getElementById('sizes-container');
    sizesContainer.innerHTML = '';
    
    selectedPieces.forEach(piece => {
        const section = document.createElement('div');
        section.style.marginBottom = '20px';
        
        let sizes = [];
        let sectionTitle = '';
        
        switch(piece) {
            case 'shirt':
                sectionTitle = 'مقاسات التيشرت';
                sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
                break;
            case 'pants':
                sectionTitle = 'مقاسات البنطلون';
                sizes = ['28', '30', '32', '34', '36', '38', '40', '42'];
                break;
            case 'shorts':
                sectionTitle = 'مقاسات الشورت';
                sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                break;
            case 'jacket':
                sectionTitle = 'مقاسات الجاكيت';
                sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                break;
            case 'shoes':
                sectionTitle = 'مقاسات الحذاء';
                sizes = ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];
                break;
            case 'socks':
                sectionTitle = 'مقاسات الشراب';
                sizes = ['S', 'M', 'L', 'XL'];
                break;
        }
        
        section.innerHTML = `
            <h4 style="color: var(--primary-color); margin-bottom: 15px;">${sectionTitle}</h4>
            <div class="sizes-grid">
                ${sizes.map(size => `
                    <div class="size-item">
                        <label class="size-label">${size}</label>
                        <input type="number" class="size-input" name="${piece}_sizes[${size}]" 
                               min="0" value="0" placeholder="0" onchange="updateTotalQuantity()">
                    </div>
                `).join('')}
            </div>
        `;
        
        sizesContainer.appendChild(section);
    });
}

function updateSelectedPiecesCount() {
    const count = document.querySelectorAll('.piece-item.selected').length;
    document.getElementById('selected-pieces-count').textContent = count;
}

function updateTotalQuantity() {
    let total = 0;
    document.querySelectorAll('.size-input').forEach(input => {
        total += parseInt(input.value) || 0;
    });
    document.getElementById('total-quantity-display').textContent = total;
}

// ========================================
// معاينة الشعار
// ========================================
function previewLogo(input) {
    const preview = document.getElementById('logo-preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Logo Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <p style="margin-top: 10px; color: var(--success-color); font-weight: 600;">
                    <i class="fas fa-check-circle"></i> تم رفع الشعار بنجاح
                </p>
            `;
            preview.style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// ========================================
// تحديث ملخص الطلب
// ========================================
function updateOrderSummary() {
    // Order Summary
    const businessType = document.getElementById('business_type').selectedOptions[0].text;
    const requirements = document.getElementById('requirements').value;
    const quantity = document.getElementById('quantity').value;
    
    const selectedPieces = Array.from(document.querySelectorAll('.piece-item.selected'))
        .map(item => item.querySelector('label span').textContent).join(', ') || 'لم يتم التحديد';
    
    document.getElementById('order-summary-review').innerHTML = `
        <p><strong>نوع النشاط:</strong> ${businessType}</p>
        <p><strong>المتطلبات:</strong> ${requirements}</p>
        <p><strong>الكمية:</strong> ${quantity}</p>
        <p><strong>القطع المحددة:</strong> ${selectedPieces}</p>
    `;
    
    // Company Summary
    const companyName = document.querySelector('[name="company_name"]').value || '-';
    const city = document.querySelector('[name="city"]').value || '-';
    const country = document.querySelector('[name="country"]').value || '-';
    
    document.getElementById('company-summary-review').innerHTML = `
        <p><strong>اسم الشركة:</strong> ${companyName}</p>
        <p><strong>المدينة:</strong> ${city}</p>
        <p><strong>الدولة:</strong> ${country}</p>
    `;
    
    // Personal Summary
    const fullName = document.querySelector('[name="full_name"]').value || '-';
    const email = document.querySelector('[name="email"]').value || '-';
    const phone = document.querySelector('[name="phone"]').value || '-';
    
    document.getElementById('personal-summary-review').innerHTML = `
        <p><strong>الاسم:</strong> ${fullName}</p>
        <p><strong>البريد الإلكتروني:</strong> ${email}</p>
        <p><strong>رقم الهاتف:</strong> ${phone}</p>
    `;
}

// ========================================
// معالجة إرسال النموذج
// ========================================
document.getElementById('orderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show loading
    document.getElementById('loadingOverlay').classList.add('active');
    
    // Submit form
    setTimeout(() => {
        this.submit();
    }, 1000);
});

// ========================================
// نوع النشاط (أخرى)
// ========================================
document.getElementById('business_type').addEventListener('change', function() {
    const otherDiv = document.getElementById('other_business_type_div');
    const otherInput = document.getElementById('other_business_type');
    
    if (this.value === 'other') {
        otherDiv.style.display = 'block';
        otherInput.required = true;
    } else {
        otherDiv.style.display = 'none';
        otherInput.required = false;
    }
});

// ========================================
// تهيئة عند تحميل الصفحة
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    init3DModel();
    showStep(1);
});
</script>

@endsection

