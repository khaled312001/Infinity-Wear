<?php $__env->startSection('title', 'صمم زي موحد - Infinity Wear'); ?>

<?php $__env->startSection('styles'); ?>
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
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="section-title">أداة التصميم البسيطة</h1>
            <p class="lead">صمم زي موحد مخصص بسهولة</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="design-preview">
                <div class="jersey-preview">
                    <div class="jersey-template" id="jerseyTemplate">
                        <div class="jersey-front">
                            <div class="jersey-number" id="jerseyNumber">10</div>
                            <div class="jersey-text" id="jerseyText">فريقك</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="design-tools">
                <h5 class="mb-4">أدوات التصميم</h5>
                
                <form id="designForm">
                    <div class="mb-4">
                        <label class="form-label">النص</label>
                        <input type="text" class="form-control" id="textInput" placeholder="أدخل النص">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">الرقم</label>
                        <input type="number" class="form-control" id="numberInput" min="1" max="99" value="10">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">لون القميص</label>
                        <div class="d-flex flex-wrap">
                            <input type="color" class="color-picker" value="#1e40af" id="jerseyColor">
                            <input type="color" class="color-picker" value="#dc2626" id="jerseyColor2">
                            <input type="color" class="color-picker" value="#059669" id="jerseyColor3">
                            <input type="color" class="color-picker" value="#7c3aed" id="jerseyColor4">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">لون النص</label>
                        <div class="d-flex flex-wrap">
                            <input type="color" class="color-picker" value="#ffffff" id="textColor">
                            <input type="color" class="color-picker" value="#000000" id="textColor2">
                            <input type="color" class="color-picker" value="#dc2626" id="textColor3">
                            <input type="color" class="color-picker" value="#059669" id="textColor4">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">حجم النص</label>
                        <input type="range" class="form-range" id="textSize" min="12" max="48" value="24">
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-primary" onclick="saveDesign()">
                            <i class="fas fa-save me-2"></i>
                            حفظ التصميم
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="resetDesign()">
                            <i class="fas fa-undo me-2"></i>
                            إعادة تعيين
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.jersey-template {
    width: 200px;
    height: 250px;
    background: #1e40af;
    border-radius: 20px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.jersey-front {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: relative;
}

.jersey-number {
    font-size: 48px;
    font-weight: bold;
    color: white;
    margin-bottom: 10px;
}

.jersey-text {
    font-size: 16px;
    color: white;
    text-align: center;
    max-width: 150px;
    word-wrap: break-word;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize design tools
    const textInput = document.getElementById('textInput');
    const numberInput = document.getElementById('numberInput');
    const jerseyColor = document.getElementById('jerseyColor');
    const textColor = document.getElementById('textColor');
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
    
    jerseyColor.addEventListener('change', function() {
        jerseyTemplate.style.background = this.value;
    });
    
    textColor.addEventListener('change', function() {
        jerseyNumber.style.color = this.value;
        jerseyText.style.color = this.value;
    });
    
    textSize.addEventListener('input', function() {
        jerseyText.style.fontSize = this.value + 'px';
    });
    
    // Color picker shortcuts
    document.querySelectorAll('.color-picker').forEach(picker => {
        picker.addEventListener('change', function() {
            if (this.id.includes('jerseyColor')) {
                jerseyTemplate.style.background = this.value;
            } else if (this.id.includes('textColor')) {
                jerseyNumber.style.color = this.value;
                jerseyText.style.color = this.value;
            }
        });
    });
});

function saveDesign() {
    // Here you would typically save the design to the server
    alert('تم حفظ التصميم بنجاح!');
}

function resetDesign() {
    document.getElementById('textInput').value = '';
    document.getElementById('numberInput').value = '10';
    document.getElementById('jerseyColor').value = '#1e40af';
    document.getElementById('textColor').value = '#ffffff';
    document.getElementById('textSize').value = '24';
    
    // Reset the jersey
    const jerseyTemplate = document.getElementById('jerseyTemplate');
    const jerseyNumber = document.getElementById('jerseyNumber');
    const jerseyText = document.getElementById('jerseyText');
    
    jerseyTemplate.style.background = '#1e40af';
    jerseyNumber.textContent = '10';
    jerseyNumber.style.color = '#ffffff';
    jerseyText.textContent = 'فريقك';
    jerseyText.style.color = '#ffffff';
    jerseyText.style.fontSize = '24px';
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\custom-designs\create.blade.php ENDPATH**/ ?>