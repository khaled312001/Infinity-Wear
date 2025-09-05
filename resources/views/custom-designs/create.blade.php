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
    
    .tshirt-template {
        width: 200px;
        height: 250px;
        background: #e5e7eb;
        border-radius: 20px;
        margin: 0 auto;
        position: relative;
        border: 3px solid #9ca3af;
    }
    
    .design-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: bold;
        text-align: center;
        word-wrap: break-word;
        max-width: 150px;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
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
                
                <!-- إدخال النص -->
                <div class="mb-4">
                    <label class="form-label">النص المطلوب</label>
                    <input type="text" id="designText" class="text-input" placeholder="أدخل النص هنا...">
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
                    <input type="range" class="form-range" min="12" max="48" value="24" id="fontSize">
                    <div class="text-center">
                        <span id="fontSizeValue">24</span> px
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
                <div class="tshirt-template" id="tshirtTemplate">
                    <div class="design-text" id="designTextPreview">
                        النص هنا
                    </div>
                </div>
                
                <!-- معلومات التصميم -->
                <div class="mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6>معلومات التصميم</h6>
                                    <p class="mb-1"><strong>النص:</strong> <span id="textInfo">النص هنا</span></p>
                                    <p class="mb-1"><strong>اللون:</strong> <span id="colorInfo">#1e3a8a</span></p>
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
    let currentText = 'النص هنا';
    let currentTextColor = '#1e3a8a';
    let currentShirtColor = '#ffffff';
    let currentFontFamily = 'Cairo';
    let currentFontSize = 24;
    
    // تحديث التصميم
    function updateDesign() {
        const textElement = document.getElementById('designTextPreview');
        const shirtElement = document.getElementById('tshirtTemplate');
        
        textElement.textContent = currentText;
        textElement.style.color = currentTextColor;
        textElement.style.fontFamily = currentFontFamily;
        textElement.style.fontSize = currentFontSize + 'px';
        shirtElement.style.backgroundColor = currentShirtColor;
        
        // تحديث المعلومات
        document.getElementById('textInfo').textContent = currentText;
        document.getElementById('colorInfo').textContent = currentTextColor;
        document.getElementById('fontInfo').textContent = currentFontFamily;
    }
    
    // إضافة مستمعي الأحداث
    document.getElementById('designText').addEventListener('input', function() {
        currentText = this.value || 'النص هنا';
        updateDesign();
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
            textColor: currentTextColor,
            shirtColor: currentShirtColor,
            fontFamily: currentFontFamily,
            fontSize: currentFontSize
        };
        
        document.getElementById('designData').value = JSON.stringify(designData);
        
        const modal = new bootstrap.Modal(document.getElementById('saveDesignModal'));
        modal.show();
    }
    
    // إعادة تعيين التصميم
    function resetDesign() {
        currentText = 'النص هنا';
        currentTextColor = '#1e3a8a';
        currentShirtColor = '#ffffff';
        currentFontFamily = 'Cairo';
        currentFontSize = 24;
        
        document.getElementById('designText').value = '';
        document.getElementById('fontSize').value = 24;
        document.getElementById('fontSizeValue').textContent = '24';
        
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
