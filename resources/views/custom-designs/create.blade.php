@extends('layouts.app')

@section('title', 'صمم زي موحد - Infinity Wear')

@section('styles')
<style>
    .design-canvas {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        background: white;
        position: relative;
        overflow: hidden;
    }
    
    .design-tools {
        background: #f8fafc;
        border-radius: 10px;
        padding: 20px;
    }
    
    .color-picker {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        margin: 5px;
    }
    
    .text-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #d1d5db;
        border-radius: 5px;
        font-size: 16px;
    }
    
    .design-preview {
        background: #f3f4f6;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
    }
    
    .jersey-preview {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 400px;
    }

    .human-figure {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .head {
        width: 40px;
        height: 40px;
        background: #f3c2a1;
        border-radius: 50%;
        margin-bottom: 10px;
        border: 2px solid #d69e2e;
    }

    .body {
        position: relative;
        z-index: 2;
    }

    .tshirt-template {
        width: 180px;
        height: 220px;
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        border-radius: 15px 15px 5px 5px;
        position: relative;
        border: 2px solid #1e40af;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .design-text {
        position: absolute;
        top: 30%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: bold;
        text-align: center;
        word-wrap: break-word;
        max-width: 150px;
        color: white;
        font-size: 16px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    .player-number {
        position: absolute;
        top: 70%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: bold;
        font-size: 48px;
        color: white;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    .arms {
        position: absolute;
        top: 60px;
        width: 220px;
        height: 120px;
        z-index: 1;
    }

    .arm {
        width: 25px;
        height: 120px;
        background: #f3c2a1;
        border-radius: 12px;
        position: absolute;
        border: 2px solid #d69e2e;
    }

    .left-arm {
        left: -30px;
        transform: rotate(-10deg);
    }

    .right-arm {
        right: -30px;
        transform: rotate(10deg);
    }

    .legs {
        display: flex;
        gap: 10px;
        margin-top: 5px;
    }

    .leg {
        width: 30px;
        height: 100px;
        background: #1e3a8a;
        border-radius: 15px;
        border: 2px solid #1e40af;
    }

    .template-option {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        border-radius: 8px;
        padding: 8px;
    }

    .template-option:hover,
    .template-option.active {
        border-color: var(--primary-color);
        background: rgba(30, 58, 138, 0.1);
    }

    .template-preview {
        text-align: center;
    }

    .template-shirt {
        width: 60px;
        height: 70px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 8px;
        font-weight: bold;
        margin: 0 auto;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <!-- عرض الرسائل -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('message'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="section-title">صمم زي موحد</h1>
            <p class="lead">أنشئ تصميمك المخصص للزي الموحد</p>
        </div>
    </div>
    
    <div class="row">
        <!-- أدوات التصميم -->
        <div class="col-lg-4">
            <div class="design-tools">
                <h4 class="mb-4">أدوات التصميم</h4>
                
                <!-- اختيار نوع التصميم -->
                <div class="mb-4">
                    <label class="form-label">نوع التصميم</label>
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="designType" id="customDesign" value="custom" checked>
                        <label class="btn btn-outline-primary" for="customDesign">تصميم مخصص</label>
                        
                        <input type="radio" class="btn-check" name="designType" id="templateDesign" value="template">
                        <label class="btn btn-outline-primary" for="templateDesign">قوالب جاهزة</label>
                    </div>
                </div>

                <!-- القوالب الجاهزة -->
                <div class="mb-4" id="templatesSection" style="display: none;">
                    <label class="form-label">اختر قالب جاهز</label>
                    <div class="row g-2">
                        <div class="col-4">
                            <div class="template-option" data-template="team1">
                                <div class="template-preview">
                                    <div class="template-shirt" style="background: linear-gradient(45deg, #1e40af, #3b82f6);">
                                        <span>فريق النصر</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="template-option" data-template="team2">
                                <div class="template-preview">
                                    <div class="template-shirt" style="background: linear-gradient(45deg, #dc2626, #ef4444);">
                                        <span>فريق الأهلي</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="template-option" data-template="team3">
                                <div class="template-preview">
                                    <div class="template-shirt" style="background: linear-gradient(45deg, #059669, #10b981);">
                                        <span>فريق الاتحاد</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- إدخال النص -->
                <div class="mb-4">
                    <label class="form-label">النص المطلوب</label>
                    <input type="text" id="designText" class="text-input" placeholder="أدخل اسم الفريق أو النص...">
                </div>

                <!-- رقم اللاعب -->
                <div class="mb-4">
                    <label class="form-label">رقم اللاعب (اختياري)</label>
                    <input type="number" id="playerNumber" class="text-input" placeholder="رقم اللاعب" min="1" max="99">
                </div>
                
                <!-- اختيار اللون -->
                <div class="mb-4">
                    <label class="form-label">لون النص</label>
                    <div class="d-flex flex-wrap">
                        <input type="color" class="color-picker" value="#1e3a8a" id="textColor">
                        <input type="color" class="color-picker" value="#dc2626" id="textColor2">
                        <input type="color" class="color-picker" value="#059669" id="textColor3">
                        <input type="color" class="color-picker" value="#7c3aed" id="textColor4">
                        <input type="color" class="color-picker" value="#ea580c" id="textColor5">
                        <input type="color" class="color-picker" value="#000000" id="textColor6">
                    </div>
                </div>
                
                <!-- اختيار لون القميص -->
                <div class="mb-4">
                    <label class="form-label">لون القميص</label>
                    <div class="d-flex flex-wrap">
                        <input type="color" class="color-picker" value="#ffffff" id="shirtColor">
                        <input type="color" class="color-picker" value="#1e3a8a" id="shirtColor2">
                        <input type="color" class="color-picker" value="#dc2626" id="shirtColor3">
                        <input type="color" class="color-picker" value="#059669" id="shirtColor4">
                        <input type="color" class="color-picker" value="#7c3aed" id="shirtColor5">
                        <input type="color" class="color-picker" value="#000000" id="shirtColor6">
                    </div>
                </div>
                
                <!-- اختيار الخط -->
                <div class="mb-4">
                    <label class="form-label">نوع الخط</label>
                    <select class="form-select" id="fontFamily">
                        <option value="Cairo">Cairo</option>
                        <option value="Arial">Arial</option>
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Courier New">Courier New</option>
                    </select>
                </div>
                
                <!-- حجم الخط -->
                <div class="mb-4">
                    <label class="form-label">حجم الخط</label>
                    <input type="range" class="form-range" min="12" max="32" value="16" id="fontSize">
                    <div class="text-center">
                        <span id="fontSizeValue">16</span> px
                    </div>
                </div>
                
                <!-- أزرار التحكم -->
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" onclick="saveDesign()">
                        <i class="fas fa-save me-2"></i>
                        حفظ التصميم
                    </button>
                    <button class="btn btn-secondary" onclick="resetDesign()">
                        <i class="fas fa-undo me-2"></i>
                        إعادة تعيين
                    </button>
                    <button class="btn btn-success" onclick="downloadDesign()">
                        <i class="fas fa-download me-2"></i>
                        تحميل التصميم
                    </button>
                </div>
            </div>
        </div>
        
        <!-- معاينة التصميم -->
        <div class="col-lg-8">
            <div class="design-preview">
                <h4 class="mb-4">معاينة التصميم</h4>
                <div class="jersey-preview">
                    <!-- مجسم الإنسان -->
                    <div class="human-figure">
                        <div class="head"></div>
                        <div class="body">
                            <div class="tshirt-template" id="tshirtTemplate">
                                <div class="design-text" id="designTextPreview">
                                    اسم الفريق
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
                
                <!-- معلومات التصميم -->
                <div class="mt-4">
                    <div class="row">
                        <div class="col-md-6">
                                                            <div class="card">
                                    <div class="card-body">
                                        <h6>معلومات التصميم</h6>
                                        <p class="mb-1"><strong>اسم الفريق:</strong> <span id="textInfo">اسم الفريق</span></p>
                                        <p class="mb-1"><strong>رقم اللاعب:</strong> <span id="numberInfo">10</span></p>
                                        <p class="mb-1"><strong>لون النص:</strong> <span id="colorInfo">#ffffff</span></p>
                                        <p class="mb-0"><strong>الخط:</strong> <span id="fontInfo">Cairo</span></p>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6>التكلفة المقدرة</h6>
                                    <p class="mb-1"><strong>الكمية:</strong> 1 قطعة</p>
                                    <p class="mb-1"><strong>السعر:</strong> 50 ريال</p>
                                    <p class="mb-0"><strong>الإجمالي:</strong> 50 ريال</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- نموذج حفظ التصميم -->
<div class="modal fade" id="saveDesignModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">حفظ التصميم</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('custom-designs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">اسم التصميم</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">وصف التصميم</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <input type="hidden" name="design_data" id="designData">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التصميم</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // متغيرات التصميم
    let currentText = 'اسم الفريق';
    let currentPlayerNumber = '10';
    let currentTextColor = '#ffffff';
    let currentShirtColor = 'linear-gradient(135deg, #1e3a8a, #3b82f6)';
    let currentFontFamily = 'Cairo';
    let currentFontSize = 16;
    let currentTemplate = null;
    
    // تحديث التصميم
    function updateDesign() {
        const textElement = document.getElementById('designTextPreview');
        const numberElement = document.getElementById('playerNumberPreview');
        const shirtElement = document.getElementById('tshirtTemplate');
        
        textElement.textContent = currentText;
        textElement.style.color = currentTextColor;
        textElement.style.fontFamily = currentFontFamily;
        textElement.style.fontSize = currentFontSize + 'px';
        
        numberElement.textContent = currentPlayerNumber;
        numberElement.style.color = currentTextColor;
        numberElement.style.fontFamily = currentFontFamily;
        numberElement.style.display = currentPlayerNumber ? 'block' : 'none';
        
        if (currentShirtColor.includes('gradient')) {
            shirtElement.style.background = currentShirtColor;
        } else {
            shirtElement.style.backgroundColor = currentShirtColor;
        }
        
        // تحديث المعلومات
        document.getElementById('textInfo').textContent = currentText;
        document.getElementById('numberInfo').textContent = currentPlayerNumber || 'بدون رقم';
        document.getElementById('colorInfo').textContent = currentTextColor;
        document.getElementById('fontInfo').textContent = currentFontFamily;
    }
    
    // إضافة مستمعي الأحداث
    document.getElementById('designText').addEventListener('input', function() {
        currentText = this.value || 'اسم الفريق';
        updateDesign();
    });

    document.getElementById('playerNumber').addEventListener('input', function() {
        currentPlayerNumber = this.value;
        updateDesign();
    });

    // مستمع تغيير نوع التصميم
    document.querySelectorAll('input[name="designType"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const templatesSection = document.getElementById('templatesSection');
            if (this.value === 'template') {
                templatesSection.style.display = 'block';
            } else {
                templatesSection.style.display = 'none';
                currentTemplate = null;
                document.querySelectorAll('.template-option').forEach(opt => opt.classList.remove('active'));
            }
        });
    });

    // مستمع اختيار القوالب
    document.querySelectorAll('.template-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.template-option').forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            const template = this.dataset.template;
            currentTemplate = template;
            
            // تطبيق إعدادات القالب
            switch(template) {
                case 'team1':
                    currentShirtColor = 'linear-gradient(45deg, #1e40af, #3b82f6)';
                    currentText = 'فريق النصر';
                    break;
                case 'team2':
                    currentShirtColor = 'linear-gradient(45deg, #dc2626, #ef4444)';
                    currentText = 'فريق الأهلي';
                    break;
                case 'team3':
                    currentShirtColor = 'linear-gradient(45deg, #059669, #10b981)';
                    currentText = 'فريق الاتحاد';
                    break;
            }
            
            // تحديث الحقول
            document.getElementById('designText').value = currentText;
            updateDesign();
        });
    });
    
    // مستمعي الألوان
    document.querySelectorAll('input[type="color"]').forEach(input => {
        input.addEventListener('change', function() {
            if (this.id.startsWith('textColor')) {
                currentTextColor = this.value;
            } else if (this.id.startsWith('shirtColor')) {
                currentShirtColor = this.value;
            }
            updateDesign();
        });
    });
    
    // مستمع الخط
    document.getElementById('fontFamily').addEventListener('change', function() {
        currentFontFamily = this.value;
        updateDesign();
    });
    
    // مستمع حجم الخط
    document.getElementById('fontSize').addEventListener('input', function() {
        currentFontSize = this.value;
        document.getElementById('fontSizeValue').textContent = this.value;
        updateDesign();
    });
    
    // حفظ التصميم
    function saveDesign() {
        const designData = {
            text: currentText,
            playerNumber: currentPlayerNumber,
            textColor: currentTextColor,
            shirtColor: currentShirtColor,
            fontFamily: currentFontFamily,
            fontSize: currentFontSize,
            template: currentTemplate
        };
        
        document.getElementById('designData').value = JSON.stringify(designData);
        
        const modal = new bootstrap.Modal(document.getElementById('saveDesignModal'));
        modal.show();
    }
    
    // إعادة تعيين التصميم
    function resetDesign() {
        currentText = 'اسم الفريق';
        currentPlayerNumber = '10';
        currentTextColor = '#ffffff';
        currentShirtColor = 'linear-gradient(135deg, #1e3a8a, #3b82f6)';
        currentFontFamily = 'Cairo';
        currentFontSize = 16;
        currentTemplate = null;
        
        document.getElementById('designText').value = '';
        document.getElementById('playerNumber').value = '';
        document.getElementById('fontSize').value = 16;
        document.getElementById('fontSizeValue').textContent = '16';
        document.getElementById('customDesign').checked = true;
        document.getElementById('templatesSection').style.display = 'none';
        document.querySelectorAll('.template-option').forEach(opt => opt.classList.remove('active'));
        
        updateDesign();
    }
    
    // تحميل التصميم
    function downloadDesign() {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        
        canvas.width = 400;
        canvas.height = 500;
        
        // رسم القميص
        ctx.fillStyle = currentShirtColor;
        ctx.fillRect(50, 100, 300, 350);
        
        // رسم النص
        ctx.fillStyle = currentTextColor;
        ctx.font = `${currentFontSize}px ${currentFontFamily}`;
        ctx.textAlign = 'center';
        ctx.fillText(currentText, 200, 300);
        
        // تحميل الصورة
        const link = document.createElement('a');
        link.download = 'design.png';
        link.href = canvas.toDataURL();
        link.click();
    }
    
    // تهيئة التصميم
    updateDesign();
</script>
@endsection
