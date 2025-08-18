/**
 * Contact Form Handler
 * YandexPro Enhanced Theme
 * 
 * Обработка контактной формы с валидацией,
 * AJAX отправкой и улучшенным UX
 */

class YandexProContactForm {
    constructor() {
        this.form = document.getElementById('yandexpro-contact-form');
        this.submitButton = null;
        this.spinner = null;
        this.messages = null;
        this.isSubmitting = false;
        
        // Настройки валидации
        this.validationRules = {
            contact_name: {
                required: true,
                minLength: 2,
                pattern: /^[a-zA-Zа-яА-Я\s\-'\.]+$/u,
                message: 'Введите корректное имя (только буквы, пробелы, дефисы)'
            },
            contact_email: {
                required: true,
                pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                message: 'Введите корректный email адрес'
            },
            contact_phone: {
                required: false,
                pattern: /^[\+]?[1-9][\d]{0,15}$/,
                message: 'Введите корректный номер телефона'
            },
            contact_message: {
                required: true,
                minLength: 10,
                maxLength: 2000,
                message: 'Сообщение должно содержать от 10 до 2000 символов'
            },
            contact_privacy: {
                required: true,
                message: 'Необходимо согласие с политикой конфиденциальности'
            }
        };

        this.init();
    }

    init() {
        if (!this.form) return;

        this.setupElements();
        this.bindEvents();
        this.setupRealTimeValidation();
        
        console.log('YandexPro Contact Form initialized');
    }

    setupElements() {
        this.submitButton = this.form.querySelector('.form-submit-btn');
        this.spinner = this.submitButton?.querySelector('.button-spinner');
        this.messages = this.form.querySelector('#form-messages');
        
        // Создаем элемент для сообщений если его нет
        if (!this.messages) {
            this.messages = document.createElement('div');
            this.messages.id = 'form-messages';
            this.messages.className = 'form-messages';
            this.messages.setAttribute('role', 'alert');
            this.messages.setAttribute('aria-live', 'polite');
            this.form.appendChild(this.messages);
        }
    }

    bindEvents() {
        // Отправка формы
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        
        // Валидация полей при потере фокуса
        const inputs = this.form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });

        // Специальная обработка для чекбокса
        const privacyCheckbox = this.form.querySelector('#contact-privacy');
        if (privacyCheckbox) {
            privacyCheckbox.addEventListener('change', () => this.validateField(privacyCheckbox));
        }

