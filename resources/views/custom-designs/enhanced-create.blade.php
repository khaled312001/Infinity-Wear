@extends('layouts.app')

@section('title', 'صمم زي موحد متقدم - Infinity Wear')

@section('styles')
<style>
    .design-canvas {
        border: 2px solid #e5e7eb;
        border-radius: 15px;
        background: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .design-tools {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    
    .color-picker-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }
    
    .color-picker {
        width: 45px;
        height: 45px;
        border: 3px solid #fff;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }
    
    .color-picker:hover {
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
    .text-input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 16px;
        transition: border-color 0.3s ease;
        font-family: 'Cairo', sans-serif;
    }
    
    .text-input:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
    }
    
    .design-preview {
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .jersey-preview {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 500px;
        position: relative;
    }

    .human-figure {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        transform: perspective(1000px) rotateY(0deg);
        transition: transform 0.5s ease;
    }

    .human-figure.rotate-3d {
        transform: perspective(1000px) rotateY(15deg);
    }

    .head {
        width: 50px;
        height: 50px;
        background: radial-gradient(circle, #f3c2a1, #d69e2e);
        border-radius: 50%;
        margin-bottom: 15px;
        border: 3px solid #d69e2e;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }

    .body {
        position: relative;
        z-index: 2;
    }

    .tshirt-template {
        width: 200px;
        height: 250px;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        border-radius: 20px 20px 8px 8px;
        position: relative;
        border: 3px solid #1e40af;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        transition: all 0.3s ease;
    }
    
    .tshirt-template:hover {
        transform: scale(1.02);
    }
    
    .design-text {
        position: absolute;
        top: 25%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: bold;
        text-align: center;
        word-wrap: break-word;
        max-width: 170px;
        color: white;
        font-size: 18px;
        text-shadow: 3px 3px 6px rgba(0,0,0,0.7);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .player-number {
        position: absolute;
        top: 65%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: 900;
        font-size: 56px;
        color: white;
        text-shadow: 3px 3px 6px rgba(0,0,0,0.7);
        font-family: 'Arial Black', Arial, sans-serif;
    }

    .team-logo {
        position: absolute;
        top: 10px;
        right: 15px;
        width: 30px;
        height: 30px;
        background: rgba(255,255,255,0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        color: var(--primary-color);
    }

    .arms {
        position: absolute;
        top: 80px;
        width: 250px;
        height: 140px;
        z-index: 1;
    }

    .arm {
        width: 30px;
        height: 140px;
        background: radial-gradient(ellipse, #f3c2a1, #d69e2e);
        border-radius: 15px;
        position: absolute;
        border: 3px solid #d69e2e;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }

    .left-arm {
        left: -35px;
        transform: rotate(-15deg);
    }

    .right-arm {
        right: -35px;
        transform: rotate(15deg);
    }

    .legs {
        display: flex;
        gap: 15px;
        margin-top: 8px;
    }

    .leg {
        width: 35px;
        height: 120px;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        border-radius: 18px;
        border: 3px solid #1e40af;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }

    .template-option {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 3px solid transparent;
        border-radius: 12px;
        padding: 12px;
        background: white;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .template-option:hover,
    .template-option.active {
        border-color: var(--primary-color);
        background: rgba(30, 58, 138, 0.1);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    .template-preview {
        text-align: center;
    }

    .template-shirt {
        width: 70px;
        height: 85px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 9px;
        font-weight: bold;
        margin: 0 auto 8px;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
        box-shadow: 0 3px 10px rgba(0,0,0,0.3);
    }

    .advanced-controls {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    }

    .control-group {
        margin-bottom: 20px;
        padding: 15px;
        background: #f8fafc;
        border-radius: 10px;
        border-left: 4px solid var(--primary-color);
    }

    .pattern-selector {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(60px, 1fr));
        gap: 10px;
        margin-top: 10px;
    }

    .pattern-option {
        width: 60px;
        height: 60px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }

    .pattern-option:hover,
    .pattern-option.active {
        border-color: var(--primary-color);
        transform: scale(1.05);
    }

    .size-selector {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .size-option {
        padding: 8px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        font-weight: 600;
    }

    .size-option:hover,
    .size-option.active {
        border-color: var(--primary-color);
        background: var(--primary-color);
        color: white;
    }

    .price-calculator {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-radius: 15px;
        padding: 20px;
        margin-top: 20px;
    }

    .price-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }

    .price-total {
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
        padding-top: 15px;
        border-top: 2px solid rgba(255,255,255,0.3);
    }

    .action-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-3d {
        background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
        border: none;
        border-radius: 12px;
        padding: 12px 20px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
    }

    .btn-3d:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30, 58, 138, 0.4);
        color: white;
    }

    @media (max-width: 768px) {
        .tshirt-template {
            width: 160px;
            height: 200px;
        }
        
        .design-text {
            font-size: 14px;
            max-width: 130px;
        }
        
        .player-number {
            font-size: 42px;
        }
        
        .action-buttons {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <!-- عرض الرسائل -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" data-aos="fade-down">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12 text-center mb-5" data-aos="fade-up">
            <h1 class="section-title">
                <i class="fas fa-palette me-3"></i>
                أداة التصميم المتقدمة
            </h1>
            <p class="lead">صمم زي موحد احترافي بتقنية ثلاثية الأبعاد</p>
        </div>
    </div>
    
    <div class="row">
        <!-- أدوات التصميم المتقدمة -->
        <div class="col-lg-4">
            <div class="design-tools" data-aos="fade-right">
                <h4 class="mb-4">
                    <i class="fas fa-tools me-2"></i>
                    أدوات التصميم
                </h4>
                
                <!-- اختيار نوع التصميم -->
                <div class="control-group">
                    <label class="form-label fw-bold">
                        <i class="fas fa-layer-group me-2"></i>
                        نوع التصميم
                    </label>
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="designType" id="customDesign" value="custom" checked>
                        <label class="btn btn-outline-primary" for="customDesign">تصميم مخصص</label>
                        
                        <input type="radio" class="btn-check" name="designType" id="templateDesign" value="template">
                        <label class="btn btn-outline-primary" for="templateDesign">قوالب جاهزة</label>
                    </div>
                </div>

                <!-- القوالب الجاهزة المحسنة -->
                <div class="control-group" id="templatesSection" style="display: none;">
                    <label class="form-label fw-bold">
                        <i class="fas fa-th-large me-2"></i>
                        اختر قالب احترافي
                    </label>
                    <div class="row g-2">
                        <div class="col-4">
                            <div class="template-option" data-template="saudi_pro">
                                <div class="template-preview">
                                    <div class="template-shirt" style="background: linear-gradient(45deg, #0d7377, #14a085);">
                                        <span>الدوري السعودي</span>
                                    </div>
                                    <small>الدوري المحترف</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="template-option" data-template="youth_academy">
                                <div class="template-preview">
                                    <div class="template-shirt" style="background: linear-gradient(45deg, #1e40af, #3b82f6);">
                                        <span>أكاديمية الشباب</span>
                                    </div>
                                    <small>أكاديميات</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="template-option" data-template="school_team">
                                <div class="template-preview">
                                    <div class="template-shirt" style="background: linear-gradient(45deg, #dc2626, #ef4444);">
                                        <span>فريق المدرسة</span>
                                    </div>
                                    <small>مدارس</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="template-option" data-template="corporate">
                                <div class="template-preview">
                                    <div class="template-shirt" style="background: linear-gradient(45deg, #7c3aed, #a855f7);">
                                        <span>شركات</span>
                                    </div>
                                    <small>مؤسسات</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="template-option" data-template="classic">
                                <div class="template-preview">
                                    <div class="template-shirt" style="background: linear-gradient(45deg, #374151, #6b7280);">
                                        <span>كلاسيكي</span>
                                    </div>
                                    <small>تقليدي</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="template-option" data-template="modern">
                                <div class="template-preview">
                                    <div class="template-shirt" style="background: linear-gradient(45deg, #f59e0b, #fbbf24);">
                                        <span>عصري</span>
                                    </div>
                                    <small>حديث</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- إدخال النص -->
                <div class="control-group">
                    <label class="form-label fw-bold">
                        <i class="fas fa-font me-2"></i>
                        اسم الفريق أو النص
                    </label>
                    <input type="text" id="designText" class="text-input" placeholder="أدخل اسم الفريق...">
                </div>

                <!-- رقم اللاعب -->
                <div class="control-group">
                    <label class="form-label fw-bold">
                        <i class="fas fa-hashtag me-2"></i>
                        رقم اللاعب
                    </label>
                    <input type="number" id="playerNumber" class="text-input" placeholder="رقم اللاعب" min="1" max="99">
                </div>

                <!-- أنماط القميص -->
                <div class="control-group">
                    <label class="form-label fw-bold">
                        <i class="fas fa-palette me-2"></i>
                        نمط القميص
                    </label>
                    <div class="pattern-selector">
                        <div class="pattern-option active" data-pattern="solid" style="background: var(--primary-color);">
                            <span style="color: white;">صافي</span>
                        </div>
                        <div class="pattern-option" data-pattern="gradient" style="background: linear-gradient(45deg, #1e40af, #3b82f6);">
                            <span style="color: white;">متدرج</span>
                        </div>
                        <div class="pattern-option" data-pattern="stripes" style="background: repeating-linear-gradient(90deg, #1e40af 0px, #1e40af 10px, #3b82f6 10px, #3b82f6 20px);">
                            <span style="color: white;">مخطط</span>
                        </div>
                        <div class="pattern-option" data-pattern="dots" style="background: #1e40af; background-image: radial-gradient(circle, #3b82f6 20%, transparent 20%); background-size: 15px 15px;">
                            <span style="color: white;">نقط</span>
                        </div>
                    </div>
                </div>
                
                <!-- اختيار الألوان المحسن -->
                <div class="control-group">
                    <label class="form-label fw-bold">
                        <i class="fas fa-fill-drip me-2"></i>
                        ألوان القميص
                    </label>
                    <div class="color-picker-container">
                        <input type="color" class="color-picker" value="#1e3a8a" id="primaryColor" title="اللون الأساسي">
                        <input type="color" class="color-picker" value="#3b82f6" id="secondaryColor" title="اللون الثانوي">
                        <input type="color" class="color-picker" value="#ffffff" id="textColor" title="لون النص">
                    </div>
                </div>

                <!-- المقاسات -->
                <div class="control-group">
                    <label class="form-label fw-bold">
                        <i class="fas fa-ruler me-2"></i>
                        المقاسات المطلوبة
                    </label>
                    <div class="size-selector">
                        <div class="size-option" data-size="XS">XS</div>
                        <div class="size-option" data-size="S">S</div>
                        <div class="size-option active" data-size="M">M</div>
                        <div class="size-option" data-size="L">L</div>
                        <div class="size-option" data-size="XL">XL</div>
                        <div class="size-option" data-size="XXL">XXL</div>
                    </div>
                </div>

                <!-- الكمية -->
                <div class="control-group">
                    <label class="form-label fw-bold">
                        <i class="fas fa-sort-numeric-up me-2"></i>
                        الكمية المطلوبة
                    </label>
                    <input type="number" id="quantity" class="text-input" value="1" min="1" max="1000">
                </div>
            </div>

            <!-- حاسبة السعر -->
            <div class="price-calculator" data-aos="fade-right" data-aos-delay="200">
                <h5 class="mb-3">
                    <i class="fas fa-calculator me-2"></i>
                    حاسبة التكلفة
                </h5>
                <div class="price-item">
                    <span>سعر القطعة الواحدة:</span>
                    <span id="unitPrice">50 ريال</span>
                </div>
                <div class="price-item">
                    <span>الكمية:</span>
                    <span id="quantityDisplay">1</span>
                </div>
                <div class="price-item">
                    <span>رسوم التصميم:</span>
                    <span id="designFee">20 ريال</span>
                </div>
                <div class="price-total">
                    <strong>الإجمالي: <span id="totalPrice">70 ريال</span></strong>
                </div>
            </div>

            <!-- أزرار التحكم -->
            <div class="action-buttons" data-aos="fade-up" data-aos-delay="400">
                <button class="btn btn-3d" onclick="toggle3D()">
                    <i class="fas fa-cube me-2"></i>
                    عرض ثلاثي الأبعاد
                </button>
                <button class="btn btn-3d" onclick="saveDesign()">
                    <i class="fas fa-save me-2"></i>
                    حفظ التصميم
                </button>
                <button class="btn btn-3d" onclick="downloadDesign()">
                    <i class="fas fa-download me-2"></i>
                    تحميل التصميم
                </button>
                <button class="btn btn-3d" onclick="shareDesign()">
                    <i class="fas fa-share-alt me-2"></i>
                    مشاركة التصميم
                </button>
            </div>
        </div>
        
        <!-- معاينة التصميم المحسنة -->
        <div class="col-lg-8">
            <div class="design-preview" data-aos="fade-left">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>
                        <i class="fas fa-eye me-2"></i>
                        معاينة التصميم
                    </h4>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary" onclick="rotateLeft()">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-primary" onclick="resetRotation()">
                            <i class="fas fa-sync"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-primary" onclick="rotateRight()">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                </div>
                
                <div class="jersey-preview">
                    <!-- مجسم الإنسان المحسن -->
                    <div class="human-figure" id="humanFigure">
                        <div class="head"></div>
                        <div class="body">
                            <div class="tshirt-template" id="tshirtTemplate">
                                <div class="team-logo" id="teamLogo">∞</div>
                                <div class="design-text" id="designTextPreview">
                                    INFINITY WEAR
                                </div>
                                <div class="player-number" id="playerNumberPreview">
                                    10
                                </div>
                            </div>
                        </div>
                        <div class="arms">
                            <div class="arm left-arm"></div>
                            <div class="arm right-arm"></div>
                        </div>
                        <div class="legs">
                            <div class="leg left-leg"></div>
                            <div class="leg right-leg"></div>
                        </div>
                    </div>
                </div>
                
                <!-- معلومات التصميم المفصلة -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card h-100" data-aos="fade-up">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    تفاصيل التصميم
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-2"><strong>اسم الفريق:</strong> <span id="textInfo">INFINITY WEAR</span></p>
                                <p class="mb-2"><strong>رقم اللاعب:</strong> <span id="numberInfo">10</span></p>
                                <p class="mb-2"><strong>النمط:</strong> <span id="patternInfo">متدرج</span></p>
                                <p class="mb-2"><strong>المقاس:</strong> <span id="sizeInfo">M</span></p>
                                <p class="mb-0"><strong>الكمية:</strong> <span id="quantityInfo">1</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100" data-aos="fade-up" data-aos-delay="100">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-palette me-2"></i>
                                    الألوان المستخدمة
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="color-sample me-2" id="primaryColorSample" style="width: 20px; height: 20px; border-radius: 50%; background: #1e3a8a;"></div>
                                    <span>اللون الأساسي: <span id="primaryColorCode">#1e3a8a</span></span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="color-sample me-2" id="secondaryColorSample" style="width: 20px; height: 20px; border-radius: 50%; background: #3b82f6;"></div>
                                    <span>اللون الثانوي: <span id="secondaryColorCode">#3b82f6</span></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="color-sample me-2" id="textColorSample" style="width: 20px; height: 20px; border-radius: 50%; background: #ffffff;"></div>
                                    <span>لون النص: <span id="textColorCode">#ffffff</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- نموذج حفظ التصميم المحسن -->
<div class="modal fade" id="saveDesignModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-save me-2"></i>
                    حفظ التصميم
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('custom-designs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">اسم التصميم</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">فئة التصميم</label>
                                <select class="form-select" name="category">
                                    <option value="football">كرة قدم</option>
                                    <option value="basketball">كرة سلة</option>
                                    <option value="volleyball">كرة طائرة</option>
                                    <option value="school">مدرسي</option>
                                    <option value="corporate">مؤسسي</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">وصف التصميم</label>
                                <textarea class="form-control" name="description" rows="4" placeholder="اكتب وصف مفصل للتصميم..."></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="design_data" id="designData">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>
                        إلغاء
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        حفظ التصميم
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // متغيرات التصميم المحسنة
    let currentDesign = {
        text: 'INFINITY WEAR',
        playerNumber: '10',
        primaryColor: '#1e3a8a',
        secondaryColor: '#3b82f6',
        textColor: '#ffffff',
        pattern: 'gradient',
        size: 'M',
        quantity: 1,
        template: null,
        rotation: 0
    };
    
    let is3DMode = false;
    
    // تحديث التصميم المحسن
    function updateDesign() {
        const textElement = document.getElementById('designTextPreview');
        const numberElement = document.getElementById('playerNumberPreview');
        const shirtElement = document.getElementById('tshirtTemplate');
        const legsElements = document.querySelectorAll('.leg');
        
        // تحديث النص
        textElement.textContent = currentDesign.text || 'INFINITY WEAR';
        textElement.style.color = currentDesign.textColor;
        
        // تحديث رقم اللاعب
        numberElement.textContent = currentDesign.playerNumber || '';
        numberElement.style.color = currentDesign.textColor;
        numberElement.style.display = currentDesign.playerNumber ? 'block' : 'none';
        
        // تحديث نمط القميص
        updateShirtPattern();
        
        // تحديث السراويل
        legsElements.forEach(leg => {
            leg.style.background = `linear-gradient(135deg, ${currentDesign.primaryColor}, ${currentDesign.secondaryColor})`;
            leg.style.borderColor = currentDesign.primaryColor;
        });
        
        // تحديث معلومات التصميم
        updateDesignInfo();
        
        // تحديث السعر
        updatePrice();
    }
    
    function updateShirtPattern() {
        const shirtElement = document.getElementById('tshirtTemplate');
        
        switch(currentDesign.pattern) {
            case 'solid':
                shirtElement.style.background = currentDesign.primaryColor;
                break;
            case 'gradient':
                shirtElement.style.background = `linear-gradient(135deg, ${currentDesign.primaryColor}, ${currentDesign.secondaryColor})`;
                break;
            case 'stripes':
                shirtElement.style.background = `repeating-linear-gradient(90deg, ${currentDesign.primaryColor} 0px, ${currentDesign.primaryColor} 20px, ${currentDesign.secondaryColor} 20px, ${currentDesign.secondaryColor} 40px)`;
                break;
            case 'dots':
                shirtElement.style.background = currentDesign.primaryColor;
                shirtElement.style.backgroundImage = `radial-gradient(circle, ${currentDesign.secondaryColor} 30%, transparent 30%)`;
                shirtElement.style.backgroundSize = '20px 20px';
                break;
        }
        
        shirtElement.style.borderColor = currentDesign.primaryColor;
    }
    
    function updateDesignInfo() {
        document.getElementById('textInfo').textContent = currentDesign.text || 'INFINITY WEAR';
        document.getElementById('numberInfo').textContent = currentDesign.playerNumber || 'بدون رقم';
        document.getElementById('patternInfo').textContent = getPatternName(currentDesign.pattern);
        document.getElementById('sizeInfo').textContent = currentDesign.size;
        document.getElementById('quantityInfo').textContent = currentDesign.quantity;
        
        // تحديث عينات الألوان
        document.getElementById('primaryColorSample').style.background = currentDesign.primaryColor;
        document.getElementById('secondaryColorSample').style.background = currentDesign.secondaryColor;
        document.getElementById('textColorSample').style.background = currentDesign.textColor;
        document.getElementById('primaryColorCode').textContent = currentDesign.primaryColor;
        document.getElementById('secondaryColorCode').textContent = currentDesign.secondaryColor;
        document.getElementById('textColorCode').textContent = currentDesign.textColor;
    }
    
    function getPatternName(pattern) {
        const patterns = {
            'solid': 'صافي',
            'gradient': 'متدرج',
            'stripes': 'مخطط',
            'dots': 'نقط'
        };
        return patterns[pattern] || 'متدرج';
    }
    
    function updatePrice() {
        const basePrice = 50;
        const designFee = 20;
        const quantity = currentDesign.quantity;
        
        // خصم على الكميات الكبيرة
        let discount = 0;
        if (quantity >= 10) discount = 0.1;
        if (quantity >= 50) discount = 0.15;
        if (quantity >= 100) discount = 0.2;
        
        const subtotal = (basePrice * quantity) + designFee;
        const total = subtotal * (1 - discount);
        
        document.getElementById('quantityDisplay').textContent = quantity;
        document.getElementById('totalPrice').textContent = Math.round(total) + ' ريال';
        
        if (discount > 0) {
            document.getElementById('designFee').innerHTML = `20 ريال <small class="text-success">(خصم ${Math.round(discount * 100)}%)</small>`;
        }
    }
    
    // مستمعي الأحداث المحسنة
    document.getElementById('designText').addEventListener('input', function() {
        currentDesign.text = this.value;
        updateDesign();
    });

    document.getElementById('playerNumber').addEventListener('input', function() {
        currentDesign.playerNumber = this.value;
        updateDesign();
    });

    document.getElementById('quantity').addEventListener('input', function() {
        currentDesign.quantity = parseInt(this.value) || 1;
        updateDesign();
    });

    // مستمعي تغيير الألوان
    document.getElementById('primaryColor').addEventListener('change', function() {
        currentDesign.primaryColor = this.value;
        updateDesign();
    });

    document.getElementById('secondaryColor').addEventListener('change', function() {
        currentDesign.secondaryColor = this.value;
        updateDesign();
    });

    document.getElementById('textColor').addEventListener('change', function() {
        currentDesign.textColor = this.value;
        updateDesign();
    });

    // مستمعي اختيار النمط
    document.querySelectorAll('.pattern-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.pattern-option').forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            currentDesign.pattern = this.dataset.pattern;
            updateDesign();
        });
    });

    // مستمعي اختيار المقاس
    document.querySelectorAll('.size-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.size-option').forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            currentDesign.size = this.dataset.size;
            updateDesign();
        });
    });

    // مستمعي القوالب الجاهزة
    document.querySelectorAll('.template-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.template-option').forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            const template = this.dataset.template;
            applyTemplate(template);
        });
    });

    function applyTemplate(template) {
        const templates = {
            'saudi_pro': {
                text: 'الدوري السعودي المحترف',
                primaryColor: '#0d7377',
                secondaryColor: '#14a085',
                pattern: 'gradient'
            },
            'youth_academy': {
                text: 'أكاديمية الشباب',
                primaryColor: '#1e40af',
                secondaryColor: '#3b82f6',
                pattern: 'gradient'
            },
            'school_team': {
                text: 'فريق المدرسة',
                primaryColor: '#dc2626',
                secondaryColor: '#ef4444',
                pattern: 'stripes'
            },
            'corporate': {
                text: 'شركة المستقبل',
                primaryColor: '#7c3aed',
                secondaryColor: '#a855f7',
                pattern: 'solid'
            },
            'classic': {
                text: 'الفريق الكلاسيكي',
                primaryColor: '#374151',
                secondaryColor: '#6b7280',
                pattern: 'solid'
            },
            'modern': {
                text: 'الفريق العصري',
                primaryColor: '#f59e0b',
                secondaryColor: '#fbbf24',
                pattern: 'dots'
            }
        };
        
        if (templates[template]) {
            Object.assign(currentDesign, templates[template]);
            
            // تحديث الحقول
            document.getElementById('designText').value = currentDesign.text;
            document.getElementById('primaryColor').value = currentDesign.primaryColor;
            document.getElementById('secondaryColor').value = currentDesign.secondaryColor;
            
            // تحديث النمط المختار
            document.querySelectorAll('.pattern-option').forEach(opt => opt.classList.remove('active'));
            document.querySelector(`[data-pattern="${currentDesign.pattern}"]`).classList.add('active');
            
            updateDesign();
        }
    }

    // وظائف التحكم في العرض ثلاثي الأبعاد
    function toggle3D() {
        const figure = document.getElementById('humanFigure');
        is3DMode = !is3DMode;
        
        if (is3DMode) {
            figure.classList.add('rotate-3d');
            document.querySelector('[onclick="toggle3D()"]').innerHTML = '<i class="fas fa-expand me-2"></i>عرض عادي';
        } else {
            figure.classList.remove('rotate-3d');
            document.querySelector('[onclick="toggle3D()"]').innerHTML = '<i class="fas fa-cube me-2"></i>عرض ثلاثي الأبعاد';
        }
    }

    function rotateLeft() {
        currentDesign.rotation -= 15;
        document.getElementById('humanFigure').style.transform = `perspective(1000px) rotateY(${currentDesign.rotation}deg)`;
    }

    function rotateRight() {
        currentDesign.rotation += 15;
        document.getElementById('humanFigure').style.transform = `perspective(1000px) rotateY(${currentDesign.rotation}deg)`;
    }

    function resetRotation() {
        currentDesign.rotation = 0;
        document.getElementById('humanFigure').style.transform = 'perspective(1000px) rotateY(0deg)';
        document.getElementById('humanFigure').classList.remove('rotate-3d');
        is3DMode = false;
        document.querySelector('[onclick="toggle3D()"]').innerHTML = '<i class="fas fa-cube me-2"></i>عرض ثلاثي الأبعاد';
    }

    // مستمع تغيير نوع التصميم
    document.querySelectorAll('input[name="designType"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const templatesSection = document.getElementById('templatesSection');
            if (this.value === 'template') {
                templatesSection.style.display = 'block';
            } else {
                templatesSection.style.display = 'none';
                document.querySelectorAll('.template-option').forEach(opt => opt.classList.remove('active'));
            }
        });
    });
    
    // حفظ التصميم المحسن
    function saveDesign() {
        document.getElementById('designData').value = JSON.stringify(currentDesign);
        const modal = new bootstrap.Modal(document.getElementById('saveDesignModal'));
        modal.show();
    }
    
    // تحميل التصميم المحسن
    function downloadDesign() {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        
        canvas.width = 800;
        canvas.height = 1000;
        
        // رسم خلفية شفافة
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // رسم القميص بالنمط المختار
        drawShirtOnCanvas(ctx);
        
        // رسم النص
        ctx.fillStyle = currentDesign.textColor;
        ctx.font = 'bold 48px Cairo, Arial';
        ctx.textAlign = 'center';
        ctx.fillText(currentDesign.text, 400, 350);
        
        // رسم رقم اللاعب
        if (currentDesign.playerNumber) {
            ctx.font = 'bold 120px Arial';
            ctx.fillText(currentDesign.playerNumber, 400, 550);
        }
        
        // تحميل الصورة
        const link = document.createElement('a');
        link.download = `infinity-wear-design-${Date.now()}.png`;
        link.href = canvas.toDataURL('image/png', 1.0);
        link.click();
    }
    
    function drawShirtOnCanvas(ctx) {
        const gradient = ctx.createLinearGradient(0, 0, 800, 1000);
        gradient.addColorStop(0, currentDesign.primaryColor);
        gradient.addColorStop(1, currentDesign.secondaryColor);
        
        ctx.fillStyle = gradient;
        ctx.fillRect(100, 200, 600, 700);
        
        // إضافة حدود
        ctx.strokeStyle = currentDesign.primaryColor;
        ctx.lineWidth = 8;
        ctx.strokeRect(100, 200, 600, 700);
    }
    
    // مشاركة التصميم
    function shareDesign() {
        if (navigator.share) {
            navigator.share({
                title: 'تصميم Infinity Wear',
                text: `شاهد تصميمي الجديد: ${currentDesign.text}`,
                url: window.location.href
            });
        } else {
            // نسخ الرابط للحافظة
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('تم نسخ رابط التصميم إلى الحافظة!');
            });
        }
    }
    
    // تهيئة التصميم
    document.addEventListener('DOMContentLoaded', function() {
        updateDesign();
        
        // تهيئة AOS للرسوم المتحركة
        if (typeof AOS !== 'undefined') {
            AOS.refresh();
        }
    });
</script>
@endsection