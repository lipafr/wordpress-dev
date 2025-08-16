<?php
/**
 * Block patterns for YandexPro theme
 *
 * @package YandexPro
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register block patterns
 */
function yandexpro_register_block_patterns() {
    
    // Check if block patterns are supported
    if (!function_exists('register_block_pattern')) {
        return;
    }

    // Register pattern categories
    register_block_pattern_category(
        'yandexpro',
        array(
            'label' => __('YandexPro', 'yandexpro'),
        )
    );

    // Hero Section Pattern
    register_block_pattern(
        'yandexpro/hero-section',
        array(
            'title'       => __('Hero секция', 'yandexpro'),
            'description' => __('Главная секция с заголовком, описанием и кнопкой', 'yandexpro'),
            'content'     => '<!-- wp:cover {"url":"","dimRatio":30,"overlayColor":"primary","minHeight":500,"align":"full"} -->
<div class="wp-block-cover alignfull has-primary-background-color has-background-dim-30 has-background-dim" style="min-height:500px"><div class="wp-block-cover__inner-container"><!-- wp:group {"layout":{"type":"constrained","contentSize":"800px"}} -->
<div class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":1,"fontSize":"xxx-large"} -->
<h1 class="wp-block-heading has-text-align-center has-xxx-large-font-size">Эксперты по Яндекс.Директ и интернет-маркетингу</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size">Практические кейсы, инсайты и тренды из мира контекстной рекламы. Только проверенная информация от практикующих специалистов.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"2rem"}}}} -->
<div class="wp-block-buttons" style="margin-top:2rem"><!-- wp:button {"backgroundColor":"accent","style":{"border":{"radius":"6px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-accent-background-color has-background wp-element-button" style="border-radius:6px">Читать блог</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->',
            'categories'  => array('yandexpro'),
        )
    );

    // Features Section Pattern
    register_block_pattern(
        'yandexpro/features-section',
        array(
            'title'       => __('Секция особенностей', 'yandexpro'),
            'description' => __('Сетка с преимуществами и особенностями', 'yandexpro'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"light"} -->
<div class="wp-block-group has-light-background-color has-background" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:heading {"textAlign":"center","fontSize":"xx-large"} -->
<h2 class="wp-block-heading has-text-align-center has-xx-large-font-size">Почему выбирают нас</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"bottom":"3rem"}}}} -->
<p class="has-text-align-center" style="margin-bottom:3rem">Мы предоставляем только актуальную и проверенную информацию</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"2rem","left":"2rem"}}}} -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","right":"1.5rem","bottom":"2rem","left":"1.5rem"}},"border":{"radius":"8px"}},"backgroundColor":"white","className":"feature-card"} -->
<div class="wp-block-group feature-card has-white-background-color has-background" style="border-radius:8px;padding-top:2rem;padding-right:1.5rem;padding-bottom:2rem;padding-left:1.5rem"><!-- wp:heading {"textAlign":"center","level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">🎯 Практический опыт</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Реальные кейсы и стратегии, которые работают в Яндекс.Директ. Без воды и теории.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","right":"1.5rem","bottom":"2rem","left":"1.5rem"}},"border":{"radius":"8px"}},"backgroundColor":"white","className":"feature-card"} -->
<div class="wp-block-group feature-card has-white-background-color has-background" style="border-radius:8px;padding-top:2rem;padding-right:1.5rem;padding-bottom:2rem;padding-left:1.5rem"><!-- wp:heading {"textAlign":"center","level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">📊 Актуальные данные</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Свежие тренды и изменения в алгоритмах. Первыми узнавайте о новых возможностях.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","right":"1.5rem","bottom":"2rem","left":"1.5rem"}},"border":{"radius":"8px"}},"backgroundColor":"white","className":"feature-card"} -->
<div class="wp-block-group feature-card has-white-background-color has-background" style="border-radius:8px;padding-top:2rem;padding-right:1.5rem;padding-bottom:2rem;padding-left:1.5rem"><!-- wp:heading {"textAlign":"center","level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-large-font-size">🚀 Результат</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Проверенные методы увеличения конверсии и снижения стоимости клика в рекламных кампаниях.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
            'categories'  => array('yandexpro'),
        )
    );

    // Call to Action Pattern
    register_block_pattern(
        'yandexpro/call-to-action',
        array(
            'title'       => __('Призыв к действию', 'yandexpro'),
            'description' => __('Секция с призывом к действию и кнопкой', 'yandexpro'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem","left":"2rem","right":"2rem"}}},"backgroundColor":"primary","textColor":"white"} -->
<div class="wp-block-group has-white-color has-primary-background-color has-text-color has-background" style="padding-top:4rem;padding-right:2rem;padding-bottom:4rem;padding-left:2rem"><!-- wp:heading {"textAlign":"center","fontSize":"xx-large"} -->
<h2 class="wp-block-heading has-text-align-center has-xx-large-font-size">Готовы улучшить свои рекламные кампании?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"large","style":{"spacing":{"margin":{"bottom":"2rem"}}}} -->
<p class="has-text-align-center has-large-font-size" style="margin-bottom:2rem">Подпишитесь на наш блог и получайте еженедельные инсайты о контекстной рекламе</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"accent","style":{"border":{"radius":"6px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-accent-background-color has-background wp-element-button" style="border-radius:6px">Подписаться на блог</a></div>
<!-- /wp:button -->

<!-- wp:button {"backgroundColor":"white","textColor":"primary","style":{"border":{"radius":"6px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-primary-color has-white-background-color has-text-color has-background wp-element-button" style="border-radius:6px">Связаться с нами</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
            'categories'  => array('yandexpro'),
        )
    );

    // Blog Posts Grid Pattern
    register_block_pattern(
        'yandexpro/blog-posts-grid',
        array(
            'title'       => __('Сетка постов блога', 'yandexpro'),
            'description' => __('Сетка с последними записями блога', 'yandexpro'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"3rem","bottom":"3rem"}}}} -->
<div class="wp-block-group" style="padding-top:3rem;padding-bottom:3rem"><!-- wp:heading {"textAlign":"center","fontSize":"xx-large"} -->
<h2 class="wp-block-heading has-text-align-center has-xx-large-font-size">Последние статьи</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"bottom":"3rem"}}}} -->
<p class="has-text-align-center" style="margin-bottom:3rem">Свежие материалы о Яндекс.Директ и интернет-маркетинге</p>
<!-- /wp:paragraph -->

<!-- wp:latest-posts {"postsToShow":6,"displayPostContent":true,"excerptLength":20,"displayAuthor":true,"displayPostDate":true,"postLayout":"grid","columns":3,"displayFeaturedImage":true,"featuredImageAlign":"top","featuredImageSizeSlug":"yandexpro-medium","addLinkToFeaturedImage":true} /-->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"2rem"}}}} -->
<div class="wp-block-buttons" style="margin-top:2rem"><!-- wp:button {"style":{"border":{"radius":"6px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" style="border-radius:6px">Все статьи</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
            'categories'  => array('yandexpro'),
        )
    );

    // Statistics Pattern
    register_block_pattern(
        'yandexpro/statistics',
        array(
            'title'       => __('Статистика и цифры', 'yandexpro'),
            'description' => __('Секция с важными цифрами и статистикой', 'yandexpro'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"light"} -->
<div class="wp-block-group has-light-background-color has-background" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:heading {"textAlign":"center","fontSize":"xx-large","style":{"spacing":{"margin":{"bottom":"3rem"}}}} -->
<h2 class="wp-block-heading has-text-align-center has-xx-large-font-size" style="margin-bottom:3rem">Наши результаты</h2>
<!-- /wp:heading -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"2rem","left":"2rem"}}}} -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","right":"1rem","bottom":"2rem","left":"1rem"}}},"className":"stat-card"} -->
<div class="wp-block-group stat-card" style="padding-top:2rem;padding-right:1rem;padding-bottom:2rem;padding-left:1rem"><!-- wp:heading {"textAlign":"center","level":3,"fontSize":"xxx-large","textColor":"accent"} -->
<h3 class="wp-block-heading has-text-align-center has-accent-color has-text-color has-xxx-large-font-size">500+</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size">Успешных кампаний</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","right":"1rem","bottom":"2rem","left":"1rem"}}},"className":"stat-card"} -->
<div class="wp-block-group stat-card" style="padding-top:2rem;padding-right:1rem;padding-bottom:2rem;padding-left:1rem"><!-- wp:heading {"textAlign":"center","level":3,"fontSize":"xxx-large","textColor":"accent"} -->
<h3 class="wp-block-heading has-text-align-center has-accent-color has-text-color has-xxx-large-font-size">-40%</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size">Снижение CPC</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","right":"1rem","bottom":"2rem","left":"1rem"}}},"className":"stat-card"} -->
<div class="wp-block-group stat-card" style="padding-top:2rem;padding-right:1rem;padding-bottom:2rem;padding-left:1rem"><!-- wp:heading {"textAlign":"center","level":3,"fontSize":"xxx-large","textColor":"accent"} -->
<h3 class="wp-block-heading has-text-align-center has-accent-color has-text-color has-xxx-large-font-size">+150%</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size">Рост конверсии</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","right":"1rem","bottom":"2rem","left":"1rem"}}},"className":"stat-card"} -->
<div class="wp-block-group stat-card" style="padding-top:2rem;padding-right:1rem;padding-bottom:2rem;padding-left:1rem"><!-- wp:heading {"textAlign":"center","level":3,"fontSize":"xxx-large","textColor":"accent"} -->
<h3 class="wp-block-heading has-text-align-center has-accent-color has-text-color has-xxx-large-font-size">1000+</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"large"} -->
<p class="has-text-align-center has-large-font-size">Довольных клиентов</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
            'categories'  => array('yandexpro'),
        )
    );

    // About Section Pattern
    register_block_pattern(
        'yandexpro/about-section',
        array(
            'title'       => __('О нас секция', 'yandexpro'),
            'description' => __('Секция с информацией о компании', 'yandexpro'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}}} -->
