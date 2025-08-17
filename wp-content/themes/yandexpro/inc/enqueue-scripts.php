<?php
/**
 * Enqueue Scripts Module
 * 
 * Модульное подключение стилей и скриптов
 *
 * @package YandexPro
 * @since 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ========================================
 * ОСНОВНОЕ ПОДКЛЮЧЕНИЕ РЕСУРСОВ
 * ========================================
 */

/**
 * Enqueue scripts and styles
 */
if (!function_exists('yandexpro_scripts')) {
    function yandexpro_scripts() {
        
        // Основной CSS темы
        wp_enqueue_style(
            'yandexpro-style',
            get_stylesheet_uri(),
            array(),
            YANDEXPRO_VERSION
        );
        
        // Основные скрипты
        wp_enqueue_script(
            'yandexpro-script',
            get_template_directory_uri() . '/assets/js/script.js',
            array(),
            YANDEXPRO_VERSION,
            true
        );

        // Navigation script
        wp_enqueue_script(
            'yandexpro-navigation',
            get_template_directory_uri() . '/assets/js/navigation.js',
            array(),
            YANDEXPRO_VERSION,
            true
        );

        // Локализация скриптов
        wp_localize_script('yandexpro-script', 'yandexpro_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('yandexpro_nonce'),
            'strings'  => array(
                'menu_toggle' => __('Toggle navigation', 'yandexpro'),
                'menu_close'  => __('Close navigation', 'yandexpro'),
                'search'      => __('Search', 'yandexpro'),
            ),
        ));

        // Comment reply script
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
        
        // Условное подключение ресурсов
        yandexpro_enqueue_conditional_assets();
    }
}
add_action('wp_enqueue_scripts', 'yandexpro_scripts');

/**
 * ========================================
 * УСЛОВНОЕ ПОДКЛЮЧЕНИЕ РЕСУРСОВ
 * ========================================
 */

/**
 * Условное подключение ресурсов в зависимости от страницы
 */
