<?php
/**
 * Footer template
 *
 * @package Perspectiva
 */
?>
<footer class="footer">
    <div class="container">
        <?php
        $logo_footer_url = get_assets_url('images/logo/logo-footer.svg');
        ?>
        <img class="footer__logo" src="<?php echo esc_url($logo_footer_url); ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" width="228" height="54" loading="lazy">
        <div class="footer__wrapper">
            <div class="footer__inner">
                <ul class="footer__list">
                    <li class="footer__list-item"><a class="footer__list-item-link" href="<?php echo esc_url(home_url('/catalog')); ?>">Продукция</a></li>



                    <li class="footer__list-item has-children">
                        <a class="footer__list-item-link" href="<?php echo esc_url( home_url( '/catalog/' ) ); ?>">
                            Каталог
                        </a>

                      <?php
                      $footer_terms = get_terms( array(
                        'taxonomy'   => 'categories',
                        'hide_empty' => true,
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                      ) );
                      ?>

                      <?php if ( ! is_wp_error( $footer_terms ) && ! empty( $footer_terms ) ) : ?>
                          <ul class="footer__sub-list">
                            <?php foreach ( $footer_terms as $term ) : ?>

                              <?php
                              $term_link = get_term_link( $term );
                              if ( is_wp_error( $term_link ) ) {
                                continue;
                              }

                              $products_query = new WP_Query( array(
                                'post_type'      => 'product',
                                'posts_per_page' => -1,
                                'post_status'    => 'publish',
                                'tax_query'      => array(
                                  array(
                                    'taxonomy' => 'categories',
                                    'field'    => 'term_id',
                                    'terms'    => $term->term_id,
                                  ),
                                ),
                              ) );
                              ?>

                              <?php if ( $products_query->have_posts() ) : ?>
                                    <li class="footer__list-item has-children">
                                        <a class="footer__list-item-link" href="<?php echo esc_url( $term_link ); ?>">
                                          <?php echo esc_html( $term->name ); ?>
                                        </a>

                                        <ul class="footer__sub-list">
                                          <?php while ( $products_query->have_posts() ) : $products_query->the_post(); ?>
                                              <li class="footer__sub-item">
                                                  <a class="footer__sub-item-link" href="<?php the_permalink(); ?>">
                                                    <?php the_title(); ?>
                                                  </a>
                                              </li>
                                          <?php endwhile; ?>
                                          <?php wp_reset_postdata(); ?>
                                        </ul>
                                    </li>
                              <?php endif; ?>

                            <?php endforeach; ?>
                          </ul>
                      <?php endif; ?>
                    </li>

                    <li class="footer__list-item"><a class="footer__list-item-link" href="<?php echo esc_url(home_url('/price-list/')); ?>">Прайс-листы</a></li>
                    <li class="footer__list-item"><a class="footer__list-item-link" href="<?php echo esc_url(home_url('/category/')); ?>">Объекты с нашей продукцией</a></li>
                </ul>
                <ul class="footer__list">
                    <li class="footer__list-item"><a class="footer__list-item-link" href="#">Информация</a></li>
                    <li class="footer__list-item"><a class="footer__list-item-link" href="<?php echo esc_url(home_url('/about/')); ?>">О компании</a></li>
                    <li class="footer__list-item"><a class="footer__list-item-link" href="<?php echo esc_url(home_url('/production/')); ?>">Производство</a></li>
                    <li class="footer__list-item"><a class="footer__list-item-link" href="<?php echo esc_url(home_url('/certificates/')); ?>">Сертификаты</a></li>
                    <li class="footer__list-item"><a class="footer__list-item-link" href="<?php echo esc_url(home_url('/novosti-i-stati/')); ?>">Новости и статьи</a></li>
                    <li class="footer__list-item"><a class="footer__list-item-link" href="<?php echo esc_url(home_url('/contacts/')); ?>">Контакты</a></li>
                    <li class="footer__list-item"><a class="footer__list-item-link" href="<?php echo esc_url(home_url('/politic/')); ?>">Политика конфиденциальности</a></li>
                </ul>
                <div class="footer__info-wrapper">
                    <p class="footer__info-title">Контакты</p>
                    <div class="footer__info-inner">
                        <a class="footer__info-link" href="tel:+78005519457">8 (800) 551-94-57</a>
                        <p class="footer__info-text">Телефон в России</p>
                    </div>
                    <div class="footer__info-inner">
                        <a class="footer__info-link" href="tel:+74951289732">+7 (495) 128-97-32</a>
                        <p class="footer__info-text">Телефон в Москве</p>
                    </div>
                    <div class="footer__info-inner">
                        <p class="footer__info-link">Пн-Пт: 09:00-18:00</p>
                        <p class="footer__info-text">Сб-Вс: Выходные</p>
                    </div>
                    <a class="footer__mail" href="mailto:info@fasad-material.ru">info@fasad-material.ru</a>
                    <p class="footer__text">456835, Челябинская область, Касли, ул. Советская, 68/29</p>
                  <?php get_template_part('components/elements/socials'); ?>
                </div>
            </div>
            <div class="footer__bottom">
                <p class="footer__bottom-text">© ООО «ТСК «Перспектива». 2007 — <?php echo date('Y'); ?></p>
                <p class="footer__bottom-text">Производство фиброцементных панелей и фасадных систем</p>
                <a class="footer__bottom-link" href="#">Разработка сайта</a>
            </div>
        </div>
    </div>
</footer>
<?php

get_template_part('components/popups/popup-callback');
get_template_part('components/popups/burger-menu');
?>


<?php wp_footer(); ?>
</body>
</html>
