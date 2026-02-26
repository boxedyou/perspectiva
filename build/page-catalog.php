<?php
/**
 * Template for catalog page
 *
 * @package Perspectiva
 */

get_header();
?>
<main class="main-catalog">
    <?php
    get_template_part('components/elements/breadcrumbs');
    get_template_part('components/sections/products');
    get_template_part('components/sections/contact-us');
    get_template_part('components/sections/seo');
    ?>
</main>

<?php
get_footer();


