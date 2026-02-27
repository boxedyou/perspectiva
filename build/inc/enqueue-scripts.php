<?php
add_action( 'wp_enqueue_scripts', 'foundationpress_scripts' );

function foundationpress_scripts() {
  // Базовый handle от названия сайта: напр. "perspectiva"
  $handle_base = sanitize_title( get_bloginfo( 'name' ) );

  $main_style_handle   = $handle_base . '-main';
  $theme_style_handle  = $handle_base . '-theme';
  $theme_script_handle = $handle_base . '-scripts';

  // Пути к файлам
  $style_src  = get_template_directory() . '/assets/css/main.min.css';
  $script_src = get_template_directory() . '/assets/js/index.min.js';

  // Временные метки для кэша
  $style_version  = file_exists( $style_src ) ? filemtime( $style_src ) : false;
  $script_version = file_exists( $script_src ) ? filemtime( $script_src ) : false;

  // =============== Стили ===============

  // Основной style.css
  wp_enqueue_style(
    $main_style_handle,
    get_template_directory_uri() . '/style.css',
    [],
    filemtime( get_template_directory() . '/style.css' ),
    'all'
  );

  // Тема (assets/css/main.min.css), зависит от основного стиля
  wp_enqueue_style(
    $theme_style_handle,
    get_template_directory_uri() . '/assets/css/main.min.css',
    [ $main_style_handle ],
    $style_version,
    'all'
  );

  // =============== Скрипты ===============

  // 1. Убираем стандартную WP jQuery и migrate
  wp_deregister_script( 'jquery' );
  wp_deregister_script( 'jquery-migrate' );

  // 2. Подключаем jQuery с CDN
  wp_register_script(
    'jquery',
    'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js',
    [],
    '3.7.1',
    true
  );
  wp_enqueue_script( 'jquery' );

  // 3. Подключаем jQuery Migrate с CDN
  wp_register_script(
    'jquery-migrate',
    'https://code.jquery.com/jquery-migrate-3.4.1.min.js',
    [ 'jquery' ],
    '3.4.1',
    true
  );
  wp_enqueue_script( 'jquery-migrate' );

  // 4. Подключаем твой основной скрипт, handle от названия сайта
  wp_enqueue_script(
    $theme_script_handle,
    get_template_directory_uri() . '/assets/js/index.min.js',
    [ 'jquery', 'jquery-migrate' ],
    $script_version,
    true
  );

  // === Передача базовых URL в JS ===
  wp_localize_script(
    $theme_script_handle,
    'ajaxurl_object',
    [
      'ajaxurl'    => admin_url( 'admin-ajax.php' ),
      'site_url'   => home_url( '/' ),       // базовый URL сайта
      'assets_url' => get_assets_url(),      // базовый URL /assets (из inc/get_url.php)
    ]
  );

  // Для одиночных постов
  if ( is_single() ) {
    wp_add_inline_script(
      $theme_script_handle,
      'const viewCounterAjax = ' . json_encode( [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'post_id'  => get_the_ID(),
      ] ) . ';',
      'before'
    );
  }
}