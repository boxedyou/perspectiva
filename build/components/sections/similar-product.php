<?php
$current_product_id = get_the_ID();
$current_terms = get_the_terms( $current_product_id, 'categories' );

$related_products = null;

if ( ! is_wp_error( $current_terms ) && ! empty( $current_terms ) ) {
  $term_ids = wp_list_pluck( $current_terms, 'term_id' );

  $args = [
    'post_type'      => 'product',
    'posts_per_page' => 8,
    'post__not_in'   => [ $current_product_id ],
    'tax_query'      => [
      [
        'taxonomy' => 'categories',
        'field'    => 'term_id',
        'terms'    => $term_ids,
      ],
    ],
  ];

  $related_products = new WP_Query( $args );
}

// Если похожих нет — просто ничего не выводим
if ( ! $related_products || ! $related_products->have_posts() ) {
  return;
}
?>

<section class="similar-product">
    <div class="container">
        <div class="similar-product__title-inner">
            <h2 class="similar-product__title">Похожие товары</h2>
            <div class="similar-product__button-inner">
                <div class="similar-product__button swiper-button-prev" data-similar-product-swiper-prev></div>
                <div class="similar-product__button swiper-button-next" data-similar-product-swiper-next></div>
            </div>
        </div>

        <div class="similar-product__swiper swiper" data-similar-product-swiper>
            <div class="similar-product__slider-wrapper swiper-wrapper">
              <?php while ( $related_products->have_posts() ) : $related_products->the_post(); ?>
                  <div class="similar-product__slide swiper-slide">
                    <?php get_template_part('components/elements/category-item'); ?>
                  </div>
              <?php endwhile; ?>
            </div>
        </div>

      <?php wp_reset_postdata(); ?>
    </div>
</section>