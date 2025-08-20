/**
 * YandexPro Theme JavaScript - УПРОЩЕННАЯ ВЕРСИЯ
 * Базовый функционал без модулей
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Мобильное меню
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', function() {
            mobileToggle.classList.toggle('active');
            mobileMenu.classList.toggle('active');
        });
        
        // Закрытие по клику на ссылку
        const mobileLinks = document.querySelectorAll('.mobile-menu-list a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
            });
        });
    }
    
    // Скролл эффекты для header
    const header = document.querySelector('.site-header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.borderBottom = '1px solid rgba(17, 24, 39, 0.12)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.85)';
                header.style.borderBottom = '1px solid rgba(17, 24, 39, 0.08)';
            }
        });
    }
    
    // Поиск
    const searchBox = document.querySelector('.search-box');
    if (searchBox) {
        searchBox.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            console.log('Searching for:', query);
        });
    }
    
    // Категории
    const categoryTags = document.querySelectorAll('.category-tag');
    categoryTags.forEach(tag => {
        tag.addEventListener('click', function(e) {
            e.preventDefault();
            
            categoryTags.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            console.log('Selected category:', this.textContent);
        });
    });
    
    // Newsletter форма
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            const email = this.querySelector('.newsletter-input').value;
            if (email && email.includes('@')) {
                // Форма отправится нормально
                console.log('Newsletter signup:', email);
            } else {
                e.preventDefault();
                alert('Пожалуйста, введите корректный email адрес');
            }
        });
    }
    
    console.log('YandexPro theme loaded successfully!');
});