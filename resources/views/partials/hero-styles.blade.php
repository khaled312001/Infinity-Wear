<style>
    /* Hero Slider Styles */
    .hero-slider {
        position: relative;
        height: 100vh;
        overflow: hidden;
    }

    .hero-slide {
        position: relative;
        height: 100vh;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(30, 58, 138, 0.8), rgba(59, 130, 246, 0.6));
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        max-width: 800px;
        padding: 2rem;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .hero-subtitle {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        opacity: 0.9;
    }

    .hero-description {
        font-size: 1.1rem;
        margin-bottom: 2rem;
        opacity: 0.8;
        line-height: 1.6;
    }

    .swiper-pagination-bullet {
        background: rgba(255, 255, 255, 0.5);
        width: 12px;
        height: 12px;
    }

    .swiper-pagination-bullet-active {
        background: #ffc107;
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: white;
        background: rgba(0, 0, 0, 0.3);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-top: -25px;
    }

    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 20px;
    }

    /* Dynamic Section Styles */
    .dynamic-section {
        padding: 5rem 0;
        position: relative;
    }

    .section-content-item {
        transition: all 0.3s ease;
        height: 100%;
    }

    .section-content-item:hover {
        transform: translateY(-5px);
    }

    .content-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        height: 100%;
        transition: all 0.3s ease;
    }

    .content-card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .content-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: white;
    }

    .content-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
        }
        
        .hero-description {
            font-size: 1rem;
        }
        
        .hero-slider {
            height: 70vh;
        }
        
        .hero-slide {
            height: 70vh;
        }
    }
</style>