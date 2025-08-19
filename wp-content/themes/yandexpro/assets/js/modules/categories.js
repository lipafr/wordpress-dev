/**
 * Categories Module
 * Интерактивность для блока популярных тем
 * 
 * @package YandexPro
 * @module Categories
 */

(function() {
    'use strict';

    const Categories = {
        // Настройки модуля
        settings: {
            containerSelector: '.categories',
            tagSelector: '.category-tag',
            activeClass: 'active',
            targetSelector: '.latest'
        },

        // Элементы DOM
        elements: {},

        /**
         * Инициализация модуля
         */
        init: function() {
            this.cacheElements();
            this.bindEvents();
            this.setActiveFromURL();
            
            console.log('Categories module initialized');
        },

        /**
         * Кеширование элементов DOM
         */
        cacheElements: function() {
            this.elements = {
                container: document.querySelector(this.settings.containerSelector),
                tags: document.querySelectorAll(this.settings.tagSelector),
                target: document.querySelector(this.settings.targetSelector)
            };
        },

        /**
         * Привязка событий
         */
        bindEvents: function() {
            if (!this.elements.tags.length) return;

            this.elements.tags.forEach(tag => {
                tag.addEventListener('click', this.handleTagClick.bind(this));
                tag.addEventListener('mousedown', this.createRipple.bind(this));
            });
        },

        /**
         * Обработка клика по тегу
         */
        handleTagClick: function(e) {
            e.preventDefault();
            
            const clickedTag = e.currentTarget;
            const categoryName = clickedTag.textContent.trim();
            
            // Убираем активный класс у всех
            this.elements.tags.forEach(tag => {
                tag.classList.remove(this.settings.activeClass);
            });
            
            // Добавляем активный класс к текущему
            clickedTag.classList.add(this.settings.activeClass);
            
            // Фильтрация статей (если нужно)
            this.filterArticles(categoryName);
            
            // Плавная прокрутка
            this.smoothScrollToTarget();
            
            // Обновляем URL (если нужно)
            this.updateURL(categoryName);
            
            console.log('Selected category:', categoryName);
        },

        /**
         * Создание ripple эффекта
         */
        createRipple: function(e) {
            const button = e.currentTarget;
            const ripple = document.createElement('span');
            const rect = button.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255,255,255,0.3);
                transform: scale(0);
                animation: ripple 0.6s linear;
                left: ${x}px;
                top: ${y}px;
                width: ${size}px;
                height: ${size}px;
                pointer-events: none;
            `;
            
            button.style.position = 'relative';
            button.style.overflow = 'hidden';
            button.appendChild(ripple);
            
            setTimeout(() => {
                if (ripple.parentNode) {
                    ripple.remove();
                }
            }, 600);
        },

        /**
         * Фильтрация статей по категории
         */
        filterArticles: function(categoryName) {
            // Здесь будет логика фильтрации статей
            // Пока просто логируем
            console.log('Filtering articles by:', categoryName);
            
            // Пример фильтрации (раскомментировать при необходимости)
            /*
            const articles = document.querySelectorAll('.article-card');
            articles.forEach(article => {
                const articleCategory = article.querySelector('.article-category');
                if (articleCategory) {
                    const match = categoryName === 'Все статьи' || 
                                  articleCategory.textContent.toLowerCase().includes(categoryName.toLowerCase());
                    article.style.display = match ? 'flex' : 'none';
                }
            });
            */
        },

        /**
         * Плавная прокрутка к целевой секции
         */
        smoothScrollToTarget: function() {
            if (!this.elements.target) return;
            
            const header = document.querySelector('.site-header');
            const adminBar = document.querySelector('#wpadminbar');
            
            let offset = 20;
            if (header) offset += header.offsetHeight;
            if (adminBar) offset += adminBar.offsetHeight;
            
            const targetPosition = this.elements.target.offsetTop - offset;
            
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        },

        /**
         * Установка активной категории из URL
         */
        setActiveFromURL: function() {
            const urlParams = new URLSearchParams(window.location.search);
            const category = urlParams.get('category');
            
            if (category) {
                const targetTag = Array.from(this.elements.tags).find(tag => 
                    tag.textContent.trim().toLowerCase() === category.toLowerCase()
                );
                
                if (targetTag) {
                    this.elements.tags.forEach(tag => {
                        tag.classList.remove(this.settings.activeClass);
                    });
                    targetTag.classList.add(this.settings.activeClass);
                }
            }
        },

        /**
         * Обновление URL (опционально)
         */
        updateURL: function(categoryName) {
            // Раскомментировать если нужно обновлять URL
            /*
            const url = new URL(window.location);
            if (categoryName === 'Все статьи') {
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('category', categoryName);
            }
            window.history.replaceState({}, '', url);
            */
        }
    };

    // Автоинициализация при загрузке DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', Categories.init.bind(Categories));
    } else {
        Categories.init();
    }

    // Экспорт в глобальную область для внешнего доступа
    window.YandexPro = window.YandexPro || {};
    window.YandexPro.Categories = Categories;

})();