        // Автоматическое форматирование телефона
        const phoneInput = this.form.querySelector('#contact-phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', (e) => this.formatPhone(e));
        }
    }

    setupRealTimeValidation() {
        // Подсчет символов для textarea
        const messageTextarea = this.form.querySelector('#contact-message');
        if (messageTextarea) {
            this.setupCharacterCounter(messageTextarea);
        }
    }

    setupCharacterCounter(textarea) {
        const maxLength = this.validationRules.contact_message.maxLength;
        const counter = document.createElement('div');
        counter.className = 'character-counter';
        counter.setAttribute('aria-live', 'polite');
        
        const updateCounter = () => {
            const currentLength = textarea.value.length;
            counter.textContent = `${currentLength}/${maxLength}`;
            counter.className = 'character-counter' + (currentLength > maxLength ? ' over-limit' : '');
        };

        textarea.addEventListener('input', updateCounter);
        textarea.parentNode.appendChild(counter);
        updateCounter();
    }

    formatPhone(event) {
        let value = event.target.value.replace(/\D/g, '');
        
        // Форматирование российских номеров
        if (value.startsWith('7') || value.startsWith('8')) {
            if (value.startsWith('8')) {
                value = '7' + value.slice(1);
            }
            value = value.replace(/^7(\d{3})(\d{3})(\d{2})(\d{2})$/, '+7 ($1) $2-$3-$4');
        } else if (value.length > 0) {
            // Международный формат
            value = '+' + value;
        }
        
        event.target.value = value;
    }

    validateField(field) {
        const fieldName = field.name;
        const rule = this.validationRules[fieldName];
        
        if (!rule) return true;

        const value = field.type === 'checkbox' ? field.checked : field.value.trim();
        const errors = [];

        // Проверка обязательности
        if (rule.required && (!value || (field.type === 'checkbox' && !field.checked))) {
            errors.push('Это поле обязательно для заполнения');
        }

        // Проверка минимальной длины
        if (value && rule.minLength && value.length < rule.minLength) {
            errors.push(`Минимум ${rule.minLength} символов`);
        }

        // Проверка максимальной длины
        if (value && rule.maxLength && value.length > rule.maxLength) {
            errors.push(`Максимум ${rule.maxLength} символов`);
        }

        // Проверка паттерна
        if (value && rule.pattern && !rule.pattern.test(value)) {
            errors.push(rule.message || 'Некорректный формат');
        }

        // Отображение ошибок
        this.displayFieldError(field, errors);
        
        return errors.length === 0;
    }

    displayFieldError(field, errors) {
        const errorElement = document.getElementById(field.name.replace('contact_', '') + '-error');
        
        if (errors.length > 0) {
            field.classList.add('error');
            field.setAttribute('aria-invalid', 'true');
            
            if (errorElement) {
                errorElement.textContent = errors[0];
                errorElement.style.display = 'block';
            }
        } else {
            field.classList.remove('error');
            field.removeAttribute('aria-invalid');
            
            if (errorElement) {
                errorElement.textContent = '';
                errorElement.style.display = 'none';
            }
        }
    }

    clearFieldError(field) {
        if (field.classList.contains('error')) {
            this.validateField(field);
        }
    }

    validateForm() {
        let isValid = true;
        const inputs = this.form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });

        return isValid;
    }

    async handleSubmit(event) {
        event.preventDefault();
        
        if (this.isSubmitting) return;

        // Валидация формы
        if (!this.validateForm()) {
            this.showMessage('Пожалуйста, исправьте ошибки в форме', 'error');
            this.focusFirstError();
            return;
        }

        this.setSubmittingState(true);

        try {
            const formData = new FormData(this.form);
            
            const response = await fetch(yandexpro_ajax.ajax_url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (result.success) {
                this.handleSuccess(result.message);
            } else {
                this.handleError(result.message || result.errors);
            }

        } catch (error) {
            console.error('Form submission error:', error);
            this.handleError('Произошла ошибка при отправке формы. Попробуйте еще раз.');
        } finally {
            this.setSubmittingState(false);
        }
    }

    handleSuccess(message) {
        this.showMessage(message, 'success');
        this.resetForm();
        
        // Отправляем событие для аналитики
        this.trackFormSubmission('success');
        
        // Скроллим к сообщению
        this.scrollToMessage();
    }

    handleError(errors) {
        if (typeof errors === 'object') {
            // Обработка ошибок полей
            Object.keys(errors).forEach(fieldName => {
                const field = this.form.querySelector(`[name="contact_${fieldName}"]`);
                if (field) {
                    this.displayFieldError(field, [errors[fieldName]]);
                }
            });
            
            this.showMessage('Пожалуйста, исправьте ошибки в форме', 'error');
            this.focusFirstError();
        } else {
            this.showMessage(errors, 'error');
        }
        
        this.trackFormSubmission('error');
    }

    setSubmittingState(isSubmitting) {
        this.isSubmitting = isSubmitting;
        
        if (this.submitButton) {
            this.submitButton.disabled = isSubmitting;
            
            const buttonText = this.submitButton.querySelector('.button-text');
            if (buttonText) {
                buttonText.textContent = isSubmitting ? 'Отправка...' : 'Отправить сообщение';
            }
            
            if (this.spinner) {
                this.spinner.style.display = isSubmitting ? 'inline-block' : 'none';
            }
        }
        
        // Добавляем класс к форме
        this.form.classList.toggle('submitting', isSubmitting);
    }

    showMessage(message, type = 'info') {
        if (!this.messages) return;

        this.messages.className = `form-messages ${type}`;
        this.messages.innerHTML = `
            <div class="message-content">
                <span class="message-icon" aria-hidden="true">
                    ${this.getMessageIcon(type)}
                </span>
                <span class="message-text">${message}</span>
            </div>
        `;
        this.messages.style.display = 'block';

        // Автоматически скрываем сообщения об ошибках через 10 секунд
        if (type === 'error') {
            setTimeout(() => {
                this.hideMessage();
            }, 10000);
        }
    }

    getMessageIcon(type) {
        const icons = {
            success: '✅',
            error: '❌',
            warning: '⚠️',
            info: 'ℹ️'
        };
        return icons[type] || icons.info;
    }

    hideMessage() {
        if (this.messages) {
            this.messages.style.display = 'none';
        }
    }

    resetForm() {
        this.form.reset();
        
        // Очищаем ошибки
        const errorElements = this.form.querySelectorAll('.error-message');
        errorElements.forEach(el => {
            el.textContent = '';
            el.style.display = 'none';
        });
        
        // Убираем классы ошибок
        const errorFields = this.form.querySelectorAll('.error');
        errorFields.forEach(field => {
            field.classList.remove('error');
            field.removeAttribute('aria-invalid');
        });

        // Сбрасываем счетчик символов
        const counter = this.form.querySelector('.character-counter');
        if (counter) {
            const textarea = this.form.querySelector('#contact-message');
            if (textarea) {
                counter.textContent = `0/${this.validationRules.contact_message.maxLength}`;
                counter.className = 'character-counter';
            }
        }
    }

    focusFirstError() {
        const firstErrorField = this.form.querySelector('.error');
        if (firstErrorField) {
            firstErrorField.focus();
            firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    scrollToMessage() {
        if (this.messages) {
            this.messages.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    trackFormSubmission(status) {
        // Google Analytics 4
        if (typeof gtag !== 'undefined') {
            gtag('event', 'form_submit', {
                event_category: 'Contact',
                event_label: 'Contact Form',
                status: status
            });
        }

        // Yandex Metrica
        if (typeof ym !== 'undefined') {
            ym(yandexpro_ajax.metrica_id || '00000000', 'reachGoal', 'contact_form_' + status);
        }

        // Custom event for other tracking
        const event = new CustomEvent('yandexpro_form_submit', {
            detail: { status: status, form: 'contact' }
        });
        document.dispatchEvent(event);
    }
}

// FAQ Accordion Handler
class YandexProFAQ {
    constructor() {
        this.faqItems = document.querySelectorAll('.faq-item');
        this.init();
    }

    init() {
        if (this.faqItems.length === 0) return;

        this.bindEvents();
        console.log('YandexPro FAQ initialized');
    }

    bindEvents() {
        this.faqItems.forEach(item => {
            const button = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');

            if (button && answer) {
                button.addEventListener('click', () => this.toggleFAQ(item, button, answer));
                
                // Keyboard support
                button.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.toggleFAQ(item, button, answer);
                    }
                });
            }
        });
    }

    toggleFAQ(item, button, answer) {
        const isExpanded = button.getAttribute('aria-expanded') === 'true';
        
        // Закрываем все остальные FAQ
        this.faqItems.forEach(otherItem => {
            if (otherItem !== item) {
                this.closeFAQ(otherItem);
            }
        });

        if (isExpanded) {
            this.closeFAQ(item);
        } else {
            this.openFAQ(item);
        }
    }

    openFAQ(item) {
        const button = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        
        button.setAttribute('aria-expanded', 'true');
        answer.setAttribute('aria-hidden', 'false');
        
        item.classList.add('active');
        
        // Анимация открытия
        answer.style.maxHeight = answer.scrollHeight + 'px';
    }

    closeFAQ(item) {
        const button = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        
        button.setAttribute('aria-expanded', 'false');
        answer.setAttribute('aria-hidden', 'true');
        
        item.classList.remove('active');
        
        // Анимация закрытия
        answer.style.maxHeight = '0px';
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Инициализируем контактную форму
    new YandexProContactForm();
    
    // Инициализируем FAQ
    new YandexProFAQ();
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Export for potential external use
window.YandexProContactForm = YandexProContactForm;
window.YandexProFAQ = YandexProFAQ;