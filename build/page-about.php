<?php
/**
 * Template for about
 *
 * @package Perspectiva
 */

get_header();
?>
  <main class="main-about">
    <?php
    get_template_part('components/sections/about-hero');
    get_template_part('components/sections/numbers');
    get_template_part('components/sections/about-description');
    get_template_part('components/sections/production-hero');
    get_template_part('components/sections/contact-us');
    ?>
  </main>

<?php
get_footer();


