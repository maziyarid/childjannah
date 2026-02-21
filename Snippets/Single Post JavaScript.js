/**
 * Teznevisan Single Post Enhancements
 * Version: 2.2.0
 */

(function() {
    'use strict';

    // Only run on single posts
    if (!document.body.classList.contains('single-post')) return;

    // =============================================
    // READING PROGRESS BAR
    // =============================================
    function initReadingProgress() {
        const progressBar = document.getElementById('tez-reading-progress-bar');
        if (!progressBar) return;

        const article = document.querySelector('.tez-post-content-main') || 
                       document.querySelector('.entry-content') || 
                       document.querySelector('article');
        
        if (!article) return;

        function updateProgress() {
            const articleRect = article.getBoundingClientRect();
            const articleTop = articleRect.top + window.pageYOffset;
            const articleHeight = article.offsetHeight;
            const windowHeight = window.innerHeight;
            const scrollTop = window.pageYOffset;
            
            const start = articleTop - windowHeight;
            const end = articleTop + articleHeight;
            const current = scrollTop - start;
            const total = end - start;
            
            let progress = (current / total) * 100;
            progress = Math.min(100, Math.max(0, progress));
            
            progressBar.style.width = progress + '%';
        }

        window.addEventListener('scroll', updateProgress, { passive: true });
        updateProgress();
    }

    // =============================================
    // TABLE OF CONTENTS
    // =============================================
    function initTableOfContents() {
        const toc = document.getElementById('tez-toc');
        const toggle = document.getElementById('tez-toc-toggle');
        const list = document.getElementById('tez-toc-list');
        
        if (!toc || !toggle || !list) return;

        // Toggle functionality
        toggle.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            list.classList.toggle('collapsed', isExpanded);
        });

        // Highlight active section
        const headings = document.querySelectorAll('.tez-heading-anchor');
        const tocLinks = list.querySelectorAll('a');
        
        if (headings.length === 0 || tocLinks.length === 0) return;

        function highlightActiveTOC() {
            const scrollPos = window.pageYOffset + 150;
            
            let activeIndex = 0;
            headings.forEach((heading, index) => {
                if (heading.offsetTop <= scrollPos) {
                    activeIndex = index;
                }
            });
            
            tocLinks.forEach((link, index) => {
                link.classList.toggle('active', index === activeIndex);
            });
        }

        window.addEventListener('scroll', highlightActiveTOC, { passive: true });
        highlightActiveTOC();

        // Smooth scroll for TOC links
        tocLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').slice(1);
                const target = document.getElementById(targetId);
                
                if (target) {
                    const headerOffset = 100;
                    const targetPosition = target.offsetTop - headerOffset;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // =============================================
    // FAQ ACCORDION
    // =============================================
    function initFAQ() {
        const faqItems = document.querySelectorAll('.tez-faq-item');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.tez-faq-question');
            const answer = item.querySelector('.tez-faq-answer');
            
            if (!question || !answer) return;
            
            question.addEventListener('click', function() {
                const isActive = item.classList.contains('active');
                
                // Close all others
                faqItems.forEach(otherItem => {
                    if (otherItem !== item && otherItem.classList.contains('active')) {
                        otherItem.classList.remove('active');
                        const otherQuestion = otherItem.querySelector('.tez-faq-question');
                        if (otherQuestion) otherQuestion.setAttribute('aria-expanded', 'false');
                    }
                });
                
                // Toggle current
                item.classList.toggle('active', !isActive);
                this.setAttribute('aria-expanded', !isActive);
            });
        });
    }

    // =============================================
    // SHARE BUTTONS
    // =============================================
    function initShareButtons() {
        // Copy link functionality
        const copyButtons = document.querySelectorAll('.tez-copy-link');
        
        copyButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const container = this.closest('[data-post-url]');
                const url = container ? container.dataset.postUrl : window.location.href;
                
                navigator.clipboard.writeText(url).then(() => {
                    showNotification('لینک کپی شد!');
                }).catch(() => {
                    // Fallback for older browsers
                    const textarea = document.createElement('textarea');
                    textarea.value = url;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                    showNotification('لینک کپی شد!');
                });
            });
        });

        // Open share links in popup
        const shareLinks = document.querySelectorAll('.tez-share-btn:not(.tez-copy-link)');
        
        shareLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.getAttribute('target') === '_blank') {
                    e.preventDefault();
                    const url = this.getAttribute('href');
                    const width = 600;
                    const height = 400;
                    const left = (screen.width - width) / 2;
                    const top = (screen.height - height) / 2;
                    
                    window.open(
                        url,
                        'share',
                        `width=${width},height=${height},left=${left},top=${top},toolbar=no,menubar=no,scrollbars=yes`
                    );
                }
            });
        });
    }

    // =============================================
    // NOTIFICATION
    // =============================================
    function showNotification(message) {
        // Remove existing notification
        const existing = document.querySelector('.tez-copy-notification');
        if (existing) existing.remove();
        
        // Create new notification
        const notification = document.createElement('div');
        notification.className = 'tez-copy-notification';
        notification.innerHTML = '<i class="fa-solid fa-check-circle"></i>' + message;
        document.body.appendChild(notification);
        
        // Show
        requestAnimationFrame(() => {
            notification.classList.add('show');
        });
        
        // Hide after delay
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 2000);
    }

    // =============================================
    // HEADING ANCHOR LINKS
    // =============================================
    function initHeadingLinks() {
        const headingLinks = document.querySelectorAll('.tez-heading-link');
        
        headingLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = window.location.href.split('#')[0] + this.getAttribute('href');
                navigator.clipboard.writeText(url).then(() => {
                    showNotification('لینک بخش کپی شد!');
                });
            });
        });
    }

    // =============================================
    // LAZY LOAD IMAGES
    // =============================================
    function initLazyImages() {
        const images = document.querySelectorAll('.tez-post-content-main img[loading="lazy"]');
        
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                        }
                        observer.unobserve(img);
                    }
                });
            }, { rootMargin: '100px' });
            
            images.forEach(img => observer.observe(img));
        }
    }

    // =============================================
    // EXTERNAL LINKS
    // =============================================
    function initExternalLinks() {
        const content = document.querySelector('.tez-post-content-main') || 
                       document.querySelector('.entry-content');
        
        if (!content) return;
        
        const links = content.querySelectorAll('a[href^="http"]');
        const currentHost = window.location.hostname;
        
        links.forEach(link => {
            try {
                const url = new URL(link.href);
                if (url.hostname !== currentHost) {
                    link.setAttribute('target', '_blank');
                    link.setAttribute('rel', 'noopener noreferrer');
                    
                    // Add external link icon if not already there
                    if (!link.querySelector('.fa-external-link') && !link.querySelector('.fa-arrow-up-right-from-square')) {
                        const icon = document.createElement('i');
                        icon.className = 'fa-solid fa-arrow-up-right-from-square';
                        icon.style.cssText = 'font-size:0.75em;margin-right:0.25rem;opacity:0.7;';
                        link.appendChild(icon);
                    }
                }
            } catch (e) {}
        });
    }

    // =============================================
    // INITIALIZE
    // =============================================
    function init() {
        initReadingProgress();
        initTableOfContents();
        initFAQ();
        initShareButtons();
        initHeadingLinks();
        initLazyImages();
        initExternalLinks();
        
        console.log('Teznevisan Single Post v2.2.0 initialized');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
