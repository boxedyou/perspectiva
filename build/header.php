<?php
/**
 * Header template
 *
 * @package Perspectiva
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="//cdn.callibri.ru/callibri.js" type="text/javascript" charset="utf-8" defer></script>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function (m, e, t, r, i, k, a) {
            m[i] = m[i] || function () {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            for (var j = 0; j < document.scripts.length; j++) {
                if (document.scripts[j].src === r) return;
            }
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a);
        })(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        // ЗАМЕНИ 12345678 на ID твоего счётчика
        ym(94256132, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/94256132" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
// Подключаем header компонент
$logo_url = get_assets_url('images/logo/logo.svg');
$logo_mobile_url = get_assets_url('images/logo/logo-mobile.svg');
?>
<header class="header" data-header>
    <div class="header__wrapper">
        <a class="header__logo-inner" href="<?php echo esc_url(home_url('/')); ?>">
            <img class="header__logo" src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>" width="168" height="120" loading="lazy">
        </a>
        <div class="header__inner">
            <div class="header__item">
                <a class="header__logo-mobile-inner" href="<?php echo esc_url(home_url('/')); ?>">
                    <img class="header__logo-mobile" src="<?php echo esc_url($logo_mobile_url); ?>" alt="<?php bloginfo('name'); ?>" width="172" height="40" loading="lazy">
                </a>


                <nav class="header__nav">
                    <ul class="header__nav-list">
                        <li class="header__list-item has-children">
                            <a href="<?php echo esc_url( home_url( '/catalog/' ) ); ?>">Каталог</a>
                            <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.5 0.5L5.5 5.5L10.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                          <?php
                          // Термины таксономии categories, у которых есть товары (product)
                          $catalog_terms = get_terms( [
                            'taxonomy'   => 'categories',
                            'hide_empty' => true,
                            'orderby'    => 'name',
                            'order'      => 'ASC',
                          ] );
                          ?>

                          <?php if ( ! is_wp_error( $catalog_terms ) && ! empty( $catalog_terms ) ) : ?>
                              <ul class="header__sub-list">
                                <?php foreach ( $catalog_terms as $term ) : ?>
                                    <li class="header__sub-item">
                                        <a class="header__sub-link" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
                                          <?php echo esc_html( $term->name ); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                              </ul>
                          <?php else : ?>
                              <!-- Если терминов нет, можно оставить твой статичный запасной вариант или ничего не выводить -->
                          <?php endif; ?>
                        </li>

                        <li class="header__list-item">
                            <a href="<?php echo esc_url( home_url( '/price-list/' ) ); ?>">Прайс-лист</a>
                        </li>
                        <li class="header__list-item has-children">
                            <a href="<?php echo esc_url( home_url( '/about/' ) ); ?>">О компании</a>
                            <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.5 0.5L5.5 5.5L10.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <ul class="header__sub-list">
                                <li class="header__sub-item">
                                    <a class="header__sub-link" href="<?php echo esc_url(home_url('/production/')); ?>">Производство</a>
                                </li>
                                <li class="header__sub-item">
                                    <a class="header__sub-link" href="<?php echo esc_url(home_url('/certificates/')); ?>">Сертификаты</a>
                                </li>
                                <li class="header__sub-item">
                                    <a class="header__sub-link" href="<?php echo esc_url(home_url('/novosti-i-stati/')); ?>">Новости и статьи</a>
                                </li>
                            </ul>
                        </li>
                        <li class="header__list-item">
                            <a href="<?php echo esc_url( home_url( '/category/' ) ); ?>">Объекты с нашей продукцией</a>
                        </li>
                        <li class="header__list-item">
                            <a href="<?php echo esc_url( home_url( '/contacts/' ) ); ?>">Контакты</a>
                        </li>
                    </ul>
                </nav>


                <div class="header__text-inner">
                    <p class="header__text">Производство и продажа фиброцементных панелей и фасадных систем</p>
                    <button class="header__button-icon" type="button" data-callback-popup-open>
                        <svg class="header__popup" width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="40" height="40" rx="6" fill="#B81618"/>
                            <path d="M27.551 11.776a1.34 1.34 0 00-1.344-1.336H13.793a1.34 1.34 0 00-1.344 1.336v16.448a1.34 1.34 0 001.344 1.336h12.414a1.34 1.34 0 001.344-1.336V11.776zM15.872 25.448c.4 0 .725.323.725.72 0 .398-.325.72-.725.72h-.01a.722.722 0 01-.724-.72c0-.397.324-.72.724-.72h.01zm4.138 0c.4 0 .724.323.724.72 0 .398-.324.72-.724.72H20a.722.722 0 01-.724-.72c0-.397.324-.72.724-.72h.01zm3.403.72v-4.112c0-.397.325-.72.725-.72.4 0 .724.323.724.72v4.112c0 .398-.324.72-.724.72a.722.722 0 01-.725-.72zm-7.54-4.832c.4 0 .724.323.724.72 0 .397-.325.72-.725.72h-.01a.722.722 0 01-.724-.72c0-.397.324-.72.724-.72h.01zm4.137 0c.4 0 .724.323.724.72 0 .397-.324.72-.724.72H20a.722.722 0 01-.724-.72c0-.397.324-.72.724-.72h.01zm-4.138-4.112c.4 0 .725.323.725.72 0 .397-.325.72-.725.72h-.01a.722.722 0 01-.724-.72c0-.397.324-.72.724-.72h.01zm4.138 0c.4 0 .724.323.724.72 0 .397-.324.72-.724.72H20a.722.722 0 01-.724-.72c0-.397.324-.72.724-.72h.01zm4.138 0c.4 0 .724.323.724.72 0 .397-.324.72-.724.72h-.01a.722.722 0 01-.725-.72c0-.397.325-.72.725-.72h.01zm-.01-4.112c.4 0 .724.322.724.72 0 .397-.324.72-.724.72h-8.276a.722.722 0 01-.724-.72c0-.398.324-.72.724-.72h8.276zM29 28.224A2.785 2.785 0 0126.207 31H13.793A2.785 2.785 0 0111 28.224V11.776A2.785 2.785 0 0113.793 9h12.414A2.785 2.785 0 0129 11.776v16.448z" fill="#fff"/>
                        </svg>
                    </button>
                    <button class="header__button-icon" type="button" >
                        <svg class="header__burger-menu" data-burger-menu-open width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.5" y="0.5" width="39" height="39" rx="5.5" stroke="white" stroke-opacity="0.3"/>
                            <path d="M10 14H30M10 20H30M10 26H30" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <svg class="header__burger-menu" data-burger-menu-close width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="40" height="40" rx="6" fill="white"/>
                            <path d="M24.9983 14.1718C25.2273 13.9427 25.5992 13.9427 25.8282 14.1718C26.0573 14.4008 26.0573 14.7727 25.8282 15.0017L20.83 20L25.8282 24.9983C26.0573 25.2273 26.0573 25.5992 25.8282 25.8282C25.5992 26.0573 25.2273 26.0573 24.9983 25.8282L20 20.83L15.0017 25.8282C14.7727 26.0573 14.4008 26.0573 14.1718 25.8282C13.9427 25.5992 13.9427 25.2273 14.1718 24.9983L19.17 20L14.1718 15.0017C13.9427 14.7727 13.9427 14.4008 14.1718 14.1718C14.4008 13.9427 14.7727 13.9427 15.0017 14.1718L20 19.17L24.9983 14.1718Z" fill="#161A1F"/>
                        </svg>

                    </button>
                </div>
            </div>
            <div class="header__item">
                <div class="header__info-wrapper">
                    <div class="header__info-inner">
                        <a class="header__info" href="tel:+78005519457">8 (800) 551-94-57</a>
                        <p class="header__info-text">Телефон в России</p>
                    </div>
                    <div class="header__info-inner">
                        <a class="header__info" href="tel:+74951289732">+7 (495) 128-97-32</a>
                        <p class="header__info-text">Телефон в Москве</p>
                    </div>
                    <div class="header__info-inner">
                        <p class="header__info">Пн-Пт: 09:00-18:00</p>
                        <p class="header__info-text">Сб-Вс: Выходные</p>
                    </div>
                </div>
                <div class="header__button-wrapper">
                    <p class="header__button-text">Челябинская область, город Касли, ул. Советская, 68/29</p>
                    <button class="header__button" type="button" data-callback-popup-open>Заказать расчёт фасада
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.5514 3.77585C19.5514 3.03776 18.9495 2.43963 18.2068 2.43963H5.79324C5.05053 2.43963 4.44865 3.03776 4.44865 3.77585V20.2241C4.44865 20.9622 5.05053 21.5604 5.79324 21.5604H18.2068C18.9495 21.5604 19.5514 20.9622 19.5514 20.2241V3.77585ZM7.87226 17.4483C8.27219 17.4483 8.59659 17.7707 8.59659 18.1681C8.59659 18.5655 8.27219 18.8879 7.87226 18.8879H7.86216C7.46224 18.8879 7.13784 18.5655 7.13784 18.1681C7.13784 17.7707 7.46224 17.4483 7.86216 17.4483H7.87226ZM12.0101 17.4483C12.41 17.4483 12.7344 17.7707 12.7344 18.1681C12.7344 18.5655 12.41 18.8879 12.0101 18.8879H12C11.6001 18.8879 11.2757 18.5655 11.2757 18.1681C11.2757 17.7707 11.6001 17.4483 12 17.4483H12.0101ZM15.4135 18.1681V14.056C15.4135 13.6586 15.7379 13.3362 16.1378 13.3362C16.5378 13.3362 16.8622 13.6586 16.8622 14.056V18.1681C16.8622 18.5655 16.5378 18.8879 16.1378 18.8879C15.7379 18.8879 15.4135 18.5655 15.4135 18.1681ZM7.87226 13.3362C8.27219 13.3362 8.59659 13.6586 8.59659 14.056C8.59659 14.4535 8.27219 14.7759 7.87226 14.7759H7.86216C7.46224 14.7759 7.13784 14.4535 7.13784 14.056C7.13784 13.6586 7.46224 13.3362 7.86216 13.3362H7.87226ZM12.0101 13.3362C12.41 13.3362 12.7344 13.6586 12.7344 14.056C12.7344 14.4535 12.41 14.7759 12.0101 14.7759H12C11.6001 14.7759 11.2757 14.4535 11.2757 14.056C11.2757 13.6586 11.6001 13.3362 12 13.3362H12.0101ZM7.87226 9.22415C8.27219 9.22415 8.59659 9.54653 8.59659 9.94396C8.59659 10.3414 8.27219 10.6638 7.87226 10.6638H7.86216C7.46224 10.6638 7.13784 10.3414 7.13784 9.94396C7.13784 9.54653 7.46224 9.22415 7.86216 9.22415H7.87226ZM12.0101 9.22415C12.41 9.22415 12.7344 9.54653 12.7344 9.94396C12.7344 10.3414 12.41 10.6638 12.0101 10.6638H12C11.6001 10.6638 11.2757 10.3414 11.2757 9.94396C11.2757 9.54653 11.6001 9.22415 12 9.22415H12.0101ZM16.1479 9.22415C16.5479 9.22415 16.8723 9.54653 16.8723 9.94396C16.8723 10.3414 16.5479 10.6638 16.1479 10.6638H16.1378C15.7379 10.6638 15.4135 10.3414 15.4135 9.94396C15.4135 9.54653 15.7379 9.22415 16.1378 9.22415H16.1479ZM16.1378 5.11207C16.5378 5.11207 16.8622 5.43446 16.8622 5.83189C16.8622 6.22932 16.5378 6.5517 16.1378 6.5517H7.86216C7.46224 6.5517 7.13784 6.22932 7.13784 5.83189C7.13784 5.43446 7.46224 5.11207 7.86216 5.11207H16.1378ZM21 20.2241C21 21.7571 19.7493 23 18.2068 23H5.79324C4.25069 23 3 21.7571 3 20.2241V3.77585C3 2.2429 4.25069 1 5.79324 1H18.2068C19.7493 1 21 2.2429 21 3.77585V20.2241Z" fill="white"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
