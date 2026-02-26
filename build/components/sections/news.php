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

// Убеждаемся, что функции экранирования подключены
if (!function_exists('esc_attr')) {
  require_once __DIR__ . '/../../function.php';
}
?>

<section class="news">
    <div class="container">
        <h1 class="news__title">Новости и статьи</h1>
        <div class="news__filter-inner">
            <button class="news__filter active" type="button">Все материалы</button>
            <button class="news__filter" type="button">Акции</button>
            <button class="news__filter" type="button">Новости</button>
            <button class="news__filter" type="button">Статьи</button>
            <button class="news__filter" type="button">Вентфасады</button>
            <button class="news__filter" type="button">Фибросайдинг</button>
            <button class="news__filter" type="button">Выставки</button>
        </div>
        <div class="news__wrapper">
          <?php foreach ($all_news as $news) :
            // Передаем данные в шаблон
            $news_image = $news['image'];
            $news_alt = $news['alt'];
            $news_title = $news['title'];
            $news_tags = $news['tags'];
            $news_date = $news['date'];
            $news_item_title = $news['item_title'];
            $news_text = $news['text'];
            $news_link = $news['link'];

            // Подключаем шаблон новости
            include __DIR__ . '/../elements/news-element.php';
          endforeach; ?>
        </div>
        <div class="news__pagination-inner">
            <div class="news__pagination news__pagination-arrow news__pagination-arrow--prev disable"></div>
            <div class="news__pagination active">1</div>
            <div class="news__pagination">2</div>
            <div class="news__pagination">3</div>
            <div class="news__pagination news__pagination--dots">...</div>
            <div class="news__pagination">8</div>
            <div class="news__pagination news__pagination-arrow news__pagination-arrow--next"></div>
        </div>
    </div>
</section>