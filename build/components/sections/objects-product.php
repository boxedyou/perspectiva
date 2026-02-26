<?php
// Данные для объектов (пример - замените на реальные данные)
$objects_data = [
  [
    'image' => '1.jpg',
    'alt' => 'Объект 1',
    'title' => 'Объект 1',
    'tags' => ['Вентфасады'],
    'filter' => 'Вентфасады',
    'object_title' => 'Название объекта 1',
    'place' => 'Москва',
    'text' => 'Описание объекта 1'
  ],
  [
    'image' => '2.jpg',
    'alt' => 'Объект 2',
    'title' => 'Объект 2',
    'tags' => ['Фибросайдинг'],
    'filter' => 'Фибросайдинг',
    'object_title' => 'Название объекта 2',
    'place' => 'Санкт-Петербург',
    'text' => 'Описание объекта 2'
  ],
  [
    'image' => '1.jpg',
    'alt' => 'Объект 1',
    'title' => 'Объект 1',
    'tags' => ['Вентфасады'],
    'filter' => 'Вентфасады',
    'object_title' => 'Название объекта 1',
    'place' => 'Москва',
    'text' => 'Описание объекта 1'
  ],
  [
    'image' => '2.jpg',
    'alt' => 'Объект 2',
    'title' => 'Объект 2',
    'tags' => ['Фибросайдинг'],
    'filter' => 'Фибросайдинг',
    'object_title' => 'Название объекта 2',
    'place' => 'Санкт-Петербург',
    'text' => 'Описание объекта 2'
  ],
  [
    'image' => '1.jpg',
    'alt' => 'Объект 1',
    'title' => 'Объект 1',
    'tags' => ['Вентфасады'],
    'filter' => 'Вентфасады',
    'object_title' => 'Название объекта 1',
    'place' => 'Москва',
    'text' => 'Описание объекта 1'
  ],
  [
    'image' => '2.jpg',
    'alt' => 'Объект 2',
    'title' => 'Объект 2',
    'tags' => ['Фибросайдинг'],
    'filter' => 'Фибросайдинг',
    'object_title' => 'Название объекта 2',
    'place' => 'Санкт-Петербург',
    'text' => 'Описание объекта 2'
  ],
];
?>

<section class="objects-product">
  <div class="container">
    <div class="objects-product__title-inner">
      <h2 class="objects-product__title">Объекты с нашей продукцией</h2>
      <div class="objects-product__button-inner">
        <div class="objects-product__button swiper-button-prev" data-objects-product-swiper-prev></div>
        <div class="objects-product__button swiper-button-next" data-objects-product-swiper-next></div>
      </div>
    </div>
    <div class="objects-product__swiper swiper" data-objects-product-swiper>
      <div class="objects-product__slider-wrapper swiper-wrapper">
        <?php foreach ($objects_data as $object) :
          // Передаем данные в шаблон
          $object_image = $object['image'];
          $object_alt = $object['alt'];
          $object_title = $object['title'];
          $object_tags = $object['tags'];
          $object_filter = $object['filter'];
          $object_item_title = $object['object_title'];
          $object_place = $object['place'];
          $object_text = $object['text'];
          ?>
          <div class="objects-product__slide swiper-slide">
            <?php include __DIR__ . '/../elements/object.php'; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>