<div class="wp-block-group" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"3rem","left":"3rem"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"40%"} -->
<div class="wp-block-column" style="flex-basis:40%"><!-- wp:image {"sizeSlug":"large","linkDestination":"none","style":{"border":{"radius":"8px"}}} -->
<figure class="wp-block-image size-large has-custom-border"><img src="" alt="" style="border-radius:8px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"60%","style":{"spacing":{"padding":{"left":"2rem"}}}} -->
<div class="wp-block-column" style="padding-left:2rem;flex-basis:60%"><!-- wp:heading {"fontSize":"xx-large"} -->
<h2 class="wp-block-heading has-xx-large-font-size">Мы знаем Яндекс.Директ изнутри</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"large","style":{"spacing":{"margin":{"bottom":"2rem"}}}} -->
<p class="has-large-font-size" style="margin-bottom:2rem">Команда экспертов с многолетним опытом работы в контекстной рекламе делится практическими знаниями и инсайтами.</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li>Более 7 лет опыта в Яндекс.Директ</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Сертифицированные специалисты</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Авторы обучающих курсов</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Спикеры на профильных конференциях</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"2rem"}}}} -->
<div class="wp-block-buttons" style="margin-top:2rem"><!-- wp:button {"style":{"border":{"radius":"6px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" style="border-radius:6px">Узнать больше</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
            'categories'  => array('yandexpro'),
        )
    );

    // FAQ Section Pattern
    register_block_pattern(
        'yandexpro/faq-section',
        array(
            'title'       => __('Часто задаваемые вопросы', 'yandexpro'),
            'description' => __('Секция с FAQ', 'yandexpro'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"backgroundColor":"light"} -->
<div class="wp-block-group has-light-background-color has-background" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:heading {"textAlign":"center","fontSize":"xx-large","style":{"spacing":{"margin":{"bottom":"3rem"}}}} -->
<h2 class="wp-block-heading has-text-align-center has-xx-large-font-size" style="margin-bottom:3rem">Часто задаваемые вопросы</h2>
<!-- /wp:heading -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"2rem","left":"2rem"}}}} -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"padding":{"top":"1.5rem","right":"1.5rem","bottom":"1.5rem","left":"1.5rem"}},"border":{"radius":"8px"}},"backgroundColor":"white","className":"faq-item"} -->
<div class="wp-block-group faq-item has-white-background-color has-background" style="border-radius:8px;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Как часто выходят новые статьи?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Мы публикуем новые материалы 2-3 раза в неделю. Подпишитесь на уведомления, чтобы не пропустить важные обновления.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"1.5rem","right":"1.5rem","bottom":"1.5rem","left":"1.5rem"}},"border":{"radius":"8px"}},"backgroundColor":"white","className":"faq-item"} -->
<div class="wp-block-group faq-item has-white-background-color has-background" style="border-radius:8px;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Можно ли задать вопрос?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Конечно! Оставляйте комментарии под статьями или пишите нам напрямую. Мы отвечаем на все вопросы.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"style":{"spacing":{"padding":{"top":"1.5rem","right":"1.5rem","bottom":"1.5rem","left":"1.5rem"}},"border":{"radius":"8px"}},"backgroundColor":"white","className":"faq-item"} -->
<div class="wp-block-group faq-item has-white-background-color has-background" style="border-radius:8px;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Есть ли платные материалы?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Основной контент блога полностью бесплатный. Дополнительно предлагаем углубленные курсы и консультации.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"1.5rem","right":"1.5rem","bottom":"1.5rem","left":"1.5rem"}},"border":{"radius":"8px"}},"backgroundColor":"white","className":"faq-item"} -->
<div class="wp-block-group faq-item has-white-background-color has-background" style="border-radius:8px;padding-top:1.5rem;padding-right:1.5rem;padding-bottom:1.5rem;padding-left:1.5rem"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Подходит ли для новичков?</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Да! У нас есть материалы как для начинающих, так и для продвинутых специалистов. Статьи маркированы по уровню сложности.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
            'categories'  => array('yandexpro'),
        )
    );

    // Contact Section Pattern
    register_block_pattern(
        'yandexpro/contact-section',
        array(
            'title'       => __('Контактная секция', 'yandexpro'),
            'description' => __('Секция с контактной информацией', 'yandexpro'),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}}} -->
