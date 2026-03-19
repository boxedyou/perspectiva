<?php
$post_id = get_the_ID();

// Фильтр (как у кнопок) — таксономия categories
$terms_filter = get_the_terms( $post_id, 'categories' );
$object_filter = 'Все объекты';
if ( ! is_wp_error( $terms_filter ) && ! empty( $terms_filter ) ) {
  $object_filter = $terms_filter[0]->name;
}

// Теги на карточке — таксономия object_type
$terms_tags = get_the_terms( $post_id, 'object_type' );
$object_tags = array();
if ( ! is_wp_error( $terms_tags ) && ! empty( $terms_tags ) ) {
  $object_tags = wp_list_pluck( $terms_tags, 'name' );
}

// ACF-группа
$objects_group = get_field( 'objects_group', $post_id );
$object_place  = isset( $objects_group['object_place'] ) ? $objects_group['object_place'] : '';
$object_text   = isset( $objects_group['object_text'] ) ? $objects_group['object_text'] : '';

$object_item_title = get_the_title( $post_id );

$thumb_id = get_post_thumbnail_id( $post_id );
$object_image_url   = '';
$object_image_alt   = '';
$object_image_title = '';

if ( $thumb_id ) {
  $object_image_url   = wp_get_attachment_image_url( $thumb_id, 'medium_large' );
  $object_image_alt   = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
  $object_image_title = get_the_title( $thumb_id );
}
?>

<div class="object" data-filter-target="<?= esc_attr( $object_filter ); ?>">
    <div class="object__img-inner">
        <img class="object__img"
             src="<?= esc_url( $object_image_url ); ?>"
             alt="<?= esc_attr( $object_image_alt ); ?>"
             title="<?= esc_attr( $object_image_title ); ?>"
             width="480"
             height="344"
             loading="lazy">
        <div class="object__tags-inner">
          <?php foreach ( $object_tags as $tag ) : ?>
              <p class="object__tag"><?= esc_html( $tag ); ?></p>
          <?php endforeach; ?>
        </div>
    </div>
    <div class="object__inner">
        <h3 class="object__title"><?= esc_html( $object_item_title ); ?></h3>
        <p class="object__place"><?= esc_html( $object_place ); ?></p>
        <p class="object__text"><?= esc_html( $object_text ); ?></p>
    </div>
</div>