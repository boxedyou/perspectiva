<?php
/**
 * Breadcrumbs component for WordPress
 * Хлебные крошки для навигации
 */

if (!defined('ABSPATH')) {
  exit;
}

$breadcrumbs = [];

// Главная
$breadcrumbs[] = [
  'title' => 'Главная',
  'url'   => home_url('/'),
  'active' => false
];

if (is_front_page()) {
  $breadcrumbs[0]['active'] = true;
} elseif (is_home()) {
  // Страница блога
  $breadcrumbs[] = [
    'title'  => get_the_title(get_option('page_for_posts')),
    'url'    => get_permalink(get_option('page_for_posts')),
    'active' => true
  ];
} elseif (is_singular()) {
  $post = get_queried_object();

  // Для иерархических типов (страницы, кастомные) — родительская цепочка
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

  // Для записей — архив типа (каталог, новости и т.д.)
  if (is_single() && !is_page()) {
    $post_type = get_post_type();
    $post_type_obj = get_post_type_object($post_type);
    if ($post_type_obj && $post_type_obj->has_archive) {
      $breadcrumbs[] = [
        'title'  => $post_type_obj->labels->name,
        'url'    => get_post_type_archive_link($post_type),
        'active' => false
      ];
    }
    // Таксономии (категории, теги)
    $taxonomies = get_object_taxonomies($post_type);
    foreach ($taxonomies as $taxonomy) {
      $terms = get_the_terms($post->ID, $taxonomy);
      if ($terms && !is_wp_error($terms)) {
        $term = array_shift($terms);
        // Родительские категории
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
        break; // Берём только одну таксономию
      }
    }
  }

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
} elseif (is_tax() || is_category() || is_tag()) {
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
    $breadcrumbs[] = [
      'title'  => get_the_date('Y'),
      'url'    => '',
      'active' => true
    ];
  } elseif (is_month()) {
    $breadcrumbs[] = [
      'title'  => get_the_date('F Y'),
      'url'    => '',
      'active' => true
    ];
  } elseif (is_day()) {
    $breadcrumbs[] = [
      'title'  => get_the_date(),
      'url'    => '',
      'active' => true
    ];
  }
}
?>

<nav class="breadcrumbs" aria-label="Хлебные крошки">
  <ol class="breadcrumbs__list">
    <?php foreach ($breadcrumbs as $index => $crumb) : ?>
      <li class="breadcrumbs__item">
        <?php if ($crumb['active'] && $index === count($breadcrumbs) - 1) : ?>
          <span class="breadcrumbs__current" aria-current="page"><?php echo esc_html($crumb['title']); ?></span>
        <?php else : ?>
          <a class="breadcrumbs__link" href="<?php echo esc_url($crumb['url']); ?>"><?php echo esc_html($crumb['title']); ?></a>
          <span class="breadcrumbs__separator" aria-hidden="true">/</span>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ol>
</nav>
