<?php
/**
 * Template for category page
 *
 * @package Perspectiva
 */

get_header();
?>
<main class="main-category">
    <?php
    get_template_part('components/elements/breadcrumbs');
    get_template_part('components/sections/objects');
    get_template_part('components/sections/map-projects');
    get_template_part('components/sections/contact-us');
    get_template_part('components/sections/seo');
    ?>
</main>

<?php
get_footer();


