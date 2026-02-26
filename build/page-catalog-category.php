<?php
/**
 * Template for catalog category page
 *
 * @package Perspectiva
 */

get_header();
?>
<main class="main-catalog">
    <?php
    get_template_part('components/sections/category-hero');
    get_template_part('components/sections/category-catalog');
    get_template_part('components/sections/seo');
    get_template_part('components/sections/contact-us');
    ?>
</main>

<?php
get_footer();


