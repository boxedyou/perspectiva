<?php
$current_term = get_queried_object();

$terms = get_terms([
  'taxonomy'   => 'categories',
  'hide_empty' => false,
  'orderby'    => 'name',
  'order'      => 'ASC',
]);

$is_term_page = $current_term instanceof WP_Term && $current_term->taxonomy === 'categories';

// Фильтруем термины: оставляем только те, у которых есть хотя бы 1 product
$terms_with_products = [];

if (!is_wp_error($terms) && !empty($terms)) {
  foreach ($terms as $term) {
    $check = new WP_Query([
      'post_type'      => 'product',
      'posts_per_page' => 1,
      'post_status'    => 'publish',
      'tax_query'      => [[
        'taxonomy' => 'categories',
        'field'    => 'term_id',
        'terms'    => (int) $term->term_id,
      ]],
      'no_found_rows' => true,
    ]);

    if ($check->have_posts()) {
      $terms_with_products[] = $term;
    }

    wp_reset_postdata();
  }
}

// Если мы не на странице термина и вообще нет терминов с product — не выводим блок
if (!$is_term_page && empty($terms_with_products)) {
  return;
}
?>

<section class="category-catalog">
    <div class="container">

        <div class="category-catalog__filter-inner">
            <a href="<?php echo esc_url(home_url('/categories/')); ?>"
               class="category-catalog__filter <?= (!$is_term_page || empty($current_term->slug)) ? 'active' : ''; ?>">
                Все
            </a>

          <?php if (!empty($terms_with_products)) : ?>
            <?php foreach ($terms_with_products as $term) : ?>
              <?php
              $term_link = get_term_link($term);
              $is_active = $is_term_page && isset($current_term->slug) && $current_term->slug === $term->slug;
              ?>
                  <a href="<?= esc_url($term_link); ?>"
                     class="category-catalog__filter <?= $is_active ? 'active' : ''; ?>">
                    <?= esc_html($term->name); ?>
                  </a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="category-catalog__wrapper">
          <?php
          $args = [
            'post_type'      => 'product',
            'posts_per_page' => 12,
            'post_status'    => 'publish',
          ];

          if ($is_term_page && !empty($current_term->slug)) {
            $args['tax_query'] = [[
              'taxonomy' => 'categories',
              'field'    => 'slug',
              'terms'    => $current_term->slug,
            ]];
          }

          $products_query = new WP_Query($args);

          if ($products_query->have_posts()) :
            while ($products_query->have_posts()) : $products_query->the_post();
              get_template_part('components/elements/category-item');
            endwhile;
            wp_reset_postdata();
          else :
            ?>
              <p>Товары не найдены.</p>
          <?php
          endif;
          ?>
        </div>

    </div>
</section>