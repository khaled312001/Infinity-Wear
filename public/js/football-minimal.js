// كرات القدم المتحركة - نسخة مبسطة جداً
console.log('بدء تحميل كرات القدم...');

// انتظار تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM محمل، بدء إنشاء الكرات...');
    createFootballBackground();
});

function createFootballBackground() {
    // إنشاء حاوي الكرات
    let container = document.getElementById('football-background');
    if (!container) {
        container = document.createElement('div');
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
    }
    
    // إنشاء كرة
    function createFootball() {
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
        
        return football;
    }
    
    // إضافة كرة
    function addFootball() {
        const football = createFootball();
        container.appendChild(football);
        console.log('تم إضافة كرة');
        
        // تحريك الكرة
        setTimeout(() => {
            football.style.top = '-100px';
            football.style.left = (parseInt(football.style.left) + 100) + 'px';
            football.style.transform = 'rotate(360deg)';
            football.style.transition = 'all 8s linear';
        }, 100);
        
        // إزالة الكرة بعد 8 ثوان
        setTimeout(() => {
            if (football.parentNode) {
                football.parentNode.removeChild(football);
                console.log('تم إزالة كرة');
            }
        }, 8000);
    }
    
    // إضافة كرات أولية
    for (let i = 0; i < 3; i++) {
        setTimeout(() => {
            addFootball();
        }, i * 1000);
    }
    
    // إضافة كرات كل 3 ثوان
    setInterval(() => {
        addFootball();
    }, 3000);
    
    console.log('تم تشغيل كرات القدم بنجاح!');
}
