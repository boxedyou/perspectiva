<?php
/**
 * Template for news page
 *
 * @package Perspectiva
 */

get_header();
?>
<main class="main-news">
    <?php
    get_template_part('components/elements/breadcrumbs');
    get_template_part('components/sections/news');
    ?>
</main>

<?php
get_footer();


