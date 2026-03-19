<?php
/**
 * Шаблон главной страницы (page-home.php)
 *  Template Name: Главная страница
 *  Description: Шаблон главной страницы из набора секций.
 *
 * @package WordPress
 * @subpackage Perspectiva
 */

get_header();
?>

<main class="main-page">
    <?php
    // Подключаем секции главной страницы
    get_template_part('components/sections/hero');
    get_template_part('components/sections/production');
    get_template_part('components/sections/products');
    get_template_part('components/sections/map-projects');
    get_template_part('components/sections/objects');
    get_template_part('components/sections/contact-us');
    ?>
</main>

<?php
get_footer();
