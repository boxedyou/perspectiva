<?php
/**
 * Template for contacts
 *
 * @package Perspectiva
 */

get_header();
?>
  <main class="main-contacts">
    <?php
    get_template_part('components/elements/breadcrumbs');
    get_template_part('components/sections/contacts-main');
    get_template_part('components/sections/contact-us');
    ?>
  </main>

<?php
get_footer();


