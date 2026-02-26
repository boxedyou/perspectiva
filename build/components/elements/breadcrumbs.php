<?php
/**
 * Breadcrumbs component
 * Хлебные крошки для навигации
 */

// Убеждаемся, что функции подключены
if (!function_exists('esc_url')) {
  require_once __DIR__ . '/../../function.php';
}

// Определяем базовый URL
$base_url = '/perspectiva/build/';

// Определяем текущую страницу
$current_script = basename($_SERVER['PHP_SELF']);

// Массив страниц с их названиями
$pages = [
  'index.php' => [
    'title' => 'Главная',
    'url' => $base_url . 'index.php'
  ],
  'page-catalog.php' => [
    'title' => 'Каталог',
    'url' => $base_url . 'page-catalog.php'
  ],
  'page-price.php' => [
    'title' => 'Прайс-лист',
    'url' => $base_url . 'page-price.php'
  ],
  'page-about.php' => [
    'title' => 'О компании',
    'url' => $base_url . 'page-about.php'
  ],
  'single-objects.php' => [
    'title' => 'Объекты',
    'url' => $base_url . 'single-objects.php'
  ],
  'page-reviews.php' => [
    'title' => 'Отзывы',
    'url' => $base_url . 'page-reviews.php'
  ],
  'page-contacts.php' => [
    'title' => 'Контакты',
    'url' => $base_url . 'page-contacts.php'
  ],
  'page-ventfacades.php' => [
    'title' => 'Вентфасады',
    'url' => $base_url . 'page-ventfacades.php'
  ],
  'page-fibrosiding.php' => [
    'title' => 'Фибросайдинг',
    'url' => $base_url . 'page-fibrosiding.php'
  ]
];

// Строим цепочку breadcrumbs
$breadcrumbs = [];

// Всегда добавляем главную страницу
$breadcrumbs[] = [
  'title' => 'Главная',
  'url' => $base_url . 'index.php',
  'active' => ($current_script === 'index.php')
];

// Добавляем текущую страницу, если это не главная
if ($current_script !== 'index.php' && isset($pages[$current_script])) {
  $breadcrumbs[] = [
    'title' => $pages[$current_script]['title'],
    'url' => $pages[$current_script]['url'],
    'active' => true
  ];
}

// Если страница не найдена в массиве, используем имя файла
if ($current_script !== 'index.php' && !isset($pages[$current_script])) {
  $page_name = str_replace(['page-', '.php'], '', $current_script);
  $page_name = ucfirst($page_name);
  $breadcrumbs[] = [
    'title' => $page_name,
    'url' => $base_url . $current_script,
    'active' => true
  ];
}
?>

<nav class="breadcrumbs" aria-label="Хлебные крошки">
  <ol class="breadcrumbs__list">
    <?php foreach ($breadcrumbs as $index => $crumb) : ?>
      <li class="breadcrumbs__item">
        <?php if ($crumb['active'] && $index === count($breadcrumbs) - 1) : ?>
          <span class="breadcrumbs__current" aria-current="page"><?= esc_html($crumb['title']) ?></span>
        <?php else : ?>
          <a class="breadcrumbs__link" href="<?= esc_url($crumb['url']) ?>"><?= esc_html($crumb['title']) ?></a>
          <span class="breadcrumbs__separator" aria-hidden="true">/</span>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ol>
</nav>