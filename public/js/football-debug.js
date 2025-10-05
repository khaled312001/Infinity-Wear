// كرات القدم المتحركة - نسخة تشخيصية
console.log('بدء تحميل ملف كرات القدم...');

// انتظار تحميل الصفحة
window.addEventListener('load', function() {
    console.log('تم تحميل الصفحة بالكامل');
    initFootballAnimation();
});

function initFootballAnimation() {
    console.log('بدء تهيئة كرات القدم...');
    
    // إنشاء حاوي الكرات
    let container = document.getElementById('football-background');
    if (!container) {
        container = document.createElement('div');
        container.className = 'football-background';
        container.id = 'football-background';
        container.style.cssText = `
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            pointer-events: none !important;
            z-index: -1 !important;
            overflow: hidden !important;
            background: transparent !important;
        `;
        document.body.appendChild(container);
        console.log('تم إنشاء حاوي الكرات');
    } else {
        console.log('حاوي الكرات موجود بالفعل');
    }
    
    // إنشاء كرة تجريبية
    function createTestFootball() {
        const football = document.createElement('div');
        football.style.cssText = `
            position: absolute !important;
            width: 60px !important;
            height: 60px !important;
            background: radial-gradient(circle at 30% 30%, #ff0000, #cc0000) !important;
            border-radius: 50% !important;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.5) !important;
            opacity: 0.9 !important;
            display: block !important;
            visibility: visible !important;
            border: 2px solid white !important;
        `;
        
        // موضع البداية
        const startX = Math.random() * (window.innerWidth - 60);
        football.style.left = startX + 'px';
        football.style.top = '100vh';
        
        // أنيميشن بسيط
        football.style.transition = 'all 8s linear';
        
        return football;
    }
    
    // إضافة كرة تجريبية
    function addTestFootball() {
        const football = createTestFootball();
        container.appendChild(football);
        console.log('تم إضافة كرة تجريبية حمراء');
        
        // تحريك الكرة
        setTimeout(() => {
            football.style.top = '-100px';
            football.style.left = (parseInt(football.style.left) + 100) + 'px';
            football.style.transform = 'rotate(360deg)';
        }, 100);
        
        // إزالة الكرة بعد 8 ثوان
        setTimeout(() => {
            if (football.parentNode) {
                football.parentNode.removeChild(football);
                console.log('تم إزالة الكرة التجريبية');
            }
        }, 8000);
    }
    
    // إضافة كرة فورية
    addTestFootball();
    
    // إضافة كرات كل 3 ثوان
    setInterval(() => {
        addTestFootball();
    }, 3000);
    
    console.log('تم تشغيل كرات القدم بنجاح!');
}

// إضافة كود إضافي للتشخيص
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM محمل');
    
    // فحص وجود ملف CSS
    const cssLink = document.querySelector('link[href*="football-animation.css"]');
    if (cssLink) {
        console.log('ملف CSS للكرات موجود');
    } else {
        console.log('ملف CSS للكرات غير موجود');
    }
    
    // فحص وجود ملف JS
    const jsScript = document.querySelector('script[src*="football-simple.js"]');
    if (jsScript) {
        console.log('ملف JS للكرات موجود');
    } else {
        console.log('ملف JS للكرات غير موجود');
    }
});
