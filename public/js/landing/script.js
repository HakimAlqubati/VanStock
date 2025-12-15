// Navbar scroll effect
window.addEventListener('scroll', function () {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 20) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// FAQ Toggle
document.querySelectorAll('.faq-question').forEach(function (question) {
    question.addEventListener('click', function () {
        const item = this.parentElement;
        const isActive = item.classList.contains('active');

        // Close all
        document.querySelectorAll('.faq-item').forEach(function (i) {
            i.classList.remove('active');
        });

        // Toggle current
        if (!isActive) {
            item.classList.add('active');
        }
    });
});

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
