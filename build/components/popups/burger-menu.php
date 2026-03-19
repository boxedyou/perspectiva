<aside class="burger-menu" data-burger-menu>
    <div class="burger-menu__wrapper">
        <div class="burger-menu__item">
            <ul class="burger-menu__list">
                <li class="burger-menu__list-item">
                    <a class="burger-menu__item-link" href="<?php echo esc_url( home_url( '/catalog/' ) ); ?>">Каталог</a>
                </li>

              <?php
              // Термины таксономии categories, у которых есть товары
              $burger_terms = get_terms( [
                'taxonomy'   => 'categories',
                'hide_empty' => true,
                'orderby'    => 'name',
                'order'      => 'ASC',
              ] );

              if ( ! is_wp_error( $burger_terms ) && ! empty( $burger_terms ) ) :
                foreach ( $burger_terms as $term ) :
                  ?>
                    <li class="burger-menu__list-item">
                        <a class="burger-menu__item-link" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
                          <?php echo esc_html( $term->name ); ?>
                        </a>

                      <?php
                      // Товары этого термина
                      $products_query = new WP_Query( [
                        'post_type'      => 'product',
                        'posts_per_page' => -1,
                        'post_status'    => 'publish',
                        'tax_query'      => [
                          [
                            'taxonomy' => 'categories',
                            'field'    => 'term_id',
                            'terms'    => $term->term_id,
                          ],
                        ],
                      ] );
                      ?>

                      <?php if ( $products_query->have_posts() ) : ?>
                          <ul class="burger-menu__sub-list">
                            <?php while ( $products_query->have_posts() ) : $products_query->the_post(); ?>
                                <li class="burger-menu__sub-item">
                                    <a class="burger-menu__sub-link" href="<?php the_permalink(); ?>">
                                        – <?php the_title(); ?>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                          </ul>
                        <?php wp_reset_postdata(); ?>
                      <?php endif; ?>
                    </li>
                <?php
                endforeach;
              endif;
              ?>
            </ul>
            <ul class="burger-menu__list">
                <li class="burger-menu__list-item"><a class="burger-menu__item-link" href="#">Информация</a></li>
                <li class="burger-menu__list-item"><a class="burger-menu__item-link" href="<?php echo esc_url( home_url( '/price-list/' ) ); ?>">Прайс-листы</a></li>
                <li class="burger-menu__list-item"><a class="burger-menu__item-link" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">О нас</a></li>
                <li class="burger-menu__list-item"><a class="burger-menu__item-link" href="<?php echo esc_url(home_url('/production/')); ?>">Производство</a></li>
                <li class="burger-menu__list-item"><a class="burger-menu__item-link" href="<?php echo esc_url(home_url('/certificates/')); ?>">Сертификаты</a></li>
                <li class="burger-menu__list-item"><a class="burger-menu__item-link" href="<?php echo esc_url(home_url('/novosti-i-stati/')); ?>">Новости и статьи</a></li>
                <li class="burger-menu__list-item"><a class="burger-menu__item-link" href="<?php echo esc_url( home_url( '/category/' ) ); ?>">Объекты с нашей продукцией</a></li>
                <li class="burger-menu__list-item"><a class="burger-menu__item-link" href="<?php echo esc_url( home_url( '/contacts/' ) ); ?>">Контакты</a></li>
            </ul>
        </div>
        <div class="burger-menu__item">
            <div class="burger-menu__contacts">
                <h2 class="burger-menu__contacts-title">Контакты</h2>
                <div class="burger-menu__contacts-item">
                    <a class="burger-menu__contacts-link" href="tel:+78005519457">8 (800) 551-94-57</a>
                    <p class="burger-menu__contacts-text">Телефон в России</p>
                </div>
                <div class="burger-menu__contacts-item">
                    <a class="burger-menu__contacts-link" href="tel:+74951289732">+7 (495) 128-97-32</a>
                    <p class="burger-menu__contacts-text">Телефон в Москве</p>
                </div>
                <div class="burger-menu__contacts-item">
                    <p class="burger-menu__contacts-text-top">Пн-Пт: 09:00-18:00</p>
                    <p class="burger-menu__contacts-text">Телефон в Москве</p>
                </div>
            </div>
            <a class="burger-menu__mail" href="mailto:info@fasad-material.ru">info@fasad-material.ru</a>
          <p class="burger-menu__address">456835, Челябинская область, Касли, ул. Советская, 68/29</p>
          <?php get_template_part('components/elements/socials'); ?>
            <button class="burger-menu__button" data-callback-popup-open>Заказать расчёт фасада
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.5514 3.77585C19.5514 3.03776 18.9495 2.43963 18.2068 2.43963H5.79324C5.05053 2.43963 4.44865 3.03776 4.44865 3.77585V20.2241C4.44865 20.9622 5.05053 21.5604 5.79324 21.5604H18.2068C18.9495 21.5604 19.5514 20.9622 19.5514 20.2241V3.77585ZM7.87226 17.4483C8.27219 17.4483 8.59659 17.7707 8.59659 18.1681C8.59659 18.5655 8.27219 18.8879 7.87226 18.8879H7.86216C7.46224 18.8879 7.13784 18.5655 7.13784 18.1681C7.13784 17.7707 7.46224 17.4483 7.86216 17.4483H7.87226ZM12.0101 17.4483C12.41 17.4483 12.7344 17.7707 12.7344 18.1681C12.7344 18.5655 12.41 18.8879 12.0101 18.8879H12C11.6001 18.8879 11.2757 18.5655 11.2757 18.1681C11.2757 17.7707 11.6001 17.4483 12 17.4483H12.0101ZM15.4135 18.1681V14.056C15.4135 13.6586 15.7379 13.3362 16.1378 13.3362C16.5378 13.3362 16.8622 13.6586 16.8622 14.056V18.1681C16.8622 18.5655 16.5378 18.8879 16.1378 18.8879C15.7379 18.8879 15.4135 18.5655 15.4135 18.1681ZM7.87226 13.3362C8.27219 13.3362 8.59659 13.6586 8.59659 14.056C8.59659 14.4535 8.27219 14.7759 7.87226 14.7759H7.86216C7.46224 14.7759 7.13784 14.4535 7.13784 14.056C7.13784 13.6586 7.46224 13.3362 7.86216 13.3362H7.87226ZM12.0101 13.3362C12.41 13.3362 12.7344 13.6586 12.7344 14.056C12.7344 14.4535 12.41 14.7759 12.0101 14.7759H12C11.6001 14.7759 11.2757 14.4535 11.2757 14.056C11.2757 13.6586 11.6001 13.3362 12 13.3362H12.0101ZM7.87226 9.22415C8.27219 9.22415 8.59659 9.54653 8.59659 9.94396C8.59659 10.3414 8.27219 10.6638 7.87226 10.6638H7.86216C7.46224 10.6638 7.13784 10.3414 7.13784 9.94396C7.13784 9.54653 7.46224 9.22415 7.86216 9.22415H7.87226ZM12.0101 9.22415C12.41 9.22415 12.7344 9.54653 12.7344 9.94396C12.7344 10.3414 12.41 10.6638 12.0101 10.6638H12C11.6001 10.6638 11.2757 10.3414 11.2757 9.94396C11.2757 9.54653 11.6001 9.22415 12 9.22415H12.0101ZM16.1479 9.22415C16.5479 9.22415 16.8723 9.54653 16.8723 9.94396C16.8723 10.3414 16.5479 10.6638 16.1479 10.6638H16.1378C15.7379 10.6638 15.4135 10.3414 15.4135 9.94396C15.4135 9.54653 15.7379 9.22415 16.1378 9.22415H16.1479ZM16.1378 5.11207C16.5378 5.11207 16.8622 5.43446 16.8622 5.83189C16.8622 6.22932 16.5378 6.5517 16.1378 6.5517H7.86216C7.46224 6.5517 7.13784 6.22932 7.13784 5.83189C7.13784 5.43446 7.46224 5.11207 7.86216 5.11207H16.1378ZM21 20.2241C21 21.7571 19.7493 23 18.2068 23H5.79324C4.25069 23 3 21.7571 3 20.2241V3.77585C3 2.2429 4.25069 1 5.79324 1H18.2068C19.7493 1 21 2.2429 21 3.77585V20.2241Z" fill="white"></path>
                </svg>
            </button>
        </div>
    </div>
</aside>
