/**
 * YandexPro Navigation Scripts
 * 
 * @package YandexPro
 * @since 1.0.0
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        initDropdownMenus();
        initKeyboardNavigation();
        initMobileMenuGestures();
        initStickyHeader();
    });

    /**
     * Dropdown Menus (if needed for future expansion)
     */
    function initDropdownMenus() {
        const menuItems = document.querySelectorAll('.nav-menu li');
        
        menuItems.forEach(item => {
            const submenu = item.querySelector('.sub-menu');
            const link = item.querySelector('a');
            
            if (submenu && link) {
                // Add dropdown indicator
                link.setAttribute('aria-haspopup', 'true');
                link.setAttribute('aria-expanded', 'false');
                
                // Toggle dropdown on click (mobile)
                link.addEventListener('click', function(event) {
                    if (window.innerWidth <= 1024) {
                        event.preventDefault();
                        toggleSubmenu(item, submenu, link);
                    }
                });
                
                // Show dropdown on hover (desktop)
                item.addEventListener('mouseenter', function() {
                    if (window.innerWidth > 1024) {
                        showSubmenu(submenu, link);
                    }
                });
                
                item.addEventListener('mouseleave', function() {
                    if (window.innerWidth > 1024) {
                        hideSubmenu(submenu, link);
                    }
                });
            }
        });

        function toggleSubmenu(item, submenu, link) {
            const isExpanded = link.getAttribute('aria-expanded') === 'true';
            
            // Close all other submenus
            closeAllSubmenus();
            
            if (!isExpanded) {
                showSubmenu(submenu, link);
            }
        }

        function showSubmenu(submenu, link) {
            submenu.style.display = 'block';
            link.setAttribute('aria-expanded', 'true');
            
            // Focus first submenu item
            const firstItem = submenu.querySelector('a');
            if (firstItem) {
                firstItem.focus();
            }
        }

        function hideSubmenu(submenu, link) {
            submenu.style.display = 'none';
            link.setAttribute('aria-expanded', 'false');
        }

        function closeAllSubmenus() {
            const allSubmenus = document.querySelectorAll('.sub-menu');
            const allToggles = document.querySelectorAll('.nav-menu a[aria-haspopup="true"]');
            
            allSubmenus.forEach(submenu => {
                submenu.style.display = 'none';
            });
            
            allToggles.forEach(toggle => {
                toggle.setAttribute('aria-expanded', 'false');
            });
        }

        // Close submenus when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.nav-menu')) {
                closeAllSubmenus();
            }
        });
    }

    /**
     * Keyboard Navigation
     */
    function initKeyboardNavigation() {
        const menuItems = document.querySelectorAll('.nav-menu a');
        
        menuItems.forEach((item, index) => {
            item.addEventListener('keydown', function(event) {
                let targetIndex;
                
                switch (event.key) {
                    case 'ArrowRight':
                    case 'ArrowDown':
                        event.preventDefault();
                        targetIndex = (index + 1) % menuItems.length;
                        menuItems[targetIndex].focus();
                        break;
                        
                    case 'ArrowLeft':
                    case 'ArrowUp':
                        event.preventDefault();
                        targetIndex = (index - 1 + menuItems.length) % menuItems.length;
                        menuItems[targetIndex].focus();
                        break;
                        
                    case 'Home':
                        event.preventDefault();
                        menuItems[0].focus();
                        break;
                        
                    case 'End':
                        event.preventDefault();
                        menuItems[menuItems.length - 1].focus();
                        break;
                        
                    case 'Escape':
                        event.preventDefault();
                        // Close mobile menu or blur current item
                        const menuToggle = document.querySelector('.menu-toggle');
                        if (menuToggle && menuToggle.getAttribute('aria-expanded') === 'true') {
                            menuToggle.click();
                            menuToggle.focus();
                        } else {
                            item.blur();
                        }
                        break;
                }
            });
        });
    }

    /**
     * Mobile Menu Gestures (Swipe to close)
     */
    function initMobileMenuGestures() {
        const menuContainer = document.querySelector('.menu-primary-container');
        const menuToggle = document.querySelector('.menu-toggle');
        
        if (!menuContainer || !menuToggle) return;

        let startX = 0;
        let startY = 0;
        let isScrolling = undefined;

        menuContainer.addEventListener('touchstart', function(event) {
            startX = event.touches[0].clientX;
            startY = event.touches[0].clientY;
            isScrolling = undefined;
        }, { passive: true });

        menuContainer.addEventListener('touchmove', function(event) {
            if (event.touches.length > 1) return;

            const currentX = event.touches[0].clientX;
            const currentY = event.touches[0].clientY;

            if (isScrolling === undefined) {
                isScrolling = Math.abs(currentY - startY) > Math.abs(currentX - startX);
            }

            if (!isScrolling) {
                event.preventDefault();
            }
        }, { passive: false });

        menuContainer.addEventListener('touchend', function(event) {
            if (isScrolling) return;

            const endX = event.changedTouches[0].clientX;
            const deltaX = endX - startX;

            // Swipe left to close menu (threshold: 50px)
            if (deltaX < -50 && menuToggle.getAttribute('aria-expanded') === 'true') {
                menuToggle.click();
            }
        }, { passive: true });
    }

    /**
     * Sticky Header
     */
    function initStickyHeader() {
        const header = document.querySelector('.site-header');
        const stickyOption = document.body.classList.contains('sticky-header');
        
        if (!header || !stickyOption) return;

        let lastScrollTop = 0;
        let isHeaderVisible = true;

        function handleScroll() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const scrollDirection = scrollTop > lastScrollTop ? 'down' : 'up';
            
            if (scrollTop > 100) {
                header.classList.add('is-sticky');
                
                if (scrollDirection === 'down' && isHeaderVisible) {
                    // Scrolling down - hide header
                    header.style.transform = 'translateY(-100%)';
                    isHeaderVisible = false;
                } else if (scrollDirection === 'up' && !isHeaderVisible) {
                    // Scrolling up - show header
                    header.style.transform = 'translateY(0)';
                    isHeaderVisible = true;
                }
            } else {
                header.classList.remove('is-sticky');
                header.style.transform = 'translateY(0)';
                isHeaderVisible = true;
            }
            
            lastScrollTop = scrollTop;
        }

        // Throttled scroll event
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    handleScroll();
                    ticking = false;
                });
                ticking = true;
            }
        });
    }

    /**
     * Focus Trap for Mobile Menu
     */
    function initFocusTrap() {
        const menuToggle = document.querySelector('.menu-toggle');
        const menuContainer = document.querySelector('.menu-primary-container');
        
        if (!menuToggle || !menuContainer) return;

        const focusableElements = menuContainer.querySelectorAll(
            'a, button, input, textarea, select, details, [tabindex]:not([tabindex="-1"])'
        );

        if (focusableElements.length === 0) return;

        const firstFocusable = focusableElements[0];
        const lastFocusable = focusableElements[focusableElements.length - 1];

        menuContainer.addEventListener('keydown', function(event) {
            if (event.key === 'Tab') {
                if (event.shiftKey) {
                    // Shift + Tab
                    if (document.activeElement === firstFocusable) {
                        event.preventDefault();
                        lastFocusable.focus();
                    }
                } else {
                    // Tab
                    if (document.activeElement === lastFocusable) {
                        event.preventDefault();
                        firstFocusable.focus();
                    }
                }
            }
        });
    }

    /**
     * Menu Animation Classes
     */
    function initMenuAnimations() {
        const menuToggle = document.querySelector('.menu-toggle');
        const menuContainer = document.querySelector('.menu-primary-container');
        
        if (!menuToggle || !menuContainer) return;

        // Add CSS classes for animations
        const style = document.createElement('style');
        style.textContent = `
            .menu-primary-container {
                transition: all 0.3s ease;
                transform: translateX(-100%);
                opacity: 0;
            }
            
            .menu-primary-container.active {
                transform: translateX(0);
                opacity: 1;
            }
            
            .menu-primary-container.closing {
                transform: translateX(-100%);
                opacity: 0;
            }
            
            @media (min-width: 1025px) {
                .menu-primary-container {
                    transform: none !important;
                    opacity: 1 !important;
                }
            }
        `;
        document.head.appendChild(style);

        // Enhanced menu toggle with animation
        menuToggle.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            if (isExpanded) {
                // Closing menu
                menuContainer.classList.add('closing');
                setTimeout(() => {
                    menuContainer.classList.remove('active', 'closing');
                }, 300);
            } else {
                // Opening menu
                menuContainer.classList.add('active');
            }
        });
    }

    // Initialize additional navigation features
    initFocusTrap();
    initMenuAnimations();

})();