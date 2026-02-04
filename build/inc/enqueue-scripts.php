<?php
/**
 * Подключение CSS и JS файлов с временными метками для cache busting
 */

/**
 * Получить версию файла на основе времени модификации
 */
function get_file_version($file_path) {
  if (file_exists($file_path)) {
    return filemtime($file_path);
  }
  return time();
}

/**
 * Подключить все CSS файлы из папки
 */
function enqueue_all_css($assets_path, $assets_url) {
  $css_dir = $assets_path . '/css/';
  $output = '';

  if (is_dir($css_dir)) {
    $files = glob($css_dir . '*.css');
    foreach ($files as $file) {
      $filename = basename($file);
      $file_url = $assets_url . '/css/' . $filename;
      $version = get_file_version($file);
      $output .= '<link rel="stylesheet" href="' . $file_url . '?v=' . $version . '">' . "\n    ";
    }
  }

  return $output;
}

/**
 * Подключить все JS файлы из папки
 */
function enqueue_all_js($assets_path, $assets_url, $defer = false) {
  $js_dir = $assets_path . '/js/';
  $output = '';

  if (is_dir($js_dir)) {
    $files = glob($js_dir . '*.js');
    foreach ($files as $file) {
      $filename = basename($file);
      // Пропускаем .map файлы
      if (strpos($filename, '.map') !== false) {
        continue;
      }
      $file_url = $assets_url . '/js/' . $filename;
      $version = get_file_version($file);
      $defer_attr = $defer ? ' defer' : '';
      $output .= '<script src="' . $file_url . '?v=' . $version . '"' . $defer_attr . '></script>' . "\n    ";
    }
  }

  return $output;
}