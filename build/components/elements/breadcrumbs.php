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
  'title' => 'Главная',
  'url'   => home_url('/'),
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
  // Добавляем цепочку родительских страниц от корня к текущему
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

    // Специальный случай: news — ссылка на страницу новостей (page-news)
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
      // Остальные типы: архив типа записи (если есть)
      $post_type_obj = get_post_type_object($post_type);
      if ($post_type_obj && $post_type_obj->has_archive) {
        $breadcrumbs[] = [
          'title'  => $post_type_obj->labels->name,
          'url'    => get_post_type_archive_link($post_type),
          'active' => false
        ];
      }
    }

    // --- 2.3. Таксономии (категории, теги) ---
    // Добавляем родительские термины и текущий термин
    $taxonomies = ($post_type === 'news') ? [] : get_object_taxonomies($post_type);
    foreach ($taxonomies as $taxonomy) {
      $terms = get_the_terms($post->ID, $taxonomy);
      if ($terms && !is_wp_error($terms)) {
        $term = array_shift($terms);
        // Родительские термины
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
        // Текущий термин
        $breadcrumbs[] = [
          'title'  => $term->name,
          'url'    => get_term_link($term),
          'active' => false
        ];
        break; // Используем только одну таксономию
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
  // Архив кастомного типа (например, /news/, /objects/)
  $post_type = get_queried_object();
  $breadcrumbs[] = [
    'title'  => $post_type->labels->name,
    'url'    => get_post_type_archive_link($post_type->name),
    'active' => true
  ];

} elseif (is_tax() || is_category() || is_tag()) {
  // Страница таксономии (категория, тег)
  $term = get_queried_object();

  // Родительские термины
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

  // Текущий термин
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
  // Архив по дате (год, месяц, день)
  if (is_year()) {
    $breadcrumbs[] = ['title' => get_the_date('Y'), 'url' => '', 'active' => true];
  } elseif (is_month()) {
    $breadcrumbs[] = ['title' => get_the_date('F Y'), 'url' => '', 'active' => true];
  } elseif (is_day()) {
    $breadcrumbs[] = ['title' => get_the_date(), 'url' => '', 'active' => true];
  }
}
?>

<!-- Вывод разметки хлебных крошек (Schema.org, доступность) -->
<nav class="breadcrumbs" aria-label="Хлебные крошки">
    <ol class="breadcrumbs__list">
      <?php foreach ($breadcrumbs as $index => $crumb) : ?>
          <li class="breadcrumbs__item">
            <?php if ($crumb['active'] && $index === count($breadcrumbs) - 1) : ?>
                <!-- Активный (текущий) элемент — span без ссылки -->
                <span class="breadcrumbs__current" aria-current="page"><?php echo esc_html($crumb['title']); ?></span>
            <?php else : ?>
                <!-- Обычный элемент — ссылка + разделитель -->
                <a class="breadcrumbs__link" href="<?php echo esc_url($crumb['url']); ?>"><?php echo esc_html($crumb['title']); ?></a>
                <span class="breadcrumbs__separator" aria-hidden="true">/</span>
            <?php endif; ?>
          </li>
      <?php endforeach; ?>
    </ol>
</nav>