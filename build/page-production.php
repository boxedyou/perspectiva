<?php
/**
 * Template for production page
 *
 * @package Perspectiva
 */

get_header();
?>
  <main class="main-production">
    <?php
    get_template_part('components/elements/breadcrumbs');
    get_template_part('components/sections/production-hero');
    get_template_part('components/sections/numbers');
    get_template_part('components/sections/products');
    get_template_part('components/sections/contact-us');
    ?>
  </main>

<?php
get_footer();


