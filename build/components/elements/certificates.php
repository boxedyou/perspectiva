<?php
/**
 * Сертификаты: страница certificates (ACF certificates) или галерея из терминов categories (categories_group.certificates).
 * Превью открывается в Fancybox (группа certificates-gallery).
 */
$certificates = array();

if ( is_page( 'certificates' ) ) {
  $raw = get_field( 'certificates' );
  if ( is_array( $raw ) ) {
    $certificates = $raw;
  }
} else {
  $terms = get_terms(
    array(
      'taxonomy'   => 'categories',
      'hide_empty' => false,
      'orderby'    => 'name',
      'order'      => 'ASC',
    )
  );

  if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
    foreach ( $terms as $term ) {
      $group = get_field( 'categories_group', 'term_' . $term->term_id );
      if ( is_array( $group ) && ! empty( $group['certificates'] ) && is_array( $group['certificates'] ) ) {
        foreach ( $group['certificates'] as $c ) {
          $certificates[] = $c;
        }
      }
    }
  }
}

$certificates = array_values(
  array_filter(
    $certificates,
    function ( $c ) {
      return is_array( $c ) && ! empty( $c['url'] );
    }
  )
);

if ( empty( $certificates ) ) {
  return;
}

$img_w = is_page( 'certificates' ) ? '244' : '264';
$img_h = is_page( 'certificates' ) ? '330' : '360';
?>
<div class="certificates">
  <?php foreach ( $certificates as $certificate ) : ?>
    <?php
    $url     = $certificate['url'];
    $alt     = isset( $certificate['alt'] ) ? $certificate['alt'] : '';
    $title   = isset( $certificate['title'] ) ? $certificate['title'] : '';
    $caption = isset( $certificate['caption'] ) ? $certificate['caption'] : '';
    if ( $caption === '' && ! empty( $certificate['description'] ) ) {
      $caption = $certificate['description'];
    }
    if ( $caption === '' ) {
      $caption = $title;
    }
    ?>
      <div class="certificate">
          <a
                  class="certificate__link"
                  href="<?php echo esc_url( $url ); ?>"
                  data-fancybox="certificates-gallery"
                  data-caption="<?php echo esc_attr( $caption ); ?>"
          >
              <img
                      src="<?php echo esc_url( $url ); ?>"
                      alt="<?php echo esc_attr( $alt ); ?>"
                      title="<?php echo esc_attr( $title ); ?>"
                      width="<?php echo esc_attr( $img_w ); ?>"
                      height="<?php echo esc_attr( $img_h ); ?>"
                      loading="lazy"
              >
          </a>
        <?php if ( $caption !== '' ) : ?>
            <p><?php echo esc_html( $caption ); ?></p>
        <?php endif; ?>
      </div>
  <?php endforeach; ?>
</div>