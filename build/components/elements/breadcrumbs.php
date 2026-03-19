<?php
/**
 * Breadcrumbs component for WordPress
 * Хлебные крошки для навигации по сайту
 *
 * Структура каждого элемента: ['title' => string, 'url' => string, 'active' => bool]
 * active=true — текущая страница (без ссылки)
 */

// Защита от прямого вызова вне WordPress
if (!defined('ABSPATH')) {
  exit;
}

// Массив элементов хлебных крошек
$breadcrumbs = [];

// === 1. ПЕРВЫЙ ЭЛЕМЕНТ: Главная страница (всегда присутствует) ===
$breadcrumbs[] = [
  'title'  => 'Главная',
  'url'    => home_url('/'),
  'active' => false
];

// === 2. ОПРЕДЕЛЕНИЕ ТИПА СТРАНИЦЫ И ФОРМИРОВАНИЕ СРЕДНИХ ЭЛЕМЕНТОВ ===

if (is_front_page()) {
  // Главная страница — первый элемент помечаем как активный
  $breadcrumbs[0]['active'] = true;

} elseif (is_home()) {
  // Страница "Блог" (posts page) — когда главная настроена как статическая
  $breadcrumbs[] = [
    'title'  => get_the_title(get_option('page_for_posts')),
    'url'    => get_permalink(get_option('page_for_posts')),
    'active' => true
  ];

} elseif (is_singular()) {
  // Одиночная запись: страница, пост или кастомный тип (project, news и т.д.)
  $post = get_queried_object();

  // --- 2.1. Для иерархических типов (страницы, проекты с родителями) ---
  if (is_post_type_hierarchical($post->post_type) && $post->post_parent) {
    $ancestors = array_reverse(get_post_ancestors($post->ID));
    foreach ($ancestors as $ancestor_id) {
      $breadcrumbs[] = [
        'title'  => get_the_title($ancestor_id),
        'url'    => get_permalink($ancestor_id),
        'active' => false
      ];
    }
  }

  // --- 2.2. Для одиночных записей (не страниц): ссылка на раздел/архив ---
  if (is_single() && !is_page()) {
    $post_type = get_post_type();

    if ($post_type === 'news') {
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
      if ($post_type_obj && $post_type_obj->has_archive) {
        $breadcrumbs[] = [
          'title'  => $post_type_obj->labels->name,
          'url'    => get_post_type_archive_link($post_type),
          'active' => false
        ];
      }
    }

    // --- 2.3. Таксономии (категории, теги) — не для news ---
    $taxonomies = ($post_type === 'news') ? [] : get_object_taxonomies($post_type);
    foreach ($taxonomies as $taxonomy) {
      $terms = get_the_terms($post->ID, $taxonomy);
      if ($terms && !is_wp_error($terms)) {
        $term = array_shift($terms);
        if ($term->parent) {
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

  // --- 2.4. Текущая запись (последний элемент) ---
  $breadcrumbs[] = [
    'title'  => get_the_title(),
    'url'    => get_permalink(),
    'active' => true
  ];

} elseif (is_post_type_archive()) {
  $post_type = get_queried_object();
  $breadcrumbs[] = [
    'title'  => $post_type->labels->name,
    'url'    => get_post_type_archive_link($post_type->name),
    'active' => true
  ];

}
elseif (is_tax() || is_category() || is_tag()) {
  $term = get_queried_object();

  if ($term->parent) {
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

elseif (is_search()) {
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
        $is_active = $crumb['active'] && $index === count($breadcrumbs) - 1;
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