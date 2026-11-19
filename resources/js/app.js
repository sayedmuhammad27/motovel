import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Scroll Reveal Animations with IntersectionObserver
    const revealElements = document.querySelectorAll('.reveal-on-scroll');
    if ('IntersectionObserver' in window && revealElements.length > 0) {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-revealed');
                    obs.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        });

        revealElements.forEach(el => observer.observe(el));
    } else {
        revealElements.forEach(el => el.classList.add('is-revealed'));
    }

    // 2. Navbar Background Transition on Scroll
    const mainNav = document.getElementById('main-nav');
    if (mainNav) {
        const handleScroll = () => {
            if (window.scrollY > 40) {
                mainNav.classList.add('bg-[#08090B]/95', 'backdrop-blur-md', 'border-b', 'border-[#303137]/80', 'py-3.5', 'shadow-2xl');
                mainNav.classList.remove('bg-transparent', 'py-6');
            } else {
                mainNav.classList.remove('bg-[#08090B]/95', 'backdrop-blur-md', 'border-b', 'border-[#303137]/80', 'py-3.5', 'shadow-2xl');
                mainNav.classList.add('bg-transparent', 'py-6');
            }
        };

        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();
    }

    // 3. Mobile Menu Toggle with Accessibility Support (R-32)
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
            mobileMenuBtn.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('hidden');
        });

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
                mobileMenuBtn.focus();
            }
        });
    }

    // 4. Back to Top Button
    const backToTopBtn = document.getElementById('back-to-top');
    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // 5. Toast / Flash Alert Auto Dismiss
    const flashAlerts = document.querySelectorAll('.flash-alert');
    flashAlerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});
