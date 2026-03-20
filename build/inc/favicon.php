<?php
if (!function_exists('favicon')) {
  function favicon()
  {
    echo '<link rel="icon" href="' . get_template_directory_uri() . '/favicon.png" sizes="32x32" type="image/png">';

    echo '<link rel="icon" href="' . get_template_directory_uri() . '/assets/images/favicon/favicon.svg" sizes="any" type="image/x-icon">';
    echo '<link rel="apple-touch-icon" sizes="1024x1024" href="' . get_template_directory_uri() . '/assets/images/favicon/apple-touch-icon-1024x1024.png">';
    echo '<link rel="apple-touch-icon" sizes="180x180" href="' . get_template_directory_uri() . '/assets/images/favicon/apple-touch-icon-180x180.png">';
    echo '<link rel="android-chrome-icon" sizes="512x512" href="' . get_template_directory_uri() . '/assets/images/favicon/android-chrome-512x512.png">';
    echo '<link rel="android-chrome-icon" sizes="96x196" href="' . get_template_directory_uri() . '/assets/images/favicon/android-chrome-96x96.png">';
    echo '<link rel="icon" href="' . get_template_directory_uri() . '/assets/images/favicon/favicon.svg">';
    echo '<link rel="apple-touch-icon" href="apple-touch-icon.png">';

  }

  add_filter('wp_head', 'favicon');
}