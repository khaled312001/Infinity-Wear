/**
 * كرات القدم المتحركة في الخلفية
 * Football Background Animation
 */

class FootballAnimation {
    constructor() {
        this.container = null;
        this.footballs = [];
        this.isActive = false;
        this.animationSpeed = 1;
        this.maxFootballs = this.getMaxFootballsForDevice();
        this.colors = ['blue', 'green', 'red', 'purple', 'special', 'light'];
        this.sizes = ['small', 'medium', 'large'];
        this.animations = ['footballFloat', 'footballGravity', 'footballZigzag'];
        this.isMobile = this.detectMobile();
        
        this.init();
    }

    getMaxFootballsForDevice() {
        if (window.innerWidth <= 480) return 3;
        if (window.innerWidth <= 768) return 5;
        return 8;
    }

    detectMobile() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || window.innerWidth <= 768;
    }

    init() {
        this.createContainer();
        this.startAnimation();
        this.bindEvents();
    }

    createContainer() {
        // إنشاء حاوي الكرات
        this.container = document.createElement('div');
        this.container.className = 'football-background';
        this.container.id = 'football-background';
        document.body.appendChild(this.container);
    }

    createFootball() {
        const football = document.createElement('div');
        football.className = 'football';
        
        // إضافة خصائص عشوائية
        const color = this.colors[Math.floor(Math.random() * this.colors.length)];
        const size = this.sizes[Math.floor(Math.random() * this.sizes.length)];
        
        football.classList.add(color, size);
        
        // موضع البداية العشوائي
        const startX = Math.random() * window.innerWidth;
        football.style.left = startX + 'px';
        
        // سرعة الأنيميشن العشوائية (أسرع على الأجهزة المحمولة)
        const baseDuration = this.isMobile ? 4 : 6;
        const duration = (Math.random() * 3 + baseDuration) / this.animationSpeed;
        football.style.animationDuration = duration + 's';
        
        // تأخير عشوائي
        const delay = Math.random() * 2;
        football.style.animationDelay = '-' + delay + 's';
        
        // إضافة تأثيرات إضافية فقط على الأجهزة غير المحمولة
        if (!this.isMobile) {
            this.addSpecialEffects(football);
        }
        
        return football;
    }

    addSpecialEffects(football) {
        // تأثيرات خاصة للكرات
        const effects = [
            () => this.addTrailEffect(football),
            () => this.addSparkleEffect(football),
            () => this.addBounceEffect(football)
        ];
        
        const randomEffect = effects[Math.floor(Math.random() * effects.length)];
        randomEffect();
    }

    addTrailEffect(football) {
        football.style.filter = 'blur(1px)';
        football.addEventListener('animationstart', () => {
            football.style.filter = 'blur(0px)';
        });
    }

    addSparkleEffect(football) {
        const sparkle = document.createElement('div');
        sparkle.style.cssText = `
            position: absolute;
            width: 4px;
            height: 4px;
            background: white;
            border-radius: 50%;
            pointer-events: none;
            animation: sparkle 1s ease-in-out infinite;
        `;
        
        // إضافة CSS للـ sparkle
        if (!document.getElementById('sparkle-style')) {
            const style = document.createElement('style');
            style.id = 'sparkle-style';
            style.textContent = `
                @keyframes sparkle {
                    0%, 100% { opacity: 0; transform: scale(0); }
                    50% { opacity: 1; transform: scale(1); }
                }
            `;
            document.head.appendChild(style);
        }
        
        football.appendChild(sparkle);
    }

    addBounceEffect(football) {
        football.style.animationTimingFunction = 'cubic-bezier(0.25, 0.46, 0.45, 0.94)';
    }

    startAnimation() {
        if (this.isActive) return;
        
        this.isActive = true;
        this.animate();
    }

    stopAnimation() {
        this.isActive = false;
        this.clearFootballs();
    }

    animate() {
        if (!this.isActive) return;
        
        // إضافة كرة جديدة إذا كان العدد أقل من الحد الأقصى
        if (this.footballs.length < this.maxFootballs) {
            this.addFootball();
        }
        
        // تنظيف الكرات التي انتهت من الحركة
        this.cleanupFootballs();
        
        // الاستمرار في الأنيميشن
        requestAnimationFrame(() => this.animate());
    }

    addFootball() {
        const football = this.createFootball();
        this.container.appendChild(football);
        this.footballs.push(football);
        
        // إزالة الكرة بعد انتهاء الأنيميشن (أسرع على الأجهزة المحمولة)
        const maxDuration = this.isMobile ? 8000 : 12000;
        setTimeout(() => {
            this.removeFootball(football);
        }, maxDuration);
    }

    removeFootball(football) {
        if (football && football.parentNode) {
            football.parentNode.removeChild(football);
            const index = this.footballs.indexOf(football);
            if (index > -1) {
                this.footballs.splice(index, 1);
            }
        }
    }

    cleanupFootballs() {
        this.footballs = this.footballs.filter(football => {
            if (!football.parentNode) {
                return false;
            }
            
            const rect = football.getBoundingClientRect();
            return rect.top < window.innerHeight + 100; // إزالة الكرات التي خرجت من الشاشة
        });
    }

    clearFootballs() {
        this.footballs.forEach(football => {
            if (football.parentNode) {
                football.parentNode.removeChild(football);
            }
        });
        this.footballs = [];
    }

    setSpeed(speed) {
        this.animationSpeed = Math.max(0.5, Math.min(3, speed));
        this.footballs.forEach(football => {
            const currentDuration = parseFloat(football.style.animationDuration);
            football.style.animationDuration = (currentDuration / this.animationSpeed) + 's';
        });
    }

    setMaxFootballs(max) {
        this.maxFootballs = Math.max(1, Math.min(20, max));
        // تنظيف الكرات الزائدة إذا كان العدد الجديد أقل
        while (this.footballs.length > this.maxFootballs) {
            const football = this.footballs.shift();
            this.removeFootball(football);
        }
    }

    bindEvents() {
        // إيقاف/تشغيل الأنيميشن عند الضغط على مسافة
        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space') {
                e.preventDefault();
                if (this.isActive) {
                    this.stopAnimation();
                } else {
                    this.startAnimation();
                }
            }
        });

        // إيقاف الأنيميشن عند تقليل الأداء (فقط على الأجهزة غير المحمولة)
        if (!this.isMobile) {
            let lastTime = performance.now();
            let frameCount = 0;
            
            const checkPerformance = () => {
                frameCount++;
                const currentTime = performance.now();
                
                if (currentTime - lastTime >= 1000) {
                    const fps = frameCount;
                    frameCount = 0;
                    lastTime = currentTime;
                    
                    // إيقاف الأنيميشن إذا كان الأداء منخفض
                    if (fps < 30 && this.isActive) {
                        console.log('أداء منخفض، تقليل عدد الكرات');
                        this.setMaxFootballs(Math.max(2, this.maxFootballs - 2));
                    }
                }
                
                requestAnimationFrame(checkPerformance);
            };
            
            checkPerformance();
        }

        // تنظيف عند إغلاق الصفحة
        window.addEventListener('beforeunload', () => {
            this.stopAnimation();
        });

        // إعادة تشغيل عند تغيير حجم النافذة
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                this.maxFootballs = this.getMaxFootballsForDevice();
                this.isMobile = this.detectMobile();
                this.clearFootballs();
            }, 250);
        });
    }

    // دوال للتحكم من الخارج
    pause() {
        this.stopAnimation();
    }

    resume() {
        this.startAnimation();
    }

    destroy() {
        this.stopAnimation();
        if (this.container && this.container.parentNode) {
            this.container.parentNode.removeChild(this.container);
        }
    }
}

