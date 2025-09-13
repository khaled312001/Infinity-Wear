// Enhanced Hero Section JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize reveal on scroll elements
    initRevealOnScroll();
    
    // Initialize scroll indicator functionality
    initScrollIndicator();
    
    // Initialize AOS library if available
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    }
});

// Function to handle reveal on scroll animations
function initRevealOnScroll() {
    const revealElements = document.querySelectorAll('.reveal, .reveal-stagger');
    const revealFadeElements = document.querySelectorAll('.reveal-fade-up');
    const revealStaggerContainers = document.querySelectorAll('.reveal-stagger');
    
    if (revealElements.length === 0 && revealFadeElements.length === 0 && revealStaggerContainers.length === 0) return;
    
    // Mark elements in viewport on load
    checkRevealElements();
    
    // Check elements on scroll
    window.addEventListener('scroll', checkRevealElements);
    
    // Add resize event listener to handle orientation changes
    window.addEventListener('resize', checkRevealElements);
    
    function checkRevealElements() {
        const windowHeight = window.innerHeight;
        const windowTop = window.scrollY;
        const windowBottom = windowTop + windowHeight;
        
        // Handle main reveal elements
        revealElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top + windowTop;
            const elementVisible = 150; // Pixels from bottom of viewport to trigger animation
            
            if (elementTop < windowBottom - elementVisible) {
                element.classList.add('is-visible');
            }
        });
        
        // Handle fade up elements
        revealFadeElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top + windowTop;
            const elementVisible = 150;
            
            if (elementTop < windowBottom - elementVisible) {
                element.classList.add('is-visible');
            }
        });
        
        // Handle staggered children elements
        revealStaggerContainers.forEach(container => {
            const containerTop = container.getBoundingClientRect().top + windowTop;
            const elementVisible = 150;
            
            if (containerTop < windowBottom - elementVisible && !container.classList.contains('stagger-animated')) {
                container.classList.add('stagger-animated');
                const children = container.children;
                Array.from(children).forEach((child, index) => {
                    setTimeout(() => {
                        child.classList.add('is-visible');
                    }, index * 100);
                });
            }
        });
    }
}

// Function to handle scroll indicator
function initScrollIndicator() {
    const scrollIndicator = document.querySelector('.scroll-indicator');
    
    if (!scrollIndicator) return;
    
    // Scroll to next section when clicked
    scrollIndicator.addEventListener('click', function() {
        const heroSection = document.querySelector('.hero-section');
        const nextSection = heroSection.nextElementSibling;
        
        if (nextSection) {
            window.scrollTo({
                top: nextSection.offsetTop,
                behavior: 'smooth'
            });
        }
    });
    
    // Hide scroll indicator when scrolled past hero section
    window.addEventListener('scroll', function() {
        const heroSection = document.querySelector('.hero-section');
        const heroBottom = heroSection.offsetTop + heroSection.offsetHeight;
        
        if (window.scrollY > heroBottom - window.innerHeight / 2) {
            scrollIndicator.style.opacity = '0';
        } else {
            scrollIndicator.style.opacity = '0.7';
        }
    });
}