/**
 * Teznevisan Complete JavaScript
 * Version: 3.1.0
 * Jannah Child Theme - Full interactive layer
 *
 * Modules:
 * - Theme management (light / dark / sepia)
 * - Accessibility toolbar (font size, high contrast, reset)
 * - Mobile menu (open/close, submenu, focus trap, keyboard)
 * - Fullscreen search overlay
 * - Header scroll (hide on scroll down, reveal on scroll up)
 * - Chaty floating contact widget
 * - Scroll to top button
 * - Desktop dropdown menus (keyboard + hover)
 * - Smooth scroll (anchor links with header offset)
 * - FAQ accordion
 * - Scroll animations (IntersectionObserver)
 * - Form enhancements (phone input sanitizer)
 * - Global helpers (scrollToForm)
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

    // Read PHP-passed context (set by wp_localize_script)
    const tez = (typeof tezData !== 'undefined') ? tezData : {};
    const isRTL = (tez.isRTL === 'true') || (document.documentElement.dir === 'rtl');

    // =============================================
    // THEME MANAGEMENT (light / dark / sepia)
    // =============================================
    function initTheme() {
        const buttons = $$('.tez-mode-btn');
        if (!buttons.length) return;

        const savedTheme = localStorage.getItem('tez-theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);

        buttons.forEach(btn => {
            const isActive = btn.dataset.theme === savedTheme;
            btn.classList.toggle('active', isActive);
            btn.setAttribute('aria-pressed', isActive);
        });

        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const theme = this.dataset.theme;

                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem('tez-theme', theme);

                buttons.forEach(b => {
                    const isActive = b.dataset.theme === theme;
                    b.classList.toggle('active', isActive);
                    b.setAttribute('aria-pressed', isActive);
                });
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
        let fontSize = parseInt(localStorage.getItem('tez-fontSize')) || 16;

        if (fontSize !== 16) html.style.fontSize = fontSize + 'px';
        if (localStorage.getItem('tez-highContrast') === 'true') body.classList.add('tez-high-contrast');

        buttons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const action = this.dataset.action;

                switch (action) {
                    case 'increase-font':
                        if (fontSize < 24) {
                            fontSize += 2;
                            html.style.fontSize = fontSize + 'px';
                            localStorage.setItem('tez-fontSize', fontSize);
                        }
                        break;
                    case 'decrease-font':
                        if (fontSize > 12) {
                            fontSize -= 2;
                            html.style.fontSize = fontSize + 'px';
                            localStorage.setItem('tez-fontSize', fontSize);
                        }
                        break;
                    case 'high-contrast':
                        body.classList.toggle('tez-high-contrast');
                        localStorage.setItem('tez-highContrast', body.classList.contains('tez-high-contrast'));
                        break;
                    case 'reset':
                        fontSize = 16;
                        html.style.fontSize = '16px';
                        body.classList.remove('tez-high-contrast');
                        localStorage.removeItem('tez-fontSize');
                        localStorage.removeItem('tez-highContrast');
                        break;
                }
            });
        });
    }

    // =============================================
    // MOBILE MENU
    // =============================================
    function initMobileMenu() {
        const toggle  = $('#tez-mobile-toggle');
        const menu    = $('#tez-mobile-menu');
        const overlay = $('#tez-mobile-overlay');
        const closeBtn = $('#tez-mobile-close');

        if (!toggle || !menu) return;

        let isOpen = false;
        let lastFocused = null;

        function openMenu() {
            if (isOpen) return;
            lastFocused = document.activeElement;
            isOpen = true;
            menu.classList.add('is-open');
            menu.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            toggle.classList.add('is-active');
            if (overlay) { overlay.classList.add('is-visible'); overlay.setAttribute('aria-hidden', 'false'); }
            document.body.classList.add('tez-menu-open');
            document.body.style.overflow = 'hidden';
            setTimeout(() => {
                const firstFocusable = menu.querySelector('button, a, input');
                if (firstFocusable) firstFocusable.focus();
            }, 100);
        }

        function closeMenu() {
            if (!isOpen) return;
            isOpen = false;
            menu.classList.remove('is-open');
            menu.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.classList.remove('is-active');
            if (overlay) { overlay.classList.remove('is-visible'); overlay.setAttribute('aria-hidden', 'true'); }
            document.body.classList.remove('tez-menu-open');
            document.body.style.overflow = '';
            if (lastFocused) { lastFocused.focus(); lastFocused = null; }
        }

        toggle.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); isOpen ? closeMenu() : openMenu(); });
        if (closeBtn) closeBtn.addEventListener('click', function(e) { e.preventDefault(); closeMenu(); });
        if (overlay) overlay.addEventListener('click', function(e) { e.preventDefault(); closeMenu(); });
        document.addEventListener('keydown', function(e) { if (e.key === 'Escape' && isOpen) closeMenu(); });
        menu.querySelectorAll('.tez-mobile-link').forEach(link => link.addEventListener('click', closeMenu));

        // Submenu toggles
        menu.querySelectorAll('.tez-submenu-toggle').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const parent  = this.closest('.tez-has-submenu');
                const submenu = parent ? parent.querySelector('.tez-mobile-submenu') : null;
                if (!submenu) return;

                const isExpanded = parent.classList.contains('is-expanded');

                menu.querySelectorAll('.tez-has-submenu.is-expanded').forEach(item => {
                    if (item !== parent) {
                        item.classList.remove('is-expanded');
                        const sub = item.querySelector('.tez-mobile-submenu');
                        if (sub) sub.style.maxHeight = null;
                        const btn2 = item.querySelector('.tez-submenu-toggle');
                        if (btn2) btn2.setAttribute('aria-expanded', 'false');
                    }
                });

                if (isExpanded) {
                    parent.classList.remove('is-expanded');
                    submenu.style.maxHeight = null;
                    this.setAttribute('aria-expanded', 'false');
                } else {
                    parent.classList.add('is-expanded');
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                    this.setAttribute('aria-expanded', 'true');
                }
            });
        });

        window.addEventListener('resize', debounce(() => {
            if (window.innerWidth >= 992 && isOpen) closeMenu();
        }, 250));
    }

    // =============================================
    // FULLSCREEN SEARCH
    // =============================================
    function initSearch() {
        const toggle   = $('#tez-search-toggle');
        const overlay  = $('#tez-search-overlay');
        const closeBtn = $('#tez-search-close');
        const input    = overlay ? overlay.querySelector('.tez-search-input') : null;

        if (!toggle || !overlay) return;

        let isOpen = false;

        function openSearch() {
            isOpen = true;
            overlay.classList.add('is-open');
            overlay.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
            setTimeout(() => { if (input) input.focus(); }, 300);
        }

        function closeSearch() {
            isOpen = false;
            overlay.classList.remove('is-open');
            overlay.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }

        toggle.addEventListener('click', function(e) { e.preventDefault(); openSearch(); });
        if (closeBtn) closeBtn.addEventListener('click', function(e) { e.preventDefault(); closeSearch(); });
        overlay.addEventListener('click', function(e) { if (e.target === overlay) closeSearch(); });
        document.addEventListener('keydown', function(e) { if (e.key === 'Escape' && isOpen) closeSearch(); });
    }

    // =============================================
    // HEADER SCROLL (hide on scroll down, show on up)
    // =============================================
    function initHeaderScroll() {
        const header = $('#tez-masthead');
        if (!header) return;

        let lastScroll = 0;
        let ticking = false;

        function updateHeader() {
            const scrollTop = window.pageYOffset;
            header.classList.toggle('is-scrolled', scrollTop > 50);
            if (scrollTop > 300) {
                header.classList.toggle('is-hidden', scrollTop > lastScroll && scrollTop > 100);
            } else {
                header.classList.remove('is-hidden');
            }
            lastScroll = scrollTop <= 0 ? 0 : scrollTop;
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) { requestAnimationFrame(updateHeader); ticking = true; }
        });
    }

    // =============================================
    // CHATY WIDGET (floating contact buttons)
    // =============================================
    function initChaty() {
        const container = $('#tez-chaty');
        const toggle   = $('#tez-chaty-toggle');
        const channels = $('#tez-chaty-channels');

        if (!toggle || !channels) return;

        let isOpen = false;

        function toggleChaty() {
            isOpen = !isOpen;
            container.classList.toggle('is-open', isOpen);
            toggle.setAttribute('aria-expanded', isOpen);
            channels.setAttribute('aria-hidden', !isOpen);
        }

        toggle.addEventListener('click', function(e) { e.preventDefault(); e.stopPropagation(); toggleChaty(); });
        document.addEventListener('click', function(e) {
            if (isOpen && container && !container.contains(e.target)) {
                isOpen = false;
                container.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
                channels.setAttribute('aria-hidden', 'true');
            }
        });
    }

    // =============================================
    // SCROLL TO TOP
    // =============================================
    function initScrollTop() {
        const btn = $('#tez-scroll-top');
        if (!btn) return;

        function updateVisibility() { btn.classList.toggle('is-visible', window.pageYOffset > 300); }

        window.addEventListener('scroll', debounce(updateVisibility, 100));
        updateVisibility();

        btn.addEventListener('click', function(e) { e.preventDefault(); window.scrollTo({ top: 0, behavior: 'smooth' }); });
    }

    // =============================================
    // DROPDOWN MENUS (Desktop)
    // =============================================
    function initDropdowns() {
        $$('.tez-has-dropdown').forEach(dropdown => {
            const link = dropdown.querySelector('.tez-nav-link');
            const menu = dropdown.querySelector('.tez-dropdown-menu');
            if (!link || !menu) return;

            dropdown.addEventListener('mouseenter', () => link.setAttribute('aria-expanded', 'true'));
            dropdown.addEventListener('mouseleave', () => link.setAttribute('aria-expanded', 'false'));

            link.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', String(!isExpanded));
                }
            });
        });
    }

    // =============================================
    // SMOOTH SCROLL (anchor links, RTL-aware offset)
    // =============================================
    function initSmoothScroll() {
        $$('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#' || href === '#0') return;

                const target = $(href);
                if (!target) return;

                e.preventDefault();
                const header = $('#tez-masthead');
                const headerHeight = header ? header.offsetHeight : 0;
                const targetPos = target.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;
                window.scrollTo({ top: Math.max(0, targetPos), behavior: 'smooth' });
            });
        });
    }

    // =============================================
    // FAQ ACCORDION
    // =============================================
    function initFAQ() {
        $$('.faq-lead-question, .tez-faq-question').forEach(question => {
            question.addEventListener('click', function() {
                const item = this.closest('.faq-lead-item, .tez-faq-item');
                if (!item) return;

                const answer = item.querySelector('.faq-lead-answer, .tez-faq-answer');
                const isActive = item.classList.contains('active');

                // Close all others
                $$('.faq-lead-item.active, .tez-faq-item.active').forEach(i => {
                    if (i !== item) {
                        i.classList.remove('active');
                        const a = i.querySelector('.faq-lead-answer, .tez-faq-answer');
                        if (a) a.style.maxHeight = null;
                        const q = i.querySelector('.faq-lead-question, .tez-faq-question');
                        if (q) q.setAttribute('aria-expanded', 'false');
                    }
                });

                if (isActive) {
                    item.classList.remove('active');
                    if (answer) answer.style.maxHeight = null;
                    this.setAttribute('aria-expanded', 'false');
                } else {
                    item.classList.add('active');
                    if (answer) answer.style.maxHeight = answer.scrollHeight + 'px';
                    this.setAttribute('aria-expanded', 'true');
                }
            });
        });
    }

    // =============================================
    // SCROLL ANIMATIONS (IntersectionObserver)
    // =============================================
    function initScrollAnimations() {
        const elements = $$('.scroll-animate');
        if (!elements.length || !('IntersectionObserver' in window)) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        elements.forEach(el => observer.observe(el));
    }

    // =============================================
    // FORM ENHANCEMENTS
    // =============================================
    function initForms() {
        // Sanitize phone inputs: digits only, max 11 chars (Iranian mobile)
        $$('input[type="tel"]').forEach(input => {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);
                e.target.value = value;
            });
        });
    }

    // =============================================
    // GLOBAL: SCROLL TO FORM (used by CTA buttons)
    // =============================================
    window.scrollToForm = function(selector) {
        const query = selector || (isRTL
            ? '#order-form, #contact-form, .lead-form-box, .tez-inquiry-form'
            : '#contact-form, #order-form, .lead-form-box, .tez-inquiry-form');
        const form = document.querySelector(query);
        if (form) {
            const header = $('#tez-masthead');
            const headerHeight = header ? header.offsetHeight : 0;
            const formPos = form.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;
            window.scrollTo({ top: Math.max(0, formPos), behavior: 'smooth' });
        }
    };

    // =============================================
    // INITIALIZE ALL MODULES
    // =============================================
    function init() {
        initTheme();
        initAccessibility();
        initMobileMenu();
        initSearch();
        initHeaderScroll();
        initChaty();
        initScrollTop();
        initDropdowns();
        initSmoothScroll();
        initFAQ();
        initScrollAnimations();
        initForms();

        document.body.classList.add('tez-loaded');
        document.body.classList.remove('loading');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
