<?php
/**
 * Секция новостей с фильтром по таксономии news_tags
 * Требует: CPT news и таксономия news_tags (регистрация в ACF)
 */

// Пагинация
$paged = get_query_var('paged') ? (int) get_query_var('paged') : 1;
if ($paged < 1 && !empty($_GET['paged'])) {
  $paged = max(1, (int) $_GET['paged']);
}
$paged = max(1, $paged);

// Текущий фильтр (slug термина) из URL
$current_filter = isset($_GET['filter']) ? sanitize_key($_GET['filter']) : '';

// Термины таксономии news_tags — пункты фильтра
$filter_terms = get_terms([
  'taxonomy'   => 'news_tags',
  'hide_empty' => true,
  'orderby'    => 'name',
  'order'      => 'ASC',
]);

if (is_wp_error($filter_terms)) {
  $filter_terms = [];
}

// Проверка валидности фильтра
if ($current_filter) {
  $valid_slugs = wp_list_pluck($filter_terms, 'slug');
  if (!in_array($current_filter, $valid_slugs, true)) {
    $current_filter = '';
  }
}

// URL страницы новостей
$news_page = get_page_by_path('novosti-i-stati');
$news_page_url = $news_page ? get_permalink($news_page) : home_url('/novosti-i-stati/');

// Запрос новостей
$query_args = [
  'post_type'      => 'news',
  'posts_per_page' => 12,
  'paged'          => $paged,
  'orderby'        => 'date',
  'order'          => 'DESC',
  'post_status'    => 'publish',
];

if ($current_filter) {
  $query_args['tax_query'] = [
    [
      'taxonomy' => 'news_tags',
      'field'    => 'slug',
      'terms'    => $current_filter,
    ],
  ];
}

$news_query = new WP_Query($query_args);
$total_pages = max(1, (int) $news_query->max_num_pages);
?>

<section class="news">
    <div class="container">
        <h1 class="news__title"><?php the_title(); ?></h1>
        <div class="news__filter-inner">
            <a href="<?= esc_url($news_page_url) ?>"
               class="news__filter<?= $current_filter === '' ? ' active' : '' ?>"
              <?= $current_filter === '' ? ' aria-current="page"' : '' ?>>Все материалы</a>
          <?php foreach ($filter_terms as $term) :
            $filter_url = add_query_arg('filter', $term->slug, $news_page_url);
            $is_active = $current_filter === $term->slug;
            ?>
              <a href="<?= esc_url($filter_url) ?>"
                 class="news__filter<?= $is_active ? ' active' : '' ?>"
                <?= $is_active ? ' aria-current="page"' : '' ?>><?= esc_html($term->name) ?></a>
          <?php endforeach; ?>
        </div>
        <div class="news__wrapper">
          <?php
          if ($news_query->have_posts()) :
            while ($news_query->have_posts()) : $news_query->the_post();
              get_template_part('components/elements/news-element');
            endwhile;
          else :
            echo '<p>Материалы не найдены.</p>';
          endif;
          wp_reset_postdata();
          ?>
        </div>

      <?php if ($total_pages > 1) : ?>
          <div class="news__pagination-inner">
            <?php if ($paged > 1) : ?>
                <a href="<?= esc_url(get_custom_pagenum_link($paged - 1, 'news', $current_filter)) ?>" class="news__pagination news__pagination-arrow news__pagination-arrow--prev"></a>
            <?php else : ?>
                <div class="news__pagination news__pagination-arrow news__pagination-arrow--prev disable"></div>
            <?php endif; ?>

            <?php
            $pages_to_show = [1];
            if ($paged > 1) $pages_to_show[] = $paged - 1;
            $pages_to_show[] = $paged;
            if ($paged < $total_pages) $pages_to_show[] = $paged + 1;
            $pages_to_show[] = $total_pages;
            $pages_to_show = array_unique($pages_to_show);
            sort($pages_to_show);

            $prev_page = 0;
            foreach ($pages_to_show as $page) {
              if ($prev_page && $page - $prev_page > 1) {
                echo '<div class="news__pagination news__pagination--dots">...</div>';
              }
              $page_url = get_custom_pagenum_link($page, 'news', $current_filter);
              if ($page == $paged) {
                echo '<div class="news__pagination active">' . esc_html($page) . '</div>';
              } else {
                echo '<a href="' . esc_url($page_url) . '" class="news__pagination">' . esc_html($page) . '</a>';
              }
              $prev_page = $page;
            }
            ?>

            <?php if ($paged < $total_pages) : ?>
                <a href="<?= esc_url(get_custom_pagenum_link($paged + 1, 'news', $current_filter)) ?>" class="news__pagination news__pagination-arrow news__pagination-arrow--next"></a>
            <?php else : ?>
                <div class="news__pagination news__pagination-arrow news__pagination-arrow--next disable"></div>
            <?php endif; ?>
          </div>
      <?php endif; ?>
    </div>
</section>