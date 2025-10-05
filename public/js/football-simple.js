// كرات القدم المتحركة - نسخة مبسطة
document.addEventListener('DOMContentLoaded', function() {
    console.log('بدء تحميل كرات القدم المتحركة...');
    
    // التأكد من عدم وجود حاوي مسبق
    let container = document.getElementById('football-background');
    if (!container) {
        container = document.createElement('div');
        container.className = 'football-background';
        container.id = 'football-background';
        document.body.appendChild(container);
        console.log('تم إنشاء حاوي الكرات');
    } else {
        console.log('حاوي الكرات موجود بالفعل');
    }
    
    // إنشاء كرة واحدة للتجربة
    function createFootball() {
        const football = document.createElement('div');
        football.className = 'football';
        
        // إضافة لون عشوائي
        const colors = ['blue', 'green', 'red', 'purple', 'special', 'light'];
        const color = colors[Math.floor(Math.random() * colors.length)];
        football.classList.add(color);
        
        // إضافة حجم عشوائي
        const sizes = ['small', 'medium', 'large'];
        const size = sizes[Math.floor(Math.random() * sizes.length)];
        football.classList.add(size);
        
        // موضع البداية العشوائي
        const startX = Math.random() * window.innerWidth;
        football.style.left = startX + 'px';
        
        // سرعة الأنيميشن العشوائية
        const duration = Math.random() * 4 + 6; // 6-10 ثوان
        football.style.animationDuration = duration + 's';
        
        // تأخير عشوائي
        const delay = Math.random() * 2;
        football.style.animationDelay = '-' + delay + 's';
        
        return football;
    }
    
    // إضافة كرات متعددة
    function addFootballs() {
        const maxFootballs = window.innerWidth <= 768 ? 5 : 8;
        
        for (let i = 0; i < maxFootballs; i++) {
            setTimeout(() => {
                const football = createFootball();
                container.appendChild(football);
                console.log('تم إضافة كرة رقم', i + 1);
                
                // إزالة الكرة بعد انتهاء الأنيميشن
                setTimeout(() => {
                    if (football.parentNode) {
                        football.parentNode.removeChild(football);
                    }
                }, 12000);
            }, i * 1000); // تأخير بين كل كرة
        }
    }
    
    // بدء الأنيميشن
    addFootballs();
    
    // إضافة كرات جديدة كل 3 ثوان
    setInterval(() => {
        if (container.children.length < 8) {
            const football = createFootball();
            container.appendChild(football);
            console.log('تم إضافة كرة جديدة، العدد الحالي:', container.children.length);
            
            setTimeout(() => {
                if (football.parentNode) {
                    football.parentNode.removeChild(football);
                    console.log('تم إزالة كرة، العدد الحالي:', container.children.length);
                }
            }, 12000);
        }
    }, 3000);
    
    // إضافة كرة فورية للتجربة
    setTimeout(() => {
        const testFootball = createFootball();
        testFootball.style.background = 'red';
        testFootball.style.border = '2px solid white';
        container.appendChild(testFootball);
        console.log('تم إضافة كرة تجريبية حمراء');
        
        setTimeout(() => {
            if (testFootball.parentNode) {
                testFootball.parentNode.removeChild(testFootball);
                console.log('تم إزالة الكرة التجريبية');
            }
        }, 5000);
    }, 1000);
    
    console.log('تم تشغيل كرات القدم المتحركة بنجاح!');
    console.log('عدد الكرات الحالي:', container.children.length);
});
