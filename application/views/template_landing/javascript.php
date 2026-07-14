<!-- JavaScript -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
// Initialize AOS Animation Library
AOS.init({
    duration: 1000,
    once: true,
    offset: 50,
});

// NAVBAR SCROLL EFFECT
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// MOBILE MENU LOGIC
const menuBtn = document.getElementById('menuBtn');
const mobileMenu = document.getElementById('mobileMenu');
const closeMenu = document.getElementById('closeMenu');

// Toggle open
menuBtn.addEventListener('click', () => {
    mobileMenu.classList.add('active');
    mobileMenu.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden'; // Prevent scrolling behind menu
});

// Toggle close
closeMenu.addEventListener('click', () => {
    mobileMenu.classList.remove('active');
    mobileMenu.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
});

// Auto close menu when a link is clicked
document.querySelectorAll('.mobile-link').forEach(link => {
    link.addEventListener('click', () => {
        mobileMenu.classList.remove('active');
        mobileMenu.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    });
});

// HERO IMAGE SLIDER LOGIC
const heroTrack = document.getElementById('heroTrack');
const dots = document.querySelectorAll('.dot');
let heroIndex = 0;
const slideCount = dots.length;

function updateHero() {
    heroTrack.style.transform = `translateX(-${heroIndex * 100}%)`;
    dots.forEach(dot => dot.classList.remove('active'));
    dots[heroIndex].classList.add('active');
}

function nextSlide() {
    heroIndex = (heroIndex + 1) % slideCount;
    updateHero();
}

function prevSlide() {
    heroIndex = (heroIndex - 1 + slideCount) % slideCount;
    updateHero();
}

// Auto slide interval
let sliderInterval = setInterval(nextSlide, 4000);

// Pagination dot click
dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        heroIndex = index;
        updateHero();
        // Reset timer on manual click
        clearInterval(sliderInterval);
        sliderInterval = setInterval(nextSlide, 4000);
    });
});

// TOUCH SWIPE SUPPORT FOR SLIDER (Mobile friendly)
let touchStartX = 0;
let touchEndX = 0;

heroTrack.addEventListener('touchstart', e => {
    touchStartX = e.changedTouches[0].screenX;
    clearInterval(sliderInterval); // Pause auto slide while touching
}, {
    passive: true
});

heroTrack.addEventListener('touchend', e => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
    sliderInterval = setInterval(nextSlide, 4000); // Resume auto slide
}, {
    passive: true
});

function handleSwipe() {
    const swipeThreshold = 50;
    if (touchEndX < touchStartX - swipeThreshold) {
        // Swiped left
        nextSlide();
    }
    if (touchEndX > touchStartX + swipeThreshold) {
        // Swiped right
        prevSlide();
    }
}
</script><!-- build:js assets/vendor/js/core.js -->