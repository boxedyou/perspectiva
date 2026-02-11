<?php
// Шаблон объекта
$images_base_url = '/perspectiva/build/assets/images/object/';
?>

<div class="object" data-filter-target="<?= esc_attr($object_filter) ?>">
  <div class="object__img-inner">
    <img class="object__img"
         src="<?= esc_url($images_base_url . $object_image) ?>"
         alt="<?= esc_attr($object_alt) ?>"
         title="<?= esc_attr($object_title) ?>"
         width="480"
         height="344"
         loading="lazy">
    <div class="object__tags-inner">
      <?php foreach ($object_tags as $tag) : ?>
        <p class="object__tag"><?= esc_html($tag) ?></p>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="object__inner">
    <h3 class="object__title"><?= esc_html($object_item_title) ?></h3>
    <p class="object__place"><?= esc_html($object_place) ?></p>
    <p class="object__text"><?= esc_html($object_text) ?></p>
  </div>
</div>