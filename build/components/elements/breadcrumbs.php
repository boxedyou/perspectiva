<?php
/**
 * Breadcrumbs component for WordPress
 * Хлебные крошки для навигации по сайту
 *
 * Структура каждого элемента: ['title' => string, 'url' => string, 'active' => bool]
 */

if (!defined('ABSPATH')) {
  exit;
}

$breadcrumbs = [];

// 1) Главная
$breadcrumbs[] = [
  'title'  => 'Главная',
  'url'    => home_url('/'),
  'active' => false
];

if (is_front_page()) {
  $breadcrumbs[0]['active'] = true;

} elseif (is_home()) {
  $breadcrumbs[] = [
    'title'  => get_the_title(get_option('page_for_posts')),
    'url'    => get_permalink(get_option('page_for_posts')),
    'active' => true
  ];

} elseif (is_singular()) {
  $post = get_queried_object();

  // FIX: на страницах catalog/categories должны быть только 3 крошки:
  // Главная / Каталог / Название страницы
  if (is_page('category') || is_page('categories')) {
    $breadcrumbs[] = [
      'title'  => 'Каталог',
      'url'    => home_url('/catalog/'),
      'active' => false
    ];

    $breadcrumbs[] = [
      'title'  => get_the_title(),
      'url'    => get_permalink(),
      'active' => true
    ];
  } else {
    // 2.1. Для иерархических типов (страницы с родителями)
    if (isset($post->post_type) && is_post_type_hierarchical($post->post_type) && !empty($post->post_parent)) {
      $ancestors = array_reverse(get_post_ancestors($post->ID));
      foreach ($ancestors as $ancestor_id) {
        $breadcrumbs[] = [
          'title'  => get_the_title($ancestor_id),
          'url'    => get_permalink($ancestor_id),
          'active' => false
        ];
      }
    }

    // 2.2. Для одиночных записей (не страниц): ссылка на архив/раздел и термы
    if (is_single() && !is_page()) {
      $post_type = get_post_type();

      // single-product:
      // 2) catalog
      // 3) categories
      if ($post_type === 'product') {
        $breadcrumbs[] = [
          'title'  => 'Каталог',
          'url'    => home_url('/catalog/'),
          'active' => false
        ];
        $breadcrumbs[] = [
          'title'  => 'Категории',
          'url'    => home_url('/categories/'),
          'active' => false
        ];
      } elseif ($post_type === 'news') {
        $news_page = get_page_by_path('novosti-i-stati');
        if ($news_page) {
          $breadcrumbs[] = [
            'title'  => get_the_title($news_page),
            'url'    => get_permalink($news_page),
            'active' => false
          ];
        }
      } else {
        $post_type_obj = get_post_type_object($post_type);
        if ($post_type_obj && !empty($post_type_obj->has_archive)) {
          $breadcrumbs[] = [
            'title'  => isset($post_type_obj->labels->name) ? $post_type_obj->labels->name : '',
            'url'    => get_post_type_archive_link($post_type),
            'active' => false
          ];
        }
      }

      // Термы
      $taxonomies = ($post_type === 'news') ? [] : get_object_taxonomies($post_type);

      foreach ($taxonomies as $taxonomy) {
        $terms = get_the_terms($post->ID, $taxonomy);
        if ($terms && !is_wp_error($terms)) {
          $term = array_shift($terms);
          if (!$term) break;

          // Для product на этом этапе добавляем только сам term (без ancestors),
          // т.к. каталог/категории уже добавлены.
          if ($post_type === 'product' && $taxonomy === 'categories') {
            $breadcrumbs[] = [
              'title'  => $term->name,
              'url'    => get_term_link($term),
              'active' => false
            ];
            break;
          }

          if (!empty($term->parent)) {
            $ancestors = get_ancestors($term->term_id, $taxonomy);
            $ancestors = array_reverse($ancestors);

            foreach ($ancestors as $ancestor_id) {
              $ancestor = get_term($ancestor_id, $taxonomy);
              if ($ancestor && !is_wp_error($ancestor)) {
                $breadcrumbs[] = [
                  'title'  => $ancestor->name,
                  'url'    => get_term_link($ancestor),
                  'active' => false
                ];
              }
            }
          }

          $breadcrumbs[] = [
            'title'  => $term->name,
            'url'    => get_term_link($term),
            'active' => false
          ];
          break;
        }
      }
    }

    // 2.4. Текущая запись
    $breadcrumbs[] = [
      'title'  => get_the_title(),
      'url'    => get_permalink(),
      'active' => true
    ];
  }

} elseif (is_post_type_archive()) {
  $post_type = get_queried_object();
  $breadcrumbs[] = [
    'title'  => isset($post_type->labels->name) ? $post_type->labels->name : '',
    'url'    => get_post_type_archive_link($post_type->name),
    'active' => true
  ];

} elseif (is_tax() || is_category() || is_tag()) {
  $term = get_queried_object();

  // Для taxonomy categories (относятся к product):
  // Главная / Каталог / Категории / Название категории
  if ($term instanceof WP_Term && $term->taxonomy === 'categories') {
    $tax_obj = get_taxonomy('categories');
    $object_types = $tax_obj ? (array) $tax_obj->object_type : [];

    if (in_array('product', $object_types, true)) {
      $breadcrumbs[] = [
        'title'  => 'Каталог',
        'url'    => home_url('/catalog/'),
        'active' => false
      ];
      $breadcrumbs[] = [
        'title'  => 'Категории',
        'url'    => home_url('/categories/'),
        'active' => false
      ];
      $breadcrumbs[] = [
        'title'  => $term->name,
        'url'    => get_term_link($term),
        'active' => true
      ];
    } else {
      // если categories НЕ относится к product — обычная логика родителей
      if (!empty($term->parent)) {
        $ancestors = get_ancestors($term->term_id, $term->taxonomy);
        $ancestors = array_reverse($ancestors);

        foreach ($ancestors as $ancestor_id) {
          $ancestor = get_term($ancestor_id, $term->taxonomy);
          if ($ancestor && !is_wp_error($ancestor)) {
            $breadcrumbs[] = [
              'title'  => $ancestor->name,
              'url'    => get_term_link($ancestor),
              'active' => false
            ];
          }
        }
      }

      $breadcrumbs[] = [
        'title'  => $term->name,
        'url'    => get_term_link($term),
        'active' => true
      ];
    }
  } else {
    // не categories — обычная логика родителей
    if ($term && !empty($term->parent)) {
      $ancestors = get_ancestors($term->term_id, $term->taxonomy);
      $ancestors = array_reverse($ancestors);

      foreach ($ancestors as $ancestor_id) {
        $ancestor = get_term($ancestor_id, $term->taxonomy);
        if ($ancestor && !is_wp_error($ancestor)) {
          $breadcrumbs[] = [
            'title'  => $ancestor->name,
            'url'    => get_term_link($ancestor),
            'active' => false
          ];
        }
      }
    }

    $breadcrumbs[] = [
      'title'  => $term ? $term->name : '',
      'url'    => $term ? get_term_link($term) : '',
      'active' => true
    ];
  }

} elseif (is_search()) {
  $breadcrumbs[] = [
    'title'  => 'Поиск: ' . get_search_query(),
    'url'    => '',
    'active' => true
  ];

} elseif (is_404()) {
  $breadcrumbs[] = [
    'title'  => 'Страница не найдена',
    'url'    => '',
    'active' => true
  ];

} elseif (is_author()) {
  $breadcrumbs[] = [
    'title'  => 'Автор: ' . get_the_author(),
    'url'    => '',
    'active' => true
  ];

} elseif (is_date()) {
  if (is_year()) {
    $breadcrumbs[] = ['title' => get_the_date('Y'), 'url' => '', 'active' => true];
  } elseif (is_month()) {
    $breadcrumbs[] = ['title' => get_the_date('F Y'), 'url' => '', 'active' => true];
  } elseif (is_day()) {
    $breadcrumbs[] = ['title' => get_the_date(), 'url' => '', 'active' => true];
  }
}

