<?php
/**
 * Functions file - подключает все необходимые функции
 */

// Подключаем функции для работы с assets
require_once __DIR__ . '/inc/enqueue-scripts.php';

// Инициализация путей к assets
if (!defined('ASSETS_PATH')) {
  define('ASSETS_PATH', __DIR__ . '/assets');
}

if (!defined('ASSETS_URL')) {
  // Автоматическое определение URL на основе текущего пути
  $script_name = $_SERVER['SCRIPT_NAME'];
  $base_path = dirname($script_name);
  define('ASSETS_URL', rtrim($base_path, '/') . '/assets');
}

/**
 * Обертка для подключения CSS файлов
 */
function enqueue_css_files() {
  return enqueue_all_css(ASSETS_PATH, ASSETS_URL);
}

/**
 * Обертка для подключения JS файлов
 */
function enqueue_js_files($defer = true) {
  return enqueue_all_js(ASSETS_PATH, ASSETS_URL, $defer);
}