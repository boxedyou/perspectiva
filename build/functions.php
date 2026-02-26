<?php
/**
 * Functions and Definitions
 * 
 * @package Perspectiva
 */

// Подключаем функции для работы с assets
require_once __DIR__ . '/inc/enqueue-scripts.php';

/**
 * Инициализация путей к assets
 */
if (!defined('ASSETS_PATH')) {
    define('ASSETS_PATH', get_template_directory() . '/assets');
}

if (!defined('ASSETS_URL')) {
    define('ASSETS_URL', get_template_directory_uri() . '/assets');
}

/**
 * Подключение стилей и скриптов
 */
function perspectiva_enqueue_scripts() {
    // Подключение CSS
    $css_dir = ASSETS_PATH . '/css/';
    if (is_dir($css_dir)) {
        $files = glob($css_dir . '*.css');
        foreach ($files as $file) {
            $filename = basename($file);
            $file_url = ASSETS_URL . '/css/' . $filename;
            $version = file_exists($file) ? filemtime($file) : time();
            wp_enqueue_style('perspectiva-' . str_replace('.', '-', $filename), $file_url, array(), $version);
        }
    }

    // Подключение JS
    $js_dir = ASSETS_PATH . '/js/';
    if (is_dir($js_dir)) {
        $files = glob($js_dir . '*.js');
        foreach ($files as $file) {
            $filename = basename($file);
            // Пропускаем .map файлы
            if (strpos($filename, '.map') !== false) {
                continue;
            }
            $file_url = ASSETS_URL . '/js/' . $filename;
            $version = file_exists($file) ? filemtime($file) : time();
            wp_enqueue_script('perspectiva-' . str_replace('.', '-', $filename), $file_url, array(), $version, true);
        }
    }
}
add_action('wp_enqueue_scripts', 'perspectiva_enqueue_scripts');

/**
 * Поддержка функций темы
 */
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

/**
 * Регистрация меню
 */
function perspectiva_register_menus() {
    register_nav_menus(array(
        'primary' => 'Основное меню',
        'footer' => 'Меню в подвале',
    ));
}
add_action('init', 'perspectiva_register_menus');

/**
 * Регистрация сайдбаров
 */
function perspectiva_widgets_init() {
    register_sidebar(array(
        'name' => 'Сайдбар',
        'id' => 'sidebar-1',
        'description' => 'Основной сайдбар',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'perspectiva_widgets_init');

/**
 * Экранирование атрибутов HTML (если функции WordPress не доступны)
 */
if (!function_exists('esc_attr')) {
    function esc_attr($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Экранирование URL (если функции WordPress не доступны)
 */
if (!function_exists('esc_url')) {
    function esc_url($url) {
        return htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Экранирование HTML (если функции WordPress не доступны)
 */
if (!function_exists('esc_html')) {
    function esc_html($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Получить URL assets
 */
function get_assets_url($path = '') {
    return get_template_directory_uri() . '/assets' . ($path ? '/' . ltrim($path, '/') : '');
}

/**
 * Получить путь к assets
 */
function get_assets_path($path = '') {
    return get_template_directory() . '/assets' . ($path ? '/' . ltrim($path, '/') : '');
}

/**
 * Custom Walker для навигационного меню
 */
class Perspectiva_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"header__sub-list\">\n";
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'header__list-item';
        
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-children';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $output .= $indent . '<li' . $class_names . '>';
        
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        
        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= '<svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.5 0.5L5.5 5.5L10.5 0.5" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>';
        }
        
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}


