<?php
$products_title = is_page('catalog')
  ? 'Каталог продукции'
  : 'Продукция ТСК «Перспектива»';
?>

<section class="products">
    <div class="container">
        <h2 class="products__title"><?= esc_html($products_title); ?></h2>

        <div class="products__wrapper">
          <?php
          $terms = get_terms([
            'taxonomy' => 'categories',
            'hide_empty' => false,
            'orderby' => 'name',
            'order' => 'ASC',
          ]);

          if (!is_wp_error($terms) && !empty($terms)) :
            foreach ($terms as $term) :
              $group = get_field('categories_group', 'term_' . $term->term_id);

              $img = $group['img'] ?? null;
              $title = $group['title'] ?? $term->name;
              $description = $group['description'] ?? '';
              $term_link = get_term_link($term);

              if (is_wp_error($term_link)) continue;


              ?>
                <div class="products__item">
                  <?php if ($img['url']) : ?>
                      <img class="products__img"
                           src="<?= esc_url($img['url']); ?>"
                           alt="<?= esc_attr($title); ?>"
                           title="<?= esc_attr($title); ?>"
                           width="732" height="480" loading="lazy">
                  <?php endif; ?>

                    <h3 class="products__item-title"><?= esc_html($title); ?></h3>

                  <?php if ($description) : ?>
                      <p class="products__item-text"><?= esc_html($description); ?></p>
                  <?php endif; ?>

                    <a class="products__item-link" href="<?= esc_url($term_link); ?>">
                        Смотреть весь фибросайдинг
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.6031 5.2142C15.8841 4.9286 16.3401 4.9286 16.6211 5.2142L22.7892 11.4827C23.0703 11.7683 23.0703 12.2317 22.7892 12.5173L16.6211 18.7858C16.3401 19.0714 15.8841 19.0714 15.6031 18.7858C15.3221 18.5002 15.3221 18.0368 15.6031 17.7512L20.5424 12.7315H1.71982C1.32238 12.7315 1 12.4039 1 12C1 11.5961 1.32238 11.2685 1.71982 11.2685H20.5424L15.6031 6.24875C15.3221 5.96315 15.3221 5.4998 15.6031 5.2142Z" fill="white"/>
                        </svg>
                    </a>
                </div>
            <?php
            endforeach;
          endif;
          ?>
        </div>

      <?php get_template_part('components/elements/products-small'); ?>
    </div>
</section>