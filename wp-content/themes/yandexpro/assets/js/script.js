/**
 * YandexPro Enhanced Theme JavaScript
 * Минимальная версия для базовой функциональности
 * 
 * @package YandexPro
 * @since 1.0.0
 */

(function() {
    'use strict';
    
    // Theme object
    const YandexPro = {
        
        /**
         * Initialize all functions
         */
        init: function() {
            console.log('YandexPro Theme JavaScript loaded');
            this.setupAccessibility();
            this.setupForms();
            this.setupAnimations();
            
            // Announce theme loaded
            this.announceToScreenReader('Theme loaded successfully');
        },
        
        /**
         * Setup accessibility features
         */
        setupAccessibility: function() {
            // Skip link functionality
            const skipLink = document.querySelector('.skip-link');
            if (skipLink) {
                skipLink.addEventListener('click', function(e) {
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.focus();
                    }
                });
            }
            
            // Focus visible for keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    document.body.classList.add('keyboard-navigation');
                }
            });
            
            document.addEventListener('mousedown', function() {
                document.body.classList.remove('keyboard-navigation');
            });
        },
        
        /**
         * Setup form enhancements
         */
        setupForms: function() {
            // Search form enhancements
            const searchForms = document.querySelectorAll('.search-form');
            searchForms.forEach(function(form) {
                const input = form.querySelector('input[type="search"]');
                const button = form.querySelector('button, input[type="submit"]');
                
                if (input && button) {
                    // Clear button functionality
                    input.addEventListener('input', function() {
                        if (this.value.length > 0) {
                            this.classList.add('has-value');
                        } else {
                            this.classList.remove('has-value');
                        }
                    });
                    
                    // Form validation
                    form.addEventListener('submit', function(e) {
                        if (input.value.trim().length === 0) {
                            e.preventDefault();
                            input.focus();
                            input.classList.add('error');
                            
                            setTimeout(function() {
                                input.classList.remove('error');
                            }, 3000);
                        }
                    });
                }
            });
        },
        
        /**
         * Setup scroll animations
         */
        setupAnimations: function() {
            // Intersection Observer for animations
            if ('IntersectionObserver' in window) {
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };
                
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-in');
                        }
                    });
                }, observerOptions);
                
                // Observe elements with animation classes
                const animateElements = document.querySelectorAll('.animate-on-scroll, .post-card, .widget');
                animateElements.forEach(function(el) {
                    observer.observe(el);
                });
            }
        },
        
        /**
         * Announce to screen readers
         */
        announceToScreenReader: function(message) {
            const announcement = document.createElement('div');
            announcement.setAttribute('aria-live', 'polite');
            announcement.setAttribute('aria-atomic', 'true');
            announcement.className = 'sr-only';
            announcement.textContent = message;
            
            document.body.appendChild(announcement);
            
            setTimeout(function() {
                document.body.removeChild(announcement);
            }, 1000);
        }
    };
    
    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', YandexPro.init.bind(YandexPro));
    } else {
        YandexPro.init();
    }
    
    // Expose to global scope for modules
    window.YandexPro = YandexPro;
    
})();