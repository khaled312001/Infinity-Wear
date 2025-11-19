@extends('layouts.app')

@section('title', 'أطلب الآن - Infinity Wear')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    :root {
        --primary-color: #4A90E2;
        --secondary-color: #2C3E50;
        --accent-color: #E74C3C;
        --light-bg: #f8f9fa;
    }

    body {
        background-color: #f0f2f5;
    }

    .viewer-container {
        height: 600px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        position: relative;
    }

    #3d-viewer {
        width: 100%;
        height: 100%;
    }

    .viewer-controls {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255,255,255,0.9);
        padding: 10px 20px;
        border-radius: 30px;
        display: flex;
        gap: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        z-index: 10;
    }

    .control-btn {
        background: none;
        border: none;
        color: var(--secondary-color);
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.2s;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .control-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .form-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        height: 100%;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--secondary-color);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
    }

    .custom-option-card {
        border: 2px solid #eee;
        border-radius: 10px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
        margin-bottom: 15px;
    }

    .custom-option-card:hover, .custom-option-card.active {
        border-color: var(--primary-color);
        background-color: rgba(74, 144, 226, 0.05);
    }

    .custom-option-card i {
        font-size: 2rem;
        color: var(--secondary-color);
        margin-bottom: 10px;
        display: block;
    }

    .color-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid #eee;
        display: inline-block;
        margin: 5px;
        transition: transform 0.2s;
    }

    .color-circle:hover {
        transform: scale(1.2);
    }

    .piece-selector {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .piece-checkbox-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        width: 80px;
        transition: all 0.2s;
    }

    .piece-checkbox-label:hover {
        background-color: #f8f9fa;
    }

    .piece-checkbox-label input {
        display: none;
    }

    .piece-checkbox-label input:checked + span {
        color: var(--primary-color);
        font-weight: bold;
    }

    .piece-checkbox-label input:checked + span::before {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        margin-left: 5px;
    }

    .piece-icon {
        font-size: 24px;
        margin-bottom: 5px;
    }

    .nav-pills .nav-link {
        color: var(--secondary-color);
        border-radius: 20px;
        padding: 10px 20px;
        margin: 0 5px;
    }

    .nav-pills .nav-link.active {
        background-color: var(--primary-color);
        color: white;
    }

    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        padding: 15px 25px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        transform: translateX(120%);
        transition: transform 0.3s ease;
        z-index: 9999;
    }

    .notification.show {
        transform: translateX(0);
    }

    .notification-success { border-left: 5px solid #2ecc71; }
    .notification-error { border-left: 5px solid #e74c3c; }
    .notification-warning { border-left: 5px solid #f1c40f; }
    .notification-info { border-left: 5px solid #3498db; }

</style>
@endpush

@section('content')
<div class="container-fluid py-5">
    <form id="importer-form" action="{{ route('importers.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="design_option" value="custom">
        <input type="hidden" id="design_3d_data" name="design_3d_data">
        <input type="hidden" id="design_preview_image" name="design_preview_image">
        <input type="hidden" id="quantity" name="quantity" value="0">

        <div class="row g-4">
            <!-- Right Column (Form Controls) -->
            <div class="col-lg-6 order-lg-1">
                <div class="form-card">
                    <ul class="nav nav-pills mb-4 justify-content-center" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-design-tab" data-bs-toggle="pill" data-bs-target="#pills-design" type="button" role="tab">التصميم</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-sizes-tab" data-bs-toggle="pill" data-bs-target="#pills-sizes" type="button" role="tab">المقاسات</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-info-tab" data-bs-toggle="pill" data-bs-target="#pills-info" type="button" role="tab">البيانات</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <!-- Design Tab -->
                        <div class="tab-pane fade show active" id="pills-design" role="tabpanel">
                            <div class="mb-4">
                                <label class="form-label">نوع النشاط</label>
                                <select class="form-select" id="design_activity_type" name="design_activity_type">
                                    <option value="">اختر نوع النشاط...</option>
                                    <option value="academy">أكاديمية رياضية</option>
                                    <option value="school">مدرسة</option>
                                    <option value="hospital">مستشفى</option>
                                    <option value="company">شركة</option>
                                    <option value="store">متجر ملابس</option>
                                    <option value="other">أخرى</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">قطع الملابس</label>
                                <div class="piece-selector">
                                    <label class="piece-checkbox-label">
                                        <input type="checkbox" class="clothing-piece-checkbox" data-piece-type="shirt" name="clothing_pieces[]" value="shirt">
                                        <i class="fas fa-tshirt piece-icon"></i>
                                        <span>قميص</span>
                                    </label>
                                    <label class="piece-checkbox-label">
                                        <input type="checkbox" class="clothing-piece-checkbox" data-piece-type="pants" name="clothing_pieces[]" value="pants">
                                        <i class="fas fa-user piece-icon"></i> <!-- Placeholder icon for pants -->
                                        <span>بنطلون</span>
                                    </label>
                                    <label class="piece-checkbox-label">
                                        <input type="checkbox" class="clothing-piece-checkbox" data-piece-type="shorts" name="clothing_pieces[]" value="shorts">
                                        <i class="fas fa-water piece-icon"></i>
                                        <span>شورت</span>
                                    </label>
                                    <label class="piece-checkbox-label">
                                        <input type="checkbox" class="clothing-piece-checkbox" data-piece-type="jacket" name="clothing_pieces[]" value="jacket">
                                        <i class="fas fa-user-tie piece-icon"></i>
                                        <span>جاكيت</span>
                                    </label>
                                    <label class="piece-checkbox-label">
                                        <input type="checkbox" class="clothing-piece-checkbox" data-piece-type="shoes" name="clothing_pieces[]" value="shoes">
                                        <i class="fas fa-shoe-prints piece-icon"></i>
                                        <span>حذاء</span>
                                    </label>
                                    <label class="piece-checkbox-label">
                                        <input type="checkbox" class="clothing-piece-checkbox" data-piece-type="socks" name="clothing_pieces[]" value="socks">
                                        <i class="fas fa-socks piece-icon"></i>
                                        <span>شراب</span>
                                    </label>
                                </div>
                            </div>

                            <div class="accordion" id="designAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#colorsCollapse">
                                            <i class="fas fa-palette me-2"></i> الألوان والأنماط
                                        </button>
                                    </h2>
                                    <div id="colorsCollapse" class="accordion-collapse collapse show" data-bs-parent="#designAccordion">
                                        <div class="accordion-body">
                                            <!-- Dynamic Color Controls will be inserted here by JS -->
                                            <p class="text-muted small mb-3">اختر قطعة من القائمة أعلاه لتخصيص ألوانها</p>
                                            
                                            <!-- Template for Shirt Colors (Hidden by default) -->
                                            <div id="color-shirt" style="display:none;" class="mb-3 border-bottom pb-3">
                                                <h6>القميص</h6>
                                                <div class="mb-2">
                                                    <label class="small">الجسم</label>
                                                    <input type="color" class="form-control form-control-color color-picker" value="#4A90E2" data-piece-type="shirt" data-part="body">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="small">الأكمام</label>
                                                    <input type="color" class="form-control form-control-color color-picker" value="#4A90E2" data-piece-type="shirt" data-part="sleeves">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="small">الياقة</label>
                                                    <input type="color" class="form-control form-control-color color-picker" value="#4A90E2" data-piece-type="shirt" data-part="collar">
                                                </div>
                                            </div>
                                            
                                            <div id="color-pants" style="display:none;" class="mb-3 border-bottom pb-3">
                                                <h6>البنطلون</h6>
                                                <div class="mb-2">
                                                    <label class="small">اللون الأساسي</label>
                                                    <input type="color" class="form-control form-control-color color-picker" value="#2C3E50" data-piece-type="pants" data-part="body">
                                                </div>
                                            </div>

                                            <div id="color-shorts" style="display:none;" class="mb-3 border-bottom pb-3">
                                                <h6>الشورت</h6>
                                                <div class="mb-2">
                                                    <label class="small">اللون الأساسي</label>
                                                    <input type="color" class="form-control form-control-color color-picker" value="#E74C3C" data-piece-type="shorts" data-part="body">
                                                </div>
                                            </div>

                                            <div id="color-jacket" style="display:none;" class="mb-3 border-bottom pb-3">
                                                <h6>الجاكيت</h6>
                                                <div class="mb-2">
                                                    <label class="small">الجسم</label>
                                                    <input type="color" class="form-control form-control-color color-picker" value="#34495E" data-piece-type="jacket" data-part="body">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="small">الأكمام</label>
                                                    <input type="color" class="form-control form-control-color color-picker" value="#34495E" data-piece-type="jacket" data-part="sleeves">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="small">الياقة</label>
                                                    <input type="color" class="form-control form-control-color color-picker" value="#34495E" data-piece-type="jacket" data-part="collar">
                                                </div>
                                            </div>

                                            <div id="color-shoes" style="display:none;" class="mb-3 border-bottom pb-3">
                                                <h6>الحذاء</h6>
                                                <div class="mb-2">
                                                    <label class="small">اللون الأساسي</label>
                                                    <input type="color" class="form-control form-control-color color-picker" value="#2C3E50" data-piece-type="shoes" data-part="body">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="small">النعل</label>
                                                    <input type="color" class="form-control form-control-color color-picker" value="#FFFFFF" data-piece-type="shoes" data-part="sole">
                                                </div>
                                            </div>

                                            <div id="color-socks" style="display:none;" class="mb-3 border-bottom pb-3">
                                                <h6>الشراب</h6>
                                                <div class="mb-2">
                                                    <label class="small">اللون الأساسي</label>
                                                    <input type="color" class="form-control form-control-color color-picker" value="#FFFFFF" data-piece-type="socks" data-part="body">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="small">الحافة</label>
                                                    <input type="color" class="form-control form-control-color color-picker" value="#FFFFFF" data-piece-type="socks" data-part="cuff">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#logosCollapse">
                                            <i class="fas fa-image me-2"></i> الشعار
                                        </button>
                                    </h2>
                                    <div id="logosCollapse" class="accordion-collapse collapse" data-bs-parent="#designAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <label class="form-label">رفع الشعار</label>
                                                <input type="file" class="form-control" id="logo_file" accept="image/*">
                                            </div>
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="form-label">القطعة</label>
                                                    <select class="form-select" id="logo_piece_type">
                                                        <option value="shirt">القميص</option>
                                                        <option value="pants">البنطلون</option>
                                                        <option value="jacket">الجاكيت</option>
                                                    </select>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label class="form-label">الموضع</label>
                                                    <select class="form-select" id="logo_position">
                                                        <!-- Options populated by JS -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                 <label class="form-label">الحجم</label>
                                                 <input type="range" class="form-range" id="logo_size" min="0.1" max="0.5" step="0.05" value="0.2">
                                            </div>
                                            <div id="logo-list" class="mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#textCollapse">
                                            <i class="fas fa-font me-2"></i> النصوص
                                        </button>
                                    </h2>
                                    <div id="textCollapse" class="accordion-collapse collapse" data-bs-parent="#designAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <label class="form-label">النص</label>
                                                <input type="text" class="form-control" id="text_content" placeholder="اكتب النص هنا">
                                            </div>
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="form-label">القطعة</label>
                                                    <select class="form-select" id="text_piece_type">
                                                        <option value="shirt">القميص</option>
                                                        <option value="pants">البنطلون</option>
                                                        <option value="jacket">الجاكيت</option>
                                                    </select>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label class="form-label">الموضع</label>
                                                    <select class="form-select" id="text_position">
                                                        <!-- Options populated by JS -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="form-label">اللون</label>
                                                    <input type="color" class="form-control form-control-color w-100" id="text_color" value="#000000">
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label class="form-label">الحجم</label>
                                                    <input type="range" class="form-range" id="text_size" min="0.1" max="0.8" step="0.05" value="0.3">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary w-100" id="add-text-btn">إضافة النص</button>
                                            <div id="text-list" class="mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sizes Tab -->
                        <div class="tab-pane fade" id="pills-sizes" role="tabpanel">
                            <h5 class="mb-3">الكميات والمقاسات</h5>
                            <p class="text-muted">أدخل الكمية المطلوبة لكل مقاس</p>
                            
                            <!-- Shirt Sizes -->
                            <div id="size-shirt" style="display:none;" class="mb-4">
                                <h6><i class="fas fa-tshirt me-2"></i> مقاسات القميص</h6>
                                <div class="row g-2">
                                    <div class="col-3">
                                        <label class="small">S</label>
                                        <input type="number" class="form-control size-input" name="sizes[shirt][s]" min="0">
                                    </div>
                                    <div class="col-3">
                                        <label class="small">M</label>
                                        <input type="number" class="form-control size-input" name="sizes[shirt][m]" min="0">
                                    </div>
                                    <div class="col-3">
                                        <label class="small">L</label>
                                        <input type="number" class="form-control size-input" name="sizes[shirt][l]" min="0">
                                    </div>
                                    <div class="col-3">
                                        <label class="small">XL</label>
                                        <input type="number" class="form-control size-input" name="sizes[shirt][xl]" min="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Pants Sizes -->
                            <div id="size-pants" style="display:none;" class="mb-4">
                                <h6><i class="fas fa-user me-2"></i> مقاسات البنطلون</h6>
                                <div class="row g-2">
                                    <div class="col-3">
                                        <label class="small">30</label>
                                        <input type="number" class="form-control size-input" name="sizes[pants][30]" min="0">
                                    </div>
                                    <div class="col-3">
                                        <label class="small">32</label>
                                        <input type="number" class="form-control size-input" name="sizes[pants][32]" min="0">
                                    </div>
                                    <div class="col-3">
                                        <label class="small">34</label>
                                        <input type="number" class="form-control size-input" name="sizes[pants][34]" min="0">
                                    </div>
                                    <div class="col-3">
                                        <label class="small">36</label>
                                        <input type="number" class="form-control size-input" name="sizes[pants][36]" min="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Other pieces sizes... -->
                            
                            <div class="mt-4 p-3 bg-light rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>الإجمالي الكلي:</strong>
                                    <span class="h4 mb-0" id="total-pieces">0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Info Tab -->
                        <div class="tab-pane fade" id="pills-info" role="tabpanel">
                            <h5 class="mb-3">معلومات التواصل</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">الاسم الكامل</label>
                                <input type="text" class="form-control" name="name" required value="{{ auth()->user()->name ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control" name="email" required value="{{ auth()->user()->email ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">رقم الهاتف</label>
                                <input type="tel" class="form-control" name="phone" required value="{{ auth()->user()->phone ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">اسم الشركة/المؤسسة</label>
                                <input type="text" class="form-control" name="company_name" required>
                            </div>
                            
                            @if(!auth()->check())
                            <div class="mb-3">
                                <label class="form-label">كلمة المرور</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">تأكيد كلمة المرور</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">ملاحظات إضافية</label>
                                <textarea class="form-control" name="requirements" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100 btn-lg mt-3" onclick="return designInterface.exportDesignData()">
                                إرسال الطلب <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Left Column (3D Viewer) - Visually Left (end in RTL) -->
            <div class="col-lg-6 order-lg-2">
                <div class="viewer-container">
                    <div id="3d-viewer"></div>
                    
                    <div class="viewer-controls">
                        <button type="button" class="control-btn" id="rotate-model" title="تدوير تلقائي">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <button type="button" class="control-btn" id="zoom-in" title="تكبير">
                            <i class="fas fa-search-plus"></i>
                        </button>
                        <button type="button" class="control-btn" id="zoom-out" title="تصغير">
                            <i class="fas fa-search-minus"></i>
                        </button>
                        <button type="button" class="control-btn" id="reset-view" title="إعادة تعيين">
                            <i class="fas fa-compress-arrows-alt"></i>
                        </button>
                        <button type="button" class="control-btn" id="view-front" title="أمام">
                            <i class="fas fa-user"></i>
                        </button>
                        <button type="button" class="control-btn" id="view-back" title="خلف">
                            <i class="fas fa-user" style="transform: scaleX(-1);"></i>
                        </button>
                    </div>
                </div>
                
                <div class="mt-4 text-center text-muted">
                    <small><i class="fas fa-mouse"></i> استخدم الفأرة للتحكم في العرض: انقر واسحب للتدوير، العجلة للتكبير</small>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<!-- Three.js and Extensions -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>

<!-- Enhanced 3D Viewer System -->
<script src="{{ asset('js/enhanced-3d-viewer.js') }}?v={{ time() }}"></script>
<script src="{{ asset('js/design-interface.js') }}?v={{ time() }}"></script>
@endpush
