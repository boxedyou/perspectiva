<?php
/**
 * Template for single objects
 *
 * @package Perspectiva
 */

get_header();
?>
<main class="main-objects">
    <?php
    get_template_part('components/elements/breadcrumbs');
    get_template_part('components/sections/single-category-hero');
    get_template_part('components/sections/description');
    get_template_part('components/sections/products');
    get_template_part('components/sections/objects-product');
    get_template_part('components/sections/similar-product');
    get_template_part('components/sections/contact-us');
    get_template_part('components/sections/seo');
    ?>
</main>

<?php
get_footer();


