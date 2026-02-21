/**
 * Teznevisan Complete JavaScript - Fixed Version
 * Version: 2.1.0
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

    // =============================================
    // THEME MANAGEMENT
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
    // ACCESSIBILITY
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
                
                switch(action) {
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
        let lastFocused = null;

        function openMenu() {
            if (isOpen) return;
            
            lastFocused = document.activeElement;
            isOpen = true;
            
            menu.classList.add('is-open');
            menu.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            toggle.classList.add('is-active');
            
            if (overlay) {
                overlay.classList.add('is-visible');
                overlay.setAttribute('aria-hidden', 'false');
            }
            
            document.body.classList.add('tez-menu-open');
            document.body.style.overflow = 'hidden';
            
            // Focus first focusable element
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
            
            if (overlay) {
                overlay.classList.remove('is-visible');
                overlay.setAttribute('aria-hidden', 'true');
            }
            
            document.body.classList.remove('tez-menu-open');
            document.body.style.overflow = '';
            
            // Return focus
            if (lastFocused) {
                lastFocused.focus();
                lastFocused = null;
            }
        }

        // Toggle button click
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

        // Close on link click
        const menuLinks = menu.querySelectorAll('.tez-mobile-link');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                closeMenu();
            });
        });

        // Submenu toggles
        const submenuToggles = menu.querySelectorAll('.tez-submenu-toggle');
        submenuToggles.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const parent = this.closest('.tez-has-submenu');
                const submenu = parent ? parent.querySelector('.tez-mobile-submenu') : null;
                
                if (!submenu) return;
                
                const isExpanded = parent.classList.contains('is-expanded');
                
                // Close other open submenus
                menu.querySelectorAll('.tez-has-submenu.is-expanded').forEach(item => {
                    if (item !== parent) {
                        item.classList.remove('is-expanded');
                        const sub = item.querySelector('.tez-mobile-submenu');
                        if (sub) sub.style.maxHeight = null;
                        const toggleBtn = item.querySelector('.tez-submenu-toggle');
                        if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
                    }
                });
                
                // Toggle current
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

        // Handle resize
        window.addEventListener('resize', debounce(() => {
            if (window.innerWidth >= 992 && isOpen) {
                closeMenu();
            }
        }, 250));
    }

    // =============================================
    // FULLSCREEN SEARCH
    // =============================================
    function initSearch() {
        const toggle = $('#tez-search-toggle');
        const overlay = $('#tez-search-overlay');
        const closeBtn = $('#tez-search-close');
        const input = overlay ? overlay.querySelector('.tez-search-input') : null;
        
        if (!toggle || !overlay) return;

        let isOpen = false;

        function openSearch() {
            isOpen = true;
            overlay.classList.add('is-open');
            overlay.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
            
            setTimeout(() => {
                if (input) input.focus();
            }, 300);
        }

        function closeSearch() {
            isOpen = false;
            overlay.classList.remove('is-open');
            overlay.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }

        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            openSearch();
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                closeSearch();
            });
        }

        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) closeSearch();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isOpen) closeSearch();
        });
    }

    // =============================================
    // HEADER SCROLL
    // =============================================
    function initHeaderScroll() {
        const header = $('#tez-masthead');
        if (!header) return;

        let lastScroll = 0;
        let ticking = false;

        function updateHeader() {
            const scrollTop = window.pageYOffset;
            
            // Add scrolled class
            header.classList.toggle('is-scrolled', scrollTop > 50);
            
            // Hide/show on scroll direction
            if (scrollTop > 300) {
                if (scrollTop > lastScroll && scrollTop > 100) {
                    header.classList.add('is-hidden');
                } else {
                    header.classList.remove('is-hidden');
                }
            } else {
                header.classList.remove('is-hidden');
            }
            
            lastScroll = scrollTop <= 0 ? 0 : scrollTop;
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(updateHeader);
                ticking = true;
            }
        });
    }

    // =============================================
    // CHATY WIDGET
    // =============================================
    function initChaty() {
        const container = $('#tez-chaty');
        const toggle = $('#tez-chaty-toggle');
        const channels = $('#tez-chaty-channels');
        
        if (!toggle || !channels) return;

        let isOpen = false;

        function toggleChaty() {
            isOpen = !isOpen;
            container.classList.toggle('is-open', isOpen);
            toggle.setAttribute('aria-expanded', isOpen);
            channels.setAttribute('aria-hidden', !isOpen);
        }

        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleChaty();
        });

        // Close on outside click
        document.addEventListener('click', function(e) {
            if (isOpen && !container.contains(e.target)) {
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

        function updateVisibility() {
            btn.classList.toggle('is-visible', window.pageYOffset > 300);
        }

        window.addEventListener('scroll', debounce(updateVisibility, 100));
        updateVisibility();

        btn.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // =============================================
    // DROPDOWN MENUS (Desktop)
    // =============================================
    function initDropdowns() {
        const dropdowns = $$('.tez-has-dropdown');
        
        dropdowns.forEach(dropdown => {
            const link = dropdown.querySelector('.tez-nav-link');
            const menu = dropdown.querySelector('.tez-dropdown-menu');
            
            if (!link || !menu) return;

            dropdown.addEventListener('mouseenter', function() {
                link.setAttribute('aria-expanded', 'true');
            });
            
            dropdown.addEventListener('mouseleave', function() {
                link.setAttribute('aria-expanded', 'false');
            });

            // Keyboard support
            link.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', !isExpanded);
                }
            });
        });
    }

    // =============================================
    // SMOOTH SCROLL
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
                
                window.scrollTo({ top: targetPos, behavior: 'smooth' });
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
                    }
                });
                
                // Toggle current
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
    // SCROLL ANIMATIONS
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
        // Phone number formatting
        $$('input[type="tel"]').forEach(input => {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);
                e.target.value = value;
            });
        });
    }

    // =============================================
    // GLOBAL SCROLL TO FORM
    // =============================================
    window.scrollToForm = function() {
        const form = document.querySelector('#order-form, #contact-form, .lead-form-box');
        if (form) {
            const header = $('#tez-masthead');
            const headerHeight = header ? header.offsetHeight : 0;
            const formPos = form.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;
            window.scrollTo({ top: formPos, behavior: 'smooth' });
        }
    };

    // =============================================
    // INITIALIZE
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
        
        console.log('Teznevisan v2.1.0 initialized');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