// تهيئة الأنيميشن عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', () => {
    // تأخير بسيط لضمان تحميل الصفحة بالكامل
    setTimeout(() => {
        window.footballAnimation = new FootballAnimation();
        
        // إضافة أزرار التحكم (اختياري)
        if (window.location.search.includes('debug=true')) {
            createControlPanel();
        }
    }, 1000);
});

// لوحة التحكم للتطوير
function createControlPanel() {
    const panel = document.createElement('div');
    panel.style.cssText = `
        position: fixed;
        top: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 15px;
        border-radius: 10px;
        z-index: 10000;
        font-family: Arial, sans-serif;
        font-size: 12px;
    `;
    
    panel.innerHTML = `
        <h4 style="margin: 0 0 10px 0;">تحكم الكرات</h4>
        <button onclick="window.footballAnimation.pause()">إيقاف</button>
        <button onclick="window.footballAnimation.resume()">تشغيل</button>
        <br><br>
        <label>السرعة: <input type="range" min="0.5" max="3" step="0.1" value="1" 
               onchange="window.footballAnimation.setSpeed(this.value)"></label>
        <br><br>
        <label>العدد الأقصى: <input type="range" min="1" max="20" step="1" value="8" 
               onchange="window.footballAnimation.setMaxFootballs(this.value)"></label>
    `;
    
    document.body.appendChild(panel);
}

// تصدير الكلاس للاستخدام الخارجي
if (typeof module !== 'undefined' && module.exports) {
    module.exports = FootballAnimation;
}
