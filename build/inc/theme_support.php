<?php
function perspectiva_theme_support() {
  // Поддержка миниатюр записей
  add_theme_support('post-thumbnails');

  // Поддержка заголовков документа
  add_theme_support('title-tag');

  // Поддержка HTML5
  add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ));

  // Поддержка кастомных логотипов
  add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'perspectiva_theme_support');