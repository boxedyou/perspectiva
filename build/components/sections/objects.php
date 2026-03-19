<?php
// 1. Текущий фильтр из GET (?filter=slug | all)
$current_filter = isset($_GET['filter']) ? sanitize_key($_GET['filter']) : 'all';

// 2. Базовый URL для ссылок фильтра
$base_url = get_permalink();

// 3. Термины для кнопок-фильтров
$filter_terms = get_terms([
  'taxonomy'   => 'object_type',
  'hide_empty' => true,
  'orderby'    => 'name',
  'order'      => 'ASC',
]);

// 4. Сколько объектов показывать
if ( is_page('category') ) {
  $objects_per_page = isset($objects_count) ? (int) $objects_count : -1;
} else {
  $objects_per_page = isset($objects_count) ? min(12, (int) $objects_count) : 12;
}

// 5. Аргументы WP_Query
$objects_args = [
  'post_type'      => 'object',
  'posts_per_page' => $objects_per_page,
  'post_status'    => 'publish',
  'orderby'        => 'date',
  'order'          => 'DESC',
];

if ($current_filter !== 'all') {
  $objects_args['tax_query'] = [[
    'taxonomy' => 'object_type',
    'field'    => 'slug',
    'terms'    => $current_filter,
  ]];
}

$objects_query = new WP_Query($objects_args);
?>
<section class="objects">
    <div class="container">
        <div class="objects__title-wrapper">
            <h2 class="objects__title">Объекты с нашей продукцией</h2>

          <?php if (!is_front_page() && !is_wp_error($filter_terms) && !empty($filter_terms)) : ?>
              <aside class="objects__filter-inner">
                  <a
                          class="objects__filter-button <?= $current_filter === 'all' ? 'active' : ''; ?>"
                          href="<?= esc_url(add_query_arg('filter', 'all', $base_url)); ?>"
                  >
                      Все объекты
                  </a>

                <?php foreach ($filter_terms as $term) : ?>
                  <?php
                  $term_url  = add_query_arg('filter', $term->slug, $base_url);
                  $is_active = ($current_filter === $term->slug);
                  ?>
                    <a
                            class="objects__filter-button <?= $is_active ? 'active' : ''; ?>"
                            href="<?= esc_url($term_url); ?>"
                    >
                      <?= esc_html($term->name); ?>
                    </a>
                <?php endforeach; ?>
              </aside>
          <?php endif; ?>
        </div>

        <div class="objects__wrapper">
          <?php if ($objects_query->have_posts()) : ?>
            <?php while ($objects_query->have_posts()) : $objects_query->the_post(); ?>
              <?php get_template_part('components/elements/object'); ?>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
          <?php else : ?>
              <p>Объекты не найдены.</p>
          <?php endif; ?>
        </div>

      <?php if (!is_page('category')) : ?>
          <a class="objects__link" href="<?= esc_url(home_url('/category/')); ?>">
              Смотреть все объекты
          </a>
      <?php endif; ?>
    </div>
</section>