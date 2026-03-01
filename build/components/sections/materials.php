<?php
/**
 * Блок «Другие материалы по теме»
 * Выводит похожие статьи по таксономии news_tags
 * Используется на single-news
 */

$related_query = null;
$current_post_id = get_the_ID();

// Термины текущей новости
$terms = get_the_terms($current_post_id, 'news_tags');
$term_ids = [];

if ($terms && !is_wp_error($terms)) {
  $term_ids = wp_list_pluck($terms, 'term_id');
}

$query_args = [
  'post_type'      => 'news',
  'posts_per_page' => -1,
  'post_status'   => 'publish',
  'post__not_in'  => [$current_post_id],
  'orderby'       => 'date',
  'order'         => 'DESC',
];

// Похожие по тегам
if (!empty($term_ids)) {
  $query_args['tax_query'] = [
    [
      'taxonomy' => 'news_tags',
      'field'    => 'term_id',
      'terms'    => $term_ids,
    ],
  ];
}

$related_query = new WP_Query($query_args);
?>

<section class="materials">
    <div class="container">
        <div class="materials__title-inner">
            <h2 class="materials__title">Другие материалы по теме</h2>
            <div class="materials__button-inner">
                <div class="materials__button swiper-button-prev" data-materials-swiper-prev></div>
                <div class="materials__button swiper-button-next" data-materials-swiper-next></div>
            </div>
        </div>
        <div class="materials__swiper swiper" data-materials-swiper>
            <div class="materials__slider-wrapper swiper-wrapper">
              <?php
              if ($related_query->have_posts()) :
                while ($related_query->have_posts()) : $related_query->the_post();
                  ?>
                    <div class="materials__slide swiper-slide">
                      <?php get_template_part('components/elements/news-element'); ?>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
              else :
                ?>
                  <p class="materials__empty">Другие материалы пока отсутствуют.</p>
              <?php endif; ?>
            </div>
        </div>
    </div>
</section>