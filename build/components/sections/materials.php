<?php
// Данные всех новостей
$all_news = [
  [
    'image' => '1.jpg',
    'alt' => 'Новости',
    'title' => 'Новости',
    'tags' => ['Новости', 'Вентфасады'],
    'date' => '15.02.2026',
    'item_title' => 'Подшивка крыши софитами',
    'text' => 'Когда крыша уже покрыта черепицей или металлопрофилем, кажется, что дом полностью защищён и готов к любым капризам погоды. Но опытные строители знают: финальный штрих, который завершает работу и придает дому...',
    'link' => '/perspectiva/build/single-news.php',
  ],
  [
    'image' => '2.jpg',
    'alt' => 'Новости',
    'title' => 'Новости',
    'tags' => ['Акции', 'Вентфасады'],
    'date' => '14.02.2026',
    'item_title' => 'Заголовок новости 2',
    'text' => 'Описание новости 2...',
    'link' => '#'
  ],
  [
    'image' => '3.jpg',
    'alt' => 'Новости',
    'title' => 'Новости',
    'tags' => ['Статьи', 'Фибросайдинг'],
    'date' => '13.02.2026',
    'item_title' => 'Заголовок новости 3',
    'text' => 'Описание новости 3...',
    'link' => '#'
  ],
  [
    'image' => '4.jpg',
    'alt' => 'Новости',
    'title' => 'Новости',
    'tags' => ['Новости'],
    'date' => '12.02.2026',
    'item_title' => 'Заголовок новости 4',
    'text' => 'Описание новости 4...',
    'link' => '#'
  ],
  [
    'image' => '5.jpg',
    'alt' => 'Новости',
    'title' => 'Новости',
    'tags' => ['Акции'],
    'date' => '11.02.2026',
    'item_title' => 'Заголовок новости 5',
    'text' => 'Описание новости 5...',
    'link' => '#'
  ],
  [
    'image' => '6.jpg',
    'alt' => 'Новости',
    'title' => 'Новости',
    'tags' => ['Статьи', 'Вентфасады'],
    'date' => '10.02.2026',
    'item_title' => 'Заголовок новости 6',
    'text' => 'Описание новости 6...',
    'link' => '#'
  ],
  [
    'image' => '7.jpg',
    'alt' => 'Новости',
    'title' => 'Новости',
    'tags' => ['Выставки'],
    'date' => '09.02.2026',
    'item_title' => 'Заголовок новости 7',
    'text' => 'Описание новости 7...',
    'link' => '#'
  ],
  [
    'image' => '8.jpg',
    'alt' => 'Новости',
    'title' => 'Новости',
    'tags' => ['Новости', 'Фибросайдинг'],
    'date' => '08.02.2026',
    'item_title' => 'Заголовок новости 8',
    'text' => 'Описание новости 8...',
    'link' => '#'
  ],
  [
    'image' => '9.jpg',
    'alt' => 'Новости',
    'title' => 'Новости',
    'tags' => ['Акции', 'Вентфасады'],
    'date' => '07.02.2026',
    'item_title' => 'Заголовок новости 9',
    'text' => 'Описание новости 9...',
    'link' => '#'
  ],
  [
    'image' => '10.jpg',
    'alt' => 'Новости',
    'title' => 'Новости',
    'tags' => ['Статьи'],
    'date' => '06.02.2026',
    'item_title' => 'Заголовок новости 10',
    'text' => 'Описание новости 10...',
    'link' => '#'
  ],
  [
    'image' => '11.jpg',
    'alt' => 'Новости',
    'title' => 'Новости',
    'tags' => ['Новости', 'Выставки'],
    'date' => '05.02.2026',
    'item_title' => 'Заголовок новости 11',
    'text' => 'Описание новости 11...',
    'link' => '#'
  ],
  [
    'image' => '12.jpg',
    'alt' => 'Новости',
    'title' => 'Новости',
    'tags' => ['Акции', 'Фибросайдинг'],
    'date' => '04.02.2026',
    'item_title' => 'Заголовок новости 12',
    'text' => 'Описание новости 12...',
    'link' => '#'
  ]
];
?>

<section class="materials">
  <div class="container">
    <div class="materials__title-inner">
      <h2 class="materials__title">Другие материалы по теме</h2>
      <div class="materials__button-inner">
        <div class="materials__button swiper-button-prev" data-materials-swiper-prev></div>
        <div class="materials__button swiper-button-next" data-materials-swiper-next></div>
      </div>
    </div>
    <div class="materials__swiper swiper" data-materials-swiper>
      <div class="materials__slider-wrapper swiper-wrapper">
        <?php foreach ($all_news as $news) :
          // Передаем данные в шаблон
          $news_image = $news['image'];
          $news_alt = $news['alt'];
          $news_title = $news['title'];
          $news_tags = $news['tags'];
          $news_date = $news['date'];
          $news_item_title = $news['item_title'];
          $news_text = $news['text'];
          $news_link = $news['link']; ?>
        <div class="materials__slide swiper-slide">
         <?php include __DIR__ . '/../elements/news-element.php'; ?>
        </div>

        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
