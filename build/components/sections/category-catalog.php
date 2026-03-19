<?php
// Текущий объект запроса (может быть терм таксономии или что-то ещё)
$current_term = get_queried_object();

// Все термины таксономии для табов
$terms = get_terms([
  'taxonomy'   => 'categories',
  'hide_empty' => false,
  'orderby'    => 'name',
  'order'      => 'ASC',
]);

// Определяем, находимся ли мы на странице термина таксономии categories
$is_term_page = $current_term instanceof WP_Term && $current_term->taxonomy === 'categories';

// Базовый URL для таба "Все": архив товаров или своя страница каталога
$all_url = get_post_type_archive_link('product'); // или home_url('/catalog/')

// Какой фильтр активен сейчас
$current_slug = $is_term_page ? $current_term->slug : 'all';
?>

<section class="category-catalog">
    <div class="container">

        <div class="category-catalog__filter-inner">
            <a href="<?php echo esc_url( home_url( '/categories/' ) ); ?>"
               class="category-catalog__filter <?= $current_slug === 'all' ? 'active' : ''; ?>">
                Все
            </a>

          <?php if ( ! is_wp_error($terms) && ! empty($terms) ) : ?>
            <?php foreach ( $terms as $term ) : ?>
              <?php
              // Ссылка на архив ТОЛЬКО с товаром этого термина
              // (страница таксономии, но мы сами ограничим вывод product’ами)
              $term_link = get_term_link($term);
              $is_active = $current_slug === $term->slug;
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
          // Собираем WP_Query ТОЛЬКО для product
          $args = [
            'post_type'      => 'product',
            'posts_per_page' => 12,
            'post_status'    => 'publish',
          ];

          // Если мы на странице термина categories — фильтруем по нему
          if ( $is_term_page ) {
            $args['tax_query'] = [[
              'taxonomy' => 'categories',
              'field'    => 'slug',
              'terms'    => $current_term->slug,
            ]];
          }

          $products_query = new WP_Query($args);

          if ( $products_query->have_posts() ) :
            while ( $products_query->have_posts() ) : $products_query->the_post();
              get_template_part('components/elements/category-item');
            endwhile;
            wp_reset_postdata();
          else :
            ?>
              <p>Товары не найдены.</p>
          <?php endif; ?>
        </div>

    </div>
</section>