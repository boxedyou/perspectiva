<?php
/**
 * Main template file
 *
 * @package Perspectiva
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
