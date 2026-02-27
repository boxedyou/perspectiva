<?php
/**
 * Template for price-list
 *
 * @package Perspectiva
 */

get_header();
?>
  <main class="main-price-list">
    <?php
    get_template_part('components/elements/breadcrumbs');
    get_template_part('components/sections/price-list');
    get_template_part('components/sections/seo');
    get_template_part('components/sections/contact-us');
    ?>
  </main>

<?php
get_footer();


