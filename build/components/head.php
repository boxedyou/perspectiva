<?php
/**
 * Head section template
 * Подключает CSS и JS файлы с версионированием
 */

// Убеждаемся, что функции подключены
if (!function_exists('enqueue_css_files')) {
  require_once __DIR__ . '/../function.php';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($page_title) ? $page_title : 'Perspectiva'; ?></title>

  <?php echo enqueue_css_files(); ?>
</head>
<body>