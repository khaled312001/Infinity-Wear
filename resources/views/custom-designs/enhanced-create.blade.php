@extends('layouts.app')

@section('title', 'أداة التصميم المتقدمة - Infinity Wear')

@section('styles')
<style>
    .design-workspace {
        background: #f8fafc;
        border-radius: 15px;
        padding: 20px;
        min-height: 600px;
    }
    
    .design-canvas {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        min-height: 500px;
    }
    
    .design-tools-panel {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .tool-section {
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .tool-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }
    
    .color-palette {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .color-option {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .color-option:hover,
    .color-option.active {
        border-color: #1e40af;
        transform: scale(1.1);
    }
    
    .template-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 15px;
    }
    
    .template-option {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .template-option:hover,
    .template-option.active {
        border-color: #1e40af;
        background: #eff6ff;
    }
    
    .jersey-preview {
        width: 100%;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .jersey-template {
        width: 180px;
        height: 220px;
        background: #1e40af;
        border-radius: 15px;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }
    
    .jersey-template:hover {
        transform: scale(1.05);
    }
    
    .jersey-number {
        font-size: 42px;
        font-weight: bold;
        color: white;
        margin-bottom: 8px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .jersey-text {
        font-size: 14px;
        color: white;
        text-align: center;
        max-width: 140px;
        word-wrap: break-word;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }
    
    .jersey-logo {
        position: absolute;
        top: 15px;
        left: 50%;
        transform: translateX(-50%);
        width: 30px;
        height: 30px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="section-title">أداة التصميم المتقدمة</h1>
            <p class="lead">صمم زي موحد احترافي مع خيارات متقدمة</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="design-workspace">
                <div class="design-canvas">
                    <div class="jersey-preview">
                        <div class="jersey-template" id="jerseyTemplate">
                            <div class="jersey-logo" id="jerseyLogo">L</div>
                            <div class="jersey-number" id="jerseyNumber">10</div>
                            <div class="jersey-text" id="jerseyText">فريقك</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="design-tools-panel">
                <h5 class="mb-4">أدوات التصميم المتقدمة</h5>
                
                <!-- Template Selection -->
                <div class="tool-section">
                    <h6 class="mb-3">اختر القالب</h6>
                    <div class="template-grid">
                        <div class="template-option active" data-template="classic">
                            <div class="jersey-mini" style="width: 40px; height: 50px; background: #1e40af; border-radius: 8px; margin: 0 auto 5px;"></div>
                            <small>كلاسيكي</small>
                        </div>
                        <div class="template-option" data-template="modern">
                            <div class="jersey-mini" style="width: 40px; height: 50px; background: #dc2626; border-radius: 15px; margin: 0 auto 5px;"></div>
                            <small>حديث</small>
                        </div>
                        <div class="template-option" data-template="sporty">
                            <div class="jersey-mini" style="width: 40px; height: 50px; background: #059669; border-radius: 5px; margin: 0 auto 5px;"></div>
                            <small>رياضي</small>
                        </div>
                    </div>
                </div>
                
                <!-- Text Customization -->
                <div class="tool-section">
                    <h6 class="mb-3">تخصيص النص</h6>
                    <div class="mb-3">
                        <label class="form-label">النص</label>
                        <input type="text" class="form-control" id="textInput" placeholder="أدخل النص">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الرقم</label>
                        <input type="number" class="form-control" id="numberInput" min="1" max="99" value="10">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">حجم النص</label>
                        <input type="range" class="form-range" id="textSize" min="10" max="50" value="14">
                    </div>
                </div>
                
                <!-- Color Customization -->
                <div class="tool-section">
                    <h6 class="mb-3">ألوان القميص</h6>
                    <div class="color-palette">
                        <div class="color-option active" style="background: #1e40af;" data-color="#1e40af"></div>
                        <div class="color-option" style="background: #dc2626;" data-color="#dc2626"></div>
                        <div class="color-option" style="background: #059669;" data-color="#059669"></div>
                        <div class="color-option" style="background: #7c3aed;" data-color="#7c3aed"></div>
                        <div class="color-option" style="background: #f59e0b;" data-color="#f59e0b"></div>
                        <div class="color-option" style="background: #000000;" data-color="#000000"></div>
                        <div class="color-option" style="background: #ffffff; border: 1px solid #ccc;" data-color="#ffffff"></div>
                        <div class="color-option" style="background: #6b7280;" data-color="#6b7280"></div>
                    </div>
                </div>
                
                <!-- Text Color -->
                <div class="tool-section">
                    <h6 class="mb-3">لون النص</h6>
                    <div class="color-palette">
                        <div class="color-option active" style="background: #ffffff;" data-text-color="#ffffff"></div>
                        <div class="color-option" style="background: #000000;" data-text-color="#000000"></div>
                        <div class="color-option" style="background: #dc2626;" data-text-color="#dc2626"></div>
                        <div class="color-option" style="background: #fbbf24;" data-text-color="#fbbf24"></div>
                        <div class="color-option" style="background: #059669;" data-text-color="#059669"></div>
                        <div class="color-option" style="background: #7c3aed;" data-text-color="#7c3aed"></div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="tool-section">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary" onclick="saveDesign()">
                            <i class="fas fa-save me-2"></i>
                            حفظ التصميم
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="resetDesign()">
                            <i class="fas fa-undo me-2"></i>
                            إعادة تعيين
                        </button>
                        <button type="button" class="btn btn-outline-info" onclick="previewDesign()">
                            <i class="fas fa-eye me-2"></i>
                            معاينة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize design tools
    const textInput = document.getElementById('textInput');
    const numberInput = document.getElementById('numberInput');
    const textSize = document.getElementById('textSize');
    
    const jerseyTemplate = document.getElementById('jerseyTemplate');
    const jerseyNumber = document.getElementById('jerseyNumber');
    const jerseyText = document.getElementById('jerseyText');
    
    // Update jersey when inputs change
    textInput.addEventListener('input', function() {
        jerseyText.textContent = this.value || 'فريقك';
    });
    
    numberInput.addEventListener('input', function() {
        jerseyNumber.textContent = this.value;
    });
    
    textSize.addEventListener('input', function() {
        jerseyText.style.fontSize = this.value + 'px';
    });
    
    // Template selection
    document.querySelectorAll('.template-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.template-option').forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            const template = this.dataset.template;
            updateTemplate(template);
        });
    });
    
    // Color selection
    document.querySelectorAll('.color-option[data-color]').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.color-option[data-color]').forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            jerseyTemplate.style.background = this.dataset.color;
        });
    });
    
    // Text color selection
    document.querySelectorAll('.color-option[data-text-color]').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.color-option[data-text-color]').forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            
            jerseyNumber.style.color = this.dataset.textColor;
            jerseyText.style.color = this.dataset.textColor;
        });
    });
});

