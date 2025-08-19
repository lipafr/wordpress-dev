<?php get_header(); ?>

<style>
/* ПРИНУДИТЕЛЬНЫЕ СТИЛИ ДЛЯ СЕКЦИЙ */
.forced-section {
    padding: 60px 0 !important;
    background: #f8fafc !important;
}
.forced-grid-3 {
    display: grid !important;
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 24px !important;
}
.forced-grid-2 {
    display: grid !important;
    grid-template-columns: 2fr 1fr !important;
    gap: 24px !important;
}
.forced-card {
    background: white !important;
    border-radius: 16px !important;
    overflow: hidden !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1) !important;
    height: 400px !important;
    display: flex !important;
    flex-direction: column !important;
}
.forced-image {
    height: 200px !important;
    background: linear-gradient(135deg, #667eea, #764ba2) !important;
    position: relative !important;
}
.forced-badge {
    position: absolute !important;
    top: 12px !important;
    left: 12px !important;
    background: rgba(255,255,255,0.9) !important;
    color: #7c3aed !important;
    padding: 4px 10px !important;
    border-radius: 12px !important;
    font-size: 11px !important;
    font-weight: 600 !important;
}
.forced-content {
    padding: 20px !important;
    flex: 1 !important;
    display: flex !important;
    flex-direction: column !important;
}
.forced-newsletter {
    padding: 80px 0 !important;
    background: linear-gradient(135deg, #7c3aed, #ec4899) !important;
    color: white !important;
    text-align: center !important;
}
</style>

<!-- ПРИНУДИТЕЛЬНО ДОБАВЛЕННЫЕ СЕКЦИИ -->

<!-- Featured Articles - УЖЕ ЕСТЬ В HEADER -->

<!-- Categories -->
<section class="forced-section">
    <div class="container">
        <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 40px; color: #111827;">Популярные темы</h2>
        <div style="display: flex; flex-wrap: wrap; gap: 16px; justify-content: center;">
            <a href="#" style="padding: 12px 24px; background: white; color: #475569; text-decoration: none; border-radius: 50px; font-weight: 500; border: 1px solid #e2e8f0;">Яндекс Директ</a>
            <a href="#" style="padding: 12px 24px; background: white; color: #475569; text-decoration: none; border-radius: 50px; font-weight: 500; border: 1px solid #e2e8f0;">Google Ads</a>
            <a href="#" style="padding: 12px 24px; background: white; color: #475569; text-decoration: none; border-radius: 50px; font-weight: 500; border: 1px solid #e2e8f0;">Аналитика</a>
            <a href="#" style="padding: 12px 24px; background: white; color: #475569; text-decoration: none; border-radius: 50px; font-weight: 500; border: 1px solid #e2e8f0;">SEO</a>
            <a href="#" style="padding: 12px 24px; background: white; color: #475569; text-decoration: none; border-radius: 50px; font-weight: 500; border: 1px solid #e2e8f0;">SMM</a>
            <a href="#" style="padding: 12px 24px; background: #7c3aed; color: white; text-decoration: none; border-radius: 50px; font-weight: 500;">Все статьи</a>
        </div>
    </div>
</section>

<!-- Latest Articles -->
<section class="forced-section">
    <div class="container">
        <h2 style="font-size: 32px; font-weight: 700; margin-bottom: 40px; color: #111827;">Новое на сайте</h2>
        
        <!-- Первая строка - 3 карточки -->
        <div class="forced-grid-3" style="margin-bottom: 24px;">
            <article class="forced-card">
                <div class="forced-image">
                    <span class="forced-badge">ЯНДЕКС ДИРЕКТ</span>
                </div>
                <div class="forced-content">
                    <div style="font-size: 12px; color: #9ca3af; margin-bottom: 12px;">12 января 2025 • 5 мин</div>
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 12px; line-height: 1.4; color: #111827;">Новые возможности автоматических стратегий в 2025 году</h3>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5; flex: 1;">Обзор последних обновлений в автоматических стратегиях Яндекс Директ и как их использовать для максимальной эффективности кампаний.</p>
                </div>
            </article>

            <article class="forced-card">
                <div class="forced-image">
                    <span class="forced-badge">АНАЛИТИКА</span>
                </div>
                <div class="forced-content">
                    <div style="font-size: 12px; color: #9ca3af; margin-bottom: 12px;">10 января 2025 • 7 мин</div>
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 12px; line-height: 1.4; color: #111827;">GA4 vs Яндекс Метрика: сравнение для контекстной рекламы</h3>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5; flex: 1;">Детальное сравнение двух главных систем аналитики. Какую выбрать для отслеживания эффективности рекламных кампаний в 2025 году.</p>
                </div>
            </article>

            <article class="forced-card">
                <div class="forced-image">
                    <span class="forced-badge">GOOGLE ADS</span>
                </div>
                <div class="forced-content">
                    <div style="font-size: 12px; color: #9ca3af; margin-bottom: 12px;">8 января 2025 • 6 мин</div>
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 12px; line-height: 1.4; color: #111827;">Performance Max кампании: полное руководство</h3>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5; flex: 1;">Как правильно настроить и оптимизировать Performance Max кампании в Google Ads. Практические советы и частые ошибки.</p>
                </div>
            </article>
        </div>

        <!-- Вторая строка - 2 карточки -->
        <div class="forced-grid-2" style="margin-bottom: 24px;">
            <article class="forced-card">
                <div class="forced-image">
                    <span class="forced-badge">ИНСТРУМЕНТЫ</span>
                </div>
                <div class="forced-content">
                    <div style="font-size: 12px; color: #9ca3af; margin-bottom: 12px;">5 января 2025 • 4 мин</div>
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 12px; line-height: 1.4; color: #111827;">ТОП-10 инструментов для сбора семантики в 2025</h3>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5; flex: 1;">Актуальный список лучших инструментов для сбора и анализа семантического ядра. Бесплатные и платные решения с примерами использования.</p>
                </div>
            </article>

            <article class="forced-card">
                <div class="forced-image">
                    <span class="forced-badge">SEO</span>
                </div>
                <div class="forced-content">
                    <div style="font-size: 12px; color: #9ca3af; margin-bottom: 12px;">3 января 2025 • 8 мин</div>
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 12px; line-height: 1.4; color: #111827;">Интеграция SEO и контекстной рекламы: синергия каналов</h3>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5; flex: 1;">Как объединить SEO-продвижение и контекстную рекламу для максимального охвата целевой аудитории. Стратегии и кейсы.</p>
                </div>
            </article>
        </div>

        <!-- Третья строка - 3 карточки -->
        <div class="forced-grid-3">
            <article class="forced-card">
                <div class="forced-image">
                    <span class="forced-badge">КЕЙСЫ</span>
                </div>
                <div class="forced-content">
                    <div style="font-size: 12px; color: #9ca3af; margin-bottom: 12px;">1 января 2025 • 10 мин</div>
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 12px; line-height: 1.4; color: #111827;">Запуск рекламы для B2B стартапа: от 0 до 1M рублей оборота</h3>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5; flex: 1;">История успеха B2B стартапа, который за 6 месяцев вырос с нуля до миллионного оборота благодаря грамотной настройке контекстной рекламы.</p>
                </div>
            </article>

            <article class="forced-card">
                <div class="forced-image">
                    <span class="forced-badge">КОНВЕРСИИ</span>
                </div>
                <div class="forced-content">
                    <div style="font-size: 12px; color: #9ca3af; margin-bottom: 12px;">28 декабря 2024 • 6 мин</div>
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 12px; line-height: 1.4; color: #111827;">Оптимизация лендингов для контекстной рекламы</h3>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5; flex: 1;">Проверенные методы повышения конверсии посадочных страниц. Практические советы по дизайну, тексту и техническим аспектам.</p>
                </div>
            </article>

            <article class="forced-card">
                <div class="forced-image">
                    <span class="forced-badge">БЮДЖЕТЫ</span>
                </div>
                <div class="forced-content">
                    <div style="font-size: 12px; color: #9ca3af; margin-bottom: 12px;">25 декабря 2024 • 5 мин</div>
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 12px; line-height: 1.4; color: #111827;">Как правильно распределить рекламный бюджет между каналами</h3>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5; flex: 1;">Методика планирования и распределения бюджета между Яндекс Директ, Google Ads и другими каналами привлечения трафика.</p>
                </div>
            </article>
        </div>

        <!-- Пагинация -->
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 40px 0; border-top: 1px solid #e2e8f0; margin-top: 40px;">
            <div>
                <span style="background: white; padding: 12px 20px; border-radius: 8px; border: 1px solid #e2e8f0; color: #64748b; cursor: pointer;">Показать еще ↓</span>
            </div>
            <div style="display: flex; gap: 16px; align-items: center;">
                <button style="padding: 12px 16px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; color: #cbd5e1; cursor: not-allowed;" disabled>← Сюда</button>
                <span style="font-weight: 600; color: #111827;">1</span>
                <button style="padding: 12px 16px; background: white; border: 1px solid #e2e8f0; border-radius: 8px; color: #64748b; cursor: pointer;">Туда →</button>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="forced-newsletter">
    <div class="container">
        <h2 style="font-size: 36px; font-weight: 800; margin-bottom: 16px;">Не пропустите новые статьи</h2>
        <p style="font-size: 18px; margin-bottom: 40px; opacity: 0.9;">Подпишитесь на рассылку и получайте лучшие материалы о контекстной рекламе</p>
        <form style="display: flex; gap: 16px; max-width: 500px; margin: 0 auto;" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <?php wp_nonce_field('yandexpro_newsletter', 'newsletter_nonce'); ?>
            <input type="hidden" name="action" value="yandexpro_newsletter">
            <input type="email" name="email" placeholder="Ваш email" required style="flex: 1; padding: 16px 20px; border: none; border-radius: 50px; font-size: 16px; outline: none;">
            <button type="submit" style="background: white; color: #7c3aed; padding: 16px 32px; border: none; border-radius: 50px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">Подписаться</button>
        </form>
    </div>
</section>

<script>
// Добавляем мобильную адаптацию
if (window.innerWidth <= 768) {
    const grids = document.querySelectorAll('.forced-grid-3, .forced-grid-2');
    grids.forEach(grid => {
        grid.style.gridTemplateColumns = '1fr';
    });
}
</script>

<?php get_footer(); ?>