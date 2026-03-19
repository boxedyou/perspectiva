<?php
/**
 * Секция "Объекты с нашей продукцией" на странице товара.
 * Ищем записи типа `objects`, у которых совпадают термины таксономии `categories`
 * с текущим товаром (post type: product).
 */

// ID текущего товара
$current_product_id = get_the_ID();

// Термины таксономии categories у текущего товара
$current_terms = get_the_terms( $current_product_id, 'categories' );

// Если терминов нет или ошибка — ничего не выводим
if ( is_wp_error( $current_terms ) || empty( $current_terms ) ) {
  return;
}

// ID терминов для запроса
$term_ids = wp_list_pluck( $current_terms, 'term_id' );

// Запрос объектов (post type: objects) с теми же терминами categories
$objects_query = new WP_Query( [
  'post_type'      => 'object',        // если у тебя slug другой — поменяй тут
  'posts_per_page' => -1,
  'post_status'    => 'publish',
  'tax_query'      => [
    [
      'taxonomy' => 'categories',
      'field'    => 'term_id',
      'terms'    => $term_ids,
    ],
  ],
] );

// Если подходящих объектов нет — выходим
if ( ! $objects_query->have_posts() ) {
  wp_reset_postdata();
  return;
}
?>

    <section class="objects-product">
        <div class="container">
            <div class="objects-product__title-inner">
                <h2 class="objects-product__title">Объекты с нашей продукцией</h2>
                <div class="objects-product__button-inner">
                    <div class="objects-product__button swiper-button-prev" data-objects-product-swiper-prev></div>
                    <div class="objects-product__button swiper-button-next" data-objects-product-swiper-next></div>
                </div>
            </div>

            <div class="objects-product__swiper swiper" data-objects-product-swiper>
                <div class="objects-product__slider-wrapper swiper-wrapper">
                  <?php while ( $objects_query->have_posts() ) : $objects_query->the_post(); ?>
                      <div class="objects-product__slide swiper-slide">
                        <?php
                        // Здесь подключается элемент `object.php`,
                        // который уже сам берёт: миниатюру, ACF `objects_group`, таксономию `categories` и т.д.
                        get_template_part('components/elements/object');
                        ?>
                      </div>
                  <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>

<?php
wp_reset_postdata();