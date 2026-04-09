<?php
// Разрешаем загрузку SVG
add_filter('upload_mimes', function ($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
});

// Корректный MIME для SVG в админке
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
  $ext = pathinfo($filename, PATHINFO_EXTENSION);

  if ($ext === 'svg') {
    $data['ext']  = 'svg';
    $data['type'] = 'image/svg+xml';
  }

  return $data;
}, 10, 4);