<div class="wp-block-group" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:heading {"textAlign":"center","fontSize":"xx-large","style":{"spacing":{"margin":{"bottom":"3rem"}}}} -->
<h2 class="wp-block-heading has-text-align-center has-xx-large-font-size" style="margin-bottom:3rem">Свяжитесь с нами</h2>
<!-- /wp:heading -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"3rem","left":"3rem"}}}} -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Написать нам</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Есть вопросы о рекламе или предложения по сотрудничеству? Мы будем рады помочь!</p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"blockGap":"1rem"}}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p><strong>📧 Email:</strong> info@yandexpro.com</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>📱 Telegram:</strong> @yandexpro</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>🕐 Время работы:</strong> Пн-Пт, 9:00-18:00 (МСК)</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Быстрая связь</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Оставьте заявку, и мы свяжемся с вами в течение рабочего дня.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"blockGap":"1rem"}}} -->
<div class="wp-block-group"><!-- wp:html -->
<form class="contact-form">
<div class="form-group">
<label for="contact-name">Имя *</label>
<input type="text" id="contact-name" name="name" required>
</div>
<div class="form-group">
<label for="contact-email">Email *</label>
<input type="email" id="contact-email" name="email" required>
</div>
<div class="form-group">
<label for="contact-message">Сообщение *</label>
<textarea id="contact-message" name="message" rows="4" required></textarea>
</div>
<button type="submit" class="btn btn-primary">Отправить сообщение</button>
</form>
<!-- /wp:html --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
            'categories'  => array('yandexpro'),
        )
    );
}

add_action('init', 'yandexpro_register_block_patterns');

/**
 * Remove default core patterns if needed
 */
function yandexpro_remove_core_patterns() {
    // Uncomment to remove specific core patterns
    // remove_theme_support('core-block-patterns');
}
// add_action('after_setup_theme', 'yandexpro_remove_core_patterns');
?>