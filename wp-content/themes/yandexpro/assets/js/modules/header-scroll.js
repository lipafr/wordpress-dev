/**
 * Header Scroll Module
 * Эффекты header при скролле
 * 
 * @package YandexPro
 * @module HeaderScroll
 */

(function() {
    'use strict';

    const HeaderScroll = {
        // Настройки модуля
        settings: {
            headerSelector: '.site-header',
            scrollThreshold: 100,
            scrolledClass: 'scrolled',
            hideThreshold: 200,
            hideClass: 'header-hidden'
        },

        // Элементы DOM
        elements: {},

        // Состояние
        lastScrollY: 0,
        isScrolled: false,
        isHidden: false,
        ticking: false,

        /**
         * Инициализация модуля
         */
        init: function() {
            this.cacheElements();
            this.bindEvents();
            this.updateHeader();
            
            console.log('Header Scroll module initialized');
        },

        /**
         * Кеширование элементов DOM
         */
        cacheElements: function() {
            this.elements = {
                header: document.querySelector(this.settings.headerSelector),
                window: window
            };
        },

        /**
         * Привязка событий
         */
        bindEvents: function() {
            if (!this.elements.header) return;

            // Оптимизированный скролл с requestAnimationFrame
            this.elements.window.addEventListener('scroll', () => {
                if (!this.ticking) {
                    requestAnimationFrame(this.updateHeader.bind(this));
                    this.ticking = true;
                }
            }, { passive: true });

            // Обновление при изменении размера
            this.elements.window.addEventListener('resize', 
                this.debounce(this.handleResize.bind(this), 250));
        },

        /**
         * Обновление состояния header
         */
        updateHeader: function() {
            const currentScrollY = this.elements.window.scrollY;
            const scrollDirection = currentScrollY > this.lastScrollY ? 'down' : 'up';
            
            // Добавляем/убираем класс scrolled
            this.handleScrolledState(currentScrollY);
            
            // Скрытие/показ header при скролле (опционально)
            // this.handleHeaderVisibility(currentScrollY, scrollDirection);
            
            // Изменение стилей в зависимости от скролла
            this.updateHeaderStyles(currentScrollY);
            
            this.lastScrollY = currentScrollY;
            this.ticking = false;
        },

        /**
         * Обработка состояния "прокручен"
         */
        handleScrolledState: function(scrollY) {
            const shouldBeScrolled = scrollY > this.settings.scrollThreshold;
            
            if (shouldBeScrolled && !this.isScrolled) {
                this.elements.header.classList.add(this.settings.scrolledClass);
                this.isScrolled = true;
            } else if (!shouldBeScrolled && this.isScrolled) {
                this.elements.header.classList.remove(this.settings.scrolledClass);
                this.isScrolled = false;
            }
        },

        /**
         * Обработка видимости header (скрытие при скролле вниз)
         */
        handleHeaderVisibility: function(scrollY, direction) {
            const shouldHide = scrollY > this.settings.hideThreshold && direction === 'down';
            const shouldShow = direction === 'up' || scrollY <= this.settings.hideThreshold;
            
            if (shouldHide && !this.isHidden) {
                this.hideHeader();
            } else if (shouldShow && this.isHidden) {
                this.showHeader();
            }
        },

        /**
         * Скрытие header
         */
        hideHeader: function() {
            this.elements.header.classList.add(this.settings.hideClass);
            this.isHidden = true;
        },

        /**
         * Показ header
         */
        showHeader: function() {
            this.elements.header.classList.remove(this.settings.hideClass);
            this.isHidden = false;
        },

        /**
         * Обновление стилей header
         */
        updateHeaderStyles: function(scrollY) {
            const opacity = Math.min(0.95 + (scrollY / 1000) * 0.05, 0.98);
            const blur = Math.min(12 + (scrollY / 100), 16);
            
            this.elements.header.style.setProperty('--header-opacity', opacity);
            this.elements.header.style.setProperty('--header-blur', `${blur}px`);
        },

        /**
         * Обработка изменения размера окна
         */
        handleResize: function() {
            // Пересчитываем позиции при изменении размера
            this.updateHeader();
        },

        /**
         * Debounce функция
         */
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

        /**
         * Плавная прокрутка к элементу
         */
        scrollToElement: function(element, offset = 0) {
            if (typeof element === 'string') {
                element = document.querySelector(element);
            }
            
            if (!element) return;
            
            const headerHeight = this.elements.header.offsetHeight;
            const adminBar = document.querySelector('#wpadminbar');
            const adminBarHeight = adminBar ? adminBar.offsetHeight : 0;
            
            const targetPosition = element.offsetTop - headerHeight - adminBarHeight - offset;
            
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        },

        /**
         * Публичный API
         */
        scrollTo: function(target, offset) {
            this.scrollToElement(target, offset);
        },

        getScrollPosition: function() {
            return this.elements.window.scrollY;
        },

        isHeaderScrolled: function() {
            return this.isScrolled;
        }
    };

    // Автоинициализация при загрузке DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', HeaderScroll.init.bind(HeaderScroll));
    } else {
        HeaderScroll.init();
    }

    // Экспорт в глобальную область
    window.YandexPro = window.YandexPro || {};
    window.YandexPro.HeaderScroll = HeaderScroll;

})();