if (!function_exists('yandexpro_enqueue_conditional_assets')) {
    function yandexpro_enqueue_conditional_assets() {
        
        // Страница блога
        if (is_page_template('page-templates/page-blog-modern.php')) {
            yandexpro_enqueue_blog_assets();
        }
        
        // Страница контактов
        if (is_page_template('page-templates/page-contact.php')) {
            yandexpro_enqueue_contact_assets();
        }
        
        // Лендинг
        if (is_page_template('page-templates/page-landing.php')) {
            yandexpro_enqueue_landing_assets();
        }
        
        // Админ бар
        if (is_admin_bar_showing()) {
            wp_add_inline_style('yandexpro-style', '
                .admin-bar .site-header {
                    top: 32px;
                }
                @media screen and (max-width: 782px) {
                    .admin-bar .site-header {
                        top: 46px;
                    }
                }
            ');
        }
    }
}

/**
 * ========================================
 * СПЕЦИАЛИЗИРОВАННЫЕ РЕСУРСЫ
 * ========================================
 */

/**
 * Ресурсы для страницы блога
 */
if (!function_exists('yandexpro_enqueue_blog_assets')) {
    function yandexpro_enqueue_blog_assets() {
        
        // CSS модули для блога встроены в основной style.css пока что
        // В будущем можно вынести в отдельные файлы
        
        // JS для блога (функции переключения категорий, анимации и т.д.)
        wp_add_inline_script('yandexpro-script', '
            // Дополнительный JS для блога будет здесь
            document.addEventListener("DOMContentLoaded", function() {
                console.log("Blog assets loaded");
            });
        ');
    }
}

/**
 * Быстрое подключение стилей блога (для использования в шаблонах)
 */
if (!function_exists('yandexpro_enqueue_blog_styles')) {
    function yandexpro_enqueue_blog_styles() {
        // Пока что используем основной style.css
        // В будущем можно добавить отдельные модули
        do_action('yandexpro_blog_styles_loaded');
    }
}

/**
 * Быстрое подключение скриптов блога
 */
if (!function_exists('yandexpro_enqueue_blog_scripts')) {
    function yandexpro_enqueue_blog_scripts() {
        // Пока что используем основной script.js
        // В будущем можно добавить отдельные модули
        do_action('yandexpro_blog_scripts_loaded');
    }
}

/**
 * Ресурсы для страницы контактов
 */
if (!function_exists('yandexpro_enqueue_contact_assets')) {
    function yandexpro_enqueue_contact_assets() {
        
        // Дополнительные стили для форм
        wp_add_inline_style('yandexpro-style', '
            .contact-form {
                max-width: 600px;
                margin: 0 auto;
            }
            .contact-form .form-group {
                margin-bottom: 1.5rem;
            }
            .contact-form input,
            .contact-form textarea {
                width: 100%;
                padding: 12px 16px;
                border: 2px solid #e5e7eb;
                border-radius: 8px;
                font-size: 16px;
                transition: border-color 0.3s ease;
            }
            .contact-form input:focus,
            .contact-form textarea:focus {
                outline: none;
                border-color: #8b5cf6;
                box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
            }
        ');
        
        // JS для валидации форм
        wp_add_inline_script('yandexpro-script', '
            document.addEventListener("DOMContentLoaded", function() {
                const contactForms = document.querySelectorAll(".contact-form");
                contactForms.forEach(function(form) {
                    form.addEventListener("submit", function(e) {
                        // Базовая валидация
                        const requiredFields = form.querySelectorAll("[required]");
                        let isValid = true;
                        
                        requiredFields.forEach(function(field) {
                            if (!field.value.trim()) {
                                field.style.borderColor = "#ef4444";
                                isValid = false;
                            } else {
                                field.style.borderColor = "#e5e7eb";
                            }
                        });
                        
                        if (!isValid) {
                            e.preventDefault();
                            alert("Пожалуйста, заполните все обязательные поля");
                        }
                    });
                });
            });
        ');
    }
}

/**
 * Ресурсы для лендинга
 */
if (!function_exists('yandexpro_enqueue_landing_assets')) {
    function yandexpro_enqueue_landing_assets() {
        
        // Дополнительные стили для лендинга
        wp_add_inline_style('yandexpro-style', '
            .landing-page .hero-section {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .landing-page .cta-button {
                background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
                color: white;
                padding: 16px 32px;
                border-radius: 50px;
                text-decoration: none;
                font-weight: 600;
                display: inline-block;
                transition: all 0.3s ease;
                border: none;
                cursor: pointer;
            }
            .landing-page .cta-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);
                color: white;
                text-decoration: none;
            }
        ');
        
        // JS для лендинга (анимации, плавный скролл и т.д.)
        wp_add_inline_script('yandexpro-script', '
            document.addEventListener("DOMContentLoaded", function() {
                // Плавный скролл для якорных ссылок
                document.querySelectorAll("a[href^=\"#\"]").forEach(function(anchor) {
                    anchor.addEventListener("click", function(e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute("href"));
                        if (target) {
                            target.scrollIntoView({
                                behavior: "smooth",
                                block: "start"
                            });
                        }
                    });
                });
            });
        ');
    }
}

/**
 * ========================================
 * ОПТИМИЗАЦИЯ ПРОИЗВОДИТЕЛЬНОСТИ
 * ========================================
 */

/**
 * Добавление атрибутов к скриптам для улучшения производительности
 */
if (!function_exists('yandexpro_script_attributes')) {
    function yandexpro_script_attributes($tag, $handle, $src) {
        
        // Добавляем defer для некритичных скриптов темы
        $defer_scripts = array(
            'yandexpro-navigation',
        );
        
        if (in_array($handle, $defer_scripts)) {
            $tag = str_replace(' src', ' defer src', $tag);
        }
        
        return $tag;
    }
}
add_filter('script_loader_tag', 'yandexpro_script_attributes', 10, 3);

/**
 * Предзагрузка критически важных ресурсов
 */
if (!function_exists('yandexpro_resource_hints')) {
    function yandexpro_resource_hints($urls, $relation_type) {
        
        switch ($relation_type) {
            case 'preload':
                // Предзагружаем критически важные шрифты
                $urls[] = array(
                    'href' => 'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700;800&display=swap',
                    'as'   => 'style',
                );
                break;
                
            case 'preconnect':
                // Предподключение к Google Fonts
                $urls[] = 'https://fonts.googleapis.com';
                $urls[] = 'https://fonts.gstatic.com';
                break;
        }
        
        return $urls;
    }
}
add_filter('wp_resource_hints', 'yandexpro_resource_hints', 10, 2);

/**
 * ========================================
 * РАЗРАБОТКА И ОТЛАДКА
 * ========================================
 */

if (defined('WP_DEBUG') && WP_DEBUG) {
    
    /**
     * Информация о загруженных ресурсах в режиме отладки
     */
    add_action('wp_footer', function() {
        if (current_user_can('manage_options')) {
            global $wp_scripts, $wp_styles;
            
            $yandexpro_scripts = array();
            $yandexpro_styles = array();
            
            foreach ($wp_scripts->queue as $handle) {
                if (strpos($handle, 'yandexpro-') === 0) {
                    $yandexpro_scripts[] = $handle;
                }
            }
            
            foreach ($wp_styles->queue as $handle) {
                if (strpos($handle, 'yandexpro-') === 0) {
                    $yandexpro_styles[] = $handle;
                }
            }
            
            echo "<!-- YandexPro Debug Info:\n";
            echo "Scripts: " . implode(', ', $yandexpro_scripts) . "\n";
            echo "Styles: " . implode(', ', $yandexpro_styles) . "\n";
            echo "Template: " . get_page_template_slug() . "\n";
            echo "-->\n";
        }
    });
    
    /**
     * Проверка существования файлов ресурсов
     */
    add_action('wp_head', function() {
        if (current_user_can('manage_options')) {
            $critical_files = array(
                '/assets/js/script.js',
                '/assets/js/navigation.js',
                '/style.css',
            );
            
            foreach ($critical_files as $file) {
                $file_path = get_template_directory() . $file;
                if (!file_exists($file_path)) {
                    echo "<!-- YandexPro Warning: Missing file {$file} -->\n";
                }
            }
        }
    });
}

/**
 * ========================================
 * СОВМЕСТИМОСТЬ И FALLBACKS
 * ========================================
 */

/**
 * Fallback для старых браузеров
 */
add_action('wp_head', function() {
    echo '<script>
        // Полифилл для старых браузеров
        if (!Element.prototype.classList) {
            // Простой полифилл для classList
            (function() {
                var regExp = function(name) {
                    return new RegExp("(^| )" + name + "( |$)");
                };
                var forEach = function(list, fn, scope) {
                    for (var i = 0; i < list.length; i++) {
                        fn.call(scope, list[i]);
                    }
                };
                
                Element.prototype.classList = {
                    add: function(name) {
                        if (!this.contains(name)) {
                            this.className += " " + name;
                        }
                    },
                    remove: function(name) {
                        this.className = this.className.replace(regExp(name), "");
                    },
                    contains: function(name) {
                        return regExp(name).test(this.className);
                    }
                };
            })();
        }
    </script>';
});

/**
 * ========================================
 * ХУКИ ДЛЯ РАСШИРЕНИЯ
 * ========================================
 */

// Хук после подключения всех ресурсов
add_action('wp_enqueue_scripts', function() {
    do_action('yandexpro_scripts_enqueued');
}, 999);

// Позволяем другим модулям добавлять свои ресурсы
do_action('yandexpro_enqueue_scripts_loaded');