function updateTemplate(template) {
    const jerseyTemplate = document.getElementById('jerseyTemplate');
    
    switch(template) {
        case 'classic':
            jerseyTemplate.style.borderRadius = '15px';
            break;
        case 'modern':
            jerseyTemplate.style.borderRadius = '20px';
            break;
        case 'sporty':
            jerseyTemplate.style.borderRadius = '8px';
            break;
    }
}

function saveDesign() {
    // Here you would typically save the design to the server
    alert('تم حفظ التصميم المتقدم بنجاح!');
}

function resetDesign() {
    // Reset all inputs
    document.getElementById('textInput').value = '';
    document.getElementById('numberInput').value = '10';
    document.getElementById('textSize').value = '14';
    
    // Reset colors
    document.querySelectorAll('.color-option[data-color]').forEach(opt => opt.classList.remove('active'));
    document.querySelector('.color-option[data-color="#1e40af"]').classList.add('active');
    
    document.querySelectorAll('.color-option[data-text-color]').forEach(opt => opt.classList.remove('active'));
    document.querySelector('.color-option[data-text-color="#ffffff"]').classList.add('active');
    
    // Reset template
    document.querySelectorAll('.template-option').forEach(opt => opt.classList.remove('active'));
    document.querySelector('.template-option[data-template="classic"]').classList.add('active');
    
    // Reset the jersey
    const jerseyTemplate = document.getElementById('jerseyTemplate');
    const jerseyNumber = document.getElementById('jerseyNumber');
    const jerseyText = document.getElementById('jerseyText');
    
    jerseyTemplate.style.background = '#1e40af';
    jerseyTemplate.style.borderRadius = '15px';
    jerseyNumber.textContent = '10';
    jerseyNumber.style.color = '#ffffff';
    jerseyText.textContent = 'فريقك';
    jerseyText.style.color = '#ffffff';
    jerseyText.style.fontSize = '14px';
}

function previewDesign() {
    // Here you would typically show a preview modal
    alert('معاينة التصميم - سيتم إضافة هذه الميزة قريباً!');
}
</script>
@endsection