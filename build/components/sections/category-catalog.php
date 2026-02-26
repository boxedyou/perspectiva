<section class="category-catalog">
  <div class="container">
    <div class="category-catalog__filter-inner">
        <button class="category-catalog__filter" type="button" data-filter="Все">Все</button>
        <button class="category-catalog__filter active" type="button" data-filter="Вентфасады">Вентфасады</button>
        <button class="category-catalog__filter" type="button" data-filter="Фибросайдинг">Фибросайдинг</button>
    </div>
      <div class="category-catalog__wrapper">
          <?php
          include __DIR__ . '/../elements/category-item.php';
          include __DIR__ . '/../elements/category-item.php';
          include __DIR__ . '/../elements/category-item.php';
          include __DIR__ . '/../elements/category-item.php';
          include __DIR__ . '/../elements/category-item.php';
          include __DIR__ . '/../elements/category-item.php';
          include __DIR__ . '/../elements/category-item.php';
          include __DIR__ . '/../elements/category-item.php';
          ?>
      </div>
      <button class="category-catalog__button" type="button">Показать ещё</button>
  </div>
</section>
