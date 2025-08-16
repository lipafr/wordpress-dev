/**
 * YandexPro Enhanced Theme JavaScript
 * 
 * @package YandexPro
 * @since 1.0.0
 */

(function() {
    'use strict';

    // DOM ready state
    let domReady = false;
    
    // Check if DOM is already loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    /**
     * Initialize all theme functionality
     */
    function init() {
        domReady = true;
        
        // Initialize components
        initMobileMenu();
        initHeaderSearch();
        initThemeSwitcher();
        initBackToTop();
        initSmoothScrolling();
        initAccessibility();
        initLazyLoading();
        initCommentForm();
        
        // Initialize after page load
        window.addEventListener('load', function() {
            initAnimations();
            optimizePerformance();
        });
    }

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        const menuToggle = document.querySelector('.menu-toggle');
        const navigation = document.querySelector('.main-navigation');
        const menu = document.querySelector('#primary-menu');
        
        if (!menuToggle || !navigation || !menu) return;

        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
            
            // Toggle aria-expanded
            menuToggle.setAttribute('aria-expanded', !isExpanded);
            
            // Toggle menu visibility
            menu.classList.toggle('show');
            
            // Update button text for screen readers
            const toggleText = menuToggle.querySelector('.menu-toggle-text');
            if (toggleText) {
                toggleText.textContent = isExpanded ? 
                    yandexpro_ajax.menu_toggle : 
                    yandexpro_ajax.menu_close;
            }
            
            // Trap focus in mobile menu
            if (!isExpanded) {
                trapFocus(menu);
            } else {
                removeFocusTrap();
            }
        });

        // Close menu on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && menu.classList.contains('show')) {
                menuToggle.click();
                menuToggle.focus();
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navigation.contains(e.target) && menu.classList.contains('show')) {
                menuToggle.click();
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && menu.classList.contains('show')) {
                menu.classList.remove('show');
                menuToggle.setAttribute('aria-expanded', 'false');
                removeFocusTrap();
            }
        });
    }

    /**
     * Header Search Toggle
     */
    function initHeaderSearch() {
        const searchToggle = document.querySelector('.search-toggle');
        const searchForm = document.querySelector('#header-search-form');
        
        if (!searchToggle || !searchForm) return;

        searchToggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            const isExpanded = searchToggle.getAttribute('aria-expanded') === 'true';
            
            // Toggle search form
            searchToggle.setAttribute('aria-expanded', !isExpanded);
            searchForm.hidden = isExpanded;
            
            // Focus search input when opened
            if (!isExpanded) {
                const searchInput = searchForm.querySelector('input[type="search"]');
                if (searchInput) {
                    setTimeout(() => searchInput.focus(), 100);
                }
            }
        });

        // Close search on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !searchForm.hidden) {
                searchForm.hidden = true;
                searchToggle.setAttribute('aria-expanded', 'false');
                searchToggle.focus();
            }
        });
    }

    /**
     * Theme Switcher (Dark/Light Mode)
     */
    function initThemeSwitcher() {
        const themeToggle = document.querySelector('.theme-toggle');
        
        if (!themeToggle) return;

        // Get saved theme or default to light
        const savedTheme = localStorage.getItem('yandexpro-theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);

        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('yandexpro-theme', newTheme);
            
            // Update button label
            const label = newTheme === 'dark' ? 'Переключить на светлую тему' : 'Переключить на тёмную тему';
            themeToggle.setAttribute('aria-label', label);
        });
    }

    /**
     * Back to Top Button
     */
    function initBackToTop() {
        const backToTopButton = document.querySelector('.back-to-top-button');
        
        if (!backToTopButton) return;

        // Show/hide button based on scroll position
        function toggleBackToTop() {
            if (window.pageYOffset > 300) {
                backToTopButton.parentElement.classList.add('show');
            } else {
                backToTopButton.parentElement.classList.remove('show');
            }
        }

        // Smooth scroll to top
        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Throttled scroll listener
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    toggleBackToTop();
                    ticking = false;
                });
                ticking = true;
            }
        });
    }

    /**
     * Smooth Scrolling for Anchor Links
     */
    function initSmoothScrolling() {
        const anchorLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');
        
        anchorLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    e.preventDefault();
                    
                    const headerHeight = document.querySelector('.site-header').offsetHeight;
                    const targetPosition = targetElement.offsetTop - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Focus target element for accessibility
                    targetElement.focus();
                }
            });
        });
    }

    /**
     * Accessibility Enhancements
     */
    function initAccessibility() {
        // Skip link functionality
        const skipLink = document.querySelector('.skip-link');
        if (skipLink) {
            skipLink.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.focus();
                    target.scrollIntoView();
                }
            });
        }

        // Enhanced focus indicators
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', function() {
            document.body.classList.remove('keyboard-navigation');
        });

        // Improve form labels
        const inputs = document.querySelectorAll('input, textarea, select');
        inputs.forEach(function(input) {
            if (!input.getAttribute('aria-label') && !input.id) {
                const label = input.parentElement.querySelector('label');
                if (label && !label.getAttribute('for')) {
                    const inputId = 'input-' + Math.random().toString(36).substr(2, 9);
                    input.id = inputId;
                    label.setAttribute('for', inputId);
                }
            }
        });
    }

    /**
     * Lazy Loading Images
     */
    function initLazyLoading() {
        // Only for browsers that don't support native lazy loading
        if ('loading' in HTMLImageElement.prototype) return;

        const images = document.querySelectorAll('img[loading="lazy"]');
        
        if (images.length === 0) return;

        const imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.classList.remove('lazy');
                    observer.unobserve(img);
                }
            });
        });

        images.forEach(function(img) {
            img.classList.add('lazy');
            imageObserver.observe(img);
        });
    }

    /**
     * Comment Form Enhancements
     */
    function initCommentForm() {
        const commentForm = document.querySelector('#commentform');
        
        if (!commentForm) return;

        // Add character counter for comment field
        const commentField = commentForm.querySelector('#comment');
        if (commentField) {
            const maxLength = 500;
            const counter = document.createElement('div');
            counter.className = 'character-counter';
            counter.setAttribute('aria-live', 'polite');
            
            function updateCounter() {
                const remaining = maxLength - commentField.value.length;
                counter.textContent = `Осталось символов: ${remaining}`;
                
                if (remaining < 50) {
                    counter.classList.add('warning');
                } else {
                    counter.classList.remove('warning');
                }
            }
            
            commentField.addEventListener('input', updateCounter);
            commentField.parentElement.appendChild(counter);
            updateCounter();
        }

        // Form validation
        commentForm.addEventListener('submit', function(e) {
            const requiredFields = commentForm.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                    field.focus();
                } else {
                    field.classList.remove('error');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    /**
     * Animations on Scroll
     */
    function initAnimations() {
        const animatedElements = document.querySelectorAll('.animate-on-scroll');
        
        if (animatedElements.length === 0) return;

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        animatedElements.forEach(function(el) {
            observer.observe(el);
        });
    }

    /**
     * Focus Trap for Modal/Menu
     */
    function trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], select'
        );
        
        const firstFocusableElement = focusableElements[0];
        const lastFocusableElement = focusableElements[focusableElements.length - 1];

        element.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstFocusableElement) {
                        lastFocusableElement.focus();
                        e.preventDefault();
                    }
                } else {
                    if (document.activeElement === lastFocusableElement) {
                        firstFocusableElement.focus();
                        e.preventDefault();
                    }
                }
            }
        });

        // Focus first element
        if (firstFocusableElement) {
            firstFocusableElement.focus();
        }
    }

    /**
     * Remove Focus Trap
     */
    function removeFocusTrap() {
        // Remove event listeners from trapped elements
        const menus = document.querySelectorAll('.main-navigation');
        menus.forEach(function(menu) {
            menu.removeEventListener('keydown', trapFocus);
        });
    }

    /**
     * Performance Optimizations
     */
    function optimizePerformance() {
        // Preload critical resources
        const criticalImages = document.querySelectorAll('img[data-priority="high"]');
        criticalImages.forEach(function(img) {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.as = 'image';
            link.href = img.src;
            document.head.appendChild(link);
        });

        // Defer non-critical scripts
        const deferredScripts = document.querySelectorAll('script[data-defer="true"]');
        deferredScripts.forEach(function(script) {
            script.defer = true;
        });
    }

    /**
     * Utility Functions
     */
    
    // Debounce function
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction() {
            const context = this;
            const args = arguments;
            const later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Throttle function
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // Export functions for external use
    window.YandexProTheme = {
        init: init,
        debounce: debounce,
        throttle: throttle
    };

})();