<?php
/**
 * Template for single news post
 *
 * @package Perspectiva
 */

get_header();
?>
<main class="main-single-news">
    <?php
    get_template_part('components/elements/breadcrumbs');
    get_template_part('components/sections/single-news-content');
    get_template_part('components/sections/contact-us');
    get_template_part('components/sections/materials');
    ?>
</main>

<?php
get_footer();


