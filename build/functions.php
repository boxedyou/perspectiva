<?php
/**
 * Функции и зависимости
 * 
 * @package Perspectiva
 */


/**
 * Инициализация путей к assets
 */
require_once( 'inc/initial_path.php' );

/**
 * Получить URL assets, Получить путь к assets
 */
require_once( 'inc/get_url.php' );

/**
 * Подключаем стили, скрипты, ajax, доп функции для WP
 */
require_once( 'inc/enqueue-scripts.php' );
/**
 * Поддержка функций темы
 */
require_once( 'inc/theme_support.php' );

/**
 * Экранирование атрибутов HTML (если функции WordPress не доступны), Экранирование URL (если функции WordPress не доступны), Экранирование HTML (если функции WordPress не доступны)
 */
require_once( 'inc/shielding.php' );

/**
 * Удаление стандартных постов WP
 */
require_once( 'inc/remove_default_post.php' );

/**
 * Кастомные ссылки пагинации для страниц с кастомными запросами
 */
require_once( 'inc/custom_link_pagination.php' );

/**
 * Кастомные тайтлы и сео мета тэги (если пустые выводится стандартные WP)
 */
require_once( 'inc/custom_seo_meta_tags.php' );

/**
 * Отправка писем через PHP
 */
require_once( 'inc/send.php' );

/**
 * Подключение фавиконок
 */
require_once( 'inc/favicon.php' );


