<?php
function remove_default_post_type() {
  remove_menu_page( 'edit.php' );
  remove_menu_page( 'edit-comments.php' );

}

add_action( 'admin_menu', 'remove_default_post_type' );


add_filter('query_vars', function ($vars) {
  $vars[] = 'post_type';
  return $vars;
});
