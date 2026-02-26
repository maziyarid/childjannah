/**
 * Teznevisan JavaScript - Complete Rewrite
 * Version: 3.3.0 - Critical Accessibility Fixes
 * Focus: Fix hamburger menu, clean functionality, add Chaty & scroll-to-top
 */

(function() {
    'use strict';

    // =============================================
    // UTILITIES
    // =============================================
    const $ = (sel, ctx = document) => ctx.querySelector(sel);
    const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

    const debounce = (fn, wait = 100) => {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn(...args), wait);
        };
    };

    // Screen reader announcements
    function announceToScreenReader(message) {
        const announcement = document.createElement('div');
        announcement.setAttribute('role', 'status');
        announcement.setAttribute('aria-live', 'polite');
        announcement.setAttribute('aria-atomic', 'true');
        announcement.classList.add('screen-reader-text');
        announcement.textContent = message;
        
        document.body.appendChild(announcement);
        setTimeout(() => announcement.remove(), 1000);
    }

    // =============================================
    // THEME MANAGEMENT
    // =============================================
    function initTheme() {
        const buttons = $$('.tez-mode-btn, .tez-theme-btn');
        if (!buttons.length) return;

        // Load saved theme or default to light - wrapped for Safari private mode
        let savedTheme = 'light';
        try {
            savedTheme = localStorage.getItem('tez-theme') || 'light';
        } catch(e) {
            console.warn('localStorage unavailable:', e);
        }
        document.documentElement.setAttribute('data-theme', savedTheme);

        // Set active state
        buttons.forEach(btn => {
            const btnTheme = btn.getAttribute('data-theme');
            const isActive = btnTheme === savedTheme;
            btn.classList.toggle('active', isActive);
            btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });

        // Handle theme changes
        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const theme = this.getAttribute('data-theme');
                if (!theme) return;

                // Apply theme
                document.documentElement.setAttribute('data-theme', theme);
                try {
                    localStorage.setItem('tez-theme', theme);
                } catch(e) {
                    console.warn('Could not save theme:', e);
                }

                // Update button states
                buttons.forEach(b => {
                    const bTheme = b.getAttribute('data-theme');
                    const isActive = bTheme === theme;
                    b.classList.toggle('active', isActive);
                    b.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                });

                // Announce to screen reader
                const themeNames = { light: 'روشن', dark: 'تاریک', sepia: 'سپیا' };
                announceToScreenReader('حالت ' + (themeNames[theme] || theme) + ' فعال شد');
            });
        });
    }

    // =============================================
    // ACCESSIBILITY TOOLBAR
    // =============================================
    function initAccessibility() {
        const buttons = $$('.tez-a11y-btn');
        if (!buttons.length) return;

        const html = document.documentElement;
        const body = document.body;

        // Load saved settings - wrapped for Safari private mode
        let fontSize = 16;
        let highContrast = false;
        try {
            fontSize = parseInt(localStorage.getItem('tez-fontSize')) || 16;
            highContrast = localStorage.getItem('tez-highContrast') === 'true';
        } catch(e) {
            console.warn('localStorage unavailable:', e);
        }
        
        if (fontSize !== 16) {
            html.style.fontSize = fontSize + 'px';
        }
        if (highContrast) {
            body.classList.add('tez-high-contrast');
        }

        // Handle accessibility actions
        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const action = this.getAttribute('data-action');

                switch (action) {
                    case 'font-size-increase':
                        if (fontSize < 24) {
                            fontSize += 2;
                            html.style.fontSize = fontSize + 'px';
                            try {
                                localStorage.setItem('tez-fontSize', fontSize);
                            } catch(e) {}
                            announceToScreenReader('اندازه فونت افزایش یافت');
                        }
                        break;

                    case 'font-size-decrease':
                        if (fontSize > 12) {
                            fontSize -= 2;
                            html.style.fontSize = fontSize + 'px';
                            try {
                                localStorage.setItem('tez-fontSize', fontSize);
                            } catch(e) {}
                            announceToScreenReader('اندازه فونت کاهش یافت');
                        }
                        break;

                    case 'contrast-toggle':
                        const hasContrast = body.classList.contains('tez-high-contrast');
                        body.classList.toggle('tez-high-contrast');
                        try {
                            localStorage.setItem('tez-highContrast', !hasContrast);
                        } catch(e) {}
                        announceToScreenReader(hasContrast ? 'کنتراست عادی' : 'کنتراست بالا فعال شد');
                        break;

                    case 'reset':
                        fontSize = 16;
                        html.style.fontSize = '16px';
                        body.classList.remove('tez-high-contrast');
                        try {
                            localStorage.removeItem('tez-fontSize');
                            localStorage.removeItem('tez-highContrast');
                        } catch(e) {}
                        announceToScreenReader('تنظیمات به حالت پیش‌فرض بازگشت');
                        break;
                }
            });
        });
    }

    // =============================================
    // MOBILE MENU - FIXED
    // =============================================
    function initMobileMenu() {
        const toggle = $('#tez-mobile-toggle');
        const menu = $('#tez-mobile-menu');
        const overlay = $('#tez-mobile-overlay');
        const closeBtn = $('#tez-mobile-close');

        if (!toggle || !menu) {
            console.warn('Mobile menu elements not found');
            return;
        }

        let isOpen = false;
        let lastFocusedElement = null;

        function openMenu() {
            if (isOpen) return;

            // Save currently focused element
            lastFocusedElement = document.activeElement;

            // Open menu
            isOpen = true;
            menu.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            
            if (overlay) {
                overlay.setAttribute('aria-hidden', 'false');
            }

            // Lock body scroll
            document.body.classList.add('tez-menu-open');

            // Announce
            announceToScreenReader('منوی موبایل باز شد');

            // Focus first focusable element in menu
            setTimeout(() => {
                const firstFocusable = menu.querySelector('a, button');
                if (firstFocusable) {
                    firstFocusable.focus();
                }
            }, 100);
        }

        function closeMenu() {
            if (!isOpen) return;

            // Close menu
            isOpen = false;
            menu.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
            
            if (overlay) {
                overlay.setAttribute('aria-hidden', 'true');
            }

            // Unlock body scroll
            document.body.classList.remove('tez-menu-open');

            // Announce
            announceToScreenReader('منوی موبایل بسته شد');

            // Restore focus
            if (lastFocusedElement) {
                lastFocusedElement.focus();
                lastFocusedElement = null;
            }
        }

        // Toggle button
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (isOpen) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // Close button
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                closeMenu();
            });
        }

        // Overlay click
        if (overlay) {
            overlay.addEventListener('click', function(e) {
                e.preventDefault();
                closeMenu();
            });
        }

        // Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isOpen) {
                closeMenu();
            }
        });

        // Close menu on link click
        const mobileLinks = menu.querySelectorAll('.tez-mobile-link');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
                setTimeout(closeMenu, 100);
            });
        });

        // Submenu toggles
        const submenuToggles = menu.querySelectorAll('.tez-submenu-toggle');
        submenuToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                
                const parent = this.closest('.tez-has-submenu');
                if (!parent) return;

                const submenu = parent.querySelector('.tez-mobile-submenu');
                if (!submenu) return;

                const isExpanded = this.getAttribute('aria-expanded') === 'true';

                if (isExpanded) {
                    this.setAttribute('aria-expanded', 'false');
                    parent.setAttribute('aria-expanded', 'false');
                } else {
                    // Close all other submenus first
                    submenuToggles.forEach(otherToggle => {
                        if (otherToggle !== this) {
                            otherToggle.setAttribute('aria-expanded', 'false');
                            const otherParent = otherToggle.closest('.tez-has-submenu');
                            if (otherParent) {
                                otherParent.setAttribute('aria-expanded', 'false');
                            }
                        }
                    });

                    this.setAttribute('aria-expanded', 'true');
                    parent.setAttribute('aria-expanded', 'true');
                }
            });
        });

        // Close menu when resizing to desktop
        window.addEventListener('resize', debounce(function() {
            if (window.innerWidth >= 1024 && isOpen) {
                closeMenu();
            }
        }, 250));
    }

    // =============================================
    // SEARCH OVERLAY
    // =============================================
    function initSearch() {
        const toggle = $('#tez-search-toggle');
        const overlay = $('#tez-search-overlay');
        const closeBtn = $('#tez-search-close');
        const input = overlay ? overlay.querySelector('.tez-search-input') : null;

        if (!toggle || !overlay) return;

        let isOpen = false;
        let lastFocusedElement = null;

        function openSearch() {
            if (isOpen) return;
            
            lastFocusedElement = document.activeElement;
            isOpen = true;
            overlay.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
            
            announceToScreenReader('جستجو باز شد');
            
            setTimeout(() => {
                if (input) input.focus();
            }, 100);
        }

        function closeSearch() {
            if (!isOpen) return;
            
            isOpen = false;
            overlay.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
            
            announceToScreenReader('جستجو بسته شد');
            
            if (lastFocusedElement) {
                lastFocusedElement.focus();
                lastFocusedElement = null;
            }
        }

        // Toggle button
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            openSearch();
        });

        // Close button
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                closeSearch();
            });
        }

        // Overlay click
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                closeSearch();
            }
        });

        // Escape key - CRITICAL FIX for WCAG 2.1.2
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isOpen) {
                e.preventDefault();
                closeSearch();
            }
        });
    }

    // =============================================
    // CHATY WIDGET - NEW
    // =============================================
    function initChaty() {
        const chaty = $('#tez-chaty');
        const toggle = $('#tez-chaty-toggle');
        const panel = $('#tez-chaty-channels');
        const channels = panel ? $$('.tez-chaty-item', panel) : [];

        if (!chaty || !toggle || !panel) return;

        let isOpen = false;

        // Restore persisted state - wrapped for Safari private mode
        let initialOpen = false;
        try {
            initialOpen = localStorage.getItem('tez-chaty-open') === 'true';
        } catch(e) {
            console.warn('localStorage unavailable:', e);
        }
        setOpen(initialOpen);

        // Toggle click
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            setOpen(!isOpen);
        });

        // ESC closes when open - WCAG 2.1.2
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isOpen) {
                e.preventDefault();
                setOpen(false);
                toggle.focus();
            }
        });

        // Focus trap within panel when open
        panel.addEventListener('keydown', function(e) {
            if (e.key !== 'Tab' || !isOpen) return;
            
            const focusables = channels.filter(el => !el.hasAttribute('disabled'));
            if (!focusables.length) return;
            
            const first = focusables[0];
            const last = focusables[focusables.length - 1];
            
            if (e.shiftKey && document.activeElement === first) {
                e.preventDefault();
                last.focus();
            } else if (!e.shiftKey && document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        });

        // Close on outside click
        document.addEventListener('click', function(e) {
            if (isOpen && !chaty.contains(e.target)) {
                setOpen(false);
            }
        });

        function setOpen(open) {
            isOpen = open;
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            panel.toggleAttribute('hidden', !open);
            panel.setAttribute('aria-hidden', open ? 'false' : 'true');
            
            // Icon swap
            const icon = toggle.querySelector('.tez-chaty-icon');
            const close = toggle.querySelector('.tez-chaty-close');
            if (icon && close) {
                icon.style.display = open ? 'none' : '';
                close.style.display = open ? '' : 'none';
            }
            
            // Focus first channel on open
            if (open && channels.length) {
                setTimeout(() => channels[0].focus(), 50);
            }
            
            // Persist state - wrapped for Safari private mode
            try {
                localStorage.setItem('tez-chaty-open', String(open));
            } catch(e) {}
            
            // Announce
            announceToScreenReader(open ? 'گزینه‌های تماس باز شد' : 'گزینه‌های تماس بسته شد');
        }
    }

    // =============================================
    // SCROLL TO TOP BUTTON - NEW
    // =============================================
    function initScrollToTop() {
        const scrollBtn = $('#tez-scroll-top');
        if (!scrollBtn) return;

        let lastY = 0;
        const threshold = 550;

        // Show/hide based on scroll position
        window.addEventListener('scroll', function() {
            const y = window.scrollY || document.documentElement.scrollTop;
            
            if (y > threshold && lastY <= threshold) {
                scrollBtn.classList.add('visible');
            } else if (y <= threshold && lastY > threshold) {
                scrollBtn.classList.remove('visible');
            }
            
            lastY = y;
        }, { passive: true });

        // Click handler
        scrollBtn.addEventListener('click', function() {
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const scrollOptions = reducedMotion 
                ? { top: 0, left: 0 } 
                : { top: 0, left: 0, behavior: 'smooth' };
            
            window.scrollTo(scrollOptions);
            announceToScreenReader('بازگشت به بالای صفحه');
        });

        // Keyboard support
        scrollBtn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    }

    // =============================================
    // DESKTOP DROPDOWN MENUS
    // =============================================
    function initDropdowns() {
        const dropdowns = $$('.tez-has-dropdown');
        if (!dropdowns.length) return;

        dropdowns.forEach(dropdown => {
            const link = dropdown.querySelector('.tez-nav-link');
            const menu = dropdown.querySelector('.tez-dropdown-menu');
            
            if (!link || !menu) return;

            // Hover
            dropdown.addEventListener('mouseenter', function() {
                link.setAttribute('aria-expanded', 'true');
            });

            dropdown.addEventListener('mouseleave', function() {
                link.setAttribute('aria-expanded', 'false');
            });

            // Keyboard
            link.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
                }

                if (e.key === 'Escape') {
                    this.setAttribute('aria-expanded', 'false');
                    this.focus();
                }
            });
        });
    }

    // =============================================
    // SMOOTH SCROLL FOR ANCHOR LINKS
    // =============================================
    function initSmoothScroll() {
        const anchors = $$('a[href^="#"]');
        
        anchors.forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                if (!href || href === '#' || href === '#0') return;

                const target = $(href);
                if (!target) return;

                e.preventDefault();

                const header = $('#tez-site-header');
                const headerHeight = header ? header.offsetHeight : 0;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = targetPosition - headerHeight - 20;

                window.scrollTo({
                    top: Math.max(0, offsetPosition),
                    behavior: 'smooth'
                });
            });
        });
    }

    // =============================================
    // FAQ ACCORDION
    // =============================================
    function initFAQ() {
        const questions = $$('.tez-faq-question, .faq-lead-question');
        if (!questions.length) return;

        questions.forEach(question => {
            question.addEventListener('click', function() {
                const item = this.closest('.tez-faq-item, .faq-lead-item');
                if (!item) return;

                const answer = item.querySelector('.tez-faq-answer, .faq-lead-answer');
                if (!answer) return;

                const isActive = item.classList.contains('active');

                // Close all others
                $$('.tez-faq-item.active, .faq-lead-item.active').forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                        const otherAnswer = otherItem.querySelector('.tez-faq-answer, .faq-lead-answer');
                        if (otherAnswer) {
                            otherAnswer.style.maxHeight = null;
                        }
                        const otherQuestion = otherItem.querySelector('.tez-faq-question, .faq-lead-question');
                        if (otherQuestion) {
                            otherQuestion.setAttribute('aria-expanded', 'false');
                        }
                    }
                });

                // Toggle this one
                if (isActive) {
                    item.classList.remove('active');
                    answer.style.maxHeight = null;
                    this.setAttribute('aria-expanded', 'false');
                } else {
                    item.classList.add('active');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    this.setAttribute('aria-expanded', 'true');
                }
            });
        });
    }

    // =============================================
    // SCROLL ANIMATIONS
    // =============================================
    function initScrollAnimations() {
        const elements = $$('.scroll-animate');
        if (!elements.length) return;

        if (!('IntersectionObserver' in window)) {
            elements.forEach(el => el.classList.add('animated'));
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        elements.forEach(el => observer.observe(el));
    }

    // =============================================
    // FORM ENHANCEMENTS
    // =============================================
    function initForms() {
        // Phone number inputs: only digits, max 11 chars (Iranian)
        const phoneInputs = $$('input[type="tel"]');
        phoneInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) {
                    value = value.substring(0, 11);
                }
                e.target.value = value;
            });
        });
    }

    // =============================================
    // GLOBAL HELPER: SCROLL TO FORM
    // =============================================
    window.scrollToForm = function(selector) {
        const defaultSelector = '#order-form, #contact-form, .lead-form-box, .tez-inquiry-form';
        const query = selector || defaultSelector;
        const form = $(query);
        
        if (form) {
            const header = $('#tez-site-header');
            const headerHeight = header ? header.offsetHeight : 0;
            const formPosition = form.getBoundingClientRect().top + window.pageYOffset;
            const offsetPosition = formPosition - headerHeight - 20;

            window.scrollTo({
                top: Math.max(0, offsetPosition),
                behavior: 'smooth'
            });
        }
    };

    // =============================================
    // INITIALIZE ALL
    // =============================================
    function init() {
        console.log('Teznevisan JS v3.3.0 initializing...');

        initTheme();
        initAccessibility();
        initMobileMenu();
        initSearch();
        initChaty();
        initScrollToTop();
        initDropdowns();
        initSmoothScroll();
        initFAQ();
        initScrollAnimations();
        initForms();

        document.body.classList.add('tez-loaded');
        document.body.classList.remove('loading');

        console.log('Teznevisan JS v3.3.0 loaded');
    }

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();