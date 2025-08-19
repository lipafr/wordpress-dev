/**
 * Mobile Menu Module
 * Функциональность мобильного меню
 * 
 * @package YandexPro
 * @module MobileMenu
 */

(function() {
    'use strict';

    const MobileMenu = {
        // Настройки модуля
        settings: {
            toggleSelector: '[data-mobile-toggle]',
            menuSelector: '[data-mobile-menu]',
            linkSelector: '.mobile-nav-link',
            activeClass: 'active',
            bodyClass: 'mobile-menu-open'
        },

        // Элементы DOM
        elements: {},

        // Состояние
        isOpen: false,

        /**
         * Инициализация модуля
         */
        init: function() {
            this.cacheElements();
            this.bindEvents();
            this.setupAccessibility();
            
            console.log('Mobile Menu module initialized');
        },

        /**
         * Кеширование элементов DOM
         */
        cacheElements: function() {
            this.elements = {
                toggle: document.querySelector(this.settings.toggleSelector),
                menu: document.querySelector(this.settings.menuSelector),
                links: document.querySelectorAll(this.settings.linkSelector),
                body: document.body
            };
        },

        /**
         * Привязка событий
         */
        bindEvents: function() {
            if (!this.elements.toggle || !this.elements.menu) return;

            // Клик по кнопке меню
            this.elements.toggle.addEventListener('click', this.handleToggleClick.bind(this));

            // Клики по ссылкам меню
            this.elements.links.forEach(link => {
                link.addEventListener('click', this.handleLinkClick.bind(this));
            });

            // Закрытие по Escape
            document.addEventListener('keydown', this.handleKeydown.bind(this));

            // Закрытие при изменении размера экрана
            window.addEventListener('resize', this.handleResize.bind(this));

            // Закрытие при клике вне меню
            document.addEventListener('click', this.handleOutsideClick.bind(this));
        },

        /**
         * Настройка доступности
         */
        setupAccessibility: function() {
            if (!this.elements.toggle || !this.elements.menu) return;

            // Устанавливаем ARIA атрибуты
            this.elements.toggle.setAttribute('aria-expanded', 'false');
            this.elements.toggle.setAttribute('aria-controls', this.elements.menu.id || 'mobile-menu');
            this.elements.menu.setAttribute('aria-hidden', 'true');
        },

        /**
         * Обработка клика по кнопке меню
         */
        handleToggleClick: function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            if (this.isOpen) {
                this.closeMenu();
            } else {
                this.openMenu();
            }
        },

        /**
         * Обработка клика по ссылке меню
         */
        handleLinkClick: function(e) {
            // Закрываем меню при клике на ссылку
            this.closeMenu();
            
            // Если это якорная ссылка, добавляем плавную прокрутку
            const href = e.currentTarget.getAttribute('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                this.smoothScrollTo(href);
            }
        },

        /**
         * Обработка нажатия клавиш
         */
        handleKeydown: function(e) {
            if (e.key === 'Escape' && this.isOpen) {
                this.closeMenu();
                this.elements.toggle.focus();
            }
        },

        /**
         * Обработка изменения размера экрана
         */
        handleResize: function() {
            // Закрываем меню при переходе на десктоп
            if (window.innerWidth > 768 && this.isOpen) {
                this.closeMenu();
            }
        },

        /**
         * Обработка клика вне меню
         */
        handleOutsideClick: function(e) {
            if (!this.isOpen) return;
            
            if (!this.elements.toggle.contains(e.target) && 
                !this.elements.menu.contains(e.target)) {
                this.closeMenu();
            }
        },

        /**
         * Открытие меню
         */
        openMenu: function() {
            this.isOpen = true;
            
            // Добавляем классы
            this.elements.toggle.classList.add(this.settings.activeClass);
            this.elements.menu.classList.add(this.settings.activeClass);
            this.elements.body.classList.add(this.settings.bodyClass);
            
            // Обновляем ARIA атрибуты
            this.elements.toggle.setAttribute('aria-expanded', 'true');
            this.elements.menu.setAttribute('aria-hidden', 'false');
            
            console.log('Mobile menu opened');
        },

        /**
         * Закрытие меню
         */
        closeMenu: function() {
            this.isOpen = false;
            
            // Убираем классы
            this.elements.toggle.classList.remove(this.settings.activeClass);
            this.elements.menu.classList.remove(this.settings.activeClass);
            this.elements.body.classList.remove(this.settings.bodyClass);
            
            // Обновляем ARIA атрибуты
            this.elements.toggle.setAttribute('aria-expanded', 'false');
            this.elements.menu.setAttribute('aria-hidden', 'true');
            
            console.log('Mobile menu closed');
        },

        /**
         * Плавная прокрутка к якорю
         */
        smoothScrollTo: function(target) {
            const element = document.querySelector(target);
            if (!element) return;
            
            const header = document.querySelector('.site-header');
            const adminBar = document.querySelector('#wpadminbar');
            
            let offset = 20;
            if (header) offset += header.offsetHeight;
            if (adminBar) offset += adminBar.offsetHeight;
            
            const targetPosition = element.offsetTop - offset;
            
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        },

        /**
         * Публичный API для внешнего управления
         */
        open: function() {
            this.openMenu();
        },

        close: function() {
            this.closeMenu();
        },

        toggle: function() {
            if (this.isOpen) {
                this.closeMenu();
            } else {
                this.openMenu();
            }
        }
    };

    // Автоинициализация при загрузке DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', MobileMenu.init.bind(MobileMenu));
    } else {
        MobileMenu.init();
    }

    // Экспорт в глобальную область
    window.YandexPro = window.YandexPro || {};
    window.YandexPro.MobileMenu = MobileMenu;

})();