// === 3. JSON-LD для BreadcrumbList ===
$json_ld_items = [];
foreach ($breadcrumbs as $index => $crumb) {
  $item = [
    '@type'    => 'ListItem',
    'position' => $index + 1,
    'name'     => $crumb['title'],
  ];

  if (!empty($crumb['url'])) {
    $item['item'] = $crumb['url'];
  }

  $json_ld_items[] = $item;
}

$json_ld = [
  '@context'        => 'https://schema.org',
  '@type'           => 'BreadcrumbList',
  'itemListElement' => $json_ld_items,
];
?>
<script type="application/ld+json"><?php echo wp_json_encode($json_ld); ?></script>

<nav class="breadcrumbs" aria-label="Хлебные крошки">
    <ul class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
      <?php foreach ($breadcrumbs as $index => $crumb) :
        $position = $index + 1;
        $is_active = !empty($crumb['active']) && $index === count($breadcrumbs) - 1;
        ?>
          <li class="breadcrumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <?php if ($is_active) : ?>
                <span itemprop="name"><?php echo esc_html($crumb['title']); ?></span>
              <?php if (!empty($crumb['url'])) : ?>
                    <meta itemprop="item" content="<?php echo esc_url($crumb['url']); ?>">
              <?php endif; ?>
                <meta itemprop="position" content="<?php echo (int) $position; ?>">
            <?php else : ?>
                <a href="<?php echo esc_url($crumb['url']); ?>" title="<?php echo esc_attr($crumb['title']); ?>" itemprop="item">
                    <span itemprop="name"><?php echo esc_html($crumb['title']); ?></span>
                    <meta itemprop="position" content="<?php echo (int) $position; ?>">
                </a>
            <?php endif; ?>
          </li>
      <?php endforeach; ?>
    </ul>
</nav>