/**
 * YandexPro Theme JavaScript
 * Основной функционал темы
 * 
 * @package YandexPro
 * @since 1.0.0
 */

(function() {
    'use strict';

    /**
     * Мобильное меню (точно как в макете)
     */
    const MobileMenu = {
        init: function() {
            this.toggle = document.querySelector('.mobile-menu-toggle');
            this.menu = document.querySelector('.mobile-menu');
            this.menuLinks = document.querySelectorAll('.mobile-menu-list a');
            
            if (this.toggle && this.menu) {
                this.bindEvents();
            }
        },

        bindEvents: function() {
            // Клик по кнопке меню
            this.toggle.addEventListener('click', this.toggleMenu.bind(this));
            
            // Закрытие по клику на ссылку
            this.menuLinks.forEach(link => {
                link.addEventListener('click', this.closeMenu.bind(this));
            });
            
            // Закрытие по ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.menu.classList.contains('active')) {
                    this.closeMenu();
                }
            });
            
            // Закрытие по клику вне меню
            document.addEventListener('click', (e) => {
                if (!this.toggle.contains(e.target) && 
                    !this.menu.contains(e.target) && 
                    this.menu.classList.contains('active')) {
                    this.closeMenu();
                }
            });
        },

        toggleMenu: function() {
            const isExpanded = this.toggle.getAttribute('aria-expanded') === 'true';
            
            if (isExpanded) {
                this.closeMenu();
            } else {
                this.openMenu();
            }
        },

        openMenu: function() {
            this.toggle.classList.add('active');
            this.toggle.setAttribute('aria-expanded', 'true');
            this.menu.classList.add('active');
            document.body.style.overflow = 'hidden'; // Запрет скролла
        },

        closeMenu: function() {
            this.toggle.classList.remove('active');
            this.toggle.setAttribute('aria-expanded', 'false');
            this.menu.classList.remove('active');
            document.body.style.overflow = ''; // Возврат скролла
        }
    };

    /**
     * Скролл-эффекты для шапки
     */
    const HeaderScroll = {
        init: function() {
            this.header = document.querySelector('.site-header');
            this.lastScrollY = window.scrollY;
            
            if (this.header) {
                this.bindEvents();
            }
        },

        bindEvents: function() {
            let ticking = false;
            
            window.addEventListener('scroll', () => {
                if (!ticking) {
                    requestAnimationFrame(this.updateHeader.bind(this));
                    ticking = true;
                }
            });
        },

        updateHeader: function() {
            const currentScrollY = window.scrollY;
            
            // Добавляем класс при скролле
            if (currentScrollY > 100) {
                this.header.classList.add('scrolled');
            } else {
                this.header.classList.remove('scrolled');
            }
            
            this.lastScrollY = currentScrollY;
            
            // Сбрасываем флаг для следующего кадра
            setTimeout(() => {
                let ticking = false;
            }, 16);
        }
    };

    /**
     * Поиск с автодополнением
     */
    const SearchEnhancement = {
        init: function() {
            this.searchBox = document.querySelector('.search-box');
            this.searchContainer = document.querySelector('.search-container');
            
            if (this.searchBox) {
                this.bindEvents();
            }
        },

        bindEvents: function() {
            // Фокус на поиске
            this.searchBox.addEventListener('focus', this.onFocus.bind(this));
            this.searchBox.addEventListener('blur', this.onBlur.bind(this));
            
            // Поиск в реальном времени (с задержкой)
            let searchTimeout;
            this.searchBox.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.handleSearch(e.target.value);
                }, 300);
            });
        },

        onFocus: function() {
            this.searchContainer.classList.add('focused');
        },

        onBlur: function() {
            // Небольшая задержка чтобы успел сработать клик по результатам
            setTimeout(() => {
                this.searchContainer.classList.remove('focused');
            }, 150);
        },

        handleSearch: function(query) {
            if (query.length < 3) return;
            
            // Здесь можно добавить AJAX поиск
            console.log('Searching for:', query);
            
            // Пример использования WordPress REST API
            if (typeof yandexproData !== 'undefined') {
                // this.performAjaxSearch(query);
            }
        }
    };

    /**
     * Анимации при скролле
     */
    const ScrollAnimations = {
        init: function() {
            this.elements = document.querySelectorAll('.animate-on-scroll');
            
            if (this.elements.length > 0) {
                this.createObserver();
            }
        },

        createObserver: function() {
            const options = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            this.observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        // Отключаем наблюдение после анимации
                        this.observer.unobserve(entry.target);
                    }
                });
            }, options);

            this.elements.forEach(element => {
                this.observer.observe(element);
            });
        }
    };

    /**
     * Плавный скролл для якорных ссылок
     */
    const SmoothScroll = {
        init: function() {
            this.links = document.querySelectorAll('a[href^="#"]');
            this.bindEvents();
        },

        bindEvents: function() {
            this.links.forEach(link => {
                link.addEventListener('click', this.handleClick.bind(this));
            });
        },

        handleClick: function(e) {
            const href = e.currentTarget.getAttribute('href');
            const target = document.querySelector(href);
            
            if (target) {
                e.preventDefault();
                
                const headerHeight = document.querySelector('.site-header').offsetHeight;
                const targetPosition = target.offsetTop - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        }
    };

    /**
     * Утилиты
     */
    const Utils = {
        // Debounce функция
        debounce: function(func, wait, immediate) {
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
        },

        // Проверка поддержки пассивных событий
        supportsPassive: function() {
            let supportsPassive = false;
            try {
                const opts = Object.defineProperty({}, 'passive', {
                    get: function() {
                        supportsPassive = true;
                    }
                });
                window.addEventListener('testPassive', null, opts);
                window.removeEventListener('testPassive', null, opts);
            } catch (e) {}
            return supportsPassive;
        }
    };

    /**
     * Newsletter форма
     */
    const Newsletter = {
        init: function() {
            this.form = document.querySelector('.newsletter-form');
            this.input = document.querySelector('.newsletter-input');
            this.button = document.querySelector('.newsletter-btn');
            
            if (this.form) {
                this.bindEvents();
            }
        },

        bindEvents: function() {
            this.form.addEventListener('submit', this.handleSubmit.bind(this));
        },

        handleSubmit: function(e) {
            const email = this.input.value.trim();
            
            if (!this.validateEmail(email)) {
                e.preventDefault();
                this.showMessage('Пожалуйста, введите корректный email адрес', 'error');
                return;
            }

            // Показываем загрузку
            this.setLoading(true);
        },

        validateEmail: function(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        },

        setLoading: function(loading) {
            if (loading) {
                this.button.disabled = true;
                this.button.textContent = 'Подписка...';
            } else {
                this.button.disabled = false;
                this.button.textContent = 'Подписаться';
            }
        },

        showMessage: function(message, type) {
            // Создаем или находим контейнер для сообщений
            let messageContainer = this.form.querySelector('.newsletter-message');
            if (!messageContainer) {
                messageContainer = document.createElement('div');
                messageContainer.className = 'newsletter-message';
                this.form.appendChild(messageContainer);
            }

            messageContainer.textContent = message;
            messageContainer.className = `newsletter-message ${type}`;
            
            // Убираем сообщение через 5 секунд
            setTimeout(() => {
                if (messageContainer.parentNode) {
                    messageContainer.remove();
                }
            }, 5000);
        }
    };

    /**
     * Back to Top кнопка
     */
    const BackToTop = {
        init: function() {
            this.button = document.querySelector('.back-to-top');
            this.backToTopBtn = document.querySelector('.back-to-top-button');
            
            if (this.button) {
                this.bindEvents();
                this.updateVisibility();
            }
        },

        bindEvents: function() {
            // Показ/скрытие при скролле
            window.addEventListener('scroll', Utils.debounce(this.updateVisibility.bind(this), 100));
            
            // Клик по кнопке
            this.backToTopBtn.addEventListener('click', this.scrollToTop.bind(this));
        },

        updateVisibility: function() {
            const scrollY = window.scrollY;
            
            if (scrollY > 300) {
                this.button.classList.add('show');
            } else {
                this.button.classList.remove('show');
            }
        },

        scrollToTop: function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    };

    /**
     * Инициализация всех модулей
     */
    function initYandexPro() {
        MobileMenu.init();
        HeaderScroll.init();
        SearchEnhancement.init();
        ScrollAnimations.init();
        SmoothScroll.init();
        Newsletter.init();
        BackToTop.init();

        // Сообщаем что тема загружена
        document.body.classList.add('yandexpro-loaded');
        
        // Отправляем кастомное событие
        const event = new CustomEvent('yandexproLoaded', {
            detail: { timestamp: Date.now() }
        });
        document.dispatchEvent(event);
    }

    // Запуск после загрузки DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initYandexPro);
    } else {
        initYandexPro();
    }

    // Экспорт в глобальную область для расширений
    window.YandexPro = {
        MobileMenu,
        HeaderScroll,
        SearchEnhancement,
        Newsletter,
        BackToTop,
        Utils
    };

})();