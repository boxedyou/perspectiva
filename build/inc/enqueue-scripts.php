<?php
add_action( 'wp_enqueue_scripts', 'perspectiva_scripts' );

function perspectiva_scripts() {
  // Базовый handle от названия сайта
  $handle_base = sanitize_title( get_bloginfo( 'name' ) );

  $main_style_handle   = $handle_base . '-main';
  $theme_style_handle  = $handle_base . '-theme';
  $theme_script_handle = $handle_base . '-scripts';

  // Пути к файлам на диске
  $style_src  = get_template_directory() . '/assets/css/main.min.css';
  $script_src = get_template_directory() . '/assets/js/index.min.js';

  // Версии по времени изменения файлов
  $style_version  = file_exists( $style_src )  ? filemtime( $style_src )  : null;
  $script_version = file_exists( $script_src ) ? filemtime( $script_src ) : null;

  // =============== Стили ===============

  // style.css
  wp_enqueue_style(
    $main_style_handle,
    get_template_directory_uri() . '/style.css',
    [],
    file_exists( get_template_directory() . '/style.css' )
      ? filemtime( get_template_directory() . '/style.css' )
      : null,
    'all'
  );

  // main.min.css
  wp_enqueue_style(
    $theme_style_handle,
    get_template_directory_uri() . '/assets/css/main.min.css',
    [ $main_style_handle ],
    $style_version,
    'all'
  );

  // =============== Скрипты ===============

  // Отключаем встроенный jQuery и migrate
  wp_deregister_script( 'jquery' );
  wp_deregister_script( 'jquery-migrate' );

  // jQuery с CDN
  wp_register_script(
    'jquery',
    'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js',
    [],
    '3.7.1',
    true
  );
  wp_enqueue_script( 'jquery' );

  // jQuery Migrate с CDN
  wp_register_script(
    'jquery-migrate',
    'https://code.jquery.com/jquery-migrate-3.4.1.min.js',
    [ 'jquery' ],
    '3.4.1',
    true
  );
  wp_enqueue_script( 'jquery-migrate' );

  // Основной скрипт (куда собран и send.js)
  wp_enqueue_script(
    $theme_script_handle,
    get_template_directory_uri() . '/assets/js/index.min.js',
    [ 'jquery', 'jquery-migrate' ],
    $script_version,
    true
  );

  // Передаём ajaxurl и базовые URL в JS
  wp_localize_script(
    $theme_script_handle,
    'ajaxurl_object',
    [
      'ajaxurl'    => admin_url( 'admin-ajax.php' ),
      'site_url'   => home_url( '/' ),
      'assets_url' => function_exists( 'get_assets_url' )
        ? get_assets_url()
        : get_template_directory_uri() . '/assets',
    ]
  );

  // (Опционально) совместимость со старым кодом, который ждёт window.ajaxurl
  wp_add_inline_script(
    $theme_script_handle,
    'if (typeof ajaxurl === "undefined" && typeof ajaxurl_object !== "undefined") { window.ajaxurl = ajaxurl_object.ajaxurl; }',
    'before'
  );
}