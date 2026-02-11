<?php
// Данные всех объектов
$all_objects = [
  [
    'image' => '1.jpg',
    'alt' => 'Объект 1',
    'title' => 'Объект 1',
    'tags' => ['Вентфасады' , 'Другое'],
    'object_title' => 'Жилой дом Аднан Мендерес',
    'place' => 'Казахстан, Туркестан',
    'text' => 'Проект включает комплекс работ: от обследования и дизайна до монтажа вентилируемого фасада с утеплением под ключ.',
    'filter' => 'Вентфасады'
  ],
  [
    'image' => '2.jpg',
    'alt' => 'Объект 2',
    'title' => 'Объект 2',
    'tags' => ['Фибросайдинг', 'Другое'],
    'object_title' => 'Название объекта 2',
    'place' => 'Местоположение объекта 2',
    'text' => 'Описание объекта 2',
    'filter' => 'Фибросайдинг'
  ],
  [
    'image' => '3.jpg',
    'alt' => 'Объект 3',
    'title' => 'Объект 3',
    'tags' => ['Вентфасады'],
    'object_title' => 'Название объекта 3',
    'place' => 'Местоположение объекта 3',
    'text' => 'Описание объекта 3',
    'filter' => 'Вентфасады'
  ],
  [
    'image' => '4.jpg',
    'alt' => 'Объект 4',
    'title' => 'Объект 4',
    'tags' => ['Фибросайдинг'],
    'object_title' => 'Название объекта 4',
    'place' => 'Местоположение объекта 4',
    'text' => 'Описание объекта 4',
    'filter' => 'Фибросайдинг'
  ],
  [
    'image' => '5.jpg',
    'alt' => 'Объект 5',
    'title' => 'Объект 5',
    'tags' => ['Вентфасады', 'Другое'],
    'object_title' => 'Название объекта 5',
    'place' => 'Местоположение объекта 5',
    'text' => 'Описание объекта 5',
    'filter' => 'Вентфасады'
  ],
  [
    'image' => '6.jpg',
    'alt' => 'Объект 6',
    'title' => 'Объект 6',
    'tags' => ['Фибросайдинг'],
    'object_title' => 'Название объекта 6',
    'place' => 'Местоположение объекта 6',
    'text' => 'Описание объекта 6',
    'filter' => 'Фибросайдинг'
  ]
];

// Количество объектов для вывода (по умолчанию все)
$objects_count = isset($objects_count) ? min($objects_count, count($all_objects)) : count($all_objects);
$objects_to_show = array_slice($all_objects, 0, $objects_count);

// Убеждаемся, что функции экранирования подключены
if (!function_exists('esc_attr')) {
  require_once __DIR__ . '/../../function.php';
}
?>

<section class="objects">
    <div class="container">
        <div class="objects__title-wrapper">
            <h2 class="objects__title">Объекты с нашей продукцией</h2>
            <aside class="objects__filter-inner">
                <button class="objects__filter-button active" type="button" data-filter="Все">Все</button>
                <button class="objects__filter-button" type="button" data-filter="Вентфасады">Вентфасады</button>
                <button class="objects__filter-button" type="button" data-filter="Фибросайдинг">Фибросайдинг</button>
            </aside>
        </div>
        <div class="objects__wrapper">
          <?php foreach ($objects_to_show as $object) :
            // Передаем данные в шаблон
            $object_image = $object['image'];
            $object_alt = $object['alt'];
            $object_title = $object['title'];
            $object_tags = $object['tags'];
            $object_filter = $object['filter'];
            $object_item_title = $object['object_title'];
            $object_place = $object['place'];
            $object_text = $object['text'];

            // Подключаем шаблон объекта
            include __DIR__ . '/../elements/object.php';
          endforeach; ?>
        </div>
        <a class="objects__link" href="">Смотреть все объекты</a>
    </div>
</section>