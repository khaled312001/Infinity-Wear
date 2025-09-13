<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<style>
/* Hero Slider Styles */
.hero-slider {
    position: relative;
    height: 100vh;
    overflow: hidden;
}

.hero-swiper {
    height: 100%;
}

.hero-slide {
    position: relative;
    height: 100vh;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-subtitle {
    font-size: 1.2rem;
    font-weight: 500;
    margin-bottom: 1rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.hero-title {
    font-size: 4rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.hero-description {
    font-size: 1.3rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.hero-buttons {
    margin-top: 2rem;
}

.hero-btn {
    padding: 15px 35px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 50px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.hero-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}

.hero-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.hero-btn:hover::before {
    left: 100%;
}

/* Decorative Elements */
.hero-decorations {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
}

.decoration-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 6s ease-in-out infinite;
}

.circle-1 {
    width: 200px;
    height: 200px;
    top: 20%;
    right: 10%;
    animation-delay: 0s;
}

.circle-2 {
    width: 150px;
    height: 150px;
    bottom: 30%;
    left: 15%;
    animation-delay: 2s;
}

.circle-3 {
    width: 100px;
    height: 100px;
    top: 60%;
    right: 25%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

/* Scroll Indicator */
.scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    z-index: 2;
    animation: bounce 2s infinite;
}

.scroll-mouse {
    width: 24px;
    height: 40px;
    border: 2px solid rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    position: relative;
    margin: 0 auto 10px;
}

.scroll-wheel {
    width: 4px;
    height: 8px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 2px;
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    animation: scroll 2s infinite;
}

.scroll-text {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
}

@keyframes scroll {
    0% { transform: translateX(-50%) translateY(0); opacity: 1; }
    100% { transform: translateX(-50%) translateY(16px); opacity: 0; }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
    40% { transform: translateX(-50%) translateY(-10px); }
    60% { transform: translateX(-50%) translateY(-5px); }
}

/* Swiper Navigation */
.swiper-button-next,
.swiper-button-prev {
    color: rgba(255, 255, 255, 0.8);
    background: rgba(255, 255, 255, 0.1);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

.swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 18px;
}

.swiper-pagination-bullet {
    background: rgba(255, 255, 255, 0.5);
    opacity: 1;
    transition: all 0.3s ease;
}

.swiper-pagination-bullet-active {
    background: white;
    transform: scale(1.2);
}

/* Section Styles */
.home-section {
    padding: 100px 0;
    position: relative;
    overflow: hidden;
}

.section-features .home-section {
    background: linear-gradient(135deg, var(--primary-color), var(--dark-blue));
    color: white;
}

.section-features .icon-wrapper {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #ffc107;
    transition: all 0.3s ease;
}

.section-features .icon-content:hover .icon-wrapper {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

.stat-label {
    color: rgba(255, 255, 255, 0.9);
    font-weight: 600;
    margin-bottom: 10px;
}

.stat-description {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    margin: 0;
}

.section-header {
    margin-bottom: 80px;
}

.section-subtitle {
    font-size: 1rem;
    color: var(--primary-color);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 1rem;
}

.section-title {
    font-size: 3rem;
    font-weight: 800;
    color: #333;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.section-description {
    font-size: 1.2rem;
    color: #666;
    max-width: 600px;
    margin: 0 auto 2rem;
    line-height: 1.6;
}

.section-divider {
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    margin: 0 auto;
    border-radius: 2px;
    transform: scaleX(0);
    transition: transform 0.8s ease;
}

.section-divider.animate {
    transform: scaleX(1);
}

/* Feature Cards */
.feature-card {
    background: white;
    border-radius: 20px;
    padding: 40px 30px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.feature-card:hover::before {
    opacity: 0.95;
}

.feature-card:hover .card-content {
    color: white;
    position: relative;
    z-index: 2;
}

.card-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 30px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    transition: all 0.3s ease;
}

.feature-card:hover .card-icon {
    background: rgba(255, 255, 255, 0.2);
    transform: scale(1.1);
}

.card-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: #333;
    transition: color 0.3s ease;
}

.card-description {
    color: #666;
    line-height: 1.6;
    transition: color 0.3s ease;
}

/* Portfolio Items */
.portfolio-item {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.portfolio-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.portfolio-item img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.portfolio-item:hover img {
    transform: scale(1.05);
}

.portfolio-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: white;
    padding: 30px 20px 20px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.portfolio-item:hover .portfolio-overlay {
    transform: translateY(0);
}

/* About Features */
.about-features {
    margin: 30px 0;
}

.feature-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    font-size: 1.1rem;
}

.feature-item i {
    color: var(--primary-color);
    margin-left: 15px;
    font-size: 1.2rem;
}

/* Animations */
.animate-on-scroll {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.8s ease;
}

.animate-on-scroll.animate {
    opacity: 1;
    transform: translateY(0);
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-description {
        font-size: 1.1rem;
    }
    
    .section-title {
        font-size: 2.2rem;
    }
    
    .hero-btn {
        padding: 12px 25px;
        font-size: 1rem;
    }
    
    .feature-card {
        padding: 30px 20px;
    }
    
    .circle-1, .circle-2, .circle-3 {
        display: none;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .hero-buttons .btn {
        display: block;
        width: 100%;
        margin-bottom: 15px;
    }
    
    .hero-buttons .btn:last-child {
        margin-bottom: 0;
    }
}
</style>