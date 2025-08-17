/**
 * YandexPro Personal Theme Scripts
 * 
 * @package YandexPro
 * @since 1.0.0
 */

(function() {
    'use strict';

    // DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
        initMobileNavigation();
        initSearchToggle();
        initThemeToggle();
        initBackToTop();
        initSmoothScrolling();
        initAccessibility();
    });

    /**
     * Mobile Navigation
     */
    function initMobileNavigation() {
        const menuToggle = document.querySelector('.menu-toggle');
        const menuContainer = document.querySelector('.menu-primary-container');
        
        if (!menuToggle || !menuContainer) return;

        menuToggle.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            // Toggle ARIA state
            this.setAttribute('aria-expanded', !isExpanded);
            
            // Toggle menu visibility
            menuContainer.classList.toggle('active');
            
            // Toggle body scroll (prevent scrolling when menu is open)
            document.body.classList.toggle('menu-open', !isExpanded);
            
            // Focus management
            if (!isExpanded) {
                // Menu opened - focus first menu item
                const firstMenuItem = menuContainer.querySelector('a');
                if (firstMenuItem) {
                    firstMenuItem.focus();
                }
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.main-navigation')) {
                closeMenu();
            }
        });

        // Close menu on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeMenu();
            }
        });

        // Close menu on window resize (when switching to desktop)
        window.addEventListener('resize', function() {
            if (window.innerWidth > 1024) {
                closeMenu();
            }
        });

        function closeMenu() {
            menuToggle.setAttribute('aria-expanded', 'false');
            menuContainer.classList.remove('active');
            document.body.classList.remove('menu-open');
        }
    }

    /**
     * Search Toggle
     */
    function initSearchToggle() {
        const searchToggle = document.querySelector('.search-toggle');
        const headerSearch = document.querySelector('.header-search');
        const searchInput = headerSearch?.querySelector('input[type="search"]');
        
        if (!searchToggle || !headerSearch) return;

        searchToggle.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            // Toggle ARIA state
            this.setAttribute('aria-expanded', !isExpanded);
            
            // Toggle search visibility
            headerSearch.classList.toggle('active');
            headerSearch.setAttribute('aria-hidden', isExpanded);
            
            // Focus management
            if (!isExpanded && searchInput) {
                setTimeout(() => searchInput.focus(), 100);
            }
        });

        // Close search when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.header-actions') && !event.target.closest('.header-search')) {
                closeSearch();
            }
        });

        // Close search on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && headerSearch.classList.contains('active')) {
                closeSearch();
                searchToggle.focus();
            }
        });

        function closeSearch() {
            searchToggle.setAttribute('aria-expanded', 'false');
            headerSearch.classList.remove('active');
            headerSearch.setAttribute('aria-hidden', 'true');
        }
    }

    /**
     * Theme Toggle (Dark/Light Mode)
     */
    function initThemeToggle() {
        const themeToggle = document.querySelector('.theme-toggle');
        
        if (!themeToggle) return;

        // Get saved theme from localStorage or default to 'light'
        const savedTheme = localStorage.getItem('yandexpro-theme') || 'light';
        setTheme(savedTheme);

        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            setTheme(newTheme);
        });

        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('yandexpro-theme', theme);
            
            // Update button aria-label
            const label = theme === 'light' 
                ? yandexpro_vars.strings.theme_toggle_dark || 'Switch to dark theme'
                : yandexpro_vars.strings.theme_toggle_light || 'Switch to light theme';
            
            themeToggle.setAttribute('aria-label', label);
        }
    }

    /**
     * Back to Top Button
     */
    function initBackToTop() {
        const backToTopButton = document.querySelector('.back-to-top');
        
        if (!backToTopButton) return;

        // Show/hide button based on scroll position
        function toggleBackToTop() {
            if (window.pageYOffset > 300) {
                backToTopButton.style.display = 'flex';
                setTimeout(() => {
                    backToTopButton.style.opacity = '1';
                    backToTopButton.style.transform = 'translateY(0)';
                }, 10);
            } else {
                backToTopButton.style.opacity = '0';
                backToTopButton.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    if (backToTopButton.style.opacity === '0') {
                        backToTopButton.style.display = 'none';
                    }
                }, 300);
            }
        }

        // Throttled scroll event
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

        // Smooth scroll to top
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Initial check
        toggleBackToTop();
    }

    /**
     * Smooth Scrolling for Anchor Links
     */
    function initSmoothScrolling() {
        // Only apply to internal anchor links
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        
        anchorLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    event.preventDefault();
                    
                    // Calculate offset for fixed header
                    const headerHeight = document.querySelector('.site-header')?.offsetHeight || 0;
                    const targetPosition = targetElement.offsetTop - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Focus the target element for accessibility
                    targetElement.focus({ preventScroll: true });
                }
            });
        });
    }

    /**
     * Accessibility Enhancements
     */
    function initAccessibility() {
        // Skip link functionality
        const skipLink = document.querySelector('a[href="#main"]');
        if (skipLink) {
            skipLink.addEventListener('click', function(event) {
                event.preventDefault();
                const mainContent = document.getElementById('main');
                if (mainContent) {
                    mainContent.focus();
                    mainContent.scrollIntoView({ behavior: 'smooth' });
                }
            });
        }

        // Keyboard navigation for dropdowns and menus
        const menuItems = document.querySelectorAll('.nav-menu a');
        menuItems.forEach(item => {
            item.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    // Allow default behavior for Enter (navigation)
                    // For space, prevent default and trigger click
                    if (event.key === ' ') {
                        event.preventDefault();
                        this.click();
                    }
                }
            });
        });

        // Focus visible elements
        const focusableElements = document.querySelectorAll(
            'a[href], button, input, textarea, select, details, [tabindex]:not([tabindex="-1"])'
        );
        
        focusableElements.forEach(element => {
            element.addEventListener('focus', function() {
                this.classList.add('has-focus');
            });
            
            element.addEventListener('blur', function() {
                this.classList.remove('has-focus');
            });
        });
    }

    /**
     * Image Lazy Loading Fallback
     * (For browsers that don't support native lazy loading)
     */
    function initLazyLoading() {
        if ('loading' in HTMLImageElement.prototype) {
            // Native lazy loading is supported
            return;
        }

        // Fallback for older browsers
        const images = document.querySelectorAll('img[loading="lazy"]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src || img.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            images.forEach(img => {
                imageObserver.observe(img);
            });
        } else {
            // Fallback for browsers without IntersectionObserver
            images.forEach(img => {
                img.src = img.dataset.src || img.src;
            });
        }
    }

    /**
     * Form Enhancements
     */
    function initFormEnhancements() {
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            // Add loading state to submit buttons
            const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
            
            if (submitButton) {
                form.addEventListener('submit', function() {
                    submitButton.disabled = true;
                    submitButton.textContent = yandexpro_vars.strings.loading || 'Loading...';
                    
                    // Re-enable after 5 seconds as fallback
                    setTimeout(() => {
                        submitButton.disabled = false;
                        submitButton.textContent = submitButton.dataset.originalText || 'Submit';
                    }, 5000);
                });
                
                // Store original text
                submitButton.dataset.originalText = submitButton.textContent;
            }
        });

        // Enhance search forms
        const searchForms = document.querySelectorAll('.search-form, form[role="search"]');
        searchForms.forEach(form => {
            const searchInput = form.querySelector('input[type="search"]');
            if (searchInput) {
                // Clear button
                const clearButton = document.createElement('button');
                clearButton.type = 'button';
                clearButton.className = 'search-clear';
                clearButton.innerHTML = '×';
                clearButton.setAttribute('aria-label', 'Clear search');
                clearButton.style.display = 'none';
                
                searchInput.parentNode.appendChild(clearButton);
                
                searchInput.addEventListener('input', function() {
                    clearButton.style.display = this.value ? 'block' : 'none';
                });
                
                clearButton.addEventListener('click', function() {
                    searchInput.value = '';
                    this.style.display = 'none';
                    searchInput.focus();
                });
            }
        });
    }

    /**
     * Performance Monitoring
     */
    function initPerformanceMonitoring() {
        if ('performance' in window && 'navigation' in performance) {
            window.addEventListener('load', function() {
                setTimeout(() => {
                    const perfData = performance.getEntriesByType('navigation')[0];
                    const loadTime = perfData.loadEventEnd - perfData.loadEventStart;
                    
                    // Log performance data (only in development)
                    if (window.location.hostname === 'localhost' || window.location.hostname.includes('dev')) {
                        console.log('Page load time:', loadTime + 'ms');
                        console.log('DOM Content Loaded:', perfData.domContentLoadedEventEnd - perfData.domContentLoadedEventStart + 'ms');
                    }
                }, 1000);
            });
        }
    }

    // Initialize additional features
    initLazyLoading();
    initFormEnhancements();
    initPerformanceMonitoring();

})();