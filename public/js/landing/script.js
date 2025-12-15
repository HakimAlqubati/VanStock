// Navbar scroll effect - Hide on scroll down, show on scroll up
(function () {
    const navbar = document.getElementById('navbar');
    const scrollTopBtn = document.querySelector('.scroll-top-btn');
    let lastScrollY = window.scrollY;
    let ticking = false;
    const scrollThreshold = 100; // Start hiding after scrolling 100px
    const scrollTopThreshold = 300; // Show scroll-to-top after 300px

    function updateNavbar() {
        const currentScrollY = window.scrollY;

        // Add scrolled class for background effect
        if (currentScrollY > 20) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }

        // Hide/show based on scroll direction (only if mobile menu is closed)
        const navMenu = document.getElementById('navMenu');
        if (!navMenu || !navMenu.classList.contains('active')) {
            if (currentScrollY > scrollThreshold) {
                if (currentScrollY > lastScrollY) {
                    // Scrolling down - hide navbar
                    navbar.classList.add('navbar-hidden');
                    navbar.classList.remove('navbar-visible');
                } else {
                    // Scrolling up - show navbar
                    navbar.classList.remove('navbar-hidden');
                    navbar.classList.add('navbar-visible');
                }
            } else {
                // Near top - always show
                navbar.classList.remove('navbar-hidden');
                navbar.classList.remove('navbar-visible');
            }
        }

        // Show/hide scroll-to-top button
        if (scrollTopBtn) {
            if (currentScrollY > scrollTopThreshold) {
                scrollTopBtn.classList.add('visible');
            } else {
                scrollTopBtn.classList.remove('visible');
            }
        }

        lastScrollY = currentScrollY;
        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) {
            window.requestAnimationFrame(function () {
                updateNavbar();
            });
            ticking = true;
        }
    });
})();

// Scroll to Top Function
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Mobile Navigation Menu Toggle
(function () {
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    const navOverlay = document.getElementById('navOverlay');
    const navLinks = document.querySelectorAll('.nav-links a');
    const body = document.body;

    if (!navToggle || !navMenu) return;

    // Toggle menu function
    function toggleMenu() {
        const isActive = navMenu.classList.contains('active');

        navToggle.classList.toggle('active');
        navMenu.classList.toggle('active');
        navOverlay?.classList.toggle('active');

        // Update aria-expanded
        navToggle.setAttribute('aria-expanded', !isActive);

        // Prevent body scroll when menu is open
        if (!isActive) {
            body.style.overflow = 'hidden';
        } else {
            body.style.overflow = '';
        }
    }

    // Close menu function
    function closeMenu() {
        navToggle.classList.remove('active');
        navMenu.classList.remove('active');
        navOverlay?.classList.remove('active');
        navToggle.setAttribute('aria-expanded', 'false');
        body.style.overflow = '';
    }

    // Toggle button click
    navToggle.addEventListener('click', function (e) {
        e.stopPropagation();
        toggleMenu();
    });

    // Close on overlay click
    navOverlay?.addEventListener('click', closeMenu);

    // Close on nav link click
    navLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            // Small delay for smooth transition
            setTimeout(closeMenu, 150);
        });
    });

    // Close on ESC key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && navMenu.classList.contains('active')) {
            closeMenu();
        }
    });

    // Close menu on window resize (if switching to desktop)
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768 && navMenu.classList.contains('active')) {
            closeMenu();
        }
    });
})();




// FAQ Toggle
function toggleFaq(question) {
    const item = question.parentElement;
    const isOpen = item.classList.contains('is-open');

    // Close all
    document.querySelectorAll('.faq-item').forEach(function (i) {
        i.classList.remove('is-open');
    });

    // Toggle current
    if (!isOpen) {
        item.classList.add('is-open');
    }
}

// Scroll Reveal Animation
function reveal() {
    var reveals = document.querySelectorAll(".reveal");
    for (var i = 0; i < reveals.length; i++) {
        var windowHeight = window.innerHeight;
        var elementTop = reveals[i].getBoundingClientRect().top;
        var elementVisible = 100;
        if (elementTop < windowHeight - elementVisible) {
            reveals[i].classList.add("active");
        }
    }
}
window.addEventListener("scroll", reveal);
reveal();

// Timeline Slider
document.addEventListener('DOMContentLoaded', function () {
    const track = document.getElementById('timelineTrack');
    if (!track) return;

    const steps = document.querySelectorAll('.timeline-step');
    const dots = document.querySelectorAll('.slider-dot');
    let currentIndex = 0;
    const totalSteps = steps.length;
    let autoSlideInterval;

    function updateSlider() {
        const stepWidth = steps[0].offsetWidth + 32; // width + gap (2rem = 32px)
        const isRtl = document.documentElement.dir === 'rtl';

        // Calculate visible items based on screen width
        let visibleItems = 3;
        if (window.innerWidth <= 600) visibleItems = 1;
        else if (window.innerWidth <= 900) visibleItems = 2;

        // Adjust max index
        const maxIndex = totalSteps - visibleItems;
        if (currentIndex > maxIndex) currentIndex = 0;

        const translateX = currentIndex * stepWidth;

        if (isRtl) {
            track.style.transform = `translateX(${translateX}px)`;
        } else {
            track.style.transform = `translateX(-${translateX}px)`;
        }

        // Update active classes
        steps.forEach((step, idx) => {
            // Mark center item as active if 3 visible, or first if 1 visible
            const activeOffset = visibleItems === 3 ? 1 : 0;
            if (idx === currentIndex + activeOffset) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });

        // Update dots
        dots.forEach((dot, idx) => {
            if (idx === currentIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    // Auto slide function
    function startAutoSlide() {
        autoSlideInterval = setInterval(() => {
            currentIndex++;
            updateSlider();
        }, 3000);
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    // Manual Navigation
    window.goToSlide = function (index) {
        currentIndex = index;
        updateSlider();
        stopAutoSlide();
        startAutoSlide(); // Restart timer
    };

    // Initialize
    updateSlider();
    startAutoSlide();

    // Pause on hover
    track.addEventListener('mouseenter', stopAutoSlide);
    track.addEventListener('mouseleave', startAutoSlide);

    // Resize handler
    window.addEventListener('resize', updateSlider);
});
